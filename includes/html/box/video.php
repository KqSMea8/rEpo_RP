 <?
	$arryTopVideo = $objVideo->getInitailVideo();
	
	if(sizeof($arryTopVideo)<=0){
		$arryTopVideo = $objVideo->getTopVideo(1);
	}

	$arryVideo = $objVideo->getTopVideo(10);

 ?>
 
 <? if(sizeof($arryVideo)>0){ ?>
 <div id="VideoPlayDiv" style="height:208px;margin-right:5px;width:312px;">

 </div>
 <Div class="videoBottom" >
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="68%"><select name="AvailableVideo" id="AvailableVideo" style="width:200px;" class="dropdown" onchange="Javascript:PlayVideo();">
		  <option>View Available Videos</option>
		  <?
		   	echo '<option value="'.$arryTopVideo[0]['videoID'].'" selected>'.stripslashes($arryTopVideo[0]['heading']).'</option>';
		  for($i=0;$i<sizeof($arryVideo);$i++){
		   	echo '<option value="'.$arryVideo[$i]['videoID'].'">'.stripslashes($arryVideo[$i]['heading']).'</option>';
		   }
		   ?>
 </select></td>
    <td height="27px" ><a href="videos.php" class="whitetxt_link" style="text-align:left;"><?=VIDEO_LIBRARAY?></a></td>
  </tr>
</table>			
</Div>
 <? } ?>
<script language="javascript1.2">
PlayVideo();
</script>