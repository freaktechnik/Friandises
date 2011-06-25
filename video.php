<?php
include 'admin/config.php';
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

$query = mysql_query("SELECT value FROM settings WHERE name='url'");
$objResult = mysql_fetch_object($query);
$PGURL = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='name'");
$objResult = mysql_fetch_object($query);
$PGNAME = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='img'");
$objResult = mysql_fetch_object($query);
$PGIMG = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='tmode'");
$objResult = mysql_fetch_object($query);
$PGTITLE = (int)$objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='desc'");
$objResult = mysql_fetch_object($query);
$PGDSC = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='tags'");
$objResult = mysql_fetch_object($query);
$PGTGS = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='teaser'");
$objResult = mysql_fetch_object($query);
$PGTEA = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='items'");
$objResult = mysql_fetch_object($query);
$PGITMS = (int)$objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='addthis'");
$objResult = mysql_fetch_object($query);
$ADD_PUBID = $objResult->value;
$cnt = 0;
$count = 0;

$id = $_GET['id'];

$share = '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid="'.$ADD_PUBID.'"></script>
<!-- AddThis Button END -->';

$categories[0]=placeholder;
$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='1'");
$objResult = mysql_fetch_object($query);
if($q==0||$objResult->category==$quat) {
	if($id==1) {
		$quat=$objResult->category;
		$namez = $objResult->name;
		$url = $objResult->url."&fs=1";
		$capz = $objResult->caption;
	}
	$c=2;
}
$categories[1]=$objResult->category;
$d=2;
$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='$c'");
$objResult = mysql_fetch_object($query);

do {
	if($objResult!=NULL&&($q==0||$objResult->category==$quat)) {
		if($id==$c) {
			$quat=$objResult->category;
			$namez = $objResult->name;
			$url = $objResult->url."&fs=1";
			$capz = $objResult->caption;
		}
	}
	if(!(array_search($objResult->category,$categories))) {
			$categories[$d]=$objResult->category;
			$d=$d+1;
	}
	$c=$c+1;
	$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='$c'");
	$objResult = mysql_fetch_object($query);
} while($objResult->hello==1);
$f=1;
while($f<$d) {
	if($quat==$categories[$f]) {
		$class='actual';
	}
	else {
		$class='';
	}
	$cat=$cat."<li><a href='/?cat=".$categories[$f]."' class='".$class."' title='".$categories[$f]."'>".$categories[$f]."</a></li>";
	$f=$f+1;
}

mysql_close($connect);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME." - ".$namez; ?> </title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="<?php echo $PGTGS; ?>">
<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
<link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" >
<link rel="stylesheet" href="style.css" type="text/css" media="screen" >
<script type="text/javascript" src="jquery-1.6.1.min.js"></script>
</head>
<body>
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
<object width='720' height='450'>
<param name='allowFullScreen' value='true'></param>
<param name='movie' value='<?php echo $url; ?>'></param>
<embed allowfullscreen='true' width='750' height='450' type='application/x-shockwave-flash' src='<?php echo $url; ?>'></embed>
</object>
<p><?php echo $share; ?></p>
<p><?php echo $capz; ?></p>
</div>
<p id="footer"><?php
	if($id==1) {
		echo "<a href='?id=2'>Next &gt;</a> | ";
	}
	else if($id<$c-1) {
		echo "<a href='?id=".($id-1)."'>&lt; Previous</a> <a href='?id=".($id+1)."'>Next &gt;</a> | ";
	}
	else if($id==$c-1) {
		echo "<a href='?id=".($id-1)."'>&lt; Previous</a> | ";
	}
?><a href="admin/login.php">Login</a> | <a href="whatsthis.php">What's this</a> | <a href="impressum.php">Impressum</a></p>
</body>
</html>