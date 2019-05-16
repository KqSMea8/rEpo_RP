<?php
	/**************************************************/
	$ThisPageName = 'viewCondition.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/inv.condition.class.php");


	
	if (class_exists('condition')) {
	  	$objCondition=new condition();
	} else {
  		echo "Class Not Found Error !! Condition Class Not Found !";
		exit;
  	}
	 
        $objFunction = new functions();
        
       $listAllCondition =  $objCondition->ListAllCondition();
        
		if($_GET['ParentID'] > 0){
			$ModuleName = 'SubCondition';
			$ListTitle  = 'SubConditions';
			$ListUrl    = "viewCondition.php?ParentID=".$_GET['ParentID']."&curP=".$_GET['curP'];
			$ParentID = $_GET['ParentID'];
			$BlankMessage  = SUbCOND_BLANK_MESSAGE;
			$InsertMessage = SUbCOND_ADD;
			$UpdateMessage = SUbCOND_UPDATE;
			$DeleteMessage = SUbCOND_REMOVE;
			$CntPrdMessage = SUbCOND_CAN_NOT_REMOVE;
		 }else{
			$ModuleName = 'Condition';
			$ListTitle  = 'Conditions';
			$ListUrl    = "viewCondition.php?curP=".$_GET['curP'];
			$ParentID = 0;
			$BlankMessage  = COND_BLANK_MESSAGE;
			$InsertMessage = COND_ADD;
			$UpdateMessage = COND_UPDATE;
			$DeleteMessage = COND_REMOVE;
			$CntPrdMessage = COND_CAN_NOT_REMOVE;
		 }	 

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_cond'] = $ModuleName.STATUS;
		$objCondition->changeConditionStatus($_GET['active_id']);
		header("location:".$ListUrl);
	}
	

	 if(!empty($_GET['delete_all'])){
		$_SESSION['mess_cond'] = $ModuleName.REMOVED;
		$objCondition->RemoveConditionCompletly($_GET['delete_all']);
		header("location:".$ListUrl);
	 }

	 if(!empty($_GET['del_id'])){
	 
	
			if($objCondition->isSubConditionExists($_GET['del_id'])){ 
				$_SESSION['mess_cond'] = CAT_SUBCOND_CAN_NOT_REMOVE;
			}else if($objCondition->isProductExists($_GET['del_id'])){
				$_SESSION['mess_cond'] = $CntPrdMessage;
			}else{ 
				$_SESSION['mess_cond'] = $ModuleName.REMOVED;
				$objCondition->RemoveCondition($_GET['del_id'], $_GET['ParentID']);
			}


		header("location:".$ListUrl);
		exit;
	}
		


 	if (is_object($objCondition)) {	
		 
		 if ($_POST) {
			CleanPost();


			 if(!empty($_POST['ParentID'])){
				$ParentID = $_POST['ParentID'];
			 }else{
				$ParentID = 0;
			 }
			 if (empty($_POST['Name'])) {
				$errMsg = $BlankMessage;
			 } else {
				if (!empty($_POST['ConditionID'])) {
					$ImageId = $_POST['ConditionID'];
					$_SESSION['mess_cond'] = $ModuleName.UPDATED;
					$objCondition->UpdateCondition($_POST);
				} else {		
					$_SESSION['mess_cond'] = $ModuleName.ADDED;
					$ImageId = $objCondition->AddCondition($_POST);	
					
									
						
				}
				
				// for Company to Company Sync by karishma || 2 Dec 2015
				if ($_SESSION['DefaultInventoryCompany'] == '1' ) {
					$Companys = $objCompany->SelectAutomaticSyncCompany();
					for($count=0;$count<count($Companys);$count++){
						$CmpID=$Companys[$count]['CmpID'];
						$objCompany->syncInventoryCompany($CmpID,$ImageId,'setting','manage condition');

					}
				}
					
				// end
			
				header("location:".$ListUrl);
				exit;
			}
		}


		if ($_GET['edit'] && !empty($_GET['edit'])) {
			$arryCondition = $objCondition->GetCondition($_GET['edit'],$ParentID);
			$ConditionID   = $_GET['edit'];	

		}
		
		if($ParentID > 0){
			$arryConditionName = $objCondition->GetNameByParentID($ParentID);
			$ParentName	  = $arryConditionName[0]['Name'];	
			/***********/
			if($ParentID > 0){
			$LevelCondition = 3;

			$arrayParentCondition = $objCondition->GetConditionNameByID($ParentID);
			
			$ParentCondition  = ' &raquo; '.stripslashes($arrayParentCondition[0]['Name']);
	
			if($arrayParentCondition[0]['ParentID']>0){
				$LevelCondition = 3;

				$BackParentID = $arrayParentCondition[0]['ParentID'];
				$arrayMainParentCondition = $objCondition->GetConditionNameByID($arrayParentCondition[0]['ParentID']);
				$MainParentCondition  = ' &raquo; '.stripslashes($arrayMainParentCondition[0]['Name']);
				
				
				if($arrayMainParentCondition[0]['ParentID']>0){
					$LevelCondition = 2;
									
					$arrayMainRootParentCondition = $objCondition->GetConditionNameByID($arrayMainParentCondition[0]['ParentID']);
					$MainParentCondition  = ' &raquo; '.stripslashes($arrayMainRootParentCondition[0]['Name']).$MainParentCondition;


					if($arrayMainRootParentCondition[0]['ParentID']>0){
						$LevelCondition = 3;
										
						$arrayLastParentCondition = $objCondition->GetConditionNameByID($arrayMainRootParentCondition[0]['ParentID']);
						$MainParentCondition  = ' &raquo; '.stripslashes($arrayLastParentCondition[0]['Name']).$MainParentCondition;
					}

				}					
				
			}			
			
		}
			
			/***************/
		}
		
		if(isset($arryCondition[0]['Status'])){
		
			$ConditionStatus = $arryCondition[0]['Status'];
		}else{
			$ConditionStatus = 1;
		}
}



 require_once("../includes/footer.php"); 
 
 
 ?>
