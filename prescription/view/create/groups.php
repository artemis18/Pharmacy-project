<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<script language="Javascript" src="/prescription/js/livesearch.js"></script>
<h1>Groups</h1>

<form action="" method="post">
    <fieldset>
        <legend>Create a Group</legend>
        <table>
            <tr>
                <td>Name of Group</td>
                <td><input type="text" name="name" id="name" value=""/></td>
            </tr>
            <tr>
                <td>Select Users</td>
                <td>
                    <table>
                        <tr>
                            <td><input type="text" 
                                       id="user_search"
                                       onKeyUp="userSearch(this.value);"/></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td>
                                <select size="10"
                                        style="width: 200px;"
                                        id="users"
                                        >
                                    
                                </select>
                            </td>
                            <td style="vertical-align: middle;">
                                <button onClick="alert();">>></button>
                            </td>
                            <td>
                                <select size="10"
                                        style="width: 200px;">
                                    
                                </select>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Submit"/></td>
            </tr>
        </table>
    </fieldset>
</form>
