<?php
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/

$settings = array(
'oauth_access_token' => "3349680335-UcfaeDLd52UTmYptYG8ZtxhowxLRjCVm2Ga5T00",
'oauth_access_token_secret' => "n6lR7v9HQdKDAMQHgNHCDh724T1biYpFiHZ6IUIGbsL43",
'consumer_key' => "aCCAJ9TacljRfrvCQyTzZeADX",
'consumer_secret' => "2CNpCB5ifP4ipQPehroFIM1hOUjeTzOtHJxjXcsdgA4JZjg2ed"
);



/*
$settings = array(
'oauth_access_token' => "3349680335-LoGBzUJGEBAbCsz8oerkCslqH0l2uFWYDZmIqLn",
'oauth_access_token_secret' => "rIXb1b81BCLWuOXV3k66Kmg0UJ06zKSUhXZeOKsc5MXlp",
'consumer_key' => "2bp9wR4TULIySIAgFWA8MHAuw",
'consumer_secret' => "6sVfV0fZmZW7EFVlsxwoTg4YftPrcEOHlJFn1ZMLth1kVrcLHG"
);
*/




$url = "https://api.twitter.com/1.1/search/tweets.json";
$requestMethod = "GET";
if (isset($_GET['lat']))  {$lat  = $_GET['lat'];}   else {$lat  = -23.5871;}
if (isset($_GET['lng']))  {$lng  = $_GET['lng'];}   else {$lng  = -46.6357;}
if (isset($_GET['dist'])) {$dist = $_GET['dist'];}  else {$dist = 30;}
if (isset($_GET['q']))    {$q    = $_GET['q'];}     else {$q    = "";}
if (isset($_GET['max_id']))    {$max_id    = $_GET['max_id'];}     else {$max_id    = "";}
 

$twitter = new TwitterAPIExchange($settings);

//Itaquera
if($q != "")
   $search = "&q=".urlencode($q);
else $search = "";


if($max_id != "")
   $search_max = "&max_id=".$max_id;
else $search_max = "";


$string = $twitter->setGetfield("?count=100&geocode=".$lat.",".$lng.",".$dist."km&lang=pt".$search."&result_type=recent")
                  ->buildOauth($url, $requestMethod)
                  ->performRequest();


//echo $string;

$string2 = json_decode ($string);
$content = Array();
foreach($string2->statuses as $item)
{   
   $content[] = Array(
                        "data"    => $item->created_at,
                        "id"      => $item->id_str,
                        "Tweet"   => $item->text,
                        "Idioma"  => $item->metadata->iso_language_code,
                        "geo"     => $item->geo,
                        "user"    => $item->user,
                        "coord"   => $item->coordinates
                     );
}
   
   $result = (json_encode(Array("results" => $content)));                     
   header("Content-type: text/javascript");
   header("Pragma: no-cache");
   header("Cache-Control: must-revalidate");
   header("Cache-Control: no-cache");
   header("Cache-Control: no-store");
   header("Expires: 0");                              
   echo $result;     
?>