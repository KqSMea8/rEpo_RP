<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
    <tr>
        <td height="32" align="left" valign="middle" class="pagenav">
		
		<span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>  <a href="viewBlog.php"><?=MANAGE_BLOG?></a>  </span> <?=$ModuleTitle?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=$ModuleTitle?>
        </td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	   	 <tr>
            <td colspan="2" align="right" height="35"  valign="top"  class="skytxt">
			<a href="viewBlog.php"><? echo MANAGE_BLOG; ?></a></td>
          </tr>
		     <tr>
              <td align="center" valign="top" class="redtxt" >
			  <? if(!empty($errMsg)) {echo $errMsg;  }?>
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
                         
	 <?php if (!empty($CommentID)) {?>
   <tr>
    <td    valign="top" ><?=BLOG_DATE?></td>
    <td  align="left"   valign="top" >
	<? 	
	if($arryBlog[0]['CommentDate'] > 0){	
		echo  $arryBlog[0]['CommentDate'];//date("jS F,  Y H:i:s", strtotime($arryBlog[0]['CommentDate']));
	}
	 echo '&nbsp;&nbsp;&nbsp;&nbsp;[Time zone : '.date_default_timezone_get().']'; ?></td>
  </tr>
 <tr>
    <td  valign="top" ><?=POSTED_BY?></td>
    <td  align="left"   valign="top" >
	<?=$arryBlog[0]['PostedByName']?>	</td>
  </tr>
  
  <? }?>
   
 
  <tr>
    <td width="15%" valign="top"><?=BLOG_TOPIC?>  <span class="bluestar">*</span>&nbsp;  </td>
    <td align="left">
	<input name="Comment" type="text" class="txtfield_contact"   style="width:330px;" maxlength="100" id="Comment" value="<?php echo stripslashes($arryBlog[0]['Comment']); ?>"  /><br> <span >( Between 5-100 characters.)</span><br><br></td>
  </tr>
  <tr>
    <td    valign="top"><?=BLOG_COMMENTS?>  <span class="bluestar">*</span>&nbsp;  </td>
    <td  align="left">
	<textarea name="CommentDetail" id="CommentDetail" class="txtfield_contact"  cols="50" rows="15" style="width:330px;" ><?php echo stripslashes($arryBlog[0]['CommentDetail']); ?></textarea><br><span >( Between 10-2000 characters.)</span><br><br></td>
  </tr>
  
  <tr>
    <td  ><?=BLOG_UPLOAD_FILE1?></td>
    <td  align="left"><input name="AttachFile1" type="file" class="txtfield_contact"  id="AttachFile1" size="17"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
	<?
	if($arryBlog[0]['AttachFile1'] !='' && file_exists('upload/blog/'.$arryBlog[0]['AttachFile1']) ){
		echo '<a href="dwn.php?attachments='.$arryBlog[0]['AttachFile1'].'" class="skytxt">'.$arryBlog[0]['AttachFile1'].'</a>';
		echo '&nbsp;&nbsp;<input type="checkbox" name="DelAttachFile1" value="upload/blog/'.$arryBlog[0]['AttachFile1'].'">Delete';
	}
	?>	</td>
  </tr>
  <tr>
    <td  ><?=BLOG_UPLOAD_FILE2?></td>
    <td  align="left"><input name="AttachFile2" type="file" class="txtfield_contact"  id="AttachFile2" size="17"  onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" />
	<?
	if($arryBlog[0]['AttachFile2'] !='' && file_exists('upload/blog/'.$arryBlog[0]['AttachFile2']) ){
		echo '<a href="dwn.php?attachments='.$arryBlog[0]['AttachFile2'].'" class="skytxt">'.$arryBlog[0]['AttachFile2'].'</a>';
		echo '&nbsp;&nbsp;<input type="checkbox" name="DelAttachFile2" value="upload/blog/'.$arryBlog[0]['AttachFile2'].'">Delete';
	}
	?>	</td>
  </tr>
  <tr>
    <td  >&nbsp;</td>
    <td  align="left"><?=SUPPORTED_BLOG_FILE_TYPES?></td>
  </tr>
  <tr>
    <td  >&nbsp;</td>
    <td  align="left">&nbsp;</td>
  </tr>
  <tr>
    <td  >Status </td>
    <td  align="left"><span >
<? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryBlog[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryBlog[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
		  <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?>>Active&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?>>InActive    </span></td>
  </tr>
 
						 
						 
                          <tr>
                            <td height="62"   align="right" valign="top" ></td>
                            <td align="left"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="80">
								<?
								if($_GET['edit'] >0) $ButtonTitle="update.jpg"; else $ButtonTitle="add.jpg";
								?>  
								  
								  <input type="image" name="SubmitButton"  id="SubmitButton" src="images/<?=$ButtonTitle?>" width="72" height="24" value=" "  alt=" <?=$ModuleTitle?> " title=" <?=$ModuleTitle?> " <?=$DisabledButton?>/></td>
                                  <td >
			  <input type="reset" name="Reset"  alt=" Reset " title=" Reset "   width="72" height="24" value=" " class="ResetContact"  />
			  
			  <input type="hidden" name="CommentID" id="CommentID" value="<?=$_GET['edit']?>" />	
			   <input type="hidden" name="MemberID" id="MemberID" value="<? echo $PostedByID;?>" />
			    <input type="hidden" name="StoreID" id="StoreID" value="<? echo $_SESSION['MemberID'];?>" />
			 
			  <input type="hidden" name="TopicID" id="TopicID" value="<?=$arryBlog[0]['TopicID']?>" />			  								  </td>
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
