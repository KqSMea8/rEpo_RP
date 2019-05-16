<?php

//ini_set('display_errors',1);
$FancyBox=1;
$ThisPageName = 'massmailSetting.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");


//ini_set('display_errors',1);
$rais_error='';

if(isset($_GET['contE_id']))
{
    $c_Eid=$_GET['contE_id'];
    $res_contE=$cc->getContact(ACCESS_TOKEN,$c_Eid);
}

if (isset($_POST['add_setting'])) {
    //$action = "Getting Contact By Email Address";
    try {
        
                if($returnContact)$_SESSION['message']='<div class="success">User successfully added.</div>';
            } catch (Exception $ex) {
                echo '<span class="label label-important">Error ' . $action . '</span>';
                echo '<div class="container alert-error"><pre class="failure-pre">';
                print_r($ex->getErrors());
                echo '</pre></div>';
                die();
            }
            
            // update the existing contact if address already existed
        
            if($returnContact){$_SESSION['message']='<div class="success">User successfully updated.</div>';header("location:viewConstContactUser.php");}
        // catch any exceptions thrown during the process and print the errors to screen
}

require_once("../includes/footer.php"); 
?>