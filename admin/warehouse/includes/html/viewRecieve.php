<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_return'])) {echo $_SESSION['mess_return']; unset($_SESSION['mess_return']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td align="right" height="22" valign="bottom">

		<? if($num>0){?>
		<!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_return.php?<?=$QueryString?>';" / -->
		
		<? } ?>

		<? if(empty($_GET['po'])){ ?>
		<a href="SoList.php" class="fancybox add fancybox.iframe">Stock In</a>
		<? } ?>

		<? if($_GET['search']!='') {?>
		<a href="<?=$RedirectURL?>" class="grey_bt">View All</a>
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
      <td width="12%" class="head1" >Return Date</td>
      <td width="12%"  class="head1" align="center">Return Number</td>
	   <td width="12%"  class="head1" align="center">Invoice Number</td>
      <td width="9%"  class="head1" align="center" >SO Number</td>
	  <td class="head1">Customer Name</td>
	   <td class="head1">Sales Person</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="8%" align="center" class="head1" >Currency</td>
       <!--<td width="5%"  align="center" class="head1">Paid</td>-->
      <td width="15%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryRecieve) && $num>0){
  $flag=true;
	$Line=0;
  	foreach($arryRecieve as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//$TotalGenerateRecieve = $objSale->GetQtyRecieveed($values['OrderID']);
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	   <td height="20">
	   <? if($values['RecieveDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['RecieveDate']));
		?>
	   
	   </td>
       <td align="center"><?=$values["RecieveID"]?></td>
	   <td align="center"><?=$values["InvoiceID"]?></td>
       <td align="center"><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" ><?=$values["SaleID"]?></a></td>
	    
       <td> <a class="fancybox fancybox.iframe" href="../sales/custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> </td> 
	    <td><?=stripslashes($values['SalesPerson'])?></td>
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['CustomerCurrency']?></td>


   <!-- <td align="center"><? 
		 if($values['RecievePaid'] == "Yes"){
			  $Paid = 'Yes';  $PaidCls = 'green';
		 }else{
			  $Paid = 'No';  $PaidCls = 'red';
		 }

		echo '<span class="'.$PaidCls.'">'.$Paid.'</span>';
		
	 ?></td>-->
      <td  align="center" class="head1_inner">

		<a href="vRecieve.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&rtn=<?=$values['RecieveID'];?>"><?=$view?></a>
		<!--a href="editRecieve.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&rtn=<?=$values['RecieveID'];?>"><?=$edit?></a-->
		<!--a href="editRecieve.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&rtn=<?=$values['RecieveID'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"><?=$delete?></a--> 
		<!--a href="pdfRecieve.php?RTN=<?=$values['OrderID']?>"><?=$download?></a -->

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="9"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryRecieve)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryRecieve)){ ?>
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
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>

<? } ?>