<?php
	require_once("../includes/header.php");



if(empty($_SESSION['WorkspaceFin']) && $arryCompany[0]['Department']!=8){ 
		$arryDefaultScreen = $objConfig->getDefaultScreen();		
		if($arryDefaultScreen[0]['Status']=='1'){		
			header('location:workspacefin.php?locationID='.$_GET['locationID']);
			exit;
		}
	}


	 
	require_once("../includes/footer.php"); 
?>
