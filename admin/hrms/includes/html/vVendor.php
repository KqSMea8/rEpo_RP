
<a class="back" href="<?=$RedirectURL?>">Back</a> 

<?
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

		<a href="<?=$EditUrl?>" class="edit">Edit</a> 
		
		<div class="had"><?=$MainModuleName?>   <span> &raquo;
			Vendor Detail
				</span>
		</div>

	
<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1"   method="post">
  
  <? if (!empty($_SESSION['mess_vendor'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_vendor'])) {echo $_SESSION['mess_vendor']; unset($_SESSION['mess_vendor']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
        <td  align="right"   class="blackbold"> Vendor Code  : </td>
        <td   align="left" ><?php echo stripslashes($arryVendor[0]['VendorCode']); ?>
	</td>
</tr>
<tr>
	     <td  align="right"  class="blackbold" width="45%">Vendor Name : </td>
	     <td   align="left" >
		<?=stripslashes($arryVendor[0]['VendorName'])?>		 </td>
	     </tr>


	<? 
	#$arryExisting = $arryVendor;
	#include("includes/html/box/custom_field_view.php");
	?>

	  

   
      <tr>
        <td  align="right"   class="blackbold" > Email : </td>
        <td   align="left" ><?php echo $arryVendor[0]['Email']; ?>		</td>
      </tr>
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Address  :</td>
          <td  align="left" >
	<?=(!empty($arryVendor[0]['Address']))?(nl2br(stripslashes($arryVendor[0]['Address']))):(NOT_SPECIFIED)?>
		   
		   
		   </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
	<?=(!empty($arryVendor[0]['Country']))?(stripslashes($arryVendor[0]['Country'])):(NOT_SPECIFIED)?>


		        </td>
      </tr>
     <tr>
	  <td  align="right" class="blackbold"> State  :</td>
	  <td  align="left" class="blacknormal">
	<?=(!empty($arryVendor[0]['State']))?(stripslashes($arryVendor[0]['State'])):(NOT_SPECIFIED)?>
	  </td>
	</tr>
	    
     
	   <tr>
        <td  align="right"   class="blackbold">City   :</td>
        <td  align="left"  >
	<?=(!empty($arryVendor[0]['City']))?(stripslashes($arryVendor[0]['City'])):(NOT_SPECIFIED)?>

		</td>
      </tr> 
	    
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	<?=(!empty($arryVendor[0]['ZipCode']))?($arryVendor[0]['ZipCode']):(NOT_SPECIFIED)?>

				</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=(!empty($arryVendor[0]['Mobile']))?($arryVendor[0]['Mobile']):(NOT_SPECIFIED)?>

		</td>
      </tr>
		<? if(!empty($arryVendor[0]['Landline'])){ ?>
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" > <?=stripslashes($arryVendor[0]['Landline'])?>	
		
			</td>
      </tr>
		<? } ?>
	    <tr>
        <td align="right"   class="blackbold" >Fax  : </td>
        <td  align="left" >
	<?=(!empty($arryVendor[0]['Fax']))?(stripslashes($arryVendor[0]['Fax'])):(NOT_SPECIFIED)?>
		
		</td>
      </tr> 

 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left">
	<?=(!empty($arryVendor[0]['Website']))?(stripslashes($arryVendor[0]['Website'])):(NOT_SPECIFIED)?>
		</td>
      </tr>



<tr>
        <td  align="right"   class="blackbold" >Status  : </td>
        <td   align="left"  >
          <?  echo ($arryVendor[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>
       </td>
      </tr>







 



	
	
</table>	
  




	
	  
	
	</td>
   </tr>

   

   </form>
</table>
</div>

		 





		  
<? } ?>

