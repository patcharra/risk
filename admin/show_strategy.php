<?
require('../common/common_header.php');
$sql = "SELECT 	IDstrategy,
				strategyName 
		FROM 	strategy";
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
<h3>กลยุทธ์</h3>
<a href="form_strategy.php" class="btn">
	<button class="myButton">เพิ่มกลยุทธ์</button>
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
				<th>ชื่อกลยุทธ์</th>
			</tr>
		</thead>
		<tbody>
		<?
		for($i=0; $i<$rows; $i++) {
			$strategyRow = mysql_fetch_assoc($result);
			$no 	 	 = $i+1;
			$IDstrategy 	 = $strategyRow['IDstrategy'];
			$strategyName = $strategyRow['strategyName'];
			?>
			<tr>
				<td class="action-col">
					<a href="form_strategy.php?code=<?=$IDstrategy?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_strategy.php?code=<?=$IDstrategy?>&action=DELETE" onClick="return confirm('คุณต้องการลบกลยุทธ์ <?=$strategyName?> ใช่หรือไม่?')">
						<button>ลบ</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td><?=$strategyName?></td>
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