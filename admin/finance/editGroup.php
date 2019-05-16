<?php
	/**************************************************/
	$ThisPageName = 'viewAccount.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
      
	$objCommon=new common();
	$objBankAccount=new BankAccount();
    
	$GroupID = (int)$_GET['edit'];	
	$_GET['del_id'] = (int)$_GET['del_id'];
	$_GET['active_id'] = (int)$_GET['active_id'];

	$ListUrl = "viewAccount.php";
	$ModuleName = "Group";


	if(!empty($_GET['del_id'])){
		$_SESSION['mess_bank_account'] = $ModuleName.REMOVED;
		$objBankAccount->RemoveGroupAccount($_GET['del_id']);
		header("location:".$ListUrl);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_bank_account'] = $ModuleName.STATUS;
		$objBankAccount->changeGroupAccountStatus($_GET['active_id']);
		header("location:".$ListUrl);
		exit;
	}


            
            if($_POST){
                
                 CleanPost();
                 $_POST['Status'] = 'Yes';
			 
                if (!empty($GroupID)) {
                    
                        
				  if(empty($_POST['GroupName'])) {
						$_SESSION['mess_bank_account'] = FILL_ALL_MANDANTRY_FIELDS;
						header("Location:editGroup.php?edit=".$GroupID."&curP=".$_GET['curP']."");
						exit;
					}else{
						$_SESSION['mess_bank_account'] = $ModuleName.UPDATED;
						
                                                 
                                                
						$objBankAccount->updateGroupAccount($_POST);
                                               // header("Location:editGroup.php?edit=".$GroupID."&curP=".$_GET['curP']."");
						header("location:".$ListUrl);						
						exit; 
					    }

                       }else{
                        
				    if(empty($_POST['AccountType']) || empty($_POST['GroupName'])) {
						 $errMsg = FILL_ALL_MANDANTRY_FIELDS;
						 $_SESSION['mess_bank_account'] = FILL_ALL_MANDANTRY_FIELDS;
						 header("Location:editGroup.php");
                                                 exit;
						
					}else{					  
						
                                                //print_r($_POST);exit;
						$_SESSION['mess_bank_account'] = $ModuleName.ADDED;
						$GroupID = $objBankAccount->addGroupAccount($_POST);
                                               // header("Location:editGroup.php?edit=".$GroupID);
						header("location:".$ListUrl);		
                                                exit;
						 
				      }
			 } 
                       
                      
                      header("Location:".$ListUrl);
	               exit;
				
            }


	

	if(!empty($GroupID)){
	   $arryGroup = $objBankAccount->getGroupAccountById($GroupID);
          
           
	   $DisabledBox = 'disabled';
	}	
    
	$_GET['Status'] = 'Yes';
        $arryAccountType = $objBankAccount->getAccountType($_GET);
      
        
   require_once("../includes/footer.php"); 
 
 
 ?>
