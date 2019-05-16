<? if (!empty($_GET['edit'])) { ?>

<div class="right-search">
  <h4><span class="icons"></span>
    <?=stripslashes($arryNews[0]['heading'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? 

	$PreviewArray['Folder'] = $Config['NewsDir'];
	$PreviewArray['FileName'] = $arryNews[0]['Image']; 
	$PreviewArray['NoImage'] = $Prefix."images/no.jpg";	 
	$PreviewArray['FileTitle'] = stripslashes($arryNews[0]['heading']);
	$PreviewArray['Width'] = "120";
	$PreviewArray['Height'] = "120";
	$PreviewArray['Link'] = "1";
	echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';

      /*$MainDir = $Config['FileUploadDir'].$Config['NewsDir'];

      if($arryNews[0]['Image'] !='' && file_exists($MainDir.$arryNews[0]['Image']) ){ 
	$ImageExist = 1;*/
?>
     <!-- <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryNews[0]['Image']?>"  title="<?=$arryNews[0]['heading']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryNews[0]['Image'].'" border=0 >';?></a> <br />
      </div>
      <?	//}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/no.jpg" title="<?=$arryNews[0]['heading']?>" /></div>
      <? // } ?>
  	-->


      </div>
    </div>
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general" || $_GET['tab']=="")?("class='active'"):("");?>><a href="<?=$EditUrl?>general">Edit <?=$ModuleName?></a></li>
    <li <?=($_GET['tab']=="document")?("class='active'"):("");?>><a href="<?=$EditUrl?>document">Documents</a></li>
	
	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
