<?
class common extends dbClass
{
		//constructor
		function common()
		{
			$this->dbClass();
		} 
		
		///////  Attribute Management //////

		function  GetAttributeValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 and locationID=".$_SESSION['locationID']):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetAttributeByValue($attribute_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and locationID=".$_SESSION['locationID']):("");

			$strSQLFeaturedQuery .= (!empty($attribute_value))?(" and v.attribute_value like '".$attribute_value."%'"):("");

			$strSQLQuery = "select v.attribute_value from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	

		function GetCrmAttribute($attribute_name,$OrderBy)
		{

			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function getAllCrmAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_attribute_value ".$sql." order by value_id asc" ;

			return $this->query($sql, 1);
		}


		function  GetFixedAttribute($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllAttributes($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and attribute_id in(".$id.")"):("");
		
			$strSQLQuery = "select * from h_attribute ".$strSQLQuery." order by attribute_id Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
		
		function addUpdateAttribute($attribute_value,$attribute_id)
		{
			$strSQLQuery ="select value_id from h_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and attribute_id='".$attribute_id."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['value_id'])) {
				$value_id = $arryRow[0]['value_id'];
			}else{ $Status=1;
			$sql = "insert into h_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
			$this->query($sql, 0);
			$value_id = $this->lastInsertId();
			}
			return $value_id;

		}

	
		function addAttribute($arryAtt)
		{
			@extract($arryAtt);	 
			$sql = "insert into h_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();

			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function updateAttribute($arryAtt)
		{
			@extract($arryAtt);	
			if(!empty($value_id)){
				$sql = "update h_attribute_value set attribute_value = '".addslashes($attribute_value)."',attribute_id = '".$attribute_id."',Status = '".$Status."'  where value_id = '".$value_id."'"; 
				$rs = $this->query($sql,0);
			}				
			return true;

		}
		function getAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}
		function countAttributes()
		{
			$sql = "select sum(1) as NumAttribute from h_attribute_value where Status=1" ;
			return $this->query($sql, 1);
		}

		function changeAttributeStatus($value_id)
		{
			if(!empty($value_id)){
				$sql="select * from h_attribute_value where value_id='".$value_id."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_attribute_value set Status='$Status' where value_id=".$value_id;
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteAttribute($id)
		{
			if(!empty($id)){
				$sql = "delete from h_attribute_value where value_id = '".mysql_real_escape_string($id)."'";
				$rs = $this->query($sql,0);
			}

			return true;
		}
	
		function isAttributeExists($attribute_value,$attribute_id,$value_id)
			{

				$strSQLQuery ="select value_id from h_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and locationID=".$_SESSION['locationID'];

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = ".$attribute_id):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != ".$value_id):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}


		function GetEmpCategory()
		{
			$sql = "select * from  h_component_cat where Status=1 order by catID Asc" ; 
			return $this->query($sql, 1);
		}

		function GetEmpCategoryName($catID)
		{
			$sql = "select * from h_component_cat where Status=1 and catID='".$catID."'" ; 
			return $this->query($sql, 1);
		}


		////////////Education Attribute Start ///// 
		function  GetAttribMultiple($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name in(".$attribute_name.") and v.Status=1 "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}



		function  GetAttribValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from h_attribute_value v inner join h_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}
		function getAttrib($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}

		function isAttribExists($attribute_value,$attribute_id,$value_id)
		{

				$strSQLQuery ="select value_id from h_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' ";

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != '".$value_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}

		////////////Document Management Start ///// 

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
			global $Config;
			@extract($arryDetails);	
			if(!empty($documentID)){
				$sql = "update h_document set heading='".addslashes($heading)."', detail = '".addslashes($detail)."' ,publish = '".$publish."',AdminID = '".$_SESSION['AdminID']."',AdminType = '".$_SESSION['AdminType']."',docDate = '".$Config['TodayDate']."'  where documentID = '".$documentID."'"; 
				
				$rs = $this->query($sql,0);
			}	

			return true;

		}


		function getDocument($id=0,$EmpID,$publish=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and documentID = '".mysql_real_escape_string($id)."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($EmpID))?(" and EmpID = '".mysql_real_escape_string($EmpID)."'"):("");
			$sql .= (!empty($publish) && $publish == 1)?(" and publish = '".$publish."'"):("");

			$sql = "select * from h_document ".$sql." order by documentID desc" ; 
			return $this->query($sql, 1);
		}

		function getActiveDocument($Limit)
		{
			$LimitSql = (!empty($Limit))?(" Limit 0,".$Limit):("");

			$sql = "select documentID,heading,document from h_document where publish=1 and document!='' order by documentID desc ".$LimitSql ;
			return $this->query($sql, 1);
		}

		function changeDocumentPublish($documentID)
		{
			if(!empty($documentID)){
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
				}
			}

			return true;

		}

		function deleteDocument($documentID)
		{
			$objConfigure=new configure();
			if(!empty($documentID)){
				$strSQLQuery = "select document from h_document where documentID='".mysql_real_escape_string($documentID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				
				$DocDir = 'upload/document/'.$_SESSION['CmpID'].'/';

				if($arryRow[0]['document'] !='' && file_exists($DocDir.$arryRow[0]['document']) ){			
					$objConfigure->UpdateStorage($DocDir.$arryRow[0]['document'],0,1);				
					unlink($DocDir.$arryRow[0]['document']);	
				}

				$sql = "delete from h_document where documentID = '".mysql_real_escape_string($documentID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
		function  ListDocument($id=0, $EmpID, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and documentID='".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($EmpID))?(" and EmpID = ".$EmpID):("");

			if($SearchKey=='yes' && ($SortBy=='publish' || $SortBy=='') ){
					$strAddQuery .= " and publish=1"; 
			}else if($SearchKey=='no' && ($SortBy=='publish' || $SortBy=='') ){
					$strAddQuery .= " and publish=0";
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
			if(!empty($documentID) && !empty($document)){
				$strSQLQuery = "update h_document set document='".$document."' where documentID=".$documentID;
				return $this->query($strSQLQuery, 0);
			}
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

		////////////Tax Document Start ///////

		function getTaxDocument($id=0,$EmpID,$publish=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and documentID = '".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($EmpID))?(" and EmpID = '".$EmpID."'"):("");
			$sql .= (!empty($publish) && $publish == 1)?(" and publish = '".$publish."'"):("");

			$sql = "select * from h_tax_form ".$sql." order by documentID Asc" ; 
			return $this->query($sql, 1);
		}

		function updateTaxDocument($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	

			$arryDocument = $this->getTaxDocument('','','');
			if (!empty($arryDocument[0]['documentID'])) {
				$sql = "update h_tax_form set heading='".addslashes($heading)."', detail = '".addslashes($detail)."' ,publish = '".$publish."',AdminID = '".$_SESSION['AdminID']."',AdminType = '".$_SESSION['AdminType']."',docDate = '".$Config['TodayDate']."'  where documentID = ".$arryDocument[0]['documentID'];
				$rs = $this->query($sql,0);
				$documentID = $arryDocument[0]['documentID'];
			}else{
				$sql = "insert into h_tax_form (locationID, heading, detail, publish, AdminID, AdminType, docDate) values('".$_SESSION['locationID']."', '".addslashes($heading)."', '".addslashes($detail)."','".addslashes($publish)."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."' )"; 
			
				$this->query($sql, 0);
				$documentID = $this->lastInsertId();
			}
				
			return $documentID;

		}

		function UpdateTaxFile($document,$documentID)
		{
			if(!empty($documentID) && !empty($document)){
				$strSQLQuery = "update h_tax_form set document='".$document."' where documentID=".$documentID;
				return $this->query($strSQLQuery, 0);
			}
		}



		////////////News Management Start ///// 

		function addNews($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_news (heading,detail,newsDate,Status) values('".addslashes($heading)."', '".addslashes($detail)."','".$newsDate."', '".$Status."')";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateNews($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($newsID)){
				$sql = "update h_news set heading = '".addslashes($heading)."', detail = '".addslashes($detail)."', newsDate = '".$newsDate."', Status = '".$Status."'  where newsID = '".$newsID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}
		function getNews($id=0,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and newsID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_news ".$sql." order by newsDate desc" ;
			return $this->query($sql, 1);
		}

		function getActiveNews($Limit)
		{
			$LimitSql = (!empty($Limit))?(" Limit 0,".$Limit):("");

			$sql = "select newsID,heading,newsDate from h_news where Status=1  order by newsDate desc ".$LimitSql ;
			return $this->query($sql, 1);
		}
		function changeNewsStatus($newsID)
		{
			if(!empty($newsID)){
				$sql="select * from h_news where newsID='".mysql_real_escape_string($newsID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_news set Status='$Status' where newsID='".mysql_real_escape_string($newsID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteNews($newsID)
		{
			$objConfigure=new configure();
			if(!empty($newsID)){
				$strSQLQuery = "select Image from h_news where newsID='".mysql_real_escape_string($newsID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				
				$ImgDir = 'upload/news/'.$_SESSION['CmpID'].'/';

				if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){
				$objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);				
                                    unlink($ImgDir.$arryRow[0]['Image']);	
				}

				$sql = "delete from h_news where newsID = '".mysql_real_escape_string($newsID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
		function  ListNews($id=0,$SearchKey,$SortBy,$AscDesc,$FromDate,$ToDate)
		{
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and newsID='".$id."'"):("");


			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '".$SearchKey."%' or newsDate like '%".$SearchKey."%')"):("");
			}

			$strAddQuery .= (!empty($FromDate))?(" and newsDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and newsDate<='".$ToDate."'"):("");


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by newsDate ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

			$strSQLQuery = "select * from h_news ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function UpdateImage($imageName,$newsID)
		{
			if(!empty($newsID) && !empty($imageName)){
				$strSQLQuery = "update h_news set Image='".$imageName."' where newsID='".$newsID."'";
				return $this->query($strSQLQuery, 0);
			}
		}


		function isNewsExists($heading,$newsID)
		{

			$strSQLQuery ="select * from h_news where LCASE(heading)='".strtolower(trim($heading))."'";

			$strSQLQuery .= (!empty($newsID))?(" and newsID != '".$newsID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['newsID'])) {
				return true;
			} else {
				return false;
			}


		}


		
		////////////Department Management Start ///// 

		function addDepartment($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_department (Division,Department,Status) values('".$Division."', '".addslashes($Department)."', '".$Status."')";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateDepartment($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($depID)){
				$sql = "update h_department set Division = '".$Division."',Department = '".addslashes($Department)."', Status = '".$Status."'  where depID = '".$depID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}
		function getDepartment($id=0,$Division,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and d.depID = '".$id."'"):("");
			$sql .= (!empty($Division))?(" and d.Division = '".$Division."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and d.Status = '".$Status."'"):("");

			$sql = "select d.*,e.EmpID, e.UserName,e.Email,e.JobTitle from h_department d left outer join h_employee e on (d.depID=e.Department and e.DeptHead=1 and e.locationID=".$_SESSION['locationID'].") ".$sql." group by d.depID  order by d.depID Asc " ;
			return $this->query($sql, 1);
		}

		
		function changeDepartmentStatus($depID)
		{
			if(!empty($depID)){
				$sql="select * from h_department where depID='".$depID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_department set Status='$Status' where depID='".$depID."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteDepartment($depID)
		{
			if(!empty($depID)){
				$sql = "delete from h_department where depID = '".mysql_real_escape_string($depID)."'";
				$rs = $this->query($sql,0);
			}
			
			return true;

		}
		
		function isDepartmentExists($Department,$depID)
		{

			$strSQLQuery ="select depID from h_department where LCASE(Department)='".strtolower(trim($Department))."'";
			#if(!empty($_SESSION['CmpDepartment'])) $strSQLQuery .= " and Division in (".$_SESSION['CmpDepartment'].")";

			$strSQLQuery .= (!empty($depID))?(" and depID != '".$depID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['depID'])) {
				return true;
			} else {
				return false;
			}


		}

		function addUpdateDepartment($Department)
		{
			$strSQLQuery ="select depID from h_department where LCASE(Department)='".strtolower(trim($Department))."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['depID'])) {
				$depID = $arryRow[0]['depID'];
			}else{	$Division=1; $Status=1;
			$sql = "insert into h_department (Division,Department,Status) values('".$Division."', '".addslashes($Department)."', '".$Status."')";		
			$this->query($sql, 0);
			$depID = $this->lastInsertId();
			}
			return $depID;

		}


		////////////Global Settings Start ///// 

		function UpdateGlobal($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($depID)){
				$sql = "update h_setting set Division = '".$Division."',Department = '".addslashes($Department)."', Status = '".$Status."'  where depID = '".$depID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}



	/*************************************/
	/********Employee Request ************/

	/************************Code Edit By Rajeev*******************************/
        function sendRequestEmail($arryDetails)
        {
                @extract($arryDetails);
                 global $Config;   
               
                $strSQLQuery = "select e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_employee e left outer join h_department d on e.Department=d.depID where e.EmpID = '". mysql_real_escape_string($EmpID)."'";   

                $arryRow = $this->query($strSQLQuery, 1);
             
                $htmlPrefix = $Config['EmailTemplateFolder'];
                $contents = file_get_contents($htmlPrefix."send_request.htm");
               
                $CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
                $contents = str_replace("[URL]",$Config['Url'],$contents);
                $contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
                $contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
                $contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
                $contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
                $contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
                $contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
                $contents = str_replace("[Subject]",mysql_real_escape_string(strip_tags($request_subject)),$contents);
                $contents = str_replace("[Message]",mysql_real_escape_string(strip_tags($request_message)),$contents);
                $contents = str_replace("[ApplyDate]",date("j M Y"),$contents);
                   
                $mail = new MyMailer();
                $mail->IsMail();           
                $mail->AddAddress($Config['AdminEmail']);
                if(!empty($Config['DeptHeadEmail'])){
                    $mail->AddCC($Config['DeptHeadEmail']);
                }
                       
                $mail->sender($Config['SiteName'], $Config['AdminEmail']);  
                $mail->Subject = $Config['SiteName']."-".mysql_real_escape_string(strip_tags($request_subject));
                $mail->IsHTML(true);
                $mail->Body = $contents; 
                //echo $Config['DeptHeadEmail']."<br>".$Config['AdminEmail'].$contents; exit;
                if($Config['Online'] == '1'){
                    $mail->Send();   
                }

           
        }
       
        function addRequest($arryDetails){  
            extract($arryDetails);   
              global $Config;   
               
                $strSQLQuery = "select e.EmpID,e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_employee e left outer join h_department d on e.Department=d.depID WHERE e.EmpID = '". mysql_real_escape_string($EmpID)."'";   
                $arryRow = $this->query($strSQLQuery, 1);
           
            $strSQLQuery = "insert into h_request SET EmpID = '".mysql_real_escape_string($EmpID)."',UserName = '".mysql_real_escape_string($arryRow[0]['UserName'])."', EmpCode = '".mysql_real_escape_string($arryRow[0]['EmpCode'])."', Department = '".mysql_real_escape_string($arryRow[0]['Department'])."', Subject = '".mysql_real_escape_string(strip_tags($request_subject))."', Message = '".mysql_real_escape_string(strip_tags($request_message))."', RequestDate = '".$Config['TodayDate']."'";

            $this->query($strSQLQuery, 0);
            return 1;
    }
   

    function moveRequest($arryDetails){  
            extract($arryDetails);   
             global $Config;   

			$arryNews["heading"] = $request_subject;
			$arryNews["detail"] = $request_message;
			$arryNews["newsDate"] = $Config['TodayDate'];
			$arryNews["Status"] = 1;
			$this->addNews($arryNews);

			$sql = "update h_request set Moved = '1' where RequestID = '".$RequestID."'"; 
			$rs = $this->query($sql,0);

            return 1;
    }


     function  ListRequest($id=0,$SearchKey,$SortBy,$AscDesc,$FromDate,$ToDate)
        {
            $strAddQuery = " where 1 = 1 ";
            $SearchKey   = strtolower(trim($SearchKey));
           
            $strAddQuery .= (!empty($FromDate))?(" and RequestDate>='".mysql_real_escape_string($FromDate)."'"):("");
            $strAddQuery .= (!empty($ToDate))?(" and RequestDate<='".mysql_real_escape_string($ToDate)."'"):("");
           
            if($SortBy != ''){
                $strAddQuery .= (!empty($SearchKey))?(" and (".mysql_real_escape_string($SortBy)." like '%".$SearchKey."%')"):("");
            }else{
                $strAddQuery .= (!empty($SearchKey))?(" and (UserName like '%".mysql_real_escape_string($SearchKey)."%'  or EmpCode like '%".mysql_real_escape_string($SearchKey)."%'  or Department like '%".mysql_real_escape_string($SearchKey)."%' ) " ):("");       
            }

            $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" Order by RequestID DESC ");
             $strSQLQuery = "SELECT * FROM h_request ".$strAddQuery." ";
            //echo "=>".$strSQLQuery;
             return $this->query($strSQLQuery, 1);       
               
        }   
       
        function RemoveRequest($RequestID)
        {
            $strSQLQuery = "DELETE FROM h_request WHERE RequestID = '".mysql_real_escape_string($RequestID)."'";
            $this->query($strSQLQuery, 0);

            return 1;

        }
       function getRequest($RequestID)
        {
             $SqlCustomer = "SELECT * FROM h_request WHERE RequestID = '".mysql_real_escape_string($RequestID)."'";
            return $this->query($SqlCustomer, 1);
        }
   




    /**************************End Code By Rajeev**************************************************/


		////////////Shift Management Start ///// 

		function addShift($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_shift (locationID, shiftName, detail, Status, WorkingHourStart, WorkingHourEnd, SL_Coming, SL_Leaving) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($shiftName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($WorkingHourStart)."', '".mysql_real_escape_string($WorkingHourEnd)."', '".mysql_real_escape_string($SL_Coming)."', '".mysql_real_escape_string($SL_Leaving)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateShift($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($shiftID)){
				$sql = "update h_shift set shiftName = '".mysql_real_escape_string($shiftName)."', detail = '".mysql_real_escape_string($detail)."', WorkingHourStart = '".mysql_real_escape_string($WorkingHourStart)."', WorkingHourEnd = '".mysql_real_escape_string($WorkingHourEnd)."', SL_Coming = '".mysql_real_escape_string($SL_Coming)."', SL_Leaving = '".mysql_real_escape_string($SL_Leaving)."', Status = '".$Status."'  where shiftID = '".$shiftID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getShift($id=0,$Status=0)
		{
			$sql = " where locationID=".$_SESSION['locationID'];
			$sql .= (!empty($id))?(" and shiftID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_shift ".$sql." order by shiftID asc" ;
			return $this->query($sql, 1);
		}

		function changeShiftStatus($shiftID)
		{
			if(!empty($shiftID)){
				$sql="select * from h_shift where shiftID='".mysql_real_escape_string($shiftID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_shift set Status='$Status' where shiftID='".mysql_real_escape_string($shiftID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteShift($shiftID)
		{
			if(!empty($shiftID)){
				$sql = "delete from h_shift where shiftID = '".mysql_real_escape_string($shiftID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
	
		function isShiftExists($shiftName,$shiftID)
		{

			$strSQLQuery ="select * from h_shift where locationID='".$_SESSION['locationID']."' and LCASE(shiftName)='".strtolower(trim($shiftName))."'";

			$strSQLQuery .= (!empty($shiftID))?(" and shiftID != '".$shiftID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['shiftID'])) {
				return true;
			} else {
				return false;
			}


		}


		////////////Tier Management Start ///// 

		function addTier($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_tier (locationID, tierName, detail, Status, RangeFrom, RangeTo, Percentage) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($tierName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($RangeFrom)."', '".mysql_real_escape_string($RangeTo)."', '".mysql_real_escape_string($Percentage)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateTier($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($tierID)){
				$sql = "update h_tier set tierName = '".mysql_real_escape_string($tierName)."', detail = '".mysql_real_escape_string($detail)."', RangeFrom = '".mysql_real_escape_string($RangeFrom)."', RangeTo = '".mysql_real_escape_string($RangeTo)."', Percentage = '".mysql_real_escape_string($Percentage)."', Status = '".$Status."'  where tierID = '".mysql_real_escape_string($tierID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getTier($id=0,$Status=0)
		{
			$sql = " where locationID=".$_SESSION['locationID'];
			$sql .= (!empty($id))?(" and tierID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_tier ".$sql." order by RangeFrom asc,RangeTo asc";
			return $this->query($sql, 1);
		}

		function changeTierStatus($tierID)
		{
			if(!empty($tierID)){
				$sql="select * from h_tier where tierID='".mysql_real_escape_string($tierID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_tier set Status='$Status' where tierID='".mysql_real_escape_string($tierID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteTier($tierID)
		{
			if(!empty($tierID)){
				$sql = "delete from h_tier where tierID = '".mysql_real_escape_string($tierID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}
		
	
		function isTierNameExists($tierName,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."' and LCASE(tierName)='".strtolower(trim($tierName))."'";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}

	
		function isCommissionTierExists($RangeFrom,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."' and LCASE(RangeFrom)='".strtolower(trim($RangeFrom))."'";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");

			
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}

			

		function isTierRangeExists($RangeFrom,$RangeTo,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."'  ";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");
			$strSQLQuery .= (!empty($RangeFrom))?(" and ( ".$RangeFrom.">=RangeFrom and ".$RangeFrom."<=RangeTo) "):("");
			$strSQLQuery .= (!empty($RangeTo))?(" and ( ".$RangeTo.">=RangeFrom and ".$RangeTo."<=RangeTo) "):("");

			//echo $strSQLQuery; exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}


		function isTierFromToExists($RangeFrom,$RangeTo,$tierID)
		{

			$strSQLQuery ="select * from h_tier where locationID='".$_SESSION['locationID']."'  ";

			$strSQLQuery .= (!empty($tierID))?(" and tierID != '".$tierID."'"):("");

			$strSQLQuery .= (!empty($RangeFrom))?(" and RangeFrom = '".$RangeFrom."'"):("");
			$strSQLQuery .= (!empty($RangeTo))?(" and RangeTo = '".$RangeTo."'"):("");

			//echo $strSQLQuery; exit;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['tierID'])) {
				return true;
			} else {
				return false;
			}


		}



		////////////Spiff Tier Management Start ///// 

		function addSpiffTier($arryDetails)
		{
			@extract($arryDetails);	
			$sql = "insert into h_spiff (locationID, tierName, detail, Status, SalesTarget, SpiffAmount) values('".$_SESSION['locationID']."', '".mysql_real_escape_string($tierName)."', '".mysql_real_escape_string($detail)."', '".$Status."', '".mysql_real_escape_string($SalesTarget)."', '".mysql_real_escape_string($SpiffAmount)."')";		
			$this->query($sql, 0);
			return true;
		}
		function updateSpiffTier($arryDetails)
		{
			@extract($arryDetails);	
			if(!empty($spiffID)){
				$sql = "update h_spiff set tierName = '".mysql_real_escape_string($tierName)."', detail = '".mysql_real_escape_string($detail)."', SalesTarget = '".mysql_real_escape_string($SalesTarget)."', SpiffAmount = '".mysql_real_escape_string($SpiffAmount)."', Status = '".$Status."'  where spiffID = '".mysql_real_escape_string($spiffID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getSpiffTier($id=0,$Status=0)
		{
			$sql = " where locationID=".$_SESSION['locationID'];
			$sql .= (!empty($id))?(" and spiffID = '".mysql_real_escape_string($id)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from h_spiff ".$sql." order by SalesTarget asc";
			return $this->query($sql, 1);
		}

		function changeSpiffTierStatus($spiffID)
		{
			if(!empty($spiffID)){
				$sql="select * from h_spiff where spiffID='".mysql_real_escape_string($spiffID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_spiff set Status='$Status' where spiffID='".mysql_real_escape_string($spiffID)."'";
					$this->query($sql,0);
				}	
			}

			return true;

		}

		function deleteSpiffTier($spiffID)
		{
			if(!empty($spiffID)){
				$sql = "delete from h_spiff where spiffID = '".mysql_real_escape_string($spiffID)."'";
				$rs = $this->query($sql,0);
			}

			return true;

		}


		function isSpiffNameExists($tierName,$spiffID)
		{

			$strSQLQuery ="select * from h_spiff where locationID='".$_SESSION['locationID']."' and LCASE(tierName)='".strtolower(trim($tierName))."'";

			$strSQLQuery .= (!empty($spiffID))?(" and spiffID != '".$spiffID."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['spiffID'])) {
				return true;
			} else {
				return false;
			}


		}

		function isSpiffTargetExists($SalesTarget,$spiffID)
		{

			$strSQLQuery ="select * from h_spiff where locationID='".$_SESSION['locationID']."' and LCASE(SalesTarget)='".strtolower(trim($SalesTarget))."'";

			$strSQLQuery .= (!empty($spiffID))?(" and spiffID != '".$spiffID."'"):("");

			
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['spiffID'])) {
				return true;
			} else {
				return false;
			}


		}



}

?>
