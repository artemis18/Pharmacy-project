<?php 
    require_once "control/validsession.php"; 
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<h1>Drug</h1>
<form action='' method='post'>
    <fieldset>
        <legend>Create a drug</legend>
        <table>
            <tr>
                <td align='right'><label>Name:</label></td>
                <td><input type='text' name='drug_name' value=""/><br/></td>
            </tr>
            <tr>
                <td align='right'><label>Form:</label></td>
                <td><input type='text' name='drug_form' value=""/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Submit"/></td>
            </tr>            
        </table>
    </fieldset>
</form>

<?php

    if(
        isset($_POST['drug_name']) && !empty($_POST['drug_name']) &&
        isset($_POST['drug_form']) && !empty($_POST['drug_form'])
      ){
        
        $name = mysql_real_escape_string($_POST['drug_name']);
        $form = mysql_real_escape_string($_POST['drug_form']);
        
        $query = "SELECT Name,Form
                  FROM   drugs
                  WHERE  Name='{$name}' AND Form='{$form}'
        ";
        $result = mysql_query($query)or die(mysql_error());
        
        if(mysql_num_rows($result) > 0){ //If record already exists in table
            echo "<span class=\"incorrect\">Error:</span> This drug already exists.<br/>";
        }
        else{ //New record
            $query = "INSERT INTO drugs
                VALUES 
                (
                    '',
                    '{$name}',
                    '{$form}'
                )
            ";
            
            mysql_query($query)or die(mysql_error());
            echo "<span class=\"correct\">Success:</span> Created drug and added to database.<br/>";
            echo "Name: {$name}<br/>";
            echo "Form: {$form}<br/>";
        }
    }
    else{ //If the fields are empty
        if(isset($_POST['submit'])){ //Only check if the form has been submitted
            if(empty($_POST['drug_name'])){echo "<span class=\"incorrect\">Error: Drug Name is missing.</span><br/>";}
            if(empty($_POST['drug_form'])){echo "<span class=\"incorrect\">Error: Drug Form is missing.</span><br/>";}
        }
    }

?>