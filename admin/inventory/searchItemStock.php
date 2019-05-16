<?php 
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
        require_once($Prefix . "classes/inv.class.php");
         require_once($Prefix . "classes/inv_category.class.php");

	
	require_once($Prefix."classes/warehouse.class.php");
	
	$objItem = new items();
	$objCommon = new common();
	$objWarehouse=new warehouse();
        $objCategory = new category();

	/*************************/ 
	if(!empty($_GET['Model']) || !empty($_GET['CatID']) || !empty($_GET['Condition']) || !empty($_GET['Genration'])){
		/*************/
		unset($_SESSION['CatIDs']);unset($_GET['CategoryID']);
		if(!empty($_GET['CatID'])){			
			$objCategory->GetCatIDByParent($_GET['CatID']);
			$ArrayCatID = array_unique($_SESSION['CatIDs']);
			$_GET['CategoryID'] = implode(",",$ArrayCatID);
			//$ArrayCatID = $objCategory->sync_category($_GET['CatID']);
			//$_GET['CategoryID'] = implode(",",$ArrayCatID);
                                 //echo "<pre/>";print_r($objCategory->sync_category($_GET['CatID']));die;
		}
		/*************/


		$arryStockItem=$objItem->StockDetail($_GET);
		$num=$objItem->numRows();

		$pagerLink=$objPager->getPager($arryStockItem,$RecordsPerPage,$_GET['curP']);
		(count($arryStockItem)>0)?($arryStockItem=$objPager->getPageRecords()):("");
		$ShowData = 1;
	}

	if (class_exists(category)) {
	    $objCategory = new category();
	    $arryCategory = $objCategory->GetCategoriesListing(0, 0);
	    $numCategory = $objCategory->numRows();
	} else {
	    echo "Class Not Found Error !! Category Class Not Found !";
	    exit;
	}


	/*************************/
	$arryModel = $objItem->GetModelGen('');
	$arryGeneration = $objCommon->GetCrmAttribute('Generation', '');
	$arryCondition = $objCommon->GetCrmAttribute('Condition', '');
	$arryExtended = $objCommon->GetCrmAttribute('Extended', '');
	$arryManufacture = $objCommon->GetCrmAttribute('Manufacture', '');
	$arryWarehouse = $objWarehouse->GetWarehouseBrief('');
	require_once("../includes/footer.php"); 	
?>


