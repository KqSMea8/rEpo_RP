<?php  
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewTransfer.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_tax.class.php");

	$objItem=new items();
	$objTax=new tax();
	

	$RedirectURL = "viewTransfer.php?curP=".$_GET['curP'];

	$EditUrl = "editTransfer.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 

	 if(!empty($_GET['view'])){
		 $arryTransfer = $objItem->GetTransfer($_GET['view']);
                 
               
                 //$TotalQty=$arryTransfer[0]['total_adjust_qty'];
                 //$TotalValue=$arryTransfer[0]['total_adjust_value'];
                 
		$transferID   = $arryTransfer[0]['transferID'];	
		if($transferID>0){
			$arryTransferItem = $objItem->GetTransferStock($transferID);
			$NumLine = sizeof($arryTransferItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}

	
				

	if(empty($NumLine)) $NumLine = 1;	


	


	require_once("../includes/footer.php"); 	 
?>


