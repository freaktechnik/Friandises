<?php session_start();if($_SESSION['access']!=allowd||$_SESSION['access']==NULL){    session_destroy(); 	header("Location: /error.php");    break;}else {	$_SESSION['access']=allowd;}include 'config.php';$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");if (!$connect){   die('Could not connect: ' . mysql_error());}mysql_select_db($DB_NAME, $connect);$query = mysql_query("SELECT value FROM settings WHERE name='name'");$objResult = mysql_fetch_object($query);$PGNAME = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='url'");$objResult = mysql_fetch_object($query);$PGURL = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='img'");$objResult = mysql_fetch_object($query);$PGIMG = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='tmode'");$objResult = mysql_fetch_object($query);$PGTITLE = (int)$objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='desc'");$objResult = mysql_fetch_object($query);$PGDSC = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='tags'");$objResult = mysql_fetch_object($query);$PGTGS = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='teaser'");$objResult = mysql_fetch_object($query);$PGTEA = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='items'");$objResult = mysql_fetch_object($query);$PGITMS = (int)$objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='addthis'");$objResult = mysql_fetch_object($query);$ADD_PUBID = $objResult->value;$query = mysql_query("SELECT value FROM settings WHERE name='gana'");$objResult = mysql_fetch_object($query);$G_ANALYTICS = $objResult->value;?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd"><html><head><title><?php echo $PGNAME; ?> - Einstellungen</title><link rel="stylesheet" href="/style.css" type="text/css" media="screen" ><meta http-equiv="Content-Type" content="text/html;charset=UTF-8" ><meta http-equiv="content-language" content="de"><meta name="generator" content="Martin Giger"></head><body><h2 id="head">Einstellungen</h2><div id="navigation"><ul><li><a href="intern.php">Video hinzufügen</a></li><li><a href="edits.php">Videodetails Bearbeiten</a></li><li><a href="#" class="actual">Einstellungen</a></li><li style="text-align: right;"><a href="user.php">Benutzername: <?php echo $_SESSION['username']; ?></a></li></ul></div><div id="intern"><form method="POST" action="write.php">	<p>Titel: <input type="text" name="name" value="<?php echo $PGNAME; ?>" class="textfield"></p>	<p>Seiten URL: <input type="text" name="url" value="<?php echo $PGURL; ?>" class="textfield"></p>	<p>Titelbild URL: <input type="text" name="img" value="<?php echo $PGIMG; ?>" class="textfield"></p>	<p>Titel-Modus: <input type="radio" name="tmode" value="1" <?php if($PGTITLE==1) { echo "checked";} ?>> Titel als Text 					<input type="radio" name="tmode" value="2" <?php if($PGTITLE==2) { echo "checked";} ?>> Bild anzeigen<br/>	</p>	<p>Beschreibung:</p>	<textarea name="desc" cols="50" rows="10"><?php echo $PGDSC; ?></textarea><br/>	<p>Meta Tags: <input type="text" name="tags" value="<?php echo $PGTGS; ?>" class="textfield"></p>	<p>Teaser: <input type="text" name="teaser" value="<?php echo $PGTEA; ?>" class="textfield"></p>	<p>Videos auf einer Seite (0 bedeutet alle): <input type="number" name="items" value="<?php echo $PGITMS; ?>" class="textfield"></p>	<p>AddThis Username: <input type="text" name="addthis" value="<?php echo $ADD_PUBID; ?>" class="textfield"></p>	<p>Google Analytics ID: <input type="text" name="gana" value="<?php echo $G_ANALYTICS; ?>" class="textfield"></p>	<input type="text" name="what" value="settings" style="display:none;">	<input type="submit" value="speichern" style="text-align:right;"><img class="sym" src="<?php if($_GET['suc']==1) {		echo "images/ok.png";	}	else {		echo "images/clear.png";	}	?>"></form></div><p id="footer"><a href="logout.php">logout</a></p></body></html>