<?php 
	/**************************************************/
	if($_GET['pop']==1)$HideNavigation = 1;
	$ThisPageName = 'viewRecurringInvoice.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();


	$module = 'Invoice';
	$ModuleName = "Recurring ".$module;
       

	$RedirectURL = "viewRecurringInvoice.php?type=".$_GET['type'];


	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID"; $PrefixSale = "IN";  $NotExist = NOT_EXIST_INVOICE;
	

	 if ($_POST) {	 CleanPost();		
		if(!empty($_POST['EntryType'])) {
			$objSale->UpdateInvoiceRecurring($_POST);
			$_SESSION['mess_rec_inv'] = INVOICE_REC_UPDATED;	
			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';	
			//header("Location:".$RedirectURL);
			exit;
		 } 
	}
		
	 $ErrorMSG = '';
	 $EditRecurringAmount = '';
	if(!empty($_GET['edit'])){
            	if(!empty($_GET['id'])){
			$arrySale = $objSale->GetSalesOrderItem($_GET['id'],'');
			$arryInvoice = $objSale->GetSale($_GET['edit'],'',$module);
			$arrySale[0]["PaymentTerm"] = $arryInvoice[0]["PaymentTerm"];
		}else{
			$arrySale = $objSale->GetSale($_GET['edit'],'',$module);
                }
		$OrderID   = $arrySale[0]['OrderID'];	
                

		/*****************/
		if($Config['vAllRecord']!=1){
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/

		if($OrderID>0){
			 
				if(!empty($_GET['id'])){
					if($arryInvoice[0]['Module']=="Invoice" && ($arryInvoice[0]['PostToGL']=="1" || $arryInvoice[0]['NoUse']=="1")){
						 $EditRecurringAmount = '1';
					}
				}


		}else{
			$ErrorMSG = $NotExist;
		}
	}
				
	//$ErrorMSG = UNDER_CONSTRUCTION; 
 
	require_once("../includes/footer.php"); 	 
?>


