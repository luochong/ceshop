<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shoplist");
class shoplistPage extends PageBase
{
	private $_demo_dao;


	
	public $store_data;

		
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_store");
	}
	
	public function prerend()
	{
		$this->store_data = $this->_demo_dao->selectA();
	}
	
	public function unload()
	{
		
	}
	
	public function doModify($id){
		
		$_SESSION['store_id'] = $id;
		Server::redirectUrl('shopadd.php');
		
		
	}
	
	
	
	
}