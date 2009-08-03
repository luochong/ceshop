<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopsmodify");

class shopsmodifyPage extends PageBase
{
	private $_demo_dao;
	public $data;
	public $data1;
	public $data2;
	public $data3;
	public $store_id;
	public $storename;
	public $area;
	public $boss;
	public $ismeal;
	public $type_id;
	public $tel;
	public $mobile;
	public $qq;
	public $email;
	public $address;
	public $storeinfo;
	public $productinfo;
	public $typename;

	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getSimpleDao();
		$this->_demo_dao->setTableName("ce_smallstore");
		
	}
	
	public function prerend()
	{
		//$this->data = $this->_demo_dao->selectA();
		$this->doSelect();
	}
	
	public function unload()
	{
		
	}
	
	public function doUpdate()
	{	
		$this->_demo_dao->setTableName("ce_smallstore");	
		
		$data['storename'] = $this->storename;
		$data['area'] = $this->area;
		$data['boss'] = $this->boss;
		$data['ismeal'] = $this->ismeal;
		$data['type_id'] = $this->type_id;
		$data['tel'] = $this->tel;
		$data['mobile'] = $this->mobile;
		$data['qq'] = $this->qq;
		$data['email'] = $this->email;
		$data['address'] = $this->address;
		$data['storeinfo'] = $this->storeinfo;
		//$data['productinfo'] = $this->productinfo;
		
		$cond = array('store_id'=>$_GET['store_id']);
		$this->_demo_dao->update($data,$cond);
		/*
		$id = $this->_demo_dao->getInsertId();
		print_r($id);
		*/
		Server::refresh();		
	}
	
	public function doSelect()
	{
		$this->_demo_dao->setTableName("ce_smallstore");
		$con = array('store_id'=>$_GET['store_id']);
		$this->data1 = $this->_demo_dao->selectA($con);
		$this->_demo_dao->setTableName("ce_smallstore_type");
		$con = array('type_id'=>$this->data1[0]['type_id']);
		$this->data2 = $this->_demo_dao->selectA($con);
		$this->data3 = $this->_demo_dao->selectA();
		//print_r($this->data3);
	}
	
}