
<?php
	$id=$_REQUEST["id"];
	require('../common/common_header.php');
	$tblname = "risk_manage_plan"; 

	$sql = "DELETE FROM $tblname WHERE IDrmp = '$id'";
	$dbquery = mysql_query($sql,$dbConn);
	mysql_close();

	echo "<script type='text/javascript'>window.location.href = 'main_risk_manage_plan.php';</script>";
?>