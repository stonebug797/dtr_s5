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

    $tquery = "SELECT count(*) FROM s5_portfolio WHERE active!='N' ". $srchQry ;
    $tresult = mysql_query($tquery) or die (mysql_error());
    $trow = mysql_fetch_row($tresult);
    $total_no=$trow[0];

    $query = "SELECT * FROM s5_portfolio WHERE active!='N' ". $srchQry . " ORDER BY CASE no WHEN '0' THEN 0 END, no ASC, edate DESC LIMIT 12";

    $result = mysql_query($query) or die (mysql_error());
    $count = mysql_num_rows($result);






?>


<?


    $curcount = 1;
    if($count) {
        while ($row = mysql_fetch_array($result)) {


            $idx = $row['idx'];
            $bidx = $row['bidx'];
            $gidx = $row['gidx'];
            $regdate = date('Y.m.d', strtotime($row['regdate']));


            $writer = $row['writer'];

            $query2 = "SELECT * FROM s5_portfolio_upload WHERE pidx='$idx' AND type='thumbnail'";


            $result2 = mysql_query($query2) or die (mysql_error());
            $row2 = mysql_fetch_array($result2);

            if ($curcount % 2 == 1) {

                $classname = "pf_left";
                $thumb = $row2['filename'];
                $client = $row['client'];
                $project_name = $row['name'];
        ?>
        <div class="item">
        <div class="<?= $classname ?>">
            <a href="../group/portfolio_detail.php?idx=<?= $idx ?>&p=<?= $page ?>&g=<?= $group ?>&b=<?= $business ?>">
                <span class="client"><?= $client ?>  </span>
                <span class="p-name"><?= $project_name ?>  </span>
                <img src="/season5/upload/<?= $thumb ?>" alt="<?= $project_name ?>">
            </a>
            <div class="group"><p><?
                    echo $biz = portfolio('biz', $gidx, $bidx); ?></p></div>
        </div>
        <?
            } else {

                $classname = "pf_right";
                $thumb = $row2['filename'];
                $client = $row['client'];
                $project_name = $row['name'];
        ?>

        <div class="<?= $classname ?>">
            <a href="../group/portfolio_detail.php?idx=<?= $idx ?>&p=<?= $page ?>&g=<?= $group ?>&b=<?= $business ?>">
                <img src="/season5/upload/<?= $thumb ?>" alt="<?= $project_name ?>">
                <span class="client"><?= $client ?>  </span>
                <span class="p-name"><?= $project_name ?>  </span>
            </a>
            <div class="group"><p><?
                    echo $biz = portfolio('biz', $gidx, $bidx); ?></p></div>

        </div>
    </div>
<?
            }



            $curcount++;
?>


<?php
        }
    }
?>





<?
if ($startNo+$limit > $total_no) {

    ?>



<script>$('.btn-moreportfolio').hide();</script>
<? } else {?>
<script>$('.btn-moreportfolio').show();</script>
<?}?>