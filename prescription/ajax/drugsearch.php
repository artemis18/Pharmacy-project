<?php 
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
    
if(
   isset($_GET['q']) &&
   isset($_GET['f'])
   ){ 
    $output = array();
    
    $id = mysql_real_escape_string($_GET['q']);
    $f = mysql_real_escape_string($_GET['f']);
    
        if(strtolower($f) == "all"){
            $query = "SELECT   DrugID, Name, Form
                      FROM     drugs
                      WHERE    Name LIKE '{$id}%'
                      ORDER BY Name
                      LIMIT    0, 100
                     ";
            $result = mysql_query($query)or die(mysql_error());
            $query = "SELECT   DrugID, Name, Form
                      FROM     drugs
                      WHERE    Name LIKE '{$id}%'
                      ORDER BY Name";
            $total = mysql_num_rows(mysql_query($query));
        }else{
            $query = "SELECT   DrugID, Name, Form
                      FROM     drugs
                      WHERE    Name LIKE '{$id}%' AND
                               Form='{$f}'
                      ORDER BY Name
                      LIMIT    0, 100
                     ";
            $result = mysql_query($query)or die(mysql_error());
            $query = "SELECT   DrugID, Name, Form
                      FROM     drugs
                      WHERE    Name LIKE '{$id}%' AND
                               Form='{$f}'
                      ORDER BY Name";
            $total = mysql_num_rows(mysql_query($query));
        }
        $output['num_results'] = $total;
        $output['results'] = array();
        
        while($row = mysql_fetch_assoc($result)){
            $drug_id = $row['DrugID'];
            $name = $row['Name'];
            $form = $row['Form'];
            if(isset($drug)){unset($drug);}
            $drug = array(
                "id" => $drug_id,
                "name" => $name,
                "form" => $form
            );
            
            $output['results'][] = $drug;
        } 
    
        $query = "SELECT   DISTINCT Form
                  FROM     drugs
                  WHERE    Name LIKE '{$id}%'
                  ORDER BY Form
                 ";
        $result = mysql_query($query)or die(mysql_error());
        
        $output['forms'] = array();
        
        while($row = mysql_fetch_assoc($result)){
            $selected = "false";
            if($row['Form'] == $f){
                $selected = "true";
            }
            $output['forms'][] = array(
                "name" => $row['Form'],
                "selected" => $selected
            );
        }
   }
   elseif(isset($_GET['id'])){
       $output = array();
       $id = mysql_real_escape_string($_GET['id']);
       
       $query = "SELECT DrugID, Name, Form
                 FROM   drugs
                 WHERE  DrugID='{$id}'
                ";
       $result = mysql_query($query)or die(mysql_error());
       $row = mysql_fetch_assoc($result);
       
       $output['drug'] = array(
           "id" => $row['DrugID'],
           "name" => $row['Name'],
           "form" => $row['Form']
       );
   }
   
   $JSONoutput = json_encode($output);
   echo $JSONoutput;
?>
