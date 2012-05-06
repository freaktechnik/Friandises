<?php session_start();
include_once 'config.php';
session_destroy(); 
header("Location: /".$PG_LOCA."index.php");
break;
?>
