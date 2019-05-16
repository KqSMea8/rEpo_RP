	 </TD>
  </TR>
 </TABLE>
 
 <TABLE WIDTH="<?=$Config['SiteWidth']?>" align="center" cellpadding="0" cellspacing="0">
	<tr>
    <td><img src="images/spacer.gif" width="30" height="5" /></td>
  </tr>
  <tr>
    <td height="23" align="center" bgcolor="#B8D3E6" class="verdana10">
	<?=HOT_ITEM?>:  <?  echo Alphabets('alpha-products.php?ch=','',$_GET['ch']); ?>
	
	
	</td>
  </tr>
  <tr>
    <td height="44" align="center" bgcolor="#236FA1" class="white11"><a href="index.php"><?=HOME?></a> &bull;
	<? 	if($arrayConfig[0]['SellOfferStatus']==1) { ?>
	<a href="offers-cat.php?opt=Sell"><?=SELL_OFFERS?></a> &bull;
	<? } ?>
	<? 	if($arrayConfig[0]['BuyOfferStatus']==1) { ?>
	<a href="offers-cat.php?opt=Buy"><?=BUY_OFFERS?></a> &bull;
	<? } ?>
	<a href="category.php?opt=All"><?=PRODUCTS?></a> &bull; <a href="companies.php"><?=COMPANIES?></a> &bull; <a href="member-area.php"><?=MEMBER_AREA?></a> &bull; <a href="inquiry-basket.php"><?=INQUIRY_BASKET?></a> &bull;<a href="editAlert.php"><?=TRADE_ALERT?></a> &bull; <a href="premium-companies.php"><?=PREMIUM_COMPANIES?></a> &bull; <a href="about-mytradespaces.php"><?=ABOUT_MY_TRADESPACES_DOT_COM?></a><br />
      &bull; <a href="premium-services.php"><?=PREMIUM_SERVICES?></a> &bull; <a href="help.php"><?=HELP?></a> &bull; <a href="sitemap.php"><?=SITEMAP?></a> &bull; <a href="contact-us.php"><?=CONTACT_US?></a> &bull; <a href="advertise-with-us.php"><?=ADVERTISE_WITH_US?></a> &bull; <a href="affiliate-program.php"><?=AFFILIATE_PROGRAM?></a> &bull; <a href="archives.php"><?=ARCHIVES?></a> &bull;<a href="alpha-products.php"><?=SEARCH_PRODUCTS?></a></td>
  </tr>
  <tr>
    <td background="images/bg-cross.gif"><img src="images/spacer.gif" width="30" height="14" /></td>
  </tr>
  <tr>
    <td><img src="images/spacer.gif" width="20" height="6" /></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%" height="47" valign="top" style="padding-left:10px;"><img src="images/paypal.jpg" width="164" height="26" /></td>
        <td width="72%" valign="top" class="verdan11">&copy; Copyright mytradespaces.com, All Rights Reserved 2007 - 2008</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1%" align="left" valign="top" background="images/bg.gif"><img src="images/corner-left.gif" width="14" height="83" /></td>
        <td width="8%" align="center" valign="middle" background="images/bg.gif"><img src="images/warning.jpg" width="43" height="49" /></td>
        <td width="89%" background="images/bg.gif" class="verdan11"><?=FOOTER_TEXT?></td>
        <td width="2%" align="right" valign="top" background="images/bg.gif"><img src="images/corner-right.gif" width="14" height="83" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><img src="images/spacer.gif" width="30" height="5" /></td>
  </tr>
</TABLE>

</BODY>
</HTML>
