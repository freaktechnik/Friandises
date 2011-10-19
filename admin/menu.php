<?php 
$pattern = '#'.$_SERVER['DOCUMENT_ROOT'].'admin/#';
$fiel = preg_replace($pattern,'',$_SERVER['SCRIPT_FILENAME']);

?>
<div id="navigation">
<ul>
<li><a href="intern.php"<?php if($fiel=="intern.php") {echo ' class="actual"';} ?>>Video hinzufügen</a></li>
<li><a href="edits.php"<?php if($fiel=="edits.php"||$fiel=="edit.php") {echo ' class="actual"';} ?>>Videodetails Bearbeiten</a></li>
<?php if($_SESSION['admin']==1) {
if($fiel=="settings.php") {$menu->settings=' class="actual"';}
if($fiel=="views.php") {$menu->views = ' class="actual"';}
if($fiel=="newu.php") {$menu->newu = ' class="actual"';}
echo '<li><a href="settings.php"'.$menu->settings.'>Einstellungen</a></li>
<li><a href="views.php"'.$menu->views.'>Views settings</a></li>
<li><a href="newu.php"'.$menu->newu.'>Benutzer hinzufügen</a></li>';
}
?>
<li style="text-align: right;"><a href="user.php"<?php if($fiel=="user.php") {echo ' class="actual"';} ?>>Benutzername: <?php echo $_SESSION['username']; ?></a></li>
</ul></div><br>