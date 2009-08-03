<?php
include_once('actionbase.class.php');
class testAction extends  ActionBase {		
	
	function doAction(){
		/*单个模块要执行的事情*/
			
		/*权限检测*/	
		if(!$this->isAllowed($this->getRole())){			
			Server::showError('出错了，这个操作你没有权限');			
		}		
	}
	public  function getRoleByDB(){	
		
		return 'admin';
	}
	
}



