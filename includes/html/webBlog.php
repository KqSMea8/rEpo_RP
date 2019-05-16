      
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=$BlogTabTitle?></div>
            </td>
          </tr>
		  
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top">
			
			<form action="" method="post" name="formList" id="formList">
                      <table width="98%" align="center" cellpadding="3" cellspacing="0" class="generaltxt_inner" >
					   <tr>
            <td align="right" height="40" ><a href="webBlogPost.php" class="view_link"><?=BLOG_POST_COMMENT?></a>
            </td>
          </tr>
<? if(sizeof($arryBlog)){
	$Count = 0;
  	foreach($arryBlog as $key=>$Values){
	$Count++;
	
		$arryReplies=$objBlog->GetNumReplies($_SESSION['StoreID'],$Values['CommentID'],1); 
		$NumReplies = $arryReplies[0]['NumReplies'];
	
  ?>
                        
						
						
						<tr>
						  <td  valign="top" class="skytxt">
						   <a href="webBlogDetail.php?CommentID=<?=$Values['CommentID']?>" ><strong><?=stripslashes($Values['Comment'])?></strong></a></td>
                          </tr>
						 <tr>
						  <td valign="top" >
<? 
echo POSTED_BY.': '.$Values['PostedByName'].' on <i>'.date("jS F,  Y H:i:s", strtotime($Values['CommentDate'])).'</i>'; 

?>  </td>
                          </tr>
						  <tr >
						  <td  valign="top" >
						    <?=substr(stripslashes(strip_tags($Values['CommentDetail'])),0,350)?>....
						 	  </td>
                          </tr> 
						   <tr >
						  <td  valign="top"  >  
						  
				 <a href="webBlogDetail.php?CommentID=<?=$Values['CommentID']?>" >Read more </a> |		  
						  
	<?
	if($Values['AttachFile1'] !='' && file_exists('upload/blog/'.$Values['AttachFile1']) ){
	$AttachExtension = GetExtension($Values['AttachFile1']);
	echo '<a href="'.$Config['Url'].'dwn.php?attachments='.$Values['AttachFile1'].'" >Dowload '.$AttachExtension.' file</a> | ';
	}
	
	if($Values['AttachFile2'] !='' && file_exists('upload/blog/'.$Values['AttachFile2']) ){
	$AttachExtension = GetExtension($Values['AttachFile2']);
	echo '<a href="'.$Config['Url'].'dwn.php?attachments='.$Values['AttachFile2'].'" >Dowload '.$AttachExtension.' file</a> | ';
	}
	
	
	?>					  
						  
						  
						 
						  
						 <a href="webBlogDetail.php?CommentID=<?=$Values['CommentID']?>&resp=1"><?=$NumReplies?> response(s)</a>
						 
						  </td>
                          </tr> 
						  
						  
							  <? if(sizeof($arryBlog)!=$Count){?>
							  <tr class="cart_title"><td height="1" style="padding:0px; margin:0px;"></td></tr>
							  <? } ?>
						  
                        <? } // foreach end //?>
                        <? }else{?>
                        <tr  >
                          <td height="30" align="center" class="redtxt"><?=NO_COMMENT_POSTED?></td>
                        </tr>
                        <? } ?>
                      </table>
                    <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                  </form></td>
                </tr>
                <? 	if($num>count($arryBlog)){ ?>
                <tr >
                  <td height="20"  class="skytxt">&nbsp;<? echo $pagerLink; ?> </td>
                </tr>
                <? } ?>
            </table>
			
			</td>
          </tr>
         
        </table>
  

