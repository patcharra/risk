<?php
require('../common/common_header.php');
$action 	= '';
$code 		= '';
$typeName 	= '';

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
}
if(isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
if(isset($_REQUEST['typeName'])) {
	$typeName = $_REQUEST['typeName'];
}

if($code == ''){
	$sql = "INSERT INTO risktype VALUES(NULL, '$typeName')";
	$result = mysql_query($sql, $dbConn);
	if($result) {
		?>
		<script>window.location.href='show_risktype.php'</script>
		<?php
	} else {
		?>
		<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มข้อมูลได้ คลิก <a href="show_risktype.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
		<?php
	}
} else {
	if($action == 'DELETE') {
		$sql = "DELETE FROM risktype WHERE IDtype = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_risktype.php'</script>
			<?php
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลได้ คลิก <a href="show_risktype.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?php
		}
	} else {
		$sql = "UPDATE risktype SET typeName = '$typeName' WHERE IDtype = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_risktype.php'</script>
			<?php
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถแก้ไขข้อมูลได้ คลิก <a href="show_risktype.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?php
		}
	}
	
}
?>