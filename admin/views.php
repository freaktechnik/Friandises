<?php session_start();
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /error.php");
    break;
}
else {
	$_SESSION['access']=allowd;
}
include 'config.php';
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);

$actualViewsNames = array();
$actualViewsStd = array();

$a = 1; //This needs to be one, else the first item is not working with array search. Whyever.

$result = mysql_query("SELECT * FROM views ORDER BY name");
while ($objResult = mysql_fetch_object($result)) {
	$actualViewsNames[$a]=$objResult->name;
	$actualViewsStd[$a]=$objResult->standard;
	$a = $a+1;
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
		$num = 0;
		
		foreach($files as $file) {
			if(strpos($file,'.')===false) {
				$stdCheck="";
				$exCheck="";
				if(array_search($file,$actualViewsNames)) {
					if($actualViewsStd[array_search($file,$actualViewsNames)]=="1") {
						$stdCheck="checked";
					}
					$exCheck="checked";
				}
				echo "<p><input type='checkbox' name='view[]' value='".$file."' ".$exCheck."> ".$file." | standard:<input type='radio' name='standard[]' value='1'".$stdCheck."></p>";
				$num = $num +1;
			}
		}
	?>	<input type="text" name="number" style="display:none;" value="<?php echo $num; ?>">
	<input type="text" name="what" style="display:none;" value="views">
	<input type="submit" value="speichern" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {
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
