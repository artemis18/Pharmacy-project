<?php
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
        
        if(isset($_GET['q'])){
            $q = mysql_real_escape_string($_GET['q']);
            
            $query = "SELECT    *
                      FROM      users
                      WHERE     Username LIKE '{$q}%' OR
                                Name LIKE '{$q}%' OR
                                Forename LIKE '{$q}%' OR
                                Surname LIKE '{$q}%' 
                      ORDER BY  Username
                      LIMIT     0, 100
                     ";
            $result = mysql_query($query)or die(mysql_error());
            while($row = mysql_fetch_assoc($result)){
                echo "<option value=\"{$row['UserID']}\">{$row['Username']}</option>";
            }
        }
?>
