<?php session_start();
include_once 'config.php';
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');

if($_SESSION['access']!='allowd'||$_SESSION['access']==NULL)
{
    session_destroy(); 
	header('Location: '.$PGURL.'/'.$PG_LOCA.'error.php?error=401 Access denied');
}
else {
	$_SESSION['access']='allowd';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $PGNAME; ?> - Einstellungen</title>
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var oldvalue = [];
	$("input").blur(function() {
		var namei = $(this).attr("name");
		if(!$("#"+namei+" .validate").hasClass("ok")&&oldvalue[namei] != $(this).val()) { // prevent radios form double submitting (not excluded with type!=radio in case the change handler won't work)
			$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"settings"},function() {
				$("#"+namei+" .validate").addClass("ok");
			});
		}
	});
	$("textarea").blur(function() {
		var namei = $(this).attr("name");
		if(oldvalue[namei] != $(this).val())
			$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"settings"},function() {
				$("#"+namei+" .validate").addClass("ok");
			});
	});
	
	$('input[type="radio"]').change(function() {
		var namei = $(this).attr("name");
		if(oldvalue[namei] != $(this).val())
			$.post('write.php',{action:"edit",name:namei,value:$(this).val(),table:"settings"},function() {
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
		oldvalue[namei] = $(this).val();
		$("#"+namei+" .validate").removeClass("ok");
	});
	$("textarea").focus(function() {
		var namei = $(this).attr("name");
		oldvalue[namei] = $(this).val();
		$("#"+namei+" .validate").removeClass("ok");
	});
});
</script>
</head>
<body>
<div id="topnav"><a href="logout.php">Log out</a></div>
<h2 id="head">Einstellungen</h2>
<?php include 'menu.php'; ?>
<div id="intern">
	<p id="name">Title: <input type="text" name="name" value="<?php echo $PGNAME; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="url">Page URL: <input type="text" name="url" value="<?php echo $PGURL; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="img">Titleimage URL: <input type="text" name="img" value="<?php echo $PGIMG; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="tmode">Titlemode: <input type="radio" name="tmode" value="1" <?php if($PGTITLE==1) { echo "checked";} ?>> Title as text 
					<input type="radio" name="tmode" value="2" <?php if($PGTITLE==2) { echo "checked";} ?>> View image <span class="validate sym"></span><br/>
	</p>
	<p id="desc">Description: <span class="validate sym"></span><br>
	<textarea name="desc" cols="50" rows="10"><?php echo $PGDSC; ?></textarea></p>
	<p id="tags">Meta Tags: <input type="text" name="tags" value="<?php echo $PGTGS; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="teaser">Teaser: <input type="text" name="teaser" value="<?php echo $PGTEA; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="items">Entries per page (0 shows all on one): <input type="number" name="items" value="<?php echo $PGITMS; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="owner">Siteowner: <input type="text" name="owner" value="<?php echo $PGOWN; ?>" class="textfield"><span class="validate"></span></p>
	<p id="imptxt">Impressum: <span class="validate sym"></span><br><textarea name="imptxt" cols="50" rows="10"><?php echo $PGIMP; ?></textarea></p>
	<p id="lang">Page Language (de, en etc.): <input type="text" name="lang" value="<?php echo $PGLANG; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="addthis">AddThis Username: <input type="text" name="addthis" value="<?php echo $ADD_PUBID; ?>" class="textfield"><span class="validate sym"></span></p>
	<p id="gana">Google Analytics ID: <input type="text" name="gana" value="<?php echo $G_ANALYTICS; ?>" class="textfield"><span class="validate sym"></span></p>
</div>
</body>
</html>