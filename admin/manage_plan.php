<?
require('../common/common_header.php');
$action 				= '';
$code 					= '';
$planName 				= '';
$IDstrategy 			= '';
$IDtype					= '';
$IDriskfac  			= '';
$riskfacName			= '';
$rationale				= '';
$target 				= '';
$accept_risk 			= '';
$deviation_accept_risk 	= '';
$time 					= '';


if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
}
if(isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
if(isset($_REQUEST['planName'])) {
	$planName = $_REQUEST['planName'];
}
if(isset($_REQUEST['IDstrategy'])) {
	$IDstrategy = $_REQUEST['IDstrategy'];
}
if(isset($_REQUEST['IDtype'])) {
	$IDtype = $_REQUEST['IDtype'];
}
if(isset($_REQUEST['IDriskfac'])) {
	$IDriskfac = $_REQUEST['IDriskfac'];
}
if(isset($_REQUEST['riskfacName'])) {
	$riskfacName = $_REQUEST['riskfacName'];
}
if(isset($_REQUEST['rationale'])) {
	$rationale = $_REQUEST['rationale'];
}
if(isset($_REQUEST['target'])) {
	$target = $_REQUEST['target'];
}
if(isset($_REQUEST['accept_risk'])) {
	$accept_risk = $_REQUEST['accept_risk'];
}
if(isset($_REQUEST['deviation_accept_risk'])) {
	$deviation_accept_risk = $_REQUEST['deviation_accept_risk'];
}
if(isset($_REQUEST['time'])) {
	$time = $_REQUEST['time'];
}


if($code == ''){
	print_r($riskfacName);
	/*$sql = "INSERT INTO strategy VALUES(NULL, '$strategyName')";
	$result = mysql_query($sql, $dbConn);
	if($result) {
		?>
		<script>window.location.href='show_strategy.php'</script>
		<?
	} else {
		?>
		<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มข้อมูลได้ คลิก <a href="show_strategy.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
		<?
	}*/
} else {
	/*if($action == 'DELETE') {
		$sql = "DELETE FROM strategy WHERE IDstrategy = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_strategy.php'</script>
			<?
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลได้ คลิก <a href="show_strategy.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?
		}
	} else {
		$sql = "UPDATE strategy SET strategyName = '$strategyName' WHERE IDstrategy = '$code'";
		$result = mysql_query($sql, $dbConn);
		if($result) {
			?>
			<script>window.location.href='show_strategy.php'</script>
			<?
		} else {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถแก้ไขข้อมูลได้ คลิก <a href="show_strategy.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?
		}
	}
	*/
}
?>