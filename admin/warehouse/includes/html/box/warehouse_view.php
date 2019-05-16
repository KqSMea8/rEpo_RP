

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
	 <td colspan="4" align="left" class="head">Warehouse Details</td>
</tr>

<tr>
        <td  align="right"   class="blackbold" width="40%"> Warehouse Code  : </td>
        <td   align="left" >
		<?php echo stripslashes($arryWarehouse[0]['warehouse_code']); ?>
           </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Warehouse Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryWarehouse[0]['warehouse_name']); ?>            </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Contact Name  : </td>
        <td   align="left" >
<? if(!empty($arryWarehouse[0]['ContactName'])){?>
<?php echo stripslashes($arryWarehouse[0]['ContactName']); ?> 
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>
           </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Phone Number : </td>
        <td   align="left" >
<? if(!empty($arryWarehouse[0]['phone_number'])){?>
<?php echo stripslashes($arryWarehouse[0]['phone_number']); ?>
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>           </td>
 </tr>
      <tr>
        <td  align="right"   class="blackbold"> Mobile Number : </td>
        <td   align="left" >

<? if(!empty($arryWarehouse[0]['mobile_number'])){?>
<?php echo stripslashes($arryWarehouse[0]['mobile_number']); ?>
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>
           </td>
      </tr>
    

   
	  
<? /********Connecting to main database*********/
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		/*******************************************/
		if($arryWarehouse[0]['country_id']>0){
			$arryCountryName = $objRegion->GetCountryName($arryWarehouse[0]['country_id']);
			$CountryName = stripslashes($arryCountryName[0]["name"]);
		}

		if(!empty($arryWarehouse[0]['state_id'])) {
			$arryState = $objRegion->getStateName($arryWarehouse[0]['state_id']);
			$StateName = stripslashes($arryState[0]["name"]);
		}else if(!empty($arryEmployee[0]['OtherState'])){
			 $StateName = stripslashes($arryWarehouse[0]['OtherState']);
		}

		if(!empty($arryWarehouse[0]['city_id'])) {
			$arryCity = $objRegion->getCityName($arryWarehouse[0]['city_id']);
			$CityName = stripslashes($arryCity[0]["name"]);
		}else if(!empty($arryWarehouse[0]['OtherCity'])){
			 $CityName = stripslashes($arryWarehouse[0]['OtherCity']);
		}

?>




	<tr>
       		 <td colspan="4" align="left"   class="head">Address Details</td>
        </tr>
   
	  
	  
	  
       <tr>
          <td align="right"   class="blackbold" valign="top">Street Address :</td>
          <td  align="left" >
            <?=stripslashes($arryWarehouse[0]['Address'])?>		          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
	<? echo $CountryName;?>
            
             
           
                  </td>
      </tr>

  <? if($StateName != ''){?>
     <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal"><? echo $StateName;?></td>
	</tr>
     <? } if($arryWarehouse[0]['OtherState'] != ''){?>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><? echo $StateName;?>           </td>
      </tr>
      <? }?>
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><? echo $CityName;?></td>
      </tr> 
       <? if($arryWarehouse[0]['OtherCity'] != ''){?>
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><? echo $CityName;?>  </div>          </td>
      </tr>
	   <? }?>
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	 <?=stripslashes($arryWarehouse[0]['ZipCode'])?>		</td>
      </tr>
	  
     
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['view'] > 0){
				 if($arryWarehouse[0]['Status'] == 1) {echo "Active";}
				 else{echo "InActive";}
			}
		  ?>
         </td>
      </tr>
	  


           <tr>
       		 <td colspan="4" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>

          <td  align="left" >
<? if(!empty($arryWarehouse[0]['description'])){?>
<?php echo stripslashes($arryWarehouse[0]['description']); ?>
<? }else{?>

<?=NOT_SPECIFIED?>

<? }?>
          
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
