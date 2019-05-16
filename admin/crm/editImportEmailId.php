<?php 
/**************************************************************/
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
	$ModuleName = "Email";
	$_GET['edit'] = (int)$_GET['edit'];

	$RedirectURL = "viewImportEmailId.php?module=".$_GET['module']."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="basic";

	$EditUrl = "editImportEmailId.php?edit=".$_GET["edit"]."&module=".$_GET['module']."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
        
        /*
        $Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
        */
         
        
	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_contact'] = 'Email ID has been deleted successfully';
                
		$objImportEmail->RemoveEmailId($_GET['del_id']);
		header("Location:".$RedirectURL);
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_contact'] = 'Email ID Status has been changed successfully';
                
		$objImportEmail->changeEmailIdStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
	}
        
        if($_GET['defaultEmail_id'] && !empty($_GET['defaultEmail_id'])){
		$_SESSION['mess_contact'] = 'Default Email ID has been changed successfully';
                
		$objImportEmail->updateDefaultEmailId($_GET['defaultEmail_id'],$_SESSION['AdminID']);
		header("Location:".$RedirectURL);
	}
        
        if($_GET['activeEmailId'] && !empty($_GET['activeEmailId'])){
		
                
		$succ_data=$objImportEmail->fetchEmailsFromServer($_GET['activeEmailId'],$_GET[mailImport],30);
                
                if($succ_data)
                {
                   $_SESSION['mess_contact'] = "Email Imported";  
                }
                else {
                     $_SESSION['mess_contact'] = "Username/Password is wrong or could not be connected, Please Try again";
                }
                
		header("Location:".$RedirectURL);
	}
	

	
	 if ($_POST) {
		CleanPost(); 
              
            	  if(empty($_POST['AddID']))
                  {
                     
                    
                    
                    $datar=$objImportEmail->AddImportEmailId($_POST);
                    
                    
                    
                    if($datar=='AlreadyExist')
                    {
                        
                       $_SESSION['mess_contact'] = 'User already exist.'; 
                       header("Location:viewImportEmailId.php");
                    }
                    else {
                         $_SESSION['mess_contact'] = 'Added Successfully'; 
                         header("Location:viewImportEmailId.php");
                        
                    }
                    
                    
                    
                     
                  }else {
                      
                      
                       $datar=$objImportEmail->UpdateImportEmailId($_POST); 
                       if($datar=='AlreadyExist')
                    {
                        
                       $_SESSION['mess_contact'] = 'Already Exists'; 
                       header("Location:viewImportEmailId.php");
                    }
                    else {
                         $_SESSION['mess_contact'] = 'Updated Successfully'; 
                         header("Location:viewImportEmailId.php");
                        
                    }    
                  }
		
		}
		

	if (!empty($_GET['edit'])) {
		$arryEmailId = $objImportEmail->GetEmailId($_GET['edit']);
		$AddID   = $_GET['edit'];	

                
                
                

		if(empty($arryEmailId [0]['id'])) {
                    
                       
                        echo "dfdfdf"; exit;
			header('location:'.$RedirectURL);
			exit;
		}
                
                
		
	
	}

		
	//$arryCustomer = $objCustomer->GetCustomer('','','Yes');

		
	if($arryEmailId [0]['status'] != ''){
		$ContactStatus = $arryEmailId [0]['status'];
	}else{
		$ContactStatus = 1;
	}				
		
	
	
	$_GET['Status']=1;$_GET['Division']=5;
	//$arryEmployee = $objEmployee->GetEmployeeList($_GET);
	//$arryLeadSource = $objCommon->GetCrmAttribute('LeadSource','');
	

			

	require_once("../includes/footer.php"); 	 
?>
