<?
require('../common/common_header.php');
$code = '';
if(isset($_REQUEST['code'])) {
	// Edit data will select
	$code 	= $_REQUEST['code'];
	$sql 	= "SELECT 	typeName 
				FROM 	risktype 
				WHERE 	IDtype = '$code'";
	$result = mysql_query($sql, $dbConn);
	$rows	= mysql_num_rows($result);
	if($rows > 0) {
		$rsktypRow = mysql_fetch_assoc($result);
		$risktype  = $rsktypRow['risktype'];
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/risk_main.css">
</head>
<body>

</body>
</html>