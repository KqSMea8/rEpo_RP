<script>
    $(document).ready(function() {
        $(".deleteProductImages").click(function() {

            var proVal = $(this).attr('alt');
            var SplitVal = proVal.split("#")
            var ItemID = SplitVal[0];
            var ImgVal = SplitVal[1];
            var CatID = <?=$_GET['CatID']?>

            //alert(CatID);
            var data = '&ItemID=' + ItemID + '&ImgVal=' + ImgVal + '&CatID=' + CatID + '&action=deleteImage';
//alert(data);
            if (data) {

                $.ajax({
                    type: "POST",
                    url: "e_ajax.php",
                    data: data,
                    success: function(msg) {
                        //alert(msg);
                        window.location.href = msg;
                    }
                });
            }

        });


    });
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateItem(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.Sku,"Item Sku")
		&&ValidateForSimpleBlank(frm.description, "Item Description")
		
		&& ValidateForSelect(frm.CategoryID,"Category")
		&& ValidateForSelect(frm.itemType,"Item Type")
		&& ValidateForSelect(frm.procurement_method,"Procurement Method")
		&& ValidateForSelect(frm.evaluationType,"Evaluation Type")
		
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		//&& ValidateForTextareaMand(frm.description,"description",10,300)
		//&& ValidateForSimpleBlank(frm.description,"description")
		
		
		){
		   var Url = "isRecordExists.php?Sku="+escape(document.getElementById("Sku").value)+"&editID="+document.getElementById("ItemID").value+"&Type=Inventory";
				  //alert(Url);
                                  
                                  SendExistRequest(Url,"Sku", "Item Sku "+document.getElementById("Sku").value);
					//SendExistRequest(Url,'Item Sku '+document.getElementById("Sku").value);
		  	
		                   return false;
				
					
			}else{
					return false;	
			}	

		
}

</script>


<div class="e_right_box">
<table width="100%"   border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
<td align="center" valign="top">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<tr>
<td  align="center" valign="middle" >

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
<form name="form1" action=""  method="post" onSubmit="return validateItem(this);"  enctype="multipart/form-data">

<? if (!empty($_SESSION['mess_product'])) { ?>
<tr>
<td  align="center"  class="message"  >
<? if (!empty($_SESSION['mess_product'])) {
echo $_SESSION['mess_product'];
unset($_SESSION['mess_product']);
} ?>
</td>
</tr>
<? } ?>
<tr>
<td align="center" valign="top" >
<table width="100%" border="0" cellpadding="3" cellspacing="1"  class="borderall">

<? if ($_GET["tab"] == "basic") {
?>


<tr>
<td colspan="2" align="left" class="head">General </td>
</tr>

<tr style="display:none33;">
<td width="31%" align="right"   class="blackbold" >SKU:   </td>
<td width="69%" height="30" align="left">

<input  name="Sku" id="Sku" readonly="readonly" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" type="text" class="disabled" maxlength="30" />	 </td>
</tr>

<tr>
<td width="31%" align="right"   class="blackbold" >Item Description : <span class="red">*</span> </td>
<td width="69%" height="30" align="left">
<input  type="text" name="description" class="inputbox" id="description" value="<? echo stripslashes($arryProduct[0]['description']); ?>"/>	 </td>
</tr>

    <tr>
                                                <td  align="right"   class="blackbold" >Procurement Method :  </td>
                                                <td   align="left">
                    <input name="procurement_method" id="procurement_method"  value="SALE">    
                                                   
                                                        </td>
                                            </tr>
                                      
  


<tr>
<td align="right"  class="blackbold">Sell Price :</td>
<td height="30" align="left"  class="blacknormal">
<input  name="sell_price" id="sell_price" onkeypress="return isDecimalKey(event);" value="<? echo $arryProduct[0]['sell_price']; ?>" type="text"  class="textbox"  size="10" maxlength="10" />  <?=$Config['Currency']?></td>

</tr>

<tr>
<td align="right" width="45%"  class="blackbold">On Hand Quantity  :</td>
<td height="30" align="left"  class="blacknormal">
<input  name="qty_on_hand " id="qty_on_hand" readonly value="<? echo $onHandQty; ?>" type="text" onkeypress="return isNumberKey(event);"  class="disabled"  size="10" maxlength="10" /> </td>
</tr>
<tr>
<td  align="right" valign="top"   class="blackbold"> Description  </td>
<td align="left" valign="top">
<Textarea name="Detail" id="Detail" class="bigbox"  ><? echo stripslashes($arryProduct[0]['Detail']); ?></Textarea>


</td>
</tr>

<tr>
<td align="right"   class="blackbold">Status  </td>
<td height="30" align="left"><span class="blacknormal">
<?
$ActiveChecked = ' checked';
if ($_GET['edit'] > 0) {
if ($arryProduct[0]['Status'] == 1) {
$ActiveChecked = ' checked';
$InActiveChecked = '';
}
if ($arryProduct[0]['Status'] == 0) {
$ActiveChecked = '';
$InActiveChecked = ' checked';
}
}
?>
<input type="radio" name="Status" id="Status" value="1" <?= $ActiveChecked ?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="Status" id="Status" value="0" <?= $InActiveChecked ?>>InActive    </span></td>
</tr>



<tr>
<td  height="70" align="right" valign="top"   class="blackbold"> Item Image </td>
<td  height="50" align="left" valign="top" >

<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
<tr>
<td width="51%" class="blacknormal" valign="top">
<input name="Image" type="file" class="inputbox" id="Image" size="25" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
<br>
<?= $MSG[201] ?>	</td>
<td width="49%">
<? if ($arryProduct[0]['Image'] != '' && file_exists('../../upload/items/images/' . $arryProduct[0]['Image'])) { ?>

<span id="DeleteSpan">
<a class="fancybox" href="../../upload/items/images/<? echo $arryProduct[0][Image]; ?>" title="<?=stripslashes($arryProduct[0]['description']);?>" data-fancybox-group="gallery">

<? echo '<img src="../../resizeimage.php?w=100&h=100&img=upload/items/images/' . $arryProduct[0]['Image'] . '" title="'.stripslashes($arryProduct[0]['description']).'" border=0  >'; ?></a>

<a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('../../upload/items/images/<? echo $arryProduct[0][Image]; ?>','DeleteSpan')" onmouseout="hideddrivetip();">
<?=$delete?></a>
</span>

<? } ?>
</td>
</tr>
</table>	</td>
</tr>
<?php } ?>






</table>
</td>
</tr>

<tr>
<td height="54" align="center">
<br>
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
</table></td>
</tr>
</table></td>
</tr>
</table>
</div>


