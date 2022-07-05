<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session

	if(isset($_POST['CardID'])&&isset($_POST['Week'])&&isset($_POST['ClassEng'])&&isset($_POST['ClassCht']))//如果是由post進入
	{
		require("conn_mysql_rollcall.php");
		$StudentID="";
		if(strlen($_POST['CardID'])==10){//傳過來的是內碼
			$sql_query_SearchID="SELECT * FROM `StudentName` WHERE `CardID`=\"".$_POST['CardID']."\"";
			$row_result=mysqli_query($db_link_rollcall,$sql_query_SearchID) or die("查詢失敗1");
			while($row=mysqli_fetch_array($row_result)){//學生卡號與學號對應
				$StudentID=$row[0];
			}
		}
		else{//傳過來的是學號
			$StudentID=$_POST['CardID'];
		}
		if($StudentID=="")	//檢查有沒有找到該生
			echo"<script  language=\"JavaScript\">alert('查無學生，請檢查學生證');location.href=\"RollCall.php?ClassEng=".$_POST['ClassEng']."&ClassCht=".$_POST['ClassCht']."&Week=".$_POST['Week']."&ClassRoom=".$_POST['ClassRoom']."\";</script>";			
		else{	
			//檢查該生是否有修本課程
			$sql_query_StudyCalss="SELECT * FROM `".$_POST['ClassEng']."` WHERE `StudentID`=\"".$StudentID."\"";
			//echo $_POST['ClassRoom'];
			$row_result=mysqli_query($db_link_rollcall,$sql_query_StudyCalss) or die("查詢失敗2");
			$Find="";
			while($row=mysqli_fetch_array($row_result)){//學生卡號與學號對應
				$Find=$row[0];
				break;
			}
			if($Find=="")//沒找到該生修課資料
				echo"<script  language=\"JavaScript\">alert('找不到該生修課資料，請聯絡老師修正');location.href=\"RollCall.php?ClassEng=".$_POST['ClassEng']."&ClassCht=".$_POST['ClassCht']."&Week=".$_POST['Week']."&ClassRoom=".$_POST['ClassRoom']."\";</script>";		
			else{//有學生 有修課 寫入資料庫紀錄點名

				if(isset($_POST['NeedSeat'])){	//不用記錄座位(直接寫入)
					$sql_query_StudyCalss="UPDATE `".$_POST['ClassEng']."` SET `Week".substr($_POST['Week'],3,-3)."`=\"Y\" WHERE `StudentID`=\"".$StudentID."\"";
					mysqli_query($db_link_rollcall,$sql_query_StudyCalss) or die("查詢失敗3");
				}
				else if(isset($_POST['Seat'])){//選定座位為".$_POST['Seat']
					$sql_query_StudyCalss="UPDATE `".$_POST['ClassEng']."` SET `Week".substr($_POST['Week'],3,-3)."`=\"".$_POST['Seat']."\" WHERE `StudentID`=\"".$StudentID."\"";
					mysqli_query($db_link_rollcall,$sql_query_StudyCalss) or die("查詢失敗3");
				}
				else{//請選擇座位再刷卡
					echo"<script  language=\"JavaScript\">alert('請選擇座位再刷卡');location.href=\"RollCall.php\";</script>";		
				}
			}
		}
		//跳轉回本來點名頁面
		if(isset($_POST['NeedSeat']))	//不用記錄座位
			echo"<script  language=\"JavaScript\">;location.href=\"RollCall.php?ClassEng=".$_POST['ClassEng']."&ClassCht=".$_POST['ClassCht']."&Week=".$_POST['Week']."&ClassRoom=".$_POST['ClassRoom']."&NeedSeat=1\";</script>";		
		else
		echo"<script  language=\"JavaScript\">;location.href=\"RollCall.php?ClassEng=".$_POST['ClassEng']."&ClassCht=".$_POST['ClassCht']."&Week=".$_POST['Week']."&ClassRoom=".$_POST['ClassRoom']."&NeedSeat=0\";</script>";		
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入並選擇課程與週次');location.href=\"RollCall.php\";</script>";		
?>