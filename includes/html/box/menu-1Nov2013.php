<?php
/*if($TopCatID>0){
	$arrayLeftCategory = $objCategory->GetSubCategoryByParent(1,$TopCatID);
}else{
	$arrayLeftCategory = $arryTopCategory;
}*/
$arrayLeftCategory = $arryTopCategory;
?>
<div class="block left-nav">
          <h2>Catagories</h2>
          <ul id="accordion">
              
               <? 
		  
		 
		
		$SublastLine = 0;
		 $SubSubLastLine = 0;
		  for($i=0;$i<sizeof($arrayLeftCategory);$i++) {
		  
			$arrySubCategory = $objCategory->GetSubCategoryByParent(1,$arrayLeftCategory[$i]['CategoryID']);
				
			$catName = substr(stripslashes($arrayLeftCategory[$i]['Name']),0,22);			
			if(sizeof($arrySubCategory)<=0) {
				$catName = '<a href="products.php?cat='.$arrayLeftCategory[$i]['CategoryID'].$StoreSuffix.'">'.$catName.'</a>';
			}	
			
			
			  
		   ?>
            <li><span class="arrow"></span><a href="JavaScript:void(0);"><?=$catName?> <!--<span class="counting">(12)</span>--></a>
               	<? if(sizeof($arrySubCategory)>0) {	
			
				echo '<ul class="sub">';
					for($j=0;$j<sizeof($arrySubCategory);$j++) {
						$SublastLine++;
					
						$arrySubLastCategory = $objCategory->GetSubSubCategoryByParent(1,$arrySubCategory[$j]['CategoryID']);
									
						if(sizeof($arrySubLastCategory)>0) {
							$SubSubCatUrl = "Javascript:ShowHideSubLastMenu('".$SublastLine."')";
						}else{
							$SubSubCatUrl = 'products.php?cat='.$arrySubCategory[$j]['CategoryID'].$StoreSuffix;
						}
					
					
					
				
						$SubLastdisplayNone = ($_GET['cat']!=$arrySubCategory[$j]['CategoryID'])?('style="display:none"'):("");
						
						if($BackParentID>0 && $SubLastdisplayNone=='style="display:none"'){
						$SubLastdisplayNone = ($BackParentID!=$arrySubCategory[$j]['CategoryID'])?('style="display:none"'):("");

						}					
						
						echo '<li><span class="arrow"></span><a href="'.$SubSubCatUrl.'">'.stripslashes($arrySubCategory[$j]['Name']).'<!--<span class="counting">(12)</span>--></a>';
						
						echo '<ul class="sub">';
							if(sizeof($arrySubLastCategory)>0) {
								foreach($arrySubLastCategory as $key=>$values_sub_last){ 
									$SubSubLastLine++;
									$arrySubSubLastCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub_last['CategoryID']);
									
									if(sizeof($arrySubSubLastCategory)>0) {
										$SubLastCatUrl = "Javascript:ShowHideSubSubLastMenu('".$SubSubLastLine."')";
									}else{
										$SubLastCatUrl = 'products.php?cat='.$values_sub_last['CategoryID'].$StoreSuffix;
									}
									
									
									echo '<li><span class="arrow"></span><a href="'.$SubLastCatUrl.'">'.stripslashes($values_sub_last['Name']).'<!--<span class="counting">(12)</span>--></a></li>';
									
	
								     }
							        }
						  echo '</ul>';
						
						 echo '</li>';
						
						
					}
				echo '</ul>';
			?>
			
			<? } ?>
            </li>
             <? } ?>
           
          </ul>
        </div>