<? if (!empty($_GET['edit555'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryContact[0]['FirstName']).' '.stripslashes($arryContact[0]['LastName'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? if($arryContact[0]['Image'] !='' && file_exists('upload/contact/'.$arryContact[0]['Image']) ){ 
	$ImageExist = 1;
?>
      <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="upload/contact/<?=$arryContact[0]['Image']?>"  title="<?=$arryContact[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img=upload/contact/'.$arryContact[0]['Image'].'" border=0 >';?></a> <br />
      </div>
      <?	}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryContact[0]['FirstName']?>" /></div>
      <? } ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div"><?=$edit?></a></span>
        <? if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('upload/contact/<?=$arryContact[0]['Image']?>','DeleteSpan')"><?=$delete?></a></span>
        <? } ?>
      </div>
    </div>
	<ul class="rightlink">	
   <li <?=($_GET['tab']=="basic")?("class='active'"):("");?>><a href="<?=$EditUrl?>basic">Edit Basic Details</a></li>

	<li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="<?=$EditUrl?>contact">Edit Address Details</a></li>
	<li <?=($_GET['tab']=="portal")?("class='active'"):("");?>><a href="<?=$EditUrl?>portal">Edit Customer Detail</a></li>
	
	<!--<li <?=($_GET['tab']=="Image")?("class='active'"):("");?>><a href="<?=$EditUrl?>Image">Edit Image</a></li>-->
	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
