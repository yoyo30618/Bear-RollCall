<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['ChangeStuCard']))//如果是由post進入
	{
		$StuID = trim($_POST['StuID']);
		$StuCard = trim($_POST['StuCard']);
		require("conn_mysql.php");
		require("conn_mysql_rollcall.php");
		//若有更新 若無則新增
		//INSERT INTO `StudentName` (`StudentID`,`StudentName`,`CardID`,`Notice`) VALUES ('1','2','3','')  ON DUPLICATE KEY UPDATE `CardID`='3';

		$sql_query_ChgCard="INSERT INTO `StudentName` (`StudentID`,`StudentName`,`CardID`,`Notice`) VALUES ('".$StuID."','','".$StuCard."','')  ON DUPLICATE KEY UPDATE `CardID`='".$StuCard."'";
		$ChgCard_result=mysqli_query($db_link_rollcall,$sql_query_ChgCard) or die("查詢失敗");//查詢帳密
		if($ChgCard_result==1)
			echo"<script  language=\"JavaScript\">alert('卡號登記/修改成功');location.href=\"StuStatus.php\";</script>";
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"login.php\";</script>";
		
?>