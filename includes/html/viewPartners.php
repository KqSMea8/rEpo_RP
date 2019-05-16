<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">

	  <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
            </span>  <?=MY_PARTNERS?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=MY_PARTNERS?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
       	<tr>
              <td align="right" class="skytxt"><a href="editPartner.php" >
                <?=ADD_NEW_PARTNER?>
              </a> &nbsp;</td>
            </tr>        
 	<tr>
        <td height="15"></td>
      </tr>
	  
  	<tr>
	  <td align="center" valign="top" class="redtxt"><? if(!empty($_SESSION['mess_partner'])) {echo $_SESSION['mess_partner']; unset($_SESSION['mess_partner']); }?></td>
	</tr>	  
	 <tr>
        <td height="15"></td>
      </tr> 
	  <tr>
        <td height="32" align="center">
		
		<table  border="0" cellpadding="0" cellspacing="0">
		
<?  if($num>0 ) { 

	//$pagerLink=$objPager->getPager($arryPartner,$RecordsPerPage,$_GET['curP']);
 	//(count($arryPartner)>0)?($arryPartner=$objPager->getPageRecords()):("");


?>
		
  <tr >
           
			
 <? 
   

 
   $i=0;
   
  foreach($arryPartner as $key=>$values){
   $i++;




		if($values['Image'] !='' && file_exists('upload/partners/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/partners/'.$values['Image'].'&w=100&h=84'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0" class="imgborder_prd" alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			$ImagePath = '<a href="upload/partners/'.$values['Image'].'" rel="lightbox" class=skytxt>'.$ImagePath.'</a>';
		}else{
			$ImagePath = '<img src="images/no-image.jpg"  border="0" class="imgborder_prd" width="100" height="84"/>';
		}
		
		
		if($i>1) { 
			$border_td = 'stories_section';
		}else{
			$border_td = 'stories_section';
		}


		if($values['Status'] ==1){
			  $status = '&nbsp;<span class=greentxt>Active</span>';
		 }else{
			  $status = '&nbsp;<span class=red12>InActive</span>';
		 }		
		
			echo ' <td valign="top" class="outline">
			<table width="200" border="0" cellspacing="0" cellpadding="3"  >
			
							<tr>
								<td class="greentxt" height="25px;" align="center" >
								<a href="'.stripslashes($values['Website']).'" target="_blank" ><b>'.stripslashes($values['heading']).'</b></a>
								</td>
						</tr>
			
			
						<tr>
						<td height="90"  valign=top align="center" >
								'.$ImagePath.'
							</td>
							
						</tr>
						
					
						<tr>
								<td align="center" height="10px;">
								
				<a href="editPartner.php?edit='.$values['partnerID'].'"><img src="images/edit.png" border="0" alt="'.EDIT.'" title="'.EDIT.'" /></a>
								<a href="editPartner.php?del_id='.$values['partnerID'].'" onclick="return confDel(\''.DELETE_PARTNER_ALERT.'\')" ><img src="images/delete.png" border="0" alt="'.DELETE.'" title="'.DELETE.'"/></a>	
								
						'.$status.'
								
								</td>
						</tr>	
								
						<tr>
								<td align="center" height="10px;">
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
			if($num>count($arryPartner)){ echo $pagerLink; }
			?>
			
			</td>
			</tr>		
  <? } else{ ?>			

  <tr>
	<td class="redtxt" height="250" align="center">
	<? echo NO_PARTNER_FOUND; ?>
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
