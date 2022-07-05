<?php
	$db_link_rollcall=@mysqli_connect("210.240.163.28","Bear-Interview","nttucsie");
	if(!$db_link_rollcall)
		die("資料庫連線失敗<br>");
	else{
		mysqli_query($db_link_rollcall, 'SET NAMES utf8');
		$seldb_rollcall=@mysqli_select_db($db_link_rollcall,"Bear-Interview_RollCall");
		if(!$seldb_rollcall)
			die("資料庫選擇失敗<br>");
	}
?>