<?php
//查詢一遍儲存現在所有坐人座位，預存於陣列中
$Week=substr( $_GET['Week'],3,-3);//把第,周切掉  
$sql_query_SeatHasPeo="SELECT week".$Week." FROM `".$_GET['ClassEng']."` WHERE week".$Week."<>\"\"";
$SeatHasPeo_result=mysqli_query($db_link_rollcall,$sql_query_SeatHasPeo) or die("查詢失敗");
$SeatHasPeo=array();
while($row=mysqli_fetch_array($SeatHasPeo_result)){
  array_push($SeatHasPeo,$row[0]);
}
?>