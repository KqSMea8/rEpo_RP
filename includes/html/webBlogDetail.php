      
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=$BlogTabTitle?></div>
            </td>
          </tr>
		  
		  
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top">
			
			
      <table width="98%" align="center" border="0" cellpadding="3" cellspacing="0" class="generaltxt_inner" >
	   <tr>
            <td align="right" 	><a href="webBlog.php" class="view_link" style="float:none">Back</a> | <a href="webBlogPost.php" class="view_link" style="float:none"><?=BLOG_POST_COMMENT?></a> &nbsp;
            </td>
          </tr>
<? if(sizeof($arryBlog)){
	
		$arryReplies=$objBlog->GetNumReplies($_SESSION['StoreID'],$arryBlog[0]['CommentID'],1); 
		$NumReplies = $arryReplies[0]['NumReplies'];
	
  ?>
                        
						
						
						<tr>
						  <td  valign="top" >
						  <strong><?=stripslashes($arryBlog[0]['Comment'])?></strong></td>
                          </tr>
						 <tr>
						  <td valign="top" >
<? 
echo POSTED_BY.': '.$arryBlog[0]['PostedByName'].' on <i>'.date("jS F,  Y H:i:s", strtotime($arryBlog[0]['CommentDate'])).'</i>'; 

?>  </td>
                          </tr>
						  <tr >
						  <td  valign="top" >
						    <?=nl2br(stripslashes($arryBlog[0]['CommentDetail']))?>
						 	  </td>
                          </tr> 
						   <tr >
						  <td  valign="top"  >  
						  
					  
						  
	<?
	if($arryBlog[0]['AttachFile1'] !='' && file_exists('upload/blog/'.$arryBlog[0]['AttachFile1']) ){
	$AttachExtension = GetExtension($arryBlog[0]['AttachFile1']);
	echo '<a href="'.$Config['Url'].'dwn.php?attachments='.$arryBlog[0]['AttachFile1'].'" >Dowload '.$AttachExtension.' file</a>';
	}
	
	if($arryBlog[0]['AttachFile2'] !='' && file_exists('upload/blog/'.$arryBlog[0]['AttachFile2']) ){
	$AttachExtension = GetExtension($arryBlog[0]['AttachFile2']);
	echo '&nbsp;&nbsp;<a href="'.$Config['Url'].'dwn.php?attachments='.$arryBlog[0]['AttachFile2'].'" >Dowload '.$AttachExtension.' file</a>  ';
	}
	
	
	?>					  
						  
						  
						 
		<? if($_GET['resp']<=0){ ?>	 
			&nbsp;&nbsp; <a href="webBlogDetail.php?CommentID=<?=$arryBlog[0]['CommentID']?>&resp=1"	><?=$NumReplies?> response(s)</a>
		 <? } ?>
						 
						  </td>
                          </tr> 
	  <? if(!empty($_SESSION['mess_blog'])) {?>
	 <tr>
		<td class="redtxt" align="center" height="60">
		<? echo $_SESSION['mess_blog']; ?>
		</td>
	</tr> 
	<? } 
	 ?> 
					<? if($_GET['resp']>0 && empty($_SESSION['mess_blog'])){ ?>	  
						<tr>
							<td><div class="heading" ><?=BLOG_RESPONSES?></div>
							</td>
          				</tr> 
						 
						<tr >
						  <td  valign="top">
						  
	 <table width="98%" align="center" cellpadding="3" cellspacing="0" class="generaltxt_inner" >
<? if(sizeof($arryResponse)){
	$Count = 0;
  	foreach($arryResponse as $key=>$Values){
	$Count++;
	
		$arryReplies=$objBlog->GetNumReplies($_SESSION['StoreID'],$Values['CommentID'],1); 
		$NumReplies = $arryReplies[0]['NumReplies'];
	
  ?>
                        
						
						
						
						 <tr>
						  <td valign="top" class="cart_title" >
<? 
echo ' On <i>'.date("jS F,  Y H:i:s", strtotime($Values['CommentDate'])).'</i>&nbsp;&nbsp;  <b>'.$Values['PostedByName'].'</b> says :'; 

?>  </td>
                          </tr>
						  <tr >
						  <td  valign="top" >
						    <?=nl2br(stripslashes($Values['CommentDetail']))?>
						 	  </td>
                          </tr> 
						   <tr >
						  <td  valign="top"  >  
						  
					  
						  
	<?
	if($Values['AttachFile1'] !='' && file_exists('upload/blog/'.$Values['AttachFile1']) ){
	$AttachExtension = GetExtension($Values['AttachFile1']);
	echo '<a href="'.$Config['Url'].'dwn.php?attachments='.$Values['AttachFile1'].'" >Dowload '.$AttachExtension.' file</a>';
	}
	
	if($Values['AttachFile2'] !='' && file_exists('upload/blog/'.$Values['AttachFile2']) ){
	$AttachExtension = GetExtension($Values['AttachFile2']);
	echo '&nbsp;&nbsp;<a href="'.$Config['Url'].'dwn.php?attachments='.$Values['AttachFile2'].'" >Dowload '.$AttachExtension.' file</a>  ';
	}
	
	
	?>					  
						  
						  
						 
						  
						
						 
						  </td>
                          </tr> 
						    <tr >
						  <td  valign="top" height="10" > </td>
                          </tr> 
						 
							
                        <? } // foreach end //?>
						
				 <? if($num>count($arryResponse)){ ?>
                <tr >
                  <td height="20"  class="skytxt">&nbsp;<? echo $pagerLink; ?> </td>
                </tr>
                <? } ?>
						
						
                        <? }else{?>
                        <tr  >
                          <td height="30" align="center" class="redtxt"><?=NO_RESPONSE_POSTED?></td>
                        </tr>
                        <? } ?>
                      </table>					  
						  </td>
						</tr>   
				  <? } ?>
					  
						  
						    <tr >
						  <td  valign="top" height="10" > </td>
                          </tr> 
					<? if(empty($_SESSION['mess_blog'])){ ?>	  
						  
					<tr>
						<td ><div class="heading" ><?=BLOG_LEAVE_RESPONSE?></div>
						</td>
          			</tr>
					
	<? if(!empty($_SESSION['MemberID'])){ ?>
	
	 
	
 	
 <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);"> 
 	  <tr >
						  <td  valign="top" >
						 
						  
						  <table width="99%" border="0" align="right" cellpadding="5" cellspacing="0" class="generaltxt_inner">
                            
                            <tr>
                              <td   width="15%"  valign="top"><?=BLOG_COMMENTS?>:
                                  </td>
                              <td  align="left"><textarea name="CommentDetail" id="CommentDetail" class="txt-feild"  cols="50" rows="10" style="width:330px;" ></textarea> <span class="mandatory">*</span>
                                  <input name="Comment" type="hidden" id="Comment" value="Response Comment" />
                                  <br />
                                <span >( Between 10-2000 characters.)</span><br />
                                <br /></td>
                            </tr>
                            <tr <? if($_SESSION['MemberID']!=$_SESSION['StoreID']) echo 'style="display:none"';?> >
                              <td  ><?=BLOG_UPLOAD_FILE1?>:</td>
                              <td  align="left"><input name="AttachFile1" type="file" class="txt-feild"  id="AttachFile1"   onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" style="width:330px;"/>
                                 
                              </td>
                            </tr>
                          <tr <? if($_SESSION['MemberID']!=$_SESSION['StoreID']) echo 'style="display:none"';?> >
                              <td  ><?=BLOG_UPLOAD_FILE2?>:</td>
                              <td  align="left"><input name="AttachFile2" type="file" class="txt-feild"  id="AttachFile2"   onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" style="width:330px;"/>
                                
                              </td>
                            </tr>
                          <tr <? if($_SESSION['MemberID']!=$_SESSION['StoreID']) echo 'style="display:none"';?> >
                                    <td  ></td>
                                    <td  align="left"><?=SUPPORTED_BLOG_FILE_TYPES?>
                                     
                                    </td>
                                  </tr>
                          
                            <tr>
                              <td height="42"   align="right" valign="top" ></td>
                              <td align="left"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="67">
									<input  class="button" type="submit" name="Submit22" value="Submit" alt="Submit" title="Submit"/>
           </td>
                                    <td width="688" >
                                       <input  class="button" type="reset" name="Submit2" value="<?=RESET?>" alt="<?=RESET?>" title="<?=RESET?>"/>
                                        <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID'];?>" />
                                        <input type="hidden" name="StoreID" id="StoreID" value="<? echo $_SESSION['StoreID'];?>" />
                                        <input type="hidden" name="TopicID" id="TopicID" value="<?=$_GET['CommentID']?>" />
										 <input type="hidden" name="Status" id="Status" value="1"  />
										
                                    </td>
                                  </tr>
                              </table></td>
                            </tr>
							
							
							
                          </table></td>
                          </tr> 
						  </form>		 
						  <?  }else{ ?>
						   <tr  >
                          <td height="80" align="center" class="redtxt"><?=BLOG_LOGIN_RESPONSE?></td>
                        </tr>
						  <? }
						  
						  } ?>
						  
						  
                      
                        <? }else{?>
                        <tr  >
                          <td height="80" align="center" class="redtxt"><?=NO_COMMENT_POSTED?></td>
                        </tr>
                        <? } 
						
						
					unset($_SESSION['mess_blog']);	
						?>
                      </table>
                    
                  </td>
                </tr>
              
            </table>
			
			</td>
          </tr>
         
        </table>
  

