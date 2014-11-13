<?php
session_start();
	$idemp	= $_SESSION["IDemp"];
	$id		= $_POST["idplan"];
	$q		= $_POST["q"];
	$date	= date('d')."-".date('m')."-".date('Y')+543;
	require('../common/common_header.php');
	$tblname = "results_activity"; 

	$sql = "insert into $tblname (IDplan,quarter,year,date,result_riskchanceQuan,IDunit_rcQuan,IDemp) values ('".$id."','".$q."','".$_POST["year"]."','".$date."','".$_POST["resultQuan"]."','".$_POST["IDunitQuan"]."','".$idemp."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	//echo $sql;
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'riskchance.php';</script>";

?>