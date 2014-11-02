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

$query		= "select mean from  level_and_meanP where levelP =".$id; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db


?>

<br>
<h3>แก้ไขระดับของผลกระทบต่อองค์กร</h3><br><br>
<table>
<form method="post" action="###">


<tr>
<td>ระดับ</td><td><?=$id?></td></tr>
<tr>
<td>ความหมาย</td><td><input type="text" name="mean" value="<?=$row_db['mean']?>"><font color='red'> *</font>
</td></tr>


<input type="hidden" name="id" value="<?=$id?>">

<tr><td colspan='4'><center><input type="submit" name="sub" value="แก้ไข" onClick="return confirm(' คุณแน่ใจที่จะแก้ไขระดับ?')">


</form>
<a href="meanlevel.php"><button>ยกเลิก</button></a></center></td></tr>

</table>


<?php

if(isset($_POST["sub"])){
	if(($_POST["mean"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	
$tblname = "level_and_meanP"; 
	
$id	= $_REQUEST["id"];

			$sql = "Update $tblname Set mean ='".$_POST["mean"]."' Where levelP ='$id'";

$dbquery = mysql_query($sql, $dbConn);


	echo "<script type='text/javascript'>window.location.href = 'meanlevel.php';</script>";
	}
}
?>


<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
?>


</body>
</html>