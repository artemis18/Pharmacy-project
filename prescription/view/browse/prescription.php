<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<script src="/prescription/js/form_creation.js"></script>
<script src="/prescription/js/browse.js"></script>
<script src="/prescription/js/liveview.js"></script>
<script type="text/javascript" language="Javascript">browse_prescriptions();</script>
<h1>Prescription Forms</h1><table class="data"><div id="browse_prescription_container"></div></table>
<div id="bg" style="visibility:hidden; background: #000; position: absolute; width: 0px; height:0px; z-index: 2; opacity: 0.4; margin: auto; top: 0px; left: 0px;"></div> 
<div id="deleteconfirm" class="submit_box rnd_corner" style="visibility: hidden;">
<div id="dc_details"></div><button type="button" onclick="hideElementCenter('test');">Hide</button></div>
<div id="display_div" style="visibility: hidden; position: absolute; z-index: 5;">
<div><a class="hide incorrect" href="#" onclick="hide_prescription();">Hide</a>&nbsp;&nbsp;<span style="color: #fff; font-weight: bold;">Created: <label id="p_timestamp"></label></span></div>
<canvas id="display_canvas" class="browse_canvas" width="225px" height="300px"></canvas></div>