<?php
include 'config.php';
date_default_timezone_set('Europe/Paris');
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
$newPubDate = dateConvertTimestamp("$objResult->added");
$filec="
    <item>
        <title>".$objResult->name."</title>
        <description><![CDATA[<img src='".$objResult->thumbnail."' alt='".$objResult->name." /><p>".$objResult->caption."</p>]]></description>
        <link>".$PGURL."/video.php?id=1</link>
        <pubDate>".$newPubDate."</pubDate>
        <category>".$objResult->category."</category>
        <enclosure url='".$objResult->url."' type='application/x-shockwave-flash' />
        <guid isPermaLink='true'>".$PGURL."/video.php?id=1</guid>
	    <media:content url='".$objResult->url."' type='application/x-shockwave-flash' expression='full' medium='video' isDefault='true' lang='".$PGLANG."' />
        <media:thumbnail url='".$objResult->thumbnail."' />
        <media:description type='html'><img src='".$objResult->thumbnail."' alt='".$objResult->name."'/>".$objResult->caption."</media:description>
        <media:title>".$objResult->name."</media:title>
        <media:keywords>".$objResult->category."</media:keywords>
        <media:embed url='".$objResult->url."' width='512' height='323' >
            <media:param name='type'>application/x-shockwave-flash</media:param>
            <media:param name='width'>512</media:param>
            <media:param name='height'>323</media:param>
            <media:param name='allowFullScreen'>true</media:param>
            <media:param name='movie'>".$objResult->url."</media:param>
        </media:embed>
    </item>
</channel>
</rss>";
//  at author field should be email
$c=2;

$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category, creator, added FROM content WHERE id='$c'");
$objResult = mysql_fetch_object($query);
do {
	if($objResult!=NULL) {
		$newPubDate = dateConvertTimestamp("$objResult->added");
		$filec="
    <item>
        <title>".$objResult->name."</title>
        <description><![CDATA[<img src='".$objResult->thumbnail."' alt='".$objResult->name." /><p>".$objResult->caption."</p>]]></description>
        <link>".$PGURL."/video.php?id=".$c."</link>
        <pubDate>".$newPubDate."</pubDate>
        <category>".$objResult->category."</category>
        <enclosure url='".$objResult->url."' type='application/x-shockwave-flash' />
        <guid isPermaLink='true'>".$PGURL."/video.php?id=".$c."</guid>
        <media:content url='".$objResult->url."' type='application/x-shockwave-flash' expression='full' medium='video' isDefault='true' lang='".$PGLANG."' />
        <media:thumbnail url='".$objResult->thumbnail."' />
        <media:description type='html'><img src='".$objResult->thumbnail."' alt='".$objResult->name."'/>".$objResult->caption."</media:description>
        <media:title>".$objResult->name."</media:title>
        <media:keywords>".$objResult->category."</media:keywords>
        <media:embed url='".$objResult->url."' width='512' height='323' >
            <media:param name='type'>application/x-shockwave-flash</media:param>
            <media:param name='width'>512</media:param>
            <media:param name='height'>323</media:param>
            <media:param name='allowFullScreen'>true</media:param>
            <media:param name='movie'>".$objResult->url."</media:param>
        </media:embed>
    </item>".$filec;
	}
	$c=$c+1;
	$query = mysql_query("SELECT name, url, caption, thumbnail, hello, category FROM content WHERE id='$c'");
	$objResult = mysql_fetch_object($query);
} while($objResult->hello==1);

$filec ='<?xml version="1.0" encoding="utf-8" ?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
<channel>
    <title>'.$PGNAME.'</title>
    <link>'.$PGURL.'</link>
    <description>'.$PGDSC.'</description>
    <language>'.$PGLANG.'</language>
    <copyright>'.$PGOWN.'</copyright>
    <pubDate>'.date('D, d M Y h:i:s T').'</pubDate>
    <image>
        <url>'.$PGURL."/".$PGIMG.'</url>
        <title>'.$PGNAME.'</title>
        <link>'.$PGURL.'</link>
    </image>'.$filec;

$file = fopen('feed.rss','w');
fwrite($file, $filec);
fclose($file);
?>