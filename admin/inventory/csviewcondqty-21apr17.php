<?php 
	$HideNavigation = 1;
 	include_once("../includes/header.php");
	require_once($Prefix."classes/item.class.php");
	require_once($Prefix."classes/inv.condition.class.php");
	require_once($Prefix."classes/custom_search.class.php"); //added on 19Apr2017 by chetan//
	$objItem=new items();
	$objCondition = new condition();
	$Itemval   =   $objItem->GetItemBySku($_GET['sku']);
	if($Itemval[0]['itemType'] == 'Kit' || $Itemval[0]['itemType'] == 'Non Kit' )
	{	
		$optionsArr = $objItem->getOptionCode($Itemval[0]['ItemID']);
		if(empty($optionsArr))
		{		
			$arryProduct = $objItem->GetKitItem($Itemval[0]['ItemID']);//
		}
        }else{
		$arryProduct = $Itemval;
	}
	/*if(empty($arryProduct))
	{
		$arryCondQty=$objItem->getItemCondion($values[0]['Sku'],'');
		$arryProduct = (count($arryCondQty) > 0) ? $values  : array() ;
	}*/
	//print_r($arryProduct);
	/*$tablestr = '';
	$tablestr = '<tr><td colspan="8">
			<table align="center" cellspacing="1" cellpadding="3" width="100%" id="list_table" class="table-popup">';
	     
        if(!empty($Arr))
        {       
		$add = (count($Arr) > 1) ? '<td width="20%"class="head1">Sku</td>' : '';
		$count = count($Arr);
		$tablestr .= '<tr align="left" valign="middle">'.$add.'
				<td width="20%"class="head1">Condition</td>
				<td  width="20%"class="head1">Qty</td>
				<td  width="20%"class="head1">Average Cost</td>
			    </tr>';        		
		foreach($Arr as $val)
                {	    
			$arryCondQty=$objItem->getItemCondion($val['sku'],'');
			$numQty =count($arryCondQty);    
			if (is_array($arryCondQty) && $numQty > 0) 
			{
				$hvhtml = $this->toReturnTableHtml($arryCondQty,$val,$arr,$count);
				$html  .= $hvhtml;
				$tablestr .= $hvhtml;
			}                
                }
		$tablestr .= '<tr>&nbsp;</tr>';
		$tablestr .= '</table></td></tr>';
		return ($html) ?  $tablestr : false;
		
        }else{
		$ItemDtl   =   $objItem->GetItemById($values['ItemID']);
		$arryCondQty=$objItem->getItemCondion($ItemDtl[0]['Sku'],'');
		$numQty =count($arryCondQty);   
		if (is_array($arryCondQty) && $numQty > 0) 
		{
			$hvhtml .= $this->toReturnTableHtml($arryCondQty,$ItemDtl[0],$arr);
			$html  .= $hvhtml;
			$tablestr .= $hvhtml;
			$tablestr .= '<tr>&nbsp;</tr>';
			$tablestr .= '</table></td></tr>';
			return ($html) ?  $tablestr : false;
		}
	}*/	

$ConditionSelectedDrop  =$objCondition-> GetConditionDropValue($_GET["condition"]);
require_once("../includes/footer.php"); 
?>
