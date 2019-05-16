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
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' and locationID='".$_SESSION['locationID']."'"):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from w_attribute_value v inner join w_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetAttributeByValue($attribute_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and locationID='".$_SESSION['locationID']."'"):("");

			$strSQLFeaturedQuery .= (!empty($attribute_value))?(" and v.attribute_value like '".$attribute_value."%'"):("");

			$strSQLQuery = "select v.attribute_value from w_attribute_value v inner join w_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	



		function  GetFixedAttribute($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from w_attribute_value v inner join w_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllAttributes($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and attribute_id ='".$id."'"):("");
		
			$strSQLQuery = "select * from w_attribute ".$strSQLQuery." order by attribute_id Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
			
		function addAttribute($arryAtt)
		{
			@extract($arryAtt);	 
			$sql = "insert into w_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
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
			(!isset($SuppCode))?($SuppCode=""):("");
	
			$sql = "update w_attribute_value set attribute_value = '".addslashes($attribute_value)."',attribute_id = '".$attribute_id."',SuppCode = '".$SuppCode."', Status = '".$Status."'  where value_id = '".$value_id."'"; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function getAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):(" and locationID='".$_SESSION['locationID']."'");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from w_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}
		function countAttributes()
		{
			$sql = "select sum(1) as NumAttribute from w_attribute_value where Status='1'" ;
			return $this->query($sql, 1);
		}

		function changeAttributeStatus($value_id)
		{
			$sql="select * from w_attribute_value where value_id='".$value_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update w_attribute_value set Status='$Status' where value_id='".$value_id."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function deleteAttribute($id)
		{
			$sql = "delete from w_attribute_value where value_id = '".$id."' and FixedCol='0' ";
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;
		}
	
		function isAttributeExists($attribute_value,$attribute_id,$value_id)
			{

				$strSQLQuery ="select value_id from w_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and locationID='".$_SESSION['locationID']."'";

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

		////////////Fixed Attribute Start ///// 
		function  GetAttribMultiple($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name in(".$attribute_name.") and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from w_attribute_value v inner join w_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}



		function  GetAttribValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status='1' "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from w_attribute_value v inner join w_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}
		function getAttrib($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from w_attribute_value ".$sql." order by attribute_value asc" ;
		
			return $this->query($sql, 1);
		}

		function isAttribExists($attribute_value,$attribute_id,$value_id)
		{

				$strSQLQuery ="select value_id from w_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' ";

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

		/********************************************/
		/*************Payment Term Start ************/

		function  ListTerm($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" and termID='".$id."'"):("");

			if($SearchKey=='active' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='1'"; 
			}else if($SearchKey=='inactive' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (termName like '%".$SearchKey."%' or Day like '%".$SearchKey."%' or Due like '%".$SearchKey."%' or CreditLimit like '%".$SearchKey."%') " ):("");		
			}
			$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by termID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			$strSQLQuery = "select * from w_term  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

		function  GetTerm($termID,$Status)
		{

			$strAddQuery = " where 1 ";
			$strAddQuery .= (!empty($termID))?(" and termID='".$termID."'"):("");
			$strAddQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strSQLQuery = "select * from w_term  ".$strAddQuery." order by termID Asc";

			return $this->query($strSQLQuery, 1);
		}		
			
		
		function AddTerm($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into w_term (termName, termDate, Due, Status, Day, CreditLimit, UpdatedDate ) values( '".addslashes($termName)."', '".$termDate."', '".addslashes($Due)."', '".$Status."', '".addslashes($Day)."', '".addslashes($CreditLimit)."',  '".$Config['TodayDate']."')";

			$this->query($strSQLQuery, 0);

			$termID = $this->lastInsertId();
			
			return $termID;

		}


		function UpdateTerm($arryDetails){
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update w_term set termName='".addslashes($termName)."', termDate='".$termDate."',  Due='".addslashes($Due)."',  Status='".$Status."'  ,Day='".addslashes($Day)."'	,CreditLimit='".addslashes($CreditLimit)."'	, UpdatedDate = '".$Config['TodayDate']."' where termID='".$termID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

					
		
		function RemoveTerm($termID)
		{
		
			$strSQLQuery = "delete from w_term where termID='".$termID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function changeTermStatus($termID)
		{
			$sql="select * from w_term where termID='".$termID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update w_term set Status='$Status' where termID='".$termID."'";
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleTermStatus($termIDs,$Status)
		{
			$sql="select termID from w_term where termID in (".$termIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update w_term set Status='".$Status."' where termID in (".$termIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		

		function isTermExists($termName,$termID=0)
		{
			$strSQLQuery = (!empty($termID))?(" and termID != '".$termID."'"):("");
			$strSQLQuery = "select termID from w_term where LCASE(termName)='".strtolower(trim($termName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['termID'])) {
				return true;
			} else {
				return false;
			}
		}


		/*************Payment Term End ************/




	  function  TrackingReport($arryDetails){ 
		global $Config;		
		extract($arryDetails);	 

		$SoAddSql = "";
		$PoAddSql = "";
		$StandSql = "";
		$SoRmaAddSql = "";
		$PoRmaAddSql = "";
		$VpAddSql = "";
		$ShipAddSQL = "";


		if($fby=='Year'){
			$SoAddSql .= " and CASE WHEN o.Module = 'Order' THEN ( YEAR(o.OrderDate)='".$y."') ELSE  ( YEAR(o.InvoiceDate)='".$y."') END ";
			$PoAddSql .= " and CASE WHEN o.Module = 'Order' THEN ( YEAR(o.OrderDate)='".$y."') ELSE  ( YEAR(o.PostedDate)='".$y."') END ";
			$StandSql .= " and  YEAR(st.CreatedDate)='".$y."'  ";
			$ShipAddSQL .= " and YEAR(o.InvoiceDate)='".$y."' ";
		}else if($fby=='Month'){
			$SoAddSql .= " and CASE WHEN o.Module = 'Order' THEN (MONTH(o.OrderDate)='".$m."' and YEAR(o.OrderDate)='".$y."') ELSE  (MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ) END ";
			$PoAddSql .= " and CASE WHEN o.Module = 'Order' THEN (MONTH(o.OrderDate)='".$m."' and YEAR(o.OrderDate)='".$y."') ELSE  (MONTH(o.PostedDate)='".$m."' and YEAR(o.PostedDate)='".$y."' ) END ";
			$StandSql .= " and MONTH(st.CreatedDate)='".$m."' and YEAR(st.CreatedDate)='".$y."'";
			$ShipAddSQL .= " and  MONTH(o.InvoiceDate)='".$m."' and YEAR(o.InvoiceDate)='".$y."' ";
 		}else{ 
			$SoAddSql .= " and CASE WHEN o.Module = 'Order' THEN (o.OrderDate>='".$f."' and o.OrderDate<='".$t."' ) ELSE  (o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."' ) END ";
			$PoAddSql .= " and CASE WHEN o.Module = 'Order' THEN (o.OrderDate>='".$f."' and o.OrderDate<='".$t."' ) ELSE  (o.PostedDate>='".$f."' and o.PostedDate<='".$t."' ) END ";

			$StandSql .= " and date(st.CreatedDate)>='".$f."' and date(st.CreatedDate)<='".$t."'";
			$ShipAddSQL .= " and o.InvoiceDate>='".$f."' and o.InvoiceDate<='".$t."'  ";
		}

		

		if(!empty($key)){
			$SearchBy = $sby;  
			$SearchKey   = strtolower(trim($key));

			$CommonVpSql = " and tr.ReceiptID like '%".$SearchKey."%' ";

		 	if($SearchBy=="Customer"){
				$SoAddSql .= " and ( c.Company like '%".$SearchKey."%' OR c.FullName like '%".$SearchKey."%' )";
				$PoAddSql .= " and ( o.wName like '%".$SearchKey."%' and o.OrderType='Dropship' )";

				$SoRmaAddSql .= " and ( c.Company like '%".$SearchKey."%' OR c.FullName like '%".$SearchKey."%' )";
				$PoRmaAddSql .= " and ( o.wName like '%".$SearchKey."%' and o.OrderType='Dropship' )";
				$ShipAddSQL .= " and ( c.Company like '%".$SearchKey."%' OR c.FullName like '%".$SearchKey."%' )";
				 
				$VpAddSql .= $CommonVpSql;
			}else if($SearchBy=="Vendor"){
				$SoAddSql .= " and ( o.ShippingCompany like '%".$SearchKey."%' and o.OrderType='Against PO' )";
				$PoAddSql .= " and ( s.CompanyName like '%".$SearchKey."%' OR s.UserName like '%".$SearchKey."%' )";
				$SoRmaAddSql .= " and ( o.ShippingCompany like '%".$SearchKey."%' and o.OrderType='Against PO' )";
				$PoRmaAddSql .= " and ( s.CompanyName like '%".$SearchKey."%' OR s.UserName like '%".$SearchKey."%' )"; 
				$VpAddSql .= " and ( s.CompanyName like '%".$SearchKey."%' OR s.UserName like '%".$SearchKey."%' )";
				$ShipAddSQL .= " and ( o.ShippingCompany like '%".$SearchKey."%' and o.OrderType='Against PO' )";
				
			}else if($SearchBy=="SO"){
				$SoAddSql .= " and  o.SaleID like '%".$SearchKey."%' ";
				$PoAddSql .= " and  o.SaleID like '%".$SearchKey."%' ";
				$SoRmaAddSql .= " and  o.SaleID like '%".$SearchKey."%' ";
				$PoRmaAddSql .= " and  o.SaleID like '%".$SearchKey."%' ";
				$ShipAddSQL .= " and  o.SaleID like '%".$SearchKey."%' ";

				$VpAddSql .= $CommonVpSql;
			}else if($SearchBy=="PO"){
				$SoAddSql .= " and  o.CustomerPO like '%".$SearchKey."%' ";
				$PoAddSql .= " and  o.PurchaseID like '%".$SearchKey."%' ";

				$SoRmaAddSql .= " and  o.CustomerPO like '%".$SearchKey."%' ";
				$PoRmaAddSql .= " and  o.PurchaseID like '%".$SearchKey."%' ";
				$ShipAddSQL .= " and  o.CustomerPO like '%".$SearchKey."%' ";

				$VpAddSql .= $CommonVpSql;

			}else{
				$SoAddSql .= " and o.".$SearchBy." like '%".$SearchKey."%' ";
				$PoAddSql .= " and o.".$SearchBy." like '%".$SearchKey."%' ";
				

				if($SearchBy =='TrackingNo'){
				   	$StandSql .= " and st.TrackingID like '%".$SearchKey."%' ";
					$ShipAddSQL .= " and w.trackingId like '%".$SearchKey."%' ";
				}else if($SearchBy =='ShippingMethod'){
				   	$StandSql .= " and st.ShippingCarrier like '%".$SearchKey."%' ";
					$ShipAddSQL .= " and w.ShipType like '%".$SearchKey."%' ";
				}else if($SearchBy =='Freight'){
				   	$StandSql .= " and st.TotalFreight like '%".$SearchKey."%' ";
					$ShipAddSQL .= " and w.totalFreight like '%".$SearchKey."%' ";
				}else{
					$SoRmaAddSql .= " and o.".$SearchBy." like '%".$SearchKey."%' ";
					$PoRmaAddSql .= " and o.".$SearchBy." like '%".$SearchKey."%' ";

					$ShipAddSQL .= " and o.".$SearchBy." like '%".$SearchKey."%' ";
					$VpAddSql .= $CommonVpSql;
				}
				

			}
		}

	
		$OrderBy = " order by TrackingNo asc, CASE WHEN Module = 'Order' THEN OrderDate ELSE OrderID END desc ";			

		$SoSQL = "select 'S' as Section, o.TrackingNo, '' as RefID, o.OrderType, o.CustCode ,'' as SuppCode, o.CustID, o.OrderID, o.InvoiceDate, o.Module, o.OrderDate,o.InvoiceID, o.SaleID,o.CustomerPO as PurchaseID, o.ShippedDate, o.ShippingMethod, o.ShippingMethodVal, o.CustomerCurrency as Currency, o.ConversionRate,  o.Freight, o.wName,  IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName ,'' as VendorName from s_order o  left outer join s_customers c on (o.CustCode = c.CustCode and o.CustCode !='')  where o.Module in ('Order', 'Invoice') and o.TrackingNo!='' ".$SoAddSql;   

		 $ShipSQL = "select 'S' as Section, w.trackingId as TrackingNo, '' as RefID, o.OrderType, o.CustCode ,'' as SuppCode, o.CustID, o.OrderID, o.InvoiceDate, o.Module, o.OrderDate,o.InvoiceID, o.SaleID,o.CustomerPO as PurchaseID, o.ShippedDate, w.ShipType	 as ShippingMethod, w.ShippingMethod as ShippingMethodVal, o.CustomerCurrency as Currency, o.ConversionRate,  w.totalFreight as Freight, o.wName,  IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName ,'' as VendorName from s_order o inner join w_shipment w  on  (w.RefID = o.InvoiceID and w.RefID!='')  left outer join s_customers c on (o.CustCode = c.CustCode and o.CustCode !='')  where o.Module in ('Invoice') and o.TrackingNo='' and w.trackingId!='' and w.ShipType!='' ".$ShipAddSQL;   

		$PoSql =  "select 'P' as Section, o.TrackingNo, '' as RefID, o.OrderType, '' as CustCode, o.SuppCode , '' as CustID, o.OrderID, o.PostedDate as InvoiceDate, o.Module, o.OrderDate, o.InvoiceID, o.SaleID,o.PurchaseID , '' as ShippedDate, o.ShippingMethod, o.ShippingMethodVal, o.Currency, o.ConversionRate, o.Freight ,  o.wName,  '' as CustomerName, IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as VendorName from p_order o  left outer join p_supplier s on (o.SuppCode = s.SuppCode and o.SuppCode !='')  where o.Module in ('Order', 'Invoice') and o.TrackingNo!='' ".$PoAddSql; 

		 $SoRMASql = "select 'S' as Section , st.TrackingID as TrackingNo , o.ReturnID as RefID, o.OrderType ,o.CustCode ,'' as SuppCode , o.CustID, o.OrderID ,o.InvoiceDate, o.Module ,o.OrderDate , o.InvoiceID , o.SaleID , o.CustomerPO as PurchaseID , st.CreatedDate as ShippedDate , st.ShippingCarrier as ShippingMethod , st.ShippingMethod as ShippingMethodVal , o.CustomerCurrency as Currency, o.ConversionRate ,  st.TotalFreight as Freight, o.wName ,  IF(c.CustomerType = 'Company' and c.Company!='', c.Company,  c.FullName) as CustomerName , '' as VendorName  from s_order o inner join standalone_shipment st  on  (st.RefID = o.OrderID and st.RefID>0)  left outer join s_customers c on (o.CustCode = c.CustCode and o.CustCode !='') where  st.ModuleType='SalesRMA' and o.Module='RMA' and st.TrackingID!=''". $StandSql .$SoRmaAddSql;

		$PoRMASql = "select 'P' as Section, st.TrackingID as TrackingNo ,o.ReturnID as RefID , o.OrderType , '' as CustCode, o.SuppCode ,'' as CustID ,o.OrderID ,o.PostedDate as InvoiceDate ,o.Module , o.OrderDate ,o.InvoiceID , o.SaleID , o.PurchaseID, st.CreatedDate as ShippedDate  ,st.ShippingCarrier as ShippingMethod , st.ShippingMethod as ShippingMethodVal  ,o.Currency,o.ConversionRate , st.TotalFreight as Freight , o.wName , '' as CustomerName , IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName,  s.CompanyName) as VendorName  from p_order o inner join standalone_shipment st  on  (o.OrderID = st.RefID and st.RefID>0) left outer join p_supplier s on (o.SuppCode = s.SuppCode and o.SuppCode !='') where  st.ModuleType='PurchaseRMA' and o.Module='RMA' and st.TrackingID!='' ". $StandSql. $PoRmaAddSql; 
  
		 $VpSql = "select  'VP' as Section , st.TrackingID as TrackingNo ,tr.ReceiptID as RefID ,'' as OrderType ,'' as CustCode, tr.SuppCode ,'' as CustID , tr.TransactionID as OrderID ,tr.PaymentDate as InvoiceDate , tr.PaymentType as Module ,'' as OrderDate,'' as InvoiceID ,'' as SaleID ,'' as PurchaseID , '' as ShippedDate ,st.ShippingCarrier as ShippingMethod, st.ShippingMethod as ShippingMethodVal, tr.ModuleCurrency as Currency, '1' as ConversionRate ,  st.TotalFreight as Freight, '' as wName , '' as CustomerName , IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName,  s.CompanyName) as VendorName  from f_transaction tr inner join  standalone_shipment st  on  (tr.TransactionID = st.RefID and st.RefID>0) left outer join p_supplier s on (tr.SuppCode = s.SuppCode and tr.SuppCode !='')  where  st.ModuleType='VendorPayment' and tr.PaymentType='Purchase' and st.TrackingID!='' $StandSql  ".$VpAddSql; 


		 $strSQLQuery = "(".$SoSQL.") UNION (".$ShipSQL.") UNION (".$PoSql.") UNION (".$SoRMASql.") UNION (".$PoRMASql.") UNION (".$VpSql.")  ".$OrderBy;

		return $this->query($strSQLQuery, 1);		
	}




}

?>
