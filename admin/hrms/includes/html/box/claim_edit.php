<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateEdit(frm)
{
	if(document.getElementById("Approved1").checked){
		if(!ValidateMandDecimalField(frm.SancAmount,"Sanctioned Amount")){
			return false;	
		}
		if(parseInt(frm.SancAmount.value) > parseInt(frm.ClaimAmount.value)){
			alert("Sanctioned amount should not be greater than claim amount.");
			return false;	
		}
		if(!ValidateForSelect(frm.IssueDate, "Sanctioned Date")){
			return false;	
		}
	}
	ShowHideLoader('1','S');
}

function ValidatePay(frm)
{
	
	if(!ValidateForSelect(frm.ReturnDate, "Payment Date")){
		return false;	
	}

	ShowHideLoader('1','S');
}
</SCRIPT>
<? include("includes/html/box/claim_view.php"); ?>
<br>
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
<? if($ReturnFlag == 1){ ?>
				 <tr>
                      <td  class="blackbold" valign="top"   align="right" width="45%">Sanctioned Amount :</td>
                      <td  align="left"   class="blacknormal" valign="top">
					
<?=(!empty($arryExpenseClaim[0]['SancAmount']))?(round($arryExpenseClaim[0]['SancAmount'],2)):("0")?>
 <?=$Config['Currency']?> 	
					  
					  </td>
                    </tr>

					<tr>
						 <td  class="blackbold" valign="top" align="right" >
							  Payment Date :<span class="red">*</span>
						 </td>
						 <td  align="left"   class="blacknormal" valign="top">
		<script type="text/javascript">
		$(function() {
			$('#ReturnDate').datepicker(
				{
				showOn: "both",
				dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-1?>:<?=date("Y")?>', 
				maxDate: "-0D", 
				changeMonth: true,
				changeYear: true

				}
			);
		});
		</script>
		<input id="ReturnDate" name="ReturnDate" readonly="" class="datebox" value=""  type="text" > 				  
							  </td>
							</tr>

		<? } ?>
<? if($EditFlag == 1 || empty($_GET['edit'])){ ?>

	<tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryExpenseClaim[0]['Comment'])?></textarea>	
			
			</td>
        </tr>


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
	<input id="ClaimAmount" name="ClaimAmount" value="<?=$arryExpenseClaim[0]['ClaimAmount']?>"  type="hidden" maxlength="10" onkeypress="return isNumberKey(event);" size="15" autocomplete="off" > 


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