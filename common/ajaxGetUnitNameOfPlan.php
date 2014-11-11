<?php
require('../common/common_header.php');
$planID = '';
$field 	= '';
if(isset($_POST['planID'])) {
	$planID = $_POST['planID'];
}
if(isset($_POST['field'])) {
	$field = $_POST['field'];
}
$sql = "SELECT 	u.unitName 
		FROM 	plan p, unit u 
		WHERE 	p.$field = u.IDunit 
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