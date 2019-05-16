<?php
	/**************************************************/
	$ThisPageName = 'viewModel.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
require_once($Prefix."classes/inv.class.php");

       
	
$objCommon = new common();
        $objItem=new items();
	$ModuleName = 'Model';
	$RedirectURL    = "viewModel.php?curP=".$_GET['curP'];
            


	if(!empty($_GET['active_id'])){
		$objItem->changeModelStatus($_GET['active_id']);
		$_SESSION['mess_model'] = MODEL_STATUS;
		header("location:".$RedirectURL);
	}

     // delete Model into database
	 
	if(!empty($_GET['del_id'])){
		$objItem->deleteModel($_GET['del_id']);
                $_SESSION['mess_model'] = MODEL_REMOVED;
		header("location:".$RedirectURL);
		exit;
	}
			
	// Add,Update Model into database	 
	 if ($_POST) {
					CleanPost();
	            if (!empty($_POST['id'])) {
	                    $_SESSION['mess_model'] = MODEL_UPDATED;
	                    $objItem->updateModel($_POST);
 												$lastShipId=$_POST['id'];
	                    //header("location:".$RedirectURL);
	            } else {		
	                    
	                    $lastShipId = $objItem->AddModelGen($_POST);
                            $_SESSION['mess_model'] = MODEL_ADDED;
						}
		          
	            // for Company to Company Sync by karishma || 4 march 2016
		if ($_SESSION['DefaultInventoryCompany'] == '1' ) {
			$Companys = $objCompany->SelectAutomaticSyncCompany();
			for($count=0;$count<count($Companys);$count++){
				$CmpID=$Companys[$count]['CmpID']; 
				$objCompany->syncInventoryCompany($CmpID,$lastShipId,'setting','manage model');

			}
		}
			
		// end

	            
	            header("location:".$RedirectURL);

	            exit;
		
	}
		

	
		if(!empty($_GET['edit'])){
		  
		     $arryModel = $objItem->GetModelGen($_GET['edit']);

		 }
	
	
		
		if($arryModel[0]['Status'] == 0){
			$ModelStatus = 0;
		}else{
			$ModelStatus = 1;
		}
                
$arryGeneration = $objCommon->GetCrmAttribute('Generation', '');

 require_once("../includes/footer.php"); 
 
 
 ?>
