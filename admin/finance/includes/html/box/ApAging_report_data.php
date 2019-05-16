<?

/*****************************************************/
$content ='<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable" >';
		
			$content .='<tr align="left" class="RowFirst">';
			$content .='<td class="head1" align="center" nowrap ><b>Vendor</b></td>  
			<td class="head1"  align="center" nowrap><b>Invoice Date</b></td>    
			<td class="head1" align="center" nowrap><b>Invoice/Credit Memo #</b></td>   
			<td class="head1" align="center" nowrap><b>Payment Term</b></td>   
			<td class="head1" align="center" nowrap><b>Due Date</b></td>  
			<td class="head1" align="center" nowrap><b>PO #</b></td>              
			<td class="head1" align="center" nowrap><b>Invoice Amount</b></td> ';
			$content .=' <td class="head1" align="center" nowrap>';

			if(empty($_GET['Currency'])){ $content .= '<b>Conversion Rate</b>'; } $content .='</td>';
			$content .='<td class="head1" align="center" nowrap>';
			$content .='<b>Original Amount</b>'; 
			if(empty($_GET['Currency'])){ $content .= $Config['Currency']; } $content .='</td>'; 

			$content .='<td class="head1" align="center" nowrap><b>Balance</b> </td>  
			<td class="head1" align="center" nowrap><b>Current </b></td>  
			<td class="head1" align="center" nowrap><b>30 Days </b></td>
			<td class="head1" align="center" nowrap><b>60 Days</b> </td>
			<td class="head1" align="center" nowrap><b>90 Days </b></td>
			<td class="head1" align="center" nowrap><b>120 Days</b></td>';
$content .='</tr>';


if(is_array($arryAging) && $num>0){
		$flag=true;
		$Line=0;
				$TotalOriginalAmount=0;
				$TotalUnpaidInvoice = 0;
				$TotalCurrentBalance = 0;
				$TotalBalance30 = 0;
				$TotalBalance60 = 0;
				$TotalBalance90 = 0;
				$TotalBalance120 = 0;
				$VendorOriginalAmount = 0;
				$VendorUnpaidInvoice = 0;
				$VendorCurrentBalance = 0;
				$VendorBalance30 = 0;
				$VendorBalance60 = 0;
				$VendorBalance90 = 0;
				$VendorBalance120 = 0;

		foreach($arryAging as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;


		$ConversionRate=1;
		if($values['Currency']!=$Config['Currency'] && $values['ConversionRate']>0 ){				
			$ConversionRate = $values['ConversionRate'];	
		 
		}

		$CurrentBalance = 0;
		$Balance30 =  0;
		$Balance60 =  0;
		$Balance90 =  0;
		$Balance120 =  0;
	 	/***********************/
		$ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
			 if($values['InvoiceEntry'] == '2' || $values['InvoiceEntry'] == '3') { 
				$ModuleLink = ''.$values["InvoiceID"].'';
			 } else { 
				$ModuleLink = $values["InvoiceID"];
			} 

		

		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];			 
			$ModuleLink = $values["CreditID"];

		
		}
		



         	$OrderAmount = $orginalAmount;
		$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount);         
                $PaidAmnt = $values['PaidAmnt'];

		if(!empty($_GET['Currency']) && $values['Currency']!=$BaseCurrency && $values['ConversionRate']>0){
			$PaidAmnt = GetConvertedAmountReverse($values['ConversionRate'], $PaidAmnt); 
		}

                if($PaidAmnt !=''){
                    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
                }else{
                    $UnpaidInvoice = $orginalAmount;
                }
                
		/***********************/
		$AgingDay = GetAgingDay($values['PostedDate']); 
		switch($AgingDay){
			case '1': $CurrentBalance = $UnpaidInvoice; break;
			case '2': $Balance30 = $UnpaidInvoice; break;
			case '3': $Balance60 = $UnpaidInvoice; break;
			case '4': $Balance90 = $UnpaidInvoice; break;
			case '5': $Balance120 = $UnpaidInvoice; break;
		} 
		/***********************/

                $TotalUnpaidInvoice +=$UnpaidInvoice;
                
                $TotalCurrentBalance +=$CurrentBalance;
                $TotalBalance30 +=$Balance30;
                $TotalBalance60 +=$Balance60;
                $TotalBalance90 +=$Balance90;
                $TotalBalance120 +=$Balance120;

		

                if(empty($values["SuppCompany"])){ 
                	$SupplierName = $objBankAccount->getSupplierName($values['SuppCode']);
                }else{
                	$SupplierName = $values["SuppCompany"];
                }


		if(!empty($values["PaymentTerm"])){
			$arryTerm = explode("-",$values["PaymentTerm"]);
			$arryDate = explode("-",$values['PostedDate']);
			list($year, $month, $day) = $arryDate;

			$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
			$DueDate = date("Y-m-d",$TempDate);
			$DueDate = date($Config['DateFormat'], strtotime($DueDate));
		}else{
			$DueDate = '';
		}


if(($NewSuppCode != '' && $NewSuppCode != $values['SuppCode'])){ 

			$VendorUnpaidInvoice += -$CreditAmount;
			$VendorCurrentBalance += -$CreditAmount;
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
			$VendorTotal = '<tr class="evenbg">
			<td colspan="8" align="right" height="30"><b> Total : </b></td>
			<td><b>'. number_format($VendorOriginalAmount,2).'</b></td>
			<td><b>'.number_format($VendorUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($VendorCurrentBalance,2).'</b></td>
			<td><b>'.number_format($VendorBalance30,2).'</b></td>
			<td><b>'.number_format($VendorBalance60,2).'</b></td>
			<td><b>'.number_format($VendorBalance90,2).'</b></td>
			<td><b>'.number_format($VendorBalance120,2).'</b></td>
			</tr>';
		 	$content .= $VendorTotal;
			$VendorOriginalAmount=0;
			$VendorUnpaidInvoice = 0;
			$VendorCurrentBalance = 0;
			$VendorBalance30 = 0;
			$VendorBalance60 = 0;
			$VendorBalance90 = 0;
			$VendorBalance120 = 0;

                        


		} 

if($NewSuppCode != $values['SuppCode']){ 

$content .=	'<tr>
		<td colspan="4" height="30" align="left" class="head1">
	<b>'.stripslashes(ucfirst($SupplierName)).'</b>
		</td>
		<td colspan="4" class="head1"><b>Phone:</b> '.$values['Landline'].'	</td>
		<td colspan="4" class="head1"><b>Contact :</b> 	'.$values['ContactPerson'].'  </td>	
		<td colspan="3" class="head1"><b>Credit Limit:</b> '.$values['CreditLimit'].'</td>
		</tr>';
		 $CreditAmount = $values['CreditAmount']; 
			if($CreditAmount>0){
		
		$content .= '<tr>
			<td></td>
			<td></td>
			<td colspan="2">Vendor Credit</td>
			<td colspan="5"></td>
			<td><b>'.$CreditAmount.'</b></td>
			<td>-'.$CreditAmount.'</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>';
		 } 
		}

 $content .= '<tr align="left" >
                <td>  </td>
		<td>'.date($Config['DateFormat'], strtotime($values['PostedDate'])).'</td>
		<td>'.$ModuleLink.'</td>		 
		<td>'.stripslashes($values["PaymentTerm"]).'</td>
		<td>'.$DueDate.' </td>
		<td>'.$values["PurchaseID"].'</td>
            
                <td>'.$OrderAmount. " ".$values["Currency"].'</td>
               
              <td>';
			 
			if($ConversionRate!=1){	
				$content .= $ConversionRate;			   
			}

		 
	


			$content .= 	'</td>';
			$content .= '<td>'; 
			$content .= number_format($orginalAmount,2);
			$TotalOriginalAmount  +=$orginalAmount;
			$content .= '</td>';
			$content .= '<td><b>'.number_format($UnpaidInvoice,2).'</b></td>
			<td>'.(!empty($CurrentBalance))?(number_format($CurrentBalance,2)):('-').'</td>
			<td>'.(!empty($Balance30))?(number_format($Balance30,2)):('-').'</td>
			<td>'.(!empty($Balance60))?(number_format($Balance60,2)):('-').'</td>
			<td>'.(!empty($Balance90))?(number_format($Balance90,2)):('-').'</td>
			<td>'.(!empty($Balance120))?(number_format($Balance120,2)):('-').'</td>';
			$content .= '</tr>';

			$NewSuppCode = $values['SuppCode'];
			$Supplier = $SupplierName;

			$VendorOriginalAmount +=$orginalAmount;
			$VendorUnpaidInvoice +=$UnpaidInvoice;
			$VendorCurrentBalance +=$CurrentBalance;
			$VendorBalance30 +=$Balance30;
			$VendorBalance60 +=$Balance60;
			$VendorBalance90 +=$Balance90;
			$VendorBalance120 +=$Balance120;

} // foreach end //


		if(empty($_GET['s'])){
			
			$VendorUnpaidInvoice += -$CreditAmount;
			$VendorCurrentBalance += -$CreditAmount;
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
			$VendorTotal = '<tr class="evenbg">
			<td colspan="8" align="right" height="30"><b>Total : </b></td>
                        <td><b>'.number_format($VendorOriginalAmount,2).'</b></td>
			<td><b>'.number_format($VendorUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($VendorCurrentBalance,2).'</b></td>
			<td><b>'.number_format($VendorBalance30,2).'</b></td>
			<td><b>'.number_format($VendorBalance60,2).'</b></td>
			<td><b>'.number_format($VendorBalance90,2).'</b></td>
			<td><b>'.number_format($VendorBalance120,2).'</b></td>
			</tr>';
			$content .= $VendorTotal;
		}else{
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
		}
	

		$content .= '<tr>
		<td colspan="8" align="right"><b>Total : </b></td>
                <td><b>'.number_format($TotalOriginalAmount,2).'</b></td>
		<td><b>'.number_format($TotalUnpaidInvoice,2).'</b></td>
		<td><b>'.number_format($TotalCurrentBalance,2).'</b></td>
		<td><b>'.number_format($TotalBalance30,2).'</b></td>
		<td><b>'.number_format($TotalBalance60,2).'</b></td>
		<td><b>'.number_format($TotalBalance90,2).'</b></td>
		<td><b>'.number_format($TotalBalance120,2).'</b></td>
		</tr>';

		 }else{
		$content .= '<tr align="center" >
		<td  colspan="15" class="no_record">'.NO_RECORD.' </td>
		</tr>';
		 } 


	
		$content .='</table>';
		//$content .='</div>'; 
		
	

if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}

#echo $content; exit;
?>
