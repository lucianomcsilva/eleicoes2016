<?php
   list($usec, $sec) = explode(' ', microtime());
   $script_start = (float) $sec + (float) $usec;
   include_once 'conexao.php';
   $dbConn = new mysqli($host, $user, $pass, $db);
                                
   $sql = "SELECT cd_path, b.cd_bairro, nm_bairro, vl_lat, vl_lng FROM `bairros` b INNER JOIN bairros_graficos bg ON b.cd_bairro = bg.CD_BAIRRO";
   if(!$rs = $dbConn->query($sql)) die('There was an error running the query ('.$sql.') [' . $dbConn->error . ']');
      
   for($i = 0; $i < $rs->num_rows; $i++)
   {
      //$row = mysql_fetch_array($rs);
      $row = $rs->fetch_array();
      //$content[$i] = Array($row['cd_bairro'], $row['vl_pop_2010']);
      $cd_path = $row['cd_path'];
      $content[$cd_path]  = array( "codigo" => $row['cd_bairro'], 
                                   "nome" => utf8_encode($row['nm_bairro']),
                                   "lat" => $row['vl_lat'],
                                   "lng" => $row['vl_lng']);
   };
   
   list($usec, $sec) = explode(' ', microtime());
   $script_end = (float) $sec + (float) $usec;  
   $elapsed_time = round($script_end - $script_start, 3)*1000;
   $formated_start = date(DATE_W3C, $script_start);
   $vl_status = 200;
   $dc_status = "OK";      
   $result = array(
                     "description" => $content,
                     "status" => "{$vl_status}",
                     "detail" => "{$dc_status}",
                     "resquest_uri" => "http://{$_SERVER['SERVER_NAME']}{$_SERVER['REQUEST_URI']}",
                     "created_at" => "{$formated_start}",
                     "elapsed_time" => "{$elapsed_time}"                        
                     );
   $result = (json_encode(array("results" => $result)));                     
   header("Content-type: text/javascript");                           
   echo $result;  
?>