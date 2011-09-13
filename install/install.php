<?php
$step=$_GET['step']
switch($step) {
	case 2: $dbname=$_POST['dbname'];
			$dblocation=$_POST['dblocation'];
			$dbusername=$_POST['dbusername'];
			$dbpassword=$_POST['dbpassword'];
			$location=$_POST['directory'];
			$a = fopen($_SERVER['DOCUMENT_ROOT'].$location.'admin/config.php','w+');
			fwrite($a, '<?php
$DB_LOCA = "'.$dblocation.'";
$DB_USER = "'.$dbusername.'";
$DB_PASS = "'.$dbpassword.'";
$DB_NAME = "'.$dbname.'";
$PG_LOCA = "'.$location.'";
?>');
			fclose($a);
			$connect = mysql_connect("$dblocation", "$dbusername", "$dbpassword");
			if (!$connect)
			{
				die('Could not connect: ' . mysql_error());
			}

			mysql_select_db($dbname, $connect);
			$query = mysql_query("CREATE TABLE settings (name TEXT,value TEXT)");
			$query = mysql_query("CREATE TABLE logins (user TEXT,password TEXT,admin INT NOT NULL DEFAULT '0',email TEXT,showemail INT NOT NULL DEFAULT '1')");
			$query = mysql_query("CREATE TABLE content (url TEXT,name TEXT,caption TEXT,category TEXT,thumbnail TEXT,id BIGINT(20) NOT NULL AUTO_INCREMENT,date DATE,creator TEXT,added TIMESTAMP DEFAULT('CURRENT_TIMESTAMP'),type TEXT)");
			break;
	case 3: $un = $_POST['un'];
			$pw = $_POST['pw'];
			$email = $_POST['e'];
			$name=$_POST['name'];
			if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
				die("e-Mail adress not valid!");
			}
			$sql = "INSERT INTO logins (user, password, admin, email) VALUES ('$un', '$pw', '1', '$email');";
			$results = mysql_query($sql);
			$subject = "Your account for your brand new Friandises installation";
			$body = "Hi ".$un."\n\nYou just created your account for your new Friandises installation.\nYour login informations:\nUsername: ".$un."\nPassword: ".$pw."\nYou can edit your e-mail adress and password when you are logged in.";
			if (!mail($email, $subject, $body)) {
				die("Error sending e-Mail.");
			}
			break;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Install Friandises</title>

<link rel="stylesheet" href="/style.css" type="text/css" media="screen" >
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
<meta http-equiv="content-language" content="en">

</head>
<body>
<h2 id="head">Install Friandises</h2>
<div id="navigation"><ul><li><a href="#" <?php if($step==1) { echo 'class="actual"'; ?>>Step 1</a></li><li><a href="#" <?php if($step==2) { echo 'class="actual"'; ?>>Step 2</a></li><li><a href="#" <?php if($step==3) { echo 'class="actual"'; ?>>Step 3</a></li><li><a href="#" <?php if($step==4) { echo 'class="actual"'; ?>>Step 4</a></li></ul></div>
<div id="intern">
<?php switch($step) {
	case 2: echo '<p>Now you need to create a first login. This login will have adminrights (creating users and changing page settings).</p>
	<form method="POST" action="install.php?step=3">
	<p>Username: <input type="text" name="un" class="textfield"></p>
	<p>Password: <input type="password" name="pw" class="textfield"></p>
	<p>e-Mail: <input type="email" name="e" class="textfield"></p>
	<p><input type="submit" value="Next"></p>
</form>'; break;
	case 3: echo '<p>Please enter basic informations about your new Friandises isntallation. Fields with * are required.</p>
	<form method="POST" action="install.php?step=4">
	<p><!--Settings informations. Please do check if requireds are enterededed--></p>
	<p><input type="submit" value="Next"></p>
</form>'; break;
	default : echo '<p>Welcome to the installer for the Friandises Project. As First step Friandises needs a database. It uses MySQL. Please fill out the fields below. Everything is needed.</p>
<form method="POST" action="install.php?step=2">
	<p>Database Name: <input type="text" name="dbname" class="textfield"></p>
	<p>Database Location (normally localhost): <input type="text" name="dblocation" class="textfield"></p>
	<p>Database Username: <input type="text" name="dbusername" class="textfield"></p>
	<p>Database Password: <input type="password" name="dbpassword" class="textfield"></p>
	<p>Directory (leave blank if Friandises is in the server root) <input type="text" name="directory" class="textfield"></p>
	<p><input type="submit" value="Next"></p>
</form>'; break;
} ?>
</div>
</body>
</html>
