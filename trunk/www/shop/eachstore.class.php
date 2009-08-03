<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "eachstore");

class eachstorePage extends PageBase
{
	private	$_demo_dao;
	public	$con;
	public $data_Store;
	public $data_StoreId;
	public $data_StoreType;

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_smallstore");
	}
	
	public function prerend()
	{
		$this->doSelectStoreType();
		$this->doSelectStoreId();
	}
	
	public function unload()
	{
		
	}
	
	public function doSelectStoreType()
	{
		$this->_demo_dao->setTableName("ce_smallstore_type");
		$this->data_StoreType = $this->_demo_dao->selectA();
	}
	
	public function doSelectStoreId()
	{
		$this->_demo_dao->setTableName("ce_smallstore");
		$con = array('type_id'=>$_POST['type_id']);
		$this->data_StoreId = $this->_demo_dao->selectA($con);
		//print_r($this->data_StoreId);
		
		
	}
	
	public function doDelete($id)
	{
		$this->_demo_dao->setTableName("ce_smallstore");
		$con = array('store_id'=>$id);
		$this->_demo_dao->delete($con);
		//print_r($con);
	//	echo "<script language=\"JavaScript\">window.location.href='shopslist.php'</script>"; 
		Server::refresh();
	}

	public function doDeletes()
	{
		$this->_demo_dao->setTableName("ce_smallstore");
		$check = $_POST['check'];
		foreach ($check as $value)
		{
			$con = array('store_id'=>$value);
			$this->_demo_dao->delete($con);
		}
		Server::refresh();
	}
}