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

$query		= "select IDunit,unitName from unit"; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db
$count		=1;
?>

<br>
<h3>จัดการหน่วยนับ</h3><br><br>

<table>
<form method="post" action="###">

<tr><td><u></b>เพิ่มหน่วยนับ</b></u></td></tr>
<tr>
<td>ชื่อหน่วยนับ</td><td><input type="text" name="unitname"><font color='red'> *</font>
</tr>


<tr><td colspan='4'><center><input type="submit" name="sub" value="เพิ่ม" onClick="return confirm(' คุณแน่ใจหรือไม่ที่จะเพิ่มหน่วยนับ?')"><input type="submit" name="clear" value="ยกเลิก"></center></td></tr>

</form>
</table>




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



<?php
$query2 = "select IDunit,unitName from unit"; 
$query_db2 = mysql_query($query2, $dbConn) or die(mysql_error());
$rows = mysql_num_rows($query_db2);
if($rows > 0){

?>




<table class= "table-data">
<tr>
<th></th>
<th></th>
<th align="center" >ลำดับที่</th>
<th align="center" >ชื่อหน่วยนับ</th>
</tr>

<?php
$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
?>
<tr>
<td><a href="update_unit.php?id=<?=$row_db2['IDunit']?>"><button>แก้ไข</button></a></td>
<td><a href="delete_unit.php?id=<?=$row_db2['IDunit']?>" onClick="return confirm(' คุณแน่ใจที่จะลบ  <?=$row_db2['unitName']?>?')"><button>ลบ</button></a></td>
<td ><center>&nbsp;<?=$count++?></center></td>
<td >&nbsp;<?=$row_db2['unitName']?> </td>
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