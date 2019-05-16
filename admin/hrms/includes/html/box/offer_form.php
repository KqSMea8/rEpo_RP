<div id="offer_form_div" style="display:none;">
<TABLE WIDTH=500   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	  <form name="formOffer" action="" method="post"  enctype="multipart/form-data" onSubmit="return validateOffer(this);">
		<tr>
		  <td >
		   <div class="had2">Send Offer Letter</div>
		  <table width="100%" border="0" cellpadding="5" cellspacing="1" class="borderall" align="center">
				<tr>
                      <td width="25%" align="right"  class="blackbold">
					 Candidate :
					  </td>
                      <td align="left" >
						<div id="CandidateDt"></div>
					  </td>
                    </tr>
					
					<tr>
                      <td  align="right"   class="blackbold"> 
						Date :
					  </td>
                      <td  align="left" valign="top">
					  <?=date($Config['DateFormat'], strtotime($Config['TodayDate']))?>
					  </td>
                    </tr>
					
					<tr>
                      <td  align="right"   class="blackbold"> 
						Joining Date :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						
<script type="text/javascript">
$(function() {
	$('#JoiningDate').datepicker(
		{
		showOn: "both", dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+2?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="JoiningDate" name="JoiningDate" readonly="" class="datebox" value=""  type="text" >					
						
					  </td>
                    </tr>	
					<tr>
                      <td  align="right"   class="blackbold" valign="top"> 
						Message :<span class="red">*</span>
					  </td>
                      <td  align="left" valign="top">
						 <textarea name="Message" type="text" class="bigbox" id="Message" maxlength="500"></textarea>	
					  </td>
                    </tr>	
                   <tr>
    <td  align="right" class="blackbold" >  Upload Offer Letter  :<span class="red">*</span></td>
    <td  align="left"  >
	<input name="OfferLetter" type="file" class="inputbox" id="OfferLetter" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	
	</td>
  </tr>
				   
				   
				   
                  </table>
		  
		  
		  
		  
		  </td>
	    </tr>
		
		<tr>
				<td align="center" >
	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Send " />
	<input type="hidden" name="CanID" id="CanID" value="" />
	<input type="hidden" name="TodayDate" id="TodayDate" value="<?=$Config['TodayDate']?>" />
	
	
				  </td>
		  </tr>
		
	    </form>
</TABLE>
</div>

<script language="JavaScript1.2" type="text/javascript">
function SetOfferForm(CanID,UserName,Email){
	var CandidateDt = 	UserName + '&nbsp;&nbsp;&nbsp;[<a href="mailto:'+Email+'">'+Email+'</a>]' ;
	document.getElementById("CanID").value = CanID;
	document.getElementById("CandidateDt").innerHTML = CandidateDt;
}

function validateOffer(frm){
	if(ValidateForSelect(frm.JoiningDate, "Joining Date")
		&& ValidateForSimpleBlank(frm.Message, "Message")
		&& ValidateMandDoc(frm.OfferLetter,"Offer Letter")
		){
				if(frm.JoiningDate.value <= frm.TodayDate.value){
					alert("Joining Date should be greater than current date.");
					return false;
				}
			

				$.fancybox.close();
				ShowHideLoader('1','P');
			
				return true;						
		}else{
				return false;	
		}			
}

</script>
