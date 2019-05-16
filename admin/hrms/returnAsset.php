<?php 
    $HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'returnAsset.php';
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/asset.class.php");
	require_once($Prefix."classes/vendor.class.php");
	$objVendor=new vendor();
	$objAsset=new asset();
	$ModuleName = "Return Asset";
	$RedirectURL = "viewAssignAsset.php?curP=".$_GET['curP'];

	 if($_POST){
			 if(empty($_POST['ReturnDate'])) {
				$errMsg = SELECT_RETURN_DATE;
			 } else {

				$objAsset->UpdateAssignAsset($_POST); 
				$_SESSION['mess_asset'] = ASSIGN_ASSET_RETURN;
				echo '<script>window.parent.location.href="'.$RedirectURL.'";</script>';
				exit;
			 
				
			}
		}
		
   
	require_once("../includes/footer.php"); 	 
?>


