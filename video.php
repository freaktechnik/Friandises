<?php
include ('admin/config.php');
include ('inc/pagevar.php');
include ('inc/items.php');

$id = (int)$_GET['id'];
$categories[0]=placeholder;
$d=1;

$suffix="&fs=1&hd=1";
$share = '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_clickback":true,"swfurl":"'.$url.'","data_ga_property": "'.$G_ANALYTICS.'","data_ga_social" : true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid='."'".$ADD_PUBID."'".'"></script>
<!-- AddThis Button END -->';

if($id<$items_length) {
	$namez = $items[$id]["name"];
	$left="";
	$right="";
	if($id<$items_length-1) {
		$left = "<a href='?id=".($id+1)."' class='left'>&lt; Previous</a>";
	}
	if($id>0) {
		$right ="<a href='?id=".($id-1)."' class='right'>Next &gt;</a>";
	}
	switch($items[$id]["type"]) {
		case "html": $inshtml = "<object type='text/html' width='750' height='450' data='".$items[$id]["url"]."?hd=1' mozallowfullscreen webkitAllowFullScreen allowfullscreen></object>"; break;
		default: $inshtml= "<object width='720' height='450'>
<param name='allowFullScreen' value='true'>
<param name='movie' value='".$items[$id]["url"].$suffix."'>
<embed allowfullscreen='true' width='750' height='450' type='application/x-shockwave-flash' src='".$items[$id]["url"].$suffix."'></embed>
</object>";
		break;
	}
	$inshtml = $inshtml."<div id='footline'>
	".$left."<div class='center'>".$share."</div>".$right."
</div><br>
<p>".$items[$id]["description"]."</p>";
	$quat=$items[$id]["category"];
}

else {
	$namez = "Video not found!";
	$inshtml = "there is no video with this ID";
}

for($inde=0;$inde<$items_length;$inde=$inde+1) {
	if(!(array_search($items[$inde]["category"],$categories))||$d==1) {
		$categories[$d]=$items[$inde]["category"];
		$d=$d+1;
	}
}
for($f=1;$f<$d;$f=$f+1) {
	if($quat==$categories[$f]) {
		$class='actual';
	}
	else {
		$class='';
	}
	$cat=$cat."<li><a href='index.php?cat=".$categories[$f]."' class='".$class."' title='".$categories[$f]."'>".$categories[$f]."</a></li>";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:og="http://ogp.me/ns#">
<head>
	
	<!-- Info -->
    <title><?php echo $PGNAME." - ".$namez; ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="description" content="<?php echo $PGDSC; ?>">
    <meta name="keywords" content="<?php echo $PGTGS; ?>">
    <meta http-equiv="content-language" content="<?php echo $PGLANG ?>">
    <meta property="og:title" content="<?php echo $namez; ?>">
    <meta property="og:type" content="movie">
    <meta property="og:url" content="<?php echo $PGURL."/video.php?id=".$id; ?>">
    <meta property="og:image" content="<?php echo $items[$id]["thumbnail"]; ?>">
    <meta property="og:description"
          content="<?php echo $items[$id]["description"]; ?>">
    <meta property="og:video" content="<?php echo $items[$id]["url"]; ?>">
	<meta property="og:video:type" content="application/x-shockwave-flash">

	<!-- CSS -->
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" >

	<!-- Scriptz -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#loginlink').click(function(e) {
		e.preventDefault();
		$(this).hide();
		$('#loginform').show();
	});
});
</script>
<?php 
echo "<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '".$G_ANALYTICS."']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
?>
</head>
<body>
<div id="topnav"><form method="POST" id="loginform" style="display:none;" action="admin/check.php">Username:<input type="text" name="name" > | Password:<input type="password" name="passwort" > <input type="submit" value="Log in"></form><a id="loginlink" href="admin/login.php">Log in</a></div>
<div id="head"><a href="<?php echo $PGURL; ?>" style="text-decoration:none;"><?php 
if($PGTITLE==1) {
	echo "<h1>".$PGNAME."</h1>";
}
else if($PGTITLE==2) {
	echo "<img src='".$PGIMG."' alt='".$PGNAME."'>";
}
?></a>
<p><?php echo $PGTEA; ?></p></div>
<div id="navigation"><ul><li><a href="<?php echo $PGURL; ?>">Home</a></li><?php echo $cat; ?></ul></div><br>
<div id="videop"><h3><?php echo $namez; ?></h3>
<?php echo $inshtml; ?>
</div>
<div id="bottom">
<div id="footer"><a href="impressum.php">Impressum</a> | <a href="<?php echo $PGURL; ?>/feeds/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" ></a></div></div>
<script type="text/javascript" src="js/footer.js"></script>
</body>
</html>