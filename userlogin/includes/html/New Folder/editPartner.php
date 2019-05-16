

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if(  ValidateForBlank(frm.heading, "Logo Title")
		&& isValidLink(frm.Website,"Website")
		&& ValidateOptionalUpload(frm.Image, "Logo")
		//&& ValidateForTextareaOpt(frm.detail,"Partner Detail",5,100)
		){
			
		
			var Url = "isRecordExists.php?PartnerHeading="+escape(document.getElementById("heading").value)+"&editID="+document.getElementById("partnerID").value;
			SendExistRequest(Url,"heading","Logo Title");
			
			
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
	
		  <div  align="right"><a href="viewPartners.php" class="Blue">List Footer Logos</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="98%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="38%" align="right" valign="top" =""  class="blackbold">
					   Logo Title <span class="red">*</span> </td>
                      <td width="62%" align="left" valign="top">
					<input  name="heading" id="heading" value="<?=stripslashes($heading)?>" type="text" class="inputbox"  size="27" maxlength="70" />					    </td>
                    </tr>


								
                    <tr>
                      <td  class="blackbold" valign="top"   align="right">Website <span class="red">*</span></td>
                      <td height="40" align="left" valign="top" ><input name="Website" type="text" class="inputbox" id="Website" value="<?php echo stripslashes($Website); ?>" size="27" maxlength="100" />  <?=$MSG[205]?></td>
                    </tr>
                    <tr>
                    <td width="38%"  class="blackbold" valign="top"   align="right"> Upload Logo</td>
                    <td width="62%" height="40" align="left" valign="top"  class="blacknormal"><input name="Image" type="file" class="textbox" size="19" id="Image"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
					<br> 	
(Recommended Dimensions: 50*50 to 300*300)  <br><?=$MSG[201]?>
           				</td>
                  </tr>
                  <?php if($Image !='' && file_exists('../upload/partners/'.$Image) ){ ?>
                  <tr>
                    <td width="38%"  class="blackbold"  align="right" valign="top" >Current Logo: </td>
                    <td width="62%" height="30" align="left" valign="top">
			<a href="#" onclick="OpenNewPopUp('../showimage.php?img=upload/partners/<?php echo $Image;?>', 150, 100, 'yes' );">		
				<? echo '<img src="../resizeimage.php?w=100&h=100&img=upload/partners/'.$Image.'" border=0 >';?>
				</a> </td>
                  </tr>
                  <? }?>			
					
					
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
								<!--	 <tr >
                      <td align="right" valign="top"  class="blackbold" >Partner Detail:
                      <td align="left" class="blacknormal"  valign="top"><textarea name="detail" id="detail" class="inputbox" cols="35" rows="2"><?=stripslashes($arryPartner[0]['detail'])?></textarea>                      </td>
                    </tr>-->

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit';?> " />
			  <input type="hidden" name="partnerID" id="partnerID"  value="<?=$_GET['edit']?>" />
			  <input type="reset" name="Reset" value="Reset" class="button" />
				    <br>  <br>  <br>
				  
				  </td></tr> 
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>