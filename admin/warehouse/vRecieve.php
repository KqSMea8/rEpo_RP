<?php 
	/**************************************************/
	$ThisPageName = "viewRecieve.php";	
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/warehouse.recieve.order.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
	require_once($Prefix."classes/warehousing.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	$objCommon=new common();
	$objWrecieve = new wrecieve();
	$objWarehouse = new warehouse();
	$objSale = new sale();
	$objTax=new tax();


	$Module = "Return";
	$ModuleIDTitle = "Return Number"; $ModuleID = "RecieveID"; $PrefixSale = "RTN";  $NotExist = NOT_EXIST_ORDER;
	$RedirectURL = "viewRecieve.php?curP=".$_GET['curP'];

	
	
	/********************************************/
	 if(!empty($_GET['view'])){

		        $arrySale = $objWrecieve->GetShipSale($_GET['view'],'','');
             
				$OrderID = $arrySale[0]['OrderID'];
			     $ref = 1;
				if($OrderID>0){
					$RecieveSo = $OrderID;
					$arrySaleItem = $objWrecieve->GetShipSaleItem($OrderID);
					
					$NumLine = sizeof($arrySaleItem);
					$arryInbound[0]['transaction_ref'] = $arrySaleItem[0]['SaleID'];
					$SaleID = $arrySale[0]['SaleID'];
				
				}else{
					$ErrorMSG = NOT_EXIST_RETURN;
				}
		$ModuleName = "View ".$Module;
		$HideSubmit = 1;
	}
	
		

	
	
	/*******************************************/
	
	

   /*******************************************/
	if(empty($NumLine)) $NumLine = 1;	
	$arrySaleTax = $objTax->GetTaxRate('2');
    
  /********************************************/
	require_once("../includes/footer.php"); 	 
?>


