<?php
require('../common/common_header.php');
$action 	= '';
$code 		= '';
$strategyName 	= '';

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
}
if(isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
if(isset($_REQUEST['strategyName'])) {
	$strategyName = $_REQUEST['strategyName'];
}

if($code == ''){
	$sql = "INSERT INTO strategy VALUES(NULL, '$strategyName')";
	$result = mysql_query($sql, $dbConn);
	if($result) {
		?>
		<script>window.location.href='show_strategy.php'</script>
		<?php
	} else {
		?>
		<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มข้อมูลได้ คลิก <a href="show_strategy.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
		<?php
	}
} else {
	if($action == 'DELETE') {
		$sql = "DELETE FROM strategy WHERE IDstrategy = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_strategy.php'</script>
			<?php
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลได้ คลิก <a href="show_strategy.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?php
		}
	} else {
		$sql = "UPDATE strategy SET strategyName = '$strategyName' WHERE IDstrategy = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_strategy.php'</script>
			<?php
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถแก้ไขข้อมูลได้ คลิก <a href="show_strategy.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?php
		}
	}
	
}
?>