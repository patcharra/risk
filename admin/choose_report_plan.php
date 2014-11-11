<?php
require('../common/common_header.php');

// Get paln
$sql = "SELECT IDplan, planName, time_year FROM plan ORDER BY time_year desc";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$planList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$planList[$tmpRow['IDplan']] = $tmpRow['planName']." (".$tmpRow['time_year'].")";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../inc/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/risk_main.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/form_table.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		
	});
	</script>
</head>
<body>
<h3>ออกรายงานแผนงาน</h3>
<?php
if($rows > 0) {
?>
<form id="form-table" name="form-table" action="report_plan.php" method="post">
	<table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
		    <tr>
		    	<td>
		    		<label class="input-required">แผนงาน</label>
				    <select id="IDplan" name="IDplan" class="form-input full">
				    	<?
				    	foreach ($planList as $id => $name) {
				    			?>
					    		<option value="<?=$id?>"><?=$name?></option>
					    		<?php
				    	}
				    	?>
				    </select>
		    	</td>
		    </tr>
	   </tbody>
   </table>
   <button id="addBtn" type="button" class="myButton" style="margin-right:10px;">ออกรายงาน</button>
</form>
<?php
} else {
	?>
	<font color="red">ยังไม่มีแผนงานในระบบ กรุณาเพิ่มแผนงานเพื่อใช้ในการออกรายงาน</font>
	<?php
}
?>
</body>
</html>