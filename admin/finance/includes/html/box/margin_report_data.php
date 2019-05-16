<?
 
$content = '<table '.$table_bg.'>
	<tr align="left"  >
		<td width="12%" class="head1">Invoice Date</td>
		<td width="17%" class="head1">Invoice Number#</td>
		<td width="12%" class="head1">PO Number#</td>
		<td width="16%" class="head1" align="right">Sale Price ['.$Config['Currency'].']</td>
		<td width="16%" class="head1" align="right">Cost of Good ['.$Config['Currency'].']</td>
		<td width="16%" class="head1" align="right">Fees ['.$Config['Currency'].']</td>
		<td class="head1" align="right">Margin ['.$Config['Currency'].']</td>		 
	</tr>';

	if(is_array($arrySale) && $num>0){
		$flag=true;
		$Line=0;
		$SubTotalSum=0;
		$AvgCostSum=0;
		$FeeSum=0;
		$MarginSum=0;
		foreach($arrySale as $key=>$values){
			$flag=!$flag;
			$bgclass = (!$flag)?("oddbg"):("evenbg");
			$Line++;
			//$arryShippInfo = $objCommon->GetShippInfoByTrackingId($values['TrackingNo']);	
			//$ShipFreight = $arryShippInfo[0]['totalFreight'];
			/**********************/
			$ConversionRate=1;
			if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
				$ConversionRate = $values['ConversionRate'];			   
			}		

			$SubTotal=$values['SubTotal'];
			$OrginalSubTotal = GetConvertedAmount($ConversionRate, $SubTotal);
			$SubTotalSum += $OrginalSubTotal; 


			$TotalAvgCost = $objSale->GetTotalAverageCost($values['OrderID']);
			$OrginalAvgCost = $TotalAvgCost;//GetConvertedAmount($ConversionRate, $TotalAvgCost);
			$AvgCostSum += $OrginalAvgCost;  

			$Freight = $values['Freight'];
			$OrginalFreight = GetConvertedAmount($ConversionRate, $Freight); 

			$Fee = $values['Fee'];
			$OrginalFee = GetConvertedAmount($ConversionRate, $Fee); 
			$FeeSum += $OrginalFee;  

			$Discount = $values['TDiscount'];
			$OrginalDiscount = GetConvertedAmount($ConversionRate, $Discount); 


			$Margin = ($OrginalSubTotal+$OrginalFreight)  - $OrginalDiscount - $OrginalAvgCost - $OrginalFee; 	
			$MarginSum += $Margin;  
			/**********************/		

			 
			$ModuleDate = $values['InvoiceDate'];
			if(!empty($ExportFile)){			 
				$ModuleID = $values['InvoiceID'];
				$PO = $values['PurchaseID'];
			}else{				 
				$ModuleID = '<a href="vInvoice.php?pop=1&amp;view='.$values['OrderID'].'" class="fancybox fancybig fancybox.iframe">'.$values['InvoiceID'].'</a>';

				
				if(!empty($values['PID'])){
					$PO = '<a href="../purchasing/vPO.php?module=Order&pop=1&view='.$values['PID'].'" class="fancybox fancybig fancybox.iframe">'.$values['PurchaseID'].'</a>';
				}else{
					$PO = $values['PurchaseID'];
				}
			}
		
			$content .='<tr class="'.$bgclass.'">	
			<td>'.date($Config['DateFormat'], strtotime($ModuleDate)).'</td>	
			<td>'.$ModuleID.'</td>	
			<td>'.$PO.'</td>			
			<td align="right">'.number_format($OrginalSubTotal,2).'</td>	
			<td align="right">'.number_format($OrginalAvgCost,2).'</td>
			<td align="right">'.number_format($OrginalFee,2).'</td>
			<td align="right">'. number_format($Margin,2). '</td>		 
			</tr>';
  	 	}  
		 
		$content .= '<tr class="oddbg">							 
			<td height="30" colspan="3" align="right"><b>Grand Total ['.$Config['Currency'].'] : </b></td>			
			<td align="right"> <b>'.number_format($SubTotalSum,2).'</b></td>
			<td align="right"> <b>'.number_format($AvgCostSum,2).'</b></td>
			<td align="right"> <b>'.number_format($FeeSum,2).'</b></td>
			<td align="right"> <b>'.number_format($MarginSum,2).'</b></td>			 
		</tr>';

	}else{
		$content .= '<tr align="center" >
		<td  colspan="8" class="no_record">'.NO_RECORD.'</td>
		</tr>';
	}  		 
	$content .= '</table>';
		 
if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}


?>

