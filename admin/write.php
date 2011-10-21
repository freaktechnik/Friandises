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
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	$creator=$_SESSION['username'];

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
	
	if(is_numeric($year)) {
		$date=$year."-".$month."-".$day;
	}
	else {
		die("Please enter a proper year");
	}

	$sql = "INSERT INTO content (url, name, caption, category, thumbnail, date, creator) VALUES ('$url', '$name', '$caption', '$category', '$thumbnail', '$date', '$creator');";
	$results = mysql_query($sql);
	include "rsscreate.php";
	header("Location: intern.php?suc=1");
}
else if($what=="settings"&&$_SESSION['admin']==1) {
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
	$owner=$_POST['owner'];
	$lang=$_POST['lang'];
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
	$sql = "UPDATE settings SET value='$owner' WHERE name='owner';";
	$results = mysql_query($sql);
	$sql = "UPDATE settings SET value='$lang' WHERE name='lang';";
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
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	if(is_numeric($year)) {
		$date=$year."-".$month."-".$day;
	}
	else {
		die("Please enter a proper year");
	}
	$sql = "UPDATE content SET url='$url',name='$name',caption='$descl',thumbnail='$thumb',category='$cat',date='$date' WHERE id='$id'";
	$results = mysql_query($sql);
	include "rsscreate.php";
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

else if($what=="email") {
	$email=$_POST['email'];
	$showemail=$_POST['showemail'];
	$un=$_POST['username'];
	if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
		die("e-Mail adress not valid!");
	}
	$sql = "UPDATE logins SET email='$email',showemail='$showemail' WHERE user='$un'";
	$results = mysql_query($sql);
	header("Location: user.php?suc=3");
}

else if($what=="newu") {
	$query = mysql_query("SELECT value FROM settings WHERE name='name'");
	$objResult = mysql_fetch_object($query);
	$PGNAME = $objResult->value;
	$query = mysql_query("SELECT value FROM settings WHERE name='url'");
	$objResult = mysql_fetch_object($query);
	$PGURL = $objResult->value;
	$name=$_POST['name'];
	$email=$_POST['email'];
	$admin=$_POST['admin'];
	$length = 8;
	$password = "";
    $possible = "12346789bcdfghjkmnpqrtvwxyz -BCDFGHJKLMNPQRTVWXYZ";
    $maxlength = strlen($possible);
    if ($length > $maxlength) {
      $length = $maxlength;
    }
    $i = 0; 
    while ($i < $length) { 
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);

      if (!strstr($password, $char)) { 
        $password .= $char;
        $i++;
      }
    }
	$query = mysql_query("SELECT email FROM logins WHERE user='$name'");
	$objResult = mysql_fetch_object($query);
	if($objResult!=NULL) {
		die("User already exists. Try again.");
	}
	$query = mysql_query("SELECT user FROM logins WHERE email='$email'");
	$objResult = mysql_fetch_object($query);
	if($objResult!=NULL) {
		die("A user is already registered with that e-Mail adress. Try again.");
	}
	if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
		die("e-Mail adress not valid!");
	}
	$sql = "INSERT INTO logins (user, password, admin, email) VALUES ('$name', '$password', '$admin', '$email')";
	$results = mysql_query($sql);
	$subject = "Your new account on ".$PGNAME."";
	$body = "Hi ".$name."\n\nSomeone just created a new account on ".$PGNAME." for you. You can find ".$PGNAME." under ".$PGURL.". \nYour login informations:\nUsername: ".$name."\nPassword: ".$password."\nYou can edit your e-mail adress and password when you are logged in.";
	if (mail($email, $subject, $body)) {
		header("Location: newu.php?suc=1");
	}
	else {
		die("Error.");
	}
}

else if($what=="views") {
	$view = $_POST['view'];
	$standard = $_POST['standard'];
	$stda = array();
	
	foreach($view as $c => $std) {
		if($std==$standard) {
			$stda[$c]=1;
		}
		else {
			$stda[$c]=0;
		}
	}
	
	$a=0;
	
	$actualViews = array();
	
	$result = mysql_query("SELECT * FROM views ORDER BY id");
	while ($objResult = mysql_fetch_object($result)) {
		$actualViews[$a]=$objResult->name;
		$actualStandard[$a]=(int)$objResult->standard;
		$a=$a+1;
	}
	
	foreach($view as $b => $viw) {
		if(FALSE === array_search($viw,$actualViews)) {
			$query = mysql_query("INSERT INTO views ( name,standard ) VALUES ('$viw','$stda[$b]' )");
		}
		if($actualStandard[$b]!=$stda[$b]&&$viw==$standard) {
			$query = mysql_query("UPDATE views SET standard='$stda[$b]' WHERE name='$viw'");
		}
	}
	foreach($actualViews as $act) {
		if(FALSE === array_search($act,$view)) {
			$query = mysql_query("DELETE FROM views WHERE name='$act'");
		}
	}
	
	header("Location: views.php?suc=1");
}

mysql_close($connect);
?>