<?php
require('../common/common_header.php');
$planID = '';
if(isset($_POST['planID'])) {
	$planID = $_POST['planID'];
}
$sql = "SELECT 	u.unitName 
		FROM 	plan p, unit u 
		WHERE 	p.IDunit_riskchance = u.IDunit 
				AND p.IDplan = '$planID'";
$result = mysql_query($sql, $dbConn);
$rows 	= mysql_num_rows($result);
if($rows > 0) {
	$tmpRow = mysql_fetch_assoc($result);
	echo $tmpRow['unitName'];
} else {
	echo "ไม่พบข้อมูลหน่วยนับของโอกาสเกิดความเสี่ยงของแผนรหัส '$planID'";
}
?>