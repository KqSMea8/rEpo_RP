<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	CleanGet();

	if (!empty($_GET['view'])) {
		$arryNews = $objCommon->getNews($_GET['view'],'');
		$PageHeading = 'Announcement: '.stripslashes($arryNews[0]['heading']);
		$newsID   = $arryNews[0]['newsID'];
		if(sizeof($arryNews)<=0){
			$ErrorExist = NO_RECORD;
		}
	}else{
		$ErrorExist = INVALID_REQUEST;
	}

	require_once("../includes/footer.php"); 	 
?>


