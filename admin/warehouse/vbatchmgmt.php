<?php 	if(!empty($_GET['pop']))$HideNavigation = 1;
      	/**************************************************/
	$ThisPageName = 'viewbatchmgmt.php'; 
	/**************************************************/

	include_once("../includes/header.php"); 
	require_once($Prefix."classes/warehouse.class.php");
	require_once($Prefix."classes/warehouse.shipment.class.php");
        require_once($Prefix."classes/sales.quote.order.class.php");

        $Module		=	"Batch Management.php";
	$objwarehouse	=	new warehouse();
        $ModDepName='WhouseBatchMgt';//by sachin
$objShipment = new shipment();
	$RedirectURL 	= 	"viewbatchmgmt.php?curP=".$_GET['curP'];
	
        if(!empty($_GET['view'])) 
        {
            $batchArr	=  	$objwarehouse->ListBatches($_GET['view'],'','');
            $objSale	=	new sale();
            //$EntriesArr	=  	$objSale->ListbatchEntries($_GET['view']);
						$_GET['batch'] = 1;
						$_GET['batchid'] = $_GET['view'];
						/******Get Shipment Records***********/	
						$Config['RecordsPerPage'] = $RecordsPerPage;
						$EntriesArr=$objShipment->ListShipment($_GET);
						/**********Count Records**************/	
						$Config['GetNumRecords'] = 1;
									$arryCount=$objShipment->ListShipment($_GET);
						$num=$arryCount[0]['NumCount'];	
						$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);	
						/*************************************/	

			$ContSaleID	=  	$objShipment->CountSaleBatches($_GET['view']);
			$ContInvoiceID	=  	$objShipment->CountInvoiceBatches($_GET['view']);



        }    
        
	require_once("../includes/footer.php"); 	 
?>


