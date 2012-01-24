<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<script type="text/javascript" language="Javascript">
var page = "drug";
</script>
<script src="/prescription/js/form_creation.js"></script>
<h1>Drugs</h1>

<table class="data">
    <tr>
        <th>Drug ID</th> 
        <th>Name</th>
        <th>Form</th>
        <th>Remove</th>
    </tr>
<?php
    
    $query = "SELECT *
              FROM   drugs
             ";
    $result = mysql_query($query)or die(mysql_error());
    
    while($row = mysql_fetch_assoc($result)){
        echo "<tr onmouseover=\"this.className='over';\" onmouseout=\"this.className='out';\">";
        echo "<td>{$row['DrugID']}</td>";
        echo "<td>{$row['Name']}</td>";
        echo "<td>{$row['Form']}</td>";
        echo "<td align='center'><a class='cross incorrect' href=\"#\" onclick=\"showElementCenter('test');\"><span>&#10006;</span></a></td>";
        echo "</tr>";
    }
?>
</table>

<!-- Div element for background blackening -->
<div id="bg" style="visibility:hidden; 
                    background: #000; 
                    position: absolute; 
                    width: 0px; 
                    height:0px; 
                    z-index: 2; 
                    opacity: 0.4; 
                    margin: auto; 
                    top: 0px; 
                    left: 0px;"></div>
                    
<div id="deleteconfirm" class="submit_box rnd_corner" style="visibility: hidden;">
    <div id="dc_details"></div>
    <button type="button" onclick="hideElementCenter('test');">Hide</button>
</div>