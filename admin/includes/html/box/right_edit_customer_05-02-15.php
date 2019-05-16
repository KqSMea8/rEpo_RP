<? if (!empty($_GET['edit'])) { ?>
<div class="right-search">
  <h4><span class="icon"></span>
    <?php 
/*
if($arryCustomer[0]['CustomerType'] == "Individual"){
	$titleImg = stripslashes(ucfirst($arryCustomer[0]['FirstName']))." ".stripslashes(ucfirst($arryCustomer[0]['LastName']));
} else {
	$titleImg = stripslashes(ucfirst($arryCustomer[0]['Company']));
}
*/
 
	$titleImg = stripslashes(ucfirst($arryCustomer[0]['FullName']));
	echo $titleImg;
	 ?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <?php 
$MainDir = "../upload/customer/".$_SESSION['CmpID']."/";
if($arryCustomer[0]['Image'] !='' && file_exists($MainDir.$arryCustomer[0]['Image']) ){ 
	$ImageExist = 1;
	$OldImage = $MainDir.$arryCustomer[0]['Image'];
?>
      <div  id="ImageDiv" align="center"> <a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryCustomer[0]['Image']?>"  title="<?=$titleImg?>"> <?php echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryCustomer[0]['Image'].'" border=0 >';?> </a> <br />
      </div>
      <?php	}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$titleImg?>" /></div>
      <?php } ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div">
        <?=$edit?>
        </a></span>
        <?php if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('<?=$MainDir.$arryCustomer[0]['Image']?>','DeleteSpan')">
        <?=$delete?>
        </a></span>
        <?php } ?>
      </div>
    </div>
    <ul class="rightlink">
      <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$EditUrl?>general">General Information</a></li>
      <li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$EditUrl?>contacts">Contacts</a></li>
      <li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$EditUrl?>bank">Bank Details</a></li>
      <li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$EditUrl?>billing">Billing Address</a></li>
      <li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$EditUrl?>shipping">Shipping Address</a></li>
	  <li <?=($_GET['tab']=="slaesPerson")?("class='active'"):("");?>><a href="<?=$EditUrl?>slaesPerson">Sales Person</a></li>
    </ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
}

include("../includes/html/box/upload_image.php");

?>
