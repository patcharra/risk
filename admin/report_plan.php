<?php
require('../common/common_header.php');
$code = '';
if(isset($_POST['IDplan'])) {
	$code = $_POST['IDplan'];
}

// Get plan data
$sql = "SELECT 	p.*,
				t.typeName,
				s.strategyName 
		FROM 	plan p, risktype t, strategy s 
		WHERE 	p.IDtype = t.IDtype AND p.IDstrategy = s.IDstrategy 
				AND p.IDplan = '$code'";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$planRow = mysql_fetch_assoc($result);
}

// Get risk_factor data
$sql = "SELECT riskfacName FROM risk_factor WHERE IDplan ='$code'";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$riskFactorList = array();
	for($i=0; $i<$rows; $i++) {
		array_push($riskFactorList, mysql_fetch_assoc($result));
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
	$riskchanceList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);

		if($planRow['riskchance_type'] == 'quan') {
			$tmpRow['detail'] = str_replace('%u', $tmpRow['unitName'], $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%v', $tmpRow['quantity'], $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%vmin', $tmpRow['quantitymin'], $tmpRow['detail']);
			$tmpRow['detail'] = str_replace('%vmax', $tmpRow['quantitymax'], $tmpRow['detail']);
		}

		$tableOandP[$tmpRow['levelO']]['riskchance'] = array(
			'levelO' 		=> $tmpRow['levelO'],
			'mean' 	 		=> $tmpRow['mean'],
			'detail' 		=> $tmpRow['detail']
		);
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
			<td colspan="2">
				<table style="float:left;" class="tableOandP">
					<thead>
						<tr>
							<th align="center" colspan="3">โอกาสเกิดความเสี่ยง</th>
							<th class="break-table"></th>
							<th align="center" colspan="3">ผลกระทบต่อองค์กร</th>
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
</body>
</html>