<?php

#Global variables for the different functions:
/** Tokens from the Twitter app for verification **/
$settings = array(
    'oauth_access_token' => "1223942603042885643-Pig1Q1zY6XILhMBic7ZWClQcO8cvYF",
    'oauth_access_token_secret' => "HcXwn6O2EXhKc7bsWbbo9j430h3l6MhAVEjVT1Bc41YOj",
    'consumer_key' => "53A869T3xK58tossGG07SA8xr",
    'consumer_secret' => "T2EOFr3woryLDauJNEjCpxSnC1eyi1clxzMRl3KX41XwSDiW1j",
    'tweet_mode' => "extended"
);

/** URL for the type of request in the API. WE SPECIFY TO DO A SEARCH **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
/** Specifying the request method **/
$requestMethod = 'GET';

require_once('TwitterAPIExchange.php');



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

foreach($string as $items)
    {
      #construct entry dict
      $entry = array(
        'date' => $items['created_at'],
        'text' => $items['full_text'],
        'author' => $items['user']['name'],
        'followers' => $items['user']['followers_count'],
        'friends' => $items['user']['friends_count'],
        'verified' => $items['user']['verified'],
        'retweets' => $items['retweet_count']
      );
      #append to entries dict
      # $twitter_entries["$entry_count"] = $entry;

      return $string;  # (inactivate when trying to retrieve)
      #  echo "Time and Date of Tweet: ".$items['created_at']."<br />";
      #  echo "Tweet text: ". $items['full_text']."<br />";
      #  echo "Tweeted by: ". $items['user']['name']."<br />";
      #  echo "Followers: ". $items['user']['followers_count']."<br />";
      #  echo "Friends: ". $items['user']['friends_count']."<br />";
      #  echo "Verified: " .$items['user']['verified']."<br /><hr />";
      #  echo "Retweets: " .$items['retweet_count']."<br /><hr />";

    }
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


?>
