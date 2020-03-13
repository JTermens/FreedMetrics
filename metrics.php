<?php

# Title needed
function wiki_search($query){

	$searchPage = $query;
	$endPoint = "https://en.wikipedia.org/w/api.php";
	$params = [
    	"action" => "query",
    	"list" => "search",
    	"srsearch" => "\"" . $searchPage . "\"",
    	"format" => "json"
	];

	$url = $endPoint . "?" . http_build_query( $params );

	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	$output = curl_exec( $ch );
	curl_close( $ch );

	$result = json_decode( $output, true );
	$count = count($result['query']['search']);
	return $count;
}
#$a= wiki_search("Hallmarks of Cancer");
#echo $a;

#Returns number of citations in PubMed Central. Needs the PMID
function pubmed_citations($query) {
	$search = file_get_contents('https://eutils.ncbi.nlm.nih.gov/entrez/eutils/elink.fcgi?dbfrom=pubmed&linkname=pubmed_pubmed_citedin&id='.$query.'=my_tool&email=my_email@example.com'
);
$gross_count = preg_match_all("([0-9]{8})",$search);
$net_count = $gross_count - 1;

return $net_count;
}
#$a = pubmed_citations('10647931');
#echo $a;


#References in crossref. Needs the DOI.
function crossref_references($doi) {
	$search = file_get_contents('https://api.crossref.org/works?filter=doi:'.$doi
);
preg_match('/referenced-by-count":(\d+),/',$search, $count);

return $count[1];
}
#$a = crossref_references('10.1016/j.cell.2011.02.013');
#echo $a;


#Returns reads article counts in Mendeley. Needs the DOI.
function readcount_mendeley($query) {
	$search = file_get_contents('https://api.mendeley.com/metadata?doi='.$query.'&access_token=MSwxNTg0MDk3NTE5MTE1LDUzOTI5MDExMSwxMDI4LGFsbCwsLDg3ZWM4NTdkNDU4ZWI0NDE0MzU5ODc1NGUxZWNhOTgyOTdkY2d4cnFiLDc5MWQwYWJjLTMzMzAtMzdiOC1hMWJmLWI0OGU2N2FjZjI3MCxWcy1Bd2N3SC03S0RGYjUycHlXNVI3UFhuZTA'
);
preg_match('#(?<=count":)[0-9]+#',$search, $count);

return $count[0];
}
#$a=readcount_mendeley('10.1016/j.cell.2011.02.013');
#echo $a;


#Returns the link of the article in Mendeley. Needs the DOI.
function link_mendeley($query) {
	$search = file_get_contents('https://api.mendeley.com/metadata?doi='.$query.'&access_token=MSwxNTgzNzQyMTI5MjM0LDUzOTI5MDExMSwxMDI4LGFsbCwsLDYyZmRkZTI0M2JhNTk1NDhmYjI5M2VlNjIzNTlhMTY5MjkzY2d4cnFiLDc5MWQwYWJjLTMzMzAtMzdiOC1hMWJmLWI0OGU2N2FjZjI3MCxKY2o5RUNGMGpSb3pYdTBOUzFIN2xwWGNYZ3M'
);
preg_match('/link":"(htt.*?)"/',$search, $link);

return $link;
}
#$b=link_mendeley('10.1016/s0092-8674(00)81683-9');
#echo $b['link_mendeley'];


#Returns counts by academic status in Mendeley. Needs the DOI. (Don't store in database)
function count_academic_status_mendeley($query) {
	$search = file_get_contents('https://api.mendeley.com/metadata?doi='.$query.'&access_token=MSwxNTgzNzQyMTI5MjM0LDUzOTI5MDExMSwxMDI4LGFsbCwsLDYyZmRkZTI0M2JhNTk1NDhmYjI5M2VlNjIzNTlhMTY5MjkzY2d4cnFiLDc5MWQwYWJjLTMzMzAtMzdiOC1hMWJmLWI0OGU2N2FjZjI3MCxKY2o5RUNGMGpSb3pYdTBOUzFIN2xwWGNYZ3M'
);
preg_match('/Associate Professor":(\d+),/',$search, $associate_professor);
preg_match('/Researcher":(\d+),/',$search, $researcher);
preg_match('/Master":(\d+),/',$search, $master_student);
preg_match('/D. Student":(\d+),/',$search, $phd_student);
preg_match('/"Professor":(\d+),/',$search, $professor);
preg_match('/Doctoral Student":(\d+),/',$search, $postdoctoral_student);
preg_match('/Lecturer":(\d+),/',$search, $lecturer);
preg_match('/Other":(\d+),/',$search, $other);
preg_match('/Librarian":(\d+),/',$search, $librarian);
preg_match('/Postgraduate":(\d+),/',$search, $postgraduate_student);


$dict = array(
	'associate_professor' => $associate_professor[1],
	'researcher' => $reserarcher[1],
	'master_student' => $master_student[1],
	'phd_student' => $phd_student[1],
	'professor' => $professor[1],
	'postdoctoral_student' => $postdoctoral_student[1],
	'lecturer' => $lecturer[1],
	'other' => $other[1],
	'librarian' => $librarian[1],
	'postgradaute_student' => $postgraduate_student[1]
);
return $dict;

}
#Example how to put count of associate professor
#$a=count_academic_status_mendeley('10647931');
#echo $a['associate_professor'];
#foreach ($a as $item){
#	echo $item[1];
#}

#Returns counts by subject area in Mendeley. Needs the DOI. (Don't store in database)
function count_subject_area_mendeley($query) {
	#it needs the DOI
	$search = file_get_contents('https://api.mendeley.com/metadata?pmid='.$query.'&access_token=MSwxNTgzNzQyMTI5MjM0LDUzOTI5MDExMSwxMDI4LGFsbCwsLDYyZmRkZTI0M2JhNTk1NDhmYjI5M2VlNjIzNTlhMTY5MjkzY2d4cnFiLDc5MWQwYWJjLTMzMzAtMzdiOC1hMWJmLWI0OGU2N2FjZjI3MCxKY2o5RUNGMGpSb3pYdTBOUzFIN2xwWGNYZ3M'
);
preg_match('/Philosophy":(\d+),/',$search, $philosophy);
preg_match('/Decision Sciences":(\d+),/',$search, $decision_sciences);
preg_match('/Chemical Engineering":(\d+),/',$search, $chemical_engineering);
preg_match('/Design":(\d+),/',$search, $design);
preg_match('/Materials Science":(\d+),/',$search, $materials_science);
preg_match('/Pharmaceutical Science":(\d+),/',$search, $pharmacology);
preg_match('/Energy":(\d+),/',$search, $energy);
preg_match('/Computer Science":(\d+),/',$search, $computer_science);
preg_match('/Health Professions":(\d+),/',$search, $nursing);
preg_match('/Social Sciences":(\d+),/',$search, $social_sciences);
preg_match('/Recreations":(\d+),/',$search, $sports);
preg_match('/Planetary Sciences":(\d+),/',$search, $planetary_sciences);
preg_match('/Physics and Astronomy":(\d+),/',$search, $physics_astronomy);
preg_match('/Engineering":(\d+),/',$search, $engineering);
preg_match('/Biological Sciences":(\d+),/',$search, $biological_sciences);
preg_match('/Dentistry":(\d+),/',$search, $medicine);
preg_match('/Arts and Humanities":(\d+),/',$search, $arts_humanities);
preg_match('/Environmental Science":(\d+),/',$search, $environmental_science);
preg_match('/Psychology":(\d+),/',$search, $psychology);
preg_match('/Finance":(\d+),/',$search, $economics);
preg_match('/Mathematics":(\d+),/',$search, $mathematics);
preg_match('/Linguistics":(\d+),/',$search, $linguistics);
preg_match('/Moleculat Biology":(\d+),/',$search, $biochem_gen_molbio);
preg_match('/Immunology and Microbiology":(\d+),/',$search, $immuno_micro);
preg_match('/Unspecified":(\d+),/',$search, $unspecified);

$dict = array(
	'philosophy' => $philosophy[1],
	'decision_sciences' => $decision_sciences[1],
	'chemical_engineering' => $chemical_engineering[1],
	'design' => $design[1],
	'materials_sciences' => $materials_sciences[1],
	'pharmacology' => $pharmacology[1],
	'energy' => $computer_science[1],
	'nursing' => $nursing[1],
	'social_sciences' => $social_sciences[1],
	'sports' => $sports[1],
	'planetary_sciences' => $planetar_sciences[1],
	'physics_astronomy' => $physics_astronomy[1],
	'engineering' => $engineering[1],
	'biological_sciences' => $biological_sciences[1],
	'medicine' => $medicine[1],
	'arts_humanities' => $arts_humanities[1],
	'environmental_sciences' => $environmental_sciences[1],
	'psychology' => $psychology[1],
	'economics' => $economics[1],
	'mathematics' => $mathematics[1],
	'linguistics' => $linguistics[1],
	'biochem_gen_molbio' => $biochem_gen_molbio[1],
	'immuno_micro' => $immuno_micro[1],
	'unspecified' => $unspecified[1]
);
return $dict;
}
#Example how to put count of physics_astronomy:
#$a=count_subject_area_mendeley('10647931');
#echo $a['physics_astronomy'];
