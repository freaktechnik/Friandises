<?php
session_start();
include ('config.php');
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');

if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /"$PG_LOCA."error.php");
}
else {
	$_SESSION['access']=allowd;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo $PGNAME." - ".$_GET['error']; ?></title>
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" >
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
	<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
    </head>
<body>
   <h2 id="head"><?php echo $_GET['error']; ?></h2>
   <div id="text"><a href="intern.php">Main admin page</a></div>
   <div id="bottom">
		<div id="footer">
			<a href="impressum.php">Impressum</a> | <a href="<?php echo $PGURL; ?>/admin/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" ></a>
		</div>
	</div>
</body>
</html>