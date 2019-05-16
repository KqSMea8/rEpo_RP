<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td height="20" class="online_searchbg" colspan="2"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
	
	 <form name="ProductSearchFormMain" action=""  method="post" onSubmit="return ProductSearch(this);" enctype="multipart/form-data">
      <tr>
        <td width="7%" align="right" valign="middle" class="bluetxt_bold10" >SEARCH:&nbsp;</td>
        <td width="29%" height="47" align="left" valign="middle">
          <input name="ProductKeyword"  id="ProductKeyword" type="text"  class="txtfield" size="40"  maxlength="50" value="<?=$_GET['productkeyword']?>"/>
       </td>
        <td width="7%" align="left" valign="middle" class="bluetxt_bold10">BROWSE:</td>
        <td width="18%" align="left" valign="middle">
		
<? 
if(sizeof($arrayMainCategory)>0) { 
	$TopCategoryHtml  = '<select name="TopCategory" class="txtfield" id="TopCategory" style="width:130px;">';
	
	$TopCategoryHtml  .= '<option value="">'.SELECT_CATEGORY.'</option>';
	
	for($i=0;$i<sizeof($arrayMainCategory);$i++) {
	
		$TopCategorySelected = ($_GET['TopCat'] == $arrayMainCategory[$i]['CategoryID'])?(" Selected"):("");
		
		$TopCategoryHtml  .= '<option value="'.$arrayMainCategory[$i]['CategoryID'].'" '.$TopCategorySelected.'>'.stripslashes($arrayMainCategory[$i]['Name']).'</option>';
		
	}
	$TopCategoryHtml  .= '</select>';

}else{
	$TopCategoryHtml  = '<input type="hidden" name="TopCategory" id="TopCategory" value="0"';
}


echo $TopCategoryHtml;

?>		
		
		
		
		       </td>
        <td width="9%"  align="left" valign="middle">
		
	<input type="image" src="images/search_button.jpg"  width="57" height="18" name="ProductSearch" title="<?=SEARCH?>"  value="<?=SEARCH?>">	
		
		</td>
        <td width="24%"  align="left" valign="middle"><a href="#" class="bluetxt_link">More Search Options</a></td>
        <td width="6%" align="left" valign="top"><a href="#"><img src="images/help_button.gif" width="46" height="22" border="0" style="margin-top:5px;"/></a></td>
      </tr>
	  </form>
    </table></td>
  </tr>
 
  
  <tr>
       
    <td align="left" width="100%" valign="top"><table cellspacing="0" cellpadding="0" id="container3_srch" align="center" >
            <tr>
            <td height="32" align="left" valign="top" ><img src="images/Online-Store.jpg" width="705" height="89" /></td>
          </tr>
         
            <tr>
              <td align="left" height="35" valign="bottom" >
			  <span class="heading2"><?=YOU_SEARCH_ITEM_FOR?></span> <span class="blueheader"><?=$_GET['topkey']?></span>
			 
			  
			  
			  
			  
			  </td>
            </tr>
			
	 	
		<? if($_GET['TopCat']>0 && sizeof($arraySubCategory)>0) { ?>
		<tr>
            <td height="29" align="left" valign="middle">
			<div style="float:left;"><span class="bluetxt_bold10">Related Searches:</span> 
			<? for($i=0;$i<sizeof($arraySubCategory);$i++) {
				if($i==5) break;
				
				echo '<a href="search-products.php?SearchBy=Product&productkeyword='.$_GET['productkeyword'].'&TopCat='.$_GET['TopCat'].'&SubCat='.$arraySubCategory[$i]['CategoryID'].'" class="read_link_more">'.stripslashes($arraySubCategory[$i]['Name']).'</a>&nbsp;';
			?>
			
			<? } ?>
			</div>
			<? if(sizeof($arraySubCategory)>5){?>
			 <a href="#"><img src="images/viewall_button.jpg" width="58" height="19" border="0" style="float:left;"/></a>
			 <? } ?>
			 </td>
          </tr>		
		<? } ?>			
			
            <tr>
              <td height="15"></td>
            </tr>
       
		
		
	<tr>
		<td align="center" valign="top" >
						
		
			 <? require_once("includes/html/box/productListing.php"); ?>
		
		</td>
		</tr>	
		
		
		
          </table></td>
		
		 <td align="right" valign="top">
		 		 
		 <? require_once("includes/html/box/right.php"); ?>

		 
		 </td>
  </tr>
    </table></td>
  </tr>
</table>
