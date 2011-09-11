<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php include 'admin/config.php';
include ('inc/pagevar.php');

echo $PGNAME; ?> - Impressum</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="<?php echo $PGLANG; ?>">

<link rel="stylesheet" href="style.css" type="text/css" media="screen" >

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {	
	$('#loginlink').click(function(e) {
		e.preventDefault();
		$(this).hide();
		$('#loginform').show();
	});
});
</script>

</head>
<body>
<div id="topnav"><form method="POST" id="loginform" style="display:none;" action="admin/check.php">Username:<input type="text" name="name"/> | Password:<input type="password" name="passwort"/> <input type="submit" value="Log in"></form><a id="loginlink" href="admin/login.php">Log in</a> | <a href="index.php">Home</a></div>
<h1 id="head">Impressum</h1>
<div id="text">
<?php echo $PGDSC; ?><br>
<?php echo $PGNAME; ?> is a link collection of videos. You can watch those videos directly on the page. This page supports youtube and sf videoportal videos, more to come. The page is built to be simple, for user and owner. It is very simple to add a video.
Neither page owner nor author are responsible for the video content.<br>
This page uses <a href="http://jquery.com">jQuery</a> and <a href="http://fancybox.net">fancybox</a>.<br>
Visit the Friandises project (which this website runs) on Github: <a href="https://github.com/freaktechnik/Friandises">Friandises on Github</a>.<br>
Flash may be required.<br>
Thx for reading.
</div>
<div id="bottom">
<div id="footer"><b>Impressum</b> | <a href="<?php echo $PGURL; ?>/feeds/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" /></a></div></div>
</body>
</html>
