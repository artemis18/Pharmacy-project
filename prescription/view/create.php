<?php require_once("control/validsession.php"); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("button#btn_patient").click(function(){
            getPatient();
        });
        $("button#btn_endorsement").click(function(){
            getEndorsement();
        });
        $("button#btn_prescriber").click(function(){
            getPrescriber();
        });
        $("button#btn_layout").click(function(){
            getLayout();
        });
    });
</script>     


<div id="create_container">
    <div id="header"></div>
    
    <div id="inner_menu">
        <ul>
            <li><a href="?page=create&amp;i=prescription">Prescription</a></li>
            <li><a href="?page=create&amp;i=patient">Patient</a></li>
            <li><a href="?page=create&amp;i=endorsement">Endorsement</a></li>
            <li><a href="?page=create&amp;i=drug">Drug</a></li>
            <li><a href="?page=create&amp;i=prescriber">Prescriber</a></li>
            <li><a href="?page=create&amp;i=test">Test</a></li>
            <li><a href="?page=create&amp;i=groups">Groups</a></li>
        </ul>
        <hr/>
        <ul>
            <li><a href="?page=create&amp;i=upload">Upload layout</a></li>
            <li><a href="?page=create&amp;i=create_layout">Create layout</a></li>
        </ul>
    </div>
    <div style="float: left;" id="right_content">
        <?php
            if(isset($_GET['i'])){
                require_once("create/{$_GET['i']}.php");
            }
        ?>
    </div>
    <div style="clear: both;"></div>
</div>