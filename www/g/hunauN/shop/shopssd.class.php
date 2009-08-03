<?php
require_once("pagebase.class.php");
require_once("daofactory.class.php");
define("PAGE_CODE", "shopssd");

class shopssdPage extends PageBase
{
	private $_demo_dao;
	public $data;
	public $dat;
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
		$this->doSelect_sd();
		//$this->doSelect_sd1();
	}
	
	public function unload()
	{
		
	}
	
	public function doInsert()
	{	
		$this->_demo_dao->setTableName("ce_s_d");	
		
		$data['store_id'] = $this->store_id;
		$data['dish_id'] = $this->dish_id;
		$data['price'] = $this->price;
		$data['ishot'] = $this->ishot;
		$data['isnew'] = $this->isnew;
		
		$this->_demo_dao->insert($data);
		
		$id = $this->_demo_dao->getInsertId();
		
		
		Server::refresh();		
	}
	
	public function doSelect()
	{
		$this->_demo_dao->setTableName("ce_smallstore");
		$con = array('ismeal'=>1);
		$this->data1 = $this->_demo_dao->selectA($con);
		
		$this->_demo_dao->setTableName("ce_dishes");
		$this->data2 = $this->_demo_dao->selectA();
		
		
	}	
	
	public function doSelect_sd()
	{
		$this->_demo_dao->setTableName("ce_smallstore");
		$con = array('store_id'=>$_POST['store_id']);
		$this->data = $this->_demo_dao->selectA($con);
		//print_r($this->data[0]['storename']);
		
		//print_r($_GET['store_id']);
		$this->_demo_dao->setTableName("ce_s_d");
		$con = array('store_id'=>$_POST['store_id']);
		$this->data_sd = $this->_demo_dao->selectA($con);
		
		$n=0;
		foreach ($this->data_sd as $value):
		$this->_demo_dao->setTableName("ce_dishes");
		$data_dish = $this->_demo_dao->selectA(array('dish_id'=>$value['dish_id']));
		$this->data3['sd_id'] = $value['sd_id'];
		$this->data3['dname'] = $data_dish[0]['dname'];
		$this->data3['price'] = $value['price'];
		
		if($value['ishot']==1):
		$this->data3['ishot'] = '是';
		else:$this->data3['ishot'] = '否';
		endif;
		if($value['isnew']==1):
		$this->data3['isnew'] = '是';
		else:$this->data3['isnew'] = '否';
		endif;
		
		
		$this->data4[$n] = $this->data3;
		$n++;
		endforeach;
		//print_r($this->data4);
	}
	/*
	public function doSelect_sd1()
	{
		$this->_demo_dao->setTableName("ce_smallstore");
		$con = array('store_id'=>$_GET['store_id']);
		$this->dat = $this->_demo_dao->selectA($con);
		
		
		//print_r($_GET['store_id']);
		$this->_demo_dao->setTableName("ce_s_d");
		$con = array('store_id'=>$_GET['store_id']);
		$this->data_sd = $this->_demo_dao->selectA($con);
		
		$n=0;
		foreach ($this->data_sd as $value):
		$this->_demo_dao->setTableName("ce_dishes");
		$data_dish = $this->_demo_dao->selectA(array('dish_id'=>$value['dish_id']));
		$this->data3['sd_id'] = $value['sd_id'];
		$this->data3['dname'] = $data_dish[0]['dname'];
		$this->data3['price'] = $value['price'];
		
		if($value['ishot']==1):
		$this->data3['ishot'] = '是';
		else:$this->data3['ishot'] = '否';
		endif;
		if($value['isnew']==1):
		$this->data3['isnew'] = '是';
		else:$this->data3['isnew'] = '否';
		endif;
		
		
		$this->data4[$n] = $this->data3;
		$n++;
		endforeach;
	}
	*/
	
	public function doDelete($id)
	{
		$this->_demo_dao->setTableName("ce_s_d");
		$con = array('sd_id'=>$id);
		print_r($id);
		$this->_demo_dao->delete($con);
		//print_r($con);
		Server::refresh();
	}
	
	public function doDeletes()
	{
		$this->_demo_dao->setTableName("ce_s_d");
		
		$chck=$_POST['check'];
		
		foreach ($chck as $value):
		$con=array('sd_id'=>$value);
		$this->_demo_dao->delete($con);
		endforeach;
		
		Server::refresh();
	}
	
}