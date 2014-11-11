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
<h3>นำเข้าข้อมูลโอกาสเกิดความเสี่ยง</h3><br><br>

<table>
<form method="post" action="###">


<tr><td>แผนงาน</td><td><SELECT NAME="plan">

	<?php 
	do{?>
			<option value='<?=$row_db['IDplan']?>'><?=$row_db['planName']?></option>
	<?php }while ($row_db = mysql_fetch_assoc($query_db));?>

</SELECT>

<tr><td colspan='4'><center><input type="submit" name="sub" value="เลือก"></center></td></tr>



</form>
</table>




<?php

if(isset($_POST["sub"])){
	$tblname = "employee"; 
	
	$md5_password =  $_POST["password"];
	$sql = "insert into $tblname (firstname,lastname,username,password,status,IDagen) 
	values 
	('".$_POST["firstname"]."','".$_POST["lastname"]."','".$_POST["username"]."', '".$md5_password."','".$_POST["status"]."', '".$_POST["agen"]."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'riskchance.php';</script>";
	
}
?>





</body>
</html>