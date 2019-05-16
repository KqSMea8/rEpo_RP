<?php
         $ThisPageName = 'myviewBOM.php';  $HideNavigation = 1;

	
	require_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
        require_once($Prefix."classes/bom.class.php");

        $objBom = new bom();
		
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
	$objRegion=new region();
        $RedirectURL = "viewAdjustment.php?curP=".$_GET['curP']."";
	$ModuleName  = "myOption Bill";
	$objItem=new items();        
        $EditUrl = "editAdjustment.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"].""; 
	
	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		
		$objItem->RemoveAdjustment($_GET['del_id']);
                $_SESSION['mess_bom'] = 'Adjustment'.ADJ_REMOVED;
		header("location: ".$RedirectURL);
	 }
	 

                
                if(!empty($_GET['optionID'])){
		 $arryOption = $objBom->ListOptionBill($_GET);


                 
		$optionID   = $arryOption[0]['optionID'];
                $bomID   = $arryOption[0]['bomID'];	
		if($optionID>0){
			$arryBomItem = $objBom->GetBOMStock($bomID,$optionID);
			$NumLine = sizeof($arryBomItem);
		}else{
			$ErrorMSG = $NotExist;
		}
	}
		

		

               if ($_POST) {
                   CleanPost();
                 ;
			 if(empty($_POST['option_code'])  ) {
				$errMsg = ENTER_OPTION_ID;
			 } else {
				if (!empty($_POST['optionID']) && $_POST['bomID'] != '') {
				  //if ($_POST['bomID'] != ''){                 //By Chetan 8Sept//
					$bom_id  = $_POST['bomID'];
                                        /*if($bom_id !=''){
                                          $objBom->UpdateBom($_POST);
                                        }*/
					$objBom->UpdateOptionBill($_POST);
					$option_ID = $_POST['optionID'];
					$_SESSION['mess_bom'] = OPTION_UPDATED;
				}else {	 
					if($_POST['bomID'] ==''){
					  $bom_id = $objBom->AddBOM($_POST);
					}else{
					   $bom_id = $_POST['bomID'];

					}
					if($bom_id > 0){
					  $option_ID = $objBom->AddOptionCat($bom_id,$_POST);
					} 
                                        $objBom->UpdateBom($_POST);
					$_SESSION['mess_bom'] = OPTION_ADDED;
				}
                                
				//$objBom->RemoveBOMComponent($bom_id,'component');     //By Chetan 8Sept//
				$objBom->AddUpdateBOMItem($bom_id,$option_ID,$_POST);
				if($_POST['NewOption'] == "Add New Option Bill"){

				header("location:myeditOptionBill.php?Sku=".$_POST['bom_Sku']."&item_id=".$_POST['bom_item_id']."&description=".$_POST['bom_description']."&bill_option=".$_POST['bill_option']."&bomID=".$bom_id."");
				exit;
				}else{
					echo '<script>parent.window.location.href ="myeditBOM.php?edit='.$bom_id.'" ;</script>';
					exit;
				}
				
			}
		}





	
if(empty($NumLine)) $NumLine = 1;
		
	require_once("../includes/footer.php"); 
	
?>
