<?php
	/**************************************************/
	$ThisPageName = 'viewTransfer.php'; $EditPage = 1;
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
        
		$TransferID = isset($_GET['edit'])?$_GET['edit']:"";	
		$ListUrl = "viewTransfer.php?curP=".$_GET['curP'];
		$ModuleName = "Transfer";
		
		 //Get Bank Account
                $arryBankAccount=$objBankAccount->getBankAccountForTransfer();   

		if(!empty($_GET['del_id'])){
			$_SESSION['mess_transfer'] = $ModuleName.REMOVED;
			$objBankAccount->RemoveTransfer($_GET['del_id']);
			header("location:".$ListUrl);
			exit;
		}         
		
		
 	if (is_object($objBankAccount)) {
            if ($_POST) {

					/******************************/
						CleanPost();
					/******************************/
					   if($_POST['TransferFrom'] == $_POST['TransferTo'] || empty($_POST['TransferFrom']) || empty($_POST['TransferTo']) || empty($_POST['TransferAmount']) || ($_POST['TransferAmount'] == "0.00")) {
					          
							 $errMsg = FILL_ALL_MANDANTRY_FIELDS;
							 $_SESSION['mess_transfer'] = FILL_ALL_MANDANTRY_FIELDS;
							 header("Location:editTransfer.php");
	                        			 exit;
							
						}else{
					  
							
							if($TransferID > 0){
								$_SESSION['mess_transfer'] = TRANSFER_MSG;
								$objBankAccount->UpdateTransfer($_POST);
								header("Location:viewTransfer.php");
			                			exit;
							}else{
								$_SESSION['mess_transfer'] = TRANSFER_MSG;
								$objBankAccount->addTransfer($_POST);
								header("Location:viewTransfer.php");
			                			exit;	
							 }
						
					        }
 
                                       
                   
            }

         }
		
   $arryAccountType = $objCommon->GetAttribValue('AccountType','');
   require_once("../includes/footer.php"); 
 
 
 ?>
