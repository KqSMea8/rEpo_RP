
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
		<? if($HideAdminPart != 1){ ?>
					<tr>
							<td  align="right"   class="blackbold" valign="top" > Department  :<span class="red">*</span> </td>
							<td   align="left" >

					<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','1');">
					  <option value="">--- Select ---</option>
					  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
					  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryLoan[0]['Department']){echo "selected";}?>>
					  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
					  </option>
					  <? } ?>
					</select></td>
						  </tr>

			   <tr>
					<td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
					<td  align="left" >
					<span id="EmpValue"></span>  <span id="SalValue"></span> <span id="SalValueCurrency" style="display:none"><b><?=$Config['Currency']?></b></span> 
					<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryLoan[0]['EmpID']?>" />
					<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
						
					
				<script language="javascript">
					EmpListSend('','1');
					</script>
							
					</td>
				  </tr>

		<? }else{ ?>
			<tr>
				  <td  class="blackbold" valign="top"   align="right" ><B>Net Salary :</B></td>
				  <td  align="left"   class="blacknormal" valign="top">
				<B><?=number_format($NetSalary)?> <?=$Config['Currency']?> </B>	
				  
				  </td>
				</tr>
		<? } ?>
		

			   
				<tr>
				  <td  class="blackbold" valign="top"   align="right" width="45%" >Loan Amount :<span class="red">*</span></td>
				<?php $arryLoan[0]['Amount']=$arryLoan[0]['Comment']='';?>
				  <td  align="left"   class="blacknormal" valign="top">
				<input id="Amount" name="Amount" class="datebox"  value="<?=$arryLoan[0]['Amount']?>"  type="text" maxlength="10" onkeypress="return isNumberKey(event);" size="15" autocomplete="off" > 
 <?=$Config['Currency']?> 	
				  
				  </td>
				</tr>
                	  


			<tr>
				  <td  class="blackbold" valign="top" align="right" >
				   Period :<span class="red">*</span>
				   </td>
				  <td  align="left"   class="blacknormal" valign="top">
				  
					<select name="ReturnPeriod" class="textbox" id="ReturnPeriod" >
					  <option value="">--- Select ---</option>
					  <? 
						for($i=6;$i<=36;$i++){
							$sel = ($arryLoan[0]['ReturnPeriod']==$i)?('selected'):('');
							echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
						}
						?>
					  
					</select> Months
			

				  </td>
				</tr>


	<tr>
          <td align="right"   class="blackbold" valign="top">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryLoan[0]['Comment'])?></textarea>	
			
			</td>
        </tr>

		<? if($HideAdminPart != 1){ ?>

		<tr>
		  <td  class="blackbold" valign="top" align="right" >Status :<span class="red">*</span></td>
		  <td  align="left"   class="blacknormal" valign="top">
		<input type="radio" name="Approved" id="Approved0" value="0" <?=($arryLoan[0]['Approved']=="0" || empty($arryLoan[0]['Approved']))?("checked"):("");?> onclick="Javascript:ShowIssueDate(0);"/>
		Pending<br>
		<input type="radio" name="Approved" id="Approved1" value="1" <?=($arryLoan[0]['Approved']=="1")?("checked"):("");?> onclick="Javascript:ShowIssueDate(1);"/>
		Approve<br>
		<input type="radio" name="Approved" id="Approved2" value="2"  <?=($arryLoan[0]['Approved']=="2")?("checked"):("");?> onclick="Javascript:ShowIssueDate(2);"/>
		Cancel<br>
		  
		<input type="hidden" name="EditApprove" id="EditApprove" value="1" />

		  </td>
		</tr>



<tr>
				  <td  class="blackbold" valign="top" align="right" >
				  <div id="IssueDateTitle" style="display:none;">Issue Date :<span class="red">*</span></div>
				  </td>
				  <td  align="left"   class="blacknormal" valign="top">
<div id="IssueDateVal" style="display:none;"> 
<script type="text/javascript">
$(function() {
$('#IssueDate').datepicker(
	{
	showOn: "both",
	dateFormat: 'yy-mm-dd', 
	yearRange: '<?=date("Y")?>:<?=date("Y")+5?>', 
	minDate: "+1M", 
	changeMonth: true,
	changeYear: true

	}
);
});
</script>
<? if($arryLoan[0]['IssueDate']>0) $IssueDate = $arryLoan[0]['IssueDate']; ?>
<input id="IssueDate" name="IssueDate" readonly="" class="datebox" value="<?=$IssueDate?>"  type="text" > 		  
	</div>			  
				  </td>
				</tr>



<tr>
				  <td  class="blackbold" valign="top" align="right" >
				  <div id="RateTitle" style="display:none;">Interest Rate :<span class="red">*</span></div>
				  </td>
				  <td  align="left"   class="blacknormal" valign="top">
<div id="RateVal" style="display:none;"> 
<input id="Rate" name="Rate" class="datebox" value="<?=$arryLoan[0]['Rate']?>"  type="text" maxlength="5" onkeypress="return isDecimalKey(event);"> 	%	 
</div>			  
				  </td>
				</tr>







		<? } ?>

</table>
<input type="hidden" name="NetSalary" id="NetSalary" value="<?=$NetSalary?>" />

