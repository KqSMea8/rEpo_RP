<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewAssemble.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/inv_tax.class.php");
        require_once($Prefix."classes/item.class.php");

	$objBom=new bom();
	$objTax=new tax();
        $objItem = new items();
	

	$RedirectURL = "viewAssemble.php?curP=".$_GET['curP'];

	$EditUrl = "editAssemble.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 

	 if(!empty($_GET['view'])){
		 $arryBOM = $objBom->ListAssemble($_GET['view'],'','','','');
                 
               
                 //$TotalQty=$arryBOM[0]['total_adjust_qty'];
                 //$TotalValue=$arryBOM[0]['total_adjust_value'];
                 $arrayItem = $objItem->checkItemSku($arryBOM[0]['Sku']);
		$bomID   = $arryBOM[0]['asmID'];	
		if($bomID>0){
			$arryBOMItem = $objBom->GetAssembleStock($bomID);
			$NumLine = sizeof($arryBOMItem);
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


