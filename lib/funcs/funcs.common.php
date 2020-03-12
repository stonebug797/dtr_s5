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
//아이피 주소 정보
function fnGetIPAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function fnGetShortURL($BITLYID, $BITLYKEY, $url)
{
	$request = "http://api.bitly.com/v3/shorten?login=".$BITLYID."&apiKey=".$BITLYKEY."&longUrl=".urlencode($url)."&format=json";
	$response = file_get_contents($request);

	if(isset($response))
	{
		$jsondata = json_decode($response,true);
		$shorturl = $jsondata['data']['url'];
	}
	return stripslashes($shorturl);
}

function fnPostPhoto($touid, $args)
{
	$url = 'https://graph.facebook.com/'.$touid.'/photos';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close ($ch);

	return $result;
}

function fnPostFeed($touid, $args)
{
	$url = 'https://graph.facebook.com/'.$touid.'/feed';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close ($ch);

	return $result;
}

function fnPostGavia($args)
{
	$url = 'http://www.npaint.com/cydeo/server/reqRender.php';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close ($ch);

	return $result;
}

function fnPostM2Day($toid, $args)
{
	$url = "http://me2day.net/api/create_post/{$toid}.json";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close ($ch);

	return $result;
}

function fnSendAdBack($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return json_decode($result)->resultCode;
}

function fnUTF8Wordwrap($str, $width, $break, $cut = true)
{
	if ($cut)
	{
		$regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.'}#';
	}
	else
	{
		$regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.',}\b#U';
	}

	if (function_exists('mb_strlen'))
	{
		$str_len = mb_strlen($str,'UTF-8');
	}
	else
	{
		$str_len = preg_match_all('/[\x00-\x7F\xC0-\xFD]/', $str, $var_empty);
	}

	$while_what = ceil($str_len / $width);
	$i = 1;
	$return = '';
	while ($i < $while_what)
	{
		preg_match($regexp, $str, $matches);
		$string = $matches[0];
        $return .= $string . $break;
        $str = substr($str, strlen($string));
        $i++;
	}
	return $return . $str;
}

function fnUTF8Length($str)
{
	$len = strlen($str);
	for ($i = $length = 0; $i < $len; $length++)
	{
		$_char = ord($str[$i]);
		if ($_char < 0x80) // 0 <= _char <128 범위의 문자 (ASCII 문자)
		{
			$i += 1;
		}
		elseif ($_char < 0xE0) // 128 <= _char < 224 범위의 문자 (확장 ASCII 문자)
		{
			$i += 2;
		}
		elseif ($_char < 0xF0) // 224 <= _char <240 범위의 문자 (유니코드 확장문자)
		{
			$i += 3;
		}
		else
		{
			$i += 4;
		}
	}
	return $length;
}

function fnUTF8CutString($str, $len, $tail = '...')
{
	if ($len >= fnUTF8Length($str))
	{
		return $str;
	}
	else
	{
		//$len -= fnUTF8Length($tail);
	}

	$strlength = strlen($str);
	for ($i = $pos = 0; $i < $strlength; $pos = $i)
	{
		$_char = ord($str[$i]);

		if ($_char < 0x80) // 0 <= _char <128 범위의 문자 (ASCII 문자)
		{
			$i += 1;
		}
		elseif ($_char < 0xE0) // 128 <= _char < 224 범위의 문자 (확장 ASCII 문자)
		{
			$i += 2;
		}
		elseif ($_char < 0xF0) // 224 <= _char <240 범위의 문자 (유니코드 확장문자)
		{
			$i += 3;
		}
		else
		{
			$i += 4;
		}
		if (--$len < 0)
		{
			break;
		}
	}
	return substr($str, 0, $pos) . $tail;
}

function fnAlert($msg)
{
	if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";
	echo "<script type='text/javascript'>";
	echo "alert('{$msg}');window.location.reload(true);";
	echo "</script>";
	exit;
}

function fnChkMobile()
{
	$isMobile = false;

	$_mAgent = '/(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/';
	if (preg_match($_mAgent, $_SERVER['HTTP_USER_AGENT']))
	{
		$isMobile = true;
	}
	else
	{
		$isMobile = false;
	}
	return $isMobile;
}

function fnChkIOS()
{
	$isIOS = false;

	$_mAgent = '/(iPad|iPod|iPhone)/';
	if (preg_match($_mAgent, $_SERVER['HTTP_USER_AGENT']))
	{
		$isIOS = true;
	}
	else
	{
		$isIOS = false;
	}
	return $isIOS;
}

function popMove($msg, $url, $is_end = true)
{
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"\n";
	echo "  \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><script type=\"text/javascript\">\n";
	if ($msg != NULL && strlen($msg) > 0)
		echo "alert(\"$msg\");\n";
	if ($url != NULL && strlen($url) > 0)
		echo "location.href = \"$url\";\n";
	echo "</script></head><body></body></html>";

	if (!$is_end)	exit();
}

function popBack($msg, $step = -1, $is_end = true)
{
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"\n";
	echo "  \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><script type=\"text/javascript\">\n";
	if ($msg != NULL && strlen($msg) > 0)
		echo "alert(\"$msg\");\n";
	echo "history.go($step);\n";

	echo "</script></head><body></body></html>";

	if (!$is_end)	exit();
}

function popClose($msg)
{
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"\n";
	echo "  \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><script type=\"text/javascript\">\n";
	if ($msg != NULL && strlen($msg) > 0)
		echo "alert(\"$msg\");\n";
	echo "window.close();\n";

	echo "</script></head><body></body></html>";
}

function fnGetConsultString($value)
{
	$consult;

	switch ($value)
	{
		case 1 :
			$consult = '상담예정';
			break;

		case 2 :
			$consult = '<span class="red">상담완료</span>';
			break;
	}

	return $consult;
}

function userpaging($page,$pagesize,$pageblock,$totalcount,$addparam,$pagename=null)
{
	$prevBlockPage = "";
	$nextBlockPage = "";

	if(!$pagename) $pagename = $_SERVER['PHP_SELF'];

	$countTotalPage			= ceil($totalcount / $pagesize);

	if($page == NULL || $page < 2) {
		$page  = 1;
		$startNo    = 0;
	} else {
		$startNo = $pagesize * ($page - 1);
	}

	if($countTotalPage > $pageblock) {
		$startBlockPage = floor(($page - 1) / $pageblock) * $pageblock + 1;

		$prevBlockPage = $startBlockPage - 1;
		$nextBlockPage = $startBlockPage + $pageblock;
	} else {
		$startBlockPage = 1;
	}

	$PageLinks = null;
	//$PageLinks .= "<strong class=\"curPage\">$page <img src=\"/resource/images/common/txt_page.gif\" alt=\"page\" /></strong>";
	//$PageLinks .= "<span class=\"page\">";
	if($countTotalPage  > $pageblock)
		$PageLinks .= "<a href=\"$pagename?page=1$addparam\" class=\"page has_bg first\">처음으로</a>\n ";
	else
		$PageLinks .= "<a href=\"#\" class=\"page has_bg first\">처음으로</a>\n";

	if($prevBlockPage > 0)
	{
		$PageLinks .= "<a href=\"$pagename?page=$prevBlockPage$addparam\" class=\"page has_bg prev\">이전</a>\n";
	}
	else
	{
		$PageLinks .= "<a href=\"#\" class=\"page has_bg prev\">이전</a>\n";
	}


	for($i = 0, $j = 0; $j < $countTotalPage && $i < $pageblock; $i ++) {
		$j = $startBlockPage + $i;

		if($page == $j) {
			$PageLinks .= "<a class=\"page active\">$j</a>\n";
		} else {
			$PageLinks .= "<a href=\"$pagename?page=$j$addparam\" class=\"page\">$j</a>\n";
		}
	}

	if($nextBlockPage > $pageblock && $nextBlockPage < $countTotalPage) {
		$PageLinks .= "<a href=\"$pagename?page=$nextBlockPage$addparam\" class=\"page has_bg next\">$nextpageico</a>\n";
	}
	else
	{
		$PageLinks .= "<a href=\"#\" class=\"page has_bg next\">$nextpageico</a>\n";
	}

	if($countTotalPage  > $pageblock)
		$PageLinks .= " <a href=\"$pagename?page=$countTotalPage$addparam\" class=\"page has_bg last\">$endpageico</a>\n";
	else
		$PageLinks .= " <a href=\"#\" class=\"page has_bg last\">$endpageico</a>";

	//$PageLinks .= "</span>";

	return $PageLinks;
}

function adminuserpaging($page, $pagesize, $pageblock, $totalcount, $addparam, $pagename=null)
{
	$prepageico = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
	$nextpageico = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
	$startpageico = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
	$endpageico = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
	$prevBlockPage = "";
	$nextBlockPage = "";

	if(!$pagename) $pagename = $_SERVER['PHP_SELF'];

	$countTotalPage = ceil($totalcount / $pagesize);

	if($page == NULL || $page < 2)
	{
		$page = 1;
		$startNo = 0;
	}
	else
	{
		$startNo = $pagesize * ($page - 1);
	}

	if($countTotalPage > $pageblock)
	{
		$startBlockPage = floor(($page - 1) / $pageblock) * $pageblock + 1;

		$prevBlockPage = $startBlockPage - 1;
		$nextBlockPage = $startBlockPage + $pageblock;
	}
	else
	{
		$startBlockPage = 1;
	}


	$PageLinks = null;
	if($countTotalPage  > $pageblock)
		$PageLinks .= "<a href=\"$pagename?page=1$addparam\" class=\"first\">$startpageico</a>\n ";
	else
		$PageLinks .= "<a class=\"first\">$startpageico</a>\n ";

	if($prevBlockPage > 0) {
		$PageLinks .= "<a href=\"$pagename?page=$prevBlockPage$addparam\" class=\"prev\">$prepageico</a>\n";
	}
	else
	{
		$PageLinks .= "<a class=\"prev\">$prepageico</a>\n";
	}


	for($i = 0, $j = 0; $j < $countTotalPage && $i < $pageblock; $i ++) {
		$j = $startBlockPage + $i;

		if($page == $j) {
			$PageLinks .= "<a href=\"#\" class=\"active\">$j</a>\n";
		} else {
			$PageLinks .= "<a href=\"$pagename?page=$j$addparam\">$j</a>\n";
		}
	}

	if($nextBlockPage > $pageblock && $nextBlockPage < $countTotalPage) {
		$PageLinks .= "<a href=\"$pagename?page=$nextBlockPage$addparam\" class=\"next\">$nextpageico</a>\n";
	}
	else
	{
		$PageLinks .= "<a class=\"next\">$nextpageico</a>\n";
	}

	if($countTotalPage  > $pageblock)
		$PageLinks .= " <a href=\"$pagename?page=$countTotalPage$addparam\" class=\"last\">$endpageico</a>\n";
	else
		$PageLinks .= " <a class=\"last\">$endpageico</a>\n";

	return $PageLinks;
}

function searchpaging($paramname, $page, $pagesize, $pageblock, $totalcount, $addparam, $pagename=null)
{
	$prepageico = '<img src="/admin/resource/img/btn_p_prev.gif" alt="전 페이지" />';
	$nextpageico = '<img src="/admin/resource/img/btn_p_next.gif" alt="다음 페이지" />';
	$startpageico = '<img src="/admin/resource/img/btn_p_first.gif" alt="첫 페이지" />';
	$endpageico = '<img src="/admin/resource/img/btn_p_last.gif" alt="마지막 페이지" />';
	$pagetmp = "{페이지}";
	$apagetmp = "<a class=\"select\">{페이지}</a>";
	$prevBlockPage = "";
	$nextBlockPage = "";

	if(!$pagename) $pagename = $_SERVER['PHP_SELF'];

	$countTotalPage = ceil($totalcount / $pagesize);

	if($page == NULL || $page < 2)
	{
		$page = 1;
		$startNo = 0;
	}
	else
	{
		$startNo = $pagesize * ($page - 1);
	}

	if($countTotalPage > $pageblock)
	{
		$startBlockPage = floor(($page - 1) / $pageblock) * $pageblock + 1;

		$prevBlockPage = $startBlockPage - 1;
		$nextBlockPage = $startBlockPage + $pageblock;
	}
	else
	{
		$startBlockPage = 1;
	}


	$PageLinks = null;
	//$PageLinks .= "<strong class=\"curPage\">$page <img src=\"/resource/images/common/txt_page.gif\" alt=\"page\" /></strong>";
	//$PageLinks .= "<span class=\"page\">";
	if($countTotalPage  > $pageblock)
		$PageLinks .= "<a href=\"$pagename?$paramname=1$addparam\" class=\"first\">$startpageico</a>\n ";
	else
		$PageLinks .= "<a class=\"first\">$startpageico</a>\n ";

	if($prevBlockPage > 0) {
		$PageLinks .= "<a href=\"$pagename?$paramname=$prevBlockPage$addparam\" class=\"prev\">$prepageico</a>\n";
	}
	else
	{
		$PageLinks .= "<a class=\"prev\">$prepageico</a>\n";
	}


	for($i = 0, $j = 0; $j < $countTotalPage && $i < $pageblock; $i ++) {
		$j = $startBlockPage + $i;

		if($page == $j) {
			$PageLinks .= "<a href=\"#\" class=\"select\">$j</a>\n";
		} else {
			$PageLinks .= "<a href=\"$pagename?$paramname=$j$addparam\">$j</a>\n";
		}
	}

	if($nextBlockPage > $pageblock && $nextBlockPage < $countTotalPage) {
		$PageLinks .= "<a href=\"$pagename?$paramname=$nextBlockPage$addparam\" class=\"next\">$nextpageico</a>\n";
	}
	else
	{
		$PageLinks .= "<a class=\"next\">$nextpageico</a>\n";
	}

	if($countTotalPage  > $pageblock)
		$PageLinks .= " <a href=\"$pagename?$paramname=$countTotalPage$addparam\" class=\"last\">$endpageico</a>\n";
	else
		$PageLinks .= " <a class=\"last\">$endpageico</a>\n";

	$PageLinks .= "</span>";

	return $PageLinks;
}

/*
 client paging 
*/
function fnClientPaging($page, $pagesize, $pageblock, $totalcount, $addparam, $pagename=null)
{
	$prepageico = '<i class="btn-pagenavi btn-pnprev">&lt;</i>';
	$nextpageico = '<i class="btn-pagenavi btn-pnnext">&gt;</i>';
	$prevPage = "";
	$nextPage = "";

	if (!$pagename) $pagename = $_SERVER['PHP_SELF'];

	$countTotalPage = ceil($totalcount / $pagesize);

	if ($page == NULL || $page < 2)
	{
		$page = 1;
	}

	if($countTotalPage > $pageblock)
	{
		$startBlockPage = floor(($page - 1) / $pageblock) * $pageblock + 1;
	}
	else
	{
		$startBlockPage = 1;
	}

	if($page > 1)
	{
		$prevPage = $page - 1;
	}
	else
	{
		$prevPage = 0;
	}

	if ($page < $countTotalPage)
	{
		$nextPage = $page + 1;
	}
	else
	{
		$nextPage = $countTotalPage + 1;
	}

	$PageLinks = null;

	if($prevPage > 0)
	{
		$PageLinks .= "<a href=\"$pagename?page=$prevPage$addparam\" class=\"prev\">$prepageico</a>\n";
	}
	else
	{
		$PageLinks .= "<a class=\"prev\">$prepageico</a>\n";
	}


	for($i = 0, $j = 0; $j < $countTotalPage && $i < $pageblock; $i ++)
	{
		$j = $startBlockPage + $i;

		if($page == $j)
		{
			$PageLinks .= "<a href=\"#\" class=\"on\">$j</a>\n";
		}
		else
		{
			$PageLinks .= "<a href=\"$pagename?page=$j$addparam\">$j</a>\n";
		}
	}

	if($nextPage <= $countTotalPage)
	{
		$PageLinks .= "<a href=\"$pagename?page=$nextPage$addparam\" class=\"next\">$nextpageico</a>\n";
	}
	else
	{
		$PageLinks .= "<a class=\"next\">$nextpageico</a>\n";
	}

	$PageLinks .= "</span>";

	return $PageLinks;
}


function getData($id){

	$arrRss = array();
	$arrValue = array();

	$db = new pdoDatabase(DB_DSN2, DB_USER, DB_PASS, DB_ERR_FUNC);
	$bind = array();
	$strTable = TBL_BOARD." A  ";
	$columns = " A.idx,A.community,A.content,A.url,A.operator" ;
	$where = " A.type = :type AND operator = :operator" ;
	$orderby = "  ";
	$bind[':type'] = 1;
	$bind[':operator'] = $id;
	

	$rows = $db->select($strTable, $where.$orderby , $bind, $columns);
	$len = count($rows);

	foreach ($rows as $data){
		$community = $data["content"];
	
		$arrValue["title"] =$community ;
		$arrValue["link"] = $data["url"];
		$arrRss[0] = $arrValue ;
	}

	$strRtn = "";
	$strRtn = json_encode($arrRss);
	return $strRtn;
}

function getRss($u){
	$url = $u;
	$source = file_get_contents($url);
	$xmlDoc = simplexml_load_string($source);
	$xmlNode = $xmlDoc->channel;
	$arrRss = array();
	$arrValue = array();
	$i = 0;
	foreach ($xmlNode->item as $key => $value) {
		$node = (string)$value->title;
		//$arrRss.
		foreach ($value->children() as $child)
		{
		    $n = (string)$child->getName() ;
		    $v = (string)$value->$n;
		    $arrValue[$n] = $v;
		    //print_r($v);
		    //echo "<br>";
		    
		}
		$arrRss[$i] = $arrValue ;
		//print_r($value);
		$i++;

		if( $i > 4) break;
	}

	$strRtn = json_encode($arrRss);

	return $strRtn;
}

/**
 * html tag 제거 함수
 *
 * Sample text:
 * $text = '<b>sample</b> text with <div>tags</div>';
 *
 * Result for strip_tags($text):
 * sample text with tags
 *
 * Result for strip_tags_content($text):
 * text with
 *
 * Result for strip_tags_content($text, '<b>'):
 * <b>sample</b> text with
 *
 * Result for strip_tags_content($text, '<b>', TRUE);
 * text with <div>tags</div>
 *
 */
function strip_tags_content($text, $tags = '', $invert = FALSE)
{
	preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
	$tags = array_unique($tags[1]);

	if(is_array($tags) AND count($tags) > 0)
	{
		if($invert == FALSE)
		{
			return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		else
		{
			return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
		}
	}
	else if($invert == FALSE)
	{
		return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
	}

	return $text;
}

function strip_all_tags_content($text)
{
	$style = preg_replace('~\<style(.*)\>(.*)\<\/style\>~', '', $text);
	$tag_str = strip_tags($style);

	return $tag_str;
}

function format_his($_tm)
{
	$durt = new DateInterval($_tm);
	//return $durt->format('%H:%I:%S');
	$sec = $durt->h * 3600 + $durt->i * 60 + $durt->s;
	return gmdate('H:i:s',$sec-1);
}

function format_s($_tm)
{
	$durt = new DateInterval($_tm);
	//return $durt->format('%H:%I:%S');
	$sec = $durt->h * 3600 + $durt->i * 60 + $durt->s;
	return $sec-1;
}
?>