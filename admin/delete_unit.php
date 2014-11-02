
<?php
	$id=$_REQUEST["id"];
	require('../common/common_header.php');
	$tblname = "unit"; 

	$sql = "DELETE FROM $tblname WHERE IDunit = '$id'";
	$dbquery = mysql_query($sql,$dbConn);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'main_unit.php';</script>";
?>