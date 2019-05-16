<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateForm(frm){
	var EntryType = $("#EntryType").val();
	if(EntryType == '1'){	
		if(  ValidateForSimpleBlank(frm.heading, "Holiday Name")
			&& ValidateForSelect(frm.holidayDate, "From Date")
			&& ValidateForSelect(frm.holidayDateTo, "To Date")
		){

			var numD = DateDiff(frm.holidayDate.value,frm.holidayDateTo.value);
 			if(frm.holidayDate.value>=frm.holidayDateTo.value){ 
				alert("To Date should be greater than From Date.");
				return false;
			}else if(numD>10){
				alert("Date range should not exceed 10 days.");
				return false;
			}else{
				var Url = "isRecordExists.php?HolidayNameRange="+escape(document.getElementById("heading").value)+"&holidayDate="+escape(document.getElementById("holidayDate").value)+"&holidayDateTo="+escape(document.getElementById("holidayDateTo").value)+"&editID="+escape(document.getElementById("holidayID").value);		
				SendMultipleExistRequest(Url,"heading","Holiday Name","holidayDate","Holiday Date");
				return false;
			}
			
		}else{
			return false;	
		}	
	
	}else{

		if(  ValidateForSimpleBlank(frm.heading, "Holiday Name")
			&& ValidateForSelect(frm.holidayDate, "Holiday Date")
		){
			var Url = "isRecordExists.php?HolidayName="+escape(document.getElementById("heading").value)+"&holidayDate="+escape(document.getElementById("holidayDate").value)+"&editID="+escape(document.getElementById("holidayID").value);
			SendMultipleExistRequest(Url,"heading","Holiday Name","holidayDate","Holiday Date");
			return false;
		}else{
			return false;	
		}	
	}		
}


$(function(){  	
	var EntryType = $("#EntryType").val();
	if(EntryType == '0' ){ 
		$("#holidayDateToShowHide").hide();  	
	}else{
		$("#holidayDateToShowHide").show();  	
	}
	DateRange();
});

function DateRange(){
	var EntryType = $("#EntryType").val();
	if(EntryType == '1' ){
		$("#Holiday").html('From');
		$("#holidayDateToShowHide").show();   
	}else{
		$("#Holiday").html('Holiday'); 
		$("#holidayDateToShowHide").hide();  
		$("#holidayDateTo").val(''); 
	}	
}

</SCRIPT>
<a href="<?=$RedirectUrl?>" class="back">Back</a>
<div class="had">Manage <?=$MainModuleName?> <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>

<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">
		
		<tr>
		  <td align="center" style="padding-top:80px">
		  <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
            
               
                <tr>
                  <td align="center" valign="top" >
				  
				  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" >
                  
                   
                    <tr>
                      <td width="30%" align="right" valign="top" class="blackbold"> 
					  Holiday Name :<span class="red">*</span> </td>
                      <td width="56%"  align="left" valign="top"><input  name="heading" id="heading" value="<?=stripslashes($arryHoliday[0]['heading'])?>" type="text" class="inputbox" maxlength="40" title="Please provide Holiday Name."/>
					  </td>
                    </tr>
				

	<tr  >
                      <td align="right" valign="top" class="blackbold">   Entry Type :</td>		                    		
			<td>
			 <select name="EntryType"  id="EntryType"  class="textbox" onchange="Javascript:DateRange();">
			<option value="0" <?=($holidayDateTo=='')?("Selected"):("")?>>Date</option>
			<option value="1" <?=($holidayDateTo>0)?("Selected"):("")?>>Date Range</option>
			</select>
			</td>
		</tr>

	
		  <tr>
                      <td align="right"  class="blackbold">
					 <span id ="Holiday"> Holiday </span> Date :<span class="red">*</span>
					  </td>
                      <td align="left">
<? 
$holidayDate='';
if(!empty($arryHoliday[0]['holidayDate'])) $holidayDate = $arryHoliday[0]['holidayDate'];  

if($holidayDate<=0) $holidayDate='';
?>				
<script type="text/javascript">
$(function() {
	$('#holidayDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd',
		yearRange: '<?=date("Y")-2?>:<?=date("Y")+1?>', 
		changeMonth: true,
		changeYear: true
		}
	);
});
</script>
<input id="holidayDate" name="holidayDate" readonly="" class="datebox" value="<?=$holidayDate?>"  type="text" > 
		 
					  </td>
                    </tr>				
                  
	 
<tr id="holidayDateToShowHide" >
                      <td align="right"  class="blackbold">
					 To Date :<span class="red">*</span>
					  </td>
                      <td align="left">
<? 
$holidayDateTo='';
if(!empty($arryHoliday[0]['holidayDateTo'])) $holidayDateTo = $arryHoliday[0]['holidayDateTo']; 
if($holidayDateTo<=0) $holidayDateTo='';

 ?>				
<script type="text/javascript">
$(function() {
	$('#holidayDateTo').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd',
		yearRange: '<?=date("Y")-2?>:<?=date("Y")+1?>', 
		changeMonth: true,
		changeYear: true
		}
	);
});
</script>
<input id="holidayDateTo" name="holidayDateTo" readonly="" class="datebox" value="<?=$holidayDateTo?>"  type="text" > 
		 
					  </td>
                    </tr>	

		 <tr >
                      <td align="right" valign="middle"  class="blackbold">Recurring :</td>
                      <td align="left" >
<input name="Recurring" type="checkbox" value="1" <?=($arryHoliday[0]['Recurring']==1)?"checked":""?> 
                          </td>
                    </tr>
					
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status :</td>
                      <td align="left" >
        <table width="151" border="0" cellpadding="0" cellspacing="0"  style="margin:0">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                      </td>
                    </tr>
                   
                  </table>
				  
				  
				  </td>
                </tr>
				
          
          </table>
		  
		  
		  </td>
	    </tr>
		<tr>
				<td align="center" valign="top"><br>
			<? if(isset($_GET['edit']) && $_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

 	<input type="hidden" name="holidayID" id="holidayID" value="<?=$_GET['edit']?>">   
 
				
				<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />&nbsp;
				  <input type="reset" name="Reset" value="Reset" class="button" /></td>
		  </tr>
	    </form>
</TABLE>
