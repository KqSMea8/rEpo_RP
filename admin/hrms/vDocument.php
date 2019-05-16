<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();

	if (!empty($_GET['view'])) {
		$arryDocument = $objCommon->getDocument($_GET['view'],0,'');
		$PageHeading = 'Edit Document: '.stripslashes($arryDocument[0]['heading']);
	}else{
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}

	require_once("../includes/footer.php"); 	 
?>


