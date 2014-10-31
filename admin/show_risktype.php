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
<button>เพิ่มประเภทความเสี่ยง</button>
<br><br>
<?
if($rows > 0) {
	?>
	<table class="table-data">
		<thead>
			<tr>
				<th class="action-col"></th>
				<th>รหัสประเภทความเสี่ยง</th>
				<th>ชื่อประเภทความเสี่ยง</th>
			</tr>
		</thead>
		<tbody>
		<?
		for($i=0; $i<$rows; $i++) {
			$rsktypRow 	 = mysql_fetch_assoc($result);
			$rsktyp_id 	 = $rsktypRow['IDtype'];
			$rsktyp_name = $rsktypRow['typeName'];
			?>
			<tr>
				<td class="action-col">
					<a href="form_risktype.php?code=<?=$rsktyp_id?>">
						<button>แก้ไข</button>
					</a>
					<button>ลบ</button>
				</td>
				<td align="center"><?=$rsktyp_id?></td>
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
	ไม่พบข้อมูล
	<?
}
?>
</body>
</html>