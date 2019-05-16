
<? $HideUnwanted = 'style="display:none;"';?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
			   
			 <?	 if($ShowList==1){ ?>  
	
	<tr>
		 <td class="had" style="text-align:center">Salary slip for the period of <?=date('F, Y', strtotime($_GET['y'].'-'.$_GET['m'].'-01'))?></td>
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
<tr>
		 <td align="left" class="head">Salary Details</td>
	</tr> 
 <tr> 
 <td  valign="top"  >
				  
<table width="49%" border="0" cellpadding="5" cellspacing="0"  style="float:left; border-top:none;" class="borderall" >

				
<? 
$AllField = ''; $Total = 0; $Deduction = 0; 
foreach($arryPayCategory as $key=>$values_cat){
	$arryHead = $objPayroll->getHead('',$values_cat['catID'],1);
	if(sizeof($arryHead)>0 || $values_cat['catGrade']=="D"){

	if($values_cat['Status']==1){
		$TotalLabel .= $values_cat['catGrade'].' + ';
		//$OnField = 'class="disabled" readonly=""';
	}else{
		//$OnField = 'class="textbox" onblur="Javascript:SetFormValues(\'1\');"';
	}
	
	$OnField = 'class="disabled" readonly=""';
	
	
	if($values_cat['catGrade']=="C"){
		echo '</table><table width="49%" border="0" cellpadding="5" class="borderall" cellspacing="0" style="float:right; border-top:none; " >';
	}
	
	
?>			
	 <tr>
		 <td colspan="2" align="left" class="head3"><?=stripslashes($values_cat['catName'])?></td>
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
		  <td align="left" width="70%" class="blackbold"><?=stripslashes($values['heading'])?> <?=stripslashes($values['subheading'])?> :<?=$Mand?></td>
		  <td align="right" >
		<? if($FieldValue>0) echo number_format($FieldValue);  else echo '0'; ?>
		   </td>
		</tr>		
	<? } ?>	
	
	
	<? if($values_cat['catGrade']=="D"){
	
		$SubTotal += $arrySalary[0]['LeaveDeduction'];
		$SubTotal += $arrySalary[0]['Advance'];
		$SubTotal += $arrySalary[0]['Loan'];
	 ?>
	 
	 <? if($arrySalary[0]['Advance']>0){ ?>
	 <tr>
		  <td align="left" class="blackbold">Advance : </td>
		  <td align="right" >
			<?  echo number_format($arrySalary[0]['Advance']); ?>

		   </td>
		</tr>
		<? } ?>
		<? if($arrySalary[0]['Loan']>0) { ?>
		<tr>
		  <td align="left" class="blackbold">Loan : </td>
		  <td align="right" >
			<? echo number_format($arrySalary[0]['Loan']); ?>

		   </td>
		</tr>
		<? } ?>
	<tr>
		  <td align="left" class="blackbold">Leave Deduction : </td>
		  <td align="right" >
			<? if($arrySalary[0]['LeaveDeduction']>0) echo number_format($arrySalary[0]['LeaveDeduction']);  else echo '0'; ?>

		   </td>
		</tr>
	<? } ?>	
	
	<tr>
		 <td align="left"  class="blackbold" ><strong>SUB TOTAL - <?=$values_cat['catGrade']?> :</strong></td>
		 <td align="right" ><strong> <? if($SubTotal>0) echo number_format($SubTotal);  else echo '0'; ?>
		  <?=$Config['Currency']?> </strong></td>
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
 
 	$Total = $arrySalary[0]['Gross'];  //$Total = round($Total);
	$TotalPM = $Total;  //round($Total/12);
	
	$NetPM = $arrySalary[0]['NetSalary']; //$NetPM = round($Total - $LastActiveSubTotal);  //round(($Total - $LastActiveSubTotal)/12);
	
	
	$CurrentPM = $NetPM;
	$CurrentPM = $NetPM - $Deduction;
 ?>		                  
      
	
	</table>
		  
	</td></tr>
	
	</table>
	
		

</table>



	  
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
		<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
		<tr <?=$HideUnwanted?>>
		 <td align="right"  ><strong>GROSS (<?=$TotalLabel?>) :</strong></td>
		 <td align="right" > <span id="TotalDiv"><? if($Total>0) echo number_format($Total);  else echo '0'; ?></span> <?=$Config['Currency']?> 
		 
		 <input type="hidden" name="CTC" id="CTC" value="<?=$Total?>" >
		  </td>
	</tr>    	
		<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
		<tr>
		 <td align="right" ><strong>GROSS APPROX  PM :</strong></td>
		 <td align="right" > <span id="TotalPmDiv"><? if($TotalPM>0) echo number_format($TotalPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="Gross" id="Gross" value="<?=$TotalPM?>" >
		   </td>
	</tr>     
	<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
		<tr>
		 <td align="right"   ><strong>NET SALARY PM :</strong></td>
		 <td align="right" > <span id="NetDiv"><? if($NetPM>0) echo number_format($NetPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="NetSalary" id="NetSalary" value="<?=$NetPM?>" >
		   </td>
	</tr> 
	<tr>
		 <td  colspan="2" height="5" ></td>
	</tr>
	<tr>
		 <td align="right"   width="90%"   ><strong>CURRENT MONTH SALARY :</strong></td>
		 <td align="right" > <span id="CurrentDiv"><? if($CurrentPM>0) echo number_format($CurrentPM);  else echo '0'; ?></span> <?=$Config['Currency']?>
		 
		 <input type="hidden" name="CurrentSalary" id="CurrentSalary" value="<?=$CurrentPM?>" >
		   </td>
	</tr> 	  
		           
                  </table>
		  
				  
				  </td>
                </tr>
				
				<tr>
				<td align="center" valign="top" >

	<input type="hidden" name="payID" id="payID" value="<?=$_GET['edit']?>">  
	<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['emp']?>">

	<input type="hidden" name="BasicField" id="BasicField" value="<?=$BasicField?>" >

	<input type="hidden" name="Year" id="Year" value="<?=$_GET['y']?>">  
	<input type="hidden" name="Month" id="Month" value="<?=$_GET['m']?>">



				  </td>
		  </tr>
		  
		  
		  
<? } ?> 	

 </table>
 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
		 <td  colspan="2" height="20" ></td>
	</tr>
  <tr>
    <td align="left" width="75%">
	</td>
	<td style="border-top:1px solid #666;">
	<strong>Authorized Signature</strong>
	</td>
	</tr>
</table>
	
 

