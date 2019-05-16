        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="page_heading_bg"><div class="page_title" ><?=PRODUCT_DETAILS?></div>
            </td>
          </tr>
		     <tr>
            <td height="313" class="featuretable_border"  align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
		
			
              <tr>
                <td  class="generaltxt_inner">
				
				

			
				
				
	<table width="100%" border="0" cellpadding="2" cellspacing="3" >
  <tr>
    <td  class="generaltxt_inner" colspan="2" style="text-align:right" height="35"><?=SUCCESSFULLY_BID_MSG?></td>
  </tr>
 
 
  <tr>
  		<td width="27%" align="center" valign="top"  >
		
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" ><?=$ImagePath?></td>
  </tr>
  <tr>
    <td align="center" class="skytxt"><?=$EnlargeImage?></td>
  </tr>
</table>  			</td>
		
    <td width="73%" align="left" valign="top"><form name="AddCartold" id="AddCart" method="post" action="">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
           		<tr>
                  <td  colspan="2" align="left" valign="top" class="txt"><span class="redtxt"><?=PRODUCT_NAME?> : </span><strong><?php echo stripslashes($arryProduct[0]['Name']);?></strong></td>
                </tr>
				
             
                <tr align="left" valign="top">
                  <td height="1" colspan="2" bgcolor="#7A603D" style="padding:0px; margin:0px;"></td>
                </tr>
             
			
             
          <tr>
            <td height="33" colspan="2" class="txt" align="left">
			
			<?
			
			echo $PriceHTML;
			
			
			?>
			
			
			
			
			
			
			
					</td>
            </tr>
       
         
          <tr>
            <td height="1" colspan="2" bgcolor="#7A603D" style="padding:0px; margin:0px;"></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="txt12">
               <? if($arryProduct[0]['Detail'] != '' ){ ?>
                <tr valign="top">
                  <td height="25" colspan="2" align="left" valign="top" class="txt"><span class="redtxt">
                    <?=DESCRIPTION?>
                    :&nbsp; </span><?php echo stripslashes($arryProduct[0]['Detail']);?></td>
                  </tr> 
				  <? } ?>
				  <tr>
                  <td height="40" colspan="2" align="right" >	
				 
					<?=$SendEmail222?> <?=$AddToCart?>				</td>
                </tr>
            </table></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>

<?
	$CheckoutUrlBuy = (!empty($_SESSION['MemberID']))?("javascript:location.href='cart.php'"):("Javascript:LoginPrompt();");  

?>
 <Div align="right"><input name="checkout" type="button" class="button" value="<?=CHECKOUT?>" onclick="<?=$CheckoutUrlBuy?>" /></Div>



                </td>
              </tr>
			  
			  
            </table></td>
          </tr>
         
        </table>
    </td>
  </tr>
</table>

