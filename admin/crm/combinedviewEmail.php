<?php 
/**************************************************************/
$HideNavigation=1;
/**************************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/region.class.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
	$objCommon=new common();
        $objImportEmail=new email();

	
	

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Email";
	
        
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	  
         //start checking ownerEmailId and their active email id
        
        //end checking ownerEmailId and their active email id
        
        
        $UserEmailId=$_GET['emailId'];
        if(isset($_GET['ViewId']) && !empty($_GET['ViewId']))
        {
              
           $arrySentItems = $objImportEmail->CombinedViewEmail($UserEmailId,$_GET['ViewId'],$_GET['type']);
           
           $num=$objImportEmail->numRows();
           
           $objImportEmail->updateSendMailStatus($_GET['ViewId']);
        }
		
 
	require_once("../includes/footer.php"); 	 
?>
