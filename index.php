

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- This Site Was Designed By Wayne D. Fields Contact: deonya22@yahoo.com -->
<html>
<head>

<meta charset="utf-8">
<meta NAME="description" CONTENT="Insert Description Here">
<meta NAME="keywords" CONTENT="Insert Keywords Here">
<script language="javascript">
function onUnloadPage()
{
	if ((window.event.clientX < 0) && (window.event.clientY < 0))
	{
	window.open('logout.php');
	}
}
</script>
</head>

<!--<frameset cols="*,960,*" border="0">-->
<FRAMESET COLS="40,620,40" border="0">
<FRAME src="xxx.html">
<frameset rows="90,330,20" border="2" >
	      <frame name="heading" src="logo.html" marginwidth="0" topmargin="0" leftmargin="0" marginheight="0" scrolling="no" frameborder="no" noresize>
	<frameset cols="150,*" border="0">

<?php session_start(); 
if($_SESSION["status"] == "admin")
{
?>

			<frame name="menu" src="menu2.html" marginwidth="0" topmargin="0" leftmargin="0" marginheight="0" scrolling="no" frameborder="no" noresize>

<?php }else if($_SESSION["status"] == "user")
{
?>

			<frame name="menu" src="menu.html" marginwidth="0" topmargin="0" leftmargin="0" marginheight="0" scrolling="no" frameborder="no" noresize>

<?php }?>

			<frame name="main" src="main.php" marginwidth="0" topmargin="0" leftmargin="0" marginheight="0" scrolling="yes" frameborder="no" noresize> 
	</frameset>
	<frame name="footer" src="footer.html" marginwidth="0" topmargin="0" leftmargin="0" marginheight="0" scrolling="no" frameborder="no" noresize>
</frameset>
<!--</frameset>-->

<noframes>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" onUnload="onUnloadPage();">
</body>
</noframes>

</frameset>
<FRAME src="xxx.html">
</FRAMESET>
</html>
