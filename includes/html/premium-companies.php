<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
       
        <td width="574" valign="top" height="350"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="26"  class="heading" ><?=PREMIUM_COMPANIES?></td>
          </tr>
	
		  <tr>
            <td >&nbsp;
			</td>
			</tr>
		  
          <tr>
            <td  height="250" >
			
<?
			
if(sizeof($arrayCompanies)>0){ 
	
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
 <? 
  $i = 0;
  foreach($arrayCompanies as $key=>$values){
  
		
		$CompanyLink   = 'view-company.php?view='.$values['MemberID'];
		
		if($values['Image'] !='' && file_exists('upload/company/'.$values['Image']) ){  
			//imageThumb('upload/company/'.$values['Image'],'upload/company/thumb/'.$values['Image'],110,60);
			//$ImagePath = 'upload/company/thumb/'.$values['Image']; 
			$ImagePath = 'resizeimage.php?img=upload/company/'.$values['Image'].'&w=110&h=60'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0"/>';
		}else{
			$ImagePath = '<img src="images/no-image.gif" border="0" />';
		}
		
		
		if($i%4==0) echo '</tr><tr>';	
		
			echo '<td align="center" valign="middle" >
				   <table border="0" cellspacing="0" cellpadding="0" alt="'.stripslashes($values['CompanyName']).'" title="'.stripslashes($values['CompanyName']).'">
						<tr>
						<td align="center" height="60" width="110" class="ImgBorder"><a href="'.$CompanyLink.'" >'.$ImagePath.'</a></td>
						<td width=3></td>
						</tr>
						<tr>
					<td align="center" colspan=2 class="skytxt" height="24" nowrap><Div style="width:110px; height:24px; overflow: hidden">'.stripslashes($values['CompanyName']).'</Div></td>
						</tr>
				   </table>
			    </td>';
	
	 	$i++;
	 
	 } 
	 
	 ?>
	 
	   </tr>
</table>
	<? 	if($num>count($arrayCompanies)){ ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0"  align="center">
	  <tr>
		<td align="center" ><? echo $pagerLink; ?></td>
	  </tr>
	</table>
	  <? } ?>

 <?	}else{ echo '<Div align=center  class=redtxt>'.NO_RECORD_FOUND.'</Div>';	}	?>
  
			
			
			</td>
          </tr>
		  
         
          <tr>
            <td height="6"></td>
          </tr>
          <tr>
            <td align="center"></td>
          </tr>
        </table></td>
		
		 <td align="right" valign="top">
		 		 
		 <? require_once("includes/html/box/right.php"); ?>

		 
		 </td>
  </tr>
    </table></td>
  </tr>
</table>
