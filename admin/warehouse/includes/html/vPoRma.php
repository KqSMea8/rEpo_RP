<? if($_GET['pop']!=1){ ?>

	<a href="<?=$RedirectURL?>" class="back">Back</a>

	<? if(empty($ErrorMSG)){?>
	<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<?php /*?><a href="<?=$EditUrl?>" class="edit">Edit</a>
	<a href="<?=$DownloadUrl?>" target="_blank" class="pdf" style="float:right">Download</a><?php*/?>
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
                           echo  '<a class="edit editpdf" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&tempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </li>                               
    </ul>
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

<?php //echo "<pre>";print_r($arryPurchase);?>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
    <td  align="center" valign="top" >
	
	
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Receipt Information</td>
</tr>
 <tr>
        <td  align="right"   class="blackbold" width="20%"> Receipt Number# : </td>
        <td   align="left" width="30%"><B><?=stripslashes($arryPurchase[0]["ReceiptNo"])?></B></td>
    
        <td  align="right"   class="blackbold" width="20%">Receipt Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr> 
 <tr>
        <td  align="right"   class="blackbold" width="20%"> RMA No# : </td>
        <td   align="left" width="30%"><B><?=stripslashes($arryPurchase[0]["ReturnID"])?></B></td>
    
        <td  align="right"   class="blackbold" width="20%">RMA Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PostedDate']))):(NOT_SPECIFIED)?>
		</td>
      </tr>  
	  <tr>
        <td  align="right"   class="blackbold" >Item RMA Date  : </td>
        <td   align="left" >
 <?=($arryPurchase[0]['ReceiptDate']>0)?(date($Config['DateFormat'], strtotime($arryPurchase[0]['ReceiptDate']))):(NOT_SPECIFIED)?>
		</td>
     
			<td  align="right"  valign="top" class="blackbold" > Comments  : </td>
			<td   align="left"  valign="top" >
	<?=(!empty($arryPurchase[0]['ReceiptComment']))?(stripslashes($arryPurchase[0]['ReceiptComment'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

    <tr>
	
	<td  align="right"   class="blackbold" width="20%"> Status : </td>
	
        <td   align="left" width="30%"><?=$arryPurchase[0]["ReceiptStatus"];?></td>
	<td align="right">Re-Stocking :</td>
     <td   align="left">
	<?=(!empty($arryRMA[0]["Restocking"]))?('Yes'):('No')?>

	      </td> 
	</tr>

    <tr>


<!--tr>
        <td  align="right" class="heading">Payment Details</td>
		 <td  align="right" class="heading"  colspan="3"></td>
      </tr>

	<tr>
        <td  align="right"   class="blackbold" > Total Amount : </td>
        <td   align="left" >
		<?	if(!empty($arryPurchase[0]['TotalAmount'])){
				echo '<B>'.$arryPurchase[0]['TotalAmount'].' '.$arryPurchase[0]['Currency'].'</B>';
			}
?>
		</td>
    
        <td  align="right"   class="blackbold" > RMA Amount Paid  : </td>
        <td   align="left" >
    <?=(!empty($arryPurchase[0]['InvoicePaid']))?('<span class="green">Yes</span>'):('<span class="red">No</span>')?>
           </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold" >Payment Date  : </td>
        <td   align="left" >
 <?=(!empty($arryPurchase[0]['PaymentDate']))?(date($Config['DateFormat'], strtotime($arryPurchase[0]['PaymentDate']))):(NOT_SPECIFIED)?>
		</td>
      
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
	 <td align="left"><? include("includes/html/box/rma_invoice_view.php");?></td>
</tr>


<tr>
	<td align="left">
	<?
	$arryShipStand['ModuleType'] = 'PurchaseRMA';
	$arryShipStand['RefID'] = $RmaOrderID; 
	$HideVoid=1;
	include("../includes/html/box/shipping_info_standalone.php");
	?>
	</td>
</tr>


<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/po_supp_purchase_rma_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/warehouse_PoRma_view.php");?></td>
		</tr>
	</table>

</td>
</tr>

<tr>
	 <td align="right">
<?
echo $CurrencyInfo = str_replace("[Currency]",$arryPurchase[0]['SuppCurrency'],CURRENCY_INFO);
?>	 
	 </td>
</tr>


<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
	 <td  align="left" class="head" >Line Item
	 <?php /*?><div style="float:right"><a class="fancybox hideprint fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$arryPurchase[0]['PurchaseID']?>" ><?=VIEW_ORDER_DETAIL?></a></div><?php */?>

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
	
		<? 	include("includes/html/box/po_item_purchase_rma_view.php");?>
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
	



<? } ?>



