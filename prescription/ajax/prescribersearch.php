<?php 
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
      
if(isset($_GET['q'])){
    
    $query = mysql_real_escape_string($_GET['q']);
    
    $query = "SELECT   PrescriberID, Forename, Surname
              FROM     prescribers
              WHERE    Forename LIKE '{$query}%' OR
                       Surname LIKE '{$query}%'
              ORDER BY Surname ASC
              LIMIT    0, 100
             ";
                       
    $result = mysql_query($query)or die(mysql_error());
    
    if(mysql_num_rows($result) > 0){
        while($row = mysql_fetch_assoc($result)){
            echo "<option value=\"{$row['PrescriberID']}\">{$row['Title']} {$row['Surname']}, {$row['Forename']}</option>";
        }
    }
    else{
        echo "No Results";
    }
}
elseif(isset($_GET['id'])){
    $prescriber_id = mysql_real_escape_string($_GET['id']);
    
    $query = "SELECT  PrescriberID, Forename, Surname, Title,
                      Road, City, Postcode
              FROM    prescribers
              WHERE   PrescriberID='{$prescriber_id}'
             ";
    $result = mysql_query($query)or die(mysql_error());
    
    $row = mysql_fetch_assoc($result);
    
    echo "{$row['PrescriberID']},{$row['Forename']},{$row['Surname']},{$row['Title']},"
         ."{$row['Road']},{$row['City']},{$row['Postcode']}";
}

?>