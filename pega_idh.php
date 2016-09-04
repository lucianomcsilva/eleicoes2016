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
header("Content-Disposition: attachment; filename=dados_idh.csv");
header("Pragma: no-cache");
header("Expires: 0");

$url = 'https://pt.wikipedia.org/wiki/Lista_dos_distritos_de_S%C3%A3o_Paulo_por_popula%C3%A7%C3%A3o';
$html=file_get_contents($url);

$doc   = new DOMDocument();
$doc2  = new DOMDocument();
$i = 1;
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


    $url_links  = $cols->item(1)->getElementsByTagName('a');;
    
    $url_detalhes  = "https://pt.wikipedia.org".$url_links->item(0)->getAttribute('href');


    @$doc2->loadHTMLFile($url_detalhes);
    
    
    
    $tables2 = $doc2->getElementsByTagName('table');
  // echo @$tables2->item(0)->getElementsByTagName('tr')->length;
    
    if( @$tables2->item(0)->getElementsByTagName('tr')->length == 10)    
    {

    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(3)->nodeValue))).",";    
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(4)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(5)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(6)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(7)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(8)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(9)->nodeValue))).",";
    echo @$tables2->item(0)->getElementsByTagName('tr')->length;
    
    
 
     }
    else if( @$tables2->item(0)->getElementsByTagName('tr')->length == 11)   
    {
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(3)->nodeValue))).",";    
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(4)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(5)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(6)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(7)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(8)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(9)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(0)->getElementsByTagName('tr')->item(10)->nodeValue))).",";
    echo @$tables2->item(0)->getElementsByTagName('tr')->length;
    }
    else if( @$tables2->item(1)->getElementsByTagName('tr')->length == 10)    
    {
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(3)->nodeValue))).",";    
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(4)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(5)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(6)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(7)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(8)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(9)->nodeValue))).",";
    echo @$tables2->item(1)->getElementsByTagName('tr')->length;
    }
    else if( @$tables2->item(1)->getElementsByTagName('tr')->length == 11)   
    {
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(3)->nodeValue))).",";    
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(4)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(5)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(6)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(7)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(8)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","",preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(9)->nodeValue))).",";
    echo str_replace(",",".",str_replace(".","", preg_replace("/\r|\n/"," ",$tables2->item(1)->getElementsByTagName('tr')->item(10)->nodeValue))).",";
    echo @$tables2->item(1)->getElementsByTagName('tr')->length;
    }
    else
    {
    echo 'NULL,';
    echo 'NULL,';
    echo 'NULL,';
    echo 'NULL,';
    echo 'NULL,';

    }
   // {try{echo $tables2->item(1)->getElementsByTagName('tr')->item(6)->nodeValue;}catch(Exception $e){echo 'NULL';}}
   //echo $url_detalhes;
    


if (cURLcheckBasicFunctions() == false) echo "deu merda";

// Will dump a beauty json :3
//echo  $url_api;
//echo  $result;
//$var = json_decode($result, true);

//var_dump($var);

            

//var_dump($result);
//var_dump($result);

   
    echo "\n";
set_time_limit(30) ;   
   //cho $table->nodeValue;
}     


?>