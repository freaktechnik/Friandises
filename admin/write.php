<?php session_start();

include_once ("config.php");
include_once ("inc/videoparse.php");
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');

if($_SESSION['access']!='allowd'||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header('Location: '.$PGURL.'error.php');
}
else {
	$_SESSION['access']='allowd';
}

$connect = mysql_connect($DB_LOCA, $DB_USER, $DB_PASS);
if (!$connect)
{
   header('Location: '.$PGURL.'error.php?error=Could not connect: '.mysql_error());
}

mysql_select_db($DB_NAME, $connect);

$action = $_POST['action'];

if($action=="edit") {
	$item = $_POST['name'];
	$value = $_POST['value'];
	$table = $_POST['table'];
	$id = $_POST['id'];
	$idtype = "id";
	if($table=="logins") {
		$idtype="user";
	}
	
	if($table=="settings"&&$_SESSION['admin']==1) {
		$sql = "UPDATE settings SET value='$value' WHERE name='$item';";
		$results = mysql_query($sql);
	}
	else if($table=="settings") {
		header('Location: '.$PGURL.'error.php?error=You are not allowed to do this.');
	}
	else {
		if($table=="logins"&&$item=="password") {
			$query = mysql_query("SELECT password FROM logins WHERE user='$id'");
			$objResult = mysql_fetch_object($query);
			$pdbpw = $objResult->password;
			if(!($_POST['oldpw']==$pdbpw&&$_POST['oldpw']!=$value)) {
				echo "2";
			}
		}
		else if($item=="email"&&!(filter_var($value, FILTER_VALIDATE_EMAIL))) {
			header('Location: '.$PGURL.'error.php?error=E-Mail adress is not valid.');
		}
		$sql = "UPDATE $table SET $item='$value' WHERE $idtype='$id'";
		$results = mysql_query($sql);
		if((int)$_POST['rss']==1) {
			include ('inc/rsscreate.php');
		}
	}
	
}

else if($action=="video") {
	$name=$_POST['name'];
	$url=$_POST['url'];
	$caption=$_POST['cap'];
	$category=$_POST['cat'];
	$day=$_POST['day'];
	$month=$_POST['month'];
	$year=$_POST['year'];
	$format=$_POST['format'];
	$creator=$_SESSION['username'];
	
	$parser = videoparse($url);

	$url = $parser->url;
	$thumbnail = $parser->thumbnail;

	$sql = "INSERT INTO content (url, name, caption, category, thumbnail, date, creator) VALUES ('$url', '$name', '$caption', '$category', '$thumbnail', '$date', '$creator');";
	$results = mysql_query($sql);
	include ('inc/rsscreate.php');
	header('Location: '.$PGURL.'intern.php?suc=1');
}

else if($action=='user') {
	$name=$_POST['name'];
	$email=$_POST['email'];
	$admin=$_POST['admin'];
	
	$query = mysql_query("SELECT email FROM logins WHERE user='$name'");
	if($query) {
		header('Location: '.$PGURL.'newu.php?suc=3');
	}
	$query = mysql_query("SELECT user FROM logins WHERE email='$email'");
	if($query) {
		header('Location: '.$PGURL.'newu.php?suc=4');
	}
	if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
		header('Location: '.$PGURL.'newu.php?suc=4');
	}
	
	$password = generatePassword();
	$sql = "INSERT INTO logins (user, password, admin, email) VALUES ('$name', '$password', '$admin', '$email')";
	$results = mysql_query($sql);
	$subject = "Your new account on ".$PGNAME."";
	$body = "Hi ".$name."\n\nSomeone just created a new account on ".$PGNAME." for you. You can find ".$PGNAME." under ".$PGURL.". \nYour login informations:\nUsername: ".$name."\nPassword: ".$password."\nYou can edit your e-mail adress and password when you are logged in.";
	if (mail($email, $subject, $body)) {
		header('Location: '.$PGURL.'newu.php?suc=1');
	}
	else {
		header('Location: '.$PGURL.'newu.php?suc=2');
	}
}

else if($action=="views") {
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
	
	header('Location: '.$PGURL.'views.php?suc=1');
}

function generatePassword($length = 8) {
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
	return $password;
}

?>