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
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table>
	<tbody>
		<tr>
			<td><b><font style="font-size:18px;">แผนงานที่ ?</font></b></td>
			<td><b><font style="font-size:18px;"><?=$planRow['planName']?></font></b></td>
		</tr>
		<tr>
			<td><b>กลยุทธ์</b></td>
			<td><?=$planRow['strategyName']?></td>
		</tr>
		<tr>
			<td style="padding-top:30px;"><b>ประเภทความเสี่ยง</b></td>
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
			<td>
				<?=$planRow['statusValue1']?> x <?=$planRow['statusValue2']?> = 
				<?php echo $planRow['statusValue1']*$planRow['statusValue2'];?>
				&nbsp;&nbsp;&nbsp;&nbsp;(โอกาสเกิด x ผลกระทบ = ผลลัพธ์)
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>