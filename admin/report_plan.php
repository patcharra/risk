<?php
/*$strWordFileName = "Word ไฟล์ง่ายนิดเดียว.doc";
header("Content-Type: application/vnd.ms-word; name=\"$strWordFileName\"");
header("Content-Disposition: inline; filename=\"$strWordFileName\"");
header("Pragma: no-cache");*/

require('../common/common_header.php');
$code = '';
if(isset($_POST['IDplan'])) {
	$code = $_POST['IDplan'];
}

// Get plan data
$sql = "SELECT 	p.*,
				t.typeName,
				s.strategyName,
				u.unitName 
		FROM 	plan p, risktype t, strategy s, unit u 
		WHERE 	p.IDtype = t.IDtype AND p.IDstrategy = s.IDstrategy 
				AND p.criteriaUnit = u.IDunit 
				AND p.IDplan = '$code'";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$planRow = mysql_fetch_assoc($result);
	$planRow['criteriaDetail'] = str_replace('%u', $planRow['unitName'], $planRow['criteriaDetail']);
	$planRow['criteriaDetail'] = str_replace('%v', number_format($planRow['criteriaValue']), $planRow['criteriaDetail']);
}

// Get risk_factor data
$sql = "SELECT riskfacName FROM risk_factor WHERE IDplan ='$code' ORDER BY IDriskfac";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$riskFactorList = array();
	for($i=0; $i<$rows; $i++) {
		array_push($riskFactorList, mysql_fetch_assoc($result));
	}
}

// Get results_to_get data
$sql = "SELECT rtgDetail FROM results_to_get WHERE IDplan ='$code' ORDER BY IDrtg";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$rtgList = array();
	for($i=0; $i<$rows; $i++) {
		array_push($rtgList, mysql_fetch_assoc($result));
	}
}

$tableOandP = array();

// Get risk_chance data
if($planRow['riskchance_type'] == 'quan') {
	$sql ="SELECT 		l.levelO,
						l.mean,
						r.detail,
						r.quantity,
						r.quantitymin,
						r.quantitymax,
						u.unitName 
			FROM 		riskchance_quan r, plan p, unit u, level_and_meano l 
			WHERE 		r.IDplan = p.IDplan AND r.level = l.levelO 
						AND p.IDunit_riskchance = u.IDunit 
			ORDER BY 	l.levelO DESC";
} else {
	$sql ="SELECT 		l.levelO,
						l.mean,
						r.detail 
			FROM 		riskchance_qual r, plan p, level_and_meano l 
			WHERE 		r.IDplan = p.IDplan AND r.level = l.levelO 
			ORDER BY 	l.levelO DESC";
}
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);

		if($planRow['riskchance_type'] == 'quan') {
			$tmpRow['detail'] = str_replace('%u', $tmpRow['unitName'], $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%v', number_format($tmpRow['quantity']), $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%vmin', number_format($tmpRow['quantitymin']), $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%vmax', number_format($tmpRow['quantitymax']), $tmpRow['detail']);
		}

		$tableOandP[$tmpRow['levelO']]['riskchance'] = array(
			'level' 		=> $tmpRow['levelO'],
			'mean' 	 		=> $tmpRow['mean'],
			'detail' 		=> $tmpRow['detail']
		);
	}
}

// Get impact data
if($planRow['impact_type'] == 'quan') {
	$sql ="SELECT 		l.levelP,
						l.mean,
						i.detail,
						i.quantity,
						i.quantitymin,
						i.quantitymax,
						u.unitName 
			FROM 		impact_quan i, plan p, unit u, level_and_meanp l 
			WHERE 		i.IDplan = p.IDplan AND i.level = l.levelP 
						AND p.IDunit_impact = u.IDunit 
			ORDER BY 	l.levelP DESC";
} else {
	$sql ="SELECT 		l.levelP,
						l.mean,
						i.detail 
			FROM 		impact_qual i, plan p, level_and_meanp l 
			WHERE 		i.IDplan = p.IDplan AND i.level = l.levelP 
			ORDER BY 	l.levelP DESC";
}
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);

		if($planRow['impact_type'] == 'quan') {
			$tmpRow['detail'] = str_replace('%u', $tmpRow['unitName'], $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%v', number_format($tmpRow['quantity']), $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%vmin', number_format($tmpRow['quantitymin']), $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%vmax', number_format($tmpRow['quantitymax']), $tmpRow['detail']);
		}

		$tableOandP[$tmpRow['levelP']]['impact'] = array(
			'level' 		=> $tmpRow['levelP'],
			'mean' 	 		=> $tmpRow['mean'],
			'detail' 		=> $tmpRow['detail']
		);
	}
}

// Get assignment data
$sql = "SELECT 		ag.agenName 
		FROM 		plan p, risk_manage_plan r, assignment am, agency ag 
		WHERE 		p.IDplan = r.IDplan AND r.IDrmp = am.IDrmp AND am.IDagen = ag.IDagen 
					AND p.IDplan = '$code'";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$agencyList = array();
	for($i=0; $i<$rows; $i++) {
		array_push($agencyList, mysql_fetch_assoc($result));
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		.stat-star-black {
			display: block;
			position: absolute;
			top: 0;
			left: 400px;
			height: 25px;
			margin-top: -2.5px;
		}
		.stat-star-white {
			display: block;
			position: absolute;
			top: 0;
			left: 110px;
			height: 25px;
			margin-top: -2.5px;
		}
		.tableOandP {
			border-collapse: collapse;
			width: 100%;
			margin-top: 30px;
		}
		.tableOandP td, .tableOandP th{
			border: 1px solid #000;
			padding: 5px;
		}
		.tableOandP td {
			vertical-align: top;
			text-align: left;
		}
		.tableOandP .break-table {
			border: none;
			width: 20px;
		}
	</style>
</head>
<body>
<table style="width: 100%;">
	<tbody>
		<tr>
			<td><b><font style="font-size:18px;">แผนงาน</font></b></td>
			<td><b><font style="font-size:18px;"><?=$planRow['planName']?></font></b></td>
		</tr>
		<tr>
			<td><b>กลยุทธ์</b></td>
			<td><?=$planRow['strategyName']?></td>
		</tr>
		<tr>
			<td style="padding-top:30px;white-space: nowrap;"><b>ประเภทความเสี่ยง</b></td>
			<td style="padding-top:30px;"><?=$planRow['typeName']?></td>
		</tr>
		<tr>
			<td><b>ความเสี่ยง</b></td>
			<td><?=$planRow['risk']?></td>
		</tr>
		<?php
		foreach ($riskFactorList as $key => $rf) {
			if($key == 0) {
				?>
				<tr>
					<td><b>ปัจจัยเสี่ยง</b></td>
					<td>- <?=$rf['riskfacName']?></td>
				</tr>
				<?php
			} else {
				?>
				<tr>
					<td></td>
					<td>- <?=$rf['riskfacName']?></td>
				</tr>
				<?php
			}
		}
		?>
		<tr>
			<td colspan="2" align="center" style="padding-top:30px;"><b><u>การประเมินความเสี่ยง</u></b></td>
		</tr>
		<tr>
			<td><b>สถานะปัจจุบัน</b></td>
			<td style="position:relative;">
				<?=$planRow['statusValue1']?> x <?=$planRow['statusValue2']?> = 
				<?php echo $planRow['statusValue1']*$planRow['statusValue2'];?>
				&nbsp;&nbsp;&nbsp;&nbsp;(โอกาสเกิด x ผลกระทบ = ผลลัพธ์) 
				<img src="../img/star-white.png" class="stat-star-black">
			</td>
		</tr>
		<tr>
			<td><b>เป้าหมาย</b></td>
			<td style="position:relative;">
				<?=$planRow['targetValue1']?> x <?=$planRow['targetValue2']?> = 
				<?php echo $planRow['targetValue1']*$planRow['targetValue2'];?> 
				<img src="../img/star-white.png" class="stat-star-white">
			</td>
		</tr>
		<tr>
			<td><b>เกณฑ์วัด</b></td>
			<td><?=$planRow['criteriaDetail']?></td>
		</tr>
		<tr>
			<td colspan="2">
				<table  class="tableOandP">
					<thead>
						<tr>
							<th align="center" colspan="3" height="30px">โอกาสเกิดความเสี่ยง</th>
							<th class="break-table" height="30px"></th>
							<th align="center" colspan="3" height="30px">ผลกระทบต่อองค์กร</th>
						</tr>
						<tr>
							<th align="center">ระดับ</th>
							<th align="center">ความหมาย</th>
							<th align="center" width="300px;">รายละเอียด</th>
							<th class="break-table"></th>
							<th align="center">ระดับ</th>
							<th align="center">ความหมาย</th>
							<th align="center" width="300px;">รายละเอียด</th>
						</tr>
					</thead>
					<tbody>
					<?php
					for ($i=count($tableOandP); $i>0; $i--) {
						?>
						<tr>
							<td align="center"><?=$i?></td>
							<td align="center"><?=$tableOandP[$i]['riskchance']['mean']?></td>
							<td align="center" width="300px;"><?=$tableOandP[$i]['riskchance']['detail']?></td>
							<td class="break-table"></td>
							<td align="center"><?=$i?></td>
							<td align="center"><?=$tableOandP[$i]['impact']['mean']?></td>
							<td align="center" width="300px;"><?=$tableOandP[$i]['impact']['detail']?></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<br><br>
<b>1. หลักการและเหตุผล</b>
<p style="margin-top:0;">&emsp;&emsp;&emsp;&emsp;&emsp;<?=$planRow['rationale']?></p>
<br>

<b>2. วัตถุประสงค์</b>
<p style="margin-top:0;">&emsp;&emsp;&emsp;&emsp;&emsp;<?=$planRow['rationale']?></p>
<br>

<b>3. เป้าหมาย</b>
<p style="margin-top:0;">&emsp;&emsp;&emsp;&emsp;&emsp;<?=$planRow['target']?></p>
<br>

<b>4. ความเสี่ยงที่ยอมรับได้</b>
<p style="margin-top:0;">&emsp;&emsp;&emsp;&emsp;&emsp;<?=$planRow['accept_risk']?></p>
<br>

<b>5. ช่วงเบี่ยงเบนความเสี่ยงที่ยอมรับได้</b>
<p style="margin-top:0;">&emsp;&emsp;&emsp;&emsp;&emsp;<?=$planRow['deviation_accept_risk']?></p>
<br>

<b>6. ระยะเวลาดำเนินการ</b>
<p style="margin-top:0;">&emsp;&emsp;&emsp;&emsp;&emsp;<b><?=$planRow['time']?> <?=$planRow['time_year']?></b></p>
<br>

<b>7. ผู้รับผิดชอบ</b>
<ul style="margin-top:0;">
<?php
foreach ($agencyList as $key => $agen) {
	?>
	<li type="square"><?=$agen['agenName']?></li>
	<?php
}
?>
</ul>

<b>8. แผนปฏิบัติการ<?=$planRow['planName']?></b>
<br>

<b>9. ผลคาดว่าที่จะได้รับ</b><br>
<?php
foreach ($rtgList as $key => $value) {
	?>
	&emsp;&emsp;&emsp;&emsp;&emsp;- <?=$value['rtgDetail']?><br>
	<?php
}
?>
</body>
</html>