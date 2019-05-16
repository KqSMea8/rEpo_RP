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
	
	   <td align="right" height="22" valign="bottom">

		<? if(empty($_GET['po'])){ ?>
		<a href="PoPurchaseRmaList.php?link=editPoRma.php" class="fancybox add fancybox.iframe">Stock Out</a>
		<? } ?>

		<? if($_GET['search']!='') {?>
		<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
		<? } ?>

        <? if($num>0){?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_rma_purchase.php?<?=$QueryString?>';" />
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
      <td width="8%"  class="head1"   >RMA #</td>
	   <td width="8%"  class="head1" >Invoice #</td>

	  <td class="head1"  >Vendor</td>
	  	<td width="12%"   class="head1" >Posted By</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="8%" align="center" class="head1" >Currency</td>
 <td width="10%" align="center" class="head1" >Receipt Status</td>
  
      <td width="8%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 

  if(is_array($arryReturn) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryReturn as $key=>$values){
	$flag=!$flag;
	$Line++;
	 if(!empty($values["VendorName"])){
		$VendorName = $values["VendorName"];
	}else{
		$VendorName = $values["SuppCompany"];
	}
  ?>
  
    <tr align="left" >
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
	   <td height="20">
	   <? if($values['PostedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['PostedDate']));
		?>
	   
	   </td>
     <td ><?=$values["ReceiptNo"]?></td>
      <td><?=$values["ReturnID"]?></td>
	   <td  ><?=$values["InvoiceID"]?></td>

	   	
      <td> <a class="fancybox fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($VendorName)?></a> </td> 
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
     <td align="center"><?=$values['SuppCurrency']?></td>

 <td align="center"><? 
		 if($values['ReceiptStatus'] == "Completed"){
			echo '<span class=green>'.$values['ReceiptStatus'].'</span>';			
		 }else{
		  	echo '<a href="editPoRma.php?active_id='.$values["ReceiptID"].'&curP='.$_GET['curP'].'" class="InActive" onclick="return confirmAction(this,\'Receipt Status Change\',\'Are you sure you want to complete this RMA Receipt?\' )">'.$values['ReceiptStatus'].'</a>';
		 }
	
		
		
	 ?></td>

	   <td  align="center" class="head1_inner">

		<a href="vPoRma.php?view=<?=$values['ReceiptID']?>&curP=<?=$_GET['curP']?>&rcpt=<?=$values['ReceiptNo'];?>"><?=$view?></a>
       <?php /*?>	<a href="editPoReturn.php?edit=<?=$values['ReceiptID']?>&curP=<?=$_GET['curP']?>&rcpt=<?=$values['ReceiptNo'];?>"><?=$edit?></a><?php */?>
		 <? if($values['ReceiptStatus']!="Completed"){?>
		<a href="editPoRma.php?del_id=<?=$values['ReceiptID']?>&curP=<?=$_GET['curP']?>&rcpt=<?=$values['ReceiptNo'];?>" onclick="return confirmDialog(this, 'RMA Receipt')"><?=$delete?></a>
       <? }?> 
        <?php /*?><a href="pdfPoRma.php?RCPT=<?=$values['ReceiptID']?>"><?=$download?></a><?php */ ?>
        <a href="../pdfCommonhtml.php?o=<?= $values['ReceiptID'] ?>&ModuleDepName=<?= $ModDepName ?>&curP=<?= $_GET['curP'] ?>"><?= $download ?></a>

	  </td>
	 
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryReturn)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryReturn)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td  align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET['curP']?>&opt=<?=$_GET['opt']?>');" /></td>
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
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>

<? } ?>
