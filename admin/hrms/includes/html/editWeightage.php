
<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		var TotalWeightage=0; Weightage=0;
		if( ValidateForSimpleBlank(frm.catName, "Category Title")
		){
			
			for(i=1;i<=3;i++){
				if(document.getElementById("Weightage"+i) != null){
					if(!ValidateOptNumField2(document.getElementById("Weightage"+i), "Weightage",1,100)){
						return false;
					}
					Weightage =  parseInt(document.getElementById("Weightage"+i).value);
					if(Weightage!='' && !isNaN(Weightage)){
						TotalWeightage = TotalWeightage + Weightage;
					}
					
				}
			}
		
			if(TotalWeightage>100){
				alert("Total Weightage should be less than or equal to 100.");
				return false;
			}
			
			var Url = "isRecordExists.php?ComponentCategory="+escape(document.getElementById("catName").value)+"&editID="+document.getElementById("catID").value;
			SendExistRequest(Url,"catName","Category Title");
			return false;
			
		}else{
			return false;	
		}
}
</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
Component Weightages   <span> &raquo; Edit Weightage</span>
</div>

		 
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="45%" align="right"    class="blackbold">
					   Category Title:<span class="red">*</span> </td>
                      <td  align="left" >
					<input  name="catName" id="catName" value="<?=stripslashes($arryWeightage[0]['catName'])?>" type="text" class="inputbox"  maxlength="40" />					    </td>
                    </tr>


					<? foreach($arryComponent as $key=>$values){ 
							$compID = $values['compID'];
							$Weightage = $arryWeightage[0]['Weightage'.$compID];
							if($Weightage==0) $Weightage='';
					?>			
                    <tr>
                      <td  class="blackbold"  valign="top"  align="right">Weightage for <br><?=stripslashes($values['heading'])?> :</td>
                      <td  align="left" valign="top" >
<input  name="Weightage<?=$compID?>" id="Weightage<?=$compID?>" value="<?=$Weightage?>" type="text" class="textbox" size="3"  maxlength="3" onkeypress="return isNumberKey(event);" />	 %
					  
					   </td>
                    </tr>
                    <? } ?>
                          
			

			
					
				
								  

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="catID" id="catID"  value="<?=$_GET['edit']?>" />
		
				  
				  </td></tr> 
				
              </form>
          </table>