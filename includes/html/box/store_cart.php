<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
    <td class="panel_top"><div class="heading">
      <?=SH0PPING_BASKET?>
    </div></td>
  </tr>
			  
                  <tr>
                    <td align="center" class="panel_middle" ><table width="93%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="74%" class="skytxt">
						<? 
						if(empty($arryNumCart[0]['NumCartItem'])) 
							echo CART_EMPTY;
						else
							echo '<a href="cart.php">'.$arryNumCart[0]['NumCartItem'].' Item(s) in the cart.</a>';
						?>
						
						</td>
                        <td width="26%" align="center" valign="middle">
						<a href="cart.php"><img src="<?=$TemplateFolder?>images/basket_icon.png"  border="0" /></a></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="center" class="panel_cart_bottom"  >
					
					<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td ><a href="#" onclick="<?=$CheckoutUrl?>" class="blacktxt_link">Check Out</a>&nbsp;<span class="blacktxt" >  |</span>&nbsp;  <a href="<?=$Config['Url']?>help.php" class="blacktxt_link" target="_blank">Help</a></td>
                      </tr>
                    </table>
					
					</td>
                  </tr>
		<tr>
			<td class="panel_bottom_cart"></td>
		  </tr>

                </table>
				<br style="line-height:8px;">