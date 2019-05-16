<? if (!empty($_GET['edit']) && empty($ErrorMSG)) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arrySupplier[0]['VendorName'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? 
$PreviewArray['Folder'] = $Config['VendorDir'];
$PreviewArray['FileName'] = $arrySupplier[0]['Image']; 
$PreviewArray['NoImage'] = $Prefix."images/nouser.gif";
$PreviewArray['FileTitle'] = stripslashes($arrySupplier[0]['VendorName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';
 
if(IsFileExist($Config['VendorDir'],$arrySupplier[0]['Image'])){
	$DeleteSpan = '<span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileRefresh(\''.$Config['VendorDir'].'\',\''.$arrySupplier[0]['Image'].'\', \'DeleteSpan\')">'.$delete.'</a></span>';
	 
	$OldImage =  $arrySupplier[0]['Image'];
 }
echo '<div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div">'.$edit.'</a></span>'.$DeleteSpan.'</div>';


$MainDir='';

/*
  if($arrySupplier[0]['Image'] !='' && file_exists($MainDir.$arrySupplier[0]['Image']) ){ 
	$ImageExist = 1;
	$OldImage = $MainDir.$arrySupplier[0]['Image'];*/
?>
     <!-- <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arrySupplier[0]['Image']?>"  title="<?=$arrySupplier[0]['VendorName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arrySupplier[0]['Image'].'" border=0 >';?></a> <br />
      </div>
      <? //}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nologo.gif" title="<?=$arrySupplier[0]['VendorName']?>" /></div>
      <? //} ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div"><?=$edit?></a></span>
        <? //if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('<?=$MainDir.$arrySupplier[0]['Image']?>','DeleteSpan')"><?=$delete?></a></span>
        <? //} ?>
      </div>
	-->

    </div>
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$EditUrl?>general">General Information</a></li>
    <li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$EditUrl?>contacts">Contacts</a></li>
	<li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$EditUrl?>bank">Bank Details</a></li>

    <li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$EditUrl?>shipping">Shipping Address</a></li>
    <li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$EditUrl?>billing">Billing Address</a></li>
   <li <?=($_GET['tab']=="LoginPermission")?("class='active'"):("");?>><a href="<?=$EditUrl?>LoginPermission">Login/Permission Detail</a></li>
 <li <?=($_GET['tab']=="merge")?("class='active'"):("");?>><a href="<?=$EditUrl?>merge">Merge Vendor</a></li>
<li <?=($_GET['tab']=="linkcustomer")?("class='active'"):("");?>><a href="<?=$EditUrl?>linkcustomer">Link Customer</a></li>
     
<li <?=($_GET['tab']=="invoice")?("class='active'"):("");?>><a href="<?=$EditUrl?>invoice">Invoices</a></li>
<!--li <?=($_GET['tab']=="payment")?("class='active'"):("");?>><a href="<?=$EditUrl?>payment">Payment History</a></li-->
<li <?=($_GET['tab']=="deposit")?("class='active'"):("");?>><a href="<?=$EditUrl?>deposit">Payment History</a></li>
<li <?=($_GET['tab']=="purchase")?("class='active'"):("");?>><a href="<?=$EditUrl?>purchase">Purchase History</a></li>
<li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$EditUrl?>sales">Sales Commission</a></li> 
<!--<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Account Details</a></li>
    <li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$EditUrl?>role">Role/Permission</a></li-->
	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} 

include("../includes/html/box/upload_image.php"); 
?>
