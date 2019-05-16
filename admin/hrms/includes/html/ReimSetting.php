
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.ReimRate, "Reimbursement Rate")
		
		){	

			ShowHideLoader('1','S');
			return true;

			
		}else{
			return false;	
		}
		
}

</SCRIPT>

<div class="had"><?=$MainModuleName?> 
<div class="message" align="center"><? if(!empty($_SESSION['mess_reim'])) {echo $_SESSION['mess_reim']; unset($_SESSION['mess_reim']); }?></div>
</div>
	

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="45%"  align="right" valign="top"   class="blackbold">
					   Reimbursement Rate :<span class="red">*</span></td>
                      <td align="left" valign="top">
					<input  name="ReimRate" id="ReimRate" value="<?=stripslashes($arryReimSettingVal[0]['ReimRate'])?>" type="text" class="inputbox" maxlength="30" onkeypress="return isDecimalKey(event);"/> <b><?=$Config['Currency']?></b>  
					    </td>
                    </tr>
                    
		<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],8)==1){ ?>
		<tr>
                      <td align="right"  class="blackbold">
					  Mileage Account : </td>
                      <td >
                     
                        <select name="ReimMileageGL" class="inputbox" id="ReimMileageGL">
							<option value="">--- None ---</option>
							<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
							<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryReimSettingVal[0]['ReimMileageGL']){echo "selected";}?>>
							<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
							<? } ?>
						</select> 
		 
					  </td>
                    </tr>
                   	
			<tr>
                      <td  align="right"  class="blackbold">
					  Miscellaneous Account :</td>
                      <td >
						<select name="ReimMissGL" class="inputbox" id="ReimMissGL">
							<option value="">--- None ---</option>
							<? for($i=0;$i<sizeof($arryBankAccount);$i++) {?>
							<option value="<?=$arryBankAccount[$i]['BankAccountID']?>" <?  if($arryBankAccount[$i]['BankAccountID']==$arryReimSettingVal[0]['ReimMissGL']){echo "selected";}?>>
							<?=ucwords($arryBankAccount[$i]['AccountName'])?> [<?=$arryBankAccount[$i]['AccountNumber']?>]</option>
							<? } ?>
						</select> 

					  </td>
                    </tr>				
 		<? } ?>
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			<input name="Submit" type="submit" class="button" id="SubmitButton" value=" Submit " />
				  
				  </td></tr> 
				
              </form>
          </table>

