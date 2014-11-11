<?php

	$tblname = "results_activity"; 

	$sql = "insert into $tblname (IDplan,quarter,year,date,resultQuan,IDunitQuan,IDemp) values ('".$_POST["unitname"]."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'riskchance.php';</script>";

?>