<?php
    //require_once "{$_SERVER['DOCUMENT_ROOT']}/prescriptiontester/includes/config.php";
    require_once "control/validsession.php";
?>
<!DOCTYPE "html"><html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="css/style.css" media="all" type="text/css" rel="stylesheet" />
        <script src="js/jquery.js" type="text/javascript"></script>
        <title>Prescription Tester</title>
    </head>
    <body>
        <div id="banner"></div>
        <div id="page_content">
            <span id="navigation">
            <?php
                //User navigation based on the session priveledge
                if($_SESSION['privilege'] == 1){
                    include "navigation/student.php";
                } 
                else if ($_SESSION['privilege'] == 2){
                    include "navigation/academic.php";
                }
                else if ($_SESSION['privilege'] == 3){
                    include "navigation/admin.php";
                }
            ?>
            </span>
            &nbsp;
            <?php
                if(isset($_SESSION['username'])){
                    echo "Logged in as ".ucfirst($_SESSION['username']);
                }
            ?>
            <noscript style="font-size: 20px; padding: 10px;"><br/><br/><span style="color: #f00;">Javascript Disabled:</span><p>This site uses Javascript to function correctly. Please enable Javascript<br/>or use another browser, like <a href="http://www.mozilla.com">Firefox</a> or <a href="http://www.google.com/chrome">Chrome</a>.</p><br/><br/></noscript>
            <div id="content"><?php include "control/page_control.php";?></div>
        </div>
        <div id="footer"></div>
    </body>
</html>