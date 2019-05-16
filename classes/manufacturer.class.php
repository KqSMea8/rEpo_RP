<?
class manufacturer extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function manufacturer(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addManufacturer($arryDetails)
	{
		@extract($arryDetails);	
		$sql = "insert into e_manufacturers (Mname,Mcode,Mdetail,Website,Status) values('".addslashes($Mname)."', '".addslashes($Mcode)."','".addslashes(strip_tags($Mdetail))."','".addslashes(strip_tags($Website))."', '".$Status."')";

		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();
		
		//Update manufacturer code if empty
		
			if(empty($Mcode)){
				$Mcode = 'mnf000'.$lastInsertId;
				$strSQLQuery = "update e_manufacturers set Mcode = '".$Mcode."' where Mid = '".$lastInsertId."'"; 
				$this->query($strSQLQuery, 0);
			}
			
			//end 
		
		return $lastInsertId;

	}
	function updateManufacturer($arryDetails)
	{
		@extract($arryDetails);	
                
                  if($imagedelete == "Yes")
                        {
                             $strSQLQuery = "select Image from e_manufacturers where Mid = '".$Mid."'"; 
			                 $arryRow = $this->query($strSQLQuery, 1);
                             $ImgDir = '../../upload/manufacturer/'.$_SESSION['CmpID'].'/';
                             unlink($ImgDir.$arryRow[0]['Image']);
			 $sql = "update e_manufacturers set Mname='".addslashes($Mname)."', Mdetail = '".addslashes(strip_tags($Mdetail))."', Website = '".addslashes($Website)."',Image='', Status = '".$Status."'  where Mid = '".$Mid."'"; 
                        }
                        else
                        {
                            $sql = "update e_manufacturers set Mname='".addslashes($Mname)."', Mdetail = '".addslashes(strip_tags($Mdetail))."', Website = '".addslashes($Website)."',Status = '".$Status."'  where Mid = '".$Mid."'"; 
                        }
		
		$rs = $this->query($sql,0);
			
		if(sizeof($rs))
			return true;
		else
			return false;

	}


	function getManufacturer($id=0,$Status=0,$SearchKey,$SortBy,$AscDesc)
	{
		
                 $sql = '';
                 $SearchKey   = strtolower(trim($SearchKey));
                 $sql .= (!empty($id))?(" where Mid='".$id."'"):(" where 1");
                 $sql .= ($Status>0)?(" and Status='".$Status."' and Status='1'  "):("");
		 if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
                     $sql .= " and Status='1'"; 
                 }else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
				$sql .= " and Status='0'";
			}else if($SortBy != ''){
				$sql .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$sql .= (!empty($SearchKey))?(" and (Mname like '".$SearchKey."%') "):("");
			}
                        $sql .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by Mid ");
			$sql .= (!empty($AscDesc))?($AscDesc):(" Desc");

		$sql = "select * from e_manufacturers ".$sql.""; 
		return $this->query($sql, 1);
	}
        
        function getManufacturerById($mid)
        {
                $sql = "SELECT * from e_manufacturers WHERE Mid = '".$mid."'"; 
                return $this->query($sql, 1);
        }
        
        function getManufacturerByProductId($id)
		{   
				if($id > 0)
				{
					 $sql = " where 1";
					 $sql .= (!empty($id))?(" and Mid = '".$id."'"):("");
					 $sql = mysql_query("select Mname from e_manufacturers ".$sql.""); 
										 $row = mysql_fetch_array($sql);
					 return $row['Mname'];
				}
								   
		}

	function changeManufacturerStatus($Mid)
	{
		$sql="select * from e_manufacturers where Mid= '".$Mid."'";
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update e_manufacturers set Status='$Status' where Mid = '".$Mid."'";
			$this->query($sql,0);
			return true;
		}			
	}

	function deleteManufacturer($Mid)
	{
		

		global $Config;
		$objConfigure = new configure();
		$objFunction=new functions();
		
		$strSQLQuery = "select Image from e_manufacturers where Mid = '".$Mid."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
		 
		if($arryRow[0]['Image'] != '') {            
			   $objFunction->DeleteFileStorage($Config['ProductsManufacturer'],$arryRow[0]['Image']); 
		}

		$sql = "delete from e_manufacturers where Mid = '".$Mid."'";
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	
	function  ListManufacturer($id=0,$MemberID, $SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = " where 1";
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and Mid='".$id."'"):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (Mname like '".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by Mid ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		$strSQLQuery = "select * from e_manufacturers ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}

	function UpdateImage($imageName,$Mid)
	{
			$strSQLQuery = "update e_manufacturers set Image='".$imageName."' where Mid = '".$Mid."'";
			return $this->query($strSQLQuery, 0);
	}


	/*function isManufacturerExists($Mname,$Mid)
	{

		$strSQLQuery ="select * from e_manufacturers where LCASE(Mname)='".strtolower(trim($Mname))."'";

		$strSQLQuery .= (!empty($Mid))?(" and Mid != '".$Mid."'"):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['Mid'])) {
			return true;
		} else {
			return false;
		}


	}*/
       
        function checkManufacturer($Mcode)
        {
            $strSQLQuery = "select * from e_manufacturers where LCASE(Mcode)='".strtolower(trim($Mcode))."'";
            return $this->query($strSQLQuery, 1);
        }
		function isManufacturerNumberExists($MCode,$Mid=0)
		{

			$strSQLQuery ="select Mid from e_manufacturers where LCASE(Mcode)='".strtolower(trim($MCode))."'";

			$strSQLQuery .= ($Mid>0)?(" and Mid != '".$Mid."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['Mid'])) {
				return true;
			} else {
				return false;
			}
		}


}
?>
