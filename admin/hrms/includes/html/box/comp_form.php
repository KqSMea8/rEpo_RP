
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
		<? if($HideAdminPart != 1){ ?>
					<tr>
							<td  align="right"   class="blackbold" valign="top" > Department  :<span class="red">*</span> </td>
							<td   align="left" >

					<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','1');">
					  <option value="">--- Select ---</option>
					  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
					  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryComp[0]['Department']){echo "selected";}?>>
					  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
					  </option>
					  <? } ?>
					</select></td>
						  </tr>

			   <tr>
					<td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
					<td  align="left" >
					<span id="EmpValue"></span>  <span id="SalValue"></span> <span id="SalValueCurrency" style="display:none"><b><?=$Config['Currency']?></b></span> 
					<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryComp[0]['EmpID']?>" />
					<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
						
					
				<script language="javascript">
					EmpListSend('','1');
					</script>
							
					</td>
				  </tr>

		<? }?>
			   

<tr>
				  <td  class="blackbold" valign="top" align="right" >
				  Working Date :<span class="red">*</span>
				  </td>
				  <td  align="left"   class="blacknormal" valign="top">
<script type="text/javascript">
$(function() {
$('#WorkingDate').datepicker(
	{
	showOn: "both",
	dateFormat: 'yy-mm-dd', 
	yearRange: '<?=date("Y")-3?>:<?=date("Y")?>', 
	maxDate: "-0D", 
	changeMonth: true,
	changeYear: true

	}
);
});
</script>
<? if($arryComp[0]['WorkingDate']>0) $WorkingDate = $arryComp[0]['WorkingDate']; ?>
<input id="WorkingDate" name="WorkingDate" readonly="" class="datebox" value="<?=$WorkingDate?>"  type="text" > 		  
			  
				  </td>
				</tr>


				<tr>
				  <td  class="blackbold" valign="top"   align="right" width="45%" >Working Hours :<span class="red">*</span></td>
				  <td  align="left"   class="blacknormal" valign="top">
				<input id="Hours" name="Hours" class="datebox"  value="<?=$arryComp[0]['Hours']?>"  type="text" maxlength="5" onkeypress="return isDecimalKey(event);" size="5" autocomplete="off" > 
	
				  
				  </td>
				</tr>
                	  

			


	<tr>
          <td align="right"   class="blackbold" valign="top">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="bigbox" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryComp[0]['Comment'])?></textarea>	
			
			</td>
        </tr>

		<? if($HideAdminPart != 1){ ?>

		<tr>
		  <td  class="blackbold" valign="top" align="right" >Status :<span class="red">*</span></td>
		  <td  align="left"   class="blacknormal" valign="top">
		<input type="radio" name="Approved" id="Approved0" value="0" <?=($arryComp[0]['Approved']=="0" || empty($arryComp[0]['Approved']))?("checked"):("");?> />
		Pending<br>
		<input type="radio" name="Approved" id="Approved1" value="1" <?=($arryComp[0]['Approved']=="1")?("checked"):("");?> />
		Approve<br>
		<input type="radio" name="Approved" id="Approved2" value="2"  <?=($arryComp[0]['Approved']=="2")?("checked"):("");?> />
		Cancel<br>
		  
		<input type="hidden" name="EditApprove" id="EditApprove" value="1" />

		  </td>
		</tr>







<tr>
				  <td  class="blackbold" valign="top" align="right" >
				  <div id="RateTitle" style="display:none;">Interest Rate :<span class="red">*</span></div>
				  </td>
				  <td  align="left"   class="blacknormal" valign="top">
<div id="RateVal" style="display:none;"> 
<input id="Rate" name="Rate" class="datebox" value="<?=$arryComp[0]['Rate']?>"  type="text" maxlength="5" onkeypress="return isDecimalKey(event);"> 	%	 
</div>			  
				  </td>
				</tr>







		<? } ?>

</table>
<input type="hidden" name="NetSalary" id="NetSalary" value="<?=$NetSalary?>" />

