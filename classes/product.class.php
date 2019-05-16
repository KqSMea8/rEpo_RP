<?php
class product extends dbClass
{

	public $throttling_is_active = false;
	var $MERCHANT_ID;
	var $MARKETPLACE_ID;
	var $SERVICE_URL;
	var $SERVICE_ORDER_URL;
	var $MWS_AUTH_TOKEN;
	var $SERVICE_PRODUCT_URL;
	var  $URL;
	var $AWS_ACCESS_KEY_ID;
	var $AWS_SECRET_ACCESS_KEY;
		//constructor
		function product()
		{
			$this->dbClass();
		} 
		
			function  GetProducts($id=0,$CategoryID,$Status,$shortby,$Mfg)
			{

				$strSQLQuery = "select p1.*,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID";
				$strSQLQuery .= ($Status>0)?(" and p1.Status='".$Status."' and c1.Status='".$Status."'"):(" and p1.Status='1' and c1.Status='1' ");
				$strSQLQuery .= (!empty($id))?(" where p1.ProductID='".$id."'"):(" where 1 ");
				$strSQLQuery .= (!empty($CategoryID))?(" and p1.CategoryID='".$CategoryID."'"):("");
				$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid='".$Mfg."'"):("");
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
			$strSQLQuery .= (!empty($id))?(" where p1.ProductID='".$id."'"):(" where 1 ");
			//echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}
                function  GetProductEdit($id)
		{

			$strSQLQuery = "select p1.* from e_products p1 ";
			$strSQLQuery .= (!empty($id))?(" where p1.ProductID='".$id."'"):(" where 1 ");
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
 			global $Config;
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
			$strAddQuery .= (!empty($id))?(" where p1.ProductID='".$id."'"):(" where 1");
			$strAddQuery .= ($CategoryID>0)?(" and p1.CategoryID IN (".$catId.")"):("");
			
			$strAddQuery .= ($Status>0)?(" and p1.Status='".$Status."' and m1.Status='1'  "):("");
			
			if($SearchKey=='active' && ($SortBy=='p1.Status' || $SortBy=='') ){
				$strAddQuery .= " and p1.Status='1'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='p1.Status' || $SortBy=='') ){
				$strAddQuery .= " and p1.Status='0'";
			}
            else if($SortBy=='p1.ProductSku'){
				$strAddQuery .= " and p1.ProductSku='".$SearchKey."' ";
			}
            else if($SortBy=='p1.Featured'){
				$strAddQuery .= " and p1.Featured like '".$SearchKey."%'";
			}
            else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (p1.Name like '".$SearchKey."%' or p1.ProductSku like '%".$SearchKey."%' or p1.AddedDate like '%".$SearchKey."%' or p1.Featured like '".$SearchKey."%' or eia.ItemAliasCode like '".$SearchKey."%') "):("");
			}
			
			if($Config['GetNumRecords']!=1)
			$strAddQuery .=" GROUP BY p1.ProductID ";

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by p1.ProductID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                
			if($Config['GetNumRecords']==1){
				$Columns = " count(p1.ProductID) as NumCount ";				
			}else{				
				$Columns = " p1.*, (select FeedProcessingStatus from amazon_items p2 where (p2.ProductSku!='' and p1.ProductSku=p2.ProductSku COLLATE latin1_swedish_ci) and Channel like '%amazon%' group by p2.ProductSku) AmazonFeedProcessingStatus, (select FeedProcessingStatus from amazon_items p2 where (p2.ProductSku!='' and p1.ProductSku=p2.ProductSku COLLATE latin1_swedish_ci) and Channel like '%ebay%' group by p2.ProductSku) EbayFeedProcessingStatus ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
       
			$strSQLQuery = "select $Columns from e_products p1 left join e_item_alias eia on eia.ProductID=p1.ProductID ".$strAddQuery;
                        # echo $strSQLQuery; die;
                                           
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
                        $strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID  where  p1.Status='1' and c1.Status='1' ";

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
                            

			$strSQLQuery .= ($CategoryID>0)?(" and  (p1.CategoryID ='".$CategoryID."' or c1.CategoryID ='".$CategoryID."' or c1.ParentID = '".$CategoryID."' )"):("");

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
			$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid='".$Mfg."'"):("");
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

			$strSQLQuery .= ($Status>0)?(" and p1.Status='".$Status."' and c1.Status='".$Status."' and m1.Status='".$Status."' "):("");

			$strSQLQuery .= ($ProductID>0)?(" and p1.ProductID !='".$ProductID."'"):("");

			$strSQLQuery .= ' order by p1.Name asc ';


			return $this->query($strSQLQuery, 1);
		}		

		function  SearchProductsCat($id=0,$CategoryIDs,$Status,$key,$state_id,$PostedByID,$Bidding)
		{
			$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID ='".$CategoryIDs."' or c1.ParentID = '".$CategoryIDs."')"):(" where 1 ");

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID='".$PostedByID."'"):("");

			$strSQLQuery .= ($Status>0)?(" and p1.Status='".$Status."' and c1.Status='".$Status."' and m1.Status='".$Status."' "):("");

			$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%')"):("");

			$strSQLQuery .= ($state_id>0)?(" and m1.state_id='".$state_id."'"):("");

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

			$strSQLQuery = "select p1.* from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status='1' and c1.Status='1' ".$strSQLFeaturedQuery."   order by rand() Desc LIMIT 0,".$FeaturedProductsCount."";
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
			$sql="select * from e_products where ProductID in (".$ProductIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0)
			{

				$sql="update e_products set Status='".$Status."' where ProductID in (".$ProductIDs.")";
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

		/******** Update by suneel for virtual product file ****/

	function UpdateVirtualFile($fileName,$ProductID)
	{
		$strSQLQuery = "update e_products set virtual_file='".$fileName."' where ProductID='".mysql_real_escape_string($ProductID)."'";
		return $this->query($strSQLQuery, 0);
	}
/********** End *******************/
                
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
			$strSQLQuery = "update e_products set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price1."', Price2='".$Price2."', Image='', Status='".$Status."',is_upld = '".$is_upld."',label_txt = '".addslashes($label_txt)."',product_type='".addslashes($product_type)."',secure_type='".addslashes($secure_type)."' where ProductID='".mysql_real_escape_string($ProductID)."'";
			$this->query($strSQLQuery, 0);
			}
			else {
			$strSQLQuery = "update e_products set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price1."', Price2='".$Price2."', Status='".$Status."',is_upld = '".$is_upld."',label_txt = '".addslashes($label_txt)."',product_type='".addslashes($product_type)."',secure_type='".addslashes($secure_type)."' where ProductID='".mysql_real_escape_string($ProductID)."'";
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
			$strSQLQuery = "update e_products set MetaTitle='".addslashes($MetaTitle)."',MetaKeywords='".addslashes($MetaKeyword)."',MetaDescription = '".addslashes($MetaDescription)."',UrlCustom = '".$UrlCustom."'  where ProductID='".mysql_real_escape_string($ProductID)."'";

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
			$strAddQuery = (!empty($global_id))?(" and Gaid='".$global_id."'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                        $strSQLQuery = "select * from e_global_optionList  where 1 ".$strAddQuery." order by id asc";
			return $this->query($strSQLQuery, 1);
		}
function  GetProductOptionList($paid) 
		{
			$strAddQuery = (!empty($paid))?(" and paid='".$paid."'"):("");
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
								$strSQLQuery = "select * from e_products_quantity_discounts where qd_id = '".mysql_real_escape_string($disID)."'";
								return $this->query($strSQLQuery, 1);
                            }
                      function UpdateDiscount($arryDetails)
                        {
                                extract($arryDetails);
                                $is_active = isset($is_active)?$is_active:"No";
                                $strSQLQuery = "update e_products_quantity_discounts set range_min='".trim($range_min)."',range_max = '".$range_max."',is_active='".trim($is_active)."',discount='".trim($discount)."',discount_type='".trim($discount_type)."',customer_type='".trim($customer_type)."' where qd_id = '".mysql_real_escape_string($DiscountId)."' and pid='".mysql_real_escape_string($ProductID)."'";
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
			global $Config;
			$objFunction=new functions();
			$select=mysql_query("select Image from e_products_images where Iid = '".mysql_real_escape_string($imageId)."' and ProductID='".mysql_real_escape_string($pid)."'");
			$arry=mysql_fetch_array($select);
			
			foreach ($arry as $Image) {  
				$objFunction->DeleteFileStorage($Config['ProductsSecondary'],$Image); 
			     
			}

			 

			$strSQLQuery = "delete from e_products_images where Iid = '".mysql_real_escape_string($imageId)."' and ProductID='".mysql_real_escape_string($pid)."'"; 
			$this->query($strSQLQuery, 0);
			return 1;
		}
                               
/*************************************Alternatative Images Function Start******************************************************************/ 
		function RemoveProduct($id,$CategoryID,$Front)
		{
			global $Config;
			$objConfigure = new configure();
			$objFunction=new functions();
			$strSQLQuery = "select Image from e_products where ProductID='".mysql_real_escape_string($id)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($arryRow[0]['Image'] != '') {            
			    $objFunction->DeleteFileStorage($Config['Products'],$arryRow[0]['Image']); 
			}
			$sql = "select * from e_products_images where ProductID='".mysql_real_escape_string($id)."'"; 
			$arry = $this->query($sql, 1);

			 
			
			foreach ($arry as $key => $values) {
			    $Image = $values['Image'];
			    if ($Image != '') {
				$objFunction->DeleteFileStorage($Config['ProductsSecondary'],$Image); 
			    }
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
			$strAddQuery .= (!empty($id))?(" where pr.ReviewId='".$id."'"):(" where 1");
			
			$strAddQuery .= ($Status>0)?(" and pr.Status='".$Status."'"):("");
			
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

/*************** Amazon product by sanjiv ************* */
	function AmazonSettings($Prefix, $amazon_setting_path, $AccID){
		
		$amazon_setting_path = (!empty($amazon_setting_path)) ? '../../':$Prefix;
	  	
	  	$AmazonSetting = $this->GetAmazonAccount($AccID, true);
	  	if(!empty($AmazonSetting)){
			include ($Prefix.'admin/e-commerce/amazon-setting.php');
			
			$config = array (
			  'ServiceURL' => $this->SERVICE_URL,
			  'ProxyHost' => null,
			  'ProxyPort' => -1,
			  'MaxErrorRetry' => 3,
			);
			return $service = new MarketplaceWebService_Client(
			     $this->AWS_ACCESS_KEY_ID, 
			     $this->AWS_SECRET_ACCESS_KEY, 
			     $config,
			     APPLICATION_NAME,
			     APPLICATION_VERSION);
	  	}else{
	  		return false;
	  	}
	}

	function AmazonSettingsForOrder($Prefix,$amazon_setting_path,$AccID){
		
		$amazon_setting_path = (!empty($amazon_setting_path)) ? '../../':$Prefix;
	  	
	  	$AmazonSetting = $this->GetAmazonAccount($AccID, true);
	  	if(!empty($AmazonSetting)){
			include ($Prefix.'admin/e-commerce/amazon-setting.php'); 

			$this->getAndSetAllMarketPlacesByMerchant($AmazonSetting[0]['merchant_id']);
		
			$config = array (
			   'ServiceURL' => $this->SERVICE_ORDER_URL,
			   'ProxyHost' => null,
			   'ProxyPort' => -1,
			   'ProxyUsername' => null,
			   'ProxyPassword' => null,
			   'MaxErrorRetry' => 3,
			 );
			
			return $service = new MarketplaceWebServiceOrders_Client(
			        $this->AWS_ACCESS_KEY_ID,
			        $this->AWS_SECRET_ACCESS_KEY,
			        APPLICATION_NAME,
			        APPLICATION_VERSION,
			        $config);
	  	}else{
	  		return false;
	  	}
	}
	
	function CreateAmazonProduct($feed,$service,$feedType,$action) 
	  { 
	  	//'A2EUQ1WTGCTBG2';
	  	$marketplaceIdArray = array("Id" => array($this->MARKETPLACE_ID));
		$feedHandle = @fopen('php://memory', 'rw+');
		fwrite($feedHandle, $feed);
		rewind($feedHandle);
		
		$request = new MarketplaceWebService_Model_SubmitFeedRequest();
		$request->setMerchant($this->MERCHANT_ID);
		$request->setMarketplaceIdList($marketplaceIdArray);
		$request->setFeedType($feedType);//_POST_PRODUCT_DATA_
		$request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
		rewind($feedHandle);
		$request->setPurgeAndReplace(false);
		$request->setFeedContent($feedHandle);
		$request->setMWSAuthToken($this->MWS_AUTH_TOKEN); // Optional
		
		rewind($feedHandle);
		
		///echo "<pre>";
		//print_r($request);die;
		$this->invokeSubmitFeed($service, $request); 
		if($action=='add'){
			$this->saveAmazonData($_POST);
		}
		if($action=='Batch' || $action=='Refund'){
				$sku = ($this->ProductSku) ? $this->ProductSku : '_MWS'.strtoupper($action).'_';
			$x = array('ProductSku'=>$sku,'FeedSubmissionId'=>$_POST['FeedSubmissionId'],'AmazonAccountID'=>$this->AccountID);
			$this->addSubmitHistory($x);
		}
		//else{
			//$x = array('ProductSku'=>'madhu123','FeedSubmissionId'=>$_POST['FeedSubmissionId'],'AmazonAccountID'=>8);
			//$this->addSubmitHistory($x);
		//
	   // }
		@fclose($feedHandle);
	  }
	  
	function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request) 
	  {
	  $response = $service->submitFeed($request);
	      try {
	              $response = $service->submitFeed($request);
	                if ($response->isSetSubmitFeedResult()) { 
	                    $submitFeedResult = $response->getSubmitFeedResult();
	                    if ($submitFeedResult->isSetFeedSubmissionInfo()) { 
	                        $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
	                    	if ($feedSubmissionInfo->isSetFeedSubmissionId()) 
	                        {
	                            $_POST['FeedSubmissionId'] = $feedSubmissionInfo->getFeedSubmissionId();
	                        }
		                     if ($feedSubmissionInfo->isSetFeedProcessingStatus()) 
	                        {
	                            $_POST['FeedProcessingStatus'] = $feedSubmissionInfo->getFeedProcessingStatus();
	                            $_SESSION['CRE_Msg'] = 'You have successfully updated your listings. It may take up to 15 minutes for your changes to propagate to all systems.';
	                        }
	                    } 
	                } 
		     } catch (MarketplaceWebService_Exception $ex) {
		     	$_POST['FeedProcessingStatus'] = 'Error';
				$_SESSION['CRE_Msg'] = "Amazon returned the following error(s): /n " . $ex->getMessage();
		     }
	 }
	 
	function invokeGetFeedSubmissionResult(MarketplaceWebService_Interface $service, $FeedSubmissionId) 
	  {	 
	  	$request = new MarketplaceWebService_Model_GetFeedSubmissionResultRequest();
		$request->setMerchant($this->MERCHANT_ID);
		$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
		$request->setFeedSubmissionId($FeedSubmissionId);
		$fileHandle = fopen('php://memory', 'rw+');
		$request->setFeedSubmissionResult($fileHandle);
		
	      try {
              $response = $service->getFeedSubmissionResult($request);
              rewind($fileHandle);
			  $responseStr = stream_get_contents($fileHandle);
			  $responseXML = new SimpleXMLElement($responseStr);
             
			  if($responseXML->Message->ProcessingReport->Result[0]->ResultCode=='Error'){
			  	$_POST['FeedProcessingStatus'] = $responseXML->Message->ProcessingReport->Result[0]->ResultCode;
			  	$Etext = '';
			  	foreach ($responseXML->Message->ProcessingReport->Result as $error){
			  		$Etext .=$error->ResultDescription.'\n';
			  	}
			  	$_SESSION['CRE_Msg'] = $_POST['FeedProcessingSMsg']  =  $Etext;
			  }else{
			  	$_POST['FeedProcessingStatus'] = $responseXML->Message->ProcessingReport->StatusCode;	
			  	$_SESSION['CRE_Msg'] = 'You have successfully updated your listings. It may take up to 15 minutes for your changes to propagate to all systems.';
			  }
	                
	     } catch (MarketplaceWebService_Exception $ex) {
	     	 $_POST['FeedProcessingStatus'] = 'Error';
	         $_SESSION['CRE_Msg'] = "Amazon returned the status error(s): /n " . $ex->getMessage();
	     }
	     
	     @fclose($feedHandle);
	 }
	 
	 
function getFeedSubmissionHistory(MarketplaceWebService_Interface $service, $FeedSubmissionId,$fetchType) 
	  {	 
		if(empty($FeedSubmissionId)) return ;
		
	  	if(!empty($FeedSubmissionId)){
		  	$request = new MarketplaceWebService_Model_GetFeedSubmissionResultRequest();
			$request->setMerchant($this->MERCHANT_ID);
			$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
			$request->setFeedSubmissionId($FeedSubmissionId);
			$fileHandle = fopen('php://memory', 'rw+');
			$request->setFeedSubmissionResult($fileHandle);
			$data = array();
		      try {
	              $response = $service->getFeedSubmissionResult($request);
	              rewind($fileHandle);
				  $responseStr = stream_get_contents($fileHandle);
				  $responseXML = new SimpleXMLElement($responseStr);
				  $responseXML = $this->processSimpleXmlResult($responseXML);

			if($responseXML->Message->ProcessingReport->Result){

			      if(count($responseXML->Message->ProcessingReport->Result)>1){
				     foreach ($responseXML->Message->ProcessingReport->Result as $report){
				     	$feedmsg = $status = '';
				     	if($report->ResultCode=='Error'){
				     		$status = $report->ResultCode;
				     		$feedmsg = $report->ResultDescription.'\n' ;
				     	}else{
				     		$status = 'Active';
				     		$feedmsg = 'Active';
				     	}
				     	
				     	if(array_key_exists($report->AdditionalInfo->SKU, $data)){ 
				     		if($report->ResultCode=='Error'){ 
							$fetchType = '';
				     			$feedmsg = $data[$report->AdditionalInfo->SKU]['feedmsg'].$feedmsg.'\n';
				     			$data[$report->AdditionalInfo->SKU] = array('status'=>$status,'feedmsg'=>$feedmsg);
				     		}		             		
				     	}else{ 
				     		$data[$report->AdditionalInfo->SKU] = array('status'=>$status,'feedmsg'=>$feedmsg);
				     	}
				     	
				     }
			     }else{
			     	$x = $this->getSkuFromSubmitHistory($FeedSubmissionId); $key = $x[0]['ProductSku'];
			     	if($responseXML->Message->ProcessingReport->Result->ResultCode=='Error'){
					$fetchType = '';				
			     		$data['FeedProcessingStatus'] = $responseXML->Message->ProcessingReport->Result->ResultCode;
			     		$data['FeedProcessingSMsg'] = $responseXML->Message->ProcessingReport->Result->ResultDescription;
					$data[$key] = array('status'=>$data['FeedProcessingStatus'],'feedmsg'=>$data['FeedProcessingSMsg']);
			     	}else{
			     		$data['FeedProcessingStatus'] = 'Active';
			     		$data['FeedProcessingSMsg'] = 'Active';
					$data[$key] = array('status'=>$data['FeedProcessingStatus'],'feedmsg'=>$data['FeedProcessingSMsg']);
			     	}
			     }
			    
			     if($fetchType=='Batch'){
				     $data['FeedProcessingStatus'] = 'Active';
				     $data['FeedProcessingSMsg'] = 'Batch listing has been Completed';
			     }
	             	}else if($responseXML->Message->ProcessingReport->ProcessingSummary->MessagesSuccessful){
				$x = $this->getSkuFromSubmitHistory($FeedSubmissionId); $key = $x[0]['ProductSku'];
				$data['FeedProcessingStatus'] = 'Active';
				$data['FeedProcessingSMsg'] = 'Active';
				$data[$key] = array('status'=>$data['FeedProcessingStatus'],'feedmsg'=>$data['FeedProcessingSMsg']);
			}else if($responseXML->Message->ProcessingReport->ProcessingSummary->MessagesProcessed){
				$data['status'] = 'In Process';
				$data['feedmsg'] = '';
			}
		     } catch (MarketplaceWebService_Exception $ex) {
		     	 $data['status'] = 'In Process';
		         $data['feedmsg'] = '';
		     }
		     
		     @fclose($feedHandle);
	  	}else{
	  		 $data['status'] = 'Error';
		     $data['feedmsg'] = 'Submission failed! please try again.';
	  	}   
	  	$data['FeedSubmissionId'] = $FeedSubmissionId;
		$this->updateBatchAmazonSubmitHistory($data);
	     
	     return $data;
	 }
	 
	 function deleteAmazonProduct($Amazonservice,$productsku,$id){
	 	$feed = '<?xml version="1.0"?>
			<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
			<Header>
			<DocumentVersion>1.01</DocumentVersion>
			<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
			</Header>
			<MessageType>Product</MessageType>
			<Message>
			<MessageID>1</MessageID>
			<OperationType>Delete</OperationType>
			<Product>
			<SKU>'.$productsku.'</SKU>
			</Product>
			</Message>
			</AmazonEnvelope>';
	 	$this->CreateAmazonProduct($feed, $Amazonservice, '_POST_PRODUCT_DATA_','delete');
	 	//if($_POST['FeedProcessingStatus']!='_FAILED_') 
	 	$this->deleteAmazonDataFromTable($id);
	 	
	 }
	 
/******************* Amazon order API***********************************/ 
	// http://docs.developer.amazonservices.com/en_US/feeds/Feeds_FeedType.html
	
	//https://sellercentral.amazon.com/gp/help/200387280
	/*PendingAvailability
	Pending
	Unshipped
	PartiallyShipped
	Shipped
	InvoiceUnconfirmed
	Canceled
	Unfulfillable*/
	function RefundAmazonOrderItems($Amazonservice,$pData){
$feed = '<?xml version="1.0" encoding="UTF-8"?>
		<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
		<Header>
		<DocumentVersion>1.01</DocumentVersion>
		<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
		</Header>
		<MessageType>OrderAdjustment</MessageType>';
$msgCount = 1;
$pData['SubTotalPrice'] = (int) ($pData['SubTotalPrice'] / count($pData['AmazonOrderItemCode']) ) ;
$data = $pData['AmazonOrderItemCode'];
foreach ($data as $vaules){
$feed .= '<Message>
		<MessageID>'.$msgCount.'</MessageID>
		<OrderAdjustment>
		<AmazonOrderID>'.$pData['AmazonOrderId'].'</AmazonOrderID>
		<AdjustedItem>
		<AmazonOrderItemCode>'.$vaules['OrderItemId'].'</AmazonOrderItemCode>
	    <AdjustmentReason>'.$pData['RefundReason'].'</AdjustmentReason>
	    <ItemPriceAdjustments>
	    <Component>
	    <Type>Principal</Type>
	    <Amount currency="'.$pData['Currency'].'">'.$pData['SubTotalPrice'].'</Amount>
	    </Component>
	    <Component>
	    <Type>Shipping</Type>
	    <Amount currency="'.$pData['Currency'].'">0.00</Amount>
	    </Component>
	    </ItemPriceAdjustments>
	    </AdjustedItem>
	    </OrderAdjustment>
	    </Message>';
	$msgCount ++;
}
$feed .= '</AmazonEnvelope>';
//pr($feed,1);

			$this->CreateAmazonProduct($feed, $Amazonservice, '_POST_PAYMENT_ADJUSTMENT_DATA_','Refund');
			if($_POST['FeedProcessingStatus']!='_FAILED_' && isset($_POST['FeedSubmissionId'])){
			}
					
		}
	 
	 //https://sellercentral.amazon.com/gp/help/200387140
	function CancelAmazonFullOrder($Amazonservice, $pData){
		
	 	$feed = '<?xml version="1.0"?> 
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
				xsi:noNamespaceSchemaLocation="amzn-envelope.xsd"> 
				<Header> 
				        <DocumentVersion>1.01</DocumentVersion> 
				        <MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier> 
				</Header> 
				<MessageType>OrderAcknowledgement</MessageType> 
				<Message> 
				        <MessageID>1</MessageID> 
				        <OrderAcknowledgement> 
				           <AmazonOrderID>'.$pData['AmazonOrderId'].'</AmazonOrderID> 
				           <StatusCode>Failure</StatusCode> 
				           <Item> 
				              <AmazonOrderItemCode>'.$pData['OrderID'].'</AmazonOrderItemCode>
                                <CancelReason>'.$pData['cancelReason'].'</CancelReason>
				           </Item> 
				        </OrderAcknowledgement> 
				</Message> 
				</AmazonEnvelope>';
	 	
	 	$this->CreateAmazonProduct($feed, $Amazonservice, '_POST_ORDER_ACKNOWLEDGEMENT_DATA_','delete');
		if($_POST['FeedProcessingStatus']!='_FAILED_' && isset($_POST['FeedSubmissionId'])){ 
	 		$this->addSubmitHistory($_POST);
	 		$this->upadateAmazonOrderStatus('Canceled',$pData['AmazonOrderId']);
	 	}else{
	 		
	 	}
	 	$_SESSION['mess_order'] = $_SESSION['CRE_Msg'];
	 	unset($_SESSION['CRE_Msg']);
	 	//if($_POST['FeedProcessingStatus']!='_FAILED_') 
	 	//$this->deleteAmazonDataFromTable($itemID);
	 }
	 
 	function ShippingCode($code){
			$x = array('USPS','UPS','FedEx','DHL','Fastway','GLS','GO!','FedEx SmartPost','DHL Global Mail','UPS Mail Innovations','Blue Package','OSM','TNT','Target',
					     'Hermes Logistik Gruppe','Royal Mail','Parcelforce','City Link','SagawaExpress','NipponExpress','YamatoTransport'
						);
			if(!empty($code)){
				foreach ($x as $y){ 
					if( strtolower($y)==strtolower(trim($code)) ) 
					return $y;
				}
			}else{
				return false;
			}
		}
		
		public function upadateshippingAfterPostToGL($Prefix, $data, $type=''){
			if(!empty($data)){
				$orders = implode(",",$data);
				//$orders = "130,131,132";
				$strSQLQuery = "SELECT s.OrderID,s.InvoiceID,s.ShippingMethod,s.ShippedDate,s.ShippingMethodVal,s.CustomerPO,s.TrackingNo,s.OrderSource,e.AmazonAccountID
							    from s_order s inner join e_orders e on(s.CustomerPO =e.AmazonOrderId COLLATE latin1_swedish_ci ) 
							    where s.OrderID IN (".trim($orders).") and s.module='Invoice' and e.AmazonAccountID>'0'  and s.CustomerPO>'0' and s.OrderSource='".$type."' 
							    and s.ShippingMethod!='' and s.TrackingNo!='' order by e.AmazonAccountID ASC";
				$arryRow = $this->query($strSQLQuery, 1);
				
				if(!empty($arryRow)){
					$AccID = '';
					$Arr = $f = array();
					foreach ($arryRow as $value){ 
						
						if( empty($AccID) ) $AccID = $value['AmazonAccountID'];
						
						if($AccID!=$value['AmazonAccountID']){
							$f[$AccID] = $Arr;
							$Arr = array();
						}
						
						array_push($Arr, $value);
						
						if($AccID!=$value['AmazonAccountID']){
							$AccID = $value['AmazonAccountID'];
							$f[$AccID] = $Arr;
						}
						
					}
				}
				
				if(empty($f)) $f[$AccID] = $Arr;
				
				foreach ($f as $fi => $fv){ 
					$Amazonservice = $this->AmazonSettings($Prefix,true,$fi);
					if($Amazonservice) $this->shipAndConfirmShipment($Amazonservice,$fv);
				}
				
			}
		}
		
		
		/* OrderID
		 * ShipmentDate
		 * ShipmentMethod
		 * trackingId
		 * ShippingMethod
		 */
		public function upadateSingleShipping($Prefix, $orderID){


			if(!empty($orderID)){
				

$strSQLQuery = "SELECT w.OrderID as S_Order,e.OrderID E_Order,w.ShipType as ShipmentMethod,w.ShipmentDate,w.ShippingMethod,w.trackingId,s.CustomerPO,s.OrderSource,e.AmazonAccountID,e.SellerChannel 
							    from s_order s inner join e_orders e on(s.CustomerPO =e.AmazonOrderId COLLATE latin1_swedish_ci ) 
								left join w_shipment w on(s.OrderID=w.ShippedID)
							    where s.OrderID ='".$orderID."' and s.module='Shipment' and s.CustomerPO>'0' 
							   	and w.ShipType!='' and w.trackingId!='' ";





				$arryRow = $this->query($strSQLQuery, 1);
	
/*			
if($_GET['pkkkk'] == '385325235' ){
	$Amazonservice = $this->AmazonSettings($Prefix,true,3);

	pr($Amazonservice,1);die;

	die;
}*/


				if(!empty($arryRow)){
					if($arryRow[0]['OrderSource']=='Amazon' && $arryRow[0]['AmazonAccountID']>0){
						$Amazonservice = $this->AmazonSettings($Prefix,true,$arryRow[0]['AmazonAccountID']);

						 
						 
						if($Amazonservice && $arryRow[0]['SellerChannel']!='Amazon.com') $this->shipAndConfirmShipment($Amazonservice,$arryRow);
					}else if($arryRow[0]['OrderSource']=='Ebay'){
						$sql3 = "select OrderItemId from e_orderdetail where OrderID='".$arryRow[0]['E_Order']."'";
						$arryRow1 = $this->query($sql3, 1);
						if(!empty($arryRow1)){
							$arryRow[0]['OrderID'] = $arryRow1[0]['OrderItemId'];
							$this->EbayUpdateShipping($Prefix,$arryRow[0]);
						}
					}
				}
		
			}
		}
		
		


		function shipAndConfirmShipment($Amazonservice, $pData){ 
				
			$feed = '<?xml version="1.0" encoding="UTF-8"?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
				    <Header>
				        <DocumentVersion>1.01</DocumentVersion>
				        <MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
				    </Header>
				    <MessageType>OrderFulfillment</MessageType>';
					$i = 1; 
					foreach ($pData as $v){ 
						$shippingDate = '';
						if($v['ShipmentDate']>0){
							$shippingDate = date('Y-m-d',strtotime($v['ShipmentDate'])).'T'.'00:01:00';
							$shippingDate = '<FulfillmentDate>'.$shippingDate.'</FulfillmentDate>';
						}
					    if(!empty($v['ShippingMethod'])){
					    	$v['ShippingMethod'] = str_replace("FEDEX","", str_replace("_", " ",  $v['ShippingMethod']) );
					    	$ShippingMethod = '<ShippingMethod>'.ucwords(strtolower($v['ShippingMethod'])).'</ShippingMethod>';
					    }else{
					    	$v['ShippingMethod'] = '';
					    }
					   $CarrierCode = $this->ShippingCode($v['ShipmentMethod']);
					   $CarrierCode = (!empty($CarrierCode))?$CarrierCode:$v['ShipmentMethod'];
			$feed .= '<Message>
				        <MessageID>'.$i.'</MessageID>
				        <OrderFulfillment>
				           <AmazonOrderID>'.$v['CustomerPO'].'</AmazonOrderID>
				           	'.$shippingDate.'
				           	<FulfillmentData>
				           	   <CarrierCode>'.$CarrierCode.'</CarrierCode>
				                '.$ShippingMethod.'
				               <ShipperTrackingNumber>'.$v['trackingId'].'</ShipperTrackingNumber>
				           </FulfillmentData>
				        </OrderFulfillment>
				    </Message>';
				        $i++;
					}    
		  $feed .= '</AmazonEnvelope>';
		
			$this->CreateAmazonProduct($feed, $Amazonservice, '_POST_ORDER_FULFILLMENT_DATA_','delete');
			if($_POST['FeedProcessingStatus']!='_FAILED_' && isset($_POST['FeedSubmissionId'])){
				$this->addSubmitHistory($_POST);				
				$this->upadateAmazonOrderStatus('Shipped',$pData[0]['CustomerPO']);
				
				//$this->upadateAmazonShippingData($pData);
			}
		}
	 
	 public function getAmazonOrders( MarketplaceWebServiceOrders_Interface $service, $from_date, $days = false ) {
        $LastUpdatedAfter    = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", strtotime( $from_date ) + 0 ); 
        if ( $days )
            $LastUpdatedAfter = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time() - $days * 24 * 3600 ); 

         $request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
 
		 $request->setSellerId($this->MERCHANT_ID);
		 $request->setMarketplaceId($this->MARKETPLACE_ID);
		 $request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
		 $request->setLastUpdatedAfter($LastUpdatedAfter);
		 
			//echo "<pre>";
        	//print_r($result->ListOrdersResult->Orders->Order);die;
	   try {
			$result = $service->ListOrders($request);
			$result = $this->parseXML($result->toXML());
			 $result = $this->processSimpleXmlResult($result);
	      	
	        if ( $result->ListOrdersResult->Orders->Order ) {
	        	
	            $orders = $result->ListOrdersResult->Orders->Order;
	            if ( is_object($orders) ) $orders = array( $orders );
	
	            return $orders;
	
	        } elseif ( isset( $result->ListOrdersResult->Orders ) ) {
	
	            return array();
	
	        }
	
	     } catch (MarketplaceWebServiceOrders_Exception $ex) {
	        $result = "Caught Exception: " . $ex->getMessage() ;
	     }
        // return result object in case of errors
        return $result;
    }

    // GetOrder (v1)
    public function getAmazonOrder( MarketplaceWebServiceOrders_Interface $service, $OrderID) {

         $request = new MarketplaceWebServiceOrders_Model_GetOrderRequest();
		 $request->setSellerId($this->MERCHANT_ID);
		 $request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
		 $request->setAmazonOrderId($OrderID);
		
		 try {
			$result = $service->GetOrder($request);    	
	         //echo "<pre>";
        	//print_r($result);
	        if ( isset( $result->GetOrderResult->Orders->Order ) ) {
	            
	            $orders = $result->GetOrderResult->Orders->Order;
	            if ( is_object($orders) ) $orders = array( $orders );
	
	            return $orders;
	
	        } elseif ( isset( $result->GetOrderResult->Orders ) ) {
	            return array();
	        }
		 }catch (MarketplaceWebServiceOrders_Exception $ex) {
		 	$result = "Caught Exception: " . $ex->getMessage() ;
		 	
		 }

        return $result;
    }

    function getAmazonLineItemsOrder(MarketplaceWebServiceOrders_Interface $service, $AmazonOrderId ) {
        // $this->GetServiceStatus();

        $request = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
		$request->setSellerId($this->MERCHANT_ID);
		//$request->setMarketplaceId($this->MARKETPLACE_ID);
		$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
		$request->setAmazonOrderId($AmazonOrderId);

		
	    try {
	        $result = $service->ListOrderItems($request);
	        
			$result = $this->parseXML($result->toXML());
			$result = $this->processSimpleXmlResult($result);
	        $resultArr = $result->ListOrderItemsResult->OrderItems->OrderItem;
        	
	        if ( $resultArr ) {
	        
	            // unify results for single and multiple items - result is an array of items
	            if ( is_array( $resultArr ) ) {
	                $items = $resultArr;
	            } else {
	                $items = array( $resultArr );
	            }
	            // return orders array
	            return $items;
	
	        // check if empty result was returned
	        } elseif ( isset( $resultArr ) ) {
	
	            // return empty array
	            return array();
	        }
	     } catch (MarketplaceWebServiceOrders_Exception $ex) {
	        $result = ("Caught Exception: " . $ex->getMessage() . "\n");
	        $result .= ("Response Status Code: " . $ex->getStatusCode() . "\n");
	     }

        // return result object in case of errors
        return $result;
    }
	 
/******************** End of Amazon Order **********************************/	 
	 
function saveAmazonData($arryDetails){
		//print_r($arryDetails);
		 global $Config;
		 extract($arryDetails);
		 $SaleEndDate = ($SaleEndDate>0) ? date('Y-m-d', strtotime($SaleEndDate)) : '';
		 $SaleStartDate = ($SaleStartDate>0) ? date('Y-m-d', strtotime($SaleStartDate)) : '';
		 $LaunchDate = ($LaunchDate>0) ? date('Y-m-d', strtotime($LaunchDate)) : '';
		 $RestockDate = ($RestockDate>0) ? date('Y-m-d', strtotime($RestockDate)) : '';
		 $Channel = (!empty($this->URL)) ? $this->URL : 'amazon';
		 //$FeedProcessingStatus = ($FeedProcessingStatus) ? $FeedProcessingStatus : '';
		 $Features = serialize($Features);
		 $Keywords = serialize($Keywords);
		 $Status = 0;
		 $isExist = false;
		 if($ProductID) $itemID = $ProductID;
		 if(empty($itemID)) $itemID = 0;
		 $sql = "select itemID,AliasID from amazon_items where itemID ='".$itemID."' and AliasID='".$AliasID."' and Channel like '%amazon%' ";
		 $exist = $this->query($sql,1);
		 
		if(!empty($exist[0]['itemID'])){
			$isExist = true;
			$where = "itemID=$itemID and Channel like '%amazon%' ";
		}else if(!empty($exist[0]['AliasID'])){
			$isExist = true;
			$where = "AliasID=$AliasID and Channel like '%amazon%' ";
		}
		 
		 if($isExist){
		 	$sql = "UPDATE amazon_items set Cat = '".$Cat."',browserNode = '".$browserNode."',MfrPartNumber = '".$MfrPartNumber."',Brand = '".$Brand."',ProductType = '".$ProductType."', ProductCode='".$ProductCode."', ProductTypeName='".$ProductTypeName."', Quantity='".$Quantity."', Price='".$Price."', ItemCondition='".$ItemCondition."', ItemConditionNote='".addslashes($ItemConditionNote)."', ShortDetail='".addslashes(strip_tags($ShortDetail))."', 
		 			LaunchDate='".$LaunchDate."', SaleStartDate='".$SaleStartDate."', SaleEndDate='".$SaleEndDate."', GiftMessage='".$GiftMessage."', GiftWrap='".$GiftWrap."', Price2='".$Price2."', RestockDate='".$RestockDate."', FeedSubmissionId='".$FeedSubmissionId."', FeedProcessingStatus='".$FeedProcessingStatus."', Status='".$Status."', LastUpdateDate='".$Config['TodayDate']."', AmazonAccountID='".$AmazonAccountID."',
		 			Features='".$Features."', Keywords='".$Keywords."' , TaxCode='".$TaxCode."', FulfilledBy='".$FulfilledBy."', Channel='".$Channel."' where $where";
		 }else{
		 	$sql = "INSERT INTO amazon_items (Name, ProductSku, itemID, Cat, browserNode, MfrPartNumber, Brand, ProductType, ProductCode, ProductTypeName, Quantity, Price, ItemCondition, ItemConditionNote, ShortDetail, LaunchDate, SaleStartDate, SaleEndDate, GiftMessage, GiftWrap, Price2, RestockDate, FeedSubmissionId, FeedProcessingStatus, Status, LastUpdateDate, AmazonAccountID, Features, Keywords, TaxCode, FulfilledBy, Channel, AliasID)
		 		 VALUES ('".$Name."','".$ProductSku."','".$itemID."', '".$Cat."', '".$browserNode."', '".$MfrPartNumber."', '".$Brand."', '".$ProductType."', '".$ProductCode."','".$ProductTypeName."', '".$Quantity."', '".$Price."', '".$ItemCondition."', '".addslashes($ItemConditionNote)."', '".addslashes(strip_tags($ShortDetail))."', '".$LaunchDate."', '".$SaleStartDate."', '".$SaleEndDate."', '".$GiftMessage."', '".$GiftWrap."', '".$Price2."', '".$RestockDate."', '".$FeedSubmissionId."', '".$FeedProcessingStatus."',
		 		 		 '".$Status."', '".$Config['TodayDate']."', '".$AmazonAccountID."', '".$Features."', '".$Keywords."', '".$TaxCode."', '".$FulfilledBy."','".$Channel."', '".$AliasID."')";
		 }
		 if($FeedProcessingStatus!='UnProcessed'){
		 	$this->addSubmitHistory($arryDetails);
		 }
		 return $this->query($sql);
		
	}
	
function getAmazonData($itemID=null, $type, $status, $FeedStatus, $query, $pid){
			if(empty($type)) return ;
			$where = " where channel LIKE '%".mysql_real_escape_string($type)."%' "; $orderBy = " LaunchDate DESC";
			if(!empty($itemID)){
				$where .= ' and itemID ='. mysql_real_escape_string($itemID);
			}
			if(!empty($pid)){
				$where .= ' and pid ='. mysql_real_escape_string($pid);
			}
			if(is_numeric($status)){
				$where .= " and ai.Status ='". mysql_real_escape_string($status)."' ";
			}
			if(!empty($FeedStatus)){
				$where .= " and FeedProcessingStatus ='".mysql_real_escape_string($FeedStatus)."' ";
			}
			
			if(!empty($query)){
				extract($query);
				if(!empty($ItemCondition)){
					$where .= " and ItemCondition LIKE '%".mysql_real_escape_string($ItemCondition)."%' ";
				}
				if(isset($QuantityFrom) && $QuantityTo>0){
					$where .= " and (ai.Quantity >='".mysql_real_escape_string((int) $QuantityFrom)."' and ai.Quantity <='".mysql_real_escape_string((int) $QuantityTo)."') ";
				}
				if(isset($PriceFrom) && $PriceTo>0){
					$where .= " and (ai.Price >='".mysql_real_escape_string($PriceFrom)."' and ai.Price <='".mysql_real_escape_string($PriceTo)."') ";
				}

				if(!empty($sortby) && !empty($key)){ $key = trim($key);
					if($sortby=='All'){
						$where .= " and (ProductSku LIKE '%".mysql_real_escape_string($key)."%' or
										Name LIKE '%".mysql_real_escape_string($key)."%' or
										ListingPrice LIKE '%".mysql_real_escape_string($key)."%' or
										FeedProcessingStatus LIKE '%".mysql_real_escape_string($key)."%' or
										ItemConditionNote LIKE '%".mysql_real_escape_string($key)."%') ";
					}else{
						$where .= " and $sortby LIKE '%".mysql_real_escape_string($key)."%' ";
					}
				}
				
				if(!empty($sortby) && $sortby!='All') $orderBy = "$sortby $asc";

			}
			
			//$sql = "select ai.*, ep.Name, ep.ProductSku from amazon_items ai inner join e_products ep on(ai.itemID=ep.ProductID) $where";
			$sql = "select ai.* from amazon_items ai $where order by $orderBy";
			return $this->query($sql, 1);
		}
	
function deleteAmazonDataFromTable($id){
			$sql = "delete from amazon_items where pid='".mysql_real_escape_string($id)."' ";
			return $this->query($sql);
		}
	
	function updateBatchAmazonStatus($SKU, $FeedProcessingStatus ,$FeedProcessingSMsg){
		$status = ($FeedProcessingStatus=='In Process') ? 0 : 1;
		$sql = "update amazon_items ai inner join e_products ep on(ai.itemID=ep.ProductID) set FeedProcessingStatus = '".$FeedProcessingStatus."', FeedProcessingSMsg='".mysql_real_escape_string($FeedProcessingSMsg)."', ai.Status='".$status."' where ai.ProductSku='".mysql_real_escape_string($SKU)."' and ai.Channel like '%amazon%' ";
		return $this->query($sql);
	}
	
	function updateAmazonStatus($FeedSubmissionId, $FeedProcessingStatus ,$FeedProcessingSMsg){ 
			$status = ($FeedProcessingStatus=='In Process') ? 0 : 1;
			$sql = "update amazon_items set FeedProcessingStatus = '".$FeedProcessingStatus."', FeedProcessingSMsg='".mysql_real_escape_string($FeedProcessingSMsg)."', Status='".$status."' where FeedSubmissionId='".mysql_real_escape_string($FeedSubmissionId)."' ";
		    return $this->query($sql);
	}
	
	function addSubmitHistory($arryDetails){ 
		global $Config;
		extract($arryDetails);
		$sql = "INSERT INTO amazon_submit_history (ProductSku,FeedSubmissionId,CreatedDate,AmazonAccountID) Values('".$ProductSku."','".$FeedSubmissionId."',NOW(),'".$AmazonAccountID."')";		
		return $this->query($sql);
	}
	
	function getAmazonSubmitHistory($arryDetails){ 
		global $Config;
		$sql = "SELECT ash.* , ep.Name, ep.ProductSku from amazon_submit_history ash left join amazon_items ep  on(ash.ProductSku=ep.ProductSku COLLATE latin1_swedish_ci) order by ash.CreatedDate DESC";
		return $this->query($sql,1);
	}
	
	function getSkuFromSubmitHistory($feedId){
		global $Config;
		$sql = "SELECT ProductSku from amazon_submit_history where FeedSubmissionId='".$feedId."' ";
		return $this->query($sql,1);
	}
	
	function updateAmazonSubmitHistory($FeedSubmissionId, $FeedProcessingStatus ,$FeedProcessingSMsg){ 
			$status = ($FeedProcessingStatus=='In Process') ? 0 : 1;
			$sql = "update amazon_submit_history set FeedProcessingStatus = '".$FeedProcessingStatus."', FeedProcessingSMsg='".mysql_real_escape_string($FeedProcessingSMsg)."', Status='".$status."' where FeedSubmissionId='".mysql_real_escape_string($FeedSubmissionId)."' ";
			return $this->query($sql);
	}
	
	function updateBatchAmazonSubmitHistory($data){
		$FeedProcessingStatus = $data['FeedProcessingStatus'];
		$FeedProcessingSMsg = $data['FeedProcessingSMsg'];
		$FeedSubmissionId = $data['FeedSubmissionId'];
		$status = ($data['status']=='In Process') ? 0 : 1;
		$arrKeys = array();
		foreach ($data as $key => $value){ 
			if(is_array($value)){
				if(count($data)==2){ 
					$FeedProcessingStatus = $value['status'];
					$FeedProcessingSMsg = $value['feedmsg'];
				}
				
				if($value['status']=='Error') array_push($arrKeys,$key);
				
				$this->updateBatchAmazonStatus($key, $value['status'], $value['feedmsg']);
			}else{	
				if(!empty($FeedProcessingStatus)) $this->updateAmazonStatus($FeedSubmissionId,$FeedProcessingStatus,$FeedProcessingSMsg);
			}
		
		}
		
		if(!empty($FeedProcessingStatus)){ 
			$sql = "update amazon_submit_history set FeedProcessingStatus = '".$FeedProcessingStatus."', FeedProcessingSMsg='".mysql_real_escape_string($FeedProcessingSMsg)."', Status='".$status."' where FeedSubmissionId='".mysql_real_escape_string($FeedSubmissionId)."' ";
			$this->query($sql);
		}elseif(!empty($arrKeys)){
			$sql = "update amazon_submit_history set FeedProcessingStatus = 'Error', FeedProcessingSMsg='".mysql_real_escape_string(implode(", ", $arrKeys).' have xml errors. Edit products to view detail message accordingly.')."', Status='".$status."' where FeedSubmissionId='".mysql_real_escape_string($FeedSubmissionId)."' ";
			$this->query($sql);
			} 
		//return $data;
		# comment header in testing mode.
		//header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
		//exit;
	}
	
	function getAccountAll(){
		$sql = "SELECT a.*, m.url from amazon_accounts  a left join amazon_markets m on(a.market_id=m.id)  where active='1' ORDER BY merchant_id ASC";
		return $this->query($sql,1);
	}
	
	function getAmazonMarketList(){
		$sql = "SELECT * from amazon_markets ORDER BY sort_order ASC";
		return $this->query($sql,1);
	}
	
	function GetAmazonAccount($id=null,$isActive=false){
		$where = '';
		if(!empty($id)) $where = " where a.id='".$id."' " ;
		if($isActive && !empty($id)) $where .= " and active='1'" ;
		$sql = "SELECT a.*, m.url, m.group_title, m.code from amazon_accounts a left join amazon_markets m on(a.market_id=m.id) $where  ORDER BY title ASC";
		return $this->query($sql,1);
	}

	function GetAmazonAccountBySetDefault(){
			$where = '';
			$sql = "SELECT a.*, m.url, m.group_title, m.code from amazon_accounts a left join amazon_markets m on(a.market_id=m.id) where  set_default = '1' and active='1' and sync_product = '1' ORDER BY title ASC";
			return $this->query($sql,1);
	}

	function getAndSetAllMarketPlacesByMerchant($MerchantID){
		$sql = "SELECT marketplace_id from amazon_accounts where merchant_id='".$MerchantID."' ";
		$marckets = $this->query($sql,1);
		$marcketList = array();
		if(!empty($marckets)){
			foreach ($marckets as $marcket){
				array_push($marcketList, $marcket['marketplace_id']);
			}
		}
		 $this->MARKETPLACE_ID = $marcketList;
	}
	
	function addAmazonAccount($arryDetails){
			global $Config;
			extract($arryDetails);
			$sql = "INSERT INTO amazon_accounts (title,merchant_id,marketplace_id,mws_auth_token,market_id,active,sync_orders,from_date,set_desc,sync_product,fulfilled_by,Default_cat,condition_note,set_condition,brand) Values('".$title."','".$merchant_id."','".$marketplace_id."','".$mws_auth_token."','".$market_id."','".$active."','".$sync_orders."','".$from_date."','".$set_desc."','".$sync_product."','".$fulfilled_by."','".$Default_cat."','".addslashes($set_condition)."','".addslashes($condition_note)."','".$brand."')";
			return $this->query($sql);
		}
		
	function updateAmazonAccount($arryDetails){
		extract($arryDetails);
		$sql = "update amazon_accounts set title= '".$title."', merchant_id= '".$merchant_id."', marketplace_id= '".$marketplace_id."', mws_auth_token='".$mws_auth_token."', market_id='".$market_id."', active='".$active."' , sync_orders='".$sync_orders."', from_date='".$from_date."', set_desc='".$set_desc."', sync_product='".$sync_product."', fulfilled_by='".$fulfilled_by."', Default_cat='".$Default_cat."', set_condition='".addslashes($set_condition)."', condition_note='".addslashes($condition_note)."' , brand='".$brand."' where id='".$acc_id."'";
		return $this->query($sql);
	}
	
	function updateDateOfLastOrder($acc_id, $amazonOrders){
		global $Config;
		$OrdersCount = (count($amazonOrders)-1);
		$date = ($amazonOrders[$OrdersCount]->LastUpdateDate>0) ? $this->convertIsoDateToSql( $amazonOrders[$OrdersCount]->LastUpdateDate ) : date('Y-m-d', strtotime('-1 day', strtotime($Config['TodayDate'])) );
		$sql = "update amazon_accounts set last_orders_sync='".$date."' where id='".$acc_id."'";
		return $this->query($sql);
	}
	
	function updateAmazonAccountStatus($id,$status){
		$sql = "update amazon_accounts set  active='".$status."' where id='".$id."'";
		return $this->query($sql);
	}

	function updateAmazonAccountSetDefault($id,$status){ 
			if($status==1){
				$sql0 = "update amazon_accounts set  set_default='0' ";
				$this->query($sql0);
				$sql = "update amazon_accounts set  set_default='1' where id='".$id."'";
			}else{
				$sql = "update amazon_accounts set  set_default='0' where id='".$id."'";
			}
			return $this->query($sql);
		}
	
	function processAmazonListingItem($arryRow, $OrderID){
		
		if($arryRow->ItemPrice){ 
			
			$Price = (isset($arryRow->ItemPrice->Amount))?$arryRow->ItemPrice->Amount/$arryRow->QuantityOrdered:0;
            $ProductID = 0;
            $OrderItemId = $arryRow->OrderItemId;
            $ProductName = addslashes($arryRow->Title);
            $Quantity = $arryRow->QuantityOrdered;
            $ProductOptions = '';
            $TaxRate = (isset($arryRow->ItemTax->Amount)) ? $arryRow->ItemTax->Amount + $arryRow->ShippingTax->Amount + $arryRow->GiftWrapTax->Amount : 0;
            $TaxDescription = 'All taxes are included (itemtax, ShippingTax, GiftWrapTax)';
            $AmazonSku = addslashes($arryRow->SellerSKU);
            $ASIN	   = addslashes($arryRow->ASIN);

            $strSQLQuery = "insert into e_orderdetail(OrderID,ProductID,ProductName,ProductOptions,Quantity ,Price, TaxRate, TaxDescription, AmazonSku, ASIN, OrderItemId) values('" . $OrderID . "','" . $ProductID . "','" . addslashes($ProductName) . "', '" . addslashes($ProductOptions) . "', '" . $Quantity . "', '" . $Price . "', '" . $TaxRate . "', '" . addslashes($TaxDescription) . "', '".$AmazonSku."', '".$ASIN."', '".$OrderItemId."')"; 
            $this->query($strSQLQuery, 0);
		}
	}
	
	function saveAmazonOrder($arryDetails){
	  $fields = join(',',array_keys($arryDetails));
      $values = join("','",array_values($arryDetails));
      
      $strSQLQuery = "insert into e_orders ($fields)  values('" .$values."')"; 
      $this->query($strSQLQuery, 0);
      
	}
	
	function upadateAmazonOrder($data){ 
		extract($data);
		 $strSQLQuery = "update e_orders set OrderStatus='".$OrderStatus."', OrderComplatedDate='".$OrderComplatedDate."' where AmazonOrderId='".$AmazonOrderId."' ";
		 $this->query($strSQLQuery, 0);
	}
	
   function upadateAmazonOrderStatus($OrderStatus, $amazonId){ 
		 $strSQLQuery = "update e_orders set OrderStatus='".$OrderStatus."' where AmazonOrderId='".$AmazonOrderId."' ";
		 $this->query($strSQLQuery, 0);
	}
	
	function upadateAmazonShippingData($ShippingData){ 
		extract($ShippingData);
		 $strSQLQuery = "update e_orders set OrderStatus='Shipped', ShipDate='".$ShipDate."', ShippingMethod='".$ShippingMethod."', TrackNumber='".$TrackNumber."', TrackMsg='".$TrackMsg."' where AmazonOrderId='".$AmazonOrderId."' ";
		 $this->query($strSQLQuery, 0);
	}
	
	function getShippingMethods(){
		$sqlSettings = "SELECT * FROM e_shipping_selected WHERE Status='Yes' ORDER BY Priority";
		return $this->query($sqlSettings);
	}
	
	/************************Cron jobs/Import orders *****************************/
	public function importOrder( $order, $account,  $Amazonservice) {
			$data = array();
			global $Config;
			$id = 0;
			if ( $this->throttling_is_active == true ) return false;
			
			 //if ( ! is_object($order) )
			 	//echo "<pre>order is not an object: ";print_r($order);echo"</pre>";die();

			if($order->OrderStatus=='Canceled') $order->OrderStatus='Cancelled';
			if($order->OrderStatus=='Cancelled'){ $this->deleteCancelOrders($order->AmazonOrderId); }

			$data = array(
				'OrderType' 		   => 'Amazon',
				'AmazonOrderId'        => $order->AmazonOrderId,
				'OrderStatus'          => $order->OrderStatus,
				'SellerChannel'		   => $order->SalesChannel,
				'AmazonAccountID'	   => $account['id'],
				'PaymentStatus'	       => 1,
				// pending orders are missing some details
				'TotalPrice'           => ( $order->OrderTotal->Amount ) ? $order->OrderTotal->Amount : '',
				'Currency'             => ( $order->OrderTotal->CurrencyCode ) ? $order->OrderTotal->CurrencyCode : '',
				'Email'         	   => ( $order->BuyerEmail ) ? addslashes($order->BuyerEmail) : '',
				'PaymentGateway'        => ( $order->PaymentMethod ) ? 'Amazon ('.$order->PaymentMethod .')' : '',
				'PaymentGatewayID'        => ( $order->PaymentMethod ) ? $order->PaymentMethod : '',
				'OrderDate'            => $this->convertIsoDateToSql( $order->PurchaseDate ),
				'OrderComplatedDate'   => $this->convertIsoDateToSql( $order->LastUpdateDate ),
				'ShippingMethod'	   => ( $order->ShipmentServiceLevelCategory ) ? $order->ShipmentServiceLevelCategory : $order->ShipServiceLevel,
				'Phone'			   	   => ( $order->ShippingAddress->Phone ) ? $order->ShippingAddress->Phone : '',
				'DelivaryDate'		   => $this->convertIsoDateToSql($order->EarliestDeliveryDate),
				'TotalQuantity' 	   =>  $order->NumberOfItemsShipped + $order->NumberOfItemsUnshipped
			);
			
			if ( isset($order->ShippingAddress) ):
			$data['ShippingName'] = addslashes($order->ShippingAddress->Name);
			$data['ShippingCompany'] = $data['ShippingName'];
			$AddressLine = ($order->ShippingAddress->AddressLine1)?$order->ShippingAddress->AddressLine1:'';
			$AddressLine .= ($order->ShippingAddress->AddressLine2)?$order->ShippingAddress->AddressLine2:'';
			$AddressLine .= ($order->ShippingAddress->AddressLine3)?$order->ShippingAddress->AddressLine3:'';
			$data['ShippingAddress'] = addslashes($AddressLine);
			$data['ShippingCity'] = addslashes($order->ShippingAddress->City);
			$data['ShippingState'] = addslashes($order->ShippingAddress->StateOrRegion);
			$data['ShippingCountry'] = ($order->ShippingAddress->County) ? addslashes($order->ShippingAddress->County) : addslashes($order->ShippingAddress->CountryCode);
			$data['ShippingZip'] = addslashes($order->ShippingAddress->PostalCode);
			$data['ShippingPhone'] = addslashes($order->ShippingAddress->Phone);
			endif;
			
			if ( isset($order->RegistrationAddress) ) :
			$data['BillingName'] = addslashes($order->RegistrationAddress->Name);
			$data['BillingCompany'] = $data['BillingName'];
			$AddressLine = ($order->RegistrationAddress->AddressLine1)?$order->RegistrationAddress->AddressLine1:'';
			$AddressLine .= ($order->RegistrationAddress->AddressLine2)?$order->RegistrationAddress->AddressLine2:'';
			$AddressLine .= ($order->RegistrationAddress->AddressLine3)?$order->RegistrationAddress->AddressLine3:'';
			$data['BillingAddress'] = addslashes($AddressLine);
			$data['BillingCity'] = addslashes($order->RegistrationAddress->City);
			$data['BillingState'] = addslashes($order->RegistrationAddress->StateOrRegion);
			$data['BillingCountry'] = ($order->RegistrationAddress->County) ? addslashes($order->RegistrationAddress->County) : addslashes($order->RegistrationAddress->CountryCode);
			$data['BillingZip'] = $order->RegistrationAddress->PostalCode;
			$data['Phone'] = $order->ShippingAddress->Phone;
			$data['Email'] = $order->ShippingAddress->Name;
			elseif(isset( $order->ShippingAddress) ):
			$data['BillingName'] = ( $order->ShippingAddress->Name ) ? addslashes($order->ShippingAddress->Name) : '';
			$data['BillingCompany'] = $data['BillingName'];
			$AddressLine = ($order->ShippingAddress->AddressLine1)?$order->ShippingAddress->AddressLine1:'';
			$AddressLine .= ($order->ShippingAddress->AddressLine2)?$order->ShippingAddress->AddressLine2:'';
			$AddressLine .= ($order->ShippingAddress->AddressLine3)?$order->ShippingAddress->AddressLine3:'';
			$data['BillingAddress'] = addslashes($AddressLine);
			$data['BillingCity'] = addslashes($order->ShippingAddress->City);
			$data['BillingState'] = addslashes($order->ShippingAddress->StateOrRegion);
			$data['BillingCountry'] = ($order->ShippingAddress->County) ? addslashes($order->ShippingAddress->County) : addslashes($order->ShippingAddress->CountryCode);
			$data['BillingZip'] = addslashes($order->ShippingAddress->PostalCode);
			endif;
			
	        if ( is_object($items) && isset($items->Error->Message) ) {
	        	$this->throttling_is_active = true;
	        	$_SESSION['mess_order'] = 'ListOrderItems requests are throttled. Skipping further order processing until next run.';
	        	return false;
	        }
	
			 # Remove pending order and insert the same order with new data
			$orderExistance = $this->order_id_exists( $order->AmazonOrderId );
			if( !empty($orderExistance['OrderID']) && ($orderExistance['OrderStatus']=='Pending') && ($order->OrderStatus=='Shipped' || $order->OrderStatus=='Unshipped') ){
				$this->deleteSyncOrder($orderExistance['OrderID']);
				$data['OrderID'] = $orderExistance['OrderID'];
				$orderExistance['OrderID']=false;
			}

			if ( !empty($orderExistance['OrderID']) ) { 		
				 $this->UpadateAmazonOrder( $data );
				 return $id = false;
			} else {
			$items = array();
	
			$items = $this->getAmazonLineItemsOrder($Amazonservice, $order->AmazonOrderId );
			$tax = $shipping = $discount = 0;
			foreach ($items as $item) {
				$TaxList = 0;
				$TaxList = $item->ItemTax->Amount + $item->ShippingTax->Amount + $item->GiftWrapTax->Amount;
	            $tax = $tax + $TaxList ;
	            $shipping = $shipping + $item->ShippingPrice->Amount;
	            $discount = $discount + ($item->ShippingDiscount->Amount + $item->PromotionDiscount->Amount);
			}
			
			$data['Shipping'] = $shipping;
			$data['DiscountAmount'] = $discount;
			$data['Tax'] = $tax;
			$data['SubTotalPrice'] = $data['TotalPrice'] - ($data['Shipping']+$data['Tax']+$data['DiscountAmount']);
			
				 $this->saveAmazonOrder( $data );
				 $id = $this->lastInsertId();
				if ( $data['OrderStatus'] != 'Canceled') {
					foreach ($items as $item) {
						$success = $this->processAmazonListingItem( $item, $id );
					}
				}
				if($id){
					# Sync amazon orders directaly into sales orders
					$this->SyncAmazonOrderInSalesOrder( $data, $id);
				}
			} 
	
			return $id;
		}
		
		function order_id_exists( $OrderID,  $Email) {
	        $strSQLQuery = "select OrderID, OrderStatus from e_orders where AmazonOrderId = '".trim($OrderID)."' ";
	   
	        $arryRow = $this->query($strSQLQuery, 1);
	        if (!empty($arryRow[0]['OrderID'])) {
	            return array('OrderID'=>$arryRow[0]['OrderID'],'OrderStatus'=>$arryRow[0]['OrderStatus']);
	        } else {
	            return false;
	        }
		}
	
		// convert 2013-02-14T08:00:58.000Z to 2013-02-14 08:00:58
		public function convertIsoDateToSql( $iso_date ) {
			$search = array( 'T', '.000Z', 'Z' );
			$replace = array( ' ', '' );
			$sql_date = str_replace( $search, $replace, $iso_date );
			return $sql_date;
		}
		
		function getDateOfLastOrder( $account_id ) {
			$strSQLQuery = "SELECT OrderComplatedDate FROM e_orders WHERE AmazonAccountID = '".$account_id."' ORDER BY OrderComplatedDate DESC LIMIT 1";
			$data = $this->query($strSQLQuery, 1);
			return $data[0]['OrderComplatedDate'];
		}
		
	public function processSimpleXmlResult( $result ) {
        return json_decode( json_encode( $result ) );
    }
	
    private function parseXML( $xml ) {

        // get rid of useless namespace before parsing XML
        $xml = str_replace('ns2:', '', $xml);

        // parse XML
        $parsed_xml = simplexml_load_string( $xml );
        // echo "<pre>XML1: ";print_r( $parsed_xml );echo"</pre>";#die();

        // if ( isset( $parsed_xml->Error ) ) {
        //     $success = 'Error';
        // } else {
        //     $success = 'Success';
        // }


        // check for secondary namespace - GetMatchingProductForIdResult
        if ( isset( $parsed_xml->GetMatchingProductForIdResult->Products->Product ) ) {

            // shortcut
            $product = $parsed_xml->GetMatchingProductForIdResult->Products->Product;

            // fetch item attributes from secondary namespace
            // $ns2 = $parsed_xml->GetMatchingProductForIdResult->Products->Product->AttributeSets->children('ns2', true);
            // $ns2 = $this->processSimpleXmlResult( $ns2 );
        
            $product->variation_type = false;
            if ( $product->Relationships->VariationParent ) {
                $product->variation_type      = 'child';
                $product->VariationParentASIN = (string)$product->Relationships->VariationParent->Identifiers->MarketplaceASIN->ASIN;
            }
            if ( $product->Relationships->VariationChild ) {
                $product->variation_type = 'parent';
            }

            // extract ASIN and MarketplaceId
            $product->ASIN          = (string)$product->Identifiers->MarketplaceASIN->ASIN;
            $product->MarketplaceId = (string)$product->Identifiers->MarketplaceASIN->MarketplaceId;

            // return product node
            return $this->processSimpleXmlResult( $product );
        }

        // check for secondary namespace - ListMatchingProductsResult
        if ( isset( $parsed_xml->ListMatchingProductsResult->Products->Product ) ) {

            $products = array();
            foreach ($parsed_xml->ListMatchingProductsResult->Products->Product as $product) {

                // fetch item attributes from secondary namespace
                // $ns2 = $product->AttributeSets->children('ns2', true);
                // $ns2 = $this->processSimpleXmlResult( $ns2 );
            
                // extract ASIN and MarketplaceId
                $product->ASIN          = (string)$product->Identifiers->MarketplaceASIN->ASIN;
                $product->MarketplaceId = (string)$product->Identifiers->MarketplaceASIN->MarketplaceId;

                // store ItemAttributes in product object
                $products[] = $product;
            }

            // return products array
            return $this->processSimpleXmlResult( $products );
        } elseif ( isset( $parsed_xml->ListMatchingProductsResult ) ) {
            return array();
        }


        // parse GetCompetitivePricingForASINResult(s)
        if ( isset( $parsed_xml->GetCompetitivePricingForASINResult ) ) {

            // return product nodes directly
            $products = $this->parseGetCompetitivePricingForASINResult( $parsed_xml );
            return $products;
        }

        // parse GetLowestOfferListingsForASINResult(s)
        if ( isset( $parsed_xml->GetLowestOfferListingsForASINResult ) ) {

            // return product nodes directly
            $products = $this->parseGetLowestOfferListingsForASINResult( $parsed_xml );
            return $products;
        }


        // return $this->processSimpleXmlResult( $parsed_xml );
        return $parsed_xml;
    } // parseXML()


    // parse GetCompetitivePricingForASINResult(s)
    private function parseGetCompetitivePricingForASINResult( $parsed_xml ) {

        $products = array();
        foreach ($parsed_xml->GetCompetitivePricingForASINResult as $GetCompetitivePricingForASINResult) {

            // catch errors like "ASIN ... is not valid for marketplace ..."
            if ( $GetCompetitivePricingForASINResult->Error ) {

                // extract ASIN and error
                $product = new stdClass();
                $product->ASIN          = (string)$GetCompetitivePricingForASINResult['ASIN'];
                $product->status        = (string)$GetCompetitivePricingForASINResult['status'];
                $product->message       = $GetCompetitivePricingForASINResult->Error->Message;
                $product->prices        = array();
                $product->MarketplaceId = '';

                // add to products array
                $products[ $product->ASIN ] = $product;
                continue;
            }

            // shortcut
            $product = $GetCompetitivePricingForASINResult->Product;
            $prices  = array();

            $CompetitivePrices = $GetCompetitivePricingForASINResult->Product->CompetitivePricing->CompetitivePrices->CompetitivePrice;

            if ( $CompetitivePrices ) {

                // if ( is_array( $GetCompetitivePricingForASINResult->Product->CompetitivePricing->CompetitivePrices->CompetitivePrice ) )
                // foreach ($GetCompetitivePricingForASINResult->Product->CompetitivePricing->CompetitivePrices->CompetitivePrice as $CompetitivePrice) {

                // if ( ! is_array( $CompetitivePrices ) ) $CompetitivePrices = array( $CompetitivePrices );
                foreach ( $CompetitivePrices as $CompetitivePrice) {

                    // ini_set('display_errors', 1);
                    // error_reporting( E_ALL | E_STRICT );
                    // echo "<pre>";print_r($CompetitivePrice);echo"</pre>";#die();

                    // extract condition and subcondition
                    $CompetitivePrice->condition            = (string)$CompetitivePrice['condition'];
                    $CompetitivePrice->subcondition         = (string)$CompetitivePrice['subcondition'];
                    $CompetitivePrice->belongsToRequester   =   (bool)$CompetitivePrice['belongsToRequester'];

                    // extract everything
                    $new_price = new stdClass();
                    $new_price->LandedPrice                 =  (float)$CompetitivePrice->Price->LandedPrice->Amount;
                    $new_price->ListingPrice                =  (float)$CompetitivePrice->Price->ListingPrice->Amount;
                    $new_price->Shipping                    =  (float)$CompetitivePrice->Price->Shipping->Amount;
                    $new_price->condition                   = (string)$CompetitivePrice['condition'];
                    $new_price->subcondition                = (string)$CompetitivePrice['subcondition'];
                    $new_price->belongsToRequester          = (string)$CompetitivePrice['belongsToRequester'] == 'true' ? true : false;
                    $new_price->id                          =    (int)$CompetitivePrice->CompetitivePriceId;
                    $prices[] = $new_price;
                }

            }

            // extract ASIN and MarketplaceId
            $product->ASIN          = (string)$product->Identifiers->MarketplaceASIN->ASIN;
            $product->MarketplaceId = (string)$product->Identifiers->MarketplaceASIN->MarketplaceId;

            // convert XML object to PHP object
            $product = $this->processSimpleXmlResult( $product );
            $product->prices        =  (array)$prices;

            // add to products array
            $products[ $product->ASIN ] = $product;
        }

        // return product nodes
        return $products;

    } // parseGetCompetitivePricingForASINResult()


    // parse GetLowestOfferListingsForASINResult(s)
    private function parseGetLowestOfferListingsForASINResult( $parsed_xml ) {

        $products = array();
        foreach ($parsed_xml->GetLowestOfferListingsForASINResult as $GetLowestOfferListingsForASINResult) {

            // catch errors like "ASIN ... is not valid for marketplace ..."
            if ( $GetLowestOfferListingsForASINResult->Error ) {

                // extract ASIN and error
                $product = new stdClass();
                $product->ASIN          = (string)$GetLowestOfferListingsForASINResult['ASIN'];
                $product->status        = (string)$GetLowestOfferListingsForASINResult['status'];
                $product->message       = $GetLowestOfferListingsForASINResult->Error->Message;
                $product->prices        = array();
                $product->MarketplaceId = '';

                // add to products array
                $products[ $product->ASIN ] = $product;
                continue;
            }

            // shortcut
            $product = $GetLowestOfferListingsForASINResult->Product;
            $prices  = array();

            $LowestOfferListings = $GetLowestOfferListingsForASINResult->Product->LowestOfferListings->LowestOfferListing;

            if ( $LowestOfferListings ) {
                // if ( is_array( $GetLowestOfferListingsForASINResult->Product->LowestOfferListings->LowestOfferListing ) )
                // foreach ($GetLowestOfferListingsForASINResult->Product->LowestOfferListings->LowestOfferListing as $LowestOfferListing) {

                // if ( ! is_array( $LowestOfferListings ) ) $LowestOfferListings = array( $LowestOfferListings );
                foreach ( $LowestOfferListings as $LowestOfferListing) {

                    // ini_set('display_errors', 1);
                    // error_reporting( E_ALL | E_STRICT );
                    // echo "<pre>";print_r($LowestOfferListing);echo"</pre>";#die();

                    // extract condition and subcondition
                    // $LowestOfferListing->condition            = (string)$LowestOfferListing['condition'];
                    // $LowestOfferListing->subcondition         = (string)$LowestOfferListing['subcondition'];

                    // extract everything
                    $new_price = new stdClass();
                    $new_price->LandedPrice                     =  (float)$LowestOfferListing->Price->LandedPrice->Amount;
                    $new_price->ListingPrice                    =  (float)$LowestOfferListing->Price->ListingPrice->Amount;
                    $new_price->Shipping                        =  (float)$LowestOfferListing->Price->Shipping->Amount;
                    $new_price->condition                       = (string)$LowestOfferListing->Qualifiers->ItemCondition;
                    $new_price->subcondition                    = (string)$LowestOfferListing->Qualifiers->ItemSubcondition;
                    $new_price->FulfillmentChannel              = (string)$LowestOfferListing->Qualifiers->FulfillmentChannel;
                    $new_price->ShipsDomestically               = (string)$LowestOfferListing->Qualifiers->ShipsDomestically;
                    $new_price->ShippingTime                    = (string)$LowestOfferListing->Qualifiers->ShippingTime->Max;
                    $new_price->SellerPositiveFeedbackRating    = (string)$LowestOfferListing->Qualifiers->SellerPositiveFeedbackRating;
                    $new_price->SellerFeedbackCount             =    (int)$LowestOfferListing->SellerFeedbackCount;
                    $new_price->MultipleOffersAtLowestPrice     = (string)$LowestOfferListing->MultipleOffersAtLowestPrice == 'True' ? 1 : 0;
                    $new_price->NumberOfOfferListingsConsidered =    (int)$LowestOfferListing->NumberOfOfferListingsConsidered;
                    $new_price->id                              =    (int)$LowestOfferListing->CompetitivePriceId;
                    $prices[] = $new_price;
                    // echo "<pre>";print_r($new_price);echo"</pre>";#die();
                }

            }

            // extract ASIN and MarketplaceId
            $product->ASIN          = (string)$product->Identifiers->MarketplaceASIN->ASIN;
            $product->MarketplaceId = (string)$product->Identifiers->MarketplaceASIN->MarketplaceId;

            // convert XML object to PHP object
            $product = $this->processSimpleXmlResult( $product );
            $product->prices        =  (array)$prices;

            // add to products array
            $products[ $product->ASIN ] = $product;
        }

        // return product nodes
        return $products;

    } // parseGetLowestOfferListingsForASINResult()
    
	function split_name($name) {
	   list($first_name, $last_name) = explode(' ', $name,2);
	   return array($first_name, $last_name);
	}
    
    function SyncAmazonOrderInSalesOrder($data, $OrderID){
    	global $Config;

	
	/****Ebay*****/
	if($data['0']['OrderType']=='Ebay')
	{
		$data=$data['0'];
		
	}
	/************/

	$listName = $this->split_name($data['ShippingName']);

	$sql = "select count(*) as total, Cid, Email, FirstName, LastName, Phone, Company from e_customers where ShippingName='" . addslashes($data['ShippingName']) . "' and ShippingAddress1='" . addslashes($data['ShippingAddress']) . "' and ShippingCity='" . addslashes($data['ShippingCity']) . "' and ShippingState='" . addslashes($data['ShippingState']) . "' and ShippingCountry='" . addslashes($data['ShippingCountry']) . "' and ShippingZip='" . addslashes($data['ShippingZip']) . "'  ";
	$res = $this->query($sql, 1);

	/*if(!empty($data['Email'])){
    		$sql = "select count(*) as total, Email, FirstName, LastName, Phone, Company from e_customers where Email='" . addslashes($data['Email']) . "' ";
        	$res = $this->query($sql, 1);
	}else{
		$sql = "select count(*) as total, Email, FirstName, LastName, Phone, Company from e_customers where FirstName='" . addslashes($listName[0]) . "' and LastName='" . addslashes($listName[1]) . "'  ";
        	$res = $this->query($sql, 1);
	}*/



	$cust = array();

	/*****Default Customer Entry*********
	if($data['Email']=='orders@ezneterp.com'){
		$data['ShippingName'] = 'Default Customer';
	}
	/*****************/

        if ($res['0']['total'] == '0') {
    	
    		$cust['Email'] = addslashes($data['Email']);
    		$cust['Phone'] = addslashes($data['Phone']);
    		$cust['Company'] = addslashes($data['ShippingName']);			
		$cust['FirstName'] = addslashes($listName[0]);
		$cust['LastName'] = addslashes($listName[1]);
		$cust['Address1'] = addslashes($data['BillingAddress']);
		$cust['City']     = addslashes($data['BillingCity']);
		$cust['State']    = addslashes($data['BillingState']);
		$cust['Country']  = addslashes($data['BillingCountry']);
		$cust['ZipCode']  = addslashes($data['BillingZip']);
		
		$cust['ShippingName'] = addslashes($data['ShippingName']);
		$cust['ShippingCompany'] = addslashes($data['ShippingName']);
		$cust['ShippingAddress1'] = addslashes($data['ShippingAddress']);
		$cust['ShippingCity'] = addslashes($data['ShippingCity']);
		$cust['ShippingState'] = addslashes($data['ShippingState']);
		$cust['ShippingCountry'] = addslashes($data['ShippingCountry']) ;
		$cust['ShippingZip'] = addslashes($data['ShippingZip']) ;
		$cust['ShippingPhone'] = addslashes($data['ShippingPhone']) ;
		
		$cust['Removed'] = 'No';
		$cust['CreatedDate'] = mysql_real_escape_string($Config['TodayDate']);
		$cust['LastUpdate'] = mysql_real_escape_string($Config['TodayDate']);
		$cust['Status'] = 'Yes';
		
		$fields = join(',',array_keys($cust));
      		$values = join("','",array_values($cust));
	    	$strSQLQuery = "INSERT INTO e_customers($fields) values('" .$values."')";
	    	$this->query($strSQLQuery);
	    	$CustID = $this->lastInsertId();
		
		$sql2 = "update e_orders set Cid='".$CustID."' where AmazonOrderId='".$data['AmazonOrderId']."'";
		$this->query($sql2);

		}else{
			$cust['Email']     = $res['0']['Email'];
            $cust['FirstName'] = $res['0']['FirstName'];
            $cust['LastName']  = $res['0']['LastName'];
            $cust['Phone']     = $res['0']['Phone'];
            $cust['Company']   = $res['0']['Company'];
	    	$cust['ShippingAddress1'] =  $res['0']['ShippingAddress1'];
            $cust['ShippingCity']     =  $res['0']['ShippingCity'];
            $cust['ShippingState']    =  $res['0']['ShippingState'];
	    	$cust['ShippingCountry']  =  $res['0']['ShippingCountry'] ;
	    	$cust['ShippingZip']      =  $res['0']['ShippingZip'] ;

			$sql2 = "update e_orders set Cid='".$res['0']['Cid']."' where AmazonOrderId='".$data['AmazonOrderId']."'";
			$this->query($sql2);

		}
	
    	#Insert only for valid users
	if(!($data['OrderStatus']=='Pending' || $data['OrderStatus']=='Cancelled' || $data['OrderStatus']=='Active')){
	$this->sync_order_in_sales($OrderID, $cust);
	}
    }
    
 	function sync_order_in_sales($OrderID,$arryCustDetails) {
    	global $Config;
        if ($OrderID != '') {

           $sql = "SELECT o.* FROM e_orders as o
			where o.OrderID='" . addslashes($OrderID) . "' ";
            $orderres = $this->query($sql, 1);

	   if($orderres[0]['isCustom']>0) return ;	    

            list($CustID, $CustCode, $CustomerName, $CustomerCompany) = $this->sync_customer_in_sales($arryCustDetails);
	    
	   if($orderres['0']['Currency'] != $Config['Currency']){  
                $ConversionRate = CurrencyConvertor(1,$orderres['0']['Currency'],$Config['Currency'],'AR',$orderres['0']['OrderDate']);
            }else{   
                $ConversionRate=1;
            }

            $SqlOrder = "INSERT INTO s_order SET
			OrderDate = '" . addslashes($orderres['0']['OrderDate']) . "',
			Module = 'Order',
			CustID = '" . addslashes($CustID) . "',
			CustCode = '" . addslashes($CustCode) . "',
			CustomerCurrency = '" . addslashes($orderres['0']['Currency']) . "',
			Status = 'Open',
			Approved = '1',
			OrderPaid = '1',
			DeliveryDate = '" . addslashes($orderres['0']['DelivaryDate']) . "',
			PaymentMethod = '" . addslashes($orderres['0']['PaymentGateway']) . "',			
			TotalAmount = '" . addslashes($orderres['0']['TotalPrice']) . "',
			CustomerName = '" . addslashes($CustomerName) . "',
			CustomerCompany = '" . addslashes($orderres['0']['BillingName']) . "',
			BillingName = '" . addslashes($orderres['0']['BillingName']) . "',
			Address = '" . addslashes($orderres['0']['BillingAddress']) . "',
			City = '" . addslashes($orderres['0']['BillingCity']) . "',
			State = '" . addslashes($orderres['0']['BillingState']) . "',
			Country = '" . addslashes($orderres['0']['BillingCountry']) . "',
			ZipCode = '" . addslashes($orderres['0']['BillingZip']) . "',
			Mobile = '" . addslashes($orderres['0']['Phone']) . "',
			Email = '" . addslashes($orderres['0']['Email']) . "',
			ShippingName = '" . addslashes($orderres['0']['ShippingName']) . "',
			ShippingCompany = '" . addslashes($orderres['0']['ShippingCompany']) . "',
			ShippingAddress = '" . addslashes($orderres['0']['ShippingAddress']) . "',
			ShippingCity = '" . addslashes($orderres['0']['ShippingCity']) . "',
			ShippingState = '" . addslashes($orderres['0']['ShippingState']) . "',
			ShippingCountry = '" . addslashes($orderres['0']['ShippingCountry']) . "',
			ShippingZipCode = '" . addslashes($orderres['0']['ShippingZip']) . "',			
			ShippingMobile = '" . addslashes($orderres['0']['ShippingPhone']) . "',
			discountAmnt = '" . addslashes($orderres['0']['DiscountAmount']) . "',
			tax_auths = 'Yes',
			taxAmnt = '" . addslashes($orderres['0']['Tax']) . "',
			SalesPersonID = '" . addslashes($Config['CmpID']) . "',
			AdminID = '" . addslashes($Config['CmpID']) . "',
			CustomerPO = '" . addslashes($orderres['0']['AmazonOrderId']) . "',
			OrderSource = '" . addslashes($orderres['0']['OrderType']) . "',
			Freight = '" . addslashes($orderres['0']['Shipping']) . "',
			ConversionRate = '" . addslashes($ConversionRate) . "',
			ecom_order_id = '" . addslashes($OrderID) . "',
			EntryBy = 'C' ";

            $this->query($SqlOrder, 0);
 
            $saleorderId = $this->lastInsertId();
            $SaleID = 'SO000' . $saleorderId;
            $sql = "update s_order set SaleID = '" . mysql_real_escape_string($SaleID) . "'
			 where OrderID='" . addslashes($saleorderId) . "'";
            $this->query($sql, 0);

           $sql = "SELECT od.OrderItemId as ProductID, od.AmazonSku as ProductSku, od.ProductName, od.Quantity, od.Price, od.TaxRate FROM e_orderdetail as od where od.OrderID='" . addslashes($OrderID) . "' ";
            $orderitemsres = $this->query($sql, 1);
            
            for ($count = 0; $count < count($orderitemsres); $count++) {
		
				$refid = 0;
				if(!is_numeric($orderitemsres[$count]['ProductID'])){
					$itemID = explode("-", $orderitemsres[$count]['ProductID']);
					$orderitemsres[$count]['ProductID'] = $itemID[0];
					$refid = $itemID[1];
				}	
		
                $SqlOrderitem = "INSERT INTO s_order_item SET
			OrderID = '" . addslashes($saleorderId) . "',
			item_id = '" . addslashes($orderitemsres[$count]['ProductID']) . "',
			sku = '" . addslashes($orderitemsres[$count]['ProductSku']) . "',
			description = '" . addslashes($orderitemsres[$count]['ProductName']) . "',
			qty = '" . addslashes($orderitemsres[$count]['Quantity']) . "',		
			price = '" . addslashes($orderitemsres[$count]['Price']) . "',			
			amount = '" . addslashes($orderitemsres[$count]['Price']*$orderitemsres[$count]['Quantity']) . "',
			Taxable = 'Yes',
			ref_id = '".$refid."',
			tax = '" . addslashes($orderitemsres[$count]['TaxRate']) . "' ";
            
                $this->query($SqlOrderitem, 0);

			# Sync inventory;
			$this->syncInventoryAndUpdatePrice($orderitemsres[$count]['ProductSku'],$orderitemsres[$count]['Quantity']);

            }
        }
    }

	public function syncInventoryAndUpdatePrice($sku, $quantity){
			global $Config;
				
			$sql = "select * from amazon_items where ProductSku ='".$sku."'";
			$data = $this->query($sql,1);

			if(!empty($data)){ 
				$finalQnt = $data[0]['Quantity'] - $quantity;
				$finalQnt = ($finalQnt>=0) ? $finalQnt : 0 ;
				$updateamazontSql = "update amazon_items set Quantity='".$finalQnt."' where ProductSku ='".$sku."'";
				$this->query($updateamazontSql,0);
			}
				
			$invsql = "select qty_on_hand from inv_items where Sku ='".$sku."' ";
			$exist = $this->query($invsql,1);
			#for Alias items check			
			if(empty($exist)){
				$invsql = "SELECT ii.* FROM `inv_item_alias` iia INNER JOIN inv_items ii on(iia.item_id=ii.ItemID) where iia.ItemAliasCode='".$sku."' ";
				$exist = $this->query($invsql,1);
				if(!empty($exist[0]['Sku'])) {
					$sku = $exist[0]['Sku'];
				}
			}

			if(!empty($exist)){ 
				$finalQnt1 = $exist[0]['qty_on_hand'] - $quantity;
				$finalQnt1 = ($finalQnt1>=0) ? $finalQnt1 : 0 ;
				$invsql = "update inv_items set qty_on_hand= '".$finalQnt1."' where Sku ='".$sku."' ";
				$this->query($invsql,0);
				
				$invConsql = "update inv_item_quanity_condition set condition_qty= '".$finalQnt1."' where Sku ='".$sku."' ";
				$this->query($invConsql,0);
			}else{
				
				if(empty($data)){ 
					$sql = "select * from e_products where ProductSku ='".$sku."'";
					$data = $this->query($sql,1);
					if(!empty($data)){ 
						$data[0]['Channel'] = 'e-commerce';
						$data[0]['ItemCondition'] = '';
						$data[0]['ItemConditionNote'] = $data[0]['Detail'];
						$data[0]['LastUpdateDate'] = $data[0]['AddedDate'];
						$data[0]['pid'] = $data[0]['ProductID'];
							
						$finalQnt = $data1[0]['Quantity'] - $quantity;
						$finalQnt = ($finalQnt>=0) ? $finalQnt : 0 ;
						$updatetSql = "update e_products set Quantity='".$quantity."' where ProductSku ='".$sku."'";
						$this->query($updatetSql,0);
					}
				}
		
				if(!empty($data)){  
					$split = explode('.',$data[0]['Channel']);
					$insert = "insert into inv_items SET
							   Sku = '".addslashes($data[0]['ProductSku'])."',
							   description = '".addslashes($data[0]['Name'])."',
							   `Condition` = '".addslashes($data[0]['ItemCondition'])."',
							   qty_on_hand = '".$finalQnt."',
							   sell_price = '".$data[0]['Price']."',
							   `Status` = '1',
							   AddedDate = '".$data[0]['LastUpdateDate']."',
							   AdminType = 'admin',
							   CreatedBy = 'admin',
							   long_description = '".addslashes($data[0]['ItemConditionNote'])."',
							   product_source = '".$split[0]."',
							   ref_id = '".$data[0]['pid']."'
							";
					$this->query($insert,0);
					
					if($lastID = $this->lastInsertId()){
						$insertCon = "insert into inv_item_quanity_condition SET
								   ItemID = '".$lastID."',
								   `condition` = '".addslashes($data[0]['ItemCondition'])."',
								   Sku = '".addslashes($data[0]['ProductSku'])."',
								   type = 'Sales',
								   condition_qty = '".$finalQnt."',
								   AvgCost = '".$data[0]['Price']."'
								";
						$this->query($insertCon,0);
					}
				}
			}
			# for update quantity while updating amazon qnt
			#updateTableQntPrice()
		}

    function sync_customer_in_sales($arryDetails) {
        @extract($arryDetails);
        global $Config;

        /* check email exist or not if exit return sales customer id
         * or insert customer and return inserted customer id		 *
         */
	$str = '';
	if(!empty($Phone)) { $str = " and Mobile='".addslashes($Phone)."' "; }
	$sql = "select count(*) as total,Cid,CustCode,FullName,Company from s_customers where FirstName='" . addslashes($FirstName) . "' and LastName='" . addslashes($LastName) . "' $str ";
        $res = $this->query($sql, 1);

	
        if ($res['0']['total'] == '0') {

		/*****Default Customer Entry*********
		if($Email=='orders@ezneterp.com'){
			$Company = 'Default Customer';
			$FirstName = 'Default';
			$LastName = 'Customer';
			$FullName = $Company;
		}
		/*****************/

            // add new
            $ipaddress = GetIPAddress();
            $FullName = $FirstName . ' ' . $LastName;

            $SqlCustomer = "INSERT INTO s_customers SET
			CustomerType = 'Individual', 
			Company = '" . mysql_real_escape_string(strip_tags($Company)) . "',
			FirstName='" . mysql_real_escape_string(strip_tags($FirstName)) . "',
			LastName = '" . mysql_real_escape_string(strip_tags($LastName)) . "', 
			FullName = '" . mysql_real_escape_string(strip_tags($FullName)) . "', 
			Gender = 'Male', 
			 
			Mobile = '" . mysql_real_escape_string($Phone) . "', 
			Email = '" . mysql_real_escape_string(strip_tags($Email)) . "', 
			CreatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "', 
			CustomerSince = '" . mysql_real_escape_string($Config['TodayDate']) . "', 
			ipaddress = '" . $ipaddress . "', 
			Status='Yes' ";

            $this->query($SqlCustomer, 0);



            $customerId = $this->lastInsertId();

            $CustCode = 'CUST00' . $customerId;

            $sql = "update s_customers set CustCode = '" . mysql_real_escape_string($CustCode) . "'
			 where Cid='" . addslashes($customerId) . "'";
            $this->query($sql, 0);

	   #save other details into address book
	   $this->insertToAddressBook($arryDetails,$customerId);
		
            return array($customerId, $CustCode, $FullName, $Company);
        } else {
            return array($res['0']['Cid'], $res['0']['CustCode'], $res['0']['FullName'], $res['0']['Company']);
        }
    }

	
     function insertToAddressBook($Data, $CustID){
		global $Config;
		extract($Data);

		$city = $this->GetCitybyID($ShippingCity);
		$state = $this->GetStatebyID($ShippingState);
		$country = $this->getCountryByName($ShippingCountry);

		 $FullName = $FirstName . ' ' . $LastName;

		if($CustID):
			$SqlCustomer = "INSERT INTO s_address_book SET
			CustID = '".$CustID."',
			AddType = 'billing',
			PrimaryContact = '1',
			FirstName = '" . mysql_real_escape_string(strip_tags($FirstName)) . "',
			LastName = '" . mysql_real_escape_string(strip_tags($LastName)) . "',
			Company = '" . mysql_real_escape_string(strip_tags($Company)) . "',
			FullName = '" . mysql_real_escape_string(strip_tags($FullName)) . "',
			Email = '" . mysql_real_escape_string(strip_tags($Email)) . "',

			Address = '" . mysql_real_escape_string(strip_tags($ShippingAddress1)) . "',
			CountryName = '" . mysql_real_escape_string(strip_tags($ShippingCountry)) . "',
			StateName = '" . mysql_real_escape_string(strip_tags($ShippingState)) . "',
			CityName = '" . mysql_real_escape_string(strip_tags($ShippingCity)) . "',

			country_id = '" . mysql_real_escape_string(strip_tags($country[0]['country_id'])) . "',
			state_id = '" . mysql_real_escape_string(strip_tags($state[0]['state_id'])) . "',
			city_id = '" . mysql_real_escape_string(strip_tags($city[0]['city_id'])) . "',

			ZipCode = '" . mysql_real_escape_string(strip_tags($ShippingZip)) . "',
			Mobile = '" . mysql_real_escape_string(strip_tags($Phone)) . "',
			CreatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "',
			UpdatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "' 
			";
			$this->query($SqlCustomer, 0);
		
			$SqlCustomer = "INSERT INTO s_address_book SET
			CustID = '".$CustID."',
			AddType = 'shipping',
			PrimaryContact = '1',
			FirstName = '" . mysql_real_escape_string(strip_tags($FirstName)) . "',
			LastName = '" . mysql_real_escape_string(strip_tags($LastName)) . "',
			Company = '" . mysql_real_escape_string(strip_tags($Company)) . "',
			FullName = '" . mysql_real_escape_string(strip_tags($FullName)) . "',
			Email = '" . mysql_real_escape_string(strip_tags($Email)) . "',

			Address = '" . mysql_real_escape_string(strip_tags($ShippingAddress1)) . "',
			CountryName = '" . mysql_real_escape_string(strip_tags($ShippingCountry)) . "',
			StateName = '" . mysql_real_escape_string(strip_tags($ShippingState)) . "',
			CityName = '" . mysql_real_escape_string(strip_tags($ShippingCity)) . "',

			country_id = '" . mysql_real_escape_string(strip_tags($country[0]['country_id'])) . "',
			state_id = '" . mysql_real_escape_string(strip_tags($state[0]['state_id'])) . "',
			city_id = '" . mysql_real_escape_string(strip_tags($city[0]['city_id'])) . "',

			ZipCode = '" . mysql_real_escape_string(strip_tags($ShippingZip)) . "',
			Mobile = '" . mysql_real_escape_string(strip_tags($Phone)) . "',
			CreatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "',
			UpdatedDate = '" . mysql_real_escape_string($Config['TodayDate']) . "' 
			";
			$this->query($SqlCustomer, 0);
			
		endif;
	}

    /*---------------------------*/
	function  GetStatebyID($name)
	{
		$strSQLQuery = "select state_id from erp.state where  LCASE(name)='".mysql_real_escape_string(strtolower(trim($name)))."'";
		return $this->query($strSQLQuery, 1);
	}

	function  GetCitybyID($name)
	{
		$strSQLQuery = "select city_id from erp.city where LCASE(name)='".mysql_real_escape_string(strtolower(trim($name)))."'";
		return $this->query($strSQLQuery, 1);
	}


        function getCountryByName($name)
	{
            $sql="select country_id from erp.country where LCASE(name) = '".mysql_real_escape_string(strtolower(trim($name)))."' ";
            return $this->query($sql);
	} 
    /*---------------------------*/



    function runAmazonOrder($objRegion, $Prefix){
    	global $Config; $accArr = array();
    	$objConfig=new admin();
    	$accounts = $this->getAccountAll();
	
	foreach($accounts as $acc) $accArr[strtolower($acc['url'])] = $acc['id'];

	       $merchant = '';
	       if(!empty($accounts)){
			   foreach ($accounts as $account ) {
			   		
				    if($account['merchant_id']==$merchant) continue; 
			   	    else $merchant = $account['merchant_id'];

				   	$Amazonservice = $this->AmazonSettingsForOrder($Prefix,false,$account['id']);
				   	
				   	if($account['last_orders_sync']>0){
				   		$lastdate = $account['last_orders_sync'];
				   	}else if($account['sync_orders'] && $account['from_date']>0){
				   		$lastdate = $account['from_date'];
				   	}
			       //$lastdate = $objProduct->getDateOfLastOrder($account['id']);
			       $days = isset($_REQUEST['days']) && $_REQUEST['days'] ? $_REQUEST['days'] : false;
				   if ( ! $lastdate && ! $days ) $days = 2;
				   
				   $amazonOrders = '';
				   if($Amazonservice)
			       $amazonOrders = $this->getAmazonOrders($Amazonservice, $lastdate, $days);
			       
			       /********Connecting to main database*********/
					//$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbMain'];
					$objConfig->connect();
					/*******************************************/
					if ( is_array( $amazonOrders ) ) { 
				       	foreach($amazonOrders as $amazonOrder){ 
				       		if($amazonOrder->ShippingAddress->CountryCode){
							$arryCountry = $objRegion->getCountryByCode($amazonOrder->ShippingAddress->CountryCode); 
							if(!empty($arryCountry)){
								$amazonOrder->ShippingAddress->CountryCode = $arryCountry[0]['name'];
								$arryState = $objRegion->GetStateByCode($amazonOrder->ShippingAddress->StateOrRegion, $arryCountry[0]['country_id']);
								if(!empty($arryState)){
									$amazonOrder->ShippingAddress->StateOrRegion = $arryState[0]['name'];
								} 
							}
				       		}
				       		 
				       	}
					}
			       /******Connecting to company database*******/
					//$Config['DbName'] = $Config['DbName'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/*******************************************/
					
			      # echo "<pre>";print_r($amazonOrders);die;
			       
			       $count = 0;
			       if ( is_array( $amazonOrders ) ) { 
			       	
				       	foreach($amazonOrders as $amazonOrder){

						$acID = '';
				       		$acID = $accArr[strtolower($amazonOrder->SalesChannel)];
				       		$account['id'] =  !empty($acID) ? $acID : $account['id'];

							if($Amazonservice) 
				       		$productId = $this->importOrder($amazonOrder, $account, $Amazonservice);

				       		if($productId>0) $count++;
				       	}
				       	
				       	if($count>0) {$_SESSION['mess_order'] = $count.' Order(s) were processed for amazon acount(s)';}
						else{ $_SESSION['mess_order'] = 'No Amazon order is available for syncing.';}
			       	
			       }else{
			       		$_SESSION['mess_order'] = $amazonOrders;
			       }
			       
			       # update last order update date 
			       $this->updateDateOfLastOrder($account['id'], $amazonOrders);
				}
	       }else{
				$_SESSION['mess_order'] = "No Amazon Account is Added";
			} 
	}

/*------------------------- Run Report for Update Fees ---------------------------------*/
	function runReportForFees($Prefix){
	   global $Config;
	   $objConfig=new admin();
	   $accounts = $this->getAccountAll();
	       
       if(!empty($accounts)){
		   foreach ($accounts as $account ) {
		   		$AmazonserviceForReport = $this->AmazonSettings($Prefix,false,$account['id']);
		   		 $this->getAmazonReportList($Prefix, $AmazonserviceForReport);
		   }
       }else{
			$_SESSION['mess_order'] = "No Amazon Account is Added";
		} 
	}
	
	function getAmazonReportList($Prefix, $service){
		
		 $request = new MarketplaceWebService_Model_GetReportListRequest();
		 $request->setMerchant($this->MERCHANT_ID);
		 $request->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
		 $request->setAvailableFromDate(new DateTime('-2 months', new DateTimeZone('UTC')));
		 $typeList = new MarketplaceWebService_Model_TypeList();
		 $request->setReportTypeList($typeList->withType('_GET_V2_SETTLEMENT_REPORT_DATA_FLAT_FILE_'));
		 $request->setMaxCount(3);
		 $request->setAcknowledged(false);
		 $request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
  
	 try {
            $response = $service->getReportList($request);
                if ($response->isSetGetReportListResult()) {
                 $getReportListResult = $response->getGetReportListResult();
                 $reportInfoList = $getReportListResult->getReportInfoList(); 
                 foreach ($reportInfoList as $reportInfo) { 
                	if ($reportInfo->getReportType()=='_GET_V2_SETTLEMENT_REPORT_DATA_FLAT_FILE_') 
                        { 
                           return $this->getAmazonReport($Prefix, $service, $reportInfo->getReportId());
			   break;
                        }
                 }
                } 
		     } catch (MarketplaceWebService_Exception $ex) {
				 echo("Caught Exception: " . $ex->getMessage() . "\n");
		         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
		         echo("Error Code: " . $ex->getErrorCode() . "\n");
		         echo("Error Type: " . $ex->getErrorType() . "\n");
		     }
  }
 
 function getAmazonReport($Prefix, $service, $reportID){
 	global $Config;
	$request = new MarketplaceWebService_Model_GetReportRequest();
	$request->setMerchant($this->MERCHANT_ID);
	$request->setReport(@fopen('php://memory', 'rw+'));
	$request->setReportId($reportID);
	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
    
    try { 
           $response = $service->getReport($request);
           //echo stream_get_contents($request->getReport()) ;die;
          $feeData = $this->getAmazonFeesFromXLS($Prefix, $request->getReport() );
          //if(!empty($feeData)) $this->updateFees($feeData);
//pr($feeData,0);
	  if(!empty($feeData)) {
						foreach ($feeData as $key => $values){
								if($values>0){
										 $this->AddFeesToGL($Prefix,'Amazon',$values,$this->getInvoiceIDFomSales($key));
								}
						}
          	$this->updateFees($feeData);
          }
              
     } catch (MarketplaceWebService_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
     }
 }
 
 
 function getAmazonFeesFromXLS($Prefix, $FileData){
 	
    require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');
  	  $Filepath = "/var/www/html/erp/csv/test.xls";
  	  file_put_contents($Filepath,'hh');
  	  file_put_contents($Filepath,$FileData);
			#echo '<pre>';print_r($_POST);exit;
			$Spreadsheet = new SpreadsheetReader($Filepath);
			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
			$LeadAddedCount = 0;
			$LeadCount = 0;
			$arrayFees=array();
			foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				
				foreach ($Spreadsheet as $Key => $Row){
					if($Count==0){
						$orderIdIndex = array_search('order-id', $Row);
						$transtTypeIndex = array_search('transaction-type', $Row);
				        $orderFeesIndex = array_search('item-related-fee-amount', $Row);
					}
					//echo "<pre>";	print_r($Row);echo "</pre>"; die;
					if(!empty($Row[$orderIdIndex]) && $Row[$transtTypeIndex]=='Order'){
						$fees = (is_numeric($Row[$orderFeesIndex])) ? abs($Row[$orderFeesIndex]):0;
						
						if(array_key_exists($Row[$orderIdIndex],$arrayFees)){ 
							$arrayFees[$Row[$orderIdIndex]] = $arrayFees[$Row[$orderIdIndex]] + $fees;
						}else{
							$arrayFees[$Row[$orderIdIndex]] = $fees;
						}
					}
					$Count++;
				}
			}
			
			return $arrayFees;
 }
 
        function updateFees($data){
	 	if(!empty($data)){
	 		foreach ($data as $key => $values){
		 		$strSQLQuery1 = "update e_orders set Fee='".$values."' where AmazonOrderId = '" . $key ."' ";
        		$this->query($strSQLQuery1, 1);
		 		$strSQLQuery = "update s_order set Fee='".$values."' where CustomerPO = '" . $key ."' ";
        		$this->query($strSQLQuery, 1);
	 		}
	 	}
 	}
 
   function Sales_order_exists( $CustomerPO) {
        $strSQLQuery = "select CustomerPO, Fee from s_order where CustomerPO = '" . $CustomerPO."' ";
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['CustomerPO'])) {
            return true;
        } else {
            return false;
        }
   }

  function getEmptyFees( $CustomerPO) {
        $strSQLQuery = "select CustomerPO, Fee from s_order where CustomerPO = '" . $CustomerPO."' ";
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['CustomerPO'])) {
            return $arryRow[0]['Fee'];
        } else {
            return 1;
        }
  }

 function getSaleIDFomSales( $CustomerPO ) {
        $strSQLQuery = "select SaleID,CustomerCurrency,OrderDate from s_order where CustomerPO = '" . $CustomerPO."' ";
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['SaleID'])) {
		$Config['Currency'] = $arryRow[0]['CustomerCurrency'];
            return array($arryRow[0]['SaleID'],$arryRow[0]['OrderDate']);
        } else {
            return 0;
        }
  }

  function journal_reference_exists( $ReferenceID) {
        $strSQLQuery = "select ReferenceID from f_gerenal_journal where ReferenceID = '" .$ReferenceID."' ";
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['ReferenceID'])) {
            return true;
        } else {
            return false;
        }
   }

/********************Bhoodev*******************/

function getInvoiceIDFomSales( $CustomerPO ) {
        //$strSQLQuery = "select SaleID,CustomerCurrency,OrderDate,OrderID,Fee,InvoiceID,ConversionRate from s_order where CustomerPO = '" . $CustomerPO."' and Module='Invoice' and PostToGL = 1 and OrderSource ='Amazon' and Fee = 0 ";
 $strSQLQuery = "select SaleID,CustomerCurrency,OrderDate,OrderID,Fee,InvoiceID,ConversionRate from s_order where CustomerPO = '" . $CustomerPO."' and Module='Invoice' and PostToGL = '1' and OrderSource ='Amazon' and Fee = '0'  ";
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['OrderID'])) {
						$Config['Currency'] = $arryRow[0]['CustomerCurrency'];
            return array($arryRow[0]['SaleID'],$arryRow[0]['OrderDate'],$arryRow[0]['OrderID'],$arryRow[0]['InvoiceID'],$arryRow[0]['ConversionRate']);
        } else {
            return 0;
        }
  }


/************************************************/

  private function AddFeesToGL($Prefix,$type,$fees,$ReferenceDetails){


	$ReferenceID = 0;
	if(!empty($ReferenceDetails)){
	 $ReferenceID = $ReferenceDetails[0];
	 $glDate = $ReferenceDetails[1];
$InvoiceID = $ReferenceDetails[3];
$ConversionRate =$ReferenceDetails[4];
	}		
	
	if( empty($ReferenceID) || $this->journal_reference_exists($ReferenceID)){ return;}

  	global $Config;
  	require_once($Prefix."classes/finance.journal.class.php");
	require_once($Prefix."classes/finance.account.class.php");
  	$objJournal = new journal();
	$objBankAccount = new BankAccount();
	# for debit
	if($type=='Amazon'){
	$AccountID1 = $objJournal->getSettingVariable('AmazonAccount');
	
	}else if($type=='Ebay'){
	$AccountID1 = $objJournal->getSettingVariable('EbayAccount');
	}
	$AccDeatail1 = $objBankAccount->getAccountNameByID($AccountID1);
	
	# for Credit
	$AccountID2 = $objJournal->getSettingVariable('AmazonEbayFee');
	$AccDeatail2 = $objBankAccount->getAccountNameByID($AccountID2);
if($AccountID1>0 && $AccountID2>0){

	$fees = round(GetConvertedAmount($ConversionRate, $fees) ,2);

  	$arryDetails = array(
  	'JournalMemo'=>$type.'-'.$InvoiceID,
  	'TotalDebit'=>$fees,
  	'TotalCredit'=>$fees,
  	'NumLine'=>'2',
  	'AccountID1'=>$AccountID1,
  	'AccountID2'=>$AccountID2,
  	'AccountName1'=>$AccDeatail1[0]['AccountName'].'['.$AccDeatail1[0]['AccountNumber'].']',
  	'AccountName2'=>$AccDeatail2[0]['AccountName'].'['.$AccDeatail2[0]['AccountNumber'].']',
  	'DebitAmnt1'=>'',
  	'DebitAmnt2'=>$fees,
  	'CreditAmnt1'=>$fees,
  	'CreditAmnt2'=>'',
	  'Comment1'=>$type,
  	'Comment2'=>$type,
	  'LocationID'=>'1',
	  'ReferenceID'=>$ReferenceID,
	  'JournalType'=>'one_time',
  	'JournalNo'=>'',
	  'JournalDate'=>$glDate,
	  'journalPrefix'=>$objJournal->getSettingVariable('JOURNAL_NO_PREFIX')
  	);
  	//pr($arryDetails);
  	$JournalID = $objJournal->addJournal($arryDetails,$journalPrefix);
  	if(!empty($JournalID)){				
		$objJournal->AddUpdateJournalEntry($JournalID, $arryDetails);
			$arryJournalEntry = $objJournal->GetJournalEntry($JournalID);
				$objJournal->PostJournalEntryToGL($arryJournalEntry,$JournalID);
  	}
  }
  }
/*------------------------- End of Run Report for Update Fees ---------------------------------*/

  /*------------------- SEARCH AMAZON PRODUCT LISTS ------------------------*/
  function AmazonProductSettings($Prefix, $amazon_setting_path, $AccID){
  
  	$amazon_setting_path = (!empty($amazon_setting_path)) ? '../../':$Prefix;
  
  	$AmazonSetting = $this->GetAmazonAccount($AccID, true);
  	if(!empty($AmazonSetting)){
  		include ($Prefix.'admin/e-commerce/amazon-setting.php');
  
  		$config = array (
  				'ServiceURL' => $this->SERVICE_PRODUCT_URL,
  				'ProxyHost' => null,
  				'ProxyPort' => -1,
  				'ProxyUsername' => null,
  				'ProxyPassword' => null,
  				'MaxErrorRetry' => 3,
  		);
  		return $service = new MarketplaceWebServiceProducts_Client(
  				$this->AWS_ACCESS_KEY_ID,
  				$this->AWS_SECRET_ACCESS_KEY,
  				APPLICATION_NAME,
  				APPLICATION_VERSION,
  				$config);
  	}else{
  		return false;
  	}
  }
  
  
  public function searchProduct($service, $queryStr, $cat){
  	if(!$service) {echo "Account is not active!"; die;}
  	$request = new MarketplaceWebServiceProducts_Model_ListMatchingProductsRequest();
  	$request->setSellerId($this->MERCHANT_ID);
  	$request->setMarketplaceId($this->MARKETPLACE_ID);
  	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
  	if(!empty($cat)) $request->setQueryContextId($cat);
  	$request->setQuery($queryStr);
  	try {
  		$response = $service->listMatchingProducts($request);
  		$result = $this->parseXML($response->toXML());
  		$result = $this->processSimpleXmlResult($result);
  		return $result;
  	}
  	catch (MarketplaceWebServiceProducts_Exception $ex) {
  		echo("Caught Exception: " . $ex->getMessage() . "\n");
  		echo("Response Status Code: " . $ex->getStatusCode() . "\n");
  		echo("Error Code: " . $ex->getErrorCode() . "\n");
  		echo("Error Type: " . $ex->getErrorType() . "\n");
  		echo("Request ID: " . $ex->getRequestId() . "\n");
  		echo("XML: " . $ex->getXML() . "\n");
  	}
  
  }
  
  /*  public function searchProductById($service, $queryStr, $cat){
   $request = new MarketplaceWebServiceProducts_Model_GetMatchingProductForIdRequest();
   $request->setSellerId($this->MERCHANT_ID);
   $request->setMarketplaceId($this->MARKETPLACE_ID);
   $request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
   $request->setIdType('SellerSKU');
   $request->setIdList('jjjj');
   $request->setQuery($queryStr);
   try {
   $response = $service->GetMatchingProductForId($request);
   $result = $this->parseXML($response->toXML());
   $result = $this->processSimpleXmlResult($result);
   return $result;
   }
   catch (MarketplaceWebServiceProducts_Exception $ex) {
   echo("Caught Exception: " . $ex->getMessage() . "\n");
   echo("Response Status Code: " . $ex->getStatusCode() . "\n");
   echo("Error Code: " . $ex->getErrorCode() . "\n");
   echo("Error Type: " . $ex->getErrorType() . "\n");
   echo("Request ID: " . $ex->getRequestId() . "\n");
   echo("XML: " . $ex->getXML() . "\n");
   }
  
   }
  
   public function GetLowestOfferListingsForSKU($service, $queryStr, $cat){
   $request = new MarketplaceWebServiceProducts_Model_GetLowestPricedOffersForSKURequest();
   $request->setSellerId($this->MERCHANT_ID);
   $request->setMarketplaceId($this->MARKETPLACE_ID);
   $request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
   $request->setItemCondition("new");
   $request->setSellerSKU("SANJIV-001");
    
   try {
   $response = $service->GetLowestPricedOffersForSKU($request);
   pr($response,1);
   echo "<pre>";
   echo ("Service Response\n");
   echo ("=============================================================================\n");
  
   $dom = new DOMDocument();
   $dom->loadXML($response->toXML());
   $dom->preserveWhiteSpace = false;
   $dom->formatOutput = true;
   echo $dom->saveXML();
   echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
   }
   catch (MarketplaceWebServiceProducts_Exception $ex) {
   echo("Caught Exception: " . $ex->getMessage() . "\n");
   echo("Response Status Code: " . $ex->getStatusCode() . "\n");
   echo("Error Code: " . $ex->getErrorCode() . "\n");
   echo("Error Type: " . $ex->getErrorType() . "\n");
   echo("Request ID: " . $ex->getRequestId() . "\n");
   echo("XML: " . $ex->getXML() . "\n");
   }
  
   }
  
   public function GetCompetitivePricingForSKU($service, $queryStr, $cat){
   $request = new MarketplaceWebServiceProducts_Model_GetCompetitivePricingForSKURequest();
   $request->setSellerId($this->MERCHANT_ID);
   $request->setMarketplaceId($this->MARKETPLACE_ID);
   $request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
   $sku_List = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
   $sku_List->setSellerSKU(array("673646-b21","383265-001"));
  
   $request->setSellerSKUList($sku_List);
   $response = $service->GetCompetitivePricingForSKU($request);
   pr($response,1);
   //$request->
   try {
   $response = $service->GetCompetitivePricingForSKU($request);
  
   echo ("Service Response\n");
   echo ("=============================================================================\n");
  
   $dom = new DOMDocument();
   $dom->loadXML($response->toXML());
   $dom->preserveWhiteSpace = false;
   $dom->formatOutput = true;
   echo $dom->saveXML();
   echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
   }
   catch (MarketplaceWebServiceProducts_Exception $ex) {
   echo("Caught Exception: " . $ex->getMessage() . "\n");
   echo("Response Status Code: " . $ex->getStatusCode() . "\n");
   echo("Error Code: " . $ex->getErrorCode() . "\n");
   echo("Error Type: " . $ex->getErrorType() . "\n");
   echo("Request ID: " . $ex->getRequestId() . "\n");
   echo("XML: " . $ex->getXML() . "\n");
   }
  
   } */
  
  
  
  public function GetLowestPricingForSKU($service, $condition, $sku){
	if (strpos($condition, 'New')!==false){ 
		$condition = 'New';
	}elseif (strpos($condition, 'Used')!==false){
		$condition = 'Used';
	}elseif (strpos($condition, 'Collectible')!==false){
		$condition = 'Collectible';
	}elseif (strpos($condition, 'Refurbished')!==false){
		$condition = 'Refurbished';
	}elseif (strpos($condition, 'Club')!==false){
		$condition = 'Club';
	}else{
		$condition = '';
	}
  	$request = new MarketplaceWebServiceProducts_Model_GetLowestPricedOffersForSKURequest();
  	$request->setSellerId($this->MERCHANT_ID);
  	$request->setMarketplaceId($this->MARKETPLACE_ID);
  	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
	if(!empty($condition))
  	$request->setItemCondition($condition);
  	$request->setSellerSKU($sku);
  
  	try {
  		$response = $service->GetLowestPricedOffersForSKU($request);
  		$response = $this->parseXML($response->toXML());
  		$response = $this->processSimpleXmlResult($response);
  		$buyBoxData = $response->GetLowestPricedOffersForSKUResult->Summary->LowestPrices->LowestPrice;
  
  		$priceArr = array();
  		if(is_array($buyBoxData)){
  			foreach($buyBoxData as $buyBox){
  				$buyBox = (array) $buyBox;
  				if(strtolower($buyBox['@attributes']->condition)==strtolower($condition)) { 
  					$priceArr['LandedPrice'] = $buyBox['LandedPrice']->Amount;
  					$priceArr['ListingPrice'] = $buyBox['ListingPrice']->Amount;
  					$priceArr['Shipping'] = $buyBox['Shipping']->Amount;
  					return $priceArr;
  				}
  			}
  		}else{
  			$priceArr['LandedPrice'] = $buyBoxData->LandedPrice->Amount;
  			$priceArr['ListingPrice'] = $buyBoxData->ListingPrice->Amount;
  			$priceArr['Shipping'] = $buyBoxData->Shipping->Amount;
  			return $priceArr;
  		}
  		/* $dom = new DOMDocument();
  		 $dom->loadXML($response->toXML());
  		 $dom->preserveWhiteSpace = false;
  		 $dom->formatOutput = true;
  		 echo $dom->saveXML(); */
  		//pr($x,1);
  	}
  	catch (MarketplaceWebServiceProducts_Exception $ex) {
  		echo("Caught Exception: " . $ex->getMessage() . "\n");
  		echo("Response Status Code: " . $ex->getStatusCode() . "\n");
  		echo("Error Code: " . $ex->getErrorCode() . "\n");
  		echo("Error Type: " . $ex->getErrorType() . "\n");
  		echo("Request ID: " . $ex->getRequestId() . "\n");
  		echo("XML: " . $ex->getXML() . "\n");
		echo "<hr/>";
//exit;
  	}
  
  }
  
  
  public function getLowestOfferListingForASIN($service, $queryStr, $ItemCondition){
  	$request = new MarketplaceWebServiceProducts_Model_GetLowestOfferListingsForASINRequest();
  	$request->setSellerId($this->MERCHANT_ID);
  	$request->setMarketplaceId($this->MARKETPLACE_ID);
  	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
  	$request->setItemCondition($ItemCondition);
  	$sku_List = new MarketplaceWebServiceProducts_Model_ASINListType();
  	$sku_List->setASIN(( $queryStr ));
  	//$sku_List = new MarketplaceWebServiceProducts_Model_SellerSKUListType();
  	//$sku_List->setSellerSKU(array("673646-b21","383265-001"));
  	//pr($queryStr);
  	$request->setASINList($sku_List);
  	try {
  		$response = $service->GetLowestOfferListingsForASIN($request);
  		$result = $this->parseXML($response->toXML());
  		return $result = $this->processSimpleXmlResult($result);
  	}
  	catch (MarketplaceWebServiceProducts_Exception $ex) {
  		echo("Caught Exception: " . $ex->getMessage() . "\n");
  		echo("Response Status Code: " . $ex->getStatusCode() . "\n");
  		echo("Error Code: " . $ex->getErrorCode() . "\n");
  		echo("Error Type: " . $ex->getErrorType() . "\n");
  		echo("Request ID: " . $ex->getRequestId() . "\n");
  		echo("XML: " . $ex->getXML() . "\n");
  	}
  
  }
  
  public function updateASIN($ASIN, $itemID, $ProductTypeName){
  	$ProductTypeName = ($ProductTypeName) ? ", ProductTypeName='".$ProductTypeName."' " : '';
  	$sql = "UPDATE amazon_items set ProductType = 'ASIN', ProductCode = '".addslashes($ASIN)."', FeedProcessingStatus='UnProcessed' $ProductTypeName where itemID='".addslashes($itemID)."' and Channel like '%amazon%' ";
  	$this->query($sql, 0);
  }
  
  public function updateASINAjax($ASIN, $itemID){
  	$sql = "UPDATE amazon_items set ProductType = 'ASIN', ProductCode = '".addslashes($ASIN)."' where itemID='".addslashes($itemID)."' and Channel like '%amazon%'  ";
  	$this->query($sql, 0);
  }
  
  public function updateFeedProcessingStatus($FeedProcessingStatus, $itemID){
  	$Error = ($FeedProcessingStatus=='Error') ? ', Status=1' : '';
  	$sql = "UPDATE amazon_items set FeedProcessingStatus='".addslashes($FeedProcessingStatus)."' $Error where itemID='".addslashes($itemID)."' and Channel like '%amazon%'  ";
  	$this->query($sql, 0);
  }
  
  public function AddAmazonProductToInlineList($productID){
			$account = $this->GetAmazonAccountBySetDefault();
			if(empty($account)) {echo 'Default Account or lowest price is not On. Please On first!!'; exit ;}
			//$productIDs = implode(",", $productIDs);
			$sql = "select Name, ProductSku, ProductID itemID, Detail ShortDetail, Price Price, Price2 Price2, Quantity Quantity,NOW() LaunchDate,NOW() SaleStartDate, m.Mname Brand from e_products p left join e_manufacturers m on(m.Mid=p.Mid) where ProductID='".$productID."' ";
			$productList = $this->query($sql,1);
			
			$vS = true ;
			$emptyName ='';
			if(empty($productList[0]['ProductSku'])) { $emptyName .= ' Sku ';$vS = false;  }
			if(empty($productList[0]['Name'])) { $emptyName .= ' Title ';$vS = false;  }
			if($productList[0]['Price']<1) { $emptyName .= ' Price '; $vS = false;  }
			if($productList[0]['Quantity']<1) { $emptyName .= ' Quantity '; $vS = false;  }
			
			if($vS){
				foreach ($productList as $list){
					$list['AmazonAccountID']=$account[0]['id'];
					$list['ItemCondition']=$account[0]['set_condition'];
					$list['MfrPartNumber']=$list['ProductSku'];
					$list['ShortDetail']=$list['Name'];
					$list['Brand']=($account[0]['brand']) ? $list['Brand'] : ''; //settings
					$list['ItemConditionNote']=(!empty($account[0]['condition_note'])) ? $account[0]['condition_note'] : $account[0]['item_condition'].' offer' ;
					$list['FulfilledBy']=$account[0]['fulfilled_by'];
					$list['TaxCode']='A_GEN_NOTAX';
					$list['ProductType']='ASIN';
					$list['FeedProcessingStatus']='UnProcessed';
					$this->saveAmazonData($list);
				}
			}else{
				$_SESSION['mess_product']= 'Amazon: Submission failded.'.$emptyName.' fields are empty!';
				header('location: viewProduct.php?curP='.$_GET["curP"]);
				exit;
			}
		}

  public function AddAmazonProductToList($productarry){
  	extract($productarry);
  	$account = $this->GetAmazonAccount($AmazonAccountID,true);
  	//$productIDs = implode(",", $productIDs);
  	$sql = "select Name, ProductSku, ProductID itemID, Detail ShortDetail, Price Price, Price2 Price2, Quantity Quantity,NOW() LaunchDate,NOW() SaleStartDate from e_products where ProductID IN($AddToAmazon) ";
  	 
  	$productList = $this->query($sql,1);
  	foreach ($productList as $list){
  		$list['AmazonAccountID']=$AmazonAccountID;
  		$list['ItemCondition']=($ItemCondition)?$ItemCondition:$account[0]['item_condition'];
  		//$list['Cat']=($Cat)?$Cat:$account[0]['Default_cat'];
  		$list['Brand']=$Brand;
  		$list['ItemConditionNote']=$ItemConditionNote;
  		$list['FulfilledBy']=$account[0]['fulfilled_by'];
  		$list['TaxCode']='A_GEN_NOTAX';
  		$list['ProductType']='ASIN';
  		$list['FeedProcessingStatus']='UnProcessed';
  		$this->saveAmazonData($list);
  	}
  }
  
  function getLowestPriceASIN($Prefix){
  	global $Config;
  	$objConfig=new admin();
  	$accounts = $this->getAccountAll();
  
  	$merchant = '';
  	if(!empty($accounts)){
  		foreach ($accounts as $account ) {
  
  			$sql1 = "select count(*) count from amazon_items where ProductCode='' and AmazonAccountID='".$account['id']."' and Channel like '%amazon%' ";
  			$rowCount = $this->query($sql1, 1);
  
  			$sql = "select p1.pid, p1.itemID, p1.ProductCode, p1.Cat, p1.ProductSku from amazon_items p1 left join e_products p2 on(p1.itemID = p2.ProductID) where ProductCode='' and AmazonAccountID='".$account['id']."' and Channel like '%amazon%' LIMIT 25";
  			$asinLists = $this->query($sql, 1);
  			//pr($asinLists,1); #false for cron run other wise set as true
  			$Amazonservice = $this->AmazonProductSettings($Prefix,false,$account['id']);
  			if(!empty($asinLists)):
  			foreach ($asinLists as $list){
  				$result_ASIN =   $this->searchProduct($Amazonservice,trim($list['ProductSku']),$list['Cat']);
  					
  				$ASIN_List = $rList = $lowest_ASIN = $listprice = array();
  				if(!empty($result_ASIN)){
  					foreach ($result_ASIN as $values){
  						array_push($ASIN_List, $values->ASIN);
  						$rList[$values->ASIN] = $values;
  					}
  					$lowest_ASIN = $this->getLowestOfferListingForASIN($Amazonservice, array_slice($ASIN_List, 0, 20), $list['ItemCondition']);
  				}
  
  				if(!empty($lowest_ASIN)):
  				foreach ($lowest_ASIN as $key=>$price){
  					$p = $price->prices[0]->LandedPrice;
  					if($p>0)
  						$listprice[$key] = ($p)? $p : 0 ;
  				}
  				asort($listprice);
  				foreach ($listprice as $key => $value){
  					$pvalues = $rList[$key];
  					$this->updateASIN( $key, $list['itemID'], $pvalues->AttributeSets->ItemAttributes->ProductTypeName );
  					break;
  				}
  				endif;
  			}
  			endif;
  
  			if($rowCount[0]['count']>count($asinLists)){
  				sleep(120);
  				$this->getLowestPriceASIN($Prefix);
  			}
  		}// account foreach close
  	}
  }
  
  public function listBatchAmazon($Prefix){
  	global $Config;
  	require_once($Prefix."classes/manufacturer.class.php");
  	$objConfig=new admin();
  	$objManufacturer = new Manufacturer();
  	$accounts = $this->getAccountAll();
  
  	$merchant = '';
  	if(!empty($accounts)){
  		foreach ($accounts as $account ) {
  
  			$sql = "select p1.*, Mid from amazon_items p1 left join e_products p2 on(p1.itemID = p2.ProductID) where FeedProcessingStatus='UnProcessed' and AmazonAccountID='".$account['id']."' and Channel like '%amazon%' ";
  			$asinLists = $this->query($sql, 1);
  			//pr($asinLists,1);
  			$Amazonservice = $this->AmazonSettings($Prefix,true,$account['id']);
  			$arryManufacturer = $objManufacturer->getManufacturer('',1,'','','');
  			if(!empty($asinLists)):
  			$feed = '<?xml version="1.0" encoding="iso-8859-1"?>
					<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
					xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
					<Header>
					<DocumentVersion>1.01</DocumentVersion>
					<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
					</Header>
					<MessageType>Product</MessageType>
					<PurgeAndReplace>false</PurgeAndReplace>';
  
  			$msgCount = 1;
  			foreach ($asinLists as $list){
  
  				extract($list);
  				/*********** Validations *****************/
  				//$ShortDetail = ($ShortDetail) ? '<Description>'.trim(strip_tags($ShortDetail)).'</Description>' : '';
  				$ShortDetail = ($Name && $account['set_desc']) ? '<Description>'.$Name.'</Description>' : '';
  				$Brand = ($Brand) ? '<Brand>'.$Brand.'</Brand>' : '';
  				$ItemConditionNote = ($ItemConditionNote) ? $ItemConditionNote : 'New offer Listing';
  				$LaunchDate = ($LaunchDate>0) ? '<LaunchDate>'.$LaunchDate.'T00:00:01</LaunchDate>' : '';
  
  				for ($i = 0; $i < sizeof($arryManufacturer); $i++) {
  					if ($arryManufacturer[$i]['Mid'] == $list['Mid']) {
  						$mid = stripslashes($arryManufacturer[$i]['Mname']);
  					}
  				}
  
  				$Manufacturer = (!empty($mid)) ? '<Manufacturer>'.$mid.'</Manufacturer>' : '';
  
  
  				$vS = true;
  				$emptyName = '';
  				if(empty($ProductSku)) { $emptyName .= ' Sku ';$vS = false;  }
  				if(empty($Name)) { $emptyName .= ' Title ';$vS = false;  }
  				if(empty($ItemCondition)) { $emptyName .= ' Condition '; $vS = false;  }
  				if($Price<1) { $emptyName .= ' Price '; $vS = false;  }
  				if(empty($ProductTypeName)) { $emptyName .= ' Title '; $vS = false;  }
  				if($Quantity<1) { $emptyName .= ' Quantity '; $vS = false;  }
  				if(empty($ProductCode)) { $emptyName .= ' Product Code '; $vS = false;  }
  				//if($LaunchDate>0) { $emptyName = 'Launch Date'; $vS = false;  }
  				$emptyName .= 'Fields are empty!';
  				/*********** Validations End *****************/
  				
  				if($vS) {
  					$feed .= '
						<Message>
						<MessageID>'.$msgCount.'</MessageID>
						<OperationType>Update</OperationType>
						<Product>
							<SKU>'.$ProductSku.'</SKU>
							<StandardProductID>
								<Type>ASIN</Type>
								<Value>'.$ProductCode.'</Value>
							</StandardProductID>
							<ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
							'.$LaunchDate.'
							            <Condition>
							                <ConditionType>'.$ItemCondition.'</ConditionType>
										 	<ConditionNote>'.$ItemConditionNote.'</ConditionNote>
							            </Condition>
							<DescriptionData>
								<Title>'.$Name.'</Title>
								'.$ShortDetail.'
								<MSRP currency="'.$Config['Currency'].'">'.$Price.'</MSRP>
								'.$Brand.'
								'.$Manufacturer.'
								<MfrPartNumber>'.$MfrPartNumber.'</MfrPartNumber>
					    		<ItemType>'.$ProductTypeName.'</ItemType>
							</DescriptionData>
						</Product>
						</Message>';
  
  					$msgCount++;
  					
  				}else{
  					$this->updateFeedProcessingStatus('Error',$list['itemID'],$emptyName);
  				}
  			}
  			$feed .= '</AmazonEnvelope>';
  			//pr($feed,1);
  			if(($vS && count($asinLists)==1) || count($asinLists)>1){
  				$this->AccountID = $account['id'];
  				$this->CreateAmazonProduct($feed, $Amazonservice, '_POST_PRODUCT_DATA_','Batch');
  				$this->updateFeedProcessingStatus('_SUBMITTED_',$list['itemID']);
  			}else{
  				
  			}
  			if(count($asinLists)==1 && $vS){
  				$sql1 = "update amazon_items set FeedSubmissionId='".$_POST['FeedSubmissionId']."' where itemID = '".$asinLists[0]['itemID']."'";
  				$this->query($sql1);
  			}
  			
  			endif; //listing array end
  		}
  		//pr($feed,1);
  	} //account array end
  }
  
  public function updateInventoryPricImageBatchAmazon($Prefix){
  	global $Config;
  	$objConfig=new admin();
  	$accounts = $this->getAccountAll();
  
  	$merchant = '';
  	if(!empty($accounts)){
  		foreach ($accounts as $account ) {
  
  			$sql = "select p1.*, p2.ProductSku, p2.Name, Mid,Image from amazon_items p1 left join e_products p2 on(p1.itemID = p2.ProductID) where AmazonAccountID='".$account['id']."' and PQIStatus=0 and Channel like '%amazon%' ";
  			$asinLists = $this->query($sql, 1);
  			//pr($asinLists,1);
  			$Amazonservice = $this->AmazonSettings($Prefix,true,$account['id']);
  			$this->AccountID = $account['id'];
  			/*--------------------Inventory FEED----------------------------------*/
  			if(!empty($asinLists)):
  			$Invfeed = '<?xml version="1.0" encoding="utf-8" ?>
						<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-
						envelope.xsd">
						<Header>
							<DocumentVersion>1.01</DocumentVersion>
							<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
						</Header>
						<MessageType>Inventory</MessageType>';
  
  			$msgCount = 1;
  			foreach ($asinLists as $list){
  				extract($list);
  				$vS = true;
  				if($list['Quantity']<1) { $vS = false;  }
  
  				if($vS){
  
  					$restock = ($list['RestockDate']>0) ? '<RestockDate>'.$list['RestockDate'].'T00:00:01</RestockDate>' : '' ;
  					if($list['FulfilledBy']=='AMAZON_NA'){
  						$filledby =  '<FulfillmentCenterID>AMAZON_NA</FulfillmentCenterID>
					  <Lookup>FulfillmentNetwork</Lookup>
					  <SwitchFulfillmentTo>AFN</SwitchFulfillmentTo>';
  					}else{
  						$filledby =  '<FulfillmentCenterID>DEFAULT</FulfillmentCenterID>
					  <Quantity>'.$list['Quantity'].'</Quantity>
					  '.$restock.'
					  <SwitchFulfillmentTo>MFN</SwitchFulfillmentTo>';
  					}
  
  					$Invfeed .= '<Message>
						  <MessageID>'.$msgCount.'</MessageID>
						  <OperationType>Update</OperationType>
						  <Inventory>
							  <SKU>'.$ProductSku.'</SKU>
							  '.$filledby.'
						  </Inventory>
						</Message>';
  					$msgCount++;
  					$referenceSKU = $ProductSku;
  				}
  			}
  			$Invfeed .= '</AmazonEnvelope>';
  
  			if($msgCount==2) $this->ProductSku = $referenceSKU;
  				
  			$this->CreateAmazonProduct($Invfeed, $Amazonservice, '_POST_INVENTORY_AVAILABILITY_DATA_','Batch');
  			/*--------------------END OF Inventory FEED----------------------------------*/
  
  			/*--------------------PRICE FEED----------------------------------*/
  			$Pricefeed = '<?xml version="1.0" encoding="utf-8" ?>
						<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-
						envelope.xsd">
						<Header>
							<DocumentVersion>1.01</DocumentVersion>
							<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
						</Header>
						<MessageType>Price</MessageType>';
  
  			$msgCount = 1;
  			foreach ($asinLists as $list){
  
  				extract($list);
  					
  				$vS = true;
  				if($list['Price']<1 || $list['Price2']<1 ) $vS = false;
  				if($vS){
  					$list['SaleEndDate'] = '2016-06-30';
  					$EndDate = ($list['SaleEndDate']>0) ? '<EndDate>'.$list['SaleEndDate'].'T00:00:01</EndDate>' : '' ;
  
  					$Pricefeed .= '<Message>
								  <MessageID>'.$msgCount.'</MessageID>
								  <Price>
									<SKU>'.$ProductSku.'</SKU>
									<StandardPrice currency="DEFAULT">'.$list['Price'].'</StandardPrice>
									<Sale>
										<StartDate>'.$list['SaleStartDate'].'T00:00:01</StartDate>
										'.$EndDate.'
										<SalePrice currency="USD">'.$list['Price2'].'</SalePrice>
									</Sale>
								  </Price>
								</Message>';
  					$msgCount++;
  				}
  			}
  			$Pricefeed .= '</AmazonEnvelope>';
  
  			$this->CreateAmazonProduct($Pricefeed, $Amazonservice, '_POST_PRODUCT_PRICING_DATA_','update');
  			/*--------------------END OF PRICE FEED----------------------------------*/
  
  			/*-------------------- IMAGE FEED----------------------------------*/
  			$Imagefeed = '<?xml version="1.0" encoding="utf-8" ?>
					<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-
					envelope.xsd">
					<Header>
						<DocumentVersion>1.01</DocumentVersion>
						<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
					</Header>
					<MessageType>ProductImage</MessageType>';
  				
  			$msgCount = 100;
  			foreach ($asinLists as $list){
  					
  				extract($list);
  				$MaxProductImageArr = $this->GetAlternativeImage($list['itemID']);
  					
  				$vS = true;
  				if(empty($list['Image']) && empty($MaxProductImageArr)) { $vS = false;  }
  					
  				if($vS){
  					if(!empty($list['Image'])){
  						$Imagefeed .= '<Message>
						<MessageID>'.$msgCount.'</MessageID>
						<OperationType>Update</OperationType>
						<ProductImage>
							<SKU>'.$ProductSku.'</SKU>
							<ImageType>Main</ImageType>
							<ImageLocation>https://wallpaperscraft.com/image/tree_leaves_fog_light_purple_autumn_94147_1600x1200.jpg</ImageLocation>
						</ProductImage>
					</Message>';
  					}
  					if(!empty($MaxProductImageArr)){
  						$i=1;
  						foreach($MaxProductImageArr as $ImageArr){
  							$i++;
  							$Imagefeed .='<Message>
						  <MessageID>'.$i.'</MessageID>
						  <OperationType>Update</OperationType>
						  <ProductImage>
							  <SKU>'.$ProductSku.'</SKU>
							  <ImageType>PT'.($i-1).'</ImageType>
							  <ImageLocation>http://199.227.27.197/erp/upload/products/images/secondary/37/LN-T4665F_4.jpg</ImageLocation>
						  </ProductImage>
						</Message>';
  						}
  					}
  					$msgCount++;
  				}else{
  					//$this->updateFeedProcessingStatus('Error',$list['itemID']);
  				}
  				
  				$sql = "update amazon_items set PQIStatus='1' where ProductSku='".$ProductSku."' and AmazonAccountID='".$account['id']."' and Channel like '%amazon%'";
  				$this->query($sql);
  			}
  			$Imagefeed .='</AmazonEnvelope>';
  
  			$this->CreateAmazonProduct($Imagefeed, $Amazonservice, '_POST_PRODUCT_IMAGE_DATA_','update');
  			/*--------------------End OF IMAGE FEED----------------------------------*/
  				
  			endif; //listing array end
  		}
  		//pr($Imagefeed,1);
  	} //account array end
  }
  /*------------------- SEARCH AMAZON PRODUCT LISTS ------------------------*/
  
   
  	
/*------------------- RUN CRON FOR SUBMITTED ITEMS ------------------------*/
	function processAmazonSubmissionHistory($Prefix){
		global $Config;
		
		$time = strtotime($Config['TodayDate']);
		$time = $time - (5 * 60);
		
		$sql = "select * from amazon_submit_history where Status !='1' and amazonAccountID>'0'";
		$asinLists = $this->query($sql, 1);
		$status = 0;
		if (is_array($asinLists) && count($asinLists) > 0) {
			foreach ($asinLists as $key => $values) {
				$status++;
				if(strtotime($values['CreatedDate']) <= $time){ 
					$fetchType = empty($values['ProductSku']) ? 'Batch' : 'SubmitHistory';
					$Amazonservice = $this->AmazonSettings($Prefix,false,$values['amazonAccountID']);
					$this->AccountID = $account['id'];
					if($Amazonservice)
					$data = $this->getFeedSubmissionHistory($Amazonservice, $values['FeedSubmissionId'], $fetchType);
				}
		    }
		}
	}
	
	
  
  /*------------------------------ Fetch product from amazon ------------------------------------*/
  function requestReport($Prefix, $service, $ReportType){
  	global $Config;
  	$request = new MarketplaceWebService_Model_RequestReportRequest();
  	$marketplaceIdArray = array("Id" => array($this->MARKETPLACE_ID));
  	$request->setMarketplaceIdList($marketplaceIdArray);
  	$request->setMerchant($this->MERCHANT_ID);
  	$request->setReportType($ReportType);
  	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
  		
  	//$typeList = new MarketplaceWebService_Model_TypeList();
  	//$request->setReportType($typeList->withType('_GET_PAYMENT_SETTLEMENT_DATA_'));
  	//$request->setStartDate('2016-05-01 21:05:08.000000');
  	//$request->setEndDate('2016-05-20 21:08:10.000000');
  
  	try {
  		$result = $service->requestReport($request);
  		$reportInfo = $result->RequestReportResult->ReportRequestInfo;
  		if($reportInfo->ReportProcessingStatus=='_SUBMITTED_'){
  			return $reportInfo->ReportRequestId;
  		}else {
  			die('Request for product report is failed. Try again.');
  		}
  	} catch (MarketplaceWebService_Exception $ex) {
  		echo("Caught Exception: " . $ex->getMessage() . "\n");
  		echo("Response Status Code: " . $ex->getStatusCode() . "\n");
  		echo("Error Code: " . $ex->getErrorCode() . "\n");
  		echo("Error Type: " . $ex->getErrorType() . "\n");
  	}
  }
  
  function getRequestedReportList($Prefix, $service, $ReportType){
  	global $Config;
  	$request = new MarketplaceWebService_Model_GetReportRequestListRequest();
  	$typeList = new MarketplaceWebService_Model_TypeList();
  	$request->setReportTypeList($typeList->withType($ReportType));
  	$request->setMaxCount(1);
  	$request->setMerchant($this->MERCHANT_ID);
  	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
  
  	try {
  		$result = $service->getReportRequestList($request);
  		$requestInfo = $result->GetReportRequestListResult->getReportRequestInfoList();
  		if($requestInfo[0]->GeneratedReportId){
  			return $requestInfo[0]->GeneratedReportId;
  		}else {
  			die('Did not get Product report. Please try after some time.');
  		}
  	} catch (MarketplaceWebService_Exception $ex) {
  		echo("Caught Exception: " . $ex->getMessage() . "\n");
  		echo("Response Status Code: " . $ex->getStatusCode() . "\n");
  		echo("Error Code: " . $ex->getErrorCode() . "\n");
  		echo("Error Type: " . $ex->getErrorType() . "\n");
  	}
  }
  
  function getReport($Prefix, $service, $reportID, $accountID){ 
  	global $Config;
  	$request = new MarketplaceWebService_Model_GetReportRequest();
  	$request->setMerchant($this->MERCHANT_ID);
  	$request->setReport(@fopen('php://memory', 'rw+'));
  	$request->setReportId($reportID);
  	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
  
  	try {
  		$result = $service->getReport($request);
  		require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
  		require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
  		require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');
  		$Filepath = "/var/www/html/erp/csv/syncProduct.xls";
  		file_put_contents($Filepath,'EMPTY');
  		file_put_contents($Filepath,$request->getReport());
  		//return true;
  			
  		//$result = $this->parseXML($result);
  		//$result = $this->processSimpleXmlResult($result);
  		//pr(stream_get_contents($request->getReport()) ,1);
  		//echo stream_get_contents($request->getReport()) ;die;
  		//die;
  			
  		$Spreadsheet = new SpreadsheetReader($Filepath);
  			
  		$Sheets = $Spreadsheet -> Sheets();
  		$Count = 0;
  		foreach ($Sheets as $Index => $Name){
  			$Spreadsheet -> ChangeSheet($Index);
  				
  			foreach ($Spreadsheet as $Key => $Row){
  					
  				if($Count==0){
  					$TaxIndex = array_search('product-tax-code', $Row);
  				}
  					
  				if($Count>0){
  					$name = $Row[0];
  					$ShortDetail = $Row[1];
  					$Sku = $Row[3];
  					$Price2 = $Price = $Row[4];
  					$Quantity = $Row[5];
  					$LaunchDate = $Row[6];
  					$ItemConditionNote = $Row[11];
  					$ItemCondition = $Row[12];
  					$ProductCode = $Row[22];
  					$FulfilledBy = $Row[26];
  
  					$Tax = (!empty($TaxIndex))? $Row[$TaxIndex] :'A_GEN_NOTAX';
  
  					$conditionArr = array(  1 => 'UsedLikeNew',
  							2 => 'UsedVeryGood',
  							3 => 'UsedGood',
  							4 => 'UsedAcceptable',
  							5 => 'CollectibleLikeNew',
  							6 => 'CollectibleVeryGood',
  							7 => 'CollectibleGood',
  							8 => 'CollectibleAcceptable',
  							9 => 'NotUsed',
  							10 => 'Refurbished',
  							11 => 'New'
  					);
  
  					$ItemCondition = $conditionArr[$ItemCondition];
  
  					$sql = "select ProductSku from amazon_items where ProductSku ='".$Sku."' and Channel like '%amazon%' ";
  					$exist = $this->query($sql,1);
  
  					if(empty($exist)){
  						$sql = "INSERT INTO amazon_items
								(Name,ProductSku,ProductType, ProductCode, Quantity, Price, ItemCondition, ItemConditionNote, ShortDetail, LaunchDate,Price2, FeedProcessingStatus,
								  Status, LastUpdateDate, AmazonAccountID, TaxCode, FulfilledBy, Channel)
						 		 VALUES ('".addslashes($name)."','".$Sku."','ASIN', '".$ProductCode."', '".$Quantity."', '".$Price."', '".addslashes($ItemCondition)."', '".addslashes($ItemConditionNote)."', '".addslashes($ShortDetail)."', '".$LaunchDate."', '".$Price2."', 'Active',
						 		 		'1', '".$Config['TodayDate']."', '".$accountID."', '".$Tax."', '".$FulfilledBy."', '".$this->URL."')";
  						$this->query($sql,0);
  					}
  
  				}
  				$Count++;
  			}
  		}
  		return true;
  
  	} catch (MarketplaceWebService_Exception $ex) {
  		echo("Caught Exception: " . $ex->getMessage() . "\n");
  		echo("Response Status Code: " . $ex->getStatusCode() . "\n");
  		echo("Error Code: " . $ex->getErrorCode() . "\n");
  		echo("Error Type: " . $ex->getErrorType() . "\n");
  	}
  }
  
  function syncProduct($Prefix, $accountID){
	$objConfig=new admin();
  	$Amazonservice = $this->AmazonSettings($Prefix,false,$accountID);
  	$requestID = $this->requestReport($Prefix,$Amazonservice,'_GET_MERCHANT_LISTINGS_DATA_');
  	if($requestID){
  		sleep(60);
  		$reportID = $this->getRequestedReportList($Prefix,$Amazonservice,'_GET_MERCHANT_LISTINGS_DATA_');
  		if($reportID){
  			$objConfig->setPID('e-commerce','lowestPrice',0);
  			$this->getReport($Prefix, $Amazonservice, $reportID, $accountID);
  		}
  	}
  }
  
  function runCronForLowestPrice($Prefix){
  	global $Config;
  	$objConfig=new admin();
  	try{
  		$processDetails = $objConfig->getPID('e-commerce','lowestPrice');
  		if($processDetails){ //(ListingPrice=0 or pid>'".$processDetails[0]['LastUpdatedID']."')
  			$sql = "select pid, AmazonAccountID,ItemCondition, ProductSku from amazon_items where ListingPrice='0' and pid<'".$processDetails[0]['LastUpdatedID']."' and Status='1' and FeedProcessingStatus='Active' and Channel like '%amazon%' order by pid DESC limit 16";
  			$data = $this->query($sql,1);
  				
  			if(!empty($data)){
  				foreach ($data as $value){ #false for cron run other wise set as true
  					$Amazonservice = $this->AmazonProductSettings($Prefix,false,$value['AmazonAccountID']);
  					if($Amazonservice){
  						$returnData = $this->GetLowestPricingForSKU($Amazonservice, $value['ItemCondition'], $value['ProductSku']);
  					}
  					if(!empty($returnData)){
  						$sql = "update amazon_items set ListingPrice='".$returnData['ListingPrice']."',Shipping='".$returnData['Shipping']."' where ProductSku='".$value['ProductSku']."' and AmazonAccountID='".$value['AmazonAccountID']."' and Channel like '%amazon%' ";
  						$this->query($sql,0);
  					}
  				}
  			}

			$cID = count($data);
			if($cID>0)
				$objConfig->updatePID('e-commerce','lowestPrice','0',$data[$cID-1]['pid']);
				else
					$objConfig->removePID('e-commerce','lowestPrice');
  		}
  	}catch(Exception $e ){
  		echo $e->getMessage();
  	}
  }
  
  function manualUpdateForLowestPrice($returnData,$sku){
  	$sql = "update amazon_items set ListingPrice='".$returnData['ListingPrice']."',Shipping='".$returnData['Shipping']."' where ProductSku='".$sku."' and Channel like '%amazon%' ";
  	$this->query($sql,0);
  }
  
  
  function updateAmazonPrice($Amazonservice, $sku, $new_price, $AccID){
  	try{
  		$this->ProductSku = $sku;
  		$this->AccountID = $AccID;
  		$Pricefeed = '<?xml version="1.0" encoding="utf-8" ?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
				<Header>
				<DocumentVersion>1.01</DocumentVersion>
				<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
				</Header>
				<MessageType>Price</MessageType>
				<Message>
				  <MessageID>1</MessageID>
				  <OperationType>Update</OperationType>
				  <Price>
				    <SKU>'.$sku.'</SKU>
				    <StandardPrice currency="DEFAULT">'.$new_price.'</StandardPrice>
				  </Price>
				</Message>
				</AmazonEnvelope>';
  
  		$this->CreateAmazonProduct($Pricefeed, $Amazonservice, '_POST_PRODUCT_PRICING_DATA_','Batch');
  		return true;
  	}catch(Exception $e){
  		return false;
  	}
  }
  
  function updateAmazonQuantity($Amazonservice, $sku, $Qnt, $AccID){
  	try{
  		$this->ProductSku = $sku;
  		$this->AccountID = $AccID;
  		$Invfeed = '<?xml version="1.0" encoding="utf-8" ?>
			<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
			<Header>
			<DocumentVersion>1.01</DocumentVersion>
			<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
			</Header>
			<MessageType>Inventory</MessageType>
			<Message>
			<MessageID>1</MessageID>
			<OperationType>Update</OperationType>
			<Inventory>
			<SKU>'.$sku.'</SKU>
			<Quantity>'.$Qnt.'</Quantity>
			</Inventory>
			</Message>
			</AmazonEnvelope>';
  
  		$this->CreateAmazonProduct($Invfeed, $Amazonservice, '_POST_INVENTORY_AVAILABILITY_DATA_','Batch');
  		return true;
  	}catch(Exception $e){
  		return false;
  	}
  }
  
  
  function updateAmazonAllPrice($Amazonservice, $pqAll, $AccID){
  	if(!empty($pqAll)):
  	try{
  		$this->AccountID = $AccID;
  		$Pricefeed = '<?xml version="1.0" encoding="utf-8" ?>
					<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
					<Header>
					<DocumentVersion>1.01</DocumentVersion>
					<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
					</Header>
					<MessageType>Price</MessageType>';
  		$msgCount = 1;
  		foreach ($pqAll as $sku => $new_price){
  			$Pricefeed .= '<Message>
	 				  <MessageID>'.$msgCount.'</MessageID>
					  <OperationType>Update</OperationType>
					  <Price>
					    <SKU>'.$sku.'</SKU>
					    <StandardPrice currency="DEFAULT">'.$new_price.'</StandardPrice>
					  </Price>
					</Message>';
  			$msgCount ++;
  			$this->updateTableQntPrice('Price', $new_price, $sku, $AccID);
  		}
  		$Pricefeed .= '</AmazonEnvelope>';
  
  		$this->CreateAmazonProduct($Pricefeed, $Amazonservice, '_POST_PRODUCT_PRICING_DATA_','Batch');
  		return true;
  	}catch(Exception $e){
  		return false;
  	}
  	endif;
  }
  
  function updateAmazonAllQuantity($Amazonservice, $pqAll, $AccID){
  	if(!empty($pqAll)):
  	try{
  		$this->AccountID = $AccID;
  		$Invfeed = '<?xml version="1.0" encoding="utf-8" ?>
					<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
					<Header>
					<DocumentVersion>1.01</DocumentVersion>
					<MerchantIdentifier>'.$this->MERCHANT_ID.'</MerchantIdentifier>
					</Header>
					<MessageType>Inventory</MessageType>';
  		$msgCount = 1;
  		foreach ($pqAll as $sku => $Qnt){
  			$Invfeed .= '<Message>
	 				  <MessageID>'.$msgCount.'</MessageID>
					  <OperationType>Update</OperationType>
					  <Inventory>
					  <SKU>'.$sku.'</SKU>
					  <Quantity>'.$Qnt.'</Quantity>
					  </Inventory>
					</Message>';
  			$msgCount ++;
  			$this->updateTableQntPrice('Quantity', $Qnt, $sku, $AccID);
  		}
  		$Invfeed .= '</AmazonEnvelope>';
  
  		$this->CreateAmazonProduct($Invfeed, $Amazonservice, '_POST_INVENTORY_AVAILABILITY_DATA_','Batch');
  		return true;
  	}catch(Exception $e){
  		return false;
  	}
  	endif;
  }
  
  
  function updateTableQntPrice($type, $value, $sku, $accID){
  	if($type=='Price') $set = " Price='".$value."' " ;
  	else if($type=='Quantity') $set = " Quantity='".$value."'";
  
  	$sql = "update amazon_items set $set where ProductSku='".$sku."' and Channel like '%amazon%' and AmazonAccountID='".$accID."' ";
  	$this->query($sql);

	$sql = "update inv_items set qty_on_hand='".$value."' where Sku='".$sku."' ";
	$this->query($sql);
  }
  /*------------------------------ End of Fetch product from amazon ------------------------------------*/
  

public function getAliasAmazonData($apiType, $AliasID){
	$sql = "select ai.*, eia.Manufacture from amazon_items ai left join e_item_alias eia on(ai.AliasID=eia.AliasID) where Channel like '%".$apiType."%' and ai.AliasID='".$AliasID."' ";
	return $this->query($sql,1);
}

/*********************************************************************************************
*	                       End of Amazon product by sanjiv
*********************************************************************************************/
	
	
	
	
/*********************************************************************************************
*			     Ebay product edited by Sanjiv
*********************************************************************************************/	
function EbayImportOrders($objRegion,$Prefix){
	global $Config;
    $objConfig=new admin();

    $objItem = new items();
    $arryEbayCredentials=$objItem->GetEbayCredentials();
	

    if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}

    include($Prefix.'ebay/keys.php');
    require_once($Prefix.'ebay/eBaySession.php');
    	
	//$tdate= date("Y-m-d",strtotime($Config['TodayDate']));
	$tdate= gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time() + 2 * 24 * 3600 );
	$siteID = 0;
	//the call being made:
	$verb = 'GetOrders';


	if($arryEbayCredentials[0]['last_orders_sync']>0){
		$lastdate = $arryEbayCredentials[0]['last_orders_sync'];
	}else if($arryEbayCredentials[0]['syncOders'] && $arryEbayCredentials[0]['from_date']>0){
		$lastdate = $arryEbayCredentials[0]['from_date'];
	}
	 
	$days = isset($_REQUEST['days']) && $_REQUEST['days'] ? $_REQUEST['days'] : false;
	if ( ! $lastdate && ! $days ) $days = 1;
	 
	$LastUpdatedAfter    = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", strtotime( $lastdate ) + 0 );
	if ( $days )
	$LastUpdatedAfter = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time() - $days * 24 * 3600 );
	 
	///Build the request Xml string
	$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
	$requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	$requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
	$requestXmlBody .= "<ModTimeFrom>".$LastUpdatedAfter."</ModTimeFrom><ModTimeTo>".$tdate."</ModTimeTo>";
	$requestXmlBody .= '<OrderRole>Seller</OrderRole><OrderStatus>All</OrderStatus>';
	$requestXmlBody .= '<IncludeFinalValueFee>true</IncludeFinalValueFee>';
	$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBody .= '</GetOrdersRequest>';

	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
	$responseXml = $session->sendHttpRequest($requestXmlBody);

	if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
	die('<P>Error sending request');

	$responseDoc = new DomDocument();
	$responseDoc->loadXML($responseXml);

	//get any error nodes
	$errors = $responseDoc->getElementsByTagName('Errors');
	$response = simplexml_import_dom($responseDoc);

	//if($_GET['pk']==1){echo "<pre>";print_r($response);die;}

	$entries = $response->PaginationResult->TotalNumberOfEntries;


	//if there are error nodes
	if ($errors->length > 0)
	{	if($Config['CronJob'] != '1'){
				if($_GET['pk']==1){echo "<pre>";print_r($response);die;}
		echo '<P><B>eBay returned the following error(s):</B>';
		//display each error
		//Get error code, ShortMesaage and LongMessage
		$code = $errors->item(0)->getElementsByTagName('ErrorCode');
		$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
		$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
	  
		//Display code and shortmessage
		echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
		
		//if there is a long message (ie ErrorLevel=1), display it
		if (count($longMsg) > 0)
		echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
}	
}
	else
	{ 
		$orders = $response->OrderArray->Order;

		if ($orders != null)
		{	
			/********Connecting to main database*********/
			$objConfig->dbName = $Config['DbMain'];
			$objConfig->connect();
			/*******************************************/
	       	foreach($orders as $order){ 

			 



			$arr[strtotime($order->CreatedTime)] = $order;
	       		if($order->ShippingAddress->Country){
				$arryCountry = $objRegion->getCountryByCode($order->ShippingAddress->Country); 
				if(!empty($arryCountry)){
					$order->ShippingAddress->CountryName = (!empty($order->ShippingAddress->CountryName) && strlen($order->ShippingAddress->CountryName)>3)?$order->ShippingAddress->CountryName:$arryCountry[0]['name'];
					$arryState = $objRegion->GetStateByCode($order->ShippingAddress->StateOrProvince, $arryCountry[0]['country_id']);
					if(!empty($arryState)){
						$order->ShippingAddress->StateOrProvince = $arryState[0]['name'];
					} 
				}
	       		}
	       		 
	       	}
		   /******Connecting to company database*******/
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/

			ksort($arr);
	       		$orders = $arr;
			foreach ($orders as $order)
			{	$orderStatus = $order->OrderStatus;
				$passorderid = ($order->ShippingDetails->SellingManagerSalesRecordNumber>0)?$order->ShippingDetails->SellingManagerSalesRecordNumber:$order->OrderID;
				
				if($order->OrderStatus=='Cancelled'){
				  $this->deleteCancelOrders($passorderid);
				}

				//if($order->OrderStatus=='Cancelled' || $order->OrderStatus=='Inactive' || $order->OrderStatus=='Active') return false;
				//if ($order->OrderStatus && !($order->OrderStatus=='Cancelled' || $order->OrderStatus=='Inactive') && $order->AmountPaid>0)
				if ($order->OrderStatus && $order->OrderStatus!='Inactive')
				{	
					$isShipped = $order->TransactionArray->Transaction[0]->ShippingDetails->ShipmentTrackingDetails;
					if(!empty($order->ShippingAddress->Name) && !empty($order->ShippingAddress->Street1)){ 
						if($order->OrderStatus=='Completed') {
							if(count($isShipped)>0){
								$order->OrderStatus = 'Shipped';
							}else{
								$order->OrderStatus = 'Unshipped';
							}	
						}else if($order->OrderStatus=='InProcess'){
							if(!empty($order->ShippingAddress->Street1))
							{
								$order->OrderStatus = 'Unshipped';
							}else{ 
								$order->OrderStatus = 'Active';
							}
						}
					}else{
						$order->OrderStatus = 'Active';
					}					
					$AmountPaid = $order->AmountPaid;
					$AmountPaidAttr = $AmountPaid->attributes();
					$AmountPaid1=$AmountPaid." ".$AmountPaidAttr["currencyID"];
					$SalesTaxAmount = $order->ShippingDetails->SalesTax->SalesTaxAmount;
					$SalesTaxAmountAttr = $SalesTaxAmount->attributes();
					$Subtotal = $order->Subtotal;
				 	$Total = $order->Total;
				 	$ShippedTime = ($order->ShippedTime)?$this->convertIsoDateToSql($order->ShippedTime):'';
					
					$shippingAddress = '';	
				 	$shippingAddress = $order->ShippingAddress;
				 	
					$adsName = $address = $CityName = $StateOrProvince = $Phone = '';

			


					if (!empty($shippingAddress->Name))
				 	{
				 		$adsName = $shippingAddress->Name;
				 	}
				 	if (!empty($shippingAddress->Street1))
				 	{
				 		$address =  $shippingAddress->Street1 ;
				 	}
				 	if (!empty($shippingAddress->Street2))
				 	{
				 		$address =  $address.', '.$shippingAddress->Street2;
				 	}
				 	if (!empty($shippingAddress->CityName)) {
				 		$CityName = $shippingAddress->CityName;
				 	}
				 	if (!empty($shippingAddress->StateOrProvince)) {
				 		$StateOrProvince = $shippingAddress->StateOrProvince;
				 	}
				 	if (!empty($shippingAddress->PostalCode)) {
				 		$PostalCode =  $shippingAddress->PostalCode;
				 	}
				 	if (!empty($shippingAddress->CountryName)) {
				 		$CountryName = $shippingAddress->CountryName;
				 	}
				 	if (!empty($shippingAddress->Phone)) {
				 		$Phone =  $shippingAddress->Phone;
				 	}

					if(empty($adsName) || empty($shippingAddress->Street1)){
				 		$order->OrderStatus = 'Active';
				 	}
				 	 
				 	$BuyerEmail = $order->TransactionArray->Transaction->Buyer->Email[0];
				 	if(empty($BuyerEmail) || $BuyerEmail=='Invalid Request') $BuyerEmail='';
					$order->PaymentMethods = ($order->PaymentMethods=='PayPal')?'Paypal':$order->PaymentMethods;
				 	$EbayTaxAmount = $order->TransactionArray->Transaction->Taxes->TotalTaxAmount;
				 		
				   $strSQLQry11 = "select OrderID, OrderStatus, BillingAddress from e_orders where AmazonOrderId ='".$passorderid."' ";
				    $arryEbayOrder = $this->query($strSQLQry11);
				    $ExistingOrderID =  $arryEbayOrder[0]['OrderID'];
				    $ExistOrderStatus = $arryEbayOrder[0]['OrderStatus'];

			    # Remove pending order and insert the same order with new data
			    if( !empty($ExistingOrderID) && ($ExistOrderStatus=='Active') && ($order->OrderStatus=='Shipped' || $order->OrderStatus=='Unshipped') ){
			    	$this->deleteSyncOrder($ExistingOrderID);
			    	$OID = $ExistingOrderID;
			    	$ExistingOrderID='';
			    }

				if( !empty($ExistingOrderID) && empty($arryEbayOrder[0]['BillingAddress']) && ($order->OrderStatus=='Shipped' || $order->OrderStatus=='Unshipped') ){
					$this->deleteOrderByEmptyAddress($passorderid);
					$ExistingOrderID='';
				}
				 	
			    if(empty($ExistingOrderID)){
				
				if(!empty($OID)){
			    		$INSERT_ID = 'OrderID, ';
			    		$OID = $OID.', ';
			    	}else{
			    		$INSERT_ID = $OID = '';
			    	}

			    	$sql="INSERT INTO e_orders($INSERT_ID Currency,OrderDate, OrderComplatedDate, SubTotalPrice, TotalPrice, TotalQuantity, BillingName, BillingCompany, BillingAddress, BillingCity,BillingState, BillingCountry,BillingZip, Phone,ShippingName, ShippingCompany, ShippingAddress, ShippingCity,ShippingState,ShippingCountry,ShippingZip, ShippingPhone,OrderStatus,AmazonOrderId, AmazonAccountID,OrderType, SellerChannel,Email, PaymentGateway, Tax,ShippingMethod,Shipping,ShipDate) VALUES($OID '".$AmountPaidAttr["currencyID"]."','".$order->CreatedTime."','".$order->CreatedTime."','".$Subtotal."','".$Total."','".$qty."','".addslashes($adsName)."','".addslashes($adsName)."','".addslashes($address)."','".addslashes($CityName)."','".addslashes($StateOrProvince)."','".addslashes($CountryName)."','".$PostalCode."','".$Phone."','".addslashes($adsName)."','".addslashes($adsName)."','".addslashes($address)."','".addslashes($CityName)."','".addslashes($StateOrProvince)."','".addslashes($CountryName)."','".$PostalCode."','".$Phone."','".$order->OrderStatus."','" . $passorderid ."','0','Ebay','Ebay.com','".addslashes($BuyerEmail)."','".$order->PaymentMethods."','".$EbayTaxAmount."','".$order->ShippingServiceSelected->ShippingService."','".$order->ShippingServiceSelected->ShippingServiceCost ."','".$ShippedTime."')";
			    	
			    	$this->query($sql, 0);
			    	$lastInsertId = $this->lastInsertId();
				    $transactions = $order->TransactionArray;
				    if ($transactions)
					{
					 foreach ($transactions->Transaction as $transaction)
						{   
							$ItemID = $transaction->Item->ItemID;
							
							if( $transaction->Item->SKU ){ 
		               			$SKU = $transaction->Item->SKU;
							}else{
		               			$SKU = $this->EbayImportOrderItemDetail($objRegion, $Prefix, $ItemID);
							}

							$qty = $transaction->QuantityPurchased;
							$title =  addslashes($transaction->Item->Title);
		                	$textis=  $transaction->Platform->Taxes->TotalTaxAmount;
		                	$TaxDescription = json_encode($transaction->Taxes->TaxDetails);
							if($lastInsertId>0)
							{
						     $sql1="INSERT INTO e_orderdetail(OrderID,Quantity,Price,ProductName,AmazonSku,OrderItemId,TaxRate,TaxDescription) VALUES ('".$lastInsertId."' ,'".$qty."','".$transaction->TransactionPrice."','".$title."','".$SKU."','".$order->OrderID."','".$textis."','".$TaxDescription."')";
						     $this->query($sql1, 0);
							}
		            }
					}
				
				    if($lastInsertId>0){
						$sq2 = "SELECT * FROM e_orders where OrderID='" . addslashes($lastInsertId). "' ";
						$orderres =$this->query($sq2, 1);
						//$orderres[0]['Email'] = $order->BuyerUserID;
						$this->SyncAmazonOrderInSalesOrder($orderres[0],$lastInsertId );
					}
				
			    }else{
			    	$sqlquery  ="update e_orders set OrderStatus='".$order->OrderStatus."',TotalPrice='".$Total."' where OrderID='".$ExistingOrderID."'";
			    	$this->query($sqlquery, 0);
			    	$sqlquery1  ="update s_order set TotalAmount='".$Total."' where CustomerPO='".$passorderid."' ";
			    	$this->query($sqlquery1, 0);
			    	$lastInsertId = 0;
			    }
			 	
			    # Get fees    
				$FinalValueFee = $FeeOrCreditAmount = $totalFee = (float) 0;
				$FeeOrCreditAmount = (float) ($order->MonetaryDetails->Payments->Payment->FeeOrCreditAmount)?$order->MonetaryDetails->Payments->Payment->FeeOrCreditAmount:0;
				$TransactionFeeOrCreditAmount = (float) ($order->ExternalTransaction->FeeOrCreditAmount)?$order->ExternalTransaction->FeeOrCreditAmount:0;
				$x = (float) $order->ExternalTransaction->FeeOrCreditAmount;
				if ($transactions=$order->TransactionArray)
				{
					 foreach ($transactions->Transaction as $transaction)
					{   
					    $FinalValueFee = $FinalValueFee + (float) $transaction->FinalValueFee;
				 }
				}
				 $fee = array();
				 $totalFee = (float)$FinalValueFee+(float)$FeeOrCreditAmount;


				/******PK*********/				 
				if($arryEbayCredentials[0]["Fee"]  == "1"){	 						$ProviderFee = round(($Total * $arryEbayCredentials[0]["FeeRate"])/100,2);		
					$totalFee = (float)$FinalValueFee+(float)$ProviderFee;
				}
				/*****************/
				

				 $fee["$passorderid"] = (float)$totalFee;
			
				 //echo $passorderid.'---- FinalValueFee '.$FinalValueFee.' FeeOrCreditAmount '.$FeeOrCreditAmount.' ExternalTransaction '.$x.' Total '.$totalFee.'<br/>';
				 $this->updateFees($fee);
				 ## End of get fees
				/* if(empty($ExistingOrderID)){
					 $this->AddFeesToGL($Prefix,'Ebay',$totalFee,$this->getSaleIDFomSales($passorderid));
				 }*/

				}
				$shippingAddress = $ShippedTime = $order = $passorderid = '';
			}	
			$this->updateEbayDateOfLastOrder($orders);
			$_SESSION['mess_order'] = 'Ebay orders are synced successfully.';
		}else{
			$_SESSION['mess_order'] = 'No Ebay order is available for syncing.';
		}

	}
}

	function EbayImportOrderItemDetail($objRegion,$Prefix,$ItemID){ 
		global $Config;
		$objConfig=new admin();
			//$ItemID = '172251620806';
		$objItem = new items();
		$arryEbayCredentials=$objItem->GetEbayCredentials();
	
		if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}
	
		include($Prefix.'ebay/keys.php');
		require_once($Prefix.'ebay/eBaySession.php');
		 
		$siteID = 0;
		$verb = 'GetItemTransactions';
	
		 $requestXmlBody ='<?xml version="1.0" encoding="utf-8" ?>
		 <GetItemTransactionsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		 <ItemID>'.$ItemID.'</ItemID>
		 <RequesterCredentials>
		 <eBayAuthToken>'.$userToken.'</eBayAuthToken>
		 </RequesterCredentials>
		 </GetItemTransactionsRequest>'; 
	
		$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		
		if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>Error sending request');
		
			$responseDoc = new DomDocument();
			$responseDoc->loadXML($responseXml);
		
			//get any error nodes
			$errors = $responseDoc->getElementsByTagName('Errors');
			$response = simplexml_import_dom($responseDoc);
		
		if ($errors->length > 0)
		{
		}
		else
		{
			$Item = $response->Item;
			if ($Item != null){
				return $Item->SKU; 
			}
			
		}
	}

	function EbayUpdateShipping($Prefix,$v){
		global $Config;
		$objConfig=new admin();
		//$ItemID = '172251620806';
		$objItem = new items();
		$arryEbayCredentials=$objItem->GetEbayCredentials();
	
		if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}
	
		include($Prefix.'ebay/keys.php');
		require_once($Prefix.'ebay/eBaySession.php');
			
		$siteID = 0;
		$verb = 'CompleteSale';
		
		$shippingDate = '';
		if($v['ShipmentDate']>0){
			$shippingDate = date('Y-m-d',strtotime($v['ShipmentDate'])).'T'.'23:55:00';
			$shippingDate = '<ShippedTime>'.$shippingDate.'</ShippedTime>';
		}
		$CarrierCode = $this->ShippingCode($v['ShipmentMethod']);
		$CarrierCode = (!empty($CarrierCode))?$CarrierCode:$v['ShipmentMethod'];
		
		$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
							<CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents">
							  <RequesterCredentials>
							    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
							  </RequesterCredentials>
							  <WarningLevel>High</WarningLevel>
							  <OrderID>'.$v['OrderID'].'</OrderID>
							  <Shipment>
							    <ShipmentTrackingDetails>
							      <ShipmentTrackingNumber>'.$v['trackingId'].'</ShipmentTrackingNumber>
							      <ShippingCarrierUsed>'.$CarrierCode.'</ShippingCarrierUsed>
							    </ShipmentTrackingDetails>
							    '.$shippingDate.'
							  </Shipment>
							</CompleteSaleRequest>';
		
		$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		$responseXml = $session->sendHttpRequest($requestXmlBody);
	
		if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>Error sending request');
	
			$responseDoc = new DomDocument();
			$responseDoc->loadXML($responseXml);
	
			//get any error nodes
			$errors = $responseDoc->getElementsByTagName('Errors');
			$response = simplexml_import_dom($responseDoc);
			//echo "<pre>";print_r($response);die;
			if ($errors->length > 0)
			{
				echo '<P><B>eBay returned the following error(s):</B>';
				//display each error
				//Get error code, ShortMesaage and LongMessage
				$code = $errors->item(0)->getElementsByTagName('ErrorCode');
				$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
				$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
				 
				//Display code and shortmessage
				$_SESSION['mess_ship'] =  str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
			
				//if there is a long message (ie ErrorLevel=1), display it
				if (count($longMsg) > 0)
					echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
				
			}
			else
			{ 	
				$this->upadateAmazonOrderStatus('Shipped',$v['CustomerPO']);
				return true;
					
			}
	}

	function updateEbayDateOfLastOrder($ebayOrders){  
		global $Config;
		$OrdersCount = (count($ebayOrders)-1);
		$date = ($ebayOrders[$OrdersCount]->CheckoutStatus->LastModifiedTime>0) ? $this->convertIsoDateToSql( $ebayOrders[$OrdersCount]->CheckoutStatus->LastModifiedTime ) : date('Y-m-d', strtotime('-1 day', strtotime($Config['TodayDate'])) );
		$sql = "update ebay_settings set last_orders_sync='".$date."' ";
		return $this->query($sql);
	}

 public function deleteCancelOrders($orderID){
	/*$strSQLQuery = "select OrderID from e_orders where AmazonOrderId = '" . mysql_real_escape_string($orderID)."' ";
        $arryRow = $this->query($strSQLQuery, 1);

	if (!empty($arryRow[0]['OrderID'])) {
		$strSQLQuery = "DELETE FROM e_orders WHERE AmazonOrderId ='".mysql_real_escape_string($orderID)."'"; 
		$this->query($strSQLQuery, 0);
		$strSQLQuery = "DELETE FROM e_orderdetail WHERE OrderID ='".mysql_real_escape_string($arryRow[0]['OrderID'])."'"; 
		$this->query($strSQLQuery, 0);
	}
	*/
    $strSQLQuery = "select OrderID,SaleID from s_order where CustomerPO = '" . $orderID."' ";
    $arryRow = $this->query($strSQLQuery, 1);

	$WQuery = "select s.OrderID,w.ShipmentStatus from s_order s left join w_shipment w on(s.OrderID=w.ShippedID) where CustomerPO = '" . $orderID."' and Module='Shipment' ";
    $WarryRow = $this->query($WQuery, 1);
    
    if (!empty($arryRow[0]['SaleID']) && $WarryRow[0]['ShipmentStatus']!='Shipped') { 
		$strSQLQuery = "DELETE from s_order where CustomerPO = '" .$orderID."' ";
	        $this->query($strSQLQuery, 0);
		$strSQLQuery = "DELETE from s_order_item where OrderID = '" . $arryRow[0]['OrderID']."' ";
	        $this->query($strSQLQuery, 0);

	    $strSQLQuery = "SELECT JournalID FROM f_gerenal_journal WHERE ReferenceID ='".trim($arryRow[0]['SaleID'])."'";
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['JournalID'])) {
			$strSQLQuery = "DELETE FROM f_gerenal_journal WHERE JournalID ='".mysql_real_escape_string($arryRow[0]['JournalID'])."'"; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "DELETE FROM f_gerenal_journal_entry WHERE JournalID ='".mysql_real_escape_string($arryRow[0]['JournalID'])."'"; 
			$this->query($strSQLQuery, 0);
		} 
    }	
 }

function deleteSyncOrder($oid)
 {
 	$strSQLQuery = "DELETE FROM e_orders WHERE OrderID = '".mysql_real_escape_string($oid)."'";
 	$this->query($strSQLQuery, 0);
 	$strSQLQuery = "DELETE FROM e_orderdetail WHERE OrderID = '".mysql_real_escape_string($oid)."'";
 	$this->query($strSQLQuery, 0);
 }

function deleteOrderByEmptyAddress($orderID){
    $strSQLQuery = "select OrderID from e_orders where AmazonOrderId = '" . mysql_real_escape_string($orderID)."' ";
    $arryRow = $this->query($strSQLQuery, 1);

	if (!empty($arryRow[0]['OrderID'])) {
		$strSQLQuery = "DELETE FROM e_orders WHERE AmazonOrderId ='".mysql_real_escape_string($orderID)."'"; 
		$this->query($strSQLQuery, 0);
		$strSQLQuery = "DELETE FROM e_orderdetail WHERE OrderID ='".mysql_real_escape_string($arryRow[0]['OrderID'])."'"; 
		$this->query($strSQLQuery, 0);
	}
 			
	$strSQLQuery = "select OrderID,SaleID from s_order where CustomerPO = '" . $orderID."' and Module='Order' ";
	$arryRow1 = $this->query($strSQLQuery, 1);
	
	if (!empty($arryRow1[0]['OrderID'])) {
		$strSQLQuery = "DELETE from s_order where CustomerPO = '" .$orderID."' ";
		$this->query($strSQLQuery, 0);
		$strSQLQuery = "DELETE from s_order_item where OrderID = '" . $arryRow1[0]['OrderID']."' ";
		$this->query($strSQLQuery, 0);
	}
 }
 

 /*-------------------Ebay Sync product ------------------*/
 function syncEbayProducts($Prefix,$pageId = 1){
 	global $Config;
 	$objConfig=new admin();
 	$objItem = new items();

	$ItemCondition='';
	$ItemConditionNote='';
	$ShortDetail='';
	$accountID='';
	$Tax='';

 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) { die('Account not exists');}
 
 	include($Prefix.'ebay/keys.php');
 	require_once($Prefix.'ebay/eBaySession.php');
 		
 	$siteID = 0;
 	$verb = 'GetMyeBaySelling';
 	// <DetailLevel> DetailLevelCodeType </DetailLevel><GranularityLevel>Fine</GranularityLevel>260ea4f4f8497ab6af9eee6bdb5ea6d0
 	/*  	$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
 	<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
 	<StartTimeFrom>2016-04-19T18:10:38.204Z</StartTimeFrom>
 	<StartTimeTo>2016-07-19T18:10:38.204Z</StartTimeTo>
 	<DetailLevel>ReturnAll</DetailLevel>
 	<Pagination>
 	<PageNumber>1</PageNumber>
 	<EntriesPerPage>200</EntriesPerPage>
 	</Pagination>
 	<RequesterCredentials>
 	<eBayAuthToken>'.$userToken.'</eBayAuthToken>
 	</RequesterCredentials>
 	</GetSellerListRequest>'; */
 	$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
					<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
 						<DetailLevel>ReturnAll</DetailLevel>
					    <ActiveList>
					    <Sort>TimeLeft</Sort>
						    <Pagination>
						      <EntriesPerPage>200</EntriesPerPage>
						      <PageNumber>'.$pageId.'</PageNumber>
						    </Pagination>
					  </ActiveList>
					  <RequesterCredentials>
					    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
					  </RequesterCredentials>
					</GetMyeBaySellingRequest>';
 
 	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
 	$responseXml = $session->sendHttpRequest($requestXmlBody);
 
 	if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
 		die('<P>Error sending request');
 
 		$responseDoc = new DomDocument();
 		$responseDoc->loadXML($responseXml);
 
 		//get any error nodes
 		$errors = $responseDoc->getElementsByTagName('Errors');
 		$response = simplexml_import_dom($responseDoc);
 		#echo "<pre>";print_r($response);die;
 		if ($errors->length > 0)
 		{
 			echo '<P><B>eBay returned the following error(s):</B>';
 			//display each error
 			//Get error code, ShortMesaage and LongMessage
 			$code = $errors->item(0)->getElementsByTagName('ErrorCode');
 			$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
 			$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
 				
 			//Display code and shortmessage
 			echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
 				
 			//if there is a long message (ie ErrorLevel=1), display it
 			if (count($longMsg) > 0)
 				echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
 
 		}
 		else
 		{
 			$products = $response->ActiveList->ItemArray->Item;
 			if(!empty($products)){
 				foreach ($products as $product){
 					$sql = "select ProductCode from amazon_items where ProductCode ='".stripslashes($product->ItemID)."' ";
 					$exist = $this->query($sql,1);
 
 					$LaunchDate = $product->ListingDetails->StartTime;
 
 					/* $y = explode("/",$product->ListingDetails->ViewItemURL);
 					 $y = str_replace("cgi.sandbox.", "", $y[2]);
 					 $pos = strpos($y, 'ebay.');
 					 $y = ($pos !== false)?$y:'ebay'; */
 
 					if(empty($exist)){
 						$sql = "INSERT INTO amazon_items
								(Name,ProductSku, ProductType, ProductCode, ProductTypeName, Quantity, Price, ItemCondition, ItemConditionNote, ShortDetail, LaunchDate,Price2, FeedProcessingStatus,
								  Status, LastUpdateDate, AmazonAccountID, TaxCode, FulfilledBy, Channel)
						 		 VALUES ('".addslashes($product->Title)."','".addslashes($product->SKU)."', '".addslashes($product->ListingType)."', '".addslashes($product->ItemID)."', '".addslashes($product->ListingDuration)."',  '".(int)$product->Quantity."', '".$product->SellingStatus->CurrentPrice."', '".addslashes($ItemCondition)."', '".addslashes($ItemConditionNote)."', '".addslashes($ShortDetail)."', '".$LaunchDate."', '".$product->BuyItNowPrice."', 'Active',
						 		 		'1', '".$Config['TodayDate']."', '".$accountID."', '".$Tax."', '".addslashes($product->ListingDetails->ViewItemURL)."', 'ebay')";
 						$this->query($sql,0);
 					}else{
 						$sql = "UPDATE amazon_items SET 
 								Name = '".addslashes($product->Title)."',
								ProductType = '".addslashes($product->ListingType)."' ,
								ProductTypeName = '".addslashes($product->ListingDuration)."',
								Quantity = '".(int)$product->Quantity."',
								Price = '".$product->SellingStatus->CurrentPrice."',
								ItemCondition = '".addslashes($ItemCondition)."',
								ItemConditionNote = '".addslashes($ItemConditionNote)."',
								ShortDetail = '".addslashes($ShortDetail)."' ,
								Price2 = '".$product->BuyItNowPrice."',
								LastUpdateDate = '".$Config['TodayDate']."' where ProductCode ='".stripslashes($product->ItemID)."' ";
						 		
 						$this->query($sql,0);
 					}
 				}
 			}
 
 		}
 		
 		$pageId = $pageId+1;
 		$totalPages = $response->ActiveList->PaginationResult->TotalNumberOfPages;
 		if($pageId<=$totalPages){ $this->syncEbayProducts($Prefix,$pageId); }
 		
 }
 
 public function updateEbayAllPrice($Prefix,$pqAll){
 	if(!empty($pqAll)){
 		global $Config;
 		$objConfig=new admin();
 		$objItem = new items();
 		$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 		if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}
 
 		include($Prefix.'ebay/keys.php');
 		require_once($Prefix.'ebay/eBaySession.php');
 
 		$siteID = 0;
 		$verb = 'ReviseInventoryStatus';
 		$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
						<ReviseInventoryStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">
						  <RequesterCredentials>
						    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
						  </RequesterCredentials>
						  <WarningLevel>High</WarningLevel>';
 
 		foreach ($pqAll as $ItemID => $new_price){
 			$requestXmlBody .='<InventoryStatus>
	   						<ItemID>'.$ItemID.'</ItemID>
						  	<StartPrice>'.$new_price.'</StartPrice>
						  </InventoryStatus>';
 
 			$this->updateTableQntPriceForEaby('Price', $new_price, $ItemID);
 				
 		}
 
 		$requestXmlBody .='</ReviseInventoryStatusRequest>';
 
 		$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
 		$responseXml = $session->sendHttpRequest($requestXmlBody);
 
 		if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
 			die('<P>Error sending request');
 				
 			$responseDoc = new DomDocument();
 			$responseDoc->loadXML($responseXml);
 			$errors = $responseDoc->getElementsByTagName('Errors');
 			$response = simplexml_import_dom($responseDoc);
 			//echo "<pre>";print_r($response);die;
 			if ($errors->length > 0)
 			{
 				echo '<P><B>eBay returned the following error(s):</B>';
 				$code = $errors->item(0)->getElementsByTagName('ErrorCode');
 				$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
 				$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
 				echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
 				if (count($longMsg) > 0)
 					echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
 			}
 			else
 			{
 				return true;
 			}
 	}
 }
 
 public function updateEbayAllQuantity($Prefix,$pqAll){
 	if(!empty($pqAll)){
 		global $Config;
 		$objConfig=new admin();
 		$objItem = new items();
 		$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 		if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}
 
 		include($Prefix.'ebay/keys.php');
 		require_once($Prefix.'ebay/eBaySession.php');
 
 		$siteID = 0;
 		$verb = 'ReviseInventoryStatus';
 		$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
						<ReviseInventoryStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">
						  <RequesterCredentials>
						    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
						  </RequesterCredentials>
						  <WarningLevel>High</WarningLevel>';
 
 		foreach ($pqAll as $ItemID => $new_qunty){
 			$requestXmlBody .='<InventoryStatus>
			 					  <ItemID>'.$ItemID.'</ItemID>
								  <Quantity>'.$new_qunty.'</Quantity>
						  	   </InventoryStatus>';
 				
 			$this->updateTableQntPriceForEaby('Quantity', $new_qunty, $ItemID);
 
 		}
 
 		$requestXmlBody .='</ReviseInventoryStatusRequest>';
 
 		$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
 		$responseXml = $session->sendHttpRequest($requestXmlBody);
 
 		if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
 			die('<P>Error sending request');
 
 			$responseDoc = new DomDocument();
 			$responseDoc->loadXML($responseXml);
 			$errors = $responseDoc->getElementsByTagName('Errors');
 			$response = simplexml_import_dom($responseDoc);
 			//echo "<pre>";print_r($response);die;
 			if ($errors->length > 0)
 			{
 				echo '<P><B>eBay returned the following error(s):</B>';
 				$code = $errors->item(0)->getElementsByTagName('ErrorCode');
 				$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
 				$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
 				echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
 				if (count($longMsg) > 0)
 					echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
 			}
 			else
 			{
 				return true;
 			}
 	}
 }
 
 public function deleteEbayProduct($Prefix, $ItemID, $id){
 	global $Config;
 	$objConfig=new admin();
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}

	if(!empty($ItemID)){
 	try{

	 	include($Prefix.'ebay/keys.php');
	 	require_once($Prefix.'ebay/eBaySession.php');
	 
	 	$siteID = 0;
	 	$verb = 'EndItem';
	 	$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
						<EndItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
						  <RequesterCredentials>
							<eBayAuthToken>'.$userToken.'</eBayAuthToken>
						  </RequesterCredentials>
						  <ItemID>'.$ItemID.'</ItemID>
						  <EndingReason>NotAvailable</EndingReason>
						</EndItemRequest>';
	 
	 	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
	 	$responseXml = $session->sendHttpRequest($requestXmlBody);
	 
	 	if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
	 		die('<P>Error sending request');
	 
	 		$responseDoc = new DomDocument();
	 		$responseDoc->loadXML($responseXml);
	 		$errors = $responseDoc->getElementsByTagName('Errors');
	 		$response = simplexml_import_dom($responseDoc);
	 		//echo "<pre>";print_r($response);die;
	 		if ($errors->length > 0)
	 		{
	 			echo '<P><B>eBay returned the following error(s):</B>';
	 			$code = $errors->item(0)->getElementsByTagName('ErrorCode');
	 			$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
	 			$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
	 			echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
	 			if (count($longMsg) > 0)
	 				echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
	 		}
	 		else
	 		{
	 			$this->deleteAmazonDataFromTable($id);
	 			return true;
	 		}
	}catch(Exception $e){
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	}
	$this->deleteAmazonDataFromTable($id);
	return true;
 }
 
 
 // nov2018
 public function deleteMultipleEbayProduct($Prefix, $ItemIDAll){
 	global $Config;
 	$objConfig=new admin();
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}

	if(!empty($ItemIDAll)){
 	try{
		$ids = implode(",",$ItemIDAll);
	 	include($Prefix.'ebay/keys.php');
	 	require_once($Prefix.'ebay/eBaySession.php');
	 
	 	$siteID = 0; $i=1;
	 	$verb = 'EndItems';
	 	$requestXmlBody ='<?xml version="1.0" encoding="utf-8"?>
						<EndItemsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
						  <RequesterCredentials>
							<eBayAuthToken>'.$userToken.'</eBayAuthToken>
						  </RequesterCredentials>';
		  	foreach ($ItemIDAll as $ItemID){
 		$requestXmlBody .='<EndItemRequestContainer>
								<MessageID>'.$i.'</MessageID>
								<EndingReason>ProductDeleted</EndingReason>
								<ItemID>'.trim($ItemID).'</ItemID>
							  </EndItemRequestContainer>';
			$i++;
 		}
 		
		$requestXmlBody .='</EndItemsRequest>';
	 	//echo $requestXmlBody;die;
	 	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
	 	$responseXml = $session->sendHttpRequest($requestXmlBody);
	 
	 	if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
	 		die('<P>Error sending request');
	 
	 		$responseDoc = new DomDocument();
	 		$responseDoc->loadXML($responseXml);
	 		$errors = $responseDoc->getElementsByTagName('Errors');
	 		$response = simplexml_import_dom($responseDoc);
	 		//echo "<pre>";print_r($response);die;
	 		if ($errors->length > 0)
	 		{
	 			echo '<P><B>eBay returned the following error(s):</B>';
	 			$code = $errors->item(0)->getElementsByTagName('ErrorCode');
	 			$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
	 			$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
	 			echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
	 			if (count($longMsg) > 0)
	 				echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
	 		}
	 		else
	 		{
	 			//$this->deleteAmazonDataFromTable($id);
	 			//return true;
	 		}
	}catch(Exception $e){
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	}
	
	if(empty($ids)) $ids = 0;
	$this->query("DELETE from amazon_items where ProductCode IN ($ids) and Channel = 'ebay' ",0);
	return true;
 }
 
 
 public function constructPostCallAndGetResponse($appID, $query, $condition , $type) {
 	$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
 	//$query = 'harry potter';
 
 	global $xmlrequest;
 	$xmlfilter ='<itemFilter>
			  <Name>Condition</Name>
			  <Value>'.$condition.'</Value>
			  <Name>ListingType</Name>
			  <Value>'.$type.'</Value>
			</itemFilter>';
 	// Create the XML request to be POSTed
 	$xmlrequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 	$xmlrequest .= "<findItemsByKeywordsRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">\n";
 	$xmlrequest .= "<keywords>";
 	$xmlrequest .= $query;
 	$xmlrequest .= "</keywords>\n";
 	//$xmlrequest .= $xmlfilter;
 	$xmlrequest .= "<paginationInput>\n <entriesPerPage>10</entriesPerPage>\n</paginationInput>\n";
 	$xmlrequest .= "</findItemsByKeywordsRequest>";
 
 	// Set up the HTTP headers
 	$headers = array(
 			'X-EBAY-SOA-OPERATION-NAME: findItemsByKeywords',
 			'X-EBAY-SOA-SERVICE-VERSION: 1.3.0',
 			'X-EBAY-SOA-REQUEST-DATA-FORMAT: XML',
 			'X-EBAY-SOA-GLOBAL-ID: EBAY-US',
 			'X-EBAY-SOA-SECURITY-APPNAME: '.$appID,
 			'Content-Type: text/xml;charset=utf-8',
 	);
 
 	$session  = curl_init($endpoint);                       // create a curl session
 	curl_setopt($session, CURLOPT_POST, true);              // POST request type
 	curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array
 	curl_setopt($session, CURLOPT_POSTFIELDS, $xmlrequest); // set the body of the POST
 	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out
 
 	$responsexml = curl_exec($session);                     // send the request
 	curl_close($session);                                   // close the session
 	return $responsexml;                                    // returns a string
 
 }
 
 public function searchEbayItemByKeywords($Prefix, $query,$condition, $type){
 	global $Config;
 	$objConfig=new admin();
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) {echo 'Account not exists'; return -1;}
 
 	include($Prefix.'ebay/keys.php');
 	require_once($Prefix.'ebay/eBaySession.php');
 
 	$appID = 'sanjivsi-testingV-PRD-d57734143-c893da4d';
 	$resp = simplexml_load_string($this->constructPostCallAndGetResponse($appID,$query, $condition, $type));
 
 	if ($resp->ack == "Success")
 	{
 		return $resp->searchResult->item;
 	}
 	else
 	{
 		$results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
 		$results .= "AppID for the Production environment.</h3>";
 	}
 }
 
 public function getEbayCategoties($Prefix, $siteID=null, $level=1, $catID=0){
 	global $Config;
 	$objConfig=new admin();
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) {echo 'Account not exists'; return -1;}
 
 	if(is_null($siteID)) {echo 'Please select site id first!'; return -1;}
 
 	include($Prefix.'ebay/keys.php');
 	require_once($Prefix.'ebay/eBaySession.php');
 
 	$verb = 'GetCategories';
 	$Parent = '';
 	if($level>1 && $catID>0){
 		$Parent = '<CategoryParent>'.(int)$catID.'</CategoryParent>';
 		$level = '<LevelLimit>'.$level.'</LevelLimit>';
 	}else{
 		$Parent = '<CategorySiteID>'.$siteID.'</CategorySiteID>';
 		$level = '<LevelLimit>1</LevelLimit>';
 	}
 	$requestXmlBody='<?xml version="1.0" encoding="utf-8"?>
					<GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
					  <RequesterCredentials>
					    <eBayAuthToken>'.$userToken.'</eBayAuthToken>
					  </RequesterCredentials>
					  '.$Parent.'
					  <DetailLevel>ReturnAll</DetailLevel>
					  '.$level.'
					</GetCategoriesRequest>';
 
 	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
 	$responseXml = $session->sendHttpRequest($requestXmlBody);
 
 	if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
 		die('<P>Error sending request');
 
 		$responseDoc = new DomDocument();
 		$responseDoc->loadXML($responseXml);
 		$errors = $responseDoc->getElementsByTagName('Errors');
 		$response = simplexml_import_dom($responseDoc);
 		//echo "<pre>";print_r($response);die;
 		if ($errors->length > 0)
 		{
 			echo '<P><B>eBay returned the following error(s):</B>';
 			$code = $errors->item(0)->getElementsByTagName('ErrorCode');
 			$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
 			$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
 			echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
 			if (count($longMsg) > 0)
 				echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
 		}
 		else
 		{
 			return $response->CategoryArray;
 		}
 }
 
 function ebaySiteList(){
 	return array(
 			0=>'United States',
 			2=>'Canada (English)',
 			3=>'UK',
 			15=>'Australia',
 			16=>'Austria',
 			23=>'Belgium (French)',
 			71=>'France',
 			77=>'Germany',
 			101=>'Italy',
 			123=>'Belgium (Dutch)',
 			146=>'Netherlands',
 			186=>'Spain',
 			193=>'Switzerland',
 			201=>'Hong Kong',
 			203=>'India',
 			205=>'Ireland',
 			207=>'Malaysia',
 			210=>'Canada (French)',
 			211=>'Philippines',
 			212=>'Poland',
 			216=>'Singapore'
 	);
 }
 
 function ebaySiteName(){
 	return array(
 			0=>'US',
 			2=>'Canada',
 			3=>'UK',
 			15=>'Australia',
 			16=>'Austria',
 			23=>'Belgium_French',
 			71=>'France',
 			77=>'Germany',
 			101=>'Italy',
 			123=>'Belgium_Dutch',
 			146=>'Netherlands',
 			186=>'Spain',
 			193=>'Switzerland',
 			201=>'HongKong',
 			203=>'India',
 			205=>'Ireland',
 			207=>'Malaysia',
 			210=>'CanadaFrench',
 			211=>'Philippines',
 			212=>'Poland',
 			216=>'Singapore'
 	);
 }
 
 function updateTableQntPriceForEaby($type, $value, $ItemID){
 	if($type=='Price') $set = " Price='".$value."' " ;
 	else if($type=='Quantity') $set = " Quantity='".$value."'";
 
 	$sql = "update amazon_items set $set where ProductCode='".$ItemID."' and channel='ebay' ";
 	$this->query($sql,0);

	$sql1 = "select pid from amazon_items where ProductCode='".$ItemID."' ";
 	$data = $this->query($sql1,1);
 	if(!empty($data[0]['pid'])){
	 	$sql = "update inv_items set qty_on_hand='".$value."' where ref_id='".$data[0]['pid']."' ";
	 	$this->query($sql,0);
 	}
 }
 
 function saveEbayData($arrData){ 
 	extract($arrData);
 	global $Config;
 	$isExist = false;

 	if(empty($itemID)) $itemID = 0;
 	$sql = "select itemID, AliasID from amazon_items where itemID ='".addslashes($itemID)."' and AliasID='".addslashes($AliasID)."' and channel='ebay' ";
 	$exist = $this->query($sql,1);
 	 	//pr($exist,1);
 	if(!empty($exist[0]['itemID'])){
 		$isExist = true;
 		$where = "itemID=$itemID and channel='ebay'";
 	}else if(!empty($exist[0]['AliasID'])){
 		$isExist = true;
 		$where = "AliasID=$AliasID and channel='ebay'";
 	}
 		
 	if($isExist){ 
 		$sql = "UPDATE amazon_items SET Name='".addslashes($itemTitle)."',
 										ProductCode = '".addslashes($ProductCode)."',
 										browserNode = '".addslashes($SiteName)."',
 										Cat = '".addslashes($primaryCategory)."',
 										Quantity='".(int)$Quantity."',
 										Price='".$startPrice."',
										Price2='".$startPrice."',
 										ShortDetail='".addslashes($itemDescription)."',
 										ItemCondition='".addslashes($itemCondition)."',
 										LastUpdateDate='".$Config['TodayDate']."',
 										ProductTypeName='".addslashes($listingDuration)."',
 										FeedProcessingSMsg='".addslashes($FeedProcessingSMsg)."',
 										FeedProcessingStatus= '".addslashes($FeedProcessingStatus)."',
 										FulfilledBy= '".addslashes($ViewItemURL)."',
 										CatHierarchy= '".addslashes($CatHierarchy)."',
										Status= '".addslashes($Status)."',
 										ProductType='".addslashes($listingType)."' where $where
 				";
		$this->query($sql,0);
 	}else{ 
 		$sql = "INSERT INTO amazon_items
								(itemID, Name,ProductSku,browserNode, ProductType, ProductCode, ProductTypeName,Cat, MfrPartNumber, Quantity, ItemCondition, ItemConditionNote, ShortDetail, LaunchDate,Price,Price2, Brand, FeedProcessingStatus,
								  Status,FeedProcessingSMsg, LastUpdateDate, SaleStartDate, AmazonAccountID, TaxCode, FulfilledBy, Channel,CatHierarchy, AliasID)
						 		 VALUES ('".addslashes($itemID)."','".addslashes($itemTitle)."','".addslashes($SKU)."', '".$SiteName."', '".addslashes($listingType)."', '".addslashes($ProductCode)."', '".addslashes($listingDuration)."',  '".addslashes($primaryCategory)."', '".addslashes($MfrPartNumber)."', '".(int)$Quantity."', '".addslashes($itemCondition)."', '".addslashes($ItemConditionNote)."', '".addslashes($itemDescription)."', '".$Config['TodayDate']."', '".$startPrice."', '".$startPrice."', '".addslashes($Brand)."', '".$FeedProcessingStatus."',
						 		 		'1', '".addslashes($FeedProcessingSMsg)."', '".$Config['TodayDate']."','".$Config['TodayDate']."', '', '', '".addslashes($ViewItemURL)."', 'ebay', '".addslashes($CatHierarchy)."', '".addslashes($AliasID)."')";
 		$this->query($sql,0);
 	}
 }
 
 function updateEbayItemIDBySKU($ProductCode, $FulfilledBy,$sku){
 	if(!empty($sku)){
 		$sql = "update amazon_items set ProductCode='".addslashes($ProductCode)."', FulfilledBy='".addslashes($FulfilledBy)."' where ProductSku ='".stripslashes($sku)."' and channel='ebay' ";
 		$this->query($sql,0);
 	}
 }
 
 function updateEbayCategory($cat, $ItemID){
 	if(!empty($cat)){
 		$sql = "update amazon_items set Cat='".addslashes($cat)."' where itemID ='".stripslashes($ItemID)."' and channel='ebay' ";
 		$this->query($sql,0);
 	}
 }
 
 Public function listBatchEbay($Prefix){
 	global $Config;
 	require_once($Prefix."classes/manufacturer.class.php");
 	$objManufacturer = new Manufacturer();
 	$objConfig=new admin();
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) { die('Account not exists'); return -1;}
 
 	include($Prefix.'ebay/keys.php');
 	require_once($Prefix.'ebay/eBaySession.php');
 
 	$verb = 'AddItems';
 	$siteID = 0;
 
 	$sql = "select p1.*, Mid from amazon_items p1 left join e_products p2 on(p1.itemID = p2.ProductID) where FeedProcessingStatus='UnProcessed' and Channel='ebay' limit 5 ";
 	$data = $this->query($sql, 1);
 	
 	$arryManufacturer = $objManufacturer->getManufacturer('',1,'','','');
 	
 	if(!empty($data)){
 
 		$xml= '<?xml version="1.0" encoding="utf-8" ?>
		<AddItemsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
 		<RequesterCredentials>
 				<eBayAuthToken>'.$userToken.'</eBayAuthToken>
		  </RequesterCredentials>
		  <ErrorLanguage>en_US</ErrorLanguage>
		  <WarningLevel>High</WarningLevel>';
 		$i = 0;
 		foreach($data as $values):
 		extract($values);
 
 		$msgStatus = false;
 		if(empty($Cat)){
 			$msgStatus = true;
 			$msg = 'Did not find category for this item. Please search manually.';
 		}else if(empty($ShortDetail)){
 			$msgStatus = true;
 			$msg = 'Description is missing.A description is required';
 		}else if(empty($Quantity)){
 			$msgStatus = true;
 			$msg = 'Quantity is not valid.The quantity must be a valid number greater than 0.';
 		}
 
 		if($msgStatus){
 			$sql = "UPDATE amazon_items set FeedProcessingStatus='Error',FeedProcessingSMsg='".$msg."' where pid='".$pid."' ";
 			$this->query($sql,0);
 			continue;
 		}
 		
 		for ($i = 0; $i < sizeof($arryManufacturer); $i++) {
 			if ($arryManufacturer[$i]['Mid'] == $values['Mid']) {
 				$mid = stripslashes($arryManufacturer[$i]['Mname']);
 			}
 		}
 		$mid = (!empty($mid)) ? '<Brand>'.$mid.'</Brand>' : '';
 		
 		$i++;
 		$xml .= '<AddItemRequestContainer>
		    <MessageID>'.$i.'</MessageID>
		    <Item>
		        <Title>'.$Name.'</Title>
			    <Description>'.$ShortDetail.'</Description>
			    <PrimaryCategory>
			      <CategoryID>'.$Cat.'</CategoryID>
			    </PrimaryCategory>
			    <StartPrice>'.$Price2.'</StartPrice>
			    <CategoryMappingAllowed>true</CategoryMappingAllowed>
			    <Country>US</Country>
			    <Currency>'.$Config['Currency'].'</Currency>
			    <ConditionID>'.$ItemCondition.'</ConditionID>
			    <DispatchTimeMax>3</DispatchTimeMax>
			    <ListingDuration>'.$ProductTypeName.'</ListingDuration>
			    <ListingType>'.$ProductType.'</ListingType>
			    <PaymentMethods>PayPal</PaymentMethods>
			    <PayPalEmailAddress>'.$paypalEmailAddress.'</PayPalEmailAddress>
			    <PictureDetails>
			      <PictureURL>http://pics.ebay.com/aw/pics/dot_clear.gif</PictureURL>
			    </PictureDetails>
			    <PostalCode>95125</PostalCode>
			    <Quantity>'.(int) $Quantity.'</Quantity>
			    <ProductListingDetails>
			    		 <BrandMPN>
			    			'.$mid.'
			    			 <MPN>'.$MfrPartNumber.'</MPN>
			    		 </BrandMPN>
			    </ProductListingDetails>
			    <ReturnPolicy>
			      <ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
			      <RefundOption>MoneyBack</RefundOption>
			      <ReturnsWithinOption>Days_30</ReturnsWithinOption>
			      <Description>If you are not satisfied, return the book for refund.</Description>
			      <ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>
			    </ReturnPolicy>
			    <ShippingDetails>
			      <ShippingType>Flat</ShippingType>
			      <ShippingServiceOptions>
			        <ShippingServicePriority>1</ShippingServicePriority>
			        <ShippingService>USPSMedia</ShippingService>
			        <ShippingServiceCost>2.50</ShippingServiceCost>
			      </ShippingServiceOptions>
			    </ShippingDetails>
			    <Site>US</Site>
				<SKU>'.$ProductSku.'</SKU>
		    </Item>
		  </AddItemRequestContainer>';
 		endforeach;
 		$xml .='</AddItemsRequest>';
//echo $xml;die;
 		$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
 		$array = array();
 
 		$responseXml = $session->sendHttpRequest(utf8_encode($xml));
 		if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
 			die('<P>Error sending request');
 				
 			$responseDoc = new DomDocument();
 			$responseDoc->loadXML($responseXml);
 				
 			//pr($responseDoc);
 			//get any error nodes
 			$errors = $responseDoc->getElementsByTagName('Errors');
 			//pr($errors,1);
 			//$response = simplexml_import_dom($responseDoc);
 			
 			if($errors->length >0)
 			{
 				$Status = 'Error';
 				$x = '';
 				$code     = $errors->item(0)->getElementsByTagName('ErrorCode');
 				$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
 				$longMsg  = $errors->item(0)->getElementsByTagName('LongMessage');

 				$x .=  $_POST['FeedProcessingSMsg'] = $shortMsg->item(0)->nodeValue.'<br/>';
 				
 				if(count($longMsg) > 0){
 					$x .= $_POST['FeedProcessingSMsg'] = $longMsg->item(0)->nodeValue;
 				}	
 					$sql = "update amazon_items set FeedProcessingSMsg='".addslashes($x)."', FeedProcessingStatus='".addslashes($Status)."'  where pid = $pid";	
 					$this->query($sql,0);
 					
 					$_SESSION['CRE_Msg'] = $x;
 			}
 			else
 			{ //no errors
 				$Status = 'Active';
 				$_POST['FeedProcessingSMsg'] = '';
 				$responses = $responseDoc->getElementsByTagName("AddItemResponse");
 				$itemID = "";
 				foreach ($responses as $response) {
 					$acks = $response->getElementsByTagName("Ack");
 					$ack   = $acks->item(0)->nodeValue;
 						
 					$endTimes  = $response->getElementsByTagName("EndTime");
 					$endTime   = $endTimes->item(0)->nodeValue;
 					$items  = $response->getElementsByTagName("AddItemResponseContainer");
 
 					foreach ($items as $item){
 						$itemIDs  = $item->getElementsByTagName("ItemID");
 						$itemid   = $itemIDs->item(0)->nodeValue;
 						array_push($array, $itemid);
 
 						//$linkBase = "http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
 						// $linkBase . $itemID ;
 						//echo "<a href=$linkBase" . $itemID . ">$itemTitle</a> <BR />";
 					}
 
 					if(!empty($array)) $this->getEbayItemDetails($Prefix,$array);
 				} // foreach response
 			}
 	}//data close if condition
 }
 
 
 function getEbayItemDetails($Prefix, $data){
 	global $Config;
 	$objConfig=new admin();
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}
 
 	include($Prefix.'ebay/keys.php');
 	require_once($Prefix.'ebay/eBaySession.php');
 		
 	$siteID = 0;
 	$verb = 'GetMultipleItems';
 
 	$requestXmlBody ='<?xml version="1.0" encoding="utf-8" ?>
		 <GetMultipleItemsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
		 <DetailLevel>ReturnAll</DetailLevel>';
 	foreach ($data as $values){
 		$requestXmlBody .='<ItemID>'.$values.'</ItemID>';
 	}
 	$requestXmlBody .='<RequesterCredentials>
		 <eBayAuthToken>'.$userToken.'</eBayAuthToken>
		 </RequesterCredentials>
		 </GetMultipleItemsRequest>';
 
 	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
 	$responseXml = $session->sendHttpRequest($requestXmlBody);
 
 	if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
 		die('<P>Error sending request');
 
 		$responseDoc = new DomDocument();
 		$responseDoc->loadXML($responseXml);
 
 		//get any error nodes
 		$errors = $responseDoc->getElementsByTagName('Errors');
 		$response = simplexml_import_dom($responseDoc);
 
 		if ($errors->length > 0)
 		{
 		}
 		else
 		{
 			$Item = $response->Item;
 			if (!empty($Item)){
 				$sandbox = ($arryEbayCredentials[0]['credential_type']=='Sandbox') ? '.sandbox' : '' ;
 				foreach ($Item as $singleItem){
 					$viewURL = "http://cgi$sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=".$singleItem->ItemID;
 					$this->updateEbayItemIDBySKU($singleItem->ItemID,$viewURL,$singleItem->SKU);
 				}
 				$_SESSION['CRE_Msg'] = 'Processed successfully on ebay.';
 			}else{
 				$_SESSION['CRE_Msg'] = 'Something went wrong, All Items are failed to add on ebay.';
 			}
 				
 		}
 }

 public function AddEbayProductToInlineList($productID){ 
 
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();

 	if(empty($arryEbayCredentials[0]['sync_product'])) { echo 'Sync Products via lowest price is not set in ebay settings.'; exit ;}

 	$sql = "select Name, ProductSku, ProductID itemID, Detail ShortDetail, Price Price, Price2 Price2, Quantity Quantity,NOW() LaunchDate,NOW() SaleStartDate, m.Mname Brand from e_products p left join e_manufacturers m on(m.Mid=p.Mid) where ProductID='".$productID."' ";
 	$productList = $this->query($sql,1);
 	
 	$vS = true ;
 	$emptyName ='';
 	if(empty($productList[0]['ProductSku'])) { $emptyName .= ' Sku ';$vS = false;  }
 	if(empty($productList[0]['Name'])) { $emptyName .= ' Title ';$vS = false;  }
 	if($productList[0]['Price']<1) { $emptyName .= ' Price '; $vS = false;  }
 	if($productList[0]['Quantity']<1) { $emptyName .= ' Quantity '; $vS = false;  }
 	
 	if($vS){
	 	foreach ($productList as $list){
	 		$list['SiteName']=$arryEbayCredentials[0]['site_id'];
 			$list['itemCondition']=$arryEbayCredentials[0]['item_condition'];
 			$list['listingDuration']=$arryEbayCredentials[0]['listing_duration'];
 			$list['listingType']=$arryEbayCredentials[0]['product_type'];
 			$list['MfrPartNumber']=$list['ProductSku'];
 			$list['itemDescription']=$list['Name'];
 			$list['itemTitle']=$list['Name'];
 			$list['itemDescription']=$list['Name'];
 			$list['SKU']=$list['ProductSku'];
 			$list['startPrice']=$list['Price'];
 			$list['Brand']= $list['Brand']; //settings is true then copy
 			$list['FeedProcessingStatus']='UnProcessed';
 			$list['ItemConditionNote']=(!empty($arryEbayCredentials[0]['condition_note'])) ? $arryEbayCredentials[0]['condition_note'] : $arryEbayCredentials[0]['item_condition'].' offer' ;
	 		$this->saveEbayData($list);
	 	}
 	}else{
 		$_SESSION['mess_product']= 'Ebay: Submission failded.'.$emptyName.' fields are empty!';
 		header('location: viewProduct.php?curP='.$_GET["curP"]);
 		exit;
 	}
 }
 
 public function AddEbayProductToList($productarry){
 	extract($productarry);
 
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) { die('Account not exists'); }
 	if(empty($ItemCondition)) die('Please select Item condition!');
 	if(empty($listingType)) die('Please select Listing Type!');
 		
 	$sql = "select Name itemTitle, ProductSku SKU, ProductID itemID, Detail ShortDetail,Price Price, Price2 startPrice, Quantity Quantity,NOW() LaunchDate,NOW() SaleStartDate from e_products where ProductID IN($AddToEbay) ";
 
 	$productList = $this->query($sql,1);
 	foreach ($productList as $list){
 		$list['SiteName']=$SiteName;
 		$list['itemCondition']=$ItemCondition;
 		$list['listingDuration']=$listingDuration;
 		$list['ItemConditionNote']=$ItemConditionNote;
 		$list['listingType']= $listingType;
 		$list['FeedProcessingStatus']='UnProcessed';
 		$this->saveEbayData($list);
 	}
 }
 
 function getLowestPriceEbay($Prefix){
 	global $Config;
 	$objConfig=new admin();
 	$objItem = new items();
 	$arryEbayCredentials=$objItem->GetEbayCredentials();
 
 	if(empty($arryEbayCredentials)) {echo 'Account not exists'; return ;}
 
 	include($Prefix.'ebay/keys.php');
 	require_once($Prefix.'ebay/eBaySession.php');
 
 	$sql1 = "select count(*) count from amazon_items where Cat='' and channel='ebay' ";
 	$rowCount = $this->query($sql1, 1);
 
 	$sql = "select pid, itemID, Name, ProductSku, Cat, ItemCondition, ProductType from amazon_items where Cat='' and channel='ebay' LIMIT 25";
 	$asinLists = $this->query($sql, 1);
 	//pr($asinLists,1);
 	if(!empty($asinLists)):
 	foreach ($asinLists as $list){
 		$result =   $this->searchEbayItemByKeywords($Prefix,trim($list['ProductSku']),trim($list['ItemCondition']),trim($list['ProductType']));
 
 		//sorting is pendding
 		/*$ASIN_List = $rList = $lowest_ASIN = $listprice = array();
 
 		if(!empty($lowest_ASIN)):
 		foreach ($lowest_ASIN as $key=>$price){
 		$p = $price->prices[0]->LandedPrice;
 		if($p>0)
 			$listprice[$key] = ($p)? $p : 0 ;
 			}
 			asort($listprice);
 			foreach ($listprice as $key => $value){
 			$pvalues = $rList[$key];
 
 			break;
 			}
 			endif;
 			*/
 		if(!empty($result)){
 			foreach ($result as $values){ //pr($values->primaryCategory->categoryId,1);
 				$this->updateEbayCategory($values->primaryCategory->categoryId,$list['itemID']);
 				break;
 			}
 		}
 
 	}
 	endif;
 
 	if($rowCount[0]['count']>count($asinLists)){
 		sleep(120);
 		$this->getLowestPriceEbay($Prefix);
 	}
 }
 
 
 
 /*-------------------End of Ebay Sync product -----------*/
 
/*********************************************************************************************
*			     End of Ebay product 
*********************************************************************************************/	

/*********Next Prevoius by Karishma 31 Aug 2016***********/
	function NextPrevRow($ProductID,$Next) {
		global $Config;
		$strAddQuery='';
		if($ProductID>0){			
			
			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select p.ProductID,p.CategoryID  from e_products p where p.ProductID ".$operator."'" . $ProductID . "'  ". $strAddQuery. " order by p.ProductID ".$asc." limit 0,1";
			$arrRow = $this->query($strSQLQuery, 1);
			if(!empty($arrRow[0]['ProductID'])){
				return array($arrRow[0]['ProductID'],$arrRow[0]['CategoryID']);
			}
		}
	}
	
	
	function GettotalActiveProductCurrentYear()
                 {
                     
                      $strSQLQuery = "SELECT * FROM e_products WHERE (DATE(AddedDate) BETWEEN '".date('Y').'-01-01'."' AND '".date('Y').'-12-31'."') AND Status = '1'";
                      return  $this->query($strSQLQuery);
                     
                 }





/**************************************************************/
# 	AMAZON RMA START
/**************************************************************/

	function runReportForRMA($Prefix){
	   global $Config;
	   $objConfig=new admin();
	   $accounts = $this->getAccountAll();
       if(!empty($accounts)){
		   $flag = false;
		   foreach ($accounts as $account ) {
				//if($account['sync_RMA']){
			   		$AmazonserviceForReport = $this->AmazonSettings($Prefix,false,$account['id']);
					$this->amazonReportRMA($Prefix,$AmazonserviceForReport);
					$flag = true;
				//}
		   }
		   if(!$flag) $_SESSION['mess_return'] = "No Amazon Account has set to Yes for RMA syncing.";
       }else{
			$_SESSION['mess_return'] = "No Amazon Account is Added";
		} 
	}

	function amazonReportRMA($Prefix, $service){
			
		 $request = new MarketplaceWebService_Model_GetReportListRequest();
		 $request->setMerchant($this->MERCHANT_ID);
		 $request->setAvailableToDate(new DateTime('now', new DateTimeZone('UTC')));
		 $request->setAvailableFromDate(new DateTime('-1 months', new DateTimeZone('UTC')));
		 $typeList = new MarketplaceWebService_Model_TypeList();
		 $request->setReportTypeList($typeList->withType('_GET_FLAT_FILE_RETURNS_DATA_BY_RETURN_DATE_'));
		 $request->setMaxCount(3);
		 $request->setAcknowledged(false);
		 $request->setMWSAuthToken($this->MWS_AUTH_TOKEN);

	 try {
            $response = $service->getReportList($request); 
                if ($response->isSetGetReportListResult()) { 
                 $getReportListResult = $response->getGetReportListResult();
                 $reportInfoList = $getReportListResult->getReportInfoList(); 
                 foreach ($reportInfoList as $reportInfo) { 
                	if ($reportInfo->getReportType()=='_GET_FLAT_FILE_RETURNS_DATA_BY_RETURN_DATE_') 
                        { 
                            $this->getAmazonReportRMA($Prefix, $service, $reportInfo->getReportId());
			   break;
                        }
                 } 
                } 
		     } catch (MarketplaceWebService_Exception $ex) {
				 echo("Caught Exception: " . $ex->getMessage() . "\n");
		         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
		         echo("Error Code: " . $ex->getErrorCode() . "\n");
		         echo("Error Type: " . $ex->getErrorType() . "\n");
		     }
  }


 function getAmazonReportRMA($Prefix, $service, $reportID){
 	global $Config;
	$objrmasale = new rmasale();
	$request = new MarketplaceWebService_Model_GetReportRequest();
	$request->setMerchant($this->MERCHANT_ID);
	$request->setReport(@fopen('php://memory', 'rw+'));
	$request->setReportId($reportID);
	$request->setMWSAuthToken($this->MWS_AUTH_TOKEN);
    
    try { 
           $response = $service->getReport($request);
          // stream_get_contents($request->getReport()); 
          $feeData = $this->getAmazonRMAFromXLS($Prefix, $request->getReport() );
         if(!empty($feeData)) {
			foreach ($feeData as $key => $values){
					if($values>0){
							 $objrmasale->amazonRMA($values,'Amazon');
					}
			}
          }
     } catch (MarketplaceWebService_Exception $ex) {
         echo("Caught Exception: " . $ex->getMessage() . "\n");
         echo("Response Status Code: " . $ex->getStatusCode() . "\n");
         echo("Error Code: " . $ex->getErrorCode() . "\n");
         echo("Error Type: " . $ex->getErrorType() . "\n");
     }
 }
 
 
 function getAmazonRMAFromXLS($Prefix, $FileData){
 	
    require_once($Prefix.'admin/php-excel-reader/excel_reader2.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader.php');
	require_once($Prefix.'admin/php-excel-reader/SpreadsheetReader_XLSX.php');
  	  $Filepath = "/var/www/html/erp/csv/rma.xls";
  	  file_put_contents($Filepath,'hh');
  	  file_put_contents($Filepath,$FileData); 
			#echo '<pre>';print_r($_POST);exit;
			$Spreadsheet = new SpreadsheetReader($Filepath);
			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
			$LeadAddedCount = 0;
			$LeadCount = 0;
			$arrayFees=array();
			foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				
				foreach ($Spreadsheet as $Key => $Row){
					if($Count==0){
						$orderIdIndex = array_search('Order ID', $Row);
						$dateIndex = array_search('Return request date', $Row);
				        $statusIndex = array_search('Return request status', $Row);
						$RMAidIndex = array_search('Amazon RMA ID', $Row);
						$merchantRMAidIndex = array_search('Merchant RMA ID', $Row);
						$qntityIndex = array_search('Return quantity', $Row);
						$reasonIndex = array_search('Return reason', $Row);
						$labelCostIndex = array_search('Label cost', $Row);
						$labelPaidIndex = array_search('Label to be paid by', $Row);
						$isPrimeIndex = array_search('Is prime', $Row);
						$deliveyDateIndex = array_search('Return delivery date', $Row);
						$merchandSKUIndex = array_search('Merchant SKU', $Row);
						$ReturncarrierIndex = array_search('Return carrier', $Row);
					}
					//echo "<pre>";	print_r($Row);echo "</pre>"; die;
					if(!empty($Row[$orderIdIndex]) && $Count>0){
						$arrayFees[] = array('Order_ID'=>$Row[$orderIdIndex],
											 'Return_request_status'=>$Row[$statusIndex],
											 'Return_request_date'=>$Row[$dateIndex],
											 'Amazon_RMA_ID'=>$Row[$RMAidIndex],
											 'Merchant_RMA_ID'=>$Row[$merchantRMAidIndex],
											 'Return_quantity'=>$Row[$qntityIndex],
											 'Return_reason'=>$Row[$reasonIndex],
											 'Label_cost'=>$Row[$labelCostIndex],
											 'Label_to_be_paid_by'=>$Row[$labelPaidIndex],
											 'Is_prime'=>$Row[$isPrimeIndex],
											 'Return_delivery_date'=>$Row[$deliveyDateIndex],
											 'Merchant_SKU'=>$Row[$merchandSKUIndex],
       										 'Return_carrier'=>$Row[$ReturncarrierIndex],
											);
					}
					$Count++;
				}
			}
			
			return $arrayFees;
 }

/**************************************************************/
# 	END OF AMAZON RMA
/**************************************************************/


	function CreateCustomAmazonSaleOrder($OrderID,$CustID,$CustomerPO){
	
		$res = $this->query("select * from e_customers where Cid='".$CustID."' ",1);
		$orderRes = $this->query("select count(CustomerPO) total from s_order where CustomerPO='".$CustomerPO."' ",1);

		if($orderRes[0]['total']>0) return $_SESSION['mess_order'] = "Sales Order is all ready exist.";
		
		if(!empty($res) && $OrderID){
			$cust = $res[0];
			$this->sync_order_in_sales($OrderID, $cust);
			$this->query("update e_orders set isCustom=1 where OrderID='".$OrderID."' ");
		}else{
			return $_SESSION['mess_order'] = "Some thing went wrong. Try after some time.";
		}
		
		return $_SESSION['mess_order'] = "Sales Order is created successfully.";
	}

}               
           
?>

