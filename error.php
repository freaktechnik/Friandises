<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php include 'admin/config.php';
		$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);
$query = mysql_query("SELECT value FROM settings WHERE name='name'");
$objResult = mysql_fetch_object($query);
$PGNAME = $objResult->value;
mysql_close($connect);
echo $PGNAME; ?> - Error 401 Access denied</title>
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" >
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
	<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
    </head>
<body>
   <h2 id="head">Error 401 Access denied</h2>
   <div id="text"><a href="index.php">Home</a></div>
   <div id="bottom">
		<div id="footer">
			<a href="impressum.php">Impressum</a> | <a href="<?php echo $PGURL; ?>/admin/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" /></a>
		</div>
	</div>
</body>
</html>
