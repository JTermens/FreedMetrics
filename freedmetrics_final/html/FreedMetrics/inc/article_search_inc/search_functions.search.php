<?php

include "$search_incDir/query_maker.search.php";
include "$search_incDir/get_article_data.search.php";


function user_history($user_id,$conn){

	$id_dict = array();

	$query = "SELECT DISTINCT article_id,visits FROM Article t1 INNER JOIN Persons_has_Article t2 ON t1.article_id = t2.Article_article_id WHERE t2.Persons_person_id=$user_id AND t2.is_user=1 ORDER BY t1.visits DESC";
	$result = $conn->query($query);
	
	if($result->num_rows > 0){
		while($row = mysqli_fetch_assoc($result)){
			array_push($id_dict, $row['article_id']);
		}
	}

	$entry_count = 0;
	$entries = array();
	if (!(count($id_dict) == 0)){
		foreach ($id_dict as $id) {
			$entry_count += 1;
			$entry = get_article_preview($id,$conn);
			$entries["entry$entry_count"] = $entry;
		}
	}

	return $entries;
}

function most_visited($max_number,$conn){

	$id_dict = array();

	$query = "SELECT article_id FROM Article ORDER BY visits DESC LIMIT $max_number;";
	$result = $conn->query($query);
	
	if($result->num_rows > 0){
		while($row = mysqli_fetch_assoc($result)){
			array_push($id_dict, $row['article_id']);
		}
	}

	$entry_count = 0;
	$entries = array();
	if (!(count($id_dict) == 0)){
		foreach ($id_dict as $id) {
			$entry_count += 1;
			$entry = get_article_preview($id,$conn);
			$entries["entry$entry_count"] = $entry;
		}
	}

	return $entries;
}

function most_recent($max_number,$conn){

	$id_dict = array();

	$query = "SELECT article_id FROM Article ORDER BY article_id DESC LIMIT $max_number;";
	$result = $conn->query($query);
	
	if($result->num_rows > 0){
		while($row = mysqli_fetch_assoc($result)){
			array_push($id_dict, $row['article_id']);
		}
	}

	$entry_count = 0;
	$entries = array();
	if (!(count($id_dict) == 0)){
		foreach ($id_dict as $id) {
			$entry_count += 1;
			$entry = get_article_preview($id,$conn);
			$entries["entry$entry_count"] = $entry;
		}
	}

	return $entries;
}

function database_search($user_query,$conn){

	// translate connectors to sql query
	$conncetor_ref = array(
		'AND' => 'AND',
		'OR' => 'OR',
		'NOT' => 'NOT IN');

	global $search_fields;

	$id_dict = array();

	$search_query = "SELECT DISTINCT article_id FROM Article WHERE ";

	# Search Query Construction

	foreach ($user_query as $condition) {
		if(count($condition) == 3){
			$condition_query = query_database($condition['search_input'],$condition['field']);
			$search_query .= " ".$conncetor_ref[$condition['connector']]." (".$condition_query.")";
		}else{
			$condition_query = query_database($condition['search_input'],$condition['field']);
			$search_query .= "(".$condition_query.")";
		}
	}

	$result = $conn->query($search_query);
	
	if($result->num_rows > 0){
		while($row = mysqli_fetch_assoc($result)){
			array_push($id_dict, $row['article_id']);
		}
	}

	$entry_count = 0;
	$entries = array();
	if (!(count($id_dict) == 0)){
		foreach ($id_dict as $id) {
			$entry_count += 1;
			$entry = get_article_preview($id,$conn);
			$entries["entry$entry_count"] = $entry;
		}
	}

	return $entries;
}

function arxiv_search($user_query,$start,$max_results){

	global $month_ref;
	global $arxiv_keyword_ref; # dictionary with arXiv's keyword references

	$entry_count = 0; # will count the number of entries found

	$arxiv_entries = array(); # dictionary with the parsed entries

	$base_url = 'http://export.arxiv.org/api/query?';

	$search_query = "search_query=";

	$query_end = "&sortBy=relevance&sortOrder=descending&start=$start&max_results=$max_results";

	# Search Query Construction
	foreach ($user_query as $condition) {
		if(count($condition) == 3){
			$condition_query = query_arxiv($condition['search_input'],$condition['field']);
			$search_query .= "+".$condition['connector']."+".$condition_query;
		}else{
			$condition_query = query_arxiv($condition['search_input'],$condition['field']);
			$search_query .= $condition_query;
		}
	}

	$feed = file_get_contents($base_url.$search_query.$query_end); # get xml from the api

	# parse entries from whole xml
	preg_match_all('/<entry>(.+?)<\/entry>/is', $feed, $entries);

	if(empty($entries)){
		return $arxiv_entries;
	}

	foreach ($entries[1] as $entry) {

		#print $entry."\n\n\n";
		$entry_count += 1;

		# parse each entry
		preg_match('/<id>(.+?)<\/id>/is', $entry, $link); # link
		preg_match('/<title>(.+?)<\/title>/is', $entry, $title); # title
		preg_match('/<summary>(.+?)<\/summary>/is', $entry, $abstract); # abstract
		if(empty($abstract)){$abstract[1] = '';}
		preg_match_all('/<name>(.+?)<\/name>/is', $entry, $authors); # authors
		preg_match_all('/<category term="(.+?)" scheme=/is', $entry, $keywords_ref); # keyword references
		if(empty($keywords_ref)){
			$keywords = '';
		}else{
			$keywords = array();
			foreach ($keywords_ref[1] as $ref) {
				if(array_key_exists($ref, $arxiv_keyword_ref)){
					$keywords[] = $arxiv_keyword_ref[$ref];
				}
			}
		}

		preg_match('/<arxiv:doi xmlns:arxiv="http:\/\/arxiv.org\/schemas\/atom">(.+?)<\/arxiv:doi>/is', $entry, $doi); # doi, if any
		if(empty($doi)){$doi[1] = '';}

		$id_raw = explode('/', $link[1]);

		$id = explode('v', $id_raw[count($id_raw)-1])[0];

		// avoid problems with ''
		$title = preg_replace('/\'/', '`', $title[1]);
		$abstract = preg_replace('/\'/', '`', $abstract[1]);
		$authors = preg_replace('/\'/', '`', $authors[1]);

		# construct entry dict
		$entry = array( 
			'title' => $title,
			'link' => $link[1],
			'doi' => $doi[1],
			'journal' => '',
			'publish_date' => '',
			'abstract' => $abstract,
			'authors' => $authors,
			'keywords' => $keywords,
			'source' => 'arxiv',
 			'source_id' => $id,
			);
		
		# append to entries dict
		$arxiv_entries["entry$entry_count"] = $entry;
	}
	return $arxiv_entries;
}

function pubmed_search($user_query,$start,$max_results){

	global $month_ref;
	
	$entry_count = 0; # will count the number of entries found

	$pubmed_entries = array(); # dictionary with the parsed entries

	# Search parameters 
	$database = 'pubmed';
	$tool = 'FreedMetrics';
	$email = 'freedmetrics@gmail.com';
	$history = 'y';

	$end = $start + $max_results;

	$base_url_search = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=$database";

	$base_url_fetch = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=$database";

	$search_query = "&term=";

	$query_end = "&retstart=$start&retmax=$end&sort=relevance&tool=$tool&email=$email&usehistory=$history";

	# Search Query Construction

	foreach ($user_query as $condition) {
		if(count($condition) == 3){
			$condition_query = query_pubmed($condition['search_input'],$condition['field']);
			$search_query .= "+".$condition['connector']."+".$condition_query;
		}else{
			$condition_query = query_pubmed($condition['search_input'],$condition['field']);
			$search_query .= $condition_query;
		}
	}

	$feed_search = file_get_contents($base_url_search.$search_query.$query_end); # get xml from search api

	preg_match('/<WebEnv>(\S+)<\/WebEnv>/', $feed_search, $webenv);
	preg_match('/<QueryKey>(\d+)<\/QueryKey>/', $feed_search, $query_key);

	# fetch parameters
	$webenv = $webenv[1];
	$query_key = $query_key[1];
	$mode = 'xml';

	# fetch Query Construction
	$query_fetch = "&query_key=$query_key&WebEnv=$webenv&retmax=$max_results&retmode=$mode&tool=$tool&email=$email";

	$feed_fetch = file_get_contents($base_url_fetch.$query_fetch); # get xml from fetch api

	# parse entries from whole xml
	preg_match_all('/<PubmedArticle>(.+?)<\/PubmedArticle>/is', $feed_fetch, $entries);

	if(empty($entries)){
		return $pubmed_entries;
	}

	foreach ($entries[1] as $entry) {
		$entry_count += 1;

		# parse each entry
		preg_match('/<PMID(.+?)\/PMID>/is', $entry, $id); # id
		preg_match('/>(.+?)</is', $id[1], $id);
		preg_match('/<Journal>(.+?)<\/Journal>/is', $entry, $journal_raw);
			preg_match('/<Title>(.+?)<\/Title>/is', $journal_raw[1], $journal); # journal
			preg_match('/<Year>(.+?)<\/Year>/is', $journal_raw[1], $year); # year

			preg_match('/<Month>(.+?)<\/Month>/is', $journal_raw[1], $month); # month
			preg_match('/<Day>(.+?)<\/Day>/is', $journal_raw[1], $day); # day

			if(empty($month)){$month = '';}else{$month = $month_ref[$month[1]];}
			if(empty($day)){$day = '';}else{$day = $day[1];}
			if(empty($year)){$year = '';}else{$year = $year[1];}

			$publish_date = $day.'/'.$month.'/'.$year; # date of publish

		preg_match('/<ArticleTitle>(.+?)<\/ArticleTitle>/is', $entry, $title); # title
		preg_match_all('/<AbstractText(.+?)<\/AbstractText>/is', $entry, $abstract_raw); # abstract
		if(empty($abstract_raw)){
			$abstract[1] = '';
		}
		else{
			$abstract = '';
			foreach ($abstract_raw[1] as $abstract_piece) {
				preg_match('/>(.*)/is', $abstract_piece, $text);
				preg_match('/Label="(.+?)"/is', $abstract_piece, $label);
				if (empty($label)) {
					$abstract.=$text[1]."\n";
				}else{
					$abstract.='<b>'.$label[1].':</b>&nbsp'.$text[1]."<br>";
				}
			}

		}

		preg_match_all('/<Author(.+?)<\/Author>/is', $entry, $authors_raw); # authors

			$authors = array();
			foreach ($authors_raw[1] as $author_raw) {
				preg_match('/<LastName>(.+?)<\/LastName>/is', $author_raw, $last_name); # last name
				preg_match('/<ForeName>(.+?)<\/ForeName>/is', $author_raw, $fore_name); # fore name
				if(empty($last_name) && empty($fore_name)){
					preg_match('/<CollectiveName>(.+?)<\/CollectiveName>/is', $author_raw, $col_name); # collective name exceptions
					$authors[] = $col_name[1];
				}elseif (empty($last_name)) {
					$authors[] = $fore_name[1];
				}elseif (empty($fore_name)) {
					$authors[] = $last_name[1];
				}else{
					$authors[] = $fore_name[1].' '.$last_name[1];
				}
			}

		preg_match('/<ArticleId IdType="doi">(.+?)<\/ArticleId>/is', $entry, $doi); # doi
		if(empty($doi)){ $doi[1] = '';}

		preg_match_all('/<Keyword (.+?)<\/Keyword>/is', $entry, $keywords_raw); # keywords
		if(empty($keywords_raw)){ 
			$keywords = '';
		}else{
			$keywords = array();
			foreach ($keywords_raw[1] as $keyword_raw) {
				preg_match('/>(.*)/is', $keyword_raw, $keyword);
				$keywords[] = $keyword[1];
			}
		}

		preg_match_all('/<MeshHeading>(.+?)\/<MeshHeading>/', $entry, $mesh_raw);
		if(!empty($keywords_raw)){ 
			foreach ($mesh_raw[1] as $mesh_raw) {
				preg_match('/>(.+?)<\/DescriptorName>/is', $mesh_raw, $mesh);
				$keywords[] = $mesh[1];
			}
		}

		$title = preg_replace('/\'/', '`', $title[1]);
		$abstract = preg_replace('/\'/', '`', $abstract);
		$authors = preg_replace('/\'/', '`', $authors);

		# construct entry dict
		$entry = array( 
			'title' => $title,
			'link' => 'https://www.ncbi.nlm.nih.gov/pubmed/'.$id[1], 
			'doi' => $doi[1],
			'journal' => $journal[1],
			'publish_date' => $publish_date,
			'abstract' => $abstract,
			'authors' => $authors,
			'keywords' => $keywords,
			'source' => 'pubmed',
			'source_id' => $id[1],
			);

		# append to entries dict
		$pubmed_entries["entry$entry_count"] = $entry;
	}
	return $pubmed_entries;
}


#function test

#print "PUBMED RESULTS\n\n\n";

#$user_query = "Cancer";
#print_r(pubmed_search($user_query,"title"));

#print "ARXIV RESULTS\n\n\n";

#$user_query = "Quantum mechanics";
#print_r(arxiv_search($user_query,"ti"));



