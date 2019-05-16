<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
       
        <td align="left"  width="100%" valign="top">
		
		<table cellspacing="0" cellpadding="0" width="100%" align="center">
          <tr>
            <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span> <?=VIDEO_LISTING?></td>
          </tr>
       
		   <tr>
        <td  align="left" valign="middle" class="heading"><?=VIDEO_LISTING?> 	</td>
      </tr>
          <tr>
            <td height="15"></td>
          </tr>
		  
	 	<tr>
            <td height="35" align="left" valign="top"  class="txt">
			
	 <? if(sizeof($arryVideoCategory)>0){?>
	 
	 <strong>Browse By Category : </strong>
		  <select name="catID" class="txtfield_contact" id="catID" style="width: 120px;" onchange="Javascript:ChangeCategory();" >
		  	  <option value="">--- All ---</option>
              <? for($i=0;$i<sizeof($arryVideoCategory);$i++) {?>
              <option value="<?=$arryVideoCategory[$i]['catID']?>" <?  if($arryVideoCategory[$i]['catID']==$_GET['catID']){echo "selected";}?>>
              <?=stripslashes($arryVideoCategory[$i]['Name'])?>
              </option>
              <? } ?>
            </select> 
	<? }?>	
				
			<input type="hidden" name="curPage" id="curPage" value="<?=$_GET['curP']?>" />	
			</td>
          </tr>
		  	  
		     <tr>
            <td height="15"></td>
          </tr>
		 
          <tr>
            <td height="32" >
			
			
			
			 <? if(sizeof($arryVideo)>0){
			
	$NumVideo = sizeof($arryVideo);
	$pagerLink=$objPager->getPager($arryVideo,$RecordsPerPage,$_GET['curP']);
 	(count($arryVideo)>0)?($arryVideo=$objPager->getPageRecords()):("");
			 
			 
			 
				foreach($arryVideo as $key=>$values){ 
				
				if($values['Image'] !='' && file_exists('videos/videos_image/'.$values['Image']) ){
				
			//imageThumb('videos/videos_image/'.$values['Image'],'videos/videos_image/thumb/'.$values['Image'],81,81);
						
			$ImagePath = 'resizeimage.php?img=videos/videos_image/'.$values['Image'].'&w=81&h=81'; 
			
			$CurrentImage = '<img src="'.$ImagePath.'" alt="Click to watch video"   border=0 >';
				}else{
					$CurrentImage = '<img src="images/no-image.gif" alt="Click to watch video"   border=0 >';
				}							

				
			?>
			
			<div class="video_listing_section">
                <div class="videolistingtxt"><span ><? echo stripslashes($values['heading']);?></span><br />
                  <? echo stripslashes($values['detail']);?> </div>
              <div class="videolistingtxt_img">		
			  
			    
			  <Div style="height:85px;" class="imgborder_success">
			 <a href="#" onclick="OpenNewPopUp('videoplayer.php?vd=<? echo $values['Video'];?>&image=videos/videos_image/<?php echo $values['Image'];?>', 330, 330, 'yes' );"  ><?=$CurrentImage?></a>
			 </Div>
			  
                    <div class="videolistingtxt_img1">					
		<a href="#" onclick="OpenNewPopUp('videoplayer.php?vd=<? echo $values['Video'];?>&image=videos/videos_image/<?php echo $values['Image'];?>', 330, 330, 'yes' );"  class="read_link">Watch Video</a>			
					
					</div>
              </div>
            </div>
                
            <? } 
			
			
		
			if($NumVideo>count($arryVideo)){
				echo '<div style="clear:both"></div>&nbsp;'.$pagerLink;
				}
			
			
			?> 
			
			
			<? }else{?> 
			<div class="blacktxt" align="center"><br><br><br><strong><?=NO_VIDEO_FOUND?></strong></div>
			<? } ?>
              </td>
          </tr>
        </table></td>
        <td align="right" valign="top">
		 <? require_once("includes/html/box/right.php"); ?>
		 
    </td>
  </tr>
    </table></td>
  </tr>
</table>
