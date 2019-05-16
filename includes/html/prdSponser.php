<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
      <tr>
        <td height="32" align="left" valign="middle" class="pagenav"><span ><?=$Nav_Home?>  <?=$Nav_MemberPortal?>
             <a href="viewProducts.php"><?=MANAGE_PRODUCTS?></a>  </span>
              <?=MAKE_SPONSERED?></td>
      </tr>
      <tr>
        <td  align="left" valign="middle" class="heading"><?=MAKE_SPONSERED?></td>
      </tr>
      <tr>
        <td height="15"></td>
      </tr>
      <tr>
        <td height="32" >
		<?
 if($arryProduct[0]['Image'] !='' && file_exists('upload/products/'.$arryProduct[0]['Image']) ){ 
			$ImagePath = 'resizeimage.php?img=upload/products/'.$arryProduct[0]['Image'].'&w=180&h=185'; 

			$ImagePath = '<a  href="upload/products/'.$arryProduct[0]['Image'].'" rel="lightbox"><img src="'.$ImagePath.'"  border="0" class="imgborder_prd"/></a>';

			
}else{
	$ImagePath = ' <img src="images/no-image.jpg"  border="0" class="imgborder_prd"/>';
}
		  		
	
		
		
	echo '<table width="100%" border="0" cellspacing="4" cellpadding="4" class="generaltxt_inner outline">
  <tr>
    <td width="15%">'.PRODUCT_NAME.' : </td>
    <td>'.stripslashes($arryProduct[0]['Name']).'</td>
  </tr>
  <tr>
    <td width="15%">'.PRODUCT_TYPE.' : </td>
    <td>'.$arryProduct[0]['Bidding'].'</td>
  </tr> 
  <tr>
    <td valign="top">'.IMAGE.' :</td>
    <td valign="top">'.$ImagePath.'</td>
  </tr>
  
</table>';		
		
		
		
		?>
		


		
				
				</td>
      </tr>
	   <tr>
        <td height="15" class="generaltxt_inner">  </td>
      </tr>
	  
	   
	   <tr>
	     <td height="32" class="generaltxt_inner">
		 <form action="" method="post" name="form1" id="form1">
		   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="generaltxt_inner" >
             <? if(sizeof($arryDuration)>0) { ?>
             <tr>
               <td class="graybox"><input type="radio" name="PackageType" id="PackageType" value="Duration" />
                 <strong><?=SELECT_DURATION?></strong></td>
             </tr>
             <tr>
               <td valign="top">
			   
				   <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					   
					   <tr>
						 <td>
					<select name="Duration" id="Duration" style="width:320px;" class="txt-feild">
					
					 <? foreach($arryDuration as $key=>$values){ ?>
	 
						<option value="<?=$values['PackageID']?>">
						 <?=stripslashes($values['Name'])?>
							 <? echo ' <span class=greentxt>( '.$Config['Currency'].' '.$values['Price'].' for '.$values['Validity'].' days )</span>'; ?> </option>
							 
							  <? } ?> 
							  
					</select>		  
							 </td>
					   </tr>
					 
				   </table>
			   
			   </td>
             </tr>
             <? } ?>
             <? if(sizeof($arryImpression)>0) { ?>
             <tr>
               <td class="graybox"><input type="radio" name="PackageType" id="PackageType" value="Impression" />
                 &nbsp;<strong><?=SELECT_IMPRESSION?></strong></td>
             </tr>
             <tr>
               <td>
			   
			   
				 <table width="99%" border="0" cellspacing="0" cellpadding="5" class="blacktxt" align="right">
					  
					   <tr>
						 <td>
						 
						 <select name="Impression" id="Impression" style="width:320px;" class="txt-feild">
						  <? foreach($arryImpression as $key=>$values2){ ?>
						 
						 <option value="<?=$values2['PackageID']?>">
						 <?=stripslashes($values2['Name'])?>
							 <? echo ' <span class=greentxt>( '.$Config['Currency'].' '.$values2['Price'].' for '.$values2['Impression'].' Impressions )</span>'; ?> 
						</option> 
							 
							<? } ?> 
							
							
						</select>	 
							 
							 </td>
					   </tr>
					   
				   </table>		   
			   
			   
			   
			   
			   </td>
             </tr>
             <? } ?>
           </table>
		   
 <? if(sizeof($arryDuration)>0 || sizeof($arryImpression)>0) {	   
	 include("includes/html/box/payment_box.php");
 }else{  ?>
 <div class="redtxt" align="center"><?=NO_PACKAGE_FOUND?></div>
 <? } ?>
 
		 <input value="<?=stripslashes($arryBanner[0]['Title'])?>" name="Title" type="hidden"  id="Title"  />
		 <span class="blacktxt">
		 <input name="webUrl" type="hidden"  id="webUrl" 
		  value="<?=$arryBanner[0]['WebsiteUrl']?>"/>
		 </span>
		 <input name="BannerUrl" type="hidden"  id="BannerUrl"
		  value="<?=$arryBanner[0]['BannerUrl']?>"  />
		 <span class="blacktxt">
		 <input type="hidden"  name="DisplayWidth" id="DisplayWidth" value="<?=$arryBanner[0]['DisplayWidth']?>"/>
		 </span>
		 <input type="hidden"  name="DisplayHeight" id="DisplayHeight" value="<?=$arryBanner[0]['DisplayHeight']?>"/>
		 
		   <input type="hidden" name="ShowOn" id="ShowOn"  value="<?=$arryBanner[0]['ShowOn']?>" />
		   
		  <input type="hidden" name="ProductID"  value="<?=$_GET['pID']?>" /> 
		 </form>
		 
		 
		 </td>
        </tr>
	  
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
