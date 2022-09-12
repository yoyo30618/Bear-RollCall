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
		<?php
			function daysDiff($date1, $date2)
			{
				$first = strtotime($date1);
				$second = strtotime($date2);
				$diff_seconds=$second-$first;
				$time = floor(($diff_seconds)/86400);
				return (int)$time;
			}
			if(isset($_GET['LockWeek'])){//如果周次已設定 依照設定為主
			}
			else{
				if(isset($_GET['ClassEng'])){//如果有選課了
					$Semester=substr($_GET['ClassEng'],0,4);//前三個為學期
					$ClassEngName=substr($_GET['ClassEng'],5);//後面為課程名稱
					$sql_query_RollCall="SELECT * FROM `ClassName` WHERE `Name_eng`=\"".$ClassEngName."\" AND `Semester`=\"".$Semester."\"";

					$RollCall_result=mysqli_query($db_link_rollcall,$sql_query_RollCall) or die("查詢失敗");
					while($row=mysqli_fetch_array($RollCall_result)){//該課程開始日期
						$WeekDiff=0;
						$WeekDiff=(int)(daysDiff($row['FirstWeek'],date("Y-m-d"))/7)+1;
						if($WeekDiff>0&&$WeekDiff<19)
							$_GET['Week']="第".$WeekDiff."週";
						else
							$_GET['Week']="第1週";
						break;
					}
				}
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
								<h1>點名Time</h1>
								<ol class="breadcrumb">
								<li><a href="index.php">首頁</a></li>
								<li class="active">點名Time</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</section>	

			<!-- 中央重點 -->
			<section class="service" style="align:center;width: 100%;">			
				<div class="container" style="align:center;width: 100%;;">
					<div class="row text-center" style="margin:0px auto;align:center;width: 90%;">
						<div class="section-title">
							<h1>請老師/助教運用此頁面快速進行點名</h1>
							<span></span>
						</div>
						<?php //查找教室
							$ClassRoom="";
							$sql_query_ClassName="SELECT * FROM `ClassName` ORDER BY `ClassName`.`Semester` ASC,`ClassName`.`Name_Eng` ASC";
							$ClassName_result=mysqli_query($db_link_rollcall,$sql_query_ClassName) or die("查詢失敗");
							while($row=mysqli_fetch_array($ClassName_result)){
								if(isset($_GET['ClassEng'])){
									if(!strcmp($_GET['ClassEng'],($row[1]."_".$row[3]))){
										$ClassRoom=$row[4];
										break;
									}
								}
							}
						?>
					
							<form class="form" name="RollCall" method="post" action="RollCallCheck.php">
								<?php
								echo "<input type=\"hidden\" id=\"ClassRoom\" name=\"ClassRoom\" value=\"".$ClassRoom."\"></input>";
								if(isset($_GET['Seat'])){
									echo "<h3 style=\"color:red;\">選定座位".$_GET['Seat']."</h3>";
									echo "<input type=\"hidden\" id=\"Seat\" name=\"Seat\" value=\"".$_GET['Seat']."\"></input>";
								}
								else{
									echo "<h3 style=\"color:red;\">請先選擇座位後，輸入卡號/學號點名</h3>";
								}
								if(isset($_GET['NeedSeat'])){
									if($_GET['NeedSeat']=="1")
										echo "<input type=\"checkbox\" checked id=\"NeedSeat\" name=\"NeedSeat\"><span  style=\"font-size:150%;\">本節課不需要紀錄座位</span></input>";
									else
										echo "<input type=\"checkbox\" id=\"NeedSeat\" name=\"NeedSeat\"><span  style=\"font-size:150%;\">本節課不需要紀錄座位</span></input>";
								}
								else{
									echo "<input type=\"checkbox\" id=\"NeedSeat\" name=\"NeedSeat\"><span  style=\"font-size:150%;\">本節課不需要紀錄座位</span></input>";
								}
								echo "<br>";
								if(isset($_GET['ClassCht'])&&isset($_GET['Week']))
									echo "<h3>目前所選課程：".$_GET['ClassCht'].",目前所選週次：".$_GET['Week'].",教室於：".$ClassRoom."</h3>";
								?>
								<input type="text" name="CardID" id="inputtext" placeholder ="輸入卡號/學號"></input><br><br>
								<?php
								if(isset($_GET['ClassEng'])){
									echo "<input type=\"hidden\" name=\"ClassEng\" value=\"".$_GET['ClassEng']."\"></input>";
								}
								if(isset($_GET['ClassRoom'])){
									echo "<input type=\"hidden\" name=\"ClassRoom\" value=\"".$_GET['ClassRoom']."\"></input>";
								}
								if(isset($_GET['Week'])){
									echo "<input type=\"hidden\" name=\"Week\" value=\"".$_GET['Week']."\"></input>";
								}
								if(isset($_GET['ClassCht'])){
									echo "<input type=\"hidden\" name=\"ClassCht\" value=\"".$_GET['ClassCht']."\"></input>";
								}
								?>
								<select name="WhatClass" style="font-size:20px;" id="SelectClass">
									<option>請選擇課程</option>
									<?php 
										$sql_query_ClassName="SELECT * FROM `ClassName` ORDER BY `ClassName`.`Semester` ASC,`ClassName`.`Name_Eng` ASC";
										$ClassName_result=mysqli_query($db_link_rollcall,$sql_query_ClassName) or die("查詢失敗");
										$TitleSemester="";
										$ClassRoom="";
										while($row=mysqli_fetch_array($ClassName_result)){
											if($TitleSemester!=$row[1]){//如果找到不同學期，新增一標題(開頭)
												echo "<optgroup label=$row[1]>";
												$TitleSemester=$row[1];
											}
											/*塞各學期課程*/
											if(isset($_GET['ClassEng'])){
												if(!strcmp($_GET['ClassEng'],($row[1]."_".$row[3]))){
													echo "<option selected value=".$row[1]."_".$row[3].">".$row[2]."</option>";//當下真正的學期與課程
													$ClassRoom=$row[4];
												}
												else
													echo "<option value=".$row[1]."_".$row[3].">".$row[2]."</option>";
											}
											else
												 echo "<option value=".$row[1]."_".$row[3].">".$row[2]."</option>";
											if($TitleSemester!=$row[1]){//如果找到不同學期，新增一標題(結尾)
												echo "</optgroup>";
											}
										}
									?>
								</select>
								
								<select name="WhatWeek" style="font-size:20px;" id="SelectWeek">
									<option>請選擇週次</option>
									<?php 
										for($i=1;$i<=20;$i++){
											if(!strcmp($_GET['Week'],"第".$i."週"))
												echo "<option selected value=Week".$i.">第".$i."週</option>";
											else
												echo "<option  value=Week".$i.">第".$i."週</option>";					
										}
									?>
								</select>
								<?php 
								/*導入教室座位svg*/
								if($ClassRoom!=""){
									include("CheckSeat.php");//查詢坐人座位，存入預存陣列
									$error=include("svg/".$ClassRoom.".svg");
									if($error==1){//正確讀入教室座位
										echo "<h3 style=\"color:red;\">請先選擇座位後，輸入卡號/學號點名</h3>";
									}
									else{
										echo "<h3 style=\"color:red;\">此教室尚無座位圖，敬請直接輸入卡號/學號點名</h3>";
										echo "<input type=\"hidden\" name=\"NeedSeat\" value=\"1\"></input>";
									}
								}
								?>
							<table style="table-layout:fixed;">
								<tr>
									<th style="width:15%;">學號</th>
									<th style="width:13%;">姓名</th>
									<?php 
										for($week=1;$week<=18;$week++)	
											echo "<th style=\"width:8%;font-size:22px\">第".$week."週</th>";
									?>
								</tr>
								<?php 
									if(isset($_GET['ClassEng'])){//有選擇才有表格
										$sql_query_RollCall="SELECT * FROM `".$_GET['ClassEng']."` ORDER BY `".$_GET['ClassEng']."`.`StudentID` ASC";
										$RollCall_result=mysqli_query($db_link_rollcall,$sql_query_RollCall) or die("查詢失敗");
										while($row=mysqli_fetch_array($RollCall_result)){//有誰修這一堂課
											echo "<tr>";
											echo "<td>$row[0]</td>";
											echo "<td>$row[1]</td>";
											for($week=2;$week<=19;$week++){//學號+姓名+20周
												if($row[$week]!="")
													echo "<td>".$row[$week]."</td>";
												else
												echo "<td></td>";
											}
											echo"</tr>";
										}
												
									} 
								?>
							</form>
						</table>
					</div><!--- END ROW -->
				</div><!--- END CONTAINER -->
			</section>
			<!--底部資訊-->	
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
			<script>//下拉式選單跳轉用
				window.onload=initForm;
				function initForm(){
					var oselWeek=document.getElementById("SelectWeek");
					var oselClass=document.getElementById("SelectClass");
					document.getElementById('inputtext').focus()
					oselWeek.onchange=jumpPage;
					oselClass.onchange=jumpPage;
				}
				function jumpPage(){
					var oselClass=document.getElementById("SelectClass");
					var oselWeek=document.getElementById("SelectWeek");
					var ClassRoom=document.getElementById("ClassRoom");
					var newURL="";
					newURL+="?ClassEng="+oselClass.options [oselClass.selectedIndex].value;
					newURL+="&ClassCht="+oselClass.options [oselClass.selectedIndex].text;
					newURL+="&Week="+oselWeek.options [oselWeek.selectedIndex].text;
					//把下拉式選單的選擇GET給自己
					if((oselClass.options [oselClass.selectedIndex].value!="請選擇課程")){
						window.location.href=newURL;
					}
				}
			</script>
		</div>
    </body>
</html>