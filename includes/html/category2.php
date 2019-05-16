        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=$MenuTitle?></div>
            </td>
          </tr>
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
			
			<tr><td class="border01 skytxt">
			<?=$FlowUrls?>
			</td></tr>
			
              <tr>
                <td >
				
				
				<?	if(sizeof($arrayCategory)>0) { ?>
				
				
                    <table width="97%" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr><td align="left">
					  <select name="cat" id="cat" style="width:180px;" class="txt-feild" onchange="Javascript:ChangeCategory();">
					  <option value="">---Select Subcategory---</option>
                        <?	for($i=0;$i<sizeof($arrayCategory);$i++) {
	    
		///////////////////////////////////
		unset($arrayNumProducts);
		
		$arrayNumProducts = $objCategory->GetNumProductsSingle($arrayCategory[$i]['CategoryID'],$_SESSION['StoreID']);
		$NumProducts = $arrayNumProducts[0]['NumProducts'];
		if($NumProducts<=0) $NumProducts = 0;
		
		
		if($arrayCategory[$i]['NumSubcategory']>0){ //Multiple Level
			$arrayNumProducts2 = $objCategory->GetNumProductsMultiple($arrayCategory[$i]['CategoryID'],$_SESSION['StoreID']);
			$NumProducts  = $NumProducts + $arrayNumProducts2[0]['NumProducts'];
		}
		 
		if($NumProducts<=0) $NumProducts = 0;
		////////////////////////////////////////
		 
		 $catLink = (!empty($arrayCategory[$i]['NumSubcategory']))?("category.php"):("products.php");

if($NumProducts>0){
?>
<option value="<?=$arrayCategory[$i]['CategoryID']?>" ><?=stripslashes($arrayCategory[$i]['Name'])?>(<?=$NumProducts?>)</option>
    
	 <? }} ?>
                    </select>
					
					  </td></tr>
                    </table>
                  <?	}else{ echo '<Div align=center  class=redtxt>'.NO_CATEGORY_FOUND.'</Div>';	}	?>
                </td>
              </tr>
            </table></td>
          </tr>
         
        </table>
    </td>
  </tr>
</table>

