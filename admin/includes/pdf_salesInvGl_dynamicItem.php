<?php

/****************************pdf_salesInvGl_dynamicItem.php*********************************/
if($arryOtherIncome[0]['GlEntryType']=="Multiple"){
$LineItem = ' <table id="itemtable" style="width:100%; border:0;cellpadding:0; cellspacing:0;border-collapse:collapse; vertical-align: top;"><tbody><tr style=" background:' . $LineHeadbackColor . '; vertical-align: top;">
        
        <td valign="top" style="width:45%; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">
           GL Account
        </td>
                <td valign="top" style="width:25%; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Amount</td>
                <td valign="top" style="width:30%; vertical-align: top; border:1px solid #e3e3e3;color:#fff;text-align:left; font-size:' . $LineItemFontSize . 'px; font-weight:' . $LineItemHeadingBold . '; color:' . $LineHeadColor . ';">Notes</td>
                
            </tr></tbody></table>';

	 $Line = 0;
	foreach ($arryMultiAccount as $key => $values) {
		 $Line++;	
		if (($Line % 2) != '1') {
		     $oddeven = 'oddrow';
		} else {
		    $oddeven = 'evenrow';
		}


		$LineItem .= '<table style="width:100%;">
					<tbody><tr class="'.$oddeven.'">
				    <td style="width:45%;text-align:left;">'.$values['AccountName']. ' ['.$values['AccountNumber'].']'.'</td>
					<td style="width:25%;text-align:left;">'.number_format($values['Amount'],2).'</td>
					<td style="width:30%;text-align:left;">'.stripslashes($values['Notes']).'</td>
		 
					</tr>					
					</tbody>
			</table>';



	}



}

/*************************************************************/


	$TotalAmount = $arrySale[0]['TotalInvoiceAmount'];

	/***********/	
	$TotalBalanceArry=array();			
 	if($arrySale[0]['PostToGL'] == "1" && $arrySale[0]['InvoicePaid']=='Part Paid'){ 
		$paidOrderAmnt = $objBankAccount->GetTotalPaymentInvoice($arrySale[0]['InvoiceID'],"Sales");
	   	if(!empty($paidOrderAmnt)){ 	
		      $Balance =  $arrySale[0]['TotalInvoiceAmount'] - $paidOrderAmnt; 
		       if($Balance>0) $TotalBalanceArry = array( '<span style="color:red">Balance:</span> ' => '<span style="color:red">'.$arrySale[0]['CustomerCurrency'].' '.number_format($Balance,2).'</span>');	
	        }
	}
	/***********/


   /***************************/
	 $TotalAmountBC='';
        /*if($arrySale[0]['CustomerCurrency'] != $Config['Currency']){ 
		 
		  $TotalAmountBC =round(GetConvertedAmount($arrySale[0]['ConversionRate'], $TotalAmount) ,2);
		  $TotalAmountBC = '<br><span style="color:red">('.$TotalAmountBC.' '.$Config['Currency'].')</span>';
	
	}	
	/***************************/
     
    $TotalDataShowArry = array( 'Grand Total: ' => $arrySale[0]['CustomerCurrency'].' '.number_format($TotalAmount,2).$TotalAmountBC);
     


if(!empty($TotalBalanceArry)){
		$TotalDataShowArry = array_merge($TotalDataShowArry, $TotalBalanceArry);	
} 
?>


	
