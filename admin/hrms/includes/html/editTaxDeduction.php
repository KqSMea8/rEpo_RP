
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.Heading, "Heading")	
		    && ValidateForSimpleBlank(frm.SocialSecurity, "Social Security")	
		    && ValidateForSimpleBlank(frm.Medicare, "Medicare")	   
		    && ValidateForSimpleBlank(frm.FUTA, "FUTA")	     
		    && ValidateForSimpleBlank(frm.SUTA, "SUTA")	
		    && ValidateForSimpleBlank(frm.TaxRate, "Tax Rate")	      
		){

			if(frm.TaxRate.value >= 100){
				alert("Tax Rate should be less than 100.");
				frm.TaxRate.focus();
				return false;
			}




			var Url = "isRecordExists.php?TaxDeductionHeading="+escape(document.getElementById("Heading").value)+"&editID="+document.getElementById("dedID").value;
			SendExistRequest(Url,"Heading","Deduction Heading");
			return false;
		}else{
			return false;	
		}
		
}



</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
Manage Tax Deduction  <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    
		<tr>
                      <td align="right"   width="45%"  class="blackbold">
					   Heading :<span class="red">*</span> </td>
                      <td  align="left" >
					<input  name="Heading" id="Heading" value="<?=stripslashes($arryTaxDeduction[0]['Heading'])?>" type="text" class="inputbox"  maxlength="40" />					    </td>
                    </tr>


                    
	<tr>
	   <td align="right"   class="blackbold">Social Security  :<span class="red">*</span></td>
                      <td align="left" class="blacknormal">
			<input  name="SocialSecurity" id="SocialSecurity" value="<?=stripslashes($arryTaxDeduction[0]['SocialSecurity'])?>" type="text" class="inputbox"  maxlength="30" />	  </td>
         </tr>	
			

	<tr>
	   <td align="right"   class="blackbold">Medicare  :<span class="red">*</span></td>
                      <td align="left" class="blacknormal">
			<input  name="Medicare" id="Medicare" value="<?=stripslashes($arryTaxDeduction[0]['Medicare'])?>" type="text" class="inputbox"  maxlength="30" />	  </td>
         </tr>	


	<tr>
	   <td align="right"   class="blackbold">FUTA :<span class="red">*</span></td>
                      <td align="left" class="blacknormal">
			<input  name="FUTA" id="FUTA" value="<?=stripslashes($arryTaxDeduction[0]['FUTA'])?>" type="text" class="inputbox"  maxlength="30" />	  </td>
         </tr>	
			

	<tr>
	   <td align="right"   class="blackbold">SUTA  :<span class="red">*</span></td>
                      <td align="left" class="blacknormal">
			<input  name="SUTA" id="SUTA" value="<?=stripslashes($arryTaxDeduction[0]['SUTA'])?>" type="text" class="inputbox"  maxlength="30" />	  </td>
         </tr>

<? if(sizeof($arryState)>0){ ?>
	<tr>
	   <td align="right"   class="blackbold">State  : </td>
                      <td align="left" class="blacknormal">
			
<select name="state_id" class="inputbox" id="state_id" >
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryState);$i++) {?>
	<option value="<?=$arryState[$i]['state_id']?>" <?  if($arryTaxDeduction[0]['state_id']==$arryState[$i]['state_id']){echo "selected";}?>>
	<?=stripslashes($arryState[$i]['name']);?>	
	</option>
	<? } ?>
</select>

	  </td>
         </tr>
<? } ?>



		<? if(sizeof($arryBankAccountList)>0){ ?>
		<tr>
                      <td align="right"    class="blackbold">
					   GL Account : </td>
                      <td  align="left" >

<select name="AccountID" class="inputbox" id="AccountID" >
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
	<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>" <?  if($arryTaxDeduction[0]['AccountID']==$arryBankAccountList[$i]['BankAccountID']){echo "selected";}?>>
	<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
	- (<?=$arryBankAccountList[$i]['AccountType']?>)
	</option>
	<? } ?>
</select>
			 </td>
                    </tr>

		<? } ?>		
					
		
	<tr>
	   <td align="right"   class="blackbold">Tax Rate  :<span class="red">*</span></td>
                      <td align="left" class="blacknormal">
			<input  name="TaxRate" id="TaxRate" value="<?=stripslashes($arryTaxDeduction[0]['TaxRate'])?>" type="text" class="textbox" size="5"  maxlength="5" onkeypress="return isDecimalKey(event);" />	 % </td>
         </tr>


			
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arryTaxDeduction[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryTaxDeduction[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>	
								  

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="dedID" id="dedID"  value="<?=$_GET['edit']?>" />
		
				  
				  </td></tr> 
				
              </form>
          </table>
