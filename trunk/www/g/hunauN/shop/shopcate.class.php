<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopcate");

class shopcatePage extends PageBase
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
		
		
	}
	
	public function unload()
	{
		
	}
	
	
	
	
}