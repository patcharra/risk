<?php
require('../common/common_header.php');
$sql = "SELECT 	i.IDimQl,
				i.detail,
				i.level,
				l.mean levelMean,
				p.planName 
		FROM 	impact_qual i, plan p, level_and_meanp l 
		WHERE 	i.IDplan = p.IDplan AND i.level = l.levelP";
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
<h3>ผลกระทบต่อองค์กรเชิงคุณภาพ</h3>
<a href="form_impact_qual.php" class="btn">
	<button class="myButton">เพิ่มผลกระทบต่อองค์กรเชิงคุณภาพ</button>
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
			$impQualRow 	 	= mysql_fetch_assoc($result);
			$no 	 	 		= $i+1;
			$impQual_id 	 	= $impQualRow['IDimQl'];
			$detail 			= $impQualRow['detail'];
			$detail				= str_replace('%u', $impQualRow['unitName'], $detail);
			?>
			<tr>
				<td class="action-col">
					<a href="form_impact_qual.php?code=<?=$impQual_id?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_impact_qual.php?code=<?=$impQual_id?>&action=DELETE" onClick="return confirm('คุณต้องการลบผลกระทบต่อองค์กรเชิงคุณภาพ <?=$detail?> ใช่หรือไม่?')">
						<button>ลบ</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td width="350px"><?=$detail?></td>
				<td width="120px"><?php echo $impQualRow['level'].' ('.$impQualRow['levelMean'].')'; ?></td>
				<td><?=$impQualRow['planName']?></td>
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