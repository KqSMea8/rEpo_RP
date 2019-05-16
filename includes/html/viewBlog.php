<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
             </span> <?=MANAGE_BLOG?>
			
			
			
			</td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading">
		<?=MANAGE_BLOG?>
		
		
			</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
	 
	   <tr>
            <td align="right"   >
			<a href="editBlog.php" class="skytxt"><?=BLOG_POST_COMMENT?></a>
               &nbsp;</td>
            </tr>
	  
	  
			
	   <tr>
              <td align="center" valign="top" class="redtxt" height="35">
			  <? if(!empty($_SESSION['mess_blog'])) {echo $_SESSION['mess_blog']; unset($_SESSION['mess_blog']); }?>
			  </td>
            </tr>
		
      <tr>
        <td height="32" class="generaltxt_inner"><table width="100%" border="0" cellspacing="0" cellpadding="0">
         
          <tr>
            <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                <tr>
                  <td width="100%" align="center" valign="top" ><form action="" method="post" name="formList" id="formList">
                      <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                        <? if(sizeof($arryBlog)){?>
                        <tr align="left" valign="middle" bgcolor="#F5F5F5" style="border-bottom:1px solid #CCCCCC;">
                          <td width="2%" align="left"  ><?=EDIT?></td>
                          
						  <td width="2%" align="left"  ><?=DELETE?></td>
						  <td width="6%"   ><?=STATUS?></td>
						 
						    <td width="17%"   ><?=POSTED_BY?></td>
						    <td width="20%"   ><?=ATTACHEMENTS?></td>
						    <td width="13%" height="20"   ><?=BLOG_DATE?></td>
                          <td width="55%"  ><?=BLOG_TOPIC?></td>
                          </tr>
  <? 
  	foreach($arryBlog as $key=>$Values){
	
	
		$arryReplies=$objBlog->GetNumReplies($_SESSION['MemberID'],$Values['CommentID'],''); 
		$NumReplies = $arryReplies[0]['NumReplies'];
		
		
			$RepliesHTML = '<span class="skytxt"><a href="viewResponse.php?TopicID='.$Values['CommentID'].'">'.$NumReplies.' response(s)</a></span>';
		
	
  ?>
                        
						<tr><td colspan="7" height="1" bgcolor="#DFEBD5" style="padding:0px; margin:0px;"></td></tr>
						
						<tr align="left" valign="top" bgcolor="#FFFFFF"  >
						  <td align="left" class="verdan11" ><a href="editBlog.php?edit=<? echo $Values['CommentID'];?>&amp;curP=<? echo $_GET['curP'];?>"><img src="images/edit.png" border="0" alt="<?=EDIT?>" title="<?=EDIT?>" /></a></td>
                          <td align="left" class="verdan11" ><a href="editBlog.php?del_id=<? echo $Values['CommentID'];?>&TopicID=<? echo $Values['TopicID'];?>&curP=<? echo $_GET['curP'];?>" onclick="return confDel('<?=DELETE_TOPIC_ALERT?>')" ><img src="images/delete.png" border="0" alt="<?=DELETE?>" title="<?=DELETE?>"/></a></td>
                          <td valign="top" class="verdan11"><? 
		 if($Values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = '<span class="red12">InActive</span>';
		 }
		echo $status;
	 ?></td>
                          <td valign="top" class="verdan11"><?=$Values['PostedByName']?></td>
                          <td valign="top" class="skytxt">
				<?
	$Attachment = '';
	if($Values['AttachFile1'] !='' && file_exists('upload/blog/'.$Values['AttachFile1']) ){
		$Attachment .= '<a href="dwn.php?attachments='.$Values['AttachFile1'].'" >'.$Values['AttachFile1'].'</a>';
	}
	if($Values['AttachFile2'] !='' && file_exists('upload/blog/'.$Values['AttachFile2']) ){
		if(!empty($Attachment)) $Attachment .= '&nbsp;<span class="verdan11">,</span>&nbsp;';
		$Attachment .= '<a href="dwn.php?attachments='.$Values['AttachFile2'].'" >'.$Values['AttachFile2'].'</a>';
	}
	
	if(empty($Attachment)) $Attachment = '<span class="verdan11">No Attachments</span>';
	
	echo $Attachment;
	?>		  
						  
						  
						  </td>
                          <td height="20" valign="top" class="verdan11"> <?=$Values['CommentDate']?></td>
                          <td class="verdan11">
						  <?=stripslashes($Values['Comment'])?>
						 
						  <br><?=$RepliesHTML?>						  </td>
                          </tr>
						  
						  
						  
                        <? } // foreach end //?>
                        <? }else{?>
                        <tr align="center" >
                          <td height="30" colspan="7" class="redtxt"><?=NO_COMMENT_POSTED?></td>
                        </tr>
                        <? } ?>
                      </table>
                    <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                  </form></td>
                </tr>
                <? 	if($num>count($arryBlog)){ ?>
                <tr >
                  <td height="20"  >&nbsp;<? echo $pagerLink; ?> </td>
                </tr>
                <? } ?>
            </table></td>
          </tr>
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
