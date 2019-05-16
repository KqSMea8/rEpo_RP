<?php
	/**************************************************/
	$ThisPageName = 'viewKra.php'; $EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	require_once($Prefix."classes/hrms.class.php");
	$objPerformance=new performance();
	$objCommon=new common();

	$ModuleName = "KRA";
	$RedirectURL = "viewKra.php";


	if(!empty($_GET['del_id'])){
		$_SESSION['mess_kra'] = KRA_REMOVED;
		$objPerformance->deleteKra($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_kra'] = KRA_STATUS_CHANGED;
		$objPerformance->changeKraStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if ($_POST) {
		CleanPost(); 
		if (!empty($_POST['kraID'])) {
			$objPerformance->updateKra($_POST);
			$kraID = $_POST['kraID'];
			$_SESSION['mess_kra'] = KRA_UPDATED;
		}else{		
			$kraID = $objPerformance->addKra($_POST);
			$_SESSION['mess_kra'] = KRA_ADDED;
		}
		header("Location:".$RedirectURL);
		exit;
		
	}
	$Status=1;
	if($_GET['edit']>0)
	{
		$arryKra = $objPerformance->getKra($_GET['edit'],'');
		$PageHeading = 'Edit KRA: '.stripslashes($arryKra[0]['heading']);
		$Status = $arryKra[0]['Status']; 
	}

	
	$arryJobTitle = $objCommon->GetAttributeValue('JobTitle','');

    require_once("../includes/footer.php"); 

?>

