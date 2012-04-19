<?php
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
if(isset($_GET['q'])){
    $query = mysql_real_escape_string($_GET['q']);
    
    $query = "SELECT   PatientID, Forename, Surname
              FROM     patients
              WHERE    Forename LIKE '{$query}%' OR
                       Surname LIKE '{$query}%'
              ORDER BY Surname ASC
              LIMIT    0, 100
             ";
    $result = mysql_query($query)or die(mysql_error());
    if(mysql_num_rows($result) > 0){
        while($row = mysql_fetch_assoc($result)){
            echo "<option value=\"{$row['PatientID']}\">{$row['Surname']}, {$row['Forename']}</option>";
        }
    }
    else{
        echo "<option>No Results</option>";
    }
}
elseif(isset($_GET['id'])){
    $patient_id = mysql_real_escape_string($_GET['id']);
    
    $query = "SELECT  PatientID, Forename, Surname, Title, Gender,
                      Road, City, Postcode, Telephone
              FROM    patients
              WHERE   PatientID='{$patient_id}'
             ";
    $result = mysql_query($query)or die(mysql_error());
    
    $row = mysql_fetch_assoc($result);
    
    $gender = ucfirst($row['Gender']);
    
    echo "{$row['PatientID']},{$row['Forename']},{$row['Surname']},{$row['Title']},"
         ."{$gender},{$row['Road']},{$row['City']},{$row['Postcode']},{$row['Telephone']}";
    
}
?>
