<?php
/**************************************************/
$ThisPageName = 'viewCategory.php'; $EditPage = 1; $HideNavigation = 1;
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

$listAllCategory =  $objCategory->ListAllCategories();

$ModuleName = 'Add Category';
$ListTitle  = 'Categories';
$RedirectURL    = "viewCategory.php?curP=".$_GET['curP'];
$ParentID = $_GET['ParentID'];




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
					$ImageDestination = $Prefix."upload/category/".$imageName;
					if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
						$objCategory->UpdateImage('Image',$imageName,$ImageId);
					}
				}else{
					$ErrorMsg = $FileArray['ErrorMsg'];
				}
				if(!empty($ErrorMsg)){
					if(!empty($_SESSION['mess_cat'])) $ErrorPrefix = '<br><br>';
					$_SESSION['mess_cat'] .= $ErrorPrefix.$ErrorMsg;
				}
					
			}

			echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
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