<? if (!empty($_GET['edit'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryEmployee[0]['UserName'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? 
$MainDir = $Config['UploadPrefix']."upload/employee/".$_SESSION['CmpID']."/";
if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ 
	$ImageExist = 1;
	$OldImage = $MainDir.$arryEmployee[0]['Image'];
?>
      <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryEmployee[0]['Image']?>"  title="<?=$arryEmployee[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 id="ImageV">';?></a> <br />
      </div>
      <? }else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryEmployee[0]['UserName']?>" /></div>
      <? } ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div"><?=$edit?></a></span>
        <? if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('<?=$MainDir.$arryEmployee[0]['Image']?>','DeleteSpan')"><?=$delete?></a></span>
        <? } ?>
      </div>
    </div>
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="personal")?("class='active'"):("");?>><a href="<?=$EditUrl?>personal">Personal Details</a></li>
   
<? if($arryEmployee[0]['ExistingEmployee']=="1"){?>
 <li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="<?=$EditUrl?>contact">Contact Details</a></li>
   <? }  ?>
    <li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Login Details</a></li>
	
   
    
    <li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$EditUrl?>role">Role/Permission</a></li>

     <?if($Config['SalesCommission']==1){ 

	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],7)==1){
?>
 <li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$EditUrl?>sales">Sales Commission</a></li>

 <? }}?>


<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){ ?>
 <li <?=($_GET['tab']=="territory")?("class='active'"):("");?>><a href="<?=$EditUrl?>territory">Territory</a></li>
<? } ?>

<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],6)==1){?>
<li <?=($_GET['tab']=="vendor")?("class='active'"):("");?>><a href="<?=$EditUrl?>vendor">Restricted Vendor</a></li> 
<? } ?>

	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} 


include("../includes/html/box/upload_image.php");

?>

