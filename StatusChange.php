<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	require("conn_mysql.php");//連線資料庫
	$FindPost=false;
	$sql_query_ChkRecord="SELECT * FROM Appointment where 1 order by `Status` ASC , `DataTime` ASC";//找尋現在的每一筆登記
	$Rst=mysqli_query($db_link,$sql_query_ChkRecord) or die("操作失敗");
	//審核中 通過! 未通過
	while($row=mysqli_fetch_array($Rst)){//每筆紀錄檢查
			
		if($row[2]>date("Y-m-d 00:00:00")){//只檢查今天以後的紀錄
			if(isset($_POST["Agree".$row[0]])){//檢查通過部分
				//資料庫寫入通過
				$sql_query_Agree="SELECT * FROM Appointment where `DataTime` = \"".$row[2]."\" order by `Status` ASC , `DataTime` ASC";//先把當天全部拒絕
				$Rst1=mysqli_query($db_link,$sql_query_Agree) or die("操作失敗");
				while($row1=mysqli_fetch_array($Rst1)){
					$row_Repent="UPDATE Appointment SET status=\"未通過\" where _ID=\"".$row1[0]."\"";
					$Rst__Repent=mysqli_query($db_link,$row_Repent) or die("操作失敗");//將當天所有改為拒絕
				}
				$row_Agree="UPDATE Appointment SET status=\"通過!\" where _ID=\"".$row[0]."\"";//把要通過那筆通過
				$Rst1=mysqli_query($db_link,$row_Agree) or die("操作失敗");//把要通過那筆通過
				?>
				<script language=javascript> //為了讓跳轉回去可以回到同一頁
					document.write("<form action=\"RecordStatus.php\" method=post name=\"form1\">");  //新增一個Form傳值回去
					document.write("<input type=\"hidden\" name=\"Pge\" value=<?php echo $_POST['Pge'];?>>");  //隱藏剛過來的頁碼 傳回去
					document.write("</form>");  
					document.form1.submit();  
				</script>  
				<?php
				break;//一次只做一筆，找到可跳出(理論上上面應該會跳轉了)
			}
			else if(isset($_POST["Refuse".$row[0]])){//檢查拒絕部分
				//資料庫寫入拒絕
				$sql_query_Refuse="UPDATE Appointment SET status=\"未通過\" where _ID=\"".$row[0]."\"";
				$Rst1=mysqli_query($db_link,$sql_query_Refuse) or die("操作失敗");//將過去的未審核拒絕
				?>
				<script language=javascript> //為了讓跳轉回去可以回到同一頁
					document.write("<form action=\"RecordStatus.php\" method=post name=\"form1\">");  //新增一個Form傳值回去
					document.write("<input type=\"hidden\" name=\"Pge\" value=<?php echo $_POST['Pge'];?>>");  //隱藏剛過來的頁碼 傳回去
					document.write("</form>");  
					document.form1.submit();  
				</script>  
				<?php
				break;//一次只做一筆，找到可跳出(理論上上面應該會跳轉了)
			}
			else if(isset($_POST["Repent".$row[0]])){//檢查反悔部分
				//資料庫寫入反悔
				$sql_query_Repent="SELECT * FROM Appointment where `DataTime`=\"".$row[2]."\" order by `Status` ASC , `DataTime` ASC";//找尋現在的每一筆登記
				$Rst1=mysqli_query($db_link,$sql_query_Repent) or die("操作失敗");//將過去的改為審核中
				while($row1=mysqli_fetch_array($Rst1)){
					$row_Repent="UPDATE Appointment SET status=\"審核中\" where _ID=\"".$row1[0]."\"";
					$Rst__Repent=mysqli_query($db_link,$row_Repent) or die("操作失敗");//將過去的未審核拒絕
				
				}
				?>
				<script language=javascript> //為了讓跳轉回去可以回到同一頁
					document.write("<form action=\"RecordStatus.php\" method=post name=\"form1\">");  //新增一個Form傳值回去
					document.write("<input type=\"hidden\" name=\"Pge\" value=<?php echo $_POST['Pge'];?>>");  //隱藏剛過來的頁碼 傳回去
					document.write("</form>");  
					document.form1.submit();  
				</script>  
				<?php
				break;//一次只做一筆，找到可跳出(理論上上面應該會跳轉了)
			}
			
		}
		else{//過去的天數如果遇到未審核  可以直接未通過 或是反悔
			if($row[6]=="審核中"){
				$sql_query_Refuse="UPDATE Appointment SET status=\"未通過\" where _ID=\"".$row[0]."\"";
				$Rst1=mysqli_query($db_link,$sql_query_Refuse) or die("操作失敗");//將過去的未審核拒絕
			}
		}
	}
	echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"index.php\";</script>";
?>