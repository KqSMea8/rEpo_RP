<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>
 <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<div class="had" style="margin-bottom:5px;"> Cash Receipt Details</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="right" width="13%">
	Cash Receipt No# : 
</td>
	<td align="left"> <strong> <? echo $arryCash[0]["ReceiptID"];    ?></strong>
	 </td>
</tr>
  <tr>
    <td align="right">
    Cash Receipt Date : 

</td>
<td align="left"><?
if($arryCash[0]["PaymentDate"] > 0) {
     echo date($Config['DateFormat'], strtotime($arryCash[0]["PaymentDate"]));
}else {
	echo NOT_SPECIFIED;
}
 ?>
	 </td>
</tr>
  <tr>
    <td align="right" >
	Deposited To :
</td>
	<td align="left">  <? echo $arryCash[0]["PaidToAccount"];  ?>
	 </td>
</tr>
<? if(!empty($arryCash[0]["ReferenceNo"])){ ?>
   <tr>
    <td align="right" >
	Reference No :
</td>
	<td align="left">  <? echo stripslashes($arryCash[0]["ReferenceNo"]);  ?>
	 </td>
</tr>
<? } ?>

  <tr>
    <td align="right">
	Posted By : 

</td>
<td ><?  
if($arryCash[0]["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$arryCash[0]['AdminID'].'" >'.stripslashes($arryCash[0]["PostedBy"]).'</a>';
}else {
	echo $arryCash[0]["PostedBy"];
}
 ?>  
	 </td>
</tr>



<? if(empty($_GET["CustID"])){ ?>
<tr>
	<td align="right">Total Amount : </td>
	<td><strong><?=number_format($arryCash[0]['TotalAmount'],2)?> <?=$Config['Currency']?></strong></td>
</tr>
<? } ?>


<? 
if($ShowCardInfo==1){
	if($arryCash[0]["Fee"]>0){ ?>
<tr>
	<td align="right">Fee : </td>
	<td><strong><?=number_format($arryCash[0]['Fee'],2)?> <?=$Config['Currency']?></strong></td>
</tr>
<? } ?>
<? if($arryCash[0]['OrderPaid']>0) { ?>
<tr>
	 <td  align="right"   >Payment Status  : </td>
	<td   align="left" >
		<?=($arryCash[0]['OrderPaid']==1)?('<span class=greenmsg>Paid</span>'):('<span class=redmsg>Refunded</span>')?>
	</td>
</tr>
<? } ?>

<tr>
	 <td align="left" colspan="2"><? $BoxPrefix = '../sales/'; include($BoxPrefix."includes/html/box/sale_card_view.php");?></td>
</tr>
<? } ?>

  <tr>
    <td align="left" colspan="2">
			
			<table width="100%" id="list_table" border="0" align="center" cellpadding="3" cellspacing="1" >  
			 
				<tr align="left">  
				
					<td width="6%"  class="head1">Type</td>
					<td width="9%"  class="head1">Customer</td>
					<td width="9%"  class="head1">Vendor</td>
					<td width="10%"  class="head1">Invoice Date</td>   
					<td width="9%" class="head1">Invoice # </td>					
					<td width="11%" class="head1">GL Account</td>
					<td width="10%" class="head1">Credit Memo #</td>
					<td width="6%" class="head1">Check# </td>
					<td width="10%" class="head1">Original Invoice Amount </td>
					<td width="8%" class="head1">Amount in Other Currency </td>
					<td  class="head1"> Amount (
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
				if($PaymentType=='Contra Invoice'){				 
					$InvoiceDate = $values['PostedDate'];
					 
					if($values['PInvoiceEntry'] == '2' || $values['PInvoiceEntry'] == '3'){
						$InvoiceID = $values["InvoiceID"];
					 	
					}else  if($values['PInvoiceEntry'] == 1){
						$InvoiceID = $values["InvoiceID"];

					}else{
						$InvoiceID =$values['InvoiceID'];
						
					}

				}else if($PaymentType=='Invoice'){					 
					$InvoiceDate = $values['InvoiceDate'];
					 
					if($values['InvoiceEntry'] == 1){
				    		$InvoiceID = $values['InvoiceID'];
					}else{
				 		$InvoiceID = $values['InvoiceID'];
					}
				}else if($PaymentType=='Credit'){					 
					$CredetID = $values['CreditID'];
					if($values['OverPaid']=='1'){	
						$PaymentType = 'Invoice';
						$CredetID ='';
						$InvoiceID = $values['InvoiceID'];
					}
				}



				$AddCurrency = '';
				if($values['ModuleCurrency']!=$Config['Currency']){
					$AddCurrency = number_format($values['OriginalAmount'],2).' '.$values['ModuleCurrency'];
				}


				echo '<tr align="left" bgcolor="'.$bgcolor.'"> 
					         
				         <td>'.$PaymentType.'</td>
					 <td>'.$CustomerName.'</td>
					  <td>'.$VendorName.'</td>
				         <td>'.$InvoiceDate.'</td>
				         <td>'.$InvoiceID.'</td>
				         <td>'.$values['AccountNameNumber'].'</td>	
					 <td>'.$CredetID.'</td>	
					  <td>'.$values['CheckNumber'].'</td>
					 <td>'.number_format($values['TotalInvoiceAmount'],2).' '.$values['CustomerCurrency'].'</td>	
					 <td>'.$AddCurrency.'</td>	
					<td>'.number_format($values['Amount'],2).'</td>		      
				        
				 </tr>';
			}

			$sumPayAmount = round($sumPayAmount,2);			
			if($sumPayAmount=='-0'){
				$sumPayAmount = '0';
			}

			echo '<tr align="left" bgcolor="'.$bgcolor.'" > 						
					 <td colspan="10" align="right"><b>Total Amount :</b> </td>	
					<td><b>'.number_format($arryCash[0]['TotalAmount'],2).'</b></td>		      
				        
				 </tr>';

		 
			
?>



</table>

<? } ?>
