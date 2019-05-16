
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
  <tr>
       
    <td align="left"  valign="top" width="100%">
<table cellspacing="0" cellpadding="0" width="100%" align="center">

	<tr>
		<td class="heading"><?=BROWSE_PRODUCTS?></td>
	</tr>
	<tr>
		<td class="pagenav"><span ><?=$Nav_Home?> </span> <?=BROWSE_PRODUCTS?> </td>
	</tr>
	  <tr>
        <td height="15"></td>
      </tr>
	<tr>
	<td align="center" valign="top" height="200" >
	
	<? require_once("includes/html/box/product-listing.php"); ?>
	
	</td>
	</tr>	
		
</table>


	</td>
<td align="right" valign="top">
		 		 
  <? include("includes/html/box/right_panel.php"); ?>

		 
		 </td>
	</tr>	
		
</table>