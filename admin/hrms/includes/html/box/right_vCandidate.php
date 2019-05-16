<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
 
<h4><span class="icon"></span><?=stripslashes($arryCandidate[0]['UserName'])?></h4>
<div class="right_box">



<div id="imgGal">
		
<? 

$PreviewArray['Folder'] = $Config['CandidateDir'];
$PreviewArray['FileName'] = $arryCandidate[0]['Image']; 
$PreviewArray['NoImage'] = $Prefix."images/nouser.gif";
$PreviewArray['FileTitle'] = stripslashes($arryCandidate[0]['UserName']);
$PreviewArray['Width'] = "120";
$PreviewArray['Height'] = "120";
$PreviewArray['Link'] = "1";
echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';

/*
$MainDir = $Config['FileUploadDir'].$Config['CandidateDir'];
if($arryCandidate[0]['Image'] !='' && file_exists($MainDir.$arryCandidate[0]['Image']) ){ 
*/

?>
						
		<!--	<div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="<?=$MainDir.$arryCandidate[0]['Image']?>"  title="<?=$arryCandidate[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img='.$MainDir.$arryCandidate[0]['Image'].'" border=0 >';?></a>
			<br />
			
			
			
				</div>
		<?	//}else{ ?>
		<div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=$arryCandidate[0]['UserName']?>" /></div>
		<? //} ?>
		-->
	</div>
  	
	
	
	
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
