<?php session_start();
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: error.php");
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
<title><?php echo $PGNAME; ?> - Video hinzufügen</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
</head>
<body>
<h2 id="head">Video hinzufügen</h2>
<div id="navigation"><ul><li><a href="#" class="actual">Video hinzufügen</a></li><li><a href="edits.php">Videodetails Bearbeiten</a></li><li><a href="settings.php">Einstellungen</a></li><li style="text-align: right;"><a href="user.php">Benutzername: <?php echo $_SESSION['username']; ?></a></li></ul></div>
<div id="intern">
<form method="POST" action="write.php">
	<p>Titel: <input type="text" name="name" class="textfield"></p>
	<p>SWF URL: <input type="text" name="url" class="textfield"></p>
	Beschreibung:<br/><textarea name="cap" cols="50" rows="10"></textarea><br/>
	<p>Kategorie: <input type="text" name="cat" class="textfield"></p>
	<input type="text" name="what" value="video" style="display:none;">
	<input type="submit" value="hinzufügen" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {
		echo "images/ok.png";
	}
	else {
		echo "images/clear.png";
	}
	?>">
</form>
</div>
<p id="footer"><a href="logout.php">logout</a></p>
</body>
</html>
