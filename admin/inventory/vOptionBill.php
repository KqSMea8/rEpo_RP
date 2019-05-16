<?php
         $ThisPageName = 'viewBOM.php';  $HideNavigation = 1;

	
	require_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
        require_once($Prefix."classes/bom.class.php");
	
	
        $objBom = new bom();
		

	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
	
                
                if(!empty($_GET['optionID'])){
		 $arryOption = $objBom->ListOptionBill($_GET);  
		$optionID   = $arryOption[0]['optionID'];
                $bomID   = $arryOption[0]['bomID'];	
		if($optionID>0){
			$arryBOMItem = $objBom->GetBOMStock($bomID,$optionID);
			$NumLine = sizeof($arryBOMItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}
		

		

             




	
if(empty($NumLine)) $NumLine = 1;
	
	
	
	require_once("../includes/footer.php"); 
	
?>
