<?
require('../common/common_header.php');
$sql = "SELECT 	IDplan,
				planName,
				time 
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
<?
if($rows > 0) {
	?>
	<table class="table-data">
		<thead>
			<tr>
				<th class="action-col"></th>
				<th>ลำดับ</th>
				<th>ชื่อแผนงาน</th>
				<th>ระยะเวลาดำเนินการ</th>
			</tr>
		</thead>
		<tbody>
		<?
		for($i=0; $i<$rows; $i++) {
			$plnRow 	 = mysql_fetch_assoc($result);
			$no 	 	 = $i+1;
			$IDplan 	 = $plnRow['IDplan'];
			$planName 	 = $plnRow['planName'];
			$time 		 = $plnRow['time'];
			?>
			<tr>
				<td class="action-col">
					<a href="form_plan.php?code=<?=$IDplan?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_plan.php?code=<?=$IDplan?>&action=DELETE" onClick="return confirm('คุณต้องการลบแผนงาน <?=$planName?> ใช่หรือไม่?')">
						<button>ลบ</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td><?=$planName?></td>
				<td><?=$time?></td>
			</tr>
			<?
		}
		?>
		</tbody>
	</table>
	<?
} else {
	?>
	ไม่พบข้อมูล
	<?
}
?>
</body>
</html>