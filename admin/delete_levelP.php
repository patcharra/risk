
<?php
	$id=$_REQUEST["id"];
	require('../common/common_header.php');
	$tblname = "level_and_meanp"; 

	$sql = "DELETE FROM $tblname WHERE levelP = '$id'";
	$dbquery = mysql_query($sql,$dbConn);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'meanlevel.php';</script>";
?>