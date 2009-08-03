<?php
//******************************************//
///		数据表定义
//******************************************//


require_once("columndefine.class.php");

class TableDefine
{
	private $table_name;
	private $column_index;
	private $column_name;
	private $column_count;

	function __construct($name)
	{
		$this->table_name = strtolower($name);
		$this->column_index = array();
		$this->column_name = array();
		$this->column_count = 0;
	}
	
	function __destruct()
	{
	}
	
	public function addColumn($name, $type, $length, $key)
	{
		$column = new ColumnDefine($name, $type, $length, $key);
		$this->column_index[] = $column;
		$this->column_name[$name] = $column;
		$this->column_count++;
	}
	
	public function makeAllColumnListStatement()
	{
		$str = "";
		foreach ($this->column_index as $column)
		{
			$str = "$str{$column->column_name}, ";
		}
		$str = substr($str, 0, strlen($str) - 2);
		return $str;
	}

	public function makePkColumnConditionStatement()
	{
		$str = "";
		foreach ($this->column_index as $column)
		{
			if ($column->column_key === "pri")
			{
				$str = "$str{$column->column_name} = ? and ";
			}
		}
		$str = substr($str, 0, strlen($str) - 5);
		return $str;
	}

	public function makeNonPkColumnConditionStatement()
	{
		$str = "";
		foreach ($this->column_index as $column)
		{
			if (!($column->column_key === "pri"))
			{
				$str = "$str{$column->column_name} = ? and ";
			}
		}
		$str = substr($str, 0, strlen($str) - 5);
		return $str;
	}

	public function makeColumnConditionStatement($argv)
	{
	}

	public function __toString()
	{
		$str = "table_name = $this->table_name: <br/>";
		for ($i = 0; $i < $this->column_count; $i++)
		{
			$str = $str . "{" . $this->column_index[$i] . "}<br/>";
		}
		return $str;
	}
	
	public function getTableName()
	{
		return $this->table_name;
	}
	
	public function getColumnCount()
	{
		return $this->column_count;
	}
	
	public function getColumnByIndex($idx)
	{
		if (isset($this->column_index[$idx]))
		{
			return $this->column_index[$idx];
		}
		else
		{
			return NULL;
		}
	}
	
	public function getColumnByName($name)
	{
		if (isset($this->column_name[$name]))
		{
			return $this->column_name[$name];
		}
		else
		{
			return NULL;
		}
	}
}

?>
