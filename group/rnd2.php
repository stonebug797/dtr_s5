<?
include_once("../include/inc_header.php");

?>
	<!-- //HEADER -->
	<!-- CONTAINER -->
	<div class="container">
		<!-- content -->
		<div class="content">
			<!-- introduce -->
			<div class="introduce introduce--seollam">
				<!-- top -->
				<div class="introduce__top">
					<div class="introduce__top-box">
						<div class="introduce__top-slogan">DOVE TO RABBIT</div>
						<h2 class="introduce__top-title">
							<strong>LABORATORY</strong>
						</h2>
						<div class="introduce__top-explore">
							<a href="#">
								Scroll to explore
								<span class="sp sp--explore"></span>
								
							</a>							
						</div>
					</div>
				</div>
				<!-- //top -->
				<!-- tab -->
				<div class="comm-tab comm-tab--3">
					<a href="../group/rnd1.php?sc=on">D.EX.LAB.</a>
					<a href="../group/rnd2.php?sc=on" class="active">SEOL-LAM LAB.</a>
					<a href="/season4/group/rnd3.php?sc=on" class="desktop">CORPORATE CULTURE LAB.</a>
					<a href="/season4/group/rnd3.php?sc=on" class="mobile mobile--inline">CORP. CULTURE</a>
				</div>
				<!-- //tab -->
				<!-- con -->
				<section class="introduce__content">
					<article class="article">
						<div class="row">
							<h3 class="comm-cat">From Carts to Hearts</h3>
							<h2 class="comm-title">
								Seol-lam <span>[ sɜ:rl-lӕm ; 설렘 ]</span><br>
								설렘이 반이다!
							</h2>
							<div class="comm-slogan">
								창조는 설렘으로 시작된다.<br>
								관계도 설렘으로 시작된다.<br>
								소비도 설렘으로 시작된다.
							</div>
							<p class="seollam-desc">
								이제 소비자들이 물건을 사던 시대는 끝났습니다. <br>
								오늘날의 소비자는 물건이 아니라 자신의 가치와 잠재된 욕망을 구매합니다. <br>
								그리고 그들은 절대 가르침이나 설득으로 움직이지 않습니다. <br>
								그들의 가슴은 어떠한 것에 끌리고 떨리는가?<br>
								소비자에게 설렘을 주는 커뮤니케이션<br>
								설렘을 표현할 수 있는 플랫폼 설렘을 센싱하고 분석할 수 있는 테크놀러지
								<strong>설렘 연구소는 소비자의 모든 설렘을 연구합니다.</strong>
							</p>			
						</div>
					</article>
					<article class="article article-last">
						<div class="row">
							<div class="seollam-master">
								<h3 class="seollam-cat">연구소장</h3>
								<h2 class="seollam-name">안해익 마스터</h2>
								<div class="seollam-image">
									<img src="../images/img_master.jpg" alt="안해익 마스터">
								</div>
								<div class="seollam-cat">주요이력</div>
								<ul class="seollam-career seollam-desc">
									<li>하쿠호도제일 제작본부장, 전무</li>
									<li>제일기획 MASTER (1호)</li>
									<li>제일기획 Interactive Creative Team ECD</li>
									<li>제일기획 New York 법인 CD</li>
									<li>깐느 국제광고제 심사위원</li>
									<li>New York Festival 심사위원</li>
									<li>국내외 광고/마케팅 캠페인 진행 및 다수 광고제 수상</li>
								</ul>							
								<div class="comm-btnwrap">
									<a href="mailto:seolab@dovetorabbit.com" class="btn btn-comm">
										CONTACT US
									</a>
								</div>
							</div>
						</div>
					</article>				
				</section>
				<!-- //con -->
			</div>
			<!-- //introduce -->
		</div>
		<!-- //content -->
	</div>
	<!-- //CONTAINER -->
<?
include_once("../include/inc_footer.php");

if ($_GET['sc']){ ?>
	<script>
	$(function () { 
		$('.introduce__top-explore a').trigger('click');
	});
	</script> 
<? } ?>