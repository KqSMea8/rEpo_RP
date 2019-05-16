<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <?=SUCCESS_STORIES?></td>
      </tr>
     
	    <tr>
        <td  align="left" valign="middle" class="heading"><?=SUCCESS_STORIES?>	</td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
  	 <tr>
        <td height="15" align="right"> <a href="postStory.php" class="greentxt_link"><?=SUBMIT_AN_ARTICLE?></a></td>
      </tr>
      <tr>
       <td >
	
	<?	if(sizeof($arryStoryDetail)>0) { ?>
	
 <table width="100%" border="0" cellspacing="2" cellpadding="5">
	 <?	
	 if(!empty($_GET['st'])){ 
	 	$wdth = 130;
	 	$hth = 140;
	 }else{
	 	$wdth = 82;
	 	$hth = 81;
	 }
	 
	 
	 
	 for($i=0;$i<sizeof($arryStoryDetail);$i++) {	
	 
	 
			  $ImgStoriesSucc = '';
			  if($arryStoryDetail[$i]['Image'] !='' && file_exists('upload/company/'.$arryStoryDetail[$i]['Image']) ){ 

				//imageThumb('upload/company/'.$arryStoryDetail[$i]['Image'],'upload/company/thumb/'.$arryStoryDetail[$i]['Image'],82,81);
				
				$ImagePath = 'resizeimage.php?img=upload/company/'.$arryStoryDetail[$i]['Image'].'&w='.$wdth.'&h='.$hth; 
			
			   	 $ImgStoriesSucc = '<img src="'.$ImagePath.'"  border=0 class="imgborder_success">';
			  }
	 
	 
	 
	  ?>
	 <tr>
		<td width="100%" class="stories_section">
		
	<? if(!empty($_GET['st'])){ 
			echo '<strong>'.stripslashes($arryStoryDetail[$i]['heading']).'</strong>';
			echo $ImgStoriesSucc;
			echo '<div class="blacktxt">'.stripslashes($arryStoryDetail[$i]['detail']).'</div>';
	   }else{
			echo '<strong>'.stripslashes($arryStoryDetail[$i]['heading']).'</strong>';
			echo $ImgStoriesSucc;
			echo '<div class="blacktxt">'.substr(stripslashes(strip_tags($arryStoryDetail[$i]['detail'])),0,320).'</div>';
			echo '<a href="stories.php?st='.$arryStoryDetail[$i]['storyID'].'" class="read_link">more..</a>';
	   }
	?>
	
	

<strong>--- <?=stripslashes($arryStoryDetail[$i]['SpeakerName'])?> [<?=stripslashes($arryStoryDetail[$i]['Designation'])?>] </strong>		
	
		</td>
	  </tr>
	
	  <? } ?>
	  
	  </table>

	 
	 <?	}else{ echo '<Div align=center  class=redtxt>'.NO_STORY_FOUND.'</Div>';	}	?>
	
	</td>
	
      </tr>
	  
	<? if($_GET['st']>0){ ?>
		   <tr>
            <td align="right" height="40" CLASS="skytxt" style="padding-right:5px;"><a href="stories.php"><?=VIEW_ALL?>...</a></td>
          </tr>
		  <? } ?>  
	  
	  
     
      
    
     
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
