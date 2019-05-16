<?php
	/**************************************************/
	$ThisPageName = 'viewTerritory.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");


	require_once($Prefix."classes/territory.class.php");
	
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
	
	if (class_exists('territory')) {
	  	$objTerritory=new territory();
	} else {
  		echo "Class Not Found Error !! Territory Class Not Found !";
		exit;
  	}
	
        $_GET['edit'] = (int)$_GET['edit'];
	$_GET['ParentID'] = (int)$_GET['ParentID'];
        
       $listAllTerritory =  $objTerritory->ListAllCategories();
      
		if($_GET['ParentID'] > 0){
			$ModuleName = 'SubTerritory';
			$ListTitle  = 'SubCategories';
			$ListUrl    = "viewTerritory.php?ParentID=".$_GET['ParentID']."&curP=".$_GET['curP'];
			$ParentID = $_GET['ParentID'];
			$BlankMessage  = SUbCAT_BLANK_MESSAGE;
			$InsertMessage = SUbCAT_ADD;
			$UpdateMessage = SUbCAT_UPDATE;
			$DeleteMessage = SUbCAT_REMOVE;
			$CntPrdMessage = SUbCAT_CAN_NOT_REMOVE;
		 }else{
			$ModuleName = 'Territory';
			$ListTitle  = 'Categories';
			$ListUrl    = "viewTerritory.php?curP=".$_GET['curP'];
			$ParentID = 0;
			$BlankMessage  = CAT_BLANK_MESSAGE;
			$InsertMessage = CAT_ADD;
			$UpdateMessage = CAT_UPDATE;
			$DeleteMessage = CAT_REMOVE;
			$CntPrdMessage = CAT_CAN_NOT_REMOVE;
		 }	 

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_cat'] = $ModuleName.STATUS;
		$objTerritory->changeTerritoryStatus($_GET['active_id']);
		header("location:".$ListUrl);
	}
	

	 if(!empty($_GET['delete_all'])){
		$_SESSION['mess_cat'] = $ModuleName.REMOVED;
		$objTerritory->RemoveTerritoryCompletly($_GET['delete_all']);
		header("location:".$ListUrl);
	 }

	 if(!empty($_GET['del_id'])){
	 
	
			if($objTerritory->isSubTerritoryExists($_GET['del_id'])){ 
				$_SESSION['mess_cat'] = CAT_SUBCAT_CAN_NOT_REMOVE;
			}/*else if($objTerritory->isProductExists($_GET['del_id'])){
				$_SESSION['mess_cat'] = $CntPrdMessage;
			}*/else{ 
				$_SESSION['mess_cat'] = $ModuleName.REMOVED;
				$objTerritory->RemoveTerritory($_GET['del_id'], $_GET['ParentID']);
			}


		header("location:".$ListUrl);
		exit;
	}
		


 	if (is_object($objTerritory)) {	
		 
		 if ($_POST) {
			/*******************/
			CleanPost(); 
			/*******************/
			 if(!empty($_POST['ParentID'])){
				$ParentID = $_POST['ParentID'];
			 }else{
				$ParentID = 0;
			 }
			 if (empty($_POST['Name'])) {
				$errMsg = $BlankMessage;
			 } else {
				if (!empty($_POST['TerritoryID'])) {
					$ImageId = $_POST['TerritoryID'];
					
					$_SESSION['mess_cat'] = $ModuleName.UPDATED;
					$objTerritory->UpdateTerritory($_POST);
				} else {		
					$_SESSION['mess_cat'] = $ModuleName.ADDED;
					$ImageId = $objTerritory->AddTerritory($_POST);							
				}
				
				

			
				
				header("location:".$ListUrl);
				exit;
			}
		}



				
			
		

		if ($_GET['edit'] && !empty($_GET['edit'])) {
			$arryTerritory = $objTerritory->GetTerritory($_GET['edit'],$ParentID);
                        $PageHeading = 'Edit '.$ModuleName.' for '.stripslashes($arryTerritory[0]['Name']);
			$TerritoryID   = $_GET['edit'];
			

		}
		
		if($ParentID > 0){
			$arryTerritoryName = $objTerritory->GetNameByParentID($ParentID);
			$ParentName	  = $arryTerritoryName[0]['Name'];
			
			
			
			/***********/
			if($ParentID > 0){
			$LevelTerritory = 2;

			$arrayParentTerritory = $objTerritory->GetTerritoryNameByID($ParentID);
			
			$ParentTerritory  = ' &raquo; '.stripslashes($arrayParentTerritory[0]['Name']);
	
			$MainParentTerritory='';

			if($arrayParentTerritory[0]['ParentID']>0){
				$LevelTerritory = 3;

				$BackParentID = $arrayParentTerritory[0]['ParentID'];
				$arrayMainParentTerritory = $objTerritory->GetTerritoryNameByID($arrayParentTerritory[0]['ParentID']);
				$MainParentTerritory  = ' &raquo; '.stripslashes($arrayMainParentTerritory[0]['Name']);
				
				
				if($arrayMainParentTerritory[0]['ParentID']>0){
					$LevelTerritory = 4;
									
					$arrayMainRootParentTerritory = $objTerritory->GetTerritoryNameByID($arrayMainParentTerritory[0]['ParentID']);
					$MainParentTerritory  = ' &raquo; '.stripslashes($arrayMainRootParentTerritory[0]['Name']).$MainParentTerritory;


					if($arrayMainRootParentTerritory[0]['ParentID']>0){
						$LevelTerritory = 5;
										
						$arrayLastParentTerritory = $objTerritory->GetTerritoryNameByID($arrayMainRootParentTerritory[0]['ParentID']);
						$MainParentTerritory  = ' &raquo; '.stripslashes($arrayLastParentTerritory[0]['Name']).$MainParentTerritory;
					}

				}					
				
			}			
			
		}
			
			/***************/
		}
		
		if(!empty($arryTerritory) && $arryTerritory[0]['Status'] != ''){
			$TerritoryStatus = $arryTerritory[0]['Status'];
		}else{
			$TerritoryStatus = 1;
		}
}



 require_once("../includes/footer.php"); 
 
 
 ?>
