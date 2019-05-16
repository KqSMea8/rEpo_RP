<?
$arryRightMenuDefault = $objConfigure->getRightMenuByDepId(0,$MainModuleID,2);
?>

<?php $LineRight =0 ;
	foreach($arryRightMenuDefault as $arryRightM){ $LineRight++; ?>    

<li <?=($_GET['tab']==$arryRightM['Link'])?("class='active'"):("");?>><a href="<?=$ViewUrl?><?=$arryRightM['Link'];?>" id="caption<?=$LineRight?>"><?=$arryRightM['Module'];?></a>

</li>

<?php } ?>
	


