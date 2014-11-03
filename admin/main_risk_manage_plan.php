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

$query		= "select IDplan,planName from plan"; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db
$count		=1;
?>

<br>
<h3>จัดการแผนบริหารความเสี่ยง</h3><br><br>

<table>
<form method="post" action="###">

<tr><td><u></b>เพิ่มแผนบริหารความเสี่ยง</b></u></td></tr>

<tr><td>แผน</td><td><SELECT NAME="plan">

	<?php 
	do{?>
			<option value='<?=$row_db['IDplan']?>'><?=$row_db['planName']?></option>
	<?php }while ($row_db = mysql_fetch_assoc($query_db));?>

</SELECT><td></tr>
<tr><td>ชื่อแผนบริหารความเสี่ยง</td><td><input type="text" name="rmpName"><font color='red'> * </font></td></tr>

<tr><td colspan='4'><center><input type="submit" name="sub" value="เพิ่ม" onClick="return confirm(' คุณแน่ใจที่จะเพิ่มแผนบริหารความเสี่ยง?')"><input type="submit" name="clear" value="ยกเลิก"></center></td></tr>



</form>
</table>




<?php

if(isset($_POST["sub"])){
	if(($_POST["rmpName"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	$tblname = "risk_manage_plan"; 
	

	$md5_password =  $_POST["password"];
	$sql = "insert into $tblname (rmpName,IDplan) 
	values 
	('".$_POST["rmpName"]."','".$_POST["plan"]."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'main_risk_manage_plan.php';</script>";
	}
}
?>






<table class= "table-data">
<tr>
<th></th>
<th></th>
<th align="center" >แผนงานที่</th>
<th align="center" >รายการแผนบริหารความเสี่ยง</th>

</tr>

<?php
$query2 = "select IDplan,planName from plan"; 
$query_db2 = mysql_query($query2, $dbConn) or die(mysql_error());
$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db



do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
$IDplan=$row_db2['IDplan'];

$query3 = "select IDrmp,rmpName from risk_manage_plan where IDplan= $IDplan"; 
$query_db3 = mysql_query($query3, $dbConn) or die(mysql_error());
$row_db3 = mysql_fetch_assoc($query_db3);//เก็บผลการประมวงผลลงตัวแปร $row_db


?>

<tr>
<td></td><td></td>


<td ><center>&nbsp;<?=$count++?></center></td>
<td >&nbsp;<?=$row_db2['planName']?> </td>
</tr>
<?php
do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
?>
<tr>
	<td><a href="update_rmp.php?id=<?=$row_db3['IDrmp']?>"><button>แก้ไข</button></a></td>
	<td><a href="delete_rmp.php?id=<?=$row_db3['IDrmp']?>" onClick="return confirm(' คุณแน่ใจที่จะลบ <?=$row_db3['rmpName']?>?')"><button>ลบ</button></a></td>

	<td></td><td >&nbsp;&nbsp;&nbsp;-&nbsp;<?=$row_db3['rmpName']?> </td>
</tr>

<?php                                                                           
}while ($row_db3 = mysql_fetch_assoc($query_db3));
?>


<?php                                                                           
}while ($row_db2 = mysql_fetch_assoc($query_db2));
?>
</table>

<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
//mysql_free_result($query_db2);//เลิกติดต่อ Mysql
?>


</body>
</html>