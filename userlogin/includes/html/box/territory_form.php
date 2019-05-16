<? 
if($Config['SalesCommission']==1){
	
	$_GET['AssignTo'] = $EmpID;
	$arryTerritoryAssign = $objTerritory->GetTerritoryAssign($_GET); 
?>
<script language="JavaScript1.2" type="text/javascript">



function validate_territory(frm){

	if(ValidateForSelect(frm.TerritoryID, "Territory")
	){	
		if(document.getElementById("TerritoryID").value != "None"){
			if(!ValidateForSelect(frm.AssignType, "Assign Type")){
				return false;	
			}
		}

		
		if(document.getElementById("ManagerID") != null){
			document.getElementById("MainManagerID").value = document.getElementById("ManagerID").value;

			if(document.getElementById("MainManagerID").value == ''){
				alert("Please Select Manager.");
				return false;	
			}

		}else{
			document.getElementById("MainManagerID").value='0';
		}



		
		ShowHideLoader('1','S');
		return true;		
	}else{
		return false;	
	}
		
}




function ShowManager(){

	var TerritoryIDVal = $("#TerritoryID option:selected").map(function(){ return this.value }).get().join(",");
	

	//if(document.getElementById("TerritoryID").value>0 && document.getElementById("AssignType").value=='Sales Person'){
	if(TerritoryIDVal!='' && document.getElementById("AssignType").value=='Sales Person'){	
		$("#ManagerDiv").show();
		$("#ManagerVal").show();
		$("#ManagerVal").html('<img src="../images/loading.gif">');
		var SendUrl = "&action=GetTerritoryManager&TerritoryID="+escape(TerritoryIDVal)+"&EmpID="+escape(document.getElementById("EmpID").value)+"&OldManagerID="+escape(document.getElementById("MainManagerID").value)+"&r="+Math.random();

	   	$.ajax({
		type: "GET",
		url: "../ajax.php",
		data: SendUrl,
		success: function (responseText) {			
			$("#ManagerVal").html(responseText);
		   
		}

	   	});
	}else{

		$("#ManagerVal").html("");
		$("#ManagerDiv").hide();
		$("#ManagerVal").hide();
	}

}


</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validate_territory(this);" enctype="multipart/form-data">
  <? if (!empty($_SESSION['mess_user'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_user'])) {echo $_SESSION['mess_user']; unset($_SESSION['mess_user']); }?>	
</td>
</tr>
<? } ?>

   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">

 <tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>

<tr>
       		 <td colspan="2" height="20">&nbsp;</td>
        </tr>	



<tr>
	<td  align="right" class="blackbold" width="45%" valign="top">Territory :<span class="red">*</span></td>
	<td align="left">

	<!--select name="TerritoryID" id="TerritoryID" class="inputbox" onchange="Javascript:ShowManager();">
	<option value="">--- Select ---</option>
	  <?php $objTerritory->getTerritoryOption(0,0,$arryTerritoryAssign[0]['TerritoryID']);?>
	<option value="None">--- None ---</option>
	</select-->

	<select name="TerritoryID[]" class="inputbox" id="TerritoryID" multiple style="height:150px;" onchange="Javascript:ShowManager();">
		
		<?php $objTerritory->getTerritoryOptionMulti(0,0,$arryTerritoryAssign[0]['TerritoryID']);?>
		<option value="None">--- None ---</option>
	<select>


	</td>
  </tr>	 

<tr>
        <td align="right" class="blackbold" valign="top">
		Assign Type  :<span class="red">*</span></td>
    <td align="left" valign="top" >
<select name="AssignType" id="AssignType" class="inputbox" onchange="Javascript:ShowManager();">
	<option value="">--- Select ---</option>
     <option value="Manager" <? if($arryTerritoryAssign[0]['AssignType'] == "Manager") echo 'selected';?>> Manager </option>
        <option value="Sales Person" <? if($arryTerritoryAssign[0]['AssignType'] == "Sales Person") echo 'selected';?>> Sales Person </option>
       
 </select>   	

	</td>
  </tr>	



<tr>
<td align="right"   class="blackbold"><div id="ManagerDiv">Manager :<span class="red">*</span></div> </td>
<td  align="left">   
	<div id="ManagerVal"></div>
	<input type="hidden" name="MainManagerID" id="MainManagerID" value="<?=$arryTerritoryAssign[0]['ManagerID']?>">
</td>
</tr>	

 
<tr>
       		 <td colspan="2" height="20">&nbsp;</td>
        </tr>	
	 
       
	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<script language="JavaScript1.2" type="text/javascript">
ShowManager();
</script>

<? } ?>

