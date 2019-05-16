<?php

class edi extends dbClass
{

	function getEDICompanies($search_str){
		$CmpID=$_SESSION['CmpID'];
	     $sql ="select CmpID,CompanyName,DisplayName,Email,Description,
		ContactPerson,Mobile,LandlineNumber,AlternateEmail,Department,ExpiryDate
		from erp.company
		where (Department='' or FIND_IN_SET ('13',Department))
		and (ExpiryDate > current_date() OR ExpiryDate='') and CmpID!='" . addslashes($CmpID) . "'
		and DisplayName='" . addslashes($search_str['search_str']) . "' or CmpID= '" . addslashes($search_str['CmpID']) . "' "; 
		$res=$this->query($sql, 1);
		#print_r($res); exit;

		foreach($res as $key=>$value){

			$RequestedCompDB='erp_'.$value['DisplayName'];

			$sql="SELECT IF('".$RequestedCompDB."' IN(SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA), 1, 0) AS found";
			$dbexist=$this->query($sql, 1);
			if($dbexist[0]['found']=='1'){
			 $sql="select count(*) as total from ".$RequestedCompDB.".edi_company
			where (EDICompId='" . addslashes($value['CmpID']) . "' And  
			RequestedCompID='" . addslashes($_SESSION['AdminID']) . "') Or (EDICompId='" . addslashes($_SESSION['AdminID']) . "' And  
			RequestedCompID='" . addslashes($value['CmpID']) . "') ";
				$issended=$this->query($sql, 1);
				if($issended[0]['total']>0){
					unset($res[$key]);
				}
			}else{
				unset($res[$key]);
			}



		}


		return $res;

	}

	function sendRequestforedi($arryDetails){

		
  $EDICompId =$arryDetails ['request_CmpID'];
  $EDIType = $arryDetails['EDITypeSelected'];
  $ToCust = $arryDetails['ToCust'];
  $ToVendor = $arryDetails['ToVendor'];
  $Added_date=date('Y-m-d');
  $RequestedCompDB='erp_'.$arryDetails['name'];
  $CompID=$_SESSION['CmpID'];
  $EDICompName=$arryDetails['name'];
  $RequestedCompID=$_SESSION['DisplayName'];
//ALTER TABLE `edi_company` ADD `EdiCustID` VARCHAR(50) NOT NULL AFTER `EDIType`, ADD `EdiReqCustID` VARCHAR(50) NOT NULL AFTER `EdiCustID`, ADD `EdiVendorID` VARCHAR(50) NOT NULL AFTER `EdiReqCustID`, ADD `EdiReqVendorID` VARCHAR(50) NOT NULL AFTER `EdiVendorID`, ADD INDEX (`EdiCustID`), ADD INDEX (`EdiReqCustID`), ADD INDEX (`EdiVendorID`), ADD INDEX (`EdiReqVendorID`);

		$sql = "INSERT INTO  edi_company SET EDICompId='" . addslashes($EDICompId) . "',Status='Reqest',
		RequestedCompID	='" . addslashes($CompID) . "',	Added_Date='" . addslashes($Added_date) . "',
		EDICompName	='" . addslashes($EDICompName) . "',RequestedCompName='" . addslashes($RequestedCompID) . "',
		EDIType ='" . addslashes($EDIType) . "',EdiReqCustID='" . addslashes($ToCust) . "',EdiReqVendorID='" . addslashes($ToVendor) . "'";
		$this->query($sql, 0);

		$sql2 = "INSERT INTO  ".$RequestedCompDB.".edi_company SET EDICompId='" . addslashes($EDICompId) . "',Status='Reqest',
		RequestedCompID	='" . addslashes($CompID) . "',	Added_Date='" . addslashes($Added_date) . "',
		EDICompName	='" . addslashes($EDICompName) . "',RequestedCompName='" . addslashes($RequestedCompID) . "', 
		EDIType ='" . addslashes($EDIType) . "',EdiCustID='" . addslashes($ToCust) . "',EdiVendorID='" . addslashes($ToVendor) . "'";
		$this->query($sql2, 0);

	}

	function getEDICompaniesByStatus($Status){
		$CmpID=$_SESSION['CmpID'];
		 $sql ="select CmpID,CompanyName,DisplayName,Email,Description,
		ContactPerson,Mobile,LandlineNumber,AlternateEmail,department,ExpiryDate
		from erp.company
		where (department='' or FIND_IN_SET ('13',department))
		and (ExpiryDate > current_date() or ExpiryDate='') and CmpID!='" . addslashes($CmpID) . "' ";
		$res=$this->query($sql, 1);

		foreach($res as $key=>$value){
			$RequestedCompDB='erp_'.$value['DisplayName'];

			$sql="SELECT IF('".$RequestedCompDB."' IN(SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA), 1, 0) AS found";
			$dbexist=$this->query($sql, 1);

			if($dbexist[0]['found']=='1'){
				$sql="select count(*) as total,ID,RequestedCompID,EDIType from ".$RequestedCompDB.".edi_company
			where (EDICompId='" . addslashes($_SESSION['CmpID']) . "' or 
			RequestedCompID='" . addslashes($_SESSION['CmpID']) . "') and Status='" . addslashes($Status) . "' ";
				$issended=$this->query($sql, 1);
				if($issended[0]['total']==0){
					unset($res[$key]);
				}else{
					$res[$key]['RequesID']=$issended[0]['ID'];
					$res[$key]['RequestedCompID']=$issended[0]['RequestedCompID'];
					$res[$key]['EDIType']=$issended[0]['EDIType'];
				}
			}else{
				unset($res[$key]);
			}




		}


		return $res;


	}

	function acceptrejectEDI($arryresult){
		global $Config;

$ID = $arryresult['request_CmpID'];
$mod = $arryresult['mod'];
		$AcceptRejectDate=date('Y-m-d');
	  $sql="select * from edi_company		where RequestedCompID='" . addslashes($ID) . "'";

		$details=$this->query($sql, 1);

	 $EDICompDB='erp_'.$details[0]['EDICompName'];

 $RequestedCompNameDB='erp_'.$details[0]['RequestedCompName'];
		
		$EDIType=$details[0]['EDIType'];

		if(strtolower($mod)=='accept'){
			$objCustomer=new Customer();
			$objSupplier=new supplier();
			$objConfig=new admin();
			$objRegion=new region();
				
			if(strtolower($EDIType)=='Vendor' || strtolower($EDIType)=='both'){

				// add as a Customer in requested EDI Company

				$sql="select count(*) as total from ".$RequestedCompNameDB.".s_customers
			where EDICompId='" . addslashes($details[0]['EDICompId']) . "'";

				$is_exist=$this->query($sql, 1);



				if($is_exist[0]['total']==0){
						
					$arryDetails=$this->getCompanyInfoForCustomer($details[0]['EDICompId'],$details[0]['RequestedCompID']);
 $sqlCust="select * from ".$RequestedCompNameDB.".s_customers	where CustCode='".addslashes($arryresult['ToCust'])."'";
								  $arryCustomer=$this->query($sqlCust, 1);

										if(is_array($arryCustomer) && $arryCustomer[0]['CustCode']!=''){
											 $sqlReqUpdate = "UPDATE ".$RequestedCompNameDB.".s_customers SET EDICompId='" . addslashes($details[0]['EDICompId']) . "',EDICompName='" . addslashes($details[0]['EDICompName']) . "'	WHERE Cid ='".$arryCustomer[0]['Cid']."'"; 
												$this->query($sqlReqUpdate, 0);
										}else{

#echo "<pre>";print_r($arryDetails); exit;

					$addCustId=$objCustomer->addCustomer($arryDetails,$RequestedCompNameDB);
						
					$arryDetails['PrimaryContact']=1;
					$Country=$arryDetails['Country'];
					unset($arryDetails['CustomerType']);
					unset($arryDetails['Gender']);
					unset($arryDetails['CustomerSince']);
					unset($arryDetails['Country']);
					unset($arryDetails['Website']);
					unset($arryDetails['EDICompId']);
					unset($arryDetails['EDICompName']);
					$AddID = $objCustomer->addCustomerAddress($arryDetails,$addCustId,'contact',$RequestedCompNameDB);
						
					/*****ADD COUNTRY/STATE/CITY NAME****/

					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/***********************************/
					$arryDetails['Country']=$Country;
					$arryCountry = $objRegion->GetCountryName($Country);
					$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);
          $arryRgn['country_id']= stripslashes($Country);

					if(!empty($arryDetails['main_state_id'])) {
						$arryState = $objRegion->getStateName($arryDetails['main_state_id']);
						$arryRgn['State']= stripslashes($arryState[0]["name"]);
					}else if(!empty($arryDetails['OtherState'])){
						$arryRgn['State']=$arryDetails['OtherState'];
					}

					if(!empty($arryDetails['main_city_id'])) {
						$arryCity = $objRegion->getCityName($arryDetails['main_city_id']);
						$arryRgn['City']= stripslashes($arryCity[0]["name"]);
					}else if(!empty($arryDetails['OtherCity'])){
						$arryRgn['City']=$arryDetails['OtherCity'];
					}


					/***********************************/
					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();

					$objCustomer->UpdateCountryStateCity($arryRgn,$AddID,$RequestedCompNameDB);
					/**************END COUNTRY NAME*********************/

					$arryDetails['PrimaryContact']=0;
					unset($arryDetails['Country']);
					$billingID = $objCustomer->addCustomerAddress($arryDetails,$addCustId,'billing',$RequestedCompNameDB);
					$objCustomer->UpdateCountryStateCity($arryRgn,$billingID,$RequestedCompNameDB);

					$shippingID = $objCustomer->addCustomerAddress($arryDetails,$addCustId,'shipping',$RequestedCompNameDB);
					$objCustomer->UpdateCountryStateCity($arryRgn,$shippingID,$RequestedCompNameDB);

          }
				}

			}
				
				

			if(strtolower($EDIType)=='Customer' || strtolower($EDIType)=='both'){
				// add as a Customer in accepted EDI Company
				$sql="select count(*) as total from ".$EDICompDB.".s_customers
		where EDICompId='" . addslashes($details[0]['RequestedCompID']) . "'";
				$is_exist=$this->query($sql, 1);
				if($is_exist[0]['total']==0){
					$arryDetails=$this->getCompanyInfoForCustomer($details[0]['RequestedCompID'],$details[0]['EDICompId']);
 $sqlData="select * from ".$EDICompDB.".s_customers	where CustCode='" . addslashes($details[0]['EdiCustID']) . "'";
										$arryCust=$this->query($sqlData, 1);
										if(is_array($arryCust) && $arryCust[0]['CustCode']!=''){
													 $sqlReqUpdate = "UPDATE ".$EDICompDB.".s_customers SET EDICompId='" . addslashes($details[0]['RequestedCompID']) . "',EDICompName='" . addslashes($details[0]['RequestedCompName']) . "'	WHERE Cid =" . $arryCust[0]['Cid']; 
		$this->query($sqlReqUpdate, 0);

										}else{
					$addCustId=$objCustomer->addCustomer($arryDetails,$EDICompDB);

					$arryDetails['PrimaryContact']=1;
					$Country=$arryDetails['Country'];
					unset($arryDetails['CustomerType']);
					unset($arryDetails['Gender']);
					unset($arryDetails['CustomerSince']);
					unset($arryDetails['Country']);
					unset($arryDetails['Website']);
					unset($arryDetails['EDICompId']);
					unset($arryDetails['EDICompName']);
					$AddID = $objCustomer->addCustomerAddress($arryDetails,$addCustId,'contact',$EDICompDB);

					/*****ADD COUNTRY/STATE/CITY NAME****/
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/***********************************/
					$arryDetails['Country']=$Country;
					$arryCountry = $objRegion->GetCountryName($arryDetails['Country']);
					$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);

					if(!empty($arryDetails['main_state_id'])) {
						$arryState = $objRegion->getStateName($arryDetails['main_state_id']);
						$arryRgn['State']= stripslashes($arryState[0]["name"]);
					}else if(!empty($arryDetails['OtherState'])){
						$arryRgn['State']=$arryDetails['OtherState'];
					}

					if(!empty($arryDetails['main_city_id'])) {
						$arryCity = $objRegion->getCityName($arryDetails['main_city_id']);
						$arryRgn['City']= stripslashes($arryCity[0]["name"]);
					}else if(!empty($arryDetails['OtherCity'])){
						$arryRgn['City']=$arryDetails['OtherCity'];
					}


					/***********************************/
					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();

					$objCustomer->UpdateCountryStateCity($arryRgn,$AddID,$EDICompDB);
					/**************END COUNTRY NAME*********************/

					$arryDetails['PrimaryContact']=0;
           $arryDetails['country_id']=$arryDetails['Country'];
					unset($arryDetails['Country']);
					$billingID = $objCustomer->addCustomerAddress($arryDetails,$addCustId,'billing',$EDICompDB);
					$objCustomer->UpdateCountryStateCity($arryRgn,$billingID,$RequestedCompNameDB);

					$shippingID = $objCustomer->addCustomerAddress($arryDetails,$addCustId,'shipping',$EDICompDB);
					$objCustomer->UpdateCountryStateCity($arryRgn,$shippingID,$EDICompDB);
          }
				}
			}

			/*******Add Suppiler***********/

			if(strtolower($EDIType)=='Customer' || strtolower($EDIType)=='both'){
				// add as a Supplier in requested EDI Company



				$sql="select count(*) as total from ".$RequestedCompNameDB.".p_supplier
		where EDICompId='" . addslashes($details[0]['EDICompId']) . "'";
				$is_exist=$this->query($sql, 1);

				if($is_exist[0]['total']==0){
					$arryDetails=$this->getCompanyInfoForSupplier($details[0]['EDICompId'],$details[0]['RequestedCompID']);

$sqlSuppSql="select * from ".$RequestedCompNameDB.".p_supplier	where SuppCode='" . addslashes($arryresult['ToVendor']) . "'";
								  $arrySupp=$this->query($sqlSuppSql, 1);
										if(is_array($arrySupp) && $arrySupp[0]['SuppCode']!=''){

													 $sqlReqUpdate = "UPDATE ".$RequestedCompNameDB.".p_supplier SET EDICompId='" . addslashes($details[0]['EDICompId']) . "',EDICompName='" . addslashes($details[0]['EDICompName']) . "'	WHERE SuppID ='" . $arrySupp[0]['SuppID']."'"; 
		$this->query($sqlReqUpdate, 0);

										}else{
					$LastInsertSupplierId=$objSupplier->AddSupplier($arryDetails,$RequestedCompNameDB);

					$arryDetails['PrimaryContact']=1;
					$AddID = $objSupplier->addSupplierAddress($arryDetails,$LastInsertSupplierId,'contact',$RequestedCompNameDB);

					$arryDetails['PrimaryContact']=0;
					$billingID = $objSupplier->addSupplierAddress($arryDetails,$LastInsertSupplierId,'billing',$RequestedCompNameDB);
					$shippingID = $objSupplier->addSupplierAddress($arryDetails,$LastInsertSupplierId,'shipping',$RequestedCompNameDB);
						
					/******************Update Cutry State City Fir Suppiler*****************/
					if($AddID>0){
						$Config['DbName'] = $Config['DbMain'];
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();
						/***********************************/
						$arryCountry = $objRegion->GetCountryName($arryDetails['country_id']);
						$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);
						if(!empty($arryDetails['main_state_id'])) {
							$arryState = $objRegion->getStateName($arryDetails['main_state_id']);
							$arryRgn['State']= stripslashes($arryState[0]["name"]);
						}else if(!empty($_POST['OtherState'])){
						 $arryRgn['State']=$_POST['OtherState'];
						}

						if(!empty($arryDetails['main_city_id'])) {
							$arryCity = $objRegion->getCityName($arryDetails['main_city_id']);
							$arryRgn['City']= stripslashes($arryCity[0]["name"]);
						}else if(!empty($arryDetails['OtherCity'])){
						 $arryRgn['City']=$arryDetails['OtherCity'];
						}
						/***********************************/
						$Config['DbName'] = $_SESSION['CmpDatabase'];
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();

						$objSupplier->UpdateAddCountryStateCity($arryRgn,$AddID,$RequestedCompNameDB);

						if($billingID>0){
					  $objSupplier->UpdateAddCountryStateCity($arryRgn,$billingID,$RequestedCompNameDB);
						}
						if($shippingID>0){
					  $objSupplier->UpdateAddCountryStateCity($arryRgn,$shippingID,$RequestedCompNameDB);
						}


					}
					/***************End ********************/
          }

				}
			}


			if(strtolower($EDIType)=='Vendor' || strtolower($EDIType)=='both'){
				// add as a Supplier in accepted EDI Company
				 $sql="select count(*) as total from ".$EDICompDB.".p_supplier
				where EDICompId='" . addslashes($details[0]['RequestedCompID']) . "'"; 
				$is_exist=$this->query($sql, 1);
				$is_exist[0]['total']=0;
				if($is_exist[0]['total']==0){
					$arryDetails=$this->getCompanyInfoForSupplier($details[0]['RequestedCompID'],$details[0]['EDICompId']);


	$sql2sql="select * from ".$EDICompDB.".p_supplier	where SuppCode='" . addslashes($arryresult['ToVendor']) . "'";
								  $arrySupplier=$this->query($sql2sql, 1);
										if(is_array($arrySupplier) && $arrySupplier[0]['SuppCode']!=''){

													 $sqlReqUpdate = "UPDATE ".$EDICompDB.".p_supplier SET EDICompId='" . addslashes($details[0]['RequestedCompID']) . "',EDICompName='" . addslashes($details[0]['RequestedCompName']) . "'	WHERE SuppID ='" . $arrySupplier[0]['SuppID']."'"; 
		$this->query($sqlReqUpdate, 0);

										}else{

		$LastInsertSupplierId=$objSupplier->AddSupplier($arryDetails,$EDICompDB);
						
					$arryDetails['PrimaryContact']=1;
					$AddID = $objSupplier->addSupplierAddress($arryDetails,$LastInsertSupplierId,'contact',$EDICompDB);

					$arryDetails['PrimaryContact']=0;
					$billingID = $objSupplier->addSupplierAddress($arryDetails,$LastInsertSupplierId,'billing',$EDICompDB);
					$shippingID = $objSupplier->addSupplierAddress($arryDetails,$LastInsertSupplierId,'shipping',$EDICompDB);
						
					/******************Update Country State City For Suppiler*****************/
					if($AddID>0){
						$Config['DbName'] = $Config['DbMain'];
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();
						/***********************************/
						$arryCountry = $objRegion->GetCountryName($arryDetails['country_id']);
						$arryRgn['Country']= stripslashes($arryCountry[0]["name"]);
						if(!empty($arryDetails['main_state_id'])) {
							$arryState = $objRegion->getStateName($arryDetails['main_state_id']);
							$arryRgn['State']= stripslashes($arryState[0]["name"]);
						}else if(!empty($_POST['OtherState'])){
						 $arryRgn['State']=$_POST['OtherState'];
						}

						if(!empty($arryDetails['main_city_id'])) {
							$arryCity = $objRegion->getCityName($arryDetails['main_city_id']);
							$arryRgn['City']= stripslashes($arryCity[0]["name"]);
						}else if(!empty($arryDetails['OtherCity'])){
						 $arryRgn['City']=$arryDetails['OtherCity'];
						}
						/***********************************/
						$Config['DbName'] = $_SESSION['CmpDatabase'];
						$objConfig->dbName = $Config['DbName'];
						$objConfig->connect();

						$objSupplier->UpdateAddCountryStateCity($arryRgn,$AddID,$EDICompDB);

						if($billingID>0){
					  $objSupplier->UpdateAddCountryStateCity($arryRgn,$billingID,$EDICompDB);
						}
						if($shippingID>0){
					  $objSupplier->UpdateAddCountryStateCity($arryRgn,$shippingID,$EDICompDB);
						}


					}
					/***************End ********************/
					}	

				}
			}
				
				
				

			/*******End Add Suppiler***********/
$sql = "UPDATE ".$EDICompDB.".edi_company SET Status='" . addslashes($mod) . "',AcceptRejectDate='" . addslashes($AcceptRejectDate) . "',EdiReqCustID = '".$arryresult['ToCust']."',EdiReqVendorID ='".$arryresult['ToVendor']."'
			WHERE RequestedCompID ='" . $ID."'"; 
		$this->query($sql, 0);

		$sql = "UPDATE ".$RequestedCompNameDB.".edi_company SET Status='" . addslashes($mod) . "',AcceptRejectDate='" . addslashes($AcceptRejectDate) . "'
			WHERE RequestedCompID ='" . $ID."'"; 
		$this->query($sql, 0);


		}


		if(strtolower($mod)=='reject'){
		
		
		$sql = "UPDATE ".$EDICompDB.".edi_company SET Status='" . addslashes($mod) . "',AcceptRejectDate='" . addslashes($AcceptRejectDate) . "'
			WHERE RequestedCompID ='" . $ID."'"; 
		$this->query($sql, 0);

		$sql = "UPDATE ".$RequestedCompNameDB.".edi_company SET Status='" . addslashes($mod) . "',AcceptRejectDate='" . addslashes($AcceptRejectDate) . "'		WHERE RequestedCompID ='" . $ID."'"; 
		$this->query($sql, 0);
		
		
		
		}


	}

	function getCompanyInfoForCustomer($CmpID,$RequestedCompID){
		$Added_date=date('Y-m-d');

		$sql="select * from erp.company	where CmpID='" . addslashes($CmpID) . "'";
		$compdetails=$this->query($sql, 1);


		$ContactPerson=explode(' ',$compdetails[0]['ContactPerson']);

		$arryDetails['CustomerType']='Individual';
		$arryDetails['Company']=$compdetails[0]['CompanyName'];
		$arryDetails['FirstName']=$ContactPerson[0];
		$arryDetails['LastName']=$ContactPerson[1];
		$arryDetails['Gender']='Male';
		$arryDetails['Email']=$compdetails[0]['Email'];
		$arryDetails['CustomerSince']=$Added_date;
		$arryDetails['Status']='Yes';
		$arryDetails['Address']=$compdetails[0]['Address'];
		$arryDetails['Country']=$compdetails[0]['country_id'];
		$arryDetails['state_id']=$compdetails[0]['state_id'];
		$arryDetails['OtherState']=$compdetails[0]['OtherState'];
		$arryDetails['city_id']=$compdetails[0]['city_id'];
		$arryDetails['OtherCity']=$compdetails[0]['OtherCity'];
		$arryDetails['ZipCode']=$compdetails[0]['ZipCode'];
		$arryDetails['Mobile']=$compdetails[0]['Mobile'];
		$arryDetails['Landline']=$compdetails[0]['LandlineNumber'];
		$arryDetails['Fax']=$compdetails[0]['Fax'];
		$arryDetails['Website']=$compdetails[0]['Website'];
		$arryDetails['main_state_id']=$compdetails[0]['state_id'];
		$arryDetails['main_city_id']=$compdetails[0]['city_id'];
		$arryDetails['EDICompId']=$CmpID;
		$arryDetails['EDICompName']=$compdetails[0]['DisplayName'];
		$arryDetails['AdminType']='admin';
		$arryDetails['AdminID']=$RequestedCompID;
		return $arryDetails;

	}

	function getCompanyInfoForSupplier($CmpID,$RequestedCompID){
		$Added_date=date('Y-m-d');

		 $sql="select * from erp.company	where CmpID='" . addslashes($CmpID) . "'";
		$compdetails=$this->query($sql, 1);


		$ContactPerson=explode(' ',$compdetails[0]['ContactPerson']);

		$arryDetails['SuppType']='Business';
		$arryDetails['CompanyName']=$compdetails[0]['CompanyName'];
		$arryDetails['FirstName']=$ContactPerson[0];
		$arryDetails['LastName']=$ContactPerson[1];
		$arryDetails['Email']=$compdetails[0]['Email'];
		$arryDetails['SupplierSince']=$Added_date;
		$arryDetails['Status']='1';
		$arryDetails['Address']=$compdetails[0]['Address'];
		$arryDetails['country_id']=$compdetails[0]['country_id'];
		$arryDetails['OtherState']=$compdetails[0]['OtherState'];
		$arryDetails['OtherCity']=$compdetails[0]['OtherCity'];
		$arryDetails['ZipCode']=$compdetails[0]['ZipCode'];
		$arryDetails['Mobile']=$compdetails[0]['Mobile'];
		$arryDetails['Landline']=$compdetails[0]['LandlineNumber'];
		$arryDetails['Fax']=$compdetails[0]['Fax'];
		$arryDetails['Website']=$compdetails[0]['Website'];
		$arryDetails['main_state_id']=$compdetails[0]['state_id'];
		$arryDetails['main_city_id']=$compdetails[0]['city_id'];
		$arryDetails['EDICompId']=$CmpID;
		$arryDetails['EDICompName']=$compdetails[0]['DisplayName'];

		return $arryDetails;

	}
function CountRequestedEDI($request){
$CmpID=$_SESSION['CmpID'];
 $sql ="select COUNT(*) as ids from edi_company where Status='" . addslashes($request) . "' and RequestedCompID!= '".$CmpID."' and EDICompId='".$CmpID."' "; 
		$res=$this->query($sql, 1);
if($res[0]['ids']>0){
return $res[0]['ids'];
}else{

return 0;
}
}

function GetRequestedEDI($request){
$CmpID=$_SESSION['CmpID'];
 $sql ="select * from edi_company where Status='" . addslashes($request) . "' and RequestedCompID!= '".$CmpID."' and EDICompId='".$CmpID."' ";
		$res=$this->query($sql, 1);

return $res;
}

	function GetEdiDeshboard($Status,$limit=7){
		$CmpID=$_SESSION['CmpID'];
		$sql ="select CmpID,CompanyName,DisplayName,Email,Description,
		ContactPerson,Mobile,LandlineNumber,AlternateEmail,department,ExpiryDate
		from erp.company
		where (department='' or FIND_IN_SET ('13',department))
		and ExpiryDate > current_date() and CmpID!='" . addslashes($CmpID) . "' ";
		$res=$this->query($sql, 1);
		$count=0;
		foreach($res as $key=>$value){
			$RequestedCompDB='erp_'.$value['DisplayName'];

			$sql="SELECT IF('".$RequestedCompDB."' IN(SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA), 1, 0) AS found";
			$dbexist=$this->query($sql, 1);

			if($dbexist[0]['found']=='1'){
				$sql="select count(*) as total,ID,RequestedCompID from ".$RequestedCompDB.".edi_company
			where (EDICompId='" . addslashes($value['CmpID']) . "' or 
			RequestedCompID='" . addslashes($value['CmpID']) . "') and Status='" . addslashes($Status) . "' and  RequestedCompID!='" . addslashes($CmpID) . "' ";
				$issended=$this->query($sql, 1);
				if($issended[0]['total']==0){
					unset($res[$key]);
				}else{
					$res[$key]['RequesID']=$issended[0]['ID'];
					$res[$key]['RequestedCompID']=$issended[0]['RequestedCompID'];
					$count++;
					if($count==$limit) break;
				}
			}else{
				unset($res[$key]);
			}



		}


		return $res;
	}

function GetCompanyForEDI($CmpID,$DbMain){

$sql ="select CmpID,CompanyName,DisplayName,Email,Description,
		ContactPerson,Mobile,LandlineNumber,AlternateEmail,department,ExpiryDate
		from ".$DbMain.".company
		where CmpID ='".addslashes($CmpID)."'"; 
$arryCompany =  $this->query($sql, 1);
if($arryCompany[0]['DisplayName']!=''){

$DisplayCompany = $DbMain."_".$arryCompany[0]['DisplayName'].".";

}else{

$DisplayCompany = '';
}
return $DisplayCompany ;
}

function GetSaleSerialItem($InvID,$Sku,$DbMain){
	 $sql ="select SerialNumbers	from ".$DbMain."s_order_item	where OrderID ='".addslashes($InvID)."' and Sku='".addslashes($Sku)."'"; 
		return $this->query($sql, 1);

}


function GetRequestList($arryDetails){

	global $Config;
			extract($arryDetails);

				$strAddQuery = " where 1";
		
			$strAddQuery .= (!empty($module))?(" and o.Type='".$module."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.DeleteDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.DeleteDate<='".$ToDate."'"):("");
			                   
		 if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID."  ) " ):("");	
			}

			//$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

	
						
			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{	
				
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.DeleteDate desc, o.reqID desc ");
			
				$Columns = "  o.*, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

		         $strSQLQuery = "select ".$Columns."  from edi_request o  left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee') ".$join."  " . $strAddQuery;
	  	#echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);	

}


}

?>
