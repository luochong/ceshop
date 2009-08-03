<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopsdish");

class shopsdishPage extends PageBase
{
	private	$_demo_dao;
	public $data;
	public $DName;
	public $check;

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_dishes");
	}
	
	public function prerend()
	{
		$this->data = $this->_demo_dao->selectA();
		//print_r($this->data);
	}
	
	public function unload()
	{
		
	}
	
	public function doInsert()
	{			
		$data['DName'] = $this->DName;
		$this->_demo_dao->insert($data);
		$id = $this->_demo_dao->getInsertID();
		Server::refresh(array('dish_id'=>$id,'upimg'=>1));
	}
	
	public function doDelete()
	{
	//	print_r($_POST['check']);
	
		$chck=$_POST['check'];
		foreach ($chck as $value):
		$con=array('dish_id'=>$value);
		$this->_demo_dao->delete($con);
		endforeach;
		Server::refresh();
	}
	

}