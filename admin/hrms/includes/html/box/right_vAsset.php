<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
<h4><span class="icon"></span><?=stripslashes($arryAsset[0]['AssetName'])?></h4>
<div class="right_box">


  <div id="imgGal">

 <?   
	$PreviewArray['Folder'] = $Config['AssetDir'];
	$PreviewArray['FileName'] = $arryAsset[0]['Image']; 
	$PreviewArray['NoImage'] = $Prefix."images/no.jpg";
	$PreviewArray['FileTitle'] = stripslashes($arryAsset[0]['AssetName']);
	$PreviewArray['Width'] = "120";
	$PreviewArray['Height'] = "120";
	$PreviewArray['Link'] = "1";
	echo '<div  id="ImageDiv" align="center">'.PreviewImage($PreviewArray).'</div>';
 
?>
        
	  
    </div>
	

  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
