<? if($_GET['pop']!=1){ ?>
<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span>
<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
</div>
<? } ?>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>


<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Return Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" width="20%"> Return No# : </td>
	<td align="left" width="30%"> <?=$arrySale[0]['ReturnID'];?></td>
 
		<td  align="right"   class="blackbold" width="20%">Item Returned Date  :</td>
		<td   align="left" >
			<?php 
			$arryTime = explode(" ",$Config['TodayDate']);
			$ReturnDate = ($arrySale[0]['ReturnDate']>0)?($arrySale[0]['ReturnDate']):($arryTime[0]); 
			echo $ReturnDate;
			?>



		</td>
	</tr>
 
	<tr>
		<td  align="right"   class="blackbold" valign="top"> Return Amount Paid  : </td>
		<td   align="left" valign="top">
		<?php
		  if($arrySale[0]['ReturnPaid'] == "Yes"){echo "Yes";}else{echo "No";}
		  
		?>
		</td>
	
		<td  align="right" class="blackbold" valign="top"> Comments  : </td>
		<td align="left" valign="top">
		<?php echo stripslashes($arrySale[0]['ReturnComment']); ?>
		</td>
	</tr>
 

</table>

	 </td>
</tr>
<tr>
	 <td align="left"><? include("includes/html/box/return_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?php
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 

echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" ><?=RETURN_ITEM?>
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>



	 </td>
</tr>

<tr>
	<td align="left" >
		<?php include("includes/html/box/so_item_return_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Process"  />
		<? } ?>
		<?php if(empty($_GET['rtn'])){?>
		<input type="hidden" name="ReturnOrderID" id="ReturnOrderID" value="<?=$_GET['edit']?>" readonly />
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



