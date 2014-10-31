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

$query		= "select firstname,lastname,IDagen,username,status from employee where IDemp =".$id; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db


$query1		= "select IDagen,agenName,agenInitname from agency "; 
$query_db1	= mysql_query($query1, $dbConn) or die(mysql_error());
$row_db1	= mysql_fetch_assoc($query_db1);//เก็บผลการประมวงผลลงตัวแปร $row_db

?>

<br>
<h3>แก้ไขผู้ใช้</h3><br><br>
<table>
<form method="post" action="###">


<tr>
<td>ชื่อ</td><td><input type="text" name="firstname" value="<?=$row_db['firstname']?>"><font color='red'> *</font>
นามสกุล<input type="text" name="lastname" value="<?=$row_db['lastname']?>"><font color='red'> *</font></td>
</tr>

<tr><td>หน่วยงาน</td><td><SELECT NAME="agen">

	<?php 
	do{
	?>
			<option value='<?=$row_db1['IDagen']?>' <?php if($row_db1['IDagen'] == $row_db['IDagen']){echo "selected";}?>><?=$row_db1['agenName']?></option>
	<?php }while ($row_db1 = mysql_fetch_assoc($query_db1));?>

</SELECT>
<tr><td>Username</td><td><input type="text" name="username" value="<?=$row_db['username']?>"><font color='red'> * </font></td></tr>
<tr><td>สิทธิ์</td><td>
	
	<input type="radio" name="status" value="user" <?php if($row_db['status'] == "user"){echo "checked";}?>>ผู้ใช้ 
	<input type="radio" name="status"  value="admin" <?php if($row_db['status'] == "admin"){echo "checked";}?> >ผู้ดูแลระบบ

<input type="hidden" name="id" value="<?=$id?>">

<tr><td colspan='4'><center><input type="submit" name="sub" value="แก้ไขผู้ใช้" onClick="return confirm(' คุณแน่ใจที่จะแก้ไขข้อมูลผู้ใช้?')">


</form>
<a href="main_emp.php"><button>ยกเลิก</button></a></center></td></tr>

</table>


<?php

if(isset($_POST["sub"])){
	if(($_POST["firstname"]=="") || ($_POST["lastname"]=="")|| ($_POST["agen"]=="")|| ($_POST["username"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	
$tblname = "employee"; 
	
$id	= $_REQUEST["id"];

			$sql = "Update $tblname Set firstname='".$_POST["firstname"]."',lastname='".$_POST["lastname"]."',IDagen='".$_POST["agen"]."',status='".$_POST["status"]."' Where IDemp='$id'";

$dbquery = mysql_query($sql, $dbConn);



	echo "<script type='text/javascript'>window.location.href = 'main_emp.php';</script>";
	}
}
?>


<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
?>


</body>
</html>