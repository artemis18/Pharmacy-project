<?php
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);

if(isset($_GET['id']) && !isset($_GET['del'])){
    
    $endorsement_id = mysql_real_escape_string($_GET['id']);
    
    $selected = explode(",", $endorsement_id);
    $output = "";
    
    for($i=1;$i<6;$i++){
        if(!empty($selected[$i])){
            $query = "SELECT drugs.Name, drugs.DrugID, endorsements.DrugID,
                             endorsements.Quantity, endorsements.EndorsementID,
                             endorsements.Dosage
                      FROM   drugs, endorsements
                      WHERE  endorsements.EndorsementID='{$selected[$i]}' AND
                             endorsements.DrugID=drugs.DrugID
                     ";
            $result = mysql_query($query)or die(mysql_error());
            while($row = mysql_fetch_assoc($result)){
                $output = $output . "{$row['Name']};{$row['Quantity']};{$row['Dosage']};";
            }
        }
        else{
            $output = $output . ";;;";
        }
    }
    echo $output;
}
elseif(isset($_GET['del']) && isset($_GET['id'])){
    $endorsement_id = mysql_real_escape_string($_GET['id']);
    
    $query = "DELETE
              FROM    endorsements
              WHERE   EndorsementID='{$endorsement_id}' 
             ";
    mysql_query($query)or die(mysql_error());
    
    $query = "DELETE
              FROM    endorsementcollection
              WHERE   EndorsementID='{$endorsement_id}' 
             ";
    mysql_query($query)or die(mysql_error());
}
elseif(isset($_GET['browse'])){
    $output = array();
    $query = "SELECT *
              FROM   endorsements AS e, drugs AS d
              WHERE  e.DrugID=d.DrugID
             ";
    $result = mysql_query($query)or die(mysql_error());
    $num_result = mysql_num_rows($result);
    $output['num_results'] = $num_result;
    $output['results'] = array();
    
    while($row = mysql_fetch_assoc($result)){
        $end = array(
            "endorsement_id" => $row['EndorsementID'],
            "drug_id" => $row['DrugID'],
            "form" => $row['Form'],
            "name" => $row['Name'],
            "quantity" => $row['Quantity'],
            "dosage" => $row['Dosage'],
            "instruction" => $row['Instruction'],
        );
        
        $output['results'][] = $end;
    }
    
    $JSONoutput = json_encode($output);
    echo $JSONoutput;
}
?>
