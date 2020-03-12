<?php
/**
 * Created by IntelliJ IDEA.
 * User: hanbv
 * Date: 2020-02-18
 * Time: 오후 3:30
 */
$pd0 = "pd0";

require_once("../include/inc_global.php");


$l = $_GET['l'];
$idx = $_GET['idx'];
$page = $_GET["p"];
$group = $_GET["g"];
$g = $_GET["g"];
$b = $_GET["b"];

include ("../admin/portfolio_view_func.php");

if($project_active == "N") {
    popMove("잘못된 접근", "portfolio.php");
}

require_once("../include/inc_header.php");

?>
    <div class="portfolio introduce--portfolio-detail">
        <!--top-->
        <div class="portfolio_detail_top" >

            <div class="portfolio_detail_top_box" >
                <style>.pf_top_header {background: url(<?= SITE_DIR . $pc_image ?>) no-repeat center center; background-size:auto 100%;}
                    @media (max-width: 640px){
                        .pf_top_header {background: url(<?= SITE_DIR . $mo_image ?>) no-repeat center center; background-size:auto 100%; height: 1000px;}
                    }
                </style>
                <div class="pf_top_header" >

                    <div class="pf_top_content">
                        <h3 class="portfolio_introduce__top-group-name <?=$textcolor?>"><? echo $biz = portfolio('biz' , $group , $business); ?></h3>
                        <h4 class="portfolio_introduce__top-client-name <?=$textcolor?>"><?= $client ?></h4>
                        <h5 class="portfolio_introduce__top-project-name <?=$textcolor?>"><?= $project_name ?></h5>
                        <p class="portfolio_introduce__top-explain <?=$textcolor?>"><?= $summary ?></p>
                    </div>
                </div>



            </div>
        </div>
        <!--//top-->

        <!-- 내용 켄텐츠 -->

            <div class="portfolio_detail_contents">

                <div class="pd-top">
                    <a href="portfolio.php?p=<?=$page?>&g=<?=$g?>&l=<?=$l?>&b=<?=$b ?>">

                        <i class="sp sp--back"></i>
                        BACK TO LIST
                    </a>
                </div>

                <div class="pd_title_logo">
                    <img  src="<?= SITE_DIR . $logoimage ?>" alt="로고 이미지">
                    <p><?=$tag?></p>
                </div>

                <div class="pd_img_content">
                    <ul>
                        <?
                        if($mlength > 0)
                        {
                            for($i = 0 ; $i < $mlength ; $i++)
                            {
                                $midx = (isset($movies[$i]['idx'])) ? $movies[$i]['idx'] : "";
                                $youtube_id = (isset($movies[$i]['youtube_id'])) ? $movies[$i]['youtube_id'] : "";
                                $youtube = "https://www.youtube.com/embed/".$youtube_id."?rel=0&enablejsapi=1&version=3&playerapiid=ytplayer" ;
                                ?>
                                <li class="pf_movie">
                                    <iframe src="<?=$youtube?>" frameborder="0"
                                            class="ymovie"
                                            allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                </li>
                                <?
                            }
                        }
                        ?>



                        <?
                        $plength = count($pimages);

                        if($plength > 0)
                        {
                            for($i = 0 ; $i < $plength ; $i++)
                            {
                                $fidx = (isset($pimages[$i]['idx'])) ? $pimages[$i]['idx'] : "";
                                $fname = (isset($pimages[$i]['filename'])) ? $pimages[$i]['filename'] : "";
                                ?>
                                <li class="pf_img'"> <img src="<?=SITE_DIR . $fname?>" class="upload_thumb"> </li>
                                <?
                            }
                        }
                        ?>



                    </ul>
                </div>

                <ul class="pd-metalist" >
                    <li><strong>PROJECT TYPE.</strong>
                        <? $ptype = portfolio('ptype' , $group , $business); echo $ptype[$project-1] ; ?>
                    </li>
                    <li><strong>CLENT.</strong><?= $client ?></li>
                    <li><strong>DATE.</strong><?=date('F. Y', strtotime($edate)) ; ?></li>
                    <li><strong>CREATOR.</strong><?= $tft ?></li>
                </ul>

                <ul class="pd-list">
                    <? if($dlength){
                    for($i=0;$i<$dlength;$i++){ ?>
                    <li>
                        <strong><?= $descriptions[$i]['subtitle'] ?></strong>
                        <?= nl2br($descriptions[$i]['content']) ?>
                    <li>
                        <?	}
                        }?>
                </ul>

            </div>

            <!-- 내용 켄텐츠 -->

    </div>

<? require_once("../include/inc_footer.php") ?>
