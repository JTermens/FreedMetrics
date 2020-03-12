<?php

include_once("$search_incDir/reference.search.php");
include_once("$search_incDir/parsers.search.php");

$_SESSION['queryData'] = $_REQUEST;

$max_results = 50;
if(array_key_exists('search_query', $_SESSION['queryData'])){
	$user_query = $_SESSION['queryData']['search_query'];
}else{
	header('Location: index.php?pagename=Not-Found');
}

$field = 'all';

$_SESSION['arXiv'] = arxiv_search($user_query,$field);
$_SESSION['PubMed'] = pubmed_search($user_query,$field);
$_SESSION['FreedMetrics Database'] = array();

?>