<?php
		
	//$FancyBox=1;
	/* * *********************************************** */
$ThisPageName = 'viewRmaAction.php';
$EditPage = 1;
	/* * *********************************************** */
require_once("../includes/header.php");
require_once($Prefix . "classes/warehouse.class.php");
		
		$objrmaaction = new warehouse();
		
		$RedirectURL = "viewRmaAction.php?curP=" . $_GET['curP'] . "&module=" . $_GET["module"];
		
		if ($_POST) { 
		
		    if (empty($_POST['binid'])) {
		     
		        $objrmaaction->AddRMAAction($_POST);
		        $_SESSION['mess_warehouse'] = "Added Successfully";
		
		    } else {
		        	
		         $objrmaaction->UpdateRMAAction($_POST,$_GET['edit']);
		        $_SESSION['mess_warehouse'] ="RMA Action has been updated successfully..";
		    }
		
		    if (!empty($_GET['edit'])) {
		        header("Location:" . $RedirectURL);
		        exit;
		    } else {
		        header("Location:" . $RedirectURL);
		        exit;
		    }
		}
		if ($_GET['edit'] > 0) {
		
		    $arryBin = $objrmaaction->getrmadata($_GET['edit']);
		}
		
		$warehouse_listted = $objrmaaction->AllWarehousesaction('');
		
		require_once("../includes/footer.php");
		?>