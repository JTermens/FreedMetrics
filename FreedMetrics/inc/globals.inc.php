<?php

$baseDir = dirname($_SERVER['SCRIPT_FILENAME']);
$baseURL = dirname($_SERVER['SCRIPT_NAME']);

$incDir = "$baseDir/inc";
$search_incDir = "$incDir/article_search.inc";
$register_incDir = "$incDir/register_login.inc";

$tplDir = "$baseDir/tpl";
$contentDir = "$tplDir/content";
$search_tplDir ="$contentDir/article_search.tpl";
$register_tplDir ="$contentDir/register_login.tpl";
$personal_tplDir = "$contentDir/personal_zone.tpl";

$logo_no_bg = "tpl/img/logos_nobg/logo6_nobg.png";
#$logo_no_bg = "tpl/img/logos_nobg/logo8_nobg.png";
#$logo_no_bg = "tpl/img/logos_nobg/logo9_nobg.png";
#$logo_no_bg = "tpl/img/logos_nobg/logo10_nobg.png";

$lg_width = 8;
$md_width = 10;

// Load accessory routines
include_once "$incDir/lib_FreedMetrics.inc.php";

$pagename_ref = array(
	'Home' => "$contentDir/home.php",
	'search-results' => "$search_tplDir/search_results.php",
);


