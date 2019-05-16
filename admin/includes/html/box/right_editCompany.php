<div class="right-search">
	<h4><span class="icon"></span><?=stripslashes($arryCompany[0]['CompanyName'])?></h4>
	<div class="right_box">
	<div id="imgGal">

		<? /*if($arryCompany[0]['Image'] !='' && file_exists('../upload/company/'.$arryCompany[0]['Image']) ){ ?>
						
			<div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="../upload/company/<?=$arryCompany[0]['Image']?>"  title="<?=stripslashes($arryCompany[0]['CompanyName'])?>"><? echo '<img src="../resizeimage.php?w=120&h=120&img=upload/company/'.$arryCompany[0]['Image'].'" border=0 >';?></a>
			<br />
			
			<!--</h1><a class="fancybox fancybox.iframe" href="includes/iframe/company_img.php">Change Photo</a>-->
			
			<a href="Javascript:void(0);" onclick="Javascript:DeleteFileReload('../upload/company/<?=$arryCompany[0]['Image']?>','ImageDiv')"><?=$delete?></a>
			
			
				</div>
		<?	}else{ ?>
		<div  id="ImageDiv" align="center"><img src="../resizeimage.php?w=120&h=120&img=images/nologo.gif" title="<?=$arryCompany[0]['CompanyName']?>" /></div>
		<? } */?>




	<? 
 

$PreviewArray['Folder'] = $Config['CmpDir'];
$PreviewArray['FileName'] = $arryCompany[0]['Image']; 
$PreviewArray['NoImage'] = $Prefix."images/nologo.gif";
$PreviewArray['FileTitle'] = stripslashes($arryCompany[0]['CompanyName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';
$ImageExist = IsFileExist($Config['CmpDir'],$arryCompany[0]['Image']);
if($ImageExist == 1){
	$DeleteSpan = '<span id="DeleteSpan"><a href="Javascript:void(0);" onclick="Javascript:RemoveFileRefresh(\''.$Config['CmpDir'].'\',\''.$arryCompany[0]['Image'].'\', \'DeleteSpan\')">'.$delete.'</a></span>';
	 
	$OldImage = $arryCompany[0]['Image'];
 }
echo '<div id="ImageEditDiv">'.$DeleteSpan.'</div>';

?>


	</div>	
	

	<ul class="rightlink">	
	<li <?=($_GET['tab']=="company")?("class='active'"):("");?>><a href="<?=$EditUrl?>company">Company Details</a></li>
	<!--<li <?=($_GET['tab']=="account")?("class='active'"):("");?>><a href="<?=$EditUrl?>account">Account Details</a></li>
	<li <?=($_GET['tab']=="currency")?("class='active'"):("");?>><a href="<?=$EditUrl?>currency">Currency Details</a></li>
	<li <?=($_GET['tab']=="DateTime")?("class='active'"):("");?>><a href="<?=$EditUrl?>DateTime">DateTime Settings</a></li>-->
	<li <?=($_GET['tab']=="global")?("class='active'"):("");?>><a href="<?=$EditUrl?>global">Global Settings</a></li>


	</ul>
	</div>
</div>
