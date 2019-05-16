<? 
	$arryProduct=$objProduct->GetSpecialProducts($_SESSION['StoreID'],1);
	$num = sizeof($arryProduct);

if($num>0){?>
	 <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
	  <tr>
		<td class="page_heading_bg">
		<div class="page_title" style="float:left;width:80%" ><?=SPECIALS?></div> 
			<? if($num>10){?>
			 <div><a href="storeSpecial.php" class="whitetxt_link">VIEW ALL</a></div> 
			 <? } ?>
			 </td>
	  </tr>
	  <tr>
		<td height="113" class="featuretable_border"  align="center">
		<? 
		$RecordsPerPage = 10;
		include("includes/html/box/store-prd-listing.php"); 
		$num=0;unset($arryProduct);
		?>
		</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  </table>
<? } ?>