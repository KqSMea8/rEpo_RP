
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{
	Trim(frm.symbol_left);
	Trim(frm.symbol_right);

	if(  ValidateForBlank(frm.name, "Currency Title") 
		&& ValidateForSimpleBlank(frm.code, "Currency Code") 
		&& ValidateMandDecimalField(frm.currency_value, "Currency Value") 
		//&& ValidateForSimpleBlank(frm.symbol_left, "Symbol Left") 
		//&& ValidateForSimpleBlank(frm.symbol_right, "Symbol Right") 
	){
		
		if(frm.symbol_left.value=='' && frm.symbol_right.value==''){
			alert('Please Enter Symbol Left or Symbol Right.');
			return false;
		}
		
		if(frm.symbol_left.value!='' && frm.symbol_right.value!=''){
			alert('Please Enter only one of the Symbols.');
			return false;
		}
	

		var Url = "isRecordExists.php?Currency="+escape(document.getElementById("name").value)+"&CurrencyCode="+escape(document.getElementById("code").value)+"&editID="+document.getElementById("currency_id").value;
		SendMultipleExistRequest(Url,"name","Currency Title","code","Currency Code");
		
		return false;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>
<a href="viewCurrencies.php" class="back">Back</a>
<div class="had"> Manage Currencies    <span> &raquo;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
			 </span>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="45%" align="right" valign="middle"  class="blackbold"> Currency Title : </td>
                      <td width="55%" align="left"><input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name"  maxlength="20" <? if($_GET['edit']==9) echo 'Readonly'; ?>/> <span class="red">*</span></td>
                    </tr>
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Currency Code :</td>
                      <td align="left" class="blacknormal"><input value="<?=stripslashes($code)?>" name="code" type="text" class="inputbox" id="code" size="6" maxlength="4" />
                        <span class="red">*</span></td>
                    </tr>
					 <tr >
					   <td align="right" valign="middle"  class="blackbold">Currency Value :</td>
					   <td align="left" class="blacknormal"><input value="<?=stripslashes($currency_value)?>" name="currency_value" type="text" class="inputbox" id="currency_value" size="6" maxlength="5" />
                         <span class="red">*</span> (Equal to 1.00 USD)</td>
				      </tr>
					 <tr >
                      <td align="right" valign="middle"  class="blackbold">Symbol Left:</td>
                      <td align="left" class="blacknormal"><input value="<?=stripslashes($symbol_left)?>" name="symbol_left" type="text" class="inputbox" id="symbol_left" size="6" maxlength="4" />
                        <span class="red">*</span></td>
                    </tr>
					 <tr >
					   <td align="right" valign="middle"  class="blackbold">&nbsp;</td>
					   <td align="left" class="blacknormal">Or</td>
				      </tr>
					 <tr >
                      <td align="right" valign="middle"  class="blackbold">Symbol Right:</td>
                      <td align="left" class="blacknormal"><input value="<?=stripslashes($symbol_right)?>" name="symbol_right" type="text" class="inputbox" id="symbol_right" size="6" maxlength="4" />
                        <span class="red">*</span></td>
                    </tr>
					
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status : </td>
                      <td align="left" class="blacknormal"><? if($_GET['edit']==9){ ?>
                        Active
        <input type="hidden" name="Status" id="Status" value="1" />
        <? }else{ ?>
        <table width="151" border="0" cellpadding="0" cellspacing="0"  style="margin:0;">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>
                        <? } ?>                      </td>
                    </tr>
                   
                  </table></td>
                </tr>
				<tr><td  align="center" height="50">
				<input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ;?>" />
                          <input type="hidden" name="currency_id" id="currency_id"  value="<?=$_GET['edit']?>" />
				</td>
				</tr>
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>