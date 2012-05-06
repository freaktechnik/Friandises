<?php

function generate() {

	global $items, $quat, $urlcatsuffix, $page, $PGITMS, $items_length, $urlviewssuffix;

	$inshtml = "";
	$cnt = 0; // items on this page
	$quatcount = 0; // items in this category (usually 0)
	$categories[0] = "placeholder";
	$d = 1; //number of categories
	$pagination = "";
	
	for($inde=0;$inde<$items_length;$inde=$inde+1) {
		if(!$quat&&(($cnt<$PGITMS&&$page*$PGITMS>$inde&&$inde>=($page-1)*$PGITMS)||$PGITMS==0)) {
			$inshtml=$inshtml."<li><a href='/video.php?id=".$inde."' title='".$items[$inde]["caption"]."'><span class='title'>".$items[$inde]["name"]."</span><img src='".$items[$inde]["thumbnail"]."' alt='".$items[$inde]["name"]."'></a></li>";
			$cnt=$cnt+1;
		}
		else if($items[$inde]["category"]==$quat) {
			$quata[$quatcount]=$inde;
			$quatcount=$quatcount+1;
		}
		
		if(!(array_search($items[$inde]["category"],$categories))||$d==1) {
			$categories[$d]=$items[$inde]["category"];
			$d=$d+1;
		}
	}

	if($quatcount>0) {
		for($i=0;$i<$quatcount;$i=$i+1) {
			if(($cnt<$PGITMS&&$page*$PGITMS>=$i&&$i>=($page-1)*$PGITMS)||$PGITMS==0) {
				$inshtml=$inshtml."<li><a href='/video.php?id=".$quata[$i]."' title='".$items[$quata[$i]]["caption"]."'><span class='title'>".$items[$quata[$i]]["name"]."</span><img src='".$items[$quata[$i]]["thumbnail"]."' alt='".$items[$quata[$i]]["name"]."'></a></li>";
				$cnt=$cnt+1;
			}
		}
	}
	
	if((($items_length>=$PGITMS&&!$quat)||$quatcount>$PGITMS)&&$PGITMS!=0) {
		if(!$quat) {
			$pgs=$items_length/$PGITMS;
		}
		else {
			$pgs=$quatcount/$PGITMS;
		}
	
		if($pgs-(int)$pgs!=0) {
			$diff=$pgs-(int)$pgs;
			$pgs=$pgs-$diff+1;
		}
		if($page==1) {
			$pagination = "<b>1</b> <a href='?page=2".$urlviewssuffix.$urlcatsuffix."'>2</a> <a href='?page=".($pgs).$urlviewssuffix.$urlcatsuffix."'>Last &gt;</a>";
		}
		else if($page<$pgs) {
			$pagination = "<a href='?page=1".$urlviewssuffix.$urlcatsuffix."'>&lt; First</a> <a href='?page=".($page-1).$urlviewssuffix.$urlcatsuffix."'>".($page-1)."</a> <b>".$page."</b> <a href='?page=".($page+1).$urlviewssuffix.$urlcatsuffix."'>".($page+1)."</a> <a href='?page=".($pgs).$urlviewssuffix.$urlcatsuffix."'>Last &gt;</a>";
		}
		else if($page==$pgs) {
			$pagination = "<a href='?page=1".$urlviewssuffix.$urlcatsuffix."'>&lt; First</a> <a href='?page=".($page-1).$urlviewssuffix.$urlcatsuffix."'>".($page-1)."</a> <b>".$page."</b>";
		}
	}
	
	
	$retu->data ='<div id="videos"><ul>'.$inshtml.'</ul></div>';
	$retu->pagination = '<div id="pagination">'.$pagination.'</div>';
	$retu->cats = $categories;
	$retu->noc = $d;
	$retu->script = "views/thumbnails/script.js";
	
	return $retu;
}

?>