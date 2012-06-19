<?php session_start();

include_once ('config.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/users.php');
include_once ($_SERVER['DOCUMENT_ROOT'].$PG_LOCA.'inc/pagevar.php');

$connect = mysql_connect($DB_LOCA, $DB_USER, $DB_PASS);
if (!$connect)
{
   header('Location: '.$PGURL.'error.php?error=Could not connect to the Database.');
}
  
if (empty($_POST['passwort'])){header('Location: '.$PGURL.'admin/login.php?fail=true'); break;}

mysql_select_db($DB_NAME, $connect);

$username=$_POST['name'];
$password=$_POST['passwort'];

if($user[$username]['email']==NULL){header('Location: '.$PGURL.'admin/login.php?fail=true'); break;} // prevent SQL injection

$query = mysql_query("SELECT user, password, admin FROM logins WHERE user='$username'");
$objResult = mysql_fetch_object($query);

  if ($username==$objResult->user && $password==$objResult->password)
  {     
    $_SESSION['access']='allowd';
    $_SESSION['username']=$_POST['name'];
    $_SESSION['login_time']=date("U");
	$_SESSION['admin']=$objResult->admin;
	
	mysql_free_result($objResult);
	mysql_close($connect);
    header('Location: '.$PGURL.'admin/intern.php');
  }
  else
  {
    mysql_free_result($objResult);
	mysql_close($connect);
    header('Location: '.$PGURL.'admin/login.php?fail=true');
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo $PGTITLE; ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    </head>
<body>
   <h2>Sie werden sofort weitergeleitet.</h2>
   <?php ?>
</body>
</html> 
