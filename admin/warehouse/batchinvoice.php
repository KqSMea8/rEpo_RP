<?php 
 /**************************************************/
    $ThisPageName = 'viewSalesQuoteOrder.php'; $EditPage = 1;$HideNavigation = 1;
    /**************************************************/
   
    require_once("../includes/header.php");
    require_once($Prefix."classes/warehouse.class.php");
    include_once("language/english.php");
			
    $ModuleName = "Batch Mgmt";
    $RedirectURL = "viewbatchmgmt.php?curP=".$_GET['curP'];
    $EditUrl = "editbatchmgmt.php?edit=".$_GET["edit"];
    $objWarehouse = new warehouse();
		
    $arryBatch =$objWarehouse->ListBatches('','Open');

    require_once("../includes/footer.php"); 
?>


