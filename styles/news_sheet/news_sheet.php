<?php
session_start(); //so we have access to session variables
//this CSS's defaults:
$defaultColors = array('rgb(85,85,85)', 'rgb(100,100,100)', 'rgb(168,168,168)', 'rgb(187,187,187)', 'rgb(136,136,136)', 'rgb(242,242,242)', 'rgb(242,242,242)', 'rgb(242,242,242)', 'rgb(248,248,248)', 'rgb(255,255,255)');
$defaultFonts = array('BINNG___.TTF', 'ADINEKIR.TTF', 'Georgia, Century Schoolbook L, New Century Schoolbook, serif', 'URW Gothic L, Verdana, Geneva, sans-serif');
$defaultFontSizes = array('33', '14', '.8', '80');
$color = $defaultColors;
//if session variables are set, use those, otherwise use the defaults
//$color = ($_SESSION['colors']) ? $_SESSION['colors'] : $defaultColors;
$font = (empty($_SESSION['fonts'])) ? $defaultFonts : $_SESSION['fonts'];
$fontSize = (empty($_SESSION['fontSize'])) ? $defaultFontSizes : $_SESSION['fontSize'];
//make sure the session variables have a value, for use elsewhere
$_SESSION['colors'] = array_values($color);
$_SESSION['fonts'] = array_values($font);
$_SESSION['fontSize'] = array_values($fontSize);
header("Content-type: text/css; charset: UTF-8");
?>

body{
	margin: 0;
	padding: 0;
	color: <?php
echo $color[0] ?>;
	font:<?php
echo $_SESSION[fontSize][2] ?>em <?php
echo $_SESSION[fonts][2] ?>;
	background: <?php
echo $color[3] ?>;
	text-align: center;
}
a{
	color: <?php
echo $color[4] ?>;
	text-decoration: underline;
	cursor: pointer;
}
a:hover{color: <?php
echo $color[2] ?>;}
abbr,acronym {letter-spacing:0.05em}
#container{
	margin: 0 auto;
	width: 724px;
	min-height:500px;
	height:auto !important;
	height:500px;
	position: relative;
	background: <?php
echo $color[9] ?> url('flowercorner.png') no-repeat top right;
	padding: 0 2em 0 2em;
	text-align: left;
	border-left:5px double <?php
echo $color[2] ?>;
	border-right:5px double <?php
echo $color[2] ?>;
}
* html #container{
    width: 744px;
    w\idth: 724px;
}
#header{
	padding-top: 3.5em;
}
h1{
	width: 500px;
	height: 45px;
	margin: 0;
}
h2{
	font-size: 12px;
	margin: 0;
	margin-top:-7px;
}
h3{
	padding-left:20px;
	color:<?php
echo $color[3] ?>;
	background: transparent url('flower.png') no-repeat 0% 50%;
}
#summary{
	padding-top:15px;
	padding-bottom:15px;
	padding-left:10px;
	padding-right:10px;
	margin-top:80px;
	border-top:1px solid <?php
echo $color[2] ?>;
	border-bottom:1px solid <?php
echo $color[2] ?>;
	color:<?php
echo $color[2] ?>;
	font:<?php
echo $_SESSION[fontSize][3]+15 ?>% <?php
echo $_SESSION[fonts][3] ?>;
}
#breadcrumbs{
	font-size: 12px;
	position: absolute;
	top: 12px;
	right: 25px;
	margin: 0;
	text-align:right;
}
#working{
	display:block;
	position:fixed;
	top:0px;
	right:0px;
	background:<?php
echo $color[0] ?>;
	color:<?php
echo $color[9] ?>;
	padding:1em;
}

#content{
	min-height:200px;
}
#content p{
	line-height: 180%;
	margin: 10px 0 10px 0;
}
#content li{
	list-style-type:square;
	margin:.4em;
}
#content ul{
	margin:0;
	padding:0;
}

#biglinks li{
	list-style-type:none;
	float:right;
	width:24em;
	margin:.5em;
	padding:1em;
	padding-left:4em;
	font-weight:bold;
	border:1px solid <?php
echo $color[3] ?>;
	background: <?php
echo $color[8] ?> url(item.gif) no-repeat 4% 50%;
}

.morelinks{
	text-align:right;
	font-weight:bold;
	margin-bottom:2em;
	margin-right:4em;
}
.code{
	padding:.5em;
	border-left:4px solid <?php echo $color[7] ?>;
	background-color: <?php echo $color[8] ?>;
}
#footer{
	height: 48px;
	line-height: 24px;
	text-align: right;
	padding: 10px 10px 0 0;
	font-size: 90%;
	margin-top:30px;
	border-top:1px solid <?php
echo $color[2] ?>;
	background:transparent url(valid-xhtml.png) no-repeat 4% 50%;
}
#footer span{
	margin-right:1em;
}




/* Navigation ala suckerfish */
#navigation h3{display:none}

#navigation{
	position:absolute;
	z-index:11;
	top:10em;
}

#navigation, #navigation ul {
	float: left;
	width: 600px;
	list-style: none;
	line-height: 1;
	background: <?php
echo $color[9] ?>;
	font-weight: bold;
	padding: 0;
	margin: 0 0 1em 0;
}
#navigation ul{
	text-transform:lowercase;
	letter-spacing:.1em;
	font:bold <?php
echo $_SESSION[fontSize][3]+15 ?>% <?php
echo $_SESSION[fonts][3] ?>;
}
#navigation ul ul{
	-moz-border-radius:0 2.2em 0 2.2em;
}
#navigation ul ul li:last-child{
	-moz-border-radius:0 0 0 100em;
}
#navigation ul ul li:first-child{
	-moz-border-radius:0 100em 0 0;
}
#navigation a {
	display: block;
	width: 10em;
	w\idth: 6em;
	text-decoration: none;
	padding: 0.25em 2em;
}
#navigation .parent {
	background: url("flower-closed.png") no-repeat 5% 50%;
}
#navigation .parent:hover {
	background: <?php
echo $color[7] ?> url("flower.png") no-repeat 5% 50%;
}
#navigation li {
	float: left;
	padding: 0;
	width: 10em;
}
#navigation li ul {
	position: absolute;
	left: -999em;
	height: auto;
	width: 14.4em;
	w\idth: 13.9em;
	font-weight: normal;
	border: solid 0.25em <?php
echo $color[6] ?>;
	margin: 0;
}
#navigation li li {
	padding-right: 1em;
	width: 13em
}
#navigation li ul a {
	width: 13em;
	w\idth: 9em;
}
#navigation li ul ul {
	margin: -1.75em 0 0 14em;
}
#navigation li:hover ul ul, #navigation li:hover ul ul ul, #navigation li.sfhover ul ul, #navigation li.sfhover ul ul ul {
	left: -999em;
}
#navigation li:hover ul, #navigation li li:hover ul, #navigation li li li:hover ul, #navigation li.sfhover ul, #navigation li li.sfhover ul, #navigation li li li.sfhover ul {
	left: auto;
}
#navigation li:hover, #navigation li.sfhover {
	background-color: <?php
echo $color[6] ?>;
}