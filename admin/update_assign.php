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


$query0		= "select g.agenName,g.IDagen from agency g"; 
$query_db0	= mysql_query($query0, $dbConn) or die(mysql_error());
$row_db0		= mysql_fetch_assoc($query_db0);//เก็บผลการประมวงผลลงตัวแปร $row_db


$query		= "select g.agenName,g.IDagen from agency g,assignment a where a.IDagen = g.IDagen and a.IDassign =".$id; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db



$query11		= "select r.rmpName,r.IDrmp from risk_manage_plan r "; 
$query_db11	= mysql_query($query11, $dbConn) or die(mysql_error());
$row_db11		= mysql_fetch_assoc($query_db11);//เก็บผลการประมวงผลลงตัวแปร $row_db


$query1		= "select r.rmpName,r.IDrmp from risk_manage_plan r,assignment a where a.IDrmp = r.IDrmp and a.IDassign =".$id; 
$query_db1	= mysql_query($query1, $dbConn) or die(mysql_error());
$row_db1		= mysql_fetch_assoc($query_db1);//เก็บผลการประมวงผลลงตัวแปร $row_db

?>

<br>
<h3>แก้ไขการมอบหมายงาน</h3><br><br>
<table>
<form method="post" action="###">



<tr><td>แผนบริหารความเสี่ยง</td><td><SELECT NAME="rmpName">

	<?php 
	do{
	?>
			<option value='<?=$row_db11['IDrmp']?>' <?php if($row_db11['IDrmp'] == $row_db1['IDrmp']){echo "selected";}?>><?=$row_db11['rmpName']?></option>
	<?php }while ($row_db11 = mysql_fetch_assoc($query_db11));?>

</SELECT>

<tr><td>ชื่อหน่วยงานที่ได้รับมอบหมาย</td><td><SELECT NAME="agenName">

	<?php 
	do{
	?>
			<option value='<?=$row_db0['IDagen']?>' <?php if($row_db0['IDagen'] == $row_db['IDagen']){echo "selected";}?>><?=$row_db0['agenName']?></option>
	<?php }while ($row_db0 = mysql_fetch_assoc($query_db0));?>

</SELECT>





<input type="hidden" name="id" value="<?=$id?>">

<tr><td colspan='4'><center><input type="submit" name="sub" value="แก้ไข" onClick="return confirm(' คุณแน่ใจที่จะแก้ไขข้อมูล?')">


</form>
<a href="main_assign.php"><button>ยกเลิก</button></a></center></td></tr>
</table>


<?php

if(isset($_POST["sub"])){
$rmpName = $_POST["rmpName"];
$agenName = $_POST["agenName"];

$query2		= "select IDagen from agency where agenName = ".$agenName; 
$query_db2	= mysql_query($query2, $dbConn) or die(mysql_error());
$row_db2		= mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


$query3		= "select IDrmp from risk_manage_plan where rmpName = ".$rmpName;  
$query_db3	= mysql_query($query3, $dbConn) or die(mysql_error());
$row_db3		= mysql_fetch_assoc($query_db3);//เก็บผลการประมวงผลลงตัวแปร $row_db



$tblname = "assignment"; 
	
$id	= $_REQUEST["id"];

			$sql = "Update $tblname Set IDrmp='".$row_db3["IDrmp"]."',IDagen='".$row_db2["IDagen"]."' Where IDassign='$id'";
	
	$dbquery = mysql_query($sql, $dbConn);

	echo "<script type='text/javascript'>window.location.href = 'main_assign.php';</script>";
}
?>


<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
?>


</body>
</html>