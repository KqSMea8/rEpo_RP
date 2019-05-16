
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.Heading, "Heading")		   
		){
			var Url = "isRecordExists.php?DeductionHeading="+escape(document.getElementById("Heading").value)+"&editID="+document.getElementById("dedID").value;
			SendExistRequest(Url,"Heading","Deduction Heading");
			return false;
		}else{
			return false;	
		}
		
}



</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>   <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    
		<tr>
                      <td width="45%" align="right"    class="blackbold">
					  Deduction Type :<span class="red">*</span> </td>
                      <td  align="left" >
					
<select name="Type" class="inputbox" id="Type" >		
	<option value="0" <?  if($arryDeduction[0]['Type']=="0"){echo "selected";}?>>Miscellaneous Deduction</option>
	<option value="1" <?  if($arryDeduction[0]['Type']=="1"){echo "selected";}?>>Tax Deduction</option>
</select>
	


   </td>
                    </tr>

		<tr>
                      <td align="right"    class="blackbold">
					   Heading :<span class="red">*</span> </td>
                      <td  align="left" >
					<input  name="Heading" id="Heading" value="<?=stripslashes($arryDeduction[0]['Heading'])?>" type="text" class="inputbox"  maxlength="40" />					    </td>
                    </tr>


	<? if(sizeof($arryBankAccountList)>0){ ?>
		<tr>
                      <td align="right"    class="blackbold">
					   GL Account : </td>
                      <td  align="left" >

<select name="AccountID" class="inputbox" id="AccountID" >
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryBankAccountList);$i++) {?>
	<option value="<?=$arryBankAccountList[$i]['BankAccountID']?>" <?  if($arryDeduction[0]['AccountID']==$arryBankAccountList[$i]['BankAccountID']){echo "selected";}?>>
	<?=stripslashes($arryBankAccountList[$i]['AccountName']);?>
	 [<?=$arryBankAccountList[$i]['AccountNumber']?>]
	</option>
	<? } ?>
</select>
			 </td>
                    </tr>

		<? } ?>

                    
	<tr >
                      <td align="right"   class="blackbold">Mandatory  :</td>
                      <td align="left" class="blacknormal">
				<input name="Mandatory" type="checkbox" value="1" <?=($arryDeduction[0]['Mandatory']==1)?"checked":""?> />	  

                                          </td>
                    </tr>	
			

			
					
					
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arryDeduction[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryDeduction[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
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
