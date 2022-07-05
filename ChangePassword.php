<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['ChangePWD']))//如果是由post進入
	{
		$NewPassword1 = trim($_POST['NewPassword1']);
		$NewPassword2 = trim($_POST['NewPassword2']);
		if(($NewPassword1=='')||($NewPassword2==''))
			echo"<script  language=\"JavaScript\">alert('密碼不能為空');location.href=\"login.php\";</script>";
		require("conn_mysql.php");
		if($NewPassword1!=$NewPassword2)
			echo"<script  language=\"JavaScript\">alert('兩次密碼輸入不一致');location.href=\"login.php\";</script>";
		else{
			$Account=$_SESSION['Bear-RollCall_Account'];
			$sql_query_ChgPwd="UPDATE `AccountTable` SET `Password`=\"$NewPassword1\" WHERE `Account`=\"$Account\"";
			$Rst=mysqli_query($db_link,$sql_query_ChgPwd) or die("操作失敗");
			if($Rst){
				session_destroy();//銷毀session
				//清除cookie
				setcookie("Bear-RollCall_Account",'',time()-1);
				setcookie("Bear-RollCall_Islogin",'',time()-1);
				setcookie("Bear-RollCall_Status",'',time()-1);
				echo"<script  language=\"JavaScript\">alert('密碼修改完畢，請重新登入!');location.href=\"login.php\";</script>";
			}
			else{
				echo"<script  language=\"JavaScript\">alert('操作可能失敗，請重新確認!');location.href=\"status.php\";</script>";
			}
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"login.php\";</script>";
		
?>