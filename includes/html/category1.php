<table  border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
      <tr>
       <?	if(sizeof($arrayCategory)>0) { ?>
	    <td width="22%" align="left" valign="top"><? include("includes/html/box/left_category.php"); ?></td>
		
		<? } ?>
		<td valign="top" >
		

        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
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
		  	<td valign="top" width="540" >


        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<? if($TopCatID>0){ ?>

		  <tr>
            <td class="heading"><?=$MenuTitle?>            </td>
          </tr>
		   <tr>
            <td  class="pagenav"  align="left"><?=$Nav_Home?> <?=$MainParentCategory?> <?=$ParentCategory?>            </td>
          </tr>
		   
		  <? } ?>
		     <tr>
            <td  align="left" height="15"></td>
          </tr>   
			   <tr>
            <td  align="left"><?=$StoreTitle?>
            </td>
          </tr>
			 
			 <tr>
            <td valign="top">

				
				
				<?	
			
				
				if(sizeof($arrayCategory)>0) { ?>
				
			
				
				
                    <table width="100%" border="0" cellspacing="0" cellpadding="7"  align="center" >
                      <tr>
          <?	for($i=0;$i<sizeof($arrayCategory);$i++) {
		  
		  
	    	 if($i%2==0) echo '</tr><tr>';	
		


		$arrySubCategory = $objCategory->GetSubCategoryByParent(1,$arrayCategory[$i]['CategoryID']);
			
		if(sizeof($arrySubCategory)>0) {
			$catLink = "category.php?cat=".$arrayCategory[$i]['CategoryID'].$StoreSuffix;
		}else{
			$catLink = 'products.php?cat='.$arrayCategory[$i]['CategoryID'].$StoreSuffix;
		}


		$ImagePath = '';
		/*
		if($arrayCategory[$i]['Image'] !='' && file_exists('upload/category/'.$arrayCategory[$i]['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/category/'.$arrayCategory[$i]['Image'].'&w=120&h=120'; 
			$ImagePath = '<a href="'.$catLink.'"><img src="'.$ImagePath.'"  border="0"   alt="'.stripslashes($arrayCategory[$i]['Name']).'" title="'.stripslashes($arrayCategory[$i]['Name']).'"/></a>';
		}else{
			$ImagePath = '<a href="'.$catLink.'"><img src="images/no.gif" border="0"  alt="'.stripslashes($arrayCategory[$i]['Name']).'" title="'.stripslashes($arrayCategory[$i]['Name']).'"></a>';
		} */

		/*
		$ImagePath = '<tr><td align=center height=125>
				'.$ImagePath.'</td>
			 </tr>';
			*/  
			  
	 	 
		echo '<td width="50%"  align=center valign="top" style="border-top:1px solid #E8E6E7;">
		
			<table width="230" border="0" cellspacing="0" cellpadding="0" align="center">
			'.$ImagePath.'
			  <tr>
			   
				<td  align=center class="subcat" width="50%" height="20"><a href="'.$catLink.'">'.stripslashes($arrayCategory[$i]['Name']).'</a></td>
			  </tr>
			 
			</table>

		</td>'; 
		 
	
		  	 if($i==sizeof($arrayCategory)-1 && $i%2==0) echo '<td style="border-top:1px solid #E8E6E7;">&nbsp;</td>';
						
						
		}
						
		 ?>
                      </tr>
                    </table>
                  <?	}else{ echo '<br><br><Div align=center  class=redtxt>'.NO_CATEGORY_FOUND.'</Div>';	}	?>                </td>
              </tr>
        </table>			</td> 
			
			
<td align="right" valign="top">
	 <? include("includes/html/box/right_panel.php"); ?>		
</td>




		  </tr>
		 </table>  </td>
  </tr>
           
         
        </table>
