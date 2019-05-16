<?php
/**************************************************/
$ThisPageName = 'viewCategory.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");

require_once("classes/category.class.php");
require_once($Prefix."classes/function.class.php");
$objFunction=new functions();

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number

if (class_exists(category)) {
	$objCategory=new category();
} else {
	echo "Class Not Found Error !! Category Class Not Found !";
	exit;
}

if ($_REQUEST['edit'] && !empty($_REQUEST['edit'])) {
	$arryCategory = $objCategory->GetCategory($_REQUEST['edit']);
	$CategoryID   = $_REQUEST['edit'];
		

}

if($ParentID > 0){
	$arryCategoryName = $objCategory->GetNameByParentID($ParentID);
	$ParentName	  = $arryCategoryName[0]['Name'];
		
		

}

$listAllCategory =  $objCategory->ListAllCategories();

if($_GET['ParentID'] > 0){
	$ModuleName = 'Category';
	$ListTitle  = 'Categories';
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
	$objCategory->changeCategoryStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}


if(!empty($_GET['delete_all'])){
	$_SESSION['mess_cat'] = $ModuleName.REMOVED;
	$objCategory->RemoveCategoryCompletly($_REQUEST['delete_all']);
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
			} else {
				$_SESSION['mess_cat'] = $ModuleName.ADDED;
				$ImageId = $objCategory->AddCategory($_POST);
			}


			if($_FILES['Image']['name'] != ''){

				$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");
				if(empty($FileArray['ErrorMsg'])){

					$ImageExtension = GetExtension($_FILES['Image']['name']);
					$imageName = $ImageId.".".$ImageExtension;
						
					$MainDir = $Prefix."upload/category/".$_SESSION['CmpID']."/";
					if (!is_dir($MainDir)) {
						mkdir($MainDir);
						chmod($MainDir,0777);
					}
					$ImageDestination = $MainDir.$imageName;
						
					if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
						$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
						unlink($_POST['OldImage']);
					}

						
					if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
						$objCategory->UpdateImage('Image',$imageName,$ImageId); 						$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
					}
				}else{
					$ErrorMsg = $FileArray['ErrorMsg'];
				}
				if(!empty($ErrorMsg)){
					if(!empty($_SESSION['mess_cat'])) $ErrorPrefix = '<br><br>';
					$_SESSION['mess_cat'] .= $ErrorPrefix.$ErrorMsg;
				}
					
			}

			header("location:".$ListUrl);
			exit;
		}
	}




	if($arryCategory[0]['Status'] != ''){
		$CategoryStatus = $arryCategory[0]['Status'];
	}else{
		$CategoryStatus = 1;
	}
}



require_once("includes/footer.php");


?>
