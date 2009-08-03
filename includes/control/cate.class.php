<?php 
require_once('controlbase.class.php');
require_once("daofactory.class.php");
class catecontrol extends ControlBase {
	private $_demo_dao;
	private $cate_data;
	public $page;
	

	
	public $cate_select_data;

	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getNamedDao('category');	
		$this->_demo_dao->setTableName("ce_store");		
	}
	
	public function prerend()
	{
		$this->setCateData();
		/*switch ($this->page){
			case 'add':{
				
				break;
			}
			case 'list':{
				
			
			
			}		
		}*/
		if(isset($_GET['act'])&&$_GET['act'] == 'update'&&isset($_GET['cateid'])&&$_GET['cateid'] != ''){
			
			$this->getCateDataById($_GET['cateid']);
			
		}
		
	
	}	
	public function unload()
	{
		
	}
	///*******************页面加载***************************/	
	private function setCateData(){		
		$this->cate_select_data = $this->_demo_dao->getCateSelect();	
	}

	public function echoCateList(){
		
		foreach ($this->cate_select_data as $key => $value){
			
			echo "$value&nbsp;&nbsp;&nbsp;&nbsp;<a  href=\"?page=add&act=update&cateid=$key\"><img src=\"".APP_ROOT."/g/hunauN/images/icon_edit.gif\" title=\"修改\" alt=\"修改\" /></a><a  href=\"$key\"  >×</a><br />";
			
		}

	}
	
	public function getCateDataById($id){
		$sql = 'select attribute_id,attribute_name,category_name,attribute_type,attribute_type,attribute_value,far_id from ce_category_attribute RIGHT JOIN ce_goods_category
ON ce_category_attribute.category_id = ce_goods_category.category_id where ce_goods_category.category_id = ?';		
		
		$this->DBdata = $this->_demo_dao->executeQueryA($sql,array($id));		
	}
	/****************************事件处理************************************/
	public function addCate(){
		$this->_demo_dao->setTableName("ce_goods_category");	
		$ctemp['category_name'] = $this->DBdata['category_name'];
		$ctemp['far_id']        = $this->DBdata['far_id'];
		$atemp = array();
		if(!empty($this->DBdata['attribute_name'])){		
			$ctemp['have_attr'] = 1; 	
		
		}else{
			$ctemp['have_attr'] = 0;
		}
		$this->_demo_dao->insert($ctemp);
		$id = $this->_demo_dao->getInsertId();
		if(!empty($this->DBdata['attribute_name'])){
				$this->_demo_dao->setTableName("ce_category_attribute");		
				for ($i = 0;$i<count($this->DBdata['attribute_name']);$i++){
					$atemp['attribute_name'] = $this->DBdata['attribute_name'][$i];
					$atemp['attribute_type'] = $this->DBdata['attribute_type'][$i];
					$atemp['attribute_value'] = $this->DBdata['attribute_value'][$i];
					$atemp['category_id']    = $id;
					if(!empty($atemp['attribute_name']))
										$this->_demo_dao->insert($atemp);		
				}		
		}
		$this->_demo_dao->removeCateData();
		
	}
	
	public function updateCate(){
		$this->_demo_dao->setTableName("ce_goods_category");	
		$ctemp['category_name'] = $this->DBdata['category_name'];
		$ctemp['far_id']        = $this->DBdata['far_id'];
		/*节点父级修改不能形成环*/
		$child = $this->_demo_dao->getChild($_GET['cateid']);		
		if($child){
			foreach ($child as $node){
				if($node['id'] == $ctemp['far_id'])
				{
					echo "<p class='error'>出错了，不能成为子类</p>";
					unset($ctemp['far_id']);
					break;
				}
			}
		}		
		
		$this->_demo_dao->update($ctemp,array('category_id' => $_GET['cateid']));
		$this->_demo_dao->removeCateData();	
		if(!empty($this->DBdata['attribute_name'])){
				$this->_demo_dao->setTableName("ce_category_attribute");		
				for ($i = 0;$i<count($this->DBdata['attribute_name']);$i++){
					$atemp['attribute_name'] = $this->DBdata['attribute_name'][$i];
					$atemp['attribute_type'] = $this->DBdata['attribute_type'][$i];
					$atemp['attribute_value'] = $this->DBdata['attribute_value'][$i];
					$atemp['category_id']    = $_GET['cateid'];					
					if(!empty($atemp['attribute_name'])){
							if(empty($this->DBdata['attribute_id'][$i])){
								$this->_demo_dao->insert($atemp);
							}else{			
								
								$this->_demo_dao->update($atemp,array('attribute_id'=>$this->DBdata['attribute_id'][$i]));
							}						
					
					}										
				}	
		}
		
	}

	
}