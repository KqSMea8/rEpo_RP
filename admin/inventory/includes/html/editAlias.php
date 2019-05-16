


<?


if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
	#include("includes/html/box/po_form.php");

?>


<script language="JavaScript1.2" type="text/javascript">
function validateForm(frm){
	var AliasID = Trim(document.getElementById("AliasID")).value;


	if( ValidateForSimpleBlank(frm.ItemAliasCode, "Alias Name")
            && ValidateForSimpleBlank(frm.description, "Description")		
	){
		if(AliasID>0){
			return true;	
		}else{	
			var Url = "isRecordExists.php?ItemAliasCode="+escape(frm.ItemAliasCode.value)+"&editID="+AliasID;
			SendExistRequest(Url, ItemAliasCode, "Alias Name");
			return false;	
		}	

	}else{
		return false;	
	}	
		
}

function refreshPage(){
		
parent.window.location.reload();

}
</script>




 <script>
$(function() {
	var ModuleID = '';
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
	 <td colspan="2" align="left" class="head"><? if(empty($_GET['edit'])){ echo 'New Alias'; }else{ echo 'Edit Alias'; }?></td>
</tr>

<tr>
	 <td colspan="2" align="left">

<table width="100%" border="0" cellpadding="5" cellspacing="0">	 
 
       
<tr>
<td  align="right" width="45%"   class="blackbold" > Alias Name:  <span class="red">*</span> </td>
<td  align="left">

<? if(!empty($_GET['edit'])){ ?>
	<input  name="ItemAliasCode" id="ItemAliasCode" value="<?=stripslashes($arryAlias[0]['ItemAliasCode'])?>"  type="text" class="disabled_inputbox" style="text-transform:uppercase"  readonly maxlength="30" />
<? }else{ ?>
	<input  name="ItemAliasCode" id="ItemAliasCode" value="<?=stripslashes($arryAlias[0]['ItemAliasCode'])?>"  type="text" class="inputbox"  style="text-transform:uppercase" maxlength="30"  onKeyPress="Javascript:ClearAvail('MsgSpan_Display'); " onBlur="Javascript:CheckAvailField('MsgSpan_Display','ItemAliasCode','<?=$_GET['edit']?>'); " />

	<span id="MsgSpan_Display"></span>


<? } ?>


</td>
</tr>

 



	
	<tr>
		<td  align="right"   class="blackbold" > Description: <span class="red">*</span>  </td>
		<td  align="left">
		<input  name="description" id="description" value="<?=stripslashes($arryAlias[0]['description'])?>" type="text"  size="30"  class="inputbox"  maxlength="200" />

		</td>
	</tr>

<tr>
	<td  align="right"   class="blackbold" >Manufacture

	:   </td>
	<td   align="left">
	<select name="Manufacture" id="Manufacture" class="inputbox">
	<option value="">Select Manufacture

	</option>
	<? for($i=0;$i<sizeof($arryManufacture);$i++) {?>
	<option value="<?=$arryManufacture[$i]['attribute_value']?>" <?  if($arryManufacture[$i]['attribute_value']==$arryAlias[0]['Manufacture']){echo "selected";}?>>
					<?=$arryManufacture[$i]['attribute_value']?>
					</option>
				<? } ?>   
	</select>
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
        
         <? //if ( $arryBOM[0]['Status']!=2) { ?>
 
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
<input name="Close" type="button" onclick="return refreshPage();" class="button" id="Close" value="Close "  />
         <? //} ?>
<input  name="Sku" id="Sku" value="<?=$Sku?>"  type="hidden"  size="10"  maxlength="30" />
<input  name="item_id" id="item_id" value="<?=$item_id?>" type="hidden"  class="inputbox"  maxlength="30" />
<input type="hidden" name="AliasID" id="AliasID" value="<?=$_GET['edit']?>" />




<input type="hidden" name="PrefixPO" id="PrefixPO" value="<?=$PrefixPO?>" />



</td>
   </tr>
  
</table>

 </form>


<? } ?>





