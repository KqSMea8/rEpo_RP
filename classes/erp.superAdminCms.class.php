<?php

class erpsupercms extends dbClass
{

	/*     * **********************************************************START FUNCTIONS FOR PAGES**************************************************************************** */

	function addPage($arryDetails) {
		@extract($arryDetails);
		 $sql = "INSERT INTO  erp_pages SET Name='" . addslashes($Name) . "', Title = '" . addslashes($Title) . "',Priority = '".$Priority."',UrlCustom = '".$UrlCustom."',UrlHash=MD5('".$UrlCustom."'),MetaKeywords='".addslashes($MetaKeywords)."',MetaTitle='".addslashes($MetaTitle)."',MetaDescription='".addslashes($MetaDescription)."',Status='" . $Status . "',Content='".addslashes($page_content)."',template='".$template."'";
		$this->query($sql, 0);
return $this->lastInsertId();
	}

	function getPages() {
		$sql = "SELECT * from erp_pages  ORDER BY Name ASC ";
		return $this->query($sql, 1);
	}

	function getPageById($id) {
		
		$sql = "SELECT * from erp_pages WHERE id = '".$id."'";
		return $this->query($sql, 1);
	}

	function updatePage($arryDetails) {
		@extract($arryDetails);
		$sql = "UPDATE  erp_pages SET Name='" . addslashes($Name) . "', Title = '" . addslashes($Title) . "',Priority = '".$Priority."',UrlCustom = '".$UrlCustom."',UrlHash=MD5('".$UrlCustom."'),MetaKeywords='".addslashes($MetaKeywords)."',MetaTitle='".addslashes($MetaTitle)."',MetaDescription='".addslashes($MetaDescription)."',Status='" . $Status . "',Content='".addslashes($page_content)."',template='".$template."' WHERE id = '".$id."'";
		$this->query($sql, 0);
	}

	function deletePage($id) {

		$sql = "DELETE from erp_pages where id = '".$id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function changePageStatus($id) {
		$sql = "select * from erp_pages where id = '".$id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update erp_pages set Status='" . $Status . "' where id = '".$id."'";
			$this->query($sql, 0);
			return true;
		}
	}

	function getPagesforFront() {
		$sql = "SELECT * from erp_pages WHERE Status = 'Yes' ORDER BY Priority ASC ";
		return $this->query($sql, 1);
	}

	function getPageIdByHash($urlhash) {
		$sql = "SELECT id FROM erp_pages WHERE UrlHash='".$urlhash."'";
		return $this->query($sql, 1);
	}

	function getPageSlug(){
		$data=array();
		$sql="SELECT UrlCustom From erp_pages";
		$slugp = $this->query($sql, 1);
		foreach($slugp as $slugs){
			$data[]=$slugs['UrlCustom'];
		}
		return $data;
	}

	function addSocialLink($arryDetails,$fileName) {
		@extract($arryDetails);
		$sql = "INSERT INTO  erp_social_link SET Title = '".$Title."',Priority = '".$priority."',Status='" . $Status . "',URI='".$uri."',Icon='" . $fileName . "'";
		$this->query($sql, 0);
	}
	function updateSocialLink($arryDetails,$fileName) {
		@extract($arryDetails);
		if(!empty($fileName)){
			$sql = "UPDATE  erp_social_link SET Title = '".$Title."',Priority = '".$priority."',URI='".$uri."',Icon='" . $fileName . "' WHERE id = '".$id."'";
		}else{
			$sql = "UPDATE  erp_social_link SET Title = '".$Title."',Priority = '".$priority."',URI='".$uri."' WHERE id = '".$id."'";
			 
		}

		$this->query($sql, 0);
	}
	
	function getSocialLink() {
		$sql = "SELECT * from erp_social_link  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}
	function getsocialLinkById($id) {
		$sql = "SELECT * from erp_social_link WHERE id = '".$id."'";
		return $this->query($sql, 1);
	}

	function changeSocialStatus($id) {
		$sql = "select * from erp_social_link where iid = '".$id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update erp_social_link set Status='" . $Status . "' where id = '".$id."'";
			$this->query($sql, 0);
			return true;
		}
	}
	function deleteSocialLink($id) {

		$sql = "DELETE from erp_social_link where id = '".$id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}
	function showPage(){
		$sql="SELECT id,Name FROM erp_pages ORDER BY Name ASC";
		return $this->query($sql, 1);
	}

	function addMenu($arryDetails) {
		@extract($arryDetails);
		$sql = "INSERT INTO  erp_menu SET page_id='" .$page_id. "', type= '" .$type. "',slug = '".$slug."'";
		$this->query($sql, 0);
	}

	function showAllMenu(){
		$sql="SELECT * FROM erp_menu GROUP BY slug";
		return $this->query($sql, 1);
	}

	function updateHeaderMenue($arryDetails) {
		@extract($arryDetails);
		 
		$sql = "UPDATE  erp_menu SET page_id='" .$page_id. "', type= '" .$type. "',slug = '".$slug."' WHERE slug = '$id'";
		$this->query($sql, 0);
	}

	function deleteHeaderMenu($id) {

		$sql = "DELETE FROM erp_menu WHERE slug = '$id' ";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function getHeaderMenyBySlug($id) {
		$sql = "SELECT * FROM erp_menu WHERE slug = '$id'";
		return $this->query($sql, 1);
	}

	function addBanner($arryDetails,$fileName) {
		@extract($arryDetails);
		$sql = "INSERT INTO  erp_banner SET Title = '".$Title."',Priority = '".$Priority."',Status='" . $Status . "',Image='" . $fileName . "'";
		$this->query($sql, 0);
	}

	function getBanner() {
		$sql = "SELECT * FROM erp_banner  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}

	function getBannerById($id) {
		$sql = "SELECT * FROM erp_banner WHERE id = '".$id."'";
		return $this->query($sql, 1);
	}

	function deleteBanner($id){
		$sql="DELETE FROM erp_banner WHERE id = '".$id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function changeBannerStatus($id) {
		$sql = "select * from erp_banner where id = '".$id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update erp_banner set Status='" . $Status . "' where id = '".$id."'";
			$this->query($sql, 0);
			return true;
		}
	}

	function updateBanner($arryDetails,$fileName) {
		@extract($arryDetails);
		if(!empty($fileName)){
			$sql = "UPDATE  erp_banner SET Title = '".$Title."',Priority = '".$Priority."',Image='" . $fileName . "' WHERE id = '".$id."'";
		}else{
			$sql = "UPDATE  erp_banner SET Title = '".$Title."',Priority = '".$Priority."' WHERE id = '".$id."'";

		}

		$this->query($sql, 0);
	}
	
	 
	function getpackFeatureById($id) {
		//$sql = "SELECT * FROM  package_feature WHERE id = '$id'";
            $sql = "SELECT * FROM  erp_pack_feature WHERE id = '$id'";
		return $this->query($sql, 1);
	}
	
	function changePackFeature($id) {
		//$sql = "SELECT * FROM package_feature WHERE id=" . $id;
            $sql = "SELECT * FROM erp_pack_feature WHERE id='" . $id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			//$sql = "UPDATE package_feature SET Status='" . $Status . "' WHERE id=" . $id;
                        $sql = "UPDATE erp_pack_feature SET Status='" . $Status . "' WHERE id = '".$id."'";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function deletePackFeature($id) {
                $sql = "DELETE FROM erp_pack_feature WHERE id = '".$id."'";
		//$sql = "DELETE FROM package_feature WHERE id = '$id' ";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}
	
	function addPackFeature($arryDetails) {
		@extract($arryDetails);
            $sql = "INSERT INTO  erp_pack_feature SET feature='".$feature."',description= '".$description."', type= '".$type."',Status = '".$Status."'";
            //$sql = "INSERT INTO  package_feature SET feature='".$feature."',description= '".$description."', type= '".$type."',Status = '".$Status."'";
		$this->query($sql, 0);
	}
	
	function updatePackFeature($arryDetails) {
		@extract($arryDetails);		
                $sql = "UPDATE erp_pack_feature SET  feature='" .$feature. " ',description= '".$description." ', type= '" .$type. "',Status = '".$Status."' WHERE id = '".$id."'";
                //$sql = "UPDATE package_feature SET  feature='" .$feature. " ',description= '".$description." ', type= '" .$type. "',Status = '".$Status."' WHERE id=" .$id;
		$this->query($sql, 0);
	}
	function getPackFeatureList() {
		$sql = "SELECT * FROM erp_pack_feature ORDER BY ModuleID  ASC ";
		//$sql = "SELECT * FROM package_feature  ORDER BY OrderBy  ASC ";
		return $this->query($sql, 1);
	}
	
	function addPkType($arryDetails,$str) {
		@extract($arryDetails);
		 echo $sql = "INSERT INTO  erp_package_type SET name='".$name."',value= '".$str."',Status = '".$Status."'";
		$this->query($sql, 0);
	}
	
	function getPackTypeList() {
		$sql = "SELECT * FROM  erp_package_type  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}
	
	
	function deletePackType($id){
		$sql="DELETE FROM erp_package_type WHERE id = '".$id."'";
		$res = $this->query($sql, 0);
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
		
	}
	
	function changePackType($id) {
		$sql = "SELECT * FROM erp_package_type WHERE id = '".$id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "UPDATE erp_package_type SET Status='" . $Status . "' WHERE id = '".$id."'";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function getpackTypeById($id) {
		$sql = "SELECT * FROM  erp_package_type WHERE id = '".$id."'";
		return $this->query($sql, 1);
	}
	

	function updatePackType($arryDetails,$str,$id) {
		@extract($arryDetails);
		 echo $sql = "UPDATE erp_package_type SET name='".$name."',value= '".$str."' WHERE id = '".$id."'";
		$this->query($sql, 0);
	}
	
	
	function getCurrenct(){
		$sql="SELECT * FROM currencies";
		return $this->query($sql, 1);
	}
	
	
	function addPackages($arryDetails,$str) {
		@extract($arryDetails);
		$sql = "INSERT INTO  erp_packages SET name='".$name."',price= '".$price."',currency='".$currency."',duration='".$duration."',package_type='".$package_type."',features='".$str."',Status = '".$Status."',allow_users='".$allow_users."',space='".$space."',additional_spaceprice='".$additional_spaceprice."',short_description='".$short_description."',edition_features='".$edition_features."',description='".$description."'";
		$this->query($sql, 0);
		
	}
		
	function getPackagesList() {
		$sql = "SELECT p.*,t.name as type FROM  erp_packages p inner join  erp_package_type t on p.package_type=t.id ORDER BY p.id DESC ";
		return $this->query($sql, 1);
	}
	
		
	function changePackstatus($id) {
		$sql = "SELECT * FROM erp_packages WHERE id = '".$id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "UPDATE erp_packages SET Status='" . $Status . "' WHERE id = '".$id."'";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function getpackageById($id) {
		$sql = "SELECT * FROM  erp_packages WHERE id = '".$id."'";
		return $this->query($sql, 1);
	}
	
	
		function getAllPackage($id=0) {
		$sql = "SELECT * FROM  erp_packages order by id asc";
		return $this->query($sql, 1);
	}
	
	
	
	

  function updatePackges($arryDetails,$str,$id,$arrayinventryModule){
  	
 	 $ShippingCareerValue=implode(",",$arryDetails['ShippingCareerVal']);
	    $PlanDurationVal=implode(",",$arryDetails['PlanDuration']);
		@extract($arryDetails);
		if($unllimited==1){
			$maxProduct='';
		}
		$sql = "UPDATE erp_packages SET name='".$name."',price= '".$price."',features='".$str."',Status = 'Yes',allow_users='".$allow_users."',space='".$space."',additional_spaceprice='".$additional_spaceprice."',short_description='".$short_description."',edition_features='".$edition_features."',description='".$description."',PlanDuration='".$PlanDurationVal."',inventryModule='".$arrayinventryModule."' , maxProduct='".$maxProduct."',batchmgmt='".$batchmgmt."',ShippingCareer='".$ShippingCareer."',ShippingCareerVal='".$ShippingCareerValue."' WHERE id = '".$id."'";	
		$this->query($sql, 0);
	}
	
	
	function deletePack($id){
		$sql="DELETE FROM erp_packages WHERE id = '".$id."'";
		$res = $this->query($sql, 0);
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
		
	}
	
	function addCoupons($arryDetails) {
		@extract($arryDetails);
	    $sql = "INSERT INTO  erp_coupons SET CouponCode = '".$CouponCode."',MinAmount='".$MinAmount."',Discount='".$Discount."',Percentage='".$Percentage."',Amount='".$Amount."',CouponType='".$CouponType."', Package='".$Package."',DiscountType='".$DiscountType."',User='".$User."',UseLimit='".$UseLimit."',ExpiryDate='".$ExpiryDate."',Status='" . $Status . "'";
		$this->query($sql, 0);
	}
	
	function changeCouponsStatus($id) {
		$sql = "select * from erp_coupons where id = '".$id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update erp_coupons set Status='" . $Status . "' where id = '".$id."'";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function deleteCoupons($id) {

		$sql = "DELETE from erp_coupons where id = '".$id."'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}
	
	function updateCoupons($arryDetails,$id) {
	    @extract($arryDetails);
		//$sql = "UPDATE  erp_coupons SET CouponCode = '".$CouponCode."',MinAmount='".$MinAmount."',Discount='".$Discount."',CouponType='".$CouponType."',ExpiryDate='".$ExpiryDate."',Status='" . $Status . "' WHERE id =" . $id;
		 $sql = "UPDATE  erp_coupons SET CouponCode = '".$CouponCode."',MinAmount='".$MinAmount."',Discount='".$Discount."',Percentage='".$Percentage."',Amount='".$Amount."',CouponType='".$CouponType."', Package='".$Package."',DiscountType='".$DiscountType."',User='".$User."',UseLimit='".$UseLimit."',ExpiryDate='".$ExpiryDate."',Status='" . $Status . "' WHERE id = '".$id."'";
		$this->query($sql, 0);
	}
	
	
	function getCouponsById($id) {
		$sql = "SELECT * from erp_coupons WHERE id = '".$id."'";
		return $this->query($sql, 1);
	}
	function getCoupons() {
		$sql = "SELECT * from erp_coupons  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}
	
	
	function getPaymentHistory1() {
		$sql = "SELECT * FROM orders  ORDER BY OrderID DESC ";
		return $this->query($sql, 1);
	}
	
	function getPaymentHistory($SearchKey,$SortBy,$AscDesc){
		
	$strAddQuery = '';
	$SearchKey   = strtolower(trim($SearchKey));
	$strAddQuery .= " where 1  and o.orderType='erp'";
	
	 if($SortBy != ''){
	
		if($SortBy=='c.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");
	
		$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
	}else{
	$strAddQuery .= (!empty($SearchKey))?(" and (c.CompanyName like '%".$SearchKey."%' or c.DisplayName like '%".$SearchKey."%'  or c.CmpID like '%".$SearchKey."%') " ):("");			}
	
	$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by o.OrderID ");
	$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" desc");
		
	    $sql="SELECT c.CmpID,
		c.CompanyName,
		c.DisplayName,
		c.Email,
		c.Image,
		o.OrderID,
		o.PaymentPlan,
		o.StartDate,
		o.EndDate,
		o.UpdatedDate,
		o.MaxUser,
		o.PlanDuration,
		o.Price,
		o.TotalAmount,
		o.FreeSpace,
		o.FreeSpaceUnit,
		o.AdditionalSpaceUnit,
		o.TransactionID,
		o.CouponCode,
		o.CouponType,
		o.DiscountType,
		o.NumUser,
		o.customer_first_name,
		o.customer_last_name,
		o.orderType,
		o.customer_credit_card_type FROM orders o  LEFT OUTER JOIN company c ON o.CmpID=c.CmpID ".$strAddQuery."";
		
	   return $this->query($sql, 1);
	}

	
	function paymentByCmpId($CmpId){
		global $Config;
	    $sql="SELECT c.CmpID,
		c.CompanyName,
		c.DisplayName,
		c.Email,
		o.PaymentPlan,
		o.StartDate,
		o.EndDate,
		o.UpdatedDate,
		o.MaxUser,
		o.PlanDuration,
		o.Price,
		o.TotalAmount,
		o.FreeSpace,
		o.FreeSpaceUnit,
		o.AdditionalSpace,
		o.AdditionalSpaceUnit,
		o.TransactionID,
		o.CouponCode,
		o.CouponDiscount,
		o.CouponType,
		o.DiscountType,
		o.NumUser,
		o.customer_first_name,
		o.customer_last_name,
		o.customer_credit_card_type,
		DECODE(o.customer_credit_card_number,'". $Config['EncryptKey']."') as customer_credit_card_number,
		o.cc_expiration_month,
		o.cc_expiration_year,
		o.cc_cvv2_number,
		o.customer_address1,
		o.customer_address2,
		o.customer_city,
		o.customer_state,
		o.country_id,
		o.customer_zip
		FROM orders o  LEFT OUTER JOIN company c ON c.CmpID=o.CmpID WHERE OrderId='".$CmpId."'
        ";
		
	   return $this->query($sql, 1);
	}
	
	
	

	/*     * ****************************************************END FUNCTIONS FOR PAGES*************************************************************************** */

       /************************** Start Parent and Sub Menu **************************/

	
   function showParentPage(){
		$sql="SELECT id,Name,UrlCustom FROM erp_pages ORDER BY Name ASC";
		return $this->query($sql, 1);
	}
   
   function addSubMenu($arryDetails,$result,$lastShipId) {
   	    
		extract($arryDetails);
		$sql = "INSERT INTO  erp_sub_menu SET parent_id='" .$result. "', menu_name= '" .$_POST['Title']. "',menu_slug = '".$_POST['UrlCustom']."',pageId = '".$lastShipId."'";
		$this->query($sql, 0);
	}
	
	function updateParentPage($arryDetails,$pageid,$LstID) {
		@extract($arryDetails);
		$sql = "UPDATE  erp_sub_menu SET parent_id='" .$pageid. "', menu_name= '" .$_POST['Title']. "',pageId = '".$LstID."' WHERE menu_slug = '". $_POST['UrlCustom']."'";
		$this->query($sql, 0);
	}
	
    function showParentMenu($pageId){
		$sql="SELECT parent_id,menu_name,menu_slug FROM  erp_sub_menu WHERE pageId = '".$pageId."' ORDER BY parent_id ASC ";
		return $this->query($sql, 1);
	}
	
    function showParentIDPage(){
		$sql="SELECT id,Name,UrlCustom FROM erp_pages ORDER BY Name ASC";
		return $this->query($sql, 1);
	}
	
    function deleteMenuPage($id) {

		$sql = "DELETE from erp_sub_menu where pageId = '" . mysql_real_escape_string($id) . "'";
		$rs0 = $this->query($sql, 0);

		if (sizeof($rs0))
		return true;
		else
		return false;
	}

/************************** End Parent and Sub Menu **************************/

	function getErpTemplate(){		
	    	$sql = "SELECT * from erp_templates WHERE Status = '1' order by TemplateId asc";
		
		$results = $this->query($sql, 1);
		return $results;
		
	}

}

?>
