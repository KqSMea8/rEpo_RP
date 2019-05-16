
<div class="had">Testimonial Detail</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
  <td  valign="top" align="left">

<table width="90%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="30%" >Author Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryvTestimonial[0]['AuthorName']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Description  :</td>
        <td   align="left" >
<?php echo stripslashes($arryvTestimonial[0]['Description']); ?>
           </td>
      </tr>

  <tr>
        <td  align="right"   class="blackbold"  > Image  :</td>
        <td   align="left" >
<? /*if($arryvTestimonial[0]['Image'] !=''){ ?>
<img border="0"src="../resizeimage.php?w=75&amp;h=75&amp;img=images/<?= $arryvTestimonial[0]['Image']; ?>">
<? }else{ ?>

<img src="../resizeimage.php?w=75&amp;h=75&amp;img=images/nouser.gif" />
 <? } */?>

<?
 

	$PreviewArray['Folder'] = $Config['TestimonialDir'];
	$PreviewArray['FileName'] = $arryvTestimonial[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($arryvTestimonial[0]['AuthorName']);
	$PreviewArray['Width'] = "75";
	$PreviewArray['Height'] = "75";
	$PreviewArray['Link'] = "1";
	$PreviewArray['NoImage'] = "../images/nouser.gif";
	echo PreviewImage($PreviewArray);

 
?>
           </td>
      </tr>
            
      <tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <?  echo ($arryvTestimonial[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>
       </td>
      </tr>

</table>

</td>
</tr>

</table>
