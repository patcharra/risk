<html>
<head>
<meta charset="utf-8">
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
$id	= $_REQUEST["id"];

$query22		= "select rmaDetail,timesuccess,IDrmp from  risk_manage_activity where IDrma =".$id; 
$query_db22	= mysql_query($query22, $dbConn) or die(mysql_error());
$row_db22	= mysql_fetch_assoc($query_db22);//เก็บผลการประมวงผลลงตัวแปร $row_db


$query		= "select rmpName,IDplan from  risk_manage_plan where IDrmp =".$row_db22["IDrmp"]; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db

$query2		= "select planName from  plan where IDplan =".$row_db['IDplan']; 
$query_db2	= mysql_query($query2, $dbConn) or die(mysql_error());
$row_db2	= mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


?>

<br>
<h3>แก้ไขกิจกรรมการจัดการความเสี่ยง</h3><br><br>
<table>
<form method="post" action="###">


<tr><td>แผน</td><td><?=$row_db2['planName']?></td></tr>
<tr><td>แผนบริหารความเสี่ยง</td><td><?=$row_db['rmpName']?></td></tr>

<input type="hidden" name="IDrma" value="<?=$id?>">

<tr><td>รายละเอียดกิจกรรมการจัดการความเสี่ยง</td><td><input type="text" name="rmaDetail" value="<?=$row_db22['rmaDetail']?>"><font color='red'> * </font></td></tr>
<tr><td>ระยะเวลาแล้วเสร็จ</td><td><input type="text" name="timesuccess" value="<?=$row_db22['timesuccess']?>"><font color='red'> * </font></td></tr>


<input type="hidden" name="id" value="<?=$id?>">

<tr><td colspan='4'><center><input type="submit" name="sub" value="แก้ไข" onClick="return confirm(' คุณแน่ใจที่จะแก้ไขกิจกรรมการจัดการความเสี่ยง?')">


</form>
<a href="main_risk_manage_plan.php"><button>ยกเลิก</button></a></center></td></tr>

</table>


<?php

if(isset($_POST["sub"])){
	if(($_POST["rmaDetail"]=="" ) || ($_POST["timesuccess"]=="" )){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	
$tblname = "risk_manage_activity"; 
	
$id	= $_REQUEST["id"];

			$sql = "Update $tblname Set rmaDetail ='".$_POST["rmaDetail"]."',timesuccess ='".$_POST["timesuccess"]."' Where IDrma ='$id'";

$dbquery = mysql_query($sql, $dbConn);


	echo "<script type='text/javascript'>window.location.href = 'main_risk_manage_plan.php';</script>";
	}
}
?>


<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
?>


</body>
</html>