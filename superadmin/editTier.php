<?php
	/**************************************************/
	$ThisPageName = 'viewTier.php'; $EditPage = 1;
	/**************************************************/
	require_once("includes/header.php");
	require_once("../classes/commonsuper.class.php");
	$objCommon=new common();
	
	$ModuleName = "Tier";
	
	$RedirectUrl = "viewTier.php?curP=".$_GET['curP'];


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_tier'] = TIER_REMOVED;
		$objCommon->deleteTier($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_tier'] = TIER_STATUS_CHANGED;
		$objCommon->changeTierStatus($_REQUEST['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}	

	if($_POST) {
		CleanPost();
		if(!empty($_POST['tierID'])) {
			$objCommon->updateTier($_POST);
			$_SESSION['mess_tier'] = TIER_UPDATED;
		}else{		
			$objCommon->addTier($_POST);
			$_SESSION['mess_tier'] = TIER_ADDED;
		}		
		header("location:".$RedirectUrl);
		exit;
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryTier = $objCommon->getTier($_GET['edit'],'');
		$Status   = $arryTier[0]['Status'];
	}
 
	require_once("includes/footer.php"); 
  ?>
