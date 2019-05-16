<?php   
	$HideNavigation = 1; 
	include_once("../includes/header.php");
        require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/warehouse.class.php");
      	include_once("language/english.php");
	$ModuleName 	= 	"Batch Mgmt";
	$objWarehouse   =   	new warehouse();
        $objSale	=   	new sale();

	$AutoPostToGlAR = $objConfigure->getSettingVariable('AutoPostToGlAr');

	if($_POST)
	{
		if($_GET['active_id'] && !empty($_GET['active_id'])){
		     $_SESSION['mess_batch'] = BATCH_STATUS;
		     

			if($_POST['Close']=='Batch Close' && ($_POST['emailInvoice']==1 || $_POST['printInvoice']==1))
			{    				
				$arr = $objWarehouse->changeBatchStatus($_GET['active_id']);				
				/********************************
				if($AutoPostToGlAR=="1"){
					require_once($Prefix."classes/item.class.php");
					require_once($Prefix."classes/finance.report.class.php");
					require_once($Prefix."classes/finance.account.class.php");
					require_once($Prefix."classes/finance.journal.class.php");
					require_once($Prefix."classes/finance.transaction.class.php");
					$objItem=new items();
					$objBankAccount = new BankAccount();
					$objReport = new report();
					$objTransaction=new transaction();
					foreach($arr as $key => $values) {
						$PostedOrderID = $values["orderID"];
						include("../includes/AutoPostToGlArInvoice.php");
					}
				}
				/********************************/	
				 
			}
				if($_POST['printInvoice']==1 && $_POST['emailInvoice']==1)
				{
					echo "<script type=\"text/javascript\">
					window.open('http://".$_SERVER['SERVER_NAME']."/erp/admin/pdfWarehousehtml.php?batchId=".$_POST['batchId']."&print=print', '_blank')
					</script>";
					echo "<script type=\"text/javascript\">
					location.href = 'http://".$_SERVER['SERVER_NAME']."/erp/admin/batchshipmentpdf.php?batchId=".$_POST['batchId']."&email=email';
					</script>";
				}
				elseif($_POST['printInvoice']==1)
				{				
					echo "<script type=\"text/javascript\">
					window.open('http://".$_SERVER['SERVER_NAME']."/erp/admin/pdfWarehousehtml.php?batchId=".$_POST['batchId']."&print=print', '_blank')
					</script>";
				}
				elseif($_POST['emailInvoice']==1)
				{				
					echo "<script type=\"text/javascript\">
					location.href = 'http://".$_SERVER['SERVER_NAME']."/erp/admin/batchshipmentpdf.php?batchId=".$_POST['batchId']."&email=email';
					</script>";
				}
				//exit(header("Location:http://".$_SERVER['SERVER_NAME']."/erp/admin/batchshipmentpdf.php"));

			//}
		  }


	}
       	require_once("../includes/footer.php"); 	 
?>


