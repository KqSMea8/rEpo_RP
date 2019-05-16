<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/asset.class.php");
	require_once($Prefix."classes/vendor.class.php");
	include_once("includes/FieldArray.php");
	$objAsset=new asset();
	$objVendor=new vendor();
	
    $ModuleName = "Assign Asset";
	$RedirectURL = "viewAssignAsset.php?curP=".$_GET['curP'];
	
	if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_asset'] = ASSIGN_ASSET_REMOVED;
		$objAsset->RemoveAssignAsset($_REQUEST['del_id'],$_REQUEST['AssetID']);
		header("Location:".$RedirectURL);
		exit;
	}
	
	/*************************/
	$arryAssignAsset=$objAsset->ListAssignAsset($_GET);
	
	$num=$objAsset->numRows();

	$pagerLink=$objPager->getPager($arryAssignAsset,$RecordsPerPage,$_GET['curP']);
	(count($arryAssignAsset)>0)?($arryAssignAsset=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("../includes/footer.php"); 	
?>


