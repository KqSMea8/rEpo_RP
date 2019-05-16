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

	
	

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Email";
	
	$RedirectURL = "flaggedEmail.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	

	$EditUrl = "flaggedEmail.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 
 
        if(isset($_POST['DeleteButton']))
        {
             CleanPost(); 
             
             foreach($_POST['emailID'] as $key=>$emailuniqueId){
                 
                 if($emailuniqueId > 0){
                     
                    echo  $emailuniqueId."<br>";
                     
                       $objImportEmail->GoToTrashCan($emailuniqueId);  
                 }
                 
                 $_SESSION['TrashCanMsg']="Email deleted Successfully";
                 
             }
                 
             
        }
        
        
        $EmailListId=$objImportEmail->GetEmailListId($_SESSION[AdminID],$_SESSION[CmpID]);
        //start checking ownerEmailId and their active email id
        if($_SESSION['AdminType']!='admin')
        {
           //$empEmailId=$objImportEmail->GetAdminEmailId($_SESSION['AdminID'],$_SESSION['CmpID']);
           $OwnerEmailId=$_SESSION['EmpEmail'];
                
        }
        
        else {
              $OwnerEmailId=$_SESSION['AdminEmail'];
                 
        } 
        //end checking ownerEmailId and their active email id
        
        if(isset($_GET['flag_id']) && !empty($_GET['flag_id']) && ($_GET['flag_id']> 0))
        {
            
            $objImportEmail->ChangeFlagStatus($_GET['flag_id']);
            $RedirectURL = "flaggedEmail.php?curP=".$_GET['curP'];
            header('location:'.$RedirectURL);
            exit;
        }
        
        
        $Config['RecordsPerPage'] = $RecordsPerPage;
        if(empty($_GET['sortby']) && empty($_GET['key']))
        {
           /*********Get Email Data***********/
          $arrySentItems = $objImportEmail->FlaggedEmails($OwnerEmailId,'',$EmailListId[0][EmailId]);
          /*********Count Records************/
            $Config['GetNumRecords']=1;
            $arryCount = $objImportEmail->FlaggedEmails($OwnerEmailId,'',$EmailListId[0][EmailId]);
            $num=$arryCount[0]['NumCount'];
          
        }else {
         /*********Get Email Data***********/
         $arrySentItems = $objImportEmail->FlaggedEmailsWithSearch($OwnerEmailId,'',$EmailListId[0][EmailId],$_GET['sortby'],$_GET['key']);
         /*********Count Records************/
            $Config['GetNumRecords']=1;
            $arryCount = $objImportEmail->FlaggedEmailsWithSearch($OwnerEmailId,'',$EmailListId[0][EmailId],$_GET['sortby'],$_GET['key']);
            $num=$arryCount[0]['NumCount'];
         
        }
         $pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	
        require_once("../includes/footer.php"); 

        ?> 
