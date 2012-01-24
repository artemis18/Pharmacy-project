<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<h1>Database - View Tables</h1>

<?php

    $query = "SHOW TABLES IN prescription";
    $result = mysql_query($query)or die(mysql_error());
    
    while($row = mysql_fetch_row($result)){
        $tables[] = $row[0];
    }
    
    for($i=0;$i<count($tables);$i++){
        echo "{$tables[$i]}<br/>";
    }

?>
