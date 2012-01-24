<?php
    require_once "control/validsession.php";
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<script language="Javascript" src="/prescription/js/livesearch.js"></script>
<script language="Javascript" src="/prescription/js/createtest.js"></script>
<script language="Javascript" src="/prescription/js/liveview.js"></script>

<form action="" 
      method="post" 
      style="float: left;" 
      name="createtest"
      onsubmit="return ttt()">
    <h1>Test</h1>
    <p>
        To create a test, search for a prescription and select it. You can select <br/>
        more than one prescription by holding CTRL while clicking on the prescriptions<br/>
        in the list. Once you have selected the prescriptions, click <strong>Create Test</strong>.<br/>
    </p>
    <br/>    
    <fieldset>
        <lengend>Create A Test</lengend>
        <br/>
        <table>
            <tr>
                <td align="right"><label>Search: </label></td>
                <td width="300px">
                    <input id="prescriptionsearch" 
                           type="text" 
                           name="prescriptionsearch" 
                           onKeyUp="livepformsearch();"/>
                    &nbsp;
                    <select id="select_field" 
                            onChange="livepformsearch();">
                        <option value="pformid">Prescription ID</option>
                        <option value="patient">Patient</option>
                        <option value="prescriber">Prescriber</option>
                        <option value="endorsement">Endorsement</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <label id="num_results">Found:</label>
                    <br/><br/>
                    Sort By Date? (Newest First):
                    <input type="checkbox" 
                           name="sortby" 
                           value="date" 
                           id="sortby_date" 
                           onclick="livepformsearch();"/>
                    <label for="sortby_date">Yes</label>
                    <br/>
                    <table>
                        <tr>
                            <td>
                                <select id="livepform" 
                                        style="vertical-align: top; 
                                               width: 200px;" 
                                        size="15" 
                                        name="pforms[]"
                                        onChange="pformdisplay(this.value);"
                                        multiple="multiple">
                                </select>
                            </td>
                            <td>
                                <button onclick="moveAccross(); return false;">>></button><br/>
                                <button onclick="bringBack(); return false;"><<</button>
                            </td>
                            <td>
                                <select id="selectedform" 
                                        style="vertical-align: top; 
                                               width: 200px;" 
                                        size="15" 
                                        name="selected[]"
                                        onChange="pformdisplay(this.value);"
                                        multiple="multiple">
                                </select>
                            </td>                            
                        </tr>
                    </table>                        
                    <span class="correct">Correct Prescription</span><br/>
                    <span class="incorrect">Incorrect Prescription</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <br/>
                    Type:&nbsp;
                    <select name="type">
                        <?php
                            
                            $query = "SELECT TestTypeID, Name, Description
                                      FROM   testtypes
                                     ";
                            $result = mysql_query($query)or die(mysql_error());
                            while($row=mysql_fetch_assoc($result)){
                                echo "<option value=\"{$row['TestTypeID']}\">{$row['Name']}</option>";
                            }
                        ?>
                    </select>&nbsp;<a href="#">Edit Test Types</a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td align="left">
                    <br/>
                    <p style="font-size: 13px;">
                    This feedback will be displayed to the student after<br/>
                    they have completed the test.
                    </p>
                </td>         
            </tr>
            <tr>
                <td><label>Feedback: </label></td>
                <td><textarea name="feedback" id="feedback" style="width: 300px; height: 100px;"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td align="right">
                    <input type="submit" value="Create Test" name="submit" />
                </td>
            </tr>
        </table>
    </fieldset>
</form>
<div style="width: 400px; float: left; margin: 10px;">
    <div valign="top">
        <h1>Current Prescription</h1>
        <canvas id="ps_view_c" 
                height="600" 
                width="450" 
                style="border: 1px solid #000; 
                       margin-bottom: 10px; 
                       float: left;">
        </canvas>
    </div>
</div>
<br/><br/>
<p>
<?php
if(
         isset($_POST['selected']) && !empty($_POST['pforms']) &&
         isset($_POST['feedback']) && isset($_POST['type'])
   ){
     $selected = $_POST['selected'];
     $feedback = mysql_real_escape_string($_POST['feedback']);
     $type = $_POST['type'];
     
     $query = "INSERT INTO tests
               VALUES
               (
                    '',
                    '{$_SESSION['user_id']}',
                    '{$feedback}',
                    '{$type}',
                    '".time()."'
               )
              ";
     mysql_query($query)or die(mysql_error());
     $test_id = mysql_insert_id();
     
     foreach($selected AS $form){
         $query = "INSERT INTO prescriptioncollection
                   VALUES
                   (
                        '{$form}',
                        '{$test_id}'
                   )
                  ";
         mysql_query($query)or die(mysql_error());
     }
     
     echo "<span class=\"correct\">Success:</span> Created test and added to database.<br/>";
 }
 else{
     if(isset($_POST['submit'])){
         if(empty($_POST['selected'])){
             echo "<span class=\"incorrect\">Error: Please select at least one prescription form.</span><br/>";
         }
     }
 }
     
?>
</p>