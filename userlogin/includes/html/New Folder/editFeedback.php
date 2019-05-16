<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.Comment, "Comments")
		&& ValidateMandRange(frm.Comment, "Comments",5,200)
		&& ValidateForSimpleBlank(frm.Name, "Name")
		&& ValidateForSimpleBlank(frm.Email, "Email Address")
		&& ValidateForEmail(frm.Email)
		){
			
			return true;
			
		}else{
			return false;	
		}
		
}

</SCRIPT>


<div class="had"> <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="98%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
	
		  <div  align="right"><a href="viewFeedback.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top">
				  <br /> <br />
				  
				  <table width="70%" border="0" cellpadding="5" cellspacing="1"  class="borderall">

				  <? if($arryFeedback[0]['feedbackDate'] > 0){ ?>
                   <tr>
                      <td  align="right" valign="top"   class="blackbold">
					   Posted Date: </td>
                      <td  align="left" valign="top">
	 <? 	
		echo date("jS F, Y H:i:s", strtotime($arryFeedback[0]['feedbackDate']));
		//echo $arryFeedback[0]['feedbackDate'];
?> 	
				</td>
                    </tr>
					<? }  ?>
					<tr >
                      <td width="43%" align="right" valign="top"  class="blackbold">Comments <span class="red">*</span></td>
                      <td align="left" class="blacknormal">
<textarea  name="Comment" id="Comment" class="inputbox" cols="40" rows="3"><?=stripslashes($arryFeedback[0]['Comment'])?></textarea></td>
                    </tr>			
					
					
					<tr>
                      <td  align="right" valign="top"   class="blackbold">
					   Posted By <span class="red">*</span> </td>
                      <td  align="left" valign="top">
					<input  name="Name" id="Name" value="<?=stripslashes($arryFeedback[0]['Name'])?>" type="text" class="inputbox"  size="30" maxlength="30" />					    </td>
                    </tr>
					
					
				
					
					
                    <tr >
                      <td align="right" valign="top"  class="blackbold">Email Address </td>
                      <td align="left" class="blacknormal"><input  name="Email" id="Email" value="<?=stripslashes($arryFeedback[0]['Email'])?>" type="text" class="inputbox"  size="30" maxlength="80"/> </td>
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
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" />
			  <input type="hidden" name="feedbackID" id="feedbackID"  value="<?=$_GET['edit']?>" />
			  <input type="reset" name="Reset" value="Reset" class="button" />
				    <br>  <br>  <br>
				  
				  </td></tr> 
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>