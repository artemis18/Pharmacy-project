<?php  
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<div id="create_container"><div id="header"></div>    
<div id="inner_menu">
<ul>
    <li><a href="?page=admin_db&i=tables">Tables</a></li>
    <li><a href="?page=admin_db&i=create_new">Create Tables</a></li>
</ul>
</div><div style="float: left;"id="right_content"><?php
            if(isset($_GET['i'])){
                require_once("{$_GET['i']}.php");
            }?>
</div><div style="clear: both;"></div></div>

