<?php session_start();
include ('config.php');
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /".$PG_LOCA."error.php");
    break;
}
else {
	$_SESSION['access']=allowd;
}

include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/items.php');
include ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
$id=$_GET['id'];


//  0000-00-00
//  0123456789
//-10987654321
$year=substr($items[$id]["date"],0,4);
$month=substr($items[$id]["date"],5,2);
$day=substr($items[$id]["date"],-2,2);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Videoinfos von Video <?php echo $items[$id]["name"]; ?> bearbeiten</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta name="description" content="<?php echo $PGDSC; ?>" >
<meta name="keywords" content="Geschichte,History,Videos,Filme,Geschichts Videos,Geschichts Filme">
<meta http-equiv="content-language" content="de">

<link rel="stylesheet" href="/style.css" type="text/css" media="screen" >
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
var videoid = <?php echo $items_length-$id;?>;
$(document).ready(function() {
	$("input").blur(function() {
		var namei = $(this).attr("name");
		if(!$("#"+namei+" .validate").hasClass("ok")&&namei!="year") { // prevent radios/selects form double submitting (not excluded with type!=radio in case the change handler won't work)
			$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"content",id:videoid},function() {
				$("#"+namei+" .validate").addClass("ok");
			});
		}
		else if(namei=="year") {
			namei = "date";
			$.post('write.php',{action:"edit",name:namei,value:createDate(),table:"content",id:videoid},function() {
				$("#"+namei+" .validate").addClass("ok");
			});
		}
	});
	
	$('input[type="select"]').change(function() {
		var namei = $(this).attr("name");
		if(namei=="month"||namei=="day")
			namei = "date";
		$.post('write.php',{action:"edit",name:namei,value:createDate(),table:"content",id:videoid},function() {
			$("#"+namei+" .validate").addClass("ok");
		});
	});
	
	$("input").keypress(function(e) {
        if(e.which == 13) {
            jQuery(this).blur();
		}
	});


	$("input").focus(function() {
		var namei = $(this).attr("name");
		if(namei=="year"||namei=="month"||namei=="day")
			namei = "date";
		$("#"+namei+" .validate").removeClass("ok");
	});
	
	function createDate() {
		var year = parseInt($('input[name="year"]').val());
		var month = $('input[name="month"]').val();
		var day = $('input[name="day"]').val();
		
		return year+"-"+month+"-"+day;
	}
});
</script>
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Videoinfos Videoinfos von Video <?php echo $items[$id]["name"]; ?> bearbeiten</h2>
<?php include 'menu.php'; ?>
<div id="intern">
<a href="edits.php">&lt; back</a>
	<p id="name">Titel: <input type="text" name="name" value="<?php echo $items[$id]["name"]; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="url">Seiten URL: <input type="text" name="url" value="<?php echo $items[$id]["url"]; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="type">Typ: <select name="type">
		<option <?php if($items[$id]["type"]=="html") echo'selected="selected" ';?>value="html">URL to display</option>
		<option <?php if($items[$id]["type"]=="swf") echo'selected="selected" ';?>value="swf">Flash file</option>
		<option <?php if($items[$id]["type"]=="audio") echo'selected="selected" ';?>value="audio">Audio file</option>
		<option <?php if($items[$id]["type"]=="video") echo'selected="selected" ';?>value="video">Video file</option>
		<option <?php if($items[$id]["type"]=="img") echo'selected="selected" ';?>value="img">Image</option>
		<option <?php if($items[$id]["type"]=="code") echo'selected="selected" ';?>value="code">HTML code</option>
		</select><span class="validate sym"></span>
	<p id="thumbnail">Thumbnail URL: <input type="text" name="thumbnail" value="<?php echo $items[$id]["thumbnail"]; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="caption">Beschreibung: <span class="validate sym"></span></p>
	<textarea name="caption" cols="50" rows="10"><?php echo $items[$id]["description"]; ?></textarea><br/>
	<p id="category">Kategorie: <input type="text" name="category" value="<?php echo $items[$id]["category"]; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="date">Datum : <select name="day">
		<option <?php if($day=="00") echo 'selected="selected" ';?>value="00">Unknown</option>
		<option <?php if($day=="01") echo 'selected="selected" ';?>value="01">01</option>
		<option <?php if($day=="02") echo 'selected="selected" ';?>value="02">02</option>
		<option <?php if($day=="03") echo 'selected="selected" ';?>value="03">03</option>
		<option <?php if($day=="04") echo 'selected="selected" ';?>value="04">04</option>
		<option <?php if($day=="05") echo 'selected="selected" ';?>value="05">05</option>
		<option <?php if($day=="06") echo 'selected="selected" ';?>value="06">06</option>
		<option <?php if($day=="07") echo 'selected="selected" ';?>value="07">07</option>
		<option <?php if($day=="08") echo 'selected="selected" ';?>value="08">08</option>
		<option <?php if($day=="09") echo 'selected="selected" ';?>value="09">09</option>
		<option <?php if($day=="10") echo 'selected="selected" ';?>value="10">10</option>
		<option <?php if($day=="11") echo 'selected="selected" ';?>value="11">11</option>
		<option <?php if($day=="12") echo 'selected="selected" ';?>value="12">12</option>
		<option <?php if($day=="13") echo 'selected="selected" ';?>value="13">13</option>
		<option <?php if($day=="14") echo 'selected="selected" ';?>value="14">14</option>
		<option <?php if($day=="15") echo 'selected="selected" ';?>value="15">15</option>
		<option <?php if($day=="16") echo 'selected="selected" ';?>value="16">16</option>
		<option <?php if($day=="17") echo 'selected="selected" ';?>value="17">17</option>
		<option <?php if($day=="18") echo 'selected="selected" ';?>value="18">18</option>
		<option <?php if($day=="19") echo 'selected="selected" ';?>value="19">19</option>
		<option <?php if($day=="20") echo 'selected="selected" ';?>value="20">20</option>
		<option <?php if($day=="21") echo 'selected="selected" ';?>value="21">21</option>
		<option <?php if($day=="22") echo 'selected="selected" ';?>value="22">22</option>
		<option <?php if($day=="23") echo 'selected="selected" ';?>value="23">23</option>
		<option <?php if($day=="24") echo 'selected="selected" ';?>value="24">24</option>
		<option <?php if($day=="25") echo 'selected="selected" ';?>value="25">25</option>
		<option <?php if($day=="26") echo 'selected="selected" ';?>value="26">26</option>
		<option <?php if($day=="27") echo 'selected="selected" ';?>value="27">27</option>
		<option <?php if($day=="28") echo 'selected="selected" ';?>value="28">28</option>
		<option <?php if($day=="29") echo 'selected="selected" ';?>value="29">29</option>
		<option <?php if($day=="30") echo 'selected="selected" ';?>value="30">30</option>
		<option <?php if($day=="31") echo 'selected="selected" ';?>value="31">31</option>
	</select>
	<select name="month">
		<option <?php if($month=="00") echo 'selected="selected" ';?>value="00">Unknown</option>
		<option <?php if($month=="01") echo 'selected="selected" ';?>value="01">January</option>
		<option <?php if($month=="02") echo 'selected="selected" ';?>value="02">February</option>
		<option <?php if($month=="03") echo 'selected="selected" ';?>value="03">March</option>
		<option <?php if($month=="04") echo 'selected="selected" ';?>value="04">April</option>
		<option <?php if($month=="05") echo 'selected="selected" ';?>value="05">May</option>
		<option <?php if($month=="06") echo 'selected="selected" ';?>value="06">June</option>
		<option <?php if($month=="07") echo 'selected="selected" ';?>value="07">July</option>
		<option <?php if($month=="08") echo 'selected="selected" ';?>value="08">August</option>
		<option <?php if($month=="09") echo 'selected="selected" ';?>value="09">September</option>
		<option <?php if($month=="10") echo 'selected="selected" ';?>value="10">October</option>
		<option <?php if($month=="11") echo 'selected="selected" ';?>value="11">November</option>
		<option <?php if($month=="12") echo 'selected="selected" ';?>value="12">December</option>
	</select> <input type="number" maxlength="4" name="year" value="<?php echo $year; ?>" class="textfield"> <span class="validate sym"></span></p>
</div>
</body>
</html>
