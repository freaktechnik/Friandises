<?php session_start();
include_once('config.php');
$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");

if($_SESSION['access']==allowd) {
    header("Location: intern.php");
}

include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Log in</title>
<link rel="stylesheet" href="/<?php echo $PG_LOCA; ?>style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
</head>
<body>
<div id="topnav"><a href="/index.php">Home</a></div>
<h2 id="head">Log in</h2>
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
	?>"><input type="submit" value="Log in"></td></tr>
</table>
</form>
<a href="newpw.php">Forgot password?</a>
</div>
</body>
</html>
