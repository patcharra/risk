<?php
	$id=$_REQUEST["id"];
	require('../common/common_header.php');
	$tblname = "agency"; 

	$sql = "DELETE FROM $tblname WHERE IDagen = '$id'";
	$dbquery = mysql_query($sql,$dbConn);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'main_agencies.php';</script>";
?>