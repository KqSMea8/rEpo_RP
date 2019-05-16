<? if (!empty($_GET['view']) && empty($ErrorMSG) ) { ?>

<div class="right-search">
<h4><span class="icon"></span><?=stripslashes($arrySupplier[0]['VendorName'])?></h4>
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


$MainDir='';
/*
$MainDir = $Config['FileUploadDir'].$Config['VendorDir'];
      if($arrySupplier[0]['Image'] !='' && file_exists($MainDir.$arrySupplier[0]['Image']) ){ 
	$ImageExist = 1;*/
?>
  <!--  <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arrySupplier[0]['Image']?>"  title="<?=$arrySupplier[0]['VendorName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arrySupplier[0]['Image'].'" border=0 >';?></a> <br />
    </div>
    <?	//}else{ ?>
    <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nologo.gif" title="<?=$arrySupplier[0]['VendorName']?>" /></div>
    <? //} ?>
	-->
	  
	  
    </div>
	
	
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="general")?("class='active'"):("");?>><a href="<?=$ViewUrl?>general">General Information</a></li>
	<li <?=($_GET['tab']=="contacts")?("class='active'"):("");?>><a href="<?=$ViewUrl?>contacts">Contacts</a></li>
	<li <?=($_GET['tab']=="bank")?("class='active'"):("");?>><a href="<?=$ViewUrl?>bank">Bank Details</a></li>

	<li <?=($_GET['tab']=="shipping")?("class='active'"):("");?>><a href="<?=$ViewUrl?>shipping">Shipping Address</a></li>
	<li <?=($_GET['tab']=="billing")?("class='active'"):("");?>><a href="<?=$ViewUrl?>billing">Billing Address</a></li>

<? if(empty($arryCompany[0]["Department"]) || substr_count($arryCompany[0]['Department'],5)==1){
$EmailActive=$objConfig->isEmailActive(); 
if($EmailActive==1){
 ?>
	<li <?=($_GET['tab']=="Email")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Email&fromm=finance">Email</a></li>
<? }}?>

<li <?=($_GET['tab']=="linkcustomer")?("class='active'"):("");?>><a href="<?=$ViewUrl?>linkcustomer">Linked Customer</a></li>
<li <?=($_GET['tab']=="invoice")?("class='active'"):("");?>><a href="<?=$ViewUrl?>invoice">Invoices</a></li>
<!--li <?=($_GET['tab']=="payment")?("class='active'"):("");?>><a href="<?=$ViewUrl?>payment">Payment History</a></li-->	
<li <?=($_GET['tab']=="deposit")?("class='active'"):("");?>><a href="<?=$ViewUrl?>deposit">Payment History</a></li>
<li <?=($_GET['tab']=="purchase")?("class='active'"):("");?>><a href="<?=$ViewUrl?>purchase">Purchase History</a></li>
<li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$ViewUrl?>sales">Sales Commission</a></li>
<!--
	<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$ViewUrl?>account">Account Details</a></li>
	<li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$ViewUrl?>role">Role/Permission</a></li>-->

	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
