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
//디버깅 정보
function fnDebug($e, $format = 'html')
{
	global $DOCROOT;

	$error = array("Error" => $e);

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
	if($format == "html")
	{
		$css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
		$msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
		$msg .= "\n" . '<div class="db-error">' . "\n\t<h3>Runtime Error</h3>";
		foreach($error as $key => $val)
		{
			$msg .= "\n\t<label>" . $key . ":</label>" . $val;
		}
		$msg .= "\n\t</div>\n</div>";
	}
	elseif($format == "text")
	{
		$msg .= "Runtime Error\n" . str_repeat("-", 50);
		foreach($error as $key => $val)
		{
			$msg .= "\n\n$key:\n$val";
		}
	}

	print_r($msg);
}

?>