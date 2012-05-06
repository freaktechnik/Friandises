<?php
include_once("admin/config.php");
$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   header("Location: /".$PG_LOCA."error.php?error=Could not connect to the Database.");
}

mysql_select_db($DB_NAME, $connect);

$items;
$i=0;

$result = mysql_query("SELECT * FROM content ORDER BY id DESC");
while ($objResult = mysql_fetch_object($result)) {
	if($objResult->caption!=NULL) {
		$objcap=$objResult->name." - ".$objResult->caption;
	}
	else {
		$objcap=$objResult->name;
	}
	
    $items[$i]["url"]=$objResult->url;
	$items[$i]["name"]=$objResult->name;
	$items[$i]["caption"]=preg_replace("/'/",'"',$objcap);
	$items[$i]["description"]=$objResult->caption;
	$items[$i]["thumbnail"]=$objResult->thumbnail;
	$items[$i]["category"]=$objResult->category;
	$items[$i]["date"]=$objResult->date;
	$items[$i]["added"]=$objResult->added;
	$items[$i]["creator"]=$objResult->creator;
	$items[$i]["type"]=$objResult->type;
	
	$i=$i+1;
}

$items_length=$i;

mysql_free_result($result);

mysql_close($connect);

?>