<?php require_once "{$_ENV['root']}/control/validsession.php"; ?>
<h1>Prescription Layout</h1>
<br/>
<p>Use this page to upload and define a prescription layout.</p>
<br/>

<form action="" method="post">
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
                <td>File</td>
            </tr>
        </table>
    </fieldset>
</form>

<div id="upload_container">
    <div id="header"></div>
    <div id="content" style="margin-left: auto; margin-right: auto;">
        <div id="lt">
            <?php
            $dir = "pform/";
            $exists = false;
            $filename;

            if(isset($_FILES['file'])){
                //Check that the file MIME type is xml
                if ($_FILES['file']['type'] == "text/xml"){

                    //Get the file name without its extension
                    $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME); 

                    if ($_FILES['file']['error'] > 0){
                        echo "Error: " . $_FILES['file']['error'] . "<br />";
                    } else {
                        if (file_exists($_ENV['root'] . $dir ."xml/". $_FILES["file"]["name"])){
                            echo "<h1>" . $filename . " already exists.</h1>";
                            $exists = true;
                        } else {
                            move_uploaded_file($_FILES['file']['tmp_name'],
                            $dir . "xml/" . $_FILES['file']['name']);
                        }
                    }
                } else {
                    echo "Invalid file";
                }
            }
            if(!isset($filename)){
            ?>
            <form enctype="multipart/form-data" action="" method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="100000"/>
                Choose a file to upload:
                <input name="file" type="file" /><br/>
                <input type="submit" value="Upload Prescription"/>
            </form>
            <?php
            } else if(isset($filename) && !$exists){ 
            ?>

            <form action="" method="post" style="width: 300px;">
                <h1>Keep this prescription form?</h1>
                <input type="radio" name="delete" value="0" /> No<br/>
                <input type="radio" name="delete" value="1" checked/> Yes<br/><br/>
                <input type="hidden" value="<?php echo $filename ?>" name="filename"/>
                <input type="submit" value="Submit"/>
            </form>    
            <?php
            }
            ?>
        </div>
        <div id="rt">
            <?php if(isset($filename)){ 
                require_once "{$_ENV['root']}/model/xmlToSvg.php";
                convert_to_svg($filename);
            ?>
            <div id="svg" style="width:<?php echo getWidth($filename) . "px";?>">
                <h1 style="text-align: center;"><?php echo $filename; ?></h1>
                <embed src="pform/svg/<?php if(isset($filename)) echo $filename;?>.svg" 
                        width="<?php echo getWidth($filename);?>" 
                        height="<?php echo getHeight($filename);?>"
                        type="image/svg+xml"
                        pluginspage="http://www.adobe.com/svg/viewer/install/"/>
            </div>
            <?php } ?>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>
<?php
if(isset($_POST['delete'])){
    if($_POST['delete'] == "0"){
        unlink($_ENV['root'] . "pform/xml/" . $_POST['filename'] . ".xml") or die("OOPS");
        unlink($_ENV['root'] . "pform/svg/" . $_POST['filename'] . ".svg") or die("OOPS");
    }
}
?>