      
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=BLOG_POST_COMMENT?></div>
            </td>
          </tr>
		
		
	
	
	
	 
	
 <form action=""  method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return validate(this);"> 
		 	 <tr >
						  <td  valign="top" class="featuretable_border"  ><table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                           
			 <tr>
            <td align="right" 	><a href="webBlog.php" class="view_link" style="float:none">Back</a> &nbsp;
            </td>
          </tr>
		   <? 
	
	 if(!empty($_SESSION['mess_blog'])) {?>
	 
	 <tr>
		<td align="center" height="300" >
		<div class="redtxt" align="center"><? echo $_SESSION['mess_blog']; unset($_SESSION['mess_blog']); ?></div>
		</td>
	</tr> 
	<? }else{
	 
	  if(!empty($_SESSION['MemberID'])){ ?>
		  
		  <tr>
                              <td><table width="98%" border="0" align="right" cellpadding="5" cellspacing="0" class="generaltxt_inner">
                                  
                                  <tr>
                                    <td width="15%" valign="top"><?=BLOG_TOPIC?>:
                                        </td>
                                    <td align="left"><input name="Comment" type="text" class="txt-feild"   style="width:330px;" maxlength="100" id="Comment" value="<?php echo stripslashes($arryBlog[0]['Comment']); ?>"> <span class="mandatory">*</span>
                                        <br />
                                        <span >( Between 5-100 characters.)</span><br />
                                      <br /></td>
                                  </tr>
                                  <tr>
                                    <td    valign="top"><?=BLOG_COMMENTS?>:
                                        </td>
                                    <td  align="left"><textarea name="CommentDetail" id="CommentDetail" class="txt-feild"  cols="50" rows="15" style="width:330px;" ><?php echo stripslashes($arryBlog[0]['CommentDetail']); ?></textarea> <span class="mandatory">*</span>
                                        <br />
                                      <span >( Between 10-2000 characters.)</span><br />
                                      <br /></td>
                                  </tr>
                                  <tr <? if($_SESSION['MemberID']!=$_SESSION['StoreID']) echo 'style="display:none"';?> >
                                    <td  ><?=BLOG_UPLOAD_FILE1?>:</td>
                                    <td  align="left"><input name="AttachFile1" type="file" class="txt-feild"  id="AttachFile1"   onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" style="width:330px;" />
                                       
                                    </td>
                                  </tr>
                                 <tr <? if($_SESSION['MemberID']!=$_SESSION['StoreID']) echo 'style="display:none"';?> >
                                    <td  ><?=BLOG_UPLOAD_FILE2?>:</td>
                                    <td  align="left"><input name="AttachFile2" type="file" class="txt-feild"  id="AttachFile2"   onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" style="width:330px;" />
                                     
                                    </td>
                                  </tr>
                                 <tr <? if($_SESSION['MemberID']!=$_SESSION['StoreID']) echo 'style="display:none"';?> >
                                    <td  ></td>
                                    <td  align="left"><?=SUPPORTED_BLOG_FILE_TYPES?>
                                     
                                    </td>
                                  </tr>
                                 
                                  <tr>
                                    <td height="62"   align="right" valign="top" ></td>
                                    <td align="left"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="80">
                     <input  class="button" type="submit" name="Submit22" value="Submit" alt="Submit" title="Submit"/>
											  
											  </td>
                                          <td >
						 &nbsp;<input  class="button" type="reset" name="Submit2" value="<?=RESET?>" alt="<?=RESET?>" title="<?=RESET?>"/>				
                      <input type="hidden" name="CommentID" id="CommentID" value="" />
                       <input type="hidden" name="MemberID" id="MemberID" value="<? echo $_SESSION['MemberID'];?>" />
                       <input type="hidden" name="StoreID" id="StoreID" value="<? echo $_SESSION['StoreID'];?>" /> 
						<input type="hidden" name="Status" id="Status" value="1"  />
                         <input type="hidden" name="TopicID" id="TopicID" value="0" />
                                          </td>
                                        </tr>
                                    </table></td>
                                  </tr>
                              </table></td>
                            </tr>
							
			 <?  }else{ ?>
					<tr  >
                          <td height="300" align="center" class="redtxt"><?=BLOG_LOGIN_POST?></td>
                        </tr>
						
							
		 <? }
		 
		 } ?>					
							
                          </table></td>
                          </tr>  
						  
 </form>
						 	 

        </table>
  

