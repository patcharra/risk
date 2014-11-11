<?php
require('../common/common_header.php');
$action 	= '';
$code 		= '';
$IDplan 	= '';
$level		= '';
$detail 	= '';

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
}
if(isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
if(isset($_REQUEST['IDplan'])) {
	$IDplan = $_REQUEST['IDplan'];
}
if(isset($_REQUEST['level'])) {
	$level = $_REQUEST['level'];
}
if(isset($_REQUEST['detail'])) {
	$detail = $_REQUEST['detail'];
}


if($code == ''){
	$sql = "INSERT INTO  impact_qual VALUES(NULL,
			'$detail',
			'$level',
			'$IDplan')";
	$result = mysql_query($sql, $dbConn);
	if($result) {
		?>
		<script>window.location.href='show_impact_qual.php'</script>
		<?php
	} else {
		?>
		<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มข้อมูลได้ คลิก <a href="show_impact_qual.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
		<?php
	}
} else {
	if($action == 'DELETE') {
		$sql = "DELETE FROM impact_qual WHERE IDimQl = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_impact_qual.php'</script>
			<?php
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลได้ คลิก <a href="show_impact_qual.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?php
		}
	} else {
		$sql = "UPDATE impact_qual SET detail = '$detail',
				level = '$level',
				IDplan = '$IDplan' 
				WHERE IDimQl = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_impact_qual.php'</script>
			<?php
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถแก้ไขข้อมูลได้ คลิก <a href="show_impact_qual.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?php
		}
	}
	
}
?>