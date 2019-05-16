<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>

	<? if(empty($ErrorMSG)){?>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$EditUrl?>" class="edit">Edit</a>
	<a href="<?=$DownloadUrl?>" target="_blank" class="pdf" style="float:right">Download</a>
	<? } ?>

	<div class="had"><?=$MainModuleName?>    <span>&raquo;	<?=$ModuleName?> Detail </span></div>
	
	
	

	<div class="message" align="center"><? if(!empty($_SESSION['mess_invoice'])) {echo $_SESSION['mess_invoice']; unset($_SESSION['mess_invoice']); }?></div>
  <?

}	



if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


	#include("includes/html/box/invoice_view.php");

?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td  align="center" valign="top" >
	
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Receipt Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Receipt No# : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["RecieveID"])?></B></td>
      </tr>
	 <tr>
        <td  align="right"   class="blackbold" >Receipt Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>  
	  <tr>
        <td  align="right"   class="blackbold" >Item Receipt Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>

	

	


</table>
	
	
	</td>
</tr>

<tr>
	 <td  align="left"><? include("includes/html/box/po_order_view.php");?></td>
</tr>

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/po_warehouse_view.php");?></td>
		</tr>
	</table>

</td>
</tr>

<tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['Currency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	 <td  align="left" class="head" >Received Item	 
	 <div style="float:right"><a class="fancybox hideprint fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div>

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
		<? 	include("includes/html/box/w_item_recieve_view.php");?>
	</td>
</tr>



</table>	
    
	
	</td>
   </tr>

  

  
</table>
	



<? } ?>



