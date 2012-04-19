<?php
    require_once("../database/database.php");
    $con = mysql_connect($db_host, $db_username, $db_password);
    $db = mysql_select_db($db_database, $con);

if(    
        //isset($_GET['patient']) &&
        //isset($_GET['prescriber']) &&
        //isset($_GET['endorsements']) &&
        isset($_GET['layout'])
  ){
    $output = array();
    $layout = mysql_real_escape_string($_GET['layout']);
    //$patient = mysql_real_escape_string($_GET['patient']);
    //$prescriber = mysql_real_escape_string($_GET['prescriber']);
    //$endorsements = explode(";",$_GET['endorsements']);
    $query = "SELECT *
              FROM   prescriptionlayouts
              WHERE  PrescriptionLayoutID='{$layout}'
             ";
    $result = mysql_query($query)or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    $num = mysql_num_rows($result);

    $ptd = $row['patient_details'];
    $pta = $row['patient_age'];
    $ptdb = $row['patient_dob'];
    $ptnhs = $row['patient_nhsno'];
    $prd = $row['prescriber_details'];
    $prs = $row['prescriber_signature'];
    $prsn = $row['prescription_serialno'];
    $e = $row['endorsements'];
    $prsd = $row['prescription_date'];
    $phs = $row['pharmacy_stamp'];
    $ndt = $row['num_days_treatment'];
    $parser = simplexml_load_file("../pform/xml/{$row['Name']}.xml");
    
    //Count the number of boxes in prescription
    $num_boxes = count($parser->xpath("PrescriptionObjects"));
    $nb = $num_boxes;

    //Assign the prescription background colour
    $bg_red = $parser->xpath("/prescription/bgColour/Red");
    $bgr = $bg_red[0][0];
    $bg_green = $parser->xpath("/prescription/bgColour/Green");
    $bgg = $bg_green[0][0];
    $bg_blue = $parser->xpath("/prescription/bgColour/Blue");
    $bgb = $bg_blue[0][0];

    //Prescription dimensions
    $pres_width = $parser->xpath("/prescription/Dimensions/width");
    $pw = $pres_width[0][0];
    $pres_height = $parser->xpath("/prescription/Dimensions/height");
    $ph = $pres_height[0][0];
    
    $placeholders = array(
        "patient_details" => $ptd,
        "patient_age" => $pta,
        "patient_dob" => $ptdb,
        "patient_nhsno" => $ptnhs,
        "prescriber_details" => $prd,
        "prescriber_signature" => $prs,
        "prescription_serialno" => $prsn,
        "endorsements" => $e,
        "prescription_date" => $prsd,
        "pharmacy_stamp" => $phs,
        "num_days_treatment" => $ndt
    );
    
    $bg_color = array(
        "red" => $bgr,
        "green" => $bgg,
        "blue" => $bgb
    );
    
    $prescription_layout = array(
        "width" => $pw,
        "height" => $ph,
        "bg" => $bg_color,
        "placeholders" => $placeholders,
        "boxes" => array()
    );
    

    //Iterate through the Boxes
    for($count = 1; $count <= $num_boxes; $count++){
        if($count != 1){
            //echo "[]";
        }
        //Get the information for each box
        $x = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/position/x");
        $x = $x[0][0];
        $y = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/position/y");
        $y = $y[0][0];
        $width = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/dimensions/width");
        $w = $width[0][0];
        $height = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/dimensions/height");
        $h = $height[0][0];
        $line_width = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineWidth");
        $lw = $line_width[0][0];
        $line_r = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineColour/Red");
        $lr = $line_r[0][0];
        $line_g = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineColour/Green");
        $lg = $line_g[0][0];
        $line_b = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineColour/Blue");
        $lb = $line_b[0][0];
        $transparent = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/transparent");
        $t = $transparent[0][0];
        $fill_r = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/fillColour/Red");
        $fr = $fill_r[0][0];
        $fill_g = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/fillColour/Green");
        $fg = $fill_g[0][0];
        $fill_b = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/fillColour/Blue");
        $fb = $fill_b[0][0];
        $text = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/name");
        $n = $text[0][0];

        //Arrays
        $position = array(
            "x" => $x,
            "y" => $y
        );
        
        $dimension = array(
            "width" => $w,
            "height" => $h
        );
        
        $line = array(
            "width" => $lw,
            "colour" => array(
                "red" => $lr,
                "green" => $lg,
                "blue" => $lb
            )
        );
        
        $fill = array(
            "transparent" => $t,
            "colour" => array(
                "red" => $fr,
                "green" => $fg,
                "blue" => $fb
            )
        );
        
        $prescription_layout['boxes'][$count - 1] = array(
            "name" => $n,
            "position" => $position,
            "dimension" => $dimension,
            "line" => $line,
            "fill" => $fill
        );
        
        $output['prescription_layout'] = $prescription_layout;
    }
    
    if(isset($_GET['patient']) && $_GET['patient'] != "Click on Show" ){
        if($_GET['patient'] == "null"){}else{

        $patient = mysql_real_escape_string($_GET['patient']);

        $query = "SELECT *
                  FROM   patients
                  WHERE  PatientID='{$patient}'
                 ";
        $result = mysql_query($query)or die(mysql_error());
        $row = mysql_fetch_assoc($result);

        $n = ucfirst($row['Title'])." ".ucfirst($row['Forename'])." ".ucfirst($row['Surname']);
        $r = ucwords($row['Road']);
        $c = ucwords($row['City']);
        $p = strtoupper($row['Postcode']);
        $t = $row['Telephone'];
        $d = strtoupper($row['DOB']);
        $nhs = strtoupper($row['NHSno']);

        $dob = explode("/",$d);
        $year_diff  = date("Y") - $dob[2];
        $month_diff = date("m") - $dob[1];
        $day_diff   = date("d") - $dob[0];
        if ($day_diff < 0 || $month_diff < 0) $year_diff--;
        $age = "{$year_diff}yrs";
        
        if($age < 10){
            if($age > 1){
                $age = "{$year_diff}yrs ";
            }
            elseif($age == 1){
                $age = "{$year_diff}yr ";
            }
            
            if($month_diff > 1){
                $age .= "{$month_diff}mths";
            }
            elseif($month_diff == 1){
                $age .= "{$month_diff}mth";
            }
            else{
                $age .= "0mths";
            }
        }
        
        $patient = array(
            "name" => $n,
            "road" => $r,
            "city" => $c,
            "postcode" => $p,
            "telephone" => $t,
            "dob" => $d,
            "nhsno" => $nhs,
            "age" => $age
        );
        $output['patient'] = $patient;
        }
    }
    if(isset($_GET['prescriber']) && $_GET['prescriber'] != "Click on Show" ){
        if($_GET['prescriber'] == "null"){}else{
            $prescriber = mysql_real_escape_string($_GET['prescriber']);

            $query = "SELECT *
                      FROM   prescribers
                      WHERE  PrescriberID='{$prescriber}'
                     ";
            $result = mysql_query($query)or die(mysql_error());
            $row = mysql_fetch_assoc($result);

            $n = ucfirst($row['Title'])." ".ucfirst($row['Forename'])." ".ucfirst($row['Surname']);
            $r = ucwords($row['Road']);
            $c = ucwords($row['City']);
            $p = strtoupper($row['Postcode']);
            $t = $row['Telephone'];

            $prescriber = array(
                "name" => $n,
                "road" => $r,
                "city" => $c,
                "postcode" => $p,
                "telephone" => $t
            );
            $output['prescriber'] = $prescriber;
        }
    }

    if(isset($_GET['endorsements'])){
        if($_GET['endorsements'] == "null"){}else{
            $end = mysql_real_escape_string($_GET['endorsements']);
            $end = explode(",",$end);
            $endorsements = array();  

            for($i=0;$i<count($end);$i++){
                if($end[$i]!="null"){
                    $query = "SELECT *
                      FROM drugs, endorsements
                      WHERE drugs.DrugID=endorsements.DrugID AND
                            endorsements.EndorsementID='{$end[$i]}'
                     ";
                    $result = mysql_query($query);
                    $row = mysql_fetch_assoc($result);

                    $n = $row['Name'];
                    $f = $row['Form'];
                    $q = $row['Quantity'];
                    $d = $row['Dosage'];
                    $in = $row['Instruction'];
                    $endorsements[$i] = array(
                        "name" => $n,
                        "form" => $f,
                        "quantity" => $q,
                        "dosage" => $d,
                        "instruction" => $in
                    );
                }
            }
            $output['endorsements'] = $endorsements;
        }
    }
    $JSONoutput = json_encode($output);
    echo $JSONoutput;
}
elseif(isset($_GET['pformid'])){
    $pformid = mysql_real_escape_string($_GET['pformid']);
    $query = "SELECT *
              FROM   prescriptionforms
              WHERE  PrescriptionFormID='{$pformid}'
             ";
    $result = mysql_query($query)or die(mysql_error());
    $row = mysql_fetch_assoc($result);
    
    $query = "SELECT pf.PrescriptionFormID, e.EndorsementID, ec.PrescriptionFormID, ec.EndorsementID
              FROM   prescriptionforms AS pf, endorsements AS e, endorsementcollection AS ec
              WHERE  pf.PrescriptionFormID='{$pformid}' AND pf.PrescriptionFormID=ec.PrescriptionFormID AND
                     e.EndorsementID=ec.EndorsementID
             ";
    $result = mysql_query($query)or die(mysql_error());
    $endorsements = "";
    while($end = mysql_fetch_assoc($result)){
        $endorsements .= "{$end['EndorsementID']},";
    }
    $endorsements = substr($endorsements, 0, strlen($endorsements)-1);
    $time = date("d/m/Y", $row['Timestamp']);
    
    $output = array(
        "pformid" => $row['PrescriptionFormID'],
        "patient" => $row['PatientID'],
        "prescriber" => $row['PrescriberID'],
        "layout" => $row['PrescriptionLayoutID'],
        "timestamp" => $time,
        "watermark" => $row['Watermark'],
        "signature" => $row['Signature'],
        "ndt" => $row['NDT'],
        "stamp" => $row['Stamp'],
        "date" => $row['Date'],
        "dob" => $row['DOB'],
        "age" => $row['Age'],
        "nhsno" => $row['NHSNo'],
        "numdays" => $row['NumDaysTreatment'],
        "endorsements" => $endorsements
    );
    
    $JSONoutput = json_encode($output);
    echo $JSONoutput;
}
?>