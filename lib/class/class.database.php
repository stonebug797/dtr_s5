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
class Database
{
	protected $user; 
    protected $pass; 
    protected $dbhost; 
    protected $dbname; 
    protected $conn;
	
	private $pre = "";
	private $error = "";
	private $errno = 0;
	private $affected_rows = 0;
	private $query_id = 0;

	public function __construct($server, $user, $pass, $database, $pre='')
	{
		$this->user = $user; 
        $this->pass = $pass; 
        $this->dbhost = $server; 
        $this->dbname = $database;
		$this->pre = $pre;
	}

	public function connect($new_link=false)
	{ 
        $this->conn = @mysql_connect($this->dbhost,$this->user,$this->pass, $new_link);
        if (!is_resource($this->conn))
		{ 
            $this->oops("Could not connect to server: <b>{$this->dbhost}</b>.");
        } 
        if (!mysql_select_db($this->dbname, $this->conn))
		{ 
            $this->oops("Could not open database: <b>{$this->dbname}</b>.");
        }
    }

	public function close() 
	{
		if (!$this->conn) return false;
		if ($this->conn)
		{
			if (!@mysql_close($this->conn))
			{
				$this->oops("Connection close failed.");
			}
		}
		$this->conn = false;
		return true;
	}

	public function escape($string)
	{
		if (get_magic_quotes_runtime()) $string = stripslashes($string);
		return @mysql_real_escape_string($string, $this->conn);
	}

	public function query($sql)
	{
		$this->query_id = @mysql_query($sql, $this->conn);

		if (!$this->query_id)
		{
			$this->oops("<b>MySQL Query fail:</b> $sql");
			return 0;
		}
		
		$this->affected_rows = @mysql_affected_rows($this->conn);

		return $this->query_id;
	}

	public function fetch_array($query_id = -1)
	{
		if ($query_id != -1)
		{
			$this->query_id = $query_id;
		}

		if (isset($this->query_id))
		{
			$record = @mysql_fetch_assoc($this->query_id);
		}
		else
		{
			$this->oops("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched.");
		}

		return $record;
	}

	public function fetch_all_array($sql)
	{
		$query_id = $this->query($sql);
		$out = array();

		while ($row = $this->fetch_array($query_id))
		{
			$out[] = $row;
		}

		$this->free_result($query_id);
		return $out;
	}

	public function free_result($query_id = -1)
	{
		if ($query_id != -1)
		{
			$this->query_id = $query_id;
		}
		if ($this->query_id != 0 && !@mysql_free_result($this->query_id))
		{
			$this->oops("Result ID: <b>$this->query_id</b> could not be freed.");
		}
	}

	public function query_first($query_string)
	{
		$query_id = $this->query($query_string);
		$out = $this->fetch_array($query_id);
		$this->free_result($query_id);
		return $out;
	}

	public function query_update($table, $data, $where='1')
	{
		$q="UPDATE `".$this->pre.$table."` SET ";
		foreach ($data as $key=>$val)
		{
			if (strtolower($val) == 'null') $q.= "`$key` = NULL, ";
			elseif (strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
			elseif (preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + $m[1], "; 
			else $q.= "`$key`='".$this->escape($val)."', ";
		}
		$q = rtrim($q, ', ') . ' WHERE '.$where.';';

		return $this->query($q);
	}

	public function query_insert($table, $data)
	{
		$q="INSERT INTO `".$this->pre.$table."` ";
		$v='';
		$n='';

		foreach ($data as $key=>$val)
		{
			$n.="`$key`, ";
			if (strtolower($val) == 'null') $v.="NULL, ";
			elseif (strtolower($val) == 'now()') $v.="NOW(), ";
			else $v.= "'".$this->escape($val)."', ";
		}

		$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

		if($this->query($q))
		{
			return mysql_insert_id($this->conn);
		}
		else return false;
	}

	public function oops($msg='')
	{
		if(is_resource($this->conn))
		{
			$this->error = mysql_error($this->conn);
			$this->errno = mysql_errno($this->conn);
		}
		else
		{
			$this->error = mysql_error();
			$this->errno = mysql_errno();
		}
?>
		<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
		<tr>
			<th colspan=2>Database Error</th>
		</tr>
		<tr>
			<td align="right" valign="top">Message:</td>
			<td><?php echo $msg; ?></td>
		</tr>
<?php
		if (!empty($this->error)) echo '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>'.$this->error.'</td></tr>'; 
?>
		<tr>
			<td align="right">Date:</td>
			<td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td>
		</tr>
<?php 
		if (!empty($_SERVER['REQUEST_URI']))
			echo '<tr><td align="right">Script:</td><td><a href="'.$_SERVER['REQUEST_URI'].'">'.$_SERVER['REQUEST_URI'].'</a></td></tr>'; 
?>
<?php
		if (!empty($_SERVER['HTTP_REFERER'])) 
			echo '<tr><td align="right">Referer:</td><td><a href="'.$_SERVER['HTTP_REFERER'].'">'.$_SERVER['HTTP_REFERER'].'</a></td></tr>';
?>
		</table>
<?php
	}
}
?>