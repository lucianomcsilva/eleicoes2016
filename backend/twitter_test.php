<?php
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "3349680335-UcfaeDLd52UTmYptYG8ZtxhowxLRjCVm2Ga5T00",
'oauth_access_token_secret' => "n6lR7v9HQdKDAMQHgNHCDh724T1biYpFiHZ6IUIGbsL43",
'consumer_key' => "aCCAJ9TacljRfrvCQyTzZeADX",
'consumer_secret' => "2CNpCB5ifP4ipQPehroFIM1hOUjeTzOtHJxjXcsdgA4JZjg2ed"
);
$url = "https://api.twitter.com/1.1/search/tweets.json";
$requestMethod = "GET";
//if (isset($_GET['user'])) {$user = $_GET['user'];} else {$user = "iagdotme";}
//if (isset($_GET['count'])) {$count = $_GET['count'];} else {$count = 100;}

//$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
/*
$string = json_decode($twitter->setGetfield($getfield) 
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
*/

//Itaquera
$search = urlencode("transporte OR onibus OR multa OR buraco OR ciclovia OR ciclovia OR metro");
echo $search;
//$string = $twitter->setGetfield("?count=100&geocode=-23.7722,-46.6683,5km&lang=pt&q=".$search)
//Vila Mariana
$string = $twitter->setGetfield("?count=100&geocode=-23.5871,-46.6357,5km&lang=pt&q=".$search)
                  ->buildOauth($url, $requestMethod)
                  ->performRequest();



$string2 = json_decode ($string);


foreach($string2->statuses as $item)
{   
   echo "data: ".$item->created_at."<br />";
   echo "id: ".$item->id_str."<br />";
   echo "Tweet: ".$item->text."<br />";
   echo "Idioma: ".$item->metadata->iso_language_code."<br />";
   print_r($item->geo);
   print_r($item->coordinates);
   echo "<hr>"  ;
   
   
}
//print_r ($string2);
/*
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

foreach($string as $items)
    {
        echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo "Tweet: ". $items['text']."<br />";
        echo "Tweeted by: ". $items['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
*/    
?>