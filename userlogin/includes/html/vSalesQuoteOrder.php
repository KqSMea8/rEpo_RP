<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	ShowHideLoader('1','P');
}



</script>
<?php 
	if($Config['Junk']==0){
		/*********************/
		/*********************/
		$CustomerID=$_SESSION['UserData']['Cid'];
	   	$NextID = $objSale->NextPrevRowCustomer($_GET['view'],1,$_GET["module"],$CustomerID);
		$PrevID = $objSale->NextPrevRowCustomer($_GET['view'],2,$_GET["module"],$CustomerID);
		$NextPrevUrl = "vSalesQuoteOrder.php?module=".$_GET["module"]."&curP=".$_GET["curP"];
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/
	}	
	?>
<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>


	<? if(empty($ErrorMSG)){?>
	



<? 
if(!empty($_REQUEST['view'])){
            $total_received = $objSale->GetQtyInvoiced($_REQUEST['view']);
			$total_ordered = $total_received[0]['Qty'];
			$total_invoiced = $total_received[0]['QtyInvoiced'];
		}
	if($arrySale[0]['Approved'] == 1 && $arrySale[0]['Status'] == 'Open'){
		if($module=='Quote' ){ 
			echo '<a class="fancybox edit" href="#convert_form" >'.CONVERT_TO_SALE_ORDER.'</a>';
			include("includes/html/box/convert_form.php");
		}/*else if($module=='Order' && $total_ordered != $total_invoiced){ 
			echo '<a class="edit" href="../finance/generateInvoice.php?so='.$arrySale[0]['SaleID'].'&view='.$arrySale[0]['OrderID'].'" target="_blank">'.GENERATE_INVOICE.'</a>';
				//include("includes/html/box/generate_invoice_form.php");
		}*/
	} 


	/*if($module=='Order' && $arrySale[0]['SaleID']!='' ){ 
		$TotalInvoice=$objSale->CountInvoices($arrySale[0]['SaleID']);
		if($TotalInvoice>0)
			echo '<a href="../finance/viewInvoice.php?po='.$arrySale[0]['SaleID'].'" class="grey_bt" target="_blank">'.$TotalInvoice.' Invoices</a>';
	}*/
        
         
        if($arrySale[0]["OrderType"] == 'Against PO' && ($POStatus == 'Completed' || $POStatus == 'Invoicing')  && ($_SESSION['AdminType'] == 'admin' || $FullAcessLabel==1)){ ?>
        <a class="edit" href="<?=$convertUrl;?>" onClick="return ResetSearch();"><?=CONVERT_TO_STANDARD_ORDER?></a>
            
        <?php }

?>








	<? } ?>

	<div class="had">
	<?=$MainModuleName?>    <span>&raquo;
		<?=$ModuleName.' Detail'?>
			
			</span>
	</div>
        
        <div class="message" align="center"><?  if (!empty($_SESSION['mess_Sale'])) {  echo $_SESSION['mess_Sale'];   unset($_SESSION['mess_Sale']);  } ?></div>
		
	  <? 

}	


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	



?>
	
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left"><? include("includes/html/box/sales_order_view.php");?></td>
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
		</table>	
    
	
	</td>
   </tr>

  

  
</table>



<? } ?>


