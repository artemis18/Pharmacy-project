<?php
    if(isset($_GET['page'])){
        switch($_SESSION['privilege']){
            case 1:
                include_once "view/{$_GET['page']}.php";
                break;
            case 2:
                include_once "view/{$_GET['page']}.php";
                break;
            case 3:
                include_once "admin/{$_GET['page']}.php";
                break;
        }
    } else {
        include_once "view/home.php";
    }
?>
