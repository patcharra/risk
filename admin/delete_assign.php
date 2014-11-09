
<?php
	$id=$_REQUEST["id"];
	require('../common/common_header.php');
	$tblname = "assignment"; 

	$sql = "DELETE FROM $tblname WHERE IDassign = '$id'";
	$dbquery = mysql_query($sql,$dbConn);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'main_assign.php';</script>";
?>