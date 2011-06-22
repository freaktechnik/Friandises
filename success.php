<?php session_start();
include 'config.php';
$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);
$query = mysql_query("SELECT value FROM settings WHERE name='name'");
$objResult = mysql_fetch_object($query);
$PGNAME = $objResult->value;
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: error.php");
}
else {
	$_SESSION['access']=allowd;
}
mysql_close($connect);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo $PGNAME; ?> - Erfolgreich</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
		<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
    </head>
<body>
   <h2 id="head">Erfolgreich gespeichert.</h2>
   <div id="text"><a href="intern.php">Zurück</a></div>
</body>
</html>
