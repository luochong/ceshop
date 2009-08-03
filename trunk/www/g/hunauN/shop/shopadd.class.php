<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopadd");
class shopaddPage extends PageBase
{
	private $_demo_dao;

	public  $name;
	public  $content;
	
	public $store_name;
	public $store_account;
	public $store_password;
	public $store_info;
		
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_store");
	}
	
	public function prerend()
	{
		if(isset($_SESSION['store_id'])){				
				$data = $this->_demo_dao->selectA(array('store_id'=>$_SESSION['store_id']));				
				$this->updateData($data[0]);	
		}
	}
	
	public function unload()
	{
		
	}
	public function addStore(){		
		
		$data['store_name']     = $this->store_name;
		$data['store_account '] = $this->store_account;
		$data['store_password'] = $this->store_password;
		$data['store_info']     = $this->store_info;
	    if($this->_demo_dao->insert($data) == 1){	    	
	    	$_SESSION['store_id'] = $this->_demo_dao->getInsertId();	    	
	    }
	    Server::refresh();		
	}
	public function reStore(){
		
		unset($_SESSION['store_id']);
		Server::refresh();	
	}
	public function modifyStore(){
		$data['store_name']     = $this->store_name;
		$data['store_account '] = $this->store_account;
		$data['store_password'] = $this->store_password;
		$data['store_info']     = $this->store_info;
	    $this->_demo_dao->update($data,array('store_id'=>$_SESSION['store_id']));		
	}
	
	
	
}