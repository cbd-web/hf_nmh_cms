<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');
$since = '';
if(isset($_GET['since_id'])){

	$since = '&since_id='.urldecode($_GET['since_id']);
}

$q = '?q=';
if(isset($_GET['q'])){

	$q = '?q='.urldecode($_GET['q']);
}

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "3096753159-7gFNOshDuooIJJho3wsdYNcqVyblUBYOnaoQ5qV",
    'oauth_access_token_secret' => "6foaiZ77nujfxFWA3DgvJZSKci00LCOFaL4JRrfOiSlDc",
    'consumer_key' => "nsFKAatV3WFnERMpi5gpLVFJI",
    'consumer_secret' => "FGnJ2ybl1fzuGYBO195okPP394UfV8hpWsSGMl2SwNGFgdTUNy"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
$url = 'https://api.twitter.com/1.1/blocks/create.json';
$requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above **/
/*$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);*/

/** Perform a POST request and echo the response **/
/*$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();*/

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = $q.'&result_type=recent&count=15'.$since;
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

//echo $getfield;