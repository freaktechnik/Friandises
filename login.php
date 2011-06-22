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
if($_SESSION['access']==allowd) {
    header("Location: intern.php");
}
mysql_close($connect);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Login</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
</head>
<body>
<h2 id="head">Login</h2>
<div id="login">
<form method="POST" action="check.php">
	<table><tr><td>Username:</td><td><input type="text" name="name"/></td></tr>
	<tr><td>Password:</td><td><input type="password" name="passwort"/></td></tr>
	<tr><td></td><td style="text-align: right;"><img class="sym" src="<?php if($_GET['fail']=='true') {
		echo "images/wrong.png";
	}
	else {
		echo "images/clear.png";
	}
	?>"><input type="submit" value="login"></td></tr>
</table>
</form>
</div>
<p id="footer"><a href="index.php">Home</a></p>
</body>
</html>
