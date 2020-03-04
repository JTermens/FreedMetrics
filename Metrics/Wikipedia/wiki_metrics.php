<?php

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

	return $result;
	
}

#Example 

$result = wiki_search("Hallmarks of Cancer");

echo ("Referenced " . count($result['query']['search']) . " times in the following articles:" . "<br>");

for ($i=0;$i < count($result['query']['search']);$i++){
		$link =("https://en.wikipedia.org/wiki/" . preg_replace("/[\s_]/", "_", $result['query']['search'][$i]['title'])); 
		echo "<a href='" . $link . "'>" . $result['query']['search'][$i]['title'] . "</a>" . "<br>";
	};





