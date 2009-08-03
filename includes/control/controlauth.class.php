<?php
require_once('registry.include.php');

abstract  class ControlAuth{
	protected $_acl;
	protected  $url_operate_map = array();
	
	protected $role;
	function __construct()
	{	
		$this->_acl = Registry::get('acl');
	}
	
	abstract public function Rend();
	
	protected function setOperateMap($operate,$url,$name){
		
		if($this->_acl->haveOperate(Registry::get('page_module'),$operate)){
			
			$this->url_operate_map[$operate]['url'] =  $url;
			$this->url_operate_map[$operate]['name'] =  $name;
		}
		
	}
	protected  function setRole($role =NULL){
		$this->role = $role;
		if($role == NULL){
			$this->role = $_SESSION[Registry::get('page_module')]['role'];
		}		
	}
	protected function createHTMLList(){		
		$this->setRole();		
		echo '<ul>';
		
		foreach ($this->url_operate_map as $key => $operate){
			
			if(PAGE_CODE == $key){ $class = 'ischeck';}
			if($this->isAllowed($this->role,$key)) echo "<li class=\"$class\" ><a href = \"{$operate['url']}\">",$operate['name'],'</a></li>';		
			$class = '';
		}	
		echo '</ul>';
	}
	
	protected  function isAllowed($role,$operate){		
	    	    
		return $this->_acl->isAllowed($role,Registry::get('page_module'),$operate);	
	}
	
}