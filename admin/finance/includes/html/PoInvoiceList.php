<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function SelectPO(PurchaseID,OrderID){	
	ResetSearch();
	window.parent.parent.location.href = document.getElementById("link").value+"?view="+OrderID+"&po="+PurchaseID;
	//parent.jQuery.fancybox.close();
   }

</script>

<div class="had">PO Number&nbsp;<?=$_GET['key']?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	 
	<tr>
	  <td  valign="top" height="300">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left">
	    <td width="12%" class="head1">Invoice Number</td>
		<td width="12%"  class="head1">Invoice Date</td>
		<td width="10%"  class="head1" >PO Number</td>
		<td width="10%"  class="head1" >Order Date</td>
		<td width="15%"  class="head1" >Supplier</td>
		<td width="8%"   align="center" class="head1" >Amount</td>
		<td width="8%"   align="center" class="head1" >Currency</td>
		<td width="10%"  align="center" class="head1" >Invoice Paid</td>
    </tr>
   
	<?php 
	if(is_array($arryInvoice) && $num>0){
	$flag=true;
	$Line=0;
	foreach($arryInvoice as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	?>
	<tr align="left"  bgcolor="<?=$bgcolor?>">
			<td>
<?php  if($values['InvoicePaid'] ==1){?>
<?=$values['InvoiceID']?>
<?php } else {?>
	<a href="Javascript:void(0);" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SelectPO('<?=$values['PurchaseID']?>','<?=$values['OrderID']?>')"><?=$values['InvoiceID']?></a>
<?php }?>
</td>
			<td>
				<? if($values['PostedDate']>0) 
				echo date($Config['DateFormat'], strtotime($values['PostedDate']));
				?>
			</td>
			<td><a class="fancybox po fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td> 
			<td><? if($values['OrderDate']>0) 
				   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
				?>	
			</td>
			<td> <a class="fancybox supp fancybox.iframe" href="suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a></td>
			<td align="center"><?=$values['TotalAmount']?></td>
			<td align="center"><?=$values['Currency']?></td>


			<td align="center"><? 
				 if($values['InvoicePaid'] ==1){
					  $Paid = 'Paid';  $PaidCls = 'green';
				 }else if($values['InvoicePaid'] ==2){
					  $Paid = 'Part Paid';  $PaidCls = 'red';
				 }else{
					  $Paid = 'Unpaid';  $PaidCls = 'red';
				 }

				echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';
		
			 ?></td>

    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_INVOICE?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryInvoice)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 

<input type="hidden" name="link" id="link" value="<?=$_GET['link'];?>">
  
</form>
</td>
	</tr>
</table>

