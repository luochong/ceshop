<?php
//******************************************//
///		应用于Mysql数据库的数据访问对象。
//      www.cardii.com 2008-04-06  
//*****************************************//

//$con = array('id'=>5);
require_once("daobase.class.php");
require_once("tabledefine.class.php");
require_once("globals.class.php");
require_once("daoexception.class.php");



class MysqlDao extends DaoBase
{
	public $insert_id;
	
	public function getNewCode($table_name, $field_name, $width = NULL)
	{
		$sql = "select $field_name from $table_name order by $field_name asc";
		
		$argv = array();
		$rows = $this->executeQuery($sql, $argv);
		
		$value1 = 0;
		$value2 = 0;
		$i = 1;
		$j = 0;
		$find_result = false;
		
		while(isset($rows[$j][0]))
		{
			if($i == 1) $value1 = $rows[$j][0];
			if($i == 2) $value2 = $rows[$j][0];
			if($i > 2)
			{
				$value1 = $value2;
				$value2 = $rows[$j][0];
			}
			
			if(($i == 1) and ($value1 > 1))
			{
				$new_id = 1;
				$find_result = true;
				break;
			}
			
			if($value2 - $value1  > 1)
			{
				$new_id = $value1 + 1;
				$find_result = true;
				break;
			}
			
			$i++;
			$j++;
		}
		if($i == 1) $the_new_code = 1;
		else if($find_result) $the_new_code = $new_id;
		else if($i == 2) $the_new_code = $value1 + 1;
		else if($i >= 3) $the_new_code = $value2 + 1;
		
		if($width != NULL)
		{
			$code_len = strlen($the_new_code);
			for($i = 1; $i <= $width - $code_len; $i++)
			{
				$the_new_code = "0".$the_new_code;
			}
		}
		return $the_new_code;
	}


	/// [Summary]
	///     按条件从指定表中检索记录
	/// [Parameter]
	///     表名、字段名和检索条件
	/// [Return]
	///     检索结果
	public function simpleFetchList($table_name, $field = NULL, $cond = NULL, $order = NULL, $pagesize = 0, $pageno = 0, $distinct = false)
	{
		if($field)
		{
			$field_list = "";
			foreach($field as $value)
			{
				$field_list .= $value.", ";
			}
			$field_list = substr($field_list, 0, strlen($field_list) - 2);
			if($distinct) //锟斤拷锟斤拷distinct锟斤拷锟?select锟斤拷锟斤拷械锟斤拷馗锟斤拷锟斤拷锟? 
			{
				$sql = "select distinct ".$field_list." from $table_name";
			}
			else
			{
				$sql = "select ".$field_list." from $table_name";
			}
		}
		else
		{
			return NULL;
		}
		
		$argv = array();
		if($cond)
		{
			$has_where = false;
			foreach ($cond as $key => $value)
			{
				if($value != "all")
				{
					if ($has_where)
					{
						$sql .= " and $key = ?";
						$argv[] = $value;
					}
					else
					{
						$sql .= " where $key = ?";
						$argv[] = $value;
						$has_where = true;
					}
				}
			}
		}

		if($order)
		{
			$has_order_by = false;
			foreach ($order as $key => $value)
			{
				if ($has_order_by)
				{
					$sql .= " $key $value,";
				}
				else
				{
					$sql .= " order by $key $value,";
					$has_order_by = true;
				}
			}
			$sql = substr($sql, 0, strlen($sql) - 1);
		}
		
		$rows = $this->executeQuery($sql, $argv, $pagesize, $pageno);
		
		return $rows;
	}
	
    public function insert($cond)
	{
		if (strlen($this->table_name) == 0)
		{
			$error = "table name of DAO not specified yet.";
			//Logger::trace($error, LOG_LEVEL_ERROR);			
			throw new DaoException($error);
			
		}
		$tabdef = $this->getTableDefine($this->table_name);

		$argv = array();
		
		$str1 = "";
		$str2 = "";
		foreach ($cond as $key => $value)
		{
			$str1 .=  "$key, ";
			$str2 .=  "?, ";
			$argv[] = $value;
		}
		$str1 = substr($str1, 0, strlen($str1) - 2);
		$str2 = substr($str2, 0, strlen($str2) - 2);
		
		$sql = "insert into " . $this->table_name . " ($str1) values ($str2)";
	
		$ret = $this->executeNonQuery($sql, $argv);
		
		return $ret;
	}
	
    public function delete($cond)
	{
		if (strlen($this->table_name) == 0)
		{
			$error = "table name of DAO not specified yet.";
			//Logger::trace($error, LOG_LEVEL_ERROR);
			
			throw new DaoException($error);
			
		}
		$tabdef = $this->getTableDefine($this->table_name);
		
		$sql = "delete from " . $this->table_name;
		
		$argv = array();
		$haswhere = false;
		foreach ($cond as $key => $value)
		{
			if ($haswhere)
			{
				$sql .= " and $key = ?";
				$argv[] = $value;
			}
			else
			{
				$sql .= " where $key = ?";
				$argv[] = $value;
				$haswhere = true;
			}
		}
		
		return $this->executeNonQuery($sql, $argv);
	}
	
    public function update($data, $cond)
	{
		if (strlen($this->table_name) == 0)
		{
			$error = "table name of DAO not specified yet.";
			//Logger::trace($error, LOG_LEVEL_ERROR);
			
			throw new DaoException($error);
			
		}
		$tabdef = $this->getTableDefine($this->table_name);

		$argv = array();
		
		$str1 = "";
		foreach ($data as $key => $value)
		{
			$str1 .=  "$key = ?, ";
			$argv[] = $value;			
		}
		$str1 = substr($str1, 0, strlen($str1) - 2);
		
		$coldef = $tabdef->getColumnByName("UPDATE_TIME");
		if (isset($coldef))
		{
			$str1 .= ", update_time = CURRENT_TIMESTAMP";
		}
		
		$str2 = "";
		foreach ($cond as $key => $value)
		{
			$str2 .= " and $key = ?";
			$argv[] = $value;
			
		}
		$str2 = substr($str2, 5);
		
		$sql = "update " . $this->table_name . " set $str1 where $str2";
		
		return $this->executeNonQuery($sql, $argv);
	}
	
	/// [Summary]
	///     按指定的条件检索table_name中的记录 
	/// [Parameter]
	///     $cont - 查询条件，形如array("field1" => "xxxx", "field2" => "xxxx")
	///     $pagesize - 每页记录数。为0表示不分页检索，检索出全记录。
	///     $pageno   - 查询的页序号。$pagesize为0时，忽略此参数。
	public function select($cond = NULL, $pagesize = 0, $pageno = 0, $order = NULL)
	{
		if (strlen($this->table_name) == 0)
		{
			$error = "table name of DAO not specified yet.";
			//Logger::trace($error, LOG_LEVEL_ERROR);			
			throw new DaoException($error);
		
		}
		$tabdef = $this->getTableDefine($this->table_name);

		$argv = array();

		$colcount = $tabdef->getColumnCount();
		$colstr  = "";
		for ($i = 0; $i < $colcount; $i++)
		{
			$coldef = $tabdef->getColumnByIndex($i);
			$colstr .= ", " . $coldef->column_name;
		}
		$sql = "select " . substr($colstr, 2);
		$sql .= " from " . $tabdef->getTableName();

		if ($cond)
		{
			$str = "";
			foreach ($cond as $key => $value)
			{
 
				if (substr($value, 0, 1) == "%" || substr($value, -1, 1) == "%")
				{
					$str .= " and $key like ?";
				}
				else
				{
					$str .= " and $key = ?";
 
				}
				$argv[] = $value;
			}
			$sql .= " where " .substr($str, 5);
		}
		
		if (isset($order))
		{
			$sql .= " order by ".$order;
		}
		
		$allrows = $this->executeQuery($sql, $argv, $pagesize, $pageno);
		
		return $allrows;
	}
	
	
	public function selectA($cond = NULL, $pagesize = 0, $pageno = 0, $order = NULL)
	{
		if (strlen($this->table_name) == 0)
		{
			$error = "table name of DAO not specified yet.";
			//Logger::trace($error, LOG_LEVEL_ERROR);			
			throw new DaoException($error);
		
		}
		$tabdef = $this->getTableDefine($this->table_name);

		$argv = array();

		$colcount = $tabdef->getColumnCount();
		$colstr  = "";
		for ($i = 0; $i < $colcount; $i++)
		{
			$coldef = $tabdef->getColumnByIndex($i);
			$colstr .= ", " . $coldef->column_name;
		}
		$sql = "select " . substr($colstr, 2);
		$sql .= " from " . $tabdef->getTableName();

		if ($cond)
		{
			$str = "";
			foreach ($cond as $key => $value)
			{
 
				if (substr($value, 0, 1) == "%" || substr($value, -1, 1) == "%")
				{
					$str .= " and $key like ?";
				}
				else
				{
					$str .= " and $key = ?";
 
				}
				$argv[] = $value;
			}
			$sql .= " where " .substr($str, 5);
		}
		
		if (isset($order))
		{
			$sql .= " order by ".$order;
		}
		
		$allrows = $this->executeQueryA($sql, $argv, $pagesize, $pageno);
		
		return $allrows;
	}
	
	/// [Summary]
	///     按指定的条件查询table_name中的记录条数
	public function count($cond = NULL)
	{
		if (strlen($this->table_name) == 0)
		{
			$error = "table name of DAO not specified yet.";
			//Logger::trace($error, LOG_LEVEL_ERROR);			
			throw new DaoException($error);
			//throw new DaoException($error);
		}
		$tabdef = $this->getTableDefine($this->table_name);

		$argv = array();

		$sql = "select count(*) from " . $tabdef->getTableName();
		if ($cond)
		{
					$str = "";
					foreach ($cond as $key => $value)
					{
		 
						if (substr($value, 0, 1) == "%" || substr($value, -1, 1) == "%")
						{
							$str .= " and $key like ?";
						}
						else
						{
							$str .= " and $key = ?";
		 
						}
						$argv[] = $value;
					}
					$sql .= " where " .substr($str, 5);
		}		
		$allrows = $this->executeQuery($sql, $argv);
		//Logger::trace($sql, LOG_LEVEL_VERBOSE);
		
		return $allrows[0][0];
	}
	/// [Summary]
	///     使用指定的Sql语句进行查询，并返回查询结果
	/// [Parameter]
	///     $sql  - 查询语句，形如："select .... from ...."
	///     $argv - 查询参数，例如："select ... where f1 = ?"中问号所代表的动态参数
 
 
	///     $pagesize - 每页记录数。为0表示不分页检索，检索出全记录。
 
	///     $pageno   - 查询的页序号。$pagesize为0时，忽略此参数。
	/// [Return]
	///     查询结果二维数组。
	public function executeQuery($sql, $argv = NULL, $pagesize = 0, $pageno = 0)
	{
		//Logger::trace("MysqlDao.executeQuery executed", LOG_LEVEL_NOTICE);
		
		if ($pagesize < 0)
		{
			$pagesize = 0;
 		}

		if ($pageno < 0)
		{
			$pageno = 0;
		}
				
		// 校锟斤拷锟斤拷锟斤拷锟叫э拷锟?
		$lowstr = strtolower($sql);
		if (!(strtolower(substr($lowstr, 0, 6)) === "select"))
		{
			//Logger::trace("Invalid query SQL statement.", LOG_LEVEL_ERROR);
			//Logger::debug("sql = $sql, argv = $argv");
		
		
			throw new DaoException("Invalid query SQL statement.");
		}
		$pos = strpos($lowstr, "from");
		if (!strpos($lowstr, "from"))
		{
			//Logger::trace("Invalid query SQL statement.", LOG_LEVEL_ERROR);
			//Logger::debug("sql = $sql, argv = $argv");
			
			throw new DaoException("Invalid query SQL statement.");
		}
		$colstr = substr($lowstr, 6, $pos - 6);

		// 锟斤拷锟斤拷锟窖?锟斤拷锟斤拷锟斤拷锟斤拷侄胃锟斤拷锟?		
		$pos = 0;
		$colcount = 0;
		while (!($pos === false))
		{
			$pos = strpos($colstr, ",", $pos + 1);
			$colcount++;
		}

		// 锟斤拷锟斤拷锟斤拷菘锟?l锟接ｏ拷锟斤拷锟斤拷锟揭?锟斤拷
		$connected = $this->connected();
		$conn = ($connected ? $this->conn : $this->connect(FALSE));

		// 锟斤拷默锟斤拷锟街凤拷锟斤拷锟斤拷为utf8		
		mysqli_query($conn, "set names 'utf8'");


		// 锟斤拷询
		$allrow = array();
		$stmt = mysqli_prepare($conn, $sql);
		if (mysqli_errno($conn))
		{
			$errno = mysqli_errno($conn);
			$error = "MYSQL ERROR #" . $errno . " : " . mysqli_error($conn);
			//Logger::trace($error, LOG_LEVEL_ERROR);
			//Logger::debug("sql = $sql ". ($argv));	
			throw new DaoException($error, $errno);
		}

		//Logger::trace("sql = " . $sql, LOG_LEVEL_VERBOSE);
		// 锟斤拷莶锟斤拷锟侥革拷锟斤拷态锟斤拷刹锟斤拷锟斤拷锟斤拷锟?
		if (isset($argv) && count($argv) > 0)
		{
			$bind_param_cmd = "mysqli_stmt_bind_param(\$stmt, ";
			$paramstr = "";
			$bindstr = "";
			$holdstr = "";
			$i = 0;
			foreach ($argv as $arg)
			{
				$paramstr .= "\$invar$i, ";
				$bindstr .= "\$invar$i = \$argv[$i]; ";
				$holdstr .= "s";
				$i++;
			}
			$bind_param_cmd = "mysqli_stmt_bind_param(\$stmt, \"$holdstr\", " . substr($paramstr, 0, strlen($paramstr) - 2) ."); ";
			$bind_param_cmd .= $bindstr;
			//Logger::trace("bind parameter: " . $bind_param_cmd, LOG_LEVEL_VERBOSE);
			eval($bind_param_cmd);
		}
		
		// 执锟斤拷SQL锟斤拷锟?			
		mysqli_stmt_execute($stmt);
		if (mysqli_stmt_errno($stmt))
		{
			$errno = mysqli_stmt_errno($stmt);
			$error = "MYSQL ERROR #" . $errno . " : " . mysqli_stmt_error($stmt);
			//Logger::trace($error, LOG_LEVEL_ERROR);
			//Logger::debug("sql = $sql ". ($argv));

			throw new DaoException($error, $errno);
		}
		
		// 锟斤拷莶锟窖?锟斤拷锟街讹拷锟斤拷态锟斤拷山锟斤拷锟斤拷锟斤拷
		// 锟斤拷锟斤拷锟斤拷纾?mysqli_stmt_bind_result($stmt, $ret1, $ret2, $ret3, ...);
		$bind_result_cmd = "mysqli_stmt_bind_result(\$stmt, ";
		for ($i = 0; $i < $colcount; $i++)
		{
			$bind_result_cmd .= "\$outvar$i, ";
		}
		$bind_result_cmd = substr($bind_result_cmd, 0, strlen($bind_result_cmd) - 2) .");";
		//Logger::trace("bind result: " . $bind_result_cmd, LOG_LEVEL_VERBOSE);
		eval($bind_result_cmd);

		// 锟斤拷莶锟窖?锟斤拷锟街讹拷锟斤拷态锟斤拷山锟斤拷锟饺★拷锟斤拷
		// 锟斤拷锟斤拷锟斤拷纾?$row = array($ret1, $ret2, $ret3, ...);
		$fetch_data_cmd = "\$row = array(";
		for ($i = 0; $i < $colcount; $i++)
		{
			$fetch_data_cmd .= "\$outvar$i, ";
		}
		$fetch_data_cmd = substr($fetch_data_cmd, 0, strlen($fetch_data_cmd) - 2) .");";
		//Logger::trace("fetch data: " . $fetch_data_cmd, LOG_LEVEL_VERBOSE);
		
		mysqli_stmt_store_result($stmt);

		// 锟斤拷页锟斤拷锟斤拷锟斤拷
		if ($pagesize > 0)
		{
			 mysqli_stmt_data_seek($stmt, $pagesize * $pageno);
 		}
		$cnt = 1;
		while (mysqli_stmt_fetch($stmt))
		{
			eval($fetch_data_cmd);
			$allrow[] = $row;
 
			if ($pagesize > 0)
			{
				if ((++$cnt) > $pagesize)
				{
					break;
				}
			}
		}
		mysqli_stmt_close($stmt);
		
		// 锟截憋拷锟斤拷菘锟?l锟接ｏ拷锟斤拷锟斤拷锟揭?锟斤拷
		if (!($connected))
		{
			$this->disconnect($conn);
		}
		
		return $allrow;
	}	
	/// [Summary]
	///     使用指定的Sql语句进行查询，并返回查询结果 luochong 2009
	/// [Parameter]
	///     $sql  - 查询语句，形如："select .... from ...."
	///     $argv - 查询参数，例如："select ... where f1 = ?"中问号所代表的动态参数
 
 
	///     $pagesize - 每页记录数。为0表示不分页检索，检索出全记录
 	///     
	///     $pageno   - 查询的页序号。$pagesize为0时，忽略此参数。
	/// [Return]
	///     查询结果二维关联数组。
		public function executeQueryA($sql, $argv = NULL,$pagesize = 0, $pageno = 0)
	{
		//Logger::trace("MysqlDao.executeQuery executed", LOG_LEVEL_NOTICE);
		
		if ($pagesize < 0)
		{
			$pagesize = 0;
 		}

		if ($pageno < 0)
		{
			$pageno = 0;
		}
				
		// 校锟斤拷锟斤拷锟斤拷锟叫э拷锟?
		$lowstr = strtolower($sql);
		if (!(strtolower(substr($lowstr, 0, 6)) === "select"))
		{
			
						
			throw new DaoException("Invalid query SQL statement.");
		}
		$pos = strpos($lowstr, "from");
		if (!strpos($lowstr, "from"))
		{
			//Logger::trace("Invalid query SQL statement.", LOG_LEVEL_ERROR);
			//Logger::debug("sql = $sql, argv = $argv");
			
			throw new DaoException("Invalid query SQL statement.");
		}
		$colstr = substr($lowstr, 6, $pos - 6);

		// 锟斤拷锟斤拷锟窖?锟斤拷锟斤拷锟斤拷锟斤拷侄胃锟斤拷锟?		
		$pos = 0;
		$colcount = 0;
		while (!($pos === false))
		{
			$pos = strpos($colstr, ",", $pos + 1);
			$colcount++;
		}

		// 锟斤拷锟斤拷锟斤拷菘锟?l锟接ｏ拷锟斤拷锟斤拷锟揭?锟斤拷
		$connected = $this->connected();
		$conn = ($connected ? $this->conn : $this->connect(FALSE));

		// 锟斤拷默锟斤拷锟街凤拷锟斤拷锟斤拷为utf8		
		mysqli_query($conn, "set names 'utf8'");
		// 锟斤拷询
		$allrow = array();
		$stmt = mysqli_prepare($conn, $sql);
		if (mysqli_errno($conn))
		{
			$errno = mysqli_errno($conn);
			$error = "MYSQL ERROR #" . $errno . " : " . mysqli_error($conn);			
			throw new DaoException($error, $errno);
		}

		//Logger::trace("sql = " . $sql, LOG_LEVEL_VERBOSE);
		// 锟斤拷莶锟斤拷锟侥革拷锟斤拷态锟斤拷刹锟斤拷锟斤拷锟斤拷锟?
		if (isset($argv) && count($argv) > 0)
		{
			$bind_param_cmd = "mysqli_stmt_bind_param(\$stmt, ";
			$paramstr = "";
			$bindstr = "";
			$holdstr = "";
			$i = 0;
			foreach ($argv as $arg)
			{
				$paramstr .= "\$invar$i, ";
				$bindstr .= "\$invar$i = \$argv[$i]; ";
				$holdstr .= "s";
				$i++;
			}
			$bind_param_cmd = "mysqli_stmt_bind_param(\$stmt, \"$holdstr\", " . substr($paramstr, 0, strlen($paramstr) - 2) ."); ";
			$bind_param_cmd .= $bindstr;
			//Logger::trace("bind parameter: " . $bind_param_cmd, LOG_LEVEL_VERBOSE);
			eval($bind_param_cmd);
		}
		
		// 执锟斤拷SQL锟斤拷锟?			
		mysqli_stmt_execute($stmt);
		if (mysqli_stmt_errno($stmt))
		{
			$errno = mysqli_stmt_errno($stmt);
			$error = "MYSQL ERROR #" . $errno . " : " . mysqli_stmt_error($stmt);
			//Logger::trace($error, LOG_LEVEL_ERROR);
			//Logger::debug("sql = $sql ". ($argv));	
			throw new DaoException($error, $errno);
		}		
		//获得结果集的元数据 //
		
		/*捆绑参数   关联数组 以结果集的字段为索引*/		
		$data = mysqli_stmt_result_metadata($stmt);
		$fields = array();
		$out = array();
		$fields[0] = $stmt;
		$count = 1;
		while($field = mysqli_fetch_field($data)) {
			    $fields[$count] = &$out[$field->name];
			    $count++;
		}   
		call_user_func_array(mysqli_stmt_bind_result, $fields);	
			   		//结果缓存			   		
		mysqli_stmt_store_result($stmt);		
					//分页
		if ($pagesize > 0)
		{
			 mysqli_stmt_data_seek($stmt, $pagesize * $pageno);
		}
		$cnt = 1;
					
		while (mysqli_stmt_fetch($stmt))
		{	
						/*解决$row引用赋值只赋最后一条记录的问题
							用下面的循环完成数据的赋值
						*/
			foreach( $out as $key=>$value )
			{
			     $row_tmb[ $key ] = $value;
			 }			
				 $allrow[] = $row_tmb;
		     if ($pagesize > 0)
			{
				if ((++$cnt) > $pagesize)
				{
					break;
				}
			}						
		}		
		mysqli_stmt_close($stmt);			
		if (!($connected))
		{
			$this->disconnect($conn);
		}		
		return $allrow;
	}
	/// [Summary]
	///     执行非查询Sql语句（增、删、改）
	/// [Parameter]
	///     $sql  - SQL语句，形如："insert into(...) values(...)"
	///     $argv - SQL语句的数，例如："insert into(...) values(?, ?, ...)"中问号所代表的动态参数
	/// [Return]
	///     增、删、改所影响到的记录数。
	public function executeNonQuery($sql, $argv = NULL)
	{	

		$affected = 0;
		$lowstr = strtolower($sql);
		if (strtolower(substr($lowstr, 0, 6)) === "select")
		{
	
			throw new DaoException("Invalid query SQL statement.");
		}

	
		$connected = $this->connected();
		$conn = ($connected ? $this->conn : $this->connect(FALSE));

	
		mysqli_query($conn, "set names 'utf8'");
		 

	
		$stmt = mysqli_prepare($conn, $sql);
		if (mysqli_errno($conn))
		{
			$errno = mysqli_errno($conn);
			$error = "MYSQL ERROR #" . $errno . " : " . mysqli_error($conn);		
					
			throw new DaoException($error, $errno);
		}

		//Logger::trace("sql = " . $sql, LOG_LEVEL_VERBOSE);
		// 锟斤拷莶锟斤拷锟侥革拷锟斤拷态锟斤拷刹锟斤拷锟斤拷锟斤拷锟?
		if (isset($argv) && count($argv) > 0)
		{
			$bind_param_cmd = "mysqli_stmt_bind_param(\$stmt, ";
			$paramstr = "";
			$bindstr = "";
			$holdstr = "";
			$i = 0;
			foreach ($argv as $arg)
			{
				$paramstr .= "\$invar$i, ";
				$bindstr .= "\$invar$i = \$argv[$i]; ";
				$holdstr .= "s";
				$i++;
			}
			$bind_param_cmd = "mysqli_stmt_bind_param(\$stmt, \"$holdstr\", " . substr($paramstr, 0, strlen($paramstr) - 2) ."); ";
			$bind_param_cmd .= $bindstr;
			//Logger::trace("bind parameter: " . $bind_param_cmd, LOG_LEVEL_VERBOSE);
			eval($bind_param_cmd);
		}

		// 执锟斤拷SQL锟斤拷锟?			
		mysqli_stmt_execute($stmt);
		if (mysqli_stmt_errno($stmt))
		{
			$errno = mysqli_stmt_errno($stmt);
		    $error = "MYSQL ERROR #" . $errno . " : " . mysqli_stmt_error($stmt);
			//Logger::trace($error, LOG_LEVEL_ERROR);
			//Logger::debug("sql = $sql ". ($argv));
			$args['error']=$error;
			throw new DaoException($error, $errno);
			//throw new DaoException("锟斤拷锟斤拷", $errno);
		}

		$this->insert_id = mysqli_stmt_insert_id($stmt);

		$affected = mysqli_stmt_affected_rows($stmt);
		
		mysqli_stmt_close($stmt);
		
		// 锟截憋拷锟斤拷菘锟?l锟接ｏ拷锟斤拷锟斤拷锟揭?锟斤拷
		if (!($connected))
		{
			$this->disconnect($conn);
		}
		
		return $affected;
	}
	
	public function getInsertId()
	{
		return $this->insert_id;
	}
	
	/// [Summary]
	///     建立数据库连接
	/// [Parameter]
	///     $mode - 连接模式。TRUE：连接保持于DAO实例中，FALSE：建立方法本地连接。
	protected function connect($mode = TRUE)
	{
		$conn = mysqli_connect(DaoBase::$dbhost, DaoBase::$dbuser, DaoBase::$dbpwd, DaoBase::$dbinst);
		if (mysqli_connect_errno())
		{
			$errno = mysqli_connect_errno();
			$error = "MYSQL ERROR #" . $errno . " : " . mysqli_connect_error();
			//Logger::trace($error, LOG_LEVEL_ERROR);
			//Logger::debug("dbhost = {DaoBase::$dbhost}, {DaoBase::$dbuser}, dbpwd = {DaoBase::$dbpwd}, dbinst = {DaoBase::$dbinst}, ", LOG_LEVEL_VERBOSE);
			
			throw new DaoException($error, $errno);
		}
		
		if ($mode)
		{
			$this->conn = $conn;
		}
		
		
		return $conn;
	}
	
	/// [Summary]
	///     释放数据库连接
	/// [Parameter]
	///     $conn - 要释放的数据库连接。如未指定，则关闭DAO实例的数据库连接。
	protected function disconnect($conn = NULL)
	{
		if (isset($conn))
		{
			mysqli_close($conn);
		}
		else
		{
			mysqli_close($this->conn);
			unset($this->conn);
		}
	}
	
	protected function connected()
	{
		return isset($this->conn);
	}

	protected function startTransaction()
	{
		mysqli_autocommit($this->conn, FALSE);
	}
	
	protected function commitTransaction()
	{
		mysqli_commit($this->conn);
		mysqli_autocommit($this->conn, TRUE);
	}

	protected function rollbackTransaction()
	{
		mysqli_rollback($this->conn);
		mysqli_autocommit($this->conn, TRUE);
	}

	/// [Summary]
	///     从系统表中读取表定义
	/// [Parameter]
	///     $table_name - 表名
	/// [Return]
	///     TableDefine - 表定义
	public function getTableDefine($table_name)
	{
		// 杩???ョ郴缁???版??搴?
		$dbinst = "information_schema";
		$sysconn = mysqli_connect(DaoBase::$dbhost, DaoBase::$dbuser, DaoBase::$dbpwd, $dbinst);
		if (mysqli_connect_errno())
		{
			$errno = mysqli_connect_errno();
			$error = "MYSQL ERROR #" . $errno . " : " . mysqli_connect_error();
			//Logger::trace($error, LOG_LEVEL_ERROR);
			//Logger::debug("dbhost = {DaoBase::$dbhost}, {DaoBase::$dbuser}, dbpwd = {DaoBase::$dbpwd}, dbinst = {$dbinst}, ", LOG_LEVEL_VERBOSE);
			throw new DaoException($error, $errno);
		}

		// 璇诲??琛ㄥ??涔?
		$sql = "select COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_KEY from COLUMNS where TABLE_SCHEMA = ? and TABLE_NAME = ? order by ORDINAL_POSITION";
		$tabledef = new TableDefine($table_name);
		if ($stmt = mysqli_prepare($sysconn, $sql))
		{
			mysqli_stmt_bind_param($stmt, "ss", DaoBase::$dbinst, $table_name);

			mysqli_stmt_execute($stmt);
			if (mysqli_errno($sysconn))
			{
				$errno = mysqli_errno($sysconn);
				$error = "MYSQL ERROR #" . $errno . " : " . mysqli_error($sysconn);
				//Logger::trace($error, LOG_LEVEL_ERROR);
				throw new DaoException($error, $errno);
			}
			
			mysqli_stmt_bind_result($stmt, $column_name, $column_type, $column_length, $column_key);

			mysqli_stmt_store_result($stmt);

			while (mysqli_stmt_fetch($stmt))
			{
				$tabledef->addColumn($column_name, $column_type, $column_length, $column_key);
			}

			mysqli_stmt_close($stmt);
		}
		
		// 关闭系统数据库连接
		mysqli_close($sysconn);
		
		return $tabledef;
	}
   	  	  //查询数据库，并返回结果集的对象数组

   	
}

?>