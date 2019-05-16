<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"  width="100%" valign="top"><table cellspacing="0" cellpadding="0" width="100%" align="center">
          <tr>
          <td  align="left" valign="middle" class="heading"><?=MANAGE_PRODUCTS?></td>
        </tr>
	   
	    <tr>
          <td  align="left" valign="middle" class="pagenav">
		<?=$Nav_Home?>  <?=$Nav_MemberPortal?> <?=MANAGE_PRODUCTS?> 
         
                </td>
        </tr>

		<?  if($_GET['CatID']>0){?>
        <tr>
          <td height="35"><strong>Category :</strong> <?=$MainParentCategory?> <?=$ParentCategory?></td>
        </tr>
		
		<? } ?>
		
        <tr>
          <td height="32" class="generaltxt_inner" align="center">
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td >
			
			
<?  if($_GET['CatID']<=0){?>	  
	<div id="light" class="white_content"  >
	
<table width="95%" align="center" cellpadding="0" cellspacing="0"  border="0">
	       <!-- <tr align="right" valign="middle" >
			<td colspan="2"> <input type="button" id="close_light" name="close_light" value=" Ok " class="alertmsg" onclick="Javascript:CloseAlert()"  /></td>
        </tr>	-->
        <tr  >
          <td  align="left" height="30" class="generaltxt" >
             
           &nbsp;<strong>Choose Category</strong></td>
        </tr>
		
	<?  if(sizeof($arryCategory)>0){ ?>
		 <tr>
		 <td valign="top" align="left" colspan="2"  class="txt">
		 
		
       
  	<?
	
	$flag=true;
	
	 $Line = 0;
	 $SubLine = 0;
	 $SublastLine = 0;
  	foreach($arryCategory as $key=>$values){
		$flag=!$flag;
			//$bgcolor=($flag)?(""):("#eeeeee");
		$Line++;
		
		$arrySubCategory = $objCategory->GetSubCategoryByParent(1,$values['CategoryID']);
			
		if(sizeof($arrySubCategory)>0) {
			$CatUrl = "Javascript:ShowHideMenu('".$Line."')";
		}else{
			$CatUrl = 'viewProducts.php?CatID='.$values['CategoryID'];
		}
			  
	echo '<div class="cat_main" style="line-height:22px;"><a href="'.$CatUrl.'" ><b>'.stripslashes($values['Name']).'</b></a></div>'; 	  

		$displayNone = ($_GET['CatID']!=$values['CategoryID'])?('style="display:none"'):("");

		echo '<div id="sub'.$Line.'" '.$displayNone.' >';
	
		if(sizeof($arrySubCategory)>0){ 
			foreach($arrySubCategory as $key=>$values_sub){ 
			
				$SubLine++;
				$arrySubSubCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub['CategoryID']);
				
				if(sizeof($arrySubSubCategory)>0) {
					$SubCatUrl = "Javascript:ShowHideSubMenu('".$SubLine."')";
				}else{
					$SubCatUrl = 'viewProducts.php?CatID='.$values_sub['CategoryID'];
				}
			
				echo '<div class="sub_cat_main" style="padding-left:20px;line-height:22px;">&raquo; <a href="'.$SubCatUrl.'" ><b>'.stripslashes($values_sub['Name']).'</b></a></div>';
				
				$SubdisplayNone = ($_GET['CatID']!=$values_sub['ParentID'])?('style="display:none"'):("");

				echo '<div id="subsub'.$SubLine.'" '.$SubdisplayNone.' >';
					if(sizeof($arrySubSubCategory)>0){ 
						foreach($arrySubSubCategory as $key=>$values_sub_sub){ 
							$SublastLine++;
							$arrySubLastCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub_sub['CategoryID']);
									
							if(sizeof($arrySubLastCategory)>0) {
								$SubSubCatUrl = "Javascript:ShowHideSubLastMenu('".$SublastLine."')";
							}else{
								$SubSubCatUrl = 'viewProducts.php?CatID='.$values_sub_sub['CategoryID'];
							}

							echo '<div class="sub_cat_main" style="padding-left:40px;line-height:22px;">&raquo; <a href="'.$SubSubCatUrl.'" ><b>'.stripslashes($values_sub_sub['Name']).'</b></a></div>';
							
							$SubLastdisplayNone = ($_GET['CatID']!=$values_sub['ParentID'])?('style="display:none"'):("");

							echo '<div id="subsublast'.$SublastLine.'" '.$SubLastdisplayNone.' >';
							if(sizeof($arrySubLastCategory)>0) {
								foreach($arrySubLastCategory as $key=>$values_sub_last){ 
									$SubSubLastLine++;
									$arrySubSubLastCategory = $objCategory->GetSubSubCategoryByParent(1,$values_sub_last['CategoryID']);
								
									if(sizeof($arrySubSubLastCategory)>0) {
										$SubLastCatUrl = "Javascript:ShowHideSubSubLastMenu('".$SubSubLastLine."')";
									}else{
										$SubLastCatUrl = 'viewProducts.php?CatID='.$values_sub_last['CategoryID'];
									}
									
									echo '<div class="sub_cat_main" style="padding-left:50px;line-height:22px;"> - <a href="'.$SubLastCatUrl.'" ><b>'.stripslashes($values_sub_last['Name']).'</b></a></div>';
									
									$SubSubLastdisplayNone = ($_GET['CatID']!=$values_sub_last['ParentID'])?('style="display:none"'):("");								
									echo '<div id="subsubsublast'.$SubSubLastLine.'" '.$SubSubLastdisplayNone.' >';
									foreach($arrySubSubLastCategory as $key=>$values_subsub_last){ 
										$SubSubLastCatUrl = 'viewProducts.php?CatID='.$values_subsub_last['CategoryID'];
										echo '<div class="sub_cat_main" style="padding-left:80px;line-height:22px;"> - <a href="'.$SubSubLastCatUrl.'" >'.stripslashes($values_subsub_last['Name']).'</a></div>';

									}
									echo '</div>';
									
									
	
								}
							}
							echo '</div>';
							
							
							
						}
					}
				echo '</div>';
				
				
			} 
			
			 
		} 



		echo '</div>';
?>


		
		
		
       	 <? } // foreach end //?>
		<input type="hidden" name="Line" id="Line" value="<?=$Line?>">
<input type="hidden" name="SubLine" id="SubLine" value="<?=$SubLine?>">
<input type="hidden" name="SubLastLine" id="SubLastLine" value="<?=$SublastLine?>">
<input type="hidden" name="SubSubLastLine" id="SubSubLastLine" value="<?=$SubSubLastLine?>">



		</td>
        </tr>
		
        <? }else{?>
        <tr align="center" >
          <td height="20" colspan="2" class="blacknormal">
            No Category Found. </td>
        </tr>
        <? } ?>
		
		 <tr>
          <td align="left"  height="20" >&nbsp;
           </td>
        </tr>
		
	
      </table>	
		
	</div> 
<? } ?>				  
			  
			  
			  </td>
            </tr>
			<?  if($_GET['CatID']>0){?>	
			
            <tr>
              <td align="right"   >
<a href="viewProducts.php" class="skytxt">Choose another category</a>			  
<br> <br>			  
<a href="editProduct.php?CatID=<?=$_GET['CatID']?>" class="skytxt"><?=ADD_NEW_PRODUCT?></a> 
                
             </td>
            </tr>
            <tr>
              <td colspan="2" align="center" valign="top" class="redtxt" height="35"><? if(!empty($_SESSION['mess_product'])) {echo $_SESSION['mess_product']; unset($_SESSION['mess_product']); }?></td>
            </tr>
            <tr>
              <td align="left"  height="280"  valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" >
                  <tr>
                    <td width="100%" align="center" valign="top" >
					<form action="" method="post" name="formList" id="formList">
                        <table width="100%" align="center" cellpadding="3" cellspacing="0" class="outline" >
                          <? if(is_array($arryProduct) && $num>0){?>
                          <tr align="left" valign="middle" bgcolor="#F5F5F5" >
                            <td width="4%" align="left"  ><?=EDIT?></td>
                            <td width="4%" align="left"  ><?=DELETE?></td>
                            <td width="29%" height="20"   ><?=PRODUCT_NAME?></td>
                            <td width="22%"  ><?=QUANTITY_AVL?></td>
                            <td width="16%"  > <!--<?=SPONSERED_ITEM?> --> Recommended                             </td>
                            <td width="13%"  ><?=FEATURED?></td>
                            <td width="12%" height="20"  ><?=STATUS?></td>
                          </tr>
                          <? 
 
  
  	foreach($arryProduct as $key=>$values){
  ?>
                          <tr align="left" valign="middle" bgcolor="#FFFFFF"  >
                            <td align="left" ><a href="editProduct.php?edit=<? echo $values['ProductID'];?>&amp;curP=<? echo $_GET['curP'];?>&CatID=<?=$_GET['CatID']?>"><img src="images/edit.png" border="0" alt="<?=EDIT?>" title="<?=EDIT?>" /></a></td>
                            <td align="left"><a href="editProduct.php?del_id=<? echo $values['ProductID'];?>&amp;curP=<? echo $_GET['curP'];?>&CatID=<?=$_GET['CatID']?>" onclick="return confDel('<?=DELETE_PRODUCT_ALERT?>')" ><img src="images/delete.png" border="0" alt="<?=DELETE?>" title="<?=DELETE?>"/></a> </td>
                            <td height="20" class="greentxt">
<? 	 
echo stripslashes($values['Name']);
  
if(!empty($values['ProductNumber'])){
	echo ' <br><span class="verdan11">('.stripslashes($values['ProductNumber']).')</span>';
}
  ?>                            </td>
                            <td class="verdan11"><?=$values['Quantity']?></td>
                            <td class="verdan11">
                              <? 
							  echo $values['Special'];
		/*echo $values['Sponser']	;		  
		 if($values['Sponser']!='Yes' && $values['Status']==1){
			  echo '<br><span class="greentxt">(<a href="prdSponser.php?pID='.$values['ProductID'].'">'.MAKE_SPONSERED.'</a>)</span>';
		 }*/
	 ?></td>
                            <td class="verdan11">
							
	<? 
		echo $values['Featured'];
		/* if($values['Featured']!='Yes' && $values['Status']==1){
			  echo '<br><span class="greentxt">(<a href="prdFeatured.php?pID='.$values['ProductID'].'">'.MAKE_FEATURED.'</a>)</span>';
		 }*/
	 ?>								</td>
                            <td height="20" class="verdan11">
	<? 
		 if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = '<span class="red12">InActive</span>';
		 }
		echo $status;
	 ?>	 </td>
                          </tr>
						  
			<tr>
				  <td colspan=7 class="borderListing"></td>
			</tr>	  
                          <? } // foreach end //?>
                          <? }else{?>
                          <tr align="center" >
                            <td height="30" colspan="7" class="redtxt"><?=NO_PRODUCT_FOUND?></td>
                          </tr>
                          <? } ?>
                        </table>
                      <input type="hidden" name="CurrentPage" id="CurrentPage" value="<? echo $_GET['curP']; ?>" />
                    </form></td>
                  </tr>
				  
				   <? 	if($num>count($arryProduct)){ ?>
                          <tr >
                            <td height="20"  >&nbsp;<? echo $pagerLink; ?> </td>
                          </tr>
                          <? } ?>
						  
              </table></td>
            </tr>
			<? }  ?>
          </table></td>
        </tr>
      
      
    </table></td>
    <td align="right" valign="top"><? require_once("includes/html/box/right.php"); ?>
    </td>
  </tr>
</table>
<div id="fade" class="black_overlay"></div>
<script language="javascript1.2" type="text/javascript">
ChooseCategoryList();
function ChooseCategoryList(){
	document.getElementById('fade').style.width = screen.width;

	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
}
</script>