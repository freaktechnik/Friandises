<?php session_start();
include_once ('config.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
if($_SESSION['access']!='allowd'||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header('Location: '.$PGURL.'/'.$PG_LOCA.'error.php?error=401 Access denied');
}
else {
	$_SESSION['access']='allowd';
}

$connect = mysql_connect($DB_LOCA, $DB_USER, $DB_PASS);
if (!$connect)
{
   header('Location: '.$PGURL.'/'.$PG_LOCA.'admin/error.php?error=Could not connect to the Database.');
}

mysql_select_db($DB_NAME, $connect);

$actualViewsNames = array();
$actualViewsStd = array();

$result = mysql_query("SELECT * FROM views ORDER BY id");
while ($objResult = mysql_fetch_object($result)) {
	$actualViewsNames[$objResult->id]=$objResult->name;
	$actualViewsStd[$objResult->id]=$objResult->standard;
}

mysql_close($connect);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Views</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="Geschichte,History,Videos,Filme,Geschichts Videos,Geschichts Filme">
<meta http-equiv="content-language" content="en">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" >

</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Select views</h2>
<?php include 'menu.php'; ?>
<div id="intern">
<form method="POST" action="write.php">
	<?php
		$dir = $_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'views';
		$files = scandir($dir);
		
		foreach($files as $file) {
			if(strpos($file,'.')===false) {
				$stdCheck="";
				$exCheck="";
				if(FALSE !== array_search($file,$actualViewsNames)) {
					if($actualViewsStd[array_search($file,$actualViewsNames)]=="1") {
						$stdCheck="checked";
					}
					$exCheck="checked";
				}
				echo "<p><input type='checkbox' name='view[]' value='".$file."' ".$exCheck."> ".$file." | standard:<input type='radio' name='standard' value='".$file."'".$stdCheck."></p>";
			}
		}
	?>
	<input type="text" name="action" value="views" style="display: none;">
	<input type="submit" value="Save" style="text-align: right;"><img class="sym" src="<?php if($_GET['suc']==1) {
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
