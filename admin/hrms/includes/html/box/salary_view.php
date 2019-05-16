

<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
			   
			 <? if($_GET['emp']>0 && empty($ErrorMsg)){ ?>  
			 
		 <tr>
	  <td align="center" valign="top"  >
		 <? include("includes/html/box/emp_box.php"); ?>
	  </td>
	</tr>	 
		
			 
<? if($_GET['pop']!=1){ ?>
		<tr>
	  <td align="center" valign="top"  >
		 
	 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >
	 <tr>
		 <td colspan="4" align="left" class="head">Bank Details</td>
	</tr>   
	    <tr>
		 <td colspan="4" align="left">
			<div id="BankDiv"><?=$BankDivHtml?></div>
			</td>
	</tr> 
	   <!--tr>
		  <td align="left" class="blackbold" width="16%">Bank Name :</td>
		  <td align="left" width="42%" > <?=stripslashes($arrySalary[0]['BankName'])?> </td>
		  <td align="left" class="blackbold" width="16%">Account Name  : </td>
		  <td align="left" > <?=stripslashes($arrySalary[0]['AccountName'])?>	 </td>
		  
		</tr>
	   <tr>
		  <td align="left" class="blackbold"> Account Number  :</td>
		  <td align="left" ><?=stripslashes($arrySalary[0]['AccountNumber'])?> </td>
		   <td align="left" class="blackbold">Routing Number  : </td>
		  <td align="left" > <?=stripslashes($arrySalary[0]['IFSCCode'])?> </td>
		</tr-->	
	  </table>	 
		 
		 
		 
	  </td>
	</tr>
<? } ?>


 <tr <?=$hourlytrHide?>>
                  <td align="center" >
				
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall" >

	<tr>
	<td align="right"  class="blackbold" valign="top">Pay Cycle :</td>
	<td align="left" >
<?=$GlobalPayCycle?>

	</td>
	</tr>	

	<tr>
	<td align="right" width="45%" class="blackbold" valign="top">Pay Rate :</td>
	<td align="left" >
<?
	if($PayRate=="" || $PayRate=="H"){
		echo "Hourly";
		$YearlySalaryDisplay = 'style="display:none"';
	}else{ 
		echo "Salary";		
	}

if($arrySalary[0]['PayCycle']!=$GlobalPayCycle){ //unset if paycycle is different
	$arrySalary[0]['PayCycleRate']='';	
}

	?>

	</td>
	</tr>	

	<tr <?=$YearlySalaryDisplay?>>
	<td align="right" class="blackbold" valign="top">Yearly Salary :</td>
	<td align="left" >
		<?=$arrySalary[0]['CTC']?> <?=$Config['Currency']?> 
	</td>
	</tr>

	<tr>
	<td align="right" class="blackbold" valign="top">Hourly Rate :</td>
	<td align="left" >
		<?=$arrySalary[0]['HourRate']?>
	</td>
	</tr>

	<? if(!empty($arrySalary[0]['PayCycleRate'])){ ?>
	<tr <?=$YearlySalaryDisplay?>>
	<td align="right" class="blackbold" valign="top"><?=$GlobalPayCycle?> Rate :</td>
	<td align="left" >
		<?=$arrySalary[0]['PayCycleRate']?>
	</td>
	</tr>
	<? }?>


</table>

				  </td>
		</tr>


		 
			 
                 <tr <?=$monthlytrHide?> >
                  <td align="center" valign="top"  >
				  <div style="text-align:right;font-weight:bold"><?=SALARY_ANUM?></div>

				  
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
			$BasicField = $FieldName;
		}
		
		
		$AmtPer = ($values['HeadType']=="Percentage")?($values['Percentage']):($values['Amount']);
		
		$AllField .= $FieldName.','.$values['HeadType'].','.$AmtPer.','.stripslashes($values['heading']).','.$values_cat['catGrade'].'#';
		
		
		
		$FieldValue = $arrySalaryDb[$values['headID']];
		$SubTotal+=$FieldValue;
		if($values_cat['catGrade']=="C"){ $Deduction+=$FieldValue; }
	 ?>	
		  
	<tr>
		  <td align="right"  class="blackbold"><?=stripslashes($values['heading'])?> <?=stripslashes($values['subheading'])?> :</td>
		  <td align="left" >
		
	<input id="<?=$FieldName?>" name="<?=$FieldName?>" class="disabled"  value="<?=$FieldValue?>"  type="text"  readonly="" size="15"> 
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
		           
                  </table>
		  
				  
				  </td>
                </tr>
				
				
		  
		  
		  
<? } ?> 	
		
		
		
          
 </table>

