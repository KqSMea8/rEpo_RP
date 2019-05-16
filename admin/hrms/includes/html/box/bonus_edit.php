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

</SCRIPT>
<? include("includes/html/box/bonus_view.php"); ?>
<br>
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">

<? if($EditFlag == 1 || empty($_GET['edit'])){ ?>

<tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryBonus[0]['Comment'])?></textarea>	
			
			</td>
        </tr>

		<tr>
		  <td  class="blackbold" valign="top" align="right" >Status :<span class="red">*</span></td>
		  <td  align="left"   class="blacknormal" valign="top">
		<input type="radio" name="Approved" id="Approved0" value="0" <?=($arryBonus[0]['Approved']=="0" || empty($arryBonus[0]['Approved']))?("checked"):("");?> onclick="Javascript:ShowIssueDate(0);"/>
		Pending<br>
		<input type="radio" name="Approved" id="Approved1" value="1" <?=($arryBonus[0]['Approved']=="1")?("checked"):("");?> onclick="Javascript:ShowIssueDate(1);"/>
		Approve<br>
		<input type="radio" name="Approved" id="Approved2" value="2"  <?=($arryBonus[0]['Approved']=="2")?("checked"):("");?> onclick="Javascript:ShowIssueDate(2);"/>
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
<? if($arryBonus[0]['IssueDate']>0) $IssueDate = $arryBonus[0]['IssueDate']; ?>
<input id="IssueDate" name="IssueDate" readonly="" class="datebox" value="<?=$IssueDate?>"  type="text" > 		  
	</div>			  
				  </td>
				</tr>



<? } ?>







			</table>
