<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
    <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		
		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>   </span> 
		<?=SEARCH_ENGINE_DESCRIPTION?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=$SEARCH_ENGINE_DESCRIPTION?>
        </td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	   	
		 <tr>
              <td align="center" valign="top" class="redtxt" height="30" >
			  <? if(!empty($_SESSION['mess_seo'])) {
				  echo $_SESSION['mess_seo']; 
				  unset($_SESSION['mess_seo']); 
			  }?>
			  </td>
            </tr>	
			
			
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%"  border="0" cellspacing="0" cellpadding="0" >
          <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);">
           
       
            <tr>
              <td align="center" valign="top"  bgcolor="#FFFFFF" height="200" >
               
               
                    <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
					  
					  <tr>
                        <td>
						<table width="100%" border="0" align="right" cellpadding="5" cellspacing="0" class="generaltxt_inner">
                         
	
   
 
  <tr>
    <td width="15%" valign="top"><?=META_TITLE?>  <span class="bluestar">*</span>&nbsp;  </td>
    <td align="left">
	<input name="MetaTitle" type="text" class="txtfield_contact"   style="width:330px;" maxlength="200" id="MetaTitle" value="<?php echo stripslashes($arrySeo[0]['MetaTitle']); ?>"  /> </td>
  </tr>
  <tr>
    <td    valign="top"><?=META_KEYWORDS?>  &nbsp;  </td>
    <td  align="left">
	<textarea name="MetaKeywords" id="MetaKeywords" class="txtfield_contact"  cols="30" rows="6" style="width:330px;" ><?php echo stripslashes($arrySeo[0]['MetaKeywords']); ?></textarea><br><span ><?=SEPARATE_ENTRIES_COMMAS?></span><br><br></td>
  </tr>
   <tr>
    <td    valign="top"><?=META_DESCRIPTION?>  &nbsp;  </td>
    <td  align="left">
	<textarea name="MetaDescription" id="MetaDescription" class="txtfield_contact"  cols="30" rows="6" style="width:330px;" ><?php echo stripslashes($arrySeo[0]['MetaDescription']); ?></textarea><br><span ><?=SEPARATE_ENTRIES_COMMAS?></span><br><br></td>
  </tr>
 
 
 
 
						 
						 
                          <tr>
                            <td height="62"   align="right" valign="top" ></td>
                            <td align="left"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="80">
								
								  
								  <input type="image" name="SubmitButton"  id="SubmitButton" src="images/add.jpg" width="72" height="24" value=" "  alt=" Submit " title=" Submit " /></td>
                                  <td >
			  <input type="reset" name="Reset"  alt=" Reset " title=" Reset "   width="72" height="24" value=" " class="ResetContact"  />
			  
			
			
			    <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID'];?>" />
			 
						  								  </td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table>
              
                </td>
            </tr>
         
          
           
          </form>
        </table></td>
      </tr>
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
  </tr>
</table>
