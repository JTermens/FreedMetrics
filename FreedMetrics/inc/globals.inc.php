<?php

session_start();

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
include_once("$incDir/lib_FreedMetrics.inc.php");

$pagename_ref = array(
	'Home' => array(
		'route' => "$contentDir/home.php", 
		'navbar_tags' => array('Advanced Search','LOGIN & REGISTER')),

	'Search-Results' => array(
		'route' => "$search_tplDir/search_results.php",
		'navbar_tags' => array('search_bar','Advanced Search','LOGIN & REGISTER')),

	'Advanced-Search' => array(
		'route' => "$search_tplDir/advanced_search.php",
		'navbar_tags' => array('search_bar','Advanced Search','LOGIN & REGISTER')),

	'Article-Page' => array(
		'route' => "$search_tplDir/article_page.php",
		'navbar_tags' => array('search_bar','Advanced Search','LOGIN & REGISTER')),

	'User-Page' => array(
		'route' => "$personal_tplDir/userpage.php",
		'navbar_tags' => array('search_bar','Advanced Search','LOGOUT')),

	'Login' => array(
		'route' => "$tplDir/page_not_found.php", 
		'navbar_tags' => array('search_bar','Advanced Search','LOGIN & REGISTER')),

	'Not-Found' => array(
		'route' => "$tplDir/page_not_found.php",
		'navbar_tags' => array('search_bar','Advanced Search','LOGIN & REGISTER')),
);

$source_ref = array('FreedMetrics Database','PubMed','arXiv');


