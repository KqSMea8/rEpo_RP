<? if (!empty($_GET['edit55'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryAsset[0]['AssetName'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? 
$MainDir = $Config['FileUploadDir'].$Config['AssetDir'];

      if($arryAsset[0]['Image'] !='' && file_exists($MainDir.$arryAsset[0]['Image']) ){ 
	$ImageExist = 1;
?>
      <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryAsset[0]['Image']?>"  title="<?=$arryAsset[0]['CompanyName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryAsset[0]['Image'].'" border=0 >';?></a> <br />
      </div>
      <?	}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/no.jpg" title="<?=$arryAsset[0]['CompanyName']?>" /></div>
      <? } ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div"><?=$edit?></a></span>
        <? if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('<?=$MainDir.$arryAsset[0]['Image']?>','DeleteSpan')"><?=$delete?></a></span>
        <? } ?>
      </div>
    </div>
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$EditUrl?>general">General Information</a></li>
    <li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="<?=$EditUrl?>contact">Contact Information</a></li>
	<li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$EditUrl?>bank">Bank Details</a></li>

    <li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$EditUrl?>shipping">Shipping Address</a></li>
    <li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$EditUrl?>billing">Billing Address</a></li>


     <!--<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Account Details</a></li>
    <li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$EditUrl?>role">Role/Permission</a></li-->
	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
