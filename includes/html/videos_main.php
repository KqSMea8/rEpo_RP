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
		<? if(sizeof($arryVideo)>0){ 
		
		$NumVideo = sizeof($arryVideo);
	$pagerLink=$objPager->getPager($arryVideo,$RecordsPerPage,$_GET['curP']);
 	(count($arryVideo)>0)?($arryVideo=$objPager->getPageRecords()):("");
		
		?>
          <tr>
            <td  >
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
   <tr>
  	<td>&nbsp;</td>
  </tr>
  
  <tr>
    


			
	<? 	
	$Count = 0;
	foreach($arryVideo as $key=>$values){ 
	$Count++;			
				if($values['Image'] !='' && file_exists('videos/videos_image/'.$values['Image']) ){
					$ImagePath = 'resizeimage.php?img=videos/videos_image/'.$values['Image'].'&w=81&h=81'; 
					$CurrentImage = '<img src="'.$ImagePath.'" alt="Click to watch video"   border=0 >';
				}else{
					$CurrentImage = '<img src="images/no-image.gif" alt="Click to watch video"   border=0 >';
				}							
	
		$BorderStyle = 'style="border-bottom:1px solid #cccccc;"';
			
	?>
			
			<td valign="top" <?=$BorderStyle?> >
			
			
<table width="320" border="0" cellspacing="0" cellpadding="0" align="left">
   <tr>
  	<td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">
	<div class="greytxt" style="text-align:justify"><span class="bluestar"><strong><?=stripslashes($values['heading'])?></strong></span><br />
                  <? echo stripslashes($values['detail']);?> </div>	</td>
    <td valign="top" width="85px">  <Div style="height:85px;" class="imgborder_success">
			 <a href="watch-video.php?videoID=<?=$values['videoID']?>" onclick="#OpenNewPopUp('videoplayer.php?vd=<? echo $values['Video'];?>&image=videos/videos_image/<?php echo $values['Image'];?>', 330, 330, 'yes' );"  ><?=$CurrentImage?></a>
			 </Div></td>
  </tr>
   <tr>
    <td valign="top"> <div class="videolistingtxt_img1" style="float:left; text-align:left">					
		<!--<a href="#" onclick="OpenNewPopUp('videoplayer.php?vd=<? echo $values['Video'];?>&image=videos/videos_image/<?php echo $values['Image'];?>', 330, 330, 'yes' );"  class="read_link">Watch Video</a>-->			
		<a href="watch-video.php?videoID=<?=$values['videoID']?>" class="read_link">Watch Video</a>				
					</div></td>
    <td valign="top" align="center" >	
		<? if($values['Pdf'] !='' && file_exists('videos/pdf/'.$values['Pdf']) ){ ?>
		
<table border="0" cellspacing="2" cellpadding="0">
  <tr>
    <td><img src="images/pdf.jpg"></td>
    <td><a href="videos/pdf/<?=$values['Pdf']?>"  target="_blank" class="skytxt" >Download</a><br><span class="greytxt">PDF File</span></td>
  </tr>
</table>
			
					
		<? } ?>			
					</td>
  </tr>
  <tr>
  	<td colspan="2">&nbsp;</td>
  </tr>
</table>
		
			
			
			
			
			</td>
			
			
                
            
			
 <? if($Count%2==0) echo '</tr><tr>';	} ?>
			
		
  </tr>
</table>
					
			
			
		
			<? if($NumVideo>count($arryVideo)){
				echo '<div style="clear:both"></div>&nbsp;'.$pagerLink;
				}
			
			
			?> 
			
			
			
              </td>
          </tr>
	<tr>
	<td>&nbsp;</td>
	</tr>	  
	<tr>
  	<td  >
	<table  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="http://www.adobe.com/go/getflashplayer" target="_blank"><img src="images/flash.jpg" border="0" /></a></td>
    <td class="greytxt_big" align="left">&nbsp;<a href="http://www.adobe.com/go/getflashplayer" target="_blank">Download Flash Player</a> </td>
	<td width="150">&nbsp;</td>
    <td><a href="http://get.adobe.com/reader/" target="_blank"><img src="images/reader.jpg" border="0" /></a> </td>
	 <td class="greytxt_big" align="left">&nbsp;<a href="http://get.adobe.com/reader/" target="_blank">Download Adobe Acrobat Reader</a></td>
  </tr>
</table>

	
	  </td>
  </tr>
 
		  
		  <? }else{?> 
		  
		  <tr><td>
			<div class="blacktxt" align="center"><br><br><br><strong><?=NO_VIDEO_FOUND?></strong></div>
			<? } ?>
		  </td></tr>
		  
        </table></td>
        <td align="right" valign="top">
		 <? require_once("includes/html/box/right.php"); ?>
		 
    </td>
  </tr>
    </table></td>
  </tr>
</table>
