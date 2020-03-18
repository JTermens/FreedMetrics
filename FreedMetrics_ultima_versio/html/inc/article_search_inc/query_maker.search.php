<?php

// query conditions for the database search
function query_database($user_query,$field){

	$search_fields = array('title','author','abstract','journal','keyword','source_id','doi');

	if ($field == 'title'){
		return "MATCH(title) AGAINST('$user_query' IN NATURAL LANGUAGE MODE)";
	}elseif ($field == 'author') {
		return "article_id IN (SELECT Article_article_id FROM Persons_has_Article WHERE is_author=1 AND Persons_person_id IN (SELECT person_id FROM Persons WHERE MATCH(name) AGAINST('$user_query' IN NATURAL LANGUAGE MODE)))";
	}elseif ($field == 'abstract') {
		return "MATCH(abstract) AGAINST('$user_query' IN NATURAL LANGUAGE MODE)";
	}elseif ($field == 'journal') {
		return "Journal_automatic_id_journal IN (SELECT automatic_id_journal FROM Journal WHERE MATCH(Name) AGAINST('$user_query' IN NATURAL LANGUAGE MODE))";
	}elseif ($field == 'keyword') {
		return "article_id IN (SELECT Article_article_id FROM Article_has_Keywords WHERE Keywords_idKeywords IN (SELECT idKeywords FROM Keywords WHERE MATCH(keyword) AGAINST('$user_query' IN NATURAL LANGUAGE MODE)))";
	}elseif ($field == 'source_id') {
		return "MATCH(source_id) AGAINST('$user_query' IN NATURAL LANGUAGE MODE)";
	}elseif ($field == 'doi') {
		return "MATCH(doi) AGAINST('$user_query' IN NATURAL LANGUAGE MODE)";
	}elseif ($field == 'all') {
		$condition_query = "";
		$field_count = 0;
		foreach ($search_fields as $field) {
			$field_count += 1;
			if($field_count == count($search_fields)){
				$condition_query .= "(".query_database($user_query,$field).")";
			}else{
				$condition_query .= "(".query_database($user_query,$field).") OR ";
			}
		}
		return $condition_query;
	}else{
		throw new Exception("$field field hasn't been recognized");
	}
}

// query conditions for the arxiv search
function query_arxiv($user_query,$field){
	if ($field == 'title'){
		return "ti:%22".preg_replace('/\s+/', '%20', $user_query)."%22";
	}elseif ($field == 'author') {
		return "au:%22".preg_replace('/\s+/', '%20', $user_query)."%22";
	}elseif ($field == 'abstract') {
		return "abs:%22".preg_replace('/\s+/', '%20', $user_query)."%22";
	}elseif ($field == 'journal') {
		return "jr:%22".preg_replace('/\s+/', '%20', $user_query)."%22";
	}elseif ($field == 'keyword') {
		return "cat:%22".preg_replace('/\s+/', '%20', $user_query)."%22";
	}elseif ($field == 'source_id') {
		return "id:%22".$user_query."%22";
	}elseif ($field == 'doi') {
		return "";
	}elseif ($field == 'all') {
		return preg_replace('/\s+/', '+', $user_query);
	}else{
		throw new Exception("$field field hasn't been recognized");
	}
}

// query conditions for the pubmed search
function query_pubmed($user_query,$field){
	if ($field == 'title'){
		return '"'.preg_replace('/\s+/', '+', $user_query).'"[title]';
	}elseif ($field == 'author') {
		return preg_replace('/\s+/', '+', $user_query)."[author]";
	}elseif ($field == 'abstract') {
		return '"'.preg_replace('/\s+/', '+', $user_query).'"[tiab]';
	}elseif ($field == 'journal') {
		return preg_replace('/\s+/', '[ta]+OR+', $user_query)."[ta]";
	}elseif ($field == 'keyword') {
		return preg_replace('/\s+/', '[keyword]+OR', $user_query)."[keyword]+OR+".preg_replace('/\s+/', '[MeSH]+OR', $user_query)."[MeSH]";
	}elseif ($field == 'source_id') {
		return $user_query."[uid]";
	}elseif ($field == 'doi') {
		return $user_query."[doi]";
	}elseif ($field == 'all') {
		return preg_replace('/\s+/', '+', $user_query);
	}else{
		throw new Exception("$field field hasn't been recognized");
	}
}