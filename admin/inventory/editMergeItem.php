<?php

			/**************************************************/
				$ThisPageName = 'viewMergeItem.php'; 
			/**************************************************/
	
			
			require_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
			require_once($Prefix."classes/bom.class.php");
		
			require_once($Prefix . "classes/inv.condition.class.php");
	
			$objCondition = new condition(); // Condition class object
			$objItem = new items();          // item class object
			$objBom=new bom();               // Bom class object

 

			$RedirectURL = "viewMergeItem.php?curP=".$_GET['curP']."";
			$ModuleName  = "Parent Item";
			        
			$EditUrl = "editMergeItem.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"].""; 
			$pageUrl ="editMergeItem.php";
			$ref_code=$loadAssemble=$TaxShowHide='';


		   /************ Delete Merge Item****************/ 
				if($_GET['del_id'] && !empty($_GET['del_id'])){
							$objBom->RemoveMergeItem($_GET['del_id']);
							$_SESSION['mess_asm'] = 'MergeItem'.ADJ_REMOVED;
							header("location: ".$RedirectURL);
				}
			 /************End  Delete Merge Item****************/ 

	
	

      /************ edit Update Merge Item****************/       
			if(!empty($_GET['edit']) && $_GET['edit']!=''){
					$arryMergeItem = $objBom->ListMergeItem($_GET['edit'],'','','','');



					$BomID = $arryMergeItem[0]['id'];
					$bID   = $arryMergeItem[0]['id'];	
					$arrayItem = $objItem->checkItemSku($arryMergeItem[0]['Sku']);
					if($bID>0){
								$arryBomItem = $objBom->GetMergeItemStock($bID);
								$loadMergeItem = 0;
								$NumLine = sizeof($arryBomItem);
					}else{
				        $ErrorMSG = $NotExist;
					}
$disSubItem =  '';
			}else{

$disSubItem =  'display:none;';
}
			/************ edit Update Merge Item****************/ 

		
			/************ Add Update Merge Item****************/ 
	if ($_POST) {

		CleanPost();
		if (!empty($_POST['editID'])) {
					$objBom->UpdateMergeItem($_POST);
					$editID = $_POST['editID'];
					$objBom->AddUpdateMergeItem($editID, $_POST);
					$_SESSION['mess_asm'] = 'Assembly Item'.ADJ_UPDATED;
		}else {	 
					$editID = $objBom->AddMerge($_POST); 
					$objBom->AddMergeItem($editID, $_POST);                   
					$_SESSION['mess_asm'] = ' Item Merge'.ADJ_ADDED;
		}

		header("Location:".$RedirectURL);
		exit;
	}
			/************ End Add Update Merge Item****************/ 


if(empty($arryMergeItem)){    
	$arryMergeItem = $objConfigure->GetDefaultArrayValue('inv_mergeitem');
	if(empty($arryBomItem)){   
		$arryBomItem = $objConfigure->GetDefaultArrayValue('inv_mergesubitem');
	}
 
}

 


if($arryMergeItem[0]['ParentValuationType']== 'Serialized' || $arryMergeItem[0]['ParentValuationType']== 'Serialized Average'){

$Serialdis = '';
}else{

$Serialdis = 'display:none;';
}

				if(empty($NumLine)) $NumLine = 1; //Line item count
				$ConditionDrop  =$objCondition-> GetConditionDropValue($arryMergeItem[0]['ParentCondition']); //Condition Drop down value
	
	require_once("../includes/footer.php"); 
	
?>
