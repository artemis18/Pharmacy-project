<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<script src="/prescription/js/form_creation.js"></script>
<script src="/prescription/js/browse.js"></script>
<script type="text/javascript" language="Javascript">browse_endorsements();</script>
<h1>Endorsements</h1>

<div id="endorsement_display">
</div>
<!-- Div element for background blackening -->
<div id="bg" style="visibility:hidden; 
                    background: #fff; 
                    position: absolute; 
                    width: 0px; 
                    height:0px; 
                    z-index: 2; 
                    opacity: 0; 
                    margin: auto; 
                    top: 0px; 
                    left: 0px;"></div>
                    
<div id="deleteconfirm" class="submit_box rnd_corner" style="visibility: hidden; padding: 20px;">
    Are you sure you want to delete this record?<br/><br/><br/>
    <button type="button" onclick="deleteEndorsement();">Yes</button>&nbsp;
    <button type="button" onclick="hideElementCenter('deleteconfirm');">No</button>
</div>