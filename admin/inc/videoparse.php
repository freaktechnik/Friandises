<?php
function videoparse($url) {

	$suffix = '/0.jpg';

	$purl = parse_url($url);
	$path = pathinfo($purl["path"]);

	switch($purl["host"]) {
	case "youtube.com":
	case "www.youtube.com":
		$vid = preg_replace('#.+v=#','',$purl["query"]);
		$vid = preg_replace('#&.+$#','',$vid);
		$vurl = 'http://www.youtube.com/embed/'.$vid."?hd=1&showinfo=0&autohide=1";
		$thumbnail = 'http://img.youtube.com/vi/'.$vid.$suffix;
		$type = "html";
	break;
	case "videoportal.sf.tv":
	case "www.videoportal.sf.tv":
		$vid = preg_replace('#.+id=#','',$purl["query"]);
		$vurl = 'http://www.sf.tv/videoplayer/embed/'.$vid;
		$thumbnail= 'http://www.videoportal.sf.tv/cvis/segment/thumbnail/'.$vid;
		$type="swf";
	break;
	case "youtu.be":
		$vid = preg_replace("#/#","",$purl["path"]);
		$vurl = 'http://www.youtube.com/embed/'.$vid."?hd=1&showinfo=0&autohide=1";
		$thumbnail= 'http://img.youtube.com/vi/'.$vid.$suffix;
		$type="html";
	break;
	case "dailymotion.com":
	case "www.dailymotion.com":
		$vid = preg_replace('#/video/#','',$purl["path"]);
		$vid = substr($vid,0,6);
		$vurl = 'http://dailymotion.com/embed/video/'.$vid;
		$thumbnail= 'http://dailymotion.com/thumbnail/video/'.$vid;
		$type="html";
	break;
	case "vimeo.com":
	case "www.vimeo.com":
		$vid = preg_replace("#/#","",$purl["path"]);
		$vurl = 'http://player.vimeo.com/video/'.$vid;
		$thumbnail = "Vimeo is complicated."; // why do I need sockets :(
		$vurl = $vurl."?title=0&amp;byline=0&amp;portrait=0&amp;color=ff9933";
		$type ="html";
	break;
	case $path["extension"]=="swf":
	case $format=="swf":
		$vurl = $url;
		$thumbnail = "images/video.png";
		$type = "swf";
	break;
	case $path["extension"]=="mp3":
	case $path["extension"]=="wav":
	case $path["extension"]=="m4a":
	case $path["extension"]=="aac":
	case $path["extension"]=="ogg":
	case $format=="audio":
		$vurl = $url;
		$thumbnail = "images/audio.png";
		$type="audio";
	break;
	case $path["extension"]=="webm":
	case $path["extension"]=="m4v":
	case $path["extension"]=="ogv":
	case $format=="video":
		$vurl = $url;
		$thumbnail = "images/video.png";
		$type = "video";
	break;
	case $path["extension"]=="jpg":
	case $path["extension"]=="jpeg":
	case $path["extension"]=="png":
	case $path["extension"]=="bmp":
	case $path["extension"]=="ico":
	case $format=="image":
		$vurl = $url;
		$thumbnail = $url;
		$type = "img";
	break;
	case $format=="html":
		$vurl = $url;
		$thumbnail = "imgaes/code.png";
		$type = "code";
	break;
	default:
		$vurl = $url;
		$thumbnail = "http://www.iwebtool2.com/img/?domain=".$url;
		$type = "html";
	}
	
	if(is_numeric($year)) {
		$date=$year."-".$month."-".$day;
	}
	else {
		header("Location: error.php?error=Please enter a proper year");
	}
	
	$ret->url = $vurl;
	$ret->thumbnail = $thumbnail;
	
	return $ret;

}
?>