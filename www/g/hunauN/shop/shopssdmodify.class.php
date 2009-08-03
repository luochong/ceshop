<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopssdmodify");

class shopssdmodifyPage extends PageBase
{
	private $_demo_dao;
	public $data;
	public $data1;
	public $data2;
	public $data3;
	public $data_sd;
	public $data4;
	public $store_id;
	public $dish_id;
	public $price;
	public $ishot;
	public $isnew;

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_s_d");
		
	}
	
	public function prerend()
	{
		//$this->data = $this->_demo_dao->selectA();
		$this->doSelect();
		//$this->doSelect_sd();
	}
	
	public function unload()
	{
		
	}
	
	public function doUpdate()
	{
		$this->_demo_dao->setTableName("ce_s_d");	
		
		
		$data['price'] = $this->price;
		$data['ishot'] = $this->ishot;
		$data['isnew'] = $this->isnew;
		
		$con = array('sd_id'=>$_GET['sd_id']);
		
		$this->_demo_dao->update($data,$con);
		
		Server::refresh();		
	}
	
	public function doSelect()
	{
		
		$this->_demo_dao->setTableName("ce_s_d");
		$con = array('sd_id'=>$_GET['sd_id']);
		$this->data3 = $this->_demo_dao->selectA($con);
		//print_r($this->data3[0]['price']);
		
		$this->_demo_dao->setTableName("ce_smallstore");
		$con = array('store_id'=>$this->data3[0]['store_id']);
		$this->data1 = $this->_demo_dao->selectA($con);
		
		$this->_demo_dao->setTableName("ce_dishes");
		$con = array('dish_id'=>$this->data3[0]['dish_id']);
		$this->data4 = $this->_demo_dao->selectA($con);
	}	
	
}