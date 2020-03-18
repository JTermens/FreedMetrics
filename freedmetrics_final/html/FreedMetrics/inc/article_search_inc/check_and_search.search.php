<?php

include "$search_incDir/reference.search.php";
include "$search_incDir/search_functions.search.php";

if ($_GET['action'] == 'new'){
	$start = 0;

	// clean past session
	$_SESSION['user_query'] = "";
	$_SESSION['start'] = $start;

	$queryData = $_REQUEST;

	unset($queryData['pagename']);
	unset($queryData['action']);

	if(empty($queryData)){
		header("Location: index.php?pagename=Home");
	}

	$user_query = array();

	// dump the request into a dict
	$query_counter = 1;
	while(!empty($queryData)){

		if(array_key_exists("search_input$query_counter", $queryData)){
			$condition = array();

			$condition['search_input'] = $queryData["search_input$query_counter"];
			$condition['field'] = $queryData["field$query_counter"];

			unset($queryData["search_input$query_counter"]);
			unset($queryData["field$query_counter"]);
		
			if($query_counter != 1){
				$condition['connector'] = $queryData["connector$query_counter"];
				unset($queryData["connector$query_counter"]);
			}

			array_push($user_query, $condition);
		}	
		$query_counter += 1;
	}

	$_SESSION['user_query'] = $user_query;

}elseif ($_GET['action'] == 'next') {
	$start = $_SESSION['start'] + $max_results;
	$_SESSION['start'] = $start;
	$user_query = $_SESSION['user_query'];
}

$_SESSION['FreedMetrics_Database'] = database_search($user_query,$conn);

// Filter the results to avoid duplications

$id_array = array(); // create an array with the source id of each article
$doi_array = array();

$result = $conn->query("SELECT source_id,doi FROM Article");
if($result->num_rows > 0){
		while($row = mysqli_fetch_assoc($result)){
			array_push($id_array, $row['source_id']);
			if ($row['doi'] != ''){
			array_push($doi_array, $row['doi']);
			}
		}
	}

$pubmed_entries = array();
foreach (pubmed_search($user_query,$start,$max_results) as $entry_key => $entry_value) {
	if (!in_array($entry_value['source_id'], $id_array)) {
		// if an article is in arxiv and pubmed, take the pubmed entry
		array_push($doi_array, $entry_value['doi']);
		$pubmed_entries[$entry_key] = $entry_value;
	}
}

$_SESSION['PubMed'] = $pubmed_entries;

$arxiv_entries = array();
foreach (arxiv_search($user_query,$start,$max_results) as $entry_key => $entry_value) {
	if (!in_array($entry_value['source_id'], $id_array) and !in_array($entry_value['doi'], $doi_array)) {
		$arxiv_entries[$entry_key] = $entry_value;
	}
}

$_SESSION['arXiv'] = $arxiv_entries;
