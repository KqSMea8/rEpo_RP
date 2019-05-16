<?php 
/**************************************************************/
$ThisPageName = '';   
$EditPage = 1;
if(!empty($_GET['pop']))$HideNavigation = 1;
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

	$_GET['ViewId'] = (int)$_GET['ViewId'];
	$_GET['emailNo'] = (int)$_GET['emailNo'];
	

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Email";
	
	$RedirectURL = "viewImportEmailId.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	

	$EditUrl = "editImportEmailId.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 


        /*
	$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 
         * 
         */
        
        
        
        //start checking ownerEmailId and their active email id
        if($_SESSION['AdminType']!='admin')
        {
            //$empEmailId=$objImportEmail->GetAdminEmailId($_SESSION['AdminID'],$_SESSION['CmpID']);
             $OwnerEmailId=$_SESSION['EmpEmail'];
           
              $activeData=mysql_query("select * from importemaillist where DefalultEmail=1 and status=1 and AdminID=".$_SESSION['AdminID']);
              $count_num=mysql_num_rows($activeData);
              if($count_num > 0)
              {
                 $activeDataEmailID=mysql_fetch_array($activeData);
                 $activeDataEmailID[EmailId]; 
              }
                        
        }
        
        else {
               $OwnerEmailId=$_SESSION['AdminEmail'];
              
              
              $activeData=mysql_query("select * from importemaillist where DefalultEmail=1 and status=1 and AdminID=".$_SESSION['AdminID']);
              $count_num=mysql_num_rows($activeData);
              if($count_num > 0)
              {
                 $activeDataEmailID=mysql_fetch_array($activeData);
                 $activeDataEmailID[EmailId]; 
              }
              
        } 
        //end checking ownerEmailId and their active email id
        
         
        
        if(isset($_POST[Submit]))
        {

         
	/*******************/
	$mailcontent = addslashes($_POST['mailcontent']);
	CleanPost(); 
	$_POST['mailcontent'] = $mailcontent;
	/*******************/
           
            
            $objImportEmail->sendEmailToUser($_POST);
            $_SESSION['mess_emailSent'] = 'Email has been sent successfully';
            unset($_SESSION['attcfile']);
            
            $RedirectURL = "viewImportedEmails.php?EmailSentStatus=SentYes";
			if($_GET['pop'] !=1){
            header('location:'.$RedirectURL);
			}
        }
	
	 if(!empty($_GET['ViewId'])){
        	$arryComposeItems = $objImportEmail->editComposeMail($_GET['ViewId']);
        }
        
        if(!empty($_GET['emailNo'])){
        	$arryComposeItems = $objImportEmail->editComposeMail($_GET['emailNo']);
        }
        if(!empty($_GET['action']) && !empty($_GET['emailNo'])){
            
            
        	$arryReplyForwardMsg = $objImportEmail->getReplyForwardMsg($_GET['emailNo'],$_GET['action']);
        }
		
 
	require_once("../includes/footer.php"); 	 
?>
