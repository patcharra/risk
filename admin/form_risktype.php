<?
require('../common/common_header.php');
$code = '';
if(isset($_REQUEST['code'])) {
	// Edit data will select
	$title	= 'แก้ไขข้อมูลประเภทความเสี่ยง';

	$code 	= $_REQUEST['code'];
	$sql 	= "SELECT 	typeName 
				FROM 	risktype 
				WHERE 	IDtype = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	if($rows > 0) {
		$rsktypRow = mysql_fetch_assoc($result);
		$risktype  = $rsktypRow['typeName'];
	}
} else {
	$title		= 'เพิ่มข้อมูลประเภทความเสี่ยง';
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
<form id="form-table" name="form-table" action="manage_risktype.php">
	<input type="hidden" name="code" value="<?=$code?>">
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
		    <tr>
			    <td>
				    <label class="input-required">ชื่อประเภทความเสี่ยง</label>
				    <input id="typeName" name="typeName" type="text" class="form-input full" value="<?=$risktype?>" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-typeName-require" class="errInputMsg err-typeName">โปรดกรอกชื่อประเภทความเสี่ยง</span>
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
    
    <a href="show_risktype.php" class="btn">
		<button class="myButton" type="button">ยกเลิก</button>
	</a>
</form>
</body>
</html>