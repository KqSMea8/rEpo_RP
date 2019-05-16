<?
$OldCode=$NewCode='';
 
$content ='<table '.$table_bg.'>
		<tr align="left">';
	
		$content .= '<td width="11%" class="head1" >Date</td>';
		$content .= '<td width="11%" class="head1" >Source</td>';
		$content .= '<td width="11%" class="head1" >Reference No#</td>';
		$content .= '<td class="head1" >Name</td>';
		$content .= '<td width="15%" class="head1" >Category</td>';
		$content .= '<td width="20%" class="head1" >GL Account</td>';
		$content .= '<td width="8%" class="head1" align="right">Debit ['.$DefaultCurrency.']</td>';
		$content .= '<td width="8%" class="head1" align="right">Credit ['.$DefaultCurrency.']</td>';
		
		if(is_array($arryReport) && $num>0){
			$flag=true;
			$Line=0;
			$totalTaxAmnt=0;
			$TotalDebit = 0;
			$TotalCredit = 0;

			foreach($arryReport as $key=>$values){		
				$ReceivedAmount = '';
				$PaidAmount = '';
	
			 	/*******PK*********/
			 	if(!empty($Config['ModuleCurrencySel'])){		
					if($values["TransactionType"]=='D')$ReceivedAmount = $values["OriginalAmount"];
					if($values["TransactionType"]=='C')$PaidAmount = $values["OriginalAmount"];	

 
					/*************/
					if(!empty($values["ModuleCurrency2"]) && $values["ModuleCurrency2"]!=$values["ModuleCurrency"]&& $_GET['Currency']!=$values["ModuleCurrency"] ){
						if($values["TransactionType"]=='D')$ReceivedAmount = round(GetConvertedAmountReverse($values["ConversionRate"], $ReceivedAmount) ,2);
						if($values["TransactionType"]=='C')$PaidAmount = round(GetConvertedAmount($values["ConversionRate"], $PaidAmount) ,2);
					}
					/*************/
				}else{
					$ReceivedAmount = $values["DebitAmnt"];
					$PaidAmount = 	$values["CreditAmnt"];	
				}
				/**********************/
				$ReceivedAmount = round($ReceivedAmount,2);
				$PaidAmount = round($PaidAmount,2);

				$TotalDebit += $ReceivedAmount;
				$TotalCredit += $PaidAmount;

				$flag=!$flag;		
				$Line++;

				$Name = '';
				if(!empty($values["CustomerName"])){ 
					$Name = stripslashes(ucfirst($values["CustomerName"])); 
				}else if(!empty($values["VendorName"])){ 
					$Name = stripslashes(ucfirst($values["VendorName"]));
				}


				$NewCode = $values["PaymentType"].'#'.$values['ReferenceNo'].'#'.$values["PaymentType"].'#'.$Name;


				$Source='';
				if(!empty($values["SaleID"])){
					$Source = 'SO: '.$values["SaleID"];
				}elseif(!empty($values["PurchaseID"])){
					$Source = 'PO: '.$values["PurchaseID"];
				}elseif(!empty($values["RecPurchaseID"])){
					$Source = 'PO: '.$values["RecPurchaseID"];
				}
				/*************/
				if($OldCode != $NewCode){


				$AccountName = (!empty($arryAccount[0]['AccountName']))?($arryAccount[0]['AccountName']):('');

				$Category = '';
				if($values["PaymentType"]=='Sales'  && $values["EntryType"]=='Invoice'  && $values["PaymentType"]==$AccountName){
					$Category = 'Customer Invoice';
				}else{
					$Category = stripslashes($values["PaymentType"]);
					if(!empty($values['Method'])){
						 $Category .= " - ".$values['Method'];
					}
					if(!empty($AccountName)){ 
						$Category .= " - ".$AccountName;
					}					 
				}

				$NegClass ='';
				if($ReceivedAmount<0 || $PaidAmount<0){
					$NegClass = ' red'; 
				}

		


					$content .='<tr >
						<td  height="30" class="heading" >
						'.date($Config['DateFormat'], strtotime($values['PaymentDate'])).'			 
						</td>
						<td  class="heading">'.stripslashes($Source).'</td> 
						<td  class="heading'.$NegClass.'">'.stripslashes($values["ReferenceNo"]).'</td> 
						<td  class="heading">'.$Name.'</td> 		    
						<td class="heading" colspan="6">'.$Category.'</td> 
					</tr>';

				}
				/*************/

				$PaymentData = '';
				if(!empty($_GET['pk'])){
					$PaymentData = $values["PaymentID"].'#'.$values["OriginalAmount"].'#'.$values["ModuleCurrency"]; 
				} 



				$ReceivedAmountVal = '';
				if($ReceivedAmount>0 || $ReceivedAmount<0){
					$ReceivedAmountVal = number_format($ReceivedAmount,2);
					$ReceivedAmountVal = str_replace("-","",$ReceivedAmountVal);
				}
				$PaidAmountVal = '';
				if($PaidAmount>0 || $PaidAmount<0){
					$PaidAmountVal = number_format($PaidAmount,2);
					$PaidAmountVal = str_replace("-","",$PaidAmountVal);
				}

				$content .='<tr >
						<td colspan="5" align="center">'.$PaymentData.'</td>
						<td>'.ucwords($values["AccountNameNumber"]).'</td> 
						 <td align="right">'.$ReceivedAmountVal.'</td> 
   						 <td align="right">'.$PaidAmountVal.'</td> 
					</tr>';


				/*************/
				$OldCode = $values["PaymentType"].'#'.$values['ReferenceNo'].'#'.$values["PaymentType"].'#'.$Name;
	 		} 

			$TotalDebit = round($TotalDebit,2);
			$TotalCredit = round($TotalCredit,2);

			$TotalDebitVal = '0';
			if($TotalDebit>0 || $TotalDebit<0){				
				$TotalDebitVal = str_replace("-","",$TotalDebit);				 
			}
			$TotalCreditVal = '0';
			if($TotalCredit>0 || $TotalCredit<0){				
				$TotalCreditVal = str_replace("-","",$TotalCredit);
			}


			 $content .='<tr>
			<td  colspan="6" align="right"> <b>Total : </b> </td>
			<td align="right"><b>'. number_format($TotalDebitVal,2).'</b></td> 
			<td align="right"><b>'. number_format($TotalCreditVal,2).'</b></td>
			</tr>';

	}else{
			$content .='<tr align="center" >
			<td  colspan="10" class="no_record">'.NO_RECORD.'</td>
			</tr>';
	} 
  

	$content .='</td>
	</tr>
	</table>';

if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}

//echo $content; exit;
?>

