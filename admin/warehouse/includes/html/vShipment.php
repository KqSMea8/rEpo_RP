<? if($_GET['pop']!=1){ 


/*********************/
		/*********************/
	   	$NextID = $objSale->NextPrevRowShipment($_GET['view'],1,'Shipment',$_GET['batch']);
		$PrevID = $objSale->NextPrevRowShipment($_GET['view'],2,'Shipment',$_GET['batch']);
		$Ie = 'yes';
if($_GET['batch']>0){ $NextPrevUrl = "vShipment.php?batch=".$_GET['batch']."&curP=".$_GET["curP"];}else{
		$NextPrevUrl = "vShipment.php?curP=".$_GET["curP"];
}
		include("includes/html/box/next_prev.php");
		/*********************/
		/*********************/

?>



<a href="<?=$RedirectURL?>" class="back">Back</a>
<div class="had">
<?=$MainModuleName?>  <span>&raquo; <?=$ModuleName?></span>
<input type="button" class="print_button"  name="exp" style="float:right" value="Print" onclick="Javascript:window.print();"/>
	<a href="<?=$DownloadUrl?>" target="_blank" class="download" style="float:right;margin-left:5px;">Download</a>
	<?php /*<a href="<?=$DownloadUrl?>&Wstatus=Packed" target="_blank" class="download" style="float:right;margin-left:5px;">Packing Slip</a>*/?>
	<ul class="editpdf_menu">
	<li>
	<a href="<?=$DownloadUrl?>&Wstatus=Packed" target="_blank" class="download" style="float:right;margin-left:5px;">Packing Slip</a>
                <ul>
		<?php 

		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&Wstatus=Packed">Default</a></li>';
		if(sizeof($GetPFdTempalteNameArray)>0) { 
		foreach($GetPFdTempalteNameArray as $tempnmval){
		 
		echo '<li><a class="editpdf download" href="'.$DownloadUrl.'&tempid='.$tempnmval['id'].'&Wstatus=Packed">'.$tempnmval['TemplateName'].'</a></li>';
		}
		}
		?>

		</ul>
        </li>
        </ul>
	<ul class="editpdf_menu">
            <li><a class="edit" href="javascript:void(0)">Edit Packing Slip</a>
                <ul>
                    <?php
                    echo '<li><a class="add" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&ModuleDepName=' . $ModuleDepName . '&ship='.$_GET['ship'].'&batch='.$_GET['batch'].'&Wstatus=Packed">Add PDF Template</a></li>';
                    if (sizeof($GetPFdTempalteNameArray) > 0) {
                        foreach ($GetPFdTempalteNameArray as $tempnmval) {
                         echo '<li>';
		 if($tempnmval['AdminID']==$_SESSION['AdminID']){
                            echo '<a class="delete" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&Deltempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '&ship='.$_GET['ship'].'&batch='.$_GET['batch'].'"></a>';
                             }

                            echo '<a class="edit editpdf" href="../editcustompdf.php?module=' . $module . '&curP=' . $_GET['curP'] . '&view=' . $_GET["view"] . '&tempid=' . $tempnmval['id'] . '&ModuleDepName=' . $ModuleDepName . '&ship='.$_GET['ship'].'&batch='.$_GET['batch'].'&Wstatus=Packed">' . $tempnmval['TemplateName'] . '</a></li>';
                        }
                    }
                    ?>

                </ul>
            </li>                               
    </ul>
</div>
<? } ?>
<? if (!empty($errMsg)) {?>
    <div align="center"  class="red"><?=$errMsg?></div>
 <? } 
  

if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{


?>
<div class="message" align="center"><? if(!empty($_SESSION['mess_shiment_delete'])) {echo $_SESSION['mess_shiment_delete']; unset($_SESSION['mess_shiment_delete']); }?></div>

<form name="form1" action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	 <td align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">	 
 <tr>
	 <td colspan="4" align="left" class="head">Shipment Information</td>
</tr>
 <tr>
	<td  align="right"   class="blackbold" width="20%"> Shipment No# : </td>
	<td align="left" width="30%"> <?=$arrySale[0]['ShippedID'];?></td>
 
		<td  align="right"   class="blackbold" width="20%">Shipment Date  :</td>
		<td   align="left" >
			<?php 
			$arryTime = explode(" ",$Config['TodayDate']);
			$ShipmentDate = ($arryShip[0]['ShipmentDate']>0)?($arryShip[0]['ShipmentDate']):($arryTime[0]); 
			#echo $ShipmentDate;
			?>

 <? if($ShipmentDate>0) 
		   echo date($Config['DateFormat'], strtotime($ShipmentDate));
		?>



		</td>
	</tr>
 <? if($arrySale[0]['CreatedDate']>0){ ?>
		<tr>
		<td  align="right"   class="blackbold" > Created Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['CreatedDate'])); ?>
		</td>
		<td  align="right"   class="blackbold" >  Updated Date  : </td>
		<td   align="left"  >
			<? echo date($Config['DateFormat']." ".$Config['TimeFormat'], strtotime($arrySale[0]['UpdatedDate'])); ?>
		</td>
		</tr>
	<? } ?>
	<tr>
		<td  align="right"   class="blackbold" valign="top"> Status  : </td>
		<td   align="left" valign="top">
		<?php
		  echo $arryShip[0]['ShipmentStatus']; 
		  
		?>
		</td>
	
		<td  align="right" class="blackbold" valign="top"> Comments  : </td>
		<td align="left" valign="top">
		<?php echo stripslashes($arryShip[0]['ShipComment']); ?>
		</td>
	</tr>
<tr>
        <td align="right" class="blackbold">Invoice:</td>
        <td   align="left"  >

<? if($arryShip[0]['RefID']!='' && $arryShip[0]['ShipmentStatus'] == 'Shipped'){?>
  


<a class="fancybox po fancybox.iframe" href="../finance/vInvoice.php?pop=1&inv=<?=$arryShip[0]['RefID']?>" ><?=$arryShip[0]['RefID']?></a>

 <?} else{?>


 <?   }?>

           </td>
      </tr>
<tr>

<td  align="right" class="blackbold" valign="top"> Ship From   : </td>
		<td align="left" valign="top">
		<?php echo stripslashes($arryShip[0]['WarehouseCode']); ?>
		</td>


<td  align="right" class="blackbold" valign="top"> Ship From(Warehouse)  : </td>
		<td align="left" valign="top">
		<?php echo stripslashes($arryShip[0]['WarehouseName']); ?>
		</td>
	</tr>
 
<tr>

<td  align="right" class="blackbold" valign="top"> Sales Order#  : </td>
		<td align="left" valign="top">
<?
echo "<a href='../sales/vSalesQuoteOrder.php?module=Order&&pop=1&so=".$SaleID."' class='fancybox fancybox.iframe'>".$SaleID."</a>";
?> 
		</td>

 
	</tr>


</table>

	 </td>
</tr>


<tr>
	<td align="left">
	<? include("../includes/html/box/shipping_info.php");?>
	</td>
</tr>
	
<tr>
	 <td align="left"><? 
 $SpiffSaleID = $SaleID;
$SpiffPrefix = '../sales/';
include("../sales/includes/html/box/sales_order_view.php");?></td>
</tr>
<tr>
    <td>

	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="left" valign="top" width="50%" class="borderpo"><? include("includes/html/box/sale_order_billto_view.php");?></td>
			<td width="1%"></td>
			<td align="left" valign="top" class="borderpo"><? include("includes/html/box/sale_order_shipto_view.php");?></td>
		</tr>
	</table>

</td>
</tr>


<tr>
	 <td align="right">
<?php
$Currency = (!empty($arrySale[0]['CustomerCurrency']))?($arrySale[0]['CustomerCurrency']):($Config['Currency']); 

echo $CurrencyInfo = str_replace("[Currency]",$Currency,CURRENCY_INFO);
?>	 
	 </td>
</tr>


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td  align="left" class="head" ><?=RETURN_ITEM?>
	 <div style="float:right"><a class="fancybox fancybox.iframe" href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$SaleID?>" ><?=VIEW_ORDER_DETAIL?></a></div>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybox").fancybox({
			'width'         : 900
		 });

});

</script>



	 </td>
</tr>

<tr>
	<td align="left" >
		<?php include("includes/html/box/so_item_shipment_view.php");?>
	</td>
</tr>

</table>	
    
	
	</td>
   </tr>

  

	<tr>
	<td  align="center">

		<? if($HideSubmit!=1){ ?>	
		<input name="Submit" type="submit" class="button" id="SubmitButton" value="Process"  />
		<? } ?>
		<?php if(empty($_GET['rtn'])){?>
		<input type="hidden" name="ShipmentOrderID" id="ShipmentOrderID" value="<?=$_GET['edit']?>" readonly />
		<?php }?>
		<input type="hidden" name="OrderID" id="OrderID" value="<?=$_GET['edit']?>" readonly />
		

	</td>
	</tr>
  
</table>

 </form>

<? } ?>



