
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
		<? if($HideAdminPart != 1){ ?>
					<tr>
							<td  align="right"   class="blackbold" valign="top" > Department  :<span class="red">*</span> </td>
							<td   align="left" >

					<select name="Department" class="inputbox" id="Department" onChange="Javascript:EmpListSend('','');">
					  <option value="">--- Select ---</option>
					  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
					  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryExpenseClaim[0]['Department']){echo "selected";}?>>
					  <?=stripslashes($arrySubDepartment[$i]['Department'])?>
					  </option>
					  <? } ?>
					</select></td>
						  </tr>

			   <tr>
					<td  align="right"  class="blackbold" valign="top"><div id="EmpTitle">Employee  :<span class="red">*</span></div> </td>
					<td  align="left" >
					<span id="EmpValue"></span>  <span id="SalValue"></span> <span id="SalValueCurrency" style="display:none"><b><?=$Config['Currency']?></b></span> 
					<input type="hidden" name="OldEmpID" id="OldEmpID" value="<?=$arryExpenseClaim[0]['EmpID']?>" />
					<input type="hidden" name="EmpStatus" id="EmpStatus" value="1" />	
						
					
				<script language="javascript">
					EmpListSend('','');
					</script>
							
					</td>
				  </tr>

			
		<? } ?>
		

			   

				<tr>
				  <td  class="blackbold" valign="top"   align="right" width="45%" >Expense Reason :<span class="red">*</span></td>
				  <td  align="left"   class="blacknormal" valign="top">
				<input id="ExpenseReason" name="ExpenseReason" class="inputbox"  value="<?=stripslashes($arryExpenseClaim[0]['ExpenseReason'])?>"  type="text" maxlength="30" onkeypress="return isAlphaKey(event);" size="15"  > 

				  
				  </td>
				</tr>

				<tr>
				  <td  class="blackbold" valign="top"   align="right">Claim Amount :<span class="red">*</span></td>
				  <td  align="left"   class="blacknormal" valign="top">
				<input id="ClaimAmount" name="ClaimAmount" class="datebox"  value="<?=$arryExpenseClaim[0]['ClaimAmount']?>"  type="text" maxlength="10" onkeypress="return isNumberKey(event);" size="15" autocomplete="off" > 
 <?=$Config['Currency']?> 	
				  
				  </td>
				</tr>
                	  
			<tr>
				  <td  class="blackbold" valign="top" align="right" >
				 Expense Date :<span class="red">*</span>
				  </td>
				  <td  align="left"   class="blacknormal" valign="top">
<script type="text/javascript">
$(function() {
$('#ExpenseDate').datepicker(
	{
	showOn: "both",
	dateFormat: 'yy-mm-dd', 
	yearRange: '<?=date("Y")-1?>:<?=date("Y")?>', 
	maxDate: "0D", 
	changeMonth: true,
	changeYear: true

	}
);
});
</script>
<? if($arryExpenseClaim[0]['ExpenseDate']>0) $ExpenseDate = $arryExpenseClaim[0]['ExpenseDate']; ?>
<input id="ExpenseDate" name="ExpenseDate" readonly="" class="datebox" value="<?=$ExpenseDate?>"  type="text" > 		  
		  
				  </td>
	</tr>

	<tr>
          <td align="right"   class="blackbold" valign="top">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryExpenseClaim[0]['Comment'])?></textarea>	
			
		</td>
        </tr>


 <tr>
                    <td  class="blackbold" valign="top"   align="right"> Upload Bill :</td>
                    <td  align="left"   class="blacknormal" valign="top"><input name="document" type="file" class="inputbox"  id="document"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" /> <?=SUPPORTED_SCAN_DOC?>
					
					
					 <? 
			  $document = stripslashes($arryExpenseClaim[0]['document']);
                          $MainDir = "upload/document/".$_SESSION['CmpID']."/";
				  if($document !='' && file_exists($MainDir.$document) ){ ?>			
			
<div  id="DocDiv" style="padding:10px 0 10px 0;">	
<?=$document?>&nbsp;&nbsp;&nbsp;
<a href="dwn.php?file=<?=$MainDir.$document?>" class="download">Download</a> 
	<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$document?>','DocDiv')">
	<?=$delete?></a>
</div>			
		 <? }?>	
					
					 
                  				</td>
                  </tr>


		<? if($HideAdminPart != 1){ ?>

		<tr>
		  <td  class="blackbold" valign="top" align="right" >Status :<span class="red">*</span></td>
		  <td  align="left"   class="blacknormal" valign="top">
		<input type="radio" name="Approved" id="Approved0" value="0" <?=($arryExpenseClaim[0]['Approved']=="0" || empty($arryExpenseClaim[0]['Approved']))?("checked"):("");?> onclick="Javascript:ShowIssueDate(0);"/>
		Pending<br>
		<input type="radio" name="Approved" id="Approved1" value="1" <?=($arryExpenseClaim[0]['Approved']=="1")?("checked"):("");?> onclick="Javascript:ShowIssueDate(1);"/>
		Approve<br>
		<input type="radio" name="Approved" id="Approved2" value="2"  <?=($arryExpenseClaim[0]['Approved']=="2")?("checked"):("");?> onclick="Javascript:ShowIssueDate(2);"/>
		Cancel<br>
		  
		<input type="hidden" name="EditApprove" id="EditApprove" value="1" />

		  </td>
		</tr>

<tr>
				  <td  class="blackbold" valign="top" align="right" >
				  <div id="SancAmountTitle" style="display:none;">Sanctioned Amount :<span class="red">*</span></div>
				  </td>
				  <td  align="left"   class="blacknormal" valign="top">
<div id="SancAmountVal" style="display:none;"> 
<input id="SancAmount" name="SancAmount" class="datebox"  value="<?=$arryExpenseClaim[0]['SancAmount']?>"  type="text" maxlength="10" onkeypress="return isNumberKey(event);" size="15" autocomplete="off" > 
 <?=$Config['Currency']?> 			  
	</div>			  
				  </td>
				</tr>


<tr>
				  <td  class="blackbold" valign="top" align="right" >
				  <div id="IssueDateTitle" style="display:none;">Sanctioned Date :<span class="red">*</span></div>
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
<? if($arryExpenseClaim[0]['IssueDate']>0) $IssueDate = $arryExpenseClaim[0]['IssueDate']; ?>
<input id="IssueDate" name="IssueDate" readonly="" class="datebox" value="<?=$IssueDate?>"  type="text" > 		  
	</div>			  
				  </td>
				</tr>










		<? } ?>

</table>

