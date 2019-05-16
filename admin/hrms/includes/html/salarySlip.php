<?
if(!empty($ErrorMSG)){
	echo '<div class="message" align="center">'.$ErrorMSG.'</div>';
}else{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" width="25%" valign="top">
	<?
if($arryCompany[0]['Image'] !='' && file_exists($Prefix.'upload/company/'.$arryCompany[0]['Image']) ){
	$SiteLogo = $Prefix.'resizeimage.php?w=120&h=120&bg=f1f1f1&img=upload/company/'.$arryCompany[0]['Image'];
	echo '<img src="'.$SiteLogo.'" border="0" alt="'.$Config['SiteName'].'" title="'.$Config['SiteName'].'"/>';
}
?>
	</td>
    <td align="center" valign="top">
	<div class="had_big"><?=$Config['SiteName']?></div>
	<div style="font-weight:bold">
	<?
	echo stripslashes($arryCurrentLocation[0]['Address']).", ".stripslashes($arryCurrentLocation[0]['City']).",<br>".stripslashes($arryCurrentLocation[0]['State']).", ".stripslashes($arryCurrentLocation[0]['Country'])."-".stripslashes($arryCurrentLocation[0]['ZipCode']); 
	?>
	</div>
	
	</td>
    <td align="right" width="25%" valign="top">
	
	<input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();">
	<!--
	<input type="button" class="dwn_button"  name="dwn" value="Download" onclick="Javascript:location.href='salary_pdf.php?view=<?=$_GET['view']?>';">
	-->
	</td>
  </tr>
</table>


<? include("includes/html/box/salary_slip.php"); ?>

<? } ?>
	
<script language="javascript1.2" type="text/javascript">
	$('.print_button').attr('title', $('.print_button').val());	   
</script>		
	   

