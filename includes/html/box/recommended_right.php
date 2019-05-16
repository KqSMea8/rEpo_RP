<?

	$SpecialItemToShow = 3;
	$arryProductSpecial=$objProduct->SpecialProducts(1,1);

	if(sizeof($arryProductSpecial)>0){
?>
<td width="195" align="center" valign="top" >

<table width="100%" border="0" cellspacing="0" cellpadding="0">

 
  <tr>
    <td valign="top" class="leftbox" align="center">
	


<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td class="recommended">Recommended Products</td>
          </tr>
		  
  <?  
  $countFet=0;
  foreach($arryProductSpecial as $key=>$values){ 
		 
		 $countFet++;
		//if($countFet>$SpecialItemToShow) break;

	    $PrdLink   = 'productDetails.php?id='.$values['ProductID'];
		 
		  
		if($values['Image'] !='' && file_exists('upload/products/'.$values['Image']) ){  
			
			$ImagePath = 'resizeimage.php?img=upload/products/'.$values['Image'].'&w=70&h=70'; 
		
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"  alt="'.stripslashes($values['Name']).'" title="'.stripslashes($values['Name']).'"/>';
			
		}else{
			$ImagePath = '<img src="images/no.gif"  border="0"   />';
		}		  
		  
		$ImagePathLink = '<a href="'.$PrdLink.'">'.$ImagePath.'</a>';	
		  
  	?>
          <tr>
            <td height="90" align="center" valign="middle" class="graybordertop featurepadding"><?=$ImagePathLink?><br /><br />
            <?=stripslashes($values['Name'])?> </td>
          </tr>
          <? } ?>
          
		<? if(sizeof($arryProductSpecial)>$SpecialItemToShow){ ?>
		<!--
		 <tr>
            <td align="center" valign="middle" class="featurepadding">
			<a href="recommended.php" class="know_more">View More &raquo;</a>
			</td>
          </tr> -->
		<? } ?>  
        </table>
		
	</td>
  </tr>
</table>		
		
</td>		
<? }  ?>		