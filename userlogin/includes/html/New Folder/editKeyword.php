

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if(  ValidateForSelect(frm.KeywordType, "Search Type")
			&& ValidateForSimpleBlank(frm.Keyword, "Search Term")
		){
			
			if(CheckSpecialCharactersForSearch(frm.Keyword,"Search Term")){
				return false;
			}
		
			var Url = "isRecordExists.php?Keyword="+escape(document.getElementById("Keyword").value)+"&editID="+document.getElementById("keywordID").value+"&KeywordType="+document.getElementById("KeywordType").value;
			SendExistRequest(Url,"Keyword","Search Term");
			
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>

<div class="had"> <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="70%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
	
		  <div  align="right"><a href="viewKeywords.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="98%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				  
				  <tr>
                      <td align="right" valign="top" =""  class="blackbold">
					  Search Type  <span class="red">*</span>
					  </td>
                      <td align="left">
					 
<select name="KeywordType" class="blacknormal" id="KeywordType" style="width: 180px;" >
  <option value="Product" <? if($KeywordType=='Product'){echo "selected";}?>>Product</option>
  <option value="Website" <? if($KeywordType=='Website'){echo "selected";}?>>Website</option>
</select> 
			
			
					  </td>
                    </tr>
				  
                    <tr>
                      <td width="38%" align="right" valign="top" =""  class="blackbold">
					   Search Term  <span class="red">*</span> </td>
                      <td width="62%" align="left" valign="top">
					<input  name="key" id="key" value="<?=stripslashes($Keyword)?>" type="text" class="inputbox"  size="27" maxlength="70" />					    </td>
                    </tr>
                   
					
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Status  </td>
                      <td align="left" class="blacknormal">
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="blacknormal">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>	
									
                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit' ;?>"  <?=$Disabled?>/>
			  <input type="hidden" name="keywordID" id="keywordID"  value="<?=$_GET['edit']?>" />
			  <input type="reset" name="Reset" value="Reset" class="button" />
				    <br>  <br>  <br>
				  
				  </td></tr> 
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>