<?php
session_start();
/* * *********************************************** */
$FancyBox = 1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;
/* * *********************************************** */


require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once(_ROOT . "/lib/mailchamp/src/config.php");


$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);

$RedirectURL = $ThisPageName;

$DbUniqueArray = array(
    "Lead" => "Lead",
    "Contact" => "Contact",
    "Customer" => "Customer"
);


if (isset($_POST['Submit'])) {
	CleanPost(); 
    $UserData = $massmail->getMailChaimpUserData($_POST);
    //echo '<pre>'; print_r($UserData['table']);die('gaaa');
    //$massmail->PR($UserData,1);
}

if (isset($_POST['save'])) {
	CleanPost(); 
    $chkval = $_POST['userCheckbox'];
    $comma_chk = implode(",", $chkval);
    $table = $_POST['table'];
    $id = $_POST['id'];
    $column = $_POST['column'];
    $userInfo = $massmail->getUserImport($comma_chk, $table, $id, $column);
    //echo '<pre>'; print_r($Mailchimp_Lists); die('user data end');
    $resutlsMess=array();
    foreach($userInfo as $values){
       
        $fname=$values['FirstName'];
        $lname=$values['LastName'];
        $email=$values['Email'];
        $id=$values['id'];
        $MsgUserInsert=$massmail->InsertUserMailChamp($MailchimSetting,$fname,$lname,$email,$group_Name,$cmpId,$Mailchimp_Lists,$id);
        array_push($resutlsMess,$MsgUserInsert);
        
    
    }
 //echo '<pre>';print_r($resutlsMess);die('hello');
 $success=$failed=0;
 foreach($resutlsMess as $values){
     
     if($values==1){
         ++$success;
         }
     else{
         ++$failed;
     }     
 }
    //echo "<h1> $success record inserted <br/> $failed record already exist</h1>";
    $_SESSION['message'] = "<div class='success'>$success record inserted <br/> $failed record already exist</div>";
}


include_once("../includes/footer.php");
?>
