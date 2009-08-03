<?php 
require_once('controlbase.class.php');
require_once("daofactory.class.php");
class testcontrol extends ControlBase {
	private $_demo_dao;

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