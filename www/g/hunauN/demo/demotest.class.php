<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "demotest");
class demotestPage extends PageBase
{
	private $_demo_dao;
	public $data;
	public  $name;
	public  $content;
	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_demo");
	}
	
	public function prerend()
	{
		$this->data = $this->_demo_dao->selectA();
	
	}
	
	public function unload()
	{
		
	}
	
	public function doAction(){			
		$data['name'] = $this->name;
		$data['content'] = $this->content;		
		
		$this->_demo_dao->insert($data);
		Server::refresh();		
	}
	
	
}

?>
