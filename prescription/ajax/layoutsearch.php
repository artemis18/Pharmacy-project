<?php
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);

if(isset($_GET['q'])){
    $query = mysql_real_escape_string($_GET['q']);
    
    $query = "SELECT   PrescriptionLayoutID, Name
              FROM     prescriptionlayouts
              WHERE    Name LIKE '{$query}%' 
              ORDER BY Name ASC
              LIMIT    0, 100
             ";
    $result = mysql_query($query)or die(mysql_error());
    if(mysql_num_rows($result) > 0){
        while($row = mysql_fetch_assoc($result)){
            echo "<option value=\"{$row['PrescriptionLayoutID']}\">{$row['Name']}</option>";
        }
    }
    else{
        echo "<option>No Results</option>";
    }
}
elseif(isset($_GET['id'])){
    
    $prescription_layout_id = mysql_real_escape_string($_GET['id']);
    
    $query = "SELECT  PrescriptionLayoutID, Name
              FROM    prescriptionlayouts
              WHERE   PrescriptionLayoutID='{$prescription_layout_id}'
             ";
    $result = mysql_query($query)or die(mysql_error());
    
    $row = mysql_fetch_assoc($result);
    
    echo "{$row['PrescriptionLayoutID']},{$row['Name']}";
    
}
?>
