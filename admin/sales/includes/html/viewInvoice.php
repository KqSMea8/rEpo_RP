<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}

/*$(document).ready(function(){
$("#SelectAll").click(function(){
   var flag,i;
   if($("#SelectAll").prop("checked") == true){
     flag = true;
   }else{
   flag = false;
   }
   var totalCheckboxes = $('input:checkbox').length;
   for(i=1; i<=totalCheckboxes; i++){
		document.getElementById('OrderID'+i).checked=flag;
	}
});
});*/
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_Invoice'])) {echo $_SESSION['mess_Invoice']; unset($_SESSION['mess_Invoice']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="top">
		
		   <? if($num>0){?>
<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_invoice.php?<?=$QueryString?>';" />
<!--<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>-->
	  <? } ?>
	
		 <? if($_GET['search']!='') {?>
	  	<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? }?>


		</td>
      </tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arrySale)?>');" /></td>-->
		<td width="10%" class="head1" >Invoice Date</td>
		<td width="12%"  class="head1" ><?=$ModuleIDTitle?></td>
		<td width="9%"  align="center" class="head1" >SO Number</td>
		<td class="head1">Customer Name</td>
		<td class="head1">Sales Person</td>
		<td width="8%" align="center" class="head1">Amount</td>
		<!--<td width="8%" align="center" class="head1">Total Amount</td>-->
		<td width="8%" align="center" class="head1">Currency</td>
		<td width="8%"  align="center" class="head1">Status</td>
		<td width="8%"  align="center" class="head1">Download</td>
		<td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arrySale) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['InvoiceDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));
		?>
	   
	   </td>
      <td align="center"><?=$values[$ModuleID]?></td>
	  <td align="center"><a href="vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?=$values['SaleID']?>" class="fancybox po fancybox.iframe"><?=$values['SaleID']?></a></td>
      <td><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>" ><?=stripslashes($values["CustomerName"])?></a></td> 
	  <td><?=stripslashes($values['SalesPerson'])?></td>
      <td align="center"><?=$values['TotalInvoiceAmount']?></td>
	  <!--<td align="center"><//?=$values['TotalAmount']?></td>-->
      <td align="center"><?=$values['CustomerCurrency']?></td>
      <td align="center">
	 <? 
		 if($values['InvoicePaid'] =='Paid'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'red';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['InvoicePaid'].'</span>';
		
	 ?>
	 
	</td>


    <td align="center"><a target="_blank" href="pdfInvoice.php?IN=<?=$values['OrderID'];?>&amp;module=Invoice"><?=$download?></a></td>
    <td  align="center" class="head1_inner">

<a href="<?=$ViewUrl.'&view='.$values['OrderID']?>" ><?=$view?></a>

<a href="<?=$EditUrl.'&del_id='.$values['OrderID']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a><br> 
<?php //if($values['InvoicePaid'] !='Paid'){?>
<!--a href="<?=$EditUrl.'&edit='.$values['OrderID']?>" target="_blank">Pay Invoice</a-->
<?php //}?>
<?
/*if($module=="Order"){ 

$TotalGenerateInvoice=$objSale->GetQtyInvoiced($values['OrderID']);


	$TotalInvoice=$objSale->CountInvoices($values['SaleID']);
	if($TotalInvoice>0)
		echo '<br><a href="viewInvoice.php?so='.$values['SaleID'].'" target="_blank">Invoices</a>';
	if($values['Status'] =='Open' && $values['Approved'] ==1 && $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty'])
		echo '<br><a href="generateInvoice.php?so='.$values['SaleID'].'&invoice='.$values['OrderID'].'&module=Order" target="_blank">'.GENERATE_INVOICE.'</a>';
}*/
?>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 

  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".po").fancybox({
			'width'         : 900
		 });

});

</script>
