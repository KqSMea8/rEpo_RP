<?
class template extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function template(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addTemplate($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into template (templateID,catID,heading,detail,templateDate,Status,HeaderMenuButton,Public) values('".$NextTemplateID."','".$catID."','".addslashes($heading)."', '".addslashes($detail)."','".$templateDate."', '".$Status."','".$HeaderMenuButton."','".$Public."')";
	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;

	}
	function updateTemplate($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "update template set heading = '".addslashes($heading)."', templateDate = '".$templateDate."', catID = '".$catID."', Status = '".$Status."', Public = '".$Public."', HeaderMenuButton = '".$HeaderMenuButton."'  where templateID = '".$templateID."'"; 
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}


	function getTemplate($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and templateID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from template ".$sql." order by templateID asc" ;
		return $this->query($sql, 1);
	}

	function getActiveTemplate($id=0)
	{
		$sql = " where Status = 1  ";
		$sql .= (!empty($id))?(" and templateID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

		$sql = "select * from template ".$sql." order by templateID desc" ;
		return $this->query($sql, 1);
	}


	function changeTemplateStatus($templateID)
	{
		$sql="select * from template where templateID='".$templateID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update template set Status='$Status' where templateID='".$templateID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteTemplate($templateID)
	{

		$strSQLQuery = "select * from template where templateID='".$templateID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		
		if($Front > 0){
			$ImgDir = 'templates/';
		}else{
			$ImgDir = '../templates/';
		}

		if($arryRow[0]['Template'] !='' && file_exists($ImgDir.$arryRow[0]['Template']) ){							unlink($ImgDir.$arryRow[0]['Template']);	
		}

		$ImgDir .= 'images/';

		if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							unlink($ImgDir.$arryRow[0]['Image']);	
		}

		$sql = "delete from template where templateID = '".$templateID."'";
		$rs = $this->query($sql,0);

		 ClearDirectory('../templates/'.$templateID.'/images/'); 
		 ClearDirectory('../templates/'.$templateID.'/css/'); 
		 rmdir('../templates/'.$templateID.'/images');
		 rmdir('../templates/'.$templateID.'/css'); 
		 rmdir('../templates/'.$templateID); 

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListTemplate($id=0,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and t.templateID='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (t.heading like '".$SearchKey."%' or c.Name like '%".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by t.templateID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select t.*,c.Name as Category from template t left outer join template_cat c on t.catID=c.catID ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function NextTemplateID()
	{
		$strSQLQuery = "select max(templateID)+1 as NextTemplateID from template";
		return $this->query($strSQLQuery, 1);
	}
	
	function UpdateImage($imageName,$templateID)
	{
			$strSQLQuery = "update template set Image='".$imageName."' where templateID='".$templateID."'";
			return $this->query($strSQLQuery, 0);
	}

	function UpdateTemplateFile($Template,$templateID)
	{
			$strSQLQuery = "update template set Template='".$Template."' where templateID='".$templateID."'";
			return $this->query($strSQLQuery, 0);
	}


	function isTemplateExists($heading,$templateID)
	{

		$strSQLQuery ="select * from template where LCASE(heading)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($templateID))?(" and templateID != '".$templateID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['templateID'])) {
			return true;
		} else {
			return false;
		}


	}


	function getTemplateByCategory($catID=0,$Status=0)
	{
		$sql = " where Public='1' ";
		$sql .= (!empty($catID))?(" and catID = '".$catID."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		$sql = "select * from template ".$sql." order by templateID Desc" ;
		return $this->query($sql, 1);
	}

	function getTemplateCategory($id=0,$Status=0)
	{
		$sql = " where 1 ";
		$sql .= (!empty($id))?(" and catID = '".$id."'"):("");
		$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
		$sql = "select * from template_cat ".$sql." order by Name Asc" ;
		return $this->query($sql, 1);
	}

	function changeCategoryStatus($catID)
	{
		$sql="select * from template_cat where catID='".$catID."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update template_cat set Status='$Status' where catID='".$catID."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function isCategoryExists($Name,$catID=0)
	{

		$strSQLQuery ="select catID from template_cat where LCASE(Name)='".strtolower(trim($Name))."'";

		$strSQLQuery .= (!empty($catID))?(" and catID != '".$catID."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['catID'])) {
			return true;
		} else {
			return false;
		}
	}

	function RemoveCategory($catID)
	{
		$strSQLQuery = "delete from template_cat where catID='".$catID."'"; 
		$this->query($strSQLQuery, 0);

	}

	function AddCategory($arryDetails)
	{ 
		extract($arryDetails);
		$strSQLQuery = "insert into template_cat (Name,Status) values('".addslashes($Name)."','".$Status."')";
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function UpdateCategory($arryDetails)
	{
		extract($arryDetails);
		$strSQLQuery = "update template_cat set Name='".addslashes($Name)."', Status='".$Status."' where catID='".$catID."'";
		$this->query($strSQLQuery, 0);

		return 1;
	}



}

?>
