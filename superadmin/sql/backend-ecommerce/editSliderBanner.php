<?php
/**************************************************/
$ThisPageName = 'sliderBanners.php'; $EditPage = 1;
/**************************************************/

include_once("includes/header.php");

require_once("classes/cartsettings.class.php");

(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
if (class_exists(cms)) {
	$objcartsettings=new Cartsettings();
} else {
	echo "Class Not Found Error !! CMS Class Not Found !";
	exit;
}
$sliderId = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
if ($sliderId && !empty($sliderId)) {$ModuleTitle = "Edit Slider Banner";}else{$ModuleTitle = "Add Slider Banner";}
$ModuleName = 'Slider Banner ';
$ListTitle  = 'Slider Banners';
$ListUrl    = "sliderBanners.php?curP=".$_GET['curP'];


if (!empty($sliderId))
{
	$arrySlider = $objcartsettings->getSliderBannerById($sliderId);
}



if(!empty($_GET['active_id'])){
	$_SESSION['mess_Page'] = $ModuleName.STATUS;
	$objcartsettings->changeSliderBannerStatus($_REQUEST['active_id']);
	header("location:".$ListUrl);
}


if(!empty($_GET['del_id'])){

	$_SESSION['mess_Page'] = $ModuleName.REMOVED;
	$objcartsettings->deleteSliderBanner($_GET['del_id']);
	header("location:".$ListUrl);
	exit;
}


$SubHeading = 'Menu';
if (is_object($objcartsettings)) {

	if ($_POST) {


		if (!empty($sliderId)) {
			$_SESSION['mess_Page'] = $ModuleName.UPDATED;
			$objcartsettings->updateSliderBanner($_POST);

				

		} else {
			$_SESSION['mess_Page'] = $ModuleName.ADDED;
			$sliderId = $objcartsettings->addSliderBanner($_POST);
				
		}
	
		if($_FILES['Slider_image']['name']!=''){
			$Compdir=$Prefix."upload/company/".$_SESSION['CmpID']."/";
			$MainDir = $Prefix."upload/company/".$_SESSION['CmpID']."/slider_image/";
			if (!is_dir($Compdir)) {
				mkdir($Compdir);
				chmod($Compdir,0777);
			}
			if (!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}
			$ImageExtension = GetExtension($_FILES['Slider_image']['name']);

			$imageName = $_FILES['Slider_image']['name'];
				
			$ImageDestination = $MainDir.$imageName;

			if(!empty($_POST['OldImage']) && file_exists($_POST['OldImage'])){
				$OldImageSize = filesize($_POST['OldImage'])/1024; //KB
				unlink($_POST['OldImage']);
			}
			if(@move_uploaded_file($_FILES['Slider_image']['tmp_name'], $ImageDestination)){
				$objcartsettings->UpdateSliderImage($imageName,$sliderId); 
				$objConfigure->UpdateStorage($ImageDestination,$OldImageSize,0);
					
			}
		}
			
		header("location:".$ListUrl);

		exit;
			
	}





	if($arrySocial[0]['Status'] == "No"){
		$PageStatus = "No";
	}else{
		$PageStatus = "Yes";
	}


}



require_once("includes/footer.php");


?>
