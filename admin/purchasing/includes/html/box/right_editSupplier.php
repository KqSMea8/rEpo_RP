<? if (!empty($_GET['edit'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arrySupplier[0]['CompanyName'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? 
      $MainDir = "upload/supplier/".$_SESSION['CmpID']."/";
      if($arrySupplier[0]['Image'] !='' && file_exists($MainDir.$arrySupplier[0]['Image']) ){ 
	$ImageExist = 1;
?>
      <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arrySupplier[0]['Image']?>"  title="<?=$arrySupplier[0]['CompanyName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arrySupplier[0]['Image'].'" border=0 >';?></a> <br />
      </div>
      <?	}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nologo.gif" title="<?=$arrySupplier[0]['CompanyName']?>" /></div>
      <? } ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div"><?=$edit?></a></span>
        <? if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('<?=$MainDir.$arrySupplier[0]['Image']?>','DeleteSpan')"><?=$delete?></a></span>
        <? } ?>
      </div>
    </div>
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$EditUrl?>general">General Information</a></li>
    <li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$EditUrl?>contacts">Contacts</a></li>
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
