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

$query		= "select IDplan,planName from plan"; 
$query_db	= mysql_query($query, $dbConn) or die(mysql_error());
$row_db		= mysql_fetch_assoc($query_db);//เก็บผลการประมวงผลลงตัวแปร $row_db
$count		=1;
$y=date('Y')+543;
?>

<br>
<h3>นำเข้าข้อมูลโอกาสเกิดความเสี่ยง</h3><br><br>

<table>
<form method="post" action="###">


<tr><td>แผนงาน</td><td><SELECT NAME="plan">

	<?php 
	do{?>
			<option value='<?=$row_db['IDplan']?>'><?=$row_db['planName']?></option>
	<?php }while ($row_db = mysql_fetch_assoc($query_db));?>

</SELECT></td></tr>

<tr><td>ไตรมาส</td><td><SELECT NAME="quarter">
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
</SELECT></td></tr>



<tr><td colspan='4'><center><input type="submit" name="sub" value="เลือก"></center></td></tr>



</form>
</table>




<?php

if(isset($_POST["sub"])){
	$id= $_POST["plan"];
		
	echo "<script type='text/javascript'>window.location.href = 'riskchance.php?id=".$id."&q=".$_POST["quarter"]."';</script>";
	
	
}

$idnew=$_REQUEST["id"];
if($id!=null){

	$id=$_REQUEST["id"];
	$q=$_REQUEST["q"];

	$query2		= "select riskchance_type,unitName,IDunit_riskchance,IDplan,planName,time_year from plan p,unit u where p.IDplan =".$idnew." and p.IDunit_riskchance=u.IDunit"; 
	$query_db2	= mysql_query($query2, $dbConn) or die(mysql_error());
	$row_db2		= mysql_fetch_assoc($query_db2);//เก็บผลการประมวงผลลงตัวแปร $row_db
	

	$query22		= "select riskchance_type,IDplan,planName from plan p where p.IDplan =".$idnew; 
	$query_db22	= mysql_query($query22, $dbConn) or die(mysql_error());
	$row_db22		= mysql_fetch_assoc($query_db22);//เก็บผลการประมวงผลลงตัวแปร $row_db

	if($row_db2['riskchance_type'] == 'quan'){ //โอกาสเกิดความเสี่ยงเชิงปริมาณ
		?>
		<br>
		<table>
		ชื่อแผนงาน  :  <?=$row_db2['planName']?><br> 
		<form method="post" action="insert_riskchance_quan.php">

			 <input type="hidden" name="idplan" value="<?=$id?>">
			 <input type="hidden" name="q" value="<?=$q?>">
			 <input type="hidden" name="IDunitQuan" value="<?=$row_db2['IDunit_riskchance']?>">
			 <input type="hidden" name="year" value="<?=$row_db2['time_year']?>">

			 <tr><td>จำนวณ </td><td><input type="text" name="resultQuan">&nbsp;&nbsp;<?=$row_db2['unitName']?></td>
			 <td ><center><input type="submit" name="sub_quan" value="บันทึก"></center></td></tr >
		</form>
		</table>
		<?php
	}
	else if($row_db22['riskchance_type'] == 'qual'){ //โอกาสเกิดความเสี่ยงเชิงคุณภาพ

		$query3		= "select detail,level,IDrcl from riskchance_qual where IDplan =".$idnew; 
		$query_db3	= mysql_query($query3, $dbConn) or die(mysql_error());
		$row_db3	= mysql_fetch_assoc($query_db3);//เก็บผลการประมวงผลลงตัวแปร $row_db

		?>


		<br>
		ชื่อแผนงาน  :  <?=$row_db22['planName']?><br> 

		<table>
		<form method="post" action="insert_riskchance_qual.php">
			 <tr><td>กรุณาเลือก... </td><td></td></tr>
			 
			 	<?php 
					do{?>
					<tr><td></td><td><input type="radio" name="status" value="<?=$row_db3['IDrcl']?>" >Level <?=$row_db3['level']?> : <?=$row_db3['detail']?></td><tr>
				<?php }while ($row_db3 = mysql_fetch_assoc($query_db3));?>

			 
			 <td colspan='2'><center><input type="submit" name="sub_quan" value="บันทึก"></center></td></tr>
		</form>
		</table>
		<?php

	}
	mysql_close();
}

?>

</body>
</html>