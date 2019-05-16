<?php
function getTopMenu($arrayLeftCategory, $start, $end, $objCategory){
	$counter=0;
	$bg=0;
	$j=0;
	$k=1;
	
	for ($i = $start; $i < $end; $i++) {
		$html .='<li>
        <a href="products.php?cat='.$arrayLeftCategory[$i]['CategoryID'].'">'.$arrayLeftCategory[$i]['Name'].'</a>';

		$arrySecondSubCategorys = $objCategory->GetSubCategoryByParent(1, $arrayLeftCategory[$i]['CategoryID']);
		if(count($arrySecondSubCategorys)>0){
			$html .='<div class="crmdrop-submenu submenunew ">
                    <div class="crmdrop-submenu-col-1 crmdrop-submenu-col-dropmenu-two">
                    <ul class="crmdrop-submenu-col-1-list">';

			foreach($arrySecondSubCategorys as $key=>$values){
				$html .='<li><a href="products.php?cat='.$arrySecondSubCategorys[$key]['CategoryID'].'"><span>'.$values['Name'].'<span></a></li>';
			}
			$html .=' </ul>
                    </div>
                  </div>';
		}
		$html .='</li>';
	}
	
	return $html;
}

function getMenu($arrayLeftCategory, $start, $end, $objCategory) {
	$counter=0;
	$bg=0;
	$j=0;
	$k=1;
	for ($i = $start; $i < $end; $i++) {
		if($bg%2==0){
			$bg1= '#fbfbfb';
		}else {
			$bg1= '#ffffff';
		}
		$arrySecondSubCategory = $objCategory->GetSubCategoryByParent(1, $arrayLeftCategory[$i]['CategoryID']);
		$catName = stripslashes($arrayLeftCategory[$i]['Name']);

			
		if(($j%3==0) || ($j==0)){
			$html .='<div class="crmdrop-submenu-col-'.$k.'">';
		}
			
		$html .='<ul class="crmdrop-submenu-col-1-list">';
		foreach($arrySecondSubCategory as $key=>$val){
			if($key==0){
				$html .='<li class="submenu-col-1-list-headmenu"><a href="products.php?cat='.$arrayLeftCategory[$i]['CategoryID'].'"> '.$catName.'&raquo</a></li>';
					
			}
			$html .='<li><a href="products.php?cat='.$arrySecondSubCategory[$key]['CategoryID'].'"><span class="ecom-linkup">'.$val['Name'].'<span></a></li>';
		}
			
		if(count($arrySecondSubCategory)==0){
			$html .='<li class="submenu-col-1-list-headmenu"><a href="products.php?cat='.$arrySecondSubCategory[$key]['CategoryID'].'">'.$catName.'&raquo</a></li>';
		}
		$html .='</ul>';
			
		$j++;
		if($j%3==0){
			$html .='</div>';
			$k++;
		}
	}
	
	return $html;
}
?>