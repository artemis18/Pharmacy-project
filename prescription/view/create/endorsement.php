<?php 
    require_once "control/validsession.php"; 
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<script type="text/javascript" language="Javascript" src="js/livesearch.js"></script>
<h1>Endorsement</h1>
<form action="" method='post'>
    <fieldset>
        <legend>Create an endorsement</legend>
        <table>
            <tr>
                <td align='right'><label>Drug name:</label></td>
                <td width="450px">
                    <input id="query" type="text" name="search" onkeyup="loadSearch();"/>
                    <select id="form" onChange="loadSearch();">
                        <option value="all">All</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    Found: <label id="num_results"></label> result(s)&nbsp;<label id="extra_result" style="font-style: italic;"></label>
                    <div id="divloader" style="visibility: hidden; display: inline;"><img src="/prescription/images/loading.gif"/></div>
                    <br/>
                    <select id="livesearch" 
                            style="vertical-align: top; 
                                   width: 70%;" 
                            size="10" 
                            name="drug"
                            onChange="displayDrug(this.value);"
                            multiple>
                    </select>
                    &nbsp;
                    <div style=" float: right; margin-left: 10px;">
                        Drug Details<br/>
                        Name: <label id="drug_name"></label><br/>
                        Form: <label id="drug_form"></label><br/>
                    </div>
                </td>
            </tr>
            <tr>
                <td align='right'><label>Dosage:</label></td>
                <td><input type='text' name='dosage'/></td>
            </tr>
            <tr>
                <td align='right'><label>Quantity:</label></td>
                <td><input type='text' name='quantity'/></td>
            </tr>   
            <tr>
                <td align='right'><label>Instruction:</label></td>
                <td><input type='text' name='instruction'/></td>
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
        isset($_POST['drug']) &&
        isset($_POST['quantity']) &&
        isset($_POST['dosage']) &&
        isset($_POST['instruction'])
      ){
        
        $drug_id = mysql_real_escape_string($_POST['drug']);
        $quantity = mysql_real_escape_string($_POST['quantity']);
        $dosage = mysql_real_escape_string($_POST['dosage']);
        $instruction = mysql_real_escape_string($_POST['instruction']);
        
        $query = "SELECT DrugID, Quantity, Dosage, Instruction
                  FROM endorsements
                  WHERE DrugID='{$drug_id}' AND Quantity='{$quantity}' AND
                        Dosage='{$dosage}' AND Instruction='{$instruction}'
                 ";

        $result = mysql_query($query)or die(mysql_error());
        
        //Record already exists in table
        if(mysql_num_rows($result) > 0){
            echo "<span class=\"incorrect\">Warning:</span> This endorsement already exists for this drug.<br/>";
        }
        else{ //New record
            $query = "INSERT INTO endorsements
                      VALUES
                      (
                        '',
                        '{$drug_id}',
                        '{$quantity}',
                        '{$dosage}',
                        '{$instruction}'
                       )
                     ";
            mysql_query($query)or die(mysql_error());
            
            $query = "SELECT Name 
                      FROM drugs
                      WHERE DrugID='{$drug_id}'
                     ";
            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);
            echo "<span class=\"correct\">Success:</span> Added new endorsement.<br/>";
            echo "Drug: {$row['Name']}<br/>";
            echo "Quantity: {$quantity}<br/>";
            echo "Dosage: {$dosage}<br/>";
            echo "Instruction: {$instruction}<br/>";
        }
    }
    else{
        if(isset($_POST['submit'])){ //Check if fields are empty
            if(empty($_POST['drug'])){echo "<span style=\"color: #f00;\">Drug is missing.</span><br/>";}
            if(empty($_POST['quantity'])){echo "<span style=\"color: #f00;\">Quantity is missing.</span><br/>";}
            if(empty($_POST['dosage'])){echo "<span style=\"color: #f00;\">Dosage is missing.</span><br/>";}
        }
    }

?>