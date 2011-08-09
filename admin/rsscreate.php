<?php
include 'config.php';
date_default_timezone_set('UTC');
$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   die('Could not connect: ' . mysql_error());
}

mysql_select_db($DB_NAME, $connect);
$query = mysql_query("SELECT value FROM settings WHERE name='name'");
$objResult = mysql_fetch_object($query);
$PGNAME = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='url'");
$objResult = mysql_fetch_object($query);
$PGURL = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='img'");
$objResult = mysql_fetch_object($query);
$PGIMG = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='desc'");
$objResult = mysql_fetch_object($query);
$PGDSC = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='owner'");
$objResult = mysql_fetch_object($query);
$PGOWN = $objResult->value;
$query = mysql_query("SELECT value FROM settings WHERE name='lang'");
$objResult = mysql_fetch_object($query);
$PGLANG = $objResult->value;

function dateConvertTimestamp($mysqlDate) {
	$rawdate=strtotime($mysqlDate);
	if ($rawdate == -1) {
		$convertedDate = 'conversion failed';
	}
	else {
		$convertedDate = date('D, d M Y h:i:s T',$rawdate);
	}
	return $convertedDate;
}

$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category, creator, added FROM content WHERE id='1'");
$objResult = mysql_fetch_object($query);
$newPubDate = dateConvert("$objResult->added");
$filec="<item>
      <title>".$objResult->name."</title>
      <description>".$objResult->caption."</description>
      <link>".$PGURL."/video.php?id=1</link>
      <author>".$objResult->creator."</author>
	  <pubDate>".$newPubDate."</pubDate>
	  <category>".$objResult->category."</category>
      <guid isPermaLink='true'>".$PGURL."/video.php?id=1</guid>
    </item>
	</channel>
 
</rss>";
//  at author field should be name,email
$c=2;

$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category, creator, added FROM content WHERE id='$c'");
$objResult = mysql_fetch_object($query);
do {
	if($objResult!=NULL) {
		$newPubDate = dateConvert("$objResult->added");
		$filec="<item>
      <title>".$objResult->name."</title>
      <description>".$objResult->caption."</description>
      <link>".$PGURL."/video.php?id=".$c."</link>
      <author>".$objResult->creator."</author>
	  <pubDate>".$newPubDate."</pubDate>
	  <category>".$objResult->category."</category>
      <guid isPermaLink='true'>".$PGURL."/video.php?id=".$c."</guid>
    </item>".$filec;
	}
	$c=$c+1;
	$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='$c'");
	$objResult = mysql_fetch_object($query);
} while($objResult->hello==1);

$filec ='<?xml version="1.0" encoding="utf-8"?>
 
<rss version="2.0">
<channel>
<title>'.$PG_NAME.'</title>
    <link>'.$PGURL.'</link>
    <description>'.$PGDSC.'</description>
    <language>'.$PGLANG.'</language>
    <copyright>'.$PGOWN.'</copyright>
    <pubDate>'.date(DATE_RFC822).'</pubDate>
    <image>
      <url>'.$PGURL."/".$PGIMG.'</url>
    </image>'.$filec;

$file = fopen('feed.rss','w+');
fwrite($file, $filec);
fclose($file);
?>