<?php

include_once("$search_incDir/load_database.search.php");
include_once("$metrics_incDir/metrics_functions.metrics.php");
include_once("$search_incDir/get_article_data.search.php");

$last_id = $conn->query("SELECT MAX(article_id) FROM Article");

if ((array_key_exists('id', $_GET)) and (!empty($_GET['id'])) and ($_GET['id'] <= $last_id)) {

	//article id
	$article_id = $_GET['id'];

	// if no actions are applied, then the article has a new visit
	if(!array_key_exists('action', $_GET)){
		$visits = $conn->query("SELECT visits FROM Article WHERE article_id=$article_id");
		$visits = $visits->fetch_assoc();
		$visits = intval($visits['visits'])+1;
		$conn->query("UPDATE Article SET visits = $visits WHERE article_id=$article_id");

		// update web and user statistics if no actions are applied
		$num_searches = $conn->query("SELECT num_searches FROM Web_Statistics WHERE idWeb_Statistics=1");
		$num_searches = $num_searches->fetch_assoc();
		$num_searches = intval($num_searches['num_searches'])+1;
		$conn->query("UPDATE Web_Statistics SET num_searches = $num_searches WHERE idWeb_Statistics=1");

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
	}

	// retrive article data
	$article_data = get_article_data($article_id,$conn);

	// refresh metrics if action=refresh_metrics
	if (array_key_exists('action', $_GET) and ($_GET['action'] == 'refresh_metrics') and (isset($_SESSION['username']))) {
		$metrics_raw = retrive_metrics($article_data,$conn,$article_id);

		// refresh doi if its a preprint from arxiv
		if (($article_data['source'] == 'arxiv') and ($article_data['doi'] == '')) {
			refresh_arxiv_doi($article_id, $conn);
		}

		// create metrics and tweets dictionaries
		$metrics_dict = array('Visits on Freedmetrics' => $article_data['visits'],
						  'Wikipedia References' => $metrics_raw[0]['Wikipedia References'],
						  'Crossref References' => $metrics_raw[0]['Crossref References'],
						  'PubMed Citations' => $metrics_raw[0]['PubMed Citations'],
						  'Total num. of tweets' => $metrics_raw[0]['Total num. of tweets'],
						  'Num. of original tweets' => $metrics_raw[0]['Num. of original tweets'],
						);
		$tweets_dict = $metrics_raw[1];

	}else{
		// create metrics and tweets dictionaries
		$metrics_dict = array('Visits on Freedmetrics' => $article_data['visits'],
						  'Wikipedia References' => $article_data['Wikipedia References'],
						  'Crossref References' => $article_data['Crossref References'],
						  'PubMed Citations' => $article_data['PubMed Citations'],
						  'Total num. of tweets' => $article_data['Total num. of tweets'],
						  'Num. of original tweets' => $article_data['Num. of original tweets'],
						);
		$tweets_dict = $article_data['tweets'];
	}

}elseif ((array_key_exists('source', $_GET)) and (array_key_exists('article-ref', $_GET))){
	$article_data = $_SESSION[$_GET['source']][$_GET['article-ref']];

	// load article to the database
	$article_id = load_article_database($article_data,$conn);

	// retrive and load its metrics
	$metrics = retrive_metrics($article_data,$conn,$article_id);

	header("Location: index.php?pagename=Article-Page&id=$article_id");
}else{
	header("Location: index.php?pagename=Home");
}
