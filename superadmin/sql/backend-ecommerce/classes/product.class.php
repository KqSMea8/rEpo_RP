<?php
class product extends dbClass
{
	//constructor
	function product()
	{
		$this->dbClass();
	}

	function  GetProducts($id=0,$CategoryID,$Status,$shortby,$Mfg)
	{

		$strSQLQuery = "select p1.*,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID";
		$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status):(" and p1.Status=1 and c1.Status=1 ");
		$strSQLQuery .= (!empty($id))?(" where p1.ProductID=".$id):(" where 1 ");
		$strSQLQuery .= (!empty($CategoryID))?(" and p1.CategoryID=".$CategoryID):("");
		$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid=".$Mfg):("");
		if($shortby == "name"){ $strSQLQuery .= "  order by p1.Name";}
		elseif($shortby == "new"){$strSQLQuery .= "  order by p1.ProductID DESC";}
		elseif($shortby == "hprice"){$strSQLQuery .= "  order by p1.Price DESC"; }
		elseif($shortby == "lprice") {$strSQLQuery .= "  order by p1.Price ASC";}
		else {$strSQLQuery .= "  order by p1.Name";}
		//echo $strSQLQuery; exit;
		return $this->query($strSQLQuery, 1);
	}

	function  GetProductById($id)
	{

		$strSQLQuery = "select p1.*,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID";
		$strSQLQuery .= (!empty($id))?(" where p1.ProductID=".$id):(" where 1 ");
		//echo $strSQLQuery; exit;
		return $this->query($strSQLQuery, 1);
	}
	function  GetProductEdit($id)
	{

		$strSQLQuery = "select p1.* from e_products p1 ";
		$strSQLQuery .= (!empty($id))?(" where p1.ProductID=".$id):(" where 1 ");
		//echo $strSQLQuery; exit;
		return $this->query($strSQLQuery, 1);
	}

	function getalllcategoryById($parent)
	{
		$query = "SELECT CategoryID,ParentID FROM `e_categories` WHERE `ParentID` = '".$parent."'";
		$result = mysql_query($query);
		$catIDs = '';
		while($values = mysql_fetch_array($result)) {

			$catIDs .= $values['CategoryID'].",";
				
			if($values['ParentID'] > 0)
			{
				$catIDs .= $this->getalllcategoryById($values['CategoryID']);
			}
		}
			
		return $catIDs;
	}


	function  GetProductsView($id=0,$CategoryID,$SearchKey,$SortBy,$AscDesc,$Status)
	{
		if(!empty($CategoryID)){
			$totalIds = $this->getalllcategoryById($CategoryID);
			$totalIds = rtrim($totalIds,",");
			$strLenIds = strlen($totalIds);
			if($strLenIds > 0)
			{
				$catId = $CategoryID.",".$totalIds;
			}else{

				$catId = $CategoryID;
			}
		}
		$strAddQuery = '';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" where p1.ProductID=".$id):(" where 1");
		$strAddQuery .= ($CategoryID>0)?(" and p1.CategoryID IN (".$catId.")"):("");
			
		$strAddQuery .= ($Status>0)?(" and p1.Status=".$Status." and m1.Status=1  "):("");
			
		if($SearchKey=='active' && ($SortBy=='p1.Status' || $SortBy=='') ){
			$strAddQuery .= " and p1.Status=1";
		}else if($SearchKey=='inactive' && ($SortBy=='p1.Status' || $SortBy=='') ){
			$strAddQuery .= " and p1.Status=0";
		}
		else if($SortBy=='p1.ProductSku'){
			$strAddQuery .= " and p1.ProductSku=".$SearchKey;
		}
		else if($SortBy=='p1.Featured'){
			$strAddQuery .= " and p1.Featured like '".$SearchKey."%'";
		}
		else if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (p1.Name like '".$SearchKey."%' or p1.ProductSku like '%".$SearchKey."%' or p1.AddedDate like '%".$SearchKey."%' or p1.Featured like '".$SearchKey."%') "):("");
		}
		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by p1.ProductID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
		 
		$strSQLQuery = "select p1.* from e_products p1 ".$strAddQuery;
		//echo $strSQLQuery;
		 
		return $this->query($strSQLQuery, 1);
			
	}



		

	function  AdvanceSearch($arryDetails)
	{
		 
		extract($arryDetails);
			
		if(!empty($price)){
			$arryPrice = explode('-',$price);
			$priceFrom = $arryPrice[0];
			$priceTo = $arryPrice[1];
		}



		//$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID left outer join e_manufacturers b1 on p1.Mid = b1.Mid where  p1.Status=1 and c1.Status=1 and b1.Status=1 ";
		$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID  where  p1.Status=1 and c1.Status=1 ";

		switch ($search_in)
		{
			case "id":
				{
					$strSQLQuery .= (!empty($search_str))?(" and ( p1.ProductSku LIKE '%".$search_str."%')"):("");
					break;
				}
			case "name" :
				{
					$strSQLQuery .= (!empty($search_str))?(" and ( p1.Name LIKE '%".$search_str."%')"):("");
					break;
				}
			default :
				{
					$strSQLQuery .= (!empty($search_str))?(" and ( p1.Name LIKE '%".$search_str."%' OR p1.ProductSku LIKE '%".$search_str."%' OR p1.Detail LIKE '%".$search_str."%')"):("");
					break;
				}
		}


		$strSQLQuery .= ($CategoryID>0)?(" and  (p1.CategoryID ='".$CategoryID."' or c1.CategoryID ='".$CategoryID."' or c1.ParentID = ".$CategoryID." )"):("");

		$strSQLQuery .= ($cat>0)?(" and  (p1.CategoryID ='".$cat."' or c1.CategoryID ='".$cat."' )"):("");

		if(!empty($priceFrom)) $strSQLQuery .= " and p1.Price >= ".$priceFrom." ";
		if(!empty($priceTo)) $strSQLQuery .= " and p1.Price <= ".$priceTo." ";

			

		$strSQLQuery .= (!empty($style))?(" and LCASE(p1.ProductStyle)='".strtolower(trim($style))."'"):("");

		$strSQLQuery .= (!empty($size))?(" and LCASE(p1.ProductSize) like '%".strtolower(trim($size))."%'"):("");
			
		$strSQLQuery .= (!empty($Recently))?(" and DATEDIFF('".date('Y-m-d')."',p1.ViewedDate)<=7 "):("");
			
			

		if($npr>0){
			$ProductPrices = '';
			for($i=1;$i<=$npr;$i++){
				if($_GET['pr'.$i]!=''){

					$arryPr = explode('-',$_GET['pr'.$i]);
					$priceFrom = $arryPr[0];
					$priceTo = $arryPr[1];

					if(!empty($priceFrom)) $ProductPrices .= " (p1.Price >= ".$priceFrom." ";
					if(!empty($priceTo)) $ProductPrices .= " and p1.Price <= ".$priceTo." ";

					$ProductPrices .= ") or ";
				}
			}
			$ProductPrices = rtrim($ProductPrices,"or ");

			$strSQLQuery .= (!empty($ProductPrices))?(" and (".$ProductPrices.")"):("");
		}
		$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid=".$Mfg):("");
		if($shortBy == "name"){ $strSQLQuery .= "  order by p1.Name";}
		elseif($shortBy == "new"){$strSQLQuery .= "  order by p1.ProductID DESC";}
		elseif($shortBy == "hprice"){$strSQLQuery .= "  order by p1.Price DESC"; }
		elseif($shortBy == "lprice") {$strSQLQuery .= "  order by p1.Price ASC";}
		else {$strSQLQuery .= "  order by p1.Name";}

		//echo $strSQLQuery; exit;

		return $this->query($strSQLQuery, 1);
	}

	function  GetPriceRange()
	{
		$strSQLQuery = 'select * from price_refine order by id asc';
		return $this->query($strSQLQuery, 1);
	}


	function  SimilarProducts($ProductID,$CategoryIDs,$Status)
	{
		$strSQLQuery = "select p1.* from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

		$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID ='".$CategoryIDs."' or c1.ParentID = '".$CategoryIDs."')"):(" where 1 ");

		$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

		$strSQLQuery .= ($ProductID>0)?(" and p1.ProductID !='".$ProductID."'"):("");

		$strSQLQuery .= ' order by p1.Name asc ';


		return $this->query($strSQLQuery, 1);
	}

	function  SearchProductsCat($id=0,$CategoryIDs,$Status,$key,$state_id,$PostedByID,$Bidding)
	{
		$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

		$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):(" where 1 ");

		$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

		$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

		$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%')"):("");

		$strSQLQuery .= ($state_id>0)?(" and m1.state_id=".$state_id):("");

		$strSQLQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

		$strSQLQuery .= ' order by p1.Name asc ';

		return $this->query($strSQLQuery, 1);
	}



	function  GetNameByParentID($id)
	{
		$strSQLQuery = "select c1.Name,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID where c1.CategoryID = '".$id."'";
		return $this->query($strSQLQuery, 1);
	}

	function  GetFeaturedProducts($settings)
	{
		$FeaturedProductsCount = $settings['FeaturedProductsCount'];

		$strSQLFeaturedQuery .= (" and p1.Featured='Yes'");

		$strSQLQuery = "select p1.* from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 ".$strSQLFeaturedQuery."   order by rand() Desc LIMIT 0,".$FeaturedProductsCount."";
		return $this->query($strSQLQuery, 1);
	}



	function checkProductSku($prductSku)
	{
		$strSQLQuery = "select * from e_products where LCASE(ProductSku) = '".strtolower(trim($prductSku))."'";
		return $this->query($strSQLQuery, 1);
	}

	function GetProductSku($prductId)
	{
		$strSQLQuery = "select ProductSku from e_products where ProductID = '".$prductId."'";
		$row = $this->query($strSQLQuery, 1);
		return $row[0]['ProductSku'];
	}


	function AddProduct($arryDetails)
	{

		extract($arryDetails);
		if($CategoryID > 0){
			$strUpdateQuery = "update e_categories set NumProducts = NumProducts + 1 where
			CategoryID = '".mysql_real_escape_string($CategoryID)."'";
			$this->query($strUpdateQuery, 0);
		}

		$Price1 =  $Price2>0?$Price2:$Price;
		$Price2 = $Price2>0?$Price:$Price2;

			

		$strSQLQuery = "insert into e_products (Name,ProductSku,CategoryID,Price ,Price2,Status, AddedDate,is_upld,label_txt,product_type,secure_type)
			values ('".addslashes($Name)."', '".addslashes($ProductSku)."','".$CategoryID."' , '".$Price1."','".$Price2."', '".$Status."','".date('Y-m-d')."', '".$is_upld."','".addslashes($label_txt)."','".addslashes($product_type)."','".addslashes($secure_type)."')";
			

		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();

		$strSQLQuery = "insert into e_products_categories (pid,cid) values ('".$lastInsertId."','".$CategoryID."')";
		$this->query($strSQLQuery, 0);
			
		//Update product sku if empty
		if(empty($ProductSku)){
			$ProductSku = 'sku000'.$lastInsertId;
			$strSQLQuery = "update e_products set ProductSku = '".$ProductSku."' where ProductID = '".$lastInsertId."'";
			$this->query($strSQLQuery, 0);
		}
			
		//end

		return $lastInsertId;
			
	}


	function changeProductStatus($ProductID)
	{
		$sql="select * from e_products where ProductID='".$ProductID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
			$Status=0;
			else
			$Status=1;
				
			$sql="update e_products set Status='".$Status."' where ProductID='".mysql_real_escape_string($ProductID)."'";
			$this->query($sql,0);

		}
			

		/*if($Status==1 && $rs[0]['Status']!=1 && $rs[0]['PostedByID']>1 ){
		 $this->ProductActiveEmail($ProductID);
			}*/

		return true;


	}

	function MultipleProductStatus($ProductIDs,$Status)
	{
		$sql="select * from e_products where ProductID in (".$ProductIDs.") and Status!=".$Status;
		$arryRow = $this->query($sql);
		if(sizeof($arryRow)>0)
		{

			$sql="update e_products set Status=".$Status." where ProductID in (".$ProductIDs.")";
			$this->query($sql,0);

		}
			
		return true;

	}


	function changeFeaturedStatus($ProductID)
	{
		$sql="select * from e_products where ProductID='".$ProductID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Featured']=='Yes')
			$Featured='No';
			else
			$Featured='Yes';
				
			$sql="update e_products set Featured='".$Featured."' where ProductID='".mysql_real_escape_string($ProductID)."'";
			$this->query($sql,0);
			return true;

		}
	}

	function UpdateViewedDate($ProductID)
	{
		global $Config;
		$sql="update e_products set ViewedDate='".$Config['TodayDate']."' where ProductID='".mysql_real_escape_string($ProductID)."'";
		$this->query($sql,0);
		return true;
	}




	function FeaturedDisabled($ProductIDs)
	{
			
		$sql="update e_products set Featured='No',FeaturedType='',Impression='0',ImpressionCount='0',  FeaturedStart='',FeaturedEnd=''   where ProductID in(".$ProductIDs.")";
		$this->query($sql,0);
		return true;

	}



	function UpdateImage($imageName,$ProductID)
	{
		$strSQLQuery = "update e_products set Image='".$imageName."' where ProductID='".mysql_real_escape_string($ProductID)."'";
		return $this->query($strSQLQuery, 0);
	}

	function UpdateVirtualFile($fileName,$ProductID)
	{
		$strSQLQuery = "update e_products set virtual_file='".$fileName."' where ProductID='".mysql_real_escape_string($ProductID)."'";
		return $this->query($strSQLQuery, 0);
	}

	function UpdateBasic($arryDetails)
	{

		extract($arryDetails);
			
		$Price1 =  $Price2>0?$Price2:$Price;
		$Price2 = $Price2>0?$Price:$Price2;

		if($imagedelete == "Yes")
		{
			$select=mysql_query("select Image from e_products where ProductID='".$ProductID."'");
			$image=mysql_fetch_array($select);
			$ImgDir = '../../upload/products/images/';
			unlink($ImgDir.$image['Image']);
			$strSQLQuery = "update e_products set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price1."', Price2='".$Price2."', Image='', Status='".$Status."',is_upld = '".$is_upld."',label_txt = '".addslashes($label_txt)."',product_type = '".addslashes($product_type)."',secure_type = '".addslashes($secure_type)."'  where ProductID='".mysql_real_escape_string($ProductID)."'";
			$this->query($strSQLQuery, 0);
		}
		else {
			$strSQLQuery = "update e_products set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price1."', Price2='".$Price2."', Status='".$Status."',is_upld = '".$is_upld."',label_txt = '".addslashes($label_txt)."',product_type = '".addslashes($product_type)."',secure_type = '".addslashes($secure_type)."'  where ProductID='".mysql_real_escape_string($ProductID)."'";
			$this->query($strSQLQuery, 0);
		}

		$strSQLQuery = "update  e_products_categories set pid='".$ProductID."',cid='".$CategoryID."'";
		$this->query($strSQLQuery, 0);

		//echo "=>".$strSQLQuery;exit;


		return 1;
	}

	function UpdateOther($arryDetails)
	{

		extract($arryDetails);

		$IsTaxable = isset($IsTaxable)?$IsTaxable:"No";
		$FreeShipping = isset($FreeShipping)?$FreeShipping:"No";

		$strSQLQuery = "update e_products set Mid='".$Mid."',Featured='".$Featured."', IsTaxable='".$IsTaxable."', Weight='".$Weight."', TaxClassId = '".$TaxClassId."', TaxRate = '".$TaxRate."', FreeShipping = '".$FreeShipping."',ShippingPrice='".$ShippingPrice."' where ProductID='".mysql_real_escape_string($ProductID)."'";

		$this->query($strSQLQuery, 0);

		return 1;
	}
	function UpdateDescription($arryDetails)
	{

		extract($arryDetails);
		$strSQLQuery = "update e_products set Detail='".addslashes($Detail)."',ShortDetail='".addslashes($ShortDetail)."' where ProductID='".mysql_real_escape_string($ProductID)."'";
		$this->query($strSQLQuery, 0);

		return 1;
	}

	function UpdateSeo($arryDetails)
	{
		extract($arryDetails);
		$strSQLQuery = "update e_products set MetaTitle='".addslashes($MetaTitle)."',MetaKeywords='".addslashes($MetaKeywords)."',MetaDescription = '".addslashes($MetaDescription)."',UrlCustom = '".$UrlCustom."'  where ProductID='".mysql_real_escape_string($ProductID)."'";

		$this->query($strSQLQuery, 0);

		return 1;
	}


	function UpdateInventory($arryDetails)
	{
		extract($arryDetails);
		$strSQLQuery = "update e_products set Quantity='".addslashes($Quantity)."',InventoryControl='".addslashes($InventoryControl)."',InventoryRule = '".$InventoryRule."',StockWarning = '".$StockWarning."' where ProductID='".mysql_real_escape_string($ProductID)."'";

		$this->query($strSQLQuery, 0);

		return 1;
	}

	function AddRecommendedProduct($arryDetails)
	{
		extract($arryDetails);
		$promo_products = $promo_products == "" ? array() : explode(",", $promo_products);

		$strSQLQuery =  "DELETE FROM e_recommended_products WHERE ProductID='".mysql_real_escape_string($ProductID)."'";
		$this->query($strSQLQuery, 0);

		foreach ($promo_products as $recommendID)
		{

			if ($recommendID != "")
			{
				$strSQLQuery = "INSERT INTO e_recommended_products SET ProductID = '".$ProductID."' , RecommendedProductID = '".$recommendID."'";
				$this->query($strSQLQuery, 1);
			}
		}


		return 1;
	}

	/*************************************Attribute Function Start******************************************************************/

	function parseOptions($options)
	{
		return explode("\n", $options);
	}


	function getProductIds($catIDs){

		$strSQLQuery = "select ProductID from e_products where CategoryID in (".$catIDs.")";

		$arraRow = $this->query($strSQLQuery, 1);

		return $arraRow;

	}

	function getAllProductIds(){

		$strSQLQuery = "select ProductID from e_products";
		$arraRow = $this->query($strSQLQuery, 1);

		return $arraRow;

	}

	function addGlobalAttribute($arryDetails)
	{
		extract($arryDetails);


		if(in_array('global',$select_products2)){
			$IsGlobal = 'Yes';
			$prductIds = $this->getAllProductIds();
		}else{

			$IsGlobal = 'No';
			foreach($select_products2 as $catID){

				$catIDs .= $catID.",";
			}
			$catIDs = rtrim($catIDs,",");

			$prductIds = $this->getProductIds($catIDs);
		}

		 

		$is_active = isset($is_active)?$is_active:"No";

		/*$parsed_options = explode("\n", $options);

		foreach ($parsed_options as $option)
		{
		if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
		{
		$is_modifier = true;
		}
		}*/
		$is_modifier = true;

		$is_modifierVal = isset($is_modifier) ? "Yes" : "No";

		$strSQLQuery = "Insert into e_global_attributes set AttributeType='".trim($attribute_type)."',IsGlobal='".$IsGlobal."', TextLength = '20', Status='".trim($is_active)."',Priority='".trim($priority)."',Name='".trim($attname)."',Caption='".trim($attname)."',required='".trim($required)."'";
		$this->query($strSQLQuery, 1);
		$lastInsertId = $this->lastInsertId();
		if($IsGlobal == "No")
		{
			foreach($select_products2 as $catID){

				$strSQLQuery = "Insert into e_catalog_attributes set Cid='".$catID."',Gaid='".$lastInsertId."'";
				$this->query($strSQLQuery, 0);
			}
		}


		if($update_mode == "rewrite"){
			foreach($prductIds as $productID){

				$ProductID = $productID['ProductID'];

				$strSQLQuery = "Insert into e_products_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='".$lastInsertId."', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";

				$this->query($strSQLQuery, 0);

				if($ProductID >0)
				{
					$attributes_countVal = 0;
					$sqlAttrVal= mysql_query("select AttributesCount from e_products where ProductID=".$ProductID);
					$attributes_countRow = mysql_fetch_array($sqlAttrVal);
					$attributes_countVal = $attributes_countRow['AttributesCount'];
					$attributes_countVal = $attributes_countVal+1;
					$strSQLQueryAttr = "update e_products set AttributesCount=".$attributes_countVal." where ProductID='".mysql_real_escape_string($ProductID)."'";
					$this->query($strSQLQueryAttr, 0);
				}
			}
		}
		 
		return $lastInsertId;

	}
	/************************OptionList********************/
	function AddGlobalAttOption($global_id,$arryDetails){
		global $Config;
		extract($arryDetails);
		for($i=1;$i<=$NumLine;$i++){
			if(!empty($arryDetails['title'.$i])){
				$sql = "insert into e_global_optionList(Gaid, title, Price, PriceType, Weight, SortOrder) values('".$global_id."', '".$arryDetails['title'.$i]."',  '".addslashes($arryDetails['Price'.$i])."', '".addslashes($arryDetails['PriceType'.$i])."', '".addslashes($arryDetails['Weight'.$i])."', '".addslashes($arryDetails['SortOrder'.$i])."')";
				$this->query($sql, 0);
			}
		}

	}
	function AddUpdateGlobalAttOption($global_id,$arryDetails){
		global $Config;
		extract($arryDetails);


		if(!empty($DelItem)){
			$strSQLQuery = "delete from e_global_optionList where id in(".$DelItem.")";
			$this->query($strSQLQuery, 0);
		}
		for($i=1;$i<=$NumLine;$i++){
			if(!empty($arryDetails['title'.$i])){
				$id = $arryDetails['id'.$i];

				if($id>0){
					$sql = "update e_global_optionList set  title='".addslashes($arryDetails['title'.$i])."',`Price`='".addslashes($arryDetails['Price'.$i])."', PriceType='".addslashes($arryDetails['PriceType'.$i])."', Weight='".addslashes($arryDetails['Weight'.$i])."', SortOrder='".addslashes($arryDetails['SortOrder'.$i])."' where id='".$id."'";

					$this->query($sql, 0);
				}else{	$sql = "insert into e_global_optionList(Gaid,paid, title, Price, PriceType, Weight, SortOrder) values('".$global_id."','".$PattID."' ,'".$arryDetails['title'.$i]."',  '".addslashes($arryDetails['Price'.$i])."', '".addslashes($arryDetails['PriceType'.$i])."', '".addslashes($arryDetails['Weight'.$i])."', '".addslashes($arryDetails['SortOrder'.$i])."')";
				$this->query($sql, 0);
				}
				#echo $sql; exit;
			}
		}

	}
	function  GetOptionList($global_id)
	{
		$strAddQuery .= (!empty($global_id))?(" and Gaid='".$global_id."'"):("");
		//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
		$strSQLQuery = "select * from e_global_optionList  where 1 ".$strAddQuery." order by id asc";
		return $this->query($strSQLQuery, 1);
	}
	function  GetProductOptionList($paid)
	{
		$strAddQuery .= (!empty($paid))?(" and paid='".$paid."'"):("");
		//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
		$strSQLQuery = "select * from e_global_optionList  where 1 ".$strAddQuery." order by id asc";
		return $this->query($strSQLQuery, 1);
	}
	/************************OptionList********************/

	function updateGlobalAttribute($arryDetails)
	{
		 
		extract($arryDetails);

		 
		$strSQLQuery = "delete from e_products_attributes where gaid='".mysql_real_escape_string($Gaid)."'";
		$this->query($strSQLQuery,0);
		$strSQLQuery = "delete from e_catalog_attributes where Gaid='".mysql_real_escape_string($Gaid)."'";
		$this->query($strSQLQuery,0);
		 
		if(in_array('global',$select_products2)){

			$IsGlobal = 'Yes';
			$prductIds = $this->getAllProductIds();
		}else{
			$IsGlobal = 'No';
			 
			foreach($select_products2 as $catID){

				$catIDs .= $catID.",";
			}
			$catIDs = rtrim($catIDs,",");

			$prductIds = $this->getProductIds($catIDs);
		}

		 

		$is_active = isset($is_active)?$is_active:"No";

		/* $parsed_options = explode("\n", $options);

		foreach ($parsed_options as $option)
		{
		if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
		{
		$is_modifier = true;
		}
		}
		*/
		$is_modifier = true;
		$is_modifierVal = isset($is_modifier) ? "Yes" : "No";
		 
		$strSQLQuery = "UPDATE e_global_attributes set AttributeType='".trim($attribute_type)."',IsGlobal='".$IsGlobal."', TextLength = '20', Status='".trim($is_active)."',Priority='".trim($priority)."',Name='".trim($attname)."',Caption='".trim($attname)."',required='".trim($required)."' WHERE Gaid = '".mysql_real_escape_string($Gaid)."'";
		$this->query($strSQLQuery, 0);
		 
		if($IsGlobal == "No")
		{
			foreach($select_products2 as $catID){
				 
				$strSQLQuery = "Insert into e_catalog_attributes set Cid='".$catID."',Gaid='".$Gaid."'";
				$this->query($strSQLQuery, 0);
			}
		}


		if($update_mode == "rewrite"){
			foreach($prductIds as $productID){

				$ProductID = $productID['ProductID'];

				$strSQLQuery = "Insert into e_products_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='".$Gaid."', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";
				$this->query($strSQLQuery, 0);

				if($ProductID >0)
				{
					$attributes_countVal = 0;
					$sqlAttrVal= mysql_query("select AttributesCount from e_products where ProductID=".$ProductID);
					$attributes_countRow = mysql_fetch_array($sqlAttrVal);
					$attributes_countVal = $attributes_countRow['AttributesCount'];
					$attributes_countVal = $attributes_countVal+1;
					$strSQLQueryAttr = "update e_products set AttributesCount=".$attributes_countVal." where ProductID='".mysql_real_escape_string($ProductID)."'";
					$this->query($strSQLQueryAttr, 0);
				}
			}
		}
		 
		return 1;


	}

	function getGlobalAttributes()
	{
		$strSQLQuery = "SELECT * FROM e_global_attributes ORDER BY Gaid DESC";
		return $this->query($strSQLQuery, 1);

	}

	function getGlobalAttributeById($attrID)
	{
		$strSQLQuery = "SELECT * FROM e_global_attributes WHERE Gaid = '".$attrID."'";
		return $this->query($strSQLQuery, 1);

	}

	function changeGlobalAttributeStatus($attrID)
	{

		$strSQLQuery = "select * from e_global_attributes where Gaid='".$attrID."'";
		$rs = $this->query($strSQLQuery);
		if(sizeof($rs))
		{
			if($rs[0]['Status'] == "Yes")
			$Status="No";
			else
			$Status="Yes";

			$strSQLQuery = "update e_global_attributes set Status='$Status' where Gaid='".mysql_real_escape_string($attrID)."'";
			$this->query($strSQLQuery,0);

		}
			
		return true;

	}

	function deleteGlobalAttribute($attrID)
	{
		$strSQLQuery = "delete from e_global_attributes where Gaid='".mysql_real_escape_string($attrID)."'";
		$this->query($strSQLQuery,0);
		$strSQLQuery = "delete from e_products_attributes where gaid='".mysql_real_escape_string($attrID)."'";
		$this->query($strSQLQuery,0);
		$strAttOptionQuery = "delete from e_global_optionList where Gaid='".mysql_real_escape_string($attrID)."'";
		$this->query($strAttOptionQuery,0);
		$strSQLQuery = "delete from e_catalog_attributes where Gaid='".mysql_real_escape_string($attrID)."'";
		$this->query($strSQLQuery,0);
	}
	 

	function InsertAttributes($arryDetails)
	{
			
		extract($arryDetails);
			
		$is_active = isset($is_active)?$is_active:"No";

		/* $parsed_options = explode("\n", $options);

		foreach ($parsed_options as $option)
		{
		if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
		{
		$is_modifier = true;
		}
		}*/
		$is_modifier = true;

		$is_modifierVal = isset($is_modifier) ? "Yes" : "No";
		 
		$strSQLQuery = "Insert into e_products_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";
		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();
		if($ProductID >0)
		{
			$attributes_countVal = 0;
			$sqlAttrVal= mysql_query("select AttributesCount from e_products where ProductID=".$ProductID);
			$attributes_countRow = mysql_fetch_array($sqlAttrVal);
			$attributes_countVal = $attributes_countRow['AttributesCount'];
			$attributes_countVal = $attributes_countVal+1;
			$strSQLQueryAttr = "update e_products set AttributesCount=".$attributes_countVal." where ProductID='".mysql_real_escape_string($ProductID)."'";
			$this->query($strSQLQueryAttr, 0);
		}
		return $lastInsertId;
	}


	function UpdateAttributes($arryDetails)
	{

		extract($arryDetails);
		$is_active = isset($is_active)?$is_active:"No";

		/*  $parsed_options = explode("\n", $options);

		foreach ($parsed_options as $option)
		{
		if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
		{
		$is_modifier = true;
		}
		}*/
		$is_modifier = true;

		$is_modifierVal = isset($is_modifier) ? "Yes" : "No";

		$strSQLQuery = "update e_products_attributes set attribute_type='".trim($attribute_type)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."' where paid = '".mysql_real_escape_string($AttributeId)."' and pid='".mysql_real_escape_string($ProductID)."'";
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function GetAttributeByID($attId)
	{

		$strSQLQuery = "select * from e_products_attributes where paid = '".$attId."'";
		return $this->query($strSQLQuery, 1);
	}
	function GetProductAttributes($ProductID)
	{

		$strSQLQuery = "Select * from e_products_attributes where pid='".$ProductID."'";
		return $this->query($strSQLQuery, 1);
	}

	function GetProductAttributesForFront($ProductID)
	{

		$strSQLQuery = "Select * from e_products_attributes where pid='".mysql_real_escape_string($ProductID)."' AND is_active='Yes' order by priority asc";
		return $this->query($strSQLQuery, 1);
	}
	 

	 

	function deleteAttribute($pid,$attributeId)
	{
		$strSQLQuery = "delete from e_products_attributes where paid='".mysql_real_escape_string($attributeId)."' and pid='".mysql_real_escape_string($pid)."'";
		$this->query($strSQLQuery, 0);

		$sqlAttrVal= mysql_query("select AttributesCount from e_products where ProductID='".mysql_real_escape_string($pid)."'");
		$attributes_countRow = mysql_fetch_array($sqlAttrVal);
		$attributes_countVal = $attributes_countRow['AttributesCount'];
		$attributes_countVal = $attributes_countVal-1;
		$strSQLQueryAttr = "update e_products set AttributesCount=".$attributes_countVal." where ProductID='".mysql_real_escape_string($pid)."'";
		$this->query($strSQLQueryAttr, 0);
		return 1;
	}

	/*************************************Attribute Function End******************************************************************/

	/*************************************Discount Function Start******************************************************************/
	function InsertDiscount($arryDetails)
	{

		extract($arryDetails);
		$is_active = isset($is_active)?$is_active:"No";
		$strSQLQuery = "Insert into e_products_quantity_discounts set range_min='".trim($range_min)."',range_max = '".$range_max."',pid='".trim($ProductID)."',is_active='".trim($is_active)."',discount='".trim($discount)."',discount_type='".trim($discount_type)."',customer_type='".trim($customer_type)."'";
		$this->query($strSQLQuery, 0);

		return 1;
	}

	function GetProductDiscount($ProductID)
	{

		$strSQLQuery = "Select * from e_products_quantity_discounts where pid='".mysql_real_escape_string($ProductID)."'";
		return $this->query($strSQLQuery, 1);
	}
	function GetDiscountByID($disID)
	{
		$strSQLQuery = "select * from e_products_quantity_discounts where qd_id = ".mysql_real_escape_string($disID)."'";
		return $this->query($strSQLQuery, 1);
	}
	function UpdateDiscount($arryDetails)
	{
		extract($arryDetails);
		$is_active = isset($is_active)?$is_active:"No";
		$strSQLQuery = "update e_products_quantity_discounts set range_min='".trim($range_min)."',range_max = '".$range_max."',is_active='".trim($is_active)."',discount='".trim($discount)."',discount_type='".trim($discount_type)."',customer_type='".trim($customer_type)."' where qd_id = '".mysql_real_escape_string($DiscountId)."' and pid=".mysql_real_escape_string($ProductID)."'";
		$this->query($strSQLQuery, 0);
		return 1;
	}
	function deleteDiscount($pid,$discId)
	{
		$strSQLQuery = "delete from e_products_quantity_discounts where qd_id='".mysql_real_escape_string($discId)."' and pid = '".mysql_real_escape_string($pid)."'";
		$this->query($strSQLQuery, 0);
		return 1;
	}
	 

	/*************************************Discount Function End******************************************************************/



	/*************************************Alternatative Images Function Start******************************************************************/

	function AddAlternativeImage($ProductID)
	{

		$strSQLQuery ="select ProductID from e_products_images where ProductID='".mysql_real_escape_string($ProductID)."'";

		$arryRow = $this->query($strSQLQuery, 1);
		if (empty($arryRow[0]['ProductID'])) {

			$strSQLQuery = "insert into e_products_images(ProductID) values ('".$ProductID."')";
			$this->query($strSQLQuery, 0);

		}

		return 1;

	}


	function UpdateAlternativeImage($imageId,$imageName,$alt_text)
	{
			
		$strSQLQuery = "INSERT INTO e_products_images set  ProductID='".$imageId."', Image='".$imageName."', alt_text='".$alt_text."'";
		return $this->query($strSQLQuery, 0);
	}

	function GetTotalImagesCount($ProductID)
	{

		$strSQLQuery = mysql_query("SELECT count( Iid ) as total FROM `e_products_images` WHERE `ProductID` ='".$ProductID."'");
		$exequery = mysql_fetch_array($strSQLQuery);
		return $exequery['total'];
	}

	function GetAlternativeImage($ProductID)
	{

		$strSQLQuery = "Select * from e_products_images where ProductID='".mysql_real_escape_string($ProductID)."'";
		return $this->query($strSQLQuery, 1);
	}





	function deleteImage($pid,$imageId)
	{
		$objConfigure=new configure();
		$select=mysql_query("select Image from e_products_images where Iid = '".mysql_real_escape_string($imageId)."' and ProductID='".mysql_real_escape_string($pid)."'");
		$image=mysql_fetch_array($select);
		$ImgDir = '../../upload/products/images/secondary/'.$_SESSION['CmpID'].'/';
		$objConfigure->UpdateStorage($ImgDir.$image['Image'],0,1);

		unlink($ImgDir.$image['Image']);
		$strSQLQuery = "delete from e_products_images where Iid = '".mysql_real_escape_string($imageId)."' and ProductID='".mysql_real_escape_string($pid)."'";
		$this->query($strSQLQuery, 0);
		return 1;
	}
	 
	/*************************************Alternatative Images Function Start******************************************************************/
	function RemoveProduct($id,$CategoryID,$Front)
	{
		$objConfigure=new configure();
		$strSQLQuery = "select Image from e_products where ProductID='".mysql_real_escape_string($id)."'";
		$arryRow = $this->query($strSQLQuery, 1);
			
		$sql = "select * from e_products_images where ProductID='".mysql_real_escape_string($id)."'";
		$arry = $this->query($sql, 1);


			
		$ImgDir = '../../upload/products/images/'.$_SESSION['CmpID'].'/';
		$ImgSecondryDir = '../../upload/products/images/secondary/'.$_SESSION['CmpID'].'/';
			
		for($i=0;$i<sizeof($arry);$i++) {
			if($arry[$i]['Image'] !='' && file_exists($ImgSecondryDir.$arry[$i]['Image']) ){			  $objConfigure->UpdateStorage($ImgSecondryDir.$arry[$i]['Image'],0,1);
			unlink($ImgSecondryDir.$arry[$i]['Image']);
			}
		}


		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){
			$objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);
			unlink($ImgDir.$arryRow[0]['Image']);
		}


		$strSQLQuery = "delete from e_products where ProductID='".mysql_real_escape_string($id)."'";
		$this->query($strSQLQuery, 0);

		$strSQLQuery = "delete from e_products_images where ProductID='".mysql_real_escape_string($id)."'";
		$this->query($strSQLQuery, 0);

		$strSQLQuery = "delete from e_products_categories where pid='".mysql_real_escape_string($id)."'";
		$this->query($strSQLQuery, 0);

			

		/*if($CategoryID > 0){
		 $strSQLQuery ="select NumProducts from e_categories where CategoryID=".$CategoryID;
		 $arryRow = $this->query($strSQLQuery, 1);
		 if (!empty($arryRow[0]['NumProducts'])) {
		 $strUpdateQuery = "update e_categories set NumProducts = NumProducts - 1 where CategoryID = ".$CategoryID;
		 $this->query($strUpdateQuery, 0);
		 }
			}*/
		return 1;
	}


	function RemoveMultipleProduct($ids,$Front)
	{
		$objConfigure=new configure();

		$strSQLQuery = "select Image,ProductID,CategoryID from e_products where ProductID in (".$ids.")";
		$arryRow = $this->query($strSQLQuery, 1);

		$strSQLQuery = "delete from e_products where ProductID in (".$ids.")";
		$this->query($strSQLQuery, 0);

		$AliasSQLQuery = "delete from e_item_alias where ProductID in (".$ids.")";
		$this->query($AliasSQLQuery, 0);
			
		$ImgDir = '../../upload/products/images/'.$_SESSION['CmpID'].'/';
		$ImgSecondryDir = '../../upload/products/images/secondary/'.$_SESSION['CmpID'].'/';
			
		for($i=0;$i<sizeof($arryRow);$i++) {

			 
			if($arryRow[$i]['Image'] !='' && file_exists($ImgDir.$arryRow[$i]['Image']) ){
				$objConfigure->UpdateStorage($ImgDir.$arryRow[$i]['Image'],0,1);
				unlink($ImgDir.$arryRow[$i]['Image']);
			}


			$sql = "select * from e_products_images where ProductID='".mysql_real_escape_string($arryRow[$i]['ProductID'])."'";
			$arry = $this->query($sql, 1);

			for($j=0;$j<sizeof($arry);$j++) {
				if($arry[$j]['Image'] !='' && file_exists($ImgSecondryDir.$arry[$j]['Image']) ){
					$objConfigure->UpdateStorage($ImgSecondryDir.$arry[$j]['Image'],0,1);

					unlink($ImgSecondryDir.$arry[$j]['Image']);
				}
			}


			if($arryRow[$i]['CategoryID'] > 0){
				$strSQLQuery ="select NumProducts from e_categories where CategoryID='".$arryRow[$i]['CategoryID']."'";
				$arryRow2 = $this->query($strSQLQuery, 1);
				if (!empty($arryRow2[$i]['NumProducts'])) {
					$strUpdateQuery = "update e_categories set NumProducts = NumProducts - 1 where CategoryID = '".$arryRow[$i]['CategoryID']."'";
					$this->query($strUpdateQuery, 0);
				}
			}


		}

		return 1;

	}


	function isProductExists($Name,$ProductID=0,$CategoryID)
	{

		$strSQLQuery ="select ProductID from e_products where LCASE(Name)='".strtolower(trim($Name))."'";

		$strSQLQuery .= ($ProductID>0)?(" and ProductID != '".$ProductID."'"):("");
		//$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID = ".$CategoryID):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ProductID'])) {
			return true;
		} else {
			return false;
		}
	}


	function isProductNumberExists($ProductSku,$ProductID=0)
	{

		$strSQLQuery ="select ProductID from e_products where LCASE(ProductSku)='".strtolower(trim($ProductSku))."'";
			
		$strSQLQuery .= ($ProductID>0)?(" and ProductID != '".$ProductID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ProductID'])) {
			return true;
		} else {
			return false;
		}
	}




	function IsActivatedProduct($ProductID)
	{
		$strSQLQuery = "select * from e_products where ProductID='".mysql_real_escape_string($ProductID)."'";
		$arryRow = $this->query($strSQLQuery, 1);
		if ($arryRow[0]['ProductID']>0) {
			return 1;
		} else {
			return 0;
		}
	}





	/*****************Product Wishlist Functions Started************/


	function checkWishlistName($cid,$name)
	{

		$SqlCustomer = "SELECT * FROM e_users_wishlist WHERE Name='".trim($name)."'  AND   Cid='".$cid."'";
		return $this->query($SqlCustomer, 1);
	}

	function addWishlist($arryDetails,$oa_attributes)
	{

		extract($arryDetails);
		global $Config;
		$SqlCustomer = "SELECT * FROM e_users_wishlist WHERE Name='".trim($Name)."'  AND   Cid='".$WhishlistCid."'";
		$arrayRows = $this->query($SqlCustomer, 1);

		if(empty($arrayRows[0]['Wlid']))
		{
			$SqlCustomer = "INSERT INTO e_users_wishlist SET Name='".trim($Name)."', Cid='".$WhishlistCid."' , CreateDate = '".$Config['TodayDate']."', UpdateDate = '".$Config['TodayDate']."'";
			$this->query($SqlCustomer, 1);
			$lastInsertId = $this->lastInsertId();
			 
			if (count($oa_attributes)>0)
			{
				foreach ($oa_attributes as $key=>$val)
				{
					$sql = mysql_query("SELECT name, options FROM e_products_attributes WHERE pid= '".$WhislistProductId."' AND paid = '".$key."'");

					while ($rowReuslt = mysql_fetch_array($sql))
					{
						if ($rowReuslt["options"] != "")
						{
							$options = $rowReuslt["options"];
							$options_array = explode("\n", $options);
							for ($i=0; $i<count($options_array); $i++)
							{
								$option = trim($options_array[$i]);
								if ($option != "")
								{
									$option_parts = array();
									$option_parts = explode("(", $option);
									$option_name = trim($option_parts[0]);
									$option_partsVal = explode("(", $val);
									$option_nameVal = trim($option_partsVal[0]);

									if ($option_name ==  $option_nameVal)
									{
										$wl_att[$key]=$rowReuslt["name"]." : ".$option_name;
									}
								}
							}
						}
						else
						{
							$wl_att[$key]=$rowReuslt["name"]." : ".$val;
						}
					}
				}
			}

			if(count($wl_att)>0){
				$attribute_id = "";
				$options = "";
				foreach($wl_att as $att_id=>$val){
					$attribute_id .= (strlen($attribute_id)>0?",":"").$att_id;
					$options .= (strlen($options)>0?"\n":"").$val;
				}


			}
			 

			$SqlCustomer = "INSERT INTO e_users_wishlist_products SET Wlid='".$lastInsertId."', ProductId='".$WhislistProductId."' , AttributeId = '".$attribute_id."', options = '".$options."'";
			return $this->query($SqlCustomer, 1);
		}
	}

	function getWishlist($cid)
	{

		$SqlCustomer = "SELECT * FROM e_users_wishlist WHERE Cid='".mysql_real_escape_string($cid)."' ORDER BY Wlid DESC";
		return $this->query($SqlCustomer, 1);
	}

	function addProductWishlist($arryDetails,$oa_attributes)
	{
		extract($arryDetails);
		 
		 
		 
		if (count($oa_attributes)>0)
		{
			foreach ($oa_attributes as $key=>$val)
			{
				$sql = mysql_query("SELECT name, options FROM e_products_attributes WHERE pid= '".$WhislistProductId."' AND paid = '".$key."'");

				while ($rowReuslt = mysql_fetch_array($sql))
				{
					if ($rowReuslt["options"] != "")
					{
						$options = $rowReuslt["options"];
						$options_array = explode("\n", $options);
						for ($i=0; $i<count($options_array); $i++)
						{
							$option = trim($options_array[$i]);
							if ($option != "")
							{
								$option_parts = array();
								$option_parts = explode("(", $option);
								$option_name = trim($option_parts[0]);
								$option_partsVal = explode("(", $val);
								$option_nameVal = trim($option_partsVal[0]);

								if ($option_name ==  $option_nameVal)
								{
									$wl_att[$key]=$rowReuslt["name"]." : ".$option_name;
								}
							}
						}
					}
					else
					{
						$wl_att[$key]=$rowReuslt["name"]." : ".$val;
					}
				}
			}
		}

		if(count($wl_att)>0){
			$attribute_id = "";
			$options = "";
			foreach($wl_att as $att_id=>$val){
				$attribute_id .= (strlen($attribute_id)>0?",":"").$att_id;
				$options .= (strlen($options)>0?"\n":"").$val;
			}


		}
		 

		$SqlCustomer = "INSERT INTO e_users_wishlist_products SET Wlid='".trim($Wlid)."', ProductId='".$WhislistProductId."' , AttributeId = '".$attribute_id."', options = '".$options."'";
		return $this->query($SqlCustomer, 1);

	}

	function checkWishlistProduct($Wlid,$Productid)
	{
		$SqlCustomer = "SELECT * FROM e_users_wishlist_products WHERE Wlid='".$Wlid."' AND ProductId = '".$Productid."'";
		return $this->query($SqlCustomer, 1);
	}


	 
	function getWishlistProduct($wlpid){
		$wl_product = array();
		$strSQLQuery = "SELECT *, e_products.ProductID FROM e_users_wishlist_products
				INNER JOIN e_products ON e_products.ProductID = e_users_wishlist_products.ProductId
				WHERE Wlpid='".$wlpid."'";
		$arryRow = $this->query($strSQLQuery, 1);
		if($arryRow){
			$wl_product = $arryRow[0];
			$product_attributes =array();
			if(strlen(trim($wl_product["Options"]))>0){
				$attribute_options= explode("\n", $wl_product["Options"]);
				$attribute_id= explode(",", $wl_product["AttributeId"]);
				foreach ($attribute_id as $key=>$val) {
					$att_opts = explode(":", $attribute_options[$key]);
					$product_attributes[$val] =trim($att_opts[1]);
				}
			}
			$wl_product["product_attributes"] = $product_attributes;

			//echo "<pre>";
			// print_r($wl_product);exit;

			return($wl_product);
		}
		return false;
	}

	function  GetProductByWishListId($Cid,$WishID)
	{

		$strSQLQuery = "SELECT Wlid, Name FROM e_users_wishlist WHERE Wlid='".mysql_real_escape_string($WishID)."'";
		$arryRow = $this->query($strSQLQuery, 1);
		if($arryRow){
			$wl_data = $arryRow;
			$strSQLQuery = "SELECT * FROM e_users_wishlist_products WHERE Wlid='".mysql_real_escape_string($WishID)."'";
			$wish_list_products = $this->query($strSQLQuery, 1);
			//echo "<pre>";
			//print_r($wish_list_products);
			$wl_products = array();

			if(count($wish_list_products)>0){
				foreach($wish_list_products as $wl_product=>$valProduct){
					$strSQLQuery= "SELECT ProductID, ProductSku, CategoryID, Name, Price,Image FROM e_products WHERE ProductID ='".$valProduct["ProductId"]."'";
					$productsList = $this->query($strSQLQuery, 1);
					if($productsList){
						$product = $productsList[0];
						$product["attributes"] = "";

						if(strlen(trim($valProduct["Options"]))> 0){
							$attribute_options= explode("\n", $valProduct["Options"]);

							$selected_att = array();
							foreach($attribute_options as $att=>$val){
								$product["attributes"] .= (strlen($product["attributes"])>0?"<br />":"").$val;
								$att_val = explode(":", $val);
								$selected_att[$att] = $att_val[1];
							}
						}
						$product["Wlpid"]= $valProduct["Wlpid"];
						$wl_products[]= $product;
					}
				}
			}
			$list= array(
					"Wlid" => $wl_data[0]["Wlid"],
					"Name" => $wl_data[0]["Name"],
					"whishlist_products" => $wl_products,
			);

		}

		//echo "<pre>";
		// print_r($list);

		return ($list);



	}

	function RemoveWishList($WishID,$Cid)
	{
		$strSQLQuery = "DELETE FROM e_users_wishlist where Wlid='".mysql_real_escape_string($WishID)."' AND Cid = '".mysql_real_escape_string($Cid)."'";
		//echo "=>".$strSQLQuery;exit;
		$this->query($strSQLQuery, 0);
		$strSQLQuery = "DELETE FROM e_users_wishlist_products where Wlid=".$WishID."";
		$this->query($strSQLQuery, 0);
	}


	function RemoveWishListProduct($Wlpid,$WishID)
	{

		$strSQLQuery = "DELETE FROM e_users_wishlist_products WHERE Wlpid = '".mysql_real_escape_string($Wlpid)."' AND  Wlid='".mysql_real_escape_string($WishID)."'";
		$this->query($strSQLQuery, 0);
	}

	function  UpdateWishList($arryDetails)
	{

		extract($arryDetails);
		global $Config;
		$SqlCustomer = "UPDATE e_users_wishlist SET Name='".trim($Name)."', UpdateDate = '".$Config['TodayDate']."' WHERE Wlid = '".mysql_real_escape_string($Wlid)."'";
		$this->query($SqlCustomer, 0);
	}

	 
	function EmailWishlist($Cid, $wishlist)
	{
		global $Config;
		$htmlPrefix = $Config['EmailTemplateFolder'];


		$strSQLQuery = "SELECT FirstName, LastName,Email FROM e_customers  WHERE Cid='".$Cid."'";
		$arryRow = $this->query($strSQLQuery, 1);
		 
		if (!empty($arryRow[0]["Email"]))
		{
			$FirstName = $arryRow[0]["FirstName"];
			$LastName = $arryRow[0]["LastName"];
			$your_email = $arryRow[0]["Email"];
			$EmailTitle = $mail_subject;
			 
			$WishlistProductHtml ="<table width=700px cellpadding=0 cellspacing=0 style='border:1px solid #ddd'>
                                    <tr>
                                    <td width=15%  style='border-bottom:1px solid #ddd';><b>Product Image</b></td>
                                    <td width=40%  style='border-bottom:1px solid #ddd';><b>Product Description</b></td>
                                    <td width=15% style='border-bottom:1px solid #ddd';><b>Product Price</b></td>
                                    </tr>";
			 
			$StoreUrl = $Config['homeCompleteUrl'].'';

			foreach ($wishlist['whishlist_products'] as $key => $wishlistproduct)
			{
				$ImagePath = $Config['Url']."resizeimage.php?img=upload/products/images/".$wishlistproduct['Image'].'&w=150&h=100';

				$WishlistProductHtml .= "<tr valign=top>
                                    <td style=border-bottom:1px solid #ddd;>";
				if(!empty($wishlistproduct['Image'])){
					$WishlistProductHtml .="<img src=".$ImagePath." title=".ucfirst(stripslashes($wishlistproduct['Image']))." />";
				}
				else
				{
					 
					$WishlistProductHtml .="<img src='./../images/no.jpg' title=".ucfirst(stripslashes($wishlistproduct['Image']))." />";
					 
				}
				$WishlistProductHtml .= "</td>
                                    <td style=border-bottom:1px solid #ddd;padding-bottom:7px;>
                                    <a href=".$StoreUrl."/productDetails.php?id=".$wishlistproduct['ProductID'].">".$wishlistproduct['Name']." </a>  <br />".$wishlistproduct['attributes']."</td>
                                    <td style=border-bottom:1px solid #ddd;>&nbsp;".display_price($wishlistproduct['Price'],"","",$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])."</td>
                                    </tr>";
			}
			$WishlistProductHtml .= "</table>";

			$contents = file_get_contents($htmlPrefix."wishlistEmail.htm");
			$FullName = ucfirst($FirstName)." ".ucfirst($LastName);
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['StoreName'],$contents);
			$contents = str_replace("[FirstName]",ucfirst($FirstName),$contents);
			$contents = str_replace("[LastName]",ucfirst($LastName),$contents);

			$contents = str_replace("[WISHLIST_PRODUCT]",$WishlistProductHtml,$contents);

			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[DATE]",date("jS, F Y"),$contents);
			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($your_email);
			$mail->sender($Config['StoreName']." - ", $Config['NotificationEmail']);
			$mail->Subject = 'Your Wishlist - '.$wishlist['Name'];
			$mail->IsHTML(true);
			$mail->Body = $contents;

			//echo $Email.$Config['AdminEmail'].$contents; exit;

			if($Config['Online'] == '1'){
				$mail->Send();
			}

			 
		}
		else
		{
			echo "Failed";
		}
	}



	/****************************End Product Wihlist Functions***********************************************************************************************/




	function AddProductReview($arryDetails)
	{
		extract($arryDetails);
		global $Config;
		$strSQLQuery = "INSERT INTO e_products_reviews SET Pid='".$ReviewProductID."',Cid = '".$ReviewCustId."',ReviewTitle='".  addslashes($ReviewTitle)."',ReviewText='".addslashes($ReviewText)."',Status = 'No',Rating='".$Rating."',DateCreated='".$Config['TodayDate']."'";
		//echo $strSQLQuery;exit;
		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;
	}

	function getReviews($id=0,$Status,$SearchKey,$SortBy,$AscDesc) {


		$strAddQuery = '';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" where pr.ReviewId=".$id):(" where 1");
			
		$strAddQuery .= ($Status>0)?(" and pr.Status=".$Status.""):("");
			
		if($SearchKey=='active' && ($SortBy=='pr.Status' || $SortBy=='') ){
			$strAddQuery .= " and pr.Status='Yes'";
		}else if($SearchKey=='inactive' && ($SortBy=='pr.Status' || $SortBy=='') ){
			$strAddQuery .= " and pr.Status='No'";
		}else if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (pr.ReviewTitle like '".$SearchKey."%' or p.ProductSku like '%".$SearchKey."%' or c.Email like '%".$SearchKey."%') "):("");
		}
		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by pr.ReviewId ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");

		$strSQLQuery = "SELECT pr.*,p.Name,p.ProductSku,c.email,c.Cid FROM e_products_reviews AS pr JOIN e_products AS p ON p.ProductID = pr.Pid JOIN e_customers AS c ON c.Cid = pr.Cid ".$strAddQuery."";
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function getReviewsByProduct($pid) {

		$where = "WHERE pr.Status = 'Yes' AND p.ProductID = '".$pid."'";
		$strSQLQuery = "SELECT pr.*,p.Name,p.ProductSku,c.email,c.Cid,c.FirstName FROM e_products_reviews AS pr JOIN e_products AS p ON p.ProductID = pr.Pid JOIN e_customers AS c ON c.Cid = pr.Cid ".$where." Order By ReviewId Desc";
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function countProductRating($pid) {

		$where = "WHERE Status = 'Yes' AND Pid = '".$pid."'";
		$strSQLQuery = "SELECT SUM(Rating) as total FROM e_products_reviews ".$where."";
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}


	function deleteReview($id) {

		$strSQLQuery = "DELETE FROM e_products_reviews WHERE ReviewId = '".mysql_real_escape_string($id)."'";
		$rs = $this->query($strSQLQuery, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function changeReviewStatus($id) {
		$strSQLQuery = "SELECT * FROM e_products_reviews WHERE ReviewId='".mysql_real_escape_string($id)."'";
		$rs = $this->query($strSQLQuery);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$strSQLQuery = "UPDATE e_products_reviews SET Status='" . $Status . "' WHERE ReviewId='".mysql_real_escape_string($id)."'";
			$this->query($strSQLQuery, 0);
			return true;
		}
	}
	 
	function getRecommendedByProduct($pid) {


		$strSQLQuery = "SELECT  p.ProductID, p.ProductSku, p.Name,p.Price,p.Price2,p.Image FROM e_recommended_products rp INNER JOIN e_products p ON p.ProductID = rp.RecommendedProductID
									WHERE rp.ProductID='".mysql_real_escape_string($pid)."'";
		 
		return $this->query($strSQLQuery, 1);
	}


	function getDiscountByProduct($id)
	{
		$where = "WHERE is_active = 'Yes' AND pid = '".mysql_real_escape_string($id)."'";
		$strSQLQuery = "SELECT * FROM `e_products_quantity_discounts` ".$where."";
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function getItemsBestSellers($settings)
	{
		$bestsellersCount = 0;
		$BestsellersPeriod = $settings['BestsellersPeriod'];

		if($settings['BestsellersAvailable'] == "Yes")
		{

			//choose term
			switch($BestsellersPeriod)
			{
				case "Year" : $period = "1 YEAR"; break;
				case "6 Months" : $period = "6 MONTH"; break;
				case "3 Months" : $period = "3 MONTH"; break;
				case "2 Months" : $period = "2 MONTH"; break;
				default:
				case "Month": $period = "1 MONTH"; break;
			}

			$bestsellersCount =  $settings['BestsellersCount'];


			$strSQLQuery =  "SELECT e_orderdetail . *, SUM(e_orderdetail.Quantity) AS product_quantity,e_products.Image FROM e_orderdetail INNER JOIN e_orders ON e_orders.OrderID = e_orderdetail.OrderID INNER JOIN e_products ON e_products.ProductID = e_orderdetail.ProductID
                                         WHERE e_products.Status = '1' AND DATE_ADD( e_orders.OrderDate, INTERVAL ".($period)." ) > NOW( ) AND e_orders.PaymentStatus = '1' GROUP BY e_orderdetail.ProductID ORDER BY product_quantity DESC
				          LIMIT ".intval($bestsellersCount)."";

			//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
				
		}
		 
		return false;
	}

	function emailToFriend($arryDetails)
	{
		extract($arryDetails);
		global $Config;
		 
		 
		$htmlPrefix = $Config['EmailTemplateFolder'];
		$contents = file_get_contents($htmlPrefix."emailto_friend.htm");
		$subject  = "Hello, $fname. This is $yname You must see it!";

		$contents = str_replace("[COMPANY_NAME]",$Config['DisplayName'],$contents);
		$contents = str_replace("[YOUR_NAME]",$yname, $contents);
		$contents = str_replace("[FRIEND_NAME]",$fname, $contents);
		$contents = str_replace("[PRODUCT_ID]",$ProductID, $contents);
		$contents = str_replace("[PRODUCT_NAME]",$ProductName, $contents);
		$contents = str_replace("[PRODUCT_URL]",$PrdLink, $contents);

		$mail = new MyMailer();
		$mail->IsMail();
		$mail->AddAddress($femail);
		$mail->sender($Config['StoreName'], $yemail);
		$mail->Subject = $Config['StoreName']." - ".$subject;
		$mail->IsHTML(true);
		$mail->Body = $contents;

		if($Config['Online'] == '1')
		{
			$mail->Send();
			$sendMail = 1;
		}
		return $sendMail;
	}
	 
	function GettotalActiveProduct()
	{
		 
		$strSQLQuery = "SELECT * FROM e_products WHERE Status = '1'";
		return  $this->query($strSQLQuery);
		 
	}
	 
	function exportProducts()
	{
		$strSQLQuery = "SELECT * FROM e_products ORDER BY ProductID ASC";
		return  $this->query($strSQLQuery);
		 
	}
	 
	 
	/*** Variant Update ************/

	function UpdateVariantProduct($arryDetails) {

		extract($arryDetails);

		$Variant_id = implode(',', $ID);

		$strSQLQuery = "update  e_products set variant_id='" . addslashes($Variant_id) . "'  where ProductID='" . $ProductID . "'";


		$this->query($strSQLQuery, 0);


		return 1;

		//return $lastInsertId;
	}

	/***************ITEM ALIAS******************/

	function GetAliasbySku($sku) {
		$strSQLQuery = "SELECT * FROM e_item_alias ";
		$strSQLQuery .= (!empty($sku)) ? (" where ProductSku = '" . $sku . "'") : ("");
		$strSQLQuery .="  ORDER BY AliasID ASC";
		#echo $strSQLQuery;
		return $this->query($strSQLQuery);
	}

	function UpdateAliasItem($arryDetails) {

		extract($arryDetails);

		$sql = "SELECT count(*) as total from e_item_alias WHERE ItemAliasCode = '" . mysql_real_escape_string(strtoupper($ItemAliasCode)) . "' and   AliasID!='" . $AliasID . "'  and   ProductID='" . addslashes($item_id) . "' ";
		$res= $this->query($sql, 1);
		if($res[0]['total']==0){
			$strSQLQuery = "update e_item_alias set ItemAliasCode = '" . addslashes($ItemAliasCode) . "', description='" . addslashes($description) . "', Manufacture='" . addslashes($Manufacture) . "', ProductSku='" . addslashes($Sku) . "', ProductID='" . addslashes($item_id) . "' where AliasID='" . $AliasID . "'";

			$this->query($strSQLQuery, 0);


			return 1;
		}

		return 0;
	}

	function AddAliasItem($arryDetails) {

		extract($arryDetails);
		$sql = "SELECT count(*) as total from e_item_alias WHERE ItemAliasCode = '" . mysql_real_escape_string(strtoupper($ItemAliasCode)) . "' and   ProductID='" . addslashes($item_id) . "' ";
		$res= $this->query($sql, 1);
		if($res[0]['total']==0){
			$strSQLQuery = "insert e_item_alias (ItemAliasCode, description, ProductSku, ProductID, Manufacture)
		                 values ('" . mysql_real_escape_string(strtoupper($ItemAliasCode)) . "','" . addslashes($description) . "','" . addslashes($Sku) . "','" . $item_id . "', '" . addslashes($Manufacture) . "')";

			$this->query($strSQLQuery, 0);
			return 1;
		}

		return 0;

		 
	}

	function GetAliasItem($AliasID) {
		$strSQLQuery = "SELECT * FROM e_item_alias ";
		$strSQLQuery .= (!empty($AliasID)) ? (" where AliasID = '" . $AliasID . "'") : ("");
		 
		return $this->query($strSQLQuery);
	}


	function  GetProductByAlias($id)
	{

		$strSQLQuery = "select Name,ProductSku,Detail  from e_products  ";
		$strSQLQuery .= " where ProductID='".$id."'";
		#echo $strSQLQuery; exit;
		return $this->query($strSQLQuery, 1);
	}
	function RemoveAlias($AliasID) {
		$strSQLQuery = "delete from e_item_alias where AliasID='" . $AliasID . "'";
		$this->query($strSQLQuery, 0);
	}


	function isItemNumberExists($ProductSku, $ItemID = 0, $PostedByID) {

		$strSQLQuery = "select ProductID from e_products where LCASE(ProductSku)='" . strtolower(trim($ProductSku)) . "'";

		$strSQLQuery .= ($ItemID > 0) ? (" and ProductID != '" . $ItemID . "'") : ("");
		//$strSQLQuery .= (!empty($PostedByID)) ? (" and PostedByID = '" . $PostedByID."'") : ("");

		$arryRow = $this->query($strSQLQuery, 1);
		//echo 'test: '.$arryRow[0]['ItemID']; exit;
		if (!empty($arryRow[0]['ProductID'])) {
			return true;
		} else {
			return false;
		}
	}

	/*     * *************FINISH********************* */


	/*     * ************** Sales Order ************* */



}

?>
