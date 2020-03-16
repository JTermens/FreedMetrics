<?php

include_once("$search_incDir/reference.search.php");
include_once("$search_incDir/parsers.search.php");

$_SESSION['queryData'] = $_REQUEST;

if(array_key_exists('search_query', $_SESSION['queryData']) and  !empty($_SESSION['queryData']['search_query'])){
	$user_query = $_SESSION['queryData']['search_query'];
}else{
	header('Location: index.php?pagename=Not-Found');
}

$field = 'all';
$max_results = 100;
$start = 0;

$arxiv_query = "search_query=$field:".preg_replace('/\s+/', '+', $user_query)."&start=$start&max_results=$max_results";
$pubmed_query = preg_replace('/\s+/', '+', $user_query)."[$field]&retstart$start&retmax=$max_results";

$_SESSION['arXiv'] = arxiv_search($arxiv_query,$field);
$_SESSION['PubMed'] = pubmed_search($pubmed_query,$field);
$_SESSION['FreedMetrics Database'] = array();