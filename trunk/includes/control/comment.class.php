<?php 
require_once('controlbase.class.php');
require_once("daofactory.class.php");
class commentControl extends ControlBase {
	private $_demo_dao;
	public $sum;

	public function load()
	{
		$factory = DaoFactory::getFactory();
		$this->_demo_dao = $factory->getNamedDao('comment');
	
	}
	public function setoption($form,$form_id){
		
		$this->_demo_dao->setFrom($form,$form_id);	
	}
	
	public function prerend()
	{
		
		
		$this->sum = $this->_demo_dao->countComment();
	
	}
	
	public function unload()
	{
		
	}
	public function addComment(){
		
		$this->_demo_dao->insertComment($this->DBdata['comment_content']);		
	}
}
	

	