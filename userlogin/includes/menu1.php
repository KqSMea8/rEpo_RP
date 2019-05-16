<? if($ModuleID == 1 || $ModuleID == 2 || $ModuleID == 20  || $ModuleID == 21  || $ModuleID == 22  || $ModuleID == 23  || $ModuleID == 24) { ?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	   <a href="adminDetails.php" class="nav_menu">Admin Settings</a>&nbsp;|&nbsp;<a href="viewAdmins.php" class="nav_menu">Manage Administrators</a>&nbsp;|&nbsp;<a href="siteSettings.php" class="nav_menu">Site Settings</a>&nbsp;|&nbsp;<a href="viewCountries.php" class="nav_menu">Manage&nbsp;Countries</a>&nbsp;|&nbsp;<a href="viewStates.php" class="nav_menu">Manage&nbsp;States</a>&nbsp;|&nbsp;<a href="viewCities.php" class="nav_menu">Manage&nbsp;Cities</a>
	  </td>
	</tr>
  </table>
<? } ?>

<? if($ModuleID == 3) { 

	 if (is_object($objMenu)) {		// Checking the object of 'cms' class.
			$arrayMenu1 = $objMenu->GetPageContent('','');
			
			/*		
			if(sizeof($arrayMenu1)>0) {		
				$menu_name1 = "";
				$menu_id1 = "";
				foreach($arrayMenu1 as $menuKey1 => $menuValue1) {
					$menu_name1 .= $menuValue1['PageTitle']."#";
					$menu_id1 .= $menuValue1['PageID']."#";
				}
				$menu_name1 = rtrim($menu_name1,"#");
				$menu_id1 = rtrim($menu_id1,"#");		
				$menu_name1 = str_replace(" ","&nbsp;",$menu_name1);
			}
			*/
			
	}		



?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	  <? 
	  	for($i=0;$i<sizeof($arrayMenu1);$i++) {
	   ?>
	 	  <a href="cms.php?PageID=<?=$arrayMenu1[$i]['PageID']?>" class="nav_menu"><?=$arrayMenu1[$i]['PageTitle']?></a>
		  <? if($i<sizeof($arrayMenu1)-1) { echo '&nbsp;|&nbsp;'; } ?>
	  <? } ?>
	  </td>
	</tr>
  </table>
<? } ?>  
 
 <? if($ModuleID == 4 || $ModuleID == 5) { ?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	  
	  <a href="editCategory.php" class="nav_menu">Add Category</a>&nbsp;|&nbsp;<a href="viewCategories.php" class="nav_menu">Manage Categories</a>&nbsp;|&nbsp;<a href="editProduct.php" class="nav_menu">Add Product</a>&nbsp;|&nbsp;<a href="viewProducts.php" class="nav_menu">Manage Products</a>
	  
	  </td>
	</tr>
  </table>
<? } ?> 
  
 <? if($ModuleID == 25 || $ModuleID == 26) { ?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	  
	  <a href="editVideoCategory.php" class="nav_menu">Add Video Category</a>&nbsp;|&nbsp;<a href="viewVideoCategories.php" class="nav_menu">Manage Video Categories</a>&nbsp;|&nbsp;<a href="editVideo.php" class="nav_menu">Add Video</a>&nbsp;|&nbsp;<a href="viewVideos.php" class="nav_menu">Manage Videos</a>
	  
	  </td>
	</tr>
  </table>
<? } ?>   
	
  
<? if($ModuleID == 6 || $ModuleID == 7 || $ModuleID == 8) { ?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	  
	 <a href="editMember.php?opt=Buyer" class="nav_menu">Add Buyer</a>&nbsp;|&nbsp;
	  <a href="viewMembers.php?opt=Buyer" class="nav_menu">Manage Buyers</a>&nbsp;|
	  &nbsp;<a href="editMember.php?opt=Seller" class="nav_menu">Add Seller</a>&nbsp;|
	  &nbsp;<a href="viewMembers.php?opt=Seller" class="nav_menu">Manage Sellers</a>&nbsp;|&nbsp;<a href="viewMemberships.php" class="nav_menu">Memberships</a>&nbsp;|&nbsp;<a href="SendEmail.php?opt=Buyer" class="nav_menu">Send Email To Buyers</a>&nbsp;|&nbsp;<a href="SendEmail.php?opt=Seller" class="nav_menu">Send Email To Sellers</a>&nbsp;|&nbsp;<a href="SendSms.php" class="nav_menu">Send Bulk SMS</a>&nbsp;|&nbsp;<a href="viewReviews.php" class="nav_menu">Store Reviews</a>
	  
	  </td>
	</tr>
  </table>
<? } ?> 

<? if($ModuleID == 27) { ?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	   <a href="editTemplate.php" class="nav_menu">Add Template</a>&nbsp;|&nbsp;
	 <a href="viewTemplates.php" class="nav_menu">Manage Templates</a>&nbsp;|&nbsp;
	  <a href="editTpCategory.php" class="nav_menu">Add Template Category</a>&nbsp;|&nbsp;
	 <a href="viewTpCategories.php" class="nav_menu">Template Category</a>
	  
	  </td>
	</tr>
  </table>
<? } ?> 


 <? if($ModuleID == 11 || $ModuleID == 12 || $ModuleID == 13) { ?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	 <a href="viewStories.php" class="nav_menu">Success Stories</a>
	 &nbsp;|&nbsp;<a href="viewNews.php" class="nav_menu">Webo Bulletins</a>
	 &nbsp;|&nbsp;<a href="viewBanners.php" class="nav_menu">Manage Banners</a>
	  &nbsp;|&nbsp; <a href="viewFaqs.php" class="nav_menu">Manage Help/FAQs</a>
	  &nbsp;|&nbsp; <a href="viewPartners.php" class="nav_menu">Manage Partners</a>
	  &nbsp;|&nbsp; <a href="viewReports.php" class="nav_menu">Offensive Content Report</a>	
	  &nbsp;|&nbsp; <a href="viewKeywords.php" class="nav_menu">Search Terms</a>
	  
	    </td>
	</tr>
  </table>
<? } ?> 
 <? if($ModuleID == 28 || $ModuleID == 29 ) { ?> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
	  <td width="10" height="20" >&nbsp;</td>
	  <td width="993" class="nevigation_menu_bg">
	  
<a href="viewPackages.php?CatID=1" class="nav_menu">Featured Products Packages</a>&nbsp;|&nbsp;<a href="viewPackages.php?CatID=2" class="nav_menu">Featured Stores Packages</a>&nbsp;|&nbsp;<a href="viewPackages.php?CatID=3" class="nav_menu">Sponsors Packages</a>&nbsp;|&nbsp;<a href="viewPackages.php?CatID=4" class="nav_menu">Banners Packages</a>	  
	  </td>
	</tr>
  </table>
<? } ?> 



