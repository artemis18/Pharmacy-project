<?php require_once "control/validsession.php"; ?>
<script type="text/javascript"></script><div id="create_container"><div id="header"></div>    
<div id="inner_menu">
<ul>
    <li><a href="?page=browse&i=prescription">Prescription</a></li>
    <li><a href="?page=browse&i=patient">Patient</a></li>
    <li><a href="?page=browse&i=endorsement">Endorsement</a></li>
    <li><a href="?page=browse&i=drug">Drug</a></li>
    <li><a href="?page=browse&i=prescriber">Prescriber</a></li>
    <li><a href="?page=browse&i=test">Test</a></li>
</ul>
</div><div style="float: left;"id="right_content"><?php
            if(isset($_GET['i'])){
                require_once("browse/{$_GET['i']}.php");
            }?>
</div><div style="clear: both;"></div></div>