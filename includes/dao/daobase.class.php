<?php
//**************************//
//数据库基类
//www.cardii.com  wzq_pro@163.com
//2008-04-06 
//*************************//

abstract class DaoBase
{
	static protected $dbhost;  //主机
	static protected $dbuser;  //用户名
	static protected $dbpwd;   //密码
	static protected $dbinst;  //数据库实例

    protected $conn;
    protected $table_name;
    
    function __construct($conn = NULL)  //构造函数
    {
		if (!isset(Daobase::$dbhost))
		{
			require_once("config.include.php");
			Daobase::$dbhost = $hostname;
			Daobase::$dbuser = $dbusername;
			Daobase::$dbpwd  = $dbpassword;
			Daobase::$dbinst = $dbname;
		}
		
		$this->table_name = "";
		
		if (isset($conn))
		{
			$this->conn = $conn;
			//$this->is_auto_connect = false;
		}
		else
		{
			//$this->is_auto_connect = true;
		}
		
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function setTableName($table_name)
    {
        $this->table_name = $table_name;
    }

    abstract public function insert($cond);
	
    abstract public function delete($cond);
	
    abstract public function update($data, $cond);
	
	abstract public function select($cond = NULL);
	
	abstract public function count($cond = NULL);
	
	abstract protected function getTableDefine($table_name);
	
	abstract protected function connect($mode = TRUE);
	
	abstract protected function disconnect($conn = NULL);
}

?>
