<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
<h4><span class="icon"></span><?=stripslashes($arrySupplier[0]['CompanyName'])?></h4>
<div class="right_box">




  <div id="imgGal">

    <? $MainDir = "upload/supplier/".$_SESSION['CmpID']."/";
      if($arrySupplier[0]['Image'] !='' && file_exists($MainDir.$arrySupplier[0]['Image']) ){ 
	$ImageExist = 1;
?>
    <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arrySupplier[0]['Image']?>"  title="<?=$arrySupplier[0]['CompanyName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arrySupplier[0]['Image'].'" border=0 >';?></a> <br />
    </div>
    <?	}else{ ?>
    <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nologo.gif" title="<?=$arrySupplier[0]['CompanyName']?>" /></div>
    <? } ?>

	  
	  
    </div>
	
	
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$ViewUrl?>general">General Information</a></li>
	<li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$ViewUrl?>contacts">Contacts</a></li>
	<li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$ViewUrl?>bank">Bank Details</a></li>

	<li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$ViewUrl?>shipping">Shipping Address</a></li>
	<li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$ViewUrl?>billing">Billing Address</a></li>

	<!--
	<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$ViewUrl?>account">Account Details</a></li>
	<li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$ViewUrl?>role">Role/Permission</a></li>-->

	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
