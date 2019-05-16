<?
class region extends dbClass
{
		//constructor
		
		
		function  ListCountry($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			//$strAddQuery = ' where c1.continent_id=2';
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and c1.country_id='".$id."'"):("");

			$strAddQuery .= (!empty($SearchKey))?(" and (c1.name like '".$SearchKey."%')"):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c1.name ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select c1.* from country c1 ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		function addCountry($ArryRequest)
		{
			extract($ArryRequest);
			$sql="insert into country (name,continent_id) values('".addslashes($name)."','".$continent_id."')"; 
			$this->query($sql,0);
			return true;
		}
		
		function updateCountry($ArryRequest)
		{
			extract($ArryRequest);
			$sql="update country set name='".addslashes($name)."',continent_id='".$continent_id."' where country_id='".$country_id."'"; 
			$this->query($sql,0);
			return true;
		}
		
	
		function getCountry($country_id,$Status)
		{
			//$sql  = " where continent_id=2"; 
			$sql  = " where 1"; 
			$sql .= (!empty($country_id))?(" and country_id='".$country_id."'"):("");
			$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$sql="select * from country ".$sql." order by name";
 			
			 return $this->get_results($sql, ARRAY_A);
		}
		function getCountryWithCode($country_id,$Status)
		{
			//$sql  = " where continent_id=2"; 
			$sql  = " where code !='' "; 
			$sql .= (!empty($country_id))?(" and country_id='".$country_id."'"):("");
			$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$sql="select * from country ".$sql." order by name";
			return $this->query($sql);
		}
		

		function getStoreCountry()
		{
			$sql="select * from country order by name";
			return $this->query($sql);
		}

		function getCountryIsd($country_id,$Status)
		{
			//$sql  = " where continent_id=2"; 
			$sql  = " where 1"; 
			$sql .= (!empty($country_id))?(" and country_id='".$country_id."'"):("");
			$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$sql="select distinct(isd_code) from country ".$sql." order by isd_code";
			return $this->query($sql);
		}
		
		function getCountryByContinent($country_id,$continent_id)
		{
			$sql  = " where 1"; 
			$sql .= (!empty($country_id))?(" and country_id='".$country_id."'"):("");
			$sql .= (!empty($continent_id))?(" and continent_id='".$continent_id."'"):("");

			$sql="select * from country ".$sql." order by name";
			return $this->query($sql);
		}

		function  GetCountryName($CountryID)
		{
			$strSQLQuery = "select name from country where country_id ='".$CountryID."'";
		
			return $this->get_results($strSQLQuery);
		}

		


		function getContinent($continent_id)
		{
			$sql  = " where 1"; 
			$sql .= (!empty($continent_id))?(" and continent_id='".$continent_id."'"):("");

			$sql="select * from continent ".$sql." order by name";
			return $this->query($sql);
		}

		function changeCountryStatus($country_id)
		{
			$sql="select * from country where country_id='".$country_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update country set Status='$Status' where country_id='".$country_id."'";
				$this->query($sql,0);
				return true;
			}			
		}
		
		function deleteCountry($country_id)
		{
			 $sql="delete from country where country_id='".$country_id."'";
			$this->query($sql,0);
			return true;
		}


		function isCountryExists($name,$country_id)
		{
			$sql ="select * from country where LCASE(name) = '".strtolower(trim($name))."'";
			$sql .= (!empty($country_id))?(" and country_id != '".$country_id."'"):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['country_id'])) {
				return true;
			} else {
				return false;
			}
		}



		function  GetCountryID($name)
		{
			$strSQLQuery = "select country_id from country where LCASE(name)='".mysql_real_escape_string(strtolower(trim($name)))."'";
			return $this->query($strSQLQuery, 1);
		}

		function  GetStateID($name,$country_id)
		{
			$strSQLQuery = "select state_id from state where country_id='".$country_id."' and LCASE(name)='".mysql_real_escape_string(strtolower(trim($name)))."'";
			return $this->query($strSQLQuery, 1);
		}
		function  GetCityID($name,$country_id)
		{
			$strSQLQuery = "select city_id from city where country_id='".$country_id."' and LCASE(name)='".strtolower(trim($name))."'";
			return $this->query($strSQLQuery, 1);
		}

		function  GetCityIDSt($name,$state_id, $country_id)
		{
			$strSQLQuery = "select city_id from city where country_id='".$country_id."' and state_id='".$state_id."' and LCASE(name)='".strtolower(trim($name))."'";
			
			return $this->query($strSQLQuery, 1);
		}


		/////////////**********  State function  *********///////////



		function  ListState($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			//$strAddQuery = ' where c.continent_id=2';
			$strAddQuery = ' where 1';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and s.state_id='".$id."'"):("");


			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (s.name like '".$SearchKey."%' or c.name like '".$SearchKey."%')"):("");
			}



			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy."   "):(" order by s.name ");

			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select s.*,c.name as country_name from state s inner join country c on s.country_id=c.country_id ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function addState($ArryRequest)
		{
			extract($ArryRequest);
			$sql="insert into state (name,country_id) values('".addslashes(trim($name))."','".$country_id."')";
			$this->query($sql,0);			
       			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;
		}
		
		function updateState($ArryRequest)
		{
			extract($ArryRequest);
			$sql="update state set name='".addslashes(trim($name))."', country_id='".$country_id."' where state_id='".$state_id."'"; 
			$this->query($sql,0);
			return true;
		}
		
	
		function getState($state_id,$Status)
		{
			//$strAddQuery  = " where  c.continent_id=2"; 
			$strAddQuery  = " where  1"; 
			$strAddQuery .= (!empty($state_id))?(" and s.state_id='".$state_id."'"):("");
			$strAddQuery .= (!empty($Status))?(" and s.Status='".$Status."'"):("");

			$strSQLQuery = "select s.*,c.name as country_name from state s inner join country c on s.country_id=c.country_id ".$strAddQuery." order by s.name";
			return $this->query($strSQLQuery, 1);
		}

		function  getStateName($state_id)
		{
			$strSQLQuery = "select name from state where state_id ='".$state_id."'";
			return $this->query($strSQLQuery, 1);
		}
                
               /*function add by rajeev*/
                function  getAllStateName($state_id)
		{
			$strSQLQuery = "select name from state where state_id in (".$state_id.")";
			
			$arryState =  $this->get_results($strSQLQuery);
			
                                                      for($i=0;$i<count($arryState);$i++)
                                                        {
                                                            $StateName .= stripslashes($arryState[$i]->name).", ";
                                                        }
                                                        return rtrim($StateName,", ");
		}
                
                function  getAllCityName($city_id)
		{
			$strSQLQuery = "select name from city where city_id in (".$city_id.")";
			$arryCity =  $this->query($strSQLQuery, 1);
                                                      for($i=0;$i<count($arryCity);$i++)
                                                        {
                                                            $CityName .= stripslashes($arryCity[$i]["name"]).", ";
                                                        }
                                                        return rtrim($CityName,", ");
		}
                
                
                function getStateByCountryForTerritory($country_id,$key)
		{
                    
                        
                       
                        
			$strAddQuery = (!empty($country_id))?(" where s.country_id='".$country_id."'"):("");
                        $strAddQuery .= (!empty($key))?(" and s.name like '%".trim($key)."%'"):("");

			$strSQLQuery = "select s.* from state s inner join country c on s.country_id=c.country_id ".$strAddQuery." order by s.name asc";
			return $this->query($strSQLQuery, 1);
		}
                
                function getCityByStateForTerritory($state_id,$key)
		{
			if(!empty($state_id)){
                            
				$strAddQuery = " where c.state_id='".$state_id."'";
                                $strAddQuery .= (!empty($key))?(" and c.name like '%".trim($key)."%'"):("");
                                 
				$strSQLQuery = "select c.* from city c inner join state s on c.state_id=s.state_id ".$strAddQuery." order by c.name";
                                //echo "=>".$strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
			}
		}
                
                /*end function by rajeev*/

		function getStateByCountry($country_id)
		{
			$strAddQuery = (!empty($country_id))?(" where s.country_id='".$country_id."'"):("");

			$strSQLQuery = "select s.* from state s inner join country c on s.country_id=c.country_id ".$strAddQuery." order by s.name asc";
			return $this->query($strSQLQuery, 1);
		}

		function getOtherState($country_id)
		{
			//$strAddQuery = ' where c.continent_id=2';
			$strAddQuery = ' where 1';
			
			$strAddQuery .= (!empty($country_id))?(" and s.country_id!='".$country_id."'"):("");

			$strSQLQuery = "select s.* from state s inner join country c on s.country_id=c.country_id ".$strAddQuery." order by s.name asc";
			return $this->query($strSQLQuery, 1);
		}
		
		function getCityByState($state_id)
		{
			if(!empty($state_id)){
				$strAddQuery = " where c.state_id='".$state_id."'";

				$strSQLQuery = "select c.* from city c inner join state s on c.state_id=s.state_id ".$strAddQuery." order by c.name";
				return $this->query($strSQLQuery, 1);
			}
		}

		function changeStateStatus($state_id)
		{
			$sql="select * from state where state_id='".$state_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update state set Status='$Status' where state_id='".$state_id."'";
				$this->query($sql,0);
				return true;
			}			
		}
		
		function deleteState($state_id)
		{
			$sql="delete from state where state_id='".$state_id."'";
			$this->query($sql,0);
			return true;
		}


		function isStateExists($name,$country_id,$state_id)
		{
			$sql ="select * from state where country_id='".$country_id."' and LCASE(name) = '".strtolower(trim($name))."'";
			$sql .= (!empty($state_id))?(" and state_id != '".$state_id."'"):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['state_id'])) {
				return true;
			} else {
				return false;
			}
		}
		

		/////////////**********  City function  *********///////////


		function  ListCity($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			//$strAddQuery = ' where  c.continent_id=2';
			$strAddQuery = ' where  1';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and ct.city_id='".$id."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (ct.name like '".$SearchKey."%' or s.name like '".$SearchKey."%' or c.name like '".$SearchKey."%')"):("");
			}
		

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by ct.name ");

			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select ct.*,s.name as state_name,c.name as country_name from city ct inner join country c on ct.country_id=c.country_id inner join state s on ct.state_id=s.state_id  ".$strAddQuery;

			//$strSQLQuery = "select ct.*,c.name as country_name from city ct inner join country c on ct.country_id=c.country_id ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

		function addCity($ArryRequest)
		{
			extract($ArryRequest);
			$sql="insert into city (name,state_id,country_id) values('".addslashes(trim($name))."','".$main_state_id."','".$country_id."')";
			$this->query($sql,0);
			$lastInsertId = $this->lastInsertId();			
			return $lastInsertId;

		}
		
		function updateCity($ArryRequest)
		{
			extract($ArryRequest);
			$sql="update city set name='".addslashes(trim($name))."', state_id='".$main_state_id."', country_id='".$country_id."' where city_id='".$city_id."'"; 
			$this->query($sql,0);
			return true;
		}
		
	
		function getCity($city_id,$Status)
		{
			$strAddQuery  = " where 1"; 
			$strAddQuery .= (!empty($city_id))?(" and ct.city_id='".$city_id."'"):("");
			$strAddQuery .= (!empty($Status))?(" and ct.Status='".$Status."'"):("");

			$strSQLQuery = "select ct.*,s.name as state_name,c.name as country_name from city ct inner join state s on ct.state_id=s.state_id inner join country c on s.country_id=c.country_id ".$strAddQuery." order by ct.name";

			return $this->query($strSQLQuery, 1);
		}

		function  getCityName($city_id)
		{
			$strSQLQuery = "select name from city where city_id ='".$city_id."'";
			return $this->query($strSQLQuery, 1);
		}

		function changeCityStatus($city_id)
		{
			$sql="select * from city where city_id='".$city_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update city set Status='$Status' where city_id='".$city_id."'";
				$this->query($sql,0);
				return true;
			}			
		}
		
		function deleteCity($city_id)
		{
			$sql="delete from city where city_id='".$city_id."'";
			$this->query($sql,0);
			return true;
		}

		function isCityExists($name,$state_id,$city_id)
		{
			$sql ="select * from city where state_id='".$state_id."' and LCASE(name) = '".strtolower(trim($name))."'";
			$sql .= (!empty($city_id))?(" and city_id != '".$city_id."'"):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['city_id'])) {
				return true;
			} else {
				return false;
			}
		}

		function getLanguage($languages_id,$Status)
		{
			$sql  = " where 1"; 
			$sql .= (!empty($languages_id))?(" and languages_id='".$languages_id."'"):("");
			$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$sql="select * from languages ".$sql." order by sort_order";
			return $this->query($sql);
		}

		function changeLanguageStatus($languages_id)
		{
			$sql="select * from languages where languages_id='".$languages_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update languages set Status='$Status' where languages_id='".$languages_id."'";
				$this->query($sql,0);
				return true;
			}			
		}


		/* ************** Currency Functions ****************/
		
		function  ListCurrency($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and currency_id ='".$id."'"):("");


			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (name like '".$SearchKey."%' or code like '%".$SearchKey."%' or symbol_left like '".$SearchKey."%' or symbol_right like '".$SearchKey."%')"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by currency_id ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from currencies".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}
	
		function addCurrency($ArryRequest)
		{
			extract($ArryRequest);
			$sql="insert into currencies (name, code, symbol_left, symbol_right, Status,currency_value) values('".addslashes($name)."', '".addslashes($code)."', '$symbol_left', '$symbol_right', '$Status','".addslashes($currency_value)."')";
			$this->query($sql,0);
			return true;
		}
		
		function updateCurrency($ArryRequest)
		{
			extract($ArryRequest);
			$sql="update currencies set name='".addslashes($name)."', code='".addslashes($code)."', symbol_left='".$symbol_left."', symbol_right='".$symbol_right."', Status='".$Status."', currency_value='".$currency_value."' where currency_id ='".$currency_id."'" ; 
			$this->query($sql,0);
			return true;
		}
		
		function getAllCurrency()
		{
			$sql="select * from currencies order by position";
			return $this->query($sql);
		}
		
		function getCurrency($currency_id,$Status)
		{
			$sql  = " where 1 "; 
			$sql .= (!empty($currency_id ))?(" and currency_id ='".$currency_id."'" ):("");
			$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$sql="select * from currencies ".$sql." order by name";
			return $this->get_results($sql, ARRAY_A);
		}
                
                function getPaymentCurrency($currency_id)
		{
			
			$sql="select * from currencies where code = '".trim($currency_id)."'";
			return $this->query($sql);
		}


		function getUpdatedCurrency($currency_id,$Status)
		{
			
			if($currency_id>0){
				$updated_date = date('Y-m-d');
				$sql="select * from currencies where currency_id ='".$currency_id."' and updated_date!='".$updated_date."'" ;
				#$sql="select * from currencies where currency_id ='".$currency_id."'" ;


				$rs = $this->query($sql);
				if($rs['0']['currency_id']>0 && $rs['0']['code']!='USD'){
					/*******************************
					$from_currency = 'USD';
					$to_currency = $rs['0']['code'];
					$amount = 1;

					
					 $lines = file("http://www.webservicex.com/CurrencyConvertor.asmx/ConversionRate?FromCurrency=".$from_currency."&ToCurrency=".$to_currency);
					 
					$arr = xml2array($lines[0].$lines[1]);

					$res = $arr['double']['value'];
					//$temp = bcmul($amount ,$res,2);
					$currency_value = $res;

					if(empty($currency_value)) $currency_value = 1;

					$sql_update="update currencies set updated_date='".$updated_date."', currency_value='".$currency_value."' where currency_id =".$currency_id ; 
					$this->query($sql_update,0);
					*******************************/
				}
			}
			
			
			$sql  = " where 1 "; 
			$sql .= (!empty($currency_id ))?(" and currency_id ='".$currency_id."'" ):("");
			$sql .= (!empty($Status))?(" and Status='".$Status."'"):("");

			$sql="select * from currencies ".$sql." order by name";
			return $this->query($sql);
		}

		function changeCurrencyStatus($currency_id)
		{
			$sql="select * from currencies where currency_id ='".$currency_id."'" ;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update currencies set Status='$Status' where currency_id ='".$currency_id."'" ;
				$this->query($sql,0);
				return true;
			}			
		}
		
		function deleteCurrency($currency_id)
		{
			$sql="delete from currencies where currency_id ='".$currency_id."'" ;
			$this->query($sql,0);
			return true;
		}


		function isCurrencyExists($name,$currency_id)
		{
			$sql ="select * from currencies where LCASE(name) = '".strtolower(trim($name))."'";
			$sql .= (!empty($currency_id ))?(" and currency_id != '".$currency_id."'" ):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['currency_id'])) {
				return true;
			} else {
				return false;
			}
		}


		function isCurrencyCodeExists($code,$currency_id)
		{
			$sql ="select * from currencies where LCASE(code) = '".strtolower(trim($code))."'";
			$sql .= (!empty($currency_id ))?(" and currency_id != '".$currency_id."'" ):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['currency_id'])) {
				return true;
			} else {
				return false;
			}
		}


		/*************Start of Zip Code *******************/
		function addZipCode($ArryRequest){			
			extract($ArryRequest);
		
			$ZipArray=explode(",",$zip_code);
			if(sizeof($ZipArray)>0){			
				foreach($ZipArray as $Zip){
					if(!empty($Zip)){
						$sql="insert ignore into zipcode (zip_code,country_id,state_id,city_id) values('".trim(addslashes($Zip))."','".$country_id."','".$main_state_id."','".$main_city_id."')";
						$this->query($sql,0);	
					}
							
				}
			}
			return true;		
		}
		
		function addZip($ArryRequest){			
			extract($ArryRequest);
			
			$sql="insert ignore into zipcode (zip_code,country_id,state_id,city_id) values('".addslashes($zip_code)."','".$country_id."','".$main_state_id."','".$main_city_id."')";
			$this->query($sql,0);	
			$lastInsertId = $this->lastInsertId();			
			return $lastInsertId;		
		}


		function updateZipCode($ArryRequest){
			extract($ArryRequest);
			$sql="update zipcode set zip_code='".addslashes($zip_code)."', state_id='".$main_state_id."', country_id='".$country_id."', city_id='".$main_city_id."' where zipcode_id='".$zipcode_id."'"; 
			$this->query($sql,0);
			return true;
		
		}
		
		function deleteZipCode($zipcode_id){
			$sql="delete from zipcode where zipcode_id='".$zipcode_id."'";
	
			$this->query($sql,0);
			return true;
		}
		
		function changeZipCodeStatus($zipcode_id){
			$sql="select * from zipcode where zipcode_id='".$zipcode_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update zipcode set Status='$Status' where zipcode_id='".$zipcode_id."'";
			
			
				$this->query($sql,0);
				return true;
			}			
		}
		
		function getZipCodeByCity($city_id){
			if(!empty($city_id)){
				$strAddQuery = " where z.city_id='".$city_id."'";

				$strSQLQuery = "select z.* from zipcode z inner join city c on z.city_id=c.city_id ".$strAddQuery." order by z.zip_code";
				
				
			    
				return $this->query($strSQLQuery, 1);
			}
		}
		
		function getZipCode($zipcode_id,$Status){
			$strAddQuery  = " where 1"; 
			$strAddQuery .= (!empty($zipcode_id))?(" and z.zipcode_id='".$zipcode_id."'"):("");
			$strAddQuery .= (!empty($Status))?(" and z.Status='".$Status."'"):("");

			$strSQLQuery = "select z.*,ct.name as city_name,s.name as state_name,c.name as country_name from zipcode z inner join city ct on z.city_id=ct.city_id inner join state s on ct.state_id=s.state_id inner join country c on s.country_id=c.country_id ".$strAddQuery." order by ct.name";
		
		
			return $this->query($strSQLQuery, 1);
		}
		
		function getZipCodeByZip($zip_code){
			if(!empty($zip_code)){
				$strAddQuery = " where z.zip_code='".$zip_code."'";

				$strSQLQuery = "select z.* from zipcode z inner join city c on z.city_id=c.city_id ".$strAddQuery." order by z.zip_code";
				
				
			    
				return $this->query($strSQLQuery, 1);
			}
		}

		function isZipCodeExists($zip_code,$city_id,$zipcode_id){
			$sql ="select * from zipcode where city_id='".$city_id."' and LCASE(zip_code) = '".strtolower(trim($zip_code))."'";
			$sql .= (!empty($zipcode_id))?(" and zipcode_id != '".$zipcode_id."'"):("");

			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['zipcode_id'])) {
				return true;
			} else {
				return false;
			}
		}
		

		function isMultiZipCodeExists($zip_code,$city_id){
			$ZipArray = explode(",",$zip_code);
			$Existing = '';
			if(sizeof($ZipArray)>0){
				foreach($ZipArray as $Zip){
					if(!empty($Zip)){
						$sql ="select zip_code from zipcode where city_id='".$city_id."' and LCASE(zip_code) = '".strtolower(trim($Zip))."'";

						$arryRow = $this->query($sql, 1);
						if (!empty($arryRow[0]['zip_code'])) {
							$Existing = $arryRow[0]['zip_code'];
							break;
						}
					}
				}

			}
			return $Existing;
		}


		function deleteMultiZipCode($zipcode_id){
			if(!empty($zipcode_id)){
				$sql = "delete from zipcode where zipcode_id in ( ".$zipcode_id.")";
				$rs = $this->query($sql,0);
			}
			return true;
		}
		/*************End of Zip Code *******************/
		function getZipTemp()
		{
			#$sql="select city, state ,state_id from zip_temp group by city,state order by state asc, city asc";
			$sql="select * from zip_temp order by state asc, city asc";
			return $this->query($sql);
		}

		function  GetStateByCode($code,$country_id)
		{
			$strSQLQuery = "select state_id from state where country_id='".$country_id."' and LCASE(code)='".mysql_real_escape_string(strtolower(trim($code)))."'";
			return $this->query($strSQLQuery, 1);
		}


		



}

?>
