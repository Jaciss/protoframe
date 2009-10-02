<?php
$mtime = explode(" ", microtime());
$starttime = $mtime[1]+$mtime[0];
require 'models/Frame.php';
$site = new Frame();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Jaciss"/>
	<meta name="keywords" content="protoframe, prototype, mvc, framework, jaciss" />
	<meta name="description" content="" />
	<meta name="ROBOTS" content="NOINDEX, NOFOLLOW"/>
	<meta name="date" content="2007-12-10T23:41:58-0900"/>

	<title><?php echo $site->pagetitle; ?></title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<link href="<?php echo $site->css; ?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="javascript/prototype.js"></script>
	<script type="text/javascript" src="javascript/Frame.js"></script>
</head>

<body id="body" onload="Frame.init();">

<div id="working"></div>

<div id="container">

	<div id="navigation">
		<h3>Navigation</h3>
		<?php echo directoryToList('views'); ?>
	</div>
	
	<div id="header">
		<h1 id="title"><?php echo $site->title ?></h1>
		<h2 id="subtitle"><?php echo $site->subtitle ?></h2>
		<p id="summary"><?php echo $site->summary ?></p>
	</div>

	<p id="breadcrumbs"><span><?php echo $site->breadcrumbs ?></span></p>
	
	<div id="content">
		<!--Content is added here via AJAX (or PHP if javascript is disabled)-->
			<?php
if ($_SERVER[QUERY_STRING]) $site->getcontent(htmlspecialchars(strip_tags($_SERVER[QUERY_STRING])));
else echo '<noscript><p><a href="?home/index">Javascript free home page</a></p></noscript>';
?>
	</div>

	<div id="footer">
		<p>JS: <span id="js_exe_time"></span> PHP: <?php echo timer($starttime) ?></p>
	</div>

</div>

<div id="debug" style="background:#000;color:#00ff00;height:80px;overflow:auto;position:fixed;bottom:-80px;width:100%;border-top:10px solid #EEE;padding-left:5px;margin:0px;padding:0px;text-align:left;padding-left:5px;" onmouseover="this.style.bottom='0px';" onmouseout="this.style.bottom='-80px';"></div>

</body>
</html>