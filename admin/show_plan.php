<?php
require('../common/common_header.php');
$sql = "SELECT 	IDplan,
				planName,
				time,
				time_year 
		FROM 	plan";
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
<h3>แผนงาน</h3>
<a href="form_plan.php" class="btn">
	<button class="myButton">เพิ่มแผนงาน</button>
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
				<th>ชื่อแผนงาน</th>
				<th>ระยะเวลาดำเนินการ</th>
			</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $i<$rows; $i++) {
			$plnRow 	 = mysql_fetch_assoc($result);
			$no 	 	 = $i+1;
			$IDplan 	 = $plnRow['IDplan'];
			$planName 	 = $plnRow['planName'];
			?>
			<tr>
				<td class="action-col" style="width:200px;">
					<a href="form_plan.php?code=<?=$IDplan?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_plan.php?code=<?=$IDplan?>&action=DELETE" onClick="return confirm('คุณต้องการลบแผนงาน <?=$planName?> ใช่หรือไม่? ข้อมูลทั้งหมดที่เกี่ยวข้องกับแผนงานนี้จะถูกลบทั้งหมด')">
						<button>ลบ</button>
					</a>
					<a href="plan_view_detail.php?IDplan=<?=$IDplan?>" target="_blank">
						<button>ดูรายละเอียด</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td><?=$planName?></td>
				<td><?=$plnRow['time']?> <?=$plnRow['time_year']?></td>
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