<?php

include_once("$search_incDir/reference.search.php");
include_once("$search_incDir/parsers.search.php");

$_SESSION['queryData'] = $_REQUEST;

$max_results = 100;
if(array_key_exists('search_query', $_SESSION['queryData'])){
	$user_query = $_SESSION['queryData']['search_query'];
}else{
	header('Location: index.php?pagename=Home');
}

$field = 'all';

$arxiv_entries = arxiv_search($user_query,$field);
$pubmed_entries = pubmed_search($user_query,$field);

?>