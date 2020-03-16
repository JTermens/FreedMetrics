<?php

include_once("$search_incDir/load_database.search.php");
include_once("$metrics_incDir/metrics_functions.metrics.php");

$article_data = $_SESSION[$_GET['source']][$_GET['article-ref']];

if ($_GET['source'] == 'FreedMetrics Database') {

	// if no actions are applied, then the article has a new visit
	if(!array_key_exists('action', $_GET)){
		$visits = $conn->query("SELECT visits FROM Article WHERE article_id=$article_id");
		$visits = $visits->fetch_assoc();
		$visits = intval($visits['visits'])+1;
		$conn->query("UPDATE Article SET visits = $visits WHERE article_id=$article_id");
	}

	//article id
	$article_id = $article_data['article_id'];

	// create metrics and tweets dictionaries
	$metrics_dict = array('Visits on Freedmetrics' => $article_data['visits'],
						  'Wikipedia References' => $article_data['Wikipedia References'],
						  'Crossref References' => $article_data['Crossref References'],
						  'PubMed Citations' => $article_data['PubMed Citations'],
						  'Total num. of tweets' => $article_data['Total number of tweets'],
						  'Num. of original tweets' => $article_data['Number of original tweets'],
						);
	$tweets_dict = $article_data['tweets'];

	// refresh metrics if action=refresh_metrics
	if (array_key_exists('action', $_GET) and ($_GET['action'] == 'refresh_metrics') and (isset($_SESSION['username']))) {
		$metrics_raw = retrive_metrics($article_data,$conn,$article_id);

		$metrics_dict = $metrics_raw[0];
		$tweets_dict = $metrics_raw[1];

		// refresh doi if its a preprint from arxiv
		if (($article_data['source'] == 'arxiv') and ($article_data['doi'] == '')) {
			refresh_arxiv_doi($article_id, $conn);
		}
	}
}else{
	// load article to the database
	$article_id = load_article_database($article_data,$conn);

	// retrive and load its metrics
	$metrics_raw = retrive_metrics($article_data,$conn,$article_id);

	$metrics_dict = $metrics_raw[0];
	$tweets_dict = $metrics_raw[1];
	$metrics_dict['Visits on Freedmetrics'] = 1;
}

// update web statistics
if(!array_key_exists('action', $_GET)){
	$num_searches = $conn->query("SELECT num_searches FROM Web_Statistics WHERE idWeb_Statistics=1");
	$num_searches = $num_searches->fetch_assoc();
	$num_searches = intval($num_searches['num_searches'])+1;
	$conn->query("UPDATE Web_Statistics SET num_searches = $num_searches WHERE idWeb_Statistics=1");
}

// if the search is done by a loged user, update its num_articles_searched
// and add it to its history
if (isset($_SESSION['username'])) {
	$user_email = $_SESSION['email'];
	$person_id = $_SESSION['person_id'];

	$num_articles_searched = $conn->query("SELECT num_articles_searched FROM Persons WHERE email='$user_email'");
	$num_articles_searched = $num_articles_searched->fetch_assoc();
	$num_articles_searched = intval($num_articles_searched['num_articles_searched'])+1;
	$conn->query("UPDATE Persons SET num_articles_searched = '$num_articles_searched' WHERE email='$user_email'");

	// add relation to persons_has_article if it isn't
	$check = $conn -> query("INSERT IGNORE INTO Persons_has_Article (Article_article_id, Persons_person_id, is_user) VALUES ($article_id,$person_id,1)" );
}
