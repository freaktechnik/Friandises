<?php
include "config.php";
$suffix = '/0.jpg';

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}
mysql_select_db($DB_NAME, $connect);
$name=$_POST['name'];
$email=$_POST['email'];

$query = mysql_query("SELECT email FROM logins WHERE user='$name'");
$objResult = mysql_fetch_object($query);
if($email==$objResult->email&&filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$query = mysql_query("SELECT value FROM settings WHERE name='name'");
	$objResult = mysql_fetch_object($query);
	$PGNAME = $objResult->value;
	$query = mysql_query("SELECT value FROM settings WHERE name='url'");
	$objResult = mysql_fetch_object($query);
	$PGURL = $objResult->value;
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
	$sql = "UPDATE logins SET password='$password' WHERE user='$name' AND email='$email'";
	$results = mysql_query($sql);
	$subject = "Your new password on ".$PGNAME."";
	$body = "Hi ".$name."\n\nHere is your new password for ".$PGNAME.". You can find ".$PGNAME." under ".$PGURL.". \nYour login informations:\nUsername: ".$name."\nPassword: ".$password."\nYou can edit your password when you are logged in.";
	if (mail($email, $subject, $body)&&$results===true) {
		header("Location: newpw.php?fail=asdf");
	}
	else {
		header("Location: newpw.php?fail=true");
	}
}
else {
	header("Location: newpw.php?fail=true");
}
mysql_close($connect);
?>
