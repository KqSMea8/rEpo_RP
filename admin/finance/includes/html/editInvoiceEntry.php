<a href="<?=$BackURL?>" class="back">Back</a>

<?
//include("includes/html/box/card_process.php"); //full

include("includes/html/box/card_process_partial.php");

?>



<div class="had">
<?=$MainModuleName?>    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
			</span>
</div>

<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>

<script src="js/editInvoiceEntry.js?<?=time()?>"></script>
<link href="<?=$Prefix?>css/select2.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?=$Prefix?>js/select2.min.js"></script>
 

<div class="message" align="center"><? if(!empty($_SESSION['mess_Invoice'])) {echo $_SESSION['mess_Invoice']; unset($_SESSION['mess_Invoice']); }?></div>
<form name="form1" id="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

    <input type="hidden" name="USER_LOG" id="USER_LOG" value="" />
		<input type="hidden" name="USER_LOG_NEW" id="USER_LOG_NEW" value="" />

<a class="fancybox fancybox.iframe" style="float:right;margin: 10px 6px 0px;" href="../sales/order_log.php?OrderID=<?=$_GET['edit']?>&module=SalesInvoiceEntry" ><img alt="user Log" src="../images/userlog.png" onmouseover="ddrivetip('<center>User Log</center>', 60,'')" onmouseout="hideddrivetip()"></a>
<table cellspacing="0" cellpadding="0" border="0" id="search_table" style="margin:0;"> 
	<tr>
		<td align="left"><b>GL Account/Line Item:</b></td>
		<td align="left">
			<?if($OrderID>0){ ?>
			<?=$GLAccountLineItem?>
			<input type="hidden" name="GLAccountLineItem" id="GLAccountLineItem" value="<?=$GLAccountLineItemType?>" readonly>
			<?}else{?>
			<select name="GLAccountLineItem" class="inputbox" id="GLAccountLineItem" onchange="Javascript: SetGLAccountLineItem(this.value);"> 
			<option value="GLAccount">GL Account</option>
			<option value="LineItem">Line Item</option>
			</select>
			<?}?>
		</td>
	</tr> 
</table>



<div id="glForm" <?=$GlDivHide?> >
<? include("includes/html/box/invoice_entry_gl.php");?>
</div>


<div id="lineItemForm" <?=$LineItemDivHide?> >
<? include("includes/html/box/invoice_entry_line.php");?>
</div>





<table width="100%" border="0" cellpadding="0" cellspacing="0"   >

   <tr>
    <td  align="center">

	<input type="hidden" name="TransactionAmount" id="TransactionAmount" class="inputbox" readonly value="<?=$CreditCardBalance?>" /> 

	<input type="hidden" name="ChargeRefund" id="ChargeRefund" class="inputbox" readonly value="0" /> 



	<input type="hidden" name="GLAccountLineItemType" id="GLAccountLineItemType" value="<?=$GLAccountLineItemType?>" readonly />
	<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
	<input type="hidden" name="GenerateInVoice" id="GenerateInVoice" value="1" />
	<input type="hidden" name="PrefixSale" id="PrefixSale" value="<?=$PrefixSale?>" />
	<input type="hidden" name="comType" id="comType" value="<?=$_SESSION['SelectOneItem']?>" />
	<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit"  />

	</td>
   </tr>
  
</table>

 </form>


<? } ?>




<script language="JavaScript1.2" type="text/javascript">
<? if($OrderID>0){ ?>
//SetGLAccountLineItem('<?=$GLAccountLineItemType?>');
<? } ?>
</script>

