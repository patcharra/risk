<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/risk_main.css">

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

$query		= "select IDagen,agenName,agenInitname from agency"; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db
$count		=1;
?>

<br>
<h3>จัดการหน่วยงาน</h3><br><br>

<table>
<form method="post" action="###">

<tr><td><u></b>เพิ่มหน่วยงาน</b></u></td></tr>
<tr><td>ชื่อหน่วยงาน</td><td><input type="text" name="agenName"><font color='red'> *</font></tr>

<tr><td>ชื่อย่อหน่วยงาน</td><td><input type="text" name="agenInitName"><font color='red'> * </font></td></tr>

<tr><td colspan='4'><center><input type="submit" name="sub" value="เพิ่ม" onClick="return confirm(' คุณแน่ใจที่จะเพิ่มข้อมูลหน่วยงาน?')"><input type="submit" name="clear" value="ยกเลิก"></center></td></tr>

</form>
</table>




<?php

if(isset($_POST["sub"])){
	if(($_POST["agenName"]=="") || ($_POST["agenInitName"]=="")){
		echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br></font>";
	}else{
	$tblname = "agency"; 
	

	$sql = "insert into $tblname (agenName,agenInitname) 
	values 
	('".$_POST["agenName"]."','".$_POST["agenInitName"]."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'main_agencies.php';</script>";
	}
}
?>

<?php
$query2 = "select IDagen,agenName,agenInitname from agency"; 
$query_db2 = mysql_query($query2, $dbConn) or die(mysql_error());
$rows = mysql_num_rows($query_db2);
if($rows > 0){

?>


<table class= "table-data">
<tr>
<th></th>
<th></th>
<th align="center" >ลำดับที่</th>
<th align="center" >ชื่อหน่วยงาน</th>
<th align="center" >ชื่อย่อหน่วยงาน</th>
</tr>

<?php
	$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


	do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
	?>
	<tr>
	<td><a href="update_agen.php?id=<?=$row_db2['IDagen']?>"><button>แก้ไข</button></a></td>
	<td><a href="delete_agen.php?id=<?=$row_db2['IDagen']?>" onClick="return confirm(' คุณแน่ใจที่จะลบ  <?=$row_db2['agenName']?>?')"><button>ลบ</button></a></td>
	<td ><center>&nbsp;<?=$count++?></center></td>
	<td >&nbsp;<?=$row_db2['agenName']?> </td>
	<td >&nbsp;<?=$row_db2['agenInitname']?> </td>
	</tr>
	<?                                                 
														  
	}while ($row_db2 = mysql_fetch_assoc($query_db2));

?>
</table>

<?php

}else{
	echo "<font color='red'><i>ไม่พบข้อมูล</i></font>";
}


mysql_free_result($query_db);//เลิกติดต่อ Mysql
//mysql_free_result($query_db2);//เลิกติดต่อ Mysql
?>


</body>
</html>