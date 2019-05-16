<?
$qty_column = 'qty_shipped';

if(!empty($_GET['Module'])){
	switch($_GET['Module']){
		/**************SalesRMA*****************/
		/*******************************/
		case 'SalesRMA': 
			$RedirectURL = '../sales/vRma.php?view='.$_GET['view'];

			if(!empty($_GET['ShippedID'])){	
				require_once($Prefix . "classes/rma.sales.class.php");
				$objrmasale = new rmasale();

				$arrySale = $objrmasale->GetReturn($_GET['ShippedID'],'', '');
				$OrderID = $arrySale[0]['OrderID'];
				
				$satandaloneRma[0]['Address2To']=$arrySale[0]['ShippingAddress'];
				$satandaloneRma[0]['ShippingName'] =$arrySale[0]['ShippingName'];
				$satandaloneRma[0]['ShippingCompany'] =$arrySale[0]['ShippingCompany'];
				$satandaloneRma[0]['ShippingAddress'] =$arrySale[0]['ShippingAddress'];
				$satandaloneRma[0]['ShippingCity']=$arrySale[0]['ShippingCity'];
				$satandaloneRma[0]['ShippingState']=$arrySale[0]['ShippingState'];
				$satandaloneRma[0]['ShippingZipCode']=$arrySale[0]['ShippingZipCode'];
				$satandaloneRma[0]['ShippingCountry']=$arrySale[0]['ShippingCountry'];
				$satandaloneRma[0]['ShippingMethod']=$arrySale[0]['ShippingMethod'];
				
			    	if($OrderID > 0) {
					$satandaloneRmaItem = $objrmasale->GetSaleItem($OrderID);

					$NumLine = sizeof($satandaloneRmaItem);
				}
				$qty_column = 'qty';
			}		    
			break;

		/*************PurchaseRMA******************/
		/*******************************/
		case 'PurchaseRMA':
			$RedirectURL = '../purchasing/vRma.php?view='.$_GET['view'];

			if(!empty($_GET['ShippedID'])){	
				require_once($Prefix . "classes/rma.purchase.class.php");
				$objPurchase = new purchase();

				$arryPurchase = $objPurchase->GetPurchaserma($_GET['ShippedID'], '', '');
				$OrderID = $arryPurchase[0]['OrderID'];
				/*******************************/
				$satandaloneRma[0]['Address2To']=$arryPurchase[0]['wAddress'];
				$satandaloneRma[0]['ShippingName'] =$arryPurchase[0]['ShippingMethod'];
				$satandaloneRma[0]['ShippingCompany'] =$arryPurchase[0]['wName'];
				$satandaloneRma[0]['ShippingAddress'] =$arryPurchase[0]['wAddress'];
				$satandaloneRma[0]['ShippingCity']=$arryPurchase[0]['wCity'];
				$satandaloneRma[0]['ShippingState']=$arryPurchase[0]['wState'];
				$satandaloneRma[0]['ShippingZipCode']=$arryPurchase[0]['wZipCode'];
				$satandaloneRma[0]['ShippingCountry']=$arryPurchase[0]['wCountry'];
				$satandaloneRma[0]['ShippingMethod']=$arryPurchase[0]['ShippingMethod'];
				/*******************************/
				if($OrderID > 0) {
					$satandaloneRmaItem = $objPurchase->GetPurchaseItemRMA($OrderID);
					$NumLine = sizeof($satandaloneRmaItem);
				}   
				$qty_column = 'qty'; 
			}
			break;
		/*************VendorPayment******************/
		/*******************************/
		case 'VendorPayment':
			$RedirectURL = '../finance/payVendor.php?edit='.$_GET['view'];
			break;
		/*******************************/
		/*******************************/
		 
		
	}
}



?>
