<?

 
/*$numHead = sizeof($reportHeader);
$numDate = sizeof($arrYDate);

$width = 100;
if($arryReport[0]['PunchCheck'] == 'Yes'){
	$width = $width + 150;
}
if($arryReport[0]['BreakCheck'] == 'Yes'){
	$width = $width + 350;
}



$tdwidth = 90;
$WeekNo = 1;
$weekColspan = 1;

if($ShowWeekly==1 && $Payroll==1){
	$weekColspan = 2;
}

if($arryCurrentLocation[0]['Overtime']==1){
	$Overtime = 1;	
	$weekColspan++;	
}else{
	$GlobalOvertimeRate = $OvertimeRate;
}

$monthColspan = $weekColspan;

*/

//$tdwidth = 45;
//$headNum = $numDate+ $numHead+1;
/******************/

/****************** START FIRST ROW ******************/
/*****************************************************/
$content ='<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable" >
		<tr align="left" class="RowFirst">';
/*	for ($j = 0; $j < $numHead; $j++) {
		
		if($reportHeader[$j][1] == "UserName"){
			$left=159*$j + 24;
			$ColFirstCls = 'ColFirst';			
			$ColStyle= 'left:'.$left.'px;';		
		}else{
			$ColFirstCls = '';	
			$ColStyle= '';		
		}
			
		$content .='<td class="head1 '.$ColFirstCls.'" style="min-width:150px;max-width:150px;'.$ColStyle.'">'.$reportHeader[$j][0].'</td>';		
	}
	$content .= '<td class="head1" nowrap >Exempt</td>';
	if($Payroll==1){
		$content .= '<td class="head1" nowrap >Pay Cycle</td>';
		$content .= '<td class="head1" nowrap >Hourly Rate</td>';
		$monthColspan=$monthColspan+1;
	}

	for($dat=0;$dat<$numDate;$dat++){
		$strtotimeVal = strtotime($arrYDate[$dat]);
		$DinNo = date("w",$strtotimeVal);
		$Day = date("d",$strtotimeVal);
		$content .= '<td class="head1">'.date("m/d/Y",$strtotimeVal).' </td>';


		
		if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
			$content .= '<td class="head1 red" colspan="'.$monthColspan.'" align="center" nowrap><strong>Semi-Month End</strong></td>';
		}
		if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
			$content .= '<td class="head1 red" colspan="'.$monthColspan.'"  align="center" nowrap><strong>Month End</strong></td>';
		}


		if($WeekEndNo==$DinNo){
			$content .= '<td class="head1 red" colspan="'.$weekColspan.'" align="center" nowrap><strong>Week '.$WeekNo.'</strong></td>';
			$WeekNo++;
		}
		

	}
	
$WeekNo = 1;*/

$content .='<td class="head1" align="center" nowrap >Customer</td>  
		<td class="head1"  align="center" nowrap>Invoice Date</td>    
		<td class="head1" align="center" nowrap>Invoice/Credit Memo #</td>   
		<td class="head1" align="center" nowrap>Payment Term</td>   
		<td class="head1" align="center" nowrap>Due Date</td>  
		<td class="head1" align="center" nowrap>SO #</td>
                <td class="head1" align="center" nowrap>Order Source</td>               
                <td class="head1" align="center" nowrap>Invoice Amount</td> ';
               $content .=' <td class="head1" align="center" nowrap>';

 if(empty($_GET['Currency'])){ $content .= 'Conversion Rate'; } $content .='</td>' 
                $content .='<td class="head1" align="center" nowrap>Original Amount'; 
 if(empty($_GET['Currency'])){ $content .= '['.$Config['Currency'].']' } $content .='</td>'; 
  
		$content .='<td class="head1" align="center" nowrap>Balance </td>  
		<td class="head1" align="center" nowrap>Current </td>  
		<td class="head1" align="center" nowrap>30 Days </td>
		<td class="head1" align="center" nowrap>60 Days </td>
		<td class="head1" align="center" nowrap>90 Days </td>
		<td class="head1" align="center" nowrap>120 Days</td>';



$content .='</tr>';


/****************** START SECOND ROW *****************/

if(is_array($arryAging) && $num>0){
		$flag=true;
		$Line=0;
		$TotalOriginalAmount = 0;
                $TotalUnpaidInvoice = 0;
                $TotalCurrentBalance = 0;
                $TotalBalance30 = 0;
                $TotalBalance60 = 0;
                $TotalBalance90 = 0;
		$TotalBalance120 = 0;
                
              
		
      
                
 		$CustomerOriginalAmount = 0;
		$CustomerUnpaidInvoice = 0;
		$CustomerCurrentBalance = 0;
                $CustomerBalance30 = 0;
                $CustomerBalance60 = 0;
                $CustomerBalance90 = 0;
		$CustomerBalance120 = 0;
		foreach($arryAging as $key=>$values){
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;
                

		$ConversionRate=1;
		if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
			$ConversionRate = $values['ConversionRate'];			   
		}



		$CurrentBalance = 0;
		$Balance30 =  0;
		$Balance60 =  0;
		$Balance90 =  0;
		$Balance120 =  0;

		 /***********************/
		$ModuleDate=''; $ModuleLink='';$orginalAmount=0;
		if($values['Module']=='Invoice'){
			$orginalAmount = $values['TotalInvoiceAmount'];
			$ModuleDate=$values['InvoiceDate'];

			if($values['InvoiceEntry'] == "2" || $values['InvoiceEntry'] == "3"){
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoiceGl.php?view='.$values['OrderID'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}else{
				$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?view='.$values['OrderID'].'&IE='.$values['InvoiceEntry'].'&pop=1">'.$values["InvoiceID"].'</a>';
			}

	
		}else if($values['Module']=='Credit'){
			$orginalAmount = -$values['TotalAmount'];
			$ModuleDate=$values['PostedDate'];
			$ModuleLink='<a class="fancybox fancybig fancybox.iframe" href="vCreditNote.php?view='.$values['OrderID'].'&pop=1">'.$values["CreditID"].'</a>';
			

		}
		
		
		
                $OrderAmount = $orginalAmount;
		$orginalAmount = GetConvertedAmount($ConversionRate, $orginalAmount); 
                $PaidAmnt = $values['ReceiveAmnt'];

		if(!empty($_GET['Currency']) && $values['CustomerCurrency']!=$BaseCurrency && $values['ConversionRate']>0){
			$PaidAmnt = GetConvertedAmountReverse($values['ConversionRate'], $PaidAmnt); 
		}


                if($PaidAmnt !=''){
                    $UnpaidInvoice = $orginalAmount-$PaidAmnt;
                }else{
                    $UnpaidInvoice = $orginalAmount;
                }
                /***********************/
		$AgingDay = GetAgingDay($ModuleDate); 
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

		if(!empty($values["PaymentTerm"])){
			$arryTerm = explode("-",$values["PaymentTerm"]);
			$arryDate = explode("-",$ModuleDate);
			list($year, $month, $day) = $arryDate;

			$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
			$DueDate = date("Y-m-d",$TempDate);
			$DueDate = date($Config['DateFormat'], strtotime($DueDate));
		}else{
			$DueDate = '';
		}


/*************************/

if(($NewCustCode != '' && $NewCustCode != $values['CustCode'])){ 

			$CustomerUnpaidInvoice += -$CreditAmount;
			$CustomerCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			$CustomerTotal = '<tr class="oddbg">
			<td colspan="9" align="right" height="30" ><b> Total : </b></td>
			<td><b>'. number_format($CustomerOriginalAmount,2).'</b></td>
                        <td><b>'.number_format($CustomerUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($CustomerCurrentBalance,2).'</b></td>
			<td><b>'.number_format($CustomerBalance30,2).'</b></td>
			<td><b>'.number_format($CustomerBalance60,2).'</b></td>
			<td><b>'.number_format($CustomerBalance90,2).'</b></td>
			<td><b>'.number_format($CustomerBalance120,2).'</b></td>
			</tr>';
		 	echo $CustomerTotal;
			$CustomerOriginalAmount=0;
			$CustomerUnpaidInvoice = 0;
			$CustomerCurrentBalance = 0;
			$CustomerBalance30 = 0;
			$CustomerBalance60 = 0;
			$CustomerBalance90 = 0;
			$CustomerBalance120 = 0;
			 
   
                      
               

     

		} 
/************************/
if($NewCustCode != $values['CustCode']){

	$content .= '<tr>
					<td colspan="4" height="30" class="head1"><b><?=stripslashes($values["Customer"])?></b>	</td>
					<td colspan="4" class="head1"><b>Phone:</b> '.$values['Landline'].'	</td>
					<td colspan="5" class="head1"><b>Contact :</b>  '.$values['ContactPerson'].'  </td>
					<td colspan="3" class="head1"><b>Credit Limit:</b> '.$values['CreditLimit'].'</td>
		</tr>';

$CreditAmount = $values['CreditAmount']; 
			if($CreditAmount>0){

$content .= '<tr>
			<td></td>
			<td></td>
			<td colspan="2">Customer Credit</td>
			<td colspan="6"></td>
			<td><b>-<?=$CreditAmount?></b></td>
			<td>'.$CreditAmount.'</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>';
		 } 
		} 



 $content .= '<tr align="left">
                <td>   </td>
		<td>'.date($Config['DateFormat'], strtotime($ModuleDate)).'</td>
		<td>'.$ModuleLink.'</td>
                <td>'.stripslashes($values["PaymentTerm"]).' </td>
		<td>'.$DueDate.' </td>
		<td>'.$values["SaleID"].'</td>
                <td>'.$values["OrderSource"].'</td>
                <td>'.$OrderAmount. ' '.$values["CustomerCurrency"].'</td>
                
                <td>';
		 
			if($ConversionRate!=1){	
				$content .= $ConversionRate;			   
			}

			
		


		$content .= '</td>';


$content .='<td>';

$content .=number_format($orginalAmount,2);
                $TotalOriginalAmount  +=$orginalAmount;

	$content .='<td><b>'.number_format($UnpaidInvoice,2).'</b></td>
		
		<td>'.(!empty($CurrentBalance))?(number_format($CurrentBalance,2)):('-').'</td>
		<td>'.(!empty($Balance30))?(number_format($Balance30,2)):('-').'</td>
		<td>'.(!empty($Balance60))?(number_format($Balance60,2)):('-').'</td>
		<td>'.(!empty($Balance90))?(number_format($Balance90,2)):('-').'</td>
		<td>'.(!empty($Balance120))?(number_format($Balance120,2)):('-').'</td>
		
		</tr>';

	$NewCustCode = $values['CustCode'];
		$Customer =  $values["Customer"];

		
		$CustomerOriginalAmount +=$orginalAmount;
		$CustomerUnpaidInvoice +=$UnpaidInvoice;
		$CustomerCurrentBalance +=$CurrentBalance;
		$CustomerBalance30 +=$Balance30;
		$CustomerBalance60 +=$Balance60;
		$CustomerBalance90 +=$Balance90;
		$CustomerBalance120 +=$Balance120;

 }



		if(empty($_GET['CustCode'])){

			$CustomerUnpaidInvoice += -$CreditAmount;
			$CustomerCurrentBalance += -$CreditAmount;

			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;

			
			$CustomerTotal = '<tr class="evenbg">
			<td colspan="9" align="right" height="30"><b>Total : </b></td>
                        <td><b>'.number_format($CustomerOriginalAmount,2).'</b></td>
			<td><b>'.number_format($CustomerUnpaidInvoice,2).'</b></td>
			<td><b>'.number_format($CustomerCurrentBalance,2).'</b></td>
			<td><b>'.number_format($CustomerBalance30,2).'</b></td>
			<td><b>'.number_format($CustomerBalance60,2).'</b></td>
			<td><b>'.number_format($CustomerBalance90,2).'</b></td>
			<td><b>'.number_format($CustomerBalance120,2).'</b></td>
			</tr>';
			$content .= $CustomerTotal;
		}else{
			$TotalUnpaidInvoice += -$CreditAmount;
			$TotalCurrentBalance += -$CreditAmount;
		}




             $content .=' <tr>
		<td colspan="9" align="right" ><b>Total : </b></td>  
                <td><b>'.number_format($TotalOriginalAmount,2).'</b></td>
                <td><b>'.number_format($TotalUnpaidInvoice,2).'</b></td>
		<td><b>'.number_format($TotalCurrentBalance,2).'</b></td>
		<td><b>'.number_format($TotalBalance30,2).'</b></td>
		<td><b>'.number_format($TotalBalance60,2).'</b></td>
		<td><b>'.number_format($TotalBalance90,2).'</b></td>
		<td><b>'.number_format($TotalBalance120,2).'</b></td>
		</tr>';
		 }else{
		$content .='<tr align="center" >
		<td  colspan="16" class="no_record">'.NO_RECORD.' </td>
		</tr>';
		 } 

	
		$content .='</table>';
		$content .='</div>'; 
		
		
$content .='</td>
</tr>

</table>';











/*****************************************************/

$numHeading=$numHead+1;
if($Payroll==1){
	$numHeading=$numHeading+2;
}

$content .='<tr align="left" >'; 
$content .= '<td class="head1" colspan="'.$numHeading.'"> </td>';
			
for($dat=0;$dat<$numDate;$dat++){
	$strtotimeVal = strtotime($arrYDate[$dat]);		
	$Day = date("d",$strtotimeVal);
	$content .= '<td class="head1">
			 <table style="margin:0" width="'.$width.'" cellpadding="0" cellspacing="1"   >
				<tr align="left" >';
					if($arryReport[0]['PunchCheck'] == 'Yes'){
						$content .= '<td width="'.$tdwidth.'" >IN</td>
						<td width="'.$tdwidth.'" >OUT</td>
						';
					}
					 if($arryReport[0]['BreakCheck'] == 'Yes'){
						$content .= '<td  width="'.$tdwidth.'">LO</td>
						<td width="'.$tdwidth.'">LI</td>
						<td width="'.$tdwidth.'" >SO</td>
						<td  width="'.$tdwidth.'">SI</td>';
						$content .= '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
						$content .= '<td width="'.$tdwidth.'" >SO</td>
						<td width="'.$tdwidth.'">SI</td>';
					 }				
					 if($arryReport[0]['DurationCheck'] == 'Yes'){				
						$content .= '<td width="'.$tdwidth.'">Dur.</td>';
					 }
					 if($ShowDaily==1 && $Payroll==1){
					    $content .= '<td width="'.$tdwidth.'">'.$Config['Currency'].'</td>';
					 }
				
				$content .= '</tr>
			  </table>
			</td>';

	if($ShowSemiMonthly==1 && $Day==$SemiMonthDay){
		$content .= '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
		if($Overtime==1){
			$content .= '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
		}
		if($Payroll==1){
			$content .= '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}
	}
	if(($ShowSemiMonthly==1 || $ShowMonthly==1) && $Day==$MonthEndDay){
		$content .= '<td class="head1" align="center" nowrap><strong>Total Dur.<strong></td>';
		if($Overtime==1){
			$content .= '<td class="head1" align="center"  nowrap><strong>Total OT<strong></td>';
		}
		if($Payroll==1){
			$content .= '<td class="head1" align="center"><strong>'.$Config['Currency'].'</strong></td>';
		}
	}


	$strtotimeVal = strtotime($arrYDate[$dat]);
	$DinNo = date("w",$strtotimeVal);		
	if($WeekEndNo==$DinNo){
		$content .= '<td class="head1" nowrap align="center" ><strong>Total Dur.<strong></td>';
		if($Overtime==1){
			$content .= '<td class="head1" nowrap align="center" ><strong>Total OT<strong></td>';
		}
		if($ShowWeekly==1 && $Payroll==1){
			$content .= '<td class="head1" align="center" nowrap><strong>'.$Config['Currency'].'<strong></td>';
		}
	}

}
  
$content .='</tr>';


/****************** START THIRD ROW *****************/
/****************************************************/





if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}

echo $content; exit;
?>
