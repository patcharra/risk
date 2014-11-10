<?
require('../common/common_header.php');
$action = '';
$code = '';
if(isset($_REQUEST['code'])) {
	// Edit data will select
	$action = 'EDIT';
	$title	= 'แก้ไขข้อมูลแผนงาน';

	// Get plan data
	$code 	= $_REQUEST['code'];
	$sql 	= "SELECT 	* 
				FROM 	plan 
				WHERE 	IDplan = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	if($rows > 0) {
		$planRow = mysql_fetch_assoc($result);
	}

	// Get risk_factor data
	$riskFactorList = array();
	$sql 	= "SELECT 	* 
				FROM 	risk_factor 
				WHERE 	IDplan = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	for($i=0; $i<$rows; $i++) {
		array_push($riskFactorList, mysql_fetch_assoc($result));
	}

	// Get objective data
	$objectiveList = array();
	$sql 	= "SELECT 	* 
				FROM 	objective 
				WHERE 	IDplan = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	for($i=0; $i<$rows; $i++) {
		array_push($objectiveList, mysql_fetch_assoc($result));
	}

	// Get results_to_get data
	$resultToGetList = array();
	$sql 	= "SELECT 	* 
				FROM 	results_to_get 
				WHERE 	IDplan = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	for($i=0; $i<$rows; $i++) {
		array_push($resultToGetList, mysql_fetch_assoc($result));
	}
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
// find unit
$sql = "SELECT IDunit, unitName FROM unit";
$result = mysql_query($sql, $dbConn);
$rows = mysql_num_rows($result);
if($rows > 0) {
	$unitList = array();
	for($i=0; $i<$rows; $i++) {
		$tmpRow = mysql_fetch_assoc($result);
		$unitList[$tmpRow['IDunit']] = $tmpRow['unitName'];
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
	#risk-factor-table tr:nth-child(2) .removeRskfacBtn, #objective-table tr:nth-child(2) .removeObjBtn,
	#resultToGet-table tr:nth-child(2) .removeRtgBtn {
        display: none;
    }
	</style>
	<script type="text/javascript">
	var action = '<?=$action?>';
	$(document).ready(function(){
		$('#addRiskFactorBtn').click(addRiskfacName);
		$('#addObjectiveBtn').click(addObjective);
		$('#addResultToGetBtn').click(addResultToGet);

		if(action == 'ADD') {
			addRiskfacName({});
			addObjective({});
			addResultToGet({});
		} else if(action == 'EDIT') {
			<?
			if(isset($riskFactorList)) {
				foreach ($riskFactorList as $key => $value) {
					?>
					addRiskfacName({
						IDriskfac		: "<?=$value['IDriskfac']?>",
						defaultValue	: "<?=$value['riskfacName']?>"
					});
					<?
				}
			}
			if(isset($objectiveList)) {
				foreach ($objectiveList as $key => $value) {
					?>
					addObjective({
						IDobj			: "<?=$value['IDobj']?>",
						defaultValue	: "<?=$value['detail']?>"
					});
					<?
				}
			}
			if(isset($resultToGetList)) {
				foreach ($resultToGetList as $key => $value) {
					?>
					addResultToGet({
						IDrtg			: "<?=$value['IDrtg']?>",
						defaultValue	: "<?=$value['rtgDetail']?>"
					});
					<?
				}
			}
			?>
		}
	});

	function addRiskfacName(data) {
        var randNum;
        var defaultValue = '';
        if(data.defaultValue) {
            defaultValue = data.defaultValue;
        }
        do {
            randNum     = parseInt(Math.random()*1000);
        } while($('riskfacName_' + randNum).length > 0);
        var inputKeyId  = 'riskfacName_' + randNum;

        // Create HTML and append
        var rowHTML  = '<tr class="rskfac-row">'
                        + '     <td>'
                        + ' 		<input id="' + inputKeyId + '" name="riskfacName[]" type="text" class="form-input full" value="' + defaultValue + '" require>';

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
        var defaultValue = '';
        if(data.defaultValue) {
            defaultValue = data.defaultValue;
        }
        do {
            randNum     = parseInt(Math.random()*1000);
        } while($('objDtl_' + randNum).length > 0);
        var inputKeyId  = 'objDtl_' + randNum;

        // Create HTML and append
        var rowHTML  = '<tr class="objDtl-row">'
                        + '     <td>'
                        + ' 		<input id="' + inputKeyId + '" name="objDtl[]" type="text" class="form-input full" value="' + defaultValue + '" require>';

        // add pkgsvl id for update
        if(action == 'EDIT' && typeof(data.IDobj) != 'undefined') {
            rowHTML += '         <input name="IDobj[]" type="hidden" value="' + data.IDobj + '">';
        }

        		rowHTML += '         <button class="removeObjBtn myButton" type="button" onclick="removeObjective(\'' + randNum + '\')">ลบ</button>'
                        + '     </td>'
                        + '</tr>'
                        + '<tr>'
                        + '		<td>'
                        + '			<span id="err-' + inputKeyId + '-require" class="errInputMsg err-' + inputKeyId + '">'
                        + '				โปรดกรอกวัตถุประสงค์'
                        + '			</span>'
                        + '		</td>'
                        + '</tr>';
        $('#objective-table tbody').append(rowHTML);
    }

    function addResultToGet(data) {
        var randNum;
        var defaultValue = '';
        if(data.defaultValue) {
            defaultValue = data.defaultValue;
        }
        do {
            randNum     = parseInt(Math.random()*1000);
        } while($('retget_' + randNum).length > 0);
        var inputKeyId  = 'retget_' + randNum;

        // Create HTML and append
        var rowHTML  = '<tr class="retget-row">'
                        + '     <td>'
                        + ' 		<input id="' + inputKeyId + '" name="rtgDetail[]" type="text" class="form-input full" value="' + defaultValue + '" require>';

        // add pkgsvl id for update
        if(action == 'EDIT' && typeof(data.IDrtg) != 'undefined') {
            rowHTML += '         <input name="IDrtg[]" type="hidden" value="' + data.IDrtg + '">';
        }

        		rowHTML += '         <button class="removeRtgBtn myButton" type="button" onclick="removeResultToGet(\'' + randNum + '\')">ลบ</button>'
                        + '     </td>'
                        + '</tr>'
                        + '<tr>'
                        + '		<td>'
                        + '			<span id="err-' + inputKeyId + '-require" class="errInputMsg err-' + inputKeyId + '">'
                        + '				โปรดกรอกผลคาดว่าจะได้รับ'
                        + '			</span>'
                        + '		</td>'
                        + '</tr>';
        $('#resultToGet-table tbody').append(rowHTML);
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

    function removeObjective(randNum) {
    	var objective 	= $('#objDtl_' + randNum);
    	var tr 			= objective.parent().parent();
    	var txt 		= objective.val();
    	var msg 		= '';
    	if(txt != '') {
    		msg = 'คุณต้องการลบวัตถุประสงค์ ' + txt + ' ออกจากแผนงานนี้ใช่หรือไม่?';
    	} else {
    		msg = 'คุณต้องการลบัตถุประสงค์ที่เลือกออกจากแผนงานนี้ใช่หรือไม่?';
    	}
    	if(confirm(msg)) {
    		tr.remove();
    	}
    }

    function removeResultToGet(randNum) {
    	var rtg 	= $('#retget_' + randNum);
    	var tr 			= rtg.parent().parent();
    	var txt 		= rtg.val();
    	var msg 		= '';
    	if(txt != '') {
    		msg = 'คุณต้องการลบผลที่คาดว่าจะได้รับ ' + txt + ' ออกจากแผนงานนี้ใช่หรือไม่?';
    	} else {
    		msg = 'คุณต้องการลบผลที่คาดว่าจะได้รับที่เลือกออกจากแผนงานนี้ใช่หรือไม่?';
    	}
    	if(confirm(msg)) {
    		tr.remove();
    	}
    }
	</script>
</head>
<body>
<h3><?=$title?></h3>
<form id="form-table" name="form-table" action="manage_plan.php" method="post">
	<input type="hidden" name="code" value="<?=$code?>">
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
		    <tr>
			    <td colspan="2">
				    <label class="input-required">ชื่อแผนงาน</label>
				    <input id="planName" name="planName" type="text" class="form-input full" value="<?=$planRow['planName']?>" valuepattern="character" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-planName-require" class="errInputMsg err-planName">โปรดกรอกชื่อแผนงาน</span>
                    <span id="err-planName-character" class="errInputMsg err-planName">โปรดกรอกข้อมูลเป็นตัวอักษรภาษาไทย หรือตัวอักษรภาษาอังกฤษเท่านั้น</span>
                </td>
            </tr>
            <tr>
			    <td colspan="2">
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
			    <td colspan="2">
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
		    <tr>
			    <td colspan="2">
				    <label class="input-required">ความเสี่ยง</label>
				    <input id="risk" name="risk" type="text" class="form-input full" value="<?=$planRow['risk']?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-risk-require" class="errInputMsg err-risk">โปรดกรอกชื่อแผนงาน</span>
                </td>
            </tr>
		</tbody>
    </table>
    <table id="risk-factor-table" class="mbk-form-input-normal" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
	    <tbody>
            <tr>
			    <td colspan="2">
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
				    <label class="input-required">สถานะปัจจุบัน (โอกาสเกิด x ผลลัพธ์)</label>
				    <input id="statusValue1" name="statusValue1" type="text" class="form-input" style="width:115px; display:inline;text-align:center;" value="<?=$planRow['statusValue1']?>" require> x 
				    <input id="statusValue2" name="statusValue2" type="text" class="form-input" style="width:115px; display:inline;text-align:center;" value="<?=$planRow['statusValue2']?>" require>
			    </td>
			    <td>
				    <label class="input-required">เป้าหมาย (โอกาสเกิด x ผลลัพธ์)</label>
				    <input id="targetValue1" name="targetValue1" type="text" class="form-input" style="width:115px; display:inline;text-align:center;" value="<?=$planRow['targetValue1']?>" require> x 
				    <input id="targetValue2" name="targetValue2" type="text" class="form-input" style="width:115px; display:inline;text-align:center;" value="<?=$planRow['targetValue2']?>" require>
			    </td>
		    </tr>
		    <tr>
			    <td colspan="2">
				    <label class="input-required">เกณฑ์วัด (ข้อความ)</label>
				    <span style="display:block;color:#888;">*ใส่ %v แทนค่าตัวเลข และใส่ %u แทนหน่วยนับ</span>
				    <input id="criteriaDetail" name="criteriaDetail" type="text" class="form-input full" value="<?=$planRow['criteriaDetail']?>" require><br>
			    </td>
		    </tr>
		    <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-criteriaDetail-require" class="errInputMsg err-criteriaDetail">โปรดกรอกข้อความเกณฑ์วัด</span>
                </td>
            </tr>
            <tr>
			    <td>
				    <label class="input-required">ค่าเกณฑ์วัด</label>
				    <input id="criteriaValue" name="criteriaValue" type="text" class="form-input half" value="<?=$planRow['criteriaValue']?>" require>
			    </td>
			    <td>
				    <label class="input-required">หน่วยเกณฑ์วัด</label>
				    <select id="criteriaUnit" name="criteriaUnit" class="form-input half">
				    	<?
				    	foreach ($unitList as $id => $name) {
				    		if($id == $plnRow['criteriaUnit']) {
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
		    <tr class="errMsgRow">
                <td>
                    <span id="err-criteriaValue-require" class="errInputMsg err-criteriaValue">โปรดกรอกค่าเกณฑ์วัด</span>
                </td>
                <td></td>
            </tr>
            <tr>
            	<td colspan="2">
            		<label class="input-required">ประเภทของโอกาสจะเกิดความเสี่ยง</label>
            		<select id="riskchance_type" name="riskchance_type" class="form-input full">
            		<?php
            		if($planRow['riskchance_type'] == 'qual') {
            			?>
            			<option value="quan">เชิงปริมาณ</option>
            			<option value="qual" selected>เชิงคุณภาพ</option>
            			<?php
            		} else {
            			?>
            			<option value="quan" selected>เชิงปริมาณ</option>
            			<option value="qual">เชิงคุณภาพ</option>
            			<?php
            		}
            		?>
            		</select>
            	</td>
            </tr>
		    <tr>
		    	<td colspan="2">
		    		<label class="input-required">หน่วยของโอกาสจะเกิดความเสี่ยง</label>
		    		<select id="IDunit_riskchance" name="IDunit_riskchance" class="form-input full">
				    	<?php
				    	foreach ($unitList as $id => $name) {
				    		if($id == $planRow['IDunit_riskchance']) {
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
            		<label class="input-required">ประเภทของผลกระทบต่อองค์กร</label>
            		<select id="impact_type" name="impact_type" class="form-input full">
            		<?php
            		if($planRow['impact_type'] == 'qual') {
            			?>
            			<option value="quan">เชิงปริมาณ</option>
            			<option value="qual" selected>เชิงคุณภาพ</option>
            			<?php
            		} else {
            			?>
            			<option value="quan" selected>เชิงปริมาณ</option>
            			<option value="qual">เชิงคุณภาพ</option>
            			<?php
            		}
            		?>
            		</select>
            	</td>
            </tr>
		    <tr>
		    	<td colspan="2">
		    		<label class="input-required">หน่วยของผลกระทบต่อองค์กร</label>
		    		<select id="IDunit_impact" name="IDunit_impact" class="form-input full">
				    	<?
				    	foreach ($unitList as $id => $name) {
				    		if($id == $planRow['IDunit_impact']) {
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
		    <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-criteriaUnit-require" class="errInputMsg err-criteriaUnit">โปรดกรอกหน่วยเกณฑ์วัด</span>
                </td>
            </tr>
	    </tbody>
    </table>
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
			    <td colspan="2">
				    <label class="input-required">หลักการและเหตุผล</label>
				    <textarea id="rationale" name="rationale" class="form-input full" rows="10" require><?=$planRow['rationale']?></textarea>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-rationale-require" class="errInputMsg err-rationale">โปรดกรอกหลักการและเหตุผล</span>
                </td>
            </tr>
       </tbody>
    </table>
    <table id="objective-table" class="mbk-form-input-normal" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
	    <tbody>
            <tr>
			    <td colspan="2">
				    <label class="input-required">วัตถุประสงค์</label>
			    </td>
		    </tr>
    	</tbody>
    </table>
    <button id="addObjectiveBtn" type="button" class="myButton" style="margin-bottom:50px;">เพิ่มวัตถุประสงค์</button>
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
    	<tbody>
            <tr>
			    <td colspan="2">
				    <label class="input-required">เป้าหมาย</label>
				    <input id="target" name="target" type="text" class="form-input full" value="<?=$planRow['target']?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-target-require" class="errInputMsg err-target">โปรดกรอกเป้าหมาย</span>
                </td>
            </tr>
            <tr>
			    <td colspan="2">
				    <label class="input-required">ความเสี่ยงที่ยอมรับได้</label>
				    <input id="accept_risk" name="accept_risk" type="text" class="form-input full" value="<?=$planRow['accept_risk']?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-accept_risk-require" class="errInputMsg err-accept_risk">โปรดกรอกความเสี่ยงที่ยอมรับได้</span>
                </td>
            </tr>
            <tr>
			    <td colspan="2">
				    <label class="input-required">ช่วงเบี่ยงเบนความเสี่ยงที่ยอมรับได้</label>
				    <input id="deviation_accept_risk" name="deviation_accept_risk" type="text" class="form-input full" value="<?=$planRow['deviation_accept_risk']?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-deviation_accept_risk-require" class="errInputMsg err-deviation_accept_risk">โปรดกรอกช่วงเบี่ยงเบนความเสี่ยงที่ยอมรับได้</span>
                </td>
            </tr>
            <tr>
			    <td colspan="2">
				    <label class="input-required">ระยะเวลาดำเนินการ</label>
				    <input id="time" name="time" type="text" class="form-input full" value="<?=$planRow['time']?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td colspan="2">
                    <span id="err-time-require" class="errInputMsg err-time">โปรดกรอกระยะเวลาดำเนินการ</span>
                </td>
            </tr>
	    </tbody>
    </table>
    <table id="resultToGet-table" class="mbk-form-input-normal" cellpadding="0" cellspacing="0" style="margin-bottom:0;">
	    <tbody>
            <tr>
			    <td colspan="2">
				    <label class="input-required">ผลคาดว่าที่จะได้รับ</label>
			    </td>
		    </tr>
    	</tbody>
    </table>
    <button id="addResultToGetBtn" type="button" class="myButton" style="margin-bottom:50px;">เพิ่มผลคาดว่าที่จะได้รับ</button><p></p>
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