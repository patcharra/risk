
<?php
	$id=$_REQUEST["id"];
	require('../common/common_header.php');
	$tblname = "level_and_meano"; 

	$sql = "DELETE FROM $tblname WHERE levelO = '$id'";
	$dbquery = mysql_query($sql,$dbConn);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'meanlevel.php';</script>";
?>