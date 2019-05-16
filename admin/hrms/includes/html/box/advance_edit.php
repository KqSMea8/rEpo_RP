<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateEdit(frm)
{
	if(document.getElementById("Approved1").checked){
		if(!ValidateForSelect(frm.IssueDate, "Issue Date")){
			return false;	
		}
	}
	ShowHideLoader('1','S');
}

function ValidateReturn(frm)
{
	if(!ValidateMandDecimalField(frm.ReturnAmount, "Return Amount")){
		return false;	
	}
	if(parseInt(frm.ReturnAmount.value) > parseInt(frm.AmountDue.value)){
		alert("Return amount should not be greater than due amount.");
		return false;	
	}
	if(!ValidateForSelect(frm.ReturnDate, "Return Date")){
		return false;	
	}

	ShowHideLoader('1','S');
}
</SCRIPT>
<? include("includes/html/box/advance_view.php"); ?>
<br>
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				<? if($ReturnFlag == 1){ ?>
				 <tr>
                      <td  class="blackbold" valign="top"   align="right" width="45%">Return Amount :<span class="red">*</span></td>
                      <td  align="left"   class="blacknormal" valign="top">
					<input id="ReturnAmount" name="ReturnAmount" class="datebox"  value=""  type="text" maxlength="10" onkeypress="return isNumberKey(event);" size="15" autocomplete="off" > 
	 <?=$Config['Currency']?> 	
					  
					  </td>
                    </tr>

					<tr>
						 <td  class="blackbold" valign="top" align="right" >
							  Return Date :<span class="red">*</span>
						 </td>
						 <td  align="left"   class="blacknormal" valign="top">
		<script type="text/javascript">
		$(function() {
			$('#ReturnDate').datepicker(
				{
				showOn: "both",
				dateFormat: 'yy-mm-dd', 
				yearRange: '<?=date("Y")-5?>:<?=date("Y")?>', 
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
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryAdvance[0]['Comment'])?></textarea>	
			
			</td>
        </tr>


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
<input id="IssueDate" name="IssueDate" readonly="" class="datebox" value="<?=$IssueDate?>"  type="text" > 		  
	</div>			  
				  </td>
				</tr>





		<? } ?>







			</table>