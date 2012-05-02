<?php session_start();
if(($_SESSION['access']!=allowd||$_SESSION['access']==NULL)|$_SESSION['admin']==0)
{
    session_destroy(); 
	header("Location: /error.php");
    break;
}
else {
	$_SESSION['access']=allowd;
}
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Benutzer erstellen</title>
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Benutzer erstellen</h2>
<?php include 'menu.php'; ?>
<div id="intern">
<form method="POST" action="write.php">
	<p>Benutzername: <input type="text" name="name" class="textfield"><img class="sym" src="<?php if($_GET['suc']==3) {
		echo "images/wrong.png";
	}
	else {
		echo "images/clear.png";
	}
	?>"></p>
	<p>e-Mail: <input type="email" name="email" class="textfield"><img class="sym" src="<?php if($_GET['suc']==4) {
		echo "images/wrong.png";
	}
	else {
		echo "images/clear.png";
	}
	?>"></p>
	<p>Soll der Benutzer Adminrechte besitzen? <input type="radio" name="admin" value="0" checked> Nein <input type="radio" name="admin" value="1" > Ja</p>
	<input type="text" name="action" value="user" style="display:none;">
	<input type="submit" value="Erstellen" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {
		echo "images/ok.png";
	}
	else if($_GET['suc']==2) {
		echo "images/wrong.png";
	}
	else {
		echo "images/clear.png";
	}
	?>">
</form>
</div>
</body>
</html>
