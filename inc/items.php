<?php

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);

$items;
$i=0;

$result = mysql_query("SELECT * FROM content ORDER BY id");
while ($objResult = mysql_fetch_object($result)) {
	if($objResult->caption!=NULL) {
		$objcap=" - ".$objResult->caption;
	}
	else {
		$objcap="";
	}
	
    $items[$i]["url"]=$objResult->url;
	$items[$i]["name"]=$objResult->name;
	$items[$i]["caption"]=$objResult->name.$objcap;
	$items[$i]["thumbnail"]=$objResult->thumbnail;
	$items[$i]["category"]=$objResult->category;
	$items[$i]["date"]=$objResult->date;
	$items[$i]["added"]=$objResult->added;
	$items[$i]["creator"]=$objResult->creator;
	
	$i=$i+1;
}

$items_length=$i;

mysql_free_result($result);

mysql_close($connect);

?>