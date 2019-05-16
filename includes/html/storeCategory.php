        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=$MenuTitle?></div>
            </td>
          </tr>
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top">
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
                  <td >&nbsp;
                  </td>
                </tr>
			<tr><td class="border01 skytxt" style="padding-left:15px;">
			<?=$FlowUrls?>
			</td></tr>
			
              <tr>
                <td >
				
				
				<?	if(sizeof($arrayCategory)>0) { ?>
                    <table width="99%" border="0" cellspacing="2" cellpadding="5" align="center">
                      <tr>
                        <?	for($i=0;$i<sizeof($arrayCategory);$i++) {
	    
		///////////////////////////////////
		unset($arrayNumProducts);
		
		$arrayNumProducts = $objCategory->GetNumProductsStoreCategory($arrayCategory[$i]['StoreCategoryID'],$_SESSION['StoreID']);
		$NumProducts = $arrayNumProducts[0]['NumProducts'];
		if($NumProducts<=0) $NumProducts = 0;
		
		////////////////////////////////////////
		 
		 $catLink = "products.php?store_cat=".$arrayCategory[$i]['StoreCategoryID']."&cat=".$_GET['cat']."&Parent=".$_GET['Parent'];

		if($NumProducts>0){

	 	 if($i%3==0) echo '</tr><tr>';
	 	 ?>
                        
                        <td  ><table border="0" cellspacing="0" cellpadding="1" class="blacktxt">
                            <tr>
                             <td><img src="<?=$TemplateFolder?>images/category_bullets.png" /></td>
							   <td width="1"></td>
							    <td><a href="<?=$catLink?>" ><u><b>
                                <?=stripslashes($arrayCategory[$i]['Name'])?>
                              </b></u></a></td>
                              <td> (<?=$NumProducts?>)</td>
                            </tr>
                        </table></td>
                        <? }} ?>
                      </tr>
                    </table>
                  <?	}else{
				  	 //echo '<br><br><Div align=center  class=redtxt>'.NO_CATEGORY_FOUND.'</Div>';
				  	}	?>
                </td>
              </tr>
			 <? if($num>1){?>
		   <tr>
            <td align="right" height="30"><a href="storePrdList.php?store_cat=<?=$_GET['store_cat']?>&cat=<?=$_GET['cat']?>&Parent=<?=$_GET['Parent']?>" class="view_link">List View&nbsp;</a>
            </td>
          </tr>
		  <? } ?>  
			 <tr>
                  <td valign="top" >
				  
				   <? include("includes/html/box/store-prd-listing.php");  ?>
                  </td>
                </tr> 
			  
            </table></td>
          </tr>
         
        </table>
 

