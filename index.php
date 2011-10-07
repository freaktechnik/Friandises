<?php
include ('admin/config.php');
include ('inc/pagevar.php');
include ('inc/items.php');

$inshtml="";
$c=1;
$d=1;
$q=0;
$categories[0]="placeholder";$urlcatsuffix="";
$cnt = 0; // items on this page



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


for($inde=0;$inde<$items_length;$inde=$inde+1) {
	if(($items[$inde]["category"]==$quat&&$cnt<$PGITMS)||(!$quat&&(($cnt<$PGITMS&&$page*$PGITMS>=$inde&&$inde>=($page-1)*$PGITMS)||$PGITMS==0))) {
		$inshtml=$inshtml."<li><a href='/video.php?id=".$inde."' title='".$items[$inde]["caption"]."'><span class='title'>".$items[$inde]["name"]."</span><img src='".$items[$inde]["thumbnail"]."' alt='".$items[$inde]["name"]."'></a></li>";
		$cnt=$cnt+1;
	}
	
	if(!(array_search($items[$inde]["category"],$categories))||$d==1) {
		$categories[$d]=$items[$inde]["category"];
		$d=$d+1;
	}
}
for($f=1;$f<$d;$f=$f+1) {	if($quat==$categories[$f]) {		$class='actual';	}	else {		$class='';	}	$cat=$cat."<li><a href='?cat=".$categories[$f]."' class='".$class."' title='".$categories[$f]."'>".$categories[$f]."</a></li>";}?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd"><html><head>
<title><?php echo $PGNAME; ?> <?php if($_GET['cat']) { echo "- ".$_GET['cat']; } else {  echo "- ".$PGTEA; } ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="<?php echo $PGTGS; ?>">
<meta http-equiv="content-language" content="<?php echo $PGLANG; ?>">

<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<link rel="alternate" type="application/rss+xml" title="feed" href="<?php echo $PGURL; ?>/feeds/feed.rss" >

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#loginlink').click(function(e) {
		e.preventDefault();
		$(this).hide();
		$('#loginform').show();
	});});</script>
<?php
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
?></head><body>
<div id="topnav"><form method="POST" id="loginform" style="display:none;" action="admin/check.php">Username:<input type="text" name="name"/> | Password:<input type="password" name="passwort"/> <input type="submit" value="Log in"></form><a id="loginlink" href="admin/login.php">Log in</a> | <a href="<?php echo $PGURL; ?>/feeds/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" /></a></div><div id="head"><a href="<?php echo $PGURL; ?>" style="text-decoration:none;"><?php if($PGTITLE==1) {	echo "<h1>".$PGNAME."</h1>";}else if($PGTITLE==2) {	echo "<img src='".$PGIMG."' alt='".$PGNAME."'>";}?></a><p><?php echo $PGTEA; ?></p></div><div id="navigation"><ul><li><a href="<?php echo $PGURL; ?>" class="<?php if(!($_GET['cat'])) { echo 'actual'; } ?>">Home</a></li><?php echo $cat; ?></ul></div><br><div id="videos"><ul><?php echo $inshtml; ?></ul></div><div id="bottom"><div id="pagination"><?php if(!$quat&&$items_length>=$PGITMS&&$PGITMS!=0) {	$pgs=$items_length/$PGITMS;	if($pgs-(int)$pgs!=0) {		$diff=$pgs-(int)$pgs;		$pgs=$pgs-$diff+1;	}	if($page==1) {		echo "<b>1</b> <a href='?page=2".$urlcatsuffix."'>2</a> <a href='?page=".($pgs).$urlcatsuffix."'>Letzte &gt;</a>";	}	else if($page<$pgs) {		echo "<a href='?page=1".$urlcatsuffix."'>&lt; Erste</a> <a href='?page=".($page-1).$urlcatsuffix."'>".($page-1)."</a> <b>".$page."</b> <a href='?page=".($page+1)."'>".($page+1)."</a> <a href='?page=".($pgs).$urlcatsuffix."'>Letzte &gt;</a>";	}	else if($page==$pgs) {		echo "<a href='?page=1".$urlcatsuffix."'>&lt; Erste</a> <a href='?page=".($page-1).$urlcatsuffix."'>".($page-1)."</a> <b>".$page."</b>";	}}?></div>
<div id="footer"><a href="impressum.php">Impressum</a> | <a href="<?php echo $PGURL; ?>/feeds/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" /></a></div></div></body></html>