<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectSO(OrderID,SaleID){	
	ResetSearch();
	window.parent.location.href = document.getElementById("link").value+"?so="+SaleID+"&invoice="+OrderID;
}

</script>

<div class="had">Select Sales Order</div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_salr']; unset($_SESSION['mess_salr']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right" valign="bottom">

<form name="frmSrch" id="frmSrch" action="SalesOrderList.php" method="get" onSubmit="return ResetSearch();">
	<input type="text" name="key" id="key" placeholder="<?=SEARCH_KEYWORD?>" class="textbox" size="20" maxlength="30" value="<?=$_GET['key']?>">&nbsp;<input type="submit" name="sbt" value="Go" class="search_button">
	 <input type="hidden" name="link" id="link" value="<?=$_GET['link']?>">
</form>



		</td>
      </tr>
	 
	<tr>
	  <td  valign="top" height="400">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none;padding:50px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="10%"  class="head1" >SO Number</td>
       <td width="10%" class="head1" >Order Date</td>
     <td class="head1" >Customer</td>
	<td class="head1">Sales Person</td>
      <td width="10%" align="center" class="head1" >Amount</td>
      <td width="8%" align="center" class="head1" >Currency</td>
     <td width="10%"  align="center" class="head1" >Status</td>
	<td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arrySale) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
       <td>
<?=$values['SaleID']?>

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
	<?=$objSale->GetOrderStatusMsg($values['Status'],$values['Approved'],$values['PaymentTerm'],$values['OrderPaid'])?>



</td>

 <td align="center">


<?

	$TotalGenerateInvoice=$objSale->GetQtyInvoicedCheck($values['OrderID']);

	if($values['Status'] =='Open' && $values['Approved'] ==1 && $TotalGenerateInvoice[0]['QtyInvoiced'] != $TotalGenerateInvoice[0]['Qty']){ ?>

<a href="Javascript:void(0);" class="action_bt" onclick="Javascript:SelectSO(<?=$values['OrderID']?>,'<?=$values['SaleID']?>')" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()"><?=GENERATE_INVOICE?></a>		
	<? }

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

