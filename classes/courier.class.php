<?
class courier extends dbClass
{
		//constructor
		function courier()
		{
			$this->dbClass();
		} 
		

		function  ListCourier($id=0,$country_id,$city_id,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = ' where 1';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and s.courier_id='".$id."'"):("");
			$strAddQuery .= (!empty($country_id))?(" and s.country_id='".$country_id."'"):("");
			$strAddQuery .= (!empty($city_id))?(" and s.city_id='".$city_id."'"):(" and s.city_id<='0' ");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (s.name like '".$SearchKey."%' or s.price like '".$SearchKey."%')"):("");
			}



			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy."   "):(" order by s.courier_id ");

			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			 $strSQLQuery = "select s.*,c.name as country_name from courier s inner join country c on s.country_id=c.country_id ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function addCourier($_REQUEST)
		{
			extract($_REQUEST);
			$sql="insert into courier (name,price,country_id,city_id,detail) values('".addslashes($name)."','".addslashes($price)."','".$country_id."','".$city_id."','".addslashes($detail)."')";
			$this->query($sql,0);
			return true;
		}

		function AddCourierDefault($country_id)
		{
			extract($_REQUEST);
			$sql="insert into courier(name,price,country_id,fixed) values('Trubaya Consolidated Delivery','5','".$country_id."',1)";
			$this->query($sql,0);
			return true;
		}
		
		function updateCourier($_REQUEST)
		{
			extract($_REQUEST);
			$sql="update courier set name='".addslashes($name)."',price='".addslashes($price)."', country_id='".$country_id."',city_id='".$city_id."',detail='".addslashes($detail)."' where courier_id='".$courier_id."'"; 
			$this->query($sql,0);
			return true;
		}
		
	
		function getCourier($courier_id,$Status)
		{
			$strAddQuery  = " where  1"; 
			$strAddQuery .= (!empty($courier_id))?(" and s.courier_id='".$courier_id."'"):("");
			$strAddQuery .= (!empty($Status))?(" and s.Status='".$Status."'"):("");

			$strSQLQuery = "select s.*,c.name as country_name,ct.name as city_name from courier s inner join country c on s.country_id=c.country_id left outer join city ct on s.city_id=ct.city_id".$strAddQuery." order by s.name";
			return $this->query($strSQLQuery, 1);
		}

		function getCourierByCountry($country_id)
		{
			$strAddQuery = (!empty($country_id))?(" where s.country_id='".$country_id."'"):("");

			$strSQLQuery = "select s.* from courier s inner join country c on s.country_id=c.country_id ".$strAddQuery." order by s.name asc";
			return $this->query($strSQLQuery, 1);
		}

		function getCityByCountry($country_id)
		{
			$strAddQuery = (!empty($country_id))?(" where ct.country_id='".$country_id."'"):("");

			$strSQLQuery = "select ct.* from city ct inner join country c on ct.country_id=c.country_id ".$strAddQuery." order by ct.name";
			return $this->query($strSQLQuery, 1);
		}

		function getFixedCourier($country_id)
		{
			$strAddQuery = (!empty($country_id))?(" and country_id='".$country_id."'"):("");

			$strSQLQuery = "select * from courier where fixed=1 ".$strAddQuery." order by name";
			return $this->query($strSQLQuery, 1);
		}
		
		function changeCourierStatus($courier_id)
		{
			$sql="select * from courier where courier_id='".$courier_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update courier set Status='$Status' where courier_id='".$courier_id."'";
				$this->query($sql,0);
				return true;
			}			
		}
		
		function deleteCourier($courier_id)
		{
			$sql="delete from courier where courier_id='".$courier_id."'";
			$this->query($sql,0);
			return true;
		}


		function isCourierExists($name,$country_id,$city_id,$courier_id)
		{
			$sql ="select * from courier where country_id='".$country_id."' and LCASE(name) = '".strtolower(trim($name))."'";
			$sql .= (!empty($courier_id))?(" and courier_id != '".$courier_id."'"):("");
			$sql .= (!empty($city_id))?(" and city_id = '".$city_id."'"):(" and city_id<='0' ");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['courier_id'])) {
				return true;
			} else {
				return false;
			}
		}
		

		function getCountryList($country_id,$Status)
		{
			$sql  = " where 1"; 
			$sql .= (!empty($country_id))?(" and country_id='".$country_id."'"):("");
			$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$sql="select * from country ".$sql." order by name";
			return $this->query($sql);
		}


}

?>
