<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopsglist");

class shopsglistPage extends PageBase
{
	public $_demo_dao;
	public $store_data;
	public $cate_select_data;
		/*分页*/
	public $sum_result;	
	private $pagesize = 5;
	public $pageno = 0;
	
	public $doact;

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getNamedDao('category');
		$this->_demo_dao->setTableName("ce_goodsinfo");
	}
	
	public function prerend()
	{
			if(!$this->doSearch()){
			$this->sum_result = $this->_demo_dao->count();
			$this->DBdata = $this->_demo_dao->selectA(NULL,$this->pagesize,$this->pageno);
			}
			$this->setCateData();
			$this->setStoreData();		
		
	}
	
	public function unload()
	{
		
	}
	
	/******************************************/
	private function setStoreData(){		
		$data = $this->_demo_dao->simpleFetchList('ce_smallstore',array('store_id','storename'));		
		foreach ($data as $value){
			$this->store_data[$value[0]] = $value[1];
		}
	
	}
	private function setCateData(){		
		$this->cate_select_data = $this->_demo_dao->getCateSelect();
		
	}	
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
	
	
	
	/*****************操作******************/
	public function delete($id){
		$r = $this->_demo_dao->simpleFetchList('ce_goodsinfo',array('picture'),array('goodsinfo_id'=>$id));
		if(is_file(SGOODS_IMG_DIR.'/'.$r[0][0])){
							 	unlink(SGOODS_IMG_DIR.'/'.$r[0][0]);
								unlink(SGOODS_IMG_DIR.'/'.'small'.$r[0][0]);	
						 	}
		$this->_demo_dao->delete(array('goodsinfo_id'=>$id));
			
	}
	
	public function doAction(){
		switch ($this->doact){
			case 'del':{
				foreach ($this->DBdata['goodsinfo_id'] as $id){
					$this->delete($id);
				}
				break;				
			}			
		}		
	}
	
	public function doSearch(){
		if($this->doact == 'search'){	
			$cond = array();			
		
			$store_id = intval($_GET['store_id']);	
			if($store_id){
				$cond['store_id'] = $store_id;
			}			
			$category_id = intval($_GET['category_id']);
			if($category_id){
				$cond['type_id'] = $category_id;				
			}
			$key = $_GET['key'];
			if($key){
				$cond['goodsname'] = '%'.$key.'%';				
			}
			$this->_demo_dao->setTableName("ce_goodsinfo");			
			$this->sum_result = $this->_demo_dao->count($cond);
			$this->DBdata = $this->_demo_dao->selectA($cond,$this->pagesize,$this->pageno);
			return true;			
		}else{
			return false;
		}	
		
	}
	
	
	
	
}