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
$query = mysql_query("SELECT value FROM settings WHERE name='desc'");
$objResult = mysql_fetch_object($query);
$PGDSC = $objResult->value;
mysql_close($connect);
 echo $PGNAME; ?>- What's this?</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
</head>
<body>
<h1 id="head">What's this?</h1>
<div id="text">
<b>Description:</b>
<p><?php echo $PGDSC; ?><p>
<?php echo $PGNAME; ?> is a link collection of videos. You can watch those videos directly on the page. This page supports youtube and sf videoportal videos, more can be comming soon. the page is built to be simple, for user and owner. It is very simple to add a video.
</div>
<p id="footer"><a href="index.php">Home</a> | <a href="impressum.php">Impressum</a> | <a href="admin/login.php">Login</a></p>
</body>
</html>
