<SCRIPT LANGUAGE=JAVASCRIPT>
 
function CheckAccountField(MSG_SPAN,FieldName,emp){
	
		document.getElementById(MSG_SPAN).innerHTML='';

		FieldLength = document.getElementById(FieldName).value.length;
	
		if(FieldLength>=5){
			document.getElementById(MSG_SPAN).innerHTML='<img src="../images/loading.gif">';	
			var Url = "isRecordExists.php?"+FieldName+"="+escape(document.getElementById(FieldName).value)+"&emp="+emp;
			var SendUrl = Url+"&r="+Math.random(); 

			httpObj.open("GET", SendUrl, true);
			httpObj.onreadystatechange = function RecieveAccountFieldRequest(){
				if (httpObj.readyState == 4) {
					if(httpObj.responseText==1) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Already exist!</span>";
					}else if(httpObj.responseText==0) {	 
						document.getElementById(MSG_SPAN).innerHTML="<span class=greenmsg>Available!</span>";
					}else {
						alert("Error occur : " + httpObj.responseText);
					}
				}
			};
			httpObj.send(null);

		}else if(FieldLength>0){
			document.getElementById(MSG_SPAN).innerHTML="<span class=redmsg>Minimum 5 characters.</span>";
		}

	}

</SCRIPT>


<div id="SalaryFormDiv">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
	<form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">		   
			   
			 <? if($_GET['emp']>0 && empty($ErrorMsg)){ ?>  
			 
		 
	
	 <? if($HideInSalaryForm!=1){ 
		 
		 $OnCTCField = 'class="textbox"';
		 
		 ?>
	 <tr>
	  <td align="center" valign="top"  >
		 <? include("includes/html/box/emp_box.php"); ?>
	  </td>
	</tr>
	<? }else{
		  $OnCTCField = 'class="disabled" readonly=""';
		  $HideTableRow = 'style="display:none"';
	 }  ?>

	<tr <?=$HideTableRow?>>
	  <td align="center" valign="top"  >
		 
	 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	 <tr>
		 <td colspan="4" align="left" class="head">Bank Details</td>
	</tr>   
	  
	   <tr>
		  <td align="left" class="blackbold" width="14%">Bank Name :</td>
		  <td align="left" width="46%" > <input type="text" name="BankName" maxlength="40" class="inputbox" id="BankName" value="<?=stripslashes($arrySalary[0]['BankName'])?>">	 </td>
		  <td align="left" class="blackbold" width="14%">Account Name  : </td>
		  <td align="left" > <input type="text" name="AccountName" maxlength="30" class="inputbox" id="AccountName" value="<?=stripslashes($arrySalary[0]['AccountName'])?>">	 </td>
		  
		</tr>
	   <tr>
		  <td align="left" class="blackbold"> Account Number  :</td>
		  <td align="left" ><input type="text" name="AccountNumber" maxlength="30" class="inputbox" id="AccountNumber" value="<?=stripslashes($arrySalary[0]['AccountNumber'])?>" onKeyPress="Javascript:ClearAvail('msg_account');return isAlphaKey(event);" onBlur="Javascript:CheckAccountField('msg_account','AccountNumber','<?=$_GET['emp']?>');">  </td>
		   <td align="left" class="blackbold">Routing Number  : </td>
		  <td align="left" > <input type="text" name="IFSCCode" maxlength="30"  class="inputbox" id="IFSCCode" value="<?=stripslashes($arrySalary[0]['IFSCCode'])?>">  </td>
		</tr>
 <tr>
		  <td align="left"></td>
		 <td align="left" colspan="3"><div id="msg_account"></div></td>
		</tr>		
	  </table>	 
		 
		 
		 
	  </td>
	</tr>

	
	 <tr>
                  <td align="center" height="30"  >
				  <div id="msg_div" class="redmsg"></div>
				  </td>
		</tr>	
			
	 <tr>
                  <td align="center" >
				
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	<tr>
	<td align="right" width="45%" class="blackbold" valign="top">Pay Rate :</td>
	<td align="left" >
<label><input type="radio" name="PayRate" id="PayRate0" value="H" <?=($PayRate=="" || $PayRate=="H")?("checked"):("")?> onclick="Javascript:SetSalaryTR();" /> Hourly </label>&nbsp;&nbsp;&nbsp;

<label><input type="radio" name="PayRate" id="PayRate1" value="S" <?=($PayRate=="S")?("checked"):("")?> onclick="Javascript:SetSalaryTR();" /> Salary <br></label>

	</td>
	</tr>	

	<tr id="hourlyratetr" style="display:none">
	<td align="right" class="blackbold" valign="top">Hourly Rate :<span class=red>*</span></td>
	<td align="left" >

<input id="HourRate" name="HourRate" class="textbox" size="15" value="<?=$arrySalary[0]['HourRate']?>"  type="text" maxlength="10" onkeypress="return isDecimalKey(event);Javascript:ClearMsg();" size="15" autocomplete="off" > 

	</td>
	</tr>
</table>

				  </td>
		</tr>	

 
                <tr id="salarydetailtr" style="display:none">
                  <td align="center" valign="top"  >
				  <div style="text-align:right;font-weight:bold" id="divAnnum"><?=SALARY_ANUM?></div>

				  
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
 <tr>
		 <td colspan="2" align="left" class="head">Salary Details</td>
	</tr> 
	
	<tr>
		  <td align="right" width="45%" class="blackbold">CTC :<span class=red>*</span></td>
		  <td align="left" >
		
	<input id="CTC" name="CTC"  <?=$OnCTCField?> value="<?=$arrySalary[0]['CTC']?>"  type="text" maxlength="10" onkeypress="return isNumberKey(event);Javascript:ClearMsg();" onblur="Javascript:SetFormValues('1');" size="15" autocomplete="off" > 
	 <?=$Config['Currency']?> 
	
	<? if($HideInSalaryForm!=1){ ?> 
	 <a href="Javascript:void(0);" onClick="Javascript:SetFormValues('0');" class="grey_bt" style="float:none" >Calculate</a>
	<? } ?>
		   </td>
		</tr>	
			
<? 
$AllField = ''; $Total = 0;
foreach($arryPayCategory as $key=>$values_cat){
	$arryHead = $objPayroll->getHead('',$values_cat['catID'],$catEmp,1);
	if(sizeof($arryHead)>0){
	
	$TotalLabel .= $values_cat['catGrade'].' + ';
?>			
	 <tr>
		 <td colspan="2" align="left" class="head2"><?=stripslashes($values_cat['catName'])?></td>
	</tr>     

	<? 	
	$SubTotal = 0; $Deduction = 0;
	foreach($arryHead as $key=>$values){
	
		$FieldName = 'Field'.$values['headID'];
		
		if($values['Default']==1){
			$Mand = "<span class=red>*</span>";
			$BasicField = $FieldName;
		}else{
			$Mand = ""; 
		}
		
		
		$AmtPer = ($values['HeadType']=="Percentage")?($values['Percentage']):($values['Amount']);
		
		$AllField .= $FieldName.','.$values['HeadType'].','.$AmtPer.','.stripslashes($values['heading']).','.$values_cat['catGrade'].'#';
		
		
		
		$FieldValue = $arrySalaryDb[$values['headID']];
		$SubTotal+=$FieldValue;
		
		if($values_cat['catGrade']=="C"){ $Deduction+=$FieldValue; }

?>	
		  
	<tr>
		  <td align="right"  class="blackbold"><?=stripslashes($values['heading'])?> <?=stripslashes($values['subheading'])?> :<?=$Mand?></td>
		  <td align="left" >
		
	<input id="<?=$FieldName?>" name="<?=$FieldName?>" class="textbox"  value="<?=$FieldValue?>"  type="text" maxlength="10" onkeypress="return isNumberKey(event);Javascript:ClearMsg();" onblur="Javascript:SetFormValues('1');" size="15" autocomplete="off"> 
	 <?=$Config['Currency']?> 
	
		   </td>
		</tr>		
	<? } ?>	
	
	<tr>
		 <td align="right"  class="blackbold" ><strong>SUB TOTAL - <?=$values_cat['catGrade']?> :</strong></td>
		 <td align="left" ><input id="SubTotal<?=$values_cat['catGrade']?>" name="SubTotal<?=$values_cat['catGrade']?>" class="disabled"  value="<?=$SubTotal?>"  type="text" readonly="" size="15"   > 
	 <?=$Config['Currency']?> </td>
	</tr>   
		
 <? 
 	$Total+=$SubTotal;

	


 
 } } 
 
 
 	$AllField = rtrim($AllField,"#");
 	$TotalLabel = rtrim($TotalLabel," + ");
 
 	$Total = round($Total);
	$TotalPM = round($Total/12);
	
	$NetPM = round(($Total - $Deduction)/12);

	$CtcDiffVal = $arrySalary[0]['CTC']-$Total;
	if($CtcDiffVal==0){
		$CtcDiffStyle='display:none;';
	}
 ?>		                  
      
	  <tr>
		 <td  colspan="2" height="10" ></td>
	</tr>
	      
		<tr>
		 <td align="right"  class="head"  ><strong>GROSS (<?=$TotalLabel?>) :</strong></td>
		 <td align="left" class="head"> <span id="TotalDiv" class="redmsg"><? if($Total>0) echo number_format($Total);  else echo '0'; ?></span> <span class="redmsg"><?=$Config['Currency']?></span>
		 
	<span id="CtcDiffSpan" style="float:right;<?=$CtcDiffStyle?>">Diffrence from CTC : <span id="CtcDiffVal"><?=$CtcDiffVal?></span> &nbsp;&nbsp;&nbsp;</span>
		
		  </td>
	</tr>    	
		<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
		<tr>
		 <td align="right"  class="head"  ><strong>GROSS APPROX  PM :</strong></td>
		 <td align="left" class="head redmsg"> <span id="TotalPmDiv"><? if($TotalPM>0) echo number_format($TotalPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="Gross" id="Gross" value="<?=$TotalPM?>" >
		   </td>
	</tr>     
	<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
		<tr>
		 <td align="right"  class="head"  ><strong>NET SALARY PM :</strong></td>
		 <td align="left" class="head redmsg"> <span id="NetDiv"><? if($NetPM>0) echo number_format($NetPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="NetSalary" id="NetSalary" value="<?=$NetPM?>" >
		   </td>
	</tr>  	  
		           
                  </table>
		  
				  
				  </td>
                </tr>
				
				<tr>
				<td align="center" valign="top" >
<? if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';
				
?>

	<input type="hidden" name="salaryID" id="salaryID" value="<?=$salaryID?>">  
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['emp']?>">
	<input type="hidden" name="catEmp" id="catEmp" value="<?=$catEmp?>">

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />
				 
	<input type="hidden" name="BasicField" id="BasicField" value="<?=$BasicField?>" >


	<input type="hidden" name="AppraisalAmountMain" id="AppraisalAmountMain" value="">
	<input type="hidden" name="AppraisalFromDate" id="AppraisalFromDate" value="">





				  </td>
		  </tr>
		  
		  
		  
<? } ?> 	
		
		
			</form>	
          
 </table>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
CheckBasicExist(); 
SetSalaryTR();
function CheckBasicExist(){
	if(document.getElementById("BasicField").value==''){
		document.getElementById("msg_div").innerHTML = "Basic Salary has not been defined for this employee's category in Payroll Structure.";	
		
		$("#divAnnum").hide(); 
		$("#SubmitButton").hide(); 
		$(".borderall").hide(); 
	}
}

function SetSalaryTR(){
	if(document.getElementById("PayRate1").checked==true){		
		$("#salarydetailtr").show(); 
		$("#hourlyratetr").hide(); 
	}else{
		$("#salarydetailtr").hide(); 
		$("#hourlyratetr").show(); 
	}
}





var allField = '<?=$AllField?>';
function SetFormValues(opt){
	ClearMsg();
	var BasicSalary=0, FieldName,FieldValue,FieldValueTemp,HeadType,AmtPer,FieldLabel,catGrade,SubTotalA=0,SubTotalB=0,SubTotalC=0,Total=0;
	var CTC = parseInt(Trim(document.getElementById("CTC")).value);

	var arrField = allField.split("#");
	
	
	
	if(CTC!='' && !isNaN(CTC)){
		document.getElementById("CTC").value = CTC;
		for(var i = 0; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			HeadType = arrField2[1];
			AmtPer = arrField2[2];
			FieldLabel = arrField2[3];
			catGrade = arrField2[4];
			
			FieldValue=0;
			
			if(i==0){
				BasicSalary = Math.round((CTC*AmtPer)/100);
				FieldValue = BasicSalary;
			}		
			
			
			
			if(opt==1){
				FieldValueTemp = parseInt(document.getElementById(FieldName).value);
				if(FieldValueTemp!='' && !isNaN(FieldValueTemp)){
					FieldValue = Math.round(FieldValueTemp);
				}
				

				if(i==0){
					if(FieldValue > CTC){
						document.getElementById("msg_div").innerHTML = FieldLabel+" should not be greater than CTC.";		
						document.getElementById(FieldName).focus();
						break;
					}
				}				
				
			}else{
				if(i>0){
					if(HeadType=='Percentage'){
						FieldValue = Math.round((BasicSalary*AmtPer)/100);
					}else{
						FieldValue = Math.round(AmtPer);
					}
				}
			}
			
			
			if(catGrade=="A") SubTotalA += FieldValue;
			if(catGrade=="B") SubTotalB += FieldValue;
			if(catGrade=="C") SubTotalC += FieldValue;
		
			document.getElementById(FieldName).value = FieldValue;
		}
		
		if(document.getElementById("SubTotalA") != null){
			document.getElementById("SubTotalA").value = SubTotalA;
			Total += SubTotalA;
		}
		if(document.getElementById("SubTotalB") != null){
			document.getElementById("SubTotalB").value = SubTotalB;
			Total += SubTotalB;
		}
		if(document.getElementById("SubTotalC") != null){
			document.getElementById("SubTotalC").value = SubTotalC;
			Total += SubTotalC;
		}
		
		if(document.getElementById("TotalDiv") != null){
			Total = Math.round(Total); 
			document.getElementById("TotalDiv").innerHTML = number_format(Total) ;
		}
		
		var CtcDiffVal = Math.round(CTC - Total); 
		if(CtcDiffVal==0){			
			document.getElementById("CtcDiffSpan").style.display = 'none' ;
		}else{
			document.getElementById("CtcDiffSpan").style.display = 'inline';
			document.getElementById("CtcDiffVal").innerHTML = CtcDiffVal ;
		}


		if(document.getElementById("TotalPmDiv") != null){
		    var TotalPm = Math.round(Total/12); 
			document.getElementById("TotalPmDiv").innerHTML = number_format(TotalPm) ;
			document.getElementById("Gross").value = TotalPm;
		}
		if(document.getElementById("NetDiv") != null){
		    var NetSalary = Math.round((Total -SubTotalC)/12); 
			document.getElementById("NetDiv").innerHTML = number_format(NetSalary) ;
			document.getElementById("NetSalary").value = NetSalary;
		}
		
			
	}else{
		for(var i = 0; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			catGrade = arrField2[4];
			document.getElementById(FieldName).value = "";
			document.getElementById("SubTotal"+catGrade).value = "";
		}	
		
		
		if(document.getElementById("TotalDiv") != null){
			document.getElementById("TotalDiv").innerHTML = "0";
		}
		if(document.getElementById("TotalPmDiv") != null){
			document.getElementById("TotalPmDiv").innerHTML = "0";
			document.getElementById("Gross").value = "0";
		}
		if(document.getElementById("NetDiv") != null){
			document.getElementById("NetDiv").innerHTML = "0";
			document.getElementById("NetSalary").value = "0";
		}
		
		arrField2 = arrField[0].split(",");
		//document.getElementById("msg_div").innerHTML = "Please Enter Valid "+arrField2[3]+".";	
		
		document.getElementById("msg_div").innerHTML = "Please Enter Valid CTC.";	
		document.getElementById("CTC").focus();
	}
	
	
}






function ValidateForm(frm)
{
	ClearMsg();

	var DataExist=0;

	/**********************/
	var AccountNumber = Trim(document.getElementById("AccountNumber")).value;
	if(AccountNumber!=''){
		if(!ValidateMandRange(document.getElementById("AccountNumber"), "Account Number",5,30)){
			return false;
		}
		DataExist = CheckExistingData("isRecordExists.php","&AccountNumber="+escape(AccountNumber)+"&emp="+document.getElementById("EmpID").value, "AccountNumber","Account Number");
		if(DataExist==1)return false;

	}
	/**********************/
	if(document.getElementById("PayRate0").checked==true){
		if(!ValidateForSimpleBlank(document.getElementById("HourRate"), "Hourly Rate")){
			return false;
		}
	}


if(document.getElementById("PayRate1").checked==true){


	var FieldName,FieldLabel,FieldValue=0,FieldValueTemp;
	var CTC = parseInt(Trim(document.getElementById("CTC")).value);
	
	var arrField = allField.split("#");
	
	if(CTC!='' && !isNaN(CTC)){
		document.getElementById("CTC").value = CTC;
		
		
		for(var i = 0; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			FieldLabel = arrField2[3];
			
			
			FieldValueTemp = parseInt(document.getElementById(FieldName).value);
			if(FieldValueTemp!='' && !isNaN(FieldValueTemp)){
				FieldValue = Math.round(FieldValueTemp);
			}
			
			
			if(i==0){
				if(!ValidateForSimpleBlank(document.getElementById(FieldName),FieldLabel)){
					return false;
				}
				
				if(FieldValue > CTC){
					document.getElementById("msg_div").innerHTML = FieldLabel+" should not be greater than CTC.";		
					document.getElementById(FieldName).focus();
					return false;
				}
			}
			
			if(!ValidateOptSalary(document.getElementById(FieldName),FieldLabel)){
				return false;
			}
		}	
		
		/*
		var Url = "isRecordExists.php?SalaryEmpID="+escape(document.getElementById("EmpID").value)+"&editID="+document.getElementById("salaryID").value;		
		SendExistRequest(Url,"EmpID","Employee Salary");
		return false;
		*/
		ShowHideLoader(1,'S');

		return true;
				
	}else{
		arrField2 = arrField[0].split(",");
		//document.getElementById("msg_div").innerHTML = "Please Enter Valid "+arrField2[3]+".";		
		document.getElementById("msg_div").innerHTML = "Please Enter Valid CTC.";		
		document.getElementById("CTC").focus();
		return false;	
	}
	
	return false;

   }
	
}


</SCRIPT>
