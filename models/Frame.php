<?php
/**
 * Frame.php
 * Simple example of how to use a server-side language with protoframe
 * Warning! This is an example only - use at your own risk.
*/
session_start();

class Frame
{
    public $title = 'proto [ frame ]'; //page title, appears on each page
    public $subtitle = 'coffee induced coding'; //subtitle of the site
    public $summary = 'This is a demo of protoframe, a tiny AJAX-based framework utilizing <acronym title="PHP Hypertext Processor">PHP</acronym> (optional) and the <a href="http://prototypejs.org">prototype javascript library</a>.  The main foci are behaviour-based interaction and data loading: only once and only when needed.  Default behaviours allow protoframe to work "out of the box" - <a href="javascript/Frame.js">view the javascript</a> or <a href="http://github.com/Jaiss/protoframe">download protoframe</a>.'; //short summary
    public $pagetitle = 'Protoframe Demo';
    public $css = 'news_sheet';
    public $css_title;
    public $breadcrumbs;
    public $page;
    private $_debug_level = 5;

    function __construct()
    {
        $this->css_title = empty($_SESSION['css']) ? $this->css : $_SESSION['css'];
        $this->css = 'styles/' . $this->css_title . '/' . $this->css_title . '.php';
        if ($_SERVER[QUERY_STRING]) {
            $query_string = htmlspecialchars(striptags($_SERVER[QUERY_STRING]));
            $crumbs = explode('/', $query_string);
            $bread = '?';
            foreach($crumbs as $crumb) {
                $bread.= ($crumb == '') ? 'index' : $crumb . '/';
                $breadcrumbs.= '<a href="' . $bread . '">' . prettify($crumb) . '</a> : ';
            }
            $this->breadcrumbs = '<a href="/" title="Home Page">Home</a> : ' . substr($breadcrumbs, 0, -2);
        } else $this->breadcrumbs = '<a href="index.php" title="home page">home</a> : ';
        $this->page = $_SERVER[SCRIPT_FILENAME];
        $this->pagetitle = prettify($crumb);
    }
    function debug($msg, $level = 0)
    {
        if ($this->_debug_level >= $level) echo $msg;
    }
    function getContent($query)
    {
        if (!$query) $query = 'index';
        if (preg_match('/\/$/', $query)) $query = $query . 'index'; //if there's a slash at the end we want the index
        if (file_exists('views/' . $query . '.php')) include 'views/' . $query . '.php';
        else include 'views/error.php';
    }
}
// General functions, these would probably be in a separate file on a larger site
/* save some typing of \t\t\t */
function entab($num)
{
    return "\n" . str_repeat("\t", $num);
}
/* turns a directory $dir into an unordered list */
function directoryToList($dir, $onlydirs = false, $sub = false)
{
    $levels = explode('/', $dir);
    $subtab = (count($levels) > 2 ? count($levels) - 2 : 0);
    $t = count($levels) + ($sub !== false ? 1 + $subtab : 0);
    $output = entab($t) . '<ul id="parent_' . ereg_replace('/', ':', $dir) . '">';
    $dirlist = opendir($dir);
    while ($file = readdir($dirlist)) {
        if ($file != '.' && $file != '..' && $file != 'index.php' && !eregi('~', $file) && !eregi('.php', $file)) {
            $newpath = $dir . '/' . $file;
            $level = explode('/', $newpath);
            $tabs = count($level) + ($sub !== false ? 1 + $subtab : 0);
            $link = ereg_replace('.php', '', ereg_replace('views/', '', $newpath));
            $class = (is_dir($newpath)) ? ' class="parent"' : ' class="file"';
            $output.= (($onlydirs == true && is_dir($newpath)) || $onlydirs == false ? entab($tabs) . '<li id="' . $file . '"' . $class . '><a href="?' . (is_dir($newpath) ? $link . '/index' : $link) . '">' . prettify($file) . '</a>' . (is_dir($newpath) ? directoryToList($newpath, $onlydirs, false) . entab($tabs) : '') . '</li>' : '');
        }
    }
    closedir($dirlist);
    $output.= entab($t) . '</ul>';
    //if($onlydirs == TRUE)
    $output = preg_replace('/<ul(.*)>\n([\t]+)<\/ul>/', '', $output);
    return $output;
}
/* Returns a prettified file or folder name */
function prettify($string)
{
    $string = (ereg_replace("/", ": ", $string));
    $string = (ereg_replace(".php", "", $string));
    $string = (ereg_replace("_", " ", $string));
    $string = (ereg_replace('\\\+', " ", $string));
    $string = ucwords($string); //only problem being that some words shouldn't be capitalized so we:
    $nocaps = array("and", "or", "of", "the");
    foreach($nocaps as $value) {
        if (eregi($value, $string) && !eregi("^$value", $string)) {
            $string = ereg_replace(ucwords($value), $value, $string);
        }
    }
    //todo:add in something to look for acronyms and not do the ucwords thing on them
    return $string;
}
/* page generation time */
function timer($starttime)
{
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];
    $endtime = $mtime;
    $totaltime = ($endtime - $starttime);
    printf("%f seconds", $totaltime);
}
