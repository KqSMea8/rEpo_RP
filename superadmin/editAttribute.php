<?php
	/**************************************************/
	$ThisPageName = 'viewAttribute.php'; $EditPage = 1;
	/**************************************************/

	require_once("includes/header.php");
	require_once("../classes/commonsuper.class.php");
	$objCommon=new common();
	$RedirectUrl ="viewAttribute.php?att=".$_GET['att'];

	if(empty($_GET['att'])){
		header("location: viewAttribute.php?att=1");
		exit;
	}

	$arryAttribute=$objCommon->AllAttributes($_GET['att']);  
	$ModuleName = $arryAttribute[0]["attribute"];
	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = $ModuleName.MODULE_REMOVED;
		$objCommon->deleteAttribute($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_att'] = $ModuleName.MODULE_STATUS_CHANGED;
		$objCommon->changeAttributeStatus($_REQUEST['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
		CleanPost();
		if (!empty($_POST['value_id'])) {
			$objCommon->updateAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.MODULE_UPDATED;
		} else {		
			$objCommon->addAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.MODULE_ADDED;
		}
	
		$RedirectUrl ="viewAttribute.php?att=".$_POST['attribute_id'];
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;$attribute_value='';
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objCommon->getAttribute($_GET['edit'],'','');
		
		$attribute_value = stripslashes($arryAtt[0]['attribute_value']);
		$Status   = $arryAtt[0]['Status'];
	}




	 require_once("includes/footer.php"); 
 
?>
