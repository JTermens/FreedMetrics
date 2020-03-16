<?php

// Mailer inclusion
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Directories and images
$baseDir = dirname($_SERVER['SCRIPT_FILENAME']);
$baseURL = dirname($_SERVER['SCRIPT_NAME']);

$dbDir = "$baseDir/db";

$incDir = "$baseDir/inc";
$search_incDir = "$incDir/article_search_inc";
$reglog_incDir = "$incDir/register_login_inc";
$mailer_incDir = "$incDir/PHPMailer_inc";
$metrics_incDir = "$incDir/metrics_inc";

$tplDir = "$baseDir/tpl";
$contentDir = "$tplDir/content";
$search_tplDir ="$contentDir/article_search_tpl";
$personal_tplDir = "$contentDir/personal_zone_tpl";

$logo_no_bg = "tpl/img/logos_nobg/logo6_nobg.png";
#$logo_no_bg = "tpl/img/logos_nobg/logo8_nobg.png";
#$logo_no_bg = "tpl/img/logos_nobg/logo9_nobg.png";
#$logo_no_bg = "tpl/img/logos_nobg/logo10_nobg.png";

$lg_width = 8;
$md_width = 10;

// Load accessory routines
include_once("$incDir/lib_FreedMetrics.inc.php");

// Database conection
include_once("../../freedmetrics_connect/db_connect.php");

// Mailer functions
require_once "$mailer_incDir/PHPMailer.php";
require_once "$mailer_incDir/SMTP.php";
require_once "$mailer_incDir/Exception.php";

// Mailer
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
// Settings
include_once("../../freedmetrics_connect/mail_connect.php");

session_start();

// Reference to each page of the website
$pagename_ref = array(
	'Home' => array(
		'route' => "$contentDir/home.php", 
		'style' => '',
	),

	'Search-Results' => array(
		'route' => "$search_tplDir/search_results.php",
		'style' => '',
	),

	'Advanced-Search' => array(
		'route' => "$search_tplDir/advanced_search.php",
		'style' => '',
	),

	'Article-Page' => array(
		'route' => "$search_tplDir/article_page.php",
		'style' => 'full-image',
	),

	'User-Page' => array(
		'route' => "$personal_tplDir/userpage.php",
		'style' => '',
	),

	'Login' => array(
		'route' => "$personal_tplDir/login.php",
		'style' => 'full-image',
	),

	'Not-Found' => array(
		'route' => "$tplDir/page_not_found.php",
		'style' => '',
	),

	'Logout' => array('route' => "$reglog_incDir/logout.reg_log.php"),
	'Name-Search' => array('route' => "$reglog_incDir/NameSearch.reg_log.php"),
	'Reg-complete' => array('route' => "$reglog_incDir/reg_complete.reg_log.php"),
	'Registration' => array('route' => "$reglog_incDir/registration.reg_log.php"),
	'Validation' => array('route' => "$reglog_incDir/validation.reg_log.php"),
);

if (isset($_SESSION['username'])) {
	$pagename_ref['Home']['navbar_tags'] = array('Advanced Search','Personal Zone','LOGOUT');
	$pagename_ref['Search-Results']['navbar_tags'] = array('search_bar','Advanced Search','Personal Zone','LOGOUT');
	$pagename_ref['Advanced-Search']['navbar_tags'] = array('search_bar','Advanced Search','Personal Zone','LOGOUT');
	$pagename_ref['Article-Page']['navbar_tags'] = array('search_bar','Advanced Search','Personal Zone','LOGOUT');
	$pagename_ref['User-Page']['navbar_tags'] = array('search_bar','Advanced Search','Personal Zone','LOGOUT');
	$pagename_ref['Not-Found']['navbar_tags'] = array('search_bar','Advanced Search','Personal Zone','LOGOUT');;
}else{
	$pagename_ref['Home']['navbar_tags'] = array('LOGIN & REGISTER');
	$pagename_ref['Search-Results']['navbar_tags'] = array('search_bar','LOGIN & REGISTER');
	$pagename_ref['Advanced-Search']['navbar_tags'] = array('search_bar','LOGIN & REGISTER');
	$pagename_ref['Article-Page']['navbar_tags'] = array('search_bar','LOGIN & REGISTER');
	$pagename_ref['User-Page']['navbar_tags'] = array('search_bar','LOGIN & REGISTER');
	$pagename_ref['Login']['navbar_tags'] = array('search_bar','LOGIN & REGISTER');
	$pagename_ref['Not-Found']['navbar_tags'] = array('search_bar','LOGIN & REGISTER');
}

$source_ref = array('FreedMetrics Database','PubMed','arXiv');