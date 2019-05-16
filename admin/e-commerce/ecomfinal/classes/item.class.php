<?

class items extends dbClass {

	//constructor
	function items()
	{
		$this->dbClass();
	}

	function GetItems($id = 0, $CategoryID, $Status, $shortby) {

		$strSQLQuery = "select p1.*,c1.ParentID from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID";
		$strSQLQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "' and c1.Status='" . $Status."'") : (" and p1.Status=1 and c1.Status=1 ");
		$strSQLQuery .= (!empty($id)) ? (" where p1.ItemID='" . $id."'") : (" where 1 ");
		$strSQLQuery .= (!empty($CategoryID)) ? (" and p1.CategoryID='" . $CategoryID."'") : ("");
		//$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid='".$Mfg."'"):("");
		if ($shortby == "description") {
			$strSQLQuery .= "  order by p1.description";
		} elseif ($shortby == "new") {
			$strSQLQuery .= "  order by p1.ItemID DESC";
		}
		//elseif($shortby == "hprice"){$strSQLQuery .= "  order by p1.Price DESC"; }
		//elseif($shortby == "lprice") {$strSQLQuery .= "  order by p1.Price ASC";}
		else {
			$strSQLQuery .= "  order by p1.description";
		}
		//echo $strSQLQuery; exit;
		return $this->query($strSQLQuery, 1);
	}

	function GetItemById($id) {

		$strAddQuery = ($id > 0) ? (" where p1.ItemID='" . $id."'") : (" where 1 ");
		$strSQLQuery = "select p1.*,c1.ParentID,group_concat(c2.CustomerID) as CustomerID
        from inv_items p1 left outer join inv_categories c1 on p1.CategoryID = c1.CategoryID 
        left join inv_customer_items c2 on c2.ItemID=p1.ItemID     " . $strAddQuery;        ;


		// echo $strSQLQuery; exit;
		return $this->query($strSQLQuery, 1);
	}

	function GetItemsView($arryDetails) {
		global $Config;
		extract($arryDetails);

		$DBName='';
		if($EDICompName!=''){
			$DBName='erp_'.$EDICompName.'.';
		}

		$CustomerID='';
		if($_SESSION['UserData']['Cid']!='')  $CustomerID=$_SESSION['UserData']['Cid'];
		$strAddQuery = ' where 1 ';
		$SearchKey = strtolower(trim($key));


		#if($Config['TrackInventory']=='0'){$strAddQuery .= " and p1.non_inventory='No'";}

		$strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
		$strAddQuery .= ($CatID > 0) ? (" and p1.CategoryID='" . $CatID . "'") : ("");
		$strAddQuery .= ($finish != '') ? (" and p1.itemType='" . $finish . "'") : ("");
		$strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");

		if( $_SESSION['is_exclusive']=='No')
		$strAddQuery .= (!empty($CustomerID)) ? (" and (c2.CustomerID='" . $CustomerID . "' or c2.CustomerID is null) and p1.Status='1'") : ("");
		else $strAddQuery .= (!empty($CustomerID)) ? (" and c2.CustomerID='" . $CustomerID . "' and p1.Status='1'") : ("");

		//$strAddQuery .= ($proc != '') ? (" and p1.procurement_method like '%" . $proc . "%'") : ("");

		$strAddQuery .= ($Status > 0) ? (" and p1.Status='" . $Status. "'") : ("");

		if ($SearchKey == 'active' && ($sortby == 'p1.Status' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=1";
		}else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=0";
		}else if ($sortby != '') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
		}else if(!empty($SearchKey)){

			$strAddQuery .= " and (p1.description like '" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.non_inventory like '%" . $SearchKey . "' or p1.evaluationType like '%" . $SearchKey . "%' or p1.itemType like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or a1.ItemAliasCode like '%" . $SearchKey . "%') group by p1.ItemID ";
			$LeftJoin = ' left outer join '.$DBName.'inv_item_alias a1 on p1.Sku=a1.sku';
		}
		if($CustomerID!=''){
			$custJoin=" left join ".$DBName."inv_customer_items c2 on c2.ItemID=p1.ItemID ";
		}


		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
		$strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

		$strSQLQuery = "select p1.* from ".$DBName."inv_items p1 " . $LeftJoin. $custJoin . $strAddQuery;

		return $this->query($strSQLQuery, 1);
	}


	function GetBOMItemsSelect($arryDetails) {
		global $Config;
		extract($arryDetails);
		$SearchKey = strtolower(trim($key));

		$strSQLQuery = "select p1.* from inv_items p1 where p1.Sku like '" . $SearchKey . "%'" ;
		$arryRow = $this->query($strSQLQuery, 1);

		if(empty($arryRow[0]['ItemID'])){
			unset($arryRow);

			$strSQLQuery = "select p1.* from inv_items p1 left outer join inv_item_alias a1 on p1.ItemID=a1.item_id where a1.ItemAliasCode like '" . $SearchKey . "%' group by p1.ItemID limit 0,1" ;
			$arryRowAlias = $this->query($strSQLQuery, 1);
			return $arryRowAlias;
		}else{
			return $arryRow;
		}


			
	}



	function GetItemsViewForSale($arryDetails) {
		global $Config;
		extract($arryDetails);
		$CustomerID='';
		if($_SESSION['UserData']['Cid']!='')  $CustomerID=$_SESSION['UserData']['Cid'];
		$strAddQuery = ' where 1 ';
		$SearchKey = strtolower(trim($key));


		#if($Config['TrackInventory']=='0'){$strAddQuery .= " and p1.non_inventory='No'";}

		$strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
		$strAddQuery .= ($CatID > 0) ? (" and p1.CategoryID='" . $CatID . "'") : ("");
		$strAddQuery .= ($finish != '') ? (" and p1.itemType='" . $finish . "'") : ("");
		$strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");

		//$strAddQuery .= ($proc != '') ? (" and p1.procurement_method like '%" . $proc . "%'") : ("");

		$strAddQuery .= ($Status > 0) ? (" and p1.Status='" . $Status. "'") : ("");

		$strAddQuery .= (!empty($CustomerID)) ? (" and c2.CustomerID='" . $CustomerID . "' ") : ("");

		if ($SearchKey == 'active' && ($sortby == 'p1.Status' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=1";
		} else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=0";
		} else if ($sortby != '') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '" . $SearchKey . "%')") : ("");
		} else {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.non_inventory like '" . $SearchKey . "' or p1.evaluationType like '%" . $SearchKey . "%' or p1.itemType like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' ) ") : ("");
		}
		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
		$strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");


		//By Chetan 18Sep//
		if($page)
		{
			$limit = 15;
			$offset = $limit*$page;
			$strAddQuery .= "  limit ($limit $offset)";
		}
		//End//

		if($CustomerID!=''){
			$custJoin=" inner join inv_customer_items c2 on c2.ItemID=p1.ItemID ";
		}

		$strSQLQuery = "select p1.*,m.bill_option from inv_items as p1 left outer join inv_bill_of_material as m on m.item_id = p1.ItemID " .$custJoin . $strAddQuery;

		return $this->query($strSQLQuery, 1);
	}

	function getOptionCode($ItemID)
	{
			
		$strAddQuery .= (!empty($ItemID)) ? (" where m.item_id='" . $ItemID."'") : ("");
		$strSQLQuery = "select c.option_code,c.optionID from inv_bom_cat c inner join inv_bill_of_material m on m.bomID = c.bomID  " . $strAddQuery;
		//echo "=>".$strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
			

	}

	function GetFinishItems($arryDetails) {

		extract($arryDetails);
		//$proc ="MAKE";GetItemsView

		$strAddQuery = ' where 1 ';
		$SearchKey = strtolower(trim($key));
		$strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
		$strAddQuery .= ($CatID > 0) ? (" and p1.CategoryID='" . $CatID . "'") : ("");
		//$strAddQuery .= ($finish != '') ? (" and p1.itemType='".$finish."'") : ("");
		//$strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");


		$strAddQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "'") : ("");

		if ($SearchKey == 'active' && ($sortby == 'p1.StatuGetItemsViews' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=1";
		} else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=0";
		} else if ($sortby != '') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '" . $SearchKey . "%')") : ("");
		} else {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.purchase_cost like '%" . $SearchKey . "%' or p1.sell_price like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or p1.UnitMeasure like '%" . $SearchKey . "%' or p1.procurement_method like '%" . $SearchKey . "%' ) ") : ("");
		}
		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
		$strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

		$strSQLQuery = "select p1.* from inv_items p1 " . $strAddQuery;

		return $this->query($strSQLQuery, 1);
	}




	function isSkuBomExists($Sku){
		$strSQLQuery = "SELECT Sku from inv_bill_of_material where Sku='".trim($Sku)."' ";
		$arryRow = $this->query($strSQLQuery, 1);

		if(!empty($arryRow[0]['Sku'])) {
			return true;
		} else {
			$strSQLQuery2 = "SELECT i.Sku from inv_item_alias a inner join inv_items i on i.ItemID=a.item_id where a.ItemAliasCode='".trim($Sku)."' ";
			$arryRow2 = $this->query($strSQLQuery2, 1);
			if(!empty($arryRow2[0]['Sku'])){
				$strSQLQuery3 = "SELECT Sku from inv_bill_of_material where Sku='".trim($arryRow2[0]['Sku'])."' ";
				$arryRow3 = $this->query($strSQLQuery3, 1);
				if(!empty($arryRow3[0]['Sku'])) {
					return true;
				} else {
					return false;
				}

			}

			return false;
		}
	}



	function GetBillItems($arryDetails) {

		extract($arryDetails);
		//$proc ="MAKE";

		$strAddQuery = " where  p1.Sku not in (select Sku from inv_bill_of_material) ";
		// $strAddQuery = " where 1 ";

		$SearchKey = strtolower(trim($key));
		$strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
		//$strAddQuery .= ($CatID > 0) ? (" and p1.CategoryID='".$CatID."'") : ("");
		//$strAddQuery .= ($finish != '') ? (" and p1.itemType='".$finish."'") : ("");
		//$strAddQuery .= (!empty($kit)) ? (" and p1.itemType='" . $kit . "'") : ("");




		$strAddQuery .= ($Status > 0) ? (" and p1.Status=" . $Status) : ("");

		if ($SearchKey == 'active' && ($sortby == 'p1.Status' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=1";
		} else if ($SearchKey == 'inactive' && ($sortby == 'p1.Status' || $sortby == '')) {
			$strAddQuery .= " and p1.Status=0";
		} else if ($sortby != '') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '" . $SearchKey . "%')") : ("");
		}else if(!empty($SearchKey)){
			$strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.purchase_cost like '%" . $SearchKey . "%' or p1.sell_price like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or p1.UnitMeasure like '%" . $SearchKey . "%' or p1.procurement_method like '%" . $SearchKey . "%' or a1.ItemAliasCode like '%" . $SearchKey . "%' ) group by p1.ItemID ") : ("");
		 $LeftJoin = ' left outer join inv_item_alias a1 on p1.Sku=a1.sku';
		}
		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
		$strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

		$strSQLQuery = "select p1.ItemID,p1.description,p1.Sku,p1.Status,p1.itemType,p1.CategoryID,p1.purchase_cost,p1.sell_price,p1.qty_on_hand,p1.UnitMeasure,p1.procurement_method from inv_items p1   " .  $LeftJoin. $strAddQuery . " ";

		if($_GET['d']==1) echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);
	}

	function GetRequiredItem($ItemID, $id) {
		$strAddQuery .= (!empty($ItemID)) ? (" and r.ItemID='" . $ItemID . "'") : ("");
		$strAddQuery .=(" and r.Type!='Alias'");
		$strAddQuery .= (!empty($id)) ? (" and r.id='" . $id . "'") : ("");
		$strSQLQuery = "select r.*,i.Sku as sku,i.description,i.qty_on_hand,evaluationType from inv_item_required r inner join inv_items i on r.item_id = i.ItemID where 1 " . $strAddQuery . " order by r.id asc";
		return $this->query($strSQLQuery, 1);
	}

	function GetAliasRequiredItem($aliasID, $id) {
		$strAddQuery .= (!empty($aliasID)) ? (" and r.aliasID='" . $aliasID . "'") : ("");
		$strAddQuery .=(" and r.Type='Alias'");
		$strAddQuery .= (!empty($id)) ? (" and r.id='" . $id . "'") : ("");
		$strSQLQuery = "select r.*,i.Sku as sku,i.description,i.qty_on_hand,evaluationType from inv_item_required r inner join inv_items i on r.item_id = i.ItemID where 1 " . $strAddQuery . " order by r.id asc";
		return $this->query($strSQLQuery, 1);
	}


	function GetKitItem($ItemID) {

		$strAddQuery .= (!empty($ItemID)) ? (" where m.item_id='" . $ItemID."'") : ("");
		$strSQLQuery = "select b.bom_qty as qty,i.Sku as sku,i.description,i.qty_on_hand,m.bill_option from inv_item_bom b inner join inv_bill_of_material m on m.bomID = b.bomID left outer join inv_items  i on i.ItemID=b.item_id  " . $strAddQuery;
		//echo "=>".$strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function GetOptionCodeItem($optionID) {

		$strAddQuery .= (!empty($optionID)) ? (" where b.optionID='" . $optionID."'") : ("");
		$strSQLQuery = "select b.bom_qty as qty,i.Sku as sku,i.description,i.qty_on_hand from inv_item_bom b left outer join inv_items  i on i.ItemID=b.item_id  " . $strAddQuery;
		//echo "=>".$strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function AddUpdateRequiredItem($ItemID, $arryDetails) {
		global $Config;

		extract($arryDetails);

		if (!empty($DelItem) && empty($CopyItemID)) {
			$strSQLQuery = "delete from inv_item_required where id in(" . $DelItem . ")";
			$this->query($strSQLQuery, 0);
		}

		for ($i = 1; $i <= $NumLine; $i++) {

			if (!empty($arryDetails['sku' . $i])) {

				$id = $arryDetails['id' . $i];

				if($CopyItemID>0){ //copy item
			  $sql = "insert into inv_item_required (ItemID, item_id, qty,Type,aliasID) values('" . $ItemID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['Type']) . "','" . addslashes($arryDetails['aliasID']) . "')";
			  $this->query($sql, 0);
				}else{
					if ($id > 0) {
						$sql = "update inv_item_required set item_id='" . $arryDetails['item_id' . $i] . "', qty='" . addslashes($arryDetails['qty' . $i]) . "'  where id='" . $id . "'";
						$this->query($sql, 0);
					} else {
						$sql = "insert into inv_item_required (ItemID, item_id, qty,Type,aliasID) values('" . $ItemID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['qty' . $i]) . "','" . addslashes($arryDetails['Type']) . "','" . addslashes($arryDetails['aliasID']) . "')";
						$this->query($sql, 0);
					}



				}

			}
		}

		return true;
	}

	function StockDetail($arryDetails) {

		extract($arryDetails);

		$strAddQuery = ' where 1 ';
		$SearchKey = strtolower(trim($keyword));
		$strAddQuery .= ($ItemID > 0) ? (" and p1.ItemID='" . $ItemID . "'") : ("");
		//$strAddQuery .= ($CategoryID > 0) ? (" and p1.CategoryID='" . $CategoryID . "' ") : ("");

		$strAddQuery .= ($CategoryID != '') ? (" and p1.CategoryID IN ($CategoryID)") : ("");
		$strAddQuery .= ($Genration != '') ? (" and (FIND_IN_SET('" . $Genration . "',p1.Generation) ) ") : ("");
		$strAddQuery .= ($Model != '') ? (" and (FIND_IN_SET('" . $Model . "',p1.Model))") : ("");
		//$strAddQuery .= (!empty($Condition)) ? (" and p1.Condition='" . $Condition . "'") : ("");
		$strAddQuery .= ($Manufacturer != '') ? (" and p1.Manufacture like '%" . $Manufacturer . "%'") : ("");
		$strAddQuery .= ($Status > 0) ? (" and p1.Status='" . $Status. "'") : ("");



		$strAddQuery .= (!empty($SearchKey)) ? (" and (p1.description like '%" . $SearchKey . "%' or p1.Sku like '%" . $SearchKey . "%' or p1.purchase_cost like '%" . $SearchKey . "%' or p1.sell_price like '%" . $SearchKey . "%' or p1.qty_on_hand like '%" . $SearchKey . "%' or p1.UnitMeasure like '%" . $SearchKey . "%' or p1.procurement_method like '%" . $SearchKey . "%' ) ") : ("");

		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by p1.ItemID ");
		$strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

		$strSQLQuery = "select p1.* from inv_items p1 " . $strAddQuery;
		if($_GET['d']==1) echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);
	}

	function CountPo($sku) {
		$strSQLQuery = "SELECT SUM(OrderID) AS totalPo FROM `p_order_item` WHERE 1 AND sku = '" . $sku . "' ";
		$rs = $this->query($strSQLQuery);
		if (sizeof($rs)) {
			if ($rs[0]['totalPo'] > 0) {
				return $rs[0]['totalPo'];
			} else {
				return 0;
			}
		}
	}

	function GetSumPo($sku) {

		$strSQLQuery = "SELECT SUM( p_order_item.qty ) AS sumPo,p_order_item.OrderID,p_order_item.sku,p_order.OrderID,p_order.Module FROM `p_order_item` p_order_item  LEFT OUTER JOIN p_order p_order ON p_order.OrderID = p_order_item.OrderID WHERE 1 AND sku = '" . $sku . "'AND p_order.Module = 'Order'";


		$rs = $this->query($strSQLQuery);
		if (sizeof($rs)) {
			if ($rs[0]['sumPo'] > 0) {
				return $rs[0]['sumPo'];
			} else {
				return 0;
			}
		}
	}

	function GetPriceRange() {
		$strSQLQuery = 'select * from price_refine order by id asc';
		return $this->query($strSQLQuery, 1);
	}

	function SearchItemsCat($id = 0, $CategoryIDs, $Status, $key, $state_id, $PostedByID, $Bidding) {
		$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join inv_categories c1 on p1.CategoryID = c1.CategoryID ";

		$strSQLQuery .= ($CategoryIDs > 0) ? (" where (p1.CategoryID ='" . $CategoryIDs . "' or c1.ParentID = '" . $CategoryIDs . "')") : (" where 1 ");

		$strSQLQuery .= ($PostedByID > 0) ? (" and p1.PostedByID='" . $PostedByID. "'") : ("");

		$strSQLQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "' and c1.Status='" . $Status . "' and m1.Status='" . $Status . "' ") : ("");

		$strSQLQuery .= (!empty($key)) ? (" and (p1.SearchTag LIKE '%" . $key . "%' OR p1.Name LIKE '%" . $key . "%' OR p1.ProductSku LIKE '%" . $key . "%')") : ("");

		$strSQLQuery .= ($state_id > 0) ? (" and m1.state_id='" . $state_id. "'") : ("");

		$strSQLQuery .= ($Bidding == 'Auction') ? (" and p1.Bidding='" . $Bidding . "'") : ("");

		$strSQLQuery .= ' order by p1.Name asc ';

		return $this->query($strSQLQuery, 1);
	}

	function GetNewItems($CategoryID, $PostedByID, $Limit) {
		$strSQLQuery = "select p1.*,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName from inv_items p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join inv_categories c1 on p1.CategoryID = c1.CategoryID ";

		$strSQLQuery .= "where 1";

		$strSQLQuery .= ($PostedByID > 0) ? (" and p1.PostedByID='" . $PostedByID . "' and c1.StoreID='" . $PostedByID. "'") : ("");
		$strSQLQuery .= ($CategoryID > 0) ? (" and p1.CategoryID='" . $CategoryID. "'") : ("");

		$Status = 1;
		$strSQLQuery .= ($Status > 0) ? (" and p1.Status='" . $Status . "' and c1.Status='" . $Status . "' and m1.Status='" . $Status . "' ") : ("");


		$strSQLQuery .= ' order by p1.ItemID desc ';
		$strSQLQuery .= ($Limit > 0) ? (" limit 0," . $Limit) : ("");

		return $this->query($strSQLQuery, 1);
	}

	function GetNameByParentID($id) {
		$strSQLQuery = "select c1.Name,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName from inv_categories c1 left outer join inv_categories c2 on c1.ParentID = c2.CategoryID where c1.CategoryID = " . $id;
		return $this->query($strSQLQuery, 1);
	}

	function GetFeaturedItems() {
		$strSQLFeaturedQuery .= (" and p1.Featured='Yes'");

		$strSQLQuery = "select p1.* from inv_items p1 inner join inv_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 " . $strSQLFeaturedQuery . "   order by rand() Desc LIMIT 0,9";
		return $this->query($strSQLQuery, 1);
	}



	function checkItemSku($Sku) {

		$CustomerID='';
		if($_SESSION['UserData']['Cid']!='')  $CustomerID=$_SESSION['UserData']['Cid'];

		if($CustomerID!=''){
			$custJoin=" left join inv_customer_items c2 on c2.ItemID=p1.ItemID ";
		}

		if( $_SESSION['is_exclusive']=='No')
		$whereAddQuery = (!empty($CustomerID)) ? (" and (c2.CustomerID='" . $CustomerID . "' or c2.CustomerID is null) and p1.Status='1'") : ("");
		else $whereAddQuery = (!empty($CustomerID)) ? (" and c2.CustomerID='" . $CustomerID . "' and p1.Status='1'") : ("");

		$strSQLQuery = "select p1.* from inv_items  p1 ".$custJoin." where p1.Sku = '" . $Sku . "' ".$whereAddQuery."";
		return $this->query($strSQLQuery, 1);
	}

	function GetItemSku($ItemID) {
		$strSQLQuery = "select Sku from inv_items where ItemID = '" . $ItemID . "'";
		$row = $this->query($strSQLQuery, 1);
		return $row[0]['Sku'];
	}

	function AddItem($arryDetails) {

		extract($arryDetails);
		if ($CategoryID > 0) {
			$strUpdateQuery = "update inv_categories set NumProducts = NumProducts + 1 where CategoryID = '" . $CategoryID . "'";
			$this->query($strUpdateQuery, 0);
		}


		if ($itemType == "Discontinue") {
			$Status = 0;
		}


		$procurment = implode(',', $procurement_method);
		$Model_type = implode(',', $Model);


		$strSQLQuery = "insert into inv_items (description,procurement_method,CategoryID,evaluationType ,itemType,non_inventory,UnitMeasure,min_stock_alert_level,max_stock_alert_level,purchase_tax_rate,sale_tax_rate,Status, AddedDate, Sku,item_alias, sell_price, qty_on_hand, long_description,Model,Generation,`Condition`,Extended,Manufacture,ReorderLevel,is_exclusive,product_type,secure_type)
	values ('" . addslashes($description) . "','" . addslashes($procurment) . "','" . $CategoryID . "' ,'" . addslashes($evaluationType) . "','" . addslashes($itemType) . "','" . $non_inventory . "','" . addslashes($UnitMeasure) . "',
	'" . addslashes($min_stock_alert_level) . "','" . addslashes($max_stock_alert_level) . "',
	'" . addslashes($purchase_tax_rate) . "','" . addslashes($sale_tax_rate) . "',
	'" . $Status . "','" . date('Y-m-d') . "','" . addslashes($Sku) . "','" . addslashes($item_alias) . "' , '" . addslashes($sell_price) . "', '" . addslashes($qty_on_hand) . "', '" . addslashes($long_description) . "', '" . addslashes($Model_type) . "', '" . addslashes($Generation_type) . "', '" . addslashes($Condition) . "', '" . addslashes($Extended) . "', '" . addslashes($Manufacture) . "','" . addslashes($ReorderLevel) . "','" . addslashes($is_exclusive) . "','".addslashes($product_type)."','".addslashes($secure_type)."')";


		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();

		if($is_exclusive=='Yes'){
			if($CustomerID!=''){
				$CustomerArray=explode(',',$CustomerID);
			}
			foreach($CustomerArray as $key=>$val){
				if($val!=''){
					$strSQLQuery = "insert into inv_customer_items (ItemID,CustomerID )
				values ('" . addslashes($lastInsertId) . "','" . addslashes($val) . "')";
					$this->query($strSQLQuery, 0);
				}

					
			}
		}

		/* if($lastInsertId>0){
		 $code="ITM000".$lastInsertId;
		 $sql="update inv_items set Sku='".$code."' where ItemID=".$lastInsertId;
		 $this->query($sql,0);

		 } */

		return $lastInsertId;
	}

	function changeItemStatus($ItemID) {
		$sql = "select * from inv_items where ItemID='" . $ItemID. "'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 1) {
				$Status = 0;
				$itemType = 'Discontinue';
				$sql = "update inv_items set Status='" . $Status . "',itemType ='" . $itemType . "' where ItemID='" . $ItemID. "'";
			} else {
				$Status = 1;

				$sql = "update inv_items set Status='" . $Status . "' where ItemID='" . $ItemID . "'";
			}
			$this->query($sql, 0);
		}


		if ($Status == 1 && $rs[0]['Status'] != 1 && $rs[0]['PostedByID'] > 1) {
			$this->ItemActiveEmail($ItemID);
		}

		return true;
	}

	function MultipleItemStatus($ItemID, $Status) {
		$sql = "select * from inv_items where ItemID in (" . $ItemID . ") and Status!='" . $Status. "'";
		$arryRow = $this->query($sql);
		if (sizeof($arryRow) > 0) {

			$sql = "update inv_items set Status='" . $Status . "' where ItemID in (" . $ItemID . ")";
			$this->query($sql, 0);

			for ($i = 0; $i < sizeof($arryRow); $i++) {

				if ($Status == 1 && $arryRow[$i]['Status'] != 1 && $arryRow[$i]['PostedByID'] > 1) {
					$this->ItemActiveEmail($arryRow[$i]['ItemID']);
				}
			}
		}

		return true;
	}

	function changeFeaturedStatus($ItemID) {
		$sql = "select * from inv_items where ItemID='" . $ItemID. "'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['itemType'] == 'Discontinue')
			$Featured = 'No';
			else
			$Featured = 'Yes';

			$sql = "update inv_items set Featured='$Featured' where ItemID='" . $ItemID. "'";
			$this->query($sql, 0);
			return true;
		}
	}

	function UpdateViewedDate($ItemID) {
		$sql = "update inv_items set ViewedDate='" . date('Y-m-d') . "' where ItemID='" . $ItemID. "'";
		$this->query($sql, 0);
		return true;
	}

	function FeaturedDisabled($ItemID) {

		$sql = "update inv_items set Featured='No',FeaturedType='',Impression='0',ImpressionCount='0',  FeaturedStart='',FeaturedEnd=''   where ItemID in(" . $ItemID . ")";
		$this->query($sql, 0);
		return true;
	}

	function UpdateImage($imageName, $ItemID) {
		$strSQLQuery = "update inv_items set Image='" . $imageName . "' where ItemID='" . $ItemID . "'";
		return $this->query($strSQLQuery, 0);
	}

	function UpdateBasic($arryDetails) {
		extract($arryDetails);
		$procurment = implode(',', $procurement_method);
		$Model_type = implode(',', $Model);

		 $strSQLQuery = "update inv_items set CategoryID = '" . $CategoryID . "',
                    description='" . mysql_real_escape_string($description) . "',
                    non_inventory = '" . $non_inventory . "',
                    procurement_method='" . $procurment . "',
                    evaluationType='" . mysql_real_escape_string($evaluationType) . "',
                    itemType='" . mysql_real_escape_string($itemType) . "',
                    UnitMeasure='" . mysql_real_escape_string($UnitMeasure) . "',
                    min_stock_alert_level='" . $min_stock_alert_level . "' ,
                    max_stock_alert_level='" . $max_stock_alert_level . "',
                    Taxable='" . mysql_real_escape_string($Taxable) . "' ,
                                        ReorderLevel='" . mysql_real_escape_string($ReorderLevel) . "' ,
                    purchase_tax_rate='" . $purchase_tax_rate . "',
                    sale_tax_rate='" . $sale_tax_rate . "', 
                    Status        = '" . $Status . "',
                                      
                    item_alias='" . mysql_real_escape_string($item_alias) . "',
                    LastAdminType='" . $_SESSION['AdminType'] . "',
                    LastCreatedBy='" . $_SESSION['DisplayName'] . "',
                    Model = '" . addslashes($Model_type) . "',
                    Generation = '" . mysql_real_escape_string($Generation_type) . "',
                        `Condition` = '" . mysql_real_escape_string($Condition) . "',
                    Extended = '" . mysql_real_escape_string($Extended) . "',
                    Manufacture = '" . mysql_real_escape_string($Manufacture) . "',
                    is_exclusive = '" . mysql_real_escape_string($is_exclusive) . "',
                    product_type = '".addslashes($product_type)."',
                    secure_type = '".addslashes($secure_type)."'
                    where ItemID='" . $ItemID . "'";  
		$this->query($strSQLQuery, 0);

		if($EditableSku==1 && $OldSku!=$Sku && !empty($Sku)){
			$strSQL2 = "update inv_items set Sku = '" . mysql_real_escape_string($Sku) . "'    where ItemID='" . mysql_real_escape_string($ItemID) . "'";
			$this->query($strSQL2, 0);
			$strSQL3 = "update inv_item_alias set sku = '" . mysql_real_escape_string($Sku) . "'    where item_id='" . mysql_real_escape_string($ItemID) . "'";
			$this->query($strSQL3, 0);

		}
			
		if($is_exclusive=='Yes'){


			if($CustomerID!=''){
				$strSQLQuery = "SELECT CustomerID FROM inv_customer_items where ItemID = '" . $ItemID . "' and  CustomerID not in (".$CustomerID.") ";
				$custres=$this->query($strSQLQuery, 1);
				foreach($custres as $key=>$val){
					if($val['CustomerID']!=''){
						$strSQLQuery = "delete from inv_customer_items where ItemID='" . addslashes($ItemID) . "'
						and CustomerID ='" . addslashes($val['CustomerID']) . "' "; 
						$this->query($strSQLQuery, 0);
					}


				}

				$CustomerArray=explode(',',$CustomerID);


				foreach($CustomerArray as $key=>$val){
					if($val!=''){
						$strSQLQuery = "SELECT count(*) as total FROM inv_customer_items
						where ItemID = '" . $ItemID . "' and CustomerID ='" . addslashes($val) . "' ";
						$res=$this->query($strSQLQuery, 1);
							
						if($res[0]['total']=='0'){
							$strSQLQuery = "insert into inv_customer_items (ItemID,CustomerID )
						values ('" . addslashes($ItemID) . "','" . addslashes($val) . "')";
							$this->query($strSQLQuery, 0);
						}
					}


				}

					
			}

		}
		elseif($is_exclusive=='No'){
			$strSQLQuery = "delete from inv_customer_items where ItemID='" . addslashes($ItemID) . "'";
			$this->query($strSQLQuery, 0);

		}

		return 1;
	}

	function GetAliasbyItemID($ItemID) {
		$strSQLQuery = "SELECT * FROM inv_item_alias where item_id = '" . $ItemID . "' ORDER BY AliasID ASC";
		//echo $strSQLQuery;
		return $this->query($strSQLQuery);
	}

	function UpdateItemOther($arryDetails) {

		extract($arryDetails);

		$strSQLQuery = "update inv_items set description='" . addslashes($description) . "', long_description='" . addslashes($long_description) . "', Status='" . $Status . "',sell_price='" . addslashes($sell_price) . "',qty_on_hand='" . addslashes($qty_on_hand) . "', LastAdminType='" . $_SESSION['AdminType'] . "',LastCreatedBy='" . $_SESSION['DisplayName'] . "' where ItemID='" . $ItemID. "'";

		$this->query($strSQLQuery, 0);


		return 1;
	}

	function UpdateSuplier($arryDetails) {

		extract($arryDetails);

		$strSQLQuery = "update inv_items set SuppCode='" . $SuppCode . "' , LastAdminType='" . $_SESSION['AdminType'] . "',LastCreatedBy='" . $_SESSION['DisplayName'] . "' where ItemID='" . $ItemID. "'";

		$this->query($strSQLQuery, 0);

		return 1;
	}

	function UpdatePrice($arryDetails) {
		global $Config;
		extract($arryDetails);

		$SelectQuery = "select purchase_cost,sell_price from inv_items where ItemID='" . $ItemID . "'";
		$rs = $this->query($SelectQuery);
		if (sizeof($rs)) {
			if ($rs[0]['purchase_cost'] != $purchase_cost) {

				$oldPurchaseCost = $rs[0]['purchase_cost'];
				//$notify=1;
			}

			if ($rs[0]['sell_price'] != $sell_price) {
				//$notify=2;
				$oldSaleCost = $rs[0]['sell_price'];
			}
		}

		$strSQLQuery = "update inv_items set average_cost='" . $average_cost . "',last_cost='" . $oldPurchaseCost . "', purchase_cost='" . $purchase_cost . "', sell_price='" . $sell_price . "', LastAdminType='" . $_SESSION['AdminType'] . "',LastCreatedBy='" . $_SESSION['DisplayName'] . "' where ItemID='" . $ItemID . "'";
		$this->query($strSQLQuery, 0);



		return 1;


	}


	/*** Variant Update ************/

	function UpdateVariantItem($arryDetails) {

		extract($arryDetails);

		$Variant_id = implode(',', $ID);

		$strSQLQuery = "update  inv_items set variant_id='" . addslashes($Variant_id) . "'  where itemID='" . $ItemID . "'";


		$this->query($strSQLQuery, 0);


		return 1;

		//return $lastInsertId;
	}

	/*     * *******************Model Genration *********************** */

	function AddModelGen($arryDetails) {

		extract($arryDetails);

		$Generation_type = implode(',', $Generation);

		$strSQLQuery = "insert into inv_ModelGen (Model,item_id,Sku,Generation,Status )
	values ('" . addslashes($Model) . "','" . addslashes($ItemID) . "','" . addslashes($Sku) . "' ,'" . addslashes($Generation_type) . "','" . $Status . "')";


		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();



		return $lastInsertId;
	}

	function updateModel($arryDetails) {

		extract($arryDetails);
		$Generation_type = implode(',', $Generation);
		$strSQLQuery = "update  inv_ModelGen set Model='" . addslashes($Model) . "' , Generation='" . addslashes($Generation_type) . "',Status='" . $Status . "' where id='" . $id . "'";

		$this->query($strSQLQuery, 0);

		return 1;
	}


	function GetModelGen($id) {
			
		$strAddQuery .= (!empty($id)) ? (" and id='" . $id . "'") : (" and Status =1 ");
		$strSQLQuery = "Select * from inv_ModelGen where 1 ".$strAddQuery." order by Model";
		return $this->query($strSQLQuery, 1);
	}

	function GetModel($ids)
	{
		if(!empty($ids)){
			$strSQLQuery = "Select * from inv_ModelGen where id in($ids) ";

			// $strSQLQuery = "Select * from inv_ModelGen where 1 ";
			// $strSQLQuery .= (!empty($id)) ? (" and id in (" . $ids . ")") : ("  ");
			#echo $strSQLQuery ; exit;
			return $this->query($strSQLQuery, 1);
		}
	}

	function deleteModel($id) {
		$strSQLQuery = "delete from inv_ModelGen where id='" . $id . "'";
		$this->query($strSQLQuery, 0);
		return true;
	}

	function ListModel($arryDetails) {

		extract($arryDetails);

		$strAddQuery = '';
		$SearchKey = strtolower(trim($key));
		$strAddQuery .= (!empty($id)) ? (" where id='" . $id . "'") : (" where 1 ");

		if ($sortBy != '') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortBy . " like '%" . $SearchKey . "%')") : ("");
		} else {
			$strAddQuery .= (!empty($SearchKey)) ? (" and ( Model like '%" . $SearchKey . "%'   ) " ) : ("");
		}


		$strAddQuery .= (!empty($sortBy)) ? (" order by " . $sortBy . " ") : (" order by Model ");
		$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

		$strSQLQuery = "select * from inv_ModelGen  " . $strAddQuery;




		return $this->query($strSQLQuery, 1);
	}

	function isModelExists($Model, $id) {


		$strSQLQuery = "select id from inv_ModelGen where LCASE(Model)='" . strtolower($Model) . "'";

		$strSQLQuery .= ($id > 0) ? (" and id != '" . $id . "'") : ("");


		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['id'])) {
			return true;
		} else {
			return false;
		}
	}

	function changeModelStatus($id) {

		$sql = "select * from inv_ModelGen where id='" . $id . "'";
		$rs = $this->query($sql);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 1) {
				$Status = 0;
			} else {
				$Status = 1;
			}
			$sql = "update inv_ModelGen set Status='" . $Status . "' where id='" . $id . "'";
			$this->query($sql, 0);
		}

		return true;
	}

	/*     * ***********************finish ******************** */

	/*     * **************************************************** */

	function ItemWarehouse($ids) {

		$strSQLQuery = "Select * from w_warehouse where WID in (" . $ids . ")";
		return $this->query($strSQLQuery, 1);
	}

	function AddItemBin($arryDetails) {
		extract($arryDetails);

		$Generation_type = implode(',', $Generation);

		//for($i=0;$i<sizeof($bin);$i++){
		for($i=0;$i<sizeof($bin_location);$i++){
			$SelectQuery = "select count(*) as total from inv_bin_stock
			where Wcode='" . addslashes($warehouse) . "' and Sku='" . addslashes($item_Sku) . "'
			 and bin='" . addslashes($bin_location[$i]) . "'  and ConditionId='" . addslashes($ConditionId) . "' ";
			$rs = $this->query($SelectQuery);
			if ($rs[0]['total']==0) {
				$strSQLQuery = "insert into inv_bin_stock (Wcode,Sku,reorderlevel,bin,ConditionId )
	values ('" . addslashes($warehouse) . "','" . addslashes($item_Sku) . "','" . addslashes($reorderlevel) . "' ,'" . addslashes($bin_location[$i]) . "' ,'" . addslashes($ConditionId) . "')";


				$this->query($strSQLQuery, 0);
				$lastInsertId = $this->lastInsertId();

			}

		}

		//}
		return $lastInsertId;
	}

	function GetBinBySku($Sku) {

		$strAddQuery = "where 1 ";
		$strAddQuery .= ($Sku != '') ? ("and inv_stock.Sku ='" . $Sku . "'") : (" ");
		$strSQLQuery = "select inv_stock.*,w.warehouse_name,w.warehouse_code,w.WID,bin.binlocation_name,binid ,c.Name
		from inv_bin_stock  inv_stock 
		left outer join w_warehouse w  on inv_stock.Wcode = w.WID 
		left outer join w_binlocation bin  on inv_stock.bin = bin.binid 
		left join inv_condition c on c.ConditionID=inv_stock.ConditionID " . $strAddQuery;


		return $this->query($strSQLQuery, 1);
	}

	function RemoveBinStock($id) {

		$sql = "delete from inv_bin_stock  where id= '" . $id . "'";
		$this->query($sql, 0);
		return 1;
	}

	/*     * **************************************************** */

	function PriceNotification($arryDetails) {
		global $Config;
		extract($arryDetails);
		$department = $Config['DepID'];
		$SelectQuery = "select description,purchase_cost,sell_price from inv_items where ItemID='" . $ItemID . "'";
		$rs = $this->query($SelectQuery);
		if (sizeof($rs)) {
			if ($rs[0]['purchase_cost'] != $purchase_cost) {

				$oldPurchaseCost = $rs[0]['purchase_cost'];
				$notify = 1;
			}

			if ($rs[0]['sell_price'] != $sell_price) {
				$notify2 = 2;
				$oldSaleCost = $rs[0]['sell_price'];
			}
		}


		if ($notify == 1) {
			/*             * ***************************** */


			$arryItem = $this->GetItemById($ItemID);
			if ($_SESSION['AdminType'] == 'admin') {
				$CreatedBy = 'Administrator';
			} else {
				$CreatedBy = $_SESSION['UserName'];
			}
			/** Notification * */
			$arryNotification['refID'] = $Sku;
			$arryNotification['refType'] = "PurchaseCost";
			$arryNotification['Name'] = $rs[0]['description'];
			$arryNotification['Subject'] = "Change Purchase cost for [SKU:" . $Sku . "]";
			$arryNotification['Message'] = 'Purchase cost for Item:' . $rs[0]['description'] . ' [SKU:' . $Sku . '] has been changed from ' . $Config['Currency'] . ' ' . $oldPurchaseCost . ' to ' . $Config['Currency'] . ' ' . $purchase_cost . '';
			$objConfigure = new configure();
			#print_r($arryNotification); exit;
			$objConfigure->AddNotification($arryNotification);
			/*             * **************** */

			/*
			 $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku. "','" . $oldPurchaseCost . "','" . $purchase_cost . "','".$department."','" .date('d:m:y h:i:s'). "','".$_SESSION['locationID']."','PurchaseCost','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['UserName']."','".$Config['Currency']."')";
			 $this->query($strSQLQuery, 0);

			 $UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));

			 $htmlPrefix = $Config['EmailTemplateFolder'];
			 $contents = file_get_contents($htmlPrefix."price_notify_admin.htm");

			 $CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
			 $contents = str_replace("[URL]",$Config['Url'],$contents);
			 $contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			 $contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			 $contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
			 $contents = str_replace("[SKU]",$arryItem[0]['Sku'],$contents);
			 $contents = str_replace("[UpdateDate]",$UpdateDate,$contents);
			 $contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
			 $contents = str_replace("[OLDCOST]",$oldPurchaseCost,$contents);
			 $contents = str_replace("[CUR]",$Config['Currency'],$contents);
			 $contents = str_replace("[PURCHASECOST]",$purchase_cost,$contents);

			 $contents = str_replace("[DESC]",$arryItem[0]['description'],$contents);


			 $mail = new MyMailer();
			 $mail->IsMail();
			 $mail->AddAddress($Config['AdminEmail']);
			 $mail->sender($Config['SiteName'], $Config['AdminEmail']);
			 $mail->Subject = $Config['SiteName']." - Purchase Price Update - For ".$arryItem[0]['Sku'];
			 $mail->IsHTML(true);
			 $mail->Body = $contents;
			 #echo $Config['AdminEmail'].$contents; exit;
			 if($Config['Online'] == '1'){
			 $mail->Send();
			 }
			 */
		}
		if ($notify2 == 2) {
			/*             * ***************************** */
			$arryItem = $this->GetItemById($ItemID);
			if ($_SESSION['AdminType'] == 'admin') {
				$CreatedBy = 'Administrator';
			} else {
				$CreatedBy = $_SESSION['UserName'];
			}

			$arryNotification['refID'] = $Sku;
			$arryNotification['refType'] = "saleCost";
			$arryNotification['Name'] = $rs[0]['description'];
			$arryNotification['Subject'] = "Change Sales cost for [SKU:" . $Sku . "]";
			$arryNotification['Message'] = 'Sales cost for Item:' . $rs[0]['description'] . ' [SKU:' . $Sku . '] has been changed from ' . $Config['Currency'] . ' ' . $oldSaleCost . ' to ' . $Config['Currency'] . ' ' . $sell_price . '';
			$objConfigure = new configure();
			#print_r($arryNotification); exit;
			$objConfigure->AddNotification($arryNotification);


			/* $strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku. "','" . $oldSaleCost . "','" . $purchase_cost . "','".$department."','" .date('d:m:y h:i:s'). "','".$_SESSION['locationID']."','saleCost','".$_SESSION['AdminID']."','".$_SESSION['AdminType']."','".$_SESSION['UserName']."','".$Config['Currency']."')";
			 $this->query($strSQLQuery, 0);
			 $UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));

			 $htmlPrefix = $Config['EmailTemplateFolder'];
			 $contents = file_get_contents($htmlPrefix."price_notify_sale_admin.htm");

			 $CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
			 $contents = str_replace("[URL]",$Config['Url'],$contents);
			 $contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			 $contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			 $contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
			 $contents = str_replace("[SKU]",$arryItem[0]['Sku'],$contents);
			 $contents = str_replace("[UpdateDate]",$UpdateDate,$contents);
			 $contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
			 $contents = str_replace("[OLDCOST]",$oldSaleCost,$contents);
			 $contents = str_replace("[SALECOST]",$sell_price,$contents);
			 $contents = str_replace("[CUR]",$Config['Currency'],$contents);
			 $contents = str_replace("[DESC]",$arryItem[0]['description'],$contents);



			 $mail = new MyMailer();
			 $mail->IsMail();
			 $mail->AddAddress($Config['AdminEmail']);
			 $mail->sender($Config['SiteName'], $Config['AdminEmail']);
			 $mail->Subject = $Config['SiteName']." - Sale Price Update - For ".$arryItem[0]['Sku'];
			 $mail->IsHTML(true);
			 $mail->Body = $contents;
			 #echo $Config['AdminEmail'].$contents; exit;
			 if($Config['Online'] == '1'){
			 $mail->Send();
			 }
			 */
		}
		return 1;
	}

	function PriceNotification555($arryDetails) {
		global $Config;
		extract($arryDetails);
		$department = $Config['DepID'];
		$SelectQuery = "select purchase_cost,sell_price from inv_items where ItemID='" . $ItemID . "'";
		$rs = $this->query($SelectQuery);
		if (sizeof($rs)) {
			if ($rs[0]['purchase_cost'] != $purchase_cost) {

				$oldPurchaseCost = $rs[0]['purchase_cost'];
				$notify = 1;
			}

			if ($rs[0]['sell_price'] != $sell_price) {
				$notify2 = 2;
				$oldSaleCost = $rs[0]['sell_price'];
			}
		}


		if ($notify == 1) {
			/*             * ***************************** */


			$arryItem = $this->GetItemById($ItemID);
			if ($_SESSION['AdminType'] == 'admin') {
				$CreatedBy = 'Administrator';
			} else {
				$CreatedBy = $_SESSION['UserName'];
			}
			#echo $Config['DepID']; exit;
			$strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku . "','" . $oldPurchaseCost . "','" . $purchase_cost . "','" . $department . "','" . date('d:m:y h:i:s') . "','" . $_SESSION['locationID'] . "','PurchaseCost','" . $_SESSION['AdminID'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['UserName'] . "','" . $Config['Currency'] . "')";
			$this->query($strSQLQuery, 0);





			$UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));
			/*             * ******************* */
			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix . "price_notify_admin.htm");

			$CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
			$contents = str_replace("[URL]", $Config['Url'], $contents);
			$contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
			$contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
			$contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);
			$contents = str_replace("[SKU]", $arryItem[0]['Sku'], $contents);
			$contents = str_replace("[UpdateDate]", $UpdateDate, $contents);
			$contents = str_replace("[CreatedBy]", $CreatedBy, $contents);
			$contents = str_replace("[OLDCOST]", $oldPurchaseCost, $contents);
			$contents = str_replace("[CUR]", $Config['Currency'], $contents);
			$contents = str_replace("[PURCHASECOST]", $purchase_cost, $contents);


			$contents = str_replace("[DESC]", $arryItem[0]['description'], $contents);



			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);
			$mail->Subject = $Config['SiteName'] . " - Purchase Price Update - For " . $arryItem[0]['Sku'];
			$mail->IsHTML(true);
			$mail->Body = $contents;
			#echo $Config['AdminEmail'].$contents; exit;
			if ($Config['Online'] == '1') {
				$mail->Send();
			}
		}
		if ($notify2 == 2) {
			/*             * ***************************** */
			$arryItem = $this->GetItemById($ItemID);
			if ($_SESSION['AdminType'] == 'admin') {
				$CreatedBy = 'Administrator';
			} else {
				$CreatedBy = $_SESSION['UserName'];
			}

			$strSQLQuery = "insert into notification (refID,old_value,new_value,department,notifyDate,locationID,RefType,AdminID,AdminType,CreatedBy,Currency)  values ('" . $Sku . "','" . $oldSaleCost . "','" . $purchase_cost . "','" . $department . "','" . date('d:m:y h:i:s') . "','" . $_SESSION['locationID'] . "','saleCost','" . $_SESSION['AdminID'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['UserName'] . "','" . $Config['Currency'] . "')";
			$this->query($strSQLQuery, 0);





			$UpdateDate = date($Config['DateFormat'], strtotime($Config['TodayDate']));
			/*             * ******************* */
			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix . "price_notify_sale_admin.htm");

			$CompanyUrl = $Config['Url'] . $Config['AdminFolder'] . '/';
			$contents = str_replace("[URL]", $Config['Url'], $contents);
			$contents = str_replace("[SITENAME]", $Config['SiteName'], $contents);
			$contents = str_replace("[FOOTER_MESSAGE]", $Config['MailFooter'], $contents);
			$contents = str_replace("[COMPNAY_URL]", $CompanyUrl, $contents);
			$contents = str_replace("[SKU]", $arryItem[0]['Sku'], $contents);
			$contents = str_replace("[UpdateDate]", $UpdateDate, $contents);
			$contents = str_replace("[CreatedBy]", $CreatedBy, $contents);
			$contents = str_replace("[OLDCOST]", $oldSaleCost, $contents);
			$contents = str_replace("[SALECOST]", $sell_price, $contents);
			$contents = str_replace("[CUR]", $Config['Currency'], $contents);
			$contents = str_replace("[DESC]", $arryItem[0]['description'], $contents);



			$mail = new MyMailer();
			$mail->IsMail();
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);
			$mail->Subject = $Config['SiteName'] . " - Sale Price Update - For " . $arryItem[0]['Sku'];
			$mail->IsHTML(true);
			$mail->Body = $contents;
			#echo $Config['AdminEmail'].$contents; exit;
			if ($Config['Online'] == '1') {
				$mail->Send();
			}
		}
		return 1;
	}

	function UpdateQuantity($arryDetails) {

		extract($arryDetails);

		$strSQLQuery = "update inv_items set allocated_qty='" . $allocated_qty . "',qty_on_demand='" . $qty_on_demand . "' where ItemID='" . $ItemID."'";


		$this->query($strSQLQuery, 0);

		return 1;
	}

	function UpdateDimensions($arryDetails) {
		extract($arryDetails);


		// $strSQLQuery = "update inv_items set pack_size='" . addslashes($pack_size) . "',weight='" . addslashes($weight) . "',width='" . addslashes($width) . "',height='" . addslashes($height) . "',depth='" . addslashes($depth) . "' where ItemID='" . $ItemID."'";

		$strSQLQuery = "update inv_items set pack_size='" . addslashes($pack_size) . "',weight='" . addslashes($weight) . "',width='" . addslashes($width) . "',height='" . addslashes($height) . "',depth='" . addslashes($depth) . "',wt_Unit='".addslashes($wtUnit)."'  ,wd_Unit='" . addslashes($wdUnit). "' ,ht_Unit='" . addslashes($htUnit)."' ,ln_Unit='" . addslashes($lnUnit). "' where ItemID='" . $ItemID."'";
		$this->query($strSQLQuery, 0);

		return 1;
	}

	function UpdateSeo($arryDetails) {


		extract($arryDetails);


		$strSQLQuery = "update inv_items set MetaTitle='" . addslashes($MetaTitle) . "',MetaKeywords='" . addslashes($MetaKeywords) . "',MetaDescription = '" . addslashes($MetaDescription) . "',UrlCustom = '" . $UrlCustom . "'  where ItemID='" . $ItemID."'";

		$this->query($strSQLQuery, 0);

		return 1;
	}

	function UpdateInventory($arryDetails) {


		extract($arryDetails);


		$strSQLQuery = "update inv_items set Quantity='" . addslashes($Quantity) . "',InventoryControl='" . addslashes($InventoryControl) . "',InventoryRule = '" . $InventoryRule . "',StockWarning = '" . $StockWarning . "' where ItemID='" . $ItemID."'";

		$this->query($strSQLQuery, 0);

		return 1;
	}

	/*     * ***********************************Alternatative Images Function Start***************************************************************** */

	function AddAlternativeImage($ItemID) {

		$strSQLQuery = "select ItemID from inv_item_images where ItemID='" . $ItemID . "'";

		$arryRow = $this->query($strSQLQuery, 1);
		if (empty($arryRow[0]['ItemID'])) {

			$strSQLQuery = "insert into inv_item_images(ItemID) values ('" . $ItemID . "')";
			$this->query($strSQLQuery, 0);
		}

		return 1;
	}

	function UpdateAlternativeImage($imageId, $imageName, $alt_text) {

		$strSQLQuery = "INSERT INTO inv_item_images set  ItemID='" . $imageId . "', Image='" . $imageName . "', alt_text='" . $alt_text . "'";

		return $this->query($strSQLQuery, 0);
	}

	function GetTotalImagesCount($ItemID) {

		$strSQLQuery = "select count(Iid) as total from inv_item_images where ItemID='" . $ItemID . "'";
		return $this->query($strSQLQuery, 1);
	}

	function GetAlternativeImage($ItemID) {

		$strSQLQuery = "Select * from inv_item_images where ItemID='" . $ItemID . "'";
		return $this->query($strSQLQuery, 1);
	}

	function deleteImage($pid, $imageId) {
		$objConfigure = new configure();
		$select = mysql_query("select Image from inv_item_images where Iid = '" . $imageId . "' and ItemID='" . $pid . "'");
		$image = mysql_fetch_array($select);
		$ImgDir = 'upload/items/images/secondary/' . $_SESSION['CmpID'] . '/';
		$objConfigure->UpdateStorage($ImgDir . $image['Image'], 0, 1);
		unlink($ImgDir . $image['Image']);
		$strSQLQuery = "delete from inv_item_images where Iid = '" . $imageId . "' and ItemID='" . $pid . "'";
		$this->query($strSQLQuery, 0);
		return 1;
	}

	/*     * ***********************************Alternatative Images Function Start***************************************************************** */

	function RemoveItem($id, $CategoryID, $Front) {
		global $Config;
		$objConfigure = new configure();

		$strSQLQuery = "select Image from inv_items where ItemID='" . $id . "'";
		$arryRow = $this->query($strSQLQuery, 1);

		$ImgDir = $Config['UploadPrefix'] . 'upload/items/images/' . $_SESSION['CmpID'] . '/';

		if ($arryRow[0]['Image'] != '' && file_exists($ImgDir . $arryRow[0]['Image'])) {
			$objConfigure->UpdateStorage($ImgDir . $arryRow[0]['Image'], 0, 1);
			unlink($ImgDir . $arryRow[0]['Image']);
		}

		$sql2 = "select * from inv_item_images where ItemID='" . $id . "'";
		$arryRow2 = $this->query($sql2, 1);
		$ImgDir = 'upload/items/images/secondary/' . $_SESSION['CmpID'] . '/';
		foreach ($arryRow2 as $key => $values) {
			$Image = $values['Image'];
			if ($Image != '' && file_exists($ImgDir . $Image)) {
				$objConfigure->UpdateStorage($ImgDir . $Image, 0, 1);
				#unlink($ImgDir . $Image);
			}
		}

		$strSQLQuery = "delete from inv_items where ItemID='" . $id . "'";
		$this->query($strSQLQuery, 0);

		$strSQLQuery = "delete from inv_item_images where ItemID='" . $id . "'";
		$this->query($strSQLQuery, 0);

		$strSQLQuery = "delete from inv_item_required where ItemID='" . $id . "'";
		$this->query($strSQLQuery, 0);

		$strSQLQuery = "delete from inv_item_alias where item_id='" . $id . "'";
		$this->query($strSQLQuery, 0);

		if ($CategoryID > 0) {
			$strSQLQuery = "select NumProducts from inv_categories where CategoryID='" . $CategoryID . "'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['NumProducts'])) {
				$strUpdateQuery = "update inv_categories set NumProducts = NumProducts - 1 where CategoryID = '" . $CategoryID . "'";
				$this->query($strUpdateQuery, 0);
			}
		}
		return 1;
	}

	function RemoveMultipleItem($ids, $Front) {


		$strSQLQuery = "select Image,CategoryID from inv_items where ItemID in (" . $ids . ")";
		$arryRow = $this->query($strSQLQuery, 1);

		$strSQLQuery = "delete from inv_items where ItemID in (" . $ids . ")";
		$this->query($strSQLQuery, 0);




		if ($Front > 0) {
			$ImgDir = 'upload/items/';
		} else {
			$ImgDir = 'upload/items/images/' . $_SESSION['CmpID'] . '/';
		}

		for ($i = 0; $i < sizeof($arryRow); $i++) {


			if ($arryRow[$i]['Image'] != '' && file_exists($ImgDir . $arryRow[$i]['Image'])) {

				unlink($ImgDir . $arryRow[$i]['Image']);
			}

			if ($arryRow[$i]['Image'] != '' && file_exists($ImgDir . 'secondary/' . $_SESSION['CmpID'] . '/' . $arryRow[$i]['Image'])) {
				unlink($ImgDir . 'secondary/' . $_SESSION['CmpID'] . '/' . $arryRow[$i]['Image']);
			}


			if ($arryRow[$i]['CategoryID'] > 0) {
				$strSQLQuery = "select NumProducts from inv_categories where CategoryID='" . $arryRow[$i]['CategoryID']."'";
				$arryRow2 = $this->query($strSQLQuery, 1);
				if (!empty($arryRow2[$i]['NumProducts'])) {
					$strUpdateQuery = "update inv_categories set NumProducts = NumProducts - 1 where CategoryID = '" . $arryRow[$i]['CategoryID']."'";
					$this->query($strUpdateQuery, 0);
				}
			}
		}

		return 1;
	}

	function isItemExists($Name, $ItemID = 0, $CategoryID) {

		$strSQLQuery = "select ItemID from inv_items where LCASE(Name)='" . strtolower(trim($Name)) . "'";

		$strSQLQuery .= ($ItemID > 0) ? (" and ItemID != '" . $ItemID."'") : ("");
		//$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID = '".$CategoryID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['ItemID'])) {
			return true;
		} else {
			return false;
		}
	}

	function isItemNumberExists($ProductSku, $ItemID = 0, $PostedByID) {

		$strSQLQuery = "select ItemID from inv_items where LCASE(Sku)='" . strtolower(trim($ProductSku)) . "'";

		$strSQLQuery .= ($ItemID > 0) ? (" and ItemID != '" . $ItemID . "'") : ("");
		$strSQLQuery .= (!empty($PostedByID)) ? (" and PostedByID = '" . $PostedByID."'") : ("");

		$arryRow = $this->query($strSQLQuery, 1);
		//echo 'test: '.$arryRow[0]['ItemID']; exit;
		if (!empty($arryRow[0]['ItemID'])) {
			return true;
		} else {
			return false;
		}
	}

	function isItemAliasExists($ItemAliasCode, $AliasID = 0) {

		$strSQLQuery = "select AliasID from inv_item_alias where LCASE(ItemAliasCode)='" . strtolower(trim($ItemAliasCode)) . "'";

		$strSQLQuery .= ($AliasID > 0) ? (" and AliasID != '" . $AliasID . "'") : ("");
		//echo $strSQLQuery; exit;
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['AliasID'])) {
			return true;
		} else {
			return false;
		}
	}



	function IsActivatedItem($ItemID) {
		$strSQLQuery = "select * from inv_items where ItemID='" . $ItemID . "'";
		$arryRow = $this->query($strSQLQuery, 1);
		if ($arryRow[0]['ItemID'] > 0) {
			return 1;
		} else {
			return 0;
		}
	}

	/*     * ************************** */

	function countItemRating($pid) {

		$where = "WHERE Status = 'Yes' AND Pid = '" . $pid."'";
		$strSQLQuery = "SELECT SUM(Rating) as total FROM inv_items_reviews " . $where . "";
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function changeReviewStatus($id) {
		$strSQLQuery = "SELECT * FROM inv_items_reviews WHERE ReviewId='" . $id."'";
		$rs = $this->query($strSQLQuery);
		if (sizeof($rs)) {
			if ($rs[0]['Status'] == 'Yes')
			$Status = 'No';
			else
			$Status = 'Yes';

			$strSQLQuery = "UPDATE inv_items_reviews SET Status='" . $Status . "' WHERE ReviewId='" . $id."'";
			$this->query($strSQLQuery, 0);
			return true;
		}
	}

	function getDiscountByItem($id) {
		$where = "WHERE is_active = 'Yes' AND pid = '" . $id."'";
		$strSQLQuery = "SELECT * FROM e_products_quantity_discounts " . $where . "";
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	/*     * ********************* STOCK ADJUSTMENT *********** */

	function ListAdjustment($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {



		$strAddQuery = '';
		$SearchKey = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id)) ? (" where a.id='" . $id."'") : (" where 1 ");
		//$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");



		if ($SortBy == 'id') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (a.id = '" . $SearchKey . "')") : ("");
		} else {

			if ($SortBy != '') {
				$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
			} else {
				$strAddQuery .= (!empty($SearchKey)) ? (" and ( a.adjust_reason like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%'  ) " ) : ("");
			}
		}

		$strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.id ");
		$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

		$strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType from inv_stock_adjustment a left outer join  inv_items  i on i.Sku=a.Sku  " . $strAddQuery;




		return $this->query($strSQLQuery, 1);
	}

	function RemoveAdjustment($id) {

		$strSQLQuery = "DELETE FROM inv_adjustment WHERE adjID = '" . $id."'";
		$rs = $this->query($strSQLQuery, 0);

		$strSQLQuery2 = "DELETE FROM inv_stock_adjustment WHERE adjID = '" . $id."'";
		$this->query($strSQLQuery2, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function AddAdjustment($arryDetails) {
		global $Config;
		extract($arryDetails);

		if (empty($Currency))
		$Currency = $Config['Currency'];

		$strSQLQuery = "insert into inv_adjustment(total_adjust_qty,total_adjust_value,WID,warehouse_code,adjust_reason,adjDate,created_by,created_id,Status)
                            values('" . $TotalQty . "', '" . $TotalValue . "',  '" . $WID . "', '" . $warehouse . "', '" . addslashes($adjustment_reason) . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "')";

		$this->query($strSQLQuery, 0);
		$adjID = $this->lastInsertId();
		if ($adjID > 0) {
			$rs = $this->getPrefix(1);

			$PrefixAD = $rs[0]['adjustmentPrefix'];


			$ModuleIDValue = $PrefixAD . '000' . $adjID;
			$strSQL = "update inv_adjustment set adjustNo='" . $ModuleIDValue . "' where adjID='" . $adjID."'";
			$this->query($strSQL, 0);
		}

		return $adjID;
	}

	function UpdateAdjustment($arryDetails) {
		global $Config;
		extract($arryDetails);



		/* if($Closed==1){
		 $Status="Closed"; $ClosedDate=$Config['TodayDate'];
		 }else{
		 $Status="In Process"; $ClosedDate='';
		 }
		 */

		$strSQLQuery = "update inv_adjustment set total_adjust_qty='" . $TotalQty . "', total_adjust_value='" . $TotalValue . "', WID='" . $WID . "',  warehouse_code='" . $warehouse . "', adjust_reason='" . addslashes($adjustment_reason) . "', Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where adjID='" . $adjID."'";

		$this->query($strSQLQuery, 0);

		return 1;
	}

	function AddUpdateStock($adjustID, $arryDetails) {
		global $Config;
		extract($arryDetails);


		if (!empty($DelItem)) {
			$strSQLQuery = "delete from inv_stock_adjustment where id in(" . $DelItem . ")";
			$this->query($strSQLQuery, 0);
		}



		for ($i = 1; $i <= $NumLine; $i++) {

			if (!empty($arryDetails['sku' . $i])) {
				//$arryTax = explode(":",$arryDetails['tax'.$i]);




				$id = $arryDetails['id' . $i];
				if ($id > 0) {
					$sql = "update inv_stock_adjustment set item_id='" . $arryDetails['item_id' . $i] . "',valuationType='" . $arryDetails['valuationType' . $i] . "',serial_value='" . $arryDetails['serial_value' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', on_hand_qty='" . addslashes($arryDetails['on_hand_qty' . $i]) . "',  price='" . addslashes($arryDetails['price' . $i]) . "', amount='" . addslashes($arryDetails['amount' . $i]) . "',`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "'  where id=" . $id;
				} else {

					$sql = "insert into inv_stock_adjustment (adjID, item_id, sku, description, on_hand_qty, qty, price, amount,valuationType,serial_value,`Condition`) values('" . $adjustID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['on_hand_qty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "')";
					if ($arryDetails['Status'] == 2) {
						$strSQLItem = "update inv_items set purchase_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
						$this->query($strSQLItem, 0);




						/*                     * ************ Add Serial Number ************************ */
						if ($arryDetails['serial_value' . $i] != '') {
							$serial_noum = explode(",", $arryDetails['serial_value' . $i]);
							for ($j = 0; $j <= sizeof($serial_noum) - 1; $j++) {
								$strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $arryDetails['warehouse'] . "','" . $serial_noum[$j] . "','" . addslashes($arryDetails['sku' . $i]) . "','" . $AID . "')";
								$this->query($strSQLQuery, 0);
								//echo   $serial_no[$i]."<br/>";
							}
						}
						/*                     * ************ Exit; ********************************** */




						/*  if ($arryDetails['serial_value' . $i] != '') {
						 $serial_no = explode(",", $arryDetails['serial_value' . $i]);

						 for ($j = 0; $j < sizeof($serial_no) - 1; $j++) {
						 $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,adjustment_no)  values ('" . $arryDetails['warehouse'] . "','" . $serial_no[$j] . "','" . addslashes($arryDetails['sku' . $i]) . "','" . $adjustID . "')";
						 $this->query($strSQLQuery, 0);
						 //echo   $serial_no[$i]."<br/>";
						 }
						 }*/
					}
					$this->query($sql, 0);
				}
					

				if ($arryDetails['Status'] == 2) {
					$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "'";
					$this->query($UpdateQtysql, 0);

					/*********Added By karishma based on Condition*********************/
					if($arryDetails['Condition' . $i]!=''){
						$sql="select count(*) as total from inv_item_quanity_condition where
						Sku='" . addslashes($arryDetails['sku' . $i]) . "' and ItemID='" . addslashes($arryDetails['item_id' . $i]) . "'
						and `condition`='".addslashes($arryDetails['Condition' . $i])."' ";
						$restbl=$this->query($sql, 1);
						if($restbl[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition
							(ItemID,`condition`,Sku,type,condition_qty)  
							values ('" . addslashes($arryDetails['item_id' . $i]) . "',
							'" . addslashes($arryDetails['Condition' . $i]) . "',
							'" . addslashes($arryDetails['sku' . $i]) . "','Stock Adjustment',
							'" . addslashes($arryDetails['qty' . $i]) . "')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
							$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $arryDetails['qty' . $i] . "  where Sku='" . $arryDetails['sku' . $i] . "'";
							$this->query($UpdateQtysql, 0);

						}
					}


					/*********End By karishma based on Condition*********************/


				}
			}
		}

		return true;
	}

	function ListSerialNumber($arryDetails) {

		extract($arryDetails);

		$strAddQuery = '';
		$SearchKey = strtolower(trim($key));
		$strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where 1 ");
		$strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
		//$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
		$strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");


		if ($SearchKey == 'not available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
			$strAddQuery .= " and (s.UsedSerial=1 or s.UsedSerial=2)";
		} else if ($SearchKey == 'available' && ($sortby == 's.UsedSerial' || $sortby == '')) {
			$strAddQuery .= " and s.UsedSerial=0";
		} else if ($sortby == 's.serialNumber') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%')") : ("");
		} else if ($sortby == 's.Sku') {

			$strAddQuery .= (!empty($SearchKey)) ? (" and (s.Sku = '" . $SearchKey . "')") : ("");
		} else {
			if ($sortby != '') {
				$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
			} else {
				$strAddQuery .= (!empty($SearchKey)) ? (" and (s.serialNumber like '%" . $SearchKey . "%' or w.warehouse_name like '%" . $SearchKey . "%' or s.Sku like '%" . $SearchKey . "%'  ) " ) : ("");
			}
		}


		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by s.Sku ");
		$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

		$strSQLQuery = "SELECT s.*, w.warehouse_name ,w.warehouse_code  FROM inv_serial_item s left outer join w_warehouse w on BINARY(s.warehouse) = BINARY(w.warehouse_code) " . $strAddQuery;

		return $this->query($strSQLQuery, 1);
	}

	function AddSerialNumber($arrayDetail) {

		extract($arrayDetail);


		for ($i = 0; $i < sizeof($serial_no); $i++) {
			$strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku)  values ('" . $warehouse . "','" . $serial_no[$i] . "','" . $Sku . "')";
			$this->query($strSQLQuery, 0);
			//echo   $serial_no[$i]."<br/>";
		}
		return 1;
	}




	function GetSerialNumber($id,$Sku,$adjustment_no,$disassembly) {

		extract($arryDetails);

		$strAddQuery .= (!empty($id)) ? (" where s.serialID='" . $id."'") : (" where 1 ");
		$strAddQuery .= (!empty($selectIDs)) ? (" and s.serialID in ('" . $selectIDs . "')") : (" ");
		$strAddQuery .= (!empty($adjustment_no))?(" and s.adjustment_no='".$adjustment_no."'"):(" ");
		$strAddQuery .= (!empty($disassembly))?(" and s.disassembly='".$disassembly."'"):(" ");
		$strAddQuery .= (!empty($Sku)) ? (" and s.Sku='" . $Sku . "'") : (" ");
		$strAddQuery .= " order by s.Sku Desc";


		$strSQLQuery = "SELECT s.*, w.warehouse_name ,w.warehouse_code  FROM inv_serial_item s left outer join w_warehouse w on BINARY(s.warehouse) = BINARY(w.warehouse_code) " . $strAddQuery;

		return $this->query($strSQLQuery, 1);
	}

	/*     * **********UPDATE PREFIX***************** */

	function updatePrefix($arryDetails) {

		extract($arryDetails);

		$strSQLQuery = "Update  inv_prefix set adjustmentPrefix='" . $adjustmentPrefix . "',
							adjustPrefixNum='" . $adjustPrefixNum . "',
							ToP = '" . $ToP . "', 
							ToN='" . $ToN . "',
							bom_prefix='" . $bom_prefix . "',
							bom_number='" . $bom_number . "',
							updateDate='" . date('Y-m-d') . "',
							created_by='" . $_SESSION['AdminType'] . "',
							created_id='" . $_SESSION['AdminID'] . "' 
							where prefixID = '" . $prefixID . "'";
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function getPrefix($prefixID) {

		$strSQLQuery = "SELECT * FROM inv_prefix where prefixID= '" . $prefixID . "'";
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function ListingAdjustment($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {


		$strAddQuery = '';
		$SearchKey = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id)) ? (" where a.adjID='" . $id."'") : (" where 1 ");
		//$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");




		if ($SortBy != '') {
			if ($SortBy == 'a.Status') {
				if ($SearchKey == "parked") {
					$SearchKey = 1;
				} else if ($SearchKey == "completed") {
					$SearchKey = 2;
				} else {
					$SearchKey = 0;
				}
				$strAddQuery .= " and a.Status = '" . $SearchKey . "'";
			} else {
				$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
			}
		} else {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (a.adjustNo like '%" . $SearchKey . "%' or a.total_adjust_qty like '%" . $SearchKey . "%' or a.total_adjust_value like '%" . $SearchKey . "%'  ) " ) : ("");
		}



		$strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.adjID ");
		$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");

		$strSQLQuery = "SELECT a.*, w.warehouse_name ,w.warehouse_code  FROM inv_adjustment a left outer join w_warehouse w on BINARY(a.warehouse_code) = BINARY(w.warehouse_code) " . $strAddQuery;

		return $this->query($strSQLQuery, 1);
	}

	function GetAdjustmentStock($adjID) {
		$strAddQuery .= (!empty($adjID)) ? (" and adjID='" . $adjID."'") : ("");
		$strSQLQuery = "select * from inv_stock_adjustment  where 1" . $strAddQuery . " order by id asc";
		return $this->query($strSQLQuery, 1);
	}

	/*     * *************** Stock Transfer ******************** */

	function ListingTransfer($arryDetails) {

		extract($arryDetails);
		$strAddQuery = '';
		$SearchKey = strtolower(trim($key));
		if ($edit > 0)
		$id = $edit;
		$strAddQuery .= (!empty($id)) ? (" where t.transferID='" . $id."'") : (" where 1 ");
		//$strAddQuery .= (!empty($Status))?(" and t.Status='".$Status."'"):(" ");



		if ($sortby != '') {
			if ($sortby == 't.Status') {
				if ($SearchKey == 'completed') {
					$SearchKey = 2;
				} elseif ($SearchKey == 'parked') {
					$SearchKey = 1;
				} elseif ($SearchKey == 'cancel') {
					$SearchKey = 1;
				}
				$strAddQuery .= " and t.Status = '" . $SearchKey . "'";
			} else {
				$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $sortby . " like '%" . $SearchKey . "%')") : ("");
			}
		} else {
			$strAddQuery .= (!empty($SearchKey)) ? (" and ( t.total_transfer_qty like '%" . $SearchKey . "%' or t.transferNo like '%" . $SearchKey . "%' or t.total_transfer_value like '%" . $SearchKey . "%' or t.Status like '%" . $SearchKey . "%' or w2.warehouse_name like '%" . $SearchKey . "%' or w1.warehouse_name like '%" . $SearchKey . "%' ) " ) : ("");
		}



		$strAddQuery .= (!empty($sortby)) ? (" order by " . $sortby . " ") : (" order by t.transferNo ");
		$strAddQuery .= (!empty($AscDesc)) ? ($asc) : (" Asc");

		$strSQLQuery = "SELECT t.*, w1.warehouse_name as from_warehouse,w2.warehouse_code as from_warehouse_code,w2.warehouse_name as to_warehouse,w2.warehouse_code as to_warehouse_code  FROM inv_transfer t left outer join w_warehouse w1 on t.from_WID = w1.WID left outer join w_warehouse w2 on t.to_WID = w2.WID  " . $strAddQuery;

		return $this->query($strSQLQuery, 1);
	}

	function ListTransfer($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {



		$strAddQuery = '';
		$SearchKey = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id)) ? (" where a.id='" . $id."'") : (" where 1 ");
		//$strAddQuery .= (!empty($Status))?(" and w.Status='".$Status."'"):(" ");



		if ($SortBy == 'id') {
			$strAddQuery .= (!empty($SearchKey)) ? (" and (a.id = '" . $SearchKey . "')") : ("");
		} else {

			if ($SortBy != '') {
				$strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
			} else {
				$strAddQuery .= (!empty($SearchKey)) ? (" and ( a.transfer_reason like '%" . $SearchKey . "%' or  a.transferNo like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%'  ) " ) : ("");
			}
		}

		$strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.id ");
		$strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Asc");

		$strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType from inv_stock_transfer a left outer join  inv_items  i on i.Sku=a.Sku  " . $strAddQuery;




		return $this->query($strSQLQuery, 1);
	}

	function RemoveTransfer($id) {

		$strSQLQuery = "DELETE FROM inv_transfer WHERE transferID = '" . $id."'";
		$rs = $this->query($strSQLQuery, 0);

		$strSQLQuery2 = "DELETE FROM inv_stock_transfer WHERE transferID = '" . $id."'";
		$this->query($strSQLQuery2, 0);

		if (sizeof($rs))
		return true;
		else
		return false;
	}

	function GetAdjustment($AdjID, $Status) {
		$strAddQuery .= (!empty($AdjID)) ? (" and a.adjID='" . $AdjID."'") : ("");
		$strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : ("");

		$strSQLQuery = "select a.*, w.warehouse_name,w.WID,w.warehouse_code  from inv_adjustment a left outer join w_warehouse  w on BINARY w.warehouse_code = BINARY a.warehouse_code where 1" . $strAddQuery . " order by a.adjID desc";
		return $this->query($strSQLQuery, 1);
	}

	function AddTransfer($arryDetails) {
		global $Config;
		extract($arryDetails);

		if (empty($Currency))
		$Currency = $Config['Currency'];

		$strSQLQuery = "insert into inv_transfer(total_transfer_qty,total_transfer_value,to_WID,from_WID,transfer_reason,transferDate,created_by,created_id,Status)
                            values('" . $TotalQty . "', '" . $TotalValue . "',  '" . $to_WID . "', '" . $from_WID . "', '" . addslashes($transfer_reason) . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "')";

		$this->query($strSQLQuery, 0);
		$tranID = $this->lastInsertId();
		if ($tranID > 0) {
			$rs = $this->getPrefix(1);
			$PrefixAD = $rs[0]['ToP'];
			$ModuleIDValue = $PrefixAD . '000' . $tranID;
			$strSQL = "update inv_transfer set transferNo='" . $ModuleIDValue . "' where transferID='" . $tranID."'";
			$this->query($strSQL, 0);
		}

		return $tranID;
	}

	function UpdateTransfer($arryDetails) {
		global $Config;
		extract($arryDetails);



		/* if($Closed==1){
		 $Status="Closed"; $ClosedDate=$Config['TodayDate'];
		 }else{
		 $Status="In Process"; $ClosedDate='';
		 }
		 */

		$strSQLQuery = "update inv_transfer set total_transfer_qty='" . $TotalQty . "', total_transfer_value='" . $TotalValue . "', to_WID='" . $to_WID . "', from_WID='" . $from_WID . "', transfer_reason='" . addslashes($transfer_reason) . "', Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where transferID='" . $transferID."'";

		$this->query($strSQLQuery, 0);

		return 1;
	}

	function AddUpdateTransferStock($tID, $arryDetails) {
		global $Config;
		extract($arryDetails);


		if (!empty($DelItem)) {
			$strSQLQuery = "delete from inv_transfer_adjustment where id in(" . $DelItem . ")";
			$this->query($strSQLQuery, 0);
		}



		for ($i = 1; $i <= $NumLine; $i++) {

			if (!empty($arryDetails['sku' . $i])) {
				//$arryTax = explode(":",$arryDetails['tax'.$i]);

				$id = $arryDetails['id' . $i];
				if ($id > 0) {
					$sql = "update inv_stock_transfer set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', on_hand_qty='" . addslashes($arryDetails['on_hand_qty' . $i]) . "', price='" . addslashes($arryDetails['price' . $i]) . "', amount='" . addslashes($arryDetails['amount' . $i]) . "' ,`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "' where id=" . $id;
				} else {

					$sql = "insert into inv_stock_transfer (transferID, item_id, sku, description, on_hand_qty, qty, price, amount,valuationType,serial_value,`Condition`) values('" . $tID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['on_hand_qty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "')";
				}
				$this->query($sql, 0);
			}
		}

		return true;
	}

	function GetTransferStock($transferID) {
		$strAddQuery .= (!empty($transferID)) ? (" and transferID='" . $transferID."'") : ("");
		$strSQLQuery = "select * from inv_stock_transfer  where 1" . $strAddQuery . " order by id asc";
		return $this->query($strSQLQuery, 1);
	}

	function GetTransfer($transferID) {
		$strAddQuery .= (!empty($transferID)) ? (" and t.transferID='" . $transferID . "'") : ("");
		$strSQLQuery = "select t.*,  w1.warehouse_name as from_warehouse,w2.warehouse_code as from_warehouse_code,w2.warehouse_name as to_warehouse,w2.warehouse_code as to_warehouse_code  FROM inv_transfer t left outer join w_warehouse w1 on t.from_WID = w1.WID left outer join w_warehouse w2 on t.to_WID = w2.WID  where 1" . $strAddQuery . " order by t.transferID asc";
		return $this->query($strSQLQuery, 1);
	}

	function getTotalQtySum($ItemID) {

		$strSQLQuery = "Select SUM(qty) as totalQty from `inv_stock_adjustment`";
		$strSQLQuery .= "where 1";
		$strSQLQuery .= ($ItemID > 0) ? (" and `item_id` ='" . $ItemID . "'") : ("");


		$rs = $this->query($strSQLQuery, 1);
		if ($rs[0]['totalQty']) {
			return $rs[0]['totalQty'];
		}
	}

	function updateStockQty($arryDetails) {

		global $Config;
		extract($arryDetails);



		for ($i = 1; $i <= $NumLine; $i++) {

			if (!empty($arryDetails['item_id' . $i])) {


				$totalQTY = $this->getTotalQtySum($arryDetails['qty' . $i]);


				$id = $arryDetails['id' . $i];
				$sql = "update inv_items set qty_on_hand = qty_on_hand+'" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
				$this->query($sql, 0);
				/* if ($arryDetails['Status'] == 2) {
				 $sql = "update inv_items set qty_on_hand='" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
				 } else if ($arryDetails['Status'] == 1) {

				 $sql = "update inv_items set allocated_qty='" . $totalQTY . "'  where ItemID=" . $arryDetails['item_id' . $i];
				 } */
			}
		}




		//$exequery = mysql_fetch_array($strSQLQuery);
	}

	/*     * *************** End Transfer ********************** */

	function GetPurchasedPriceItem($sku) {
		$strAddQuery .= (!empty($sku)) ? (" and i.sku='" . $sku . "'") : ("");
		$strSQLQuery = "select o.SuppCode,o.SuppCompany,o.OrderID,o.PurchaseID,o.OrderDate,o.Currency, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved=1  and o.Module='Order' " . $strAddQuery . " order by o.OrderDate desc ";
		return $this->query($strSQLQuery, 1);
	}

	/* function GetPurchasePriceItem2($OrderID,$key) {

	//$strAddQuery .= (!empty($key))?(" and i.sku='".$key."'):("");
	//$strAddQuery .= (!empty($key))?(" and i.OrderID='".$key."'):("");
	$strSQLQuery = "select i.*,t.RateDescription,o.OrderDate,o.Currency from p_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join p_order o on i.OrderID=o.OrderID where 1" . $strAddQuery . " order by o.OrderDate desc";
	return $this->query($strSQLQuery, 1);
	} */

	function GetTransactionItem($item_id, $OrderID, $PurchaseID, $Module) {
		$strAddQuery .= (!empty($item_id)) ? (" and i.item_id='" . $item_id . "'") : ("");
		$strAddQuery .= (!empty($OrderID)) ? (" and o.OrderID='" . $OrderID."'") : ("");
		$strAddQuery .= (!empty($PurchaseID)) ? (" and o.PurchaseID='" . $PurchaseID . "'") : ("");
		//$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		$strSQLQuery = "select o.*, i.item_id,i.sku,i.qty,i.description,i.price from p_order o inner join p_order_item i on o.OrderID=i.OrderID where o.Status='Completed' and o.Approved=1 " . $strAddQuery . " order by o.OrderID desc ";
		return $this->query($strSQLQuery, 1);
	}


	function GetTransactionForSku($TransactionSku) {

		$strSQLQuery = "select * from inv_item_transaction where TransactionSku = '".$TransactionSku."' order by TransactionID desc";
		return $this->query($strSQLQuery, 1);
	}


	function addItemTransaction($arryTransaction,$arryDetails,$type){

		global $Config;
		extract($arryDetails);
		extract($arryTransaction);

		$DBName='';
		$EDICompName=$EDISalesCompName;
		if($EDIPurchaseCompName!='' && $type== 'PO') {
			$DBName='erp_'.$EDIPurchaseCompName.'.';
			$EDICompName=$EDIPurchaseCompName;
		}



		if($type == 'SO' || $type == 'PO'){

			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['qty'.$i])){

					$id = $arryDetails['id'.$i];

					$sql = "insert into ".$DBName."inv_item_transaction set TransactionOrderID = '".$TransactionOrderID."', TransactionInvoiceID='".$TransactionInvoiceID."', TransactionDate='".$TransactionDate."',TransactionType='".$TransactionType."', TransactionSku='".addslashes($arryDetails['sku'.$i])."',TransactionItemID='".$arryDetails['item_id'.$i]."',TransactionDescription='".addslashes($arryDetails['description'.$i])."',TransactionUnitPrice='".addslashes($arryDetails['price'.$i])."',TransactionCurrency='".$Config['Currency']."',TransactionQty='".addslashes($arryDetails['qty'.$i])."'";
					$this->query($sql, 0);


				}
			}

		}
			
		if($type == 'ASM' || $type == 'DSM'){

			if($type == 'ASM') $qty = $assembly_qty; else $qty = $disassembly_qty;
			$unitPrice = 0;
			$unitPrice = $TotalValue/$qty;
			$unitPrice = number_format($unitPrice,2,'.','');

			$sql = "insert into inv_item_transaction set TransactionOrderID = '".$TransactionOrderID."', TransactionInvoiceID='".$TransactionInvoiceID."', TransactionDate='".$TransactionDate."',TransactionType='".$TransactionType."', TransactionSku='".addslashes($Sku)."',TransactionItemID='".$item_id."',TransactionDescription='".addslashes($description)."',TransactionUnitPrice='".addslashes($unitPrice)."',TransactionCurrency='".$Config['Currency']."',TransactionQty='".addslashes($qty)."'";
			//exit;
			$this->query($sql, 0);


		}


	}

	/* * ***************************************** Quantity ********************* */

	function GetOrderdedQty($sku) {
		//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

		$sql = "select SUM(i.qty) as purchase_qty FROM p_order as o	inner join p_order_item as i on o.OrderID=i.OrderID	inner join inv_items as p on i.item_id = p.ItemID	where o.Status!='Completed' and	i.sku='" . $sku . "'";


		$rs = $this->query($sql);
		return $rs[0]['purchase_qty'];
	}

	function GetAdjustmentQty($sku) {
		//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

		$sql = "select SUM(i.qty) as adjust_qty FROM inv_adjustment as a inner join inv_stock_adjustment as i on a.adjID=i.adjID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '" . $sku . "' ";

		$rs = $this->query($sql);
		return $rs[0]['adjust_qty'];
	}

	function GetRecievedQty($sku) {
		//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

		$sql = "select SUM(i.qty_received) as qty_received FROM p_order as o	inner join p_order_item as i on o.OrderID=i.OrderID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '" . $sku . "' ";


		$rs = $this->query($sql);
		return $rs[0]['qty_received'];
	}

	function GetAssemblyQty($sku) {
		//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

		$sql = "select SUM(i.qty) as adjust_qty FROM inv_adjustment as a	inner join inv_stock_adjustment as i on a.adjID=i.adjID	inner join inv_items as p on i.item_id = p.ItemID	where	i.sku = '" . $sku . "' ";
		$rs = $this->query($sql);
		return $rs[0]['adjust_qty'];
	}

	function GetSaleOrderdedQty($sku) {
		//echo $sql = "select  SUM(i.qty) as purchase_qty from  p_order_item i  where  i.sku='".$sku."'";

		$sql = "select SUM(i.qty) as sales_qty FROM s_order as s	inner join s_order_item as i on s.OrderID=i.OrderID	where s.Status='Closed' and	i.sku='" . $sku . "'";


		$rs = $this->query($sql);
		return $rs[0]['sales_qty'];
	}

	/*     * ************************ End Quantity ************* */

	function AdjustmentReport($FilterBy, $FromDate, $ToDate, $Month, $Year, $warehouse_code, $Status) {


		$strAddQuery = "";
		if ($FilterBy == 'Year') {
			$strAddQuery .= " and YEAR(a.adjDate)='" . $Year . "'";
		} else {
			$strAddQuery .= (!empty($FromDate)) ? (" and a.adjDate>='" . $FromDate . "'") : ("");
			$strAddQuery .= (!empty($ToDate)) ? (" and a.adjDate<='" . $ToDate . "'") : ("");
		}



		$strAddQuery .= (!empty($warehouse_code)) ? (" and a.warehouse_code='" . $warehouse_code . "'") : ("");
		$strAddQuery .= ($Status >= 0) ? (" and a.Status='" . $Status . "'") : ("");

		$strSQLQuery = "select  a.adjDate,a.adjustNo,a.total_adjust_qty, a.adjID, a.warehouse_code,a.adjust_reason, a.total_adjust_value, a.total_adjust_qty, a.Status,w.warehouse_name,w.WID,w.warehouse_code  from inv_adjustment a left outer join w_warehouse  w on BINARY w.warehouse_code = BINARY a.warehouse_code where 1 " . $strAddQuery . " order by a.adjDate desc";

		return $this->query($strSQLQuery, 1);
	}

	function GetNumAdjByYear($FilterBy, $month, $Year, $FromDate, $ToDate, $warehouse_code, $Status) {

		$strAddQuery = "";


		$strAddQuery .= (!empty($FromDate)) ? (" and a.adjDate >= '" . $FromDate . "'") : ("");
		$strAddQuery .= (!empty($ToDate)) ? (" and a.adjDate <= '" . $ToDate . "'") : ("");

		$strAddQuery .= (!empty($warehouse_code)) ? (" and a.warehouse_code='" . $warehouse_code . "'") : ("");
		$strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : ("");

		$strSQLQuery = "select count(a.adjID) as TotalAdj  from inv_adjustment a where YEAR(a.adjDate)='" . $Year . "' " . $strAddQuery . " order by a.adjDate desc";

		return $this->query($strSQLQuery, 1);
	}

	function GetNumAdjByMonth($Year, $FromDate, $ToDate, $warehouse_code, $Status) {
		$strAddQuery = "";
		$strAddQuery .= (!empty($FromDate)) ? (" and a.adjDate = '" . $ToDate . "' ") : ("");
		$strAddQuery .= (!empty($Year)) ? (" and YEAR(a.adjDate)='" . $Year . "' ") : ("");
		$strAddQuery .= (!empty($warehouse_code)) ? (" and a.warehouse_code='" . $warehouse_code . "'") : ("");

		$strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : ("");

		$strSQLQuery = "select count(a.adjID) as TotalAdj  from inv_adjustment a where 1 " . $strAddQuery . " order by a.adjDate desc";
		//echo "=>".$strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	function TransferReport($FilterBy, $FromDate, $ToDate, $Month, $Year, $warehouse_code1, $warehouse_code2, $Status) {

		$strAddQuery = "";

		if ($FilterBy == 'Year') {
			$strAddQuery .= " and YEAR(t.transferDate)='" . $Year . "'";
		} else {
			$strAddQuery .= (!empty($FromDate)) ? (" and t.transferDate>='" . $FromDate . "'") : ("");
			$strAddQuery .= (!empty($ToDate)) ? (" and t.transferDate<='" . $ToDate . "'") : ("");
		}

		$strAddQuery .= (!empty($warehouse_code1)) ? (" and t.from_WID='" . $warehouse_code1 . "'") : ("");
		$strAddQuery .= (!empty($warehouse_code2)) ? (" and t.to_WID='" . $warehouse_code2 . "'") : ("");
		$strAddQuery .= ($Status >= 0) ? (" and t.Status='" . $Status . "'") : ("");

		$strSQLQuery = "select  t.transferDate,t.transferNo,t.total_transfer_qty, t.transferID, t.from_WID,t.to_WID,t.transfer_reason, t.total_transfer_value, t.Status,w1.warehouse_code as from_warehouse,w1.warehouse_name as from_warehouse_name,w1.WID,w2.warehouse_code as to_warehouse,w2.warehouse_name as to_warehouse_name,w2.WID from inv_transfer t inner join w_warehouse w1 on w1.WID=t.from_WID inner join  w_warehouse w2  on w2.WID=t.to_WID  where 1 " . $strAddQuery . " order by t.transferDate desc";

		return $this->query($strSQLQuery, 1);
	}

	function ExportItem() {
		$strSQLQuery = "SELECT * FROM inv_items ORDER BY ItemID ASC";
		return $this->query($strSQLQuery);
	}

	/*     * *************ITEM ALIAS***************** */

	function GetAliasbySku($sku) {
		$strSQLQuery = "SELECT * FROM inv_item_alias ";
		$strSQLQuery .= (!empty($sku)) ? (" where sku = '" . $sku . "'") : ("");
		$strSQLQuery .="  ORDER BY AliasID ASC";
		#echo $strSQLQuery;
		return $this->query($strSQLQuery);
	}

	function UpdateAliasItem($arryDetails) {

		extract($arryDetails);

		$strSQLQuery = "update inv_item_alias set ItemAliasCode = '" . addslashes($ItemAliasCode) . "', description='" . addslashes($description) . "', Manufacture='" . addslashes($Manufacture) . "', sku='" . addslashes($Sku) . "', item_id='" . addslashes($item_id) . "' where AliasID='" . $AliasID . "'";

		$this->query($strSQLQuery, 0);


		return 1;
	}

	function AddAliasItem($arryDetails) {

		extract($arryDetails);

		$strSQLQuery = "insert inv_item_alias (ItemAliasCode, description, sku, item_id, Manufacture)
		                 values ('" . mysql_real_escape_string(strtoupper($ItemAliasCode)) . "','" . addslashes($description) . "','" . addslashes($Sku) . "','" . $item_id . "', '" . addslashes($Manufacture) . "')";

		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();

		return $lastInsertId;
	}

	function GetAliasItem($AliasID) {
		$strSQLQuery = "SELECT * FROM inv_item_alias ";
		$strSQLQuery .= (!empty($AliasID)) ? (" where AliasID = '" . $AliasID . "'") : ("");
		#echo $strSQLQuery;
		return $this->query($strSQLQuery);
	}

	function RemoveAlias($AliasID) {
		$strSQLQuery = "delete from inv_item_alias where AliasID='" . $AliasID . "'";
		$this->query($strSQLQuery, 0);
	}

	/*     * *************FINISH********************* */


	/*     * ************** Sales Order ************* */

	function GetSOHistory($sku, $Status, $numHistory) {
		$strAddQuery = "";
		$strAddQuery .= ($numHistory == '1year') ? (" AND s_order.OrderDate >= DATE_SUB(NOW(),INTERVAL 1 YEAR)") : ("");
		$strAddQuery .= ($numHistory == '6month') ? (" AND s_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)") : ("");
		$strAddQuery .= ($numHistory == '30d') ? (" AND s_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)") : ("");
		$strAddQuery .= ($numHistory == '7d') ? (" AND s_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)") : ("");
		$strAddQuery .= (!empty($Status)) ? (" and s_order.Status='" . $Status . "'") : ("");
		$strAddQuery .= (!empty($sku)) ? (" and s_order_item.sku='" . $sku . "'") : ("");

		$strSQLQuery = "SELECT s_order_item. * ,s_order.CustomerName,s_order.CustCode, s_order.OrderID, s_order.OrderDate, s_order.SaleID, s_order.Module
				FROM s_order_item s_order_item
				LEFT OUTER JOIN s_order s_order ON s_order.OrderID = s_order_item.OrderID
				WHERE s_order.Module = 'Order'
				
				 " . $strAddQuery . "
				ORDER BY s_order_item.OrderID DESC";
		#echo "=>".$strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}

	/* function CountSo($sku,$din){
	 $strSQLQuery = "SELECT SUM( qty ) AS totalso FROM `s_sale_item` WHERE 1 AND sku = '".$sku."' AND ";
	 $rs = $this->query($strSQLQuery);
	 if (sizeof($rs)) {
	 if ($rs[0]['totalPo'] > 0){
	 return $rs[0]['totalPo'];
	 } else{
	 return 0;
	 }
	 }

	 } */

	function GetPOHistory($sku, $Status, $numHistory) {
		$strAddQuery = "";
		$strAddQuery .= ($numHistory == '1year') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(),INTERVAL 1 YEAR)") : ("");
		$strAddQuery .= ($numHistory == '6month') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)") : ("");
		$strAddQuery .= ($numHistory == '30d') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 30 DAY)") : ("");
		$strAddQuery .= ($numHistory == '7d') ? (" AND p_order.OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)") : ("");
		$strAddQuery .= (!empty($Status)) ? (" and p_order.Status='" . $Status . "'") : ("");
		$strAddQuery .= (!empty($sku)) ? (" and p_order_item.sku='" . $sku . "'") : ("");

		$strSQLQuery = "SELECT p_order_item. * ,p_order.SuppCompany,p_order.SuppCode, p_order.OrderID, p_order.OrderDate,  p_order.PurchaseID, p_order.Module
			FROM p_order_item p_order_item
			LEFT OUTER JOIN p_order p_order ON p_order.OrderID = p_order_item.OrderID
			WHERE p_order.Module = 'Order'

			" . $strAddQuery . "
			Group BY p_order_item.OrderID DESC";
		#echo "=>".$strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);
	}


	function NextPrevItem($ItemID,$Next) {
		global $Config;
		if($ItemID>0){


			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select i.ItemID,i.CategoryID  from inv_items i where i.ItemID".$operator."'" . $ItemID . "'  ". $strAddQuery. " order by i.ItemID ".$asc." limit 0,1";

			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow;
		}
	}



	function isSerialExists($Serial_No,$id)
	{
		$strSQLQuery = "select serialID from inv_serial_item where LCASE(serialNumber)='" . strtolower(trim($Serial_No)) . "'";
		$strSQLQuery .= ($id > 0) ? (" and serialID != '" . $id . "'") : ("");
		$arryRow = $this->query($strSQLQuery, 1);
		if ($arryRow[0]['serialID'] > 0)
		{
			return 1;
		} else {
			return 0;
		}
	}


	function GetGenrationBasedOnModel($ModelId)
	{
		if(!empty($ModelId)){
			$strSQLQuery = "Select id,Generation from inv_ModelGen where id IN($ModelId) order by Generation asc";

	 	return  $this->query($strSQLQuery, 1);
		}
	}



	function isSkuTransactionExist($Sku){
		$Sku = strtolower(trim($Sku));

		$AsmSql = "select 'Sku' as SkuCode from inv_assembly where Sku = '".$Sku."' limit 0,1";
		$BomSql = "select 'Sku' as SkuCode from inv_bill_of_material where Sku = '".$Sku."' limit 0,1";
		$BinSql = "select 'Sku' as SkuCode from inv_bin_stock where Sku = '".$Sku."' limit 0,1";
		$DisSql = "select 'Sku' as SkuCode from inv_disassembly where Sku = '".$Sku."' limit 0,1";
		$AsmSql = "select 'sku' as SkuCode from inv_item_assembly where sku = '".$Sku."' limit 0,1";
		$ItBomSql = "select 'sku' as SkuCode from inv_item_bom where sku = '".$Sku."' limit 0,1";
		$ItDisSql = "select 'sku' as SkuCode from inv_item_disassembly where sku = '".$Sku."' limit 0,1";
		$StkSql = "select 'sku' as SkuCode from inv_stock_transfer where sku = '".$Sku."' limit 0,1";
		$StkAdjSql = "select 'sku' as SkuCode from inv_stock_adjustment where sku = '".$Sku."' limit 0,1";

		$strSQLQuery = "(".$AsmSql.") UNION (".$BomSql.") UNION (".$BinSql.") UNION (".$DisSql.") UNION (".$AsmSql.") UNION (".$ItBomSql.") UNION (".$ItDisSql.") UNION (".$StkSql.") UNION (".$StkAdjSql.") ";
		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['SkuCode'])) {
			return true;
		}else{
			return false;
		}
	}


	function isChildCategoryExist($CategoryID){
		//$Sku = strtolower(trim($Sku));

		$CatSql = "select 'CategoryID' as CatID from inv_items where CategoryID = '".$CategoryID."' limit 0,1";


		$strSQLQuery = "(".$CatSql.")  ";
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['CatID'])) {
			return true;
		}else{
			return false;
		}
	}




	function isCategoryTransactionExist($CategoryID){
		//$Sku = strtolower(trim($Sku));

		$CatSql = "select 'CategoryID' as CatID from inv_items where CategoryID = '".$CategoryID."' limit 0,1";


		$strSQLQuery = "(".$CatSql.")  ";
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['CatID'])) {
			return true;
		}else{
			return false;
		}
	}


	function isCategoryTransactionExist2($CategoryID){
		//$Sku = strtolower(trim($Sku));

		#$CatSql = "select 'CategoryID' as CatID from inv_items where CategoryID = '".$CategoryID."' limit 0,1";
		$sql = "select p.ItemID from inv_items p
inner join inv_categories sc on sc.ParentID = p.CategoryID
inner join `inv_categories` c on c.CategoryID = p.CategoryID where p.CategoryID = '".$CategoryID."' ";

		#$strSQLQuery = "(".$CatSql.")  ";
		$arryRow = $this->query($sql, 1);



		if (!empty($arryRow[0]['ItemID'])) {
			return true;
		}else{
			return false;
		}
	}

	function checkSubCatByTran($CategoryID){

		$strSQLQuery = "SELECT CategoryID FROM `inv_categories` WHERE `ParentID`='".$CategoryID."'";

		return $this->query($strSQLQuery, 1);
	}
	/*

	function checkSubCatByTran($CategoryID){

	$query = "SELECT * FROM inv_categories WHERE ParentID ='".$CategoryID."'";

	$rs = $this->query($strSQLQuery, 1);
	if(is_array($rs)){
	foreach ($rs as $key => $SubValues) {
	if(!$this->isCategoryTransactionExist($SubValues['CategoryID'])){

	return 1;

	}else{
	return 0;
	}
	if($SubValues['ParentID'] > 0)
	{
	$this->checkSubCatByTran($SubValues['CategoryID']);
	}
	}
	}
	}
	*/
	//By Chetan//
	function UpdateShoworNoComponentItem($arryDetails) {
		extract($arryDetails);

		$strSQLQuery = "update inv_items set showcomponent = '" . $compnent_show . "' where ItemID='" . $ItemID . "'";
		$this->query($strSQLQuery, 0);

		return 1;
	}
	//End//

	///Update bu bh


	function parseOptions($options)
	{
		return explode("\n", $options);
	}
	//By Chetan21Aug//
	function addCrmItems($arryDetails)
	{
		extract($arryDetails);
		$objField = new field();
		$arryflds=$objField->getAllCustomFieldByModuleID(2003);
		$arry = array_map(function($arr){
			if($arr['editable']==1){
				return $arr['fieldname'];
			}else{
				unset($arr);
			}
		},$arryflds);
		$arryflds = array_values(array_filter($arry));
		foreach($arryflds as $key)
		{
			$str.= "$key='".$arryDetails[$key]."'".',';
		}
		$strSQLQuery = "insert into inv_items set ".$str." long_description ='" . addslashes($long_description) . "' ,Status = '" . $Status . "', AddedDate ='" . date('Y-m-d') . "' ,
            Sku = '" . addslashes($Sku) . "',sell_price ='" . addslashes($sell_price) . "' , qty_on_hand = '" . addslashes($qty_on_hand) ."',description ='" . addslashes($description) . "'  ";
		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();

		return $lastInsertId;

	}

	//By Chetan 9sep//
	function checkItemAliasSku($Sku) {
		$strSQLQuery = "select ItemAliasCode,AliasID,sku,description,item_id from inv_item_alias where LOWER(ItemAliasCode) = '" . strtolower($Sku) . "'";
		return $this->query($strSQLQuery, 1);
	}
	//By Chetan 9sep//
	function getAliasRequiredItemByIds($ItemId,$AlaisId)
	{
		$strSQLQuery2 = "select ir.item_id,i.ItemID,i.description,i.sku,i.qty_on_hand from inv_item_required ir left join inv_items i on ir.item_id = i.ItemID where ir.ItemID = '".$ItemId."' and ir.AliasID = '" . $AlaisId . "' ";
		return $this->query($strSQLQuery2, 1);
	}

	//End//




	/*******************Function Sync Items***************************************/



	// Inventory to E-Commerce
	// E-Commerce to Inventory
	// both

	function sync_items($ItemsArray){


		if($ItemsArray['ItemID']){

			if($ItemsArray['synctypeselected']=='all'){
				$strSQLQuery = "select ItemID from inv_items order by ItemID asc ";
				$res=$this->query($strSQLQuery, 1);
				foreach($res as $items){
					$SyncItemsArray['ItemID'][]=$items['ItemID'];
				}
			}else{
				foreach($ItemsArray['ItemID'] as $items){
					$SyncItemsArray['ItemID'][]=$items;
				}
			}

		}

		if($ItemsArray['ProductID']){
			if($ItemsArray['synctypeselected']=='all'){
				$strSQLQuery = "select ProductID from e_products order by ProductID asc ";
				$res=$this->query($strSQLQuery, 1);
				foreach($res as $items){
					$SyncItemsArray['ItemID'][]=$items['ProductID'];
				}
			}else{
				foreach($ItemsArray['ProductID'] as $items){
					$SyncItemsArray['ItemID'][]=$items;
				}
			}

		}



		$sync_items = $_SESSION['sync_items'];

		switch ($sync_items) {
			case I2E:
				// code for Inventory to e-commerce

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Item.* from inv_items as Item
					left join inv_item_images ItemImages on ItemImages.ItemID=Item.ItemID
					where Item.ItemID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					$this->syncFromInventory($ItemsArray);



				}
				/*********end **********/

				break;
			case E2I:
				// code for e-commerce  to Inventory

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Products.* from e_products as Products
					left join e_products_images ProductsImages on ProductsImages.ProductID=Products.ProductID
					where Products.ProductID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);

					$this->syncFromEcommerce($ItemsArray);



				}
				/*********end **********/

				break;
			case both:
				// code for both
				// code for Inventory to e-commerce

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Item.* from inv_items as Item
					left join inv_item_images ItemImages on ItemImages.ItemID=Item.ItemID
					where Item.ItemID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);
					if($ItemsArray){
					 $this->syncFromInventory($ItemsArray);
					}


				}
				/*********end **********/

				// code for e-commerce  to Inventory

				foreach($SyncItemsArray['ItemID'] as $items){
					$sql = "select Products.* from e_products as Products
					left join e_products_images ProductsImages on ProductsImages.ProductID=Products.ProductID
					where Products.ProductID='".addslashes($items)."'"; 
					$ItemsArray = $this->query($sql, 1);
					if($ItemsArray){
					 $this->syncFromEcommerce($ItemsArray);
					}


				}
				/*********end **********/

				break;

		}
			
	}

	function checkSkuExist($Sku,$table,$field,$selectedFieldId){
		$sql = "select count(*) as total,".$selectedFieldId." from ".$table." where  ".$field."= '".addslashes($Sku)."' ";
		$ItemsAvail = $this->query($sql, 1);
		if($ItemsAvail[0]['total']==0){
			return '0';
		}
		return $ItemsAvail[0][$selectedFieldId];
			
	}

	function syncFromInventory($ItemsArray){

		$ItemID=$ItemsArray[0]['ItemID'];
		$Sku=$ItemsArray[0]['Sku'];
		$CategoryID=$ItemsArray[0]['CategoryID'];
		$description=$ItemsArray[0]['description'];
		$long_description=$ItemsArray[0]['long_description'];
		$Manufacture=$ItemsArray[0]['Manufacture'];
		$sell_price=$ItemsArray[0]['sell_price'];
		$Taxable=$ItemsArray[0]['Taxable'];
		$sale_tax_rate=$ItemsArray[0]['sale_tax_rate'];
		$weight=$ItemsArray[0]['weight'];
		$Image=$ItemsArray[0]['Image'];
		$Quantity=$ItemsArray[0]['qty_on_hand'];
		$VariantId=$ItemsArray[0]['variant_id'];

		$AddedDate=date('Y-m-d');


		$is_exist=$this->checkSkuExist($Sku,'e_products','ProductSku','ProductID');


		// get manufacturer id by name beacuse inventory has varchar field type
		if($Manufacture!=''){
			$sql = "select * from e_manufacturers where  Mname= '".addslashes($Manufacture)."' limit 1 ";
			$ManufactureRes = $this->query($sql, 1);
			if($ManufactureRes){
				// if manufacturer available
				$Mid=$ManufactureRes[0]['Mid'];
			}else{
				// create new manufacturer
				$sql="insert into e_manufacturers set Mname='".addslashes($Manufacture)."', Status='1' ";
				$this->query($sql,0);
				$Mid=$this->lastInsertId();
				$sql="update e_manufacturers set Mcode='".addslashes($Mid)."' where Mid='".addslashes($Mid)."' ";
				$this->query($sql,0);
			}
		}
			


		/*******************
		 * Check category sync
		 *
		 */
		if($CategoryID!='0'){
			$sql = "select CategoryID from e_categories where item_categoryId= '".addslashes($CategoryID)."' limit 1 ";
			$CategoryRes = $this->query($sql, 1);

			if($CategoryRes){
				// if category already sync
				$CategoryID=$CategoryRes[0]['CategoryID'];
			}else{
				// get parent category id

				if($this->checkCategoryExist($CategoryID,'inv_categories')){
					$MainCategoryId=$this->getParentCategoryId($CategoryID,'inv_categories');

					$catArray['Category']=json_encode(array($MainCategoryId));

					$this->syncCategorytoEcommerce($catArray);

					$sql = "select CategoryID from e_categories where item_categoryId= '".addslashes($CategoryID)."' limit 1 ";
					$CategoryRes = $this->query($sql, 1);
					$CategoryID=$CategoryRes[0]['CategoryID'];
				}else{
					$CategoryID=0;
				}
			}

			// end
		}

		if($is_exist=='0'){

			/***********insert new item************/



			$sql="insert into e_products set Name='".addslashes($description)."' , ProductSku='".addslashes($Sku)."' ,
				Detail='".addslashes($long_description)."' ,ShortDetail='".addslashes($description)."' ,
				Price='".addslashes($sell_price)."' ,InventoryControl='Yes' ,
				IsTaxable='".addslashes($Taxable)."' ,TaxRate='".addslashes($sale_tax_rate)."' ,
				Weight='".addslashes($weight)."' , Image='".addslashes($Image)."' ,
				AddedDate='".addslashes($AddedDate)."'  ,Quantity='".addslashes($Quantity)."' ,
				Status='1',variant_id='".addslashes($VariantId)."' , CategoryID= '".addslashes($CategoryID)."', Mid= '".addslashes($Mid)."'";
			$this->query($sql,0);
			$lastInsertItemId=$this->lastInsertId();


			/***************add multiple image**************/
			$sql = "select * from inv_item_images where  ItemID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];

				$sql="insert into e_products_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ProductID ='".addslashes($lastInsertItemId)."'";
				$this->query($sql,0);
			}

			// end
			/***************add alias**************/
			$sql = "select * from inv_item_alias where  item_id= '".addslashes($ItemID)."' ";
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['sku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];

				$sql="insert into e_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					ProductSku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					ProductID='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
				$this->query($sql,0);
			}

			// end




		}
		else {

			// update old item
			$lastInsertItemId=$is_exist;
			$sql="update e_products set Name='".addslashes($description)."' ,
				Detail='".addslashes($long_description)."' ,ShortDetail='".addslashes($description)."' ,
				Price='".addslashes($sell_price)."' ,InventoryControl='Yes' ,
				IsTaxable='".addslashes($Taxable)."' ,TaxRate='".addslashes($sale_tax_rate)."' ,
				Weight='".addslashes($weight)."' , Image='".addslashes($Image)."' ,
				AddedDate='".addslashes($AddedDate)."'  ,Status='1' , variant_id='".addslashes($VariantId)."' ,
				CategoryID= '".addslashes($CategoryID)."',Mid= '".addslashes($Mid)."'
				where ProductSku='".addslashes($Sku)."' ";
			$this->query($sql,0);

			/***************add multiple image**************/
			$sql = "select * from inv_item_images where  ItemID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];
				$sql = "select count(*) as total from e_products_images where  ProductID= '".addslashes($lastInsertItemId)."'
				and Image= '".addslashes($Image)."'  ";
				$ExistImageArray = $this->query($sql, 1);
				if($ExistImageArray[0]['total']=='0'){
					$sql="insert into e_products_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ProductID ='".addslashes($lastInsertItemId)."'";
					$this->query($sql,0);
				}

			}

			// end


			/***************add Alias**************/
			$sql = "select * from inv_item_alias where  item_id= '".addslashes($ItemID)."' ";
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['sku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];

				$sql = "select count(*) as total from e_item_alias where  ProductID= '".addslashes($lastInsertItemId)."'
				and ItemAliasCode= '".addslashes($ItemAliasCode)."'  ";
				$ExistAliasArray = $this->query($sql, 1);
				if($ExistAliasArray[0]['total']=='0'){
					$sql="insert into e_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					ProductSku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					ProductID='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
					$this->query($sql,0);
				}else{
					$sql="update e_item_alias set ProductSku='".addslashes($ItemAliassku)."' ,
					VendorCode ='".addslashes($ItemAliasVendorCode)."',	description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."'
					 where  ProductID= '".addslashes($lastInsertItemId)."' and ItemAliasCode= '".addslashes($ItemAliasCode)."' ";
					$this->query($sql,0);
				}

			}



			// end


		}

	}
	function syncFromEcommerce($ItemsArray){

		$ItemID=$ItemsArray[0]['ProductID'];
		$Sku=$ItemsArray[0]['ProductSku'];
		$CategoryID=$ItemsArray[0]['CategoryID'];
		$description=$ItemsArray[0]['Name'];
		$long_description=$ItemsArray[0]['Detail'];
		$Mid=$ItemsArray[0]['Mid'];
		$sell_price=$ItemsArray[0]['Price'];
		$Taxable=$ItemsArray[0]['IsTaxable'];
		$sale_tax_rate=$ItemsArray[0]['TaxRate'];
		$weight=$ItemsArray[0]['Weight'];
		$Image=$ItemsArray[0]['Image'];
		$Quantity=$ItemsArray[0]['Quantity'];
		$VariantId=$ItemsArray[0]['variant_id'];
		$AddedDate=date('Y-m-d');


		$is_exist=$this->checkSkuExist($Sku,'inv_items','Sku','ItemID');

		// get manufacturer id by id beacuse product has int field type

		$sql = "select * from e_manufacturers where  Mid= '".addslashes($Mid)."' limit 1 ";
		$ManufactureRes = $this->query($sql, 1);
		$Manufacture=$ManufactureRes[0]['Mname'];


		/*******************
		 * Check category sync
		 *
		 */
		if($CategoryID!='0'){
			$sql = "select CategoryID from inv_categories where e_categoryId= '".addslashes($CategoryID)."' limit 1 ";
			$CategoryRes = $this->query($sql, 1);

			if($CategoryRes){
				// if category already sync
				$CategoryID=$CategoryRes[0]['CategoryID'];
			}else{
				// get parent category id
				if($this->checkCategoryExist($CategoryID,'e_categories')){
					$MainCategoryId=$this->getParentCategoryId($CategoryID,'e_categories');

					$catArray['Category']=json_encode(array($MainCategoryId));

					$this->syncCategorytoInventory($catArray);
					$sql = "select CategoryID from inv_categories where e_categoryId= '".addslashes($CategoryID)."' limit 1 ";
					$CategoryRes = $this->query($sql, 1);
					$CategoryID=$CategoryRes[0]['CategoryID'];
				}else{
					$CategoryID=0;
				}
			}

			// end

		}
		if($is_exist=='0'){

			/***********insert new item************/

			$sql="insert into inv_items set description='".addslashes($description)."' ,
				Sku='".addslashes($Sku)."' ,long_description='".addslashes($long_description)."' ,
				sell_price='".addslashes($sell_price)."' ,Taxable='".addslashes($Taxable)."' ,
				sale_tax_rate='".addslashes($sale_tax_rate)."' ,weight='".addslashes($weight)."' , 
				Image='".addslashes($Image)."' , Manufacture='".addslashes($Manufacture)."' ,
				AddedDate='".addslashes($AddedDate)."' ,qty_on_hand='".addslashes($Quantity)."' ,
				Status='1' ,variant_id='".addslashes($VariantId)."' ,
				CategoryID= '".addslashes($CategoryID)."'";
			$this->query($sql,0);
			$lastInsertItemId=$this->lastInsertId();

			/***************add multiple image**************/
			$sql = "select * from e_products_images where  ProductID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];

				$sql="insert into inv_item_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ItemID ='".addslashes($lastInsertItemId)."'";
				$this->query($sql,0);
			}

			// end

			/***************add alias**************/
			$sql = "select * from e_item_alias where ProductID = '".addslashes($ItemID)."' ";
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['ProductSku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];

				$sql="insert into inv_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					sku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					item_id='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
				$this->query($sql,0);
			}

			// end

		}
		else {

			// update old item
			$lastInsertItemId=$is_exist;
			$sql="update inv_items set description='".addslashes($description)."' ,
						long_description='".addslashes($long_description)."' ,
						sell_price='".addslashes($sell_price)."' ,Taxable='".addslashes($Taxable)."' ,
						sale_tax_rate='".addslashes($sale_tax_rate)."' ,weight='".addslashes($weight)."' , 
						Image='".addslashes($Image)."' , Manufacture='".addslashes($Manufacture)."' ,
						AddedDate='".addslashes($AddedDate)."' ,Status='1' ,variant_id='".addslashes($VariantId)."' ,
						CategoryID= '".addslashes($CategoryID)."'
						where Sku='".addslashes($Sku)."' ";
			$this->query($sql,0);


			/***************add multiple image**************/
			$sql = "select * from e_products_images where  ProductID= '".addslashes($ItemID)."' ";
			$AllImageArray = $this->query($sql, 1);

			foreach($AllImageArray as $imageArray){
				$Image=$imageArray['Image'];
				$alt_text=$imageArray['alt_text'];
				$sql = "select count(*) as total from inv_item_images where  ItemID= '".addslashes($lastInsertItemId)."'
				and Image= '".addslashes($Image)."'  ";
				$ExistImageArray = $this->query($sql, 1);
				if($ExistImageArray[0]['total']=='0'){
					$sql="insert into inv_item_images set Image='".addslashes($Image)."' ,
					alt_text='".addslashes($alt_text)."' ,ItemID ='".addslashes($lastInsertItemId)."'";
					$this->query($sql,0);
				}

			}

			// end
			/***************add Alias**************/
			$sql = "select * from e_item_alias where ProductID = '".addslashes($ItemID)."' ";
			$AllAliasArray = $this->query($sql, 1);

			foreach($AllAliasArray as $aliasArray){
				$ItemAliasCode=$aliasArray['ItemAliasCode'];
				$ItemAliassku=$aliasArray['ProductSku'];
				$ItemAliasVendorCode=$aliasArray['VendorCode'];
				$ItemAliasdescription=$aliasArray['description'];
				$ItemAliasAliasType=$aliasArray['AliasType'];
				$ItemAliasManufacture=$aliasArray['Manufacture'];
				$sql = "select count(*) as total from inv_item_alias where  item_id= '".addslashes($lastInsertItemId)."'
				and ItemAliasCode= '".addslashes($ItemAliasCode)."'  ";
				$ExistAliasArray = $this->query($sql, 1);
				if($ExistAliasArray[0]['total']=='0'){
					$sql="insert into inv_item_alias set ItemAliasCode='".addslashes($ItemAliasCode)."' ,
					sku='".addslashes($ItemAliassku)."' ,VendorCode ='".addslashes($ItemAliasVendorCode)."',
					item_id='".addslashes($lastInsertItemId)."' ,description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' ";
					$this->query($sql,0);
				}
				else{
					$sql="update inv_item_alias set sku='".addslashes($ItemAliassku)."' ,
					VendorCode ='".addslashes($ItemAliasVendorCode)."',	description ='".addslashes($ItemAliasdescription)."',
					AliasType='".addslashes($ItemAliasAliasType)."' ,Manufacture ='".addslashes($ItemAliasManufacture)."' 
					 where  item_id= '".addslashes($lastInsertItemId)."' and ItemAliasCode= '".addslashes($ItemAliasCode)."' ";
					$this->query($sql,0);
				}

			}

			// end

		}

	}



	function syncCategorytoEcommerce($get) {
		$catIds = json_decode(stripslashes($get['Category']));

		if(count($catIds))
		{
			$this->insertData = array();
			$this->updateData = array();
			foreach ($catIds as $id)
			{
				$strSQLQuery5 = "select count(*) count from e_categories where item_categoryId =".$id."";
				$res = $this->query($strSQLQuery5, 1);
				if($res[0]['count'] == 1){
					array_push($this->updateData, (array('CategoryID' => $id, 'ParentID' => 0)));
					$this->getAllDataFromInventory($id,2);
				}else{

					array_push($this->insertData, (array('CategoryID' => $id, 'ParentID' => 0)));

					$this->getAllDataFromInventory($id,1);
				}
			}


			for ($i = 0; $i < sizeOf($this->insertData); $i++) {

				$strSQLQuery = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->insertData[$i]['CategoryID'] . "";
				$this->query($strSQLQuery, 1);
				for ($j = 0; $j < sizeOf($this->insertData); $j++) {
					$this->insertData[$j]['ParentID'] = ($this->insertData[$j]['ParentID'] == $this->insertData[$i]['CategoryID']) ? $this->lastInsertId() : $this->insertData[$j]['ParentID'];
				}
			}



			for ($k = 0; $k < sizeOf($this->updateData); $k++)
			{
				if($this->updateData[$k]['ParentID'] == 0)
				{

					$this->updateSynCatDatatoEcommerce($this->updateData[$k]['CategoryID']);

				}else{

					$SQLQuery5 = "select count(*) count from e_categories where item_categoryId =".$this->updateData[$k]['CategoryID']."";
					$res5 = $this->query($SQLQuery5, 1);

					if($res5[0]['count'] == 1)
					{

						$this->updateSynCatDatatoEcommerce($this->updateData[$k]['CategoryID']);

					}else{

						$strSqlQuery3 = "select CategoryID from e_categories where item_categoryId =".$this->updateData[$k]['ParentID']."";
						$resPCatID = $this->query($strSqlQuery3, 1);

						$strSqlQuery4 = "INSERT INTO e_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,item_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from inv_categories WHERE CategoryID = " . $this->updateData[$k]['CategoryID'] . "";
						$this->query($strSqlQuery4, 1);

					}


				}

			}

		}
	}


	function syncCategorytoInventory($get) {
		$catIds = json_decode(stripslashes($get['Category']));
		if(count($catIds))
		{
			$this->insertData = array();
			$this->updateData = array();
			foreach ($catIds as $id)
			{
				$strSQLQuery5 = "select count(*) count from inv_categories where e_categoryId =".$id."";
				$res = $this->query($strSQLQuery5, 1);
				if($res[0]['count'] == 1){
					array_push($this->updateData, (array('CategoryID' => $id, 'ParentID' => 0)));
					$this->getAllDataFromEcommerce($id,2);
				}else{
					array_push($this->insertData, (array('CategoryID' => $id, 'ParentID' => 0)));
					$this->getAllDataFromEcommerce($id,1);
				}
			}


			for ($i = 0; $i < sizeOf($this->insertData); $i++) {
				$added = date("Y-m-d");
				$strSQLQuery = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                   select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $this->insertData[$i]['ParentID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->insertData[$i]['CategoryID']." from e_categories WHERE CategoryID = " . $this->insertData[$i]['CategoryID'] . "";
				$this->query($strSQLQuery, 1);
				for ($j = 0; $j < sizeOf($this->insertData); $j++) {
					$this->insertData[$j]['ParentID'] = ($this->insertData[$j]['ParentID'] == $this->insertData[$i]['CategoryID']) ? $this->lastInsertId() : $this->insertData[$j]['ParentID'];
				}
			}

			for ($k = 0; $k < sizeOf($this->updateData); $k++)
			{
				if($this->updateData[$k]['ParentID'] == 0)
				{

					$this->updateSynCatDatatoInventory($this->updateData[$k]['CategoryID']);

				}else{

					$SQLQuery5 = "select count(*) count from inv_categories where e_categoryId =".$this->updateData[$k]['CategoryID']."";
					$res5 = $this->query($SQLQuery5, 1);

					if($res5[0]['count'] == 1)
					{

						$this->updateSynCatDatatoInventory($this->updateData[$k]['CategoryID']);

					}else{

						$strSqlQuery3 = "select CategoryID from inv_categories where e_categoryId =".$this->updateData[$k]['ParentID']."";
						$resPCatID = $this->query($strSqlQuery3, 1);

						$strSqlQuery4 = "INSERT INTO inv_categories (`Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`,`ParentID`,`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,`AddedDate`,`code`,e_categoryId)
                                       select `Name`,`MetaTitle`,`MetaKeyword`,`MetaDescription`,`CategoryDescription`,`Image`," . $resPCatID[0]['CategoryID'] . ",`Level`,`Status`,`NumSubcategory`,`NumProducts`,`sort_order`,CURDATE(),`code`,".$this->updateData[$k]['CategoryID']." from e_categories WHERE CategoryID = " . $this->updateData[$k]['CategoryID'] . "";
						$this->query($strSqlQuery4, 1);

					}


				}

			}
		}
	}

	function getAllDataFromInventory($parentId, $do) {
			
		$query = mysql_query("select CategoryID,ParentID from inv_categories where ParentID In(" . $parentId . ")");
		while ($row = mysql_fetch_assoc($query)) {
			($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
			$this->getAllDataFromInventory($row['CategoryID']);
		}

	}


	function getAllDataFromEcommerce($parentId, $do) {
		$query = mysql_query("select CategoryID,ParentID from e_categories where ParentID In(" . $parentId . ")");
		while ($row = mysql_fetch_assoc($query)) {
			($do == 1) ? array_push($this->insertData, $row) : array_push($this->updateData, $row);
			$this->getAllDataFromEcommerce($row['CategoryID']);
		}
	}

	function updateSynCatDatatoEcommerce($ID)
	{
		$strSqlQuery2 = "update e_categories ecat,(select * from inv_categories where CategoryID = ".$ID.") old
                                        set ecat.Name               = old.Name,
                                            ecat.MetaTitle          = old.MetaTitle,
                                            ecat.MetaKeyword        = old.MetaKeyword,
                                            ecat.MetaDescription    = old.MetaDescription,
                                            ecat.CategoryDescription = old.CategoryDescription,
                                            ecat.Image              = old.Image,
                                            ecat.NumSubcategory     = old.NumSubcategory, 
                                            ecat.NumProducts        = old.NumProducts
                                        where item_categoryId = ".$ID; 
		$result = $this->query($strSqlQuery2, 1);
	}

	function updateSynCatDatatoInventory($ID)
	{
		$strSqlQuery2 = "update inv_categories ecat,(select * from e_categories where CategoryID = ".$ID.") old
                                        set ecat.Name               = old.Name,
                                            ecat.MetaTitle          = old.MetaTitle,
                                            ecat.MetaKeyword        = old.MetaKeyword,
                                            ecat.MetaDescription    = old.MetaDescription,
                                            ecat.CategoryDescription = old.CategoryDescription,
                                            ecat.Image              = old.Image,
                                            ecat.NumSubcategory     = old.NumSubcategory, 
                                            ecat.NumProducts        = old.NumProducts
                                        where e_categoryId = ".$ID; 
		$result = $this->query($strSqlQuery2, 1);
	}


	function getParentCategoryId($catId,$table){
		$sql = "select ParentID,CategoryID from $table where CategoryID= '".addslashes($catId)."' limit 1 ";
		$Res = $this->query($sql, 1);

		if ($Res[0]['ParentID'] =='0') {
			return $Res[0]['CategoryID'];
		} else {
			return $this->getParentCategoryId($Res[0]['ParentID'],$table);
		}
	}



	function checkCategoryExist($catId,$table){
		$sql = "select count(*) as total from $table where CategoryID= '".addslashes($catId)."' limit 1 ";
		$Res = $this->query($sql, 1);

		if ($Res[0]['total'] =='1') {
			return true;
		}
		return false;
	}

	// get customers 9 nov 2015 by karishma

	function getCustomers($ItemID=0)
	{
		$CmpID=$_SESSION['CmpID'];
		$sql="Select id,permission,ref_id FROM erp.`company_user` WHERE 1 AND comId='" . addslashes($CmpID). "'  AND user_type='customer '";
		$res=$this->query($sql, 1);



		$customerArray=array();


		foreach($res as $val){

			$SqlCustomer = "select c1.Cid,c1.FullName,b.ID from s_customers c1
			left join inv_customer_items b on b.CustomerID=c1.Cid and b.ItemID='" . addslashes($ItemID). "'
			WHERE c1.Cid='" . addslashes($val['ref_id']). "' "; 

			//$SqlCustomer .= ($ItemID!=0)? " and  b.ItemID='" . addslashes($ItemID). "' ":'';
			$result=$this->query($SqlCustomer, 1);
			if(!empty($result[0]['Cid']) && ($result[0]['ID']=='0' || $result[0]['ID']==''))
			$customerArray[]=array('Cid'=>$result[0]['Cid'],'FullName'=>stripslashes($result[0]['FullName']));
		}
		return $customerArray;
			

	}

	function getSelectedCustomers($ItemID=0)
	{

		$sql="select c1.Cid,c1.FullName,b.ID from inv_customer_items  b
			Inner join s_customers  c1 on c1.Cid=b.CustomerID where ItemID='" . addslashes($ItemID). "'	";
		$res=$this->query($sql, 1);

		$customerArray=array();

		foreach($res as $val){

			$customerArray[]=array('Cid'=>$val['Cid'],'FullName'=>stripslashes($val['FullName']));
		}
		return $customerArray;
			

	}

	function getGlobalAttributes()
	{
		$strSQLQuery = "SELECT * FROM inv_global_attributes ORDER BY Gaid DESC";
		return $this->query($strSQLQuery, 1);

	}

	function getProductIds($catIDs){

		$strSQLQuery = "select ItemID from inv_items where CategoryID in (".$catIDs.")";

		$arraRow = $this->query($strSQLQuery, 1);

		return $arraRow;

	}
	function getAllProductIds(){

		$strSQLQuery = "select ItemID from inv_items";
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

		$strSQLQuery = "Insert into inv_global_attributes set AttributeType='".trim($attribute_type)."',IsGlobal='".$IsGlobal."', TextLength = '20', Status='".trim($is_active)."',Priority='".trim($priority)."',Name='".trim($attname)."',Caption='".trim($attname)."',required='".trim($required)."'";
		$this->query($strSQLQuery, 1);
		$lastInsertId = $this->lastInsertId();
		if($IsGlobal == "No")
		{
			foreach($select_products2 as $catID){

				$strSQLQuery = "Insert into inv_catalog_attributes set Cid='".$catID."',Gaid='".$lastInsertId."'";
				$this->query($strSQLQuery, 0);
			}
		}


		if($update_mode == "rewrite"){
			foreach($prductIds as $productID){

				$ProductID = $productID['ItemID'];

				$strSQLQuery = "Insert into inv_item_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='".$lastInsertId."', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";

				$this->query($strSQLQuery, 0);

				if($ProductID >0)
				{
					$attributes_countVal = 0;
					$sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$ProductID);
					$attributes_countRow = mysql_fetch_array($sqlAttrVal);
					$attributes_countVal = $attributes_countRow['AttributesCount'];
					$attributes_countVal = $attributes_countVal+1;
					$strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($ProductID)."'";
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
				$sql = "insert into inv_global_optionList(Gaid, title, Price, PriceType, Weight, SortOrder) values('".$global_id."', '".$arryDetails['title'.$i]."',  '".addslashes($arryDetails['Price'.$i])."', '".addslashes($arryDetails['PriceType'.$i])."', '".addslashes($arryDetails['Weight'.$i])."', '".addslashes($arryDetails['SortOrder'.$i])."')";
				$this->query($sql, 0);
			}
		}

	}
	function AddUpdateGlobalAttOption($global_id,$arryDetails){
		global $Config;
		extract($arryDetails);


		if(!empty($DelItem)){
			$strSQLQuery = "delete from inv_global_optionList where id in(".$DelItem.")";
			$this->query($strSQLQuery, 0);
		}
		for($i=1;$i<=$NumLine;$i++){
			if(!empty($arryDetails['title'.$i])){
				$id = $arryDetails['id'.$i];

				if($id>0){
					$sql = "update inv_global_optionList set  title='".addslashes($arryDetails['title'.$i])."',`Price`='".addslashes($arryDetails['Price'.$i])."', PriceType='".addslashes($arryDetails['PriceType'.$i])."', Weight='".addslashes($arryDetails['Weight'.$i])."', SortOrder='".addslashes($arryDetails['SortOrder'.$i])."' where id='".$id."'";

					$this->query($sql, 0);
				}else{	$sql = "insert into inv_global_optionList(Gaid,paid, title, Price, PriceType, Weight, SortOrder) values('".$global_id."','".$PattID."' ,'".$arryDetails['title'.$i]."',  '".addslashes($arryDetails['Price'.$i])."', '".addslashes($arryDetails['PriceType'.$i])."', '".addslashes($arryDetails['Weight'.$i])."', '".addslashes($arryDetails['SortOrder'.$i])."')";
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
		$strSQLQuery = "select * from inv_global_optionList  where 1 ".$strAddQuery." order by id asc";
		return $this->query($strSQLQuery, 1);
	}
	function  GetProductOptionList($paid)
	{
		$strAddQuery .= (!empty($paid))?(" and paid='".$paid."'"):("");
		//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
		$strSQLQuery = "select * from inv_global_optionList  where 1 ".$strAddQuery." order by id asc";
		return $this->query($strSQLQuery, 1);
	}
	/************************OptionList********************/

	function updateGlobalAttribute($arryDetails)
	{
			
		extract($arryDetails);

			
		$strSQLQuery = "delete from inv_item_attributes where gaid='".mysql_real_escape_string($Gaid)."'";
		$this->query($strSQLQuery,0);
		$strSQLQuery = "delete from inv_catalog_attributes where Gaid='".mysql_real_escape_string($Gaid)."'";
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
			
		$strSQLQuery = "UPDATE inv_global_attributes set AttributeType='".trim($attribute_type)."',IsGlobal='".$IsGlobal."', TextLength = '20', Status='".trim($is_active)."',Priority='".trim($priority)."',Name='".trim($attname)."',Caption='".trim($attname)."',required='".trim($required)."' WHERE Gaid = '".mysql_real_escape_string($Gaid)."'";
		$this->query($strSQLQuery, 0);
			
		if($IsGlobal == "No")
		{
			foreach($select_products2 as $catID){
					
				$strSQLQuery = "Insert into inv_catalog_attributes set Cid='".$catID."',Gaid='".$Gaid."'";
				$this->query($strSQLQuery, 0);
			}
		}


		if($update_mode == "rewrite"){
			foreach($prductIds as $productID){

				$ProductID = $productID['ItemID'];

				$strSQLQuery = "Insert into inv_item_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='".$Gaid."', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";
				$this->query($strSQLQuery, 0);

				if($ProductID >0)
				{
					$attributes_countVal = 0;
					$sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$ProductID);
					$attributes_countRow = mysql_fetch_array($sqlAttrVal);
					$attributes_countVal = $attributes_countRow['AttributesCount'];
					$attributes_countVal = $attributes_countVal+1;
					$strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($ProductID)."'";
					$this->query($strSQLQueryAttr, 0);
				}
			}
		}
			
		return 1;


	}



	function getGlobalAttributeById($attrID)
	{
		$strSQLQuery = "SELECT * FROM inv_global_attributes WHERE Gaid = '".$attrID."'";
		return $this->query($strSQLQuery, 1);

	}

	function changeGlobalAttributeStatus($attrID)
	{

		$strSQLQuery = "select * from inv_global_attributes where Gaid='".$attrID."'";
		$rs = $this->query($strSQLQuery);
		if(sizeof($rs))
		{
			if($rs[0]['Status'] == "Yes")
			$Status="No";
			else
			$Status="Yes";

			$strSQLQuery = "update inv_global_attributes set Status='$Status' where Gaid='".mysql_real_escape_string($attrID)."'";
			$this->query($strSQLQuery,0);

		}
			
		return true;

	}

	function deleteGlobalAttribute($attrID)
	{
		$strSQLQuery = "delete from inv_global_attributes where Gaid='".mysql_real_escape_string($attrID)."'";
		$this->query($strSQLQuery,0);
		$strSQLQuery = "delete from inv_item_attributes where gaid='".mysql_real_escape_string($attrID)."'";
		$this->query($strSQLQuery,0);
		$strAttOptionQuery = "delete from inv_global_optionList where Gaid='".mysql_real_escape_string($attrID)."'";
		$this->query($strAttOptionQuery,0);
		$strSQLQuery = "delete from inv_catalog_attributes where Gaid='".mysql_real_escape_string($attrID)."'";
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
			
		$strSQLQuery = "Insert into inv_item_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."'";
		$this->query($strSQLQuery, 0);
		$lastInsertId = $this->lastInsertId();
		if($ProductID >0)
		{
			$attributes_countVal = 0;
			$sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID=".$ProductID);
			$attributes_countRow = mysql_fetch_array($sqlAttrVal);
			$attributes_countVal = $attributes_countRow['AttributesCount'];
			$attributes_countVal = $attributes_countVal+1;
			$strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($ProductID)."'";
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

		$strSQLQuery = "update inv_item_attributes set attribute_type='".trim($attribute_type)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."',required='".trim($required)."' where paid = '".mysql_real_escape_string($AttributeId)."' and pid='".mysql_real_escape_string($ProductID)."'";
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function GetAttributeByID($attId)
	{

		$strSQLQuery = "select * from inv_item_attributes where paid = '".$attId."'";
		return $this->query($strSQLQuery, 1);
	}
	function GetProductAttributes($ProductID)
	{

		$strSQLQuery = "Select * from inv_item_attributes where pid='".$ProductID."'";
		return $this->query($strSQLQuery, 1);
	}

	function GetProductAttributesForFront($ProductID)
	{

		$strSQLQuery = "Select * from inv_item_attributes where pid='".mysql_real_escape_string($ProductID)."' AND is_active='Yes' order by priority asc";
		return $this->query($strSQLQuery, 1);
	}




	function deleteAttribute($pid,$attributeId)
	{
		$strSQLQuery = "delete from inv_item_attributes where paid='".mysql_real_escape_string($attributeId)."' and pid='".mysql_real_escape_string($pid)."'";
		$this->query($strSQLQuery, 0);

		$sqlAttrVal= mysql_query("select AttributesCount from inv_items where ItemID='".mysql_real_escape_string($pid)."'");
		$attributes_countRow = mysql_fetch_array($sqlAttrVal);
		$attributes_countVal = $attributes_countRow['AttributesCount'];
		$attributes_countVal = $attributes_countVal-1;
		$strSQLQueryAttr = "update inv_items set AttributesCount=".$attributes_countVal." where ItemID='".mysql_real_escape_string($pid)."'";
		$this->query($strSQLQueryAttr, 0);
		return 1;
	}

	/*************************************Attribute Function End******************************************************************/

	/*********Added By karishma based on Condition*********************/
	function getItemCondionQty($Sku,$Condi) {
		$strSQLQuery = "select condition_qty from inv_item_quanity_condition where Sku = '" . $Sku . "' and `condition`= '" .addslashes($Condi) . "' ";
		$row = $this->query($strSQLQuery, 1);
		return $row;
	}
	/*********End By karishma based on Condition*********************/

	function UpdateVirtualFile($fileName,$ItemID)
	{
		$strSQLQuery = "update inv_items set virtual_file='".$fileName."' where ItemID='".mysql_real_escape_string($ItemID)."'";
		return $this->query($strSQLQuery, 0);
	}
}


?>
