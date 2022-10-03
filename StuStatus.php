<!DOCTYPE html>
<html lang="en">

	<head>
		<?php 
			session_start();
			require("conn_mysql.php");
			require("conn_mysql_rollcall.php");
			if(!isset($_COOKIE['Bear-RollCall_Account'])){//未登入 跳轉離開
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
								<h1>學生資訊修正</h1>
								<ol class="breadcrumb">
								<li><a href="index.php">首頁</a></li>
								<li class="active">學生資訊修正</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</section>	
			
			<?php
				$tp=$_SESSION['Bear-RollCall_Account'];
				$sql_query_data="SELECT * FROM AccountTable where Account='$tp'";//資料撈取
				$Data_result=mysqli_query($db_link,$sql_query_data) or die("查詢失敗");
				while($row=mysqli_fetch_array($Data_result))
				{
					$Account=$row[0];
					$Password=$row[1];
					$Stauts=$row[2];
					$EMail=$row[3];
					$Name=$row[4];
				}
			?>
			<!--中央重點-->
			<section class="service-promotion section-padding">
				<div class="container">
					<div class="row text-center">
						<div class="col-md-4 col-sm-4 col-xs-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
							<div class="single_service_promotion">
								<h1>學號/卡號大資料庫修改</h1>
								若該學號存在於資料庫內，則會替換為新卡號<br>
								<form class="form" name="ChangeStuCard" method="post" action="StuCardChange.php">
									<input type="text" name="StuID" class="form-control" placeholder="請輸入欲修改/新增卡號之學生學號"required="required"><br>
									<input type="text" name="StuCard" class="form-control" placeholder="請輸入新卡號(十碼)"required="required"><br>
									<!-- <input type="text" name="StuName" class="form-control" placeholder="該生姓名"required="required"><br> -->
									<input type="submit" value="卡號修改" name="ChangeStuCard" id="submitButton" class="btn-light-bg" title="卡號修改"/><br>
								</form>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
							<div class="single_service_promotion">
								<h1>新增課程資訊</h1>
								<form class="form" name="CreateClass" method="post" action="AddClass.php">
									<select style="font-size:20px;" name="Semester">
										<option disabled ="disabled">課程開設學期</option>
										<?php
											$ThisYear=date("Y")-1911;
											for($i=$ThisYear;$i<=$ThisYear+3;$i++){
										?>
											<optgroup label=<?php echo $i?>>
												<option value=<?php echo $i."1"?>><?php echo $i."1"?></option>
												<option value=<?php echo $i."1"?>><?php echo $i."2"?></option>
											</optgroup>
										<?php
											}
										?>
									</select>
									<select style="font-size:20px;" name="ClassRoom">
										<option disabled ="disabled">課程教室</option>
										<option value="C219">C219</option>
										<option value="C302">C302</option>
										<option value="C303">C303</option>
										<option value="C311">C311</option>
										<option value="C402">C402</option>
										<option value="C403">C403</option>
										<option value="C404">C404</option>
										<option value="C420">C420</option>
										<option value="C512">C512</option>
										<option value="C506">C506</option>
									</select><br><br>
									<input type="text" name="ClassName_Cht" class="form-control" placeholder="新課程之中文名稱"required="required"><br>
									<input type="text" name="ClassName_Eng" class="form-control" placeholder="新課程之英文名稱"required="required"><br>
									課程開始日~結束日<br>
									<input id="date" type="date" name="FirstWeek" required="required">
									<input id="date" type="date" name="LastWeek" required="required"><br><br>
									星期&nbsp;<select style="font-size:20px;" name="Week">
										<option disabled ="disabled">課程星期</option>
										<option value="7">日</option>
										<option value="1">一</option>
										<option value="2">二</option>
										<option value="3">三</option>
										<option value="4">四</option>
										<option value="5">五</option>
										<option value="6">六</option>
									</select><br><br>
									課程時段<br>
									<input id="date" type="time" name="StartTime" required="required">
									<input id="date" type="time" name="EndTime" required="required"><br><br>
									
									<input type="submit" value="新增課程" name="CreateClass" id="submitButton" class="btn-light-bg" title="新增課程"/><br>
								</form>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s" data-wow-offset="0">
							<div class="single_service_promotion">
								<h1>課程人員修改</h1>
								<br><br>
								<form class="form" name="AddStuToClass" method="post" action="AddStuToClass.php">
									<select name="WhatClass" style="font-size:20px;" id="SelectClass">
										<option disabled ="disabled">請選擇課程</option>
										<?php 
											$sql_query_ClassName="SELECT * FROM `ClassName` ORDER BY `ClassName`.`Semester` ASC";
											$ClassName_result=mysqli_query($db_link_rollcall,$sql_query_ClassName) or die("查詢失敗");
											$TitleSemester="";
											while($row=mysqli_fetch_array($ClassName_result)){
												if($TitleSemester!=$row['Semester']){//如果找到不同學期，新增一標題(開頭)
													echo "<optgroup label=".$row['Semester'].">";
													$TitleSemester=$row['Semester'];
												}
												echo "<option value=".$row['Semester']."_".$row['Name_Eng'].">".$row['Name_Cht']."</option>";
												if($TitleSemester!=$row['Semester']){//如果找到不同學期，新增一標題(結尾)
													echo "</optgroup>";
												}
											}
											echo "</optgroup>";
										?>
									</select>
									<br>	<br>			
									<input type="text" name="StuID" class="form-control" placeholder="請輸入欲加入課程的學號/卡號"required="required"><br>
									<input type="text" name="StuName" class="form-control" placeholder="學生姓名"><br>
									<input type="submit" value="新增學生" name="AddStuToClass" id="submitButton" class="btn-light-bg" title="新增學生"/><br>
								</form>
								<br>
							</div>
						</div>
					</div>
				</div>
			</section>	
			<section class="service">			
				<div class="container">
					<div class="row text-center">
						<h1>開課資訊</h1>
						<form class="form" name="BookCancel" method="post" action="BookCancel.php"><!--取消用Form-->
							<table>
							<tr>
								<th>學期</th>
								<th>課程名稱</th>
								<th>教室</th>
								<th>星期</th>
								<th>開始日<br>結束日</th>
								<th>課程時段</th>
							</tr>
								<?php
									//資料撈取
									$sql_query_ClassInfo="SELECT * FROM `ClassName` WHERE 1 ORDER BY `ClassName`.`Semester` DESC";
									$ClassInfo_result=mysqli_query($db_link_rollcall,$sql_query_ClassInfo) or die("查詢失敗");
									while($row=mysqli_fetch_array($ClassInfo_result))
									{
										echo "<tr>";
											echo "<th>".$row['Semester']."</th>";
											echo "<th>".$row['Name_Cht']."<br>".$row['Name_Eng']."</th>";
											echo "<th>".$row['ClassRoom']."</th>";
											echo "<th>".$row['Week']."</th>";
											echo "<th>".$row['FirstWeek']."<br>".$row['LastWeek']."</th>";
											echo "<th>".$row['StartTime']."<br>".$row['EndTime']."</th>";
										echo "</tr>";
									}
								?>
							</table><br>
						</form>
						
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