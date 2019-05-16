

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
	<form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">		   
			   
			 <?	 if($ShowList==1){ ?>  
			 
		
	
	<tr>
		 <td class="had2" style="text-align:center">Salary for the period of <?=date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'))?></td>
	</tr>
			 
	<tr>
	  <td align="center" valign="top"  >
		 <? include("includes/html/box/emp_box.php"); ?>
	  </td>
	</tr>			 
	<tr>
	  <td align="center" valign="top"  >
		 <? include("includes/html/box/leave_box.php"); ?>
	  </td>
	</tr>		 
			 
	 <tr>
                  <td align="center" height="30"  >
				  <div id="msg_div" class="redmsg"></div>
				  </td>
		</tr>
		

 <tr>
		  <td align="right"  >
		 <?if($arryCurrentLocation[0]['Advance']==1){?><a class="fancybox action_bt fancybox.iframe" href="empAdvance.php?emp=<?=$_GET['emp']?>&y=<?=$_GET['y']?>&m=<?=$_GET['m']?>">Advance</a><?}?>  
		 
		 <?if($arryCurrentLocation[0]['Loan']==1){?><a class="fancybox action_bt fancybox.iframe" href="empLoan.php?emp=<?=$_GET['emp']?>&y=<?=$_GET['y']?>&m=<?=$_GET['m']?>">Loan</a><?}?>
		  </td>
</tr>

 <tr>
   <td align="center" valign="top"  >

				  
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	<tr>
		 <td colspan="2" align="left" class="head">Salary Details</td>
	</tr> 	
	
	<tr>
		  <td align="right" width="45%" class="blackbold">CTC :</td>
		  <td align="left" >
		
	<input id="CTC" name="CTC" class="disabled"  value="<?=$arrySalary[0]['CTC']?>"  type="text" size="15" > 
	 <?=$Config['Currency']?> 
	 

		   </td>
		</tr>
	
	
<? 
$NumDayMonth = date('t', strtotime($_GET['y'].'-'.$_GET['m'].'-01'));


$AllField = ''; $Total = 0; $Deduction = 0; $Retirals=0;
foreach($arryPayCategory as $key=>$values_cat){
	$arryHead = $objPayroll->getHead('',$values_cat['catID'],1);
	if(sizeof($arryHead)>0 || $values_cat['catGrade']=="D"){

	if($values_cat['Status']==1){
		$TotalLabel .= $values_cat['catGrade'].' + ';
		$OnField = 'class="disabled" readonly=""';
	}else{
		$OnField = 'class="textbox" onblur="Javascript:SetFormValues(\'1\');" onkeypress="return isDecimalKey(event);Javascript:ClearMsg();" ';
	}
?>			
	 <tr>
		 <td colspan="2" align="left" class="head2"><?=stripslashes($values_cat['catName'])?></td>
	</tr>     

	<? 	
	$SubTotal = 0; 
	foreach($arryHead as $key=>$values){
	
		$FieldName = Field.$values['headID'];
		
		if($values['Default']==1){
			$BasicField = $FieldName;
		}
		
		
		$AmtPer = ($values['HeadType']=="Percentage")?($values['Percentage']):($values['Amount']);
		
		$AllField .= $FieldName.','.$values['HeadType'].','.$AmtPer.','.stripslashes($values['heading']).','.$values_cat['catGrade'].'#';
		
		
		
		$FieldValue = round($arrySalaryDb[$values['headID']],2);
		$SubTotal+=$FieldValue;
		
		if($values_cat['catGrade']=="C"){ 
			$Retirals+=$FieldValue; 
		}
	 ?>	
		
		  
	<tr>
		  <td align="right" width="45%" class="blackbold"><?=stripslashes($values['heading'])?> <?=stripslashes($values['subheading'])?> :<?=$Mand?></td>
		  <td align="left" >
		
	<input id="<?=$FieldName?>" name="<?=$FieldName?>"  value="<?=$FieldValue?>"  type="text" maxlength="10" size="15"   <?=$OnField?> > 
	 <?=$Config['Currency']?> 
	
		   </td>
		</tr>		
	<? } ?>	
	
	
	
	<? if($values_cat['catGrade']=="D"){
	
		$SubTotal += $arrySalary[0]['LeaveDeduction'];
	 ?>
	<tr>
		  <td align="right" class="blackbold">Leave Deduction : </td>
		  <td align="left" >
	<input id="LeaveDeduction" name="LeaveDeduction"  value="<?=$arrySalary[0]['LeaveDeduction']?>"  type="text" maxlength="10" size="15" onkeypress="return isDecimalKey(event);Javascript:ClearMsg();" class="textbox" onblur="Javascript:SetFormValues('1');"> 
	 <?=$Config['Currency']?> 
		   </td>
		</tr>
	<? } 
	
	
	
	$SubTotal = round($SubTotal,2);
	?>	
	
	
	<tr>
		 <td align="right"  class="blackbold" ><strong>SUB TOTAL - <?=$values_cat['catGrade']?> :</strong></td>
		 <td align="left" ><input id="SubTotal<?=$values_cat['catGrade']?>" name="SubTotal<?=$values_cat['catGrade']?>" class="disabled" readonly="" value="<?=$SubTotal?>"  type="text"  size="15"   > 
	 <?=$Config['Currency']?> </td>
	</tr>   
		
 <? 
 	if($values_cat['Status']==1){ 
		$LastActiveSubTotal = $SubTotal; //Get Retirals Subtotal
		$Total+=$SubTotal;
	}else{
		$Deduction+=$SubTotal;
	}
 
 	
 
	} 
 
 } 
 
  
 	$AllField = rtrim($AllField,"#");
 	$TotalLabel = rtrim($TotalLabel," + ");
 
 
 
 	//$Total = round($Total);  //$Total = $arrySalary[0]['Gross'];
	$TotalPM = $Total;  //round($Total/12);
	
	$NetPM = $Total - $Retirals;  //$NetPM = $arrySalary[0]['NetSalary']; //round(($Total - $Retirals)/12);
	
	
	$CurrentPM = $NetPM;
	$CurrentPM = $NetPM - round($Deduction);
 ?>		                  
      
	  <tr>
		 <td  colspan="2" height="10" ></td>
	</tr>
	      
		<tr>
		 <td align="right"  class="head"  ><strong>GROSS (<?=$TotalLabel?>) :</strong></td>
		 <td align="left" class="head redmsg"> <span id="TotalDiv"><? if($Total>0) echo number_format($Total);  else echo '0'; ?></span> <?=$Config['Currency']?> 
		 
		
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
		 <td align="left" class="head redmsg"> <span id="NetDiv">
		 <? 
		 
		 if($NetPM>0) echo number_format($NetPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="NetSalary" id="NetSalary" value="<?=round($NetPM)?>" >

&nbsp;&nbsp;&nbsp;
<span class="normal">[<?=number_format(round($NetPM/$NumDayMonth)).' '.$Config['Currency'].' Per Day'?> ]</span>




		   </td>
	</tr> 
	<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
	<tr>
		 <td align="right"  class="head"  ><strong>CURRENT MONTH SALARY :</strong></td>
		 <td align="left" class="head redmsg"> <span id="CurrentDiv"><? if($CurrentPM>0) echo number_format($CurrentPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="CurrentSalary" id="CurrentSalary" value="<?=round($CurrentPM)?>" >
		   </td>
	</tr> 
	
	
	 	  
		           
                  </table>
		  
				  
				  </td>
                </tr>
				
				<tr>
				<td align="center" valign="top" >
			<? if($_GET['edit'] >0 ) $ButtonTitle = 'Update'; else $ButtonTitle =  'Submit';?>

	<input type="hidden" name="payID" id="payID" value="<?=$_GET['edit']?>">  
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['emp']?>">

	<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> " />

&nbsp;
<input type="hidden" name="BasicField" id="BasicField" value="<?=$BasicField?>" >

	<input type="hidden" name="Year" id="Year" value="<?=$_GET['y']?>">  
	<input type="hidden" name="Month" id="Month" value="<?=$_GET['m']?>">

	<input type="hidden" name="LeaveTaken" id="LeaveTaken" value="<?=$LeaveTakenMonth?>">  




				  </td>
		  </tr>
		  
		  
		  
<? } ?> 	
		
		
			</form>	
          
 </table>

<SCRIPT LANGUAGE=JAVASCRIPT>
var allField = '<?=$AllField?>';
function SetFormValues(opt){
	ClearMsg();
	var FieldName,FieldValue,FieldValueTemp,HeadType,AmtPer,FieldLabel,catGrade,SubTotalA=0,SubTotalB=0,SubTotalC=0,SubTotalD=0,Total=0,LeaveDeduction=0;
	var BasicFieldName = document.getElementById("BasicField").value; 
	var BasicSalary = Trim(document.getElementById(BasicFieldName)).value;
	var arrField = allField.split("#");
	if(BasicSalary!='' && !isNaN(BasicSalary)){
		
		for(var i = 1; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			HeadType = arrField2[1];
			AmtPer = arrField2[2];
			FieldLabel = arrField2[3];
			catGrade = arrField2[4];
			
			FieldValue=0;
			
			if(catGrade=="D"){
			
				if(opt==1){
					FieldValueTemp = parseFloat(document.getElementById(FieldName).value);
					if(FieldValueTemp!='' && !isNaN(FieldValueTemp)){
						FieldValue = FieldValueTemp;
					}
				}else{
					if(HeadType=='Percentage'){
						FieldValue = (BasicSalary*AmtPer)/100;
					}else{
						FieldValue = AmtPer;
					}
				}
			
			
				SubTotalD += FieldValue;
				document.getElementById(FieldName).value = FieldValue;
				
				
			}
			
			
			
		}
		
		
		if(document.getElementById("SubTotalD") != null){
			LeaveDeduction = parseFloat(document.getElementById("LeaveDeduction").value);
			if(LeaveDeduction!='' && !isNaN(LeaveDeduction)){
				//LeaveDeduction = Math.round(LeaveDeduction);
				SubTotalD += LeaveDeduction;
			}else{
				LeaveDeduction=0;
			}
			document.getElementById("LeaveDeduction").value = LeaveDeduction;
			document.getElementById("SubTotalD").value = SubTotalD;
		}	
			
			
		if(document.getElementById("CurrentDiv") != null){
			NetSalary = document.getElementById("NetSalary").value;
		    var CurrentSalary = NetSalary-Math.round(SubTotalD); 
			document.getElementById("CurrentDiv").innerHTML = number_format(CurrentSalary) ;
			document.getElementById("CurrentSalary").value = CurrentSalary;
		}
		
		
	}
	
	
}




function ValidateForm(frm)
{
	ClearMsg();
	var FieldName,FieldLabel,catGrade;
	var BasicFieldName = document.getElementById("BasicField").value; 
	var BasicSalary = Trim(document.getElementById(BasicFieldName)).value;
	
	var arrField = allField.split("#");
	
	if(BasicSalary!='' && !isNaN(BasicSalary)){
		for(var i = 1; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			FieldLabel = arrField2[3];
			catGrade = arrField2[4];
			if(catGrade=="D"){
				if(!ValidateOptDecimalField(document.getElementById(FieldName),FieldLabel)){
					return false;
				}
			}
		}	
		
		ShowHideLoader(1,'S');

		return true;
				
	}
	
	
}


</SCRIPT>