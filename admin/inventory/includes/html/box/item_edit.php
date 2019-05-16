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

getCustomerstr($('#is_exclusive').val());
	});
function getCustomerstr(is_exclusive){
		if(is_exclusive=='Yes'){
			$('#CustTR').show();
		}else{
			$('#CustTR').hide();
		}
		
	}

	</script>
	<script language="JavaScript1.2" type="text/javascript">



	function validateItem(frm)
	{

	
		var ManageBOM=document.getElementById("ManageBOM").value;
		
	if( ValidateForSelect(frm.non_inventory,"Inventory")
	&& ValidateForSimpleBlank(frm.Sku,"SKU Code")
	&& ValidateForSimpleBlank(frm.description, "Item Description")
	
     // if(ManageBOM==1)
       // {
	//&& ValidateForSelect(frm.CategoryID,"Category")
       // }
       
	){

	if(document.getElementById("non_inventory").value == 'yes')
		{

		

		/*if(!ValidateForSelect(frm.Condition,"Condition")){
		 return false;
		}*/


	     

		if(document.getElementById("EditableSku").value == '1')
			{ 

		      if(ManageBOM==1)
		        {
			if(!ValidateForSelect(frm.itemType,"Item Type"))
				{
			 return false;
			}
		        }
		}
		//if(!ValidateForSelect(frm.procurement_method,"Procurement Method")){
		 //return false;
		//}

		if(!ValidateOptionalUpload(frm.Image,"Image")){
		 return false;
		}


	}
	

		if(document.getElementById("EditableSku").value == '1')
			{ 	
			var Url = "isRecordExists.php?Sku="+escape(document.getElementById("Sku").value)+"&editID="+document.getElementById("ItemID").value+"&Type=Inventory";	
			SendExistRequest(Url,"Sku", "SKU Code "+document.getElementById("Sku").value);
			return false;
		}else{
			ShowHideLoader('1','S');
			return true;	
		}


	}else{
		return false;	
	}	


	}

function valdatebinlocation(frm){

if( ValidateForSelect(frm.warehouse,"Warehouse")
	&& ValidateForSelect(frm.bin_location,"Bin location")
       
	){

//var Url = "isRecordExists.php?ItemWarehouse="+escape(document.getElementById("warehouse").value)+"&ItemBin="+document.getElementById("bin_location").value;
	//alert(Url);

	//SendExistRequest(Url,"warehouse", "warehouse or bin location"+document.getElementById("warehouse").value);
	return true;
}else{

	return false;
}
}


function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Model"+i).checked=true;
	}

	Getcheckbox();
}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Model"+i).checked=false;
	}
	Getcheckbox();
}

function SelectAllRcrd()
{	
	for(i=1; i<=document.form1.Line2.value; i++){
		document.getElementById("WID"+i).checked=true;
	}
	
}

function SelectNoneRcrds()
{
	for(i=1; i<=document.form1.Line2.value; i++){
		document.getElementById("WID"+i).checked=false;
	}
	
}

function SelectAllBinRecord()
{	
	for(i=1; i<=document.form1.Line4.value; i++)
		{
		document.getElementById("bin"+i).checked=true;
	}

}

function SelectNoneBinRecords()
{
	for(i=1; i<=document.form1.Line4.value; i++){
		document.getElementById("bin"+i).checked=false;
	}
}



function filterwarehouse(id)
	{ 
var CatID = '<?=$_GET['CatID']?>';
		location.href="editItem.php?edit="+document.getElementById("ItemID").value+"&CatID="+CatID+"&WID="+id+"&tab=binlocation";		

	}

$(document).ready(function() {
$('#non_inventory').on('change', function() {
 
if(this.value == 'No'){
$('#non_inv').hide();
$('#CatSpan').hide();
}else{
$('#non_inv').show();
$('#CatSpan').show();
}
});
$('#ReorderLevel').on('change', function() { 
		if(this.value != ''){
			$('#showReorder').show();
        $('#showreordertext').show();
$('#gOrder').show();
		}else{
			$('#showReorder').hide();
$('#showreordertext').hide();
$('#gOrder').hide();
		}
	});
if($('#ReorderLevel').val()!=''){

$('#showReorder').show();
        $('#showreordertext').show();
$('#gOrder').show();

}else{

	$('#showReorder').hide();
$('#showreordertext').hide();
$('#gOrder').hide();
}



});


function Getcheckbox(opt)
{	
	if(opt==1){
		document.getElementById("GetGen").value='';
	}
var Model1= document.getElementById("Line").value;
var ModelId='';	
for(i=1; i<=Model1; i++)
{
	if(document.getElementById("Model"+i).checked){
	  	ModelId = ModelId + document.getElementById("Model"+i).value+',';	  
	}		
}

var Gennn= document.getElementById("GetGen").value;

var SendUrl = 'ajax.php?action=Generation&ModelId='+ModelId+'&GenVal='+Gennn+'&r='+Math.random();;

document.getElementById("PermissionValue1").innerHTML = '';
httpObj.open("GET", SendUrl, true);
httpObj.onreadystatechange = function GenRecieve()
{
if (httpObj.readyState == 4)
	{
	//alert(httpObj.responseText);
		
			document.getElementById("PermissionValue1").innerHTML  = httpObj.responseText;
	}
	};
	httpObj.send(null);


}
function CheckGeneration()
{
var Gen= document.getElementById("Generationid").value;
//alert(Gen);
var jk='';	
for(j=0; j<=Gen; j++)
{
	
if(document.getElementById("Generation"+j).checked)
		{
	jk += document.getElementById("Generation"+j).value+',';
	//alert(jk);
	    }

else
{
//alert(jk);	
}
//alert(jk);
document.getElementById("Generation_type").value =jk;		
}
}



//////


function EditCheckGeneration(gen)
{
//alert(gen);
//var Gen= document.getElementById("Generationid").value;
//alert(Gen);
var jk='';	
//for(j=0; j<=Gen; j++)
//{
	
if(gen !='')
		{
	jk = gen;

	//alert(jk);
	    }

else
{
//alert(jk);	
}

var str = document.getElementById("Generation_type").value;
//alert(str);
//alert(str.includes(jk));
if(str.includes(jk) == false ){
str = str + jk +',';

}
document.getElementById("Generation_type").value =str;		
}

function EditGetcheckbox(opt,ModelId)
{	

//alert(ModelId);
	//if(opt==1){
		//document.getElementById("GetGen").value='';
	//}
var Model1= document.getElementById("Line").value;
//var ModelId=modid;	
/*for(i=1; i<=Model1; i++)
{
	if(document.getElementById("Model"+i).checked){
	  	ModelId = ModelId + document.getElementById("Model"+i).value+',';	  
	}		
}*/

var Gennn= document.getElementById("GetGen").value;

var SendUrl = 'ajax.php?action=EditGeneration&ModelId='+ModelId+'&GenVal='+Gennn+'&r='+Math.random();;
//alert(SendUrl);
document.getElementById("PermissionValue1").innerHTML = '';
httpObj.open("GET", SendUrl, true);
httpObj.onreadystatechange = function GenRecieve()
{
if (httpObj.readyState == 4)
	{
	//alert(httpObj.responseText);
		
			document.getElementById("PermissionValue1").innerHTML  = httpObj.responseText;
	}
	};
	httpObj.send(null);


}

function Getbox(mod,line){
//alert(line);

if (document.getElementById("Model"+line).checked == true) {
//alert(line);
    document.getElementById("Gen_"+mod).style.display = 'block';
}else{
document.getElementById("Gen_"+mod).style.display = 'none';
}

}

function Getboxhide(mod,line){
//alert(line);
$("#Gen_"+mod).toggle();
//if (document.getElementById("Model"+line).checked == true) {
//alert(line);
    //document.getElementById("Gen_"+mod).style.display = 'block';
//}else{
//document.getElementById("Gen_"+mod).style.display = 'none';
//}

}
</script>
<? if($_GET['tab'] == 'basic'){
 $validate = "return validateItem(this)";


if($arryProduct[0]['ReorderLevel']!=''){
$reorderDisplay ='';
}else{
$reorderDisplay ='style="display:none;"';

}

}else if($_GET['tab'] == 'binlocation'){
 $validate = "return valdatebinlocation(this)";
}else if($_GET['tab'] == 'Required'){
 $validate = "return validateRequired(this)";
} 




?>
<? if($_SESSION['SelectOneItem'] == 1){ 

$dis = 'style="display:none"';
}else{

$dis ='';
}

?>
<div class="e_right_box">
<? if (!empty($_SESSION['mess_product'])) { ?>	
	<div class="message" align="center">
	<? 	echo $_SESSION['mess_product'];	unset($_SESSION['mess_product']);	 ?>
	</div>	
<? } ?>
	<form name="form1" action=""  method="post" onSubmit="<?=$validate?>"  enctype="multipart/form-data">
	<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
	
	
	<tr>
	<td align="center" valign="top" >
	<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="borderall">

	<? if ($_GET["tab"] == "basic") {?>
	<tr>
	<td colspan="2" align="left" class="head">Basic Information </td>
	</tr>
	<tr <?=$dis?>>
	<td  align="right"  class="blackbold" >Inventory Item:<span class="red">*</span></td>
	<td   align="left">
<? if($Config['TrackInventory']=='0' && $arryProduct[0]['non_inventory']=='No'){ ?>
<input name="non_inventory" class="disabled" size="5" id="non_inventory" value="No" readonly>
<? }else{ 

	if(empty($arryProduct[0]['non_inventory'])) $arryProduct[0]['non_inventory']='No';

?>
	<select name="non_inventory" class="inputbox" id="non_inventory">
	<option value="">-Select-</option>
	<option value="yes" <? if($arryProduct[0]['non_inventory']=='yes'){ echo "selected"; }?>>Yes</option>
	<option value="No" <? if($arryProduct[0]['non_inventory']=='No'){ echo "selected"; }?>>No</option>
	</select>
<? } ?>



	</td>
	</tr> 

<tr >
	<td  align="right"  class="blackbold" valign="top" >Exclusive Items :</td>
	<td   align="left">

	<select name="is_exclusive" class="inputbox" id="is_exclusive" onchange="getCustomerstr(this.value);">
	<option value="No" <? if($arryProduct[0]['is_exclusive']=='No'){ echo "selected"; }?>>No</option>	
	<option value="Yes" <? if($arryProduct[0]['is_exclusive']=='Yes'){ echo "selected"; }?>>Yes</option>
	
	</select>

	<div style="display:none;" id="CustTR">
	<a class="fancybox fancybox.iframe" href="CustomerList.php?ItemID=<?php echo $arryProduct[0]['ItemID'];?>" >Assign Customers</a></div>

	<input type="hidden" name="CustomerID" class="inputbox" id="CustomerID"/>
	</td>
	</tr>     
	<tr style="display:none33;">
	<td  align="right" width="33%"  class="blackbold" valign="top">SKU  :<span class="red">*</span> </td>
	<td  align="left">
	<? if($EditableSku==1){?>
	<input name="Sku" type="text" class="inputbox" style="text-transform:uppercase" id="Sku" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display'); return AvoidSpace(event); " onBlur="Javascript:CheckAvailField('MsgSpan_Display','Sku','<?=$_GET['edit']?>'); "/>
		<br>
		<span id="MsgSpan_Display"></span>
	<?}else{?>
	<input  name="Sku" id="Sku" readonly="readonly" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" type="text" class="disabled" style="text-transform:uppercase"  maxlength="30" />	
	<?}?>
	<input type="hidden" name="EditableSku" id="EditableSku" value="<?=$EditableSku?>" >
	<input  name="OldSku" id="OldSku" readonly="readonly" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" type="hidden" class="disabled" maxlength="30" />	


 </td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold" >Item Description :<span class="red">*</span></td>
	<td  align="left">
	<input  type="text" name="description" class="inputbox" id="description" value="<? echo stripslashes($arryProduct[0]['description']); ?>" style="width:440px;"  maxlength="200"  />	 </td>
	</tr>
<tr >
	<td  align="right"   class="blackbold" >Category /SubCategory :</span> </td>
	<td  align="left">

	<select name="CategoryID" id="CategoryID" class="inputbox">
	<option value="">Select Category</option>
	<?php
	$objCategory->getCategories(0, 0, $_GET['CatID']);
	?>
	</select>


	</td>
	</tr>

<tr <?=$dis?>>
<?php if($arrySection['Model']==1)
{    
$varmodel="Model:";
}
 else 
 {

$varmodel="";

  }?>
<td colspan="2"  align="right" >
<div id="non_inv" <?=$DisplayNone?>>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
		<tr>
		<td  align="right" width="33%"   class="blackbold" valign="top" ><?=$varmodel?></td>
		<td   align="left">
		<?php if($arrySection['Model']==1)
    	{ ?>  
<div id="PermissionValue" style="width:450px; height:300px; overflow:auto">  
<table width="100%"  border="0" cellspacing=0 cellpadding=2>
	<tr> 
		<?   $flag = 0;
		if(sizeof($arryModel)>0) {					   
			for($i=0;$i<sizeof($arryModel);$i++) { 

			if ($flag % 3 == 0) {
			echo "</tr><tr>";
			}

			$Line = $flag+1;
			

			$class = explode(",",$Mod);
			?>

			<td align="left"  valign="top" width="220" height="20">
				<input type="checkbox" onchange="Getbox(this.value,<?=$Line?>);"  name="Model[]" id="Model<?=$Line?>" <? if(in_array($arryModel[$i]['id'], $class)){
				echo "checked";}?> value="<?=$arryModel[$i]['id'];?>">&nbsp;

				<? $ArrGetGen = $objItem->GetGenrationBasedOnModel($arryModel[$i]['id']); 


$arryGen = $objItem->GetModGen($arryProduct[0]['ItemID'],$arryModel[$i]['id']);

 $Genclass = '';
if(!empty($arryGen[0]['genration'])){
	$Genclass = explode(",",$arryGen[0]['genration']);
}

?>

				<span  onmouseout="hideddrivetip()"  onmouseover="ddrivetip('<center><?=$ArrGetGen[0]['Generation']?></center>', 200,'')"><a href="#" onclick="Getboxhide(<?=$arryModel[$i]['id']?>,<?=$Line?>);"><?=stripslashes($arryModel[$i]['Model']);?></a></span> 	

<div id="Gen_<?=$arryModel[$i]['id']?>" style="display:none; border: 1px solid gray; width: 100px;">&nbsp;&nbsp;&nbsp;Generation:
<?php $GenArry = explode(",",$ArrGetGen[0]['Generation']); 
sort($GenArry, SORT_NATURAL | SORT_FLAG_CASE);

//print_r($GenArry);
for($g=0;$g<sizeof($GenArry);$g++) {?>

<div align="left" style="border-top: 1px solid gray; width: 81px;padding: 10px;"><input type="checkbox" <? if(!empty($Genclass)) { if(in_array($GenArry[$g], $Genclass)){
				echo "checked";} } ?>   name="Gen_<?=$arryModel[$i]['id']?>[]" id="Gen<?=$arryModel[$i]['id']?>"  value="<?=$GenArry[$g];?>">&nbsp;<?=$GenArry[$g];?></div>

<? }?>
</div>						
			</td>
			<?
				$flag++;
			} ?>

			<input type="hidden" name="Line" id="Line" value="<? echo sizeof($arryModel);?>">





		<? }else{ 
			$HideSibmit = 1;
			echo "<td>No Model Exists.</td>";
		}
		?>
	</tr>
</table>
</div>


		</td>
		</tr>
		 
	<?  if(sizeof($arryModel)>1) {	?>
	<!--tr>
		<td></td>
		<td align="right"><a style = "color:white" class= "button" href="javascript:SelectAllRecord();">Select All</a>  <a style = "color:white" class= "button" href="javascript:SelectNoneRecords();" >Select None</a>
	`		</td>
	</tr-->
	<? } ?>
	
	<? } ?>
<?php if($arrySection['Model']==1)
    	{ ?>  
	<!--tr>

		<td  align="right" width="38%"   class="blackbold" valign="top" >Generation : </td>
		<td   align="left">
		
<div id="PermissionValue1" style="width:380px; height:50px; overflow:auto"> </div>
	<input type="hidden" name="Generation_type" id="Generation_type" value="<?=stripslashes($arryProduct[0]['Generation']);?>" />
	<input type="hidden" name="GetGen" id="GetGen" value="<?=stripslashes($arryProduct[0]['Generation']);?>">
	</td>
	</tr-->
<? } ?>
<!--tr>
	<td  align="right"   class="blackbold" >Condition /SubCondition :<span class="red">*</span> </td>
	<td  align="left">

	<select name="Condition" id="Condition" class="inputbox">
	<option value="">Select Condition</option>
	<?php
	$objCondition->getConditions(0, 0, $arryProduct[0]['Condition']);
	?>
	</select>


	</td>
	</tr-->

	<!--tr>
	<td  align="right"   class="blackbold" >Condition :  </td>
	<td   align="left">
	<select name="Condition" id="Condition" class="inputbox">
	<option value="">Select Condition</option>
	<? for($i=0;$i<sizeof($arryCondition);$i++) {?>
	<option value="<?=$arryCondition[$i]['attribute_value']?>" <?  if($arryCondition[$i]['attribute_value']==$arryProduct[0]['Condition']){echo "selected";}?>><?=$arryCondition[$i]['attribute_value']?></option> 
	<? } ?> 								 
	</select>
	</td>
	</tr-->
	<!--tr>
	<td  align="right"   class="blackbold" >Extended

	:  </td>
	<td   align="left">
	<select name="Extended" id="Extended" class="inputbox">
	<option value="">Select Extended

	</option>
	<? for($i=0;$i<sizeof($arryExtended);$i++) {?>
	<option value="<?=$arryExtended[$i]['attribute_value']?>" <?  if($arryExtended[$i]['attribute_value']==$arryProduct[0]['Extended']){echo "selected";}?>>
					<?=$arryExtended[$i]['attribute_value']?>
					</option>
				<? } ?>   
	</select>
	</td>
	</tr-->
	</tr>
	<tr <?=$dis?>>
	<td  align="right"   class="blackbold" >Manufacture

	:   </td>
	<td   align="left">
	<input type="hidden" name="ManageBOM" id="ManageBOM" value="<? echo $arryMainmenuSection['Manage BOM']?>">
	<select name="Manufacture" id="Manufacture" class="inputbox">
	<option value="">Select Manufacture

	</option>
	<? for($i=0;$i<sizeof($arryManufacture);$i++) {?>
	<option value="<?=$arryManufacture[$i]['attribute_value']?>" <?  if($arryManufacture[$i]['attribute_value']==$arryProduct[0]['Manufacture']){echo "selected";}?>>
					<?=$arryManufacture[$i]['attribute_value']?>
					</option>
				<? } ?>   
	</select>
	</td>
	</tr>
	<?php if($arryMainmenuSection['Manage BOM']==1)
    	{ ?>
	<tr <?=$dis?>>
	<td  align="right"   class="blackbold" >Item Type :   </td>
	<td  align="left">
<? //if($EditableSku){ ?>
	<select name="itemType" id="itemType" class="inputbox">
	<option value="">Select Item Type</option>
	<? for ($i = 0; $i < sizeof($arryItemType); $i++) { ?>
	<option value="<?= $arryItemType[$i]['attribute_value'] ?>" <? if ($arryItemType[$i]['attribute_value'] == $arryProduct[0]['itemType']) {
	echo "selected";
	} ?>>
	<?= $arryItemType[$i]['attribute_value'] ?>
	</option>
	<? } ?>
	</select>
<? //}else{
	//echo '<input name="itemType" id="itemType" class="disabled_inputbox" readonly value="'.$arryProduct[0]['itemType'].'">';
//} ?>




	</td>
	</tr>
	<?php } ?>
<tr style="display:none;">
	<td  align="right"  class="blackbold" valign="top">Procurement Method :   </td>
	<td  align="left">

	<?php echo $dropList; ?>

	</td>
	</tr>
<?php if($arryMainmenuSection['Manage BOM']==1)
    	{ ?>
	<!--tr>
	<td  align="right"   class="blackbold" >Valuation Method :   </td>
	<td  align="left">
<? if($EditableSku){ ?>
	<select name="evaluationType" id="evaluationType" class="inputbox">
	<option value="">Select Valuation</option>
	<? for ($i = 0; $i < sizeof($arryEvaluationType); $i++) { ?>
	<option value="<?= $arryEvaluationType[$i]['attribute_value'] ?>" <? if ($arryEvaluationType[$i]['attribute_value'] == $arryProduct[0]['evaluationType']) {
	echo "selected";
	} ?>>
	<?= $arryEvaluationType[$i]['attribute_value'] ?>
	</option>
	<? } ?>
	</select>

<? }else{
	echo '<input name="evaluationType" id="evaluationType" class="disabled_inputbox" readonly value="'.$arryProduct[0]['evaluationType'].'">';
} ?>



	</td>
	</tr-->

	<?php }?>

	
	<tr <?=$dis?>>
	<td  align="right"   class="blackbold" >Unit Measure: </td>
	<td  align="left">
	<!--<input  name="UnitMeasure" id="UnitMeasure" value="<? echo stripslashes($arryProduct[0]['UnitMeasure']); ?>" type="text" class="inputbox"   maxlength="100" />-->


	<select name="UnitMeasure" id="UnitMeasure" class="inputbox">
	<option value="">Select Unit Measure</option>
	<? for ($i = 0; $i < sizeof($arryUnit); $i++) { ?>
	<option value="<?= $arryUnit[$i]['attribute_value'] ?>" <? if ($arryUnit[$i]['attribute_value'] == $arryProduct[0]['UnitMeasure']){         echo "selected";} ?>>  <?= $arryUnit[$i]['attribute_value'] ?></option>
	<? } ?>
	</select>
	</td>

	</tr>

<tr <?=$dis?>>
		<td  align="right"   class="blackbold">Reorder Level : </td>
		<td  align="left">
		<!--input  name="ReorderLevel" id="ReorderLevel" value="<? echo stripslashes($arryProduct[0]['ReorderLevel']); ?>" type="text" class="inputbox"  size="30" maxlength="40" /-->	

<select name="ReorderLevel" id="ReorderLevel" class="inputbox">
		<option value="">Select Reorder Method</option>
		<? for($i=0;$i<sizeof($arryReorder);$i++) {?>
		<option value="<?=$arryReorder[$i]['attribute_value']?>" <?  if($arryReorder[$i]['attribute_value']==$arryProduct[0]['ReorderLevel']){echo "selected";}?>><?=$arryReorder[$i]['attribute_value']?></option> 
		<? } ?> 								 
		</select>

<span id="showreordertext" <?=$reorderDisplay?>><input  name="Reorderlabelbox" id="Reorderlabelbox" value="<? echo stripslashes($arryProduct[0]['Reorderlabelbox']); ?>" type="text" class="inputbox"  size="30" maxlength="100" /></span>

</td>
		</tr>

<tr id="showReorder" <?=$dis?> <?=$reorderDisplay?>>
	<td  align="right" valign="top"   class="blackbold" >Condition :  </td>
	<td   align="left">
	<select name="Condition[]" id="Condition" multiple="multiple" size="10" class="inputbox" style="width:200px">
	<option value="">Select Condition</option>
	<?


?>
 
<?=$ConditionDrop?>								 
	</select>
	</td>
	</tr>

<?=$WorkOrder?>
<!--tr id="showReorder" style="display:none;">
<td colspan="2" align="right" >
<div id="showReorder" <?=$displayReorder?>>
<table width="100%"   border="0" cellpadding="0" cellspacing="0" >
	<tr>
	<td  align="right" width="37%"  class="blackbold">Min Stock Alert Level : </td>
	<td align="left">
	<input  name="min_stock_alert_level" id="min_stock_alert_level" value="<? echo stripslashes($arryProduct[0]['min_stock_alert_level']); ?>" type="text" class="inputbox"   maxlength="40" />	</td>
	</tr>

	<tr>
	<td  align="right"   class="blackbold">Max Stock Alert Level : </td>
	<td align="left">
	<input  name="max_stock_alert_level" id="max_stock_alert_level" value="<? echo stripslashes($arryProduct[0]['max_stock_alert_level']); ?>" type="text" class="inputbox"   maxlength="40" />	</td>
	</tr>
</table>
</div>
</td>
		</tr-->
	<tr style="display:none;">
	<td  align="right"  class="blackbold" >Insurance Policy :</td>
	<td   ><input name="insurance_policy" type="text" class="inputbox" id="insurance_policy" value="<? if(isset($arryProduct[0]['insurance_policy'])) echo $arryProduct[0]['insurance_policy']; ?>"  size="10" maxlength="10"></td>
	</tr>
<!--tr>
               <td  align="right" class="blackbold">Taxable  :</td>
               <td   align="left">

<input type="checkbox" name="Taxable" id="Taxable" value="Yes" <?  if($arryProduct[0]['Taxable']=='Yes'){echo "checked";}?>>
       
               </td>
</tr-->
	
	

</table></div>
</td>
</tr>


<tr>
	<td  align="right"   class="blackbold" >Purchase Tax Rate :  </td>
	<td  align="left">
<? if ($arryProduct[0]['purchase_tax_rate']=='Yes') { $NoTaxPur ='';	$YesTaxPur = "selected";}else{ $NoTaxPur = "selected"; $YesTaxPur =''; } ?>
	<select name="purchase_tax_rate" id="purchase_tax_rate" class="inputbox">
<option value="Yes" <?=$YesTaxPur?> >Yes </option>
<option value="No" <?=$NoTaxPur?>>No</option>
	
	

	</select>
	</td>
	</tr>


<tr>
	<td  align="right"   class="blackbold" >Sale Tax Rate :  </td>
	<td  align="left">
	<? if ($arryProduct[0]['sale_tax_rate']=='Yes') {$NoTaxSel='';	$YesTaxSel = "selected";}else{ $NoTaxSel = "selected";  $YesTaxSel=''; } ?>
<select name="sale_tax_rate" id="sale_tax_rate" class="inputbox">
	<option value="Yes" <?=$YesTaxSel?>>Yes </option>
<option value="No" <?=$NoTaxSel?>>No</option>
	
	</select>
	</td>
	</tr>

	<tr style="display:none4564;">
	<td align="right"   class="blackbold">Status : </td>
	<td align="left"><span class="blacknormal">
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
	<td colspan="2" align="left" class="head">Image  </td>
	</tr>

	

	<tr style="display:none56456;">
	<td   align="right" valign="top"   class="blackbold"> Item Image :</td>
	<td   align="left" valign="top" >


	<input name="Image" type="file" class="inputbox" id="Image"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	<br>
	<?= $MSG[201] ?>		</td>
	</tr>

<tr><td ></td >
<td >
		
<? 	
if(IsFileExist($Config['Items'],$arryProduct[0]['Image'])){
$OldImage = $arryProduct[0]['Image'];
?>

<input type="hidden" name="OldImage" value="<?=$OldImage?>">
<span id="DeleteSpan">
<?php
	$PreviewArray['Folder'] = $Config['Items'];
	$PreviewArray['FileName'] = $arryProduct[0]['Image']; 
	$PreviewArray['NoImage'] = $Prefix."images/no.jpg";
	$PreviewArray['FileTitle'] = stripslashes($arryProduct[0]['Sku']);
	$PreviewArray['Width'] = "120";
	$PreviewArray['Height'] = "120";
	$PreviewArray['Link'] = "1";
	echo '<br><div id="ImageDiv">'.PreviewImage($PreviewArray).'
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:RemoveFile(\''.$Config['Items'].'\',\''.$arryProduct[0]['Image'].'\',\'ImageDiv\')">'.$delete.'</a><input type="hidden" name="OldImage" value="'.$OldImage.'"></div>';

?>

</span>

<? } ?>
<script language="JavaScript1.2" type="text/javascript">
 //Getcheckbox(0);
//SelectGeneration();
</script>
	</td>
</tr>




	<?php } ?>

	



	
<? 
if ($_GET["tab"] == "alterimages") { include("includes/html/box/alternete_images.php");} 
if ($_GET["tab"] == "Price") { include("includes/html/box/inv_price.php");} 
if ($_GET["tab"] == "Quantity") { include("includes/html/box/quantity.php");} 
if ($_GET["tab"] == "Supplier") { include("includes/html/box/vendor.php");} 
if ($_GET["tab"] == "Dimensions") { include("includes/html/box/Dimensions.php");} 
if($_GET['tab'] == 'binlocation'){ include("includes/html/box/binLocation.php");}
if($_GET['tab'] == 'Alias'){ include("includes/html/box/alias.php");}
if ($_GET["tab"] == "Transaction") { $ItemSku = isset($arryProduct[0]['Sku']) ? $arryProduct[0]['Sku'] : ''; include("includes/html/box/item_transaction.php"); } 
if($_GET['tab'] == 'Component'){ include("includes/html/box/component.php");}
if ($_GET["tab"] == "viewattributes") {  include("includes/html/box/AttributeDetail.php");}
if ($_GET["tab"] == "addattributes") {  include("includes/html/box/addAttributeDetail.php");}
if ($_GET["tab"] == "editattributes") {  include("includes/html/box/editAttributeDetail.php");}

?>
<? if($_REQUEST['tab'] == "Variant"){ ?>

<tr>
	<td colspan="2" align="left">
<table <?=$table_bg?>>
    <tr align="left"  >
      <td width="15%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','ID','<?=sizeof($GetVariantList)?>');" /></td>
     <td class="head1" >Variant Name</td>
    
       
    </tr>
   
    <?php 
  if(is_array($GetVariantList) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($GetVariantList as $key=>$values){
	$flag=!$flag;
	$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
	$Line++;
	if (in_array($values['id'], $varient))  {
			$checked ="checked";
			}else{
			$checked ="";
			}
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td>
        <input type="checkbox" name="ID[]" id="ID<?=$Line?>" <?php echo $checked;?> value="<?=$values['id']?>" variantname="<?=$values["variant_name"]?>" varianttypeID="<?=$values["variant_type_id"]?>" />
        
	<!--<a href="Javascript:void(0)" onMouseover="ddrivetip('<?=CLICK_TO_SELECT?>', '','')"; onMouseout="hideddrivetip()" onclick="Javascript:SetCustCode('<?=$values["CustCode"]?>','<?=$values["Cid"]?>','<?=$_GET['creditnote']?>');"><?=$values["CustCode"]?></a>-->
	</td>
    <td><?=$values["variant_name"]?></td>
   
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record">No record found</td>
    </tr>
    <?php } ?>
  
	
  </table>
</td>
</tr>	
<!--tr>
	<td colspan="2" align="left">
<? 
$ItemID = $_GET['edit'];
//include("includes/html/box/Variant.php");
?>
</td>
</tr-->	
<? } ?>

<? if($_REQUEST['tab'] == "Required"){ ?>
<tr>
	<td colspan="2" align="left" class="head">Required Items </td>
</tr>	
<tr>
	<td colspan="2" align="left">
<? 
$ItemID = $_GET['edit'];
include("includes/html/box/required_items.php");
?>
</td>
</tr>	
<? } ?>
 

	

 
	</table>
	</td>
	</tr>
<?
if ($_GET['edit'] > 0) {
	if ($_GET['tab'] == "Price" ) {
		$ButtonID = 'UpdatePrice';
		$ButtonTitle = 'Update';
	} elseif ($_GET['tab'] == "basic") {
		$ButtonID = 'UpdateBasic';
		$ButtonTitle = 'Update';
	} elseif ($_GET['tab'] == "discount" || $_GET['tab'] == "editDiscount") {
		$ButtonID = 'UpdateDiscount';
		$ButtonTitle = 'Save';
	} elseif ($_GET['tab'] == "other") {
		$ButtonID = 'UpdateOther';
		$ButtonTitle = 'Update';
	} elseif ($_GET['tab'] == "inventory") {
		$ButtonID = 'UpdateInventory';
		$ButtonTitle = 'Save';
	}elseif ($_GET['tab'] == "alterimages") {
	       $ButtonTitle = 'Update';
	       $disabled = 'style="display:none;"';
	} elseif ($_GET['tab'] == "Transaction"){
	      $disabled = 'style="display:none;"';
	} elseif ($_GET['tab'] == "Alias"){
	     $disabled = 'style="display:none;"';
	}elseif ($_GET['tab'] == "binlocation"){
	     $disabled = 'style="display:none;"';	
	}else {
		$ButtonID = 'btn';
		$ButtonTitle = 'Update';
	}
} else {
$ButtonTitle = 'Submit';
}

	$PostedByID = (!empty($arryProduct[0]['PostedByID'])?($arryProduct[0]['PostedByID']):("1"));
	 

	if (sizeof($arryCategory) <= 0)
	$DisabledButton = 'disabled';
	?>
	<tr <?=$disabled?>>
	<td  align="center">
	
	
	
	<input name="Submit" type="submit" class="button" id="<?= $ButtonID; ?>" value=" <?= $ButtonTitle ?> "  />


	<input type="hidden" name="ItemID" id="ItemID" value="<? echo $_GET['edit']; ?>" />

	<input  name="item_Sku" id="item_Sku" value="<? echo stripslashes($arryProduct[0]['Sku']); ?>" type="hidden"/>
<input  name="category" id="category" value="<? $CategoryID= isset($arryProduct[0]['CategoryID']) ? $arryProduct[0]['CategoryID'] : ''; echo stripslashes($CategoryID); ?>" type="hidden"/>
	<input type="hidden" name="MaxProductImage" id="MaxProductImage" value="<? echo $MaxProductImage; ?>" />


	</td>
	</tr>

	
	</table>
	</form>
	</div>

	<? if ($_GET['tab'] == "alterimages") {
	include("includes/html/box/addimage_form.php");
	} ?>
