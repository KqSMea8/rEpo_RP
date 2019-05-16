<?php    
	include_once("../includes/header.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
	require_once($Prefix."classes/warehouse.class.php");
	include_once("language/english.php");
	include_once("includes/FieldArray.php");

	if(empty($_SESSION['batchmgmt'])){
		header("location:viewShipment.php");
		exit;
		}

	$ModuleName = "Batch Mgmt";
	$objShipment = new shipment();
	$objWarehouse   =   new warehouse();
	$objSale	=   new sale();
	$RedirectURL = "viewbatchmgmt.php?curP=".$_GET['curP'];
        
	(empty($_GET['Sale_srch']))?($_GET['Sale_srch']=""):("");


		  if($_GET['active_id'] && !empty($_GET['active_id'])){
		     $_SESSION['mess_batch'] = BATCH_STATUS;
		     $arr = $objWarehouse->changeBatchStatus($_GET['active_id']);
				   if(is_array($arr) && !empty($arr))
				   {    
				        $_SESSION['orderIds'] = $arr;
				        exit(header("Location:http://".$_SERVER['SERVER_NAME']."/erp/admin/batchInvoicepdf.php"));
				       
				   }
		     header("Location:".$RedirectURL);
		  }
        

         
		$Config['RecordsPerPage'] = $RecordsPerPage;
		if($_GET['Sale_srch']!=''){
		$Config['SaleID'] = $_GET['Sale_srch'];
		}

		$arryBatch =$objWarehouse->ListBatches('','','');
		$Config['GetNumRecords'] = 1;
		$arryCount=$objWarehouse->ListBatches('','','');
		$num=$arryCount[0]['NumCount'];	
		$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);
		/*****************************************************************************/
	
/****************************************************************************/






	require_once("../includes/footer.php"); 	 
?>


