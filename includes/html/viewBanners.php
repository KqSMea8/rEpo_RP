<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">

	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span>  <?=MY_BANNERS?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=MY_BANNERS?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
            
 	
	   <tr>
              <td align="right"   ><a href="advertise-with-us.php" class="skytxt"><?=ADVERTISE_WITH_US?></a>
                
               &nbsp;</td>
            </tr> 
  	<tr>
	  <td align="center" valign="top" class="redtxt"><? if(!empty($_SESSION['mess_banner'])) {echo $_SESSION['mess_banner']; unset($_SESSION['mess_banner']); }?></td>
	</tr>	  
	 <tr>
        <td height="15"></td>
      </tr> 
	  <tr>
        <td height="32" align="center">
		
		<table  border="0" cellpadding="0" cellspacing="0">
		
<?  if($num>0 ) { 

	$pagerLink=$objPager->getPager($arryBanner,$RecordsPerPage,$_GET['curP']);
 	(count($arryBanner)>0)?($arryBanner=$objPager->getPageRecords()):("");


?>
		
  <tr >
           
			
 <? 
   

 
   $i=0;
   
  foreach($arryBanner as $key=>$values){
   $i++;



		if($values['Image'] !='' && file_exists('banner/'.$values['Image']) ){ 
			$ImagePath = 'resizeimage.php?img=banner/'.$values['Image'].'&w=100&h=84'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';

			//$ImagePath = '<a onclick="OpenNewPopUp(\'showimage.php?img='.$values['BannerUrl'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.$ImagePath.'</a>';
			$ImagePath = '<a href="banner/'.$values['Image'].'" rel="lightbox">'.$ImagePath.'</a>';

		}else{
			$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="100" height="84"/>';
		}
		
		
		if($i>1) { 
			$border_td = 'stories_section';
		}else{
			$border_td = 'stories_section';
		}

	
		if($values['BannerType']=='Impression' && $values['TotalImpressions']>0 && $values['Impressions']>0 && $values['Impressions']==$values['TotalImpressions']){
			$BookImpression = '<a href="bookImpression.php?bnID='.$values[BannerID].'">'.BOOK_IMPRESSION.'</a>';
		}else if($values['BannerType']=='Duration' && $values['ExpDate'] < date('Y-m-d')){
			$BookImpression = '<a href="bookImpression.php?bnID='.$values[BannerID].'">'.BOOK_IMPRESSION.'</a>';
		}else{
			$BookImpression = '';
		}

		 if($values['Status'] ==1){
			  $status = '&nbsp;<span class=greentxt>Active</span>';
		 }else{
			  $status = '&nbsp;<span class=red12>InActive</span>';
		 }	
		
			echo ' <td valign="top" class="outline">
			<table width="200" border="0" cellspacing="0" cellpadding="3"  >
			
							<tr>
								<td class="blacktxt" height="25px;" align="center" >
								'.stripslashes($values['Title']).'
								</td>
						</tr>
			
			
						<tr>
						<td height="90"  valign=top align="center" >
								'.$ImagePath.'
							</td>
							
						</tr>
						
					
						<tr>
								<td align="center" height="10px;">
								
				<a href="editBanner.php?edit='.$values['BannerID'].'"><img src="images/edit.png" border="0" alt="'.EDIT.'" title="'.EDIT.'" /></a>
								<a href="editBanner.php?del_id='.$values['BannerID'].'" onclick="return confDel(\''.DELETE_BANNER_ALERT.'\')" ><img src="images/delete.png" border="0" alt="'.DELETE.'" title="'.DELETE.'"/></a>'. $status .'				
								
								
								</td>
						</tr>	
								
						<tr>
								<td align="center" height="10px;" class="skytxt">
								'.$BookImpression.'
								</td>
						</tr>
							 
				   </table></td> ';
			  
				
			
			if($i%3==0) echo '</tr><tr >';	
			
					
	 
	 } 
	 
	 ?>
	 
	   



			
			
      </tr>
	  
			<tr>
            <td height="60" align="left">&nbsp;
			<?php 
			if($num>count($arryBanner)){ echo $pagerLink; }
			?>
			
			</td>
			</tr>		
  <? } else{ ?>			

  <tr>
	<td class="redtxt" height="250" align="center">
	
No banners have been posted yet.
	</td>
	</tr>
 <? } ?>
			 
		</table>

		
		</td>
      </tr>
	  
	 
	  

    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
