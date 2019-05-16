<?php 
	/**************************************************/
	$ThisPageName = 'viewAsset.php'; $EditPage = 1;
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/asset.class.php");
	require_once($Prefix."classes/hrms.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once($Prefix."classes/vendor.class.php");
	$objVendor=new vendor();
	$objFunction=new functions();
	$objCommon=new common();

	$objAsset=new asset();

	$ModuleName = "Asset";
	$RedirectURL = "viewAsset.php?curP=".$_GET['curP'];

	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_asset'] = ASSET_REMOVED;
		$objAsset->RemoveAsset($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_asset'] = ASSET_STATUS_CHANGED;
		$objAsset->changeAssetStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}
	

	
	 if($_POST){
		 CleanPost(); 
			 if(empty($_POST['AssetName'])) {
				$errMsg = ENTER_ASSET;
			 } else {

				if(!empty($_POST['AssetID'])) {
					$LastInsertId = $_POST['AssetID'];
					$objAsset->UpdateAsset($_POST);
					$_SESSION['mess_asset'] = ASSET_UPDATED;
				}else{	 
					if($objAsset->isTagIDExists($_POST['TagID'],'')){
						$_SESSION['mess_asset'] = TAGID_ALREADY_REGISTERED;
					}else{	
						$LastInsertId = $objAsset->AddAsset($_POST); 
						$_SESSION['mess_asset'] = ASSET_ADDED;
					}
				}
				

				if($_FILES['Image']['name'] != ''){
					

					$FileInfoArray['FileType'] = "Image";
					$FileInfoArray['FileDir'] = $Config['AssetDir'];
					$FileInfoArray['FileID'] =  $LastInsertId;
					$FileInfoArray['OldFile'] = $_POST['OldImage'];
					$FileInfoArray['UpdateStorage'] = '1';
					$ResponseArray = $objFunction->UploadFile($_FILES['Image'], $FileInfoArray);
					if($ResponseArray['Success']=="1"){  
						$objAsset->UpdateImage($ResponseArray['FileName'],$LastInsertId);
					}else{
						$ErrorMsg = $ResponseArray['ErrorMsg'];
					}
					 
					if(!empty($ErrorMsg)){
						if(!empty($_SESSION['mess_asset'])) $ErrorPrefix = '<br><br>';
						$_SESSION['mess_asset'] .= $ErrorPrefix.$ErrorMsg;
					}

				}

	
				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		

	if(!empty($_GET['edit'])) {
		$arryAsset = $objAsset->GetAsset($_GET['edit'],'','');

		$PageHeading = 'Edit Asset: '.stripslashes($arryAsset[0]['AssetName']);
		$AssetID   = $_GET['edit'];	
	}
				
	if($arryAsset[0]['Status'] != ''){
		$AssetStatus = $arryAsset[0]['Status'];
	}else{
		$AssetStatus = 1;
	}				
		
    //Get Vendor		
	$arryVendor = $objVendor->GetAssetVendor($status=1);

	$arryCategory = $objCommon->GetAttribValue('AssetCat','');
	$arryBrand = $objCommon->GetAttribValue('AssetBrand','');

	#$arryCustomField = $objConfigure->CustomFieldList($CurrentDepID,'Asset','');


	require_once("../includes/footer.php"); 	 
?>


