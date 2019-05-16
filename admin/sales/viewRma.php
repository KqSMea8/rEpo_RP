<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/rma.sales.class.php");
	$objrmasale = new rmasale();

	$RedirectURL = "viewRma.php";
	$ModuleName = "RMA";
        $ModuleDepName='Sales'.$ModuleName;//bysachin
	if(!empty($_GET['so'])){
		$MainModuleName = "Returns for SO Number : ".$_GET['SaleID'];
		$RedirectURL = "viewRma.php?so=".$_GET['SaleID'];
	}

	/*------------- Amazon order by Sanjiv ----------------------*/
  		require_once($Prefix."classes/product.class.php");
	    $objProduct=new product();
  	   if($_GET['synctype'] == 'sync_amazon'){
		  $orderID = $objProduct->runReportForRMA($Prefix);
		  if(empty($_SESSION['mess_return']))  $_SESSION['mess_return'] =  "Amazon RMA is synced successfully.";
   		  header("location:viewRma.php?curP=".$_GET['curP']);
        exit;
  	   }
  	   
  	  if($_GET['synctype'] == 'sync_ebay'){
	      require_once($Prefix."classes/item.class.php");
	      $objProduct->EbayImportOrders($objRegion,$Prefix);
				header("location:viewRma.php?curP=".$_GET['curP']);
        exit;
  	   }
       /*------------------- End -------------------------------*/



//$SendUrl = "sendRMA.php?module=".$ModuleName."&curP=".$_GET['curP'];
$SendUrl = "sendRMA.php?module=".$ModuleName."&curP=".$_GET['curP'];
/**************Row color functionality added by nisha************************/       
 if($_POST) {
	CleanPost();
    if(sizeof($_POST['OrderID'] > 0)) {
        $Order = implode(",", $_POST['OrderID']);	 
        if(isset($_POST['RowColor']) && !empty($_POST['RowColor'])){
						if($_POST['RowColor']=='None') $_POST['RowColor']='';
						$_SESSION['mess_return'] = ROW_HIGHLIGHTED;
						$objrmasale->setRowColorSale($Order,$_POST['RowColor']);
header("location:".$RedirectUrl);
 
       //exit;
        }
      
       
    }
}       
/***************
	/*************************/	
	$Config['RecordsPerPage'] = $RecordsPerPage;
	$arryReturn=$objrmasale->ListSalesRma($_GET);

	/*******Count Records**********/	
	$Config['GetNumRecords'] = 1;
        $arryCount=$objrmasale->ListSalesRma($_GET);
	$num=$arryCount[0]['NumCount'];	

	$pagerLink=$objPager->getPaging($num,$RecordsPerPage,$_GET['curP']);


  	//$ErrorMSG = UNDER_CONSTRUCTION; // Disable Temporarly

	require_once("../includes/footer.php"); 	
?>
