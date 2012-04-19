<?php
/**
 * @author Mohammad Abdullah
 */
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "pharmacy";

function mysql_start(){
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
}

function mysql_end(){
    mysql_close($con);
}

?>
