<?
	$arryNewLeftProduct=$objProduct->GetNewProducts('','',1);
?>
<td width="195" align="center" valign="top" >


<table width="100%" border="0" cellspacing="0" cellpadding="0">
 
   <tr>
    <td class="leftbox" align="center" valign="top" >
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
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="border-bottom:1px solid #a4a2a2">&nbsp;</td>
  </tr>
</table>
		
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="newarrivalbg55">
			
			
			<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
   <? if(sizeof(arryNewLeftProduct)>0){ 
			  
	  $PrdLink   = 'productDetails.php?id='.$arryNewLeftProduct[0]['ProductID'];
		  
		if($arryNewLeftProduct[0]['Image'] !='' && file_exists('upload/products/'.$arryNewLeftProduct[0]['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/'.$arryNewLeftProduct[0]['Image'].'&w=90&h=90'; 
			$ImagePath = '<img src="'.$ImagePath.'"  border="0"   alt="'.stripslashes($arryNewLeftProduct[0]['Name']).'" title="'.stripslashes($arryNewLeftProduct[0]['Name']).'"/>';
		}else{
			$ImagePath = '<img src="images/no.gif" border="0"  alt="'.stripslashes($arryNewLeftProduct[0]['Name']).'" title="'.stripslashes($arryNewLeftProduct[0]['Name']).'">';
		} 
		
		$ImagePathLink = '<a href="'.$PrdLink.'">'.$ImagePath.'</a>';	  
			  
			  ?>
			  <tr>
                <td class="vouchercode" height="36">New Arrival </td>
              </tr>
              <tr>
                <td height="105" align="center" valign="middle">
				<?=$ImagePathLink?>
				
				</td>
              </tr>
              <tr>
                <td align="right" valign="top"><a href="new_arrival.php" class="know_more">Know more &raquo;</a></td>
              </tr>
			  <? } ?>
              
            </table>
			
			
			
			
			
			</td>
            </tr>
         
		  
		  
        </table>		
				<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td style="border-bottom:1px solid #a4a2a2">&nbsp;</td>
  </tr>
</table>
			
		<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
 <tr>
            <td height="30"></td>
          </tr>  	  
	<tr>
    <td  align="center" valign="top" >
	
		<? 
		$image_banner=1;
		include("includes/html/box/banner.php"); ?>
			
	</td>
 	</tr>	
	  <tr>
            <td height="30"></td>
          </tr>  
 
  

  
  <tr>
    <td  align="center" valign="top" >
	
		<? 
	
		$image_banner=0;
		include("includes/html/box/banner.php"); ?>
			
	</td>
 	</tr>
	 <tr>
            <td height="15"></td>
          </tr> 
		  
		  
	 <tr>
            <td height="29"></td>
          </tr> 		  
		  
</table>

			
			
	</td>
 	</tr>	
 

		  
  
	  
  
</table>		
		
		
</td>