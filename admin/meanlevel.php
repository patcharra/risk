<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="../css/risk_main.css">
<style> 
	.displaydata tr .deletebtn{
		display: none;
	}
	.displaydata tr:last-child .deletebtn{
		display: inline;
	}
</style>
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

$query		= "select max(levelP) maxlevel from  level_and_meanP "; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db

$query1		= "select max(levelO) maxlevel from  level_and_meanO "; 
$query_db1	= mysql_query($query1, $dbConn) or die(mysql_error());
$row_db1	= mysql_fetch_assoc($query_db1);//เก็บผลการประมวงผลลงตัวแปร $row_db


?>

<br>
<h3>จัดการระดับและความหมาย</h3><br><br>





<table>
<tr><td width= 500><u><button><a href="meanlevel.php?id=btnO">เพิ่มระดับและความหมายของโอกาสจะเกิดความเสี่ยง</button></u></td>

<td><u><button><a href="meanlevel.php?id=btnP">เพิ่มระดับและความหมายของผลกระทบต่อองค์กร</button></u></td></tr>
<tr><td width= 500>

<?php
if($_REQUEST["id"]== "btnO"){

?>

<form method="post" action="###">
<table>
<tr><td>ระดับ</td><td><input type="text" name="level" value="<?php echo $row_db1['maxlevel']+1 ?>" readonly ></td></tr>

<tr><td>ความหมาย</td><td><input type="text" name="mean"><font color='red'> * </font></td></tr>

<tr><td colspan='4'><center><input type="submit" name="addO" value="เพิ่ม" onClick="return confirm(' คุณแน่ใจที่จะเพิ่มระดับ?')">
<input type="submit" name="clear" value="ยกเลิก"></center></td></tr>
</table>
</form>
<?php
}
?>
</td>

<td>
<?php

if($_REQUEST["id"]== "btnP"){

?>

<form method="post" action="###">
<table >
<tr><td>ระดับ</td><td><input type="text" name="level" value="<?php echo $row_db['maxlevel']+1 ?>" readonly ></td></tr>

<tr><td>ความหมาย</td><td><input type="text" name="mean"><font color='red'> * </font></td></tr>

<tr><td colspan='4'><center><input type="submit" name="addP" value="เพิ่ม" onClick="return confirm(' คุณแน่ใจที่จะเพิ่มระดับ?')">
<input type="submit" name="clear" value="ยกเลิก"></center></td></tr>
</table>
</form>
<?php
}
?>
</td></tr>
</table>




<?php
	

	
	if(isset($_POST["addO"])){
		$tblname = "level_and_meanO"; 
		$colname = "levelO";
		
		if(($_POST["mean"]=="")){
			echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br><br><br></font>";
		}
		else{
			$sql = "insert into $tblname ($colname,mean) values ('".$_POST["level"]."','".$_POST["mean"]."')"; 
			$dbquery = mysql_query($sql, $dbConn);
			
			mysql_close();
			echo "<script type='text/javascript'>window.location.href = 'meanlevel.php';</script>";

			echo "sql = ".$sql;
		}
	}
	else if(isset($_POST["addP"])){
		$tblname = "level_and_meanP"; 
		$colname = "levelP";

		if(($_POST["mean"]=="")){
			echo "<font color='red' size='2'>กรุณากรอกข้อมูลให้ครบถ้วน<br><br><br></font>";
		}
		else{
			$sql = "insert into $tblname ($colname,mean) values ('".$_POST["level"]."','".$_POST["mean"]."')"; 
			$dbquery = mysql_query($sql, $dbConn);
			
			mysql_close();
			echo "<script type='text/javascript'>window.location.href = 'meanlevel.php';</script>";

			echo "sql = ".$sql;
		}

	}

?>


<table >
<tr><td width= 500 style="vertical-align:top;">


<table class= "table-data displaydata" >
<tr><th align="center" colspan="4" width="300" >โอกาสจะเกิดความเสี่ยง</th></tr>
<tr>
<th></th>
<th></th>
<th align="center" >ระดับ</th>
<th align="center" >ความหมาย</th>

</tr>

<?php
$query2 = "select levelO,mean from  level_and_meanO "; 
$query_db2 = mysql_query($query2, $dbConn) or die(mysql_error());
$row_db2 = mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db


do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
?>
<tr>
<td><a href="update_levelO.php?id=<?=$row_db2['levelO']?>"><button>แก้ไข</button></a></td>
<td><a href="delete_levelO.php?id=<?=$row_db2['levelO']?>" onClick="return confirm(' คุณแน่ใจที่จะลบระดับ   <?=$row_db2['levelO']?>?')"><button class="deletebtn">ลบ</button></a></td>
<td ><center>&nbsp;<?=$row_db2['levelO']?></center></td>
<td >&nbsp;<?=$row_db2['mean']?> </td>
</tr>
<?php                                                
                                                      
}while ($row_db2 = mysql_fetch_assoc($query_db2));
?>
</table>



</td>
<td width= 300  style="vertical-align:top;">

<table class= "table-data displaydata">
<tr><th align="center" colspan="4" width="300">ผลกระทบต่อองค์กร</th></tr>
<tr>
<th></th>
<th></th>
<th align="center" >ระดับ</th>
<th align="center" >ความหมาย</th>

</tr>

<?php
$query3 = "select levelP,mean from  level_and_meanP "; 
$query_db3 = mysql_query($query3, $dbConn) or die(mysql_error());
$row_db3 = mysql_fetch_assoc($query_db3);//เก็บผลการประมวงผลลงตัวแปร $row_db


do{ //คำสั้ง loop ของ php เพื่อนำข้อมูลมาแสดง
?>
<tr>
<td><a href="update_levelP.php?id=<?=$row_db3['levelP']?>"><button>แก้ไข</button></a></td>
<td><a href="delete_levelP.php?id=<?=$row_db3['levelP']?>" onClick="return confirm(' คุณแน่ใจที่จะลบระดับ   <?=$row_db3['levelP']?>?')"><button class="deletebtn">ลบ</button></a></td>
<td ><center>&nbsp;<?=$row_db3['levelP']?></center></td>
<td >&nbsp;<?=$row_db3['mean']?> </td>
</tr>
<?php                                                
                                                      
}while ($row_db3 = mysql_fetch_assoc($query_db3));
?>
</table>

</td></tr>
</table>

<?php
mysql_free_result($query_db);//เลิกติดต่อ Mysql
//mysql_free_result($query_db2);//เลิกติดต่อ Mysql
?>


</body>
</html>