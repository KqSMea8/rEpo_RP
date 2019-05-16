<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?> </span>  News</td>
      </tr>
     	    
	    <tr>
        <td  align="left" valign="middle" class="heading"><?=WEBO_BULLETIN?></td>
      </tr>
	  
      <tr>
        <td height="15"></td>
      </tr>
   
      <tr>
       <td >
	
	<?	if(sizeof($arryNewsDetail)>0) { ?>
	
 <table width="100%" border="0" cellspacing="2" cellpadding="5">
	 <?	for($i=0;$i<sizeof($arryNewsDetail);$i++) {	
	 
	 
	 if($_GET['nw']>0){ 
	 	$NewsImageWidth = 200;
	 	$NewsImageHeight = 220;
		$NewsPrefix = '';
	 }else{
	 	$NewsImageWidth = 82;
	 	$NewsImageHeight = 81;
		$NewsPrefix = 'S_';
	 }
	 
	 
	 
			  $ImgNewsSucc = '';
			  if($arryNewsDetail[$i]['Image'] !='' && file_exists('upload/bulletins/'.$arryNewsDetail[$i]['Image']) ){ 

				//imageThumb('upload/bulletins/'.$arryNewsDetail[$i]['Image'],'upload/bulletins/thumb/'.$NewsPrefix.$arryNewsDetail[$i]['Image'],$NewsImageWidth,$NewsImageHeight);
				
				$ImagePath = 'resizeimage.php?img=upload/bulletins/'.$arryNewsDetail[$i]['Image'].'&w='.$NewsImageWidth.'&h='.$NewsImageHeight; 
				
				
			   	// $ImgNewsSucc = '<a href="#" onclick="OpenNewPopUp(\'showimage.php?img=upload/bulletins/'.$arryNewsDetail[$i][Image].'\', 150, 100, \'yes\' );"><img src="'.$ImagePath.'"  border=0 class="imgborder_success"></a>';
			   	 $ImgNewsSucc = '<a href="upload/bulletins/'.$arryNewsDetail[$i][Image].'" rel="lightbox"><img src="'.$ImagePath.'"  border=0 class="imgborder_success"></a>';
				 
				 
			  }
	 
	 
	 
	  ?>
		<tr>
			<td class="graybox"><?=stripslashes($arryNewsDetail[$i]['heading'])?></td>
		  </tr>
	  
	 <tr>
		<td width="100%" class="blacktxt">
		<?=$ImgNewsSucc?>
		
		<? 	if($arryNewsDetail[$i]['newsDate'] > 0){	echo '<div class="blacktxt"><i>'.  date("jS, F Y", strtotime($arryNewsDetail[$i]['newsDate'])) .'</i></div>'; }	?>

	
		
	<? if(!empty($_GET['nw'])){ 
			echo stripslashes($arryNewsDetail[$i]['detail']);
	   }else{
			echo substr(stripslashes(strip_tags($arryNewsDetail[$i]['detail'])),0,320);
			echo '<div class="skytxt"><a href="news.php?nw='.$arryNewsDetail[$i]['newsID'].'" class="read_link">more..</a></div>';
	   }
	?>
	
	
		</td>
	  </tr>
	
	  <? } ?>
	  
	  </table>

	 
	 <?	}else{ echo '<Div align=center  class=redtxt>'.NO_BULLETIN_FOUND.'</Div>';	}	?>
	
	</td>
	
      </tr>
	  
	<? if($_GET['nw']>0){ ?>
	   <tr>
		<td align="right" height="40" CLASS="skytxt" style="padding-right:5px;"><a href="news.php"><?=VIEW_ALL?>...</a></td>
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
