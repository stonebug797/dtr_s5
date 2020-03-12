<?php
/**
 * Created by IntelliJ IDEA.
 * User: hjk
 * Date: 2020-02-18
 * Time: 오후 3:30
 */
require_once("../include/inc_global.php");
include_once("../include/inc_header.php");

    $list=( $_GET['l'] ) ? $_GET['l'] : 0;
    $page=( $_GET['p'] ) ? $_GET['p'] : 1;
    $group=( $_GET['g'] ) ? $_GET['g'] : 0;
    $business=( $_GET['b'] ) ? $_GET['b'] : 0;
?>

<?

    if($group) {
        switch ($group) {
            case 1 :
                $groupname = 'creative';
                $grouptitle1 = 'NEW EXPERIENCE TRIAL' ;
                $grouptitle2 = '<strong>DIGITAL EXPERIENCE</strong> GROUP' ;
                $groupurl = 'group/creative.php' ;
                $list_type = 'type_1';
                break;

            case 2 :
                $groupname = 'marketing';
                $grouptitle1 = 'IMC / Digital & Social / BTL / Media  ' ;
                $grouptitle2 = '<strong> MARKETING </strong> GROUP' ;
                $groupurl = 'group/marketing.php';
                $list_type = 'type_2';
                break;

            case 3 :
                $groupname = 'enc';
                $grouptitle1 = ' Branded Content / Video Commerce / Content Marketing ' ;
                $grouptitle2 = '<strong>DIGITAL E&amp;C </strong>GROUP' ;
                $groupurl = 'group/enc.php' ;
                $list_type = 'type_2';
                break;

            case 4 :
                $groupname = 'seollam';
                $grouptitle1 = 'DOVE TO RABBIT' ;
                $grouptitle2 = '<strong>LABORATORY</strong> ' ;
                $groupurl = 'group/rnd1.php' ;
                $list_type = 'type_2';
                break;
            default :
                break;

        }
    }
?>

    <div id="portfolio introduce--<?=$groupname?>">
        <div id="header_menu_container">
            <!-- header_menu -->
            <div class="row">
                <section class="header_menu--<?=$list_type?> ">
                    <h2 class="blind">헤더 메뉴</h2>
                    <div class="bm_left">
                        <ul>
                            <?
                            $gquery = "SELECT * FROM group_category WHERE active='Y' ORDER BY gidx ASC";
                            $gresult = mysql_query($gquery) or die (mysql_error());

                            ?>
                            <?if($group == 1){ ?>


                                <li <? if($business == 1){?> class="active"<?}?>><a href="#" onclick="goLink(1, 1)">ALL</a></li>
                                <li <? if($business == 2){?> class="active"<?}?>><a href="#" onclick="goLink(1, 2)">SPACE EXPERIENCE</a></li>
                                <li <? if($business == 3){?> class="active"<?}?>><a href="#" onclick="goLink(1, 3)">TECHNOLOGY EXPERIENCE</a></li>
                                <li <? if($business == 4){?> class="active"<?}?>><a href="#" onclick="goLink(1, 4)">MEDIA EXPERIENCE</a></li>
                                <li <? if($business == 5){?> class="active"<?}?>><a href="#" onclick="goLink(1, 5)">UI/UX,CX</a></li>

                            <? } else if($group == 2) { ?>


                                <li <? if($business == 1){?> class="active"<?}?>><a href="#" onclick="goLink(2, 1)">ALL</a></li>
                                <li <? if($business == 2){?> class="active"<?}?>><a href="#" onclick="goLink(2, 2)">CAMPAION SOLUTION</a></li>
                                <li <? if($business == 3){?> class="active"<?}?>><a href="#" onclick="goLink(2, 3)">DIGTAL SOLUTION</a></li>
                                <li <? if($business == 4){?> class="active"<?}?>><a href="#" onclick="goLink(2, 4)">CONTENT SOLUTION</a></li>
                                <li <? if($business == 5){?> class="active"<?}?>><a href="#" onclick="goLink(2, 5)">BTL SOLUTION</a></li>


                            <? } else if($group == 3) { ?>

                                <li <? if($business == 1){?> class="active"<?}?>><a href="#" onclick="goLink(3, 1)">ALL</a></li>
                                <li <? if($business == 2){?> class="active"<?}?>><a href="#" onclick="goLink(3, 2)">BRANDED CONTENT</a></li>
                                <li <? if($business == 3){?> class="active"<?}?>><a href="#" onclick="goLink(3, 2)">VIDEO COMMERCE</a></li>
                                <li <? if($business == 4){?> class="active"<?}?>><a href="#" onclick="goLink(3, 2)">CONTENT MARKETING</a></li>

                            <? }  ?>
                        </ul>
                    </div>
                    <div class="bm_right" alt="그룹소개">
                        <?if($group == 1){ ?>
                            <a href="/season5/group/creative.php"></a>
                        <? } else if($group == 2) { ?>
                            <a href="/season5/group/marketing.php"></a>
                        <? } else if($group == 3) { ?>
                            <a href="/season5/group/enc.php"></a>
                        <? }  ?>

                    </div>

                </section>
            </div>
        </div>
        <!-- //header_menu -->


    <!-- portfolio -->

        <div id="portfolio_list_container">
            <section class="portfolio-list-<?=$list_type?>">
                <h2 class="blind">포트폴리오</h2>
                <div class="row">
                        <ul>


                        </ul>
                </div>
            </section>
        </div>



        <!-- client -->
        <div id="client_container">
            <section class="main-client">
                <h2 class="blind">Client</h2>
                <div class="row">
                    <div class="main-client__wrap">
                        <ul class="main-client__list">
                            <li>
                                <img src="../images/img_client2.png" class="desktop" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                                <img src="../images/img_client1_m.png" class="mobile mobile--inline" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                            </li>
                            <li>
                                <img src="../images/img_client3.png" class="desktop" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                                <img src="../images/img_client2_m.png" class="mobile mobile--inline" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                            </li>
                            <li>
                                <img src="../images/img_client4.png" class="desktop" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                                <img src="../images/img_client3_m.png" class="mobile mobile--inline" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                            </li>
                            <li>
                                <img src="../images/img_client5.png" class="desktop" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                                <img src="../images/img_client4_m.png" class="mobile mobile--inline" alt="KB,신한카드,이노션,미래애셋,기아,SK텔레콤,코웨이,신세계,AIA,제일월드와이드">
                            </li>
                        </ul>
                        <div class="main-client__btn main-client__btn--prev"></div>
                        <div class="main-client__btn main-client__btn--next"></div>
                    </div>
                </div>
            </section>
        </div>
        <!-- //client -->

</div>



<!-- 포트폴리오 스크립트-->
<script>

    function goLink(_g , _b) {
        location.href = "portfolio.php?g=" + _g + "&b=" + _b;
    }

    var groupIdx = <?=$group?>;
    if(groupIdx == 1) {
        portf_biz_dex(<?=$business?>);

    } else {
        portf_biz_makting(<?=$business?>);
    }

    $(function () {
        var slider = {
            init : function () {

                $('.main-client__list').bxSlider({
                    prevSelector : '.main-client__btn--prev',
                    nextSelector : '.main-client__btn--next',
                    prevText : '<span class="sp sp--clientprev">다음 클라이언트</span>',
                    nextText :  '<span class="sp sp--clientnext">이전 클라이언트</span>',
                    pager : false
                })
            }


        }
        slider.init();
    });



    // dex : list_type = 1
    function portf_biz_dex(a){

        var target = $('.portfolio-list-<?=$list_type?> > div.row');
        target.html('');

        $('.btn-moreportfolio').attr({'data-page' :1 ,'data-start' : 0}) ;
        var group = <?=$group?>;
        $.ajax({
            url : 'ajax_list5.php?p=1&g='+group+'&b='+a+'&s=0',
            type : 'post',
            dataType : 'html',
            success : function (result) {
                target.append(result);
                console.log(result);
                //있을시
                if (true) {
                    $('.portfolio-list-<?=$list_type?> li a').each(function(e){
                        $(this).attr('href', $(this).attr('href')+'&b='+a+'&l='+(e+1));
                    });

                    $('.btn-moreportfolio').attr({'data-page' : 2 ,'data-start' : 10 }) ;
                }
            }
        });
    }




    function portf_biz_makting(a){
        var target = $('.portfolio-list-<?=$list_type?> > div.row ul');
        target.html('');
        $('.btn-moreportfolio').attr({'data-page' :1 ,'data-start' : 0}) ;
        var group = <?=$group?>;
        $.ajax({
            url : 'ajax_list4.php?p=1&g='+group+'&b='+a+'&s=0',
            type : 'post',
            dataType : 'html',
            success : function (result) {
                target.append(result);
                console.log(result);
                //있을시
                if (true) {
                    $('.portfolio-list-<?=$list_type?> li a').each(function(e){
                        $(this).attr('href', $(this).attr('href')+'&b='+a+'&l='+(e+1));
                    });

                    $('.btn-moreportfolio').attr({'data-page' : 2 ,'data-start' : 10 }) ;
                }
            }
        });
    }





</script>
<? require_once("../include/inc_footer.php") ?>
