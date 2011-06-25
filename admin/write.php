<?php session_start();

if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /index.php");
}
else {
	$_SESSION['access']=allowd;
}
include "config.php";
$suffix = '/0.jpg';

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);
$what=$_POST['what'];
if($what=="video") {
	$name=$_POST['name'];
	$url=$_POST['url'];
	$caption=$_POST['cap'];
	$category=$_POST['cat'];

	if(preg_match('#http://.+youtube.com/#',$url)) {
		$url = preg_replace('#http://.+youtube.com/.+watch#','watch',$url);
		$url = preg_replace('#watch\?v=#','http://www.youtube.com/v/',$url);
		$url = preg_replace('#&.+$#','',$url);
		$thumbnail= preg_replace('#http://www.youtube.com/v/#','http://img.youtube.com/vi/',$url);
		$thumbnail.=$suffix;
	}
	else if(preg_match('#http://www.videoportal.sf.tv/#',$url)) {
		$url = preg_replace('#http://www.videoportal.sf.tv/video\?id=#','http://www.sf.tv/videoplayer/embed/',$url);
		$thumbnail= preg_replace('#http://www.sf.tv/videoplayer/embed/#','http://www.videoportal.sf.tv/cvis/segment/thumbnail/',$url);
	}
	else if(preg_match('#http://.+youtu.be/#',$url)) {
		$url = preg_replace('#http://.+youtu.be/#','http://www.youtube.com/v/',$url);
		$thumbnail= preg_replace('#http://www.youtube.com/v/#','http://img.youtube.com/vi/',$url);
		$thumbnail.=$suffix;
	}
	/*else if(preg_match('#http://vimeo.com#',$url)) {
		$url = preg_replace('#http://www.youtu.be/#','http://www.youtube.com/v/',$url);
		$thumbnail= preg_replace('#http://www.youtube.com/v/#','http://i1.ytimg.com/vi/',$url);
	} neesds HTML Player.*/

	$sql = "INSERT INTO content (url, name, caption, category, thumbnail) VALUES ('$url', '$name', '$caption', '$category', '$thumbnail');";
	$results = mysql_query($sql);
	header("Location: intern.php?suc=1");
}
else if($what=="settings") {
	$name=$_POST['name'];
	$url=$_POST['url'];
	$descl=$_POST['desc'];
	$tags=$_POST['tags'];
	$teaser=$_POST['teaser'];
	$tmode=$_POST['tmode'];
	$img=$_POST['img'];
	$items=$_POST['items'];
	$addthis=$_POST['addthis'];
	$gana=$_POST['gana'];
	$sql = "UPDATE settings SET value='$url' WHERE name='url';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$name' WHERE name='name';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$descl' WHERE name='desc';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$tags' WHERE name='tags';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$teaser' WHERE name='teaser';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$tmode' WHERE name='tmode';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$img' WHERE name='img';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$items' WHERE name='items';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$addthis' WHERE name='addthis';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$gana' WHERE name='gana';";
	$results = mysql_query($sql);
	header("Location: settings.php?suc=1");
}
else if($what=="edit") {
	$id=$_POST['id'];
	$name=$_POST['name'];
	$url=$_POST['url'];
	$descl=$_POST['desc'];
	$thumb=$_POST['thumbnail'];
	$cat=$_POST['category'];
	$sql = "UPDATE content SET url='$url',name='$name',caption='$descl',thumbnail='$thumb',category='$cat' WHERE id='$id'";
	$results = mysql_query($sql);
	header("Location: edit.php?suc=1&id=".$id);
}
else if($what=="user") {
	$opw=$_POST['oldpw'];
	$npw=$_POST['newpw'];
	$npw2=$_POST['newpw2'];
	$un=$_POST['username'];
	$query = mysql_query("SELECT password FROM logins WHERE user='$un'");
	$objResult = mysql_fetch_object($query);
	$pdbpw = $objResult->password;
	if($opw==$pdbpw&&$npw==$npw2&&oldpw!=newpw) {
		$sql = "UPDATE logins SET password='$npw' WHERE user='$un'";
		$results = mysql_query($sql);
		header("Location: user.php?suc=1");
	}
	else {
		header("Location: user.php?suc=2");
	}
}

mysql_close($connect);
?>