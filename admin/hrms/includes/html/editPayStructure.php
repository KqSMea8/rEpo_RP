<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm){
	
		if(!ValidateForSimpleBlank(frm.heading, "Heading")){
			return false;
		}
		
		
		if(frm.Default.value!=1){
		
			if(!ValidateForSelect(frm.HeadType, "Head Type")){
				return false;
			}
			
			if(document.getElementById("HeadType").value=='Percentage'){
				if(!ValidateMandNumField2(frm.Percentage,"Percentage",1,100)){
					return false;
				}
			}
			if(document.getElementById("HeadType").value=='Fixed'){
				if(!ValidateMandNumField2(frm.Amount,"Amount",1,10000000)){
					return false;
				}
			}
			
		}else{
		
			if(!ValidateMandNumField2(frm.Percentage,"Percentage",1,100)){
				return false;
			}
		
		
		}

		var Url = "isRecordExists.php?PayHeading="+escape(document.getElementById("heading").value)+"&catID="+document.getElementById("catID").value+"&catEmp="+document.getElementById("catEmp").value+"&editID="+document.getElementById("headID").value;
		SendExistRequest(Url,"heading","Heading");
		return false;
		
}

function ShowTypeOption(){
	if(document.getElementById("HeadType").value=='Fixed'){
		document.getElementById('AmountTitle').style.display = 'block'; 
		document.getElementById('AmountValue').style.display = 'block'; 
		
		document.getElementById('PercentageTitle').style.display = 'none'; 
		document.getElementById('PercentageValue').style.display = 'none'; 
	}else if(document.getElementById("HeadType").value=='Percentage'){
		document.getElementById('AmountTitle').style.display = 'none'; 
		document.getElementById('AmountValue').style.display = 'none'; 
		
		document.getElementById('PercentageTitle').style.display = 'block'; 
		document.getElementById('PercentageValue').style.display = 'block'; 
	}else{
		document.getElementById('AmountTitle').style.display = 'none'; 
		document.getElementById('AmountValue').style.display = 'none'; 
		
		document.getElementById('PercentageTitle').style.display = 'none'; 
		document.getElementById('PercentageValue').style.display = 'none'; 
	}
}
</SCRIPT>

<a href="<?=$RedirectURL?>" class="back">Back</a>

<div class="had">
Payroll Structure <span> &raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>

		
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
             
                <tr>
                  <td align="center"  ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
					<tr>
						  <td class="blackbold" align="right" >
						  Payroll Category : 
						  </td>
						  <td   align="left" >
							<B><?=$PayCategory?> </B>
							</td>
				   </tr>
				   <tr>
						  <td class="blackbold" align="right" >
						  Employee Category :
						  </td>
						  <td   align="left" >
							 <B><?=$EmpCategory?> </B>
							</td>
				   </tr>


                    <tr>
                      <td width="45%" align="right"    class="blackbold">
					  Heading :<span class="red">*</span> </td>
                      <td align="left" >
					<input  name="heading" id="heading" value="<?=stripslashes($arryHead[0]['heading'])?>" type="text" class="inputbox"  maxlength="40"  />					    </td>
                    </tr>	
					
				  <tr>
					<td  align="right"   class="blackbold"> Sub Heading  : </td>
					<td   align="left" >
					<input  name="subheading" id="subheading" value="<?=stripslashes($arryHead[0]['subheading'])?>" type="text" class="inputbox"  maxlength="40"   />						</td>
				  </tr>	                       
              
			  <? if($arryHead[0]['Default']==1){ ?>
			   <tr >
				<td  align="right" class="blackbold">Type :</td>
				<td align="left"><?=$arryHead[0]['HeadType']?> <input name="HeadType" type="hidden" value="<?=$arryHead[0]['HeadType']?>" /></td>
				</tr>
				
				
				  <tr>
				<td align="right" class="blackbold" >
				Percentage  :<span class="red">*</span>
				
				</td>
				<td  align="left"  >
				
				<input name="Percentage" type="text" class="textbox" id="Percentage" value="<?=stripslashes($arryHead[0]['Percentage'])?>" size="3"  maxlength="3" onkeypress="return isNumberKey(event);" /> %	of CTC
				
						</td>
			</tr>	
				
				
			   <tr >
				<td  align="right" class="blackbold">Status :</td>
				<td align="left">Active <input name="Status" type="hidden" value="1" /></td>
				</tr>
			  <? }else{ ?>
			  
			  
			     <tr >
				<td  align="right" class="blackbold">Type :<span class="red">*</span></td>
				<td align="left">

				<select name="HeadType" class="inputbox" id="HeadType" onChange="Javascript:ShowTypeOption();">
					<option value="">--- Select ---</option>
					<? for($i=0;$i<sizeof($arryHeadType);$i++) {?>
						<option value="<?=$arryHeadType[$i]['attribute_value']?>" <?  if($arryHeadType[$i]['attribute_value']==$arryHead[0]['HeadType']){echo "selected";}?>>
						<?=$arryHeadType[$i]['attribute_value']?>
						</option>
					<? } ?>
				</select> 	</td>
			  </tr>	
					
			      <tr>
				<td align="right" class="blackbold" >
				<div id="PercentageTitle">Percentage  :<span class="red">*</span></div>
				<div id="AmountTitle">Amount  :<span class="red">*</span></div>
				</td>
				<td  align="left"  >
				<div id="PercentageValue">
				<input name="Percentage" type="text" class="textbox" id="Percentage" value="<?=stripslashes($arryHead[0]['Percentage'])?>" size="3"  maxlength="3" onkeypress='return isNumberKey(event)'/> %	of <?=$BasicTitle?></div>	
				<div  id="AmountValue"><input name="Amount" type="text" class="textbox" id="Amount" value="<?=stripslashes($arryHead[0]['Amount'])?>" maxlength="10" size="10"  onkeypress='return isDecimalKey(event)'/> <?=$Config['Currency']?></div>
						</td>
			</tr>	
	
					
					
                    <tr >
                      <td align="right"   class="blackbold">Status  :</td>
                      <td align="left" >
				
        <table border="0" cellpadding="0" cellspacing="0" style="margin:0">
          <tr>
            <td width="10" align="left" ><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" >Active</td>
            <td width="10" align="left" ><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" >InActive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
						<? } ?>		  

                  
                  </table></td>
                </tr>
			
				 <tr><td align="center"><br />
			
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
			  <input type="hidden" name="headID" id="headID"  value="<?=$_GET['edit']?>" />
				  
			  <input type="hidden" name="catID" id="catID"  value="<?=$_GET['cat']?>" />
			  <input type="hidden" name="catEmp" id="catEmp"  value="<?=$_GET['catEmp']?>" />
				  
			 <input type="hidden" name="Default" id="Default"  value="<?=$arryHead[0]['Default']?>" />	 
				  
				  
				  </td></tr> 
			
				
              </form>
          </table>
<SCRIPT LANGUAGE=JAVASCRIPT>
	ShowTypeOption();
</SCRIPT>
