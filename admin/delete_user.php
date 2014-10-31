
<?php
	$id=$_REQUEST["id"];
	$hostname = "localhost"; 
	$user = "root"; 
	$password = "1234"; 
	$dbname = "risk"; 
	$tblname = "employee"; 

	mysql_connect($hostname, $user, $password) or die("ติดต่อฐานข้อมูลไม่ได้");

	mysql_select_db($dbname) or die("เลือกฐานข้อมูลไม่ได้");

	$sql = "DELETE FROM $tblname WHERE IDemp = '$id'";
	$dbquery = mysql_db_query($dbname, $sql);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'main_emp.php';</script>";
?>