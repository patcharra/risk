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

$query		= "select agenName,agenInitname from agency where IDagen =".$id; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db


?>

<br>
<h3>แก้ไขหน่วยงาน</h3><br><br>
<table>
<form method="post" action="###">


<tr><td>ชื่อหน่วยงาน</td><td><input type="text" name="agenName" value="<?=$row_db['agenName']?>"><font color='red'> *</font></td></tr>

<tr><td>ชื่อย่อหน่วยงาน</td><td><input type="text" name="agenInitName" value="<?=$row_db['agenInitname']?>"><font color='red'> * </font></td></tr>

<input type="hidden" name="id" value="<?=$id?>">

<tr><td colspan='4'><center><input type="submit" name="sub" value="แก้ไข" onClick="return confirm(' คุณแน่ใจที่จะแก้ไขข้อมูลหน่วยงาน?')">


</form>
<a href="main_agencies.php"><button>ยกเลิก</button></a></center></td></tr>
</table>


<?php

if(isset($_POST["sub"])){
	if(($_POST["agenName"]=="") || ($_POST["agenInitName"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	
$tblname = "agency"; 
	
$id	= $_REQUEST["id"];

			$sql = "Update $tblname Set agenName='".$_POST["agenName"]."',agenInitname='".$_POST["agenInitName"]."' Where IDagen='$id'";
	
	$dbquery = mysql_query($sql, $dbConn);

	echo "<script type='text/javascript'>window.location.href = 'main_agencies.php';</script>";
	}
}
?>


<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
?>


</body>
</html>