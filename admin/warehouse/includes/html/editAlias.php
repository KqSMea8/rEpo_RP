


<?


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_form.php");

?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	
		
	
	var AliasID = Trim(document.getElementById("AliasID")).value;

	

	if( ValidateForSimpleBlank(frm.ItemAliasCode, "alias Name ")
                && ValidateForSelect(frm.SuppCode, "vendor Code ")
		&& ValidateForSimpleBlank(frm.description, "description")
		
	){
		
			//var Url = "isRecordExists.php?"+ModuleField+"="+escape(ModuleVal)+"&editID="+OrderID;
			//SendExistRequest(Url,ModuleField, "<?=$ModuleIDTitle?>");
			return true;	
		

	}else{
		return false;	
	}	
		
}
</script>




 <script>
$(function() {
	var ModuleID = '<?=$ModuleID555?>';
$( "#"+ModuleID ).tooltip({
	position: {
	my: "center bottom-2",
	at: "center+110 bottom+70",
		using: function( position, feedback ) {
			$( this ).css( position );

		}
	}
	});
});
</script>



<form name="form1"  action=""  method="post" onSubmit="return validateForm(this);" enctype="multipart/form-data">

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">New Alias</td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 
       
      <tr>
                         <td  align="right" width="45%"   class="blackbold" > Alias Name:  <span class="red">*</span> </td>
                        <td  align="left">
                       <input  name="ItemAliasCode" id="ItemAliasCode" value="<?=$arryBOM[0]['ItemAliasCode']?>"  type="text" class="inputbox" size="10"  maxlength="30" />
                       </td>
                    </tr>
<? 


if(!empty($_GET['item_id']) && $_GET['Sku']!='' ){ $display = 'style="display:none"'; $type = 'hidden';}else{ $type = 'text';}?>
      
      <tr <?=$display?>>
                         <td  align="right"   class="blackbold" > Item Code:  <span class="red">*</span> </td>
                        <td  align="left">
                       <input  name="Sku" id="Sku" value="<?=$_GET['Sku']?>"  type="<?=type?>" class="disabled" size="10"  maxlength="30" />
                       <input  name="item_id" id="item_id" value="<?=$_GET['item_id']?>" type="hidden"  class="inputbox"  maxlength="30" />
                       
                        	
                           

                <a class="fancybox fancybox.iframe" href="finishItemList.php?id=1&finish=Finished Good" ><?= $search ?></a></td>

<!--<a class="fancybox fancybox.iframe" href="../warehouse/warehouseList.php" ><?= $search ?></a>--></td>
                    </tr>
 <tr>
                        <td  align="right"   class="blackbold" > Type:   </td>
                        <td  align="left">

			<select name="AliasType" class="inputbox" id="AliasType">
			<option value="">--Select--</option>
			<option value="Customer">Customer</option>
			<option value="Vendor">Vendor</option>
			<option value="Genral">Genral</option>
			</select
			</select>
                         

</td>
                    </tr>
<tr>
	<td align="right" width="45%" class="blackbold" > Vendor Code :<span class="red">*</span> </td>
	<td align="left" >
	<input name="SuppCode" type="text" readonly class="disabled" style="width:90px;" id="SuppCode" value="<?php echo stripslashes($arrySupplier[0]['SuppCode']); ?>" maxlength="40" readonly />
	<a class="fancybox fancybox.iframe" href="SuppList.php" ><?= $search ?></a>
<input name="SuppCompany" type="hidden" readonly class="disabled"  id="SuppCompany" value="<?php echo stripslashes($arrySupplier[0]['CompanyName']); ?>" maxlength="50" onkeypress="return isCharKey(event);"/>
<input name="SuppContact" type="hidden" readonly  class="inputbox" id="SuppContact" value="<?php echo stripslashes($arrySupplier[0]['SuppContact']); ?>" maxlength="30" onkeypress="return isCharKey(event);"/>
<input name="City" type="hidden" readonly class="disabled"  id="City" value="<?php echo stripslashes($arrySupplier[0]['City']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
<input name="State" type="hidden" readonly class="disabled"  id="State" value="<?php echo stripslashes($arrySupplier[0]['State']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
<input name="Country" type="hidden"  readonly class="disabled" id="Country" value="<?php echo stripslashes($arrySupplier[0]['Country']); ?>"  maxlength="30" onkeypress="return isCharKey(event);"/>
<input name="ZipCode" type="hidden" readonly class="disabled" id="ZipCode" value="<?php echo stripslashes($arrySupplier[0]['ZipCode']); ?>"  maxlength="30" onkeypress="return isAlphaKey(event);"/>
	</td>
	</tr>


	
                    <tr>
                        <td  align="right"   class="blackbold" > Description:   </td>
                        <td  align="left">
                            
                      
                           <input  name="description" id="description" value="<?=$arryBOM[0]['description']?>" type="text"  size="30"  class="inputbox"  maxlength="15" />

</td>
                    </tr>





</table>

	 </td>
</tr>







</table>	
    
	
	</td>
   </tr>


   <tr <?=$disNone?>>
    <td  align="center">
	
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
        
         <? if ( $arryBOM[0]['Status']!=2) { ?>
 
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
 <input name="Calcel" type="submit" class="button" id="SubmitButton" value=" Cancel "  />
         <? } ?>

<input type="hidden" name="AliasID" id="AliasID" value="<?=$_GET['edit']?>" />




<input type="hidden" name="PrefixPO" id="PrefixPO" value="<?=$PrefixPO?>" />



</td>
   </tr>
  
</table>

 </form>


<? } ?>





