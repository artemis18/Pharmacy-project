<?php 
    require_once "control/validsession.php"; 
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);

/**
 * Check if the title is set and sets it selected
 */
function checkTitle($title){
    if(isset($_POST['title'])){
        if($_POST['title'] == $title){
            echo " selected ";
        }
    }    
}

/**
 * Checks if a certain field is set and then echo it
 */
function checkText($field){
    if(isset($_POST[$field])){
        echo $_POST[$field];
    }
}

?>
<h1>Prescriber</h1>
<form action='' method='post'>
    <fieldset>
        <legend>Create a prescriber</legend>
        <table>
            <tr>
                <td align='right'><label>Title:</label></td>
                <td>
                    <select name="title">
                    <option value="mr"<?php checkTitle("mr"); ?>>Mr</option>
                    <option value="mrs"<?php checkTitle("mrs"); ?>>Mrs</option>
                    <option value="miss"<?php checkTitle("miss"); ?>>Miss</option>
                    <option value="dr"<?php checkTitle("dr"); ?>>Dr</option>
                    </select>
                </td>
            </tr>                  
            <tr>
                <td align='right'><label>Forename:</label></td>
                <td><input type='text' name='forename' value="<?php echo $_SESSION['username']; ?>"/><br/></td>
            </tr>
            <tr>
                <td align='right'><label>Surname:</label></td>
                <td><input type='text' name='surname' value="<?php checkText("surname"); ?>"/></td>
            </tr>
            <tr>
                <td align='right'><label>Road:</label></td>
                <td><input type='text' name='road' value="<?php checkText("road"); ?>"/></td>
            </tr>            
            <tr>
                <td align='right'><label>City:</label></td>
                <td><input type='text' name='city' value="<?php checkText("city"); ?>"/></td>
            </tr>
            <tr>
                <td align='right'><label>Postcode:</label></td>
                <td><input type='text' name='postcode' value="<?php checkText("postcode"); ?>"/></td>
            </tr>
            <tr>
                <td align='right'><label>Phone:</label></td>
                <td><input type='text' name='telephone' value="<?php checkText("telephone"); ?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Submit" name="submit"/></td>
            </tr>            
        </table>
    </fieldset>
</form>

<?php
    if( 
        isset($_POST['title']) && !empty($_POST['title']) &&            
        isset($_POST['forename']) && !empty($_POST['forename']) &&
        isset($_POST['surname']) && !empty($_POST['surname']) &&
        isset($_POST['road']) && !empty($_POST['road']) &&            
        isset($_POST['city']) && !empty($_POST['city']) &&
        isset($_POST['postcode']) && !empty($_POST['postcode']) &&
        isset($_POST['telephone']) && !empty($_POST['telephone'])
      ){
        
        $title = mysql_escape_string($_POST['title']);        
        $forename = mysql_escape_string($_POST['forename']);
        $surname = mysql_escape_string($_POST['surname']);
        $road = mysql_escape_string($_POST['road']);
        $city = mysql_escape_string($_POST['city']);
        $postcode = mysql_escape_string($_POST['postcode']);
        $telephone = mysql_escape_string($_POST['telephone']);
        
        $query =   "SELECT PrescriberID FROM prescribers 
                    WHERE
                        Title = '{$title}' AND        
                        Forename = '{$forename}' AND
                        Surname = '{$surname}' AND
                        Road = '{$road}' AND
                        City = '{$city}' AND
                        Postcode = '{$postcode}' AND
                        Telephone = '{$telephone}'";
                        
        $result = mysql_query($query) or die(mysql_error());
                
        if(mysql_num_rows($result) > 0){
            echo "Prescriber already exists";
        } else {
            $query = "INSERT INTO prescribers
                      VALUES
                      (
                        '',
                        '{$title}',            
                        '{$forename}',
                        '{$surname}',
                        '{$road}',                        
                        '{$city}',
                        '{$postcode}',
                        '{$telephone}'
                      );";
            $result = mysql_query($query) or die(mysql_error());
            
            echo "Successfully added new Prescriber to Database.<br/>";
        }
    }
    else{
        if(isset($_POST['submit'])){
            if(empty($_POST['title'])){echo "<span style=\"color: #f00;\">Title is empty.</span><br/>";}
            if(empty($_POST['forename'])){echo "<span style=\"color: #f00;\">Forename is empty.</span><br/>";}
            if(empty($_POST['surname'])){echo "<span style=\"color: #f00;\">Surname field is empty.</span><br/>";}
            if(empty($_POST['road'])){echo "<span style=\"color: #f00;\">Road field is empty.</span><br/>";}
            if(empty($_POST['city'])){echo "<span style=\"color: #f00;\">City field is empty.</span><br/>";}
            if(empty($_POST['postcode'])){echo "<span style=\"color: #f00;\">Postcode field is empty.</span><br/>";}
            if(empty($_POST['telephone'])){echo "<span style=\"color: #f00;\">Telephone field is empty.</span><br/>";}
        }
    }
?>