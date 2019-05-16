<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSelect(frm.Year, "Year")
		    && ValidateForSimpleBlank(frm.TaxRate, "Tax Rate") 
		){	
		
			if(frm.TaxRate.value >= 100){
				alert("Tax Rate should be less than 100.");
				frm.TaxRate.focus();
				return false;
			}
				
			for(var i=1;i<=5;i++){
				if(document.getElementById("From"+i) != null){
					if(!ValidateForSimpleBlank(document.getElementById("From"+i), "From Amount")){
						return false;
					}	
					var FromAmount = parseInt(document.getElementById("From"+i).value);
					var ToAmount = parseInt(document.getElementById("To"+i).value);

					if(ToAmount>0){					
						if(FromAmount >= ToAmount){
							alert("To Amount should be greater than From Amount.");
							document.getElementById("To"+i).focus();
							return false;
						}
					}

				}
			}






			
			/**********************/
			DataExist = CheckExistingData("isRecordExists.php", "&TaxBracketRate="+escape(document.getElementById("TaxRate").value)+"&Year="+escape(document.getElementById("Year").value)+"&editID="+document.getElementById("bracketID").value, "TaxRate","Tax Rate");
			if(DataExist==1)return false;

			/**********************/
			
	

			ShowHideLoader('1','S');
			return true;

			
		}else{
			return false;	
		}
		
}

</SCRIPT>
<a href="<?=$RedirectUrl?>" class="back">Back</a>


<div class="had"><?=$MainModuleName?> <span> &raquo;
<? 
$MemberTitle = (!empty($_GET['edit']))?(" Edit ") :(" Add ");
echo $MemberTitle.$ModuleName;
?>
</span>
</div>
	

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                  
                    
<tr>
                      <td  align="right"  class="blackbold" width="45%">
					Year :<span class="red">*</span>
					  </td>
                      <td >
				<?=getYears($arryBracket[0]['Year'],"Year","textbox")?>

		 
					  </td>
                    </tr>				
                  	



<tr>
                      <td  align="right"  class="blackbold">
					Tax Rate :<span class="red">*</span>
					  </td>
                      <td >

<input name="TaxRate" type="text" class="textbox" size="5" maxlength="6" id="TaxRate" value="<?=$arryBracket[0]['TaxRate']?>" onkeypress="return isDecimalKey(event);"/> %
		 
					  </td>
                    </tr>
                   	

<tr>
                      <td  align="left"  class="head" colspan="2">
			Tax Bracket 
		      </td>
                     
                    </tr>

		<? foreach($arryFiling as $key=>$values){ 
			$Line = $values["filingID"];
			unset($FilingValArray);
			$FilingValArray = explode("#",$arryBracket[0]['Filing'.$Line]);
		?>	
		<tr>
                      <td  align="right"  class="blackbold">
			<?=stripslashes($values['filingStatus'])?> :<span class="red">*</span> 
		      </td>
                      <td> 
<input name="From<?=$Line?>" id="From<?=$Line?>" type="text" class="textbox" size="10" maxlength="10"  value="<?=$FilingValArray[0]?>" onkeypress="return isNumberKey(event);" Placeholder="From"/> - <input name="To<?=$Line?>" id="To<?=$Line?>" type="text" class="textbox" size="10" maxlength="10"  value="<?=$FilingValArray[1]?>" onkeypress="return isNumberKey(event);" Placeholder="To"/> <?=$Config['CurrencySymbol']?>



			</td>
                    </tr>
                  <? } ?>
	

                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="bracketID" id="bracketID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>






