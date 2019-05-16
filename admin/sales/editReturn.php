<?php 
	/**************************************************/
	$ThisPageName = "viewReturn.php";	$EditPage = 1; $SetFullPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	$objSale = new sale();
	$objTax=new tax();

	$Module = "Return";
	$ModuleIDTitle = "Return Number"; $ModuleID = "ReturnID"; $PrefixSale = "RTN";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewReturn.php?curP=".$_GET['curP'];

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_return'] = RETURN_REMOVED;
		$objSale->RemoveReturn($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	 
	 
	if($_POST){
            	CleanPost();
       
	if(!empty($_POST['ReturnOrderID'])){   
		$OrderID = $objSale->ReturnOrder($_POST);
		$_SESSION['mess_return'] = RETURN_ADDED;
		header("Location:".$RedirectURL);
		exit;
	}else if(!empty($_POST['rtnID']) && ($_POST['Submit'] == "Save")){  
		$objSale->UpdateReturn($_POST);
		$_SESSION['mess_return'] = RETURN_UPDATED;
		header("Location:".$RedirectURL);
		exit;
	}
        
         /********************UPDATE SERIAL NUMBER*******************************************/
                
                        for($k=1;$k<=$_POST['NumLine'];$k++){

                               $serial_value = $_POST['serial_value'.$k];

                               $explodeSerialVal = explode(",",$serial_value);
                               $SerailSize = sizeof($explodeSerialVal);

                               for($j=0;$j<$SerailSize;$j++){

                                   $arraySerailData['serialNumber'] = trim($explodeSerialVal[$j]);
                                   $arraySerailData['warehouse'] = $_POST['wCode'];
                                   $arraySerailData['Sku'] = $_POST['sku'.$k];

                                   if($arraySerailData['serialNumber'] != ""){
                                       $objSale->addSerailNumberForReturn($arraySerailData);
                                   }
                               }



                       }
                
                /***********************END SERIAL NUMBER****************************************************/
        
        
        
        }
		
	if(!empty($_GET['edit']) && !empty($_GET['InvoiceID'])){
		$arrySale = $objSale->GetInvoice($_GET['edit'],$_GET['InvoiceID'],'Invoice');
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
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);

			$SaleID = $arrySale[0]['SaleID'];
			#$arryInvoiceOrder = $objSale->GetInvoiceOrder($SaleID);
			$TotalGenerateReturn = $objSale->GetQtyReturned($OrderID);
			if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']){
		      $HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			}
			
		}else{
			$ErrorMSG = NOT_EXIST_ORDER;
		}

		$ModuleName = "Add ".$Module;

	}else if(!empty($_GET['edit']) && !empty($_GET['rtn'])){
		$arrySale = $objSale->GetReturn($_GET['edit'],$_GET['rtn'],'Return');
		$OrderID   = $arrySale[0]['OrderID'];	
		$SaleID = $arrySale[0]['SaleID'];


		/*****************/
		if($Config['vAllRecord']!=1){	
			if($arrySale[0]['SalesPersonID'] != $_SESSION['AdminID'] && $arrySale[0]['AdminID'] != $_SESSION['AdminID']){
			header('location:'.$RedirectURL);
			exit;
			}
		}
		/*****************/


		if($OrderID>0){
			$arrySaleItem = $objSale->GetSaleItem($OrderID);
			$NumLine = sizeof($arrySaleItem);
			
			$TotalGenerateReturn = $objSale->GetQtyReturned($OrderID);
			if($TotalGenerateReturn[0]['QtyInvoiced'] == $TotalGenerateReturn[0]['QtyReturned']){
		      $HideSubmit = 1;
			  $RtnInvoiceMess = SO_ITEM_TO_NO_RETURN;
			}
			
		}else{
			$ErrorMSG = NOT_EXIST_RETURN;
		}
		$ModuleName = "Edit ".$Module;
		$HideSubmit = 1;
	}else{
		$ErrorMSG = SELECT_SO_FIRST;
		$ModuleName = "Add ".$Module;
	}
				

	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('1');


	require_once("../includes/footer.php"); 	 
?>


