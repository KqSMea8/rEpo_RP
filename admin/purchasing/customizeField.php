<?php
	require_once("../includes/header.php");


	if($_POST) {
		if (!empty($_POST['NumField'])) {
			$objConfigure->updateCustomFieldValue($_POST);
			$_SESSION['mess_cust'] = CUSTOM_FIELD_UPDATED;
		}	
		$RedirectUrl ="customizeField.php?m=".$_POST['Module'];
		header("location:".$RedirectUrl);
		exit;
	}
	
	$arryCustModule = $objConfigure->GetCustomFieldModule($CurrentDepID);

	if(!empty($_GET['m'])){
		$arryCustomField = $objConfigure->GetCustomField('','1',$CurrentDepID,$_GET['m'],'');
		$NumField = sizeof($arryCustomField);
	}

	require_once("../includes/footer.php"); 
?>
