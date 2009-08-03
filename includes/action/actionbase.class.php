<?php
require_once('action.interface.php');
/**
 * 模块前端操作接口   用于对模块的权限检测
 *
 */
class ActionBase implements actionInterface {
	protected $_page_code;
	protected $_page_module;	
	function __construct(){		
	/*所以模块的都要做的事实*/	
		
		$this->_page_code = PAGE_CODE;/*testmysql*/
		$this->_page_module = Registry::get('page_module');/*test*/	
		
		/*加载权限表*/
		require_once('authMap.include.php');
		
		
		
	}

	/**
	 *检测权限
	 *
	 * @param string $role
	 */
	protected  function isAllowed($role){		
	    $acl = Registry::get('acl');	    
		return $acl->isAllowed($role,$this->_page_module,$this->_page_code );	
	}
	
	protected function getRole(){
		return isset($_SESSION[$this->_page_module]['role'])?$_SESSION[$this->_page_module]['role'] :($_SESSION[$this->_page_module]['role'] = $this->getRoleByDB());		
		
	}
	
	
	/*基类必须重载的两个函数*/
	public  function doAction(){}
	public  function getRoleByDB(){}
	

	
}
