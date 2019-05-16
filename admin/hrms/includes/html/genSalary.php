 <script language="javascript">
  	$(document).ready(function() {
		$("#Department").change(function(){
			$("#preview_div").hide();
		});
		$("#y").change(function(){
			$("#preview_div").hide();
		});
		$("#m").change(function(){
			$("#preview_div").hide();
		});

	});



$(function() {
	/*
	$('.empinfo').tooltip({
		position: {
			 at: "left bottom-10"
		},
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	*/

	$(".empinfo").hover(function(){   
		var EmpID = $(this).attr('alt');
		$("#ShowInfo_"+EmpID).slideToggle(600);
	});

});

</script>

<script language="JavaScript1.2" type="text/javascript">
	function ValidateSearch(){
		if(document.getElementById("catEmp").value==""){
				alert("Please Select Employee Category.");
				document.getElementById("catEmp").focus();
				return false;
		}

		if(document.getElementById("y").value==""){
			alert("Please Select Year.");
			document.getElementById("y").focus();
			return false;
		}
		if(document.getElementById("m").value==""){
			alert("Please Select Month.");
			document.getElementById("m").focus();
			return false;
		}
		var YearMonth = document.getElementById("y").value+document.getElementById("m").value;
		if(YearMonth >= document.getElementById("TodayDt").value){
			alert("Select year and month should be less than current month.");
			return false;
		}

		ShowHideLoader(1,'L');
	}	
</script>





  <div><a href="<?=$RedirectUrl?>" class="back">Back</a></div>
<div class="had">View Generated Salary &raquo; <span>
Generate Salary
</span>
</div>

  
<div>
<table  border="0" cellpadding="0" cellspacing="0"  id="search_table" style="margin:0">
 <form action="" method="get" name="form3" onSubmit="return ValidateSearch();">
	<tr>
		
		<td>
		<select name="Department" class="textbox" id="Department">
		  <option value="">--- All ---</option>
		  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
		  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$_GET['Department']){echo "selected";}?>>
		   <?=stripslashes($arrySubDepartment[$i]['Department'])?>
		  </option>
		  <? } ?>
		</select>		
		</td>
	 
   <td>
	   <select name="catEmp" class="textbox" id="catEmp" >
		<option value="">Select Category</option>
		  <? for($i=0;$i<sizeof($arryEmpCategory);$i++) {?>
		  <option value="<?=$arryEmpCategory[$i]['catID']?>" <?  if($arryEmpCategory[$i]['catID']==$_GET['catEmp']){echo "selected";}?>>
		  <?=$arryEmpCategory[$i]['catName']?>
		  </option>
		  <? } ?>
		 <option value="0" <?  if($_GET['catEmp']=="0"){echo "selected";}?>>Other</option>
		</select>
  </td>



		 <td><?=getYears($_GET['y'],"y","textbox")?></td>
			  
          <td><?=getMonths($_GET['m'],"m","textbox")?></td>
		 <td>
		 <input name="s" type="submit" class="search_button" value="Go"  />

		 <input type="hidden" name="TodayDt" id="TodayDt" value="<?=date("Ym", strtotime($Config['TodayDate']))?>" >


		 </td> 
		
	</tr>
	</form>		

</table>
</div>					



<div id="prv_msg_div" style="display:none"><br><img src="images/loading.gif">&nbsp;Loading..............</div>
<div id="preview_div" >	

<? if(!empty($ErrorMsg)){ ?> 
	  <div align="center" id="ErrorMsg" class="redmsg">
		 <br><?=$ErrorMsg?>
	  </div>
<? }else{ ?>


<? if($ShowList==1){ ?>
<br>
<form action="" method="post" name="form1">


 <? if($num>0){ ?>

 
 <div style="float:right;margin-bottom:5px;"><?=str_replace("[Currency]",$Config['Currency'],CURRENCY_INFO);?></div>
<div class="cb"></div>
 <div>
<input type="submit" name="GenButton" class="button" style="float:right;margin-bottom:5px;" value="Generate Salary" onclick="javascript: return ValidateMultiple('employee','generate salary','NumField','EmpID');">
</div>
<? } ?>


<br>
<table <?=$table_bg?> >
   
    <tr align="left"  >
       <td width="15%" class="head" >Employee</td>
       <td width="7%"  class="head">GROSS</td>
       <td width="8%"  class="head">Net Salary</td>
		<?
			$arryHead = $objPayroll->getHead('',4,$_GET['catEmp'],1);
			if(sizeof($arryHead)>0){
				foreach($arryHead as $key=>$values){
					echo '<td class="head">'.stripslashes($values['heading']).'</td>';
					
				}
			}

			if($arryCurrentLocation[0]['Advance']==1){ 
				echo '<td width="5%" class="head">Advance</td>';
			}
			if($arryCurrentLocation[0]['Loan']==1){ 
				echo '<td width="5%" class="head">Loan</td>';
			}
			#echo '<td width="5%" class="head">Leave Taken</td>';
			#echo '<td width="10%" class="head">Amount to Deduct for Leave</td>';
			echo '<td width="6%" class="head">Leave To Deduct</td>';
			echo '<td width="10%" class="head">Leave Deduction</td>';

			echo '<td width="5%" class="head">Arrear</td>';
			if($arryCurrentLocation[0]['Overtime']==1){ 
				echo '<td width="5%" class="head">Overtime</td>';
			}
			if($arryCurrentLocation[0]['Bonus']==1){ 
				echo '<td width="5%" class="head">Bonus</td>';
			}

		?>
       <td width="6%"  class="head" align="center">Current Salary</td>
       <td width="4%"  align="center" class="head" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','EmpID','<?=sizeof($arryEmployee)?>');" />
	  </td>
    </tr>
   





    <?php 
  if(is_array($arryEmployee) && $num>0){
	$flag=true;
	$Line=0; $AdvanceData = '';  $LoanData = ''; $BonusIDs = ''; $CompIDs = '';
	foreach($arryEmployee as $key=>$values_emp){
	$flag=!$flag;
	$Line++;
	$Deduction=0; $FieldValue=0; $AllField = '';

	/*****************/
	
	$MainWorkingHour = $WorkingHour;
	if(!empty($values_emp['WorkingHourStart']) && !empty($values_emp['WorkingHourEnd'])){
		$MainWorkingHour = $objTime->GetTimeDifference($values_emp['WorkingHourStart'],$values_emp['WorkingHourEnd'],1);
	}




	$CurrentPM = $values_emp["NetSalary"];
	$LeaveTakenMonth = $objLeave->getLeaveByMonth($values_emp['EmpID'],$_GET['y'],$_GET['m'],"'Approved','Taken'",'');
	$ShortLeave = $objLeave->getShortLeave($values_emp['EmpID'],$_GET['y'],$_GET['m']);
	/*****************/
	$arryComp = $objLeave->getActiveComp($values_emp['EmpID'],$_GET['y'],$_GET['m']);
	$TotalComp = sizeof($arryComp);
	if($TotalComp>0 && $LeaveTakenMonth>0){
		$LeaveTakenMonth = $LeaveTakenMonth - $TotalComp;
		foreach($arryComp as $key=>$values){
			$CompIDs .= $values['CompID'].',';
		}		
	}

	$LeaveMonth = $LeaveTakenMonth;
	/********************/
	$SalaryData = $values_emp['SalaryData'];
	unset($arrySalaryDb);
	if(!empty($SalaryData)){
		$arrySalaryData = explode("#",$SalaryData);
		foreach($arrySalaryData as $values_sal){
			$arryIDSalary = explode(":",$values_sal);
			$arrySalaryDb[$arryIDSalary[0]] = $arryIDSalary[1]/12;
		}
	}
	/********************/
	$BasicSalary = round($arrySalaryDb[1],2);

	$PerDaySalary = round($CurrentPM/$NumDayMonth);
    $PerHourSalary =  round($PerDaySalary / $MainWorkingHour, 2);

	/*******************/
	$ShortLeaveExtra=0; $ShortLeaveAmountToDeduct=0; $LeaveAmountToDeduct=0;
	if($ShortLeave>0 && $arryCurrentLocation[0]['SL_Deduct']==1){
		$ShortLeaveExtra = $ShortLeave - $arryCurrentLocation[0]['MaxShortLeave'];
		if($ShortLeaveExtra>0){
			$ShortLeaveExtra = $ShortLeaveExtra/2;
			#$LeaveTakenMonth = $LeaveTakenMonth + $ShortLeaveExtra;
			$ShortLeaveAmountToDeduct = $ShortLeaveExtra*$PerDaySalary;
		}
	}
	if($LeaveTakenMonth>0 || $ShortLeaveAmountToDeduct>0){
		$LeaveAmountToDeduct = $LeaveTakenMonth*$PerDaySalary;
	}
	if($ShortLeaveExtra>0){
		$LeaveTakenMonth = $LeaveTakenMonth + $ShortLeaveExtra;
	}
	/*******************/
	if($LeaveTakenMonth<=0) $LeaveTakenMonth=0;
  ?>
    <tr align="left">
	<td>
		<a class="fancybox empinfo fancybox.iframe" href="empInfo.php?view=<?=$values_emp['EmpID']?>" alt="<?=$values_emp['EmpID']?>"><?=$values_emp["EmpCode"]?></a>	
		<br><?=stripslashes($values_emp['UserName'])?> 

		<div id="ShowInfo_<?=$values_emp['EmpID']?>" class="showPopInfo" >

		<? 
		   echo '<div class="PopImg">';
                   $MainDir = "upload/employee/".$_SESSION['CmpID']."/";
		   if($values_emp['Image'] !='' && file_exists($MainDir.$values_emp['Image']) ){ 
			 echo '<img src="resizeimage.php?w=70&h=70&img='.$MainDir.$values_emp['Image'].'" border=0 >';
		   }else{ 
			 echo '<img src="../../resizeimage.php?w=70&h=70&img=images/nouser.gif" border=0/>';
		   } 
		 
		  echo '</div><div class="PopContent">Designation : '.stripslashes($values_emp["JobTitle"]).'
			<br>Department : '.stripslashes($values_emp["Department"]).'
			<br>Leave : '.$LeaveMonth;
			if($ShortLeave>0){ 
				echo '<br>Short Leave : '.$ShortLeave.'<br>Total Leave : '.$LeaveTakenMonth;
			}
          echo '</div>';
		 ?>
			

		</div>
		
	</td>

	<td><? if($values_emp["Gross"]>0) echo number_format($values_emp["Gross"]); ?></td>
	<td><? if($values_emp["NetSalary"]>0) echo number_format($values_emp["NetSalary"]); ?>
		<input type="hidden" name="BasicSalary_<?=$values_emp['EmpID']?>" id="BasicSalary_<?=$values_emp['EmpID']?>" value="<?=$BasicSalary?>" >
	
		<input type="hidden" name="NetSalary_<?=$values_emp['EmpID']?>" id="NetSalary_<?=$values_emp['EmpID']?>" value="<?=round($values_emp["NetSalary"])?>" >
	</td>
	<?
	/******************************/
	if(sizeof($arryHead)>0){
		
		foreach($arryHead as $key=>$values){
			$FieldName = 'Field'.$values['headID'].'_'.$values_emp['EmpID'];

			$AmtPer = ($values['HeadType']=="Percentage")?($values['Percentage']):($values['Amount']);
			$AllField .= $FieldName.','.$values['HeadType'].','.$AmtPer.','.stripslashes($values['heading']).',D#';

			$FieldValue = ($values['HeadType']=="Percentage")?(($BasicSalary*$values['Percentage'])/100):($values['Amount']);
			$FieldValue = round($FieldValue,2);
			$Deduction += $FieldValue;

			echo '<td><input id="'.$FieldName.'" name="'.$FieldName.'"  value="'.$FieldValue.'"  type="text" maxlength="10" size="8"  class="textbox" onblur="Javascript:SetFormValues(\''.$values_emp['EmpID'].'\');" onkeypress="return isDecimalKey(event);" ></td>';					
		}
		$AllField = rtrim($AllField,"#");
	}	
	/******************************/
	if($arryCurrentLocation[0]['Advance']==1){ 
			$arryAdvance=$objPayroll->getActiveAdvance($values_emp['EmpID'],$_GET['y'],$_GET['m']);
			$TotalAdvanceAmount=0;  
			if(sizeof($arryAdvance)>0){
				foreach($arryAdvance as $key=>$values){
					$AdvanceAmount = 0;
					if(!empty($values['Amount'])){
						$AdvanceAmount = $values['Amount'] / $values['ReturnPeriod'];
						$TotalAdvanceAmount += $AdvanceAmount;
						$AdvanceData .= $values['AdvID'].':'.round($AdvanceAmount,2).'#';
					}

				}
			}
		echo '<td><input type="text" class="disabled" readonly name="Advance_'.$values_emp['EmpID'].'" id="Advance_'.$values_emp['EmpID'].'" value="'.round($TotalAdvanceAmount,2).'" size="8"></td>'; 
		$Deduction += round($TotalAdvanceAmount,2);
	}
	/******************************/
	if($arryCurrentLocation[0]['Loan']==1){ 
		$arryLoan=$objPayroll->getActiveLoan($values_emp['EmpID'],$_GET['y'],$_GET['m']);
		$TotalLoanAmount=0;
		if(sizeof($arryLoan)>0){
			foreach($arryLoan as $key=>$values){
				$LoanAmount = 0;
				if(!empty($values['Amount'])){
					$Rate = ($values['Amount'] * $values['Rate']) / 100;
					$LoanAmount = ($values['Amount'] + $Rate) / $values['ReturnPeriod'];
					$TotalLoanAmount += $LoanAmount;
					$LoanData .= $values['LoanID'].':'.round($LoanAmount,2).'#';
				}

			}
		}
		echo '<td><input type="text" class="disabled" readonly name="Loan_'.$values_emp['EmpID'].'" id="Loan_'.$values_emp['EmpID'].'" value="'.round($TotalLoanAmount,2).'" size="8"></td>'; 
		$Deduction += round($TotalLoanAmount,2);
	}
	/******************************/
	
	#echo '<td>'.$LeaveTakenMonth.'</td>'; 	
	$ToDeductForLeave = round($LeaveAmountToDeduct+$ShortLeaveAmountToDeduct);
	
	echo '<td>';
	 if($LeaveTakenMonth>0){
		echo '<div class="select-wrap"><select name="LeaveDeducted_'.$values_emp['EmpID'].'" id="LeaveDeducted_'.$values_emp['EmpID'].'" onchange="Javascript:SetFormValues(\''.$values_emp['EmpID'].'\');">';
		for($i=0;$i<=$LeaveTakenMonth;$i=$i+0.5){
		  $sel = ($arrySalary[0]['LeaveDeducted']==$i)?('selected'):('');
		echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
		}
		echo '</select></div>';
	 }
	echo '</td>
	<td><input id="LeaveDeduction_'.$values_emp['EmpID'].'" name="LeaveDeduction_'.$values_emp['EmpID'].'"  value="0"  type="text" maxlength="10" size="8" onkeypress="return isDecimalKey(event);" class="disabled" readonly onblur="Javascript:SetFormValues(\''.$values_emp['EmpID'].'\');"><input type="hidden" class="disabled" readonly name="LeaveTaken_'.$values_emp['EmpID'].'" id="LeaveTaken_'.$values_emp['EmpID'].'" value="'.$LeaveTakenMonth.'" size="4"></td>';



	echo '<td><input type="text" class="textbox" name="Arrear_'.$values_emp['EmpID'].'" id="Arrear_'.$values_emp['EmpID'].'" value="'.round($Arrear,2).'" size="8" maxlength="10" onblur="Javascript:SetFormValues(\''.$values_emp['EmpID'].'\');"></td>'; 
	$CurrentPM += round($Arrear);
	/******************************/
	if($arryCurrentLocation[0]['Overtime']==1){ 
		$arryOvertime=$objTime->getTotalOvertime($values_emp['EmpID'],$_GET['y'],$_GET['m']);
		$TotalOvertimeHour = $arryOvertime[0]['TotalHour'];
		$TotalHoursRate = $arryOvertime[0]['TotalHoursRate'];
		$TotalOvertime = $PerHourSalary*$TotalHoursRate;

		echo '<td><input type="text" class="disabled" readonly name="Overtime_'.$values_emp['EmpID'].'" id="Overtime_'.$values_emp['EmpID'].'" value="'.round($TotalOvertime).'" size="8"></td>'; 
		$CurrentPM += round($TotalOvertime);
	}
	/******************************/
	if($arryCurrentLocation[0]['Bonus']==1){ 
		$arryBonus = $objPayroll->getTotalBonus($values_emp['EmpID'],$_GET['y'],$_GET['m']);
		$TotalBonus=0;
		if(sizeof($arryBonus)>0){
			foreach($arryBonus as $key=>$values){
				$TotalBonus += $values['Amount'];
				$BonusIDs .= $values['BonusID'].',';
			}			
		}
		echo '<td><input type="text" class="disabled" readonly name="Bonus_'.$values_emp['EmpID'].'" id="Bonus_'.$values_emp['EmpID'].'" value="'.round($TotalBonus,2).'" size="8"></td>'; 
		$CurrentPM += round($TotalBonus);
	}
	/******************************/
	
	?>
	<td align="center">
	<? $CurrentPM = $CurrentPM - round($Deduction) ; ?>
	<div id="CurrentDiv_<?=$values_emp['EmpID']?>" style="font-weight:bold"><? if($CurrentPM>0) echo number_format($CurrentPM); ?></div>
	<input type="hidden" name="CurrentSalary_<?=$values_emp['EmpID']?>" id="CurrentSalary_<?=$values_emp['EmpID']?>" value="<?=round($CurrentPM)?>" >
	<input type="hidden" name="PerDaySalary_<?=$values_emp['EmpID']?>" id="PerDaySalary_<?=$values_emp['EmpID']?>" value="<?=round($PerDaySalary)?>" >

	<input type="hidden" name="catEmp_<?=$values_emp['EmpID']?>" id="catEmp_<?=$values_emp['EmpID']?>" value="<?=$values_emp['catEmp']?>" >


	<input type="hidden" name="AllField_<?=$values_emp['EmpID']?>" id="AllField_<?=$values_emp['EmpID']?>" value="<?=$AllField?>" >
	</td>

	<td align="center">
	  	  <input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$values_emp['EmpID']?>" />
    </td>
    </tr>
    <?php 
		unset($arrySalaryDb);
	
	} // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="40" class="no_record"><?=NO_EMP_TO_PAY?></td>
    </tr>
    <?php } ?>
  
  
<tr >  <td  colspan="40" id="td_pager">Total Record(s) : &nbsp;<?php echo $num;?>  &nbsp;<?php if(count($arryEmployee)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink; }?>
  </td>
  </tr>
  </table>
	<?
	$BonusIDs = rtrim($BonusIDs,",");
	$CompIDs = rtrim($CompIDs,",");
	?>
   <input type="hidden" name="NumField" id="NumField" value="<?=$Line?>">
   <input type="hidden" name="Year" id="Year" value="<?=$_GET["y"]?>">
   <input type="hidden" name="Month" id="Month" value="<?=$_GET["m"]?>">
   <input type="hidden" name="AdvanceData" id="AdvanceData" value="<?=$AdvanceData?>">
   <input type="hidden" name="LoanData" id="LoanData" value="<?=$LoanData?>">
	<input type="hidden" name="BonusIDs" id="BonusIDs" value="<?=$BonusIDs?>">
	<input type="hidden" name="CompIDs" id="CompIDs" value="<?=$CompIDs?>">

   </form>
 <? } ?>








<? } ?>
</div>
		
		

<SCRIPT LANGUAGE=JAVASCRIPT>
function SetFormValues(EmpID){
	var FieldName,FieldValue,FieldValueTemp,HeadType,AmtPer,FieldLabel,catGrade,SubTotalA=0,SubTotalB=0,SubTotalC=0,SubTotalD=0,
		Total=0,LeaveDeduction=0,Advance=0,Loan=0,LeaveDeducted=0,PerDaySalary=0;
	var NetSalary = document.getElementById("NetSalary_"+EmpID).value;

	var allField = Trim(document.getElementById("AllField_"+EmpID)).value;
	var BasicSalary = Trim(document.getElementById("BasicSalary_"+EmpID)).value;
	var arrField = allField.split("#");

	var opt = 1;
	
	if(BasicSalary!='' && !isNaN(BasicSalary)){
		
		for(var i = 0; i < arrField.length; i++) {
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
			
	}




	/*************************/
	if(document.getElementById("LeaveDeducted_"+EmpID) != null){
		LeaveDeducted = parseFloat(document.getElementById("LeaveDeducted_"+EmpID).value);
		PerDaySalary = parseFloat(document.getElementById("PerDaySalary_"+EmpID).value);
		LeaveDeduction = LeaveDeducted*PerDaySalary;
		document.getElementById("LeaveDeduction_"+EmpID).value = Math.round(LeaveDeduction,2);
	}
	/*************************/
	LeaveDeduction = parseFloat(document.getElementById("LeaveDeduction_"+EmpID).value);
	if(LeaveDeduction!='' && !isNaN(LeaveDeduction)){
		SubTotalD += LeaveDeduction;
	}else{
		LeaveDeduction=0;
	}
	document.getElementById("LeaveDeduction_"+EmpID).value = LeaveDeduction;
	/*************************/
	if(document.getElementById("Advance_"+EmpID) != null){
		Advance = parseFloat(document.getElementById("Advance_"+EmpID).value);
		if(Advance!='' && !isNaN(Advance)){
			//Advance = Math.round(Advance);
			SubTotalD += Advance;
		}else{
			Advance=0;
		}
		document.getElementById("Advance_"+EmpID).value = Advance;
	}
	/*************************/
	if(document.getElementById("Loan_"+EmpID) != null){
		Loan = parseFloat(document.getElementById("Loan_"+EmpID).value);
		if(Loan!='' && !isNaN(Loan)){
			//Loan = Math.round(Loan);
			SubTotalD += Loan;
		}else{
			Loan=0;
		}
		document.getElementById("Loan_"+EmpID).value = Loan;
	}
	/*************************/
	
	/*************************/
	var CurrentSalary = NetSalary-Math.round(SubTotalD); 


	if(document.getElementById("Arrear_"+EmpID) != null){
		CurrentSalary = CurrentSalary + Math.round(document.getElementById("Arrear_"+EmpID).value);
	}	
	if(document.getElementById("Overtime_"+EmpID) != null){
		CurrentSalary = CurrentSalary + Math.round(document.getElementById("Overtime_"+EmpID).value);
	}
	if(document.getElementById("Bonus_"+EmpID) != null){
		CurrentSalary = CurrentSalary + Math.round(document.getElementById("Bonus_"+EmpID).value);
	}
	document.getElementById("CurrentDiv_"+EmpID).innerHTML = number_format(CurrentSalary) ;
	document.getElementById("CurrentSalary_"+EmpID).value = CurrentSalary;
	
}
</SCRIPT>
	   

