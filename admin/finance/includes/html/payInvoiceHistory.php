<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>
	<?php //if(!empty($_REQUEST['view']) && $paidAmnt != $InvoiceAmount){?>
	<!--<a class="fancybox add" href="#payInvoice_div" style="float: right;">Pay Vendor</a>-->
	<?php //}?>
        <?php }?>
	<div class="had">Payment History</div>
	 
  <?

	



if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


	#include("includes/html/box/invoice_view.php");

?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<!--<tr>
	<td colspan="2" align="left" class="head">Payment History</td>
</tr>-->
<tr>
	<td align="left" colspan="2">
	<? 	include("includes/html/box/purchase_payment_invoice_view.php");?>
	</td>
</tr>
</table>
 <? if($_GET['pop']!=1){ ?>       
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">

<br>
<tr>
    <td  align="center" valign="top" >
<?php if($arryPurchase[0]['InvoiceEntry'] == 1){ ?>	
  <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Invoice Information</td>
</tr>
   <?php   
        $arryRecurr = $arryPurchase;

        include("../includes/html/box/recurring_2column_view.php");
        ?>  
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" width="20%"><B><?=stripslashes($arryPurchase[0]["InvoiceID"])?></B></td>
   

        <td  align="right" width="30%"  class="blackbold" >Invoice Date  : </td>
        <td   align="left" >
                <? 	
                $arryTime = explode(" ",$Config['TodayDate']);
                echo date($Config['DateFormat'], strtotime($arryTime[0]));
                ?>

		</td>
      </tr>  
      
      
      
 <tr>
        <td  align="right"   class="blackbold" >Item Received Date  :</td>
        <td   align="left" >
 <?=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
</td>

  <td  align="right" class="blackbold">Payment Term  :</td>
        <td   align="left">
		 <?=(!empty($arryPurchase[0]['PaymentTerm']))?(stripslashes($arryPurchase[0]['PaymentTerm'])):(NOT_SPECIFIED)?>
		</td>
      </tr>
      
      <tr>
        <td  align="right" class="blackbold">Payment Method  :</td>
        <td   align="left">
		 <?=(!empty($arryPurchase[0]['PaymentMethod']))?(stripslashes($arryPurchase[0]['PaymentMethod'])):(NOT_SPECIFIED)?>
		</td>
 
        <td  align="right" class="blackbold">Shipping Method  :</td>
        <td   align="left">
		<?=(!empty($arryPurchase[0]['ShippingMethod']))?(stripslashes($arryPurchase[0]['ShippingMethod'])):(NOT_SPECIFIED)?>
		</td>
</tr>
 
<tr>
        <td  align="right"   class="blackbold">Assigned To  : </td>
        <td   align="left">

<? if(!empty($arryPurchase[0]['AssignedEmp'])){ ?>
<a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryPurchase[0]['AssignedEmpID']?>" ><?=stripslashes($arryPurchase[0]['AssignedEmp'])?></a>   
<? 
	}else{
		echo NOT_SPECIFIED;
	}
?>
		  
		   </td>
                   <td valign="top" align="right" class="blackbold">Reference No#  :</td>
                   <td valign="top" align="left">
                    <B><?=stripslashes($arryPurchase[0]['PurchaseID'])?></B>
                </td>
      </tr>
 
 	<tr>
            <td  align="right" valign="top" class="blackbold" >&nbsp;</td>
			<td   align="left" >&nbsp;</td>
			<td  align="right"  valign="top" class="blackbold" > Comments  : </td>
			<td  valign="top" align="left" >
                        <?=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED)?>
		</td>
	</tr>

</table>     
 <?php } else {?>      
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="2" align="left" class="head">Invoice Information</td>
</tr>
 <tr>
        <td  align="right" class="blackbold" width="20%"> Invoice # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["InvoiceID"])?></B></td>
      </tr>
	 <tr>
        <td  align="right" class="blackbold">Invoice Date  : </td>
        <td   align="left" >
 		<?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>  
       <tr>
        <td  align="right" class="blackbold">Item Received Date  :</td>
        <td  align="left"><?=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
        <tr>
                <td  align="right"   class="blackbold"> Comments  : </td>
                <td  align="left">
                         <?=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED)?>

                </td>
        </tr>

 <tr>
        <td  align="right" class="heading">Payment Details</td>
		 <td  align="right" class="heading"></td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Total Amount : </td>
        <td   align="left" >
		<?	echo '<B>'.$arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'].'</B>';?>
		</td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Invoice Paid  : </td>
        <td   align="left" >
    <?=($arryPurchase[0]['InvoicePaid'] == 1)?('<span class="green">Yes</span>'):('<span class="red">No</span>')?>
           </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" >Payment Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PaymentDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
<tr>
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['InvPaymentMethod']))?(stripslashes($arryPurchase[0]['InvPaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

<tr>
        <td  align="right" class="blackbold">Payment Ref #  :</td>
        <td   align="left">
	<?=(!empty($arryPurchase[0]['PaymentRef']))?(stripslashes($arryPurchase[0]['PaymentRef'])):(NOT_SPECIFIED)?>
	
		</td>
</tr>

</table>
 <?php }?>      
	
	
	</td>
</tr>

<!--<tr>
	 <td  align="left"><? //include("../purchasing/includes/html/box/po_order_view.php");?></td>
</tr>-->

<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("../purchasing/includes/html/box/po_supp_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("../purchasing/includes/html/box/po_warehouse_view.php");?></td>
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
	 <td  align="left" class="head" ><?=RECEIVED_ITEM?>
         <?php if($arryPurchase[0]['InvoiceEntry'] != 1){ ?>    
	 <div style="float:right"><a class="fancybox hideprint fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div>
         <?php }?>
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
	<td align="left">
		 
            
              <?php
                if($arryPurchase[0]['InvoiceEntry'] == 1){
                    
                    include("includes/html/box/po_item_Invoice_Entry_view.php");
                }else{
                    include("includes/html/box/po_item_invoice.php");
                }
            ?>
	</td>
</tr>



</table>	
    
	
	</td>
   </tr>

  

  
</table>
	
 <?php }?>
<?php
//include("includes/html/box/purchase_invoice_payment_form.php");
?>

<? } ?>



