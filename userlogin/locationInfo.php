<?php 
	$HideNavigation = 1;
	/**************************************************/
	$ThisPageName = 'viewLocation.php'; 
	/**************************************************/
	include_once("includes/header.php");

	if (!empty($_GET['view'])) {
		$arryLocation = $objConfigure->GetLocation($_GET['view'],'');


		if($arryLocation[0]['currency_id']>0){
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();

			$arryCurrency = $objRegion->getCurrency($arryLocation[0]['currency_id'],'');
		}
	}else{
		echo '<div class="redmsg" align="center">'.INVALID_REQUEST.'</div>';
	}

	require_once("includes/footer.php"); 	 
?>


