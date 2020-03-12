<? 
require_once("../include/inc_global.php");
require_once("../include/inc_func.php");

$startNo = $_GET["s"]; 
$page = $_GET["p"]; 
$group = $_GET["g"]; 
$business = $_GET["b"]; 

$srchQry = "";

if($group)
{
	$srchQry .= " AND gidx=$group";
}

if($business)
{
	$srchQry .= " AND bidx=$business";
}


// 페이징 시작 인덱스 설정
if($page == NULL || $page < 2)
{
	$page = 1; 
} 


if($startNo < 1)
{
	$limit = $page * 5; 
}  else {
	$limit = 5 ;
}

$tquery = "SELECT count(*) FROM portfolio WHERE active!='N' ". $srchQry ;
$tresult = mysql_query($tquery) or die (mysql_error());
$trow = mysql_fetch_row($tresult);
$total_no=$trow[0];

//$query = "SELECT * FROM s5_portfolio WHERE active!='N' ". $srchQry . " ORDER BY CASE no WHEN '0' THEN 0 END, no ASC, edate DESC LIMIT 12";
$query = "SELECT * FROM s5_portfolio WHERE active!='N' ". $srchQry . " ORDER BY CASE no WHEN '0' THEN 0 END, no ASC, edate";

$result = mysql_query($query) or die (mysql_error());
$count = mysql_num_rows($result);


if($count)
{
    while($row = mysql_fetch_array($result))
    {
        $idx = $row['idx'];
        $bidx = $row['bidx'];
        $gidx = $row['gidx'];
        $project_name = $row['name'];
        $writer = $row['writer'];

        $query2 = "SELECT * FROM s5_portfolio_upload WHERE pidx='$idx' AND type='thumbnail'";
        $result2 = mysql_query($query2) or die (mysql_error());
        $row2 = mysql_fetch_array($result2);
        $thumb = $row2['filename'];

        $regdate = date('Y.m.d', strtotime($row['regdate']));
?>

        <li>
            <div>
                <a href="../group/portfolio_detail.php?idx=<?=$idx?>&p=<?=$page?>&g=<?=$group?>&b=<?=$business?>">

                    <dl>
                        <dt><img src="/season5/upload/<?=$thumb?>" alt="<?=$project_name?>"></dt>
                        <dd><img  src="/season5/upload/sample_logo.jpg" alt="<?=$project_name?>"></dd>
                    </dl>

                    <h5>  <?=$project_name?></h5>
                    <h4><?echo $biz = portfolio('biz' , $gidx , $bidx ) ;?></h4>

                </a>
            </div>
        </li>





<?
									}
								}

if ($startNo+$limit > $total_no) {
?>
<script>$('.btn-moreportfolio').hide();</script>
<? } else {?>
<script>$('.btn-moreportfolio').show();</script>
<?}?>