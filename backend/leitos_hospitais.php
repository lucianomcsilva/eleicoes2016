<?php
   list($usec, $sec) = explode(' ', microtime());
   $script_start = (float) $sec + (float) $usec;
   include_once 'conexao.php';
   $dbConn = new mysqli($host, $user, $pass, $db);
  
   
   $sql = "select  cd_path, vl_leitos from leitos_hospitais dg inner join bairros_graficos bg on bg.CD_BAIRRO = dg.cd_bairro;";
   if(!$rs = $dbConn->query($sql)) die('There was an error running the query ('.$sql.') [' . $dbConn->error . ']');
      
   for($i = 0; $i < $rs->num_rows; $i++)
   {
      //$row = mysql_fetch_array($rs);
      $row = $rs->fetch_array();
      $content[$i] = Array($row['cd_path'], $row['vl_leitos']);
   };
   
   list($usec, $sec) = explode(' ', microtime());
   $script_end = (float) $sec + (float) $usec;  
   $elapsed_time = round($script_end - $script_start, 3)*1000;
   $formated_start = date(DATE_W3C, $script_start);
   $vl_status = 200;
   $dc_status = "OK";      
   $result = array(
                     "plots" => $content,
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