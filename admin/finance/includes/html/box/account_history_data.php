<?
 $ClubMethodArry = array('prepayment', 'check', 'electronic transfer');	
 $PrevName=$ReferenceNoClub=$TotalFlag=$CountClub55=$PrevPaymentDate='';
 $DataArray = array();
 $ReferenceNoClub = array();

$content ='<table '.$table_bg.'>
		<tr align="left"  >
			<td width="10%"  class="head1">Date</td>
			<td width="8%" class="head1">Reference</td>
			<td class="head1">Name</td>
			<td width="15%" class="head1">Category</td>
			<td width="11%" class="head1" align="right">Beginning Balance</td>
			<td width="8%" class="head1" align="right">Debit</td>
			<td width="8%"  class="head1" align="right">Credit</td>
			<td width="8%"  class="head1" align="right">Net Change</td>
			<td width="10%"  class="head1" align="right">Ending Balance</td>
			<td width="5%"   class="head1 head1_action">Action</td>
	       </tr>';
		$TotalDebit = 0;
		$TotalCredit = 0;
	 
		$Balance = $BeginningBalance;
		 if($num>0 || $BeginningBalance>0){
			$flag = true;
			$Line = 0;
			
			
			$TotalClubPaid = 0;
			$TotalClubReceived = 0;
			$SameCheck = 0;
			$Count = 0;
			$CountClub = 0;
			foreach($arryBankAccountHistory as $key=>$values){  // foreach start //
				$flag=!$flag;
	 
				$Line++;
				$Count++;

				
				$ReceivedAmount = '';
				$PaidAmount = '';
	
				$TransactionID = $values["TransactionID"];
				if(empty($TransactionID)) $TransactionID = $values["PidTransactionID"];
	
				$ReceiptID='';
				if(!empty($TransactionID)){
					$ReceiptID = $objBankAccount->getTransactionReceiptID($TransactionID);
				}


			 	/*******PK*********/
			 	if(!empty($Config['ModuleCurrencySel'])){		
					if($values["TransactionType"]=='D')$ReceivedAmount = $values["OriginalAmnt"];
					if($values["TransactionType"]=='C')$PaidAmount = $values["OriginalAmnt"];	
				}else{
					$ReceivedAmount = $values["DebitAmnt"];
					$PaidAmount = 	$values["CreditAmnt"];	
				}
				/**********************/

if(!empty($_GET['pk'])){ echo  ','.$ReceivedAmount;}

				if($Config['CreditMinusDebit']==1){
					$Balance +=  $PaidAmount - $ReceivedAmount;
				}else{
					$Balance +=  $ReceivedAmount-$PaidAmount;
				}
				$TotalDebit += $ReceivedAmount;
				$TotalCredit += $PaidAmount;

				 $Name='';
				 if(!empty($values["CustomerName"])){
					$Name = stripslashes(ucfirst($values["CustomerName"]));
				 }else if(!empty($values["VendorName"])){
					$Name = stripslashes(ucfirst($values["VendorName"]));
				 }
	
				$Method = trim(strtolower($values['Method']));

				/*************************/
				/*************************/
				#if($PrevName == $Name && $PrevPaymentDate == $values["PaymentDate"] && $PrevPaymentType == $values["PaymentType"] && $PrevMethod == $values['Method'] && $PrevReceiptID == $ReceiptID && $values['Method']!='' && in_array($Method,$ClubMethodArry) ){

				if($PrevName == $Name && $PrevPaymentDate == $values["PaymentDate"] && $PrevPaymentType == $values["PaymentType"] && !empty($ReceiptID) && $PrevReceiptID == $ReceiptID ){
					if(empty($TotalClubPaid)){
						 $TotalClubPaid = $PrevPaidAmount;
						 $ReferenceNoClub[] = $PrevReceiptID;			 
					}
					if(empty($TotalClubReceived)){
						 $TotalClubReceived = $PrevReceivedAmount;
						 $ReferenceNoClub[] = $PrevReceiptID;			 
					}
		

					$TotalClubPaid += $PaidAmount;
					$TotalClubReceived += $ReceivedAmount;
					$ReferenceNoClub[] = $ReceiptID;
					$SameCheck = 1;	
					$TotalFlag = 1;	
					 
				 	unset($DataArray[$Count-1]); 
				}else{		
					$SameCheck = 0;

					if(!empty($ReferenceNoClub[0])){
						$ReferenceNoClub = array_unique($ReferenceNoClub);
						$CheckRef = implode(", ", $ReferenceNoClub);
						unset($ReferenceNoClub);
					}
					 
				}

				if($SameCheck==0 && $TotalFlag>0){
				 	$CountClub++;
					$BeginningBalanceStart = ($CountClub==1 && !isset($DataArray[1]))?(number_format($BeginningBalance,2)):('');
					$contentTotal = '<tr>
					<td>'.date($Config['DateFormat'], strtotime($PrevPaymentDate)).'</td>
					<td>'.$CheckRef.'</td>
					<td>'.$PrevName.'</td>
					<td>'.stripslashes($PrevPaymentType).' - '.$PrevMethod;
					if($PrevMethod=='Check') $contentTotal .= ' - '.$PrevCheckNumber;
					$contentTotal .= '</td>
					<td align="right"><strong>'.$BeginningBalanceStart.'</strong></td>';

					if($PrevPaymentType=='Sales' && !empty($TotalClubReceived) && !empty($TotalClubPaid)){
						$TotalClubReceived = $TotalClubReceived - $TotalClubPaid;
						$TotalClubPaid = 0;
					}else if($PrevPaymentType=='Purchase' && !empty($TotalClubReceived) && !empty($TotalClubPaid)){
						$TotalClubPaid = $TotalClubPaid - $TotalClubReceived;
						$TotalClubReceived = 0;
					}
		



					$contentTotal .= '<td align="right">';
					if($TotalClubReceived>0 || $TotalClubReceived<0){
						$TotalClubReceived = round($TotalClubReceived,2);	
						$TotalClubReceivedShow = str_replace("-","",$TotalClubReceived);
						$contentTotal .= number_format($TotalClubReceivedShow,2);
					}

					$contentTotal .= '</td>';

					$contentTotal .= '<td align="right">';
					if($TotalClubPaid>0 || $TotalClubPaid<0){
						$TotalClubPaid = round($TotalClubPaid,2);
						$TotalClubPaidShow = str_replace("-","",$TotalClubPaid);
						$contentTotal .= number_format($TotalClubPaidShow,2);
					}
					$contentTotal .= '</td>';

					$contentTotal .= '<td>'.$CountClub55.'</td>
					<td align="right"><strong>'.number_format($PrevBalance,2).'</strong></td>
					<td></td>
					</tr>';
					$TotalClubReceived = 0;
					$TotalClubPaid = 0;
					$TotalFlag = 0;	

					 					
					$DataArray[$Count] = $contentTotal;
					unset($DataArray[$Count-1]); 

					$Count++;

				}
				/*************************/
				/*************************/

			$ReferenceNoShow = (!empty($ReceiptID))?($ReceiptID):(stripslashes($values["ReferenceNo"]));
			$BeginningBalanceStart = ($Line==1)?(number_format($BeginningBalance,2)):('');
			$ReceivedAmountShow = ($ReceivedAmount>0 || $ReceivedAmount<0)?(number_format($ReceivedAmount,2)):('');
			$ReceivedAmountShow = str_replace("-","",$ReceivedAmountShow);

			$PaidAmountShow = ($PaidAmount>0 || $PaidAmount<0)?(number_format($PaidAmount,2)):('');
			$PaidAmountShow = str_replace("-","",$PaidAmountShow);

			$BalanceShow = str_replace("-","",$Balance);

			$PaymentIDShow = (!empty($_GET['pk']))?($values["PaymentID"].'#'.$PaidAmount.'#'.$ReceivedAmount):('');

			$Category='';
			if($values["PaymentType"]=='Sales'  && $values["EntryType"]=='Invoice'  && $values["PaymentType"]==$arryAccount[0]['AccountName']){
				$Category = 'Customer Invoice';
			}else{
				$Category = stripslashes($values["PaymentType"]);
				if(!empty($values['Method'])){
					 $Category .= " - ".$values['Method'];
					if($values['Method']=='Check' && !empty($values['CheckNumber'])){
						 $Category .= " - ".$values['CheckNumber'];
					}
				}
				if(!empty($AccountName)){ 
					 $Category .= " - ".$AccountName;
				}
			}

			/*************************/
			$Links = '';
			if(empty($ExportFile)){
				if(!empty($values['JournalID'])){
					$Links = '<a href="vGeneralJournal.php?pop=1&amp;view='.$values['JournalID'].'" class="fancybox po fancybox.iframe">'.$view.'</a>';
				}
				if(!empty($values['InvoiceID']) && $values['PaymentType'] == 'Sales'){
					$Links = '<a href="receiveInvoiceHistory.php?pop=1&amp;InvoiceID='.$values['InvoiceID'].'&edit='.$values['OrderID'].'&InvoiceID='.$values['InvoiceID'].'" class="fancybox po fancybox.iframe">'.$view.'</a>';
				}
				if(!empty($values['InvoiceID']) && $values['PaymentType'] == 'Purchase'){
					$Links = ' <a href="payInvoiceHistory.php?pop=1&amp;po='.$values['PurchaseID'].'&view='.$values['OrderID'].'&inv='.$values['InvoiceID'].'" class="fancybox po fancybox.iframe">'.$view.'</a>';
				}	 	
				if(!empty($values['ExpenseID'])){$Flag=1;
					$Links = '<a href="vOtherExpense.php?pop=1&amp;Flag='.$Flag.'&amp;view='.$values['ExpenseID'].'" class="fancybox po fancybox.iframe">'.$view.'</a>';
				} 

				if(!empty($values['TransferID'])){
					$Links = '<a href="vTransfer.php?pop=1&amp;view='.$values['TransferID'].'" class="fancybox po fancybox.iframe">'.$view.'</a>';
				}
				if(!empty($values['DepositID'])){
					$Links = '<a href="vDeposit.php?pop=1&amp;view='.$values['DepositID'].'" class="fancybox po fancybox.iframe">'.$view.'</a>';
				}

			}
			/*************************/
			 
			$DataArray[$Count] = '<tr class="row'.$Line.'">
				<td>'.date($Config['DateFormat'], strtotime($values['PaymentDate'])).'</td>
				<td>'.$ReferenceNoShow.'</td> 
				<td>'.$Name.'</td> 
				<td>'.$Category.'</td>
				<td align="right"><strong>'.$BeginningBalanceStart.'</strong></td>
				<td align="right">'.$ReceivedAmountShow.'</td>
				<td align="right">'.$PaidAmountShow.'</td>
				<td align="right">'.$PaymentIDShow.'</td>
				<td align="right"><strong>'.number_format($BalanceShow,2).'</strong></td> 
				<td align="center"  class="head1_inner">'.$Links.'</td> 
			</tr>';  
  	
			 



			$PrevPaymentDate = $values['PaymentDate'];
			$PrevReferenceNo = $values["ReferenceNo"];
			$PrevReceiptID = $ReceiptID;
			$PrevPaymentType = $values["PaymentType"];
			$PrevMethod = $values["Method"];
			$PrevCheckNumber = $values['CheckNumber'];
			$PrevPaidAmount = $PaidAmount;
			$PrevReceivedAmount = $ReceivedAmount;
			$PrevName = $Name;
			$PrevBalance = $Balance; 
 			
				
	 	} // foreach end //
			

		
/*************************/
/*************************/
$SameCheck = 0;
if(!empty($ReferenceNoClub[0])){
	$ReferenceNoClub = array_unique($ReferenceNoClub);
	$CheckRef = implode(", ", $ReferenceNoClub);
	unset($ReferenceNoClub);
}

if($SameCheck==0 && $TotalFlag>0){	
	$Count++;		
	$contentTotal = '<tr>
	<td>'.date($Config['DateFormat'], strtotime($PrevPaymentDate)).'</td>
	<td>'.$CheckRef.'</td>
	<td>'.$PrevName.'</td>
	<td>'.stripslashes($PrevPaymentType).' - '.$PrevMethod;
	if($PrevMethod=='Check')$contentTotal .= ' - '.$PrevCheckNumber;
	$contentTotal .= '</td>
	<td></td>';

	if($PrevPaymentType=='Sales' && !empty($TotalClubReceived) && !empty($TotalClubPaid)){
		$TotalClubReceived = $TotalClubReceived - $TotalClubPaid;
		$TotalClubPaid = 0;
	}else if($PrevPaymentType=='Purchase' && !empty($TotalClubReceived) && !empty($TotalClubPaid)){
		$TotalClubPaid = $TotalClubPaid - $TotalClubReceived;
		$TotalClubReceived = 0;
	}
		



	$contentTotal .= '<td align="right">';
	if($TotalClubReceived>0 || $TotalClubReceived<0){
		$TotalClubReceivedShow = str_replace("-","",$TotalClubReceived);
		$contentTotal .= number_format($TotalClubReceivedShow,2);
	}
	$contentTotal .= '</td>';

	$contentTotal .= '<td align="right">';
	if($TotalClubPaid>0 || $TotalClubPaid<0){
		$TotalClubPaidShow = str_replace("-","",$TotalClubPaid);
		$contentTotal .= number_format($TotalClubPaidShow,2);
	}
	$contentTotal .= '</td>';

	$contentTotal .= '<td></td>
	<td align="right"><strong>'.number_format($PrevBalance,2).'</strong></td>
	<td></td>
	</tr>';
	$TotalClubReceived = 0;
	$TotalClubPaid = 0;
	$TotalFlag = 0;	 


	$DataArray[$Count] = $contentTotal; 	
	unset($DataArray[$Count-1]); 
}
/*************************/
/*************************/



		/*************************/
		foreach($DataArray as $value){ 
			$content .= $value;
		}
		/*************************/



	}else{
			$content .='<tr align="center" >
			<td  colspan="10" class="no_record">'.NO_RECORD.'</td>
			</tr>';
	} 


  
$TotalDebit = round($TotalDebit,2);
$TotalCredit = round($TotalCredit,2);

if($Config['CreditMinusDebit']==1){
	$TotalNetChange = $TotalCredit - $TotalDebit;
}else{
	$TotalNetChange = $TotalDebit - $TotalCredit;
}

$content .= '<tr> 
	<td colspan="4" align="right" >
	<strong>Report Total : </strong>
	</td>
	<td align="right"><strong>'.number_format($BeginningBalance,2).'</strong></td>
	<td align="right"><strong>'.number_format($TotalDebit,2).'</strong></td>
	<td align="right"><strong>'.number_format($TotalCredit,2).'</strong></td>
	<td align="right"><strong>'.number_format($TotalNetChange,2).'</strong></td>
	<td align="right"><strong>'.number_format($Balance,2).'</strong></td>
	<td ></td>
</tr>';



	$content .=' 
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

