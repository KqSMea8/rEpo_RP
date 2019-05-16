<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

<div class="had" style="margin-bottom:5px;">Asset Name: <?=stripslashes($arryAsset[0]['AssetName'])?> </div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
  <tr>
    <td align="left" >


<table width="100%" border="0" cellpadding="3" cellspacing="0" >	  
	<tr>
	  <td  align="right"   class="blackbold" width="20%"> Tag ID  :</td>
	  <td   align="left" ><?=$arryAsset[0]['TagID']?>  </td>
	</tr>
	 <tr>
        <td  align="right"   class="blackbold" >Serial Number : </td>
        <td   align="left" >
	<?=(!empty($arryAsset[0]['SerialNumber']))?(stripslashes($arryAsset[0]['SerialNumber'])):(NOT_SPECIFIED)?>
  </td>
      </tr>	  
  
<tr>
        <td align="right"   class="blackbold" >Model Number :</td>
        <td  align="left"  >
	<?=(!empty($arryAsset[0]['Model']))?(stripslashes($arryAsset[0]['Model'])):(NOT_SPECIFIED)?>
	</td>
      </tr>

	<!--tr>
        <td align="right"   class="blackbold" >Category :</td>
        <td  align="left"  >
	<?=(!empty($arryAsset[0]['Category']))?(stripslashes($arryAsset[0]['Category'])):(NOT_SPECIFIED)?>
	</td>
      </tr-->

	  	<tr>
        <td align="right"   class="blackbold" >Brand :</td>
        <td  align="left"  >
	<?=(!empty($arryAsset[0]['Brand']))?(stripslashes($arryAsset[0]['Brand'])):(NOT_SPECIFIED)?>
	</td>
      </tr>

	
	  
	  <!--tr>
        <td  align="right"   class="blackbold"> Vendor : </td>
        <td   align="left" >
	<?=(!empty($arryVendor[0]['VendorName']))?(stripslashes($arryVendor[0]['VendorName'])):(NOT_SPECIFIED)?>
	</td>
      </tr-->
	 
	  <tr>
        <td align="right" class="blackbold" >Acquired : </td>
        <td  align="left" >
<? if($arryAsset[0]['Acquired']>0) echo date($Config['DateFormat'], strtotime($arryAsset[0]['Acquired'])); 
	else echo NOT_SPECIFIED;
?>		
		</td>
      </tr> 
 

</table>		
	
	
	</td>
	 <td align="right" width="20%" valign="top">
	  <? 
          $MainDir = "upload/asset/".$_SESSION['CmpID']."/";
          if($arryAsset[0]['Image'] !='' && file_exists($MainDir.$arryAsset[0]['Image']) ){ 
		$ImageExist = 1;
	?>
		<? echo '<img src="resizeimage.php?w=200&h=200&img='.$MainDir.$arryAsset[0]['Image'].'" border=0 >';?>
		<?	}else{ ?>
	  <img src="../../resizeimage.php?w=120&h=120&img=images/no.jpg" />

		<? } ?>
	 
	 </td>
  </tr>
</table>
<? } ?>
