
<?php
	$id=$_REQUEST["id"];
	require('../common/common_header.php');
	$tblname = "employee"; 

	$sql = "DELETE FROM $tblname WHERE IDemp = '$id'";
	$dbquery = mysql_query($sql,$dbConn);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'main_emp.php';</script>";
?>