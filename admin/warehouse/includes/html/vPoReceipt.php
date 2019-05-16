<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>

	<? if(empty($ErrorMSG)){?>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<!--a href="<?=$EditUrl?>" class="edit">Edit</a-->
	<!--<a href="<?=$DownloadUrl?>" target="_blank" class="pdf" style="float:right">Download</a>-->
        <ul class="editpdf_menu">
	<li>
	<a href="<?=$DownloadUrl?>" target="_blank" class="pdf" style="float:right;margin-left:5px;">Download</a>
                <ul>
		<?php 

		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'">Default</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
		 
		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&tempid='.$tempnmval['id'].'">'.$tempnmval['TemplateName'].'</a></li>';
		}
		}
		?>

		</ul>
        </li>
        </ul>
	<ul class="editpdf_menu">
            <li><a class="edit" href="javascript:void(0)">Edit PDF</a>
                <ul>
                    <?php
                    echo '<li><a class="add" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&ModuleDepName=' . $ModuleDepName . '&rcpt='.$_GET['rcpt'].'">Add PDF Template</a></li>';
                    if (sizeof($GetPFdTempalteNameArray) > 0) {
                        foreach ($GetPFdTempalteNameArray as $tempnmval) {
                         echo '<li>';
		 if($tempnmval['AdminID']==$_SESSION['AdminID']){
                            echo '<a class="delete" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&Deltempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '"></a>';
                             }

                            echo '<a class="edit editpdf" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&tempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </li>                               
    </ul>
	<? } ?>

	<div class="had"><?=$MainModuleName?>    <span>&raquo;	<?=$ModuleName?> Detail </span></div>
	
	
	

	<div class="message" align="center"><? if(!empty($_SESSION['mess_Receipt'])) {echo $_SESSION['mess_Receipt']; unset($_SESSION['mess_Receipt']); }?></div>
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
	 <td colspan="4" align="left" class="head">Receipt Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Receipt # : </td>
        <td   align="left" ><B><?=stripslashes($arryPurchase[0]["ReceiptID"])?></B></td>
      
        <td  align="right"   class="blackbold" > Item Received Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['ReceivedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceivedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>
<? if($arryPurchase[0]['CreatedDate']>0){ ?>
	<tr>
	<td  align="right"   class="blackbold" > Created Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['CreatedDate'])); ?>
	</td>
	<td  align="right"   class="blackbold" >  Updated Date  : </td>
	<td   align="left"  >
		<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arryPurchase[0]['UpdatedDate'])); ?>
	</td>
	</tr>
	<? } ?>
 <tr>
        <td  align="right"   class="blackbold" > Generate Invoice  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['GenrateInvoice']==1)?("Yes"):("No")?>
		</td>
      </tr>
 <tr>
 <td  align="right"   class="blackbold" >  Invoice Number # : </td>
<td   align="left" ><B><?=stripslashes($arryPurchase[0]["RefInvoiceID"])?></B></td>
 </tr>
<tr>
        <td  align="right"   class="blackbold" > Receipt Status  : </td>
        <td   align="left" > 
<?=($arryPurchase[0]['ReceiptStatus'] =='Completed')?('<span class=green>'.$arryPurchase[0]['ReceiptStatus'].'</span>'):('<span class=red>'.$arryPurchase[0]['ReceiptStatus'].'</span>')?>
 
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
                  
      </tr>
	<tr>
			<td  align="right"   class="blackbold" > Comments  : </td>
			<td   align="left" >
	<?=(!empty($arryPurchase[0]['InvoiceComment']))?(stripslashes($arryPurchase[0]['InvoiceComment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

 <!--tr>
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
</tr-->

</table>
 	
	
 </td>
</tr>

<tr>
	 <td  align="left">
<? 
if($arryPurchase[0]['InvoiceEntry'] == 0){ 
	include("includes/html/box/po_order_view.php");
}
?></td>
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
	 <td  align="left" class="head" ><?=RECEIVED_ITEM?>
             <?php  if($arryPurchase[0]['InvoiceEntry'] != 1){?>
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
	<td align="left" >
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
	



<? } ?>



