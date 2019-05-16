<?php
	$HideNavigation = 1;
	require_once("../includes/header.php");

	if(!empty($_POST['idToShow'])){
		CleanPost(); 
		$ID = implode(",",$_POST['idToShow']);
		$objConfig->updateBlockStatus($ID,1);
		echo '<script>window.parent.location.href="workspacefin.php";</script>';
		exit;
	}


	require_once("../includes/menu.php");
	$arryBlock = $objConfig->getBlockRows(0);


	require_once("../includes/footer.php"); 
?>
