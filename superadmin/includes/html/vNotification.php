
<div class="had">Notification Detail</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
  <td  valign="top" align="left">

<table width="90%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="30%" >Heading  : </td>
        <td   align="left" >
<?php echo stripslashes($arryvnotification[0]['Heading']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Date  :</td>
        <td   align="left" >
<?php echo stripslashes($arryvnotification[0]['Date']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Latest update  :</td>
        <td   align="left" >
<?php echo ($arryvnotification[0]['latest_update'] == 1)?("Yes"):(" No"); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Content  :</td>
        <td   align="left" >
<?php echo stripslashes($arryvnotification[0]['Detail']); ?>
           </td>
      </tr>
  <tr>
        <td  align="right"   class="blackbold"  > Image  :</td>
	 <!--td   align="left" >
<? if(IsFileExist($Config['NotificationDir'],$arryvnotification[0]['Image'])){ ?>
<img border="0"src="../resizeimage.php?w=75&amp;h=75&amp;img=<?= $Config['FileUploadUrl'].$Config['NotificationDir'].$arryvnotification[0]['Image']; ?>">
<? }else{ ?>

<img src="../resizeimage.php?w=75&amp;h=75&amp;img=<?=$Config['FileUploadUrl'].$Config['NotificationDir'];?>nouser.gif" />
 <? } ?>
           </td-->

			<td>

			<?  
			unset($PreviewArray);
			$PreviewArray['Folder'] = $Config['NotificationDir'];
			$PreviewArray['FileName'] = $arryvnotification[0]['Image']; 	
			$PreviewArray['FileTitle'] = stripslashes($arryvnotification[0]['Heading']);
			$PreviewArray['Width'] = "200";
			$PreviewArray['Height'] = "200";
			$PreviewArray['Link'] = "1";
			echo PreviewImage($PreviewArray);

			?>

			</td>

      </tr>
            
      <tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <?  echo ($arryvnotification[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>
       </td>
      </tr>

</table>

</td>
</tr>

</table>
