<?
require('../common/common_header.php');
$action 	= '';
$code 		= '';
$IDplan 	= '';
$level		= '';
$detail 	= '';
$quantity 	= '';
$quantitymin = '';
$quantitymax = '';

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
if(isset($_REQUEST['quantity'])) {
	$quantity = $_REQUEST['quantity'];
}
if(isset($_REQUEST['quantitymin'])) {
	$quantitymin = $_REQUEST['quantitymin'];
}
if(isset($_REQUEST['quantitymax'])) {
	$quantitymax = $_REQUEST['quantitymax'];
}


if($code == ''){
	$sql = "INSERT INTO  impact_quan VALUES(NULL,
			'$detail',
			'$IDplan',
			'$level',
			'$quantity',
			'$quantitymin',
			'$quantitymax')";
	$result = mysql_query($sql, $dbConn);
	if($result) {
		?>
		<script>window.location.href='show_impact_quan.php'</script>
		<?
	} else {
		?>
		<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มข้อมูลได้ คลิก <a href="show_impact_quan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
		<?
	}
} else {
	if($action == 'DELETE') {
		$sql = "DELETE FROM impact_quan WHERE IDimQn = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_impact_quan.php'</script>
			<?
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลได้ คลิก <a href="show_impact_quan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?
		}
	} else {
		$sql = "UPDATE impact_quan SET detail = '$detail',
				IDplan = '$IDplan',
				level = '$level',
				quantity = '$quantity',
				quantitymin = '$quantitymin',
				quantitymax = '$quantitymax' 
				WHERE IDimQn = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_impact_quan.php'</script>
			<?
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถแก้ไขข้อมูลได้ คลิก <a href="show_impact_quan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?
		}
	}
	
}
?>