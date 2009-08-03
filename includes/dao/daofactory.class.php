<?php
//**************************//
//´´½¨dao
//www.cardii.com
//2008-04-05 wzq_pro@163.com
//*************************//

class DaoFactory
{
	private $dbtype;
	
    private function __construct($dbtype)
    {
		$this->dbtype = $dbtype;
    }

    public function getSimpleDao()
    {
		$class_name = $this->dbtype . "Dao";
		require_once($class_name . ".class.php");
		$dao = new $class_name();
		return $dao;
    }

    public function getNamedDao($dao_name)
    {
		$class_name = $dao_name . "Dao";
		require_once($class_name . ".class.php");
		$dao = new $class_name();
		return $dao;
    }

	public function __toString()
	{
		return $this->dbtype . "DaoFactory";
	}
	
	static public function getFactory()
	{
		return new DaoFactory("Mysql");
	}
}

?>
