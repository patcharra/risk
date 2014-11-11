
<html>
<body>
<center>

<style type="text/css">

td{font-family:arial, sans-serif; font-size:15px;}
</style>


<br>

<?/////////////////////ส่วนแสดงรายการ///////////////////////////?>


<?php
date_default_timezone_set('Asia/Bangkok');

$username = $_SESSION["username"];
//ติดต่อฐานข้อมูล
$hostname_krukat = "localhost";
$database_krukat = "risk";
$username_krukat = "root";
$password_krukat = "root";

$krukat = mysql_pconnect($hostname_krukat, $username_krukat, $password_krukat) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';");

mysql_select_db($database_krukat, $krukat);

?>
<?if(isset($username)){?>
 
<b>เปลี่ยนรหัสผ่าน<b><br>
<table>
<form method="post" action="change_password.php">
	
	<tr><td>Passwordเก่า</td><td><input type="password" name="password"></td></tr>
	<tr><td>Passwordใหม่</td><td><input type="password" name="npassword1"></td></tr>
	<tr><td>ยืนยันPasswordใหม่</td><td><input type="password" name="npassword2"></td></tr>

	<tr><td></td><td><input type="submit" name="sub" value="บันทึก"  onClick="return confirm(' คุณแน่ใจที่จะแก้ไขข้อมูลผู้ใช้?')">
	<input type="submit" name="clear" value="ยกเลิก"></td></tr>

</form>
</table>

<?

	if(isset($_POST["sub"])){
	$hostname = "localhost"; 
	$user = "root";
	$password = "root"; 
	$dbname = "risk"; 
	$tblname = "employee"; 

	mysql_connect($hostname, $user, $password) or die("ติดต่อฐานข้อมูลไม่ได้");

	mysql_select_db($dbname) or die("เลือกฐานข้อมูลไม่ได้");
	
	$query = "select IDemp,password from employee where username='".$username."'"; 
	mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';"); //ให้ใช้การเข้ารหัวอักษรแบบ utf8
	$query_db = mysql_query($query, $krukat) or die(mysql_error());
	$row_db = mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db

	$md5_passwordo =  $_POST["password"];

		if(($_POST["password"]=="") || ($_POST["npassword1"]=="")|| ($_POST["npassword2"]=="")){
			echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
		}else if($md5_passwordo != $row_db["password"]){
			echo "<font color='red' size='2'>รหัสผ่านไม่ถูกต้อง กรุณากรอกใหม่อีกครั้ง<br></font>";
		}else if($_POST["npassword1"]!=$_POST["npassword2"]){
			echo "<font color='red' size='2'>รหัสผ่านไม่ตรงกัน กรุณากรอกใหม่อีกครั้ง<br></font>";
		}else{
			$md5_password = $_POST["npassword1"];
			$sql = "Update $tblname Set password='".$md5_password."' Where IDemp='".$row_db['IDemp']."' ";
			$dbquery = mysql_db_query($dbname, $sql);
			mysql_close();
			echo"<script language=\"JavaScript\">";
			echo"alert('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว')";
			echo"</script>";
			echo "<script type='text/javascript'>window.location.href = 'change_password.php';</script>";
		}
	
	}


?>
<?}else{echo "กรุณาล็อกอินใหม่!!";}?>


</center>
</body>
</html>