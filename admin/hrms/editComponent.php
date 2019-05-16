<?php
	/**************************************************/
	$ThisPageName = 'viewComponent.php'; $EditPage = 1;
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	$objPerformance=new performance();
	
	$ModuleName = "Component";
	$RedirectURL = "viewComponent.php";


	 if(!empty($_GET['del_id'])){
		$_SESSION['mess_component'] = COMPONENT_REMOVED;
		$objPerformance->deleteComponent($_GET['del_id']);
		header("Location:".$RedirectURL);
		exit;
	}

	if(!empty($_GET['active_id'])){
		$_SESSION['mess_component'] = COMPONENT_STATUS_CHANGED;
		$objPerformance->changeComponentStatus($_GET['active_id']);
		header("Location:".$RedirectURL);
		exit;
	}


	if ($_POST) {

		if (!empty($_POST['compID'])) {
			$objPerformance->updateComponent($_POST);
			$compID = $_POST['compID'];
			$_SESSION['mess_component'] = COMPONENT_UPDATED;
		}else{		
			$compID = $objPerformance->addComponent($_POST);
			$_SESSION['mess_component'] = COMPONENT_ADDED;
		}
		header("Location:".$RedirectURL);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryComponent = $objPerformance->getComponent($_GET['edit'],'');
		$PageHeading = 'Edit Component: '.stripslashes($arryComponent[0]['heading']);
		$Status = $arryComponent[0]['Status']; 
	}else{
		header("Location:".$RedirectURL);
		exit;
	}

	


  require_once("../includes/footer.php"); 

?>

