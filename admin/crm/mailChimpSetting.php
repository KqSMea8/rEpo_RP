<?php

//ini_set('display_errors',1);
$FancyBox=1;
$ThisPageName = 'massmailSetting.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once($Prefix."classes/massmail.class.php");
$massmail = new massmail();
$accountdetail=  $massmail->Getmailchimpaccount();

//ini_set('display_errors',1);


if (!empty($_POST)) {
    
    if(!empty($_POST['mail_chimp_Api_Key'])){
        CleanPost();
       
        //echo '<pre>'; print_r($_POST);die;
        $massmail->AddmailchimpAccount($_POST);
        $_SESSION['message']='<div class="success">Account successfully added.</div>';
        header("location:mailChimpSetting.php");
         exit;
       
    }
    
}
if(!empty($_GET['AccountD_id'])){
    $massmail->DeleteAllDataAccount();
    $massmail->DeleteAllDataAccount1();
    $massmail->DeleteAllDataAccount2();
    $massmail->DeleteAllDataAccount3();
    $massmail->DeleteAllDataAccount4();
    $massmail->DeleteAllDataAccount5();
    $massmail->DeleteAllDataAccount6();
    
    
    $_SESSION['message']='<div class="success"> Account deleted successfully.</div>';
    header("location:mailChimpSetting.php");
     exit;
}

require_once("../includes/footer.php");
?>
