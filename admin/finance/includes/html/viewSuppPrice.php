<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_purchase'])) {echo $_SESSION['mess_purchase']; unset($_SESSION['mess_purchase']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	
	<tr>
        <td align="left" >
<?
echo '<a class="red_bt fancybox fancybox.iframe" href="SupplierList.php?link=viewSuppPrice.php">Select Vendor</a>';
?>
</td>
      </tr>	

	<tr>
        <td align="center" class="redmsg"><?=$ErrorMSG?></td>
      </tr>	

	<tr>
        <td align="left" height="30">
<?
if(!empty($arrySupplier[0]['SuppID'])){
	$_GET['supp'] = $_GET['sc'];
	require_once("includes/html/box/supp_box.php"); 
}
?>
</td>
      </tr>
	 
<? if(!empty($_GET['sc'])){ ?>

	<tr>
	  <td  valign="top">
	<br><br>

<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="<?=$MainPrefix?>images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?=sizeof($arryPurchase)?>');" /></td>-->
       <td width="8%" class="head1" >SKU</td>
      <td class="head1" >Description</td>
     <td width="12%"  class="head1" >Unit Price</td>
      <td width="12%"  class="head1" >Currency</td>
      <td  width="12%" class="head1" >PO Number</td>
       <td width="18%" class="head1" >Order Date</td>
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
      <td ><?=$values['sku']?></td>
     <td><?=stripslashes($values['description'])?></td>
      <td><?=$values['price']?></td>
     <td><?=$values['Currency']?></td>
       <td><a class="fancybox fancybig fancybox.iframe" href="../purchasing/vPO.php?module=Order&pop=1&po=<?=$values['PurchaseID']?>" ><?=$values["PurchaseID"]?></a></td>
	   <td height="20">
	   <? if($values['OrderDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['OrderDate']));
		?>
	   
	   </td>
     
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="6"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryPurchase)>0){?>
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
