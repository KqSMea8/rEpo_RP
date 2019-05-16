<? if(empty($ErrorExist)){ ?>
	<div class="had" style="margin-bottom:5px;"><?=stripslashes($arryNews[0]['heading'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
 <tr>
        <td  align="left" valign="top">
		
	<?  
        $PreviewArray['Folder'] = $Config['NewsDir'];
	$PreviewArray['FileName'] = $arryNews[0]['Image']; 	 
	$PreviewArray['FileTitle'] = stripslashes($arryNews[0]['heading']);
	$PreviewArray['Width'] = "200";
	$PreviewArray['Height'] = "200";
	 
	echo '<div style="float:right; padding:5px;">'.PreviewImage($PreviewArray).'</div>';
	?>
	 
	  

	<div style="font-weight:bold;"><? if($arryNews[0]['newsDate']>0) echo date($Config['DateFormat'], strtotime($arryNews[0]['newsDate'])); ?></div>

	<div><?=stripslashes($arryNews[0]['detail'])?></div>
		
		
		</td>
      </tr>
</table>
<? 

include("includes/html/box/news_doc.php");




}else{ 
	echo '<div class="redmsg" align="center">'.$ErrorExist.'</div>';	
} ?>
