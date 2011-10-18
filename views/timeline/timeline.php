<?php

function generate() {

global $items, $quat, $PGURL, $PGNAME, $items_length;

$categories[0]="placeholder";
$objact="{'wiki-url':'".$PGURL."', 
  'wiki-section':'".$PGNAME."', 
  'dateTimeFormat': 'Gregorian',
  'events': [
";
$d=1; //number of categorys

for($inde=0;$inde<$items_length;$inde=$inde+1) {

	if(!$quat||$items[$inde]["category"]==$quat) {
		$descre=str_replace("'","\"",$items[$id]["caption"]);echo $descre;

		if(substr($items[$inde]["date"],-5,2)=="00") {	
			$objact = $objact."{'start':'".substr($items[$inde]["date"],0,4)."-01-01T00:00:00+01:00','end':'".substr($items[$inde]["date"],0,4)."-12-31T00:00:00+01:00','durationEvent':true,'title':'".$items[$inde]["name"]."','caption':'".$descre."','icon':'".$items[$inde]["thumbnail"]."','link':'".$PGURL."/video.php?id=".$inde."'},";
		}
		else if (substr($items[$inde]["date"],-2)=="00") {
			$objact = $objact."{'start':'".substr($items[$inde]["date"],0,4)."-".substr($items[$inde]["date"],-5,2)."-01T00:00:00+01:00','end':'".substr($items[$inde]["date"],0,4)."-".substr($items[$inde]["date"],-5,2)."-30T00:00:00+01:00','durationEvent':true,'title':'".$items[$inde]["name"]."','caption':'".$descre."','icon':'".$items[$inde]["thumbnail"]."','link':'".$PGURL."/video.php?id=".$inde."'},";
		}
		else {
			$objact = $objact."{'start':'".$items[$inde]["date"]."T00:00:00+01:00','durationEvent':false,'title':'".$items[$inde]["name"]."','caption':'".$descre."','icon':'".$items[$inde]["thumbnail"]."','link':'".$PGURL."/video.php?id=".$inde."'},";
		}
	}
	
	if(!(array_search($items[$inde]["category"],$categories))||$d==1) {
		$categories[$d]=$items[$inde]["category"];
		$d=$d+1;
	}
}

$objact = $objact."] }";


$retu->data = '<div id="my-timeline" style="height: 400px;"></div>
<noscript>
This page uses Javascript to show you a Timeline. Please enable Javascript in your browser to see the full page. Thank you.
</noscript>';
$retu->cats = $categories;
$retu->noc = $d;

// Not needed from here on
$retu->head = '<script type="text/javascript">
 var tl;
 var objact = '.$objact.';
 
 function onLoad() {
 
   var theme = Timeline.ClassicTheme.create();
            theme.event.instant.icon = "no-image-40.png";
            theme.event.instant.iconWidth = 50;  // These are for the default stand-alone icon
            theme.event.instant.iconHeight = 25;
			theme.event.track.height = 50;
            theme.event.tape.height = 8;
 
   var eventSource = new Timeline.DefaultEventSource();
   var bandInfos = [
     Timeline.createBandInfo({
		 eventSource:    eventSource,
         width:          "90%", 
         intervalUnit:   Timeline.DateTime.MONTH, 
         intervalPixels: 50,
		 theme:          theme,
		 eventPainterParams: {
                        iconLabelGap:     10,
                        labelRightMargin: 20,
                        
                        iconWidth:        50, // These are for per-event custom icons
                        iconHeight:       25
                    }
     }),
     Timeline.createBandInfo({
	     overview:       true,
	     eventSource:    eventSource,
         width:          "10%", 
         intervalUnit:   Timeline.DateTime.YEAR, 
         intervalPixels: 80
     })
   ];
   
  Timeline.OriginalEventPainter.prototype._showBubble = function(x, y, evt) {
   document.location.href=evt.getLink();
  }
   
   // scroll both bands
   bandInfos[1].syncWith = 0;
   bandInfos[1].highlight = true;
   
   
   eventSource.loadJSON(objact, document.location.href); 
   
   tl = Timeline.create(document.getElementById("my-timeline"), bandInfos);
 }

 var resizeTimerID = null;
 function onResize() {
     if (resizeTimerID == null) {
         resizeTimerID = window.setTimeout(function() {
             resizeTimerID = null;
             tl.layout();
         }, 500);
     }
 }
</script>';
$retu->script = "http://static.simile.mit.edu/timeline/api-2.3.0/timeline-api.js?bundle=true";
$retu->onload = "onLoad();";
$retu->onresize = "onResize()";

return $retu;

}

?>
