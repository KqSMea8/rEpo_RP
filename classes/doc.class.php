<?
class doc extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function doc(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addDocument($arryDetails)
	{
		global $Config;
		@extract($arryDetails);	
		$sql = "insert into h_document (locationID, heading, detail, publish, AdminID, AdminType, docDate) values('".$_SESSION['locationID']."', '".addslashes($heading)."', '".addslashes($detail)."','".addslashes($publish)."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."' )";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateDocument($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update h_document set heading='".addslashes($heading)."', detail = '".addslashes($detail)."' ,publish = '".$publish."',AdminID = '".$_SESSION['AdminID']."',AdminType = '".$_SESSION['AdminType']."',docDate = '".$Config['TodayDate']."'  where documentID = '".$documentID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}


	function getDocument($id=0,$EmpID,$publish=0)
	{
		$sql = " where 1";
		$sql .= (!empty($id))?(" and documentID = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
		$sql .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");
		$sql .= (!empty($publish) && $publish == 1)?(" and publish = '".$publish."'"):("");

		$sql = "select * from h_document ".$sql." order by documentID desc" ; 
		return $this->query($sql, 1);
	}

	function changeDocumentPublish($documentID)
	{
		$sql="select * from h_document where documentID='".$documentID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{

			if($rs[0]['publish']==1){
				$publish=0; $_SESSION['mess_document'] = "Document has been published successfully.";
			}else{
				$publish=1; $_SESSION['mess_document'] = "Document has been unpublished.";
			}
				
			$sql="update h_document set publish='$publish' where documentID='".$documentID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteDocument($documentID)
	{

		$strSQLQuery = "select document from h_document where documentID='".$documentID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		$DocDir = 'upload/document/';

		if($arryRow[0]['document'] !='' && file_exists($DocDir.$arryRow[0]['document']) ){	
		unlink($DocDir.$arryRow[0]['document']);	
		}

		$sql = "delete from h_document where documentID = '".$documentID."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListDocument($id=0, $EmpID, $SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = " where 1 ";
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and documentID='".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
		$strAddQuery .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");

		if($SearchKey=='yes' && ($SortBy=='publish' || $SortBy=='') ){
				$strAddQuery .= " and publish='1'"; 
		}else if($SearchKey=='no' && ($SortBy=='publish' || $SortBy=='') ){
				$strAddQuery .= " and publish='0'";
		}else if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or detail like '%".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by documentID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from h_document ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function UpdateDocumentFile($document,$documentID)
	{
			$strSQLQuery = "update h_document set document='".$document."' where documentID='".$documentID."'";
			return $this->query($strSQLQuery, 0);
	}


	function isDocumentExists($heading, $documentID)
	{

		$strSQLQuery ="select * from h_document where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($documentID))?(" and documentID != '".$documentID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['documentID'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
