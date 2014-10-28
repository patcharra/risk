<html>
<body>
<br><br><br><br><br><br><br><br><br>
<center>

<font size=5>***ยินดีต้อนรับ คุณ 

<?
session_start(); 
echo $_SESSION["firstname"]."  ".$_SESSION["lastname"];

?>
 เข้าสู่ระบบ***</font><br>
<img src="mainLine.png" width=500><br>

<?
if($_SESSION["status"] == "admin"){
?>

คุณได้เข้าใช้งานระบบด้วยสิทธิ์ของ "ผู้ดูแลระบบ"<br>
<?}else if($_SESSION["status"] == "user"){?>
คุณได้เข้าใช้งานระบบด้วยสิทธิ์ของ "ผู้ใช้"<br>

<?}else{?>
คุณได้เข้าใช้งานระบบด้วยสิทธิ์ของ "ผู้อำนวยการ"

<?}?>
จาก

<?
echo $_SESSION["agenName"];
?>

</center>

</body>
</html>