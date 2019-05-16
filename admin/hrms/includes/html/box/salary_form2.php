

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
	<form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">		   
			   
			 <? if($_GET['emp']>0 && empty($ErrorMsg)){ ?>  
			 
		 <tr>
                  <td align="center" valign="top"  >
				  <div id="msg_div" class="redmsg"></div>
				  </td>
				  </tr>	 
			 
			 
                <tr>
                  <td align="center" valign="top"  >
				  <div style="text-align:right;font-weight:bold"><?=SALARY_ANUM?></div>

				  
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >

			
<? 
$AllField = ''; $Total = 0;
foreach($arryPayCategory as $key=>$values_cat){
	$arryHead = $objPayroll->getHead('',$values_cat['catID'],'',1);
	if(sizeof($arryHead)>0){
	
	$TotalLabel .= $values_cat['catGrade'].' + ';
?>			
	 <tr>
		 <td colspan="2" align="left" class="head"><?=stripslashes($values_cat['catName'])?></td>
	</tr>     

	<? 	
	$SubTotal = 0;
	foreach($arryHead as $key=>$values){
	
		$FieldName = Field.$values['headID'];
		
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
		
	 ?>	
		  
	<tr>
		  <td align="right" width="45%" class="blackbold"><?=stripslashes($values['heading'])?> <?=stripslashes($values['subheading'])?> :<?=$Mand?></td>
		  <td align="left" >
		
	<input id="<?=$FieldName?>" name="<?=$FieldName?>" class="inputbox"  value="<?=$FieldValue?>"  type="text" maxlength="30" onkeypress="Javascript:ClearMsg();" onblur="Javascript:SetFormValues('1');" > 
	 <?=$Config['Currency']?> 
	<?
		if($values['Default']==1){ echo '<a href="Javascript:void(0);" onClick="Javascript:SetFormValues(\'0\');" class="grey_bt" style="float:none" >Calculate</a>'; }
	?>
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
 
 	$TotalPM = $Total/12;
 ?>		                  
      
	  <tr>
		 <td  colspan="2" height="10" ></td>
	</tr>
	      
		<tr>
		 <td align="right"  class="head"  ><strong>GROSS (<?=$TotalLabel?>) :</strong></td>
		 <td align="left" class="head redmsg"> <span id="TotalDiv"><? if($Total>0) echo number_format($Total,2,'.',',');  else echo '0'; ?></span> <?=$Config['Currency']?>  </td>
	</tr>    	
		<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
		<tr>
		 <td align="right"  class="head"  ><strong>GROSS APPROX  PM :</strong></td>
		 <td align="left" class="head redmsg"> <span id="TotalPmDiv"><? if($TotalPM>0) echo number_format($TotalPM,2,'.',',');  else echo '0'; ?></span> <?=$Config['Currency']?>  </td>
	</tr>     
		  
		           
                  </table>
		  
				  
				  </td>
                </tr>
				
				<tr>
				<td align="center" valign="top" >
			<? if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="salaryID" id="salaryID" value="<?=$_GET['edit']?>">  
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['emp']?>">

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />

&nbsp;
				  <input type="reset" name="Reset" value="Reset" class="button" />
	<input type="hidden" name="BasicField" id="BasicField" value="<?=$BasicField?>" >




				  </td>
		  </tr>
		  
		  
		  
<? } ?> 	
		
		
			</form>	
          
 </table>

<SCRIPT LANGUAGE=JAVASCRIPT>
var allField = '<?=$AllField?>';
function SetFormValues(opt){
	ClearMsg();
	var FieldName,FieldValue,HeadType,AmtPer,FieldLabel,catGrade,SubTotalA=0,SubTotalB=0,SubTotalC=0,Total=0;
	var BasicFieldName = document.getElementById("BasicField").value; 
	var BasicSalary = parseInt(Trim(document.getElementById(BasicFieldName)).value);

	var arrField = allField.split("#");
	
	
	
	if(BasicSalary!='' && !isNaN(BasicSalary)){
		document.getElementById(BasicFieldName).value = BasicSalary;
		SubTotalA += BasicSalary;
		for(var i = 1; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			HeadType = arrField2[1];
			AmtPer = arrField2[2];
			FieldLabel = arrField2[3];
			catGrade = arrField2[4];
			
			FieldValue=0;
			if(opt==1){
				FieldValue = Math.round(document.getElementById(FieldName).value);
			}else{
				if(HeadType=='Percentage'){
					FieldValue = Math.round((BasicSalary*AmtPer)/100);
				}else{
					FieldValue = Math.round(AmtPer);
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
			document.getElementById("TotalDiv").innerHTML = number_format(Total,2,'.',',') ;
		}
		if(document.getElementById("TotalPmDiv") != null){
		    var TotalPm = Total/12; 
			document.getElementById("TotalPmDiv").innerHTML = number_format(TotalPm,2,'.',',') ;
		}
		
		
			
	}else{
		for(var i = 1; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			catGrade = arrField2[4];
			document.getElementById(FieldName).value = "";
			document.getElementById("SubTotal"+catGrade).value = "";
		}	
		
		arrField2 = arrField[0].split(",");
		document.getElementById("msg_div").innerHTML = "Please Enter Valid "+arrField2[3]+".";		
		document.getElementById(arrField2[0]).focus();
	}
	
	
}






function ValidateForm(frm)
{
	ClearMsg();
	var FieldName,FieldLabel;
	var BasicFieldName = document.getElementById("BasicField").value; 
	var BasicSalary = parseInt(Trim(document.getElementById(BasicFieldName)).value);
	
	var arrField = allField.split("#");
	
	if(BasicSalary!='' && !isNaN(BasicSalary)){
		document.getElementById(BasicFieldName).value = BasicSalary;
		
		
		for(var i = 1; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			FieldLabel = arrField2[3];
			if(!ValidateOptSalary(document.getElementById(FieldName),FieldLabel)){
				return false;
			}
		}	
		
		/*
		var Url = "isRecordExists.php?SalaryEmpID="+escape(document.getElementById("EmpID").value)+"&editID="+document.getElementById("salaryID").value;		
		SendExistRequest(Url,"EmpID","Employee Salary");
		return false;
		*/
		return true;
				
	}else{
		arrField2 = arrField[0].split(",");
		document.getElementById("msg_div").innerHTML = "Please Enter Valid "+arrField2[3]+".";		
		document.getElementById(arrField2[0]).focus();
		return false;	
	}
	
	return false;
	
}


</SCRIPT>