<?php
include_once('admin/config.php');
$connect = mysql_connect($DB_LOCA, $DB_USER, $DB_PASS);
if (!$connect)
{
   header('Location: error.php?error=Could not connect to the Database.');
}

mysql_select_db($DB_NAME, $connect);

$query = mysql_query("SELECT value FROM settings WHERE name='url'");
$objResult = mysql_fetch_object($query);
$PGURL = ($TOP_LVL ? $objResult->value.$PG_LOCA : $objResult->value);
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
$query = mysql_query("SELECT value FROM settings WHERE name='owner'");
$objResult = mysql_fetch_object($query);
$PGOWN = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='imptxt'");
$objResult = mysql_fetch_object($query);
$PGIMP = $objResult->value;

mysql_close($connect);

?>