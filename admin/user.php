<?php session_start();
include 'config.php';
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: ".$_SERVER['DOCUMENT_ROOT'].$PG_LOCA."/error.php");
}
else {
	$_SESSION['access']=allowd;
}
$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}
$un =$_SESSION['username'];
mysql_select_db($DB_NAME, $connect);
$query = mysql_query("SELECT value FROM settings WHERE name='name'");
$objResult = mysql_fetch_object($query);
$PGNAME = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='desc'");
$objResult = mysql_fetch_object($query);
$PGDSC = $objResult->value;
$query = mysql_query("SELECT email,showemail FROM logins WHERE user='$un'");
$objResult = mysql_fetch_object($query);
$email = $objResult->email;
$showemail = $objResult->showemail;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Benutzerinfos</title>
<link rel="stylesheet" href="/<?php echo $PG_LOCA;?>style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
var oldpw="";
var newpw="";
var newpw2="";
var a1=0;
var a2=0;
var a3=0;

var showrss = 1;
if("a<?php if($showemail==0) echo "a";?>"=="aa")
	showrss = 0;

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
		//pseudocheck. Could use check.php (used for login) but would make the load a lot higher, since I'm using keyup.
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

function check() {
	if(a1==1&&a2==1&&a3==1) {
		$.post('write.php',{action:"edit",name:"password",value:$("#newpw").val(),table:"logins",id:'<?php echo $_SESSION['username']; ?>'},function(data) {
			if(data=="2") {	
				$("#4").attr("src","images/wrong.png");
			}
			else {
				$("#4").attr("src","images/ok.png");
			}
		});
	}
}

/* E-Mail form scriptz */
	$('#emailform input[type!="radio"]').blur(function() {
		var namei = $(this).attr("name");
		$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"logins",id:'<?php echo $_SESSION['username']; ?>',rss:showrss},function() {
			$("#"+namei+" .validate").addClass("ok");
		});
	});
	
	$('#emailform input[type="radio"]').change(function() {
		var namei = $(this).attr("name");
		$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"logins",id:'<?php echo $_SESSION['username']; ?>',rss:1},function() {
			$("#"+namei+" .validate").addClass("ok");
			showrss = $(this).val();
		});
	});
	
	$("#emailform input").keypress(function(e) {
        if(e.which == 13) {
            jQuery(this).blur();
		}
	});


	$("#emailform input").focus(function() {
		$("#"+$(this).attr("name")+" .validate").removeClass("ok");
	});
});
</script>
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Benutzerinfos</h2>
<?php include 'menu.php'; ?>
<div id="intern">
	Passwort ändern: <img class="sym" id="4" src="images/clear.png">
		<p>Aktuelles Passwort <input id="oldpw" type="password" name="oldpw" value="" class="textfield"><img class="sym" id="1" src="images/clear.png"></p>
		<p>Neues Passwort <input id="newpw" type="password" name="newpw" value="" class="textfield"><img class="sym" id="2" src="images/clear.png"></p>
		<p>Passwort bestätigen <input id="newpw2" type="password" name="newpw2" value="" class="textfield"><img class="sym" id="3" src="images/clear.png"></p>
	E-Mail Einstellungen:
	<div id="emailform">
		<p id="email">E-Mail Adresse: <input type="email" name="email" value="<?php echo $email ?>" class="textfield"><span class="validate sym"></span></p>
		<p id="showemail">E-Mail Adresse im RSS-Feed anzeigen? <input type="radio" name="showemail" value="0" <?php if($showemail==0) { echo "checked";} ?>> Nein <input type="radio" name="showemail" value="1" <?php if($showemail==1) { echo "checked"; }?>> Ja <span class="validate sym"></span></p>
	</div>
</div>
</body>
</html>