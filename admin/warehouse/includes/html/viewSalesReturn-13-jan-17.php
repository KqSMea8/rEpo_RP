<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>
<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_RECEIPT'])) {echo $_SESSION['mess_RECEIPT']; unset($_SESSION['mess_RECEIPT']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td  height="22" valign="bottom">

	<? if(empty($_GET['po'])){ ?>
		<a href="ReturnList.php?link=editSalesReturn.php" class="fancybox add fancybox.iframe">Stock In</a>
		<? } ?>

		<? if($_GET['search']!='') {?>
		<a href="<?='viewSalesReturn.php';?>" class="grey_bt">View All</a>
		<? } ?>

		<? if($num>0){?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_rma_sales.php?<?=$QueryString?>';">
		
		<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
		
		
		
		
		<? } ?>

	

		</td>
	</tr>
	 
	<tr>
	  <td  valign="top">
	

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      <td width="12%" class="head1" >Receipt Date</td>
      <td width="10%"  class="head1"  >Receipt #</td>
	   <td width="10%"  class="head1" >Invoice #</td>
      <td width="9%"  class="head1"  >RMA Number</td>
	  <td class="head1">Customer </td>
	  <td width="12%"   class="head1" >Posted By</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="6%" align="center" class="head1" >Currency</td>
       <td width="12%"  align="center" class="head1">Receipt Status</td>

      <td width="8%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryReturn) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryReturn as $key=>$values){
	$flag=!$flag;
	 
	$Line++;
	
	//$TotalGenerateReturn = $objSale->GetQtyReturned($values['OrderID']);
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	   <td height="20">
	   <? if($values['ReceiptDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ReceiptDate']));
		?>
	   
	   </td>
       <td ><?=$values["ReceiptNo"]?></td>
	   <td ><?=$values["InvoiceID"]?></td>
       <td  ><?=$values["ReturnID"]?></td>
	    
       <td> <a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> </td> 
	    <td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>
       <td align="center"><?=$values['TotalReceiptAmount']?></td>
     <td align="center"><?=$values['CustomerCurrency']?></td>

 
 <td align="center"><? 
		 if($values['ReceiptStatus'] == "Completed"){
			echo '<span class=green>'.$values['ReceiptStatus'].'</span>';			
		 }else{
		  	echo '<a href="editSalesReturn.php?active_id='.$values["ReceiptID"].'&curP='.$_GET['curP'].'" class="InActive" onclick="return confirmAction(this,\'Receipt Status Change\',\'Are you sure you want to complete this RMA Receipt?\' )">'.$values['ReceiptStatus'].'</a>';
		 }
	
		
		
	 ?></td>

	 
      <td  align="center" class="head1_inner">

		<a href="vSalesReturn.php?view=<?=$values['ReceiptID']?>&curP=<?=$_GET['curP']?>&rcpt=<?=$values['ReceiptNo'];?>"><?=$view?></a>
                <? if($values['ReceiptStatus']!="Completed"){?>
		<!--<a href="editSalesReturn.php?edit=<?=$values['ReceiptID']?>&curP=<?=$_GET['curP']?>&rcpt=<?=$values['ReceiptNo'];?>"><?=$edit?></a>-->
		<a href="editSalesReturn.php?del_id=<?=$values['ReceiptID']?>&curP=<?=$_GET['curP']?>&rcpt=<?=$values['ReceiptNo'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a> 
                <? }?>
                <a href="pdfWarehouseReturn.php?RTN=<?=$values['ReceiptID']?>"><?=$download?></a>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="10" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReturn)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryReturn)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td  align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".po").fancybox({
			'width'         : 900
		 });

});

</script>

<? } ?>
