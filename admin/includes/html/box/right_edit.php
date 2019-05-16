<?
$rename = '<img src="'.$Config['Url'].'admin/images/edit.png" border="0" class="editicon" onMouseover="ddrivetip(\'<center>Rename Caption</center>\', 100,\'\')"; onMouseout="hideddrivetip()" >';

$arryRightMenuDefault = $objConfigure->getRightMenuByDepId(0,$MainModuleID,1);

?>

    <?php $LineRight =0 ;
    foreach($arryRightMenuDefault as $arryRightM){ $LineRight++; ?>    
    	
 <li <?=($_GET['tab']==$arryRightM['Link'])?("class='active'"):("");?> onmouseover="Javascrip:ShowHideEdit(<?=$LineRight?>,1)"  onmouseout="Javascrip:ShowHideEdit(<?=$LineRight?>,0)" >

 <a class="fancybox fancysmall fancybox.iframe"  style="display:none;"  id="rename<?=$LineRight?>" href="../editRightMenu.php?ModuleID=<?=$arryRightM['ModuleID']?>&Line=<?=$LineRight?>" id="rename<?=$arryRightM['ModuleID']?>"><?=$rename?></a>

<a href="<?=$EditUrl?><?=$arryRightM['Link'];?>" id="caption<?=$LineRight?>"><?=$arryRightM['Module'];?></a>
 

 
 </li>
    
   <?php } ?>
	

<SCRIPT LANGUAGE=JAVASCRIPT>

function ShowHideEdit(Line,opt){	
	if(opt==1){		
		$("#rename"+Line).show();
	}else{
		$("#rename"+Line).hide();
	}
}
</SCRIPT>
