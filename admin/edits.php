<?php session_start();
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /error.php");
}
else {
	$_SESSION['access']=allowd;
}
include 'config.php';
$c=1;

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
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

$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category, date FROM content WHERE id='1'");
$objResult = mysql_fetch_object($query);
$inshtml="<li><a href='edit.php?id=1' title='".$objResult->name."'><img src='".$objResult->thumbnail."' alt='".$objResult->name."'>".$objResult->name." - ".$objResult->date."</a></li>";
$c=2;
$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category, date FROM content WHERE id='$c'");
$objResult = mysql_fetch_object($query);
do {
	$inshtml=$inshtml."<li><a href='edit.php?id=".$c."' title='".$objResult->name."'><img src='".$objResult->thumbnail."' alt='".$objResult->name."'>".$objResult->name." - ".$objResult->date."</a></li>";
	$c=$c+1;
	$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category, date FROM content WHERE id='$c'");
	$objResult = mysql_fetch_object($query);
} while($objResult->hello==1);

mysql_close($connect);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Videoinfos Bearbeiten</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="Geschichte,History,Videos,Filme,Geschichts Videos,Geschichts Filme">
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" >
</head>
<body>
<div id="topnav"><a href="logout.php">logout</a></div>
<h2 id="head">Videoinfos Bearbeiten</h2>
<div id="navigation"><ul><li><a href="intern.php">Video hinzufügen</a></li><li><a href="#" class="actual">Videodetails Bearbeiten</a></li><?php if($_SESSION['admin']==1) {echo '<li><a href="settings.php">Einstellungen</a></li>';} ?><li style="text-align: right;"><a href="user.php">Benutzername: <?php echo $_SESSION['username']; ?></a></li></ul></div><br>
<div id="edits"><ul><?php echo $inshtml; ?></ul></div>
</body>
</html>
