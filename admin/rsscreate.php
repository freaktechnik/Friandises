<?php
include ('config.php');
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/items.php');
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/users.php');

date_default_timezone_set('Europe/Paris');

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

$filec = "</channel>
</rss>";
$newPubDate = dateConvertTimestamp("$objResult->added");
for($fad=1;$fad<$items_length;$fad++) {

	if($users[$items[$fad]["creator"]]["showemail"]==1) {
		$author= "
			<author>".$users[$items[$fad]["creator"]]["email"]."</author>";
	}
	else {
		$author = "";
	}
	$filec="
    <item>
        <title>".$items[$fad]["name"]."</title>
        <description><![CDATA[<img src='".$items[$fad]["thumbnail"]."' alt='".$items[$fad]["name"]." /><p>".$items[$fad]["caption"]."</p>]]></description>
        <link>".$PGURL."/video.php?id=".$fad."</link>
        <pubDate>".dateConvertTimestamp("$items[$fad]['added']")."</pubDate>
        <category>".$items[$fad]["category"]."</category>".$author."
        <enclosure url='".$items[$fad]["url"]."' type='application/x-shockwave-flash' />
        <guid isPermaLink='true'>".$PGURL."/video.php?id=".$fad."</guid>
	    <media:content url='".$items[$fad]["url"]."' type='application/x-shockwave-flash' expression='full' medium='video' isDefault='true' lang='".$PGLANG."' />
        <media:thumbnail url='".$items[$fad]["thumbnail"]."' />
        <media:description type='html'><img src='".$items[$fad]["thumbnail"]."' alt='".$items[$fad]["name"]."'/>".$items[$fad]["caption"]."</media:description>
        <media:title>".$items[$fad]["name"]."</media:title>
        <media:keywords>".$items[$fad]["category"]."</media:keywords>
        <media:embed url='".$items[$fad]["url"]."' width='512' height='323' >
            <media:param name='type'>application/x-shockwave-flash</media:param>
            <media:param name='width'>512</media:param>
            <media:param name='height'>323</media:param>
            <media:param name='allowFullScreen'>true</media:param>
            <media:param name='movie'>".$items[$fad]["url"]."</media:param>
        </media:embed>
    </item>".$filec;
}


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

$file = fopen($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'feeds/feed.rss','w+');
fwrite($file, $filec);
fclose($file);
?>