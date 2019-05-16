<?

	if(empty($FeaturedItemToShow))$FeaturedItemToShow = 3;
	$arryProductFeatured=$objProduct->FeaturedProducts(1,1);

	if(sizeof($arryProductFeatured)>0){
?>
<td width="195" align="center" valign="top" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <? if($HomePage == 1){ ?>
  <tr>
            <td><a href="#"><img src="images/social_network.jpg" alt="Social Network" border="0" /></a></td>
          </tr>
          <tr>
            <td height="15"></td>
          </tr>
 <? } ?>
 
  <tr>
    <td valign="top" class="leftbox" align="center">
	




<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="newarrivalheader">featured products</td>
          </tr>
		  
  <?  
  $countFet=0;
  foreach($arryProductFeatured as $key=>$values){ 
		 
		 $countFet++;
		if($countFet>$FeaturedItemToShow) break;

	    $PrdLink   = 'productDetails.php?id='.$values['ProductID'];
		 
		  
		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=100&h=100'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			
		}else{
			$ImagePath = '<img src="images/no.gif"  border="0"   />';
		}		  
		  
		$ImagePathLink = '<a href="'.$PrdLink.'">'.$ImagePath.'</a>';	
		  
  	?>
          <tr>
            <td height="110" align="center" valign="middle" class="grayborder featurepadding"><?=$ImagePathLink?><br /><br />
            <?=stripslashes($values['Name'])?> </td>
          </tr>
          <? } ?>
          
		<? if(sizeof($arryProductFeatured)>$FeaturedItemToShow){ ?>
		 <tr>
            <td align="center" valign="middle" height="30">
			<a href="featured.php" class="know_more">View More &raquo;</a>
			</td>
          </tr> 
		<? } ?>
		
		<tr>
            <td height="10" >
			</td>
		</tr>	
		  
        </table>
		
	</td>
  </tr>
 
  
</table>		
		
</td>		
<? }  ?>		