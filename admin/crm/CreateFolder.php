<?php 


/**************************************************************/
$HideNavigation=1;
$ThisPageName = 'viewLead.php?module=lead'; $EditPage = 1;
/**************************************************************/
        
	include_once("../includes/header.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
	$objCommon=new common();

	//$objContact=new contact();
	$objEmployee=new employee();
	$objCustomer=new Customer();  
	$ModuleName = "Folder";
	 
	 if(!empty($_GET['delete_id']) && ($_GET['delete_id'] > 0))
         {
             $EmailFolderDetails=$objConfig->DeleteFolder($_GET['delete_id']);
	      $RedirectURL  = $_SERVER['HTTP_REFERER'];
             header('location:'.$RedirectURL);
	     exit;
             
         }
       
        
	 if($_POST) {
		CleanPost(); 
              
            	  if(empty($_POST['FolderID']))
                  {
                    $datar=$objConfig->AddFolderName($_POST);
                  }else {
                       $datar=$objConfig->UpdateFolderName($_POST);
                  }
		echo '<script>window.parent.location.href="'.$_POST['Referer'].'";</script>';		
	     	exit;
	 }
         

	 //$EmailListData=$objFolder->GetEmailListId($_SESSION[AdminID], $_SESSION[CmpID]);	

         if(!empty($_GET['edit']) && ($_GET['edit'] > 0))
         {
             $EmailFolderDetails=$objConfig->GetFolderDetails($_GET['edit']); 
         }
         

	
		
	
	require_once("../includes/footer.php"); 	 
?>
