
<div class="had"> <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?></div>

<TABLE WIDTH="70%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD  align="center" valign="top"><table width="100%"   border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
	
		  <div  align="right"><a href="viewVideos.php" class="Blue">List <?=$ModuleName?>s</a>&nbsp;</div><br>
		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="98%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				  
				  <tr>
                      <td align="right" valign="top" =""  class="blackbold">
					  Video Category  <span class="red">*</span>
					  </td>
                      <td align="left">
					  <? if(sizeof($arryVideoCategory)>0){?>
		  <select name="catID" class="blacknormal" id="catID" style="width: 180px;" >
		  	  <option value="">--- Select Category ---</option>
              <? for($i=0;$i<sizeof($arryVideoCategory);$i++) {?>
              <option value="<?=$arryVideoCategory[$i]['catID']?>" <?  if($arryVideoCategory[$i]['catID']==$catID){echo "selected";}?>>
              <?=stripslashes($arryVideoCategory[$i]['Name'])?>
              </option>
              <? } ?>
            </select> 
			<? }else{
				$Disabled = 'disabled="disabled"';
			?>
			<span class="red">No Category Found.</span> 
			<? } ?>
					  </td>
                    </tr>
				  
                    <tr>
                      <td width="38%" align="right" valign="top" =""  class="blackbold">
					   Video Title <span class="red">*</span> </td>
                      <td width="62%" align="left" valign="top">
					<input  name="heading" id="heading" value="<?=stripslashes($heading)?>" type="text" class="inputbox"  size="27" maxlength="70" />					    </td>
                    </tr>
                    <tr>
                        <td align="right" valign="top"    class="blackbold">Sort Order : </td>
                        <td height="30" align="left"><input  name="sort_order" value="<?=$sort_order?>" type="text" class="inputbox" id="sort_order" size="4" maxlength="4" /></td>
                      </tr>
					
	  <tr>
    <td height="50" align="right" valign="top"   class="blackbold"> Video File :  </td>
    <td height="50" align="left" valign="top" class="blacknormal">
	<input name="Video" type="file" class="textbox" id="Video" size="19" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"><br>
	(supported file types: swf and flv)	</td>
  </tr>
<? if($Video !='' && file_exists('../videos/'.$Video) ){ ?>
<tr>
  <td width="38%" align="right"   class="blackbold">Current Video File : </td>
    <td width="62%" height="30" align="left"  class="blacknormal">
								
		<a href="#" onclick="OpenNewPopUp('../videoplayer.php?vd=<? echo $Video;?>&image=videos/videos_image/<?php echo $Image;?>', 330, 330, 'yes' );"><? echo stripslashes($Video);?></a>		
				
				
				
							  </td>
  </tr>  
<?
	}
?>

								
 				<tr>
                    <td width="38%"  class="blackbold" valign="top"   align="right"> Video Thumbnail:</td>
                    <td width="62%" height="40" align="left" valign="top"  class="blacknormal"><input name="Image" type="file" class="textbox" size="19" id="Image"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
                   <br> <?=$MSG[200]?> <br><?=$MSG[201]?>					</td>
                  </tr>
				  
                  <?php if($Image !='' && file_exists('../videos/videos_image/'.$Image) ){ ?>
          		 <tr>
                    <td width="38%"  class="blackbold"  align="right" >Current Thumbnail: </td>
                    <td width="62%" height="30" align="left" >
			<a href="#" onclick="OpenNewPopUp('../showimage.php?img=videos/videos_image/<?php echo $Image;?>', 150, 100, 'yes' );">		
					<?php echo '<img src="../videos/videos_image/'.$Image.'" height="50" width="50" border=0 >';
				?></a> </td>
                  </tr>
                  <? }?>			
				
			<tr>
                    <td  class="blackbold" valign="top"   align="right"> Uplaod PDF:</td>
                    <td  height="40" align="left" valign="top"  class="blacknormal"><input name="Pdf" type="file" class="textbox" size="19" id="Pdf"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
                   				</td>
                  </tr>
				  
                  <?php if($Pdf !='' && file_exists('../videos/pdf/'.$Pdf) ){ ?>
          		 <tr>
                    <td  class="blackbold"  align="right" >Current PDF: </td>
                    <td height="30" align="left" >
					<?php echo '<a href="../videos/pdf/'.$Pdf.'" target="_blank">'.$Pdf.'</a>'; ?> 
				</td>
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
									 <tr >
                      <td align="right" valign="top"  class="blackbold" >Video Detail:
                      <td align="left" class="blacknormal"  valign="top"><textarea name="detail" id="detail" class="inputbox" cols="35" rows="4"><?=stripslashes($arryVideo[0]['detail'])?></textarea>
                      </td>
                    </tr>

                  
                  </table></td>
                </tr>
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?> <?=$ModuleName?>"  <?=$Disabled?>/>
			  <input type="hidden" name="videoID" id="videoID"  value="<?=$_GET['edit']?>" />
			  <input type="reset" name="Reset" value="Reset" class="button" />
				  
				  </td></tr> 
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if(  ValidateForSelect(frm.catID, "Video Category")
		&& ValidateForBlank(frm.heading, "Video Title")
		&& ValidateOptNumField(frm.sort_order, "Sort Order")
		&& ValidateOptionalUploadVideo(frm.Video, "Video File")
		&& ValidateOptionalUpload(frm.Image, "Video Thumbnail")
		&& ValidateForTextareaOpt(frm.detail,"Video Detail",5,300)
		&& ValidateOptionalUploadPdf(frm.Pdf)
		){
			
		
			var Url = "isRecordExists.php?VideoHeading="+document.getElementById("heading").value+"&editID="+document.getElementById("videoID").value;
			SendExistRequest(Url,"heading","Video Title");
			
			
			return false;
			
		}else{
			return false;	
		}
		
}



</SCRIPT>