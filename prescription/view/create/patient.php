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
 * Checks if the gender is already and selects it
 */
function checkGender($gender){
    if(isset($_POST['gender'])){
        if($_POST['gender'] == $gender){
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
<h1>Patient</h1>
<form action='' method='post'>
    <fieldset>
        <legend>Create a patient</legend>
        <table>
            <tr>
                <td align='right'><label>Description:</label></td>
                <td><input type='text' name='description' value="<?php checkText("description"); ?>"/><br/></td>
            </tr>   
            <tr>
                <td align='right'><label>NHS Number:</label></td>
                <td><input type='text' name='nhsno' value="<?php checkText("nhsno"); ?>"/><br/></td>
            </tr> 
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
                <td><input type='text' name='forename' value="<?php checkText("forename"); ?>"/><br/></td>
            </tr>
            <tr>
                <td align='right'><label>Surname:</label></td>
                <td><input type='text' name='surname' value="<?php checkText("surname"); ?>"/></td>
            </tr>  
            <tr>
                <td align='right'><label>Gender:</label></td>
                <td>
                    <select name="gender">
                        <option value="male"<?php checkGender("male"); ?>>Male</option>
                        <option value="female"<?php checkGender("female"); ?>>Female</option>
                    </select>
                </td>                
            </tr>
            <tr>
                <td align='right'><label>DOB:</label></td>
                <td style="padding-left: 2px;">
                    <input maxlength="2" style="width: 25px;" type='text' name='day' value="<?php checkText("day"); ?>"/>/
                    <input maxlength="2" style="width: 25px;" type='text' name='month' value="<?php checkText("month"); ?>"/>/
                    <input maxlength="4" style="width: 40px;" type='text' name='year' value="<?php checkText("year"); ?>"/>
                </td>
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
                <td><input type="submit" value="Submit"/></td>
            </tr>            
        </table>
    </fieldset>
</form>

<?php
    if( 
        isset($_POST['description']) &&                 
        isset($_POST['title']) &&          
        isset($_POST['forename']) &&
        isset($_POST['surname']) &&
        isset($_POST['gender']) &&
        isset($_POST['day']) &&
        isset($_POST['month']) &&
        isset($_POST['year']) &&          
        isset($_POST['road']) &&           
        isset($_POST['city']) &&
        isset($_POST['postcode']) &&
        isset($_POST['telephone']) &&
        isset($_POST['nhsno'])
      ){
        //$avatar = mysql_escape_string($_POST['avatar']);
        $description = mysql_escape_string($_POST['description']);
        $title = mysql_escape_string($_POST['title']);        
        $forename = mysql_escape_string($_POST['forename']);
        $surname = mysql_escape_string($_POST['surname']);
        $gender = mysql_escape_string($_POST['gender']);
        $dob = mysql_escape_string($_POST['day'] . "/" . $_POST['month'] . "/" . $_POST['year']);
        $road = mysql_escape_string($_POST['road']);
        $city = mysql_escape_string($_POST['city']);
        $postcode = mysql_escape_string($_POST['postcode']);
        $telephone = mysql_escape_string($_POST['telephone']);
        $nhsno = mysql_real_escape_string($_POST['nhsno']);
        
        $query =   "SELECT PatientID FROM patients
                    WHERE
                        Description = '{$description}' AND
                        Title = '{$title}' AND        
                        Forename = '{$forename}' AND
                        Surname = '{$surname}' AND
                        Gender = '{$gender}' AND
                        DOB = '{$dob}' AND
                        Road = '{$road}' AND
                        City = '{$city}' AND
                        Postcode = '{$postcode}' AND
                        Telephone = '{$telephone}'";
                        
        $result = mysql_query($query) or die(mysql_error());

        //If the record already exists
        if(mysql_num_rows($result) > 0){
            echo "<span class=\"incorrect\">Warning:</span> Patient already exists";
        } else { //New record
            $query = "INSERT INTO patients
                      VALUES
                      (
                        '',
                        '{$nhsno}',
                        '',
                        '{$description}',
                        '{$title}',            
                        '{$forename}',
                        '{$surname}',
                        '{$gender}',
                        '{$dob}',
                        '{$road}',                        
                        '{$city}',
                        '{$postcode}',
                        '{$telephone}'
                      );";
            //echo $query;
            $result = mysql_query($query) or die(mysql_error());
            echo "<span class=\"correct\">Success:</span> Patient created and added to database.<br/>";
        }
    } else {
        if(isset($_POST['description'])){ //Only check if form has been submitted
            if(empty($_POST['description'])){echo "<span class=\"incorrect\">Description is missing</span><br/>";}                 
            if(empty($_POST['title'])){echo "<span class=\"incorrect\">Title is missing</span><br/>";}            
            if(empty($_POST['forename'])){echo "<span class=\"incorrect\">Forename is missing</span><br/>";} 
            if(empty($_POST['surname'])){echo "<span class=\"incorrect\">Surname is missing</span><br/>";} 
            if(empty($_POST['gender'])){echo "<span class=\"incorrect\">Gender is missing</span><br/>";} 
            if(empty($_POST['day'])){echo "<span class=\"incorrect\">Day is missing</span><br/>";} 
            if(empty($_POST['month'])){echo "<span class=\"incorrect\">Month is missing</span><br/>";} 
            if(empty($_POST['year'])){echo "<span class=\"incorrect\">Year is missing</span><br/>";} 
            if(empty($_POST['road'])){echo "<span class=\"incorrect\">Road is missing</span><br/>";} 
            if(empty($_POST['city'])){echo "<span class=\"incorrect\">City is missing</span><br/>";} 
            if(empty($_POST['postcode'])){echo "<span class=\"incorrect\">Postcode is missing</span><br/>";} 
            if(empty($_POST['telephone'])){echo "<span class=\"incorrect\">Telephone is missing</span><br/>";} 
        }
    }
?>