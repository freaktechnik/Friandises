<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php include 'admin/config.php';$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);
$query = mysql_query("SELECT value FROM settings WHERE name='name'");
$objResult = mysql_fetch_object($query);
$PGNAME = $objResult->value;
mysql_close($connect);
echo $PGNAME; ?> - Impressum</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
</head>
<body>
<h1 id="head">Impressum</h1>
<div id="text">
<?php echo $PGNAME; ?> - <?php echo date('Y'); ?> all rights reserved
Page written by <a href="http://simcity4.bplaced.net">Martin Giger</a>.<br>
Neither page owner nor author are responsible for the video content.<br>
This page uses <a href="http://jquery.com">jQuery</a> and fancybox.<br>
Flash may be required.<br>
Thx for reading.
</div>
<p id="footer"><a href="index.php">Home</a> | <a href="whatsthis.php">What's this</a> | <a href="admin/login.php">Login</a></p>
</body>
</html>
