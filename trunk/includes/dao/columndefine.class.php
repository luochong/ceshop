<?php

//******************************************//
///		数据库表字段定义
///     www.cardii.com 
//******************************************//


class ColumnDefine
{
	public $column_name;
	public $column_type;
	public $column_length;
	public $column_key;

	function __construct($name, $type, $length, $key)
	{
		$this->column_name = strtolower($name);
		$this->column_type = strtolower($type);
		$this->column_length = $length;
		$this->column_key = strtolower($key);
	}
	
	function __destruct()
	{
	}
	
	public function __toString()
	{
		return "column_name = $this->column_name, column_type = $this->column_type, column_length = $this->column_length, column_key = $this->column_key";
	}
}

?>
