<script language="JavaScript1.2" type="text/javascript">
function ResetSearch(){	
	$("#prv_msg_div").show();
	$("#frmSrch").hide();
	$("#preview_div").hide();
}
function SelectSO(OrderID,InvoiceID){	
	ResetSearch();
	window.parent.location.href = document.getElementById("link").value+"?InvoiceID="+InvoiceID+"&edit="+OrderID+"&invoice=1";
}

</script>

<div class="message" align="center"><? if(!empty($_SESSION['mess_salr'])) {echo $_SESSION['mess_sale']; unset($_SESSION['mess_sale']); }?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	<tr>
	<td valign="bottom" align="right">

	<form onsubmit="return ResetSearch();" method="get" action="selectInvoice.php" id="frmSrch" name="frmSrch">
	<input type="text" value="" maxlength="30" size="20" class="textbox" placeholder="Search Keyword" id="key" name="key">&nbsp;<input type="submit" class="search_button" value="Go" name="sbt">
	<input type="hidden" value="" id="o" name="o">
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
	    <td width="14%" class="head1">Invoice Number</td>
		<td width="12%"  class="head1">Invoice Date</td>
		<td class="head1">Customer Name</td>
		<td class="head1">Sales Person</td>
		<td width="10%" align="center" class="head1" >Amount</td>
		<td width="10%" align="center" class="head1" >Currency</td>
		<td width="10%" align="center" class="head1" >Status</td>
		
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
                            
                      <a href="<?=$EditURL?>?InvoiceEntryID=<?=$values['InvoiceID']?>" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" target="_parent" onClick="ResetSearch();">
                         <?=$values['InvoiceID']?></a></td>
			<td>
				<? /*if($values['InvoiceDate']>0) 
				echo date($Config['DateFormat'], strtotime($values['InvoiceDate']));*/
				echo $values['InvoiceDate'];
				?>
			</td>
			<td><?=stripslashes($values["CustomerName"])?></td> 
			<td><?=stripslashes($values['SalesPerson'])?></td>
			<td align="center"><?=$values['TotalInvoiceAmount']?></td>
			<td align="center"><?=$values['CustomerCurrency']?></td>
			<td align="center">	
			 <? 
                                if($values['InvoicePaid'] =='Paid'){
                                        $StatusCls = 'green';
                                }else{
                                        $StatusCls = 'red';
                                }

                               echo '<span class="'.$StatusCls.'">'.$values['InvoicePaid'].'</span>';

                        ?></td>



    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record"><?=NO_INVOICE?> </td>
    </tr>
    <?php } ?>
  
	 <tr>  
	 <td colspan="7"  id="td_pager">
	 Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arrySale)>0){?>
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

