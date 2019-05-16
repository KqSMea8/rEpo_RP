<script language="JavaScript1.2" type="text/javascript">
function ValidateSearch(){	
	ShowHideLoader('1');
	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';
}
</script>

<div class="had"><?=$MainModuleName?></div>
<div class="message" align="center"><? if(!empty($_SESSION['mess_ship'])) {echo $_SESSION['mess_ship']; unset($_SESSION['mess_ship']); }?></div>


<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td align="right" height="22" valign="bottom">

		<? if($num>0){?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_Shipment.php?<?=$QueryString?>';" />
		
		<? } ?>

		<?php  
            if(empty($_GET['po'])){
            //added on 16May by chetan//
            if($_SESSION['batchmgmt'] == NULL || empty($_SESSION['batchmgmt'])){
         ?>
            <a href="SorderList.php?link=editShipment.php" class="fancybox add fancybox.iframe">Add Shipment</a>
        <?php }else{?>
            
            <a href="selectbatch.php" class="fancybox add fancybox.iframe">Add Shipment</a><!--added by chetan 6May-->
        <?php } } ?>

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
      <td width="10%" class="head1" >Shipment Date</td>
      <td width="10%"  class="head1"  >Shipment #</td>
	  
      <td width="9%"  class="head1"  >SO #</td>
      <td width="9%"  class="head1"  >Invoice #</td>
	  <td class="head1">Customer</td>
	   <td width="10%" class="head1">Sales Person</td>
	<td width="10%"   class="head1" >Posted By</td>
      <td width="8%" align="center" class="head1" >Amount</td>
      <td width="5%" align="center" class="head1" >Currency</td>
<td width="5%" align="center" class="head1" >Status</td>
      
      <td width="10%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryShipment) && $num>0){


  	$flag=true;
	$Line=0;
  	foreach($arryShipment as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	 $arryShip = $objShipment->GetWarehouseShip('',$values['OrderID']);

 	$InvPostToGL='';
	if(!empty($arryShip[0]['RefID'])){
	 	$arryInvoice = $objSale->GetInvoice('', $arryShip[0]['RefID'], 'Invoice');
		if(isset($arryInvoice[0]['PostToGL'])){
			$InvPostToGL = $arryInvoice[0]['PostToGL'];
		}
	} 
	//$TotalGenerateShipment = $objSale->GetQtyShipmented($values['OrderID']);
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	   <td height="20">
	   <? if($values['ShipmentDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ShipmentDate']));
	   ?>
	   
	   </td>
       <td><?=$values["ShippingID"]?></td>
	  
       <td><?=$values["SaleID"]?></td>
 <td><a class="fancybox po fancybox.iframe" href="../finance/vInvoice.php?pop=1&inv=<?=$values['RefID']?>" ><?=$values["RefID"]?></a></td>
	    
       <td> <a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> </td> 
	     <td><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['SalesPersonID']?>"><?=stripslashes($values["SalesPerson"])?></a></td>
<td >
<?  
if($values["AdminType"]=='employee') {
	echo '<a class="fancybox fancybox.iframe" href="../userInfo.php?view='.$values['AdminID'].'" >'.stripslashes($values["PostedBy"]).'</a>';
}else {
	echo $values["PostedBy"];
}
 ?>  
</td>
       <td align="center"><?=$values['TotalAmount']?></td>
     <td align="center"><?=$values['CustomerCurrency']?></td>
<td align="center">
<?
if($values['ShipmentStatus'] == 'Shipped'){
	$cls ='green';
}else{
	$cls ='red';
}
?>
<span class="<?=$cls?>"><?=$values['ShipmentStatus']?></span>


</td>


   
      <td  align="center" class="head1_inner">

		<a href="vShipment.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&ship=<?=$values['ShippingID'];?>"><?=$view?></a>
<? if(empty($InvPostToGL)){?>
		<a href="editShipment.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&ship=<?=$values['ShippingID'];?>"><?=$edit?></a>
<? }?>
<? if($values['ShipmentStatus'] != 'Shipped'){?>
		<a href="editShipment.php?del_id=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&ship=<?=$values['ShippingID'];?>" onclick="return confirmDialog(this, 'Shipment')"><?=$delete?></a> 
<? }?>
		<a href="pdfShipment.php?SHIP=<?=$values['OrderID']?>"><?=$download?></a>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryShipment)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
  
  
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
