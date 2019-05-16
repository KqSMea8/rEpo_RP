<?php 
	$ThisPageName = ""; 
        include_once("../includes/header.php");
	//require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix . "classes/filter.class.php");
        require_once($Prefix . "classes/email.class.php");
        $objFilter = new filter();
        //(empty($_GET['module'])) ? ($_GET['module'] = "Email") : ("");
	$ModuleName = "Email";
	$objImportEmail=new email();
	$objCustomer=new Customer(); 
        
       

/* * **************************End Custom Filter*************************************** */
        /*
        $Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect();  
         */
        
        if(isset($_POST['MoveToFolder']) && !empty($_POST['MoveToFolder']))
        {
           CleanPost(); 
            
            foreach($_POST['emailID'] as $key=>$emailuniqueId){
                 
                 if($emailuniqueId > 0){
   
                      $objImportEmail->AssignFolderToEmail($emailuniqueId,$_POST['MoveToFolder']);
    
                 }
                 $FolderData=$objImportEmail->GetEmailFolderDetails($_POST['MoveToFolder']);
                 if($_POST['MoveToFolder']=='Spam') $FolderData[0]['FolderName']='Spam';
                 $_SESSION['TrashCanMsg']="Email moved to '".$FolderData[0]['FolderName']."' Successfully";
                 
             }
             
            $RedirectURL = "viewImportedEmails.php?curP=".$_GET['curP'];
            header('location:'.$RedirectURL);
            exit;
        }
        
        
        if(isset($_POST['DeleteButton']))
        {
             CleanPost(); 
             
             foreach($_POST['emailID'] as $key=>$emailuniqueId){
                 
                 if($emailuniqueId > 0){
                     
                       $objImportEmail->GoToTrashCan($emailuniqueId);  
                 }
                 
                 $_SESSION['TrashCanMsg']="Email deleted Successfully";
                 
             }
                 
             
        }
        
        if(isset($_POST['MarkRead']))
        {
             CleanPost(); 
              $cntemail=0;
             foreach($_POST['emailID'] as $key=>$emailuniqueId){
                 
                 if($emailuniqueId > 0){
                     
                       
                     
                        $cntemail++;
                       $objImportEmail->updateSendMailStatus($emailuniqueId);  
                 }
                 
                 if($cntemail > 1)
                 {
                  $_SESSION['TrashCanMsg']= $cntemail." conversations has been marked as read.";
                 }else {
                    $_SESSION['TrashCanMsg']="The conversation has been marked as read."; 
                 }
             }
                 
             
        }
        if(isset($_POST['MarkUnRead']))
        {
             CleanPost(); 
             $cntemail=0;
             foreach($_POST['emailID'] as $key=>$emailuniqueId){
                 
                 if($emailuniqueId > 0){
                     
                       //echo $emailuniqueId;continue;
                       $cntemail++;
                       $objImportEmail->MarkAsUnRead($emailuniqueId);  
                 }
                 
                 if($cntemail > 1)
                 {
                  $_SESSION['TrashCanMsg']= $cntemail." conversations has been marked as unread.";
                 }else {
                    $_SESSION['TrashCanMsg']="The conversation has been marked as unread."; 
                 }
                 
                 
             }
                 
             
        }
        if(isset($_GET['flag_id']) && !empty($_GET['flag_id']) && ($_GET['flag_id']> 0))
        {
            
            $objImportEmail->ChangeFlagStatus($_GET['flag_id']);
            $RedirectURL = "viewImportedEmails.php?curP=".$_GET['curP'];
            header('location:'.$RedirectURL);
            exit;
        }
        

         
        $EmailListId=$objImportEmail->GetEmailListId($_SESSION[AdminID],$_SESSION[CmpID]);
        $countExist=$objImportEmail->GetInboxEmailCount($EmailListId[0][id]);
        
        
         

        if(!empty($_GET['ownerId'])){            
	  	$ownerId = $_GET['ownerId'];
        }else if($EmailListId[0]['id'] > 0){
           	$ownerId =  $EmailListId[0]['id'];
        }else{            
            header("Location:viewImportEmailId.php");
            exit;
        }
         

	
	/*********Get Email Data***********/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryEmailsList=$objImportEmail->ListImportEmails($ownerId,$_GET['sortby'],$_GET['key']);
	/*********Count Records************/
	$Config['GetNumRecords'] = 1;	
        $arryCount=$objImportEmail->ListImportEmails($ownerId,$_GET['sortby'],$_GET['key']);	
	$num=$arryCount[0]['NumCount'];	
	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
	/*********************************/


	require_once("../includes/footer.php"); 	 
?>


