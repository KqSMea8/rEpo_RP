<?php 
	$HideNavigation = 1;
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv.condition.class.php");
	
	$objItem=new items();
	$objCondition = new condition();
	$Itemval   =   $objItem->GetItemBySku($_GET['sku']);
	/*if($Itemval[0]['itemType'] == 'Kit' || $Itemval[0]['itemType'] == 'Non Kit' )
	{	
		$optionsArr = $objItem->getOptionCode($Itemval[0]['ItemID']);
		if(empty($optionsArr))
		{		
			$arryProduct = $objItem->GetKitItem($Itemval[0]['ItemID']);//
		}
        }else{
		$arryProduct = $Itemval;
	}*/


$bomArr = $objItem->KitItemsOfComponent($Itemval[0]['ItemID']);

	    $num    = $objItem->numRows();	

	
$ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($_GET["condition"]);
require_once("../includes/footer.php"); 
?>
