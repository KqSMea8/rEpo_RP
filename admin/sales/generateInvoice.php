<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewInvoice.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/sales.class.php");
	require_once($Prefix . "classes/item.class.php");

	$objSale = new sale();
	$objTax = new tax();
	$objItem = new items();
	$_GET['module']='Order';
	$module = $_GET['module'];
	$ModuleName = "Sale ".$_GET['module'];
	$RedirectURL = "viewInvoice.php?curP=".$_GET['curP'];
	$EditUrl = "editInvoice.php?edit=".$_GET["invoice"]."&curP=".$_GET["curP"]; 
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "SaleInvoiceID"; $PrefixSale = "IN";  $NotExist = NOT_EXIST_ORDER;

	if(!empty($_GET['invoice']) || !empty($_GET['so'])){
		$arrySale = $objSale->GetSale($_GET['invoice'],$_GET['so'],$module);
		
		$OrderID   = $arrySale[0]['OrderID'];	
		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}
				

	if(!empty($_POST['GenerateInVoice'])) {	
		$_POST['InvoiceID'] = $_POST['SaleInvoiceID'];
		/*****************/
		unset($_SESSION['mess_gen']);
		for($i=1;$i<=$_POST['NumLine'];$i++){			
			$ItemID = $_POST['item_id'.$i];
			$Sku = $_POST['sku'.$i];
			$Qty = $_POST['qty'.$i];
			$msg = '';			
			if($Qty>0 && !empty($Sku) && !empty($ItemID)){				
				$arryItem = $objItem->GetItemById($ItemID);				
				if($arryItem[0]['evaluationType']=='Serialized'){
					$NumSerial = $objSale->CountSkuSerialNo($Sku);
					/*$_GET['Sku']=$Sku;
					$arrySerial=$objItem->ListSerialNumber($_GET);
					$NumSerial = sizeof($arrySerial);*/

					if($Qty > $NumSerial){
						$msg = str_replace("[Sku]",$Sku,SERIALIZE_NUM_MSG);
						$msg = str_replace("[NumSerial]",$NumSerial,$msg);
						$msg = str_replace("[Qty]",$Qty,$msg);
						$_SESSION['mess_gen'] .= $msg;
					}
				}
			}
		}
		
		
		if(!empty($_SESSION['mess_gen'])){
			$_SESSION['mess_gen'] = INVOICE_NOT_GENERATED.'<br>'.$_SESSION['mess_gen'];
			
			$RedirectURL = "generateInvoice.php?so=".$_GET['so']."&invoice=".$_GET['invoice']; 
			header("Location:".$RedirectURL);
			exit;
		}
		
		/*****************/
		
		$order_id = $objSale->GenerateInVoice($_POST);
		$_SESSION['mess_Invoice'] = INVOICE_GENERATED_MESSAGE;
		$objSale->AddInvoiceItem($order_id, $_POST); 
		$RedirectURL = "viewInvoice.php";
		header("Location:".$RedirectURL);
		exit;
	 } 
				
				
	if(empty($NumLine)) $NumLine = 1;	


	$arrySaleTax = $objTax->GetTaxRate('1');
	
	$_SESSION['DateFormat']= $Config['DateFormat'];

	require_once("../includes/footer.php"); 	 
?>


