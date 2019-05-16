<? if($_GET['pop']!=1){?>
<a class="back" href="<?=$RedirectURL?>">Back</a> 
<div class="had">
     <?=$MainModuleName?>   &raquo; <span>View Details</span>

</div>

<? }?>

<h2><font color="darkred"> Batch : <?php echo stripslashes($batchArr[0]['batchname']); ?>          </h2>
  
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Batch Details</td>
</tr>

<tr>
	<td  align="right"   class="blackbold" > Batch Name  : </td>
	<td   align="left" ><?php echo stripslashes($batchArr[0]['batchname']); ?></td>
	</tr>
<tr>
	<td  align="right"   class="blackbold"> No of Sales Entries  : </td>
	<td   align="left" ><?php echo $ContSaleID	=  	$objShipment->CountSaleBatches($_GET['view']);
			 ?>      </td>

	<td  align="right"   class="blackbold">No of Invoice Entries  : </td>
	<td   align="left" ><?php echo $ContInvoiceID	=  	$objShipment->CountInvoiceBatches($_GET['view']); ?>   </td>
</tr>

<tr>
	<td  align="right"   class="blackbold"> Created On : </td>
	<td   align="left" ><?php echo date('d F, Y h:i A', strtotime($batchArr[0]['createdon']));?> </td>

	<td  align="right"   class="blackbold"> Created By : </td>
	<td   align="left" ><?php echo stripslashes($batchArr[0]['createdby']); ?> <td>
</tr>
 
<tr>
	<td align="right"   class="blackbold" >Modified  On :</td>
	<td  align="left" ><?php echo date('d F, Y h:i A', strtotime($batchArr[0]['modifiedon'])); ?> </td>

	<td  align="right"   class="blackbold"> Modified  by  :</td>
	<td   align="left" ><?php echo stripslashes($batchArr[0]['modifiedby']); ?></td>
</tr>
<tr>
	<td  align="right" class="blackbold"> status  :</td>
	<td  align="left" class="blacknormal"><?php echo stripslashes($batchArr[0]['status']); ?></td>
</tr>
      
	
 
</table>	
  

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
		<td align="right" height="22" valign="bottom">

		<? if($num>0){?>
		<input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location='export_Shipment.php?<?=$QueryString?>';" />
		
		<? } ?>

		<?php  
            if($batchArr[0]['status'] =='Open'){
            //added on 16May by chetan//
            //if($_SESSION['batchmgmt'] == NULL || empty($_SESSION['batchmgmt'])){
         ?>
            <a href="SorderList.php?link=editShipment.php&batchId=<?=$_GET['view']?>" class="fancybox add fancybox.iframe">Add Shipment</a>
        <?php //}else{?>
            
           <!-- <a href="selectbatch.php" class="fancybox add fancybox.iframe">Add Shipment</a><added by chetan 6May-->
        <?php } //} ?>

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
  if(is_array($EntriesArr)){


  	$flag=true;
	$Line=0;
  	foreach($EntriesArr as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	
	//$TotalGenerateShipment = $objSale->GetQtyShipmented($values['OrderID']);
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
	   <td height="20">
	   <? if($values['ShippedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($values['ShippedDate']));
	   ?>
	   
	   </td>
       <td><?=$values["ShippingID"]?></td>
	  
        <td > <a class="fancybox po fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&amp;pop=1&amp;so=<?php echo $values['SaleID'] ?>"> <?php echo $values['SaleID'] ?></a></td>
 <td><a class="fancybox po fancybox.iframe" href="../finance/vInvoice.php?pop=1&inv=<?=$values['InvoiceID']?>" ><?=$values["InvoiceID"]?></a> <? if($batchArr[0]['status']!='Closed' && $values['PostToGL']!='1' && !empty($values['InvoiceID'])){ ?> &nbsp;&nbsp;&nbsp; <a href="editshipInvoice.php?InvoiceID=<?=$values['InvoiceID']?>&curP=<?=$_GET['curP']?>&ship=<?=$values['ShippingID'];?>&batch=<?=$_GET['view']?>"><?=$edit?></a><? }?></td>
	    
       <td> <a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>"><?=stripslashes($values["CustomerName"])?></a> </td> 
	     <td>
         <? $salesPersoToDisplay ="";
          			if((!empty($values['SalesPersonID'])) || (!empty($values['VendorSalesPerson']))){
          			$salesPersoToDisplay = $objConfig->createSalesPersonLink($values['SalesPersonID'],$values['VendorSalesPerson']);
						
                            echo $salesPersoToDisplay;
					 }

           ?>
		</td>
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

		<a href="vShipment.php?view=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&ship=<?=$values['ShippingID'];?>&batch=<?=$_GET['view']?>"><?=$view?></a>
<? 

 //if($batchArr[0]['status'] =='Open'){
if(($values['ShipmentStatus'] != 'Shipped' || $batchArr[0]['status'] =='Open') && ($values['PostToGL']!='1')){

 ?>
		<a href="editShipment.php?edit=<?=$values['OrderID']?>&curP=<?=$_GET['curP']?>&ship=<?=$values['ShippingID'];?>&batch=<?=$_GET['view']?>"><?=$edit?></a>
		<a href="editShipment.php?del_id=<?=$values['OrderID']?>&batch=<?=$_GET['view']?>&curP=<?=$_GET['curP']?>&ship=<?=$values['ShippingID'];?>" onclick="return confirmDialog(this, 'Shipment')"><?=$delete?></a> 
<? } //}?>
		<!--<a href="pdfShipment.php?SHIP=<?=$values['OrderID']?>"><?=$download?></a>-->
               <a href="../pdfCommonhtml.php?SHIP=<?= $values['OrderID'] ?>&ModuleDepName=<?= $ModDepName ?>&curP=<?= $_GET['curP'] ?>"><?= $download ?></a>

	</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="11" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="11"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($num)>0){?>
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


	
	  
	
	</td>
   </tr>

   <tr>
	<td align="left" valign="top">&nbsp;
	
</td>
   </tr>


   </form>
</table>
