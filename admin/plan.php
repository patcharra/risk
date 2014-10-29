

<html>
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
<?


//ติดต่อฐานข้อมูล
$hostname_krukat = "localhost";
$database_krukat = "risk";
$username_krukat = "root";
$password_krukat = "1234";

$krukat = mysql_pconnect($hostname_krukat, $username_krukat, $password_krukat) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';");

mysql_select_db($database_krukat, $krukat);
$query = "select IDstrategy,strategyName from strategy"; 
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';"); //ให้ใช้การเข้ารหัวอักษรแบบ utf8
$query_db = mysql_query($query, $krukat) or die(mysql_error());
$row_db = mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db


$yearc = $_REQUEST['yearc'];

$count=1;
?>

<br>
<b>แผนงาน</b><br><br>
<table>
<form method="post" action="###">


<tr>
<td>ชื่อแผนงาน</td><td><input type="text" name="nameplan"><font color='red'> *</font></td>
</tr>

<tr><td>กลยุทธ์</td><td><SELECT NAME="strategy">

	<?do{?>
			<option value='<?=$row_db['IDstrategy']?>'><?=$row_db['strategyName']?></option>
	<?}while ($row_db = mysql_fetch_assoc($query_db));?>

</SELECT>
</td></tr>
<tr><td>ความเสี่ยง</td><td><input type="text" name="risk"><font color='red'> * </font></td></tr>
<tr><td>ปัจจัยเสี่ยง</td><td>

1. <input type="text" name="riskFactor1" ><font color='red'> * </font><br>
2. <input type="text" name="riskFactor2" ><font color='red'> * </font> <button class="addRiskFactorBrn">+</button>

</td></tr>
<tr><td>สถานะปัจจุบัน</td><td><input type="text" name="statusnow"><font color='red'> *  </font></td></tr>

<tr><td colspan='4'><center><input type="submit" name="sub" value="เพิ่มแผนงาน" onClick="return confirm(' คุณแน่ใจที่จะสร้างแบบฟอร์ม?')"><input type="submit" name="clear" value="ยกเลิก"></center></td></tr>



</form>
</table>

<table>
<tr>
<td align="center" width="50" BGCOLOR="CCCC66"><b>ลำดับที่</b></td>
<td align="center" width="100" BGCOLOR="CCCC66"><b>ปีที่</b></td>
<td align="center" width="50" BGCOLOR="CCCC66"><b>สถานะ</b></td>
<td align="center" width="50" BGCOLOR="CCCC66"><b>ลบ</b></td>


</tr>

<?php
$query2 = "select Year,Status from formdetail group by Year order by Year"; 
$query_db2 = mysql_query($query2, $krukat) or die(mysql_error());
$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db
do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง

$query222 = "select FormDeID  from formdetail where year='".$row_db2['Year']."'"; 
$query_db222 = mysql_query($query222, $krukat) or die(mysql_error());
$row_db222 = mysql_fetch_assoc($query_db222);//เก็บผลการประมวงผลลงตัวแปร $row_db
$ccc=0;
do{
$query333 = "select PlanAreaID  from planarea where formdeid='".$row_db222['FormDeID']."'"; 
$query_db333 = mysql_query($query333, $krukat) or die(mysql_error());
$row_db333 = mysql_fetch_assoc($query_db333);//เก็บผลการประมวงผลลงตัวแปร $row_db
if(isset($row_db333['PlanAreaID'])){
$ccc=1;
}
}while ($row_db222 = mysql_fetch_assoc($query_db222));
if($ccc==0){
$query222 = "select FormDeID  from formdetail where year='".$row_db2['Year']."'"; 
$query_db222 = mysql_query($query222, $krukat) or die(mysql_error());
$row_db222 = mysql_fetch_assoc($query_db222);//เก็บผลการประมวงผลลงตัวแปร $row_db
do{
$query333 = "select ReAreaID  from resultarea where formdeid='".$row_db222['FormDeID']."'"; 
$query_db333 = mysql_query($query333, $krukat) or die(mysql_error());
$row_db333 = mysql_fetch_assoc($query_db333);//เก็บผลการประมวงผลลงตัวแปร $row_db
if(isset($row_db333['PlanAreaID'])){
$ccc=1;
}
}while ($row_db222 = mysql_fetch_assoc($query_db222));
}
?>
<tr>
<td BGCOLOR="ededc9">&nbsp;<?=$count++?></td>
<td BGCOLOR="ededc9">&nbsp;<?=$row_db2['Year']?></td>
<td BGCOLOR="ededc9"><a href="edit_topic.php?year=<?=$row_db2['Year']?>&status=<?=$row_db2['Status']?>"     <?if($row_db2['Status']=='off'){?>onClick="return confirm(' คุณแน่ใจที่่จะเปิดใช้งานแบบฟอร์มปี <?=$row_db2['Year']?> ?\n')"<?}else if($row_db2['Status']=='on'){?>onClick="return confirm(' คุณแน่ใจที่่จะปิดการใช้งานแบบฟอร์มปี <?=$row_db2['Year']?> ?\n')"<?}?>>[<?=$row_db2['Status']?>]</a></td>
<td align="center"  BGCOLOR="ededc9"><?if($row_db2['Status']=='off'){?><a href="delete_topic.php?year=<?=$row_db2['Year']?>" <?if($ccc==0){?>onClick="return confirm(' คุณแน่ใจที่จะลบแบบฟอร์มปี <?=$row_db2['Year']?> ?\n')"<?}else if($ccc==1){?>onClick="return confirm('แบบฟอร์มปี <?=$row_db2['Year']?> มีข้อมูลอยู่แล้ว\nคุณแน่ใจที่จะลบ ?')"<?}?>><?}else{?><a href="main_topic.php" onClick="return confirm(' ขณะนี้แบบฟอร์มปี<?=$row_db2['Year']?>\nถูกเปิดใช้งานอยู่คุณไม่สามารถลบแบบฟอร์มนี้ได้  ')"><?}?><img src="close.png" width=20></a></td>
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