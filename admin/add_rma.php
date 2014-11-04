<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/risk_main.css">

</head>
<body>


<style type="text/css">

a:link, a:active, a:visited {
color:#000000; 
text-decoration: none}

a:hover {
color:#0000FF; 
text-decoration: none}
td{font-family:arial, sans-serif; font-size:15px;}

</style>
<?php
require('../common/common_header.php');
$id=$_REQUEST["id"];

$query0		= "select rmpName,IDplan from risk_manage_plan where IDrmp=$id"; 
$query_db0	= mysql_query($query0, $dbConn) or die(mysql_error());
$row_db0	= mysql_fetch_assoc($query_db0);//เก็บผลการประมวงผลลงตัวแปร $row_db


$query		= "select planName from plan where IDplan=".$row_db0['IDplan']; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db

$count		=1;
?>

<br>
<table>
<form method="post" action="###">

<tr><td><u></b>เพิ่มกิจกรรมการจัดการความเสี่ยง</b></u></td></tr>

<tr><td>แผน</td><td><?=$row_db['planName']?></td></tr>
<tr><td>แผนบริหารความเสี่ยง</td><td><?=$row_db0['rmpName']?></td></tr>

<input type="hidden" name="IDrmp" value="<?=$id?>">

<tr><td>รายละเอียดกิจกรรมการจัดการความเสี่ยง</td><td><input type="text" name="rmaDetail"><font color='red'> * </font></td></tr>
<tr><td>ระยะเวลาแล้วเสร็จ</td><td><input type="text" name="timesuccess"><font color='red'> * </font></td></tr>

<tr><td colspan='4'><center><input type="submit" name="sub" value="เพิ่ม" onClick="return confirm(' คุณแน่ใจที่จะเพิ่มกิจกรรมการจัดการความเสี่ยง?')">

</form>
<a href="main_risk_manage_plan.php"><button>ยกเลิก</button></a></center>

</table>




<?php

if(isset($_POST["sub"])){

	if(($_POST["rmaDetail"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	$tblname = "risk_manage_activity"; 

	$id	= $_REQUEST["IDrmp"];
	
	$sql = "insert into $tblname (rmaDetail,timesuccess,IDrmp) 
	values 
	('".$_POST["rmaDetail"]."','".$_POST["timesuccess"]."','".$id."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'main_risk_manage_plan.php';</script>";
	}
}
?>



<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
//mysql_free_result($query_db2);//เลิกติดต่อ Mysql
?>


</body>
</html>