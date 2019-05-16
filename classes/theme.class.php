<?php

class theme extends dbClass
{


	function  GetWidgets()
	{
		$sql = "SELECT * FROM theme_widgets where status='1'";
		return $this->query($sql, 1);
	}
	function  GetThemes()
	{
		$sql = "SELECT * FROM theme_theme";
		return $this->query($sql, 1);
	}
	function getThemeById($id) {
		$sql = "SELECT * from theme_theme WHERE id = '" . addslashes($id) . "'";
		return $this->query($sql, 1);
	}
	function GetPagesByThemeId($id) {
		$sql = "SELECT * from theme_pages WHERE themeId = '" . addslashes($id) . "'";
		return $this->query($sql, 1);
	}

	function GetPagesByThemeIdAndPageID($id) {
		$sql = "SELECT * from theme_pages WHERE  id= '" . addslashes($id) . "' ";
		return $this->query($sql, 1);
	}

	function SaveLayout($id,$layoutval) {

		$sql = "UPDATE theme_pages SET layoutType='" . addslashes($layoutval) . "'	WHERE id ='" . $id."'";
		$this->query($sql, 0);
	}

	function SaveSetting($id,$content) {

		$sql = "UPDATE theme_pages SET setting='" . addslashes($content) . "'	WHERE id ='" . $id."'";
		$this->query($sql, 0);
	}

	function saveSectionsetting($id,$type,$content) {

		$sql = "UPDATE theme_theme SET `$type`='" . addslashes($content) . "'	WHERE id ='" . $id."'";
		$this->query($sql, 0);
	}

	function addTheme($arryDetails) {
		@extract($arryDetails);

		$sql = "INSERT INTO  theme_theme SET themeName='" . addslashes($themeName) . "'";
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();

		$pageArray=array('home','productDetails','products','cart','checkout','myProfile','change_password','addressBook','myWishlist','myOrders','newsletter','login','forgot','register','page','account','completed','myOrder');
		$pageDisplayArray=array('Home','Product Details','Products','Cart','Checkout','My Profile','Change Password','Address Book','My Wishlist','My Orders','Newsletter','Login','Forgot','Register','Page','Account','Completed','Order Detail');
		foreach($pageArray as $key=>$val){
			$sql = "INSERT INTO  theme_pages SET page='" . addslashes($val) . "', pageDisplayName='" . addslashes($pageDisplayArray[$key]) . "', themeId='" . addslashes($lastInsertId) . "'";
			$this->query($sql, 0);
		}
	}

	function updateTheme($arryDetails) {

		@extract($arryDetails);
		$sql = "UPDATE theme_theme SET themeName='" . addslashes($themeName) . "'	WHERE id ='" . $id."'";

		$this->query($sql, 0);
	}
	function UpdateThumbImage($imageName,$ThemeId)
	{

		$sql = "UPDATE  theme_theme SET thumb_image='".$imageName."' WHERE id ='" . $ThemeId."'";
		return $this->query($sql, 0);

	}

	function deleteTheme($ThemeId){
		$sql = "DELETE FROM theme_pages WHERE themeId = '".addslashes($ThemeId)."'";
		$this->query($sql, 0);

		$sql = "DELETE FROM theme_theme WHERE id = '".addslashes($ThemeId)."'";
		$this->query($sql, 0);
	}


	

	function getEcomTemplates($TemplateType,$ecomType='') {
		global $Config;
			

		/*
		$sql = "SELECT a.*,b.themeUploadedName from erp.templates a
		left join theme_theme b on  b.themeUploadedName=a.TemplateName 
		where TemplateType='" . addslashes($TemplateType) . "' and Status=1 ";
		$sql .= ($ecomType!=''? "and ecomType='" . addslashes($ecomType) . "' ":"");
		$sql .= " having b.themeUploadedName is null ORDER BY TemplateId DESC ";*/
		
		$sql="SELECT a . * from  erp.templates a where  TemplateType = '" . addslashes($TemplateType) . "' 
		and Status = 'Yes'  and ecomType = '" . addslashes($ecomType) . "' ORDER BY TemplateId DESC";		
		$templates= $this->query($sql, 1);
		
		foreach($templates as $key=>$value){
			$sql="SELECT count(*) as total from  theme_theme where themeUploadedName = '" . addslashes($value['TemplateName']) . "' ";		
			$purchasedtemplates= $this->query($sql, 1);
			if($purchasedtemplates[0]['total']>0){
				unset($templates[$key]);
			}
		}
		
		$arrangetemplates=array_values($templates);		
		
		return $arrangetemplates;
	}


	function makeOrder($arryDetails){
		@extract($arryDetails);
		
		$ids= implode(',',$arryDetails['templateId']);
		$sql = "SELECT * from erp.templates where TemplateId in (".$ids.") ";
		$templates=$this->query($sql, 1);
		$totalPrice='';
		foreach($templates as $templatesdata){
			$totalPrice=$totalPrice+$templatesdata['TemplatePrice'];
		}
		$sql = "INSERT INTO  theme_order SET amount='" . addslashes($totalPrice) . "', 
		templateDetail='" . addslashes(serialize($templates)) . "', orderdate=NOW(), status='Process'";
				
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		
		return $lastInsertId;
	}

	function getOrder($lastInsertId){
		
		$sql = "SELECT * from theme_order where orderid = '" . addslashes($lastInsertId) . "' ";
		$order=$this->query($sql, 1);
		
		return $order;
	}
	function addpaymentresponse($data){
		$sql = "INSERT INTO  theme_payment_response SET response='" . addslashes(serialize($data)) . "'";
				
		$this->query($sql, 0);
	}
	
	function updateOrderPayment($data){
		
		
		$orderId=$data['custom'];
		if($data['payment_status']=='Completed'){			
			$sql = "UPDATE  theme_order SET paymentResponce='".addslashes(serialize($data))."',status='Success' WHERE orderid = '" . addslashes($orderId) . "'";
			$this->query($sql, 0);
			$orderData=$this->getOrder($orderId);
			
			$templateDetail=unserialize($orderData[0]['templateDetail']);
			
			foreach($templateDetail as $templateval){
				
				$this->ImportTheme($templateval['TemplateDisplayName'],$templateval['Thumbnail'],$templateval['TemplateName']);
			}
			
			
		}else{
			$sql = "UPDATE  theme_theme SET paymentResponce='".addslashes(serialize($data))."',status='Fail' WHERE orderid = '" . addslashes($orderId) . "'";
			 $this->query($sql, 0);
		}
		return true;
	}
	
	function ImportTheme($themeName,$imageName,$themeUploadedName) {

		
			
			
		$header='<div id="logo_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove logo_widget ui-draggable-handle"><span>Logo</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="currency_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove currency_widget ui-draggable-handle"><span>Currency</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="signin_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove signin_widget ui-draggable-handle"><span>SignIN</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="topmenu_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove topmenu_widget ui-draggable-handle"><span>Top Menu</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="social_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove social_widget ui-draggable-handle"><span>Social Link</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="search_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-handle ui-draggable-dragging remove search_widget"><span>Search</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div>';
		$footer='<div id="footer_subscriber_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove footer_subscriber_widget ui-draggable-handle"><span>Footer Subscriber</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="footer_information_menu_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove footer_information_menu_widget ui-draggable-handle"><span>Footer Information Menu</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="footer_shop_menu_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove footer_shop_menu_widget ui-draggable-handle"><span>Footer Shop Menu</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="footer_my_account_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-handle ui-draggable-dragging remove footer_my_account_widget"><span>Footer My Account</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div>';
		$left='<div id="left_category_menu_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable ui-draggable-dragging remove left_category_menu_widget ui-draggable-handle"><span>Left Category Menu</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="left_manufacturer_filter_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable remove left_manufacturer_filter_widget ui-draggable-dragging ui-draggable-handle"><span>Left Manufacturer Filter</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div id="left_price_filter_widget" style="width:242px;height:242px; display:inline-block; " class="drag ui-draggable remove left_price_filter_widget ui-draggable-dragging ui-draggable-handle"><span>Left Price Filter</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div>';
		$Home='<div class="drag ui-draggable ui-draggable-handle ui-draggable-dragging remove best_seller_products_widget" style="width:242px;height:242px; display:inline-block; " id="best_seller_products_widget"><span>Best Seller Products</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div class="drag ui-draggable ui-draggable-handle ui-draggable-dragging remove slider_banner_widget" style="width:242px;height:242px; display:inline-block; " id="slider_banner_widget"><span>Slider Banner</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div><div class="drag ui-draggable ui-draggable-handle ui-draggable-dragging remove featured_products_widget" style="width:242px;height:242px; display:inline-block; " id="featured_products_widget"><span>Featured Products</span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span><span><a title="Remove" class="xicon delete" href="Javascript:void(0)">X</a></span></div>';
		
		$sql = "INSERT INTO  theme_theme SET themeName='" . addslashes($themeName) . "' , thumb_image='".addslashes($imageName)."', themeUploadedName='".addslashes($themeUploadedName)."', header='".addslashes($header)."' , footer='".addslashes($footer)."', `left`='".addslashes($left)."' ";
		
		$this->query($sql, 0);
		
		$lastInsertId = $this->lastInsertId();
		$pageArray=array('home','productDetails','products','cart','checkout','myProfile','change_password','addressBook','myWishlist','myOrders','newsletter','login','forgot','register','page','account','completed','myOrder');
		$pageDisplayArray=array('Home','Product Details','Products','Cart','Checkout','My Profile','Change Password','Address Book','My Wishlist','My Orders','Newsletter','Login','Forgot','Register','Page','Account','Completed','Order Detail');
		$pageSettingArray=array($Home,'','','','','','','','','','','','','','','','','');
		foreach($pageArray as $key=>$val){
			$sql = "INSERT INTO  theme_pages SET page='" . addslashes($val) . "', pageDisplayName='" . addslashes($pageDisplayArray[$key]) . "', themeId='" . addslashes($lastInsertId) . "', setting='" .addslashes($pageSettingArray[$key]) . "'";
				
			$this->query($sql, 0);
		}
	}



}

?>
