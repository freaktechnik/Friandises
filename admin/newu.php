<?php session_start();
if(($_SESSION['access']!=allowd||$_SESSION['access']==NULL)|$_SESSION['admin']==0)
{
    session_destroy(); 
	header("Location: /".$PG_LOCA."error.php?error=401 Access denied");
    break;
}
else {
	$_SESSION['access']=allowd;
}
include_once ('config.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Add User</title>
<link rel="stylesheet" href="/<?php echo $PG_LOCA; ?>style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Add User</h2>
<?php include 'menu.php'; ?>
<div id="intern">
<form method="POST" action="write.php">
	<p>Username: <input type="text" name="name" class="textfield"><img class="sym" src="<?php if($_GET['suc']==3) {
		echo "images/wrong.png";
	}
	else {
		echo "images/clear.png";
	}
	?>"></p>
	<p>E-Mail: <input type="email" name="email" class="textfield"><img class="sym" src="<?php if($_GET['suc']==4) {
		echo "images/wrong.png";
	}
	else {
		echo "images/clear.png";
	}
	?>"></p>
	<p>Adminrights? <input type="radio" name="admin" value="0" checked> No <input type="radio" name="admin" value="1" > Yes</p>
	<input type="text" name="action" value="user" style="display:none;">
	<input type="submit" value="Create" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {
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
