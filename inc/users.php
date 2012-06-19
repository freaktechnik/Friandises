<?php
include_once($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'admin/config.php');
include_once('pagevar.php');
$connect = mysql_connect($DB_LOCA, $DB_USER, $DB_PASS);
if (!$connect)
{
   header('Location: '.$PGURL.'error.php?error=Could not connect to the Database.');
}

mysql_select_db($DB_NAME, $connect);

$users;
$i=0;

$result = mysql_query("SELECT user,email,showemail FROM logins");
while ($objResult = mysql_fetch_object($result)) {
	
    $user[$objResult->user]["email"]=$objResult->email;
	$user[$objResult->user]["show"]=$objResult->showemail;
	
	$i=$i+1;
}

$users=$i;

mysql_free_result($result);

mysql_close($connect);

?>