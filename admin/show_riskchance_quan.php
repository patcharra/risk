<?
require('../common/common_header.php');
$sql = "SELECT 	r.IDrcq,
				r.detail,
				r.level,
				l.mean levelMean,
				r.quantity,
				r.quantitymin,
				r.quantitymax,
				p.planName,
				u.unitName 
		FROM 	riskchance_quan r, plan p, unit u, level_and_meano l 
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
<h3>โอกาสเกิดความเสี่ยงเชิงปริมาณ</h3>
<a href="form_riskchance_quan.php" class="btn">
	<button class="myButton">เพิ่มโอกาสเกิดความเสี่ยงเชิงปริมาณ</button>
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
				<th>โอกาสเกิดความเสี่ยงเชิงปริมาณ</th>
				<th>ระดับ</th>
				<th>แผนงาน</th>
			</tr>
		</thead>
		<tbody>
		<?
		for($i=0; $i<$rows; $i++) {
			$rskchcQuanRow 	 	= mysql_fetch_assoc($result);
			$no 	 	 		= $i+1;
			$rskchcQuan_id 	 	= $rskchcQuanRow['IDrcq'];
			$detail 			= $rskchcQuanRow['detail'];
			$detail				= str_replace('%u', $rskchcQuanRow['unitName'], $detail);
			$detail				= str_replace('%v', $rskchcQuanRow['quantity'], $detail);
			$detail				= str_replace('%vmin', $rskchcQuanRow['quantitymin'], $detail);
			$detail				= str_replace('%vmax', $rskchcQuanRow['quantitymax'], $detail);
			?>
			<tr>
				<td class="action-col">
					<a href="form_riskchance_quan.php?code=<?=$rskchcQuan_id?>" >
						<button>แก้ไข</button>
					</a>
					<a href="manage_riskchance_quan.php?code=<?=$rskchcQuan_id?>&action=DELETE" onClick="return confirm('คุณต้องการลบประเภทความเสี่ยง <?=$rsktyp_name?> ใช่หรือไม่?')">
						<button>ลบ</button>
					</a>
				</td>
				<td align="center"><?=$no?></td>
				<td><?=$detail?></td>
				<td><? echo $rskchcQuanRow['level'].' ('.$rskchcQuanRow['levelMean'].')'; ?></td>
				<td><?=$rskchcQuanRow['planName']?></td>
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