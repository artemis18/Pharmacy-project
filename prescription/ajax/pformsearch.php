<?php

function printdate($timestamp){
    return date("d/m/y", $timestamp);
}

    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);
    
if( //Check if fields are correctly set
        isset($_GET['q']) &&
        isset($_GET['field']) &&
        isset($_GET['sortby'])
  ){
    $search = mysql_real_escape_string($_GET['q']);
    $field = mysql_real_escape_string($_GET['field']);
    $sortby = mysql_real_escape_string($_GET['sortby']);
    if($field == "patient"){
        
        $query = "SELECT   pt.PatientID, pt.Title, pt.Forename, pt.Surname,
                           pt.Gender, pf.PrescriptionFormID, pf.PatientID,
                           pf.Timestamp
                  FROM     patients AS pt, prescriptionforms AS pf
                  WHERE    pt.PatientID=pf.PatientID AND
                          (pt.Forename LIKE '{$search}%' OR
                           pt.Surname LIKE '{$search}%')

                  ORDER BY ";
        if($sortby == "true"){
            $query = $query . " Timestamp DESC";
            }
        else{
            $query = $query . " Surname ASC";
            }
        $query = $query . " LIMIT 0, 100";
            
        $result = mysql_query($query)or die("<option>".mysql_error()."</option>");
        $num = mysql_num_rows($result);
        echo $num . ";";
        
        if($num > 0){
            while($row = mysql_fetch_assoc($result)){
                echo "<option ";
                if(substr($row['PrescriptionFormID'], strlen($row['PrescriptionFormID'])-2, 2) != "00"){
                    echo " class=\"incorrect\" ";
                }
                else{
                    echo " class=\"correct\" ";
                }
                echo " value=\"{$row['PrescriptionFormID']}\">{$row['Surname']}, {$row['Forename']} - (".printdate($row['Timestamp']).")</option>";
            }
        }
        else{
            echo "<option>No Results</option>";
        }
    }
    elseif($field == "prescriber"){
        $query = "SELECT   pr.PrescriberID, pr.Title, pr.Forename, pr.Surname,
                           pf.PrescriptionFormID, pf.PrescriberID,
                           pf.Timestamp
                  FROM     prescribers pr, prescriptionforms pf
                  WHERE    pr.PrescriberID=pf.PrescriberID AND
                          (pr.Forename LIKE '%{$search}%' OR
                           pr.Surname LIKE '%{$search}%')
                  ORDER BY ";
        if($sortby == "true"){
            $query = $query . " Timestamp DESC";
        }
        else{
            $query = $query . " Surname";
        }
        $query = $query . " LIMIT 0, 100";                   
        $result = mysql_query($query)or die(mysql_error());
        $num = mysql_num_rows($result);
        echo $num . ";";
        
        if($num > 0){
            while($row = mysql_fetch_assoc($result)){
                echo "<option ";
                if(substr($row['PrescriptionFormID'], strlen($row['PrescriptionFormID'])-2, 2) != "00"){
                    echo " class=\"incorrect\" ";
                }
                else{
                    echo " class=\"correct\" ";
                }
                echo " value=\"{$row['PrescriptionFormID']}\">{$row['Surname']}, {$row['Forename']} - (".printdate($row['Timestamp']).")</option>";
            }
        }
        else{
            echo "<option>No Results</option>";
        }
    }
    elseif($field == "endorsement"){
        $query = "SELECT   ed.EndorsementID, ed.Quantity, ed.Dosage, dr.Name,
                           dr.Form, pf.PrescriptionFormID, ec.EndorsementID,
                           pf.Timestamp, ec.PrescriptionFormID, dr.DrugID,
                           ed.DrugID
                  FROM     endorsements ed, prescriptionforms pf, drugs dr,
                           endorsementcollection ec
                  WHERE    ed.EndorsementID=ec.EndorsementID AND
                           pf.PrescriptionFormID=ec.PrescriptionFormID AND
                           ed.DrugID=dr.DrugID AND
                          (dr.Name LIKE '{$search}%' OR
                           dr.Form LIKE '{$search}%' OR
                           ed.Quantity LIKE '{$search}%' OR
                           ed.Dosage LIKE '{$search}%')
                  ORDER BY ";
        if($sortby == "true"){
            $query = $query . " Timestamp DESC";
        }
        else{
            $query = $query . " Name ASC";
        }
        $query = $query . " LIMIT 0, 100";
        $result = mysql_query($query)or die(mysql_error());
        $num = mysql_num_rows($result);
        echo $num . ";";
        
        if($num > 0){
            while($row = mysql_fetch_assoc($result)){
                echo "<option ";
                if(substr($row['PrescriptionFormID'], strlen($row['PrescriptionFormID'])-2, 2) != "00"){
                    echo " class=\"incorrect\" ";
                }
                else{
                    echo " class=\"correct\" ";
                }
                echo " value=\"{$row['PrescriptionFormID']}\">{$row['Name']}, {$row['Form']} - (".printdate($row['Timestamp']).")</option>";
            }
        }
        else{
            echo "<option>No Results</option>";
        }
    }
    elseif($field == "layout"){
        $query = "SELECT   pl.Name, pl.PrescriptionLayoutID,
                           pf.PrescriptionLayoutID, pf.PrescriptionFormID,
                           pf.Timestamp
                  FROM     prescriptionlayouts pl, prescriptionforms pf
                  WHERE    pl.PrescriptionLayoutID=pf.PrescriptionLayoutID AND
                           pl.Name LIKE '%{$search}%'
                  ORDER BY ";
                           
        if($sortby == "true"){
            $query = $query . " Timestamp DESC";
        }
        else{
            $query = $query . " Surname";
        }
        $query = $query . " LIMIT 0, 100";
        $result = mysql_query($query)or die(mysql_error());
        $num = mysql_num_rows($result);
        echo $num . ";";
        
        if($num > 0){
            while($row = mysql_fetch_assoc($result)){
                echo "<option ";
                if(substr($row['PrescriptionFormID'], strlen($row['PrescriptionFormID'])-2, 2) != "00"){
                    echo " class=\"incorrect\" ";
                }
                else{
                    echo " class=\"correct\" ";
                }
                echo " value=\"{$row['PrescriptionFormID']}\">{$row['Surname']}, {$row['Forename']}</option>";
            }
        }
        else{
            echo "<option>No Results</option>";
        }
    }
    elseif($field == "pformid"){
        $query = "SELECT   PrescriptionFormID,
                           Timestamp
                  FROM     prescriptionforms
                  WHERE    PrescriptionFormID LIKE '{$search}%'
                  ORDER BY ";
                  
        if($sortby == "true"){
            $query = $query . " Timestamp DESC";
        }
        else{
            $query = $query . " PrescriptionFormID";
        }
        $query = $query . " LIMIT 0, 100";
        $result = mysql_query($query)or die(mysql_error());
        $num = mysql_num_rows($result);
        echo $num . ";";
        
        if($num > 0){
            while($row = mysql_fetch_assoc($result)){
                echo "<option ";
                if(substr($row['PrescriptionFormID'], strlen($row['PrescriptionFormID'])-2, 2) != "00"){
                    echo " class=\"incorrect\" ";
                }
                else{
                    echo " class=\"correct\" ";
                }
                echo " value=\"{$row['PrescriptionFormID']}\">{$row['PrescriptionFormID']} - (".printdate($row['Timestamp']).")</option>";
            }
        }
        else{
            echo "<option>No Results</option>";
        }
    }
    else{ //If no field has been selected, sort the prescriptions by timestamp
        $query = "SELECT   PrescriptionFormID,
                           Timestamp
                  FROM     prescriptionforms
                  WHERE    1=1
                  ORDER BY Timestamp DESC";
        $query = $query . " LIMIT 0, 100";
        $result = mysql_query($query)or die(mysql_error());
        $num = mysql_num_rows($result);
        echo $num . ";";
        
        if($num > 0){
            while($row = mysql_fetch_assoc($result)){
                echo "<option ";
                if(substr($row['PrescriptionFormID'], strlen($row['PrescriptionFormID'])-2, 2) != "00"){
                    echo " class=\"incorrect\" ";
                }
                else{
                    echo " class=\"correct\" ";
                }
                echo "value=\"{$row['PrescriptionFormID']}\">{$row['PrescriptionFormID']} - (".printdate($row['Timestamp']).")</option>";
            }
        }
        else{
            echo "<option>No Results</option>";
        }
    }
}

elseif(isset($_GET['browse'])){
    $query = "SELECT *
              FROM   prescriptionforms
             ";
    $result = mysql_query($query)or die(mysql_error());
    $num_results = mysql_num_rows($result);
    $output = array();
    $output['num_results'] = $num_results;
    $output['results'] = array();
    
    while($row = mysql_fetch_assoc($result)){
        $time = date("d/m/Y", $row['Timestamp']);
        $prescription = array(
            "prescription_form_id" => $row['PrescriptionFormID'],
            "patient_id" => $row['PatientID'],
            "prescriber_id" => $row['PrescriberID'],
            "layout_id" => $row['PrescriptionLayoutID'],
            "feedback" => $row['FeedbackNote'],
            "timestamp" => $time,
            "watermark" => $row['Watermark'],
            "signature" => $row['Signature'],
            "ndt" => $row['NDT'],
            "stamp" => $row['Stamp'],
            "date" => $row['Date'],
            "dob" => $row['DOB'],
            "age" => $row['Age'],
            "nhsno" => $row['NHSNo'],
            "numdaystreatment" => $row['NumDaysTreatment']
        );
        
        $output['results'][] = $prescription;
    }
    
    $JSONoutput = json_encode($output);
    echo $JSONoutput;
}

//If a single prescription has been selected, get details
elseif(isset($_GET['id'])){
    $prescription_id = mysql_real_escape_string($_GET['id']);
    $output = array();
    
    //Prescription Form Table
    $pf_query = "SELECT  pf.PrescriptionFormID, pf.Timestamp,
                         pf.Watermark, pf.Signature, pf.NDT,
                         pf.Stamp, pf.Date, pf.DOB, pf.Age, pf.NHSNo,
                         pf.NumDaysTreatment
                 FROM    prescriptionforms AS pf
                 WHERE   PrescriptionFormID='{$prescription_id}'
               ";
    $pf_result = mysql_query($pf_query)or die(mysql_error());
    $pf_row = mysql_fetch_assoc($pf_result);
    
    $date = printdate($pf_row['Timestamp']);
    
    $prescription_form = array(
        "id" => $pf_row['PrescriptionFormID'],
        "timestamp" => $date,
        "watermark" => $pf_row['Watermark'],
        "signature" => $pf_row['Signature'],
        "ndt" => $pf_row['NDT'],
        "stamp" => $pf_row['Stamp'],
        "date" => $pf_row['Date'],
        "dob" => $pf_row['DOB'],
        "age" => $pf_row['Age'],
        "nhsno" => $pf_row['NHSNo'],
        "numdays" => $pf_row['NumDaysTreatment']
    );
    
    $output['PrescriptionForm'] = $prescription_form;
    
    $pt_query = "SELECT pt.patientID, pf.PatientID, pf.PrescriptionFormID
                 FROM   patients AS pt, prescriptionforms AS pf
                 WHERE  pt.patientID=pf.PatientID AND
                        pf.PrescriptionFormID='{$prescription_id}'
                ";
    $pt_result = mysql_query($pt_query)or die(mysql_error());
    $pt_row = mysql_fetch_assoc($pt_result);
    
    $output['Patient'] = $pt_row['PatientID'];
    
    $pr_query = "SELECT pr.PrescriberID, pf.PrescriberID, pf.PrescriptionFormID
                 FROM   prescribers AS pr, prescriptionforms AS pf
                 WHERE  pr.PrescriberID=pf.PrescriberID AND
                        pf.PrescriptionFormID='{$prescription_id}'
                ";
    $pr_result = mysql_query($pr_query)or die(mysql_error());
    $pr_row = mysql_fetch_assoc($pr_result);
    
    $output['Prescriber'] = $pr_row['PrescriberID'];
    
    //Prescription layout Table
    $pl_query = "SELECT pl.PrescriptionLayoutID, pf.PrescriptionLayoutID,
                        pf.PrescriptionFormID
                 FROM   prescriptionlayouts AS pl, prescriptionforms AS pf
                 WHERE  pl.PrescriptionLayoutID=pf.PrescriptionLayoutID AND
                        pf.PrescriptionFormID='{$prescription_id}'
                ";
    $pl_result = mysql_query($pl_query)or die(mysql_error());
    $pl_row = mysql_fetch_assoc($pl_result);
    
    $output['PrescriptionLayout'] = $pl_row['PrescriptionLayoutID'];
    
    
    //Drug Table
    $drug_query = "SELECT     pf.PrescriptionFormID, ec.PrescriptionFormID,
                              ec.EndorsementID, ed.EndorsementID
                   FROM       prescriptionforms AS pf,
                              endorsements AS ed, endorsementcollection AS ec
                   WHERE      pf.PrescriptionFormID='{$prescription_id}' AND
                              pf.PrescriptionFormID=ec.PrescriptionFormID AND
                              ed.EndorsementID=ec.EndorsementID
                  ";
    
    $endorsements = array();
                   
    $drug_result = mysql_query($drug_query)or die(mysql_error());
    
    while($drug_row = mysql_fetch_assoc($drug_result)){
        $endorsements[] = $drug_row['EndorsementID'];
    }
    
    $output['Endorsements'] = $endorsements;
    
    $JSONoutput = json_encode($output);
    echo $JSONoutput;
}

//Just in case
else{
    echo "Nothing";
}
?>
