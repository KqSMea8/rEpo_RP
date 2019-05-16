<?php 
	/**************************************************/
	$ThisPageName = 'viewVendor.php'; $EditPage = 1;
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/vendor.class.php");
	require_once($Prefix."classes/function.class.php");
	$objFunction=new functions();
	$objVendor=new vendor();

	$ModuleName = "Vendor";
	$RedirectURL = "viewVendor.php?curP=".$_GET['curP'];


	/*********  Multiple Actions To Perform **********/
	/*
	 if(!empty($_GET['multiple_action_id'])){
	 	$multiple_action_id = rtrim($_GET['multiple_action_id'],",");
		
		$mulArray = explode(",",$multiple_action_id);
	
		switch($_GET['multipleAction']){
			case 'delete':
					foreach($mulArray as $del_id){
						$objVendor->RemoveVendor($del_id);
					}
					$_SESSION['mess_vendor'] = VENDOR_REMOVED;
					break;
			case 'active':
					$objVendor->MultipleVendorStatus($multiple_action_id,1);
					$_SESSION['mess_vendor'] = VENDOR_STATUS_CHANGED;
					break;
			case 'inactive':
					$objVendor->MultipleVendorStatus($multiple_action_id,0);
					$_SESSION['mess_vendor'] = VENDOR_STATUS_CHANGED;
					break;				
		}
		header("location: ".$RedirectURL);
		exit;
		
	 }*/


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_vendor'] = VENDOR_REMOVED;
		$objVendor->RemoveVendor($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_vendor'] = VENDOR_STATUS_CHANGED;
		$objVendor->changeVendorStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if ($_POST) {
			CleanPost(); 
			 if (empty($_POST['Email'])) {
				$errMsg = ENTER_EMAIL;
			 }else{


				if(!empty($_POST['VendorID'])) {
					$LastInsertId = $_POST['VendorID'];
					$objVendor->UpdateVendor($_POST);
					$_SESSION['mess_vendor'] = VENDOR_UPDATED;	
				}else{	 
					if($objVendor->isEmailExists($_POST['Email'],'')){
						$_SESSION['mess_vendor'] = EMAIL_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objVendor->AddVendor($_POST); 
						$_SESSION['mess_vendor'] = VENDOR_ADDED;
					}
				}
		

				/***********************************/
				if($_FILES['Image']['name'] != ''){
					$FileArray = $objFunction->CheckUploadedFile($_FILES['Image'],"Image");

					if(empty($FileArray['ErrorMsg'])){
						$ImageExtension = $FileArray['Extension']; 
						$imageName = $LastInsertId.".".$ImageExtension;	
                                                $MainDir = "upload/vendor/".$_SESSION['CmpID']."/";						
						if (!is_dir($MainDir)) {
							mkdir($MainDir);
							chmod($MainDir,0777);
						}
						$ImageDestination = $MainDir.$imageName;						
						if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
							$objVendor->UpdateImage($imageName,$LastInsertId);
						}
					}else{
						$ErrorMsg = $FileArray['ErrorMsg'];
					}

					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_vendor'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_vendor'] .= $ErrorPrefix.$ErrorMsg;
					}

				}			


				/***********************************/
				if($LastInsertId>0){
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/***********************************/

					$arryCountry = $objRegion->GetCountryName($_POST['country_id']);
					$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);

					if(!empty($_POST['main_state_id'])) {
						$arryState = $objRegion->getStateName($_POST['main_state_id']);
						$arryRgn['State']= stripslashes($arryState[0]["name"]);
					}else if(!empty($_POST['OtherState'])){
						 $arryRgn['State']=$_POST['OtherState'];
					}

					if(!empty($_POST['main_city_id'])) {
						$arryCity = $objRegion->getCityName($_POST['main_city_id']);
						$arryRgn['City']= stripslashes($arryCity[0]["name"]);
					}else if(!empty($_POST['OtherCity'])){
						 $arryRgn['City']=$_POST['OtherCity'];
					}


					/***********************************/
					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();

					$objVendor->UpdateCountyStateCity($arryRgn,$LastInsertId);

				}
				/***********************************/
				/***********************************/
				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		

	if(!empty($_GET['edit'])) {
		$arryVendor = $objVendor->GetVendor($_GET['edit'],'','');
		$VendorID   = $_GET['edit'];	
	}
	
	if($arryVendor[0]['Status'] != ''){
		$VendorStatus = $arryVendor[0]['Status'];
	}else{
		$VendorStatus = 1;
	}				

	#$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Vendor','');

	require_once("../includes/footer.php"); 	 
?>


