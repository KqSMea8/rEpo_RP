<?php 
	/**************************************************/
	if($_GET['pop']==1)$HideNavigation = 1;
	$ThisPageName = 'viewRecurringSO.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	$objSale = new sale();

	(!$_GET['module'])?($_GET['module']='Quote'):(""); 
	$module = $_GET['module'];

	/**************/
	$ModuleArray = array('Quote','Order'); 
	if(!in_array($_GET['module'],$ModuleArray)){
		die(INVALID_REQUEST);		 
	}
	/**************/


	$ModuleName = "Recurring ".$_GET['module'];
       

	$RedirectURL = "viewRecurringSO.php?module=".$module."&curP=".$_GET['curP'];


	if($module=='Quote'){	
		$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $PrefixSale = "QT"; 
		$UpdateMSG = SO_QUOTE_REC_UPDATED;  $AddMSG = SO_QUOTE_ADDED; $RemoveMSG = SO_QUOTE_REMOVED; $NotExist = NOT_EXIST_QUOTE; 
	}else{
		$ModuleIDTitle = "Sale Number"; $ModuleID = "SaleID"; $PrefixSale = "SO"; 
		$UpdateMSG = SO_ORDER_REC_UPDATED;  $AddMSG = SO_ORDER_ADDED; $RemoveMSG = SO_ORDER_REMOVED; $NotExist = NOT_EXIST_ORDER;
	}

	

	 if ($_POST) {	
		 	CleanPost();
		if(!empty($_POST['EntryType'])) {
			$objSale->UpdateSaleRecurring($_POST);
			$_SESSION['mess_rec_so'] = $UpdateMSG;	
			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';	
			//header("Location:".$RedirectURL);
			exit;
		 } 
	}
		

	if(!empty($_GET['edit'])){
            
		$arrySale = $objSale->GetSalesOrderItem($_GET['edit'],'');
                 
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
			//$ErrorMSG = '';
		}else{
			$ErrorMSG = $NotExist;
		}
	}
				
	//$ErrorMSG = UNDER_CONSTRUCTION; 

	require_once("../includes/footer.php"); 	 
?>


