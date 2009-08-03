<?php
require_once("pagebase.class.php");
define("PAGE_CODE", "testmysql");
class testmysqlPage extends PageBase
{

	public function load()
	{
		
		$factory = DaoFactory::getFactory();
		$dao = $factory->getSimpleDao();
		$dao->setTableName("test");
		//print_r($dao->selectA());
		
		//echo $dao->getNewCode("test",'id',8);
	}
	
	public function prerend()
	{

	}
	
	public function unload()
	{
		
	}
	
}

?>
