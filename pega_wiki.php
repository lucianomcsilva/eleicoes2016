<?php
function cURLcheckBasicFunctions()
{
  if( !function_exists("curl_init") &&
      !function_exists("curl_setopt") &&
      !function_exists("curl_exec") &&
      !function_exists("curl_close") ) return false;
  else return true;
}

//-------------------------------------------------------------------------------

//Forcar o Download
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=bairros.csv");
header("Pragma: no-cache");
header("Expires: 0");

$url = 'https://pt.wikipedia.org/wiki/Lista_dos_distritos_de_S%C3%A3o_Paulo_por_popula%C3%A7%C3%A3o';
$html=file_get_contents($url);

$doc   = new DOMDocument();

@$doc->loadHTMLFile($url);
$tables = $doc->getElementsByTagName('table');
//echo $tables->item(0)->nodeValue;
$rows =  $tables->item(0)->getElementsByTagName('tr');
foreach ($rows as $row) 
{
    $cols = $row->getElementsByTagName('td');
    if($cols->length == 0) continue;
    foreach ($cols as $col) 
    {     
      
//      echo $col->nodeValue;
      echo str_replace(".", "", $col->nodeValue);
      echo ",";
    }
    $bairro = $cols->item(1)->nodeValue;
    
    
    $url_api = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode("Bairro ".$bairro." São Paulo, SP");
    $ch = curl_init();

    // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url_api);
    // Execute
    $result=curl_exec($ch);
    // Closing
    curl_close($ch);

    


if (cURLcheckBasicFunctions() == false) echo "deu merda";

// Will dump a beauty json :3
//echo  $url_api;
//echo  $result;
$var = json_decode($result, true);

//var_dump($var);
echo $var["results"][0]["geometry"]["location"]["lat"].",".$var["results"][0]["geometry"]["location"]["lng"];
            

//var_dump($result);
//var_dump($result);

   
    echo "\n";
set_time_limit(30) ;   
   //cho $table->nodeValue;
}     


?>