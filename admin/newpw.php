<?php session_start();
include_once ("config.php");
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');

if($_SESSION['access']==allowd) {
    header("Location: intern.php");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Forgot Password</title>
<link rel="stylesheet" href="/<?php echo $PG_LOCA;?>style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
</head>
<body>
<div id="topnav"><a href="/index.php">Home</a></div>
<h2 id="head">Forgot Password</h2>
<div id="login">
<form method="POST" action="pwrec.php">
	<table><tr><td>Username:</td><td><input type="text" name="name"/></td></tr>
	<tr><td>E-Mail:</td><td><input type="email" name="email"/></td></tr>
	<tr><td></td><td style="text-align: right;"><img class="sym" src="<?php if($_GET['fail']=='true') {
		echo "images/wrong.png";
	}
	else if($_GET['fail']=='false') {
		echo "images/ok.png";
	}
	else {
		echo "images/clear.png";
	}
	?>"><input type="submit" value="Get new password!"></td></tr>
</table>
</form>
</div>
</body>
</html>
