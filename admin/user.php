<?php session_start();
include_once 'config.php';
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/users.php');
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /".$PG_LOCA."error.php?error=401 Access denied");
}
else {
	$_SESSION['access']=allowd;
}
$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   header("Location: /".$PG_LOCA."admin/error.php?error=Could not connect to the Database.");
}
$un =$_SESSION['username'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Personal Settings</title>
<link rel="stylesheet" href="/<?php echo $PG_LOCA;?>style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">
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
if("a<?php if($user[$un]["show"]==0) echo "a";?>"=="aa")
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
		$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"logins",id:'<?php echo $un; ?>',rss:showrss},function() {
			$("#"+namei+" .validate").addClass("ok");
		});
	});
	
	$('#emailform input[type="radio"]').change(function() {
		var namei = $(this).attr("name");
		$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"logins",id:'<?php echo $un; ?>',rss:1},function() {
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
<h2 id="head">Personal Settings</h2>
<?php include 'menu.php'; ?>
<div id="intern">
	Change Password: <img class="sym" id="4" src="images/clear.png">
		<p>Actual Password <input id="oldpw" type="password" name="oldpw" value="" class="textfield"><img class="sym" id="1" src="images/clear.png"></p>
		<p>New Password <input id="newpw" type="password" name="newpw" value="" class="textfield"><img class="sym" id="2" src="images/clear.png"></p>
		<p>Confirm Password <input id="newpw2" type="password" name="newpw2" value="" class="textfield"><img class="sym" id="3" src="images/clear.png"></p>
	E-Mail Settings:
	<div id="emailform">
		<p id="email">E-Mail Address: <input type="email" name="email" value="<?php echo $user[$un]["email"] ?>" class="textfield"><span class="validate sym"></span></p>
		<p id="showemail">Show E-Mail Address in RSS-Feed? <input type="radio" name="showemail" value="0" <?php if($user[$un]["show"]==0) { echo "checked";} ?>> No <input type="radio" name="showemail" value="1" <?php if($user[$un]["show"]==1) { echo "checked"; }?>> Yes <span class="validate sym"></span></p>
	</div>
</div>
</body>
</html>