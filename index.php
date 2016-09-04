<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="generator" content="PSPad editor, www.pspad.com">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
    <title>Eleições 2016</title>
  </head>
 <body>
   <h1>Titulo</h1>
   <p> Um teste de paragrafo com uma frase um pouco maior </p>
   <div id="div_loading" style="display:none; position:absolute;width:100%;height: 100%;top: 0;left: 0;opacity: 0.5; background: url(2.gif) no-repeat center center; background-color: #000000;"></div>
   <div>
   Busca: <input type="text" id='iq' value="">
   Região:   
   <select id="select_bairro">
   <?php
   include_once '/backend/conexao.php';
   ini_set("allow_url_fopen", "On");
   $dbConn = new mysqli($host, $user, $pass, $db);
     
   $sql = "SELECT `cd_bairro`, `vl_pop_2010` FROM `bairros`";
   $sql = "SELECT nm_bairro, vl_lat, vl_lng FROM `bairros` b INNER JOIN bairros_graficos bg ON b.cd_bairro = bg.CD_BAIRRO";
   if(!$rs = $dbConn->query($sql)) die('There was an error running the query ('.$sql.') [' . $dbConn->error . ']');
      
   for($i = 0; $i < $rs->num_rows; $i++)   
   {
      //$row = mysql_fetch_array($rs);
      $row = $rs->fetch_array();
      $option = "lat=".$row['vl_lat']."&lng=".$row['vl_lng'];
     ?>
         <option value="<?=$option?>"><?=utf8_encode($row['nm_bairro'])?></option>     
     <?php      
   };
   ?>  
   </select>                                                           
   <button id="button_search">Buscar</button>  
   <div id="result2">
     
   
   </div>
   <pre id='result' style="width:100%; border:1px solid red;">
   </pre>
   </div>
   <script>
         $('#button_search').on('click', function() 
         {            
            
            $("#div_loading").show();
            $.get("http://192.168.1.119/labs/eleicoes2016/backend/twitter_search.php", { q: $("#iq").val(), lat: $("#select_bairro").val().split('&')[0].split("=")[1], lng: $("#select_bairro").val().split('&')[1].split("=")[1] }).done(function(Data)
            {                        
               console.log(Data);
               $("#result").html(Data);
               //json = jQuery.parseJSON(Data);
               //console.log(json);
               //console.log(json.results[i]);
               //$("#result2").append("<h1>"+json.results.length+" tweets"</h1>");
                      
               for(i = 0; i < json.results.length; i++)
               {
                  $("#result2").append('<br>Data:'+json.results[i].data + '\
                                        <br>Idioma:'+json.results[i].Idioma + '\
                                        <br>Tweet:'+json.results[i].Tweet + '\
                                        <br>geo:'+json.results[i].geo + '\
                                        <br>coord:'+json.results[i].coord + '\
                                        <hr>');   
               }
               $("#div_loading").hide();
            }, "json");
         });        
   </script>
 </body>
</html>