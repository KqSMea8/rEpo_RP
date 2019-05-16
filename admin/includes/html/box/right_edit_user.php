<? if (!empty($_GET['edit'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryEmployee[0]['UserName'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? 


$PreviewArray['Folder'] = $Config['EmployeeDir'];
$PreviewArray['FileName'] = $arryEmployee[0]['Image']; 
$PreviewArray['NoImage'] = $Prefix."images/nouser.gif";
$PreviewArray['FileTitle'] = stripslashes($arryEmployee[0]['UserName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';
$ImageExist = IsFileExist($Config['EmployeeDir'],$arryEmployee[0]['Image']);
if($ImageExist == 1){
	$DeleteSpan = '<span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileRefresh(\''.$Config['EmployeeDir'].'\',\''.$arryEmployee[0]['Image'].'\', \'DeleteSpan\')">'.$delete.'</a></span>';
 }
echo '<div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div">'.$edit.'</a></span>'.$DeleteSpan.'</div>';



	/*$MainDir = $Config['FileUploadDir'].$Config['EmployeeDir'];
if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ 
	$ImageExist = 1;
	$OldImage = $MainDir.$arryEmployee[0]['Image'];*/
?>
    <!--  <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryEmployee[0]['Image']?>"  title="<?=$arryEmployee[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 id="ImageV">';?></a> <br />
      </div>
      <? //}else{ ?>
      <div  id="ImageDiv" align="center"><img src="<?=$MainPrefix?>../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryEmployee[0]['UserName']?>" /></div>
      <? //} ?>
      <div id="ImageEditDiv"><span id="EditSpan"><a class="fancybox" href="#image_uploader_div"><?=$edit?></a></span>
        <? //if($ImageExist == 1){?>
        <span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('<?=$MainDir.$arryEmployee[0]['Image']?>','DeleteSpan')"><?=$delete?></a></span>
        <? //} ?>
      </div>
	-->
    </div>
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="personal")?("class='active'"):("");?>><a href="<?=$EditUrl?>personal">Personal Details</a></li>
   
<? if($arryEmployee[0]['ExistingEmployee']=="1"){?>
 <li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="<?=$EditUrl?>contact">Contact Details</a></li>
   <? }  ?>
    <li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Login Details</a></li>
	
   
    
    <li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$EditUrl?>role">Role/Permission</a></li>

     <?
 

if($Config['SalesCommission']==1){ 

	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],7)==1){
?>
 <li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$EditUrl?>sales">Sales Commission</a></li>

 <? }?>


<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){ ?>
 <li <?=($_GET['tab']=="territory")?("class='active'"):("");?>><a href="<?=$EditUrl?>territory">Territory</a></li>

<? }
}
 ?>

<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){ ?>
<li <?=($_GET['tab']=="quota")?("class='active'"):("");?>><a href="<?=$EditUrl?>chat"><?php echo 'Chat Permission';?></a></li> 
<? } ?>

<? if($objConfig->isZoomMeetngActive()){ ?>
<li <?=($_GET['tab']=="zoom")?("class='active'"):("");?>><a href="<?=$EditUrl?>zoom"><?php echo 'Zoom Meeting Permission';?></a></li> 
<? } ?>

<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],6)==1){?>
<li <?=($_GET['tab']=="vendor")?("class='active'"):("");?>><a href="<?=$EditUrl?>vendor">Restricted Vendor</a></li> 
<? } ?>

 <?  
include($MainPrefix."includes/html/box/security_qst_remove.php"); 
include($MainPrefix."includes/html/box/security_level_user.php"); 

?>

	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} 


include($MainPrefix."includes/html/box/upload_image.php");

?>

