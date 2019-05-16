
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){

	if(document.getElementById("bracketID") != null){
		document.getElementById("MainbracketID").value = document.getElementById("bracketID").value;
	}


		if( ValidateForSimpleBlank(frm.Heading, "Rule Heading")
		    && ValidateForSelect(frm.Year, "Year")
		    && ValidateForSelect(frm.filingID, "Filing Status")
		    && ValidateForSelect(frm.MainbracketID, "Tax Bracket")
		    && ValidateForSelect(frm.dedID, "Deduction")	   
		){
			var Url = "isRecordExists.php?DeductionRule="+escape(document.getElementById("Heading").value)+"&editID="+escape(document.getElementById("ruleID").value);
			SendExistRequest(Url,"Heading","Rule Heading");
			return false;
		}else{
			return false;	
		}
		
}

function GetTaxBracket(){

	$("#tax_bracket").html('');	
	if(document.getElementById("Year").value>0){ 
		$("#tax_bracket").html('<img src="../images/loading.gif">');
		$.ajax({
			type: "GET",
			async: false,
			url: "ajax.php",
			data: "&action=TaxBracket&filingID="+escape(document.getElementById("filingID").value)+"&Year="+escape(document.getElementById("Year").value)+"&OldbracketID="+escape(document.getElementById("OldbracketID").value)+"&r="+Math.random(),
			success: function (responseText) {
				$("#tax_bracket").html(responseText);				
			}
		});

		
		
	}
	
}

</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
<?=$MainModuleName?>   <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Create ".$ModuleName); ?>
		
		</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  >

<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    
	<tr>
		<td align="right" class="blackbold"  width="45%">
				 Rule Heading :<span class="red">*</span> </td>
		<td  align="left">
				<input  name="Heading" id="Heading" value="<?=stripslashes($arryDeductionRule[0]['Heading'])?>" type="text" class="inputbox"  maxlength="40" />	
  	        </td>
	</tr>

<tr>
                      <td  align="right"  class="blackbold" >
					Year :<span class="red">*</span>
					  </td>
                      <td >
				<?=getYears($arryDeductionRule[0]['Year'],"Year","textbox")?>

		 
					  </td>
                    </tr>
		

		<tr>
                      <td align="right"    class="blackbold">
					  Filing Status :<span class="red">*</span> </td>
                      <td  align="left" >

<select name="filingID" class="inputbox" id="filingID">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryFiling);$i++) {?>
	<option value="<?=$arryFiling[$i]['filingID']?>" <?  if($arryDeductionRule[0]['filingID']==$arryFiling[$i]['filingID']){echo "selected";}?>>
	<?=stripslashes($arryFiling[$i]['filingStatus'])?></option>
	<? } ?>
</select>
			 </td>
                    </tr>

		<tr >
                      <td align="right"   class="blackbold">Tax Bracket  :<span class="red">*</span></td>
                      <td align="left" class="blacknormal">
				
			<div id="tax_bracket"></div>
			
			 </td>
                    </tr>

                    
	<tr >
                      <td align="right"   class="blackbold">Deduction  :<span class="red">*</span></td>
                      <td align="left" class="blacknormal">
				

<select name="dedID" class="inputbox" id="dedID" >
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryDeduction);$i++) {?>
	<option value="<?=$arryDeduction[$i]['dedID']?>" <?  if($arryDeductionRule[0]['dedID']==$arryDeduction[$i]['dedID']){echo "selected";}?>>
	<?=stripslashes($arryDeduction[$i]['Heading'])?></option>
	<? } ?>
</select>



			 </td>
                    </tr>	
			
		
			
					
					
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_GET['edit'] > 0){
				 if($arryDeductionRule[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryDeductionRule[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
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
			  <input type="hidden" name="ruleID" id="ruleID"  value="<?=$_GET['edit']?>" />

 <input type="hidden" name="OldbracketID" id="OldbracketID"  value="<?=$arryDeductionRule[0]['bracketID']?>" />		
 <input type="hidden" name="MainbracketID" id="MainbracketID"  value="<?=$arryDeductionRule[0]['bracketID']?>" />


				  
				  </td></tr> 
				
              </form>
          </table>

<script>


$(document).ready(function () {
	GetTaxBracket();

	$("#Year").on("change", function () { 
		GetTaxBracket();
	});	
	 
	/*$("#filingID").on("change", function () { 
		GetTaxBracket();
	});*/

});

</script>
