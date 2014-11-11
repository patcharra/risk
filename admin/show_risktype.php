<?
require('../common/common_header.php');
$sql = "SELECT 	IDtype,
				typeName 
		FROM 	risktype";
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
<h3>ประเภทความเสี่ยง</h3>
<a href="form_risktype.php" class="btn">
	<button class="myButton">เพิ่มประเภทความเสี่ยง</button>
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
				<th>ชื่อประเภทความเสี่ยง</th>
			</tr>
		</thead>
		<tbody>
		<?
		for($i=0; $i<$rows; $i++) {
			$rsktypRow 	 = mysql_fetch_assoc($result);
			$no 	 	 = $i+1;
			$rsktyp_id 	 = $rsktypRow['IDtype'];
			$rsktyp_name = $rsktypRow['typeName'];
			?>
			<tr>
				<td class="action-col">
					<a href="form_risktype.php?code=<?=$rsktyp_id?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_risktype.php?code=<?=$rsktyp_id?>&action=DELETE" onClick="return confirm('คุณต้องการลบประเภทความเสี่ยง <?=$rsktyp_name?> ใช่หรือไม่?')">
						<button>ลบ</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td><?=$rsktyp_name?></td>
			</tr>
			<?
		}
		?>
		</tbody>
	</table>
	<?
} else {
	?>
	<font color="red">
		<i>ไม่พบข้อมูล</i>
	</font>
	<?
}
?>
</body>
</html>