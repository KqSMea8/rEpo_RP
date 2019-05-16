<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>
 <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<div class="had" style="margin-bottom:5px;"> Vendor Payment Details</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
<? if(empty($_GET["SuppCode"])){ ?>
<tr>
	<td align="right">Total Amount Paid : </td>
	<td><strong><?=number_format($arryVendorPayment[0]['TotalAmount'],2)?> <?=$Config['Currency']?> </strong></td>
</tr>
<? } ?>
  <tr>
    <td align="right" width="13%">
	Payment No# : 
</td>
	<td align="left"> <strong> <? echo $arryVendorPayment[0]["ReceiptID"];    ?></strong>
	 </td>
</tr>
  <tr>
    <td align="right">
    Payment Date : 

</td>
<td align="left"><?
if($arryVendorPayment[0]["PaymentDate"] > 0) {
     echo date($Config['DateFormat'], strtotime($arryVendorPayment[0]["PaymentDate"]));
}else {
	echo NOT_SPECIFIED;
}
 ?>
	 </td>
</tr>

   <tr>
    <td align="right" >
	Payment Account :
</td>
	<td align="left">  <? echo $arryVendorPayment[0]["PaymentAccount"];  ?>
	 </td>
</tr>

<? if(!empty($arryVendorPayment[0]["ReferenceNo"])){ ?>
   <tr>
    <td align="right" >
	Reference No :
</td>
	<td align="left">  <? echo stripslashes($arryVendorPayment[0]["ReferenceNo"]);  ?>
	 </td>
</tr>
<? } ?>

  <tr>
    <td align="right">
	Posted By : 

</td>
<td ><?  
if($arryVendorPayment[0]["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryVendorPayment[0]['AdminID'].'" >'.stripslashes($arryVendorPayment[0]["PostedBy"]).'</a>';
}else {
	echo $arryVendorPayment[0]["PostedBy"];
}
 ?>  
	 </td>
</tr>

  <tr>
    <td align="right">	Payment Term : </td>
	<td><?=$arryVendorPayment[0]['Method']?></td>
 </tr>
<? if($arryVendorPayment[0]['Method']=="Check"){?>
  <tr>
    <td align="right">	Bank Name : </td>
	<td><?=$arryVendorPayment[0]['CheckBankName']?></td>
 </tr>
  <tr>
    <td align="right">	Check Number : </td>
	<td><?=$arryVendorPayment[0]['CheckNumber']?></td>
 </tr>
  <tr>
    <td align="right">	Check Format : </td>
	<td><?=$arryVendorPayment[0]['CheckFormat']?></td>
 </tr>
<? } ?>

  <tr>
    <td align="left" colspan="3">
			
			<table width="100%" id="list_table" border="0" align="center" cellpadding="3" cellspacing="1" >  
			 
				<tr align="left">  
				
					<td width="5%"  class="head1">Type</td>
					<td width="9%"  class="head1">Vendor</td>
					<td width="9%"  class="head1">Customer</td>	
					<td width="11%"  class="head1">Invoice Date</td>   
					<td width="8%" class="head1">Invoice # </td>					
					<td width="8%" class="head1">Ref No# </td>
					<td width="11%" class="head1">GL Account</td>					
					<td width="10%" class="head1">Credit Memo #</td>
					<td width="6%" class="head1">Check# </td>
					<td width="10%" class="head1">Original Invoice Amount </td>
					<td width="8%" class="head1">Amount in Other Currency </td>					
					<td  class="head1"> Amount  (
<?php echo $Config['Currency'];?>)</td>
				</tr>
				
<?php 				
			$sumPayAmount=0;
			$Line=0;
			$flag='';
			foreach($arryTransaction as $key=>$values){
				 
				$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
				$sumPayAmount += $values['Amount'];
				$Line++;
				
				if(!empty($values['CustomerName'])){
					$CustomerName = stripslashes($values['CustomerName']);
				}else{
					$CustomerName = '';
				}

				if(!empty($values['VendorName'])){
					$VendorName = stripslashes($values['VendorName']);
				}else{
					$VendorName = '';
				}

				$InvoiceDate ='';$InvoiceID='';	$InvoiceDate='';$CredetID='';
				$PaymentType = $values['PaymentType'];
				if($PaymentType=='Invoice'){				 
					$InvoiceDate = $values['PostedDate'];
					$InvoiceID = $values['InvoiceID'];

				}else if($PaymentType=='Contra Invoice'){					 
					$InvoiceDate = $values['InvoiceDate'];
					$InvoiceID = $values['InvoiceID'];
					
				}else if($PaymentType=='Credit'){					 
					$CredetID = $values['CreditID'];
					$InvoiceDate = $values['PostedDate'];
					if($values['OverPaid']=='1'){	
						$PaymentType = 'Invoice';
						$CredetID ='';
						$InvoiceID = $values['InvoiceID'];
					}
				}


				$AddCurrency = '';
				if($values['ModuleCurrency']!=$Config['Currency'] && !empty($values['OriginalAmount'])){
					$AddCurrency = number_format($values['OriginalAmount'],2).' '.$values['ModuleCurrency'];
				}


				echo '<tr align="left" bgcolor="'.$bgcolor.'"> 
					         
				         <td>'.$PaymentType.'</td>
					  <td>'.$VendorName.'</td>
					 <td>'.$CustomerName.'</td>		
				         <td>'.$InvoiceDate.'</td>
				         <td>'.$InvoiceID.'</td>
				         <td>'.$values['PurchaseID'].'</td>
					   <td>'.$values['AccountNameNumber'].'</td>		
					 <td>'.$CredetID.'</td>	
					  <td>'.$values['CheckNumber'].'</td>
					<td>'.number_format($values['VendorTotalAmount'],2).' '.$values['Currency'].'</td>	
					<td>'.$AddCurrency.'</td>	
					<td>'.number_format($values['Amount'],2).'</td>		      
				        
				 </tr>';
			}

			$sumPayAmount = round($sumPayAmount,2);			
			if($sumPayAmount=='-0'){
				$sumPayAmount = '0';
			}

			echo '<tr align="left" bgcolor="'.$bgcolor.'" > 						
					 <td colspan="11" align="right"><b>Total Amount :</b> </td>	
					<td><b>'.number_format($arryVendorPayment[0]['TotalAmount'],2).'</b></td>		      
				        
				 </tr>';

		 
			
?>



</table>

<? } ?>
