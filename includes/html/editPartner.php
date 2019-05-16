<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		
		<? $ModuleTitle = (!empty($_GET['edit']))?(EDIT_PARTNER) :(ADD_NEW_PARTNER);?>
		
		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?> </span> <?=$ModuleTitle?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=$ModuleTitle?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" class="generaltxt_inner" align="center">
		
		
		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <? if(!empty($errMsg)){ ?>
          <tr>
            <td colspan="2" height="30" align="center" valign="top"  class="red12"><?=$errMsg?></td>
          </tr>
          <? } ?>
        
          <tr>
            <td colspan="2" align="right"  height="50" valign="top"  class="skytxt"><a href="viewPartners.php">
              <? echo MY_PARTNERS; ?>
            </a></td>
          </tr> 
		  
		   <tr>
            <td colspan="2"  valign="top" >
			
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  valign="top">
	
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="5" cellspacing="5" bgcolor="#FFFFFF" class="generaltxt_inner">
                    <tr>
                      <td width="16%" align="left" valign="top" nowrap="nowrap" >
					   <?=PARTNER_TITLE?> <span class="bluestar">*</span> </td>
                      <td width="84%" align="left" valign="top">
					<input  name="heading" id="heading" value="<?=stripslashes($heading)?>" type="text" class="txtfield_contact"  size="31" maxlength="70" />					    </td>
                    </tr>


								
                    <tr>
                      <td  valign="top"   align="left"><?=WEBSITE?> <span class="bluestar">*</span></td>
                      <td height="40" align="left" valign="top" bgcolor="#FFFFFF"><input name="Website" type="text" class="txtfield_contact" id="Website" value="<? echo stripslashes($Website); ?>" size="31" maxlength="100" /> <br>(for e.g. http://webo.co.za)</td>
                    </tr>
                    <tr>
                    <td width="16%"  valign="top"   align="left"> <?=IMAGE?>
					<? if(empty($_GET['edit'])){ echo '<span class="bluestar">*</span>'; } ?>
					
					
					</td>
                    <td width="84%" height="40" align="left" valign="top" bgcolor="#FFFFFF"><input name="Image" type="file" class="textbox" size="19" id="Image"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
                   <span  class="generaltxt_inner">
                 <br><?=SUPPORTED_IMAGE_TYPES?>
				 <br> (Recommended Dimensions: <span id="WidthSpan2"><?=$WidthMax?></span> by <?=$HeightMax?> pixels)
                </span>				</td>
                  </tr>
               
		 <tr>
                      <td nowrap="nowrap" ><?=DISPLAY_WIDTH?> <span class="bluestar"> *</span> </td>
                      <td height="30" align="left"><span >
                        <input type="text" class="txtfield_contact" size="7" maxlength="3" name="DisplayWidth" id="DisplayWidth" value="<?=$DisplayWidth?>"/>
                        <?=$WidthMin?>
                        to
                        <?=$WidthMax?>
                      </span></td>
                    </tr>
                    <tr>
                      <td nowrap="nowrap"><?=DISPLAY_HEIGHT?> <span class="bluestar">*</span> </td>
                      <td height="30" align="left"><span >
                        <input type="text" class="txtfield_contact" size="7" maxlength="3" name="DisplayHeight" id="DisplayHeight" value="<?=$DisplayHeight?>"/>
                        <?=$HeightMin?>
                        to
                        <?=$HeightMax?>
                      </span></td>
                    </tr>						
					
					
                    <tr >
                      <td align="left" valign="top" ><?=STATUS?>  </td>
                      <td align="left" class="blacktxt">
        <table width="151" border="0" cellpadding="0" cellspacing="0"  class="generaltxt_inner">
          <tr>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?=($Status==1)?"checked":""?> /></td>
            <td width="48" align="left" valign="middle">Active</td>
            <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?=($Status==0)?"checked":""?> value="0" /></td>
            <td width="63" align="left" valign="middle">Inactive</td>
          </tr>
        </table>                                            </td>
                    </tr>
                    <tr >
                      <td align="left" valign="top" >&nbsp;</td>
                      <td align="left" >
					  
			<? 
			
			if($_GET['edit'] >0) $ButtonTitle="update.jpg"; else $ButtonTitle="add.jpg";
	
			if($LimitCrossed==1)  $DisabledButton = 'disabled';
			
			?>			  
					  
					  
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="80">
                            <input type="image" name="SubmitButton"  id="SubmitButton" src="images/<?=$ButtonTitle?>" width="72" height="24" value=" "  alt=" <?=$ButtonTitle?> " title=" <?=$ButtonTitle?> " <?=$DisabledButton?>/></td><td ><input type="reset" name="Reset"  width="72" height="24" value=" " class="ResetContact"  <?=$DisabledButton?>/>
                              <input type="hidden" name="partnerID" id="partnerID" value="<? echo $_GET['edit']; ?>" />

                              
							    <input type="hidden" name="MemberID" id="MemberID" value="<?php echo $_SESSION['MemberID']?>" />
							  
							  </td>
                        </tr>
                      </table></td>
                    </tr>

                  
                  </table></td>
                </tr> 
              </form>
          </table>	
	
	</td>
    <td valign="top"  style="padding-top:10px;" align="right">
	
	<? if($Image !='' && file_exists('upload/partners/'.$Image) ){ 
			$ImagePath = 'resizeimage.php?img=upload/partners/'.$Image.'&w='.$DisplayWidth.'&h='.$DisplayHeight; 

			$ImagePath = '<a href="upload/partners/'.$Image.'" rel="lightbox" ><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';
			echo $ImagePath;
			$ImageExist = 1;
		}
	
	?>
	
	<input type="hidden" name="ImageExist" id="ImageExist" value="<?=$ImageExist?>" >
	
	</td>
  </tr>
</table>
	
			
			
			
			
			
			
			</td>
          </tr>
         
        </table>
		

		
		
		</td>
      </tr>
    </table></td>
        <td align="right"  valign="top"><? require_once("includes/html/box/right.php"); ?>    </td>

  </tr>
</table>
</td>
  </tr>
</table>
