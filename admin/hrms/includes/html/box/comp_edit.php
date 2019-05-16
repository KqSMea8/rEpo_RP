<SCRIPT LANGUAGE=JAVASCRIPT>
function ValidateEdit(frm)
{
	ShowHideLoader('1','S');
}

</SCRIPT>
<? include("includes/html/box/comp_view.php"); ?>
<br>
<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				
<? if($EditFlag == 1 || empty($_GET['edit'])){ ?>

<tr>
          <td align="right"   class="blackbold" valign="top" width="45%">Comment  :</td>
          <td  align="left" >
            <textarea name="Comment" type="text" class="textarea" id="Comment" maxlength="250" onkeypress="return isAlphaKey(event);"><?=stripslashes($arryComp[0]['Comment'])?></textarea>	
			
			</td>
        </tr>


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



<? } ?>







			</table>