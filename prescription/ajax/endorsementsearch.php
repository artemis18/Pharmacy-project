<?php
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);

$drug_name = $_GET['q'];

/**
 * Load a specific endorsement. This is called when a drug is 
 * selected in the select box on the select endorsement div
 */
if(!isset($_GET['s']) && $_GET['s'] != "loaddetails"){
    $query = "SELECT   drugs.Name,drugs.DrugID, endorsements.DrugID, endorsements.Quantity,
                       endorsements.Dosage,endorsements.EndorsementID
              FROM     drugs,endorsements
              WHERE
                       drugs.Name LIKE '{$drug_name}%' AND
                       endorsements.DrugID=drugs.DrugID
              ORDER BY drugs.Name ASC
              LIMIT    0, 100
             ";

    $result = mysql_query($query)or die(mysql_error());
    if(mysql_num_rows($result) > 0){

        while($row = mysql_fetch_assoc($result)){
            echo "<option value=\"{$row['EndorsementID']}\">{$row['Name']} - {$row['Quantity']} - {$row['Dosage']}</option>";
        }
    } else {
        echo "<option>No Results</option>";
    }    
}
else
    { //Live search for endorsements
    $query = "SELECT drugs.Name,drugs.DrugID,endorsements.DrugID,endorsements.Quantity,
                     endorsements.Dosage
              FROM   drugs,endorsements
              WHERE  endorsements.EndorsementID='{$drug_name}' AND
                     endorsements.DrugID=drugs.DrugID
    ";
    
    $result = mysql_query($query)or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    
    echo "{$row['Name']};{$row['Quantity']};{$row['Dosage']}";
}

?>