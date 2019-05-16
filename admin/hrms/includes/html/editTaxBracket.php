<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSelect(frm.Year, "Year")
		    && ValidateForSelect(frm.periodID, "Payroll Period")
		    && ValidateForSelect(frm.FilingStatus, "Filing Status")
		){	
		
			var NumLine = parseInt($("#NumLine").val());
			for(var i=1;i<=NumLine;i++){
				if(document.getElementById("FromAmount"+i) != null){
					if(!ValidateForSimpleBlank(document.getElementById("FromAmount"+i), "From Amount")){
						return false;
					}
					var FromAmount = parseInt(document.getElementById("FromAmount"+i).value);
					var ToAmount = parseInt(document.getElementById("ToAmount"+i).value);

					if(ToAmount>0){					
						if(FromAmount >= ToAmount){
							alert("To Amount should be greater than From Amount.");
							document.getElementById("ToAmount"+i).focus();
							return false;
						}
					}

					if(!ValidateForSimpleBlank(document.getElementById("TaxAmount"+i), "Tax Amount")){
						return false;
					}
					if(!ValidateForSimpleBlank(document.getElementById("TaxPercentage"+i), "Tax Percentage")){
						return false;
					}


					if(document.getElementById("TaxPercentage"+i).value >= 100){
						alert("Tax Percentage should be less than 100.");
						document.getElementById("TaxPercentage"+i).focus();
						return false;
					}



				     
				}
			}



			
			/**********************/
			DataExist = CheckExistingData("isRecordExists.php", "&periodID="+escape(document.getElementById("periodID").value)+"&Year="+escape(document.getElementById("Year").value)+"&FilingStatus="+escape(document.getElementById("FilingStatus").value)+"&editID="+document.getElementById("bracketID").value, "bracketID","Tax Bracket");

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
	
 <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
 <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
             
              
                <tr>
                  <td align="center" valign="top" >

<table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                  
                    
<tr>
<td  align="right"  class="blackbold" width="10%">
	Year :<span class="red">*</span>
</td>
<td >
	<?=getYears($arryBracket[0]['Year'],"Year","textbox")?>
</td>
</tr>				
                  	
<tr>
<td  align="right"  class="blackbold">
	Payroll Period :<span class="red">*</span>
</td>
<td>

<select name="periodID" class="textbox" id="periodID" style="width:100px;">
	<option value="">--- Select ---</option>
	<? for($i=0;$i<sizeof($arryPayPeriod);$i++) {?>
	<option value="<?=$arryPayPeriod[$i]['periodID']?>" <?  if($arryBracket[0]['periodID']==$arryPayPeriod[$i]['periodID']){echo "selected";}?>>
	<?=stripslashes($arryPayPeriod[$i]['periodName'])?></option>
	<? } ?>
</select>

</td>
</tr>	

<tr>
        <td  align="right"   class="blackbold"> Filing Status  :<span class="red">*</span> </td>
        <td   align="left" >
		
    <select name="FilingStatus" class="textbox" id="FilingStatus" style="width:100px;">
      <option value="">--- Select ---</option>
      <option value="Single" <?  if($arryBracket[0]['FilingStatus']=="Single"){echo "selected";}?>> Single </option>
      <option value="Married" <?  if($arryBracket[0]['FilingStatus']=="Married"){echo "selected";}?>> Married </option>
     
    </select>

 </td>
      </tr>


<tr>
	<td colspan="2" align="left" class="head">Tax Bracket</td>
</tr>	
<tr>
	<td colspan="2" align="left">
	<? 
	include("includes/html/box/tax_bracket.php");
	?>
</td>
</tr>	

  
	

                 
                  </table></td>
                </tr>
				
		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="bracketID" id="bracketID"  value="<?=$_GET['edit']?>" />
				  
				  </td></tr> 
				
             
          </table>



 </form>


