<?php
    //Store super global variables
    $_ENV['project_name'] = "prescription";
    //Increase the project portability by keeping track of the server root + project name
    $_ENV['root'] = $_SERVER['DOCUMENT_ROOT'] . $_ENV['project_name'] . "/";
?>
