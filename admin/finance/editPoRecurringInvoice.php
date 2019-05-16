<?php 
	/**************************************************/
	if($_GET['pop']==1)$HideNavigation = 1;
	$ThisPageName = 'viewPoRecurringInvoice.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/purchase.class.php");
	$objPurchase = new purchase();

	 
	$ModuleName = "Recurring Invoice";
       

	$RedirectURL = "viewPoRecurringInvoice.php?curP=".$_GET['curP'];


	 $NotExist = NOT_EXIST_INVOICE;
	

	 if (!empty($_POST)) {	 
		CleanPost();		
		if(!empty($_POST['EntryType'])) {
			$objPurchase->UpdatePurchaseRecurring($_POST);
			$_SESSION['mess_recpo_inv'] = INVOICE_REC_UPDATED;	
			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';	
			//header("Location:".$RedirectURL);
			exit;
		 } 
	}
		

	if(!empty($_GET['edit'])){            
		$arryPurchase = $objPurchase->GetPurchase($_GET['edit'],'','Invoice');                 
		$OrderID   = $arryPurchase[0]['OrderID'];  
		      
 		if($OrderID>0){

			//Posted Gl Invoice
			if($arryPurchase[0]['Module']=="Invoice" && $arryPurchase[0]['PostToGL']=="1" && ($arryPurchase[0]['InvoiceEntry']=="2" || $arryPurchase[0]['InvoiceEntry']=="3") ){
				 $EditPoRecurringAmountGL = '1';
			}		 
			 
		}else{
			$ErrorMSG = $NotExist;
		}
	}
				
	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


