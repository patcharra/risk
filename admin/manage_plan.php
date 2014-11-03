<?
require('../common/common_header.php');
$action 				= '';
$code 					= '';
$planName 				= '';
$risk 					= '';
$IDstrategy 			= '';
$IDtype					= '';
$statusValue1 			= '';
$statusValue2 			= '';
$targetValue1			= '';
$targetValue2 			= '';
$IDriskfac  			= '';
$riskfacName			= '';
$rationale				= '';
$target 				= '';
$accept_risk 			= '';
$deviation_accept_risk 	= '';
$time 					= '';
$IDobj 					= '';
$objDtl 				= '';
$IDrtg 					= '';
$rtgDetail 				= '';

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
}
if(isset($_REQUEST['code'])) {
	$code = $_REQUEST['code'];
}
if(isset($_REQUEST['planName'])) {
	$planName = $_REQUEST['planName'];
}
if(isset($_REQUEST['risk'])) {
	$risk = $_REQUEST['risk'];
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
if(isset($_REQUEST['IDobj'])) {
	$IDobj = $_REQUEST['IDobj'];
}
if(isset($_REQUEST['objDtl'])) {
	$objDtl = $_REQUEST['objDtl'];
}
if(isset($_REQUEST['IDrtg'])) {
	$IDrtg = $_REQUEST['IDrtg'];
}
if(isset($_REQUEST['rtgDetail'])) {
	$rtgDetail = $_REQUEST['rtgDetail'];
}
if(isset($_REQUEST['statusValue1'])) {
	$statusValue1 = $_REQUEST['statusValue1'];
}
if(isset($_REQUEST['statusValue2'])) {
	$statusValue2 = $_REQUEST['statusValue2'];
}
if(isset($_REQUEST['targetValue1'])) {
	$targetValue1 = $_REQUEST['targetValue1'];
}
if(isset($_REQUEST['targetValue2'])) {
	$targetValue2 = $_REQUEST['targetValue2'];
}

if($code == ''){
	date_default_timezone_set("Asia/Bangkok");
	$day 	= date('d');
	$month 	= date('m');
	$year 	= date('Y');

	$sql = "INSERT INTO plan VALUES(NULL,
								'$planName',
								'$risk',
								'$rationale',
								'$target',
								'$accept_risk',
								'$deviation_accept_risk',
								'$IDtype',
								'$statusValue1',
								'$statusValue2',
								'$targetValue1',
								'$targetValue2',
								'$criteriaDetail',
								'$criteriaValue',
								'$criteriaUnit',
								'$time',
								'$IDstrategy',
								'$day',
								'$month',
								'$year' )";
	$result = mysql_query($sql, $dbConn);

	if(!$result) {
		?>
		<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มข้อมูลแผนงานได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
		<?
		exit();
	}

	// Get plan id
	$sql = "SELECT MAX(IDplan) IDplan FROM plan";
	$result = mysql_query($sql, $dbConn);
	$rows = mysql_num_rows($result);
	if($rows > 0) {
		$tmpRow = mysql_fetch_assoc($result);
		$IDplan = $tmpRow['IDplan'];
	} else {
		$IDplan = 1;
	}

	//Insert risk_factor
	foreach ($riskfacName as $key => $name) {
		$sql = "INSERT INTO risk_factor VALUES(NULL, '$name', $IDplan)";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มข้อมูลปัจจัยเสี่ยง "<?=$name?>" ได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล<br>
			<?
			exit();
		}
	}

	//Insert objective
	foreach ($riskfacName as $key => $name) {
		$sql = "INSERT INTO objective VALUES(NULL, $IDplan, '$name')";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มวัตถุประสงค์ "<?=$name?>" ได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล<br>
			<?
			exit();
		}
	}

	//Insert results_to_get
	foreach ($rtgDetail as $key => $name) {
		$sql = "INSERT INTO results_to_get VALUES(NULL, $IDplan, '$name')";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถเพิ่มผลคาดว่าที่จะได้รับ "<?=$name?>" ได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล<br>
			<?
			exit();
		}
	}
	?>
	<script>window.location.href='show_plan.php'</script>
	<?
} else {
	if($action == 'DELETE') {
		//Delete risk_factor
		$sql = "DELETE FROM risk_factor WHERE IDplan = '$code'";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลปัจจัยเสี่ยงได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล<br>
			<?
			exit();
		}

		//Delete objective
		$sql = "DELETE FROM objective WHERE IDplan = '$code'";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลวัตถุประสงค์ได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล<br>
			<?
			exit();
		}

		//Delete results_to_get
		$sql = "DELETE FROM results_to_get WHERE IDplan = '$code'";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลวผลคาดว่าที่จะได้รับได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล<br>
			<?
			exit();
		}

		// Delete plan
		$sql = "DELETE FROM plan WHERE IDplan = '$code'";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลแผนงานได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล<br>
			<?
			exit();
		}
		?>
		<script>window.location.href='show_plan.php'</script>
		<?
	} else {
		$sql = "UPDATE plan SET planName 				= '$planName',
								risk 					= '$risk',
								rationale 				= '$rationale',
								target 					= '$target',
								accept_risk 			= '$accept_risk',
								deviation_accept_risk 	= '$deviation_accept_risk',
								IDtype 					= '$IDtype',
								statusValue1 			= '$statusValue1',
								statusValue2 			= '$statusValue2',
								targetValue1 			= '$targetValue1',
								targetValue2 			= '$targetValue2',
								criteriaDetail 			= '$criteriaDetail',
								criteriaValue 			= '$criteriaValue',
								criteriaUnit 			= '$criteriaUnit',
								time 					= '$time',
								IDstrategy 				= '$IDstrategy',
								d_insert 				= '$day',
								m_insert 				= '$m_insert',
								y_insert 				= '$y_insert' 
							WHERE IDplan = '$code'";
		$result = mysql_query($sql, $dbConn);
		if(!$result) {
			?>
			<b>เกิดข้อผิดพลาด!</b> ไม่สามารถแก้ไขข้อมูลได้ คลิก <a href="show_plan.php">ย้อนกลับ</a> เพื่อกลับไปหน้าดูข้อมูล
			<?
		}

		// Delete risk_factor if delete old risk_factor
		$oldRskFacList = array();
		$newRskFacList = array();
		// Find old risk_factor
		$sql = "SELECT IDriskfac FROM risk_factor WHERE IDplan = '$code'";
		$result = mysql_query($sql, $dbConn);
		$rows 	= mysql_num_rows($result);
		for($i=0; $i<$rows; $i++) {
			$oldRskFacRecord = mysql_fetch_assoc($result);
			array_push($oldRskFacList, $oldRskFacRecord['IDriskfac']);
		}
		// Find new risk_factor
		foreach ($IDriskfac as $key => $newRskFac_id) {
			array_push($newRskFacList, $newRskFac_id);
		}
		// Check for delete 
		foreach ($oldRskFacList as $key => $oldRskFac_id) {
			if(!in_array($oldRskFac_id, $newRskFacList)) {
				// Delete risk_factor
				$sql = "DELETE FROM risk_factor WHERE IDriskfac = '$oldRskFac_id'";
				$result = mysql_query($sql, $dbConn);
				if(!$result) {
					?>
					<b>เกิดข้อผิดพลาด!</b> ไม่สามารถลบข้อมูลปัจจัยเสี่ยงรหัส <?=$oldRskFac_id?>ได้
					<?
				}
			}
		}
		// Update or Add risk_factor
		$updatePkgsvlResult = true;
		$updatePkgsvlError  = '';

		foreach ($riskfacName as $key => $rskFac_name) {
			if(isset($IDriskfac[$key])) {
				// Update package_service_lists
				$pkgsvl_id 		= $formData['pkgsvl_id'][$key];
				$pkgsvlRecord 	= new TableSpa('package_service_lists', $pkgsvl_id);
				$pkgsvlRecord->setFieldValue('rskFac_name', $rskFac_name);
				if(!$pkgsvlRecord->commit()) {
					$updatePkgsvlResult = false;
					$updatePkgsvlError .= 'EDIT_PAKAGE_SERVICE_LISTS['.($key+1).']_FAIL\n';
				}
			} else {
				// Add new package_service_lists
				$pkgsvlValues 	= array($rskFac_name, $code);
				$pkgsvlRecord 	= new TableSpa('package_service_lists', $pkgsvlValues);
				if(!$pkgsvlRecord->insertSuccess()) {
					$updatePkgsvlResult = false;
					$updatePkgsvlError .= 'ADD_PAKAGE_SERVICE_LISTS['.($key+1).']_FAIL\n';
				}
			}
		}


		?>
		<script>window.location.href='show_plan.php'</script>
		<?
	}
	
}
?>