<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../inc/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/risk_main.css">
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/form_table.js"></script>

</head>
<body>


<style type="text/css">

a:link, a:active, a:visited {
color:#000000; 
text-decoration: none}

a:hover {
color:#0000FF; 
text-decoration: none}
td{font-family:arial, sans-serif; font-size:15px;}

</style>
<?php
require('../common/common_header.php');

$query		= "select level,mean,topicName from  level_and_mean "; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db

$query1		= "select max(level) maxlevel from  level_and_mean "; 
$query_db1	= mysql_query($query1, $dbConn) or die(mysql_error());
$row_db1	= mysql_fetch_assoc($query_db1);//เก็บผลการประมวงผลลงตัวแปร $row_db

$count		=1;
?>

<br>
<h3>จัดการระดับและความหมาย</h3><br><br>

<form id="form-table" name="form-table" action="###">
    <table class="mbk-form-input-normal" cellpadding="0" cellspacing="0">
	    <tbody>
		    <tr>
			    <td>
				    <label class="input-required">ระดับ</label>
				    <input id="level" name="level" type="text" class="form-input full" value="<?php echo $row_db1['maxlevel']+1 ?>"  readonly>


			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-level-require" class="errInputMsg err-level">โปรดกรอกระดับ</span>
                </td>
            </tr>
			<tr>
			    <td>
				    <label class="input-required">ความหมาย</label>
				    <input id="mean" name="mean" type="text" class="form-input full" valuepattern="character" require>
			    </td>
		    </tr>
            <tr class="errMsgRow">
                <td>
                    <span id="err-mean-require" class="errInputMsg err-mean">โปรดกรอกความหมาย</span>
                    <span id="err-mean-character" class="errInputMsg err-mean">โปรดกรอกข้อมูลเป็นตัวอักษรภาษาไทย หรือตัวอักษรภาษาอังกฤษเท่านั้น</span>
                </td>
            </tr>
	    </tbody>
    </table>
    <button id="addBtn" type="button" class="myButton" style="margin-right:10px;">เพิ่ม</button>
	<input type="submit" name="clear" value="ยกเลิก" class="myButton">
</form>




<?php

if(isset($_POST["sub"])){
	if(($_POST["unitname"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	$tblname = "unit"; 
	

	$sql = "insert into $tblname (unitName) values ('".$_POST["unitname"]."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'main_unit.php';</script>";
	}
}
?>




<table class= "table-data">
<tr>
<th></th>
<th></th>
<th align="center" >ลำดับที่</th>
<th align="center" >ชื่อหน่วยนับ</th>
</tr>

<?php
$query2 = "select IDunit,unitName from unit"; 
$query_db2 = mysql_query($query2, $dbConn) or die(mysql_error());
$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
?>
<tr>
<td><a href="update_unit.php?id=<?=$row_db2['IDunit']?>"><button>แก้ไข</button></a></td>
<td><a href="delete_unit.php?id=<?=$row_db2['IDunit']?>" onClick="return confirm(' คุณแน่ใจที่จะลบ  <?=$row_db2['unitName']?>?')"><button>ลบ</button></a></td>
<td ><center>&nbsp;<?=$count++?></center></td>
<td >&nbsp;<?=$row_db2['unitName']?> </td>
</tr>
<?php                                                
                                                      
}while ($row_db2 = mysql_fetch_assoc($query_db2));
?>
</table>

<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
//mysql_free_result($query_db2);//เลิกติดต่อ Mysql
?>


</body>
</html>