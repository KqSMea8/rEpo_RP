<?php 


/**************************************************************/
$HideNavigation=1;
$ThisPageName = 'viewImportEmailId.php'; $EditPage = 1;
/**************************************************************/
        
	include_once("../includes/header.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
	$objCommon=new common();
        $objImportEmail=new email();

	//$objContact=new contact();
	$objEmployee=new employee();
	$objCustomer=new Customer();  
	$ModuleName = "Folder";
	 

	 if(!empty($_GET['delete_id']) && ($_GET['delete_id'] > 0))
         {
             
              
             $EmailFolderDetails=$objImportEmail->DeleteEmailFolder($_GET['delete_id']);
             // $RedirectURL = "viewImportedEmails.php?curP=".$_GET['curP'];
	      $RedirectURL  = $_SERVER['HTTP_REFERER'];
             header('location:'.$RedirectURL);
	     exit;
             
         }
       
        
	 if($_POST) {
		CleanPost(); 
              
            	  if(empty($_POST['FolderID']))
                  {
                    
                    
                    $datar=$objImportEmail->AddEmailFolderName($_POST);
                    //$_SESSION['mess_folder'] = 'Folder Added Successfully';
                       
                  }else {
                      
                      
                       $datar=$objImportEmail->UpdateEmailFolderName($_POST);
                      // $_SESSION['mess_folder'] = 'Folder Updated Successfully';
                       
                  }
		
		echo '<script>window.parent.location.href="'.$_POST['Referer'].'";</script>';		
		//header('location:'.$RedirectURL);
	     	exit;
	 }
         

	 $EmailListData=$objImportEmail->GetEmailListId($_SESSION[AdminID], $_SESSION[CmpID]);	

         if(!empty($_GET['edit']) && ($_GET['edit'] > 0))
         {
             $EmailFolderDetails=$objImportEmail->GetEmailFolderDetails($_GET['edit']); 
         }
         

	
		
	
	require_once("../includes/footer.php"); 	 
?>
