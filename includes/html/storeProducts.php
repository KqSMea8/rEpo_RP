        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=PRODUCTS?></div>
            </td>
          </tr>
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
		
			 <? if($num>0){?>
		   <tr>
            <td align="right" height="30"><a href="storePrdList.php?cat=<?=$_GET['cat']?>" class="view_link">List View&nbsp;</a>
            </td>
          </tr>
		  <? } ?>
              <tr>
                <td>
				
				<? include("includes/html/box/store-prd-listing.php"); ?>
                </td>
              </tr>
            </table></td>
          </tr>
         
        </table>
    

<? if($num>0){ include("includes/html/box/store-vat-msg.php"); } ?>