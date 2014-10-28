<?php
session_start();
mysql_connect("localhost","root","1234");
mysql_select_db("risk");

$md5_password =  $_POST["pass"];
$strSQL = "SELECT * FROM employee WHERE username = '".($_POST['usern'])."'
and password = '".($md5_password)."'";
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';"); //ให้ใช้การเข้ารหัวอักษรแบบ utf8

	
$objQuery = mysql_query($strSQL);
$objResult = mysql_fetch_array($objQuery);
if(!$objResult){

 echo "<script type='text/javascript'>window.location.href = 'login.php?id=99';</script>";

}
else{
$_SESSION["firstname"] = $objResult["firstname"];
$_SESSION["lastname"] = $objResult["lastname"];
$_SESSION["status"] = $objResult["status"];
$_SESSION["username"] = $objResult["username"];
$_SESSION["IDemp"] = $objResult["IDemp"];
$_SESSION["IDagen"] = $objResult["IDagen"];


	$strSQL2 = "SELECT * FROM employee e, agency a WHERE username =  '".$_SESSION["username"]."' AND e.`IDagen` = a.`IDagen`";
	
	$objQuery2 = mysql_query($strSQL2);
	$objResult2 = mysql_fetch_array($objQuery2);
	if(!$objResult2){
	echo "non agencies!";
	}
	else{

		$_SESSION["agenName"] = $objResult2["agenName"];
	}



session_write_close();
 echo "<script type='text/javascript'>window.location.href = 'index.php';</script>";
}

mysql_close();
?>