<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['CreateClass']))//如果是由post進入
	{
		$ClassName_Cht = trim($_POST['ClassName_Cht']);
		$Semester = trim($_POST['Semester']);
		$ClassName_Eng = trim($_POST['ClassName_Eng']);
		$ClassRoom = trim($_POST['ClassRoom']);
		$Week = trim($_POST['Week']);
		$FirstWeek = trim($_POST['FirstWeek']);
		$LastWeek = trim($_POST['LastWeek']);
		if($LastWeek<$FirstWeek){
			$tp=$LastWeek;
			$LastWeek=$FirstWeek;
			$FirstWeek=$tp;
		}
		$StartTime = trim($_POST['StartTime']);
		$EndTime = trim($_POST['EndTime']);
		if($EndTime<$StartTime){
			$tp=$EndTime;
			$EndTime=$StartTime;
			$StartTime=$tp;
		}
		require("conn_mysql.php");
		require("conn_mysql_rollcall.php");
		//若有更新 若無則新增
		//INSERT INTO `StudentName` (`StudentID`,`StudentName`,`CardID`,`Notice`) VALUES ('1','2','3','')  ON DUPLICATE KEY UPDATE `CardID`='3';
		$sql_query_CntClass="SELECT COUNT(*) FROM `ClassName` WHERE `Semester`='".$Semester."' AND `Name_Eng`='".$ClassName_Eng."'";
		// print($sql_query_CntClass);
		$CntClass_result=mysqli_query($db_link_rollcall,$sql_query_CntClass) or die("查詢失敗");
		while($row=mysqli_fetch_array($CntClass_result)){
			$ClassCnt=$row[0];
			break;
		}
		// print($ClassCnt);
		if($ClassCnt>0)
			echo"<script  language=\"JavaScript\">alert('該課程已存在，請檢察學期與課程名稱');location.href=\"StuStatus.php\";</script>";
		else{
			$sql_query_AddClass="INSERT INTO `ClassName` (`Semester`,`Name_Cht`,`Name_Eng`,`ClassRoom`,`Week`,`StartTime`,`EndTime`,`FirstWeek`,`LastWeek`,`Notice`) VALUES ('".$Semester."','".$ClassName_Cht."','".$ClassName_Eng."','".$ClassRoom."','".$Week."','".$StartTime."','".$EndTime."','".$FirstWeek."','".$LastWeek."','')  ";
			// print($sql_query_AddClass);
			$AddClass_result=mysqli_query($db_link_rollcall,$sql_query_AddClass) or die("查詢失敗");
			if($AddClass_result==1){//課程創建成功時，必須新增課程資料庫
				
				$sql_query_CreateTable="CREATE TABLE `Bear-Interview_RollCall`.`".$Semester."_".$ClassName_Eng ."` ";
				$sql_query_CreateTable=$sql_query_CreateTable."( `StudentID` CHARACTER(80) NOT NULL ,  ";
				$sql_query_CreateTable=$sql_query_CreateTable."`StudentName` CHARACTER(80) NOT NULL ,  ";
				$sql_query_CreateTable=$sql_query_CreateTable."`Week1` CHARACTER(80) NOT NULL DEFAULT '',";    
				$sql_query_CreateTable=$sql_query_CreateTable."`Week2` CHARACTER(80) NOT NULL DEFAULT '',";       
				$sql_query_CreateTable=$sql_query_CreateTable."`Week3` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week4` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week5` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week6` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week7` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week8` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week9` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week10` CHARACTER(80) NOT NULL DEFAULT '',";    
				$sql_query_CreateTable=$sql_query_CreateTable."`Week11` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week12` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week13` CHARACTER(80) NOT NULL DEFAULT '',";    
				$sql_query_CreateTable=$sql_query_CreateTable."`Week14` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week15` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week16` CHARACTER(80) NOT NULL DEFAULT '',";    
				$sql_query_CreateTable=$sql_query_CreateTable."`Week17` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week18` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week19` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."`Week20` CHARACTER(80) NOT NULL DEFAULT '',";   
				$sql_query_CreateTable=$sql_query_CreateTable."PRIMARY KEY  (`StudentID`(80))) ENGINE = InnoDB";
				// print($sql_query_CreateTable);
				$CreateTable_result=mysqli_query($db_link_rollcall,$sql_query_CreateTable) or die("查詢失敗");
				echo"<script  language=\"JavaScript\">alert('課程新增成功');location.href=\"StuStatus.php\";</script>";			
			}
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"StuStatus.php\";</script>";
		
?>