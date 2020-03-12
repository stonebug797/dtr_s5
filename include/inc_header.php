
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>DOVE TO RABBIT</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="디지털 마케팅 컴퍼니, 온오프라인 통합 마케팅, 뉴미디어 서비스, 글로벌 마케팅">
	<meta property="og:title" content="DOVE TO RABBIT">
	<meta property="og:url" content="http://www.dovetorabbit.com/">
	<meta property="og:image" content="http://dovetorabbit.com/season5/images/logo_big.png">
	<meta property="og:description" content="디지털 마케팅 컴퍼니, 온오프라인 통합 마케팅, 뉴미디어 서비스, 글로벌 마케팅">	
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">

    <!-- favicon -->
	<link rel="apple-touch-icon" href="/season5/favicon.png" />
	<link rel="shortcut icon" href="/season5/favicon.ico" />

    <!-- css -->
    <link rel="stylesheet" href="/season5/common/js/bx/jquery.bxslider.min.css">
    <link rel="stylesheet" href="/season5/common/css/reset.css">
    <link rel="stylesheet" href="/season5/common/css/common.css">
    <link rel="stylesheet" href="/season5/common/css/portfolio.css">

    <!-- script -->
    <script src="/season5/common/js/jquery-3.1.1.min.js"></script>
    <script src="/season5/common/js/jquery.easing.min.js"></script>
    <script src="/season5/common/js/bx/jquery.bxslider.min.js"></script>
    <script src="/season5/common/js/common.js"></script>

    <style>
        .header_bg {
            <? if($textcolor == "white") { ?>
            background: rgba(0, 0, 0, 0.9); transition:all .1s ease-out;
            <? } else { ?>
            background: rgba(255, 255, 255, 0.9); transition:all .1s ease-out;
            <? } ?>
        }
    </style>
</head>
<body>
    <!-- WRAP -->
    <div id="wrap" class="<?= $pd0 ?>">
        <!-- HEADER -->
        <header id="header" class="header">
            <div class="h-container">
                <div class="logo">
                    <a href="/season5">
                        <? if($textcolor == "white") { ?>
                        <img src="/season5/images/logo_w.png" alt="Dove to rabbit">
                        <? } else { ?>
                        <img src="/season5/images/logo_b.png" alt="Dove to rabbit">
                        <? } ?>
                    </a>
                </div>
                <button type="button" class="btn-allmenu" data-allmenu>
                    <span class="blind">
                        전체메뉴보기
                    </span>
                    <span class="btn-allmenu_item btn-allmenu_item-top bg<?=$textcolor?>"></span>
                    <span class="btn-allmenu_item btn-allmenu_item-middle bg<?=$textcolor?>"></span>
                    <span class="btn-allmenu_item btn-allmenu_item-bottom bg<?=$textcolor?>"></span>
                </button>
                <div class="gnb">
                    <div class="gnb_wrap">
                        <ul class="gnb_menu">
                            <li>
                                <a href="/season5">HOME</a>
                            </li>
                            <li>
                                <a href="/season5/company">ABOUT</a>
                            </li>
                            <li>
                                <a href="/season5/company/business.php">BUSINESS AREA</a>
                                <ul>
                                    <li><a href="/season5/group/portfolio.php?g=2&b=1">MARKETING</a></li>
                                    <li><a href="/season5/group/portfolio.php?g=1&b=1">DIGITAL EXPERIENCE</a></li>
                                    <li><a href="/season5/group/portfolio.php?g=3&b=1">DIGITAL ENT.</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="/season5/company/contact.php">CONTACT</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- //HEADER -->
	
<? 

include ($_SERVER['DOCUMENT_ROOT']."/season5/include/inc_func.php");
?>