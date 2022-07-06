<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['AddStuToClass']))//如果是由post進入
	{
		$StuID = trim($_POST['StuID']);
		$StuName = trim($_POST['StuName']);
		$WhatClass = trim($_POST['WhatClass']);
		require("conn_mysql.php");
		require("conn_mysql_rollcall.php");
		$sql_query_AddStuToClass="INSERT INTO `".$WhatClass."`(`StudentID`, `StudentName`) VALUES ('".$StuID."','".$StuName."')";
		// print($sql_query_AddStuToClass);
		$AddStuToClass_result=mysqli_query($db_link_rollcall,$sql_query_AddStuToClass) or die("查詢失敗");
		if($AddStuToClass_result==1){//學生新增成功
			echo"<script  language=\"JavaScript\">alert('學生新增成功');location.href=\"StuStatus.php\";</script>";
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"StuStatus.php\";</script>";
		
?>