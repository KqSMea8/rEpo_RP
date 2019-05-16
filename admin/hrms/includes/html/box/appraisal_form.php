

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
	<form name="form1" action="" method="post" onSubmit="return ValidateAppraisal(this);" enctype="multipart/form-data">		   
			   
			 <? if($_GET['emp']>0 && empty($ErrorMsg)){ ?>  
			 
		 
	 <tr>
	  <td align="center" valign="top"  >
		 <? include("includes/html/box/emp_box.php"); ?>
	  </td>
	</tr>

	

			 
                <tr>
                  <td align="center" valign="top"  >
<div id="msg_div" class="redmsg"></div>				  
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
 <tr>
		 <td colspan="2" align="left" class="head">Appraisal Details</td>
	</tr> 

	<tr>
		 <td align="right"  class="blackbold"  >CTC :</td>
		 <td align="left" > <? if($CTC>0) echo number_format($CTC);  else echo '0'; ?> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="CTC_Old" id="CTC_Old" value="<?=$CTC?>" >
		   </td>
	</tr> 
	<tr>
		 <td align="right"  class="blackbold">GROSS PM :</td>
		 <td align="left" > <? if($Gross>0) echo number_format($Gross);  else echo '0'; ?> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="Gross_Old" id="Gross_Old" value="<?=$Gross?>" >
		   </td>
	</tr>  	
	<tr>
		 <td align="right"  class="blackbold">Net Salary PM :</td>
		 <td align="left" > <? if($NetSalary>0) echo number_format($NetSalary);  else echo '0'; ?> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="NetSalary_Old" id="NetSalary_Old" value="<?=$NetSalary?>" >
		   </td>
	</tr>  

<tr>
		  <td align="right" width="45%" class="blackbold">Appraisal From Date :<span class=red>*</span></td>
		  <td align="left" >
		
	
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
		showOn: "both", yearRange: '<?=date("Y")-1?>:<?=date("Y")?>', 
		dateFormat: 'yy-mm-dd',
		minDate: "-6M", 
		maxDate: "+1M", 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<? $FromDate = date('Y-m').'-01'; ?>
<input id="FromDate" name="FromDate" readonly="" class="datebox" value="<?=$FromDate?>"  type="text" > 	
	 

		   </td>
		</tr>	


	<tr>
		  <td align="right" width="45%" class="blackbold">Appraisal Amount :<span class=red>*</span></td>
		  <td align="left" >
		
	<input id="AppraisalAmount" name="AppraisalAmount" class="textbox"  value="<?=$arryAppraisal[0]['AppraisalAmount']?>"  type="text" maxlength="10" onkeypress="Javascript:ClearMsg();return isNumberKey(event);"  size="15" autocomplete="off" > 
	 <?=$Config['Currency']?> 
	 

		   </td>
		</tr>	

		 
	<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
		  
		           
                  </table>
		  
				  
				  </td>
                </tr>
				
				<tr>
				<td align="center" valign="top" >


	<input name="Continue" type="submit" class="button" id="Continue" value="Continue" />




				  </td>
		  </tr>
		  
		  
		  
<? } ?> 	
		
		
			</form>	
          
 </table>

<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateAppraisal(frm)
{
	ClearMsg();
		
	var AppraisalAmount = parseInt(Trim(document.getElementById("AppraisalAmount")).value);
	var GrossSalary = parseInt(Trim(document.getElementById("Gross_Old")).value);

	if(!ValidateForSelect(document.getElementById("FromDate"),"Appraisal From Date")){
		return false;
	}
	if(!ValidateMandNumField(document.getElementById("AppraisalAmount"),"Appraisal Amount")){
		return false;
	}
	if(AppraisalAmount > GrossSalary){
		document.getElementById("msg_div").innerHTML = "Appraisal Amount should not be greater than Gross Salary.";		
		document.getElementById("AppraisalAmount").focus();
		return false;
	}


	/************************/
	var CTC = parseInt(Trim(document.getElementById("CTC_Old")).value) + (parseInt(AppraisalAmount)*12);
	document.getElementById("CTC").value = CTC;
	document.getElementById("AppraisalAmountMain").value = document.getElementById("AppraisalAmount").value;
	document.getElementById("AppraisalFromDate").value = document.getElementById("FromDate").value;


	SetFormValues('0');

	/************************/
	$('#SalaryFormDiv').show();
	return false;
}


</SCRIPT>