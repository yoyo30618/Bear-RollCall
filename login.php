<!DOCTYPE html>
<html lang="en">

	<head>
		<?php 
			session_start();
			require("conn_mysql.php");
			if(isset($_COOKIE['Bear-RollCall_Account'])){//已經登入 跳轉離開
				header('refresh:0;url=index.php');
			}
		?>
		<!-- 設定抬頭與預設css -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>課程點名系統</title>		
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">	
		<link href='http://fonts.googleapis.com/css?family=Cousine:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Merriweather:400,700,900,300' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/flexslider.css">	
		<link rel="stylesheet" href="assets/venobox/css/venobox.css" />
		<link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">	
		<link rel="stylesheet" href="assets/css/animate.css">	
		<link rel="stylesheet" href="assets/css/style.css">	
		<link rel="stylesheet" href="assets/css/switcher/switcher.css"> 	
		<link rel="stylesheet" href="assets/css/switcher/style1.css" id="colors">	
		<style>
		table{
		  width:100%;
		  border-collapse: collapse;
		}
		th, td {
		  border: 1px solid black;
		  width:10%;
		  text-align:center;
		  border-collapse: collapse;
		  font-size:25px;
		}
		</style>
	</head>
	
    <body>
		<div class="bear">
			<!--START PRELOADER-->
			<div class="preloader status">
				<div class="status">
					<div class="status-mes"></div>
				</div>
			</div>		
			<!--START NAVBAR-->
			<div class="navbar navbar-default navbar-fixed-top menu-top menu_dropdown">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="index.php" class="navbar-brand"><img src="assets/img/logo.png" alt="logo"></a>
					</div>
					<!--上方橫幅宣告-->
					<div class="navbar-collapse collapse">
						<nav>
							<ul class="nav navbar-nav navbar-right">
								<li><a href="index.php">首頁</a></li>
								<li><a href="RollCallStatus.php">點名狀態</a></li>
								<?php
									if(isset($_COOKIE['Bear-RollCall_Status'])&&($_COOKIE['Bear-RollCall_Status'])=="管理員"){
										echo "<li><a>課程點名/修正</a>";
											echo "<ul class=\"sub-menu\">";
												echo "<li><a href=\"RollCall.php\">課程點名</a></li>";
												echo "<li><a href=\"StuStatus.php\">學生資訊修正</a></li>";
											echo "</ul>";
										echo "</li>";
									}
									if(isset($_COOKIE['Bear-RollCall_Account'])){//如果有設定cookie代表已經登入
										echo "<li><a href=\"status.php\">個人狀態</a></li>";
										
										echo "<li><a href=\"logout.php\">登出</a></li>";
									}
									else{//尚未登入則顯示登入與註冊按鈕
										echo "<li><a href=\"login.php\">登入</a></li>";
									}
								?>
							</ul>
						</nav>
					</div> 
				</div>
			</div> 	
			<!--中上橫幅-->
			<section class="section-top" style="background-image: url(assets/img/bg/section-bg.jpg);  background-size:cover; background-position: center center;background-attachment:fixed;">
				<div class="overlay">
					<div class="container">
						<div class="col-md-10 col-md-offset-1 col-xs-12 text-center">
							<div class="section-top-title wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
								<h1>登入系統</h1>
								<ol class="breadcrumb">
								<li><a href="index.php">首頁</a></li>
								<li class="active">登入系統</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</section>	

			<!-- 中央重點 -->
			<section class="contact_area section-padding">
				<div class="container">	
					<div class="row contact_padding">	
						<div class="col-md-8 col-sm-12 col-sm-6 col-xs-12 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.6s" data-wow-offset="0">
							<div class="contact">
								<h1>輸入您的帳號/密碼以登入</h1>
								<form class="form" name="login" method="post" action="logincheck.php">
									<div class="row">
										<div class="form-group col-md-6">
											<input type="text" name="Account" class="form-control" placeholder="帳號(學號)"required="required">
										</div>
										<div class="form-group col-md-6">
											<input type="password" name="Password" class="form-control" placeholder="密碼"required="required">
										</div>
										<div class="form-group col-md-12">
										<div class="actions">
											<input type="submit" value="登入" name="login" id="submitButton" class="btn-light-bg" title="點此登入" />
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="single-address wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.4s" data-wow-offset="0">
								<div class="media">
									<div class="media-left">
										<i class="fa fa-rocket"></i>
									</div>
									<div class="media-body text-left">
										<h2 class="media-heading">地址</h2>
										<p>95092<br> 臺東市大學路二段369號<br>資訊工程學系</p>
									</div>
								</div>
							</div>
							<div class="single-address wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.5s" data-wow-offset="0">
								<div class="media">
									<div class="media-left">
										<i class="fa fa-phone"></i>
									</div>
									<div class="media-body text-left">
										<h2 class="media-heading">電話與老師聯絡</h2>
										<p>(089) 517602 <br> (089) 318855#6212</p>
									</div>
								</div>
							</div>
							<div class="single-address wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.6s" data-wow-offset="0">
								<div class="media">
									<div class="media-left">
										<i class="fa fa-envelope"></i>
									</div>
									<div class="media-body text-left">
										<h2 class="media-heading">E-mail與老師聯絡</h2>
										<p>cwlee@nttu.edu.tw</p>
									</div>
								</div>
							</div>
						</div>
					</div>		
				</div>		
			</section>	
			<!--底部資訊-->
			<section class="footer-top">
				<div class="footer_overlay section-padding">	
					<div class="container">
						<div class="row">					
							<div class="col-md-4 col-sm-6  wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
								<div class="single_footer">
									<h1>佳衛點名系統</h1>
									<p>這是個用來點名ㄉ網站。</p>
									<div class="footer_contact">
										<ul>
											<li><i class="fa fa-phone"></i> 連絡電話<br>(089)318855#6212<br>(089)517602</li>
											<li><i class="fa fa-envelope"></i> cwlee@nttu.edu.tw</li>
											<li><i class="fa fa-rocket"></i>95092<br>臺東市大學路二段369號 資訊工程學系</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-2 col-sm-6  wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
								<div class="single_footer">
									<h1>相關連結</h1>
									<ul>
										
											<?php
												if(isset($_COOKIE['Bear-RollCall_Account'])){//如果設定cookie代表已登入
													echo "<li><a href=\"status.php\">個人狀態</a></li>";
													echo "<li><a href=\"logout.php\">登出</a></li>";
												}
												else{//尚未登入顯示登入與註冊
													echo "<li><a href=\"login.php\">登入</a></li>";
													
												}
											?>
										<h1></h1>
										<li><a href="http://algotutor.nttu.edu.tw/domjudge">DomJudge</a></li>
										<li><a href="http://algolab.nttu.edu.tw">實驗室網頁</a></li>
										<li><a href="http://www.nttu.edu.tw">臺東大學</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--版權列-->
			<footer class="footer section-padding">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 text-center  wow zoomIn">
							<p class="footer_copyright">Copyright &copy; 2021.BEAR All rights reserved.</p>						
						</div>
					</div>
				</div>
			</footer>
			<!--無用換色功能-->
			<div id="style-switcher">
				<h2>選擇你喜愛的顏色<a href="#"><i class="fa fa-cog fa-spin"></i></a></h2>
				<div>
				<ul class="colors" id="color1">
					<li><a href="#" class="style1"></a></li>
					<li><a href="#" class="style2"></a></li>
					<li><a href="#" class="style3"></a></li>
					<li><a href="#" class="style4"></a></li>
					<li><a href="#" class="style5"></a></li>
					<li><a href="#" class="style6"></a></li>
					<li><a href="#" class="style7"></a></li>
					<li><a href="#" class="style8"></a></li>
					<li><a href="#" class="style9"></a></li>
					<li><a href="#" class="style10"></a></li>
					<li><a href="#" class="style11"></a></li>
					<li><a href="#" class="style12"></a></li>
					<li><a href="#" class="style13"></a></li>
					<li><a href="#" class="style14"></a></li>
					<li><a href="#" class="style15"></a></li>
					<li><a href="#" class="style16"></a></li>
					<li><a href="#" class="style17"></a></li>
					<li><a href="#" class="style18"></a></li>
					<li><a href="#" class="style19"></a></li>
					<li><a href="#" class="style20"></a></li>
				</ul>
				</div>
			</div>  
			<script src="assets/js/jquery-1.11.3.min.js"></script>
			<script src="assets/bootstrap/js/bootstrap.min.js"></script>
			<script src="assets/js/scrolltopcontrol.js"></script>
			<script src="assets/js/jquery.flexslider.js"></script>		
			<script src="assets/venobox/js/venobox.min.js"></script>
			<script src="assets/js/jquery.mixitup.js"></script>
			<script src="assets/js/jquery.countTo.js"></script>
			<script src="assets/js/jquery.inview.min.js"></script>
			<script src="assets/owlcarousel/js/owl.carousel.min.js"></script>
			<script src="assets/js/wow.min.js"></script>
			<script src="assets/js/switcher.js"></script>			
			<script src="assets/js/scripts.js"></script>
			<script type="text/javascript">
				$(".partner").owlCarousel({
				autoPlay: 3000, //Set AutoPlay to 3 seconds
				items : 4,
				itemsDesktop : [1199,3],
				itemsDesktopSmall : [979,3]
				});
			</script>
		</div>
    </body>
</html>