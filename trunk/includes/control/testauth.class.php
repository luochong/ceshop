<?php
require_once('controlauth.class.php');
class testauthControl extends ControlAuth{	
	
	function Rend(){		
		/*生产   操作关系     列表*/	
		$this->setOperateMap('testmysql','testmysql.php','测试mysql');
		$this->setOperateMap('test02','test02.php','测试test02');		
		$this->createHTMLList();	
	}
}