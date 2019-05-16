
<script>

function validateCob(frm){


	if( ValidateForSimpleBlank(frm.OpportunityName, "Opportunity Name")
		&& ValidateForSimpleBlank(frm.CloseDate, " Expected Close Date")
		&& ValidateForSimpleBlank(frm.CloseTime, " Expected Close Time")
		&& ValidateForSelect(frm.SalesStage,"Sales Stage")
		&& ValidateForSelect(frm.AssignTo,"Assign User")
		
		
		
		//&& ValidateForTextareaMand(frm.street_address,"Street Address",10,300)bs
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		
		
		){
		

					return true;
					
			}else{
					return false;	
			}	

		
}

 $(function() {
			$('#CloseTime').timepicker({ 'timeFormat': 'H:i:s' });
			$('#timeformatExample2').timepicker({ 'timeFormat': 'h:i A' });
		  });
</script>
<div id="Convert_div" style="display:none;" >
    <h2>Convert Lead : <?=$arryLead[0]['FirstName']?></h2>
	<div id="info" style="color:red;" align="center"></div>
    
    <? if($ModifyLabel==1){?>
<form name="topForm"  id="tpfrm" action="" onsubmit="return validateCob(this);" method="POST">

 
 <table width="500"   border="0" cellpadding="5" cellspacing="0" class="borderall">


  <tr>
	 <td colspan="2" class="head">Create Opportunity  </td>
</tr>
</table>

<div id="opp">
 <table width="500"   border="0" cellpadding="5" cellspacing="0" class="borderall">

 
<tr>
        <td  align="right"  > Opportunity Name  : <span class="red">*</span></td>
        <td  align="left" >
<input name="OpportunityName" type="text" class="inputbox"  id="OpportunityName" value=""  maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"  > Expected Close Date :<span class="red">*</span></td>
        <td  align="left" >
<script type="text/javascript">
$(function() {


	$('#CloseDate').datepicker(
		{
		
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>', 
		minDate: "-D", 
        changeMonth: true,
		changeYear: true
		}
	);
});
</script>


<input id="CloseDate" name="CloseDate"  class="disabled" palceholder="Close Date"    size="15" value=""  type="date" >    <input type="text" name="CloseTime" size="10" class="disabled time" id="CloseTime"  value="" placeholder="Close Time"/>             </td>
      </tr>
	   <tr>
        <td  align="right"   > Sales Stage  :<span class="red">*</span> </td>
        <td align="left"  >

		  <select name="SalesStage"  class="inputbox" id="SalesStage" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arrySalesStage);$i++) {?>
			<option value="<?=$arrySalesStage[$i]['attribute_value']?>" <?  if($arrySalesStage[$i]['attribute_value']==$arryLead[0]['lead_source']){echo "selected";}?>>
			<?=$arrySalesStage[$i]['attribute_value']?>
			</option>
		<? } ?></select>           </td>
      </tr>
	   <tr>
        <td align="right"   > AssignTo  : <span class="red">*</span></td>
        <td align="left"  >


   <? if($HideSibmit!=1){?>
               <select name="AssignTo"  class="inputbox" id="AssignTo" >
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
		
     
		
	
                
                </table>
				</div>
<br />
				 <div align="center">
                  <input name="Status" id="Status" type="hidden"   value="1"   />
				 <input name="lead_source" id="lead_source" type="hidden"   value="<?php echo $arryLead[0]['lead_source']; ?>"   />
				 <input name="LeadID" id="LeadID" type="hidden"   value="<?php echo $_GET['view']; ?>"   /> 
				 <input name="ContinueButton" type="submit" class="button" id="ContinueButton"  value="Continue &raquo;"   /></div>
	</form>
    <? } else{?>
    <div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
    <? }?>
	
</div>	


