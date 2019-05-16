

<script language="JavaScript1.2" type="text/javascript">


function SendEventExistRequest(Url){
		var SendUrl = Url+"&r="+Math.random(); 
		httpObj.open("GET", SendUrl, true);
		httpObj.onreadystatechange = function RecieveEventRequest(){
			if (httpObj.readyState == 4) {

				
				if(httpObj.responseText==1) {
				
					alert("Warehouse code already exists in database. Please enter another.");
					document.getElementById("warehouse_code").select();
					return false;
				} else if(httpObj.responseText==2) {	 
					alert("Warehouse name already exists in database. Please enter another.");
					document.getElementById("warehouse_name").select();
					return false;
				} else if(httpObj.responseText==0) {	 
					document.forms[0].submit();
				}else {
					alert("Error occur : " + httpObj.responseText);
					return false;
				}
			}
		};
		httpObj.send(null);
	}

function validateLead(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.warehouse_code,"Uniqe Warehouse Code")
		&&ValidateForSimpleBlank(frm.warehouse_name, "Warehouse Name")
		&& ValidateForTextareaMand(frm.Address,"Street Address",10,300)
		&& ValidateForSelect(frm.country_id,"Country")
		&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		//&& ValidateForTextareaMand(frm.description,"description",10,300)
		//&& ValidateForSimpleBlank(frm.description,"description")
		
		
		){
			
					
					
				
                  var Url = "isRecordExists.php?warehouse_code="+escape(document.getElementById("warehouse_code").value)+"&warehouse_name="+escape(document.getElementById("warehouse_name").value)+"&editID="+document.getElementById("WID").value+"&Type=Warehouse";
				  //alert(Url);
					SendEventExistRequest(Url);
		  	
		      return false;
				
					
			}else{
					return false;	
			}	

		
}


function ltype(){

 
 var opt = document.getElementById('type').value;

if(opt=="Company"){
    document.getElementById('com').style.display = 'block';
	}else{
	document.getElementById('com').style.display = 'none';
	document.getElementById('company').value = '';
  
 }
    
    
}



</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateLead(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Warehouse Details</td>
</tr>

<tr>
        <td  align="right"   class="blackbold" width="40%"> Warehouse Code  :<span class="red">*</span> </td>
        <td   align="left" >
		
     <input name="warehouse_code" type="text" class="inputbox" id="warehouse_code" value="<?php echo stripslashes($arryWarehouse[0]['warehouse_code']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');" onBlur="Javascript:CheckAvailField('MsgSpan_Display','warehouse_code','<?=$_GET['edit']?>');"/>

<span id="MsgSpan_Display"></span>
           </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Warehouse Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="warehouse_name" type="text" class="inputbox" id="warehouse_name" value="<?php echo stripslashes($arryWarehouse[0]['warehouse_name']); ?>"  maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Bin Location  : </td>
        <td   align="left" >
<input name="BinLocation" type="text" class="inputbox" id="BinLocation" value="<?php echo stripslashes($arryWarehouse[0]['ContactName']); ?>"  maxlength="50" />            </td>
      </tr>

	 
 </table>	
  




	
	  
	

   <tr>
	<td align="left" valign="top">&nbsp;
	
</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="WID" id="WID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryWarehouse[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryWarehouse[0]['city_id']; ?>" />




</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	//ShowPermission();
</SCRIPT>
