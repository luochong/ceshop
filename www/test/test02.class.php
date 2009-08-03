<?php
require_once("pagebase.class.php");
define("PAGE_CODE", "test02");
class test02Page extends PageBase
{

	public function load()
	{
		

		
		//echo $dao->getNewCode("test",'id',8);
	}
	
	public function prerend()
	{

	}
	
	public function unload()
	{
		
	}
	public function show(){
		echo 'helloworld!';
	}
	
}

?>
