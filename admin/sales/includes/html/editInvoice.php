<? if($_GET['pop']!=1){ ?>

	
	<a href="<?=$RedirectURL?>" class="back">Back</a>
	
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
	<?php
	//if(!empty($_REQUEST['edit']) && $paidAmnt != $InvoiceAmount){?>
	<!--a class="fancybox add" href="#payInvoice_div" style="float: right;">Pay Invoice</a-->
	<?php //}?>
	<div class="had"><?=$MainModuleName?>    <span>&raquo;	<?=$ModuleName?>		
			</span>
	</div>	
	<div class="message" align="center"><? if(!empty($_SESSION['mess_Invoice'])) {echo $_SESSION['mess_Invoice']; unset($_SESSION['mess_Invoice']); }?></div>
	  <? 
}	
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	
?>
	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

<tr>
	 <td align="left"><? include("includes/html/box/invoice_information_view.php");?></td>
</tr>

<tr>
    <td  align="center">

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0"  class="borderall">
		<tr>
			<td align="left" valign="top" width="50%"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td align="left" valign="top"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?

$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 
echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borderall">
		<tr>
			 <td colspan="2" align="left" class="head" >Line Item</td>
		</tr>
		<tr>
			<td align="left" colspan="2">
				<? 	include("includes/html/box/sales_order_item_view.php");?>
			</td>
		</tr>
		<!--tr>
			 <td colspan="2" align="left" class="head" >Payment History</td>
		</tr>
		<tr>
			<td align="left" colspan="2">
				<? 	//include("includes/html/box/payment_invoice_view.php");?>
			</td>
		</tr-->
		</table>	
    
	
	</td>
   </tr>

  

  
</table>

 

<?php 
	#include("includes/html/box/invoice_payment_form.php");
} ?>


