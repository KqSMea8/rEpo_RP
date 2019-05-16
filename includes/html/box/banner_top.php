<?
unset($arryBanner);

$arryBanner = $objBanner->getBanners('','Top');



if(($PageID==1)){
	$BannerSuffuix = '';
	
}else{
	$BannerSuffuix = '2';
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
        <td height="12"></td>
 </tr>
 <?	

 $BannerDisplayed = '';
 if(sizeof($arryBanner)>0){	
  for($i=0;$i<sizeof($arryBanner);$i++){	


	if($arryBanner[$i]['Image'] !='' && file_exists('banner/'.$arryBanner[$i]['Image']) ){ 

	  if($i==1) break;


	$ShowBanner = 0;
	
  	if($arryBanner[$i]['BannerType'] == 'Impression'){
		if($arryBanner[$i]['TotalImpressions']>0 && ($arryBanner[$i]['TotalImpressions']-$arryBanner[$i]['Impressions'])>0){
  			$ShowBanner = 1;
		}else{
			$BannerDisabled .= $arryBanner[$i]['BannerID'].',';
		}
	}else if($arryBanner[$i]['BannerType'] == 'Duration'){
		if($arryBanner[$i]['ActDate'] <= date('Y-m-d') && $arryBanner[$i]['ExpDate'] >= date('Y-m-d')){
  			$ShowBanner = 1;
		}else{
			$BannerDisabled .= $arryBanner[$i]['BannerID'].',';
		}
	}else{
			$BannerDisabled .= $arryBanner[$i]['BannerID'].',';
	}
  
  	
	if($ShowBanner==1){



	$BannerDisplayed .= $arryBanner[$i]['BannerID'].',';
	$BannerType .= $values['BannerType'].',';

	
	//$ImagePath = $arryBanner[$i]['BannerUrl'];
		$ImagePath = 'resizeimage.php?img=banner/'.$arryBanner[$i]['Image'].'&w='.$arryBanner[$i]['DisplayWidth'].'&h='.$arryBanner[$i]['DisplayHeight'].'&bg=95c143';  
	  ?>

  <tr>
   	 <td align="center" >
<a href="link.php?bID=<?=$arryBanner[$i]['BannerID']?>" target="_blank"><img src="<?=$ImagePath?>" 
alt="<?=stripslashes($arryBanner[$i]['Title'])?>" title="<?=stripslashes($arryBanner[$i]['Title'])?>" border="0"/></a>	
	 </td>
	</td>
  </tr>

<? } 
	}
	
  }


	if($BannerDisplayed!=''){
		 $BannerDisplayed = rtrim($BannerDisplayed,",");
		 $BannerType = rtrim($BannerType,",");
		 $objPackage->FeaturedCounter($BannerDisplayed,$BannerType,'Banner');
		// $objBanner->UpdateImpressions($BannerDisplayed);
	}

	if($BannerDisabled!=''){
		 $BannerDisabled = rtrim($BannerDisabled,",");
		 $objBanner->BannerDisabled($BannerDisabled);
	}	
	

}?> 

<tr>
        <td height="7"></td>
 </tr>
</table>

			
			
			