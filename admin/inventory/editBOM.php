<?php            
	/**************************************************/
	$ThisPageName = 'viewBOM.php'; $EditPage=1;
	/**************************************************/	
	// require_once("phpuploader/include_phpuploader.php");
	require_once("../includes/header.php");
	require_once($Prefix."classes/bom.class.php");
	require_once($Prefix."classes/item.class.php");
		
	$objBom = new bom();
	$objItems = new items();

	$editBomID=$_GET['edit'];
	$RedirectURL = "viewBOM.php?curP=".$_GET['curP'];
	$ModuleName  = "BOM";
  
	$EditUrl = "editBOM.php?edit=" . $_GET["edit"] . "&curP=" . $_GET["curP"] . "&tab=";
	$ActionUrl = "editBOM.php?curP=1&tab=bill_Information";      
   
	(empty($ConditionDrop))?($ConditionDrop=""):("");  
	$NotExist = NOT_EXIST_DATA; 

	if(!empty($_GET['del_id'])){
		$objBom->RemoveBOM($_GET['del_id']);
		$_SESSION['mess_bom'] = 'BOM'.ADJ_REMOVED;
		header("location: ".$RedirectURL);
		exit;
	}


	 if(!empty($_GET['bc'])&&!empty($_GET['bom_Sku'])){
		 $arryBOMSelect = $objBom->ListBOM($_GET['bc'],'','','','');


		 $arryItem = $objItems->checkItemSku($_GET['bom_Sku']);

#print_r($arryItem);
		$arryBOM[0]['Sku'] = $arryItem[0]['Sku'];
		$arryBOM[0]['description'] = $arryItem[0]['description'];
		$arryBOM[0]['item_id'] = $arryItem[0]['ItemID'];
		$arryBOM[0]['on_hand_qty'] = $arryItem[0]['qty_on_hand'];
		$arryBOM[0]['bill_option'] = $arryBOMSelect[0]['bill_option'];
                 
		$bomID   = $arryBOMSelect[0]['bomID'];	
		if($bomID>0){
			$arryBomItem = $objBom->GetBOMStock($bomID,'');
			$NumLine = sizeof($arryBomItem);
		}else{
			$ErrorMSG = $NotExist;
		}
             //$_GET['optionID'] = $_GET['option_code'];
	  if($arryBOM[0]['bill_option'] =='Yes'){
		$arryOption = $objBom->ListOptionBill($_GET);
		$optionID   = $arryOption[0]['optionID']; //added by chetan 10Mar2017//

                    $num2=$objBom->numRows();

			if($_GET['option_del_id'] && !empty($_GET['option_del_id'])){
				$objBom->RemoveOptionBOM($_GET['option_del_id']);
				$_SESSION['mess_bom'] = OPTION_REMOVED;
				$RedURL ="editBOM.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=".$_GET['tab'];
				header("location: ".$RedURL);
				exit;
			}
                 }


	}
		if(!empty($_GET['edit'])){
			$arryBOM = $objBom->ListBOM($_GET['edit'],'','','','');
			$bomID   = $arryBOM[0]['bomID'];
			
		if($arryBOM[0]['bill_option'] == 'No'){
			if($bomID >0){

				//		
				$arryBomItem = $objBom->GetBOMStock($bomID,'');
				//  print_r($arryBomItem);
				$NumLine = sizeof($arryBomItem);
				$ErrorMSG = $NotExist;
			}
			

		}


		if($arryBOM[0]['bill_option'] == 'Yes'){
			$arryOption = $objBom->ListOptionBill($_GET);
			$num2=$objBom->numRows();
			$optionID   = $arryOption[0]['optionID'];

			/*$arryBomItem = $objBom->GetBOMStock($bomID,'');//hide by chetan 26May2017//
			//  print_r($arryBomItem);
			$NumLine = sizeof($arryBomItem);
			$ErrorMSG = $NotExist;*/
			
			
		     }

			if($_GET['option_del_id'] && !empty($_GET['option_del_id'])){
				$objBom->RemoveOptionBOM($_GET['option_del_id']);
				$_SESSION['mess_bom'] = OPTION_REMOVED;
				$RedURL ="editBOM.php?edit=".$_GET['edit']."&curP=".$_GET['curP']."&tab=".$_GET['tab'];
				header("location: ".$RedURL);
				exit;
			}

		}
	     	
	 
	if($arryBOM[0]['bill_option'] == 'Yes'){
		$display1 = "style='display:block;'";
		$display2 = "style='display:none;'";
	}else{
		$display1 = "style='display:none;'";
		$display2 = "style='display:block;'";
	}

	
	



   if($_POST) {       
          
if($_POST['bill_option'] == 'Yes') {
	CleanPost();      

		if ($_POST['bomID'] != '') {
					$bom_id = $_POST['bomID'];
					$objBom->UpdateBom($_POST,$bomID);              					
					$objBom->UpdateOptionBill($_POST);
					$_SESSION['mess_bom'] = 'BOM'.ADJ_UPDATED;
		}else {	
		
					if($_POST['bomID'] ==''){
						 $bom_id = $objBom->AddBOM($_POST);
					}else{
						 $bom_id = $_POST['bomID'];
					}

					if($bom_id > 0){
						$objBom->AddOptionCat($bom_id,$_POST);
						       
					} 
                		 
  }
// for Company to Company Sync by karishma || 2 Dec 2015
						if ($_SESSION['DefaultInventoryCompany'] == '1' ) {

							$Companys = $objCompany->SelectAutomaticSyncCompany();
								for($count=0;$count<count($Companys);$count++){
										$CmpID=$Companys[$count]['CmpID'];
										$objCompany->syncInventoryCompany($CmpID,$bom_id,'BOM');
		
								}
						} //end
					$_SESSION['mess_bom'] = 'BOM'.ADJ_ADDED;
		
          
		
          header("Location:" . $ActionUrl);
						exit;
		
		
	}



       if($_POST['bill_option'] == 'No'){
                CleanPost(); 
		if (!empty($_POST['bomID'])) {
		 $bom_id = $_POST['bomID'];
                
				$objBom->UpdateBom($_POST);
				$objBom->AddUpdateBOMItem($bom_id,'',$_POST); 
				$_SESSION['mess_bom'] = 'BOM'.ADJ_UPDATED;

                                if($_POST['bill_option'] == 'No')
                                {
                                    $objBom->RemoveBOMComponent($bom_id,'option');     
                                }    
                                //End// 
			

		}else {                    
		     $BOM_ID = $objBom->AddBOM($_POST);
		if($BOM_ID >0){

			if(!empty($_POST['optionIds']) && count($_POST['optionIds'])>0){
			  $objBom->AddOptionBillCodes($BOM_ID ,$_POST,$_GET['bc']); 
			}else{
			  $objBom->AddUpdateBOMItem($BOM_ID ,'',$_POST,'');
			}
			//End//
			} 
			
			// for Company to Company Sync by karishma || 2 Dec 2015
             if ($_SESSION['DefaultInventoryCompany'] == '1' ) {
			
             		$Companys = $objCompany->SelectAutomaticSyncCompany();
             		for($count=0;$count<count($Companys);$count++){
             			$CmpID=$Companys[$count]['CmpID'];
             			$objCompany->syncInventoryCompany($CmpID,$BOM_ID,'BOM');
             			
             		}
} //end
			
			
			    $_SESSION['mess_bom'] = 'BOM'.ADJ_ADDED;

			}

			header("Location:" . $ActionUrl);
			exit;
			


        }
}


	
	if(empty($NumLine)) $NumLine = 1;
	if(empty($NumLine1)) $NumLine1 = 1;
	if(empty($newNumLine)) $newNumLine = 1;

	if(empty($arryOption)){   
		$arryOption = $objConfigure->GetDefaultArrayValue('inv_bom_cat');
	}
	
	require_once("../includes/footer.php"); 
	
?>
