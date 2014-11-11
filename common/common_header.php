<?
/*
 * Database
 */
define('DB_HOST', 		'localhost');
define('DB_USERNAME', 	'root');
define('DB_PASSWORD', 	'root');
define('DB_NAME', 		'risk');

/*
 * Global Connection
 */
$dbConn;
dbConnect();
function dbConnect() {
	global $dbConn;
	$dbConn = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
	if($dbConn) {
		if(mysql_select_db(DB_NAME, $dbConn)) {
			// Initial
			mysql_query("SET NAMES UTF8", $dbConn);
		} else {
			throw new Exception('Cannot select database');
		}
	} else {
		throw new Exception('Cannot connect host');
	}
}
function dbClose() {
	global $dbConn;
	return mysql_close($dbConn);
}

function redirect($url) {
	echo "<script>window.location.href='$url'</script>";
}

$date_now 	= date('d');
$month_now 	= date('m');
$year_now 	= date('Y');
?>

