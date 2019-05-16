<?
unset($arryBanner);


$arryBanner = $objBanner->getBanners($ThisPage,'',$image_banner,$BannerDisplayed);

?>
		
	
	


<?	
 $BannerDisplayed = '';
 $BannerType = '';
$BannerCount = 0;
 if(sizeof($arryBanner)>0){	

  for($i=0;$i<sizeof($arryBanner);$i++){	


	if($arryBanner[$i]['Image'] !='' && file_exists('banner/'.$arryBanner[$i]['Image']) ){ 


		  if($i==$BannerLimit) break;
	
	
		
	
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
		$BannerType .= $arryBanner[$i]['BannerType'].',';
	
	
	$ImagePath = 'banner/'.$arryBanner[$i]['Image'];
	//	$ImagePath = 'resizeimage.php?img=banner/'.$arryBanner[$i]['Image'].'&w='.$arryBanner[$i]['DisplayWidth'].'&h='.$arryBanner[$i]['DisplayHeight'].'&bg=ffffff'; 

		$BannerCount++;
	  ?>

<? if($BannerCount==1){ 
	$TableShown = 1;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="bannerbox5">
<? } ?>

 
  <tr>
   	 <td align="center" style="padding-top:3px;padding-bottom:3px;">

<?	
$Extension = GetExtension($arryBanner[$i]['Image']);	
if($Extension=='swf'){	?>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="<?=$arryBanner[$i]['DisplayWidth']?>" height="<?=$arryBanner[$i]['DisplayHeight']?>">
<param name="movie" value="banner/<?=$arryBanner[$i]['Image']?>" />
<param name="quality" value="high" />
<param name="WMode" value="Transparent" />
<embed src="banner/<?=$arryBanner[$i]['Image']?>" width="<?=$arryBanner[$i]['DisplayWidth']?>" height="<?=$arryBanner[$i]['DisplayHeight']?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="Transparent"></embed>
</object>
<? }else{ ?>
	 <a href="link.php?bID=<?=$arryBanner[$i]['BannerID']?>" target="_blank"><img src="<?=$ImagePath?>" alt="<?=stripslashes($arryBanner[$i]['Title'])?>" title="<?=stripslashes($arryBanner[$i]['Title'])?>" border="0" width="<?=$arryBanner[$i]['DisplayWidth']?>" Height="<?=$arryBanner[$i]['DisplayHeight']?>"/></a>
<? } ?>	 
	 
	 
	 </td>
  </tr>


<?   } 
	}

  }


	if($BannerDisplayed!=''){
		 $BannerDisplayed = rtrim($BannerDisplayed,",");
		 $BannerType = rtrim($BannerType,",");
		
		 //$objPackage->FeaturedCounter($BannerDisplayed,$BannerType,'Banner');
		 //$objBanner->UpdateImpressions($BannerDisplayed);
	}

	if($BannerDisabled!=''){
		  $BannerDisabled = rtrim($BannerDisabled,",");
		 $objBanner->BannerDisabled($BannerDisabled);
	}	
?>	

<? }?> 



<? if($TableShown==1){ ?>

</table>
<? } ?>


			
			