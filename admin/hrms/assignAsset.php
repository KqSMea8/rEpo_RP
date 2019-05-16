<?php 
	/**************************************************/
	$ThisPageName = 'viewAssignAsset.php'; $EditPage = 1;
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
	$RedirectURL = "viewAssignAsset.php?curP=".$_GET['curP'];

	 if($_POST){
			 if(empty($_POST['AssetName'])) {
				$errMsg = ENTER_ASSET;
			 } else {

				$objAsset->AddAssignAsset($_POST); 
				$_SESSION['mess_asset'] = ASSIGN_ASSET_ADDED;
				header("Location:".$RedirectURL);
				exit;
				
			}
		}
		
   
	require_once("../includes/footer.php"); 	 
?>


