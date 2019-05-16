<?php    $HideNavigation = 1;
	include_once("../includes/header.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/warehouse.class.php");
      	include_once("language/english.php");
	include_once("includes/FieldArray.php");
	$ModuleName 	= 	"Batch Mgmt";
	$objWarehouse   =   	new warehouse();
        $objSale	=   	new sale();
        
	
	if(!empty($_POST))
	{
		(empty($_POST['frbatchId']))?($_POST['frbatchId']=""):("");


		$RedirectURL 	= 	"movebatchInvoice.php?batchId=".$_POST['frbatchId'];

		if($_POST['Move'])
		{
			$arryBatch 	=	$objWarehouse->ListBatches('','Open',$_POST['batchId']);			
			$MoveIds	= 	implode(',',$_POST['moveto']);
		}
		
		
		if($_POST['Save'])
		{	
			if($_POST['invoiceIds'])
			{
			        $save	=	$objSale->moveInvoicesto($_POST['batchId'],$_POST['invoiceIds'],$_POST['frbatchId']);
			        $_SESSION['mess_batch'] = BATCH_MOVE;
		        	exit(header("Location:".$RedirectURL));
			}else{
                                $_SESSION['mess_batch'] = BATCH_LIST;
                                exit(header("Location:".$RedirectURL));
                        }
		}



	}else{        
       
		$objSale	=	new sale();
		$EntriesArr	=  	$objSale->ListbatchEntries($_GET['batchId']);
	}
       	require_once("../includes/footer.php"); 	 
?>


