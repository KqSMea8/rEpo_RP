<?php
/**************************************************/
$ThisPageName = 'viewManufacturer.php'; $EditPage = 1;
/**************************************************/
include_once("includes/header.php");

require_once("classes/manufacturer.class.php");
require_once($Prefix."classes/function.class.php");
$objFunction=new functions();

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(manufacturer)) {
	$objManufacturer=new manufacturer();
} else {
	echo "Class Not Found Error !! Category Class Not Found !";
	exit;
}

$ModuleName = 'Manufacturer';
$ListTitle  = 'Manufacturers';
$ListUrl    = "viewManufacturer.php?curP=".$_GET['curP'];
 
if ($_REQUEST['edit'] && !empty($_REQUEST['edit']))
{
	$Mid = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
	$arryManufacturer = $objManufacturer->getManufacturerById($Mid);

}

	
 

if(!empty($_GET['active_id'])){
	$_SESSION['mess_man'] = $ModuleName.STATUS;
	$objManufacturer->changeManufacturerStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}




if(!empty($_GET['del_id'])){
	$_SESSION['mess_man'] = $ModuleName.REMOVED;
	$objManufacturer->deleteManufacturer($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}



if (is_object($objManufacturer)) {
		
	if ($_POST) {

		if (!empty($_POST['Mid'])) {
			$ImageId = $_POST['Mid'];
			$_SESSION['mess_man'] = $ModuleName.UPDATED;
			$objManufacturer->updateManufacturer($_POST);
		} else {
			$_SESSION['mess_man'] = $ModuleName.ADDED;
			$ImageId = $objManufacturer->addManufacturer($_POST);
		}


		if($_FILES['Image']['name'] != ''){
				
			$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");
			if(empty($FileArray['ErrorMsg'])){
				$ImageExtension = GetExtension($_FILES['Image']['name']);
				$imageName = $ImageId.".".$ImageExtension;

				$MainDir = $Prefix."upload/manufacturer/".$_SESSION['CmpID']."/";
				if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				}

				if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
					$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
					unlink($_POST['OldImage']);
				}


				$ImageDestination = $MainDir.$imageName;
					
				if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
					$objManufacturer->UpdateImage($imageName,$ImageId);
					$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);

				}
			}else{
				$ErrorMsg = $FileArray['ErrorMsg'];
			}

			if(!empty($ErrorMsg)){
				if(!empty($_SESSION['mess_man'])) $ErrorPrefix = '<br><br>';
				$_SESSION['mess_man'] .= $ErrorPrefix.$ErrorMsg;
			}
		}

		header("location:".$ListUrl);
		exit;
			
	}





	if($arryManufacturer[0]['Status'] != ''){
		$ManufacturerStatus = $arryManufacturer[0]['Status'];
	}else{
		$ManufacturerStatus = 1;
	}
}



require_once("includes/footer.php");


?>
