<?php
	/**************************************************/
	$ThisPageName = 'viewEducation.php'; $EditPage = 1;
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	$ModuleName = "Attribute";

	$RedirectUrl ="viewEducation.php?ed=".$_GET['ed'];

	if(empty($_GET['ed'])){
		header("location: viewEducation.php?ed=4");
		exit;
	}


	if(!empty($_GET['del_id'])){
		$_SESSION['mess_ed'] = ATT_REMOVED;
		$objCommon->deleteAttribute($_GET['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_ed'] = ATT_STATUS_CHANGED;
		$objCommon->changeAttributeStatus($_GET['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['value_id'])) {
			$objCommon->updateAttribute($_POST);
			$_SESSION['mess_ed'] = ATT_UPDATED;
		} else {		
			$objCommon->addAttribute($_POST);
			$_SESSION['mess_ed'] = ATT_ADDED;
		}
	
		$RedirectUrl ="viewEducation.php?ed=".$_POST['attribute_id'];
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1; $attribute_value='';
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objCommon->getAttribute($_GET['edit'],'','');
		
		$attribute_value = stripslashes($arryAtt[0]['attribute_value']);
		$Status   = $arryAtt[0]['Status'];
	}


	 $arryAttribute=$objCommon->AllAttributes('3,4,5,6,7');  


	 require_once("../includes/footer.php"); 
 
?>
