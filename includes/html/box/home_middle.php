<?  
	/***** LATES OFFERS ***/
	$arryProduct=$objProduct->GetLatestOffers('','',5);
	$num = sizeof($arryProduct);

?>

<table width="583" border="0" cellspacing="0" cellpadding="0">
         <? if($num>0){ ?>
		 
		  <tr>
            <td class="latestofferbg"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="latestofferheader">Latest Offers</td>
              </tr>
              <tr>
                <td align="left" valign="top">
				
		<? 
		$PageLimit = 4;
		require_once("includes/html/box/product-listing-latest.php"); 
		?>
				
				
				
				</td>
              </tr>
			 
              <tr>
                <td height="25" align="right" valign="middle">
				 <? if($num>4){ ?>
				<a href="special_offers.php" class="know_more">View More &raquo;</a> 
				 <? } ?></td>
              </tr>
			
            </table></td>
          </tr>
		   <tr>
            <td height="15"></td>
          </tr>
		  <? } ?>
         
		 
<?
	/***** HOT PRODUCTS ***/
	$arryProduct=$objProduct->GetNewProducts('','',5);
	$num = sizeof($arryProduct);

?>
	
 
	 <? if($num>0){ ?>	 
          <tr>
            <td class="latestofferbg"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="latestofferheader">Hot Products</td>
              </tr>
              <tr>
                <td align="left" valign="top">
				
			<? 
		$PageLimit = 4;
		require_once("includes/html/box/product-listing-hot.php"); 
		?>	
				
				
				</td>
              </tr>
			 
              <tr>
                <td height="25" align="right" valign="middle">
				  <? if($num>4){ ?>
				<a href="hot_products.php" class="know_more">View More &raquo;</a>
				  <? } ?>
				</td>
              </tr>
			
            </table></td>
          </tr>
		  
		 <? } ?> 
		  
		  
		  <tr>
            <td height="15"></td>
          </tr>
          <tr>
            <td class="stepbg"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="latestofferheader">Easy Transaction Procedure</td>
              </tr>
              <tr>
                <td align="left" valign="top" style="padding:0px 0 5px 0px;">
                <a href="easy_transaction.php" class="step1"><!--step1 --></a><div class="step1_arrow"></div>
                <a href="easy_transaction.php" class="step2"><!--step2 --></a><div class="step1_arrow"></div>
                <a href="easy_transaction.php" class="step3"><!--step3 --></a><div class="step1_arrow"></div>
                <a href="easy_transaction.php" class="step4"><!--step4 --></a><div class="step1_arrow"></div>
                <a href="easy_transaction.php" class="step5"><!--step5 --></a>
                </td>
              </tr>
              
            </table></td>
          </tr> 
		  
		  
        </table>