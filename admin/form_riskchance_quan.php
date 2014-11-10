<?
require('../common/common_header.php');
$code = '';
if(isset($_REQUEST['code'])) {
	// Edit data will select
	$title	= 'แก้ไขข้อมูลโอกาสเกิดความเสี่ยงเชิงปริมาณ';

	$code 	= $_REQUEST['code'];
	$sql 	= "SELECT 	r.*,
						u.unitName 
				FROM 	riskchance_quan r, plan p, unit u  
				WHERE 	r.IDplan = p.IDplan AND p.IDunit_riskchance = u.IDunit  
						AND r.IDrcq = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	if($rows > 0) {
		$rskchcRow = mysql_fetch_assoc($result);
	}
} else {
	$title		= 'เพิ่มข้อมูลโอกาสเกิดความเสี่ยงเชิงปริมาณ';
}

// find plan
date_default_timezone_set("Asia/Bangkok");
$year 	= date('Y');
$sql = "SELECT IDplan, planName FROM plan where y_insert = '$year'";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$planList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$planList[$tmpRow['IDplan']] = $tmpRow['planName'];
	}
}

// find level
$sql = "SELECT levelO, mean FROM level_and_meano";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$levelList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$levelList[$tmpRow['levelO']] = $tmpRow['levelO'].' ('.$tmpRow['mean'].')';
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
			if($(this).val() == '1') {
				$('#quantity_row').css('display', 'table-row');
				$('#quantity').attr("require", true);
				$('#quantity').attr("valuepattern", "money");
				$('.quantityMinMax').css('display', 'none');
				$('#quantitymin').removeAttr('require');
				$('#quantitymax').removeAttr('require');
				$('#quantitymin').removeAttr('valuepattern');
				$('#quantitymax').removeAttr('valuepattern');
				$('#quantitymin').removeClass('required');
				$('#quantitymax').removeClass('required');
				$('#quantitymin').val('');
				$('#quantitymax').val('');
				$('.err-quantitymin').css('display', 'none');
				$('.err-quantitymax').css('display', 'none');
			} else {
				$('#quantity_row').css('display', 'none');
				$('#quantitymin').attr("valuepattern", "money");
				$('#quantitymax').attr("valuepattern", "money");
				$('#quantity').removeAttr('require');
				$('#quantity').removeAttr('valuepattern');
				$('#quantity').removeClass('required');
				$('#quantity').val('');
				$('.quantityMinMax').css('display', 'table-row');
				$('#quantitymin').attr("require", true);
				$('#quantitymax').attr("require", true);
				$('.err-quantity').css('display', 'none');
			}
		});

		$('#IDplan').change(function(){
			getUnitName($('#IDplan').val());
		});

		getUnitName($('#IDplan').val());

		if($('#quantity').val() == '' || $('#quantity').val() == '0') {
			$('#chk_quantype2').click();
		} else {
			$('#chk_quantype1').click();
		}
	});

	function getUnitName(planID) {
		$.ajax({
			url: '../common/ajaxGetUnitNameOfPlan.php',
			type: 'POST',
			data: {
				planID: planID
			},
			success:
			function(response) {
				$('.unitName').text(response);
			}
		})
	}

	function beforeSaveRecord() {
		if($('#quantitymin').val() != '' && $('#quantitymax').val() != '' 
			&& $('#quantitymin').val() != '0' && $('#quantitymax').val() != '0') {
			var min = parseFloat($('#quantitymin').val());
			var max = parseFloat($('#quantitymax').val());
			if(min >= max) {
				alert("คุณกรอกค่าเริ่มต้น และค่าสิ้นสุดไม่ถูกต้อง\nค่าเริ่มต้นต้องน้อยกว่าค่าสิ้นสุด");
				$('#quantitymin').addClass('required');
				$('#quantitymax').addClass('required');
				return false;
			} else {
				$('#quantitymin').removeClass('required');
				$('#quantitymax').removeClass('required');
				$('.err-quantitymin').css('display', 'none');
				$('.err-quantitymax').css('display', 'none');
			}
		}
		return true;
	}
	</script>
</head>
<body>
<h3><?=$title?></h3>
<form id="form-table" name="form-table" action="manage_riskchance_quan.php">
	<input type="hidden" name="code" value="<?=$code?>">
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
	    	<tr>
			    <td colspan="2">
				    <label class="input-required">แผนงาน</label>
				    <select id="IDplan" name="IDplan" class="form-input full">
				    	<?
				    	foreach ($planList as $id => $name) {
				    		if($id == $rskchcRow['IDplan']) {
				    			?>
					    		<option value="<?=$id?>" selected><?=$name?></option>
					    		<?
				    		}  else {
				    			?>
					    		<option value="<?=$id?>"><?=$name?></option>
					    		<?
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
				    	<?
				    	foreach ($levelList as $id => $name) {
				    		if($id == $rskchcRow['level']) {
				    			?>
					    		<option value="<?=$id?>" selected><?=$name?></option>
					    		<?
				    		}  else {
				    			?>
					    		<option value="<?=$id?>"><?=$name?></option>
					    		<?
				    		}
				    	}
				    	?>
				    </select>
			    </td>
		    </tr>
		    <tr>
			    <td colspan="2">
				    <label class="input-required">รายละเอียด</label>
				    <textarea id="detail" name="detail" class="form-input full" rows="5" require><?=$rskchcRow['detail']?></textarea>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-detail-require" class="errInputMsg err-detail">โปรดกรอกรายละเอียด</span>
                </td>
            </tr>
            <tr>
            	<td colspan="2">
            		<label>รูปแบบค่า</label>
            		<input id="chk_quantype1" type="radio" name="quantype" value="1" checked> ค่าสุทธิ &nbsp;&nbsp;&nbsp;&nbsp;
            		<input id="chk_quantype2" type="radio" name="quantype" value="2"> ช่วง<br><br>
            	</td>
            </tr>
            <tr id="quantity_row">
			    <td colspan="2">
				    <label class="input-required">ค่าสุทธิ (<span class="unitName"><?=$rskchcRow['unitName']?></span>)</label>
				    <input id="quantity" name="quantity" type="text" class="form-input full" value="<?=$rskchcRow['quantity']?>" valuepattern="money" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-quantity-require" class="errInputMsg err-quantity">โปรดกรอกค่าสุทธิ</span>
                    <span id="err-quantity-money" class="errInputMsg err-quantity">โปรดกรอกข้อมูลเป็นตัวเลขเท่านั้น</span>
                </td>
            </tr>
            <tr class="quantityMinMax" style="display:none;">
			    <td>
				    <label class="input-required">ค่าเริ่มต้น (<span class="unitName"><?=$rskchcRow['unitName']?></span>)</label>
				    <input id="quantitymin" name="quantitymin" type="text" class="form-input half" value="<?=$rskchcRow['quantitymin']?>" valuepattern="money">
			    </td>
			    <td>
				    <label class="input-required">ค่าสิ้นสุด (<span class="unitName"><?=$rskchcRow['unitName']?></span>)</label>
				    <input id="quantitymax" name="quantitymax" type="text" class="form-input half" value="<?=$rskchcRow['quantitymax']?>" valuepattern="money">
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-quantitymin-require" class="errInputMsg err-quantitymin">โปรดกรอกค่าเริ่มต้น</span>
                    <span id="err-quantitymin-money" class="errInputMsg err-quantitymin">โปรดกรอกข้อมูลเป็นตัวเลขเท่านั้น</span>
                </td>
                <td>
                    <span id="err-quantitymax-require" class="errInputMsg err-quantitymax">โปรดกรอกค่าสิ้นสุด</span>
                    <span id="err-quantitymax-money" class="errInputMsg err-quantitymax">โปรดกรอกข้อมูลเป็นตัวเลขเท่านั้น</span>
                </td>
            </tr>
	    </tbody>
    </table>
    <?
    if($code == '') {
    	?>
    	<button id="addBtn" type="button" class="myButton" style="margin-right:10px;">เพิ่ม</button>
    	<?
    } else {
    	?>
    	<button id="editBtn" type="button" class="myButton" style="margin-right:10px;">
    		แก้ไข
    	</button>
    	<?
    }
    ?>
    
    <a href="show_riskchance_quan.php" class="btn">
		<button class="myButton" type="button">ยกเลิก</button>
	</a>
</form>
</body>
</html>