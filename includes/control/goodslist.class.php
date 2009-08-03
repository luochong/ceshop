<?php 
require_once('controlbase.class.php');
require_once("daofactory.class.php");
class goodslistcontrol extends ControlBase {
	private $_demo_dao;
	public $store_data;
	public $cate_select_data;
	
	/*分页*/
	public $sum_result;	
	private $pagesize = 5;
	public $pageno = 0;
	
	public $editpage = 'shopgoods.php';

	public function load()
	{
		if($pageno = intval($_GET['pageno'])){
			$this->pageno = $pageno;
		}
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getNamedDao('category');
		$this->_demo_dao->setTableName("ce_goods");		
	}
	
	public function prerend()
	{
		if(!$this->doSearch()){
			$this->sum_result = $this->_demo_dao->count();
			$this->DBdata = $this->_demo_dao->selectA(NULL,$this->pagesize,$this->pageno);
			
		}
				
		
		$this->setStoreData();
		$this->setCateData();
	}
	
	public function unload()
	{
		
	}
	/*******************************************/
	private function setStoreData(){		
		$data = $this->_demo_dao->simpleFetchList('ce_store',array('store_id','store_name'));		
		foreach ($data as $value){
			$this->store_data[$value[0]] = $value[1];
		}	
	}
	private function setCateData(){
		
		$this->cate_select_data = $this->_demo_dao->getCateSelect();	
	}

	
	/***************************生产HTML*****************************/
	/*分页*/
	public function MakePageUrl(){
		$php_self = $_SERVER['REQUEST_URI']; 
		$str = '';	
		$sum = $this->sum_result/$this->pagesize;
		
		$str .='<ul class="page_tab">';
		$str .='<li>共'.ceil($sum).'页</li>';
		if(($page_no = $this->pageno) >0){
			$page_no = $page_no-1;
			$url = $this->Makeurl($php_self,array('pageno'=>$page_no));
			$str .="<li><a href=\"$url\">上一页</a></li>";
		}
		for($i = 0 ;$i < $sum;$i++){
			
			$url = $this->Makeurl($php_self,array('pageno'=>$i));
			if($i == $this->pageno)	$selected ='class="selected"';		
				$str .= "<li><a href=\"$url\" $selected >".($i+1).'</a></li>';
			$selected = '';		
		}
		echo $str;
		
		
	}	
	/******************************事件处理****************************/
	
	public function doSearch(){
		if($_GET['act'] == 'search'){
			$cond = array();
			
			//store_id=6&category_id=3&key=	
			$store_id = intval($_GET['store_id']);	
			if($store_id){
				$cond['store_id'] = $store_id;
			}			
			$category_id = intval($_GET['category_id']);
			if($category_id){
				$cond['category_id'] = $category_id;				
			}
			$key = $_GET['key'];
			if($key){
				$cond['goods_name'] = '%'.$key.'%';				
			}
			$this->_demo_dao->setTableName("ce_goods");		
			$this->sum_result = $this->_demo_dao->count($cond);
			$this->DBdata = $this->_demo_dao->selectA($cond,$this->pagesize,$this->pageno);
			return true;			
		}else{
			return false;
		}
	}
	public function doAction(){	
		
		switch ($this->DBdata['doact']){
			case 'del':{
				foreach ($this->DBdata['goods_id'] as $id){
					$this->doDelete($id);					
				}
				break;
			}
			case 'best':{
				foreach ($this->DBdata['goods_id'] as $id){
					$this->doBest($id);					
				}
				break;
			}
			case 'nobest':{
				foreach ($this->DBdata['goods_id'] as $id){
					$this->doNoBest($id);					
				}
				break;
			}
		}	
		
		
	}
	
	
	public function doDelete($id){			
		$this->_demo_dao->setTableName("ce_goods_attribute");	
		$this->_demo_dao->delete(array('goods_id'=>$id));
		$this->_demo_dao->setTableName("ce_goods");	
		$this->_demo_dao->delete(array('goods_id'=>$id));		
		
	}
	
	public function doBest($id){		
		$this->_demo_dao->setTableName("ce_goods");	
		$this->_demo_dao->update(array('is_best'=>1),array('goods_id'=>$id));		
	}
	public function doNoBest($id){		
		$this->_demo_dao->setTableName("ce_goods");	
		$this->_demo_dao->update(array('is_best'=>0),array('goods_id'=>$id));	
	}
	/*********************************工具函数******************************************/





}