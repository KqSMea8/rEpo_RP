<?php
	/**************************************************/
	$ThisPageName = 'viewComponent.php'; 
	/**************************************************/

	require_once("../includes/header.php");
	require_once($Prefix."classes/performance.class.php");
	$objPerformance=new performance();
	
	$ModuleName = "Component";
	$RedirectURL = "viewComponent.php";
	$EditUrl = "editComponent.php?edit=".$_GET['view'];

	
	if($_GET['view']>0){
		$arryComponent = $objPerformance->getComponent($_GET['view'],'');
		$PageHeading = 'Component: '.stripslashes($arryComponent[0]['heading']);
	}else{
		header("Location:".$RedirectURL);
		exit;
	}


   require_once("../includes/footer.php"); 

?>

