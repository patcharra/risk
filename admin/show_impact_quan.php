<?php
require('../common/common_header.php');
$sql = "SELECT 	i.IDimQn,
				i.detail,
				i.level,
				l.mean levelMean,
				i.quantity,
				i.quantitymin,
				i.quantitymax,
				p.planName,
				u.unitName 
		FROM 	impact_quan i, plan p, unit u, level_and_meanp l 
		WHERE 	i.IDplan = p.IDplan AND p.IDunit_impact = u.IDunit AND i.level = l.levelP";
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
<h3>ผลกระทบต่อองค์กรเชิงปริมาณ</h3>
<a href="form_impact_quan.php" class="btn">
	<button class="myButton">เพิ่มผลกระทบต่อองค์กรเชิงปริมาณ</button>
</a>
<br><br>
<?php
if($rows > 0) {
	?>
	<table class="table-data">
		<thead>
			<tr>
				<th class="action-col"></th>
				<th>ลำดับ</th>
				<th>ผลกระทบต่อองค์กรเชิงปริมาณ</th>
				<th>ระดับ</th>
				<th>แผนงาน</th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $i<$rows; $i++) {
			$impQuanRow 	 	= mysql_fetch_assoc($result);
			$no 	 	 		= $i+1;
			$impQuan_id 	 	= $impQuanRow['IDimQn'];
			$detail 			= $impQuanRow['detail'];
			$detail				= str_replace('%u', $impQuanRow['unitName'], $detail);
			$detail				= str_replace('%v', $impQuanRow['quantity'], $detail);
			$detail				= str_replace('%vmin', $impQuanRow['quantitymin'], $detail);
			$detail				= str_replace('%vmax', $impQuanRow['quantitymax'], $detail);
			?>
			<tr>
				<td class="action-col">
					<a href="form_impact_quan.php?code=<?=$impQuan_id?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_impact_quan.php?code=<?=$impQuan_id?>&action=DELETE" onClick="return confirm('คุณต้องการลบผลกระทบต่อองค์กรเชิงปริมาณ <?=$detail?> ใช่หรือไม่?')">
						<button>ลบ</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td><?=$detail?></td>
				<td><?php echo $impQuanRow['level'].' ('.$impQuanRow['levelMean'].')'; ?></td>
				<td><?=$impQuanRow['planName']?></td>
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