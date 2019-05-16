
<div class="had">
<?=stripslashes($arryCategory[0]['Name'])?> Packages<br><br>
  <? 
			$PackageTitle = (!empty($_GET['edit']))?("&nbsp; Edit ") :("&nbsp; Add ");
			echo $PackageTitle.$ModuleName;
			 ?>
			 
</div>
<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD HEIGHT=398 align="center" valign="top"><table width="100%" height="388"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="388" align="center" valign="middle">
		  <div  align="right"><a href="viewPackages.php?CatID=<?=$_GET['CatID']?>" class="Blue">List <?=$ModuleName?>s</a></div><br>
		    <table width="100%" height="110" border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
             
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                   
				    <tr   <?=$TypeDisplay?> >
                      <td align="right" valign="middle"  class="blackbold">Type </td>
                      <td align="left" valign="middle" class="blacknormal">
				<select name="Type" id="Type" class="inputbox" onchange="Javascript: ShowHide();">
					<option value="Impression" <? if($arryPackage[0]['Type'] == 'Impression') echo 'selected';?>> Impression </option>
					<option value="Duration" <? if($arryPackage[0]['Type'] == 'Duration') echo 'selected';?>> Duration </option>
                  </select>
				  
				  </td>
                    </tr>
				   
				    <tr>
                      <td width="42%" align="right" valign="middle"  class="blackbold"> Package Name <span class="red">*</span> </td>
                      <td width="58%" align="left"><input value="<?=stripslashes($arryPackage[0]['Name'])?>" name="Name" type="text" class="inputbox" id="Name" size="30" maxlength="30" <? if($_GET['edit']==1) echo 'Readonly'; ?>/> </td>
                    </tr>
                   
				     <tr>
                      <td align="right" valign="middle"  class="blackbold">Price <span class="red">*</span> </td>
                      <td align="left" valign="middle" class="blacknormal"><input name="Price"  value="<?=$arryPackage[0]['Price']?>" type="text" class="inputbox" id="Price" size="10" maxlength="10"> <?=$Config['Currency']?>                        </td>
                    </tr>
				   
                    <tr>
                      <td align="right" valign="middle"  class="blackbold">
					 
					 <Div id="ImpressionTitle" <? if($arryPackage[0]['Type'] != 'Impression') echo 'style="display:none;"';?> > No of <?=$ImpressionTitle?> <span class="red">*</span> </Div>
					  
					   </td>
                      <td align="left" valign="middle" class="blacknormal">
					  <Div id="ImpressionValue" <? if($arryPackage[0]['Type'] != 'Impression') echo 'style="display:none;"';?>> 
					  <input name="Impression" value="<?=$arryPackage[0]['Impression']?>"  type="text" class="inputbox" id="Impression" size="5" maxlength="6"  />
					  </Div>
					  
					  </td>
                    </tr>
				   
				   
				    <tr>
                      <td align="right" valign="middle"  class="blackbold">
					   
				 <Div id="DurationTitle"  <? if($arryPackage[0]['Type'] == 'Impression') echo 'style="display:none;"';?> > Validity ( In Days) <span class="red">*</span> </Div>	   
					   
					  
					  </td>
                      <td align="left" valign="middle" class="blacknormal">
			<Div id="DurationValue"  <? if($arryPackage[0]['Type'] == 'Impression') echo 'style="display:none;"';?>>		  
	 <input name="Validity" value="<?=$arryPackage[0]['Validity']?>"  type="text" class="inputbox" id="Validity" size="5" maxlength="5" />  </Div>
					  
					  </td>
                    </tr>
                   
                  
                   
					
					
					   
                    <tr >
                      <td align="right" valign="middle"  class="blackbold">Status </td>
                      <td align="left" class="blacknormal"><? if($_GET['edit']==1){ ?>
                        Active
                        <input name="Price"  value="<?=$arryPackage[0]['Price']?>" type="hidden" class="inputbox" id="Price" size="10" maxlength="10">
        <input type="hidden" name="Status" id="Status" value="1" />
        <? }else{ ?>
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($arryPackage[0]['Status']==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($arryPackage[0]['Status']==0)?"checked":""?> value="0" /></td>
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
				  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>" />
                    <input type="hidden" name="PackageID" id="PackageID"  value="<?=$_GET['edit']?>" />
                    <input type="hidden" name="CatID" id="CatID" value="<? echo $_GET['CatID']; ?>" />
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

var ImpressionTitle = '<?=$ImpressionTitle?>';
function ShowHide()
{
	if(document.getElementById("Type").value == 'Impression'){
		document.getElementById("ImpressionTitle").style.display = 'block'; 
		document.getElementById("ImpressionValue").style.display = 'block'; 

		document.getElementById("DurationTitle").style.display = 'none'; 
		document.getElementById("DurationValue").style.display = 'none'; 
	}else{
		document.getElementById("ImpressionTitle").style.display = 'none'; 
		document.getElementById("ImpressionValue").style.display = 'none'; 

		document.getElementById("DurationTitle").style.display = 'block'; 
		document.getElementById("DurationValue").style.display = 'block'; 

	}

}

function ValidateForm(frm)
{

	if(  ValidateForBlank(frm.Name, "Package Name") 
		 && ValidateMandDecimalField(frm.Price,"Price")
	){
		if(document.getElementById("Type").value == 'Duration'){
			if(!ValidateMandNumField2(frm.Validity,"Validity",1,10000)){
				return false;	
			}
		}else{
			if(!ValidateMandNumField2(frm.Impression,"No of "+ImpressionTitle,1,10000)){
				return false;	
			}
		}
		
		var Url = "isRecordExists.php?Package="+document.getElementById("Name").value+"&editID="+ document.getElementById("PackageID").value+"&CatID="+ document.getElementById("CatID").value;
		SendExistRequest(Url,"Name","Package Name");
		return false;
	}else{
		return false;	
	}
	
	
	
}

</SCRIPT>