<?php

function arxiv_search($query){

	global $month_ref;
	global $arxiv_keyword_ref; # dictionary with arXiv's keyword references

	$entry_count = 0; # will count the number of entries found

	$arxiv_entries = array(); # dictionary with the parsed entries

	$base_url = 'http://export.arxiv.org/api/query?';

	$feed = file_get_contents($base_url.$query); # get xml from the api

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

function pubmed_search($query){

	global $month_ref;
	global $max_results;
	global $start;
	
	$entry_count = 0; # will count the number of entries found

	$pubmed_entries = array(); # dictionary with the parsed entries

	$base_url_search = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?';

	$base_url_fetch = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?';

	# Search parameters 
	$database = 'pubmed';
	$tool = 'FreedMetrics';
	$email = 'freedmetrics@gmail.com';
	$history = 'y';

	# Search Query Construction
	$query_search = "db=$database&term=".$query."&tool=$tool&email=$email&usehistory=$history";

	$feed_search = file_get_contents($base_url_search.$query_search); # get xml from search api

	preg_match('/<WebEnv>(\S+)<\/WebEnv>/', $feed_search, $webenv);
	preg_match('/<QueryKey>(\d+)<\/QueryKey>/', $feed_search, $query_key);

	# fetch parameters
	$webenv = $webenv[1];
	$query_key = $query_key[1];
	$mode = 'xml';

	# fetch Query Construction
	$query_fetch = "db=$database&query_key=$query_key&WebEnv=$webenv&retmode=$mode&retstart$start&retmax=$max_results&tool=$tool&email=$email";

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



