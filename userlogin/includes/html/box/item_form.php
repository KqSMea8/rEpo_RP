<script language="JavaScript1.2" type="text/javascript">
function validateItem(frm){

	if( ValidateForSimpleBlank(frm.Sku,"SKU Number")
	    && ValidateForSimpleBlank(frm.description, "Item Name")	
	    && ValidateOptionalUpload(frm.Image, "Image")
	  ){
		   
		if(document.getElementById("ItemID").value>0){
			ShowHideLoader('1','S');
			return true;
		}else{
		  var Url = "isRecordExists.php?Sku="+escape(document.getElementById("Sku").value)+"&editID="+document.getElementById("ItemID").value+"&Type=Inventory";
                
		  SendExistRequest(Url,"Sku", "SKU Number "+document.getElementById("Sku").value);

  	
		   return false;
		}			
					
	}else{
			return false;	
	}	

		
}

</script>


<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
<form name="form1" action=""  method="post" onSubmit="return validateItem(this);"  enctype="multipart/form-data">

<? if (!empty($_SESSION['mess_item'])) { ?>
<tr>
<td  align="center"  class="message"  >
<? if (!empty($_SESSION['mess_item'])) {
echo $_SESSION['mess_item'];
unset($_SESSION['mess_item']);
} ?>
</td>
</tr>
<? } ?>
<tr>
<td align="center" valign="top" >
<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="borderall">



<tr>
<td width="15%" align="right" valign="top"  class="blackbold" >SKU : <span class="red">*</span>  </td>
<td align="left"  width="30%" valign="top">
<?  if (!empty($_GET['edit'])) { ?>	
<input  name="Sku" id="Sku"  value="<? echo stripslashes($arryItem[0]['Sku']); ?>" type="text"  maxlength="30" class="disabled" readonly />	
<? }else{ ?>
<input  name="Sku" id="Sku"  value="<? echo stripslashes($arryItem[0]['Sku']); ?>" type="text"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display'); return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_Display','Sku','<?=$_GET['edit']?>'); " class="inputbox"/>
<div id="MsgSpan_Display"></div>

	
<? } ?>


 </td>

<td  align="right"   class="blackbold" valign="top" width="25%">Item Name : <span class="red">*</span> </td>
<td  height="30" align="left" valign="top">
<input  type="text" name="description" class="inputbox" id="description" value="<? echo stripslashes($arryItem[0]['description']); ?>"/>	 </td>
</tr>
                                      
 

<tr>
<td align="right"  class="blackbold"> Price :</td>
<td height="30" align="left"  class="blacknormal">
<input  name="sell_price" id="sell_price" onkeypress="return isDecimalKey(event);" value="<? echo $arryItem[0]['sell_price']; ?>" type="text"  class="textbox"  size="10" maxlength="10" />  <?=$Config['Currency']?></td>


<td align="right"  class="blackbold">Qty on Hand  :</td>
<td height="30" align="left"  class="blacknormal">
<input  name="qty_on_hand" id="qty_on_hand" value="<? echo $arryItem[0]['qty_on_hand']; ?>" type="text" onkeypress="return isNumberKey(event);"  class="textbox"  size="10" maxlength="10" /> </td>
</tr>





<tr>
<td align="right"  valign="top"  class="blackbold"> Item Image :</td>
<td  align="left" valign="top" >

<input name="Image" type="file" class="inputbox" id="Image" size="25" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">

	
<? 
$MainDir = $Config['UploadPrefix']."upload/items/images/".$_SESSION['CmpID']."/";	
if($arryItem[0]['Image'] != '' && file_exists($MainDir.$arryItem[0]['Image'])) {

$OldImage = $MainDir.$arryItem[0]['Image'];

 ?>
<br><br>
<input type="hidden" name="OldImage" value="<?=$OldImage?>">
<span id="DeleteSpan">
<a class="fancybox" href="<?=$MainDir.$arryItem[0]['Image']?>" title="<?=stripslashes($arryItem[0]['description']);?>" data-fancybox-group="gallery">

<? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryItem[0]['Image'].'" border=0 id="ImageV">';?></a>

<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryItem[0]['Image']?>','DeleteSpan')" onmouseout="hideddrivetip();">
<?=$delete?></a>
</span>
<br><br>
<? } ?>
	

</td>

<td align="right"   class="blackbold" valign="top">Status : </td>
<td height="30" align="left" valign="top"><span class="blacknormal">
<?
$ActiveChecked = ' checked';
if ($_GET['edit'] > 0) {
if ($arryItem[0]['Status'] == 1) {
$ActiveChecked = ' checked';
$InActiveChecked = '';
}
if ($arryItem[0]['Status'] == 0) {
$ActiveChecked = '';
$InActiveChecked = ' checked';
}
}
?>
<input type="radio" name="Status" id="Status" value="1" <?= $ActiveChecked ?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="Status" id="Status" value="0" <?= $InActiveChecked ?>>InActive    </span></td>
</tr>

<tr>
<td  align="right" valign="top"   class="blackbold"> Description : </td>
<td align="left" valign="top" colspan="3">
<Textarea name="long_description" id="long_description" class="bigbox" maxlength="500" ><? echo stripslashes($arryItem[0]['long_description']); ?></Textarea>


</td>
</tr>


</table>
</td>
</tr>

<tr>
<td align="center">

<?
if ($_GET['edit'] > 0) {
	$ButtonTitle = 'Update';
} else {
	$ButtonTitle = 'Submit';
}


?>

<input name="Submit" type="submit" class="button" id="<?= $ButtonID; ?>" value=" <?= $ButtonTitle ?> " <?= $DisabledButton ?> />

   
<input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['edit']; ?>" />


</td>
</tr>

</form>
</table>



