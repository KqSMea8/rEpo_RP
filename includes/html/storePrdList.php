        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=PRODUCTS?></div>
            </td>
          </tr>
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
		
				<tr>
                  <td height="10" ></td>
                </tr>
			<? if($_GET['cat']>0){?>
		  	<tr>
                  <td class="border01 skytxt" style="padding-left:15px;"><?=$FlowUrls?>
                  </td>
                </tr>
		  <? } ?>
              <tr>
                <td valign="top" align="center">
				
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top"><? include("includes/html/box/store-prd-listview.php"); ?></td>
  </tr>
</table>

				
                </td>
              </tr>
            </table></td>
          </tr>
         
        </table>
    

<? if($num>0){ include("includes/html/box/store-vat-msg.php"); } ?>