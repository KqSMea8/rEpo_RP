

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
	<form name="form1" action="" method="post" onSubmit="return ValidateForm(this);" enctype="multipart/form-data">		   
			   
			 <?	 if($ShowList==1){ ?>  
			 
		 <tr>
                  <td align="center" valign="top"  >
				  <div id="msg_div" class="redmsg"></div>
				  </td>
				  </tr>	 
	
	<tr>
		 <td align="left"><div id="search_table" style="display:block; width:200px; margin:0;"> <strong>Salary For Month:</strong>&nbsp;&nbsp;&nbsp;<?=date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'))?></div></td>
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
                  <td align="center" valign="top"  >

				  
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >

			
<? 
$AllField = ''; $Total = 0; $Deduction = 0; 
foreach($arryPayCategory as $key=>$values_cat){
	$arryHead = $objPayroll->getHead('',$values_cat['catID'],'',1);
	if(sizeof($arryHead)>0){

	if($values_cat['Status']==1){
		$TotalLabel .= $values_cat['catGrade'].' + ';
		$OnField = 'class="disabled" readonly=""';
	}else{
		$OnField = 'class="textbox" onblur="Javascript:SetFormValues(\'1\');"';
	}
?>			
	 <tr>
		 <td colspan="2" align="left" class="head"><?=stripslashes($values_cat['catName'])?></td>
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
		
		
		
		$FieldValue = $arrySalaryDb[$values['headID']];
		$SubTotal+=$FieldValue;
		
	 ?>	
		  
	<tr>
		  <td align="right" width="45%" class="blackbold"><?=stripslashes($values['heading'])?> <?=stripslashes($values['subheading'])?> :<?=$Mand?></td>
		  <td align="left" >
		
	<input id="<?=$FieldName?>" name="<?=$FieldName?>"  value="<?=$FieldValue?>"  type="text" maxlength="10" size="15" onkeypress="Javascript:ClearMsg();"   <?=$OnField?> > 
	 <?=$Config['Currency']?> 
	
		   </td>
		</tr>		
	<? } ?>	
	
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
 
 	
 
 } } 
 

 
 	$AllField = rtrim($AllField,"#");
 	$TotalLabel = rtrim($TotalLabel," + ");
 
 	$Total = round($Total);
	$TotalPM = round($Total/12);
	
	$NetPM = round(($Total - $LastActiveSubTotal)/12);
	
	
	$CurrentPM = $NetPM;
	$CurrentPM = round((($Total - $LastActiveSubTotal)/12) - $Deduction);
 ?>		                  
      
	  <tr>
		 <td  colspan="2" height="10" ></td>
	</tr>
	      
		<tr>
		 <td align="right"  class="head"  ><strong>GROSS (<?=$TotalLabel?>) :</strong></td>
		 <td align="left" class="head redmsg"> <span id="TotalDiv"><? if($Total>0) echo number_format($Total);  else echo '0'; ?></span> <?=$Config['Currency']?> 
		 
		 <input type="hidden" name="CTC" id="CTC" value="<?=$Total?>" >
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
	<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
	<tr>
		 <td align="right"  class="head"  ><strong>CURRENT MONTH SALARY :</strong></td>
		 <td align="left" class="head redmsg"> <span id="CurrentDiv"><? if($CurrentPM>0) echo number_format($CurrentPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="CurrentSalary" id="CurrentSalary" value="<?=$CurrentPM?>" >
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
	var FieldName,FieldValue,FieldValueTemp,HeadType,AmtPer,FieldLabel,catGrade,SubTotalA=0,SubTotalB=0,SubTotalC=0,SubTotalD=0,Total=0;
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
				FieldValueTemp = parseInt(document.getElementById(FieldName).value);
				if(FieldValueTemp!='' && !isNaN(FieldValueTemp)){
					FieldValue = Math.round(FieldValueTemp);
				}
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
			if(catGrade=="D") SubTotalD += FieldValue;
		
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
		if(document.getElementById("SubTotalD") != null){
			document.getElementById("SubTotalD").value = SubTotalD;
		}
		
		if(document.getElementById("TotalDiv") != null){
			Total = Math.round(Total); 
			document.getElementById("TotalDiv").innerHTML = number_format(Total) ;
			document.getElementById("CTC").value = Total;
		}
		if(document.getElementById("TotalPmDiv") != null){
		    var TotalPm = Math.round(Total/12); 
			document.getElementById("TotalPmDiv").innerHTML = number_format(TotalPm) ;
			document.getElementById("Gross").value = TotalPm;
		}
		if(document.getElementById("NetDiv") != null){
		    var NetSalary = Math.round((Total - SubTotalC)/12); 
			document.getElementById("NetDiv").innerHTML = number_format(NetSalary) ;
			document.getElementById("NetSalary").value = NetSalary;
		}
		if(document.getElementById("CurrentDiv") != null){
		    var CurrentSalary = Math.round(((Total - SubTotalC)/12)-SubTotalD); 
			document.getElementById("CurrentDiv").innerHTML = number_format(CurrentSalary) ;
			document.getElementById("CurrentSalary").value = CurrentSalary;
		}
		
			
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
		for(var i = 1; i < arrField.length; i++) {
			var arrField2 = arrField[i].split(",");
			FieldName = arrField2[0];
			FieldLabel = arrField2[3];
			if(!ValidateOptSalary(document.getElementById(FieldName),FieldLabel)){
				return false;
			}
		}	
	
		return true;
				
	}
	
	
}


</SCRIPT>