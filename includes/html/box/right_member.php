<?
$GapHtml = ' <table border="0" cellspacing="4" cellpadding="4" width="100%">
<tr>
    <td height="4" class="grayborder"></td>
</td>
  </tr>
</table>';

?> 
 
<table border="0" cellspacing="4" cellpadding="4"   align="center"  >
<tr><td class="leftbox" width="195" >




<table border="0" cellspacing="0" cellpadding="0"  width="95%" align="center"  >

  <tr>
    <td  class="newarrivalheader"><?
	echo '<i>WELCOME <a href="member-area.php" >'.$_SESSION['UserName'].'</a>,</i>';
	
	?></td>
  </tr>

   <tr>
    <td  height="25" class="txt"><?
	echo '<a href="logout.php" class="log_out">'.LOG_OUT.'</a>';
	
	?></td>
  </tr>
</table>


<?=$GapHtml?>


	
	
<table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td class="newarrivalheader"><?=MY_ACCOUNT?></td>
  </tr> 
  <tr>
   	 <td align="center"  >
	 
		<table align="center" width="90%" class="panel_links" border="0" >
		  <? if($_SESSION['MemberType']=='Seller'){ ?>
			  <tr><td><a href="account-company.php"><?=EDIT_ACCOUNT?></a></td></tr>
			  <tr><td><a href="view-company.php?view=<?=$_SESSION['MemberID']?>"><?=VIEW_COMPANY_PROFILE?></a></td></tr>
		  	<tr><td><a href="upgrade-membership.php"><?=UPGRADE_MEMBERSHIP?></a></td></tr>
			<tr><td><a href="change-password.php"><?=CHANGE_PASSWORD?></a></td></tr>
		  <? } else{ 
			?>
			 <tr><td><a href="account.php"><?=EDIT_ACCOUNT?></a></td></tr>
			 <tr><td><a href="change-password.php"><?=CHANGE_PASSWORD?></a></td></tr>
		  <? } 
		 
		  ?>
		  <!--
		  <tr><td><a href="viewReviews.php"><?=MY_REVIEWS?></a></td></tr>
		  <tr><td><a href="viewBanners.php"><?=MY_BANNERS?></a></td></tr>
		  <tr><td><a href="advertise-with-us.php"><?=ADVERTISE_WITH_US?></a></td></tr>
		 -->
		 <tr><td><a href="myOrders.php"><?=MY_ORDERS?></a></td></tr>
		  <tr><td><a href="wishList.php">Wish List</a></td></tr>
		 <? if($_SESSION['MemberType']=='Seller'){ ?>
		  <tr><td><a href="viewProducts.php"><?=MANAGE_PRODUCTS?></a></td></tr>
		 <? } ?>
		  <tr><td><a href="cart.php">View Cart</a></td></tr>
		  
		</table>

	 </td>
  </tr>
</table>	   

<? if($_SESSION['MemberType']=='Seller'){ ?>
	
<table width="95%" align="center" border="0" cellspacing="0" cellpadding="0" style="display:none">
 <tr>
    <td class="newarrivalheader"><?=MY_STORE?></td>
  </tr> 
  <tr>
   	 <td align="center"  >
	 
		<table align="center" width="90%" class="panel_links" border="0">
		
		 <? if($_SESSION['SelectedTemplate'] > 0 && !empty($_SESSION['WebsiteStoreOption'])){ ?>
		 		
			<? if($_SESSION['WebsiteStoreOption']=='w'){ ?>
			<tr><td><a href="<? echo $Config['StorePrefix'].$_SESSION['UserName'].'/home.php'; ?>"><?=GO_TO_WEBSITE?></a></td></tr>
			<tr><td><a href="edit-template.php?ws=w"><?=EDIT_TEMPLATE?></a></td></tr>
			<tr><td><a href="change-template.php"><?=CHANGE_TEMPLATE?></a></td></tr>
			<tr><td><a href="web-content.php"><?=EDIT_WEBSITE_CONTENT?></a></td></tr>
			<tr><td><a href="searchEngine.php"><?=SEARCH_ENGINE_DESCRIPTION?></a></td></tr>
				<? if($_SESSION['FeaturedWeb'] != 'Yes') { ?>
					<tr><td><a href="upgrade-webfeatured.php"><?=UPGRADE_FEATURED_WEBSITE?></a></td></tr>
				<? } ?>
			<tr><td><a href="viewBlog.php"><?=MANAGE_BLOG?></a></td></tr>
			<tr><td><a href="myOrders.php"><?=MY_ORDERS?></a></td></tr>
			  <tr><td><a href="viewPartners.php"><?=MY_PARTNERS?></a></td></tr>
			<tr><td><a href="account-setup.php"><?=GET_ONLINE_STORE?></a></td></tr>
<tr><td><a href="member-area.php?close_request=w" onclick="return confDel('<?=CLOSE_WEBSITE_ALERT?>')"><?=CLOSE_WEBSITE?></a></td></tr>
			<? } else if($_SESSION['WebsiteStoreOption']=='s'){ ?>
				<tr><td><a href="<? echo $Config['StorePrefix'].$_SESSION['UserName'].'/store.php'; ?>"><?=VIEW_STORE?></a></td></tr>
				<tr><td><a href="edit-template.php"><?=EDIT_TEMPLATE?></a></td></tr>
				<tr><td><a href="change-template.php"><?=CHANGE_TEMPLATE?></a></td></tr>
				<tr><td><a href="store-content.php"><?=EDIT_STORE_CONTENT?></a></td></tr>
				<tr><td><a href="account-payment.php"><?=PAYMENT_INFORMATION?></a></td></tr>
				<tr><td><a href="account-delivery.php"><?=DELIVERY_FEE?></a></td></tr>
				<tr><td><a href="searchEngine.php"><?=SEARCH_ENGINE_DESCRIPTION?></a></td></tr>
						  <? if($_SESSION['Featured'] != 'Yes') { ?>
						  <tr><td><a href="upgrade-featured.php"><?=UPGRADE_FEATURED_STORE?></a></td></tr>
						  <? } ?>
				  
				 <tr><td><a href="viewCategories.php"><?=MANAGE_CATAGORIES?></a></td></tr>
				  <tr><td><a href="viewProducts.php"><?=MANAGE_PRODUCTS?></a></td></tr>
			   <tr><td><a href="editProduct.php"><?=ADD_NEW_PRODUCT?></a></td></tr>
			   <tr><td><a href="viewOrders.php"><?=VIEW_ORDERS?></a></td></tr> 
			    <tr><td><a href="myOrders.php"><?=MY_ORDERS?></a></td></tr>
			   <tr><td><a href="viewPartners.php"><?=MY_PARTNERS?></a></td></tr>
			  
			   <tr><td><a href="account-setup.php"><?=GET_WEBSITE?></a></td></tr>
<tr><td><a href="member-area.php?close_request=s" onclick="return confDel('<?=CLOSE_STORE_ALERT?>')"><?=CLOSE_ONLINE_STORE?></a></td></tr>
			  <? }else if($_SESSION['WebsiteStoreOption']=='ws'){?>
					<tr><td><a href="<? echo $Config['StorePrefix'].$_SESSION['UserName'].'/home.php'; ?>"><?=GO_TO_WEBSITE?></a></td></tr>
					<tr><td><a href="<? echo $Config['StorePrefix'].$_SESSION['UserName'].'/store.php'; ?>"><?=VIEW_STORE?></a></td></tr>
					<tr><td><a href="change-template.php"><?=CHANGE_TEMPLATE?></a></td></tr>
					<tr><td><a href="edit-template.php"><?=EDIT_TEMPLATE?></a></td></tr>
					<tr><td><a href="web-content.php"><?=EDIT_WEBSITE_CONTENT?></a></td></tr>
					<tr><td><a href="store-content.php"><?=EDIT_STORE_CONTENT?></a></td></tr>
					<tr><td><a href="viewBlog.php"><?=MANAGE_BLOG?></a></td></tr>
					<tr><td><a href="account-payment.php"><?=PAYMENT_INFORMATION?></a></td></tr>
					<tr><td><a href="account-delivery.php"><?=DELIVERY_FEE?></a></td></tr>
					<tr><td><a href="searchEngine.php"><?=SEARCH_ENGINE_DESCRIPTION?></a></td></tr>
					<? if($_SESSION['Featured'] != 'Yes') { ?>
					<tr><td><a href="upgrade-featured.php"><?=UPGRADE_FEATURED_STORE?></a></td></tr>
					<? } ?>
					<? if($_SESSION['FeaturedWeb'] != 'Yes') { ?>
					<tr><td><a href="upgrade-webfeatured.php"><?=UPGRADE_FEATURED_WEBSITE?></a></td></tr>
					<? } ?>
					
					<tr><td><a href="viewCategories.php"><?=MANAGE_CATAGORIES?></a></td></tr>
					<tr><td><a href="viewProducts.php"><?=MANAGE_PRODUCTS?></a></td></tr>
					<tr><td><a href="editProduct.php"><?=ADD_NEW_PRODUCT?></a></td></tr>
					
					<tr><td><a href="viewPartners.php"><?=MY_PARTNERS?></a></td></tr>
					<tr><td><a href="viewOrders.php"><?=VIEW_ORDERS?></a></td></tr> 
<tr><td><a href="myOrders.php"><?=MY_ORDERS?></a></td></tr>
<tr><td><a href="member-area.php?close_request=w" onclick="return confDel('<?=CLOSE_WEBSITE_ALERT?>')"><?=CLOSE_WEBSITE?></a></td></tr>
<tr><td><a href="member-area.php?close_request=s" onclick="return confDel('<?=CLOSE_STORE_ALERT?>')"><?=CLOSE_ONLINE_STORE?></a></td></tr>					
				<? } ?>
				
					
			
		  <? }else{ ?>
			  <tr><td><a href="account-setup.php"><?=SETUP_YOUR_ACCOUNT?></a></td></tr>
		  <? } ?>

		</table>

	 </td>
  </tr>
</table>
<? } ?>

<table width="95%" align="center" border="0" cellspacing="0" cellpadding="0" style="display:none">
 <tr>
    <td class="newarrivalheader"><?=MY_TOOL_SET?></td>
  </tr> 
  <tr>
   	 <td align="center"  >
	 
		<table align="center" width="90%" class="panel_links" border="0">
		  <? if($_SESSION['MemberType']=='Seller' && !empty($_SESSION['WebsiteStoreOption'])){ ?>
		   <tr><td><a href="buyCredits.php?tp=email"><?=EMAIL_CREDITS_BUY?></a></td></tr>
		   <tr><td><a href="buyCredits.php?tp=sms"><?=SMS_CREDITS_BUY?></a></td></tr>
		  <tr><td><a href="viewBulks.php?tp=email"><?=SUBSCRIBED_EMAIL?></a></td></tr>
		  <tr><td><a href="SendEmail.php"><?=SEND_BULK_EMAIL?></a></td></tr>
		  <tr><td><a href="viewBulks.php?tp=sms"><?=SUBSCRIBED_SMS?></a></td></tr>
		  <tr><td><a href="SendSms.php"><?=SEND_SMS?></a></td></tr>
		  <? } ?>
		  <tr><td><a href="viewSubcribe.php?tp=email"><?=MY_EMAIL_SUSBCRIBE?></a></td></tr>
		  <tr><td><a href="viewSubcribe.php?tp=sms"><?=MY_SMS_SUSBCRIBE?></a></td></tr>
		</table>

	 </td>
  </tr>
</table>





 </td>
  </tr>
</table>