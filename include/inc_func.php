<? 
function trandData(){
$returnArr = array();

$query = "SELECT * FROM keyword ORDER BY regdate DESC LIMIT 1";
$result = mysql_query($query) or die (mysql_error());
$count = mysql_num_rows($result);

$data = mysql_fetch_array($result);
$regdate = date('Y-m-d' , strtotime($data['regdate']));
 array_push($returnArr ,$regdate ) ;

	if($count)
	{ 
		$result = mysql_query($query) or die (mysql_error());
		while($row = mysql_fetch_array($result))
		{ 
			for ($t=1 ; $t<16; $t++) {
			 array_push($returnArr , $row['keyword'.$t]) ;
			}
		}
	}
	return $returnArr ;

} // function trandTag()
 
function portfolio($cate , $no , $bno=0 ){
	
	if ($cate == 'group') {
		$gquery = "SELECT * FROM group_category WHERE active='Y' and gidx=$no";
		$gresult = mysql_query($gquery) or die (mysql_error());
		
		$re = mysql_fetch_array($gresult);
		return $re['text'] ;
		exit ;
	} else if ($cate == 'biz') {
		$bquery = "SELECT * FROM business_category WHERE active='Y' AND gidx=$no AND bidx=$bno";
		$bresult = mysql_query($bquery) or die (mysql_error());

		$re = mysql_fetch_array($bresult);
		return $re['text'] ;
		exit ;
	} else if ($cate == 'ptype') {
		$pquery = "SELECT * FROM project_category WHERE active='Y' AND gidx=$no AND bidx=$bno ORDER BY pidx ASC";
		$presult = mysql_query($pquery) or die (mysql_error());
		$re = array();
			while($prow = mysql_fetch_array($presult))
			{
				array_push($re , $prow['text']) ;
			}
		return $re  ;
		exit ;
	} else if ($cate == 'thumb'){		
		$fquery = "SELECT * FROM portfolio_upload WHERE pidx=$no and type='thumbnail' ORDER BY idx ASC";
		$fresult = mysql_query($fquery) or die (mysql_error()); 
		$re = mysql_fetch_array($fresult);
		
		return $re['filename'] ;
		exit ; 
	}
}
 
function yMovie(){
	$query = "SELECT * FROM movie ORDER BY regdate DESC LIMIT 1";
	$result = mysql_query($query) or die (mysql_error());
	$count = mysql_num_rows($result);

	$row = ($count) ? mysql_fetch_array($result) : null;

	$youtube_id = (isset($row['youtube_id'])) ? $row['youtube_id'] : null;
	$youtube = "https://www.youtube.com/embed/".$youtube_id."?rel=0" ;
	return $youtube  ;
}

?>