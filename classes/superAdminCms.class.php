<?php

class supercms extends dbClass
{


	function addPage($arryDetails) {
		@extract($arryDetails);

		$sql = "INSERT INTO  pages SET Name='" . mysql_real_escape_string(strip_tags($Name)) . "', Title = '" . mysql_real_escape_string(strip_tags($Title)) . "',Priority = '".mysql_real_escape_string(strip_tags($Priority))."',UrlCustom = '".mysql_real_escape_string(strip_tags($UrlCustom))."',UrlHash=MD5('".$UrlCustom."'),MetaKeywords='".mysql_real_escape_string(strip_tags($MetaKeywords))."',MetaTitle='".mysql_real_escape_string(strip_tags($MetaTitle))."',MetaDescription='".mysql_real_escape_string(strip_tags($MetaDescription))."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "',Content='".addslashes($page_content)."',template='".mysql_real_escape_string(strip_tags($template))."'";
		$this->query($sql, 0);
		return $this->lastInsertId();
	}

	function getPages() {
		global $Config;
		$addsql ='';
		if($Config['GetNumRecords']==1){
			$Columns = " count(id) as NumCount ";				
		}else{				
			$Columns = " * ";
			if($Config['RecordsPerPage']>0){
				$addsql .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
			
		}

		$sql = "SELECT ".$Columns." from pages  ORDER BY Name ASC ".$addsql;

		return $this->query($sql, 1);
	}

	function getPageById($id) {
		 $sql = "SELECT * from pages WHERE id = '" . mysql_real_escape_string($id) . "'";
		return $this->query($sql, 1);
	}

	function updatePage($arryDetails) {
		@extract($arryDetails);
		$sql = "UPDATE  pages SET Name='" . mysql_real_escape_string(strip_tags($Name)) . "', Title = '" . mysql_real_escape_string(strip_tags($Title)) . "',Priority = '".mysql_real_escape_string(strip_tags($Priority))."', UrlHash=MD5('".$UrlCustom."'),MetaKeywords='".mysql_real_escape_string(strip_tags($MetaKeywords))."',MetaTitle='".mysql_real_escape_string(strip_tags($MetaTitle))."',MetaDescription='".mysql_real_escape_string(strip_tags($MetaDescription))."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "',Content='".addslashes($page_content)."',template='".mysql_real_escape_string(strip_tags($template))."' WHERE id ='" . mysql_real_escape_string($id)."' ";
		$this->query($sql, 0);
	}

	function deletePage($id) {

		$sql = "DELETE from pages where id = '" . mysql_real_escape_string($id) . "'";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function changePageStatus($id) {
		$sql = "select * from pages where id = '" . mysql_real_escape_string($id) . "'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update pages set Status='" . mysql_real_escape_string(strip_tags($Status)) . "' where id = '" . mysql_real_escape_string($id) . "'";
			$this->query($sql, 0);
			return true;
		}
	}

	function getPagesforFront() {
		$sql = "SELECT * from pages WHERE Status = 'Yes' ORDER BY Priority ASC ";
		return $this->query($sql, 1);
	}

	function getPageIdByHash($urlhash) {
		$sql = "SELECT id FROM pages WHERE UrlHash='".$urlhash."'";
		return $this->query($sql, 1);
	}

	function getPageSlug(){
		$data=array();
		$sql="SELECT UrlCustom From pages";
		$slugp = $this->query($sql, 1);
		foreach($slugp as $slugs){
			$data[]=$slugs['UrlCustom'];
		}
		return $data;
	}

	function addSocialLink($arryDetails,$fileName) {
		@extract($arryDetails);
		$sql = "INSERT INTO  social_link SET Title = '".$Title."',Priority = '".$priority."',Status='" . $Status . "',URI='".$uri."',Icon='" . $fileName . "'";
		$this->query($sql, 0);
	}
	function updateSocialLink($arryDetails,$fileName) {
		@extract($arryDetails);
		if(!empty($fileName)){
			$sql = "UPDATE  social_link SET Title = '".$Title."',Priority = '".$priority."',URI='".$uri."',Icon='" . $fileName . "' WHERE id ='" . $id."'";
		}else{
			$sql = "UPDATE  social_link SET Title = '".$Title."',Priority = '".$priority."',URI='".$uri."' WHERE id ='" . $id."'";
			 
		}

		$this->query($sql, 0);
	}
	
	function getSocialLink() {
		$sql = "SELECT * from social_link  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}
	function getsocialLinkById($id) {
		$sql = "SELECT * from social_link WHERE id = '" . mysql_real_escape_string($id) . "' ";
		return $this->query($sql, 1);
	}

	function changeSocialStatus($id) {
		$sql = "select * from social_link where id = '" . mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update social_link set Status='" . $Status . "' where id = '" . mysql_real_escape_string($id) . "' ";
			$this->query($sql, 0);
			return true;
		}
	}

	function deleteSocialLink($id) {
		global $Config;
		$objFunction=new functions();
		if(!empty($id)){
			$strSQLQuery = "select Icon from social_link where id='".$id."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($arryRow[0]['Icon'] !='' ){				
				$objFunction->DeleteFileStorage($Config['SiteIconDir'],$arryRow[0]['Icon']);		
			}

			 
			$sql = "DELETE from social_link where id = '" . mysql_real_escape_string($id) . "' ";
			$rs = $this->query($sql, 0);
		}
		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function showPage(){
		$sql="SELECT id,Name FROM pages ORDER BY Name ASC";
		return $this->query($sql, 1);
	}

	function addMenu($arryDetails) {
		@extract($arryDetails);
		 $sql = "INSERT INTO  menu SET page_id='" .$page_id. "', type= '" .$type. "',slug = '".$slug."'";
		$this->query($sql, 0);
	}

	function showAllMenu(){
		$sql="SELECT * FROM menu GROUP BY slug";
		return $this->query($sql, 1);
	}

	function updateHeaderMenue($arryDetails) {
		@extract($arryDetails);
		 
		$sql = "UPDATE  menu SET page_id='" .$page_id. "', type= '" .$type. "',slug = '".$slug."' WHERE slug = '". mysql_real_escape_string($id)."'";
		$this->query($sql, 0);
	}

	function deleteHeaderMenu($id) {

		$sql = "DELETE FROM menu WHERE slug = '". mysql_real_escape_string($id)."' ";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function getHeaderMenyBySlug($id) {
		$sql = "SELECT * FROM menu WHERE slug = '". mysql_real_escape_string($id)."'";
		return $this->query($sql, 1);
	}

	function addBanner($arryDetails,$fileName) {
		@extract($arryDetails);
		$sql = "INSERT INTO  banner SET Title = '".$Title."',Priority = '".$Priority."',Status='" . $Status . "',Image='" . $fileName . "'";
		$this->query($sql, 0);
	}

	function getBanner() {
		$sql = "SELECT * FROM banner  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}

	function getBannerById($id) {
		$sql = "SELECT * FROM banner WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		return $this->query($sql, 1);
	}

	function deleteBanner($id) {
		global $Config;
		$objFunction=new functions();
		if(!empty($id)){
			$strSQLQuery = "select Image from banner where id='".$id."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($arryRow[0]['Image'] !='' ){				
				$objFunction->DeleteFileStorage($Config['BannerDir'],$arryRow[0]['Image']);		
			}

			 
			$sql = "DELETE from banner where id = '" . mysql_real_escape_string($id) . "' ";
			$rs = $this->query($sql, 0);
		}
		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function deleteOrderHistory($OrderID){
		$sql="DELETE FROM orders WHERE OrderID='".mysql_real_escape_string($OrderID)."'";
		$rs=$this->query($sql,0);
		if(sizeof($rs)){
			return true;
			
		}else{
			return false;
		}
	}

	function changeBannerStatus($id) {
		$sql = "select * from banner where id='" . $id."'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update banner set Status='" . $Status . "' where id = '" .  mysql_real_escape_string($id) . "' ";
			$this->query($sql, 0);
			return true;
		}
	}

	function updateBanner($arryDetails,$fileName) {
		@extract($arryDetails);
		if(!empty($fileName)){
			$sql = "UPDATE  banner SET Title = '".$Title."',Priority = '".$Priority."',Image='" . $fileName . "' WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		}else{
			$sql = "UPDATE  banner SET Title = '".$Title."',Priority = '".$Priority."' WHERE id = '" .  mysql_real_escape_string($id) . "' ";

		}

		$this->query($sql, 0);
	}
	
	 
	function getpackFeatureById($id) {
		$sql = "SELECT * FROM  package_feature WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		return $this->query($sql, 1);
	}
	
	function changePackFeature($id) {
		$sql = "SELECT * FROM package_feature WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "UPDATE package_feature SET Status='" . $Status . "' WHERE id = '" .  mysql_real_escape_string($id) . "' ";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function deletePackFeature($id) {

		$sql = "DELETE FROM package_feature WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}
	
	function addPackFeature($arryDetails) {
		@extract($arryDetails);
		 $sql = "INSERT INTO  package_feature SET feature='".$feature."',description= '".$description."', type= '".$type."',Status = '".$Status."'";
		$this->query($sql, 0);
	}
	
	function updatePackFeature($arryDetails) {
		@extract($arryDetails);		
	    $sql = "UPDATE package_feature SET  feature='" .$feature. " ',description= '".$description." ', type= '" .$type. "',Status = '".$Status."' WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$this->query($sql, 0);
	}
	function getPackFeatureList() {
		//$sql = "SELECT * FROM package_feature  ORDER BY ModuleID  ASC ";
		$sql = "SELECT * FROM package_feature  ORDER BY OrderBy  ASC ";
		return $this->query($sql, 1);
	}
	
	function addPkType($arryDetails,$str) {
		@extract($arryDetails);
		 echo $sql = "INSERT INTO  package_type SET name='".$name."',value= '".$str."',Status = '".$Status."'";
		$this->query($sql, 0);
	}
	
	function getPackTypeList() {
		$sql = "SELECT * FROM  package_type  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}
	
	
	function deletePackType($id){
		$sql="DELETE FROM package_type WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
		
	}
	
	function changePackType($id) {
		$sql = "SELECT * FROM package_type WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "UPDATE package_type SET Status='" . $Status . "' WHERE id = '" .  mysql_real_escape_string($id) . "' ";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function getpackTypeById($id) {
		$sql = "SELECT * FROM  package_type WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		return $this->query($sql, 1);
	}
	

	function updatePackType($arryDetails,$str,$id) {
		@extract($arryDetails);
		 echo $sql = "UPDATE package_type SET name='".$name."',value= '".$str."' WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$this->query($sql, 0);
	}
	
	
	function getCurrenct(){
		$sql="SELECT * FROM currencies";
		return $this->query($sql, 1);
	}
	
	
	function addPackages($arryDetails,$str) {
		@extract($arryDetails);
		$sql = "INSERT INTO  packages SET name='".$name."',price= '".$price."',currency='".$currency."',duration='".$duration."',package_type='".$package_type."',features='".$str."',Status = '".$Status."',allow_users='".$allow_users."',space='".$space."',additional_spaceprice='".$additional_spaceprice."',short_description='".$short_description."',edition_features='".$edition_features."',description='".$description."'";
		$this->query($sql, 0);
		
	}
		
	function getPackagesList() {
		$sql = "SELECT p.*,t.name as type FROM  packages p inner join  package_type t on p.package_type=t.id ORDER BY p.id DESC ";
		return $this->query($sql, 1);
	}
	
		
	function changePackstatus($id) {
		$sql = "SELECT * FROM packages WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "UPDATE packages SET Status='" . $Status . "' WHERE id = '" .  mysql_real_escape_string($id) . "' ";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function getpackageById($id) {
		$sql = "SELECT * FROM  packages WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		return $this->query($sql, 1);
	}

  function updatePackges($arryDetails,$str,$id) {
		//@extract($arryDetails);
		//$sql = "UPDATE packages SET name='".$name."',price= '".$price."',currency='".$currency."',duration='".$duration."',package_type='".$package_type."',features='".$str."',Status = 'Yes',allow_users='".$allow_users."',space='".$space."',additional_spaceprice='".$additional_spaceprice."',short_description='".$short_description."',edition_features='".$edition_features."',description='".$description."' WHERE id=" . $id;
		
	       $PlanDurationVal=implode(",",$arryDetails['PlanDuration']);
		@extract($arryDetails);
		$sql = "UPDATE packages SET price= '".$price."',currency='".$currency."',duration='".$duration."',package_type='".$package_type."',features='".$str."',Status = 'Yes',allow_users='".$allow_users."',space='".$space."',additional_spaceprice='".$additional_spaceprice."',short_description='".$short_description."',edition_features='".$edition_features."',description='".$description."' 
		
		,PlanDuration='".$PlanDurationVal."',allow_multisite='".addslashes($allow_multisite)."'
		
		WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$this->query($sql, 0);
	}
	
	
	function deletePack($id){
		$sql="DELETE FROM packages WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$res = $this->query($sql, 0);
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
		
	}
	
	function addCoupons($arryDetails) {
		@extract($arryDetails);
	    $sql = "INSERT INTO  coupons SET CouponCode = '".$CouponCode."',MinAmount='".$MinAmount."',Discount='".$Discount."',Percentage='".$Percentage."',Amount='".$Amount."',CouponType='".$CouponType."', Package='".$Package."',DiscountType='".$DiscountType."',User='".$User."',UseLimit='".$UseLimit."',ExpiryDate='".$ExpiryDate."',Status='" . $Status . "'";
		$this->query($sql, 0);
	}
	
	function changeCouponsStatus($id) {
		$sql = "select * from coupons where id = '" .  mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$sql = "update coupons set Status='" . $Status . "' where id = '" .  mysql_real_escape_string($id) . "' ";
			$this->query($sql, 0);
			return true;
		}
	}
	
	function deleteCoupons($id) {

		$sql = "DELETE from coupons where id = '" .  mysql_real_escape_string($id) . "' ";
		$rs = $this->query($sql, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}
	
	function updateCoupons($arryDetails,$id) {
	    @extract($arryDetails);
		//$sql = "UPDATE  coupons SET CouponCode = '".$CouponCode."',MinAmount='".$MinAmount."',Discount='".$Discount."',CouponType='".$CouponType."',ExpiryDate='".$ExpiryDate."',Status='" . $Status . "' WHERE id =" . $id;
		 $sql = "UPDATE  coupons SET CouponCode = '".$CouponCode."',MinAmount='".$MinAmount."',Discount='".$Discount."',Percentage='".$Percentage."',Amount='".$Amount."',CouponType='".$CouponType."', Package='".$Package."',DiscountType='".$DiscountType."',User='".$User."',UseLimit='".$UseLimit."',ExpiryDate='".$ExpiryDate."',Status='" . $Status . "' WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		$this->query($sql, 0);
	}
	
	
	function getCouponsById($id) {
		$sql = "SELECT * from coupons WHERE id = '" .  mysql_real_escape_string($id) . "' ";
		return $this->query($sql, 1);
	}
	function getCoupons() {
		$sql = "SELECT * from coupons  ORDER BY id DESC ";
		return $this->query($sql, 1);
	}
	
	
	function getPaymentHistory1() {
		$sql = "SELECT * FROM orders  ORDER BY OrderID DESC ";
		return $this->query($sql, 1);
	}
	
	function getPaymentHistory($SearchKey,$SortBy,$AscDesc,$mode){	
		global $Config;
	$strAddQuery = '';
	$SearchKey   = strtolower(trim($SearchKey));
	$strAddQuery .= "where 1 AND o.RsID='0'";

	if($mode=='Free'){
		$strAddQuery .= " AND o.OrderType='Free'";
	}else if($mode!=''){
		$strAddQuery .= " AND o.OrderType=''";
	}

	
	 if($SortBy != ''){
	
		if($SortBy=='c.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");
	
		$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
	}else{
	$strAddQuery .= (!empty($SearchKey))?(" and (c.CompanyName like '%".$SearchKey."%' or c.DisplayName like '%".$SearchKey."%'  or c.CmpID like '%".$SearchKey."%') " ):("");			}
	
	$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by o.OrderID ");
	$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" desc");
		
	if($Config['GetNumRecords']==1){
		$Columns = " count(o.OrderID) as NumCount ";				
	}else{				
		$Columns = " c.CmpID,
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
		o.customer_credit_card_type ";
		if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}
		
	}



	   $sql="SELECT ".$Columns." FROM orders o  LEFT OUTER JOIN company c ON o.CmpID=c.CmpID ".$strAddQuery."";
		
	   return $this->query($sql, 1);
	}

	
	
	
	
	function getOrderHistoryReller($SearchKey,$SortBy,$AscDesc){
		global $Config;
	$strAddQuery = '';
	$SearchKey   = strtolower(trim($SearchKey));
	$strAddQuery .= " where 1 AND o.RsID >'0'";
	
	 if($SortBy != ''){
	
		if($SortBy=='c.Status')	$AscDesc = ($AscDesc=="Asc")?("Desc"):("Asc");
	
		$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
	}else{
	$strAddQuery .= (!empty($SearchKey))?(" and (c.CompanyName like '%".$SearchKey."%' or r.FullName like '%".$SearchKey."%'  or c.DisplayName like '%".$SearchKey."%'  or c.CmpID like '%".$SearchKey."%') " ):("");			}
	
	$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by o.OrderID ");
	$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" desc");
		
	if($Config['GetNumRecords']==1){
		$Columns = " count(o.OrderID) as NumCount ";				
	}else{				
		$Columns = " c.CmpID,
		c.CompanyName,
		r.FullName as ResellerName,
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
		o.PaymentStatus,
		o.customer_credit_card_type  ";
		if($Config['RecordsPerPage']>0){
			$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
		}				
	}

	    $sql="SELECT ".$Columns." FROM orders o  LEFT OUTER JOIN company c ON o.CmpID=c.CmpID LEFT OUTER JOIN reseller r ON o.RsID=r.RsID ".$strAddQuery."";
		
	   return $this->query($sql, 1);
	}
	
	
	
	function changePaymentStatus($id) {
			$sql = "update orders set PaymentStatus='1' where OrderID  = '" .  mysql_real_escape_string($id) . "' ";
			$this->query($sql, 0);
			return true;
	
	}
	

	
	
	function getOrderHistoryByRsID($RsID){

	    $sql="SELECT c.CmpID,
		c.CompanyName,
		r.FullName as ResellerName,
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
		o.PaymentStatus,
		o.customer_credit_card_type FROM orders o  LEFT OUTER JOIN company c ON o.CmpID=c.CmpID LEFT OUTER JOIN reseller r ON o.RsID=r.RsID WHERE o.RsID='".$RsID."' order by o.OrderID desc";
		
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
	
 /************************** Start Parent and Sub Menu **************************/

	
   function showParentPage($id){
		$addsql = '';
		if($id>0) $addsql .= " where id not in (".$id.")";
		$sql="SELECT id,Name,UrlCustom FROM pages ".$addsql." ORDER BY Name ASC";
		 
		return $this->query($sql, 1);
	}
   
   function addSubMenu($arryDetails,$result,$lastShipId) {
   	    
		extract($arryDetails);
		$sql = "INSERT INTO  sub_menu SET parent_id='" .$result. "', menu_name= '" .$_POST['Title']. "',menu_slug = '".$_POST['UrlCustom']."',pageId = '".$lastShipId."'";
		$this->query($sql, 0);
	}
	
	function updateParentPage($arryDetails,$pageid,$LstID) {
		@extract($arryDetails);
		$sql = "UPDATE  sub_menu SET parent_id='" .$pageid. "', menu_name= '" .$_POST['Title']. "',pageId = '".$LstID."' WHERE menu_slug = '". $_POST['UrlCustom']."'";
		$this->query($sql, 0);
	}
	
    function showParentMenu($pageId){
		$sql="SELECT parent_id,menu_name,menu_slug FROM  sub_menu WHERE pageId = '".$pageId."' ORDER BY parent_id ASC ";
		return $this->query($sql, 1);
	}
	
    function showParentIDPage(){
		$sql="SELECT id,Name,UrlCustom FROM pages ORDER BY Name ASC";
		return $this->query($sql, 1);
	}
	
    function deleteMenuPage($id) {

		$sql = "DELETE from sub_menu where pageId = '" . mysql_real_escape_string($id) . "'";
		$rs0 = $this->query($sql, 0);

		if (sizeof($rs0))
		return true;
		else
		return false;
	}

/************************** End Parent and Sub Menu **************************/
/*********************************Testimonial**********************************/

        function getTestimonial() {
		global $Config;
		$strAddQuery = '';
		if($Config['GetNumRecords']==1){
			$Columns = " count(TestimonialID) as NumCount ";				
		}else{				
			$Columns = " * ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
		
		}

		 $sql = "SELECT ".$Columns." from testimonial  ORDER BY TestimonialID DESC ".$strAddQuery;
		return $this->query($sql, 1);
	}

    function changeTestimonialStatus($TestimonialID) {
		$sql = "select * from testimonial where TestimonialID = '" . mysql_real_escape_string($TestimonialID) . "'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == '1')
			$Status = '0';
			else
			$Status = '1';

			 $sql = "update testimonial set Status='" . mysql_real_escape_string(strip_tags($Status)) . "' where TestimonialID = '" . mysql_real_escape_string($TestimonialID) . "'";
			$this->query($sql, 0);
			return true;
		}
	}



	function deleteTestimonial($TestimonialID) {
		global $Config;
		$objFunction=new functions();
		if(!empty($TestimonialID)){
			$strSQLQuery = "select Image from testimonial where TestimonialID='".mysql_real_escape_string($TestimonialID)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($arryRow[0]['Image'] !='' ){				
				$objFunction->DeleteFileStorage($Config['TestimonialDir'],$arryRow[0]['Image']);		
			}

			 
			$sql = "DELETE from testimonial where TestimonialID = '" . mysql_real_escape_string($TestimonialID) . "' ";
			$rs = $this->query($sql, 0);
		}
		if (sizeof($rs))
		return true;
		else
		return false;
	}

    
        function updateTestimonial($arryDetails,$fileName) {
		@extract($arryDetails);

		if(!empty($fileName)){
	      $sql = "UPDATE  testimonial SET AuthorName = '". mysql_real_escape_string(strip_tags($AuthorName)) ."',Description = '". mysql_real_escape_string(strip_tags($Description)) ."',Image='".mysql_real_escape_string(strip_tags($fileName))."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "' WHERE TestimonialID = '" .  mysql_real_escape_string($TestimonialID) . "' ";
         }else{

             $sql = "UPDATE  testimonial SET AuthorName ='". mysql_real_escape_string(strip_tags($AuthorName)) ."',Description = '". mysql_real_escape_string(strip_tags($Description)) ."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "' WHERE TestimonialID = '" .  mysql_real_escape_string($TestimonialID) . "' ";
        }
		$this->query($sql, 0);
               
	}


       function addTestimonial($arryDetails,$fileName) {
		@extract($arryDetails);

		$sql = "INSERT INTO  testimonial SET AuthorName ='". mysql_real_escape_string(strip_tags($AuthorName)) ."', Description = '" . mysql_real_escape_string(strip_tags($Description)) . "',Image = '".mysql_real_escape_string(strip_tags($fileName))."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "'";
		$this->query($sql, 0);
		return $this->lastInsertId();
	}

	function getTestimonialById($TestimonialID) {
		 $sql = "SELECT * from testimonial WHERE TestimonialID = '" . mysql_real_escape_string($TestimonialID) . "'";
		return $this->query($sql, 1);
	}


       function vTestimonial($TestimonialID) {
		 $sql = "SELECT * from testimonial WHERE TestimonialID = '" . mysql_real_escape_string($TestimonialID) . "'";
		return $this->query($sql, 1);
	}

 /*******************End Testimonial*********************************/

	function getProject(){		
	    	$sql = "SELECT * from project WHERE Status = '1' ";
		
		$results = $this->query($sql, 1);
		return $results;
		
	}

	function getCrmTemplate(){		
	    	$sql = "SELECT * from crm_templates WHERE Status = '1' order by TemplateName asc";
		
		$results = $this->query($sql, 1);
		return $results;
		
	}

	/************************ Faq By Abid 24 Aug****************/
  function addFaq($arryDetails,$fileName) {
		@extract($arryDetails);

		$sql = "INSERT INTO  faq SET Title ='". mysql_real_escape_string(strip_tags($Title)) ."',MetaTitle='".mysql_real_escape_string(strip_tags($MetaTitle))."',MetaKeywords='".mysql_real_escape_string(strip_tags($MetaKeywords))."',MetaDescription='".mysql_real_escape_string(strip_tags($MetaDescription))."', Content = '" . addslashes($Content) . "',Image = '".mysql_real_escape_string(strip_tags($fileName))."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "'";
		$this->query($sql, 0);
		return $this->lastInsertId();
	}



            function updateFaq($arryDetails,$fileName) {
		@extract($arryDetails);

		if(!empty($fileName)){
	      		$addsql = " , Image='".mysql_real_escape_string(strip_tags($fileName))."' ";
         	} 

		$sql = "UPDATE  faq SET Title = '". mysql_real_escape_string(strip_tags($Title)) ."',MetaTitle='".mysql_real_escape_string(strip_tags($MetaTitle))."',MetaKeywords='".mysql_real_escape_string(strip_tags($MetaKeywords))."',MetaDescription='".mysql_real_escape_string(strip_tags($MetaDescription))."', Content = '". addslashes($Content) ."',Status='" . mysql_real_escape_string(strip_tags($Status)) . "' ".$addsql."  WHERE FaqID = '" .  mysql_real_escape_string($FaqID) . "' ";

		$this->query($sql, 0);
               
	}


       function deleteFaq($FaqID) {
		global $Config;
		$objFunction=new functions();
		if(!empty($FaqID)){
			$sql = "select Image from faq where FaqID='".mysql_real_escape_string($FaqID)."'"; 
			$arryFaq = $this->query($sql, 1);

			if($arryFaq[0]['Image'] !='' ){				
				$objFunction->DeleteFileStorage($Config['FaqDir'],$arryFaq[0]['Image']);		
			} 

			$sql = "DELETE from faq where FaqID = '" . mysql_real_escape_string($FaqID) . "'";
			$this->query($sql, 0);    
		}
		return 1;
	}


	 


          
              function changeFaqStatus($FaqID) {
		$sql = "select * from faq where FaqID = '" . mysql_real_escape_string($FaqID) . "'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == '1')
			$Status = '0';
			else
			$Status = '1';

			 $sql = "update faq set Status='" . mysql_real_escape_string(strip_tags($Status)) . "' where FaqID = '" . mysql_real_escape_string($FaqID) . "'";
			$this->query($sql, 0);
			return true;
		}
	}


              function getFaqById($FaqID) {
		 $sql = "SELECT * from faq WHERE FaqID = '" . mysql_real_escape_string($FaqID) . "'";
		return $this->query($sql, 1);
	}



             
	       function vFaq($FaqID) {
			 $sql = "SELECT * from faq WHERE FaqID = '" . mysql_real_escape_string($FaqID) . "'";
			return $this->query($sql, 1);
		}




              function getFaq() {
		global $Config;
		$strAddQuery = '';
		if($Config['GetNumRecords']==1){
			$Columns = " count(FaqID) as NumCount ";				
		}else{				
			$Columns = " * ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}
		
		}

		 $sql = "SELECT ".$Columns." from faq  ORDER BY Title asc ".$strAddQuery;
		return $this->query($sql, 1);
	}

/************* End Faq By Abid ***********/


}

?>
