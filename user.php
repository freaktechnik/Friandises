<?php session_start();
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: error.php");
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
$query = mysql_query("SELECT value FROM settings WHERE name='desc'");
$objResult = mysql_fetch_object($query);
$PGDSC = $objResult->value;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Benutzerinfos</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
<script type="text/javascript" src="jquery-1.5.1.min.js"></script>
<script>
var oldpw="";
var newpw="";
var newpw2="";
var a1=0;
var a2=0;
var a3=0;
$(document).ready(function () {
	$("#oldpw").keyup(function() {
		oldpw=$("#oldpw").val();
		if(newpw==oldpw&&newpw!="") {
			$("#2").attr("src","images/wrong.png");
			a2=0;
			check();
		}
		else if(newpw!="") {
			$("#2").attr("src","images/ok.png");
			a2=1;
			check();
		}
		else {
			$("#2").attr("src","images/clear.png");
			a2=0;
			check();
		}
		//pseudocheck. Could use check.php (used for login) but needs sessions.
		if(oldpw=="") {
			a1=0;
			check();
		}
		else {
			a1=1;
			check();
		}
	});
	$("#newpw").keyup(function() {
		newpw=$("#newpw").val();
		if(newpw==oldpw&&newpw!="") {
			$("#2").attr("src","images/wrong.png");
			a2=0;
			check();
		}
		else if(newpw!="") {
			$("#2").attr("src","images/ok.png");
			a2=1;
			check();
		}
		else {
			$("#2").attr("src","images/clear.png");
			a2=0;
			check();
		}
		if(newpw==newpw2&&newpw!=""&&newpw2!="") {
			$("#3").attr("src","images/ok.png");
			a3=1;
			check();
		}
		else if(newpw!=""&&newpw2!="") {
			$("#3").attr("src","images/wrong.png");
			a3=0;
			check();
		}
		else {
			$("#3").attr("src","images/clear.png");
			a3=0;
			check();
		}
	});
	$("#newpw2").keyup(function() {
		newpw2=$("#newpw2").val();
		if(newpw==newpw2&&newpw!=""&&newpw2!="") {
			$("#3").attr("src","images/ok.png");
			a3=1;
			check();
		}
		else if(newpw!=""&&newpw2!="") {
			$("#3").attr("src","images/wrong.png");
			a3=0;
			check();
		}
		else {
			$("#3").attr("src","images/clear.png");
			a3=0;
			check();
		}
	});
});
function check() {
	if(a1==1&&a2==1&&a3==1) {
		$("#s").attr("disabled","");
	}
	else {
		$("#s").attr("disabled","true");
	}
}
</script>
</head>
<body>
<h2 id="head">Benutzerinfos</h2>
<div id="navigation"><ul><li><a href="intern.php">Video hinzufügen</a></li><li><a href="edits.php">Videodetails Bearbeiten</a></li><li><a href="settings.php">Einstellungen</a></li><li style="text-align: right;"><a href="#"  class="actual">Benutzername: <?php echo $_SESSION['username']; ?></a></li></ul></div>
<div id="intern">
Passwort ändern:
<form method="POST" action="write.php">
	<p>Aktuelles Passwort <input id="oldpw" type="password" name="oldpw" value="" class="textfield"><img class="sym" id="1" src="images/clear.png"></p>
	<p>Neues Passwort <input id="newpw" type="password" name="newpw" value="" class="textfield"><img class="sym" id="2" src="images/clear.png"></p>
	<p>Passwort bestätigen <input id="newpw2" type="password" name="newpw2" value="" class="textfield"><img class="sym" id="3" src="images/clear.png"></p>
	<input type="text" name="what" value="user" style="display:none;">
	<input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" style="display:none;">
	<input type="submit" value="speichern" style="text-align:right;" disabled="true" id="s"><img class="sym" id="4" src="<?php if($_GET['suc']==1) {
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
<p id="footer"><a href="logout.php">logout</a></p>
</body>
</html>