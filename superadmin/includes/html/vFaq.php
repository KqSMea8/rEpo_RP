
<div class="had">FAQ Detail</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

<tr>
  <td  valign="top" align="left">

<table width="90%" border="0" cellpadding="5" cellspacing="0" class="borderall" style="margin:0;">
  <tr>
        <td  align="right"   class="blackbold" width="20%" >Title : </td>
        <td   align="left" >
<?php echo stripslashes($arryvFaq[0]['Title']); ?>
           </td>
      </tr>




  <tr>
        <td  align="right"   class="blackbold"  valign="top"> Image  :</td>
        <td   align="left" >
 <? 

	$PreviewArray['Folder'] = $Config['FaqDir'];
	$PreviewArray['FileName'] = $arryvFaq[0]['Image']; 
	$PreviewArray['FileTitle'] = stripslashes($arryvFaq[0]['Title']);
	$PreviewArray['Width'] = "70";
	$PreviewArray['Height'] = "70";
	$PreviewArray['Link'] = "1";
	$PreviewArray['NoImage'] = "../images/no.jpg";
	echo PreviewImage($PreviewArray);

 
?>
           </td>
      </tr>
            
      <tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <?  echo ($arryvFaq[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>
       </td>
      </tr>


	<tr>
        <td  align="right"   class="blackbold"  valign="top" >Content : </td>
        <td   align="left" >
<?php echo stripslashes($arryvFaq[0]['Content']); ?>
           </td>
      </tr>
</table>

</td>
</tr>

</table>
