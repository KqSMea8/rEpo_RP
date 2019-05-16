<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewEmployee.php'; 
	/**************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/hrms.class.php");
	$objCommon=new common();
	CleanGet();

	if (!empty($_GET['view']))
            {
		$arryBenefit = $objCommon->getBenefit($_GET['view'],'');
               // print_r($arryBenefit);exit;
		if(sizeof($arryBenefit)<=0)
                    {
			$ErrorExist = NO_RECORD;
		}
	}else{
		$ErrorExist = INVALID_REQUEST;
	}

	require_once("../includes/footer.php"); 	 
?>



