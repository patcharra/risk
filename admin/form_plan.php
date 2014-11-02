<?
require('../common/common_header.php');
$action = '';
$code = '';
if(isset($_REQUEST['code'])) {
	// Edit data will select
	$action = 'EDIT';
	$title	= 'แก้ไขข้อมูลแผนงาน';

	/*$code 	= $_REQUEST['code'];
	$sql 	= "SELECT 	typeName 
				FROM 	risktype 
				WHERE 	IDtype = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	if($rows > 0) {
		$rsktypRow = mysql_fetch_assoc($result);
		$risktype  = $rsktypRow['typeName'];
	}*/
} else {
	$action = 'ADD';
	$title		= 'เพิ่มข้อมูลแผนงาน';
}

// find strategy
$sql = "SELECT IDstrategy, strategyName FROM strategy";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$strategyList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$strategyList[$tmpRow['IDstrategy']] = $tmpRow['strategyName'];
	}
}
// find risktype
$sql = "SELECT IDtype, typeName FROM risktype";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$risktypeList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$risktypeList[$tmpRow['IDtype']] = $tmpRow['typeName'];
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
	<style type="text/css">
	#risk-factor-table tr:nth-child(2) .removeRskfacBtn {
        display: none;
    }
	</style>
	<script type="text/javascript">
	var action = '<?=$action?>';
	$(document).ready(function(){
		$('#addRiskFactorBtn').click(addRiskfacName);

		if(action == 'ADD') {
			addRiskfacName({
                defaultValue : false
            });
		} else if(action == 'EDIT') {

		}
	});

	function addRiskfacName(data) {
        var randNum;
        do {
            randNum     = parseInt(Math.random()*1000);
        } while($('riskfacName_' + randNum).length > 0);
        var inputKeyId  = 'riskfacName_' + randNum;

        // Create HTML and append
        var rowHTML  = '<tr class="rskfac-row">'
                        + '     <td>'
                        + ' 		<input id="' + inputKeyId + '" name="riskfacName[]" type="text" class="form-input full" value="' + data.riskfacName + '" require>';

        // add pkgsvl id for update
        if(action == 'EDIT' && typeof(data.IDriskfac) != 'undefined') {
            rowHTML += '         <input name="IDriskfac[]" type="hidden" value="' + data.IDriskfac + '">';
        }

        		rowHTML += '         <button class="removeRskfacBtn myButton" type="button" onclick="removeRiskfacName(\'' + randNum + '\')">ลบ</button>'
                        + '     </td>'
                        + '</tr>'
                        + '<tr>'
                        + '		<td>'
                        + '			<span id="err-' + inputKeyId + '-require" class="errInputMsg err-' + inputKeyId + '">'
                        + '				โปรดกรอกปัจจัยเสี่ยง'
                        + '			</span>'
                        + '		</td>'
                        + '</tr>';
        $('#risk-factor-table tbody').append(rowHTML);
    }

    function addObjective(data) {
        var randNum;
        do {
            randNum     = parseInt(Math.random()*1000);
        } while($('objDtl_' + randNum).length > 0);
        var inputKeyId  = 'objDtl_' + randNum;

        // Create HTML and append
        var rowHTML  = '<tr class="objDtl-row">'
                        + '     <td>'
                        + ' 		<input id="' + inputKeyId + '" name="objDetail[]" type="text" class="form-input full" value="' + data.riskfacName + '" require>';

        // add pkgsvl id for update
        if(action == 'EDIT' && typeof(data.IDriskfac) != 'undefined') {
            rowHTML += '         <input name="IDriskfac[]" type="hidden" value="' + data.IDriskfac + '">';
        }

        		rowHTML += '         <button class="removeRskfacBtn myButton" type="button" onclick="removeRiskfacName(\'' + randNum + '\')">ลบ</button>'
                        + '     </td>'
                        + '</tr>'
                        + '<tr>'
                        + '		<td>'
                        + '			<span id="err-' + inputKeyId + '-require" class="errInputMsg err-' + inputKeyId + '">'
                        + '				โปรดกรอกปัจจัยเสี่ยง'
                        + '			</span>'
                        + '		</td>'
                        + '</tr>';
        $('#risk-factor-table tbody').append(rowHTML);
    }

    function removeRiskfacName(randNum) {
    	var riskfacName 	= $('#riskfacName_' + randNum);
    	var tr 			= riskfacName.parent().parent();
    	var txt 		= riskfacName.val();
    	var msg 		= '';
    	if(txt != '') {
    		msg = 'คุณต้องการลบปัจจัยเสี่ยง ' + txt + ' ออกจากแผนงานนี้ใช่หรือไม่?';
    	} else {
    		msg = 'คุณต้องการลบปัจจัยเสี่ยงที่เลือกออกจากแผนงานนี้ใช่หรือไม่?';
    	}
    	if(confirm(msg)) {
    		tr.remove();
    	}
    }
	</script>
</head>
<body>
<h3><?=$title?></h3>
<form id="form-table" name="form-table" action="manage_plan.php">
	<input type="hidden" name="code" value="<?=$code?>">
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
		    <tr>
			    <td>
				    <label class="input-required">ชื่อแผนงาน</label>
				    <input id="planName" name="planName" type="text" class="form-input full" value="<?=$planName?>" valuepattern="character" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-planName-require" class="errInputMsg err-planName">โปรดกรอกชื่อแผนงาน</span>
                    <span id="err-planName-character" class="errInputMsg err-planName">โปรดกรอกข้อมูลเป็นตัวอักษรภาษาไทย หรือตัวอักษรภาษาอังกฤษเท่านั้น</span>
                </td>
            </tr>
            <tr>
			    <td>
				    <label class="input-required">กลยุทธ์</label>
				    <select id="IDstrategy" name="IDstrategy" class="form-input full">
				    	<?
				    	foreach ($strategyList as $id => $name) {
				    		if($id == $plnRow['IDstrategy']) {
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
			    <td>
				    <label class="input-required">ประเภทความเสี่ยง</label>
				    <select id="IDtype" name="IDtype" class="form-input full">
				    	<?
				    	foreach ($risktypeList as $id => $name) {
				    		if($id == $plnRow['IDtype']) {
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
		</tbody>
    </table>
    <table id="risk-factor-table" class="mbk-form-input-normal" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
	    <tbody>
            <tr>
			    <td>
				    <label class="input-required">ปัจจัยเสี่ยง</label>
			    </td>
		    </tr>
    	</tbody>
    </table>
    <button id="addRiskFactorBtn" type="button" class="myButton" style="margin-bottom:50px;">เพิ่มปัจจัยเสี่ยง</button>
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
    	<tbody>
            <tr>
			    <td>
				    <label class="input-required">หลักการและเหตุผล</label>
				    <textarea id="rationale" name="rationale" class="form-input full" rows="10" require><?=$risk?></textarea>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-rationale-require" class="errInputMsg err-rationale">โปรดกรอกหลักการและเหตุผล</span>
                </td>
            </tr>
       </tbody>
    </table>
    <table id="objective-table" class="mbk-form-input-normal" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
	    <tbody>
            <tr>
			    <td>
				    <label class="input-required">วัตถุประสงค์</label>
			    </td>
		    </tr>
    	</tbody>
    </table>
    <button id="addObjectiveBtn" type="button" class="myButton" style="margin-bottom:50px;">เพิ่มวัตถุประสงค์</button>
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
    	<tbody>
            <tr>
			    <td>
				    <label class="input-required">เป้าหมาย</label>
				    <input id="target" name="target" type="text" class="form-input full" value="<?=$target?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-target-require" class="errInputMsg err-target">โปรดกรอกเป้าหมาย</span>
                </td>
            </tr>
            <tr>
			    <td>
				    <label class="input-required">ความเสี่ยงที่ยอมรับได้</label>
				    <input id="accept_risk" name="accept_risk" type="text" class="form-input full" value="<?=$accept_risk?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-accept_risk-require" class="errInputMsg err-accept_risk">โปรดกรอกความเสี่ยงที่ยอมรับได้</span>
                </td>
            </tr>
            <tr>
			    <td>
				    <label class="input-required">ช่วงเบี่ยงเบนความเสี่ยงที่ยอมรับได้</label>
				    <input id="deviation_accept_risk" name="deviation_accept_risk" type="text" class="form-input full" value="<?=$deviation_accept_risk?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-deviation_accept_risk-require" class="errInputMsg err-deviation_accept_risk">โปรดกรอกช่วงเบี่ยงเบนความเสี่ยงที่ยอมรับได้</span>
                </td>
            </tr>
            <tr>
			    <td>
				    <label class="input-required">ระยะเวลาดำเนินการ</label>
				    <input id="time" name="time" type="text" class="form-input full" value="<?=$time?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-time-require" class="errInputMsg err-time">โปรดกรอกระยะเวลาดำเนินการ</span>
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
    
    <a href="show_plan.php" class="btn">
		<button class="myButton" type="button">ยกเลิก</button>
	</a>
</form>
</body>
</html>