<html>
<head>
<meta charset="utf-8">
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
$id	= $_REQUEST["id"];

$query		= "select unitName from  unit where IDunit =".$id; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db


?>

<br>
<h3>แก้ไขหน่วยนับ</h3><br><br>
<table>
<form method="post" action="###">


<tr>
<td>ชื่อหน่วยนับ</td><td><input type="text" name="unitname" value="<?=$row_db['unitName']?>"><font color='red'> *</font>
</td></tr>


<input type="hidden" name="id" value="<?=$id?>">

<tr><td colspan='4'><center><input type="submit" name="sub" value="แก้ไขหน่วยนับ" onClick="return confirm(' คุณแน่ใจที่จะแก้ไขหน่วยนับ?')">


</form>
<a href="main_unit.php"><button>ยกเลิก</button></a></center></td></tr>

</table>


<?php

if(isset($_POST["sub"])){
	if(($_POST["unitname"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	
$tblname = "unit"; 
	
$id	= $_REQUEST["id"];

			$sql = "Update $tblname Set unitName ='".$_POST["unitname"]."' Where IDunit ='$id'";

$dbquery = mysql_query($sql, $dbConn);


	echo "<script type='text/javascript'>window.location.href = 'main_unit.php';</script>";
	}
}
?>


<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
?>


</body>
</html>