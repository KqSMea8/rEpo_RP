<?
if($TopCatID>0){
	$arrayLeftCategory = $objCategory->GetSubCategoryByParent(1,$TopCatID);
}else{
	$arrayLeftCategory = $arryTopCategory;
}

?>
<script language="javascript1.2" type="text/javascript">

function ShowHideSubLastMenu(id){
	 var totalMenus = document.getElementById("SubLastLine").value;
	
	 for(var i=1;i<=totalMenus;i++){
	 
	  if(i==id){
	   if(document.getElementById("subsublast"+id).style.display == 'inline' ){
		document.getElementById("subsublast"+id).style.display = 'none';
	   }else{
		document.getElementById("subsublast"+id).style.display = 'inline';
	   }
	  }else{
		document.getElementById("subsublast"+i).style.display = 'none';
	  }
	  
	  
	 }
 
}



function ShowHideSubSubLastMenu(id){
	 var totalMenus = document.getElementById("SubSubLastLine").value;
	
	 for(var i=1;i<=totalMenus;i++){
	 
	  if(i==id){
	   if(document.getElementById("subsubsublast"+id).style.display == 'inline' ){
		document.getElementById("subsubsublast"+id).style.display = 'none';
	   }else{
		document.getElementById("subsubsublast"+id).style.display = 'inline';
	   }
	  }else{
		document.getElementById("subsubsublast"+i).style.display = 'none';
	  }
	  
	  
	 }
 
}
</script>
<table width="197" border="0" cellspacing="0" cellpadding="0">
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
		  <tr>
            <td class="leftnavheader" ><?=$catName?></td>
          </tr>
		  
          <tr>
            <td align="left" valign="top" class="leftnav" height="10">
			<? if(sizeof($arrySubCategory)>0) {	
			
				echo '<ul>';
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
						
						echo '<li><a href="'.$SubSubCatUrl.'">'.stripslashes($arrySubCategory[$j]['Name']).'</a>';
						
						echo '<div id="subsublast'.$SublastLine.'" '.$SubLastdisplayNone.' >';
							if(sizeof($arrySubLastCategory)>0) {
								foreach($arrySubLastCategory as $key=>$values_sub_last){ 
									$SubSubLastLine++;
									$arrySubSubLastCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub_last['CategoryID']);
									
									if(sizeof($arrySubSubLastCategory)>0) {
										$SubLastCatUrl = "Javascript:ShowHideSubSubLastMenu('".$SubSubLastLine."')";
									}else{
										$SubLastCatUrl = 'products.php?cat='.$values_sub_last['CategoryID'].$StoreSuffix;
									}
									
									
									echo '<div class="pagenav_left"><a href="'.$SubLastCatUrl.'"  >'.stripslashes($values_sub_last['Name']).'</a></div>';
									
									
						$SubSubLastdisplayNone = ($_GET['cat']!=$arrySubSubLastCategory[$j]['CategoryID'])?('style="display:none"'):("");
					$SubSubLastdisplayNone = ($LevelCategory==5 && $arrayParent1[0]['ParentID']==$values_sub_last['CategoryID'])?('style="display:inline;"'):('style="display:none;"');

									
									
									echo '<div id="subsubsublast'.$SubSubLastLine.'" '.$SubSubLastdisplayNone.' >';
									foreach($arrySubSubLastCategory as $key=>$values_subsub_last){ 
										$SubSubLastCatUrl = 'products.php?cat='.$values_subsub_last['CategoryID'].$StoreSuffix;
										echo '<div class="pagenav_left_sub"><a href="'.$SubSubLastCatUrl.'" >'.stripslashes($values_subsub_last['Name']).'</a></div>';

									}
									echo '</div>';

	
								}
							}
						echo '</div>';
						
						echo '</li>';
						
						
						
						
						
						
						
						
						
						
						
					}
				echo '</ul>';
			?>
			
			<? } ?>
			</td>
          </tr>
		  
		  <? } ?>
 </table>
<input type="hidden" name="SubLastLine" id="SubLastLine" value="<?=$SublastLine?>">
<input type="hidden" name="SubSubLastLine" id="SubSubLastLine" value="<?=$SubSubLastLine?>">
