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
		  	<td valign="top"  >


        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<? if($TopCatID>0){ ?>

		  <tr>
            <td class="heading"><?=$MenuTitle?>            </td>
          </tr>
		   <tr>
            <td  class="pagenav"  align="left"><?=$Nav_Home?><?=$CountryNav?><?=$MainParentCategory?><?=$ParentCategory?>            </td>
          </tr>
		   
		  <? } ?>
		     <tr>
            <td  align="left" height="10"></td>
          </tr>   
			   <tr>
            <td  align="left"><?=$StoreTitle?>
            </td>
          </tr>
			  <tr>
            <td  align="left" height="20"></td>
          </tr> 
			 <tr>
            <td valign="top" align="left">

				
				
				<?	
			
				
				if(sizeof($arrayCategory)>0) { ?>
				
			
				
				
                    <table  border="0" cellspacing="0" cellpadding="0"   >
                      <tr>
          <?	for($i=0;$i<sizeof($arrayCategory);$i++) {
		  
		  	
	    	 if($i%3==0){
			    echo '</tr><tr>';	
			    $Pd_left = '';
			  }else{
			  	$Pd_left = ';padding-left:20px;';
			  }
		


		$arrySubCategory = $objCategory->GetSubCategoryByParent(1,$arrayCategory[$i]['CategoryID']);
			
		if(sizeof($arrySubCategory)>0) {
			$catLink = "category.php?cat=".$arrayCategory[$i]['CategoryID'].$StoreSuffix;
		}else{
			$catLink = 'products.php?cat='.$arrayCategory[$i]['CategoryID'].$StoreSuffix;
		}


		$ImagePath = '';
		
		
		if($arrayCategory[$i]['Image'] !='' && file_exists('upload/category/'.$arrayCategory[$i]['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/category/'.$arrayCategory[$i]['Image'].'&w=110&h=110'; 
			$ImagePath = '<a href="'.$catLink.'"><img src="'.$ImagePath.'"  border="0"   alt="'.stripslashes($arrayCategory[$i]['Name']).'" title="'.stripslashes($arrayCategory[$i]['Name']).'"/></a>';
		}else{
			$ImagePath = '<a href="'.$catLink.'"><img src="images/no.gif" border="0"  alt="'.stripslashes($arrayCategory[$i]['Name']).'" title="'.stripslashes($arrayCategory[$i]['Name']).'"></a>';
		} 

			
				
			echo '<td width="160" style="padding-bottom:25px;'.$Pd_left.'"  >
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr><td class="subcatimg">'.$ImagePath.'</td></tr>
				<tr><td class="subcat"><a href="'.$catLink.'">'.stripslashes($arrayCategory[$i]['Name']).'</a></td></tr>
				</table>	
			</td>'; 
					
						
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
