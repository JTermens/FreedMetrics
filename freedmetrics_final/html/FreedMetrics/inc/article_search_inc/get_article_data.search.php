<?php

function get_article_data($article_id,$conn) {

	#GET DATA FROM THE TABLE ARTICLES

	$sql = "SELECT title, abstract, article_date, url, doi, source_id, wikipedia_references, crossref_references, pubmed_citations, total_tweets, original_tweets, visits, source_idsource, Journal_automatic_id_journal FROM Article WHERE article_id='$article_id'";
	$result = $conn->query($sql) or die($conn->error);
	$row = $result->fetch_assoc();

	$title = $row['title'];
	$abstract = $row['abstract'];
	$article_date = $row['article_date'];
	$link = $row['url'];
	$doi = $row['doi'];
	$source_id = $row['source_id'];
	$wikipedia_references = $row['wikipedia_references'];
	$crossref_references = $row['crossref_references'];
	$pubmed_citations = $row['pubmed_citations'];
	$total_tweets = $row['total_tweets'];
	$original_tweets = $row['original_tweets'];
	$visits = $row['visits'];

	$idsource = $row['source_idsource'];
	$automatic_id_journal = $row['Journal_automatic_id_journal'];

	#GET DATA FROM THE TABLE JOURNAL
	$sql = "SELECT Name FROM Journal WHERE automatic_id_journal='$automatic_id_journal'";
	$result = $conn->query($sql) or die($conn->error);
	$row = $result->fetch_assoc();

	$journal = $row['Name'];


	#GET DATA FROM THE TABLE SOURCE
	$sql = "SELECT source FROM source WHERE idsource='$idsource'";
	$result = $conn->query($sql) or die($conn->error);
	$row = $result->fetch_assoc();

	$source = $row['source'];


	#GET DATA FROM THE TABLE JOURNAL
	$sql = "SELECT Name FROM Journal WHERE automatic_id_journal='$automatic_id_journal'";
	$result = $conn->query($sql) or die($conn->error);
	$row = $result->fetch_assoc();

	$journal = $row['Name'];


	////// GETTING ID_KEYWORDS AND KEYWORDS  //////
	#GET ID_KEYWORDS FROM THE TABLE ARTICLE_HAS_KEYWORDS
	$sql = "SELECT Keywords_idKeywords FROM Article_has_Keywords WHERE Article_article_id=$article_id";
	$result = $conn->query($sql);
	$data = array();
	$id_keywords = array();
	if ($result->num_rows > 0) {
	  while ($row = mysqli_fetch_assoc($result)){
	    $data[] = $row;
	  }
	}
	foreach ($data as $item){
	  $id_keywords[] = $item['Keywords_idKeywords'];
	}


	#GET KEYWORDS FROM THE TABLE KEYWORDS
	$keywords = array();
	foreach ($id_keywords as $id_keyword) {
	  $sql = "SELECT keyword FROM Keywords WHERE idKeywords='$id_keyword'";
	  $result = $conn->query($sql) or die($conn->error);
	  $row = $result->fetch_assoc();
	  $keywords[] = $row['keyword'];
	}


	////// GETTING ID_AUTHORS AND AUTHORS  //////
	#GET ID_AUTHOR(PERSON_ID) FROM THE TABLE PERSONS_HAS_ARTICLE
	$sql = "SELECT Persons_person_id FROM Persons_has_Article WHERE Article_article_id=$article_id AND is_author=1";
	$result = $conn->query($sql);
	$data = array();
	$id_authors = array();
	if ($result->num_rows > 0) {
	  while ($row = mysqli_fetch_assoc($result)){
	    $data[] = $row;
	  }
	}
	foreach ($data as $item){
	  $id_authors[] = $item['Persons_person_id'];
	}


	#GET AUTHORS FROM THE TABLE AUTHORS
	$authors = array();
	foreach ($id_authors as $id_author) {
	  $sql = "SELECT name FROM Persons WHERE person_id='$id_author'";
	  $result = $conn->query($sql) or die($conn->error);
	  $row = $result->fetch_assoc();
	  $authors[] = $row['name'];
	}

	$tweet_ids = array();

	#GET TWEET_ID FROM THE TABLE TWEET
	$sql = "SELECT tweet_id FROM Tweet WHERE Article_article_id='$article_id'";
	$result = $conn->query($sql);
	$data = array();
	while ($row = mysqli_fetch_assoc($result)){
	    $data[] = $row;
	  }
	foreach ($data as $item){
	  array_push($tweet_ids, $item['tweet_id']);
	}


	$article_data = array('article_id' => $article_id,
	                      'title' => $title,
	                      'link' => $link,
	                      'doi' => $doi,
	                      'journal' => $journal,
	                      'publish_date' => $article_date,
	                      'abstract' => $abstract,
	                      'authors' => $authors,
	                      'keywords' => $keywords,
	                      'source' => $source,
	                      'source_id' => $source_id,
	                      'visits' => $visits,
	                      'Wikipedia References' => $wikipedia_references,
	                      'Crossref References' => $crossref_references,
	                      'PubMed Citations' => $pubmed_citations,
	                      'Total num. of tweets' => $total_tweets,
	                      'Num. of original tweets' => $original_tweets,
	                      'tweets' => $tweet_ids);

	return $article_data;
}




#user_history("b@b")