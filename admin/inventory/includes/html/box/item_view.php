	
<? if($_SESSION['SelectOneItem'] == 1){ 

$dis = 'style="display:none"';
}else{

$dis ='';
}
	
?>

<div class="e_right_box">

	

	<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
	<form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
	<input type="hidden" name="CategoryID" id="CategoryID" value="<? echo $CategoryID; ?>" /> 
	<? if (!empty($_SESSION['mess_product'])) {?>
	<tr>
	<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_product'])) {echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); }?>	
	</td>
	</tr>
	<? } ?>
	<tr>
	<td   align="center" valign="top" >
	<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="borderall">

	<? if ($_GET["tab"] == "basic") { ?>
	<tr>
	<td  colspan="2" align="left" class="head">Basic Information </td>
	</tr>
 
	<tr <?=$dis?>>
	<td  width="45%" align="right"   class="blackbold" > Inventory Item : </td>
	<td   align="left">
	<? echo stripslashes(ucfirst($arryItem[0]['non_inventory']));?> </td>
	</tr>
	<tr>
	<td  width="45%" align="right"   class="blackbold" >SKU : </td>
	<td   align="left">
	<? echo stripslashes($arryItem[0]['Sku']); ?> </td>
	</tr>
<tr>
	<td  align="right"   class="blackbold" >Item Description : </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['description']))?(stripslashes($arryItem[0]['description'])):(NOT_SPECIFIED)?>

	</tr>
	<tr >
	<td  align="right"   class="blackbold" >Item Category :</td>
	<td   align="left">

	<?php 

	//foreach($listAllCategory as $key=>$value){

	//$arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
	$CatName =$objCategory->category_tree($arryItem[0]['CategoryID']);
	//echo rtrim($CatName,'>>');

	?>
	<?php //if($_GET['CatID']==$value['CategoryID']){ echo $value['Name'];}?>
	<?php 

	//foreach ($arrySubCategory as $key => $value) {
	//$arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']);
	?>
	<?php //if($_GET['CatID']==$value['CategoryID']){echo $value['Name'];}?>

	<?php
	//foreach ($arrySubCategory as $key => $value) { 
	//$arrySubCategory = $objCategory->GetSubCategoryByParent('',$value['CategoryID']); 
	?>
	<?php //if($_GET['CatID']==$value['CategoryID']){echo $value['Name'];}?>
	<?php
	//foreach ($arrySubCategory as $key => $value) { ?>
	<?php //if($_GET['CatID']==$value['CategoryID']){ echo $value['Name'];}?>
	<?php 
	//}
	//}

	//}
	//} 
	?>


	</td>
	</tr>
<? if($arryItem[0]['non_inventory']=='yes'){?>
 <?php if($arrySection['Model']==1)
    	{ ?>
	<tr <?=$dis?>>
	<td  align="right" valign="top"   class="blackbold" >Model:  </td>
	<td   align="left">


<?  if(!empty($arryItem[0]['Model'])){
$gen='';
   foreach ($arryModel as $key=>$model){

	$ArrGetGen = $objItem->GetGenrationBasedOnModel($model['id']);
	$arrGen1 =  $objItem->GetModGen($arryItem[0]['ItemID'],$model['id']);
	$arrGen2 = explode(",",$ArrGetGen[0]['Generation']);
		$class = explode(",",$Mod);
if(in_array($model['id'], $class)){
	
	
	//$gen =implode(",",$gen_array);
if(!empty($arrGen1[0]['genration'])){
?>
	<span  onmouseout="Javascript:hideddrivetip()"  onmouseover="Javascript:ddrivetip('<center><?=$gen?></center>', 200,'')"><?=$model['Model']?>    <?=$arrGen1[0]['genration']?></span><br>
	
<?} else{?>
<span  ><?=$model['Model']?></span><br>

<?}
}

}


#echo $ItemModel;
}else{
echo NOT_SPECIFIED;
}
?>




	

	</td>

	</tr>
<?} ?>
 <?php if($arrySection['Model']==1)
    	{ ?>
	<!--tr>
	<td  align="right"   class="blackbold" >Generation

	:   </td>
	<td   align="left">
	
	<?=(!empty($arryItem[0]['Generation']))?(stripslashes($arryItem[0]['Generation'])):(NOT_SPECIFIED)?>

	</td>
	</tr-->
<?} ?>
	<tr <?=$dis?>>
	<td  align="right"   class="blackbold" >Condition: </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['Condition']))?(stripslashes($arryItem[0]['Condition'])):(NOT_SPECIFIED)?>

	</td>
	</tr>
	<tr <?=$dis?>>
	<td  align="right"   class="blackbold" >Extended

	:  </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['Extended']))?(stripslashes($arryItem[0]['Extended'])):(NOT_SPECIFIED)?>

	</td>
	</tr>
	</tr>
	<tr <?=$dis?>>
	<td  align="right"   class="blackbold" >Manufacture:  </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['Manufacture']))?(stripslashes($arryItem[0]['Manufacture'])):(NOT_SPECIFIED)?>
	</td>
	</tr>
	
	<tr style="display:none;">
	<td  align="right"   class="blackbold" >Procurement Method :   </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['procurement_method']))?(stripslashes($arryItem[0]['procurement_method'])):(NOT_SPECIFIED)?>


	</td>
	</tr>
	<?php if($arryMainmenuSection['Manage BOM']==1)
    	{ ?>
	<!--tr>
	<td  align="right"   class="blackbold" >Valuation Method :   </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['evaluationType']))?(stripslashes($arryItem[0]['evaluationType'])):(NOT_SPECIFIED)?>

	</td>
	</tr-->
	<?php }?>
		<?php if($arryMainmenuSection['Manage BOM']==1)
    	{ ?>
	<tr>
	<td  align="right"   class="blackbold" >Item Type :   </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['itemType']))?(stripslashes($arryItem[0]['itemType'])):(NOT_SPECIFIED)?>

	</td>
	</tr>
	<?php }?>
	<tr <?=$dis?>>
	<td  align="right"   class="blackbold" >Unit Measure: </td>
	<td   align="left">
	<?=(!empty($arryItem[0]['UnitMeasure']))?(stripslashes($arryItem[0]['UnitMeasure'])):(NOT_SPECIFIED)?>


	</td>
	</tr>

<tr <?=$dis?>>
		<td  align="right"   class="blackbold">Reorder Level : </td>
		<td  align="left">
			
<?=(!empty($arryItem[0]['ReorderLevel']))?(stripslashes($arryItem[0]['ReorderLevel'])):(NOT_SPECIFIED)?></td>
		</tr>
<? if($arryItem[0]['ReorderLevel']!=''){?>

	<tr  style="display:none;">
	<td  align="right"   class="blackbold">Min Stock Alert Level : </td>
	<td  align="left">
	<?=(!empty($arryItem[0]['min_stock_alert_level']))?(stripslashes($arryItem[0]['min_stock_alert_level'])):(NOT_SPECIFIED)?>
	</td>
	</tr>

	<tr  style="display:none;">
	<td  align="right"   class="blackbold">Max Stock Alert Level : </td>
	<td  align="left">
	<?=(!empty($arryItem[0]['max_stock_alert_level']))?(stripslashes($arryItem[0]['max_stock_alert_level'])):(NOT_SPECIFIED)?>
	</td>
	</tr>
<? }?>

	<tr style="display:none;">
	<td   align="right"  class="blackbold" >Insurance Policy :</td>
	<td   ><input name="insurance_policy" type="text" class="inputbox" id="insurance_policy" value="<? if(!empty($arryItem[0]['insurance_policy'])) echo $arryItem[0]['insurance_policy']; ?>"  size="10" maxlength="10"></td>
	</tr>
<!--tr>
                       <td  align="right"   class="blackbold" > Taxable : </td>
                       <td   align="left" >
       <?=($arryItem[0]['Taxable']=='Yes')?("Yes"):("No")?>

               </td>
       </tr-->
	<tr>
	<td  align="right"   class="blackbold" >Purchase Tax Rate :  </td>
	<td   align="left">
<?=($arryItem[0]['purchase_tax_rate']=='Yes')?("Yes"):("No")?>
	

	</td>
	</tr>
<? }?>
	<tr>
	<td  align="right"   class="blackbold" >Sale Tax Rate :  </td>
	<td   align="left">
<?=($arryItem[0]['sale_tax_rate']=='Yes')?("Yes"):("No")?>
	
	</td>
	</tr>
<tr>
	<td align="right"   class="blackbold">Status :  </td>
	<td  align="left"><span class="blacknormal">
	<?
	if ($arryItem[0]['Status'] == 1) {
	$ActiveChecked = ' Active';
	}
	else {
	$ActiveChecked="Inactive";
	}
	?>
	<?= $ActiveChecked ?>
	</td>
	</tr>

	<tr><td class="head" align="left" colspan="2"> Image  </td></tr>

	
	<tr>
	<td   align="right" valign="top" class="blackbold"> Item Image : </td>
	<td   align="left">

	 <? 
 
 
	$PreviewArray['Folder'] = $Config['Items'];
	$PreviewArray['FileName'] = $arryItem[0]['Image']; 
	//$PreviewArray['NoImage'] = $Prefix."images/no.jpg";
	$PreviewArray['FileTitle'] = stripslashes($arryItem[0]['Sku']);
	$PreviewArray['Width'] = "120";
	$PreviewArray['Height'] = "120";
	$PreviewArray['Link'] = "1";
	echo '<div id="ImageDiv">'.PreviewImage($PreviewArray).'</div>';
 

?>
	</td>
	</tr>
	
	<?php } ?>
	<?php if ($_GET['tab'] == "alterimages") { ?>
	<tr>
	<td colspan="2" align="left" class="head">Alternative Images <!--<a class="fancybox" href="#addimage_div" style="float: right;"> Add Alternative Images </a>--></td>
	</tr>
	<?php if(count($MaxProductImageArr) >0){?>
	<tr>
	<td colspan="2" class="list-Image">
	<ul>
	<?php
	$irts = 1;
	  
	foreach($MaxProductImageArr as $image){
	$ImageName = $image['Image'];
	$ImageId = $image['Iid'];
	$alt_text = $image['alt_text'];
	 if(IsFileExist($Config['ItemsSecondary'],$ImageName)){ 
	 	
		$PreviewArray['Folder'] = $Config['ItemsSecondary'];
		$PreviewArray['FileName'] = $ImageName; 
		$PreviewArray['NoImage'] = $Prefix."images/no.jpg";
		$PreviewArray['FileTitle'] = stripslashes($alt_text);
		$PreviewArray['Width'] = "100";
		$PreviewArray['Height'] = "100";
		$PreviewArray['Link'] = "1";
		$showImage = PreviewImage($PreviewArray);
	}
	?>
	<li <?php if($irts%5 == "0"){?> class="last"<?php }?>><?=$showImage;?></li>
	<?$irts = $irts+1;}?>  
	</ul>
	</td>
	</tr>
	<?php }else{?>
	<tr valign="middle" bgcolor="#ffffff" align="left">
	<td class="no_record" colspan="5">No Images Found.</td>

	</tr>
	<?php }?>






	<?php } ?>
<? if($_GET['tab'] == 'Alias'){  ?>

<tr><td colspan="2">

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	
	<tr>
	  <td  >

<table WIDTH="100%"   BORDER=0 <?=$table_bg?>>
   
	<tr align="left"  >
	
		<td   class="head1" >Alias Name</td>
		
		<td  class="head1" > Description</td>
		<td width="20%"  align="center" class="head1 head1_action" >Required Items</td>
	</tr>
   
<?php 
if(is_array($arryAlias) && $AliasNum >0 ){
	$flag=true;
	$Line=0;
		foreach($arryAlias as $key=>$values){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;

?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    
      <td ><?=$values["ItemAliasCode"]?></td>
      <!--td > 
	  <? echo stripslashes($values['AliasType']);?>		       </td-->
        <!--td> <? echo $values['VendorCode'];?></td-->
     
	  <td><?=stripslashes($values['description'])?></td>
       
   
      <td  align="center"  >
	  
	&nbsp;&nbsp;<a class="fancybox fancybox.iframe" href="editaliasItem.php?view=<?=$values['AliasID']?>&item_id=<?=$_GET['view']?>&CatID=<?=$_GET["CatID"]?>&tab=<?=$_GET['tab']?>&amp;curP=<?php echo $_GET['curP'];?>"   > <?=$view?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $AliasNum;?>      <?php if(count($arryTicket)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </td>
  </tr>
</TABLE>
</td>
  </tr>
<? }?>


<? if($_REQUEST['tab'] == "Required"){ ?>
<tr>
	<td colspan="2" align="left" class="head">Required Items </td>
</tr>	
<tr>
	<td colspan="2" align="left">
<? 
$ItemID = $_GET['view'];
include("includes/html/box/required_items.php");
?>
</td>
</tr>	
<? } ?>

<? if($_GET['tab'] == 'binlocation'){  ?>
 
<tr>
	 <td colspan="2" align="left"  class="head" >Warehouse/Bin Location</td>
     
</tr>


	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
	<tbody>
	<tr>
	<td class="head1">Warehouse</td>
	<td class="head1">Bin Location</td>
<td class="head1">Condition</td>
	<td class="head1">Quantity</td>
	
	

	</tr>
	<?php if (count($arryWbin) > 0) {
$i=0;
	foreach ($arryWbin as $ItemBin) {
$i++;
$warehouseQtyCond=$objItem->GetConWarehouseQty($arryItem[0]['Sku'],$ItemBin['WID'],$ItemBin['condition']);
	?>
	<tr class="evenbg" bgcolor="#ffffff" align="left">
	<td ><?=$ItemBin['warehouse_name']?></td>
	<td ><?=$ItemBin['binlocation_name']?></td>
<td ><?=$ItemBin['condition']?></td>
<td ><?=$warehouseQtyCond?></td>
	
	

	</tr>
	<?php  }
	} else {
	?>
	<tr valign="middle" bgcolor="#ffffff" align="left">
	<td class="no_record" colspan="6">No Records Found.</td>

	</tr>
	<?php } ?>
	</tbody>
	</table>
	</td>
	</tr>
<? /*********************************/?>
<? }?>
	<? if ($_GET["tab"] == "Quantity") { 

$availableQty = $RecievedQty+$on_sale_order;
?>

	<tr>
	<td colspan="2" align="left" class="head">Item Quantity </td>
	</tr>
<tr>
	<td align="right"  class="blackbold">Condition :</td>
	<td align="left"  class="blacknormal">
<select name="Condition" id="Condition" class="textbox"  <?php if($_GET['view']>0){ ?>onchange="getConditionQty(this.value)" <?php }?> style="width:110px;"><option value="" <?=$selectCond?>>Select</option><?=$ConditionSelectedDrop?></select>
</td>
	</tr>
	<tr>
	<td align="right" width="45%"  class="blackbold">On Hand  :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_on_hand" id="qty_on_hand" readonly value="<? echo $RecievedQty; ?>" type="text" onkeypress="return isNumberKey(event);"  class="disabled"  size="13" maxlength="10" /> </td>
	</tr>

	<tr>
	<td align="right"  class="blackbold">On Purchase Order  :</td>
	<td align="left"  class="blacknormal">
	<input  name="on_purchase_qty" id="on_purchase_qty" readonly value="<? echo $OrderQty; ?>" onkeypress="return isNumberKey(event);" type="text"  class="disabled"  size="13" maxlength="10" /> </td>

	</tr>

	<tr>
	<td align="right"  class="blackbold">On Sales Order  :</td>
	<td align="left"  class="blacknormal">
	<input  name="on_sales_qty" id="on_sales_qty" readonly value="<? echo $on_sale_order; ?>" onkeypress="return isNumberKey(event);" type="text"  class="disabled"  size="13" maxlength="10" /> </td>
	</tr>

	<tr style="display:none;">
	<td align="right"  class="blackbold">Allocated :</td>
	<td align="left"  class="blacknormal">
	<input  name="allocated_qty" id="allocated_qty" value="<? echo $AllocatedQty; ?>" onkeypress="return isNumberKey(event);" readonly type="text" class="disabled"  size="13" maxlength="10" /> </td>

	</tr>
	<tr style="display:none;">
	<td align="right"  class="blackbold">On Demand :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_on_demand" id="qty_on_demand" value="<? echo $arryItem[0]['qty_on_demand']; ?>" onkeypress="return isNumberKey(event);" type="text"  class="textbox"  size="13" maxlength="10" /> </td>

	</tr>
	<tr style="display:none;">
	<td align="right"  class="blackbold">Max level :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_max_level" id="qty_max_level" value="<? if(!empty($arryItem[0]['qty_max_level'])) echo $arryItem[0]['qty_max_level']; ?>" onkeypress="return isNumberKey(event);" type="text"  class="textbox"  size="10" maxlength="10" /> </td>

	</tr>
	<tr>
	<td align="right"  class="blackbold">Available :</td>
	<td align="left"  class="blacknormal">
	<input  name="qty_available" id="qty_available" value="<? echo $availableQty-$on_sale_order; ?>" onkeypress="return isNumberKey(event);" type="text" readonly  class="disabled"  size="13" maxlength="10" /> </td>

	</tr>


	<?php } ?>
	<? if ($_GET["tab"] == "Price") { ?>
	<tr>
	<td colspan="2"    class="blackbold">Item Sku : 
	<?=$arryItem[0]['Sku']?></td>

	</tr>
	<td colspan="2"    class="blackbold">Item Description : 
	<?=stripslashes($arryItem[0]['description'])?></td>

	</tr>

	<tr>
	<td colspan="2" align="left" class="head">Vendor Price List  </td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">


	<tr align="left">
	
	<td width="15%"  class="head1"> Vendor</td>
	<td width="15%"  class="head1">Date</td>
	<td width="15%"  class="head1"> Qty Received</td>
	<td width="15%"  class="head1"> Unit Price</td>
	 


	<td width="15%"  class="head1"> Net Price [<?=$Config['Currency']?>]</td>



	</tr>

	<?php
		if (is_array($arryItemOrder) && $num > 0) {
	$flag = true;
	$Line = 0;
	foreach ($arryItemOrder as $key => $values) {
	$flag = !$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	$ItemCost = round($values['ItemCost'],2);
	?>
	<tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
	

	<td> <a class="fancybox supp fancybox.iframe" href="../purchasing/suppInfo.php?view=<?=$values['SuppCode']?>"><?=stripslashes($values["SuppCompany"])?></a></td>
	<td><?= date($Config['DateFormat'] , strtotime($values['PostedDate'])); ?></td>
	<td><?=$values['qty_received']?></td>
	<td><?=number_format($ItemCost,2)?> <?=$values['Currency']; ?></td>

	 


	<td> <?php 
	
	if($values['Currency']!=$Config['Currency']){
		$ConversionRate=$values['ConversionRate']; //from db
		if(empty($ConversionRate)){
			$ConversionRate = 1;		
		}
		/*if(empty($arryCurrencyVal[$values['Currency']])){
			$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
			$arryCurrencyVal[$values['Currency']]=$ConversionRate;			
		}else{
			$ConversionRate=$arryCurrencyVal[$values['Currency']];
		}*/
	}else{
		$ConversionRate = 1;
	}

	 

	$NetPrice = round(GetConvertedAmount($ConversionRate, $ItemCost),2);

	echo number_format($NetPrice,2);?></td>

	</tr>
	<?php
		$avgTotCost += $NetPrice;
		$totalQty +=$values['qty_received'];		 

		} // foreach end 
		$avrageCost = $avgTotCost/$num ; 

//echo $avgTotCost.'/'.$num ;
	?>



	<?php } else { ?>
	<tr >
	<td  colspan="6" class="no_record">No Records found.</td>
	</tr>

	<?php } ?>



	<tr >  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryItemOrder) > 0) { ?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}
	?></td>
	</tr>






	</table>
	</div>


	<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">



	</td>
	</tr>

<tr>
	<td colspan="2" align="left" class="head">Adjustment Price List  </td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
	<tr align="left">
	<td width="15%"  class="head1"> Adjustment</td>
	<td width="15%"  class="head1">Date</td>
	<td width="15%"  class="head1"> Qty Received</td>
	<td width="15%"  class="head1"> Unit Price</td>
	 
	<td width="15%"  class="head1"> Net Price [<?=$Config['Currency']?>]</td>

	</tr>

	<?php
	if(!empty($arryIAdjOrder)) {
	$flag = true;
	$Line = 0;
	foreach ($arryIAdjOrder as $key => $values2) {
	$flag = !$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;

	 $ItemCost2 = round($values2['ItemCost'],2);
	?>
	<tr align="left" valign="middle" bgcolor="<?= $bgcolor ?>">
	

	<td> <a  ><?=stripslashes($values2["OrderID"])?></a></td>
	<td><? if($values2['PostedDate']>0){ echo date($Config['DateFormat'] , strtotime($values2['PostedDate']));} ?></td>
	<td><?=$values2['qty_received']?></td>
	<td><?=number_format($ItemCost2,2)?> <?=$values2['Currency']; ?></td>

	<td> <?php 
	
	if($values2['Currency']!=$Config['Currency']){
		$ConversionRate2=$values2['ConversionRate']; //from db
		if(empty($ConversionRate2)){
			$ConversionRate2 = 1;		
		}
		/*if(empty($arryCurrencyVal[$values['Currency']])){
			$ConversionRate=CurrencyConvertor(1,$values['Currency'],$Config['Currency']);
			$arryCurrencyVal[$values['Currency']]=$ConversionRate;			
		}else{
			$ConversionRate=$arryCurrencyVal[$values['Currency']];
		}*/
	}else{
		$ConversionRate2 = 1;
	}

	$NetPrice2 =  $ItemCost2;
	 
	//$NetPrice2 = round(GetConvertedAmount($ConversionRate2, $ItemCost2),2);

	echo number_format($NetPrice2,2);?></td>

	</tr>
	<?php
		$avgTotCost2 += $NetPrice2;
		$totalQty2 +=$values2['qty_received'];		 

		} // foreach end 
		//$avrageCost2 = $avgTotCost2/$num2 ;
		//echo $avgCost = $avgTotCost+$avgTotCost2;
		// echo $totalNum = $num+$num2;
		$avrageCost = ($avgTotCost+$avgTotCost2)/($num+$num2);

		//echo $avgTotCost.'/'.$num ;
	?>



	<?php } else { ?>
	<tr >
	<td  colspan="6" class="no_record">No Records found.</td>
	</tr>

	<?php } ?>



	<tr >  <td  colspan="5" >Total Record(s) : &nbsp;<?php echo $num2; ?>      <?php if (count($arryItemOrder) > 0) { ?>
	&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
	}
	?></td>
	</tr>
</table>
</td>
	</tr>

	<tr>
	<td colspan="2" align="left" class="head">Item Price </td>
	</tr>

<?php if($_SESSION['SelectOneItem'] == 0){ ?>
<tr>
	<td align="right"  class="blackbold">Condition :</td>
	<td align="left"  class="blacknormal">
<select name="Condition" id="Condition" class="textbox"  <?php if($_GET['view']>0){ ?>onchange="getConditionCost(this.value)" <?php }?> style="width:110px;"><option value="" <?=$selectCond?>>Select</option><?=$ConditionSelectedDrop?></select>
</td>
	</tr>
<? }?>
	<tr>
	<td align="right"  class="blackbold">Average Cost :</td>
	<td align="left"  class="blacknormal">
	<? echo $avgCost;  ?> <?=$Config['Currency']?></td>
	</tr>

	<tr>
	<td align="right"  class="blackbold">Last Cost :</td>
	<td align="left"  class="blacknormal">
	<? echo $lastPrice; ?> <?=$Config['Currency']?></td>

	</tr>

	
	<!--tr>
	<td align="right"  class="blackbold">Cost of good  :</td>
	<td align="left"  class="blacknormal">
	<input  name="purchase_cost" id="purchase_cost" onkeypress="return isDecimalKey(event);" class="disabled" value="<? echo round($avgCost,2);?>" type="text"    size="10" maxlength="10" /> <?=$Config['Currency']?> </td>
	</tr-->


	<tr>
	<td align="right"  class="blackbold">Sell Price :</td>
	<td align="left"  class="blacknormal">
	<? echo $arryItem[0]['sell_price']; ?> <?=$Config['Currency']?></td>
	</tr>

<? if(!empty($arryConPrice[0]['pricetype'])){ ?>
	<!--updated by chetan 23Feb2017--->
	<tr>
	<td align="right"  class="blackbold">Price Type :</td>
	<td align="left"  class="blacknormal"><?php echo ucfirst($arryConPrice[0]['pricetype'])?></td>
	</tr>
	<? if($arryConPrice[0]['pricetype']=='percentage' || $arryConPrice[0]['pricetype']=='fixed')
	   {  
	 	if($arryConPrice[0]['pricetype']=='percentage')	{
	?>	
	<tr>
	<td align="right"  class="blackbold">Percentage :</td>
	<td align="left"  class="blacknormal"><?php echo $arryConPrice[0]['prpercent'].'%'?></td>
	</tr>
		<? }?>
	<tr>
	<td align="right"  class="blackbold">Price :</td>
	<td align="left"  class="blacknormal"><?php echo $arryConPrice[0]['fprice']?> <?=$Config['Currency']?></td>
	</tr>
	
	
	<? } 	if($arryConPrice[0]['pricetype']=='range') { ?>	
	<tr>
	<td align="right"  class="blackbold"></td>
	<td align="left"  class="blacknormal">
	<table width="40%" cellspacing="1" cellpadding="3" align="left" id="list_table">
	<tr align="left">
		<td width="5%"  class="head1"> Qtyfrom</td>
		<td width="5%"  class="head1">Qtyto</td>
		<td width="5%"  class="head1"> Percentage</td>
		<td width="25%"  class="head1"> Price</td>
	</tr>
		<? 
		$qtyfrom 	= explode(',',$arryConPrice[0]['qtyfrom']);
		$qtyto	 	= explode(',',$arryConPrice[0]['qtyto']);	
		$fprice 	= explode(',',$arryConPrice[0]['fprice']);
		$prpercent	= explode(',',$arryConPrice[0]['prpercent']);	
		$count 		= count($qtyfrom);
		
		for($i=0;$i<$count;$i++){
		?>
	<tr align="left">	
		<td width="5%" > <?php echo $qtyfrom[$i]?></td>
		<td width="5%" > <?php echo $qtyto[$i]?></td>
		<td width="5%" > <?php echo $prpercent[$i]?></td>
		<td width="25%" > <?php echo $fprice[$i]?> <?=$Config['Currency']?></td>
	</tr>
	<?   }  }

	}
 ?>
	</table>
	</td>
	</tr>
<!--End-->


	</tr>

	



	<?php } ?>
	<? if ($_GET["tab"] == "Supplier") { 


		if(empty($arrySupplier[0]['SuppCode'])){
			$arrySupplier = $objConfigure->GetDefaultArrayValue('p_supplier');
		}
?>

	<tr> 
	<td colspan="2" align="left" class="head">Vendor Information</td>
	</tr>

	<tr>
	<td align="right" width="45%" class="blackbold" > Vendor Code : </td>
	<td align="left" >
	<?php echo stripslashes($arrySupplier[0]['SuppCode']); ?>

	</td>
	</tr>


	<tr>
	<td align="right" class="blackbold" > Company Name : </td>
	<td align="left" >
	<?php echo stripslashes($arrySupplier[0]['CompanyName']); ?> </td>
	</tr>
	<tr style="display: none;">
	<td align="right" class="blackbold" > Contact Name : </td>
	<td align="left" >
	<?php if(!empty($arrySupplier[0]['SuppContact'])) echo stripslashes($arrySupplier[0]['SuppContact']); ?> </td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > City  : </td>
	<td   align="left" >
	<?php echo stripslashes($arrySupplier[0]['City']); ?>
	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > State  : </td>
	<td   align="left" >
	<?php echo stripslashes($arrySupplier[0]['State']); ?>
	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > Country  : </td>
	<td   align="left" >
	<?php echo stripslashes($arrySupplier[0]['Country']); ?>
	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" > Zip Code  : </td>
	<td   align="left" >
	<?php echo stripslashes($arrySupplier[0]['ZipCode']); ?>
	</td>
	</tr>





	<?php } ?>

	<? if ($_GET["tab"] == "Dimensions") { ?>

	<tr>
            
	<td colspan="2" align="left" class="head">Dimensions </td>
	</tr>
	<tr style=display:none;>
	<td align="right" width="45%"  class="blackbold">Pack Size :</td>
	<td align="left"  class="blacknormal"><? echo stripslashes($arryItem[0]['pack_size']); ?> </td>
	</tr> 

	<tr>
	<td align="right"  class="blackbold">Weight:</td>
	<td align="left"  class="blacknormal"><? 
            $Wunit=$arryItem[0]['wt_Unit'];
            echo $arryItem[0]['weight']." ".$Wunit; ?></td>

	</tr> 

	<tr>
	<td align="right"  class="blackbold">Length:</td>
	<td align="left"  class="blacknormal"><? 
            $lnunit=$arryItem[0]['ln_Unit'];
            echo stripslashes($arryItem[0]['width'])." ".$lnunit; ?> </td>
	</tr> 

	<tr>
	<td align="right"  class="blackbold">Width:</td>
	<td align="left"  class="blacknormal"><? 
            $wdnit=$arryItem[0]['wd_Unit'];
            echo stripslashes($arryItem[0]['height'])." ".$wdnit; ?> </td>

	</tr> 

	<tr>
	<td align="right"  class="blackbold">Height:</td>
	<td align="left"  class="blacknormal"><? 
            $htunit=$arryItem[0]['ht_Unit'];
            echo stripslashes($arryItem[0]['depth'])." ".$htunit; ?> </td>

	</tr> 



	<?php } ?>



	<? if ($_GET["tab"] == "Cost") { ?>

	<tr>
	<td colspan="2" align="left" class="head">Manage Cost </td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" align="center" id="list_table">
	<tbody>
	<tr>
	<td class="head1">Transaction ID</td>
	<td class="head1">Transaction Date</td>
	<td class="head1">Item Code</td>
	<td class="head1">Item Description</td>
	<td class="head1">Transaction Type</td>
	<td class="head1">Trans Qty</td>

	<td class="head1">Stock On Hand</td>
	<td class="head1">Trans Unit cost</td>
	<td class="head1">Pre Avg Cost</td>
	<td class="head1">Post Avg Cost</td>

	</tr>
	<?php  if(count($DiscountArr) > 0) {
	foreach($DiscountArr as $discount) {   ?>
	<tr valign="middle" bgcolor="#ffffff" align="left">
	<td><?=$discount['range_min'];?></td>
	<td><?=$discount['range_max'];?></td>
	<td><?=$discount['range_max'];?></td>
	<td><?=$discount['range_max'];?></td>
	<td><?=$discount['range_max'];?></td>
	<td><?=$discount['range_max'];?></td>
	<td><?=number_format($discount['discount'],2);?></td>
	<td><?=$discount['discount_type'];?></td>
	<td><?=$discount['is_active'];?></td>
	<td><a href="editProduct.php?edit=<? echo $_GET['edit']; ?>&curP=<?php echo $_GET['curP']; ?>&CatID=<?= $_GET['CatID'] ?>&disID=<?=$discount['qd_id'];?>&tab=editDiscount"><?= $edit ?></a>  <a href="javascript:void();" class="deleteProductDiscount" alt="<?=$_GET['edit']."#".$discount['qd_id']?>"><?= $delete ?></a>	</td></td>
	</tr>
	<?php   
	}
	} else { 
	?>
	<tr valign="middle" bgcolor="#ffffff" align="left">
	<td class="no_record" colspan="10">No Transaction Found.</td>

	</tr>
	<?php   }   ?>
	</tbody>
	</table> 
	</td>
	</tr>



	<?php } ?>


	<?php if ($_GET["tab"] == "Transaction") {  

          $ItemSku = $arryItem[0]['Sku'];
	  include("includes/html/box/item_transaction.php");

	 } ?>


	</table>
	</td>
	</tr>

<input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['view']; ?>" />

	<input  name="item_Sku" id="item_Sku" value="<? echo stripslashes($arryItem[0]['Sku']); ?>" type="hidden"/>
<input  name="category" id="category" value="<? echo stripslashes($arryItem[0]['CategoryID']); ?>" type="hidden"/>
	</form>
	</table>
	</div>
	<? if ($_GET['tab'] == "alterimages") {
	include("includes/html/box/addimage_form.php");
	} ?>
