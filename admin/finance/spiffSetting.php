<?php
/**************************************************/
	$EditPage = 1; $_GET['edit']=999;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/finance.class.php");
        require_once($Prefix."classes/finance.account.class.php");
        
        $objBankAccount= new BankAccount();
	
	$objCommon = new common();
	
          $ListUrl = "spiffSetting.php";
          $ModuleName = "Spiff Setting";
             
         
  	
 
		 
		 if(!empty($_POST)){
		               CleanPost();                                  
                            $_SESSION['mess_setting'] = $ModuleName.$MSG[102];
                            $objCommon->updateSpiffSettings($_POST);

                            header("location:".$ListUrl);
                            exit;
			
		}
                
        /*******************************************************************/
        $arrySpiffSettings = $objCommon->getSpiffSettings();
	if(empty($arrySpiffSettings[0]['SpiffID'])){
        	$arrySpiffSettings = $objConfigure->GetDefaultArrayValue('f_spiff');
	}
        $arryExpenseType = $objBankAccount->getBankAccount('','Yes','','','');	




        $arryBankAccount=$objBankAccount->getBankAccountForPaidPayment(); 

#pr($arryBankAccount,1);
        
        $arryPaymentTerm = $objConfigure->GetTerm('','1');
	$arryPaymentMethod = $objConfigure->GetAttribFinance('PaymentMethod','');
	$arryShippingMethod = $objConfigure->GetAttribValue('ShippingMethod','');
        
        /***************************************************************************************/
		
 

 require_once("../includes/footer.php"); 
 
 
 ?>
