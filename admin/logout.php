<?php session_start();
include_once ('config.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/items.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');
session_destroy();
header('Location: '.$PGURL.'index.php');
?>
