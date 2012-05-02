<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php include 'admin/config.php';
include ('inc/pagevar.php');
echo $PGNAME." - ".$_GET['error'];?></title>
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" >
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
	<meta http-equiv="content-language" content="en">
<meta name="generator" content="Martin Giger">
<?php 
echo "<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '".$G_ANALYTICS."']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>";
?>
    </head>
<body>
   <h2 id="head"><?php echo $_GET['error']; ?></h2>
   <div id="text"><a href="index.php">Frontpage</a></div>
   <div id="bottom">
		<div id="footer">
			<a href="impressum.php">Impressum</a> | <a href="<?php echo $PGURL; ?>/admin/feed.rss" title="RSS Feed"><img src="images/rss.png" alt="RSS Feed" ></a>
		</div>
		<script type="text/javascript" src="js/footer.js"></script>
	</div>
</body>
</html>
