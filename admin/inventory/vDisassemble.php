<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewDisassembly.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/inv_tax.class.php");

	$objBom=new bom();
	$objTax=new tax();
	

	$RedirectURL = "viewDisassembly.php?curP=".$_GET['curP'];

	$EditUrl = "editDassemble.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]; 

	 if(!empty($_GET['view'])){
		 $arryBOM = $objBom->ListDisassemble($_GET['view'],'','','','');
		$bomID   = $arryBOM[0]['DsmID'];	
		if($bomID>0){
			$arryBOMItem = $objBom->GetDisassembleStock($bomID);
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


