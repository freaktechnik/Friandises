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
$query = mysql_query("SELECT value FROM settings WHERE name='lang'");
$objResult = mysql_fetch_object($query);
$PGLANG = $objResult->value;
mysql_close($connect);
echo $PGNAME; ?> - Impressum</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="<?php echo $PGLANG; ?>">
<script type="text/javascript" src="jquery-1.6.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#loginlink').click(function(e) {
		e.preventDefault();
		$(this).hide();
		$('#loginform').show();
	});
});
</script>
</head>
<body>
<div id="topnav"><form method="POST" id="loginform" style="display:none;" action="admin/check.php">Username:<input type="text" name="name"/> | Password:<input type="password" name="passwort"/> <input type="submit" value="login"></form><a id="loginlink" href="admin/login.php">Login</a> | <a href="index.php">Home</a></div>
<h1 id="head">Impressum</h1>
<div id="text">
<?php echo $PGDSC; ?><br>
<?php echo $PGNAME; ?> is a link collection of videos. You can watch those videos directly on the page. This page supports youtube and sf videoportal videos, more can be comming soon. The page is built to be simple, for user and owner. It is very simple to add a video.
Neither page owner nor author are responsible for the video content.<br>
This page uses <a href="http://jquery.com">jQuery</a> and <a href="http://fancybox.net">fancybox</a>.<br>
Visit the Friandises project (on which this page is based) on Github: <a href="https://github.com/freaktechnik/Friandises">Friandises on Github</a>.<br>
Flash may be required.<br>
Thx for reading.
</div>
</body>
</html>
