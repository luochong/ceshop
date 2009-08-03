<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopstype");

class shopstypePage extends PageBase
{
	private	$_demo_dao;
	public $data;
	public $typename;
	public $check;

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_smallstore_type");
	}
	
	public function prerend()
	{
		$this->data = $this->_demo_dao->selectA();
	
	}
	
	public function unload()
	{
		
	}
	
	public function doInsert()
	{			
		$data['typename'] = $this->typename;
		$this->_demo_dao->insert($data);
		Server::refresh();
	}
	
	public function doDelete()
	{
		
		$chck=$_POST['check'];
		
		foreach ($chck as $value):
		$con=array('type_id'=>$value);
		$this->_demo_dao->delete($con);
		endforeach;
		
		Server::refresh();
	}
	

}