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

$query3 = "select IDrmp,rmpName from risk_manage_plan "; 
$query_db3 = mysql_query($query3, $dbConn) or die(mysql_error());
$row_db3 = mysql_fetch_assoc($query_db3);//เก็บผลการประมวงผลลงตัวแปร $row_db

?>

<br>
<h3>มอบหมายแผนงาน</h3><br><br>

<table>
<form method="post" action="###">

<tr><td>แผนบริหารความเสี่ยง</td>
<td><SELECT NAME="plan">

	<?php 
	do{?>
			<option value='<?=$row_db3['IDrmp']?>'><?=$row_db3['rmpName']?></option>
	<?php }while ($row_db3 = mysql_fetch_assoc($query_db3));?>

</SELECT>
</td></tr>


<tr><td>ชื่อหน่วยงาน</td>
<td><SELECT NAME="agen">

	<?php 
	do{?>
			<option value='<?=$row_db['IDagen']?>'><?=$row_db['agenName']?></option>
	<?php }while ($row_db = mysql_fetch_assoc($query_db));?>

</SELECT>
</td></tr>





<tr><td colspan='4'><center><input type="submit" name="sub" value="บันทึก" onClick="return confirm(' คุณแน่ใจที่จะบันทึกการมอบหมาย?')"><input type="submit" name="clear" value="ยกเลิก"></center></td></tr>

</form>
</table>




<?php

if(isset($_POST["sub"])){
	
	$tblname = "assignment"; 
	
	$sql = "insert into $tblname (IDrmp,IDagen) 
	values 
	('".$_POST["plan"]."','".$_POST["agen"]."')"; 
	$dbquery = mysql_query($sql, $dbConn);
	
	mysql_close();
	echo "<script type='text/javascript'>window.location.href = 'main_assign.php';</script>";
	
}
?>

<?php
$query2 = "select IDassign,agenName,rmpName from assignment a, agency aa,risk_manage_plan r where a.IDrmp = r.IDrmp and a.IDagen = aa.IDagen order by IDassign"; 
$query_db2 = mysql_query($query2, $dbConn) or die(mysql_error());
$rows = mysql_num_rows($query_db2);
if($rows > 0){

?>
<table class= "table-data">
<tr>
<th></th>
<th></th>
<th align="center" >ลำดับที่</th>
<th align="center" >แผนบริหารความเสี่ยง</th>
<th align="center" >ชื่อหน่วยงาน</th>
</tr>

<?php

	$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


	do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
	?>
	<tr>
	<td><a href="update_assign.php?id=<?=$row_db2['IDassign']?>"><button>แก้ไข</button></a></td>
	<td><a href="delete_assign.php?id=<?=$row_db2['IDassign']?>" onClick="return confirm(' คุณแน่ใจที่จะลบ?')"><button>ลบ</button></a></td>
	<td ><center>&nbsp;<?=$count++?></center></td>
	<td >&nbsp;<?=$row_db2['rmpName']?> </td>
	<td >&nbsp;<?=$row_db2['agenName']?> </td>
	</tr>
	<?php                                                 
														  
	}while ($row_db2 = mysql_fetch_assoc($query_db2));


?>
</table>



<?php

}else{
	echo "<font color='red'><i>ไม่พบข้อมูล</i></font>";
}

mysql_free_result($query_db);//เลิกติดต่อ Mysql
?>


</body>
</html>