<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['login']))//如果是由post進入
	{
		$Account = trim($_POST['Account']);
		$Password = trim($_POST['Password']);
		if(($Account=='')||($Password==''))//空白帳密
			echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼不能為空');location.href=\"login.php\";</script>";
		require("conn_mysql.php");
		$sql_query_login="SELECT * FROM AccountTable where Account='$Account'";
		$Pwd_result=mysqli_query($db_link,$sql_query_login) or die("查詢失敗");//查詢帳密
		while($row=mysqli_fetch_array($Pwd_result))
		{
			if($row[1]==$Password)//登入成功
			{
				if($row[2]=="審核中"){
					echo"<script  language=\"JavaScript\">alert('此帳號尚未被老師審核，請等待老師審核通過');location.href=\"login.php\";</script>";
					break;
				}
				else if($row[2]=="拒絕申請"){
					echo"<script  language=\"JavaScript\">alert('此帳號已被禁止，請重新註冊申請');location.href=\"register.php\";</script>";
					break;
				}
				$_SESSION['Bear-RollCall_Account']=$Account;//登入成功將資訊儲存到session中
				$_SESSION['Bear-RollCall_Islogin']=1;
				setcookie("Bear-RollCall_Account",$Account);
				if($row[2]=="管理員")//存不同權限
					setcookie("Bear-RollCall_Status","管理員");
				else
					setcookie("Bear-RollCall_Status","學生");
				header('refresh:1;url=index.php');
				break;
			}
			else//密碼錯誤登入失敗
				echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼錯誤');location.href=\"login.php\";</script>";
		}
		if(!isset($_SESSION['Bear-RollCall_Account']))//都找不到代表沒帳號
			echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼錯誤');location.href=\"login.php\";</script>";
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"login.php\";</script>";
		
?>