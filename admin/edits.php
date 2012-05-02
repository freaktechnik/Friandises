<?php session_start();
include ('config.php');
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/items.php');
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /".$PG_LOCA."error.php");
}
else {
	$_SESSION['access']=allowd;
}
for($inde=0;$inde<$items_length;$inde=$inde+1) {
	$inshtml=$inshtml."<li><a href='edit.php?id=".$inde."' title='".$items[$inde]["name"]."'><img src='".$items[$inde]["thumbnail"]."' alt='".$items[$inde]["name"]."'>".$items[$inde]["name"]." - ".$items[$inde]["date"]."</a></li>";
}
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
<link rel="stylesheet" href="/<?php echo $PG_LOCA;?>style.css" type="text/css" media="screen" >
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Videoinfos Bearbeiten</h2>
<?php include 'menu.php'; ?>
<div id="edits"><ul><?php echo $inshtml; ?></ul></div>
</body>
</html>
