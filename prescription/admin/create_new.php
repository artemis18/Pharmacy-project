<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
    
    if(isset($_GET['create'])){
        
    }
    else{
?>
<h1>Database - Create Table Structure</h1>
<p>Creating the table structure from scratch will delete all previous data and replace it with empty tables.</p>
<p>This is recommended to be done when first installing this system on a new machine.</p>
<p><a href="?page=admin_db&i=create_new&create=yes">Create Tables</a></p>

<?php
    }
?>