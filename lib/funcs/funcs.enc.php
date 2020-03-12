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
function encrypt_md5_base64($plain_text, $password="password", $iv_len = 16)
{
	$enc_text=null;
	$plain_text .= "\x13";
	$n = strlen($plain_text);
	if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
	$i = 0;
	while ($iv_len-- >0)
	{
		$enc_text .= chr(mt_rand() & 0xff);
	}

	$iv = substr($password ^ $enc_text, 0, 512);
	while($i <$n)
	{
		$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
		$enc_text .= $block;
		$iv = substr($block . $iv, 0, 512) ^ $password;
		$i += 16;
	}

	return base64_encode($enc_text);
}

function decrypt_md5_base64($enc_text, $password="password", $iv_len = 16)
{
	$enc_text = base64_decode($enc_text);
	$n = strlen($enc_text);
	$i = $iv_len;
	$plain_text = '';
	$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
	while($i < $n)
	{
		$block = substr($enc_text, $i, 16);
		$plain_text .= $block ^ pack('H*', md5($iv));
		$iv = substr($block . $iv, 0, 512) ^ $password;
		$i += 16;
	}
	return preg_replace('/\x13\x00*$/', '', $plain_text);
}

function encrypt($name)
{
	$enc_name = encrypt_md5_base64($name,"ianfja)(#j_+(@kdo=+@0!()O");
	return $enc_name;
}

function decrypt($name)
{
	$enc_name = decrypt_md5_base64($name,"ianfja)(#j_+(@kdo=+@0!()O");
	return $enc_name;
}

?>