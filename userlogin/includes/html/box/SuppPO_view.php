<?php 
require_once($Prefix."classes/purchase.class.php");	
	$objPurchase = new purchase();	
if(!empty($arrySupplier[0]['SuppCode'])){
	    $arrySupplier = $objSupplier->GetSupplier('',$arrySupplier[0]['SuppCode'],'');
		if(!empty($arrySupplier[0]['SuppID'])){
			$arryPurchase=$objPurchase->GetSuppPurchase($arrySupplier[0]['SuppCode'],'','','Order');
			$num=$objPurchase->numRows();

			$pagerLink=$objPager->getPager($arryPurchase,$RecordsPerPage,$_GET['curP']);
			(count($arryPurchase)>0)?($arryPurchase=$objPager->getPageRecords()):("");
		}else{
			$ErrorMSG = NOT_EXIST_SUPP;
		}
	}

?>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	<!-- <tr>
        <td align="left" >
<?
echo '<a class="red_bt fancybox fancybox.iframe" href="SupplierList.php?link=viewSuppPO.php">Select Vendor</a>';
?>
</td>
      </tr>	-->

	<tr>
        <td align="center" class="redmsg"><?=$ErrorMSG?></td>
      </tr>	

<? if(!empty($arrySupplier[0]['SuppCode'])){ ?>

	<tr>
	  <td  valign="top">
	<br><br>

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryPurchase)?>');" /></td>-->
      <td  width="12%" class="head1" >PO Number</td>
       <td width="18%" class="head1" >Order Date</td>
      <td width="12%" align="center" class="head1" >Amount</td>
      <td width="12%" align="center" class="head1" >Currency</td>
     <td  width="14%" align="center" class="head1" >Status</td>
       <td width="12%"  align="center" class="head1" >Approved</td>
      <td  align="center" class="head1 head1_action" >Invoices</td>
    </tr>
   
    <?php 
   
  if(is_array($arryPurchase) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryPurchase as $key=>$values){
	$flag=!$flag;
	$Line++;
	
  ?>
    <tr align="left" >
      <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?=$Line?>" value="<?=$values['OrderID']?>" /></td>-->
       <td><a class="fancybox fancybig fancybox.iframe" href="../admin/purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
	   <td height="20">
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>
	   
	   </td>
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['Currency']?></td>
     <td align="center">
	<?  $OrderIsOpen = 0;
		 if($values['Status'] == 'Cancelled' || $values['Status'] == 'Rejected'){
			 $StatusCls = 'red';
		 }else if($values['Status'] == 'Completed'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = '';
			 $OrderIsOpen = 1;
		 }

		echo '<span class="'.$StatusCls.'">'.$values['Status'].'</span>';
		
	 ?>
	 
	</td>


    <td align="center"><? 
		 if($values['Approved'] ==1){
			  $Approved = 'Yes';  $ApprovedCls = 'green';
		 }else{
			  $Approved = 'No';  $ApprovedCls = 'red';
		 }

		echo '<span class="'.$ApprovedCls.'">'.$Approved.'</span>';
		
	 ?></td>
      <td  align="center" class="head1_inner">

<?
	$TotalInvoice=$objPurchase->CountInvoices($values['PurchaseID']);
	$TotalQtyLeft = $objPurchase->GetTotalQtyLeft($values['PurchaseID']);
	
	//echo '<a href="viewPoInvoice.php?po='.$values['PurchaseID'].'" target="_blank" >'.$TotalInvoice.' Invoices</a>';
	
	
	if($values['Approved'] ==1){  //Temp
		if($TotalQtyLeft>0 && $OrderIsOpen == 1){
			#echo '  <a href="recieveOrder.php?po='.$values['OrderID'].'" target="_blank" >Receive</a>';
		}else{
			echo ' <span class=black>Received<span>';
		}
	}

?>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record"><?=NO_PO?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryPurchase)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','OrderID','editPurchase.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
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

	<? } ?>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>

<? } ?>
