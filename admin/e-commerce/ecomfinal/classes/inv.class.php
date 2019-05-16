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

			$strSQLQuery = "select v.* from inv_attribute_value v inner join inv_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetAttributeByValue($attribute_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and locationID=".$_SESSION['locationID']):("");

			$strSQLFeaturedQuery .= (!empty($attribute_value))?(" and v.attribute_value like '".$attribute_value."%'"):("");

			$strSQLQuery = "select v.attribute_value from inv_attribute_value v inner join inv_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	

		function GetCrmAttribute($attribute_name,$OrderBy)
		{

			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			 $strSQLQuery = "select v.* from inv_attribute_value v inner join inv_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;
			

			return $this->query($strSQLQuery, 1);
		}

		function getAllCrmAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = ".$id):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = ".$attribute_id):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from inv_attribute_value ".$sql." order by value_id asc" ;

			return $this->query($sql, 1);
		}


		function  GetFixedAttribute($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from inv_attribute_value v inner join inv_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllAttributes($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and attribute_id in(".$id.")"):("");
		
			$strSQLQuery = "select * from inv_attribute ".$strSQLQuery." order by attribute_id Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
			
		function addAttribute($arryAtt)
		{
			
			@extract($arryAtt);	 
			$sql = "insert into inv_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();

			if(sizeof($rs))
				return $lastInsertId;
			else
				return false;

		}
		function updateAttribute($arryAtt)
		{
			@extract($arryAtt);	
			$sql = "update inv_attribute_value set attribute_value = '".addslashes($attribute_value)."',attribute_id = '".$attribute_id."',Status = '".$Status."'  where editable=1 and value_id = ".$value_id; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function getAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = ".$id):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($attribute_id))?(" and attribute_id = ".$attribute_id):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from inv_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}
		function countAttributes()
		{
			$sql = "select sum(1) as NumAttribute from inv_attribute_value where Status=1" ;
			return $this->query($sql, 1);
		}

		function changeAttributeStatus($value_id)
		{
			$sql="select * from inv_attribute_value where value_id=".$value_id;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update inv_attribute_value set Status='$Status' where value_id=".$value_id;
				$this->query($sql,0);
				return true;
			}			
		}

		function deleteAttribute($id)
		{
			$sql = "delete from inv_attribute_value where value_id = ".$id;
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;
		}
	
		function isAttributeExists($attribute_value,$attribute_id,$value_id)
			{

				$strSQLQuery ="select value_id from inv_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and locationID=".$_SESSION['locationID'];

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

		/****************************************/


}

?>