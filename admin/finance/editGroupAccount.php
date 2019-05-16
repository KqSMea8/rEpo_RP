<?php
	/**************************************************/
	$ThisPageName = 'viewAccount.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/finance.account.class.php");
        
        
           
  (!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
  
	$objCommon=new common();
	
	if (class_exists(BankAccount)) {
		$objBankAccount=new BankAccount();
	} else {
		echo "Class Not Found Error !! Bank Account Class Not Found !";
		exit;
	}
        
            
		$GroupID = (int)$_GET['edit'];	
		$_GET['del_id'] = (int)$_GET['del_id'];

		$ListUrl = "viewAccount.php?curP=".$_GET['curP'];
		$ModuleName = "Group Account";
		
		 
                
		
                
            

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
	
		
 	if (is_object($objBankAccount)) {
            
            if ($_POST) {
                
                 CleanPost();
                 $_POST['Status'] = 'Yes';
			 
                if (!empty($GroupID)) {
                    
                        
				  if(empty($_POST['GroupName'])) {
						$_SESSION['mess_bank_account'] = FILL_ALL_MANDANTRY_FIELDS;
						header("Location:editGroupAccount.php?edit=".$GroupID."&curP=".$_GET['curP']."");
						exit;
					}else{
						$_SESSION['mess_bank_account'] = $ModuleName.UPDATED;
						
                                                 
                                                
						$objBankAccount->updateGroupAccount($_POST);
                                                header("Location:editGroupAccount.php?edit=".$GroupID."&curP=".$_GET['curP']."");
						exit; 
					    }

                       }else{
                        
				    if(empty($_POST['AccountType']) || empty($_POST['GroupName'])) {
						 $errMsg = FILL_ALL_MANDANTRY_FIELDS;
						 $_SESSION['mess_bank_account'] = FILL_ALL_MANDANTRY_FIELDS;
						 header("Location:editGroupAccount.php");
                                                 exit;
						
					}else{					  
						
                                                //print_r($_POST);exit;
						$_SESSION['mess_bank_account'] = $ModuleName.ADDED;
						$GroupID = $objBankAccount->addGroupAccount($_POST);
                                                header("Location:editGroupAccount.php?edit=".$GroupID);
                                                exit;
						 
				      }
			 } 
                       
                      
                      header("Location:".$ListUrl);
	               exit;
				
            }

         }
	

	if(!empty($GroupID)){
	   $arryGroupAccount = $objBankAccount->getGroupAccountById($GroupID);
          
           
	   $DisabledBox = 'disabled';
	}	
    
	$_GET['Status'] = 'Yes';
        $arryAccountType = $objBankAccount->getAccountType($_GET);
        //$_GET['status'] = 'Yes';
        //$arryBankAccountList=$objBankAccount->getBankAccount($id,$_GET['status'],$_GET['key'],$_GET['sortby'],$_GET['asc']);

        
        
        
        
   require_once("../includes/footer.php"); 
 
 
 ?>
