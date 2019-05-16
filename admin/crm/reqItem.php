<?php 
	$HideNavigation = 1; 
	/**************************************************/
	//$ThisPageName = 'viewQuote.php?module=Quote'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");	
	require_once($Prefix."classes/quote.class.php");
	$objItem = new items();
	$objQuote = new quote();
	/*************************/
	if($_GET['oid']>0){
		$arryOrderItem = $objQuote->GetRequiredItem($_GET['oid']);
		$ParentItem = $arryOrderItem[0]['sku'];		
		/********************/
		$RequiredItem = $arryOrderItem[0]['req_item'];
		if(!empty($RequiredItem)){
			$arryReqItem = explode("#",$RequiredItem);
			$Count=0;
			foreach($arryReqItem as $values_sal){
				$arryTemp = explode("|",$values_sal);
				$arryRequired[$Count]["item_id"] = $arryTemp[0];
				$arryRequired[$Count]["sku"] = $arryTemp[1];
				$arryRequired[$Count]["description"] = $arryTemp[2];
				$arryRequired[$Count]["qty"] = $arryTemp[3];
				$Count++;
			}
			$num = sizeof($arryRequired);
		}
		/********************/

	}else if($_GET['item']>0){
		$arryItem = $objItem->GetItemById($_GET['item']);
		$ParentItem = $arryItem[0]['Sku'];

		$arryRequired = $objItem->GetRequiredItem($_GET['item'],'');
		$num = sizeof($arryRequired);
		
	}
	/*************************/ 
	require_once("../includes/footer.php"); 	
?>
