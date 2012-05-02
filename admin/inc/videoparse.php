<?php
function videoparse($url) {

	$suffix = '/0.jpg';

	$purl = parse_url($url);

	switch($purl["host"]) {
	case "youtube.com":
	case "www.youtube.com":
		$vid = preg_replace('#.+v=#','',$purl["query"]);
		$vid = preg_replace('#&.+$#','',$vid);
		$vurl = 'http://www.youtube.com/embed/'.$vid;
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
		$vurl = 'http://www.youtube.com/embed/'.$vid;
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
		$thumbnail ="Vimeo is complicated."; // why do I need sockets :(
		$vurl = $vurl."?title=0&amp;byline=0&amp;portrait=0&amp;color=ff9933";
		$type="html";
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