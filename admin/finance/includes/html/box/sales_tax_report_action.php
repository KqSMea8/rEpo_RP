<?

$content ='<table width="100%" align="center" cellpadding="3" cellspacing="1" id="myTable" >
		<tr align="left" class="RowFirst">';
if($_GET['rby']=='L'){
	    $content .= '<td class="head1" nowrap >Tax Rate</td>';
}
		$content .= '<td class="head1" nowrap >Customer</td>';
if($_GET['rby']=='C'){
	    $content .= '<td class="head1" nowrap ></td>';
}
		$content .= '<td class="head1" nowrap align="center">Invoice Date</td>';
		$content .= '<td class="head1" nowrap align="center">Invoice#</td>';
		$content .= '<td class="head1" nowrap align="center">Invoice Amount</td>';
		$content .= '<td class="head1" nowrap align="center">Payment Term</td>';
		$content .= '<td class="head1" nowrap align="center">Due Date</td>';
		$content .= '<td class="head1" nowrap align="center">SO #</td>';
		$content .= '<td class="head1" nowrap align="center">Tax Amount ('.$Config['Currency'].')</td>';
			
		if(is_array($arrySale) && $num>0){
		$flag=true;
		$Line=0;
		
		$CustomerAmount=0;
		
        $TotalAmount = 0;

		foreach($arrySale as $key=>$values){
		
			$ConversionRate=1;
			if($values['CustomerCurrency']!=$Config['Currency'] && $values['ConversionRate']>0){
				$ConversionRate = $values['ConversionRate'];			   
			}
		        $Amount = GetConvertedAmount($ConversionRate, $values['taxAmnt']);


			   $TotalAmount +=$Amount;
			    
			   $InvoiceDate = date($Config['DateFormat'], strtotime($values['InvoiceDate']));
			   $Mobile = $values['Mobile'];
			   $CustomerName = $values["CustomerName"];
			   $paymentTerm = $values['PaymentTerm'];
               $SaleID = $values["SaleID"];
    
               $InvID = $values['InvoiceID'];
               
	       
		$flag=!$flag;
		$bgclass = (!$flag)?("oddbg"):("evenbg");
		$Line++;

         
		if(!empty($values["PaymentTerm"])){ 
			$arryTerm = explode("-",$values["PaymentTerm"]);
			$arryDate = explode("-",$values['InvoiceDate']);
			list($year, $month, $day) = $arryDate;

			$TempDate  = mktime(0, 0, 0, $month , $day+$arryTerm[1], $year);	
			$DueDate = date("Y-m-d",$TempDate);
			$DueDate = date($Config['DateFormat'], strtotime($DueDate));
		}else{
			$DueDate = '';
		}
		

		$TaxRateValue = trim(stripslashes($values['TaxRate']));
		$arrTxs = explode(":",$TaxRateValue);
		$TaxVale = $arrTxs[1].' : '.$arrTxs[2].'%';


		$TaxByCode = ($_GET['rby']=='L')?($TaxVale):($values['CustCode']);

	     if($NewCustCode!='' && $NewCustCode != $TaxByCode){

	          $content .='<tr class="oddbg">
	        <td '.$TaxDisplay.'> </td>
			<td colspan="7" align="right" height="30" ><b> Total : </b></td>
			<td><b>'.number_format($CustomerAmount,2).'</b></td>
			
			</tr>';
		 	//echo $CustomerTotal;
		 	$CustomerAmount=0;
		 } 

	  $DisplayAllCustomer='';
	  if($_GET['rby']=='L'){
		$DisplayAllCustomer = '<b>'.$CustomerName.'</b>';
	  }
	

          if($NewCustCode != $TaxByCode){ 

	           if($_GET['rby']=='L'){
					
					$content .='<tr>
					 <td align="left" height="30" class="head1"><b>'.$TaxVale.'</b></td>
					  <td align="left" height="30" class="head1"></td>				
					</tr>';
					
			
				}else{
					$content .='<tr>
					 <td align="left" height="30" class="head1"><b>'.$CustomerName.'</b></td>
					 <td colspan="4" class="head1"><b> Phone : </b>'.$Mobile.'</td>
					</tr>';
				} 
		}
 	
 	
		
		
		 
      $content .= '<tralign="left" class="<?=$bgclass?>">
                  <td>  </td>     
                   <td '.$TaxDisplay.'>  '.$DisplayAllCustomer.' </td>
	  <td class="head1" align="center">'.$InvoiceDate.'</td>
	  
	  <td class="head1" align="center">'.$InvID.'</td>
	    <td class="head1" align="center">'.$values["TotalInvoiceAmount"].' '.$values["CustomerCurrency"].'</td>
	 <td class="head1" align="center">'.$paymentTerm.'</td>
		
	 <td class="head1" align="center">'.$DueDate.'</td>
	
	 <td class="head1" align="center">'.$SaleID.'</td>
		
	<td class="head1" ><b>'.number_format($Amount,2).'</b></td>
		
		</tr>';
		
	
		 $NewCustCode = $TaxByCode;
		 $CustomerAmount +=$Amount;

		      } 
		
		
		if($_GET['rby']=='L'){
			 if(empty($_GET['Tax'])){			
			 	$content .= '<tr class="oddbg">
			 	<td '.$TaxDisplay.'> </td>
				<td colspan="7" align="right" height="30" ><b> Total : </b></td>
				<td><b>'.number_format($CustomerAmount,2).'</b></td>
				
				</tr>';
			 } 
		}else{
			 if(empty($_GET['CustCode'])){			
			 	$content .= '<tr class="oddbg">
			 	<td '.$TaxDisplay.'> </td>
				<td colspan="7" align="right" height="30" ><b> Total : </b></td>
				<td><b>'.number_format($CustomerAmount,2).'</b></td>
				
				</tr>';
			 } 
		}
		
		 $content .='<tr class="oddbg">
		 <td '.$TaxDisplay.'> </td>
		<td  colspan="7" align="right" height="30"><b>Total Tax Amount:  </b></td>
	    <td><b>'.number_format($TotalAmount,2).'</b></td>
		</tr>';	

}else{
	$content .='<tr >
<td  colspan="9" class="no_record">'.NO_RECORD.'</td>
</tr>';
} 
  

$content .='</td>
  	</tr>
  </table>';
	
	//echo $content;exit;
if(!empty($ExportFile)){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$ExportFile);
	echo $content;exit;
}else{
	echo $content;
}


?>

