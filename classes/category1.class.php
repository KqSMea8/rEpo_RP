<?
class category extends dbClass
{
		//constructor
		function category()
		{
			$this->dbClass();
		} 
		
		function  ListCategories($ParentID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" where c1.ParentID=".$ParentID):(" where c1.ParentID=0");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcategory,c1.NumProducts from categories c1 left outer join categories c2 on c1.ParentID = c2.CategoryID".$strAddQuery." order by c1.Name";

			return $this->query($strSQLQuery, 1);
		}

		function  GetCategory($CategoryID,$ParentID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" where c1.ParentID=".$ParentID):(" where c1.ParentID=0");
			$strAddQuery .= ($CategoryID>0)?(" and c1.CategoryID=".$CategoryID):("");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.Status,c1.NumSubcategory,c1.NumProducts from categories c1 left outer join categories c2 on c1.ParentID = c2.CategoryID ".$strAddQuery." order by c1.Name";
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetStoreCategory($StoreCategoryID,$CategoryID,$StoreID,$Status)
		{
			$strAddQuery = ' where 1 ';
			$strAddQuery .= ($StoreCategoryID>0)?(" and sc.StoreCategoryID=".$StoreCategoryID):("");
			$strAddQuery .= ($CategoryID>0)?(" and sc.CategoryID=".$CategoryID):("");
			$strAddQuery .= ($StoreID>0)?(" and sc.StoreID=".$StoreID):("");
			$strAddQuery .= ($Status>0)?(" and sc.Status=".$Status):("");

			$strSQLQuery = "select sc.*,c1.ParentID,c1.Name as SubCategory,c2.Name as Category from store_categories sc inner join categories c1 on sc.CategoryID = c1.CategoryID left outer join categories c2 on c1.ParentID = c2.CategoryID ".$strAddQuery." order by sc.Name";
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetNameByParentID($ParentID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select Name from categories where CategoryID = ".$ParentID.$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetStoreCategoryByID($StoreCategoryID)
		{
			$strSQLQuery = "select * from store_categories c1 where c1.StoreCategoryID=".$StoreCategoryID;
			return $this->query($strSQLQuery, 1);
		}

		function  GetCategoryNameByID($CategoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select c1.Name from categories c1 where c1.Status=1 and c1.CategoryID in(".$CategoryID.") ".$strAddQuery." order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}

		function AddCategory($arryDetails)
		{ 
			extract($arryDetails);
			$strSQLQuery = "insert into categories (ParentID,Name,Status) values('".$ParentID."','".addslashes($Name)."','".$Status."')";
			$this->query($strSQLQuery, 0);
			$lastInsertId = $this->lastInsertId();

			if($ParentID > 0){
				$strUpdateQuery = "update categories set NumSubcategory = NumSubcategory + 1 where CategoryID = '".$ParentID."'";
				$this->query($strUpdateQuery, 0);
			}
			return 1;

		}

		function AddStoreCategory($arryDetails)
		{ 
			extract($arryDetails);
			$strSQLQuery = "insert into store_categories (CategoryID,StoreID,Name,Status) values('".$CategoryID."','".$PostedByID."','".addslashes($Name)."','".$Status."')";
			$this->query($strSQLQuery, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}

		function UpdateCategory($arryDetails)
		{
			extract($arryDetails);
			$strSQLQuery = "update categories set ParentID='".$ParentID."',Name='".addslashes($Name)."', Status='".$Status."' where CategoryID=".$CategoryID;
			$this->query($strSQLQuery, 0);

			return 1;
		}

		function UpdateStoreCategory($arryDetails)
		{
			extract($arryDetails);
			$strSQLQuery = "update store_categories set CategoryID='".$CategoryID."',Name='".addslashes($Name)."', Status='".$Status."' where StoreCategoryID=".$StoreCategoryID; 
			$this->query($strSQLQuery, 0);

			return 1;
		}

		function RemoveCategory($id, $ParentID)
		{
			$strSQLQuery = "delete from categories where CategoryID=".$id; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from store_categories where CategoryID=".$id; 
			$this->query($strSQLQuery, 0);

			if($ParentID > 0){

				$strSQLQuery ="select NumSubcategory from categories where CategoryID=".$ParentID;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['NumSubcategory'])) {
					$strUpdateQuery = "update categories set NumSubcategory = NumSubcategory - 1 where CategoryID = '".$ParentID."'";
					$this->query($strUpdateQuery, 0);
				} 


			}
			return 1;
		}

		function RemoveCategoryCompletly($id)
		{

			$strSQLQuery = "delete from categories where CategoryID=".$id; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from categories where ParentID=".$id; 
			$this->query($strSQLQuery, 0);

		
			/******************************/
			$strSQLQuery = "delete from products where CategoryID=".$id; 
			$this->query($strSQLQuery, 0);
			
			return 1;
		}

		function RemoveStoreCategory($StoreCategoryID)
		{

			$strSQLQuery = "delete from store_categories where StoreCategoryID=".$StoreCategoryID; 
			$this->query($strSQLQuery, 0);
			
			return 1;
		}

		function changeCategoryStatus($CategoryID)
		{
			$sql="select * from categories where CategoryID=".$CategoryID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update categories set Status='$Status' where CategoryID=".$CategoryID;
				$this->query($sql,0);
				return true;
			}			
		}

		function isSubCategoryExists($id)
		{
			$strSQLQuery ="select * from categories where ParentID=".$id;
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		function isProductExists($id)
		{
			$strSQLQuery ="select * from products where CategoryID=".$id;
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}
		
		function isCategoryExists($Name,$CategoryID=0,$ParentID=0)
		{

			$strSQLQuery ="select CategoryID from categories where LCASE(Name)='".strtolower(trim($Name))."' and ParentID = ".$ParentID;

			$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID != ".$CategoryID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['CategoryID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isStoreCategoryExists($Name,$StoreCategoryID=0,$StoreID)
		{

			$strSQLQuery ="select StoreCategoryID from store_categories where LCASE(Name)='".strtolower(trim($Name))."' and StoreID = ".$StoreID;

			$strSQLQuery .= (!empty($StoreCategoryID))?(" and StoreCategoryID != ".$StoreCategoryID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['StoreCategoryID'])) {
				return true;
			} else {
				return false;
			}
		}	

		function  GetCategoriesListing($id=0,$ParentID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID=".$ParentID):(" and c1.ParentID=0");
			$strAddQuery .= (!empty($id))?(" and c1.CategoryID=".$id):("");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcategory from categories c1 left outer join categories c2 on c1.ParentID = c2.CategoryID where c1.Status=1 ".$strAddQuery." order by c1.Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetSubCategoriesListing($id=0,$ParentID,$StoreID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" and c1.ParentID=".$ParentID):(" and c1.ParentID=0");
			$strAddQuery .= (!empty($id))?(" and c1.CategoryID=".$id):("");

			$strSQLQuery = "select c1.CategoryID,c1.Name,c1.ParentID,c1.NumProducts, if(c1.ParentID>0,c2.Name,'') as ParentName ,c1.NumSubcategory,sc.StoreCategoryID from categories c1 left outer join categories c2 on c1.ParentID = c2.CategoryID left outer join store_categories  sc on (c1.CategoryID=sc.CategoryID and sc.StoreID=".$StoreID." and sc.Status=1) where c1.Status=1 ".$strAddQuery." group by c1.Name order by c1.Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetCategoryByParent($Status,$ParentID)
		{
			$strAddQuery = (!empty($Status))?(" and Status=".$Status):("");

			$strSQLQuery = "select * from categories where ParentID=".$ParentID.$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		function  GetParentCategories($CategoryIDs,$StoreID)
		{
			 $strSQLQuery = "select c1.*,sc.StoreCategoryID from categories c1 left outer join store_categories  sc on (c1.CategoryID=sc.CategoryID and sc.StoreID=".$StoreID." and sc.Status=1) where c1.ParentID=0 and c1.Status=1 and c1.CategoryID in(".$CategoryIDs." ) group by c1.Name order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}

		function  GetStoreCategories($PostedByID)
		{
			 $strSQLQuery = "select p1.CategoryID,p1.StoreCategoryID,c1.ParentID from products p1 inner join categories c1 on p1.CategoryID=c1.CategoryID left outer join categories c2 on c2.ParentID=c1.CategoryID where p1.Status=1 and c1.Status=1 and p1.PostedByID=".$PostedByID." group by p1.CategoryID";

			return $this->query($strSQLQuery, 1);
		}

		function GetNumProductsStoreCategory($StoreCategoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

			$strSQLQuery = "select count(*) as NumProducts from products p1 where p1.Status=1  and p1.StoreCategoryID=".$StoreCategoryID.$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}
		
		function GetNumProductsSingle($CategoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

			$strSQLQuery = "select count(*) as NumProducts from products p1 where p1.Status=1  and p1.CategoryID=".$CategoryID.$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}		

		function GetNumProductsMultiple($CategoryID,$PostedByID){
			$strAddQuery = ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

			$strSQLQuery = "select count(*) as NumProducts from products p1 where p1.Status=1  and p1.CategoryID in( select CategoryID from categories where ParentID='".$CategoryID."' and Status=1)".$strAddQuery;

			return $this->query($strSQLQuery, 1);

		}


	





}

?>
