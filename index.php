<?php
include ('admin/config.php');
include ('inc/pagevar.php');
include ('inc/items.php');
include ('inc/views.php');

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);
$urlcatsuffix="";
$urlviewsuffix="";
$view = new View();

if($_GET['cat']) {
	$quat=$_GET['cat'];
	$urlcatsuffix="&cat=".$quat;
}

if($_GET['page']) {
	$page=$_GET['page'];
}
else {
	$page=1;
}

if($_GET['view']) {
	$view->setView($_GET['view']);
	$urlviewssuffix="&view=".$view->getView();
	$urlviewsuffix="?view=".$view->getView();
	if($urlcatsuffix!="") {
		$urlcatsuffix=$urlcatsuffix."&view=".$view->getView();
	}
	else {
		$urlcatsuffix = "?view=".$view->getView();
	}
}

include ('views/'.$view->getView().'/'.$view->getView().'.php');

$reta = generate();
$viewselect = $view->getSelects();

$categories = $reta->cats;
$numCat = $reta->noc;
for($f=1;$f<$numCat;$f=$f+1) {
	if($quat==$categories[$f]) {
		$class='actual';
	}
	else {
		$class='';
	}
	$cat=$cat."<li><a href='?cat=".$categories[$f].$urlviewssuffix."' class='".$class."' title='".$categories[$f]."'>".$categories[$f]."</a></li>";
}

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd"><html><head>
<title><?php echo $PGNAME; ?> <?php if($_GET['cat']) { echo "- ".$_GET['cat']; } else {  echo "- ".$PGTEA; } ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="<?php echo $PGTGS; ?>">
<meta http-equiv="content-language" content="<?php echo $PGLANG; ?>">

<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<link rel="stylesheet" href="views/<?php echo $view->getView(); ?>/style.css" type="text/css" media="screen" >
<link rel="alternate" type="application/rss+xml" title="feed" href="<?php echo $PGURL; ?>/feeds/feed.rss" >

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#loginlink').click(function(e) {
		e.preventDefault();
		$(this).hide();
		$('#loginform').show();
	});
	
	$('#view-select').change(function() {
		var args = "<?php echo $_SERVER['QUERY_STRING']; ?>";
		if(args.match(/view=/)) {
			args = args.replace(/view=[a-z]*&?/,'');
		}
		if(args.match(/page=/)) {
			args = args.replace(/page=[1-9]*&?/,'');
		}
		var presuff = "&view="
		if (args=="") {
			presuff="view=";
		}
		
		location.href = "index.php?"+args+presuff+($(this).find(":selected").html()).toLowerCase();
	});});</script>
<?php
if($reta->script) {
	echo "<script type='text/javascript' src='".$reta->script."'></script>";
}
if($reta->head) {
	echo $reta->head;
}
if(!($_GET['cat'])) { echo "<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '".$G_ANALYTICS."']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
}
?></head><body <?php if($reta->onload) {
	echo "onload='".$reta->onload."' ";
}
if($retu->onresize) {
	echo "onresize='".$retu->onresize."' ";
}?>>
<div id="topnav"><form method="POST" id="loginform" style="display:none;" action="admin/check.php">Username:<input type="text" name="name"/> | Password:<input type="password" name="passwort"/> <input type="submit" value="Log in"></form><a id="loginlink" href="admin/login.php">Log in</a> | <a href="<?php echo $PGURL; ?>/feeds/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" /></a></div>
<div id="head"><a href="<?php echo $PGURL.$urlviewsuffix; ?>" style="text-decoration:none;"><?php if($PGTITLE==1) {	echo "<h1>".$PGNAME."</h1>";}else if($PGTITLE==2) {	echo "<img src='".$PGIMG."' alt='".$PGNAME."'>";}?></a>
<p><?php echo $PGTEA; ?></p></div>
<div id="navigation"><ul><li><a href="<?php echo $PGURL.$urlviewsuffix; ?>" class="<?php if(!($_GET['cat'])) { echo 'actual'; } ?>">Home</a></li><?php echo $cat; ?></ul><select name="view" id="view-select"><?php echo $viewselect; ?></select></div><br>
<?php echo $reta->data; ?>
<div id="footer"><a href="impressum.php">Impressum</a> | <a href="<?php echo $PGURL; ?>/feeds/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" /></a></div></div></body></html>