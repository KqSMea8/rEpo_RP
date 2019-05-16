
<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>

<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />

 

<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateOpp(frm){

	

	if( ValidateForSimpleBlank(frm.OpportunityName, "Opportunity Name")
		&& ValidateForSelect(frm.CloseDate, "Expected Close Date")
		&& ValidateForSelect(frm.CloseTime, "Close Time")
		&& ValidateForSelect(frm.SalesStage, "Sales Stage")
		//&& ValidateForSelect(frm.AssignTo,"Assign To")
		&& ValidateForSelect(frm.lead_source,"Lead Source")
		
		
		
		){
		
                  var Url = "isRecordExists.php?OpportunityName="+escape(document.getElementById("OpportunityName").value)+"&editID="+document.getElementById("OpportunityID").value+"&Type=Opportunity";
					SendExistRequest(Url,"OpportunityName", "Opportunity Name");

					return false;	
					
			}else{
					return false;	
			}	

		
}
//$('#timepicker_start').timepicker({ 'timeFormat': 'H:i:s' });

 $(function() {
			$('#CloseTime').timepicker({ 'timeFormat': 'H:i:s' });
			$('#timeformatExample2').timepicker({ 'timeFormat': 'h:i A' });
		  });

</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateOpp(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Opprtunity Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" width="20%">Opportunity Name  :<span class="red">*</span> </td>
        <td width="20%"  align="left" width="25%">
<input name="OpportunityName" type="text" class="inputbox" id="OpportunityName" value="<?php //echo stripslashes($arryOpportunity[0]['OpportunityName']); ?>"  maxlength="50" />            </td>
      
        <td  align="right"   class="blackbold" width="20%"> Organization Name : </td>
        <td   align="left" >
<input name="OrgName" type="text" class="inputbox" id="OrgName" value="<?php //echo stripslashes($arryOpportunity[0]['OrgName']); ?>"  maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Amount (<?=$Config['Currency']?>) :</td>
        <td   align="left" >
<input name="Amount" type="text" class="inputbox" id="Amount" onkeypress="return isDecimalKey(event);" value="<?php //echo stripslashes($arryOpportunity[0]['Amount']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold">  Expected Close Date :<span class="red">*</span> </td>
        <td   align="left" >
				
<script type="text/javascript">
$(function() {
	$('#CloseDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>',
        changeMonth: true,
       changeYear: true
		}
	);
});
</script>
<input name="CloseDate" type="text" readonly="" class="datebox"  placeholder="Close Date" size="13" id="CloseDate" value="<?php //echo stripslashes($arryOpportunity[0]['CloseDate']); ?>"  maxlength="50" />  &nbsp;&nbsp; <input type="text" name="CloseTime" size="10" class="disabled time" id="CloseTime"  value="" placeholder="Close Time"/>        </td>
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> Sales Stage : <span class="red">*</span></td>
        <td   align="left" >
 <select name="SalesStage" class="inputbox" id="SalesStage" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arrySalesStage);$i++) {?>
			<option value="<?=$arrySalesStage[$i]['attribute_value']?>" <?php  //if($arrySalesStage[$i]['attribute_value']==$arryOpportunity[0]['SalesStage']){echo "selected";}?>>
			<?=$arrySalesStage[$i]['attribute_value']?>
			</option>
		<? } ?></select>            </td>
     
        <td  align="right"   class="blackbold"> Lead Source  :<span class="red">*</span> </td>
        <td   align="left" >
		
     <select name="lead_source" class="inputbox" id="lead_source" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryLeadSource);$i++) {?>
			<option value="<?=$arryLeadSource[$i]['attribute_value']?>" <?php  //if($arryLeadSource[$i]['attribute_value']==$arryOpportunity[0]['lead_source']){echo "selected";}?>>
			<?=$arryLeadSource[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select>

 </td>
 </tr>
 
     
 <tr >
        <td  align="right"   class="blackbold">Opportunity Type  : </td>
        <td   align="left" >
		

		<select name="OpportunityType" class="inputbox" id="OpportunityType" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryOppType);$i++) {?>
			<option value="<?=$arryOppType[$i]['attribute_value']?>" <?php  //if($arryOppType[$i]['attribute_value']==$arryOpportunity[0]['OpportunityType']){echo "selected";}?>>
			<?=$arryOppType[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select> 	  
             </td>
     
        <td  align="right"   class="blackbold">Contact Name : </td>
        <td   align="left" >
<input name="ContactName" type="text" class="inputbox" size="15" id="ContactName" value="<?php //echo stripslashes($arryOpportunity[0]['ContactName']); ?>"  maxlength="50" />            </td>
      </tr>
	  
     
	<tr>

<td  align="right"   class="blackbold">Website : </td>
        <td   align="left" >
<input name="oppsite" type="text" class="inputbox" size="15" id="oppsite" value="<?php //echo stripslashes($arryOpportunity[0]['oppsite']); ?>"  maxlength="50" />            </td>

        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >

		<? 
		  	 $ActiveChecked = 'checked';
			/* if($_REQUEST['edit'] > 0){
				 if($arryOpportunity[0]['Status'] == 1) {$ActiveChecked = 'checked'; $InActiveChecked ='';}
				 if($arryOpportunity[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}*/
		  ?>
          
           <input type="radio" name="Status" id="Status" value="1"  /><!--<?=$ActiveChecked?>-->
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0"  /><!--<?=$InActiveChecked?>-->
          InActive  </td>
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
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />



<input type="hidden" name="OpportunityID" id="OpportunityID"  value="<?=$_GET['edit']?>" />
<input type="hidden" name="Status" id="Status"  value="0" />	
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	ShowPermission();
</SCRIPT>
