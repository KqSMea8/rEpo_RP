<? 

	$arryBulletin = $objNews->getNews('',1);

?>

<div class="containt_box">
              <div class="headerbox">
			  <a href="news.php"><img src="images/webo_bulletin.jpg" alt="Supplier" width="200" height="25" border="0" /></a></div>
			  
		      <div class="headerbox_inner">
			  
<table width="185" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="160">
	
 <? 
	  	if(sizeof($arryBulletin)>0) { 
		 $Line = 0;
	  for($i=0;$i<sizeof($arryBulletin);$i++) {
			 $Line++;
			 if($Line==3) break;
			
			
	  $ImgBulletin = '';	 
	  if($arryBulletin[$i]['Image'] !='' && file_exists('upload/bulletins/'.$arryBulletin[$i]['Image']) ){ 
							//imageThumb('upload/bulletins/'.$arryBulletin[$i]['Image'],'upload/bulletins/thumb/S_'.$arryBulletin[$i]['Image'],59,46);
					
			$ImagePath = 'resizeimage.php?img=upload/bulletins/'.$arryBulletin[$i]['Image'].'&w=59&h=59'; 
			
			$ImgBulletin = '<td valign=top ><a href="news.php?nw='.$arryBulletin[$i]['newsID'].'"><img src="'.$ImagePath.'"  border=0 class="imgborder"></a></td>';
	
	}
			 
			 
			 
	  ?>
			  
			  
			  
			  
                <div class="headerbox_inner_detail2">
				
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<?=$ImgBulletin?>	
				
<td valign=top class="blacktxt"><a href="news.php?nw=<?=$arryBulletin[$i]['newsID']?>"><?=substr(stripslashes($arryBulletin[$i]['heading']),0,70);?></a></td>
  </tr>
</table>				
				
				
				</div>
				
			<? } ?>	
				
		       
	 <? } else { ?>
	  	<div class="greytxt" align="center"><br><br><br><?=NO_BULLETIN_FOUND?></div> 	  
	 <? } ?>	
	
	</td>
  </tr>
  <tr>
    <td valign="top" height="25" >
	  <? if(sizeof($arryBulletin)>0) { ?>
	  <div class="headerbox_inner_detail1">
	<a href="news.php"  class="greentxt_link"><?=VIEW_ALL?></a>
	
	</div>
	  <? } ?>
		
		  
		  </td>
  </tr>
</table>		
		
		
			  
			  
			  		
				
				
				
				
				
		
		        </div>
  </div>






