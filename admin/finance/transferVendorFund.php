<?php 
	$HideNavigation = 1;
	require_once("../includes/header.php");
	require_once($Prefix."classes/finance.account.class.php");
	require_once($Prefix."classes/finance.class.php");
	require_once($Prefix."classes/supplier.class.php");
        $objBankAccount=new BankAccount();
        $objCommon = new common();
	$objSupplier=new supplier();

	$SuppID   = (int)$_GET['SuppID'];
	$OrderID   = (int)$_GET['OrderID'];
	$RefNo = $_GET['Ref'];
	$RedirectURL = "transferVendorFund.php?SuppID=".$SuppID;

	if(!empty($SuppID)) {
		$arrySupplier = $objSupplier->GetSupplier($SuppID ,'','');
			
		if(empty($arrySupplier[0]['SuppID'])){
			$ErrorMsg = NOT_EXIST_SUPP;
		}else{
			if($OrderID>0){
				$RefNo='';
			}
			$arryTransfer = $objBankAccount->GetVendorTransfer($TransferID,$OrderID,$RefNo);
			$TransferID = $arryTransfer[0]['TransferID'];
		}
	}else{
		$ErrorMsg = INVALID_REQUEST;
	}


	/*************************/
	if($_POST){
		CleanPost();
		if(empty($_POST['PaidAmount']) || empty($SuppID) ||  ($_POST['PaidAmount'] == '0') || ($_POST['PaidAmount'] != $_POST['total_payment'])
                                        || ($_POST['PaidAmount'] > $_POST['totalOpenBalance'])) {
			$_SESSION['mess_transfer'] = ERROR_IN_PAY_INVOICE;
			header("Location:".$RedirectURL);
			exit;
		}else{	
			$_POST['OrderID'] = $OrderID;
			$_POST['TransferFrom'] = $arrySupplier[0]['SuppCode'];
			$_POST['TransferTo'] = $_POST['SuppCode'];
	

			if(!empty($TransferID)){
				$_POST['ReferenceNo'] = $arryTransfer[0]['ReferenceNo'];
				$objBankAccount->UpdateVendorTransferInfo($_POST);
			}else{ 

				$TransferPrefix = $objCommon->getSettingVariable('TRANSFER_PAYMENT_PREFIX');			
				$_POST['ReferenceNo'] = $TransferPrefix.rand(999,9999999999999);
				$objBankAccount->AddVendorTransferInfo($_POST);
			}
			$TransferFundLink = "transferVendorFund.php?SuppID=".$SuppID."&OrderID=".$OrderID."&Ref=".$_POST['ReferenceNo'];
			echo '<script language="JavaScript1.2" type="text/javascript">
			window.parent.document.getElementById("FundTransferRef").value="'.$_POST['ReferenceNo'].'";
			window.parent.document.getElementById("TransferFundLink").href="'.$TransferFundLink.'";
			parent.jQuery.fancybox.close();
			</script>';
		}
		
	}
	/*************************/





	//$ErrorMsg = UNDER_MAINT;

        $arryVendorList=$objBankAccount->getVendorList();   
     
	$arryBankAccount=$objBankAccount->getBankAccount('','Yes','','','');	            
 
	require_once("../includes/footer.php"); 	
?>


