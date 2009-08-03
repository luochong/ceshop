<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopsnewlogo");

class shopsnewlogoPage extends PageBase
{
	private $_demo_dao;
	public $data;
	

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_smallstore");
		
	}
	
	public function prerend()
	{
		$this->data = $this->_demo_dao->selectA();
		//print_r($_GET['store_id']);
	}
	
	public function unload()
	{
		
	}
	
	
	
	
}