<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1"   method="post">
  
  <? if (!empty($_SESSION['mess_asset'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_asset'])) {echo $_SESSION['mess_asset']; unset($_SESSION['mess_asset']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
 

<tr>
	 <td colspan="2" align="left" class="head">General Information</td>
</tr>
<tr>
        <td  align="right" width="45%"   class="blackbold">Tag ID  : </td>
        <td   align="left" ><?php echo stripslashes($arryAsset[0]['TagID']); ?>
	</td>
</tr>
  <tr>
        <td  align="right"   class="blackbold" > Serial Number : </td>
        <td   align="left" >
		<?=(!empty($arryAsset[0]['SerialNumber']))?($arryAsset[0]['SerialNumber']):(NOT_SPECIFIED)?>
	
	   	</td>
      </tr>

  <!--<tr>
        <td  align="right"   class="blackbold" > RFID : </td>
        <td   align="left" >  
	<//?=(!empty($arryAsset[0]['RFID']))?($arryAsset[0]['RFID']):(NOT_SPECIFIED)?>
		
		
		</td>
      </tr>-->

<tr>
	     <td  align="right"  class="blackbold">Asset Name : </td>
	     <td   align="left" >
		<?=stripslashes($arryAsset[0]['AssetName'])?>		 </td>
	     </tr>



  <tr>
        <td align="right"   class="blackbold" >Model  :</td>
        <td  align="left"  >
	<?=(!empty($arryAsset[0]['Model']))?($arryAsset[0]['Model']):(NOT_SPECIFIED)?>

		</td>
      </tr>

	<!--tr>
			<td  align="right"   class="blackbold" > Category  : </td>
			<td   align="left" >
	<?=(!empty($arryAsset[0]['Category']))?(stripslashes($arryAsset[0]['Category'])):(NOT_SPECIFIED)?>

		</td>
	</tr-->

	<tr>
			<td  align="right"   class="blackbold" > Brand : </td>
			<td   align="left" >
	<?=(!empty($arryAsset[0]['Brand']))?(stripslashes($arryAsset[0]['Brand'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

<tr>
        <td  align="right"   class="blackbold" > Storage Location : </td>
        <td   align="left" >
<?php echo stripslashes($arryAsset[0]['Location']); ?>           </td>
      </tr>

        <tr>
          <td align="right"   class="blackbold" valign="top" >Description  :</td>
          <td  align="left" >
	<?=(!empty($arryAsset[0]['Description']))?(nl2br(stripslashes($arryAsset[0]['Description']))):(NOT_SPECIFIED)?>
		   
		   
		   </td>
        </tr>	

<tr>
        <td align="right"   class="blackbold" >Acquired :</td>
        <td  align="left"  >
 <?=($arryAsset[0]['Acquired']>0)?(date($Config['DateFormat'], strtotime($arryAsset[0]['Acquired']))):(NOT_SPECIFIED)?>

				</td>
      </tr>

	<? 
	$arryExisting = $arryAsset;
	#include("includes/html/box/custom_field_view.php");
	?>

	  <!--<tr>
        <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left"  >
          <?/*  
			if($arryAsset[0] > 0){
			  $status = 'In Use';
			  $class = 'green';
			}else{
			  $status = 'In Stock';
			  $class = 'red';
			}*/
				  
			//echo '<span class="'.$class.'" >'.$arryAsset[0]['Status'].'</span>';

		 ?>
       </td>
      </tr>-->



  <tr>
	 <td colspan="2" align="left" class="head">Assigned Information</td>
</tr>
   <tr>
        <td  align="right"   class="blackbold" > Assigned To  :</td>
        <td   align="left" >
		<?php if(!empty($arryAsset[0]['AssignID'])){?>
		<a class="fancybox fancybox.iframe" href="empInfo.php?view=<?=$arryAsset[0]['AssignID']?>" ><?=$arryAsset[0]["UserName"]?>[<?=$arryAsset[0]['JobTitle']?>]</a>
		<?php } else {?>
		<span class="red"><?=NOT_ASSIGNED?></span>
		<?php }?>
        <!--<input type="button" value="Assigned History" class="button">-->

      </td>
      </tr>
	  

  <!--tr>
	 <td colspan="2" align="left" class="head">Vendor Information</td>
</tr>
	  <tr>
        <td align="right"   class="blackbold" >Vendor  : </td>
        <td  align="left">
		
	<?=(!empty($arryAsset[0]['VendorName']))?(stripslashes($arryAsset[0]['VendorName'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 


	    

	    <tr>
        <td align="right"   class="blackbold" >Warranty Starts  : </td>
        <td  align="left" >
 <?=($arryAsset[0]['WrStart']>0)?(date($Config['DateFormat'], strtotime($arryAsset[0]['WrStart']))):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 

 <tr>
        <td align="right"   class="blackbold" >Warranty Ends :</td>
        <td align="left">
 <?=($arryAsset[0]['WrEnd']>0)?(date($Config['DateFormat'], strtotime($arryAsset[0]['WrEnd']))):(NOT_SPECIFIED)?>
		</td>
      </tr-->






 
 




	
	
</table>	
  




	
	  
	
	</td>
   </tr>

   

   </form>
</table>
</div>

