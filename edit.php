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
$id=$_GET['id'];

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

$query = mysql_query("SELECT name, url, caption, thumbnail, category FROM content WHERE id='$id'");
$objResult = mysql_fetch_object($query);
$name=$objResult->name;
$url=$objResult->url;
$caption=$objResult->caption;
$thumbnailURL=$objResult->thumbnail;
$category=$objResult->category;

mysql_close($connect);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Videoinfos von Video <?php echo $name; ?> bearbeiten</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="Geschichte,History,Videos,Filme,Geschichts Videos,Geschichts Filme">
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
</head>
<body>
<h2 id="head">Videoinfos Videoinfos von Video <?php echo $name; ?> bearbeiten</h2>
<div id="navigation"><ul><li><a href="intern.php">Video hinzufügen</a></li><li><a href="#" class="actual">Videodetails Bearbeiten</a></li><li><a href="settings.php">Einstellungen</a></li><li style="text-align: right;"><a href="user.php">Benutzername: <?php echo $_SESSION['username']; ?></a></li></ul></div><br>
<div id="intern">
<a href="edits.php">&lt; back</a>
<form method="POST" action="write.php">
	<p>Titel: <input type="text" name="name" value="<?php echo $name; ?>" class="textfield"></p>
	<p>Seiten URL: <input type="text" name="url" value="<?php echo $url; ?>" class="textfield"></p>
	<p>Thumbnail URL: <input type="text" name="thumbnail" value="<?php echo $thumbnailURL; ?>" class="textfield"></p>
	<p>Beschreibung:</p>
	<textarea name="desc" cols="50" rows="10"><?php echo $caption; ?></textarea><br/>
	<p>Kategorie: <input type="text" name="category" value="<?php echo $category; ?>" class="textfield"></p>
	<input type="text" name="what" value="edit" style="display:none;">
	<input type="text" name="id" value="<?php echo $id; ?>" style="display:none;">
	<input type="submit" value="speichern" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {
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
