<?
/*
$Percentage = $arryPayment[0]['CommPercentage'];
$CommPaidOn = $arryPayment[0]['CommPaidOn'];
$CommOn = $arryPayment[0]['CommOn'];
$CommType = $arryPayment[0]['CommType'];

*/
 
$Percentage = (!empty($arryPayment[0]['CommPercentage']))?($arryPayment[0]['CommPercentage']):("");
$CommPaidOn = (!empty($arryPayment[0]['CommPaidOn']))?($arryPayment[0]['CommPaidOn']):("");      
$CommOn = (!empty($arryPayment[0]['CommOn']))?($arryPayment[0]['CommOn']):("");  
$CommType = (!empty($arryPayment[0]['CommType']))?($arryPayment[0]['CommType']):("");  
 (empty($OrginalAvgCost))?($OrginalAvgCost=""):("");
 (empty($OrginalFee))?($OrginalFee=""):("");
 


$TotalCommissionSum=0;

$content ='<table '.$table_bg.'>
	<tr align="left">';
	if($CommOn==1){
		$content .= '<td width="10%" class="head1">Payment Date</td>';
	}
	$content .= '<td  class="head1">Customer</td>
		<td width="10%" class="head1">Invoice Date</td>	
		<td width="8%" class="head1">Invoice #</td>	
		 <td width="7%"   class="head1">Status</td>  			
		<td width="12%" class="head1" align="right">Invoice Total ['.$Config['Currency'].']</td>';	
	if($CommOn==1){
		$content .= '<td width="12%" class="head1" align="right">Sales Amount ['.$Config['Currency'].']</td>';
	}
	if($CommOn==2){
		$content .= '<td width="12%" class="head1" align="right">Cost of Good ['.$Config['Currency'].']</td>
		<td width="9%" class="head1" align="right">Fees ['.$Config['Currency'].']</td>
		<td width="9%" class="head1" align="right">Margin ['.$Config['Currency'].']</td>';
	}
	//if($CommOn==1 || $CommOn==2){
		$content .= '<td width="12%" class="head1" align="right">Commission ['.$Config['Currency'].']</td>';
	//}
	$content .= '</tr>';
	 if(is_array($arryPayment) && $num>0){
		$flag=true;
		$Line=0; 
		$EmpDivision = 5;

		$TotalSalesAmount=0;$TotalMargin=0;$SalesCommission=0;
	
		$TotalMargin=0;
		$TotalInvoiceAmount=0;
		$TotalCOG = 0;
		$TotalFee = 0;

 
		foreach($arryPayment as $key=>$values){//start foreach
			$flag=!$flag;
			$Line++;
			/********************/
			$ConversionRate=1;
			if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
				$ConversionRate = $values['ConversionRate'];			   
			}
		
			$InvoiceAmount = $values['TotalInvoiceAmount'] - $values['taxAmnt'];
			$OrginalInvoiceAmount = GetConvertedAmount($ConversionRate, $InvoiceAmount); 			
			/********************/

			/****************/
			$PaymentDate = ($values['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($values['PaymentDate']))):('-');
			$InvoiceDate = ($values['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($values['InvoiceDate']))):('-');
			if($_GET['pop']==1 || !empty($ExportFile)){ 
				$CustomerName = stripslashes($values["CustomerName"]);  
				$MainInvoiceID = $values["MainInvoiceID"];
			}else{ 
				$CustomerName = '<a class="fancybox fancybox.iframe" href="../custInfo.php?view='.$values['CustCode'].'">'.stripslashes($values["CustomerName"]).'</a>';
				$MainInvoiceID = '<a class="fancybox fancybig fancybox.iframe" href="vInvoice.php?pop=1&view='.$values['InID'].'" >'.$values["MainInvoiceID"].'</a>';
			}


			if($values['InvoicePaid'] == 'Paid') {
                        	$StatusCls = 'green';
                    	}else{
                        	$StatusCls = 'red';
                    	} 
                    	$InvoicePaid = '<span class="' . $StatusCls . '">' . $values['InvoicePaid'] . '</span>';
			/****************/

			$content .= '<tr align="left">';
			if($CommOn==1){				
				$content .= '<td>'.$PaymentDate.'</td>';
			}
 
			$content .= '<td height="20">'.$CustomerName.'</td>
				<td>'.$InvoiceDate.'</td>	
				<td>'.$MainInvoiceID.'</td>	
				 <td>'.$InvoicePaid.'</td>  			
				<td align="right">'.number_format($OrginalInvoiceAmount,2).'</td>';	
			if($CommOn==1){
				$content .= '<td align="right">'.number_format($values['DebitAmnt'],2).'</td>';
			}

			/*************/
			$PaymentID='';
			$TotalCommission=0;
			$OrderID = $values['InID'];
			if($CommOn==2){					
				include("../includes/html/box/commission_cal_margin.php");
				$TotalCommissionSum += $TotalCommission;	 
				$TotalMargin += $Margin;

				$content .= '<td align="right">'.number_format($OrginalAvgCost,2).'</td>
					<td align="right">'.number_format($OrginalFee,2).'</td>
					<td align="right">'.number_format($Margin,2).'</td>
					';
			}else if($CommOn==1){				 
				$PaymentID = $values["PaymentID"]; 
				if($PaymentID>0 || $CommType=="Spiff"){				
					include("../includes/html/box/commission_cal_per.php");
					$TotalCommissionSum += $TotalCommission;
				}
			}else{								
				include("../includes/html/box/commission_cal.php");
				$TotalCommissionSum += $TotalCommission;				
			}

			/******Payroll Data**********/
			if(!empty($Payroll)){
				if($TotalCommission>0){
					$ModuleDate = ($CommOn==1)?($values['PaymentDate']):($values['InvoiceDate']);	
					$arrayList[$EmpID][$ModuleDate]["Commission"] += $TotalCommission;
				}
			}
			/**********************/

			$content .= '<td align="right">'.number_format($TotalCommission,2).'</td>';
			$content .= '</tr>';


			/**************************/
			$TotalInvoiceAmount += 	$OrginalInvoiceAmount;
			$TotalSalesAmount += $values['DebitAmnt'];
			$TotalCOG += $OrginalAvgCost;
			$TotalFee += $OrginalFee;
			/**************************/


		}//end foreach
	}else{
		$content .='<tr align="center" >
		<td  colspan="11" class="no_record">'.NO_RECORD.'</td>
		</tr>';
	} 
  

	if($TotalInvoiceAmount>0){ 
		if($CommOn==1){ //per invoice
			$TotalCommission = $TotalCommissionSum;
		}else if($CommOn==2){//margin	
			if($arrySalesCommission[0]['SalesPersonType']=="Residual"){	
		  		 $TotalCommission = $TotalCommissionSum;
			}
		}else{ //total amount
 			$TotalCommission = $TotalCommissionSum;
		  
		}


		
	$content .= '<tr id="td_pager">'; 
	if($CommOn==1){ $content .= '<td></td>'; } 
	$content .= '<td></td>
		     <td></td>	
		     <td></td>
		     
	<td align="right"><strong>Total :</strong> </td>	
	<td align="right"><strong>'.number_format($TotalInvoiceAmount,2).'</strong></td> ';
	if($CommOn==1){
		$content .= '<td align="right"><strong>'.number_format($TotalSalesAmount,2).'</strong></td>';
	}
	if($CommOn==2){
		$content .= '<td align="right"><strong>'.number_format($TotalCOG,2).'</strong></td>
		<td align="right"><strong>'.number_format($TotalFee,2).'</strong></td>
		<td align="right"><strong>'.number_format($TotalMargin,2).'</strong></td>';
	}
 
	$content .= '<td align="right"> </td>';
	 
	$content .= '</tr>';

 
	/*if($CommPaidOn=='Paid' && $CommOn==1 ){
		$content .= '<tr id="td_pager">  
		<td colspan="10" align="right"><strong>Total Sales Amount : '.number_format($TotalSalesAmount,2).'</strong></td> </tr>';
 	}*/

	 
	$content .= '<tr id="td_pager">  
		<td colspan="10" align="right"><strong>Total Sales Commission : '.number_format($TotalCommission,2).'</strong></td>
		
	</tr>';

	}


	$content .='</table>';

 
if(!empty($Payroll)){
	$content = '';
}else if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}

//echo $content; exit;
?>

