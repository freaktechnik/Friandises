<?php

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
$query = mysql_query("SELECT value FROM settings WHERE name='gana'");
$objResult = mysql_fetch_object($query);
$G_ANALYTICS = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='addthis'");
$objResult = mysql_fetch_object($query);
$ADD_PUBID = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='lang'");
$objResult = mysql_fetch_object($query);
$PGLANG = $objResult->value;

mysql_close($connect);

?>