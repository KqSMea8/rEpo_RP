<?
$arrayIndustryType = $objConfig->GetIndustryType();


/********Connecting to main database*********/
$CmpDatabase = $Config['DbName']."_".$arryCompany[0]['DisplayName'];

$Config['DbName2'] = $CmpDatabase;
if(!$objConfig->connect_check()){
	echo $ErrorMsg = ERROR_NO_DB;exit;
}else{
	$Config['DbName'] = $CmpDatabase;
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
}
/*******************************************/

$NumPaymentTable = $objConfigure->NumPaymentTable();

if($NumPaymentTable>0){
	$ClassName = 'disabled_inputbox';
	$Disabled = 'Disabled';
	$DisablesMsg =  INDUSTRY_DISABLE_MSG;
}else{
	$ClassName = 'inputbox';
}

?>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_company'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >




<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

<tr>
       		 <td colspan="2" align="left" class="head">Inventory Settings</td>
        </tr>

<tr>
        <td  align="right"   class="blackbold" width="40%"
		>Track Inventory  : </td>
        <td   align="left"  >
          <? 
		
		 if(!empty($arryCompany[0]['TrackInventory'])) {$TrackChecked = 'checked'; $InTrackChecked = ''; }else {$TrackChecked = ''; $InTrackChecked ='checked';
		}
	  ?>
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="1" <?=$TrackChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="0" <?=$InTrackChecked?> />
          No</label> </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" 
		>Inventory Level  : </td>
        <td   align="left"  >
          <? 
		
		 if(!empty($arryCompany[0]['InventoryLevel'])) {$LevelChecked = 'checked'; $InLevelChecked = ''; }else {$LevelChecked = ''; $InLevelChecked ='checked';
		}
	  ?>
          <label><input type="radio" name="InventoryLevel" id="InventoryLevel" value="1" <?=$LevelChecked?> />
          Bin location based</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="InventoryLevel" id="InventoryLevel" value="0" <?=$InLevelChecked?> />
          Non Bin location based</label> </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" 
		>Display Global Attribute  : </td>
        <td   align="left"  >
          <? 
		
		 if(empty($arryCompany[0]['TrackVariant'])) {$TrackVariant = ''; $InTrackVariant = ' checked'; }else {$TrackVariant = ' checked'; $InTrackVariant ='';
		}
	  ?>
          <label><input type="radio" name="TrackVariant" id="TrackVariant" value="1" <?=$TrackVariant?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="TrackVariant" id="TrackVariant" value="0" <?=$InTrackVariant?> />
          No</label> </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" 
		>Sync Items : </td>
        <td   align="left"  >
	 <select id="sync_items" class="inputbox" name="sync_items">
		<option value="">Select</option>
		<option value="I2E" <?php if($arryCompany[0]['sync_items']=='I2E') { echo "selected";}?>>Inventory to E-Commerce</option>
		<option value="E2I" <?php if($arryCompany[0]['sync_items']=='E2I') { echo "selected";}?>>E-Commerce to Inventory</option>
		<option value="both" <?php if($arryCompany[0]['sync_items']=='both') { echo "selected";}?>>Both</option>
	</select>
</td>
      </tr>

<tr>
        <td align="right"   class="blackbold" >Sync Type </td>
        <td align="left">
        <?php $syncTypeArray=array('automatic'=>'Automatic','manual'=>'Manual');?>
        <select class="inputbox" name="sync_type" id="sync_type">
        <option value="">Select</option>
        <?php foreach($syncTypeArray as $key=>$val){
        	echo ' <option value="'.$key.'" ';
        	echo ($arryCompany[0]['sync_type']==$key)? 'selected':'';
        	echo '>'.$val.'</option>';
			}?>
       
        </select></td>
      </tr>

      <tr>
       		<td colspan="2" align="left" class="head">Company Type</td>
        </tr>
        
      <tr>
     
        
		<td align="right"   class="blackbold" >Industry: </td>
        <td align="left" >
        
        <?php $IndustryArray=array('1'=>'Standard','0'=>'Distribution');?>
        <select class="<?=$ClassName?>" <?=$Disabled?>  name="SelectOneItem" id="SelectOneItem" onchange="Javascript:GetIndustryType();">
      
        <?php foreach($IndustryArray as $key=>$val){
        	echo ' <option value="'.$key.'" ';
        	echo ($arryCompany[0]['SelectOneItem']==$key)? 'selected':'';
        	echo '>'.$val.'</option>';
			}?>
       
        </select>

	<?=$DisablesMsg?>
        </td>
		
      </tr>
      
 
	      <tr id="IndustryTr">
     
        
		<td align="right"   class="blackbold" >Industry Type: </td>
        <td align="left" >
        
	<select  class="<?=$ClassName?>" <?=$Disabled?> name="IndustryID" id="IndustryID">
		<option value="0" >--- None ---</option>
		<?php foreach($arrayIndustryType as $key=>$values){
		echo ' <option value="'.$values['IndustryID'].'" ';
		echo ($values['IndustryID']==$arryCompany[0]['IndustryID'])? 'selected':'';
		echo '>'.$values['IndustryName'].'</option>';
		}?>
		</select>

        </td>
		
      </tr>
	  
	

</table>

	
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	

      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" Update "  />


<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" readonly />

<input type="hidden" name="NumPaymentTable" id="NumPaymentTable" value="<?=$NumPaymentTable?>" readonly />



<input type="hidden" name="SelectOneItemOld" id="SelectOneItemOld" value="<?=$arryCompany[0]['SelectOneItem']?>" readonly />

<input type="hidden" name="IndustryIDOld" id="IndustryIDOld" value="<?=$arryCompany[0]['IndustryID']?>" readonly />

</div>

</td>
   </tr>
   </form>
</table>
<SCRIPT LANGUAGE=JAVASCRIPT>
function GetIndustryType(){
	var SelectOneItem = $('#SelectOneItem').val();
	if(SelectOneItem==1){
		$('#IndustryTr').show();		
	}else{
		$('#IndustryID').val(0);
		$('#IndustryTr').hide();
	}	
}
GetIndustryType();
</SCRIPT>



