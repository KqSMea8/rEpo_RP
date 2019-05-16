<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
       
        <td align="left"  width="100%" valign="top">
		
		<table cellspacing="0" cellpadding="0" width="100%" align="center">
          <tr>
            <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <a href="videos.php"><?=VIDEO_LISTING?></a> </span> <?=$PageTitle?></td>
          </tr>
       
		   <tr>
        <td  align="left" valign="middle" >
		
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="heading" width="57%"><?=$PageTitle?></td>
    <td  class="small_txt border_bottom"  style="text-align:right">
	
 <? if(sizeof($arryVideoCategory)>0){?>
	 
	 <strong>Browse By Category : </strong>
		  <select name="catID" class="txtfield_contact" id="catID" style="width: 160px;" onchange="Javascript:ChangeCategory();" >
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
</table>

		
		
		
			</td>
      </tr>
	  
	  <? if(sizeof($arryTopVideo)>0){?>
	  <tr>
            <td valign="top" height="4">

			</td>
          </tr>
	  
 
          <tr>
            <td valign="top">
			
	<div id="VideoPlayDiv" style="width:700px;height:427px"></div>

<script language="javascript1.2">
PlayVideo('<?=$_GET['videoID']?>');
</script>		
			
			
			</td>
          </tr>
		  <? } ?>
		  
		   <tr>
            <td valign="top" height="4">

			</td>
          </tr>
	 	
		  	  
		   
		<? if(sizeof($arryVideo)>0){ 
		
		$NumVideo = sizeof($arryVideo);
	$pagerLink=$objPager->getPager($arryVideo,$RecordsPerPage,$_GET['curP']);
 	(count($arryVideo)>0)?($arryVideo=$objPager->getPageRecords()):("");
		
		?>
          <tr>
            <td  valign="top" >
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
 
  

			
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
	
			
	?>
	
<tr>
	<td valign="top" height="12" >&nbsp;			
	</td>
  </tr>	
			
<tr>
    
	<td valign="top"  >			
			
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3"><span class="bluestar"><strong><?=stripslashes($values['heading'])?></strong></span></td>
    </tr>
  <tr>
    <td class="greytxt" valign="top" width="60%"><? echo stripslashes($values['detail']);?></td>
    <td width="20%" align="right" valign="top">
	
	<table border="0" cellspacing="2" cellpadding="2">
		  <tr>
			
			<td><a href="#" onclick="Javascript:PlayVideo('<?=$values['videoID']?>');" class="skytxt">Watch Video</a></td>
		  
		  <td><img src="images/Videos-icon.jpg"></td>
		  </tr>
		</table>
	
	
	</td>
    <td width="20%" align="right" valign="top">
	
		<? if($values['Pdf'] !='' && file_exists('videos/pdf/'.$values['Pdf']) ){ ?>
				
		<table border="0" cellspacing="2" cellpadding="2">
		  <tr>
			
			<td><a href="videos/pdf/<?=$values['Pdf']?>"  target="_blank" class="skytxt" >Download PDF</a></td>
		  
		  <td><img src="images/pdf.jpg"></td>
		  </tr>
		</table>
		<? } ?>	


	</td>
  </tr>
</table>
		
	</td>
  </tr>
		
	<tr>
	<td valign="top" height="12" style="border-bottom:1px solid #cccccc;" >&nbsp;			
	</td>
  </tr>
					
	<? } ?>			
	
			<? if($NumVideo>count($arryVideo)){
				echo '<div style="clear:both"></div>&nbsp;'.$pagerLink;
				}
			
			
			?> 
  
</table>
	
	
	
			
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
		  
		  
	
</table>

	</td>
        <td align="right" valign="top">
		 <? require_once("includes/html/box/right.php"); ?>
		 
    </td>
  </tr>
    </table></td>
  </tr>
</table>
