

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
		<?php echo stripslashes($arryWarehouse[0]['warehouse_code']); ?>
           </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Warehouse Name  :<span class="red">*</span> </td>
        <td   align="left" >
<?php echo stripslashes($arryWarehouse[0]['warehouse_name']); ?>            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Contact Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryWarehouse[0]['ContactName']); ?>            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Phone Number : </td>
        <td   align="left" >
<?php echo stripslashes($arryWarehouse[0]['phone_number']); ?>            </td>
      </tr>
      <tr>
        <td  align="right"   class="blackbold"> Mobile Number : </td>
        <td   align="left" >
<?php echo stripslashes($arryWarehouse[0]['mobile_number']); ?>           </td>
      </tr>
      <? if($arryWarehouse[0]['Default']==1){?>
 <tr>
        <td  align="right"   class="blackbold"> Default Warehouse : </td>
        <td   align="left" >
 <? if($arryWarehouse[0]['Default']==1){echo "Default";}?>          </td>
      </tr>
<? }?>
   
	  
 <tr>




	<tr>
       		 <td colspan="2" align="left"   class="head">Address Details</td>
        </tr>
   
	  
	  
	  
       <tr>
          <td align="right"   class="blackbold" valign="top">Street Address :<span class="red">*</span></td>
          <td  align="left" >
            <?=stripslashes($arryWarehouse[0]['Address'])?>		          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryWarehouse[0]['country_id'] != ''){
		$CountrySelected = $arryWarehouse[0]['country_id']; 
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
             <option value="" >-- Select Country --</option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
     <? if($arryWarehouse[0]['OtherState'] != ''){?>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><?php echo $arryWarehouse[0]['OtherState']; ?> </div>           </td>
      </tr>
      <? }?>
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
       <? if($arryWarehouse[0]['OtherCity'] != ''){?>
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><?php echo $arryWarehouse[0]['OtherCity']; ?>  </div>          </td>
      </tr>
	   <? }?>
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <?=stripslashes($arryWarehouse[0]['ZipCode'])?>		</td>
      </tr>
	  
     
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryWarehouse[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryWarehouse[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>
	  


           <tr>
       		 <td colspan="2" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>

          <td  align="left" >
          <?php echo stripslashes($arryWarehouse[0]['description']); ?>
                      </td>
        </tr>
         
	
</table>	
  




	
	  
	
	</td>
   </tr>

   <tr>
	<td align="left" valign="top">&nbsp;
	
</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none">
	
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