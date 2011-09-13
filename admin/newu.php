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
<div id="navigation"><ul><li><a href="intern.php">Video hinzufügen</a></li><li><a href="edits.php">Videodetails Bearbeiten</a></li><?php if($_SESSION['admin']==1) {echo '<li><a href="settings.php">Einstellungen</a></li><li><a href="#" class="actual">Benutzer hinzufügen</a></li>';} ?><li style="text-align: right;"><a href="user.php">Benutzername: <?php echo $_SESSION['username']; ?></a></li></ul></div>
<div id="intern">
<form method="POST" action="write.php">
	<p>Benutzername: <input type="text" name="name" class="textfield"></p>
	<p>e-Mail: <input type="email" name="email" class="textfield"></p>
	<p>Soll der Benutzer Adminrechte besitzen? <input type="radio" name="admin" value="0" checked> Nein <input type="radio" name="admin" value="1" > Ja</p>
	<input type="text" name="what" value="newu" style="display:none;">
	<input type="submit" value="Erstellen" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {
		echo "images/ok.png";
	}
	else {
		echo "images/clear.png";
	}
	?>">
</form>
</div>
</body>
</html>
