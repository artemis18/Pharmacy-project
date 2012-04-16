<?php
    if(!isset($_SESSION)){
        session_start();
    }
    
    if (!isset($_SESSION['username'])){
        session_destroy();
        header('Location: /prescription/view/login.php');
        exit();
    }
?>