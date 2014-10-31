<html>
<head>
<meta charset="utf-8">
</head>
<body>
<center>

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

$query		= "select IDagen,agenName,agenInitname from agency"; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db
$count		=1;
?>

<br>
<b>ผู้ใช้</b><br><br>
<table>
<form method="post" action="###">


<tr>
<td>ชื่อ</td><td><input type="text" name="firstname"><font color='red'> *</font>
นามสกุล<input type="text" name="lastname"><font color='red'> *</font></td>
</tr>

<tr><td>หน่วยงาน</td><td><SELECT NAME="agen">

	<?php 
	do{?>
			<option value='<?=$row_db['IDagen']?>'><?=$row_db['agenName']?></option>
	<?php }while ($row_db = mysql_fetch_assoc($query_db));?>

</SELECT>
<tr><td>Username</td><td><input type="text" name="username"><font color='red'> * </font></td></tr>
<tr><td>รหัสผ่าน</td><td><input type="password" name="password"><font color='red'> * </font></td></tr>
<tr><td>ยืนยันรหัสผ่านอีกครั้ง</td><td><input type="password" name="password2"><font color='red'> *</td></tr>
<tr><td>สิทธิ์</td><td>
	
	<input type="radio" name="status" value="user"  checked>ผู้ใช้ 
	<input type="radio" name="status"  value="admin" >ผู้ดูแลระบบ

<tr><td colspan='4'><center><input type="submit" name="sub" value="เพิ่มผู้ใช้" onClick="return confirm(' คุณแน่ใจที่จะเพิ่มข้อมูลผู้ใช้?')"><input type="submit" name="clear" value="ยกเลิก"></center></td></tr>



</form>
</table>




<?php

if(isset($_POST["sub"])){
	if(($_POST["firstname"]=="") || ($_POST["lastname"]=="")|| ($_POST["agen"]=="")|| ($_POST["username"]=="")|| ($_POST["password"]=="")|| ($_POST["password2"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else if($_POST["password"]!=$_POST["password2"]){
		echo "<font color='red' size='2'>รหัสผ่านไม่ตรงกัน กรุณากรอกใหม่อีกครั้ง<br></font>";
	}else{
	$tblname = "employee"; 
	

	$md5_password =  $_POST["password"];
	$sql = "insert into $tblname (firstname,lastname,username,password,status,IDagen) 
	values 
	('".$_POST["firstname"]."','".$_POST["lastname"]."','".$_POST["username"]."', '".$md5_password."','".$_POST["status"]."', '".$_POST["agen"]."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'main_emp.php';</script>";
	}
}
?>






<table>
<tr>
<td align="center" width="50" BGCOLOR="CCCC66"><b>ลำดับที่</b></td>
<td align="center" width="100" BGCOLOR="CCCC66"><b>ชื่อ</b></td>
<td align="center" width="100" BGCOLOR="CCCC66"><b>หน่วยงาน</b></td>
<td align="center" width="100" BGCOLOR="CCCC66"><b>username</b></td>
<td align="center" width="50" BGCOLOR="CCCC66"><b>สถานะ</b></td>
</tr>

<?php
$query2 = "select IDemp,firstname,lastname,IDagen,username,status from employee"; 
$query_db2 = mysql_query($query2, $dbConn) or die(mysql_error());
$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
$idemp=$row_db2['IDemp'];
?>
<tr>
<td BGCOLOR="ededc9">&nbsp;<?=$count++?></td>
<td BGCOLOR="ededc9">&nbsp;<?=$row_db2['firstname']?>&nbsp;&nbsp;<?=$row_db2['lastname']?> </td>
<?php
$query3 = "select a.agenInitname from agency a,employee e where a.IDagen=e.IDagen and e.IDemp='".$idemp."'"; 
$query_db3 = mysql_query($query3, $dbConn) or die(mysql_error());
$row_db3 = mysql_fetch_assoc($query_db3);//เก็บผลการประมวงผลลงตัวแปร $row_db

do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง

?>
<td BGCOLOR="ededc9">&nbsp;<?=$row_db3['agenInitname']?> </td>
<?php
}while ($row_db3 = mysql_fetch_assoc($query_db3));
?>

<td BGCOLOR="ededc9">&nbsp;<?=$row_db2['username']?> </td>
<td BGCOLOR="ededc9">&nbsp;<?=$row_db2['status']?> </td>

<td BGCOLOR="ededc9"><a href="update_user.php?id=<?=$row_db2['IDemp']?>">[แก้ไข]</a></td>
<td BGCOLOR="ededc9"><a href="delete_user.php?id=<?=$row_db2['IDemp']?>" onClick="return confirm(' คุณแน่ใจที่จะลบ คุณ <?=$row_db['Name']?>?')">[ลบ]</a></td>
</tr>
<?                                                 
                                                      
}while ($row_db2 = mysql_fetch_assoc($query_db2));

?>
</table>

<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
//mysql_free_result($query_db2);//เลิกติดต่อ Mysql
?>


</center>
</body>
</html>