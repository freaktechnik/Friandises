<?php session_start();

include 'config.php';

$connect = mysql_connect("$DB_LOCA", "$DB_USER", "$DB_PASS");
if (!$connect)
{
   header("Location: /".$PG_LOCA."error.php?error=Could not connect to the Database.");
}
  
if (empty($_POST['passwort'])){header("Location: /index.php"); break;}

mysql_select_db($DB_NAME, $connect);

$username=$_POST['name'];
$password=$_POST['passwort'];

$query = mysql_query("SELECT user, password, admin FROM logins WHERE user='$username'");
$objResult = mysql_fetch_object($query);



  if ($username==$objResult->user && $password==$objResult->password)
  {     
    $_SESSION['access']=allowd;
    $_SESSION['username']=$_POST['name'];
    $_SESSION['login_time']=date("U");
	$_SESSION['admin']=$objResult->admin;
    header("Location: intern.php");
    break;
  }
  else
  {
    header("Location: login.php?fail=true");
    break;
  }

if($_SESSION['access']=!allowd)
{
    header("Location: /error.php");
    break;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Geschichte-sehen.ch</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    </head>
<body>
   <h2>Sie werden sofort weitergeleitet</h2>
   <?php ?>
</body>
</html> 
