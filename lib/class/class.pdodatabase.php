<?php
/**
 * The contents of this source file is the sole property of Cream Union Ltd.
 * Unauthorized duplication or access is prohibited.
 *
 *
 * @package		Cream
 * @author		Cream Dev Team
 * @copyright	Copyright (C) 2004-2012 Cream Union Ltd.
 * @license		http://www.crea-m.com/user_guide/license.html
 * @link		http://www.crea-m.com
 * @since		Version 1.0
 */
class pdoDatabase
{
	private $dsn;
	private $username;
	private $password;
	private $error;
	private $sql;
	private $bind;
	private $errorCallbackFunction;
	private $errorMsgFormat;
	private $dbconn = null;

	public function __construct($dsn, $username, $password, $errFunc = "")
	{
		$this->dsn = $dsn;
		$this->username = $username;
		$this->password = $password;

		if (!empty($errFunc))
		{
			$this->setErrorCallbackFunction($errFunc);
		}

		try
		{
			$this->dbconn = new PDO($this->dsn, $this->username, $this->password);
			$this->dbconn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND ,"SET NAMES 'UTF8'");
			$this->dbconn->setAttribute(PDO::ATTR_PERSISTENT, true);
			$this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $est)
		{
			die("pdo connection error! ". $est->getMessage() ."<br/>");
		}
	}

	public function __destruct()
	{
		$this->dbconn = null;
	}

	public function close() 
	{
		if (!$this->dbconn) return false;
		if ($this->dbconn)
		{
			$this->dbconn = null;
		}
		return true;
	}

	private function debug()
	{
		global $DOCROOT;
		if(!empty($this->errorCallbackFunction))
		{
			$error = array("Error" => $this->error);
			if(!empty($this->sql))
			{
				$error["SQL Statement"] = $this->sql;
			}
			if(!empty($this->bind))
			{
				$error["Bind Parameters"] = trim(print_r($this->bind, true));
			}

			$backtrace = debug_backtrace();
			if(!empty($backtrace))
			{
				foreach($backtrace as $info)
				{
					if($info["file"] != __FILE__)
					{
						$error["Backtrace"] = str_replace($DOCROOT, '', $info["file"]) . " at line " . $info["line"];
					}
				}
			}

			$msg = "";
			if($this->errorMsgFormat == "html")
			{
				if(!empty($error["Bind Parameters"]))
				{
					$error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
				}
				$css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
				$msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
				$msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
				foreach($error as $key => $val)
				{
					$msg .= "\n\t<label>" . $key . ":</label>" . $val;
				}
				$msg .= "\n\t</div>\n</div>";
			}
			elseif($this->errorMsgFormat == "text")
			{
				$msg .= "SQL Error\n" . str_repeat("-", 50);
				foreach($error as $key => $val)
				{
					$msg .= "\n\n$key:\n$val";
				}
			}

			$func = $this->errorCallbackFunction;
			$func($msg);
		}
	}

	public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat="html")
	{
		if(in_array(strtolower($errorCallbackFunction), array("echo", "print")))
		{
			$errorCallbackFunction = "print_r";
		}

		if(function_exists($errorCallbackFunction))
		{
			$this->errorCallbackFunction = $errorCallbackFunction;
			if(!in_array(strtolower($errorMsgFormat), array("html", "text")))
			{
				$errorMsgFormat = "html";
			}
			$this->errorMsgFormat = $errorMsgFormat;
		}
	}

	private function filter($table, $info)
	{
		$driver = $this->dbconn->getAttribute(PDO::ATTR_DRIVER_NAME);
		if($driver == 'sqlite')
		{
			$sql = "PRAGMA table_info('" . $table . "');";
			$key = "name";
		}
		elseif($driver == 'mysql')
		{
			$sql = "DESCRIBE " . $table . ";";
			$key = "Field";
		}
		else
		{
			$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
			$key = "column_name";
		}

		if(false !== ($list = $this->run($sql)))
		{
			$fields = array();
			foreach($list as $record)
			{
				$fields[] = $record[$key];
			}
			return array_values(array_intersect($fields, array_keys($info)));
		}
		return array();
	}

	private function cleanup($bind)
	{
		if(!is_array($bind))
		{
			if(!empty($bind))
			{
				$bind = array($bind);
			}
			else
			{
				$bind = array();
			}
		}
		return $bind;
	}

	public function select($table, $where="", $bind="", $fields="*")
	{
		$sql = "SELECT " . $fields . " FROM " . $table;
		if(!empty($where))
		{
			$sql .= " WHERE " . $where;
		}
		$sql .= ";";
		return $this->run($sql, $bind);
	}

	public function insert($table, $info)
	{
		$fields = $this->filter($table, $info);
		$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
		$bind = array();
		foreach($fields as $field)
		{
			$bind[":$field"] = $info[$field];
		}
		return $this->run($sql, $bind);
	}

	public function update($table, $info, $where, $bind="")
	{
		$fields = $this->filter($table, $info);
		$fieldSize = sizeof($fields);

		$sql = "UPDATE " . $table . " SET ";
		for($f = 0; $f < $fieldSize; ++$f)
		{
			if($f > 0)
			{
				$sql .= ", ";
			}
			$sql .= $fields[$f] . " = :update_" . $fields[$f];
		}
		$sql .= " WHERE " . $where . ";";


		$bind = $this->cleanup($bind);
		foreach($fields as $field)
		{
			$bind[":update_$field"] = $info[$field];
		}

		return $this->run($sql, $bind);
	}

	public function delete($table, $where, $bind="")
	{
		$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
		$this->run($sql, $bind);
	}

	public function run($sql, $bind="")
	{
		$this->sql = trim($sql);
		$this->bind = $this->cleanup($bind);
		$this->error = "";

		try
		{
			$pdostmt = $this->dbconn->prepare($this->sql);
			if($pdostmt->execute($this->bind) !== false)
			{
				if (preg_match("/^insert /i", $this->sql))
				{
					return $this->dbconn->lastInsertId();
				}
				elseif(preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql))
				{
					return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
				}
				elseif(preg_match("/^(" . implode("|", array("delete", "update")) . ") /i", $this->sql))
				{
					return $pdostmt->rowCount();
				}
			}
		}
		catch (PDOException $e)
		{
			$this->error = $e->getMessage();
			$this->debug();
			return false;
		}
	}
}
?>
