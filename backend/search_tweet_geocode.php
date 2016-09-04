<?php
   list($usec, $sec) = explode(' ', microtime());
   $script_start = (float) $sec + (float) $usec;
   include_once 'conexao.php';
   ini_set("allow_url_fopen", "On");
   $dbConn = new mysqli($host, $user, $pass, $db);
     
   $sql = "SELECT `cd_bairro`, `vl_pop_2010` FROM `bairros`";
   $sql = "SELECT cd_path, vl_lat, vl_lng FROM `bairros` b INNER JOIN bairros_graficos bg ON b.cd_bairro = bg.CD_BAIRRO";
   if(!$rs = $dbConn->query($sql)) die('There was an error running the query ('.$sql.') [' . $dbConn->error . ']');
   $tweets = Array();   
   for($i = 0; $i < $rs->num_rows; $i++)   
   {
      //$row = mysql_fetch_array($rs);
      $row = $rs->fetch_array();
      
      //$q = urlencode("transporte OR onibus OR multa OR buraco OR ciclovia OR ciclovia OR metro OR CET");
      //$q = urlencode("russomano");
      //$q   = urlencode("creche OR emei OR 'ensino fundamental'");
      //$q     = urlencode("hospital OR sus OR doente");
      //$q     = urlencode("'altas horas' OR altashoras");      
      //$q = "acelerasp";      
      if (isset($_GET['q']))    {$q    = $_GET['q'];}     else {$q    = "";}
      
      $rnd   = rand(0, 999);
      set_time_limit(120);
      $dist = 2;
      
      
      
      $json = json_decode(file_get_contents("http://192.168.1.119/labs/eleicoes2016/backend/twitter_search.php?lat=".$row['vl_lat']."&lgn=".$row['vl_lng']."&dist=$dist&q=".$q));
      set_time_limit(120);      
      $count = @sizeof($json->results);
      $min_id = 9999999999999999999999;
      $cd_path = $row['cd_path'];
      if($count > 0)   
      {
         foreach($json->results as $tweet) if($min_id > intval($tweet->id)) $min_id = intval($tweet->id);
         $tweets[$cd_path][] = $json->results;
      }         
      if($count == 100)
      {
         $json = json_decode(file_get_contents("http://192.168.1.119/labs/eleicoes2016/backend/twitter_search.php?lat=".$row['vl_lat']."&lgn=".$row['vl_lng']."&max_id=".$min_id."dist=1&q=".$q));
         if($count > 0)   
         {
            foreach($json->results as $tweet) if($min_id > intval($tweet->id)) $min_id = intval($tweet->id);
            $tweets[$cd_path][] = $json->results;
         }         
      }
      $count += @sizeof($json->results); 
      
      $content[$i] = Array($row['cd_path'], $count);
   };
   
   list($usec, $sec) = explode(' ', microtime());
   $script_end = (float) $sec + (float) $usec;  
   $elapsed_time = round($script_end - $script_start, 3)*1000;
   $formated_start = date(DATE_W3C, $script_start);
   $vl_status = 200;
   $dc_status = "OK";      
   $result = array(
                     "plots" => $content,
                     "tweets"  => $tweets,
                     "status" => "{$vl_status}",
                     "detail" => "{$dc_status}",
                     "resquest_uri" => "http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}",
                     "created_at" => "{$formated_start}",
                     "elapsed_time" => "{$elapsed_time}"                        
                     );
   $result = (json_encode(array("results" => $result)));
   header("Pragma: no-cache");
   header("Cache-Control: must-revalidate");
   header("Cache-Control: no-cache");
   header("Cache-Control: no-store");
   header("Expires: 0");                        
   header("Content-type: text/javascript");                           
   echo $result;  
?>