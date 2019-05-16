<? if (!empty($_GET['view'])) { ?>

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



/*$MainDir = $Config['FileUploadDir'].$Config['EmployeeDir'];
if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ 
	$ImageExist = 1;*/
?>
      <!--div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryEmployee[0]['Image']?>"  title="<?=$arryEmployee[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 id="ImageV">';?></a> <br />
      </div-->
      <? //}else{ ?>
      <!--div  id="ImageDiv" align="center"><img src="<?=$MainPrefix?>../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryEmployee[0]['UserName']?>" /></div-->
      <? //} ?>
    
    </div>
	<ul class="rightlink">	
    <li <?=($_GET['tab']=="personal")?("class='active'"):("");?>><a href="<?=$ViewUrl?>personal">Personal Details</a></li>
    
<? 
if($arryEmployee[0]['ExistingEmployee']=="1"){ ?>
<li <?=($_GET['tab']=="contact")?("class='active'"):("");?>><a href="<?=$ViewUrl?>contact">Contact Details</a></li>
<? } ?>   


    <li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$ViewUrl?>account">Login Details</a></li>
	
   
    
    <li <?=($_GET['tab']=="role")?("class='active'"):("");?>><a href="<?=$ViewUrl?>role">Role/Permission</a></li>

<?if($Config['SalesCommission']==1){ 
	if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],7)==1){
?>
 <li <?=($_GET['tab']=="sales")?("class='active'"):("");?>><a href="<?=$ViewUrl?>sales">Sales Commission</a></li>
 <? }?>

<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){ ?>
 <li <?=($_GET['tab']=="territory")?("class='active'"):("");?>><a href="<?=$ViewUrl?>territory">Territory</a></li>

<? }
} ?>

<? if(empty($arryCompany[0]['Department']) || substr_count($arryCompany[0]['Department'],5)==1){ ?>
<li <?=($_GET['tab']=="quota")?("class='active'"):("");?>><a href="<?=$ViewUrl?>chat"><?php echo 'Chat Permission';?></a></li> 
<? } ?>


	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
