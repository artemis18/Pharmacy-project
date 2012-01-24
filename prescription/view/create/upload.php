<?php 
    require_once "control/validsession.php"; 
    require_once("database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
?>
<h1>Prescription Layout</h1>
<br/>
<p>Use this page to upload and define a prescription layout.</p>
<br/>

<form enctype="multipart/form-data" action="" method="post">
    <fieldset>
        <legend>Prescription layout creation</legend>
        <table>
            <tr>
                <td>Name: </td>
                <td><input type="text" name="name" /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <br/>
                    <p style="font-size: 13px;">
                    Please upload the prescription layout, created using<br/>
                    the prescription designer software.
                    </p>
                </td>
            </tr>
            <tr>
                <td>File: </td>
                <td>
                    <input type="hidden" name="MAX_FILE_SIZE" value="100000"/>
                    <input type="file" name="file"/>
                </td>
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
            isset($_POST['name']) && !empty($_POST['name']) &&
            isset($_FILES['file']) && $_FILES['file']['type'] == "text/xml"
      ){
        $dir = "pform/";
        $exists = false;
        $name = mysql_real_escape_string($_POST['name']);
        
        $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
        
        if($_FILES['file']['error'] > 0){
            echo "<span class=\"incorrect\">Error: {$_FILES['file']['error']}</span><br/>";
        }
        else{
            if(file_exists($dir . "xml/" . $_FILES['file']['name'])){
                echo "<span class=\"incorrect\">Warning: </span>{$filename} already exists.<br/>";
                $exists = true;
            }
            else{
                move_uploaded_file($_FILES['file']['tmp_name'],
                        $dir . "xml/" . $_FILES['file']['name']);
                
                require_once "model/xmlToSvg.php";
                convert_to_svg($filename);
                
                //Placeholder positions
                $patient_details = "";
                $patient_age = "";
                $patient_dob = "";
                $patient_nhsno = "";
                $prescriber_details = "";
                $prescriber_signature = "";
                $prescription_serialno = "";
                $endorsements = "";
                $prescription_date = "";
                $pharmacy_stamp = "";
                
                //Get the placeholder information from xml file
                $parser = simplexml_load_file("pform/xml/" . $filename . ".xml");
                
                //Count the number of boxes in prescription
                $num_boxes = count($parser->xpath("PrescriptionObjects"));
                
                for($count = 1; $count <= $num_boxes; $count++){
                    $placeholder = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/placeholder");
                    $x = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/position/x");
                    $y = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/position/y");
                    switch($placeholder[0][0]){
                        case "patient_details":
                            $patient_details = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "patient_age":
                            $patient_age = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "patient_dob":
                            $patient_dob = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "patient_nhsno":
                            $patient_nhsno = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "prescriber_details":
                            $prescriber_details = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "prescriber_signature":
                            $prescriber_signature = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "prescription_serialno":
                            $prescription_serialno = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "endorsements":
                            $endorsements = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "prescription_date":
                            $prescription_date = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "pharmacy_stamp":
                            $pharmacy_stamp = "{$x[0][0]},{$y[0][0]}";
                            break;
                        case "num_days_treatment":
                            $num_days_treatment = "{$x[0][0]},{$y[0][0]}";
                            break;
                        default:
                            break;
                    }
                }
                
                $query = "INSERT INTO prescriptionlayouts
                          VALUES
                          (
                            '',
                            '{$name}',
                            '{$patient_details}',
                            '{$patient_age}',
                            '{$patient_dob}',
                            '{$patient_nhsno}',
                            '{$prescriber_details}',
                            '{$prescriber_signature}',
                            '{$prescription_serialno}',
                            '{$endorsements}',
                            '{$prescription_date}',
                            '{$pharmacy_stamp}',
                            '{$num_days_treatment}'
                          )
                         ";
                mysql_query($query)or die(mysql_error());
                
                echo "<span class=\"correct\">Sucess: </span> Prescription Layout uploaded and added to database.<br/>";
            }
        }
        
    }
    else{
        if(isset($_POST['submit'])){
            if($_FILES['file']['type'] != "text/xml"){
                echo "<span class=\"incorrect\">Error: Incorrect file submitted.</span><br/>";
            }
            if(empty($patient_details)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"patient_details\" not specified.<br/>";
            }
            if(empty($patient_age)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"patient_age\" not specified.<br/>";
            }
            if(empty($patient_dob)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"patient_dob\" not specified.<br/>";
            }
            if(empty($patient_nhsno)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"patient_nhsno\" not specified.<br/>";
            }
            if(empty($prescriber_details)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"prescriber_details\" not specified.<br/>";
            }
            if(empty($prescriber_signature)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"prescriber_signature\" not specified.<br/>";
            }
            if(empty($prescription_serialno)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"prescription_serialno\" not specified.<br/>";
            }
            if(empty($endorsements)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"endorsements\" not specified.<br/>";
            }
            if(empty($prescription_date)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"prescription_date\" not specified.<br/>";
            }
            if(empty($pharmacy_stamp)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"pharmacy_stamp\" not specified.<br/>";
            }
            if(empty($num_days_treatment)){
                echo "<span class=\"incorrect\">Warning: </span>Placeholder for \"num_days_treatment\" not specified.<br/>";
            }
        }
    }
        
?>