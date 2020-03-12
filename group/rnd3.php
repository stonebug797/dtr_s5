<?
include_once("../include/inc_header.php");
?>
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
				<div class="comm-tab">
					<a href="/season4/group/rnd1.php?sc=on">D.EX.LAB.</a>
					<!-- <a href="/season4/group/rnd2.php?sc=on">SEOL-LAM LAB.</a> -->
					<a href="/season4/group/rnd3.php?sc=on" class="desktop active">CORPORATE CULTURE LAB.</a>
					<a href="/season4/group/rnd3.php?sc=on" class="mobile mobile--inline active">CORP. CULTURE</a>
				</div>
				<!-- //tab -->
				<!-- con -->
				<section class="introduce__content">
					<article class="article">
						<div class="row">
							<div class="row--col">
								<div class="col col2">
									<h3 class="comm-cat">Corporate Culture Lab</h3>
									<h2 class="comm-title">
										좋은 회사는 <br>
										좋은 기업문화가 <br>
										바탕이 됩니다.
									</h2>
									<div class="comm-slogan" style="color:#4c4c4c;">
										꿈을 꾸고 이루며, 함께 성장하는 좋은 회사 <br>
										서로 돕고 응원하며 성장의 동력이 되는 기업 문화 <br>
										우리는 좋은 회사에 어울리는  <br>
										좋은 기업문화를 고민하고 만들어 갑니다.
									</div>
									<ul class="comm-list seollam-desc">
										<li>
											<strong>기업 문화의 성장</strong>
											도브투래빗이 하나되기 위한 단체활동, 더욱 친밀해지기 위한 그룹활동, <br>
											각 사람의 필요와 만족을 위한 개인맞춤 문화까지<br>
											조직의 문화도 상황과 여건, 사람에 따라 변화 하듯, 우리의 기업문화는 성장 중 입니다. <br>
											우리는 다양한 시도를 통해 좋은 기업문화가 정착되고 퍼져나가도록 즉시 실행합니다.
										</li>
										<li>
											<strong>기업 문화의 확장</strong>
											<p>
												우리의 목표는 좋은 기업을 만드는 것입니다. <br>
												이 꿈은 도브투래빗에만 머무르지 않습니다. <br>
												좋은 회사를 꿈꾸는 모든 기업에 우리의 시도와 노하우를 전파하기를 꿈꿉니다.
											</p>
											<p>
												전문적이고 간소화 된 도브투래빗 진단 툴을 활용하여 조직 문화를 진단하고, <br>
												개인의 성향을 파악하여 맞춤 조직문화를 기획하고 제안합니다. 
											</p>
											<p>
												도브투래빗 기업문화 연구소와 좋은 기업을 만들어 보시지 않겠습니까?<br>
												우리는 사람과 회사, 그리고 꿈의 성장을 연구합니다.
											</p>
										</li>
									</ul>		
									<div class="comm-btnwrap">
										<a href="mailto:friends@dovetorabbit.com" class="btn btn-comm">
											CONTACT US
										</a>
									</div>
								</div>
								<div class="col col2">
									<div class="seollam-sliderwrap">
										<div class="seollam-sliderbox">
											<ul class="seollam-sliderlist">
												<li><img src="/season4/images/img_seollam.jpg" alt="설레임"></li>
												<li><img src="/season4/images/img_fre1.jpg" alt="설레임"></li>
												<li><img src="/season4/images/img_fre2.jpg" alt="설레임"></li>
												<li><img src="/season4/images/img_fre3.jpg" alt="설레임"></li>
												<li><img src="/season4/images/img_fre4.jpg" alt="설레임"></li>
											</ul>
											<div class="comm-pager">
												<span class="comm-pager--btn comm-pager--prev"></span>
												<span class="comm-pager--current seollam-current">01</span>
												<span class="comm-pager--dot">/</span>
												<span class="comm-pager--all seollam-all">02</span>
												<span class="comm-pager--btn comm-pager--next"></span>
											</div>
										</div>
									</div>
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
	<script>
	$(function () {
		$('.seollam-sliderlist').bxSlider({
			pager:false,
			prevSelector : '.comm-pager--prev',
			nextSelector : '.comm-pager--next',
			prevText : '<span class="sp sp--commprev">이전 포트폴리오</span>',
			nextText :  '<span class="sp sp--commnext">다음 포트폴리오</span>',
			infiniteLoop : false,
			onSliderLoad : function () {
				var ss = $('.seollam-sliderlist li').length;
				if (ss < 10) {
					ss = '0'+ss;
				}
				$('.seollam-all').text(ss);
			},
			onSlideAfter : function (c,o,n) {
				console.log(n);
				var cn = n+1;
				if (cn < 10) {
					cn = '0' + cn;
				}
				$('.seollam-current').text(cn);
			},
			onSlideBefore : function (c,o,n) {	
				var cn = n+1;
				if (cn < 10) {
					cn = '0' + cn;
				}
				$('.seollam-current').text(cn);
			},
			oneToOneTouch : false
		});
	});
	</script>
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