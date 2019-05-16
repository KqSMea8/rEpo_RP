<?php 
require_once("includes/header.php");
include_once("includes/header_menu.php");

ValidateMemberSession($ThisPage);

if(!empty($Cid)){$arrayMyProfile = $objCustomer->getCustomerById($Cid);}

    if($arrayMyProfile[0]['Newsletters'] == "Yes")
    {
        $newsletter_yes = "checked";
    }
    else{
        $newsletter_no = "checked";
    }

if(!empty($_POST))
 {
    
   $objCustomer->addNewsletter($_POST);
   $_SESSION['successMsg'] = NEWSLETTER_MSG;
    header("location: newsletter.php");										
    exit;
 }
 

require_once("includes/footer.php"); 
?>