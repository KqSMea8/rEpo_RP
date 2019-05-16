<?php 
	if(!empty($_GET['pop']))$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewBOM.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	

	$objBom=new bom();
	
	

	$RedirectURL = "viewBOM.php?curP=".$_GET['curP'];

	 $EditUrl = "editBOM.php?edit=" . $_GET["view"] . "&curP=" . $_GET["curP"] ;
	$ViewUrl = "vBom.php?view=" . $_GET["view"] . "&curP=" . $_GET["curP"] ;
	

 

	 if(!empty($_GET['view'])){
		 $arryBOM = $objBom->ListBOM($_GET['view'],'','','','');
			if($arryBOM[0]['bill_option'] == 'Yes'){
			 $arryOption = $objBom->ListOptionBill($_GET);
			}
			
              
		$bomID   = $arryBOM[0]['bomID'];	
		if($bomID>0){
			$arryBOMItem = $objBom->GetBOMStock($bomID,'');
			$NumLine = sizeof($arryBOMItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}else{
		header("Location:".$RedirectURL);
		exit;
	}

	
				

		


	


	require_once("../includes/footer.php"); 	 
?>


