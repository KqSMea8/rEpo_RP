<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAdjustment.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv_tax.class.php");

	$objItem=new items();
	$objTax=new tax();
	

	$RedirectURL = "viewAdjustment.php?curP=".$_GET['curP'];

	$EditUrl = "editAdjustment.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 

	 if(!empty($_GET['view'])){
		 $arryAdjustment = $objItem->ListingAdjustment($_GET['view'],'','','','');
                 
               
                 //$TotalQty=$arryAdjustment[0]['total_adjust_qty'];
                 //$TotalValue=$arryAdjustment[0]['total_adjust_value'];
                 
		$adjID   = $arryAdjustment[0]['adjID'];	
		if($adjID>0){
			$arryAdjustmentItem = $objItem->GetAdjustmentStock($adjID);
			$NumLine = sizeof($arryAdjustmentItem);
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


