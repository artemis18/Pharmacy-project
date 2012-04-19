<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<h1>Prescribers</h1>

<table>
    <tr>
        <th class="center" style="padding: 0px 10px 5px 0px;">Patient ID</th> 
        <th class="center" style="padding: 0px 10px 5px 0px;">Title</th>
        <th class="center" style="padding: 0px 10px 5px 0px;">Forename</th>
        <th class="center" style="padding: 0px 10px 5px 0px;">Surname</th>
        <th class="center" style="padding: 0px 10px 5px 0px;">Road</th>
        <th class="center" style="padding: 0px 10px 5px 0px;">City</th>
        <th class="center" style="padding: 0px 10px 5px 0px;">Postcode</th>
        <th class="center" style="padding: 0px 10px 5px 0px;">Telephone</th>
        <th>Remove</th>        
    </tr>
<?php
    
    $query = "SELECT *
              FROM   prescribers
             ";
    $result = mysql_query($query)or die(mysql_error());
    
    while($row = mysql_fetch_assoc($result)){
        echo "<tr onmouseover=\"this.className='over';\" onmouseout=\"this.className='out';\">";
        echo "<td>{$row['PrescriberID']}</td>";
        echo "<td>{$row['Title']}</td>";
        echo "<td>{$row['Forename']}</td>";
        echo "<td>{$row['Surname']}</td>";
        echo "<td>{$row['Road']}</td>";
        echo "<td>{$row['City']}</td>";
        echo "<td>{$row['Postcode']}</td>";
        echo "<td>{$row['Telephone']}</td>";
        echo "<td align='center'><a class='cross incorrect' href=\"#\" onclick=\"showElementCenter('test');\"><span>&#10006;</span></a></td>";        
        echo "</tr>";
    }
?>
</table>