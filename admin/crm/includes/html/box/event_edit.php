<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">
function validate_lead(frm){
	if( ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		//&& ValidateRadioButtons(frm.Gender, "Gender")
		//&& ValidateForSelect(frm.date_of_birth,"Date of Birth")
		//&& ValidateOptionalUpload(frm.Image, "Image")
		){
			return true;	
		}else{
			return false;	
		}	
}

function validate_Edit(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSelect(frm.type,"Lead Type")
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSelect(frm.AssignTo,"Assign To")
		&& ValidateForTextareaMand(frm.street_address,"Street Address",10,300)
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		){
		
			if(Trim(frm.Landline1).value == '' && Trim(frm.Landline2).value == '' && Trim(frm.Landline3).value == ''){
						//alert("ok");
			}else if(Trim(frm.Landline1).value == '' || Trim(frm.Landline2).value == '' || Trim(frm.Landline3).value == ''){
				alert("Please Enter Complete Landline Number.");
				return false;
			}		
		
			return true;	
		}else{
			return false;	
		}	
}


function validate_education(frm){
	if( ValidateForSelect(frm.Graduation,"Graduation")
		){
			return true;	
		}else{
			return false;	
		}	
}








</script>



   
<div class="left_box">
&nbsp
	<!--<p <?=($_GET['tab']=="Summary")?("class='active'"):("");?>><a href="<?=$EditUrl?>Summary">Lead Summary</a></p>-->
	<!--<p <?=($_GET['tab']=="Comments")?("class='active'"):("");?>><a href="<?=$EditUrl?>Comments">Comments</a></p>-->
	<!--<p <?=($_GET['tab']=="Activity")?("class='active'"):("");?>><a href="<?=$EditUrl?>Activity">Activity</a></p>-->
	<!--<p <?=($_GET['tab']=="Documents")?("class='active'"):("");?>><a href="<?=$EditUrl?>Documents">Documents</a></p>-->
	<!--<p <?=($_GET['tab']=="Convert")?("class='active'"):("");?>><a class="fancybox" href="#Convert_div" >Convert Lead</a></p>-->
	
</div>	



<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_Edit(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_lead'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_lead'])) {echo $_SESSION['mess_lead']; unset($_SESSION['mess_lead']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="2" align="left" class="head">Lead Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> Type  :<span class="red">*</span> </td>
        <td   align="left" >
		 <select name="type" class="inputbox" id="type" >
		<option value="">--- Select ---</option>
		
			<option value="Individual" <?  if($arryLead[0]['type']=='Individual'){echo "selected";}?>>Individual</option>
			<option value="Company" <?  if($arryLead[0]['type']=='Company'){echo "selected";}?>>Company</option>
	

		 </select>
           </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryLead[0]['FirstName']); ?>"  maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryLead[0]['LastName']); ?>"  maxlength="50" />            </td>
      </tr>
	

 <tr>
        <td  align="right"   class="blackbold"> Primary Email : </td>
        <td   align="left" >
<input name="primary_email" type="text" class="inputbox" id="primary_email" value="<?php echo stripslashes($arryLead[0]['primary_email']); ?>"  maxlength="50" />            </td>
      </tr>
	   <tr>
        <td  align="right"   class="blackbold"> Product : </td>
        <td   align="left" >
<input name="ProductID" type="text" class="inputbox" id="ProductID" value="<?php echo stripslashes($arryLead[0]['ProductID']); ?>"  maxlength="50" />            </td>
      </tr>

   <tr>
        <td  align="right"   class="blackbold"> Price  ($):</td>
        <td   align="left" >
<input name="product_price" type="text" class="inputbox" id="product_price" value="<?php echo stripslashes($arryLead[0]['product_price']); ?>"  maxlength="50" />            </td>
      </tr>
	     <tr>
        <td  align="right"   class="blackbold"> Company  : </td>
        <td   align="left" >
<input name="company" type="text" class="inputbox" id="company" value="<?php echo stripslashes($arryLead[0]['company']); ?>"  maxlength="50" />            </td>
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> Website : </td>
        <td   align="left" >
<input name="Website" type="text" class="inputbox" id="Website" value="<?php echo stripslashes($arryLead[0]['Website']); ?>"  maxlength="50" />            </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Designation : </td>
        <td   align="left" >
<input name="designation" type="text" class="inputbox" id="designation" value="<?php echo stripslashes($arryLead[0]['designation']); ?>"  maxlength="50" />            </td>
      </tr>
	  
	 <!--  <tr>
        <td  align="right"   > Date of Birth : <span class="red">*</span> </td>
        <td   align="left" >
		
<script type="text/javascript">
$(function() {
	$('#date_of_birth').datepick(
		{
		dateFormat: 'yyyy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		defaultDate: '<?=$arryLead[0]['date_of_birth']?>'
		}
	);
});
</script>
<input id="date_of_birth" name="date_of_birth" readonly="" class="disabled" size="10" value="<?=$arryLead[0]['date_of_birth']?>"  type="text" >         </td>
      </tr> -->

  <tr>
        <td  align="right"   class="blackbold"> Industry  : </td>
        <td   align="left" >
		
            <select name="Industry" class="inputbox" id="Industry" >
			<option value="">--- Select ---</option>
			<option value="Apparel" <?  if($arryLead[0]['Industry']=="Apparel"){echo "selected";}?> >Apparel</option>
			<option  value="Hospitaoptionty" <?  if($arryLead[0]['Industry']=="Hospitaoptionty"){echo "selected";}?> >Hospitaoptionty</option>
			<option  value="Insurance" <?  if($arryLead[0]['Industry']=="Insurance"){echo "selected";}?> >Insurance</option>
			<option  value="Machinery" <?  if($arryLead[0]['Industry']=="Machinery"){echo "selected";}?> >Machinery</option>
			<option  value="Manufacturing" <?  if($arryLead[0]['Industry']=="Manufacturing"){echo "selected";}?> >Manufacturing</option>
			<option  value="Media" <?  if($arryLead[0]['Industry']=="Media"){echo "selected";}?> >Media</option>
			<option  value="Recreation" <?  if($arryLead[0]['Industry']=="Recreation"){echo "selected";}?> >Recreation</option>
			<option  value="Retail" <?  if($arryLead[0]['Industry']=="Retail"){echo "selected";}?> >Retail</option>
			<option  value="Shipping"  <?  if($arryLead[0]['Industry']=="Shipping"){echo "selected";}?>>Shipping</option>
			<option  value="Technology" <?  if($arryLead[0]['Industry']=="Technology"){echo "selected";}?> >Technology</option>
			<option  value="Telecommunications" <?  if($arryLead[0]['Industry']=="Telecommunications"){echo "selected";}?> >Telecommunications</option>
			<option  value="Finance" <?  if($arryLead[0]['Industry']=="Finance"){echo "selected";}?> >Finance</option>
			<option  value="Other" <?  if($arryLead[0]['Industry']=="Other"){echo "selected";}?> >Other</li>
            
            </select> </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Annual Revenue : </td>
        <td   align="left" >
<input name="AnnualRevenue" type="text" class="inputbox" id="AnnualRevenue" value="<?php echo stripslashes($arryLead[0]['AnnualRevenue']); ?>"  maxlength="50" />            </td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> Lead Source  : </td>
        <td   align="left" >
		
              <select name="lead_source" class="inputbox" id="lead_source" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryLeadSource);$i++) {?>
			<option value="<?=$arryLeadSource[$i]['attribute_value']?>" <?  if($arryLeadSource[$i]['attribute_value']==$arryLead[0]['lead_source']){echo "selected";}?>>
			<?=$arryLeadSource[$i]['attribute_value']?>
			</option>
		<? } ?></select>
		</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">  Assigned To  :<span class="red">*</span> </td>
        <td   align="left" >
		 <? if($HideSibmit!=1){?>
               <select name="AssignTo" class="inputbox" id="AssignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryLead[0]['AssignTo']){echo "selected";}?>>
							<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)
							</option>
						<? } ?>
					</select>
					
					<? }else{ 
						$HideSibmit = 1;
					?>
					<div class="redmsg">No employee exist.</div>
					<? } ?>
             </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Lead Status  : </td>
        <td   align="left" >
		
            <select name="lead_status" class="inputbox" id="lead_status" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryLeadStatus);$i++) {?>
			<option value="<?=$arryLeadStatus[$i]['attribute_value']?>" <?  if($arryLeadStatus[$i]['attribute_value']==$arryLead[0]['lead_status']){echo "selected";}?>>
			<?=$arryLeadStatus[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select> 	   </td>
      </tr>
	  
 <tr>



	
	<tr>
       		 <td colspan="2" align="left"   class="head">Address Details</td>
        </tr>
   
	  
	  
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Street Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryLead[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?
	if($arryLead[0]['country_id'] != ''){
		$CountrySelected = $arryLead[0]['country_id']; 
	}else{
		$CountrySelected = 106;
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
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
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryEmployee[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryEmployee[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryLead[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryLead[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
		<?
		if(!empty($arryLead[0]['LandlineNumber'])){
			$LandArray = explode(" ",$arryLead[0]['LandlineNumber']);
	    }
		?>
		<input name="Landline1" type="text" class="textbox" id="Landline1" value="<?=$LandArray[0]?>" size="3" maxlength="4" />&nbsp;&nbsp;
		<input name="Landline2" type="text" class="textbox" id="Landline2" value="<?=$LandArray[1]?>" size="3" maxlength="4" />&nbsp;&nbsp;
		<input name="Landline3" type="text" class="textbox" id="Landline3" value="<?=$LandArray[2]?>" size="8" maxlength="8" />		</td>
      </tr>







	<tr>
       		 <td colspan="2" align="left"   class="head">Description Details</td>
        </tr>	
	
	
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top">Description :<span class="red">*</span></td>
          <td  align="left" >
            <Textarea name="description" id="description" class="inputbox"  ><? echo stripslashes($arryLead[0]['description']); ?></Textarea>

				<script type="text/javascript">

				var editorName = 'description';

				var editor = new ew_DHTMLEditor(editorName);

				editor.create = function() {
					var sBasePath = '../FCKeditor/';
					var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
					oFCKeditor.BasePath = sBasePath;
					oFCKeditor.ReplaceTextarea();
					this.active = true;
				}
				ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

				ew_CreateEditor(); 


				</script>			          </td>
        </tr>
 

 

	

	

</table>	



<script type="text/javascript">
$('#piGal table').bxGallery({
  maxwidth: 300,
  maxheight: 200,
  thumbwidth: 75,
  thumbcontainer: 300,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>


<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>



	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" <?=$dis?>>
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />




</div>
<input type="hidden" name="leadID" id="leadID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryLead[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryLead[0]['city_id']; ?>" />

</td>
   </tr>
   </form>
</table>
</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="Lead"){ ?>
	StateListSend();
<? } ?>
<? if($_GET["tab"]=="account"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>



