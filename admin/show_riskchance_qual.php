<?php
require('../common/common_header.php');
$sql = "SELECT 	r.IDrcl,
				r.detail,
				r.level,
				l.mean levelMean,
				p.planName,
				u.unitName 
		FROM 	riskchance_qual r, plan p, unit u, level_and_meano l 
		WHERE 	r.IDplan = p.IDplan AND p.IDunit_riskchance = u.IDunit AND r.level = l.levelO";
$result = mysql_query($sql, $dbConn);
$rows	= mysql_num_rows($result);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/risk_main.css">
</head>
<body>
<h3>โอกาสเกิดความเสี่ยงเชิงคุณภาพ</h3>
<a href="form_riskchance_qual.php" class="btn">
	<button class="myButton">เพิ่มโอกาสเกิดความเสี่ยงเชิงคุณภาพ</button>
</a>
<br><br>
<?php
if($rows > 0) {
	?>
	<table class="table-data" style="width: 100%;">
		<thead>
			<tr>
				<th class="action-col"></th>
				<th>ลำดับ</th>
				<th width="350px">รายละเอียด</th>
				<th width="120px">ระดับ</th>
				<th>แผนงาน</th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $i<$rows; $i++) {
			$rskchcQualRow 	 	= mysql_fetch_assoc($result);
			$no 	 	 		= $i+1;
			$rskchcQual_id 	 	= $rskchcQualRow['IDrcl'];
			$detail 			= $rskchcQualRow['detail'];
			?>
			<tr>
				<td class="action-col">
					<a href="form_riskchance_qual.php?code=<?=$rskchcQual_id?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_riskchance_qual.php?code=<?=$rskchcQual_id?>&action=DELETE" onClick="return confirm('คุณต้องการลบโอกาสเกิดความเสี่ยงเชิงคุณภาพ <?=$detail?> ใช่หรือไม่?')">
						<button>ลบ</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td width="350px"><?=$detail?></td>
				<td width="120px"><?php echo $rskchcQualRow['level'].' ('.$rskchcQualRow['levelMean'].')'; ?></td>
				<td><?=$rskchcQualRow['planName']?></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
	<?php
} else {
	?>
	<font color="red">
		<i>ไม่พบข้อมูล</i>
	</font>
	<?php
}
?>
</body>
</html>