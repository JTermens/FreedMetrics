<?php

#Global variables for the different functions:
include_once("../../freedmetrics_connect/twitter_connect.php");

/** URL for the type of request in the API. WE SPECIFY TO DO A SEARCH **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
/** Specifying the request method **/
$requestMethod = 'GET';

require_once("$metrics_incDir/TwitterAPIExchange.metrics.php");



function getArrayTweets($search){

global $settings, $url, $requestMethod;

#Specify search:
$getfield = '?q='.$search.' AND -filter:retweets AND -filter:replies&result_type=mixed&count=100&tweet_mode=extended';

#Connection to the API
$twitter = new TwitterAPIExchange($settings);
#Converting the JSON string into an associate array
$string = json_decode($twitter->setGetfield($getfield)
                              ->buildOauth($url, $requestMethod)
                              ->performRequest(),$assoc = TRUE);
$string = $string['statuses'];
$entry_count = count($string);

$twitter_entries = array();

foreach($string as $items){
      #construct entry dict
      $entry = array(
        'tweet_id' => $items['id'],
      );
      #append to entries dict
      $twitter_entries["$entry_count"] = $entry;
    }

    return $twitter_entries;
}


function total_tweets($search){

global $settings, $url, $requestMethod;

#Specify search:
$getfield = '?q='.$search.'&result_type=mixed&count=100&tweet_mode=extended';

#Connection to the API
$twitter = new TwitterAPIExchange($settings);
#Converting the JSON string into an associate array
$string = json_decode($twitter->setGetfield($getfield)
                              ->buildOauth($url, $requestMethod)
                              ->performRequest(),$assoc = TRUE);
$string = $string['statuses'];
$num_items = count($string);
return $num_items;

}

function original_tweets($search){

global $settings, $url, $requestMethod;

#Specify search:
$getfield = '?q='.$search.' AND -filter:retweets AND -filter:replies&result_type=mixed&count=100&tweet_mode=extended';

#Connection to the API
$twitter = new TwitterAPIExchange($settings);
#Converting the JSON string into an associate array
$string = json_decode($twitter->setGetfield($getfield)
                              ->buildOauth($url, $requestMethod)
                              ->performRequest(),$assoc = TRUE);
$string = $string['statuses'];
$num_items = count($string);
return $num_items;

}

#$yes = "happy hour";
#getArrayTweets("hi");
#$tweet_array=getArrayTweets("\"$yes\"");

#$a=total_tweets("cancer");
#echo $a;
#$b=number_original_tweets("cancer");

#foreach ($tweet_array as $items) {
#  echo $items;
