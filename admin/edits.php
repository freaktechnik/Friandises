<?php session_start();
include_once ('config.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/items.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
if($_SESSION['access']!='allowd'||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header('Location: '.$PGURL.'/'.$PG_LOCA.'error.php?error=401 Access denied');
}
else {
	$_SESSION['access']='allowd';
}
for($inde=0;$inde<$items_length;$inde=$inde+1) {
	$inshtml=$inshtml."<li><a href='edit.php?id=".$inde."' title='".$items[$inde]["name"]."'><img src='".$items[$inde]["thumbnail"]."' alt='".$items[$inde]["name"]."'>".$items[$inde]["name"]." - ".$items[$inde]["date"]."</a></li>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Edit Entries</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" >
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Edit Entries</h2>
<?php include 'menu.php'; ?>
<div id="edits"><ul><?php echo $inshtml; ?></ul></div>
</body>
</html>
