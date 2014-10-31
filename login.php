<?
session_start();
session_destroy();
?>
<html>
<head>

<meta http-equiv=Content-Type content="text/html; charset=utf-8">
</head>
<body>


<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<center><div border=0   class="output_box" style="
background-image:-webkit-gradient(linear,left top,left bottom,from( #ffffff ),to( #FF3300 ));
background-image:-webkit-linear-gradient( #ffffff,#FF3300 );
background-image: -moz-linear-gradient( #ffffff,#FF3300 );
background-image: -ms-linear-gradient( #ffffff,#FF3300 );
background-image: -o-linear-gradient( #ffffff,#FF3300 );
background-image: linear-gradient( #ffffff,#FF3300 ); 
border-top-width: 0px;
border-right-width: 0px;
border-left-width: 0px;
border-bottom-width: 0px;
padding: 0px 0px 0px 0px;
margin: 0px 0px 0px 0px;
border-radius:10px;
box-shadow: black 0.7em 1em 1em;
width:550px;">
<center>
	<form name="form1" method="post" action="check_login.php">
		<img src="login_icon.png" width="90"><B><font size=4>เข้าสู่ระบบ</font></B> 
		<table>
			<tr><td>  ชื่อผู้ใช้ :</td><td><input type="text" name="usern"></td><br>
			<tr><td>รหัสผู้ใช้ :</td><td><input type="password" name="pass"></td><br>

			<tr><td></td><td><input type="submit" name="subm" value="เข้าสู่ระบบ">
			</td>

		</table>
	</form>

	<?php 
	$check = $_GET["id"];
	if($check == 99){
		echo "ชื่อผู้ใช้ หรือ รหัสผู้ใช้ไม่ถูกต้อง!";
	}
	
	?>
</center>

<br><br>
<br><br>

<center><font size=1>© 2014 สำนักนโยบายแผนและงบประมาณ องค์การอุตสาหกรรมป่าไม้  โทรสาร 0-2629-8660</font></center>
</div></center>

</body>
</html>