<?php session_start();
include 'config.php';
if($_SESSION['access']!=allowd||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header("Location: /".$PG_LOCA."error.php?error=401 Access denied");
    break;
}
else {
	$_SESSION['access']=allowd;
}
$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   header("Location: /".$PG_LOCA."admin/error.php?error=Could not connect to the Database.");
}

mysql_select_db($DB_NAME, $connect);
$query = mysql_query("SELECT value FROM settings WHERE name='name'");
$objResult = mysql_fetch_object($query);
$PGNAME = $objResult->value;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Video hinzufügen</title>
<link rel="stylesheet" href="/<?php echo $PG_LOCA;?>style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="de">
<meta name="generator" content="Martin Giger">

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
var textarea = false;
$(document).ready(function() {
	$('select[name="format"]').change(function() {
		if($(this).val()=="html") {
			var val = $('input[name="url"]').val();
			$('input[name="url"]').remove();
			$('<textarea name="url" cols="50" rows="10">'+val+'</textarea>').insertBefore('select[name="format"]');
			$("#urllabel").text("Code");
			textarea = true;
		}
		else if(textarea) {
			textarea = false;
			var val = $('textarea[name="url"]').val();
			$("#urllabel").text("URL");
			$('textarea[name="url"]').remove();
			$('<input type="text" name="url" class="textfield" value="'+val+'">').insertBefore('select[name="format"]');
		}
	});
});
</script>
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Video hinzufügen</h2>
<?php include 'menu.php'; ?>
<div id="intern">
	<p>Titel: <input type="text" name="name" class="textfield"></p>
	<p><span id="urllabel">URL</span>: <input type="text" name="url" class="textfield"><select name="format">
		<option selected="selected" value="auto">Auto detect</option>
		<option value="swf">Flash file</option>
		<option value="audio">Audio file</option>
		<option value="video">Video file</option>
		<option value="img">Image</option>
		<option value="html">HTML code</option>
		</select></p>
	Beschreibung:<br/><textarea name="cap" cols="50" rows="10"></textarea><br/>
	<p>Kategorie: <input type="text" name="cat" class="textfield"></p>
	<p>Datum : <select name="day">
		<option value="00">Unknown</option>
		<option selected="selected" value="01">01</option>
		<option value="02">02</option>
		<option value="03">03</option>
		<option value="04">04</option>
		<option value="05">05</option>
		<option value="06">06</option>
		<option value="07">07</option>
		<option value="08">08</option>
		<option value="09">09</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
		<option value="17">17</option>
		<option value="18">18</option>
		<option value="19">19</option>
		<option value="20">20</option>
		<option value="21">21</option>
		<option value="22">22</option>
		<option value="23">23</option>
		<option value="24">24</option>
		<option value="25">25</option>
		<option value="26">26</option>
		<option value="27">27</option>
		<option value="28">28</option>
		<option value="29">29</option>
		<option value="30">30</option>
		<option value="31">31</option>
	</select>
	<select name="month">
		<option value="00">Unknown</option>
		<option selected="selected" value="01">January</option>
		<option value="02">February</option>
		<option value="03">March</option>
		<option value="04">April</option>
		<option value="05">May</option>
		<option value="06">June</option>
		<option value="07">July</option>
		<option value="08">August</option>
		<option value="09">September</option>
		<option value="10">October</option>
		<option value="11">November</option>
		<option value="12">December</option>
	</select> <input type="text" size="4" maxlength="4" name="year" class="textfield"></p>
	<input type="text" name="action" value="video" style="display:none;">
	<input type="submit" value="Hinzufügen" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {
		echo "images/ok.png";
	}
	else {
		echo "images/clear.png";
	}
	?>">
</form>
</div>
</body>
</html>
