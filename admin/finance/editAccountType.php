<?php
	/**************************************************/
	$ThisPageName = 'viewAccountType.php'; $EditPage = 1;
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
        
            
		$AccountTypeID = isset($_GET['edit'])?$_GET['edit']:"";	
		$ListUrl = "viewAccountType.php?curP=".$_GET['curP'];
		$ModuleName = "Account Type";
		
		 
                
		if(!empty($AccountTypeID)){
			$_GET['AccountTypeID'] = (int)$AccountTypeID;
		        $arryAccountType = $objBankAccount->getAccountType($_GET);

		        	
		  
		}
                
            

		if(!empty($_GET['del_id'])){
			$_SESSION['mess_account_type'] = $ModuleName.REMOVED;
			$objBankAccount->RemoveAccountType($_GET['del_id']);
			header("location:".$ListUrl);
			exit;
		}
        
		if(!empty($_GET['active_id'])){
			$_SESSION['mess_account_type'] = $ModuleName.STATUS;
			//echo "=>".$_SESSION['mess_account_type'];exit;
			$objBankAccount->changeAccountTypeStatus($_GET['active_id']);
			header("location:".$ListUrl);
		}
	
		
 	if (is_object($objBankAccount)) {
            
            if ($_POST) {
			     CleanPost();
                if (!empty($AccountTypeID)) {
				  if(empty($_POST['AccountType'])) {
					 $_SESSION['mess_account_type'] = FILL_ALL_MANDANTRY_FIELDS;
					 header("Location:editAccountType.php?edit=".$AccountTypeID."&curP=".$_GET['curP']."");
	                                 exit;
					}else{
						$_SESSION['mess_account_type'] = $ModuleName.UPDATED;
						/******************************/
						 CleanPost();
						/******************************/
						$objBankAccount->updateAccountType($_POST);
						
						 }

                       }else{
					   
					   if(empty($_POST['AccountType'])) {
							 $errMsg = FILL_ALL_MANDANTRY_FIELDS;
							 $_SESSION['mess_account_type'] = FILL_ALL_MANDANTRY_FIELDS;
							 header("Location:editAccountType.php");
	                        			 exit;
							
						}else{
					  
							/******************************/
							 CleanPost();
							/******************************/

							$_SESSION['mess_account_type'] = $ModuleName.ADDED;
							$AccountTypeID = $objBankAccount->addAccountType($_POST);
						
							
					      }
					   } 
                       
                       
                      header("Location:".$ListUrl);
	               exit;
				
            }

         }
		
   require_once("../includes/footer.php"); 
 
 
 ?>
