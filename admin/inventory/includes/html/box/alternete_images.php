
<tr>
	<td colspan="2" align="left" ><a class="fancybox add" href="#addimage_div" style="float: right;"> Add  Images </a> </td>
	</tr>

<tr>
	<td colspan="2" align="left" class="head">Alternative Images </td>
	</tr>
	<?php if (count($MaxProductImageArr) > 0) { ?>
	<tr>
	<td colspan="2" class="list-Image">
	<ul>
	<?php
	$irts = 1;
	
	$MainDir = $Config['FileUploadDir'].$Config['ItemsSecondary'];
	foreach ($MaxProductImageArr as $image) {

	$ImageName = $image['Image'];
	$ImageId = $image['Iid'];
	$alt_text = $image['alt_text'];
	 if(IsFileExist($Config['ItemsSecondary'],$ImageName)){ 
	 

	$PreviewArray['Folder'] = $Config['ItemsSecondary'];
	$PreviewArray['FileName'] = $ImageName; 
	$PreviewArray['NoImage'] = $Prefix."images/no.jpg";
	$PreviewArray['FileTitle'] = stripslashes($alt_text);
	$PreviewArray['Width'] = "100";
	$PreviewArray['Height'] = "100";
	$PreviewArray['Link'] = "1";
	$showImage = PreviewImage($PreviewArray);
	
	$showImage.='<a href="'.$ActionUrl.'&del_image='.$ImageId.'" class="deleteProductImages" alt="' . $_GET['edit'] . "#" . $ImageId . '" onclick="return confirmDialog(this, \'Image\')"  >'.$delete.'</a>';


	}
	?>
	<li <?php if ($irts % 5 == "0") { ?> class="last"<?php } ?>><?= $showImage; ?></li>
	<? $irts = $irts + 1;
	} ?>
	</ul>
	</td>
	</tr>
	<?php } else { ?>
<tr valign="">
<td colspan="2" class="list-Image">No Images.</td>
</tr>
	

	
<?php } ?>
