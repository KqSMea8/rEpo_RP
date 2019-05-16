<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}

function SetSaleID(SaleID){
	ResetSearch();
	window.parent.document.getElementById("SaleID").value=SaleID;
	parent.jQuery.fancybox.close();
	ShowHideLoader('1','P');

}

function SelectSO(OrderID,SaleID){	
	ResetSearch();
	window.parent.location.href = document.getElementById("link").value+"?so="+SaleID+"&invoice="+OrderID;
}

function selectSearch(EditURL, SaleID){ 
         ResetSearch(); 
         var SuppCode = window.parent.document.getElementById("SuppCode").value; 
         window.parent.location.href = EditURL+"&SaleID="+SaleID+"&SuppCode="+SuppCode;
}
</script>

<div class="had">Select Sales Order</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	<td align="right" valign="bottom">

	<form name="frmSrch" id="frmSrch" action="selectSO.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	<input type="hidden" name="o" id="o" value="<?=$_GET['o']?>">
	</form>



	</td>
	</tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
    <tr align="left">
		<td width="12%"  class="head1" >SO Number</td>
		<td width="12%" class="head1" >Order Date</td>
		<td class="head1" >Customer Name</td>
		<td class="head1">Sales Person</td>
		<td width="10%" align="center" class="head1" >Amount</td>
		<td width="10%" align="center" class="head1" >Currency</td>
		<td width="10%"  align="center" class="head1" >Status</td>
		
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
		

 <td>


	<?

	$TotalGenerateInvoice=$objSale->GetQtyInvoiced($values['OrderID']);

	//if($values['Status'] =='Open' && $values['Approved'] ==1 && $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty']){ 

if($values['Status'] =='Open' && $values['Approved'] ==1 ){
?>

<a href="Javascript:void(0);" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"   onClick="selectSearch('<?=$EditURL?>', '<?=$values["SaleID"]?>');"><?=$values['SaleID']?></a>
	
	<? }else{
		echo $values['SaleID'];
	}

	?>

</td>





			<td>
			<? /*if($values['OrderDate']>0) 
			echo date($Config['DateFormat'], strtotime($values['OrderDate']));*/
			echo $values['OrderDate'];
			?>

			</td>
			<td><?=stripslashes($values["CustomerName"])?></td> 
			<td><?=stripslashes($values['SalesPerson'])?></td>
			<td align="center"><?=$values['TotalAmount']?></td>
			<td align="center"><?=$values['CustomerCurrency']?></td>
			<td align="center">	
			

 <? $OrderStatus = $objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid']);
echo $OrderStatus;
		
	 ?>


</td>




    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_SO?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="8"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}?></td>
	 </tr>
  </table>

  </div> 


  
</form>
</td>
	</tr>
</table>

