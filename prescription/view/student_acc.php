<?php
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<h1>My Account</h1>
<?php

$query = "SELECT *
          FROM   users
          WHERE  UserID='{$_SESSION['user_id']}'
         ";
$result = mysql_query($query)or die(mysql_error());
$row = mysql_fetch_assoc($result);

?>
<table style="margin-left: 60px;">
    <tr>
        <td class="title">User ID:</td>
        <td><?php echo $row['UserID']; ?></td>
    </tr>
    <tr>
        <td class="title">Username:</td>
        <td><?php echo $row['Username']; ?></td>
    </tr>
    <tr>
        <td class="title">Privilege:</td>
        <td><?php echo $row['Privilege']; ?></td>
    </tr>
    <tr>
        <td class="title">Forename:</td>
        <td><?php echo $row['Forename']; ?></td>
    </tr>
    <tr>
        <td class="title">Surname:</td>
        <td><?php echo $row['Surname']; ?></td>
    </tr>
</table>

