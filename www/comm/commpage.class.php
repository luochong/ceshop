<?php 
require_once('pagebase.class.php');
require_once("daofactory.class.php");
define("PAGE_CODE", "commpage");
class commpagePage extends PageBase {
	private $_demo_dao;
	public $data;
	public $form;
	public $form_id;
	
	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getNamedDao('comment');
		$this->form = 'goods';
		$this->form_id = 2;
		$this->_demo_dao->setFrom($this->form,$this->form_id);		
	}
	
	public function prerend()
	{
		$this->data = $this->_demo_dao->getCommentData();
	}
	
	public function getfar($id){		
		return $this->_demo_dao->getFather($id);
	}
	
	public function unload()
	{
		
	
	}

}
	

	