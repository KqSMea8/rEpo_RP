<?
class items extends dbClass
{
		//constructor
		function items()
		{
			$this->dbClass();
		} 
		
		function  GetItems($id=0,$CategoryID,$Status,$shortby,$Mfg)
		{

		        $strSQLQuery = "select p1.*,c1.ParentID from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID";
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status):(" and p1.Status=1 and c1.Status=1 ");
			$strSQLQuery .= (!empty($id))?(" where p1.ItemID=".$id):(" where 1 ");
			$strSQLQuery .= (!empty($CategoryID))?(" and p1.CategoryID=".$CategoryID):("");
                        //$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid=".$Mfg):("");
                        if($shortby == "name"){ $strSQLQuery .= "  order by p1.Name";}
                        elseif($shortby == "new"){$strSQLQuery .= "  order by p1.ItemID DESC";}
                        //elseif($shortby == "hprice"){$strSQLQuery .= "  order by p1.Price DESC"; }
                        //elseif($shortby == "lprice") {$strSQLQuery .= "  order by p1.Price ASC";}
                        else {$strSQLQuery .= "  order by p1.description";}
                        //echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}
                
       function  GetItemById($id)
		{
   
              $strAddQuery = ($id>0)?(" where p1.ItemID=".$id):(" where 1 ");
		     $strSQLQuery = "select p1.*,c1.ParentID from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID ".$strAddQuery;;
			
			
                        //echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}
                
               

		function  GetItemsView($id=0,$CategoryID,$SearchKey,$SortBy,$AscDesc,$Status)
		{
               
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where p1.ItemID=".$id):(" where 1");
			$strAddQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");
			
			$strAddQuery .= ($Status>0)?(" and p1.Status=".$Status." and m1.Status=1  "):("");
			
			if($SearchKey=='active' && ($SortBy=='p1.Status' || $SortBy=='') ){
				$strAddQuery .= " and p1.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='p1.Status' || $SortBy=='') ){
				$strAddQuery .= " and p1.Status=0";
			}
                        else if($SortBy=='p1.Sku'){
				$strAddQuery .= " and p1.Sku=".$SearchKey;
			}
                        else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (p1.description like '".$SearchKey."%' or p1.Sku like '%".$SearchKey."%' or p1.AddedDate like '%".$SearchKey."%') "):("");
			}
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by p1.ItemID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                       
			 $strSQLQuery = "select p1.* from inv_items p1 ".$strAddQuery;
                                                   
			return $this->query($strSQLQuery, 1);
			
		}

		

		function  getItemStyles($id=0,$CategoryIDs,$Status,$key)
		{
			$strSQLQuery = "select p1.ProductStyle from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID left outer join e_manufacturers b1 on p1.brandID = b1.brandID where p1.ProductStyle!='' ";

			$strSQLQuery .= ($CategoryIDs>0)?(" and (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):("");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%' )"):("");


			$strSQLQuery .= ' group by p1.ProductStyle order by p1.ProductStyle asc ';

			return $this->query($strSQLQuery, 1);
		}

		function  getItemSizes($id=0,$CategoryIDs,$Status,$key,$state_id,$PostedByID)
		{
			$strSQLQuery = "select p1.ProductSize from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID left outer join e_manufacturers b1 on p1.brandID = b1.brandID ";

			$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):(" where 1 ");

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%' )"):("");

			$strSQLQuery .= ($state_id>0)?(" and m1.state_id=".$state_id):("");


			$strSQLQuery .= ' group by p1.ProductSize order by p1.ProductSize asc ';

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



			//$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID left outer join e_manufacturers b1 on p1.Mid = b1.Mid where  p1.Status=1 and c1.Status=1 and b1.Status=1 ";
                        $strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID  where  p1.Status=1 and c1.Status=1 ";

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
                            

			$strSQLQuery .= ($CategoryID>0)?(" and  (p1.CategoryID =".$CategoryID." or c1.CategoryID =".$CategoryID." or c1.ParentID = ".$CategoryID." )"):("");

			$strSQLQuery .= ($cat>0)?(" and  (p1.CategoryID =".$cat." or c1.CategoryID =".$cat." )"):("");

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
                        elseif($shortBy == "new"){$strSQLQuery .= "  order by p1.ItemID DESC";}
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
		

		function  SimilarItems($ItemID,$CategoryIDs,$Status)
		{
			$strSQLQuery = "select p1.* from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):(" where 1 ");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= ($ItemID>0)?(" and p1.ItemID !=".$ItemID):("");

			$strSQLQuery .= ' order by p1.Name asc ';


			return $this->query($strSQLQuery, 1);
		}		

		function  SearchItemsCat($id=0,$CategoryIDs,$Status,$key,$state_id,$PostedByID,$Bidding)
		{
			$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):(" where 1 ");

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%')"):("");

			$strSQLQuery .= ($state_id>0)?(" and m1.state_id=".$state_id):("");

			$strSQLQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery .= ' order by p1.Name asc ';
	
			return $this->query($strSQLQuery, 1);
		}

		function  GetLatestOffers($CategoryID,$PostedByID,$Limit)
		{
			$strSQLQuery = "select p1.*,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= "where SalePrice>0 ";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");


			$strSQLQuery .= ' order by p1.ItemID desc ';
			$strSQLQuery .= ($Limit>0)?(" limit 0,".$Limit):("");

			return $this->query($strSQLQuery, 1);
		}
		
		function  GetNewItems($CategoryID,$PostedByID,$Limit)
		{
			$strSQLQuery = "select p1.*,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= "where 1";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");


			$strSQLQuery .= ' order by p1.ItemID desc ';
			$strSQLQuery .= ($Limit>0)?(" limit 0,".$Limit):("");

			return $this->query($strSQLQuery, 1);
		}

		function  SearchItemsStoreCategory($CategoryID,$StoreCategoryID,$PostedByID)
		{
			$strSQLQuery = "select p1.*,if(p1.StoreCategoryID>0,c1.Name,'') as StoreCategoryName,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID ";

			$strSQLQuery .= "where 1";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");
			$strSQLQuery .= ($StoreCategoryID>0)?(" and p1.StoreCategoryID=".$StoreCategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");


			$strSQLQuery .= ' order by p1.Name desc ';
	
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetStoreItems($PostedByID,$Bidding)
		{
			$strSQLFeaturedQuery = ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");
			$strSQLFeaturedQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery = "select p1.* from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 ".$strSQLFeaturedQuery." ";

			return $this->query($strSQLQuery, 1);
		}

		function  GetNumStoreItems($PostedByID,$Bidding)
		{
			$strSQLFeaturedQuery = ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");
			$strSQLFeaturedQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery = "select count(*) as NumProducts from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 ".$strSQLFeaturedQuery." ";

			return $this->query($strSQLQuery, 1);
		}



		function  ItemsStoreCategory($CategoryID,$StoreCategoryID,$PostedByID,$Bidding)
		{
			$strSQLQuery = "select p1.*,if(p1.StoreCategoryID>0,c1.Name,'') as StoreCategoryName,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID  ";

			$strSQLQuery .= "where 1";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");
			$strSQLQuery .= ($StoreCategoryID>0)?(" and p1.StoreCategoryID=".$StoreCategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery .= ' order by p1.Name desc ';
	
			return $this->query($strSQLQuery, 1);
		}	
		
		function  FeaturedItems($Status,$rand)
		{
			$strSQLQuery = "select p1.*,m1.Ranking,m1.UserName,m1.Website,m1.MembershipID,m1.CreditCard from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= " where p1.Featured='Yes' ";
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." " ):("");

			$strSQLQuery .= ($rand==1)?(" order by rand()" ):(" order by p1.Name");


			return $this->query($strSQLQuery, 1);
		}



		
		function  CompareItems($ids)
		{
			$strSQLQuery = "select p1.*,m1.Ranking,m1.WebsiteStoreOption,m1.UserName,m1.Website,m1.MembershipID,m1.CreditCard,c.name as Country,s.name as State from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID left outer join country c on m1.country_id=c.country_id left outer join state s on m1.state_id=s.state_id where p1.Status=1 and p1.ItemID in(".$ids.")  order by p1.ItemID";
			return $this->query($strSQLQuery, 1);
		}


		function  GetNameByParentID($id)
		{
			$strSQLQuery = "select c1.Name,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID where c1.CategoryID = ".$id;
			return $this->query($strSQLQuery, 1);
		}

		function  GetFeaturedItems()
		{
			$strSQLFeaturedQuery .= (" and p1.Featured='Yes'");

			$strSQLQuery = "select p1.* from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 ".$strSQLFeaturedQuery."   order by rand() Desc LIMIT 0,9";
			return $this->query($strSQLQuery, 1);
		}

		

									function checkItemSku($Sku)
									{
										$strSQLQuery = "select * from inv_items where Sku = ".$Sku;
										 return $this->query($strSQLQuery, 1);
									}
									
                                    function GetItemSku($ItemID)
                                    {
                                        $strSQLQuery = "select Sku from inv_items where ItemID = ".$ItemID;
                                        $row = $this->query($strSQLQuery, 1);
                                        return $row[0]['ProductSku'];
                                    }

		
		function AddItem($arryDetails)
		{

			extract($arryDetails);
			/*if($CategoryID > 0){
				$strUpdateQuery = "update e_categories set NumProducts = NumProducts + 1 where CategoryID = '".$CategoryID."'";
				$this->query($strUpdateQuery, 0);
			}*/


			$strSQLQuery = "insert into inv_items (description,procurement_method,CategoryID,evaluationType ,itemType,UnitMeasure,min_stock_alert_level,max_stock_alert_level,purchase_tax_rate,sale_tax_rate,Status, AddedDate) 
                                                                                                         values ('".addslashes($description)."',
																										 '".addslashes($procurement_method)."',
																										 '".$CategoryID."' ,
																										 '".addslashes($evaluationType)."',
																										 '".addslashes($itemType)."',
																										 '".addslashes($UnitMeasure)."',
																										 '".addslashes($min_stock_alert_level)."','".addslashes($max_stock_alert_level)."', '".addslashes($purchase_tax_rate)."','".addslashes($sale_tax_rate)."', '".$Status."','".date('Y-m-d')."')";
                                                   

			$this->query($strSQLQuery, 0);
			$lastInsertId = $this->lastInsertId();

				if($lastInsertId>0){
					$code="ITM000".$lastInsertId;
					$sql="update inv_items set Sku='".$code."' where ItemID=".$lastInsertId;
				$this->query($sql,0);

				}

			return $lastInsertId;
			
		}


		function changeItemStatus($ItemID)
		{
			$sql="select * from inv_items where ItemID=".$ItemID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update inv_items set Status='$Status' where ItemID=".$ItemID;
				$this->query($sql,0);

			}	
			

			if($Status==1 && $rs[0]['Status']!=1 && $rs[0]['PostedByID']>1 ){
				$this->ItemActiveEmail($ItemID);
			}

			return true;


		}



		function MultipleItemStatus($ItemID,$Status)
		{
			$sql="select * from inv_items where ItemID in (".$ItemID.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0)
			{

				$sql="update inv_items set Status=".$Status." where ItemID in (".$ItemID.")";
				$this->query($sql,0);

				for($i=0;$i<sizeof($arryRow);$i++) {

					if($Status==1 && $arryRow[$i]['Status']!=1 && $arryRow[$i]['PostedByID']>1 ){
						$this->ItemActiveEmail($arryRow[$i]['ItemID']);
						
					}
				}
				
			}	
			
			return true;

		}


		function changeFeaturedStatus($ItemID)
		{
			$sql="select * from inv_items where ItemID=".$ItemID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Featured']=='Yes')
					$Featured='No';
				else
					$Featured='Yes';
					
				$sql="update inv_items set Featured='$Featured' where ItemID=".$ItemID;
				$this->query($sql,0);
				return true;

			}			
		}

		function UpdateViewedDate($ItemID)
		{
			$sql="update inv_items set ViewedDate='".date('Y-m-d')."' where ItemID=".$ItemID;
			$this->query($sql,0);
			return true;
		}


	
		
		function FeaturedDisabled($ItemID)
		{
					
			$sql="update inv_items set Featured='No',FeaturedType='',Impression='0',ImpressionCount='0',  FeaturedStart='',FeaturedEnd=''   where ItemID in(".$ItemID.")";
			$this->query($sql,0);
			return true;

		}

		

		function UpdateImage($imageName,$ItemID)
		{
				$strSQLQuery = "update inv_items set Image='".$imageName."' where ItemID=".$ItemID;
				return $this->query($strSQLQuery, 0);
		}

		
                
              function UpdateBasic($arryDetails)
		{
			
			
			extract($arryDetails);

			 $strSQLQuery = "update inv_items set CategoryID = '".$CategoryID."', description='".addslashes($description)."',procurement_method='".addslashes($procurement_method)."',evaluationType='".addslashes($evaluationType)."',itemType='".addslashes($itemType)."',UnitMeasure='".addslashes($UnitMeasure)."',min_stock_alert_level='".$min_stock_alert_level."' ,max_stock_alert_level='".$max_stock_alert_level."',purchase_tax_rate='".addslashes($purchase_tax_rate)."',sale_tax_rate='".addslashes($sale_tax_rate)."', Status='".$Status."' where ItemID=".$ItemID;
                        
                        /*if($imagedelete == "Yes")
                        {
                                $select=mysql_query("select Image from inv_items where ItemID=".$ItemID."");
                                $image=mysql_fetch_array($select);
                                $ImgDir = '../../upload/products/images/';
                                unlink($ImgDir.$image['Image']);
			  $strSQLQuery = "update inv_items set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price."', SalePrice='".$SalePrice."', Image='', Status='".$Status."' where ItemID=".$ItemID;
                        }
                       else {
                           $strSQLQuery = "update inv_items set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price."', SalePrice='".$SalePrice."', Status='".$Status."' where ItemID=".$ItemID;
                       }
                      */
                      // echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);

			return 1;
		}
       function UpdateOther($arryDetails)
		{
		
			extract($arryDetails);
			
			$strSQLQuery = "update inv_items set Mid='".$Mid."',Featured='".$Featured."', IsTaxable='".$IsTaxable."', Weight='".$Weight."', TaxClassId = '".$TaxClassId."', TaxRate = '".$TaxRate."', FreeShipping = '".$FreeShipping."',ShippingPrice='".$ShippingPrice."' where ItemID=".$ItemID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
	 function UpdatePrice($arryDetails)
		{
		
			extract($arryDetails);
			
		 $strSQLQuery = "update inv_items set average_cost='".$average_cost."',last_cost='".$last_cost."', purchase_cost='".$purchase_cost."', sell_price='".$sell_price."' where ItemID=".$ItemID;
			

			$this->query($strSQLQuery, 0);

			return 1;
		}
       function UpdateDimensions($arryDetails)
		{
			extract($arryDetails);
			
			
			$strSQLQuery = "update inv_items set pack_size='".addslashes($pack_size)."',weight='".addslashes($weight)."',width='".addslashes($width)."',height='".addslashes($height)."',depth='".addslashes($depth)."' where ItemID=".$ItemID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                 function UpdateSeo($arryDetails)
		{
			
			
			extract($arryDetails);
			
			
			$strSQLQuery = "update inv_items set MetaTitle='".addslashes($MetaTitle)."',MetaKeywords='".addslashes($MetaKeywords)."',MetaDescription = '".addslashes($MetaDescription)."',UrlCustom = '".$UrlCustom."'  where ItemID=".$ItemID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                
                 function UpdateInventory($arryDetails)
		{
			
			
			extract($arryDetails);
			
			
			$strSQLQuery = "update inv_items set Quantity='".addslashes($Quantity)."',InventoryControl='".addslashes($InventoryControl)."',InventoryRule = '".$InventoryRule."',StockWarning = '".$StockWarning."' where ItemID=".$ItemID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
              /*************************************Attribute Function Start******************************************************************/      
                
                function parseOptions($options)
                {
                        return explode("\n", $options);
                }
	
	
                               
                
               function InsertAttributes($arryDetails)
		{
			
			extract($arryDetails);
			
			$is_active = isset($is_active)?$is_active:"No";
                        
                        $parsed_options = explode("\n", $options);
                        
                        foreach ($parsed_options as $option)
                        {
                                if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
                                {
                                        $is_modifier = true;
                                }
                        }
                        
                      
                        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";
                       
			$strSQLQuery = "Insert into inv_items_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ItemID)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($caption)."',options='".trim($options)."'";
			$this->query($strSQLQuery, 0);
                                                     if($ItemID >0)
                                                     {
                                                         $attributes_countVal = 0;
                                                         $sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$ItemID);
                                                         $attributes_countRow = mysql_fetch_array($sqlAttrVal);
                                                         $attributes_countVal = $attributes_countRow['AttributesCount'];
                                                         $attributes_countVal = $attributes_countVal+1;
                                                         $strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID=".$ItemID;
		      	  $this->query($strSQLQueryAttr, 0);
                                                     }
			return 1;
		}
                
                
                function UpdateAttributes($arryDetails)
		{

			extract($arryDetails);
			$is_active = isset($is_active)?$is_active:"No";
                        
                         $parsed_options = explode("\n", $options);
                        
                        foreach ($parsed_options as $option)
                        {
                                if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
                                {
                                        $is_modifier = true;
                                }
                        }
                        
                      
                        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";
                        
			$strSQLQuery = "update inv_items_attributes set attribute_type='".trim($attribute_type)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($caption)."',options='".trim($options)."' where paid = '".$AttributeId."' and pid=".$ItemID;
			$this->query($strSQLQuery, 0);
			return 1;
		}
                
                function GetAttributeByID($attId)
		{
	
			$strSQLQuery = "select * from inv_items_attributes where paid = ".$attId;
			return $this->query($strSQLQuery, 1);
		}
               function GetItemAttributes($ItemID)
		{
			 
			$strSQLQuery = "Select * from inv_items_attributes where pid=".$ItemID;
  			return $this->query($strSQLQuery, 1);
		}
                
                function GetItemAttributesForFront($ItemID)
		{
			 
			$strSQLQuery = "Select * from inv_items_attributes where pid=".$ItemID." AND is_active='Yes'";
  			return $this->query($strSQLQuery, 1);
		}
             
                
                         
                                        
                        function deleteAttribute($pid,$attributeId)
                                {
                                        $strSQLQuery = "delete from inv_items_attributes where paid=".$attributeId." and pid=".$pid; 
                                        $this->query($strSQLQuery, 0);

                                        $sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$pid);
                                        $attributes_countRow = mysql_fetch_array($sqlAttrVal);
                                        $attributes_countVal = $attributes_countRow['AttributesCount'];
                                        $attributes_countVal = $attributes_countVal-1;
                                        $strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID=".$pid;
                                         $this->query($strSQLQueryAttr, 0);
                                               return 1;
                                }
                                
 /*************************************Attribute Function End******************************************************************/     
                                
                                /*************************************Discount Function Start******************************************************************/ 
                                   function InsertDiscount($arryDetails)
		{
			
			extract($arryDetails);
			$is_active = isset($is_active)?$is_active:"No";
			$strSQLQuery = "Insert into e_products_quantity_discounts set range_min='".trim($range_min)."',range_max = '".$range_max."',pid='".trim($ItemID)."',is_active='".trim($is_active)."',discount='".trim($discount)."',discount_type='".trim($discount_type)."',customer_type='".trim($customer_type)."'";
			$this->query($strSQLQuery, 0);
                                                     
			return 1;
		}
                
                            function GetItemDiscount($ItemID)
                                {

                                        $strSQLQuery = "Select * from e_products_quantity_discounts where pid=".$ItemID;
                                        return $this->query($strSQLQuery, 1);
                                }
                        function GetDiscountByID($disID)
                            {

                                    $strSQLQuery = "select * from e_products_quantity_discounts where qd_id = ".$disID;
                                    return $this->query($strSQLQuery, 1);
                            }
                      function UpdateDiscount($arryDetails)
		{

			extract($arryDetails);
			$is_active = isset($is_active)?$is_active:"No";
			$strSQLQuery = "update e_products_quantity_discounts set range_min='".trim($range_min)."',range_max = '".$range_max."',is_active='".trim($is_active)."',discount='".trim($discount)."',discount_type='".trim($discount_type)."',customer_type='".trim($customer_type)."' where qd_id = '".$DiscountId."' and pid=".$ItemID;
			$this->query($strSQLQuery, 0);
			return 1;
		}
                     function deleteDiscount($pid,$discId)
                                {
                                        $strSQLQuery = "delete from e_products_quantity_discounts where qd_id=".$discId." and pid=".$pid; 
                                        $this->query($strSQLQuery, 0);
                                               return 1;
                                }
                               
                                
                                /*************************************Discount Function End******************************************************************/ 
                                
		function SendEmailToAdmin($ItemID)
		{

			$arryProduct = $this->GetItems($ItemID,0,0,0);

			if($arryProduct[0]['PostedByID']>0){
				$contents = file_get_contents("html/newproduct.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);


				$contents = str_replace("[FULLNAME]",$_SESSION['Name'],$contents);
				$contents = str_replace("[USERNAME]",$_SESSION['UserName'],$contents);
				$contents = str_replace("[POSTED_FOR]",$arryProduct[0]['PostedFor'],$contents);
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				$contents = str_replace("[PRICE]",$arryProduct[0]['Price'],$contents);
				$contents = str_replace("[QUANTITY]",$arryProduct[0]['Quantity'],$contents);
				$contents = str_replace("[Type]",$arryProduct[0]['Bidding'],$contents);

				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/images/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editProduct.php?edit='.$ItemID, $contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($_SESSION['Name'], $_SESSION['Email']);   
				$mail->Subject = $Config['SiteName']." - New product has been posted ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$_SESSION['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			}
		
			return 1;
		}
		

		function ItemActiveEmail($ItemID)
		{
			
			$arryProduct = $this->GetItems($ItemID,0,0,0);

			if($arryProduct[0]['PostedByID']>0){
				$contents = file_get_contents("../html/activeproduct.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);


				$contents = str_replace("[USERNAME]",stripslashes($arryProduct[0]['UserName']),$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
			
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				$contents = str_replace("[Type]",$arryProduct[0]['Bidding'],$contents);

				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/images/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryProduct[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Your product posting has been approved ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryProduct[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			}
		
			return 1;
		}
                
    /*************************************Alternatative Images Function Start******************************************************************/ 
                
		function AddAlternativeImage($ItemID)
		{

			$strSQLQuery ="select ItemID from inv_items_images where ItemID='".$ItemID."'";

			$arryRow = $this->query($strSQLQuery, 1);
			if (empty($arryRow[0]['ItemID'])) {
				
				$strSQLQuery = "insert into inv_items_images(ItemID) values ('".$ItemID."')"; 
				$this->query($strSQLQuery, 0);

			} 

			return 1;

		}


		function UpdateAlternativeImage($imageId,$imageName,$alt_text)
		{
			
			 $strSQLQuery = "INSERT INTO inv_items_images set  ItemID=".$imageId.", Image='".$imageName."', alt_text='".$alt_text."'";
  			return $this->query($strSQLQuery, 0);
		}
                
     function GetTotalImagesCount($ItemID)
		{
			 
			echo $strSQLQuery = "Select count( Iid ) as total from `inv_items_images` WHERE `ItemID` ='".$ItemID."'";
		$exequery = $this->query($stSQLQuery, 1);
  			//$exequery = mysql_fetch_array($strSQLQuery);
                                                      return $exequery[0]['total'];
		}
                
                function GetAlternativeImage($ItemID)
		{
			 
			$strSQLQuery = "Select * from inv_items_images where ItemID=".$ItemID;
  			return $this->query($strSQLQuery, 1);
		}
                
              
                
                
                
                          function deleteImage($pid,$imageId)
                                {
                                            $select=mysql_query("select Image from inv_items_images where Iid = '".$imageId."' and ItemID=".$pid."");
                                            $image=mysql_fetch_array($select);
                                            $ImgDir = '../../upload/products/images/secondary/';
                                            unlink($ImgDir.$image['Image']);
                                            $strSQLQuery = "delete from inv_items_images where Iid = '".$imageId."' and ItemID=".$pid; 
                                            $this->query($strSQLQuery, 0);
                                            return 1;
                                }
                               
/*************************************Alternatative Images Function Start******************************************************************/ 
		function RemoveItem($id,$CategoryID,$Front)
		{
			$strSQLQuery = "select Image from inv_items where ItemID=".$id; 
			$arryRow = $this->query($strSQLQuery, 1);
			
			$sql = "select * from inv_items_images where ItemID=".$id; 
			$arry = $this->query($sql, 1);
			
			if($Front > 0){
				$ImgDir = 'upload/products/images/';
			}else{
				$ImgDir = '../upload/products/images/';
			}



			for($i=1;$i<=20;$i++){ 
				if($arry[0]['Image'.$i] !='' && file_exists($ImgDir.$arry[0]['Image'.$i]) ){
                                                                               unlink($ImgDir.$arry[0]['Image'.$i]);	
				}
			}



			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){
                                                                    unlink($ImgDir.$arryRow[0]['Image']);	
			}


			$strSQLQuery = "delete from inv_items where ItemID=".$id; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from inv_items_images where ItemID=".$id; 
			$this->query($strSQLQuery, 0);

			

			if($CategoryID > 0){
				$strSQLQuery ="select NumProducts from e_categories where CategoryID=".$CategoryID;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['NumProducts'])) {
					$strUpdateQuery = "update e_categories set NumProducts = NumProducts - 1 where CategoryID = ".$CategoryID;
					$this->query($strUpdateQuery, 0);
				} 
			}
			return 1;
		}
		

		function RemoveMultipleItem($ids,$Front)
		{
			

			$strSQLQuery = "select Image,CategoryID from inv_items where ItemID in (".$ids.")"; 
			$arryRow = $this->query($strSQLQuery, 1);

			$strSQLQuery = "delete from inv_items where ItemID in (".$ids.")"; 
			$this->query($strSQLQuery, 0);

			


			if($Front > 0){
				$ImgDir = '../../upload/products/';
			}else{
				$ImgDir = '../../upload/products/images/';
			}
			
			for($i=0;$i<sizeof($arryRow);$i++) {
                            
                             
					if($arryRow[$i]['Image'] !='' && file_exists($ImgDir.$arryRow[$i]['Image']) ){
                                                                                                      
                                                                                                        unlink($ImgDir.$arryRow[$i]['Image']);	
					}

					if($arryRow[$i]['Image'] !='' && file_exists($ImgDir.'secondary/'.$arryRow[$i]['Image']) ){
                                                                                                   unlink($ImgDir.'secondary/'.$arryRow[$i]['Image']);
					}


					if($arryRow[$i]['CategoryID'] > 0){
						$strSQLQuery ="select NumProducts from e_categories where CategoryID=".$arryRow[$i]['CategoryID'];
						$arryRow2 = $this->query($strSQLQuery, 1);
						if (!empty($arryRow2[$i]['NumProducts'])) {
							$strUpdateQuery = "update e_categories set NumProducts = NumProducts - 1 where CategoryID = ".$arryRow[$i]['CategoryID'];
							$this->query($strUpdateQuery, 0);
						} 
					}


			}

			return 1;

		}


		function isItemExists($Name,$ItemID=0,$CategoryID)
		{

			$strSQLQuery ="select ItemID from inv_items where LCASE(Name)='".strtolower(trim($Name))."'";

			$strSQLQuery .= ($ItemID>0)?(" and ItemID != ".$ItemID):("");
			//$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID = ".$CategoryID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ItemID'])) {
				return true;
			} else {
				return false;
			}
		}
		

		function isItemNumberExists($ProductSku,$ItemID=0,$PostedByID)
		{

			$strSQLQuery ="select ItemID from inv_items where LCASE(ProductSku)='".strtolower(trim($ProductSku))."'";

			$strSQLQuery .= ($ItemID>0)?(" and ItemID != ".$ItemID):("");
			$strSQLQuery .= (!empty($PostedByID))?(" and PostedByID = ".$PostedByID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ItemID'])) {
				return true;
			} else {
				return false;
			}
		}


		function IsActivatedItem($ItemID)
		{
			$strSQLQuery = "select * from inv_items where ItemID='".$ItemID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if ($arryRow[0]['ItemID']>0) {
				return 1;
			} else {
				return 0;
			}
		}


		function AddSearchKeyword($Keyword,$KeywordType)
		{
			$strSQLQuery ="select Keyword from keywords where Keyword='".trim($Keyword)."' and KeywordType='".$KeywordType."'";

			$arryRow = $this->query($strSQLQuery, 1);


			if ($arryRow[0]['Keyword']=='') {
				
				$sql = "insert into keywords (Keyword,KeywordType,Date) values ('".addslashes(trim($Keyword))."', '".addslashes($KeywordType)."','".date('Y-m-d H:i:s')."')";

				$this->query($sql, 0);

			}else{
	
				$sql="update keywords set Date='".date('Y-m-d H:i:s')."' where LCASE(Keyword)='".strtolower(trim($Keyword))."' and KeywordType='".$KeywordType."'";
				$this->query($sql,0);
			}

			return 1;


		}


		function GetSearchKeywords()
		{
			$strSQLQuery = "select * from keywords where Status=1 order by Date desc limit 0,60";

			return $this->query($strSQLQuery, 1);

		}

		 

		/*****************************/

		function  GetWishList($MemberID,$WishID)
		{

			$strSQLQuery = "select p1.ItemID, p1.Name,p1.Quantity, p1.Status,w1.WishID  from inv_items p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID inner join wishlist w1 on p1.ItemID = w1.ItemID left outer join members m1 on p1.PostedByID = m1.MemberID";

			$strSQLQuery .= (!empty($WishID))?(" where w1.WishID=".$WishID):(" where 1 ");
			$strSQLQuery .= ($MemberID>0)?(" and w1.MemberID=".$MemberID):("");
			$strSQLQuery .= "  order by w1.WishID desc";

			return $this->query($strSQLQuery, 1);

		}

		function RemoveWishList($WishID)
		{
			$strSQLQuery = "delete from wishlist where WishID=".$WishID; 
			$this->query($strSQLQuery, 0);
		}
                
                function AddItemReview($arryDetails)
                {
                    extract($arryDetails);
                    global $Config;
                    $strSQLQuery = "INSERT INTO inv_items_reviews SET Pid='".$ReviewItemID."',Cid = '".$ReviewCustId."',ReviewTitle='".  addslashes($ReviewTitle)."',ReviewText='".addslashes($ReviewText)."',Status = 'No',Rating='".$Rating."',DateCreated='".$Config['TodayDate']."'";
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
                    
                        $strSQLQuery = "SELECT pr.*,p.Name,p.ProductSku,c.email,c.Cid FROM inv_items_reviews AS pr JOIN inv_items AS p ON p.ItemID = pr.Pid JOIN e_customers AS c ON c.Cid = pr.Cid ".$strAddQuery."";
                        //echo $strSQLQuery;exit;
                        return $this->query($strSQLQuery, 1);
                    }
                    
                  function getReviewsByItem($pid) {
                
                        $where = "WHERE pr.Status = 'Yes' AND p.ItemID = ".$pid;
                        $strSQLQuery = "SELECT pr.*,p.Name,p.ProductSku,c.email,c.Cid,c.FirstName FROM inv_items_reviews AS pr JOIN inv_items AS p ON p.ItemID = pr.Pid JOIN e_customers AS c ON c.Cid = pr.Cid ".$where." Order By ReviewId Desc";
                        //echo $strSQLQuery;exit;
                        return $this->query($strSQLQuery, 1);
                    }   
                    
                     function countItemRating($pid) {
                
                        $where = "WHERE Status = 'Yes' AND Pid = ".$pid;
                        $strSQLQuery = "SELECT SUM(Rating) as total FROM inv_items_reviews ".$where."";
                        //echo $strSQLQuery;exit;
                        return $this->query($strSQLQuery, 1);
                    }   
                    
                    
                     function deleteReview($id) {

                        $strSQLQuery = "DELETE FROM inv_items_reviews WHERE ReviewId = " . $id;
                        $rs = $this->query($strSQLQuery, 0);

                        if (sizeof($rs))
                            return true;
                        else
                            return false;
                    }

                    function changeReviewStatus($id) {
                        $strSQLQuery = "SELECT * FROM inv_items_reviews WHERE ReviewId=" . $id;
                        $rs = $this->query($strSQLQuery);
                        if (sizeof($rs)) {
                            if ($rs[0]['Status'] == 'Yes')
                                $Status = 'No';
                            else
                                $Status = 'Yes';

                            $strSQLQuery = "UPDATE inv_items_reviews SET Status='" . $Status . "' WHERE ReviewId=" . $id;
                            $this->query($strSQLQuery, 0);
                            return true;
                        }
                    }
                    
                  function getDiscountByItem($id)
                  {
                      $where = "WHERE is_active = 'Yes' AND pid = ".$id;
                      $strSQLQuery = "SELECT * FROM e_products_quantity_discounts ".$where."";
                      //echo $strSQLQuery;exit;
                      return $this->query($strSQLQuery, 1);
                  }

}

?>
