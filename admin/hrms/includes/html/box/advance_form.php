<SCRIPT LANGUAGE=JAVASCRIPT>


function ShowReturnDiv(ret_type)
{
	if(ret_type==2){
		$("#ReturnPeriodTitle").show();
		$("#ReturnPeriodVal").show();
		$("#ReturnDateTitle").hide();
		$("#ReturnDateVal").hide();
		$("#ReturnDate").val("");
	}else{
		$("#ReturnPeriodTitle").hide();
		$("#ReturnPeriodVal").hide();
		$("#ReturnDateTitle").show();
		$("#ReturnDateVal").show();
		$("#ReturnPeriod").val("");
	}

}
</SCRIPT>

<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
		<? if($HideAdminPart != 1){ ?>
					<tr>
							<td  align="right"   class="blackbold" valign="top" > Department  :<span class="red">*</span> </td>
							<td   align="left" >

					<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','1');">
					  <option value="">--- Select ---</option>
					  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
					  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryAdvance[0]['Department']){echo "selected";}?>>
					  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
					  </option>
					  <? } ?>
					</select></td>
						  </tr>

			   <tr>
					<td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
					<td  align="left" >
					<span id="EmpValue"></span>  <span id="SalValue"></span> <span id="SalValueCurrency" style="display:none"><b><?=$Config['Currency']?></b></span> 
					<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryAdvance[0]['EmpID']?>" />
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
				  <td  class="blackbold" valign="top"   align="right" width="45%" >Amount :<span class="red">*</span></td>
				  <td  align="left"   class="blacknormal" valign="top">
				<input id="Amount" name="Amount" class="datebox"  value="<?=$arryAdvance[0]['Amount']?>"  type="text" maxlength="10" onkeypress="return isNumberKey(event);" size="15" autocomplete="off" > 
 <?=$Config['Currency']?> 	
				  
				  </td>
				</tr>
                	  



				<tr>
				  <td  class="blackbold" valign="top" align="right" >Return Type :<span class="red">*</span></td>
				  <td  align="left"   class="blacknormal" valign="top">
 <input type="radio" name="ReturnType" id="ReturnType1" value="1" <?=($arryAdvance[0]['ReturnType']=="1" || empty($arryAdvance[0]['ReturnType']))?("checked"):("");?> onClick="Javascript:ShowReturnDiv(1);"/>
	  <?=RETURN_ONE?><br>
	  <input type="radio" name="ReturnType" id="ReturnType2" value="2"  <?=($arryAdvance[0]['ReturnType']=="2")?("checked"):("");?>  onClick="Javascript:ShowReturnDiv(2);"/>
	  <?=RETURN_INSTALLMENT?>				
				  
				  </td>
				</tr>

			<tr>
				  <td  class="blackbold" valign="top" align="right" >
				  <div id="ReturnDateTitle" style="display:none;">Return Date :<span class="red">*</span></div>
				  </td>
				  <td  align="left"   class="blacknormal" valign="top">
<div id="ReturnDateVal" style="display:none;"> 
<script type="text/javascript">
$(function() {
$('#ReturnDate').datepicker(
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
<input id="ReturnDate" name="ReturnDate" readonly="" class="datebox" value="<?=$arryAdvance[0]['ReturnDate']?>"  type="text" > 	</div>			  
				  </td>
				</tr>

			<tr>
				  <td  class="blackbold" valign="top" align="right" >
				   <div id="ReturnPeriodTitle" style="display:none;">Return Period :<span class="red">*</span></div>
				   </td>
				  <td  align="left"   class="blacknormal" valign="top">
				   <div id="ReturnPeriodVal" style="display:none;">
					<select name="ReturnPeriod" class="textbox" id="ReturnPeriod" >
					  <option value="">--- Select ---</option>
					  <? 
						for($i=1;$i<=36;$i++){
							$sel = ($arryAdvance[0]['ReturnPeriod']==$i)?('selected'):('');
							echo '<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
						}
						?>
					  
					</select> Months
				</div>

				  </td>
				</tr>


	<tr>
          <td align="right"   class="blackbold" valign="top">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryAdvance[0]['Comment'])?></textarea>	
			
			</td>
        </tr>

		<? if($HideAdminPart != 1){ ?>

		<tr>
		  <td  class="blackbold" valign="top" align="right" >Status :<span class="red">*</span></td>
		  <td  align="left"   class="blacknormal" valign="top">
		<input type="radio" name="Approved" id="Approved0" value="0" <?=($arryAdvance[0]['Approved']=="0" || empty($arryAdvance[0]['Approved']))?("checked"):("");?> onclick="Javascript:ShowIssueDate(0);"/>
		Pending<br>
		<input type="radio" name="Approved" id="Approved1" value="1" <?=($arryAdvance[0]['Approved']=="1")?("checked"):("");?> onclick="Javascript:ShowIssueDate(1);"/>
		Approve<br>
		<input type="radio" name="Approved" id="Approved2" value="2"  <?=($arryAdvance[0]['Approved']=="2")?("checked"):("");?> onclick="Javascript:ShowIssueDate(2);"/>
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
<? if($arryAdvance[0]['IssueDate']>0) $IssueDate = $arryAdvance[0]['IssueDate']; ?>
<input id="IssueDate" name="IssueDate" readonly="" class="datebox" value="<?=$IssueDate?>"  type="text" > 	</div>			  
				  </td>
				</tr>









		<? } ?>

</table>
<input type="hidden" name="NetSalary" id="NetSalary" value="<?=$NetSalary?>" />


<SCRIPT LANGUAGE=JAVASCRIPT>
ShowReturnDiv('<?=$ReturnType?>');
</SCRIPT>