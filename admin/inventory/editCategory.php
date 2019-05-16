<?php
	/**************************************************/
	$ThisPageName = 'viewCategory.php'; $EditPage = 1;
	/**************************************************/
 	include_once("../includes/header.php");
	
require_once($Prefix."classes/function.class.php");

	require_once($Prefix."classes/inv_category.class.php");
	require_once($Prefix."classes/item.class.php");
require_once($Prefix . "classes/inv.class.php");
	
  	$objCategory=new category();
	 $objItems=new items();
	 $objCommon = new common();	
        $objFunction = new functions();
        
       $listAllCategory =  $objCategory->ListAllCategories();
        
		if($_GET['ParentID'] > 0){
			$ModuleName = 'SubCategory';
			$ListTitle  = 'SubCategories';
			$ListUrl    = "viewCategory.php?ParentID=".$_GET['ParentID']."&curP=".$_GET['curP'];
			$ParentID = $_GET['ParentID'];
			$BlankMessage  = SUbCAT_BLANK_MESSAGE;
			$InsertMessage = SUbCAT_ADD;
			$UpdateMessage = SUbCAT_UPDATE;
			$DeleteMessage = SUbCAT_REMOVE;
			$CntPrdMessage = SUbCAT_CAN_NOT_REMOVE;
		 }else{
			$ModuleName = 'Category';
			$ListTitle  = 'Categories';
			$ListUrl    = "viewCategory.php?curP=".$_GET['curP'];
			$ParentID = 0;
			$BlankMessage  = CAT_BLANK_MESSAGE;
			$InsertMessage = CAT_ADD;
			$UpdateMessage = CAT_UPDATE;
			$DeleteMessage = CAT_REMOVE;
			$CntPrdMessage = CAT_CAN_NOT_REMOVE;
		 }	 

	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_cat'] = $ModuleName.STATUS;
		$objCategory->changeCategoryStatus($_GET['active_id']);
		header("location:".$ListUrl);
	}
	

	 if(!empty($_GET['delete_all'])){
		$_SESSION['mess_cat'] = $ModuleName.REMOVED;
		$objCategory->RemoveCategoryCompletly($_GET['delete_all']);
		header("location:".$ListUrl);
	 }

	 if(!empty($_GET['del_id'])){
	 
	
			if($objCategory->isSubCategoryExists($_GET['del_id'])){ 
				$_SESSION['mess_cat'] = CAT_SUBCAT_CAN_NOT_REMOVE;
			}else if($objCategory->isProductExists($_GET['del_id'])){
				$_SESSION['mess_cat'] = $CntPrdMessage;
			}else{ 
				$_SESSION['mess_cat'] = $ModuleName.REMOVED;
				$objCategory->RemoveCategory($_GET['del_id'], $_GET['ParentID']);
			}


		header("location:".$ListUrl);
		exit;
	}
		


 	if (is_object($objCategory)) {	
		 
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
				if (!empty($_POST['CategoryID'])) {
					$ImageId = $_POST['CategoryID'];
					
					$_SESSION['mess_cat'] = $ModuleName.UPDATED;
					$objCategory->UpdateCategory($_POST);
					
					if($_POST['Spiff']==1 ){
					
					$objItems->UpdateOverrideItem($_POST);
					
					}
				} else {		
					$_SESSION['mess_cat'] = $ModuleName.ADDED;
					$ImageId = $objCategory->AddCategory($_POST);
					
					
							
				}
				
			
				
				// for Company to Company Sync by karishma ||  3 march 2016

				if ($_SESSION['DefaultInventoryCompany'] == '1') {
					$Companys = $objCompany->SelectAutomaticSyncCompany();
					for($count=0;$count<count($Companys);$count++){
						$CmpID=$Companys[$count]['CmpID']; 
						$objCompany->syncInventoryCompany($CmpID,$ImageId,'category');
						
					}
				}
				// end
				
				

			if($_FILES['Image']['name'] != ''){
			 
		$FileInfoArray['FileType'] = "Image";
		$FileInfoArray['FileDir'] = $Config['ItemCategory'];
		$FileInfoArray['FileID'] = $ImageId;
		$FileInfoArray['OldFile'] = $_POST['OldImage'];
		$FileInfoArray['UpdateStorage'] = '1';
		$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
		if($ResponseArray['Success']=="1"){				 
			#$objItem->UpdateImage($ResponseArray['FileName'], $ImageId);
			$objCategory->UpdateImage('Image',$ResponseArray['FileName'],$ImageId);			
		}else{
			$ErrorMsg = $ResponseArray['ErrorMsg'];
		}

			}
				
				header("location:".$ListUrl);
				exit;
			}
		}



				
			
		

		if ($_GET['edit'] && !empty($_GET['edit'])) {
			$arryCategory = $objCategory->GetCategory($_GET['edit'],$ParentID);
			$CategoryID   = $_GET['edit'];
			
	$arryItem= $objItems->GetItemByCategoryID($CategoryID);
	
	
		}
		
		if($ParentID > 0){
			$arryCategoryName = $objCategory->GetNameByParentID($ParentID);
			$ParentName	  = $arryCategoryName[0]['Name'];
			
		
			
			/***********/
			if($ParentID > 0){
			$LevelCategory = 2;

			$arrayParentCategory = $objCategory->GetCategoryNameByID($ParentID);
			
			$ParentCategory  = ' &raquo; '.stripslashes($arrayParentCategory[0]['Name']);
	
			if($arrayParentCategory[0]['ParentID']>0){
				$LevelCategory = 3;

				$BackParentID = $arrayParentCategory[0]['ParentID'];
				$arrayMainParentCategory = $objCategory->GetCategoryNameByID($arrayParentCategory[0]['ParentID']);
				$MainParentCategory  = ' &raquo; '.stripslashes($arrayMainParentCategory[0]['Name']);
				
				
				if($arrayMainParentCategory[0]['ParentID']>0){
					$LevelCategory = 4;
									
					$arrayMainRootParentCategory = $objCategory->GetCategoryNameByID($arrayMainParentCategory[0]['ParentID']);
					$MainParentCategory  = ' &raquo; '.stripslashes($arrayMainRootParentCategory[0]['Name']).$MainParentCategory;


					if($arrayMainRootParentCategory[0]['ParentID']>0){
						$LevelCategory = 5;
										
						$arrayLastParentCategory = $objCategory->GetCategoryNameByID($arrayMainRootParentCategory[0]['ParentID']);
						$MainParentCategory  = ' &raquo; '.stripslashes($arrayLastParentCategory[0]['Name']).$MainParentCategory;
					}

				}					
				
			}			
			
		}
			
			/***************/
		}
		
		if($arryCategory[0]['Status'] != ''){
			$CategoryStatus = $arryCategory[0]['Status'];
		}else{
			$CategoryStatus = 1;
		}
}

$arryEvaluationType = $objCommon->GetCrmAttribute('EvaluationType', '');

 require_once("../includes/footer.php"); 
 
 
 ?>
