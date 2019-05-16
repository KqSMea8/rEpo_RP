<?php
	/**************************************************/
	$ThisPageName = 'viewManufacturer.php'; $EditPage = 1; $HideNavigation = 1;
	/**************************************************/
 	include_once("../includes/header.php");

	require_once($Prefix."classes/manufacturer.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	
  	$objManufacturer=new manufacturer();
	
        $ModuleName = 'Add Manufacturer';
        $ListTitle  = 'Manufacturers';
        $RedirectURL    = "viewManufacturer.php?curP=".$_GET['curP'];
        

 	if (is_object($objManufacturer)) {	
		 
		 if ($_POST) {
		
					if (!empty($_POST['Mid'])) {
							$ImageId = $_POST['Mid'];
							$_SESSION['mess_man'] = $ModuleName.UPDATED;
							$objManufacturer->updateManufacturer($_POST);
					} else {	
							$checkMcode = $objManufacturer->checkManufacturer($_POST['Mcode']);
							if(count($checkMcode) > 0){
							  $_SESSION['mess_man'] = "Manufacturer Code is already exists.";
							  header("location:editManufacturer.php");
							  exit;
							}else{
								$_SESSION['mess_man'] = $ModuleName.ADDED;
								$ImageId = $objManufacturer->addManufacturer($_POST);							
							}
					}

	   
					if($_FILES['Image']['name'] != ''){
					
						$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");
						if(empty($FileArray['ErrorMsg'])){
							$ImageExtension = GetExtension($_FILES['Image']['name']);
							$imageName = $ImageId.".".$ImageExtension;	
							$ImageDestination = $Prefix."upload/manufacturer/".$imageName;
							//echo "=>".$ImageDestination;die;
							if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
								$objManufacturer->UpdateImage($imageName,$ImageId);
							}
						}else{
							$ErrorMsg = $FileArray['ErrorMsg'];
						}

						if(!empty($ErrorMsg)){
							if(!empty($_SESSION['mess_man'])) $ErrorPrefix = '<br><br>';
								$_SESSION['mess_man'] .= $ErrorPrefix.$ErrorMsg;
							}
					}

					echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				  exit;
			
		}
		

	
	
		
		if($arryManufacturer[0]['Status'] != ''){
			$ManufacturerStatus = $arryManufacturer[0]['Status'];
		}else{
			$ManufacturerStatus = 1;
		}
}



 require_once("../includes/footer.php"); 
 
 
 ?>
