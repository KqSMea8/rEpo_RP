
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



/*
$MainDir = $Config['FileUploadDir'].$Config['EmployeeDir'];
      if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ 
	$ImageExist = 1;
	$OldImage = $MainDir.$arryEmployee[0]['Image'];*/
?>
     <!-- <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryEmployee[0]['Image']?>"  title="<?=$arryEmployee[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 >';?></a> <br />
      </div>
      <?	//}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryEmployee[0]['UserName']?>" /></div>
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
<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Login Details</a></li>
<? if($arryEmployee[0]['ExistingEmployee']=="1"){ //start ExistingEmployee ?>
<li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="<?=$EditUrl?>contact">Contact Details</a></li>
<li <?=($_GET['tab']=="education")?("class='active'"):("");?>><a href="<?=$EditUrl?>education">Education</a></li>
<li <?=($_GET['tab']=="id")?("class='active'"):("");?>><a href="<?=$EditUrl?>id">ID Proof</a></li>

<li <?=($_GET['tab']=="emergency")?("class='active'"):("");?>><a href="<?=$EditUrl?>emergency">Emergency Contacts</a></li>
<li <?=($_GET['tab']=="job")?("class='active'"):("");?>><a href="<?=$EditUrl?>job">Job Details</a></li>
<li <?=($_GET['tab']=="employment")?("class='active'"):("");?>><a href="<?=$EditUrl?>employment">Employment History</a></li>
<li <?=($_GET['tab']=="family")?("class='active'"):("");?>><a href="<?=$EditUrl?>family">Family Details</a></li>
<li <?=($_GET['tab']=="resume")?("class='active'"):("");?>><a href="<?=$EditUrl?>resume">Resume</a></li>
<li <?=($_GET['tab']=="supervisor")?("class='active'"):("");?>><a href="<?=$EditUrl?>supervisor">Supervisor</a></li>
<? } //end ExistingEmployee ?>
	</ul>






  </div>
</div>
<? include("../includes/html/box/upload_image.php");  ?>
