<?php
include 'config.php';
$inshtml="";
$c=1;
$d=1;
$q=0;

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}
mysql_select_db($DB_NAME, $connect);
$query = mysql_query("SELECT value FROM settings WHERE name='url'");$objResult = mysql_fetch_object($query);$PGURL = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='name'");$objResult = mysql_fetch_object($query);$PGNAME = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='img'");$objResult = mysql_fetch_object($query);$PGIMG = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='tmode'");$objResult = mysql_fetch_object($query);$PGTITLE = (int)$objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='desc'");$objResult = mysql_fetch_object($query);$PGDSC = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='tags'");$objResult = mysql_fetch_object($query);$PGTGS = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='teaser'");$objResult = mysql_fetch_object($query);$PGTEA = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='items'");$objResult = mysql_fetch_object($query);$PGITMS = (int)$objResult->value;$cnt = 0;$count = 0;if($_GET['cat']) {	$q=1;	$quat=$_GET['cat'];}if($_GET['page']) {	$page=$_GET['page'];}else {	$page=1;}$categories[0]=placeholder;$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='1'");$objResult = mysql_fetch_object($query);if($q==0||$objResult->category==$quat) {	if($objResult->caption!=NULL) {		$objcap=" - ".$objResult->caption;	}	else {		$objcap="";	}	if(($cnt<$PGITMS&&$page*$PGITMS>=$count&&$count>($page-1)*$PGITMS)||$PGITMS==0) {		$inshtml="<li><a href='".$objResult->url."' title='".$objResult->name.$objcap."'><span class='title'>".$objResult->name."</span><img src='".$objResult->thumbnail."' alt='".$objResult->name."'></a></li>";		$cnt++;	}	else {		$inshtml="";	}	$c=2;	$count= 1;}$categories[1]=$objResult->category;$d=2;$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='$c'");$objResult = mysql_fetch_object($query);do {	if($objResult!=NULL&&($q==0||$objResult->category==$quat)) {		if($objResult->caption!=NULL) {			$objcap=" - ".$objResult->caption;		}		else {			$objcap="";		}		if(($cnt<$PGITMS&&$page*$PGITMS>=$count&&$count>($page-1)*$PGITMS)||$PGITMS==0) {			$inshtml=$inshtml."<li><a href='".$objResult->url."' title='".$objResult->name.$objcap."'><span class='title'>".$objResult->name."</span><img src='".$objResult->thumbnail."' alt='".$objResult->name."'></a></li>";			$cnt=$cnt+1;		}		$count=$count+1;	}	if(!(array_search($objResult->category,$categories))) {			$categories[$d]=$objResult->category;			$d=$d+1;	}	$c=$c+1;	$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='$c'");	$objResult = mysql_fetch_object($query);} while($objResult->hello==1);$f=1;while($f<$d) {	if($quat==$categories[$f]) {		$class='actual';	}	else {		$class='';	}	$cat=$cat."<li><a href='?cat=".$categories[$f]."' class='".$class."' title='".$categories[$f]."'>".$categories[$f]."</a></li>";	$f=$f+1;}
mysql_close($connect);?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd"><html><head><title><?php echo $PGNAME; ?> <?php if($_GET['cat']) { echo "- ".$_GET['cat']; } else {  echo "- ".$PGTEA; } ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="<?php echo $PGTGS; ?>">
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">
<link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" >
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<script type="text/javascript" src="jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">
$(document).ready(function() {	$('#videos a')	.attr('rel', 'gallery')	.fancybox({'type':'swf','padding':'0','swf': {'wmode':'transparent','allowfullscreen':'true'}});
	$('#videos img').load(function() {
		$('#videos img').each(function(i) {
			var height = $(this).height();
			if(height<139&&height>100) {
				var margin=(140-height)/2;
				$(this).css('marginTop',margin);
			}
			else if(height<=0.1) {
				console.info("yay");
				var path = $(this).attr('src');
				var imag = new Image();
				var width;
				imag.src = path;
				imag.onload = function() {
					width = imag.width;
					height = imag.height;
					var factor = width/187;
					height = height * factor;
					var margin = (140-height)/2;
					console.info(margin);
					$(this).css('marginTop',margin);
				};
			}
		});	});});</script>
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
?></head><body><div id="head"><a href="<?php echo $PGURL; ?>" style="text-decoration:none;"><?php if($PGTITLE==1) {	echo "<h1>".$PGNAME."</h1>";}else if($PGTITLE==2) {	echo "<img src='".$PGIMG."' alt='".$PGNAME."'>";}?></a><p><?php echo $PGTEA; ?></p></div><div id="navigation"><ul><li><a href="<?php echo $PGURL; ?>" class="<?php if(!($_GET['cat'])) { echo 'actual'; } ?>">Home</a></li><?php echo $cat; ?></ul></div><br><div id="videos"><ul><?php echo $inshtml; ?></ul></div><p id="footer"><?php if($count>=$PGITMS&&$PGITMS!=0) {	$pgs=$count/$PGITMS;	if($pgs-(int)$pgs!=0) {		$diff=$pgs-(int)$pgs;		$pgs=$pgs-$diff+1;	}	if($page==1) {		echo "<b>1</b> <a href='?page=2'>2</a> <a href='?page=".($pgs)."'>Letzte &gt;</a> | ";	}	else if($page<$pgs) {		echo "<a href='?page=1'>&lt; Erste</a> <a href='?page=".($page-1)."'>".($page-1)."</a> <b>".$page."</b> <a href='?page=2'>2</a> <a href='?page=".($page+1)."'>".($page+1)."</a> <a href='?page=".($pgs)."'>Letzte &gt;</a> | ";	}	else if($page=$pgs) {		echo "<a href='?page=1'>&lt; Erste</a> <a href='?page=".($page-1)."'>".($page-1)."</a> <b>".$page."</b> | ";	}}?><a href="login.php">Login</a> | <a href="whatsthis.php">What's this</a> | <a href="impressum.php">Impressum</a></p></body></html>