
<div class="had">
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("&nbsp; Edit ") :("&nbsp; Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="388" align="center" valign="middle" >
		  <div  align="right"><a href="viewMemberships.php" class="Blue">List <?=$ModuleName?>s</a></div><br>
		    <table width="100%" height="110" border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
             
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="42%" align="right" valign="middle" =""  class="blackbold"> Membership Name <span class="red">*</span> </td>
                      <td width="58%" align="left"><input value="<?=stripslashes($arryMember[0]['Name'])?>" name="Name" type="text" class="inputbox" id="Name" size="30" maxlength="30" <? //if($_GET['edit']==1) echo 'Readonly'; ?>/> </td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"  class="blackbold">Description </td>
                      <td align="left">
 <textarea  name="Description" cols="40" rows="5" class="inputbox" id="Description"><?=stripslashes($arryMember[0]['Description'])?></textarea>                      </td>
                    </tr>
                    <tr>
                      <td align="right" valign="middle"  class="blackbold">Validity ( In Days) <span class="red">*</span> </td>
                      <td align="left" valign="middle" class="blacknormal">
					  
                        <select name="Validity" id="Validity" class="inputbox" style="width:65px;">
                          <option value="1" <? if($arryMember[0]['Validity'] == 1) echo 'selected';?>> 1 </option>
                          <option value="2" <? if($arryMember[0]['Validity'] == 2) echo 'selected';?>> 2 </option>
                          <option value="3" <? if($arryMember[0]['Validity'] == 3) echo 'selected';?>> 3 </option>
                          <option value="4" <? if($arryMember[0]['Validity'] == 4) echo 'selected';?>> 4 </option>
                          <option value="5" <? if($arryMember[0]['Validity'] == 5) echo 'selected';?>> 5 </option>
                          <option value="6" <? if($arryMember[0]['Validity'] == 6) echo 'selected';?>> 6 </option>
                          <option value="7" <? if($arryMember[0]['Validity'] == 7) echo 'selected';?>> 7 </option>
                          <option value="14" <? if($arryMember[0]['Validity'] == 14) echo 'selected';?>> 14 </option>
                          <option value="30" <? if($arryMember[0]['Validity'] == 30) echo 'selected';?>> 30 </option>
                          <option value="60" <? if($arryMember[0]['Validity'] == 60) echo 'selected';?>> 60 </option>
                          <option value="90" <? if($arryMember[0]['Validity'] == 90) echo 'selected';?>> 90 </option>
                          <option value="120" <? if($arryMember[0]['Validity'] == 120) echo 'selected';?>> 120 </option>
                          <option value="150" <? if($arryMember[0]['Validity'] == 150) echo 'selected';?>> 150 </option>
                          <option value="180" <? if($arryMember[0]['Validity'] == 180) echo 'selected';?>> 180 </option>
                          <option value="365" <? if($arryMember[0]['Validity'] == 365) echo 'selected';?>> 365 </option>
                        </select>
						
						</td>
                    </tr>
                    <? if($_GET['edit']!=1) { ?>
                    <tr>
                      <td align="right" valign="middle"  class="blackbold">Price <span class="red">*</span> </td>
                      <td align="left" valign="middle" class="blacknormal"><input name="Price"  value="<?=$arryMember[0]['Price']?>" type="text" class="inputbox" id="Price" size="8" maxlength="10"> <?=$Config['Currency']?>
                        </td>
                    </tr>
                    <? } ?>
					
										  
					 <tr>
                          <td align="right" valign="middle"  class="blackbold">Maximum Product Posting</td>
					      <td align="left" valign="middle" class="blacknormal"><select name="MaxProduct" id="MaxProduct" class="inputbox" style="width:65px;">
                              <option value="0" <? if($arryMember[0]['MaxProduct'] == 0) echo 'selected';?>> 0 </option>
                              <option value="1" <? if($arryMember[0]['MaxProduct'] == 1) echo 'selected';?>> 1 </option>
                              <option value="2" <? if($arryMember[0]['MaxProduct'] == 2) echo 'selected';?>> 2 </option>
                              <option value="3" <? if($arryMember[0]['MaxProduct'] == 3) echo 'selected';?>> 3 </option>
                              <option value="4" <? if($arryMember[0]['MaxProduct'] == 4) echo 'selected';?>> 4 </option>
                              <option value="5" <? if($arryMember[0]['MaxProduct'] == 5) echo 'selected';?>> 5 </option>
                              <option value="10" <? if($arryMember[0]['MaxProduct'] == 10) echo 'selected';?>> 10 </option>
                              <option value="15" <? if($arryMember[0]['MaxProduct'] == 15) echo 'selected';?>> 15 </option>
                              <option value="20" <? if($arryMember[0]['MaxProduct'] == 20) echo 'selected';?>> 20 </option>
                              <option value="25" <? if($arryMember[0]['MaxProduct'] == 25) echo 'selected';?>> 25 </option>
                              <option value="30" <? if($arryMember[0]['MaxProduct'] == 30) echo 'selected';?>> 30 </option>
                              <option value="40" <? if($arryMember[0]['MaxProduct'] == 40) echo 'selected';?>> 40 </option>
                              <option value="50" <? if($arryMember[0]['MaxProduct'] == 50) echo 'selected';?>> 50 </option>
                              <option value="60" <? if($arryMember[0]['MaxProduct'] == 60) echo 'selected';?>> 60 </option>
                             <option value="75" <? if($arryMember[0]['MaxProduct'] == 75) echo 'selected';?>> 75 </option>
                             <option value="80" <? if($arryMember[0]['MaxProduct'] == 80) echo 'selected';?>> 80 </option>
                              <option value="100" <? if($arryMember[0]['MaxProduct'] == 100) echo 'selected';?>> 100 </option>
                              <option value="150" <? if($arryMember[0]['MaxProduct'] == 150) echo 'selected';?>> 150 </option>
                              <option value="200" <? if($arryMember[0]['MaxProduct'] == 200) echo 'selected';?>> 200 </option>
                              <option value="250" <? if($arryMember[0]['MaxProduct'] == 250) echo 'selected';?>> 250 </option>
                              <option value="300" <? if($arryMember[0]['MaxProduct'] == 300) echo 'selected';?>> 300 </option>
                              <option value="400" <? if($arryMember[0]['MaxProduct'] == 400) echo 'selected';?>> 400 </option>
							  <option value="500" <? if($arryMember[0]['MaxProduct'] == 500) echo 'selected';?>> 500 </option>
							  <option value="750" <? if($arryMember[0]['MaxProduct'] == 750) echo 'selected';?>> 750 </option>
                              <option value="1250" <? if($arryMember[0]['MaxProduct'] == 1250) echo 'selected';?>> 1250 </option>
                              <option value="2000" <? if($arryMember[0]['MaxProduct'] == 2000) echo 'selected';?>> 2000 </option>
                              <option value="3000" <? if($arryMember[0]['MaxProduct'] == 3000) echo 'selected';?>> 3000 </option>
                          </select></td>
				      </tr>
					  
					  
					  
					<tr style="display:none">
                          <td align="right" valign="middle"  class="blackbold">Maximum Alternative Image Per Product </td>
					      <td align="left" valign="middle" class="blacknormal">
						  <select name="MaxProductImage" id="MaxProductImage" class="inputbox" style="width:65px;">
							 	<?
								for($i=0;$i<=20;$i++){
								
									$sel = ($arryMember[0]['MaxProductImage'] == $i)?(" selected"):("");

									echo '<option value="'.$i.'" '.$sel.'> '.$i.' </option>';
								}
								?>
                              
                             
                          </select>
						  
						  </td>
				      </tr>   
					  
					  <!--
						<tr>
                          <td align="right" valign="middle"  class="blackbold">Maximum Email Limit</td>
					      <td align="left" valign="middle">
						  <select name="MaxEmail" id="MaxEmail" class="inputbox" style="width:65px;">
                               <option value="0" <? if($arryMember[0]['MaxEmail'] == '0') echo 'selected';?>> 0 </option>
							   <option value="5" <? if($arryMember[0]['MaxEmail'] == 5) echo 'selected';?>> 5 </option>
                              <option value="10" <? if($arryMember[0]['MaxEmail'] == 10) echo 'selected';?>> 10 </option>
                              <option value="15" <? if($arryMember[0]['MaxEmail'] == 15) echo 'selected';?>> 15 </option>
                              <option value="20" <? if($arryMember[0]['MaxEmail'] == 20) echo 'selected';?>> 20 </option>
                              <option value="25" <? if($arryMember[0]['MaxEmail'] == 25) echo 'selected';?>> 25 </option>
                              <option value="30" <? if($arryMember[0]['MaxEmail'] == 30) echo 'selected';?>> 30 </option>
                              <option value="40" <? if($arryMember[0]['MaxEmail'] == 40) echo 'selected';?>> 40 </option>
                              <option value="50" <? if($arryMember[0]['MaxEmail'] == 50) echo 'selected';?>> 50 </option>
                              <option value="75" <? if($arryMember[0]['MaxEmail'] == 75) echo 'selected';?>> 75 </option>
                              <option value="100" <? if($arryMember[0]['MaxEmail'] == 100) echo 'selected';?>> 100 </option>
                              <option value="150" <? if($arryMember[0]['MaxEmail'] == 150) echo 'selected';?>> 150 </option>
                              <option value="200" <? if($arryMember[0]['MaxEmail'] == 200) echo 'selected';?>> 200 </option>
							  <option value="500" <? if($arryMember[0]['MaxEmail'] == 500) echo 'selected';?>> 500 </option>
							  <option value="750" <? if($arryMember[0]['MaxEmail'] == 750) echo 'selected';?>> 750 </option>
							  <option value="1000" <? if($arryMember[0]['MaxEmail'] == 1000) echo 'selected';?>> 1000 </option>
							  <option value="1500" <? if($arryMember[0]['MaxEmail'] == 1500) echo 'selected';?>> 1500 </option>
							  <option value="2000" <? if($arryMember[0]['MaxEmail'] == 2000) echo 'selected';?>> 2000 </option>
                          </select></td>
				      </tr>		  
			<tr>
                          <td align="right" valign="middle"  class="blackbold">Maximum SMS Limit</td>
					      <td align="left" valign="middle">
						  <select name="MaxSms" id="MaxSms" class="inputbox" style="width:65px;">
                               <option value="0" <? if($arryMember[0]['MaxSms'] == '0') echo 'selected';?>> 0 </option>
							   <option value="5" <? if($arryMember[0]['MaxSms'] == 5) echo 'selected';?>> 5 </option>
                              <option value="10" <? if($arryMember[0]['MaxSms'] == 10) echo 'selected';?>> 10 </option>
                              <option value="15" <? if($arryMember[0]['MaxSms'] == 15) echo 'selected';?>> 15 </option>
                              <option value="20" <? if($arryMember[0]['MaxSms'] == 20) echo 'selected';?>> 20 </option>
                              <option value="25" <? if($arryMember[0]['MaxSms'] == 25) echo 'selected';?>> 25 </option>
                              <option value="30" <? if($arryMember[0]['MaxSms'] == 30) echo 'selected';?>> 30 </option>
                              <option value="40" <? if($arryMember[0]['MaxSms'] == 40) echo 'selected';?>> 40 </option>
                              <option value="50" <? if($arryMember[0]['MaxSms'] == 50) echo 'selected';?>> 50 </option>
                              <option value="75" <? if($arryMember[0]['MaxSms'] == 75) echo 'selected';?>> 75 </option>
                              <option value="100" <? if($arryMember[0]['MaxSms'] == 100) echo 'selected';?>> 100 </option>
                              <option value="150" <? if($arryMember[0]['MaxSms'] == 150) echo 'selected';?>> 150 </option>
                              <option value="200" <? if($arryMember[0]['MaxSms'] == 200) echo 'selected';?>> 200 </option>
							  <option value="500" <? if($arryMember[0]['MaxSms'] == 500) echo 'selected';?>> 500 </option>
							  <option value="750" <? if($arryMember[0]['MaxSms'] == 750) echo 'selected';?>> 750 </option>
							  <option value="1000" <? if($arryMember[0]['MaxSms'] == 1000) echo 'selected';?>> 1000 </option>
							  <option value="1500" <? if($arryMember[0]['MaxSms'] == 1500) echo 'selected';?>> 1500 </option>
							  <option value="2000" <? if($arryMember[0]['MaxSms'] == 2000) echo 'selected';?>> 2000 </option>
                          </select></td>
				      </tr>	-->		  
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status </td>
                      <td align="left" class="blacknormal"><? if($_GET['edit']==1){ ?>
                        Active
                        <input name="Price"  value="<?=$arryMember[0]['Price']?>" type="hidden" class="inputbox" id="Price" size="10" maxlength="10">
        <input type="hidden" name="Status" id="Status" value="1" />
        <? }else{ ?>
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($arryMember[0]['Status']==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($arryMember[0]['Status']==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>
                        <? } ?>                      </td>
                    </tr>
                    <tr>
                      <td align="right" valign="middle" >&nbsp;</td>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
				
				<tr>
                  <td align="center" valign="top" >
				  <br>
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ;?>" />
                    <input type="hidden" name="MembershipID" id="MembershipID"  value="<?=$_GET['edit']?>" />
					
					  <input type="reset" name="Reset" value="Reset" class="button" />
					  <br>  <br>
				  </td>
                </tr>
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{

	if(  ValidateForBlank(frm.Name, "Membership Name") 
		&& ValidateForTextareaOpt(frm.Description, "Description",10,500)
		&& ValidateMandNumField2(frm.Validity,"Validity",1,10000)
	){
		if(document.getElementById("MembershipID").value != 1){
			if(!ValidateMandDecimalField(frm.Price,"Price")){
				return false;	
			}
		}
		
		/*
		if(document.getElementById("ReferralAmount").value > 0 ){
			if(!ValidateMandDecimalField(frm.ReferralAmount,"Referral Amount")){
				return false;	
			}
		}*/
		
		var Url = "isRecordExists.php?Membership="+document.getElementById("Name").value+"&editID="+ document.getElementById("MembershipID").value;
		SendExistRequest(Url,"Name","Membership Name");
		return false;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>