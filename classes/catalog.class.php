<?
class catalog extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function catalog(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addCatalog($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into catalog (heading,detail,catalogDate,Status) values('".addslashes($heading)."', '".addslashes($detail)."','".$catalogDate."', '".$Status."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateCatalog($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update catalog set heading = '".addslashes($heading)."', detail = '".addslashes($detail)."', catalogDate = '".$catalogDate."', Status = '".$Status."'  where catalogID = '".$catalogID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}
	function getCatalog($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and catalogID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from catalog ".$sql." order by catalogDate desc" ;
		return $this->query($sql, 1);
	}

	function changeCatalogStatus($catalogID)
	{
		$sql="select * from catalog where catalogID='".$catalogID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update catalog set Status='$Status' where catalogID='".$catalogID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteCatalog($catalogID)
	{

		$strSQLQuery = "select Image from catalog where catalogID='".$catalogID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		if($Front > 0){
			$ImgDir = 'upload/catalog/';
		}else{
			$ImgDir = '../upload/catalog/';
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							unlink($ImgDir.$arryRow[0]['Image']);	
		}

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.'thumbs/'.$arryRow[0]['Image']) ){					unlink($ImgDir.'thumbs/'.$arryRow[0]['Image']);
		}

		$sql = "delete from catalog where catalogID = '".$catalogID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListCatalog($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and catalogID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (heading like '".$SearchKey."%' or catalogDate like '%".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by catalogDate ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from catalog ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function UpdateImage($imageName,$catalogID)
	{
			$strSQLQuery = "update catalog set Image='".$imageName."' where catalogID='".$catalogID."'";
			return $this->query($strSQLQuery, 0);
	}


	function isCatalogExists($heading,$catalogID)
	{

		$strSQLQuery ="select * from catalog where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($catalogID))?(" and catalogID != '".$catalogID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['catalogID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
