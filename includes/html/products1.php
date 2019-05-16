
 <table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr>
       
	    <td width="22%" align="left" valign="top">
		
		<? 
		if(sizeof($arryProduct)>0 || !empty($_GET['style']) || !empty($_GET['size']) || !empty($_GET['price'])){
			include("includes/html/box/left_refine.php");
		}else{
			include("includes/html/box/left_category.php");
		}
		
		 ?></td>
		
		
		<td valign="top">
		
				      
	   
	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
			<? 
			if($TopCatID>0 && $ModuleImagePath==''){
				$arrayModuleImage = $objCategory->GetCategoryNameByID($TopCatID);
				if($arrayModuleImage[0]['Image']!='' && file_exists("upload/category/".$arrayModuleImage[0]['Image'])){
					$ModuleImagePath = 'resizeimage.php?img=upload/category/'.$arrayModuleImage[0]['Image'].'&w=730&h=730'; 
				}
			}

			if($ModuleImagePath!=''){
			?>
          <tr>
            <td colspan="2"><img src="<?=$ModuleImagePath?>"  style="padding-bottom:24px;"/></td>
          </tr>
		  <? } ?>
		  <tr>
		  	<td valign="top" width="520" >
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
         
 <tr>
            <td class="heading"><?=$MenuTitle?>
            </td>
          </tr>
		   <tr>
            <td  class="pagenav" align="left"><?=$Nav_Home?> <?=$MainParentCategory?> <?=$ParentCategory?>
            </td>
          </tr>
		  <?  if($_GET['cat'] > 0){ ?>
		   <tr>
            <td  style="text-align:right" class="txt"><a href="Javascript:window.history.go(-1)"><strong>Back to previous page</strong></a>&nbsp;
            </td>
          </tr>
		  <? }  ?>
		   <tr>
            <td  height="30" align="left"><?=$StoreTitle?>
            </td>
          </tr>
	 	 
		 
		 
		 
		 
		
          <tr>
            <td  align="center" valign="top">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			
              
		
                <tr>
                  <td valign="top" >
				  
				  
				  <? 
				  if($numStore > 0 && empty($_GET['brand']) && empty($_GET['style']) && empty($_GET['size']) && empty($_GET['price'])) { 
				  	include("includes/html/box/store-list.php");
				  }
				  
				  
				 if($_GET['cat'] > 0){
					  if($_GET['StoreID']>0 || empty($numBrand) || !empty($_GET['style']) || !empty($_GET['size']) || !empty($_GET['price'])){
						include("includes/html/box/product-listing-quick.php");
						$ShowRecommended = 1;
					  }		
				  }else{
				  		include("includes/html/box/product-listing-quick.php");
				  }		  
				  
				    ?>
				  
				  </td>
                </tr>
            </table></td>
          </tr>
      </table>
			
			</td> 
			
<? if($_GET['cat'] > 0){ ?>			
<td align="right" valign="top">
	 <? include("includes/html/box/right_panel.php"); ?>	
	 
	 <br><br>
	 
	 <table width="195" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  valign="top" align="center"><? include("includes/html/box/banner.php"); ?> </td>
  </tr>
</table>

	 
	 	
</td>
<? } ?>



		  </tr>
		 </table>  
	   
	   
	   
	    


</td>
</tr>
</table>
