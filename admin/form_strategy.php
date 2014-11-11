<?php
require('../common/common_header.php');
$code = '';
if(isset($_REQUEST['code'])) {
	// Edit data will select
	$title	= 'แก้ไขข้อมูลกลยุทธ์';

	$code 	= $_REQUEST['code'];
	$sql 	= "SELECT 	strategyName 
				FROM 	strategy 
				WHERE 	IDstrategy = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	if($rows > 0) {
		$strategyRow 	= mysql_fetch_assoc($result);
		$strategyName  = $strategyRow['strategyName'];
	}
} else {
	$title		= 'เพิ่มข้อมูลกลยุทธ์';
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
</head>
<body>
<h3><?=$title?></h3>
<form id="form-table" name="form-table" action="manage_strategy.php">
	<input type="hidden" name="code" value="<?=$code?>">
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
		    <tr>
			    <td>
				    <label class="input-required">ชื่อกลยุทธ์</label>
				    <input id="strategyName" name="strategyName" type="text" class="form-input full" value="<?=$strategyName?>" valuepattern="character" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-strategyName-require" class="errInputMsg err-strategyName">โปรดกรอกชื่อกลยุทธ์</span>
                    <span id="err-strategyName-character" class="errInputMsg err-strategyName">โปรดกรอกข้อมูลเป็นตัวอักษรภาษาไทย หรือตัวอักษรภาษาอังกฤษเท่านั้น</span>
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
    
    <a href="show_strategy.php" class="btn">
		<button class="myButton" type="button">ยกเลิก</button>
	</a>
</form>
</body>
</html>