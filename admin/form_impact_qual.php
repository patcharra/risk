<?php
require('../common/common_header.php');
$code = '';
if(isset($_REQUEST['code'])) {
	// Edit data will select
	$title	= 'แก้ไขข้อมูลผลกระทบต่อองค์กรเชิงคุณภาพ';

	$code 	= $_REQUEST['code'];
	$sql 	= "SELECT 	i.*,
						u.unitName 
				FROM 	impact_qual i, plan p, unit u  
				WHERE 	i.IDplan = p.IDplan AND p.IDunit_impact = u.IDunit 
						AND i.IDimQl = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	if($rows > 0) {
		$impRow = mysql_fetch_assoc($result);
	}
} else {
	$title		= 'เพิ่มข้อมูลผลกระทบต่อองค์กรเชิงคุณภาพ';
}

// find plan
date_default_timezone_set("Asia/Bangkok");
$year 	= (int)date('Y')+543;
$sql = "SELECT IDplan, planName FROM plan where y_insert = '$year' AND impact_type = 'qual'";
$result = mysql_query($sql, $dbConn);
$rowsPlan = mysql_num_rows($result);
if($rowsPlan > 0) {
	$planList = array();
	for($i=0; $i<$rowsPlan; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$planList[$tmpRow['IDplan']] = $tmpRow['planName'];
	}
}

// find level
$sql = "SELECT levelP, mean FROM level_and_meanp";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$levelList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$levelList[$tmpRow['levelP']] = $tmpRow['levelP'].' ('.$tmpRow['mean'].')';
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
		$('input[name="quantype"]').click(function(){
		$('#IDplan').change(function(){
			getUnitName($('#IDplan').val());
		});

		getUnitName($('#IDplan').val());
	});

	function getUnitName(planID) {
		$.ajax({
			url: '../common/ajaxGetUnitNameOfPlan.php',
			type: 'POST',
			data: {
				planID: planID,
				field: 'IDunit_impact'
			},
			success:
			function(response) {
				$('.unitName').text(response);
			}
		})
	}
	</script>
</head>
<body>
<h3><?=$title?></h3>
<?php
if($rowsPlan <= 0) {
	?>
	<font color="red">ไม่พบแผนงานที่มีประเภทผลกระทบต่อองค์กรแบบเชิงคุณภาพ</font><br><br>
	<a href="show_impact_qual.php">ย้อนกลับ</a>
	<?php
} else {
?>
<form id="form-table" name="form-table" action="manage_impact_qual.php">
	<input type="hidden" name="code" value="<?=$code?>">
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
	    	<tr>
			    <td colspan="2">
				    <label class="input-required">แผนงาน</label>
				    <select id="IDplan" name="IDplan" class="form-input full">
				    	<?php
				    	foreach ($planList as $id => $name) {
				    		if($id == $impRow['IDplan']) {
				    			?>
					    		<option value="<?=$id?>" selected><?=$name?></option>
					    		<?php
				    		}  else {
				    			?>
					    		<option value="<?=$id?>"><?=$name?></option>
					    		<?php
				    		}
				    	}
				    	?>
				    </select>
			    </td>
		    </tr>
		    <tr>
			    <td colspan="2">
				    <label class="input-required">ระดับ</label>
				    <select id="level" name="level" class="form-input full">
				    	<?php
				    	foreach ($levelList as $id => $name) {
				    		if($id == $impRow['level']) {
				    			?>
					    		<option value="<?=$id?>" selected><?=$name?></option>
					    		<?php
				    		}  else {
				    			?>
					    		<option value="<?=$id?>"><?=$name?></option>
					    		<?php
				    		}
				    	}
				    	?>
				    </select>
			    </td>
		    </tr>
		    <tr>
			    <td colspan="2">
				    <label class="input-required">รายละเอียด</label>
				    <textarea id="detail" name="detail" class="form-input full" rows="5" require><?=$impRow['detail']?></textarea>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-detail-require" class="errInputMsg err-detail">โปรดกรอกรายละเอียด</span>
                </td>
            </tr>
	    </tbody>
    </table>
    <?php
    if($code == '') {
    	?>
    	<button id="addBtn" type="button" class="myButton" style="margin-right:10px;">เพิ่ม</button>
    	<?php
    } else {
    	?>
    	<button id="editBtn" type="button" class="myButton" style="margin-right:10px;">
    		แก้ไข
    	</button>
    	<?php
    }
    ?>
    
    <a href="show_impact_qual.php" class="btn">
		<button class="myButton" type="button">ยกเลิก</button>
	</a>
</form>
<?php
}
?>
</body>
</html>