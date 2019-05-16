<script language="JavaScript1.2" type="text/javascript">
function validateAsset(frm){

	var DataExist=0;

	if(document.getElementById("AssetID").value == ""){
	
		/**********************/
		var TagID = Trim(document.getElementById("TagID")).value;

		if(TagID!=''){
			if(!ValidateMandRange(document.getElementById("TagID"), "Tag ID",3,30)){
				return false;
			}
			DataExist = CheckExistingData("isRecordExists.php","&TagID="+escape(TagID)+"&editID="+document.getElementById("AssetID").value, "TagID","Tag ID");
			if(DataExist==1)return false;

		}
		/**********************/
		var SerialNumber = Trim(document.getElementById("SerialNumber")).value;
		if(SerialNumber!=''){
			if(!ValidateMandRange(document.getElementById("SerialNumber"), "Serial Number",3,30)){
				return false;
			}
			DataExist = CheckExistingData("isRecordExists.php","&SerialNumber="+escape(SerialNumber)+"&editID="+document.getElementById("AssetID").value, "SerialNumber","Serial Number");
			if(DataExist==1)return false;

		}
		/**********************
		var RFID = Trim(document.getElementById("RFID")).value;
		if(RFID!=''){
			if(!ValidateMandRange(document.getElementById("RFID"), "RFID Code",3,30)){
				return false;
			}
			DataExist = CheckExistingData("isRecordExists.php","&RFID="+escape(RFID)+"&editID="+document.getElementById("AssetID").value, "RFID","RFID Code");
			if(DataExist==1)return false;

		}
		/**********************/
		
	}


	if(!ValidateMandRange(frm.AssetName, "Asset Name",3,30)){
		return false;
	}
	/**********************/
	if(!ValidateOptionalUpload(frm.Image, "Image")){
		return false;
	}
	
	/**********************/

	ShowHideLoader('1','S');
	
}
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateAsset(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 <tr>
        <td  align="right"   class="blackbold" width="40%"> Tag ID : </td>
		<td   align="left" >
			<?php if(!empty($_GET['edit'])){?>
			<?=$arryAsset[0]['TagID'];?>
			<?php } else {?>
			<input name="TagID" type="text" class="datebox" id="TagID" value=""  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_TagID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_TagID','TagID','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
			<span id="MsgSpan_TagID">
			</span>
			<?php }?>

		</td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> Serial Number : </td>
        <td   align="left">
		 <?php if(!empty($_GET['edit'])){?>
			<?=(!empty($arryAsset[0]['SerialNumber']))?($arryAsset[0]['SerialNumber']):(NOT_SPECIFIED)?>
			<?php } else {?>
			<input name="SerialNumber" type="text" class="inputbox" id="SerialNumber" value="<?php echo stripslashes($arryAsset[0]['SerialNumber']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_SerialNumber');" onBlur="Javascript:CheckAvailField('MsgSpan_SerialNumber','SerialNumber','<?=$_GET['edit']?>');"/>
	       <span id="MsgSpan_SerialNumber"></span>
			<?php }?>
		
				
	 </td>
      </tr>	 	

     <!--<tr>
        <td  align="right" class="blackbold">RFID Code : </td>
        <td align="left">
		
		 <//?php if(!empty($_GET['edit'])){?>
			<//?=$arryAsset[0]['RFID'];?>
			<//?php } else {?>
				<input name="RFID" type="text" class="inputbox" id="RFID" value="" maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_RFID');return isAlphaKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_RFID','RFID','<//?=$_GET['edit']?>');" />

		     <span id="MsgSpan_RFID"></span>	
			<//?php }?>
			
	
	 </td>
     </tr>-->	 




		<tr>
			<td  align="right"   class="blackbold"> Asset Name  :<span class="red">*</span></td>
			<td   align="left" >
			<input name="AssetName" type="text" class="inputbox" id="AssetName" value="<?php echo stripslashes($arryAsset[0]['AssetName']); ?>"  maxlength="40" onKeyPress="Javascript:return isAlphaKey(event);" />
			</td>
		</tr>

	 <tr>
		<td align="right"   class="blackbold" >Model  :</td>
		<td  align="left"  >
		<input name="Model" type="text" class="inputbox" id="Model" value="<?=stripslashes($arryAsset[0]['Model'])?>"     maxlength="50" />			
		</td>
	</tr>

	<? if(sizeof($arryCategory)>0){ ?>
		<!--tr>
				<td  align="right" class="blackbold">Category  :</td>
				<td   align="left">
				  <select name="Category" class="inputbox" id="Category">
					<option value="">--- None ---</option>
						<? for($i=0;$i<sizeof($arryCategory);$i++) {?>
							<option value="<?=$arryCategory[$i]['attribute_value']?>" <?  if($arryCategory[$i]['attribute_value']==$arryAsset[0]['Category']){echo "selected";}?>>
							<?=$arryCategory[$i]['attribute_value']?>
					</option>
						<? } ?>
				</select> 
				</td>
		</tr-->
	<? } ?>

	<? //if(sizeof($arryBrand)>0){ ?>
	<tr>
			<td  align="right" class="blackbold">Brand  :</td>
			<td   align="left">

<input name="Brand" type="text" class="inputbox" id="Brand" value="<?=stripslashes($arryAsset[0]['Brand'])?>"     maxlength="30" />	

			  <!--select name="Brand" class="inputbox" id="Brand">
				<option value="">--- None ---</option>
					<? for($i=0;$i<sizeof($arryBrand);$i++) {?>
						<option value="<?=$arryBrand[$i]['attribute_value']?>" <?  if($arryBrand[$i]['attribute_value']==$arryAsset[0]['Brand']){echo "selected";}?>>
						<?=$arryBrand[$i]['attribute_value']?>
				</option>
					<? } ?>
			</select--> 
			</td>
	</tr>
	<? //} ?>

	  
	<tr>
		<td  align="right"   class="blackbold"  > Storage Location  : </td>
		<td   align="left" >
		<input name="Location" type="text" class="inputbox" id="Location" value="<?php echo stripslashes($arryAsset[0]['Location']); ?>"  maxlength="50" />            </td>
	</tr>

	<tr>
		<td  align="right"   class="blackbold" valign="top"> Description  : </td>
		<td   align="left" >
		<textarea name="Description" type="text" class="textarea" id="Address" maxlength="500"><?=stripslashes($arryAsset[0]['Description'])?></textarea>	     

		</td>
	</tr>

<? 
	#$arryExisting = $arryAsset;
	#include("includes/html/box/custom_field_form.php");
	?>


<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

<?php

 if($arryAsset[0]['Image'] !='' && IsFileExist($Config['AssetDir'], $arryAsset[0]['Image']) ){ 
	$OldImage = $arryAsset[0]['Image'];
 
	$PreviewArray['Folder'] = $Config['AssetDir'];
	$PreviewArray['FileName'] = $arryAsset[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($arryAsset[0]['AssetName']);
	$PreviewArray['Width'] = "150";
	$PreviewArray['Height'] = "150";
	$PreviewArray['Link'] = "1";
	echo '<div  id="ImageDiv">'.PreviewImage($PreviewArray).'&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['AssetDir'].'\',\''.$arryAsset[0]['Image'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'" /></div>';

}


?>

	
		</td>
  </tr>	  
 


	  <? if(sizeof($arryVendor)>0){ ?>
	<!--tr>
			<td  align="right" class="blackbold">Vendor  :</td>
			<td   align="left">
			  <select name="Vendor" class="inputbox" id="Vendor">
				<option value="">--- None ---</option>
					<? for($i=0;$i<sizeof($arryVendor);$i++) {?>
						<option value="<?=$arryVendor[$i]['VendorID']?>" <?  if($arryVendor[$i]['VendorID']==$arryAsset[0]['Vendor']){echo "selected";}?>>
						<?=$arryVendor[$i]['VendorName']?>
				</option>
					<? } ?>
			</select> 
			</td>
	</tr-->
	<? } ?>


  <tr>
        <td  align="right"   class="blackbold" >Acquired :</td>
        <td   align="left" >

<script type="text/javascript">
$(function() {
	$('#Acquired').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-50?>:<?=date("Y")?>', 
		maxDate: "-0D", 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>

<? 	
$Acquired = ($arryAsset[0]['Acquired']>0)?($arryAsset[0]['Acquired']):(""); 
?>
<input id="Acquired" name="Acquired" readonly="" class="datebox" value="<?=$Acquired?>"  type="text" > 


</td>
      </tr>
     
	  



	  <!--tr>
        <td align="right"   class="blackbold">Warranty Starts  : </td>
        <td  align="left" >
<script type="text/javascript">
$(function() {
	$('#WrStart').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<? 	
$WrStart = ($arryAsset[0]['WrStart']>0)?($arryAsset[0]['WrStart']):(""); 
?>
<input id="WrStart" name="WrStart" readonly="" class="datebox" value="<?=$WrStart?>"  type="text" > 		
		</td>
      </tr>
	  
 <tr>
        <td align="right"   class="blackbold">Warranty Ends  : </td>
        <td  align="left" >
<script type="text/javascript">
$(function() {
	$('#WrEnd').datepicker(
		{
		showOn: "both",
		yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<? 	
$WrEnd = ($arryAsset[0]['WrEnd']>0)?($arryAsset[0]['WrEnd']):(""); 
?>
<input id="WrEnd" name="WrEnd" readonly="" class="datebox" value="<?=$WrEnd?>"  type="text" > 		
		</td>
      </tr--> 



	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="AssetID" id="AssetID" value="<?=$_GET['edit']?>" />


</div>

</td>
   </tr>
   </form>
</table>

