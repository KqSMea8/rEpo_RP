<? if(sizeof($arrayMainCategory)>0) {  ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="panel_top"><div class="heading">
      <?=PRODUCT_CATEGORIES?>
    </div></td>
  </tr>
  <tr>
    <td align="left"  class="panel_middle_grey"><?	if(sizeof($arrayMainCategory)>0) { 
	
		echo '<ul>';
		
		 for($i=0;$i<sizeof($arrayMainCategory);$i++) {
					if($i==20) break;


				if((sizeof($arrayMainCategory)-1)==$i){
					$BoxStyle = 'style="border-bottom:0px dashed #ffffff;height:auto"';
				}else{
					$BoxStyle = 'style="height:auto"';
				}


				$catLink = (!empty($arrayMainCategory[$i]['NumSubcategory']))?("category.php"):("products.php");
				
				$catLink = (!empty($arrayMainCategory[$i]['StoreCategoryID']))?("storeCategory.php"):($catLink);


				echo '<li><a href="'.$catLink.'?cat='.$arrayMainCategory[$i]['CategoryID'].'" class="category_link" '.$BoxStyle.'>'.stripslashes($arrayMainCategory[$i]['Name']).'</a></li>';
			}
			
		echo '</ul>';
		
		if(sizeof($arrayMainCategory)>20) { 
			echo '<div height="18" align="right" style="padding-right:5px;"><a href="category.php">'.MORE.'...</a></div>';
		}
	
	}else{
		echo '<div align="center" class="redtxt">'.NO_CATEGORY_FOUND.'</div>';
	}
	
	?>
    </td>
  </tr>
  <tr>
    <td class="panel_bottom"></td>
  </tr>
</table>
<br style="line-height:8px;">
<? } ?>