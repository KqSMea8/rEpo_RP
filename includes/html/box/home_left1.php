<?
	$arryNewLeftProduct=$objProduct->GetNewProducts('','',1);
?>
<td width="195" align="center" valign="top" >


<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
   <tr>
    <td class="leftbox" align="center" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="buyer_pro"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td height="34" class="vouchercode">Buyer Protection</td>
                    </tr>
                    <tr>
                      <td height="105" align="center" valign="middle"><a href="buyer_protection.php"><img src="images/buyer_protection.jpg" alt="Buyer Protection" border="0"/></a></td>
                    </tr>
                </table></td>
              </tr>
              
              
            </table>
	</td>
 	</tr>	
 
  <tr>
            <td height="15"></td>
          </tr>
 
  <tr>
    <td class="leftbox" align="center" valign="top">
	
	



<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="newarrivalbg">
			
			
			<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
   <? if(sizeof(arryNewLeftProduct)>0){ 
			  
	  $PrdLink   = 'productDetails.php?id='.$arryNewLeftProduct[0]['ProductID'];
		  
		if($arryNewLeftProduct[0]['Image'] !='' && file_exists('upload/products/'.$arryNewLeftProduct[0]['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$arryNewLeftProduct[0]['Image'].'&w=73&h=73'; 
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"   alt="'.stripslashes($arryNewLeftProduct[0]['Name']).'" title="'.stripslashes($arryNewLeftProduct[0]['Name']).'"/>';
		}else{
			$ImagePath = '<img src="images/no.gif" border="0"  alt="'.stripslashes($arryNewLeftProduct[0]['Name']).'" title="'.stripslashes($arryNewLeftProduct[0]['Name']).'">';
		} 
		
		$ImagePathLink = '<a href="'.$PrdLink.'">'.$ImagePath.'</a>';	  
			  
			  ?>
			  <tr>
                <td class="newarrivalheader">New Arrival</td>
              </tr>
              <tr>
                <td height="105" align="center" valign="middle">
				<?=$ImagePathLink?>
				
				</td>
              </tr>
              <tr>
                <td height="25" align="right" valign="top"><a href="new_arrival.php" class="know_more">Know more &raquo;</a></td>
              </tr>
			  <? } ?>
              <tr>
                <td class="vouchercode">Latest Voucher Codes</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td class="offoffer"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="70" class="grayborder"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="66%" align="center" valign="middle">25% off
                      <br />
                      all orders over $425
code : <span class="proid">5OM-D</span></td>
                    <td width="34%" align="right" valign="middle"><img src="images/olimar.jpg" alt="Olimar" /><br />
                      <a href="#"><img src="images/go.jpg" alt="go" border="0" /></a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="70"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="66%" align="center" valign="middle">25% off <br />
                      all orders over $425
                      code : <span class="proid">5OM-D</span></td>
                    <td width="34%" align="right" valign="middle"><img src="images/olimar.jpg" alt="Olimar" /><br />
                      <a href="#"><img src="images/go.jpg" alt="go" border="0" /></a></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            </tr>
        
		  
		  
		  
		  
		  
		  
        </table>
		
		
		
		
</td>
  </tr>
   <tr>
            <td height="15"></td>
          </tr>
  
  <tr>
    <td  align="center" valign="top">
	
		<? include("includes/html/box/banner.php"); ?>
			
	</td>
 	</tr>
  
</table>		
		
		
</td>