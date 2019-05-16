<?
class sale extends dbClass
{
		//constructor
		function sale()
		{
			$this->dbClass();
		} 
		
		function  ListSale($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "SaleID"; 
			}
           
			if($module == "Invoice"){ $moduledd = 'Invoice';}else{$moduledd = 'Order';}
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 

			$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
			$strAddQuery .= (!empty($FromDateInv))?(" and o.InvoiceDate>='".$FromDateInv."'"):("");
			$strAddQuery .= (!empty($ToDateInv))?(" and o.InvoiceDate<='".$ToDateInv."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			
			if($ToApprove=='1'){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}
			
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.ReturnID = '' and o.Status != 'Cancelled'"):(" ");
			$strAddQuery .= (!empty($InvoiceID))?(" group by SaleID"):(" ");
			
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
			//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");
			
			

			$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module,o.tax_auths  from s_order o ".$strAddQuery;
		
		   // echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}
		
		function  SalesReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$SalesPID,$Status)
		{

			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.OrderDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.OrderDate)='".$Month."' and YEAR(o.OrderDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($SalesPID))?(" and o.SalesPersonID='".$SalesPID."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select o.OrderDate, o.PostedDate, o.OrderID, o.SaleID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCurrency, o.Freight, o.discountAmnt, o.taxAmnt, o.TotalAmount, o.Status,o.Approved  from s_order o where o.Module='Order' ".$strAddQuery." order by o.OrderDate desc";
				//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
		
		
		
		function  GetNumSOByYear($Year,$FromDate,$ToDate,$CustCode,$SalesPID,$Status)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");

			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($SalesPID))?(" and o.SalesPersonID='".$SalesPID."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select count(o.OrderID) as TotalOrder  from s_order o where o.Module='Order' and YEAR(o.OrderDate)='".$Year."' ".$strAddQuery." order by o.OrderDate desc";
				//echo "=>".$strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}
		
		function  GetNumSOByMonth($Year,$FromDate,$ToDate,$CustCode,$SalesPID,$Status)
		{
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate = '".$ToDate."' "):("");
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($SalesPID))?(" and o.SalesPersonID='".$SalesPID."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select count(o.OrderID) as TotalOrder  from s_order o where o.Module='Order' and YEAR(o.OrderDate)='".$Year."' ".$strAddQuery." order by o.OrderDate desc";
				//echo "=>".$strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}
		
		function  GetOrderAmountByMonth($Year,$FromDate,$ToDate,$CustCode,$Status)
		{
		    global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate = '".$ToDate."' "):("");
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strSQLQuery = "select o.TotalAmount,o.CustomerCurrency from s_order o where o.Module='Order' and YEAR(o.OrderDate)='".$Year."' ".$strAddQuery." order by o.OrderDate desc";
			$rs = $this->query($strSQLQuery, 1);
			for($i=0;$i<=count($rs);$i++)
			{
				if(($rs[$i]['TotalAmount'] > 0) && ($Config['Currency'] != "INR")){
				 $avgCost += CurrencyConvertor($rs[$i]['TotalAmount'],$rs[$i]['CustomerCurrency'],$Config['Currency']);
				}else{
				 $avgCost += $rs[$i]['TotalAmount'];
				}
			}
		
			return ceil($avgCost);
					
		}
		
		function  GetOrderAmountByYear($Year,$FromDate,$ToDate,$CustCode,$Status)
		{
			global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");

			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strSQLQuery = "select o.TotalAmount,o.CustomerCurrency  from s_order o where o.Module='Order' and YEAR(o.OrderDate)='".$Year."' ".$strAddQuery." order by o.OrderDate desc";
			$rs = $this->query($strSQLQuery, 1);
			for($i=0;$i<=count($rs);$i++)
			{
				if($rs[$i]['TotalAmount'] > 0 && $Config['Currency'] != $rs[$i]['CustomerCurrency']){
				 $avgCost += CurrencyConvertor($rs[$i]['TotalAmount'],$rs[$i]['CustomerCurrency'],$Config['Currency']);
				}else{
				 $avgCost += $rs[$i]['TotalAmount'];
				}
			}
		
			return ceil($avgCost);		
		}
		
		
		function getCustomerOrderedAmount($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status)
		{
			
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.OrderDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.OrderDate)='".$Month."' and YEAR(o.OrderDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			
			$strSQLQuery = "select SUM(TotalAmount) as totalOrderAmnt from s_order as o WHERE o.Module='Order' ".$strAddQuery;
			//echo $strSQLQuery;exit;
			$rs = $this->query($strSQLQuery, 1);
		    return $rs[0]['totalOrderAmnt'];	
		
		}
		
		function getSalesPersonOrderedAmount($FilterBy,$FromDate,$ToDate,$Month,$Year,$SalesPID,$Status)
		{
			
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.OrderDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.OrderDate)='".$Month."' and YEAR(o.OrderDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($SalesPID))?(" and o.SalesPersonID='".$SalesPID."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			
			$strSQLQuery = "select SUM(TotalAmount) as totalOrderAmnt from s_order as o WHERE o.Module='Order' ".$strAddQuery;
			//echo $strSQLQuery;exit;
			$rs = $this->query($strSQLQuery, 1);
		    return $rs[0]['totalOrderAmnt'];	
		
		}


		function  SalesCommReport($FromDate,$ToDate,$SalesPersonID)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");			

			$strSQLQuery = "select sum(p.DebitAmnt) as TotalSales,o.SalesPersonID,o.SalesPerson from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' ) where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and o.SalesPerson!='' ".$strAddQuery." group by o.SalesPersonID order by o.SalesPersonID asc";

				
			return $this->query($strSQLQuery, 1);		
		}


		function  PaymentReport($FromDate,$ToDate,$SalesPersonID)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");			

			$strSQLQuery = "select p.*,o.InvoiceDate,o.OrderDate,o.CustomerName,o.SalesPersonID,o.SalesPerson from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' ) where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." order by p.PaymentDate desc,p.PaymentID desc";

				
			return $this->query($strSQLQuery, 1);		
		}

		function  GetSalesPayment($FromDate,$ToDate,$SalesPersonID)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");			

			$strSQLQuery = "select sum(p.DebitAmnt) as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by o.SalesPersonID";

			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['TotalSales'];
				
		}

		function  GetSalesPaymentNonResidual($FromDate,$ToDate,$SalesPersonID)
		{

			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");
	
			$sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by p.InvoiceID order by p.PaymentDate asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);

		
			if(!empty($arryInvoice[0]["InvoiceID"])){
				$strSQLQuery = "select sum(p.DebitAmnt) as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and p.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." group by o.SalesPersonID";
			
				$arryRow = $this->query($strSQLQuery, 1);
			}

			return $arryRow[0]['TotalSales'];
				
		}




		function  ListInvoice($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "SaleID"; 
			}

			$moduledd = 'Invoice';
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));

			if($Config['vAllRecord']!=1){
				$strAddQuery .= " and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') ";				
			}

			$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
			$strAddQuery .= (!empty($FromDateInv))?(" and o.InvoiceDate>='".$FromDateInv."'"):("");
			$strAddQuery .= (!empty($ToDateInv))?(" and o.InvoiceDate<='".$ToDateInv."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby=='o.InvoicePaid'){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '".$SearchKey."')"):("");
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.InvoicePaid like '".$SearchKey."' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");	
				
			}
			$strAddQuery .= " and o.InvoiceID != '' and o.ReturnID = ''";
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strAddQuery .= (!empty($InvoicePaid))?(" and o.InvoicePaid='".$InvoicePaid."'"):("");
			$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from s_order o ".$strAddQuery;
		
		    //echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}		

		function  ListInvoiceShipping($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "SaleID"; 
			}

			$moduledd = 'Invoice';
			$strAddQuery = " where 1 ";
			$SearchKey   = strtolower(trim($key));

			if($Config['vAllRecord']!=1){
				$strAddQuery .= " and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') ";				
			}

			$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
			$strAddQuery .= (!empty($FromDateInv))?(" and o.InvoiceDate>='".$FromDateInv."'"):("");
			$strAddQuery .= (!empty($ToDateInv))?(" and o.InvoiceDate<='".$ToDateInv."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby=='o.InvoicePaid'){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '".$SearchKey."')"):("");
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.InvoicePaid like '".$SearchKey."' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");	
				
			}
			$strAddQuery .= " and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and so.Status='Completed' ";

			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");

			$strAddQuery .= (!empty($so))?(" and so.SaleID='".$so."'"):("");
			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID='".$InvoiceID."'"):("");

			$strAddQuery .= (!empty($InvoicePaid))?(" and o.InvoicePaid='".$InvoicePaid."'"):("");
			$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from s_order o inner join s_order so on (o.SaleID= so.SaleID and so.Module='Order') ".$strAddQuery;
		
		    //echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}



		function  GetSale($OrderID,$SaleID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.*,e.Email as CreatedByEmail from s_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') where 1 ".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetInvoice($OrderID,$InvoiceID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID='".$InvoiceID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetReturn($OrderID,$ReturnID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($ReturnID))?(" and o.ReturnID='".$ReturnID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		

		function  GetSaleItem($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
			$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetInvoiceOrder($SaleID)
		{
			$strSQLQuery = "select OrderID from s_order o where SaleID='".$SaleID."' and Module='Invoice' order by o.OrderID asc";
			return $this->query($strSQLQuery, 1);
		}	

		function  GetSuppPurchase($CustCode,$OrderID,$SaleID,$Module)
		{
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}

		function AddSale($arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			//echo '<pre>'; print_r($arryDetails);exit;
			
			$CustomerCurrency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
	
		    $strSQLQuery = "INSERT INTO s_order SET Module = '".$Module."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', CreditID = '".$CreditID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', ClosedDate = '".$ClosedDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".addslashes($CustID)."',CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."',InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."' ,Taxable='".addslashes($Taxable)."' ,Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."' ";

			//crm quote fields
			$strSQLQuery .= " ,subject='".addslashes($subject)."' ,CustType='".addslashes($CustType)."' ,opportunityName='".addslashes($opportunityName)."' ,OpportunityID='".addslashes($OpportunityID)."', assignTo='".addslashes($assignTo)."', AssignType='".addslashes($AssignType)."', GroupID='".addslashes($GroupID)."' ";
		 	

			//echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			
			
			$OrderID = $this->lastInsertId();

			if(empty($arryDetails[$ModuleID]) && !empty($ModuleID)){
				$ModuleIDValue = $PrefixSale.'000'.$OrderID;
				$strSQL = "update s_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}

			return $OrderID;

		}

		function AddUpdateItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);


			if(!empty($DelItem)){
				$strSQLQuery = "delete from s_order_item where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
#echo '<pre>';print_r($arryDetails);exit;
		   $discountAmnt = 0;$taxAmnt=0; $totalTaxAmnt=0;
			for($i=1;$i<=$NumLine;$i++){

				if(!empty($arryDetails['sku'.$i])){

					$arryTax = explode(":",$arryDetails['tax'.$i]);
					$id = $arryDetails['id'.$i];
					
					if($arryDetails['discount'.$i] > 0){
					 $discountAmnt += $arryDetails['discount'.$i];
					}
				
					if($arryTax[1] > 0){
					 $actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i];	
					 $taxAmnt = ($actualAmnt*$arryTax[1])/100;
					 $totalTaxAmnt += $taxAmnt;

					}
					if($id>0){
						$sql = "update s_order_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."', discount ='".addslashes($arryDetails['discount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."'  where id=".$id; 
					}else{
						$sql = "insert into s_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, discount, Taxable) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['discount'.$i])."' ,'".addslashes($arryDetails['item_taxable'.$i])."')";
					}

					$this->query($sql, 0);	

				}
			}
		        $strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
				$this->query($strSQL, 0);
			return true;

		}



		function UpdateSale($arryDetails){ 
			global $Config;
			extract($arryDetails);	
			
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

			$strSQLQuery = "UPDATE s_order SET Module = '".$Module."', OrderDate='".$OrderDate."', InvoiceID = '".$InvoiceID."',SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', ClosedDate = '".$ClosedDate."', Comment = '".addslashes($Comment)."', CustomerCurrency = '".addslashes($CustomerCurrency)."' , CustCode='".addslashes($CustCode)."', CustID = '".addslashes($CustID)."' , BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."',InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."' WHERE OrderID='".$OrderID."'";
			$this->query($strSQLQuery, 0);

			return 1;
		}

	
		function ReceiveOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);


			$arrySale = $this->GetSale($ReceiveOrderID,'','');
			$arrySale[0]["Module"] = "Invoice";
			$arrySale[0]["ModuleID"] = "InvoiceID";
			$arrySale[0]["PrefixSale"] = "INV";
			$arrySale[0]["ShippedDate"] = $ShippedDate;
			$arrySale[0]["Freight"] = $Freight;
			$arrySale[0]["TotalAmount"] = $TotalAmount;	
			$arrySale[0]["InvoicePaid"] = $InvoicePaid;	
			$arrySale[0]["InvoiceComment"] = $InvoiceComment;	
			$order_id = $this->AddSale($arrySale[0]);


			/******** Item Updation for Invoice ************/
			$arryItem = $this->GetSaleItem($ReceiveOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				
				if(!empty($arryDetails['id'.$i]) && $arryDetails['qty'.$i]>0){
					$qty_received = $arryDetails['qty'.$i];
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount ,Taxable) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["item_taxable"]."')";

					$this->query($sql, 0);	

				}
			}

			//echo $order_id; exit; 


			return $order_id;
		}



		function  ListReturn($arryDetails)
		{
			
			global $Config;
			extract($arryDetails);
	
			$strAddQuery = "where o.Module='Return' ";
			$SearchKey   = strtolower(trim($key));

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 

			$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");
			$strAddQuery .= (!empty($FromDateRtn))?(" and o.ReturnDate>='".$FromDateRtn."'"):("");
			$strAddQuery .= (!empty($ToDateRtn))?(" and o.ReturnDate<='".$ToDateRtn."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and o.ReturnPaid='Yes'"; 
			}else if($SearchKey=='no' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and o.ReturnPaid!='Yes'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.ReturnID like '%".$SearchKey."%'  or o.InvoiceID like '%".$SearchKey."%'  or o.SaleID like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' ) " ):("");	
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.OrderDate, o.ReturnDate, o.OrderID, o.SaleID,o.ReturnID,o.InvoiceID, o.CustCode, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.ReturnPaid,o.SalesPerson  from s_order o ".$strAddQuery;
		//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}

		function UpdateInvoice($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update s_order set ShippedDate='".$ShippedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes($InvoiceComment)."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID='".$OrderID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

		function  CountSkuSerialNo($Sku)
		{
			$strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and Sku='".$Sku."'";
			$arryRow = $this->query($strSQLQuery, 1);
			
			$sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='".$Sku."' group by i.sku";			
			$arryInvoiced = $this->query($sqlInvoiced);
			$NumLeft = $arryRow[0]['TotalSerial']-$arryInvoiced[0]['QtyInvoiced'];
			if($NumLeft<0) $NumLeft=0;
			return $NumLeft;		
		}

		function  CountInvoices($SaleID)
		{
			$strSQLQuery = "select count(o.OrderID) as TotalInvoice from s_order o where o.Module='Invoice' and SaleID='".$SaleID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['TotalInvoice'];		
		}

		function RemoveSale($OrderID){
			
			$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}

		function  GetQtyReceived($id)
		{
			$sql = "select sum(i.qty_received) as QtyReceived from s_order_item i where i.ref_id='".$id."' group by i.ref_id";
			$rs = $this->query($sql);
			return $rs[0]['QtyReceived'];
		}

		function  GetQtyOrderded($id)
		{
			$sql = "select i.qty as QtyOrderded from s_order_item i where i.id='".$id."'";
			$rs = $this->query($sql);
			return $rs[0]['QtyOrderded'];
		}


		function ConvertToSaleOrder($OrderID,$SaleID)
		{
			if(empty($SaleID)){
				$SaleID = 'SO000'.$OrderID;
			}

			$sql="UPDATE s_order SET Module='Order',SaleID='".$SaleID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);				

			return true;
		}
		
		
		function  GetSaleOrderForInvoice($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
			$arrayRow = $this->query($strSQLQuery, 1);
			return $arrayRow[0];
		}		
		
		
		function GenerateInVoice($InvoiceData)
		{
		    global $Config;
		    $arryDetails = $this->GetSaleOrderForInvoice($InvoiceData['OrderID']);
			
			
			extract($arryDetails);
			 		 	
		   
			$InvoiceID = $InvoiceData['InvoiceID'];
            $TotalInvoiceAmount = $InvoiceData['TotalAmount'];
			$Freight = $InvoiceData['Freight'];
			
			$ShippedDate = $InvoiceData['ShippedDate'];
			$wCode = $InvoiceData['wCode'];
			$wName = $InvoiceData['wName'];
			$InvoiceComment = $InvoiceData['InvoiceComment'];
			
			if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];
			
			$strSQLQuery = "INSERT INTO s_order SET Module = 'Invoice', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', CustomerName = '".addslashes($CustomerName)."', BillingName = '".addslashes($BillingName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".addslashes($Freight)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."' ";

	
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			if(empty($InvoiceID)){
				$InvoiceID = 'IN000'.$OrderID;
			}

			$sql="UPDATE s_order SET InvoiceID='".$InvoiceID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);	
			return $OrderID;
		}
		
		function AddInvoiceItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			$discountAmnt = 0;$taxAmnt=0; $totalTaxAmnt=0;
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['qty'.$i])){
					
					$id = $arryDetails['id'.$i];
					
					if($arryDetails['tax'.$i] > 0){
						$actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i]; 	
						$taxAmnt = ($actualAmnt*$arryDetails['tax'.$i])/100;
						$totalTaxAmnt += $taxAmnt;
					}


					$sql = "insert into s_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".addslashes($arryDetails['tax_id'.$i])."', '".addslashes($arryDetails['tax'.$i])."', '".addslashes($arryDetails['amount'.$i])."', '".addslashes($arryDetails['discount'.$i])."', '".addslashes($arryDetails['item_taxable'.$i])."')";
					$this->query($sql, 0);	
					
					$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qtyreceived = $arrRow[0]['qty_received'];
					$qtyreceived = $qtyreceived+$arryDetails['qty'.$i];
					
					$qtyinvoiced = $arrRow[0]['qty_invoiced'];
					$qtyinvoiced = $qtyinvoiced+$arryDetails['qty'.$i];
					
					$sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);	
				}
			}


		 $strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
		$this->query($strSQL, 0);



			return true;

		}
		
		
		function  GetQtyInvoiced($id)
		{
			$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty) as Qty from s_order_item i where i.OrderID='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			return $rs;
		}
		
		function  GetQtyReturned($id)
		{
			$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty_returned) as QtyReturned from s_order_item i where i.OrderID='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			return $rs;
		}
		
		
		function RemoveInvoice($OrderID){
			
			$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}
		function  addPaymentInformation($arryDetails)
		{
		    global $Config;
			extract($arryDetails);
			$strSQLQuery = "INSERT INTO s_invoice_payment SET  OrderID = '".$OrderID."', CustID = '".$CustID."', CustCode = '".$CustCode."', SaleID = '".$SaleID."', InvoiceID='".$InvoiceID."', PaidAmount = '".$PaidAmount."', PaidReferenceNo = '".addslashes($PaidReferenceNo)."', PaidDate = '".$PaidDate."', PaidComment = '".addslashes($PaidComment)."',PaidMethod= '".addslashes($PaidMethod)."'";
			$this->query($strSQLQuery, 1);
		}
		
		function GetPaymentInvoice($oid)
		{
			$strSQLQuery = "select * from s_invoice_payment where OrderID='".$oid."' order by InvoicePayID desc";
			return $this->query($strSQLQuery, 1);
		}
		
		function GetTotalPaymentAmntForInvoice($oid)
		{
		    $strSQLQuery = "select sum(PaidAmount) as total from s_invoice_payment where OrderID='".$oid."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
		
		function GetTotalPaymentAmntForOrder($SaleID)
		{
		    $strSQLQuery = "select sum(PaidAmount) as total from s_invoice_payment where SaleID='".$SaleID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
		
		function updateInvoiceStatus($oid,$chk)
		{
			   if($chk == 1){$InvoiceStatus = "Part Paid";}else{ $InvoiceStatus = "Paid";}
			  
			   $strSQLQuery = "update s_order set InvoicePaid = '".$InvoiceStatus."' where OrderID='".$oid."'";
			   $this->query($strSQLQuery, 0);
		}
		
		function updateOrderStatus($SaleID)
		{
		   $strSQLQuery = "update s_order set Status = 'Completed' where SaleID='".$SaleID."'";
		   $this->query($strSQLQuery, 0);
		}
		
		function isEmailExists($Email,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != ".$OrderID):("");
			$strSQLQuery = "select OrderID from s_order where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isQuoteExists($QuoteID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != ".$OrderID):("");
			$strSQLQuery = "select OrderID from s_order where Module='Quote' and QuoteID='".trim($QuoteID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}	

		function isSaleExists($SaleID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" AND OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "SELECT OrderID from s_order where Module='Order' AND SaleID='".trim($SaleID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}			
		
		function isInvoiceNumberExists($InvoiceID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" AND OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "SELECT OrderID from s_order where Module='Invoice' AND InvoiceID = '".trim($InvoiceID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}		
		

		function isInvoiceExists($InvoiceID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from s_order where Module='Invoice' and InvoiceID='".trim($InvoiceID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}	

	 
		
		
	 function ReturnOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);
			$arrySale = $this->GetSale($ReturnOrderID,'','');
			$arrySale[0]["Module"] = "Return";
			$arrySale[0]["ModuleID"] = "ReturnID";
			$arrySale[0]["PrefixSale"] = "RTN";
			$arrySale[0]["ReturnID"] = $ReturnID;
			$arrySale[0]["ReturnDate"] = $ReturnDate;
			$arrySale[0]["Freight"] = $Freight;
			$arrySale[0]["TotalAmount"] = $TotalAmount;	
			$arrySale[0]["ReturnPaid"] = $ReturnPaid;	
			$arrySale[0]["ReturnComment"] = $ReturnComment;	
			/*$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	
			$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	*/
			$order_id = $this->AddReturnOrder($arrySale[0]);


			/******** Item Updation for Return ************/
			$arryItem = $this->GetSaleItem($ReturnOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id) && $arryDetails['qty'.$i]>0){
					$qty_returned = $arryDetails['qty'.$i];
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, Taxable) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['received_qty'.$i])."', '".addslashes($arryDetails['received_qty'.$i])."','".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."')";

					$this->query($sql, 0);	
					
					//Update Item
					$sqlSelect = "select qty_returned from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_returned = $arrRow[0]['qty_returned'];
					$qty_returned = $qty_returned+$arryDetails['qty'.$i];
					$sqlupdate = "update s_order_item set qty_returned = '".$qty_returned."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);	
					//end code
				}
			}


			return $order_id;
		}
		
		function AddReturnOrder($arryDetails){
		
		    global $Config;
		    
			extract($arryDetails);
			 		 	
			$strSQLQuery = "INSERT INTO s_order SET Module = '".$Module."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".addslashes($Freight)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."', ReturnID = '".$ReturnID."', ReturnDate='".$ReturnDate."',ReturnPaid='".$ReturnPaid."',ReturnComment='".addslashes($ReturnComment)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."' ,tax_auths='".addslashes($tax_auths)."' ";
			//echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			if(empty($ReturnID)){
				$ReturnID = 'RTN000'.$OrderID;
			}

			$sql="UPDATE s_order SET ReturnID='".$ReturnID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);

		 return $OrderID;		
		}
		
		function RemoveReturn($OrderID){
			
			$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}
		
		function UpdateReturn($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update s_order set ReturnPaid='".$ReturnPaid."', ReturnComment='".addslashes($ReturnComment)."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID=".$OrderID.""; 
			$this->query($strSQLQuery, 0);

			return 1;
		}
		
			function isReturnExists($ReturnID,$OrderID=0)
			{
				$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
				$strSQLQuery = "select OrderID from s_order where Module='Return' and ReturnID='".trim($ReturnID)."'".$strSQLQuery;
				$arryRow = $this->query($strSQLQuery, 1);

				if (!empty($arryRow[0]['OrderID'])) {
					return true;
				} else {
					return false;
				}
			}	
			
			
			//Sent All Email Here
			 function AuthorizeSales($OrderID,$Authorize,$Complete)
				{
					global $Config;	


					if($OrderID>0){
					
					if($Authorize==1){
					 $Action = 'Approved';
					}else if($Authorize==2){
				      $Action = 'Cancelled';
					}else if($Authorize==3){
					  $Action = 'Closed'; 
					} 
						
						$arrySale = $this->GetSale($OrderID,'','');
						$module = $arrySale[0]['Module'];

						if($module=='Quote'){	
							$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; 
						}else if($module=='Order'){
							$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
						}

						if($arrySale[0]['AdminType'] == 'admin'){
							$CreatedBy = 'Administrator';
							$ToEmail = $Config['AdminEmail'];
						}else{
							$CreatedBy = stripslashes($arrySale[0]['CreatedBy']);

							$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$arrySale[0]['AdminID']."'";
							$arryEmp = $this->query($strSQLQuery, 1);

							$ToEmail = $arryEmp[0]['Email'];
							$CC = $Config['AdminEmail'];
						}
						
						$OrderDate = ($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED);				
						$SalesPerson = (!empty($arrySale[0]['SalesPerson']))? (stripslashes($arrySale[0]['SalesPerson'])): (NOT_SPECIFIED);
						
						//$CC = "rajeev@sakshay.in";
						/**********************/
						$htmlPrefix = $Config['EmailTemplateFolder'];				
						$contents = file_get_contents($htmlPrefix."sales_auth.htm");
						
						$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
						$contents = str_replace("[URL]",$Config['Url'],$contents);
						$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
						$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
						$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

						$contents = str_replace("[Module]",$module,$contents);
						$contents = str_replace("[Action]",$Action,$contents);
						$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
						$contents = str_replace("[ModuleID]",$arrySale[0][$ModuleID],$contents);
						$contents = str_replace("[OrderDate]",$OrderDate,$contents);
						$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
						$contents = str_replace("[Status]",$arrySale[0]['Status'],$contents);
						$contents = str_replace("[SalesPerson]",$SalesPerson,$contents);
							
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($ToEmail);
						if(!empty($CC)) $mail->AddAddress($CC);
						$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
						$mail->Subject = $Config['SiteName']." - Sale ".$module." has been ".$Action;
						$mail->IsHTML(true);
						$mail->Body = $contents;  
						//echo "To->".$ToEmail."=CC=>".$CC.$contents; exit;
						if($Config['Online'] == '1'){
							$mail->Send();	
						}

					}

					return 1;
		}
		
		function sendAssignedEmail($OrderID, $SalesPersonID)
		{
			global $Config;	


			if($OrderID>0){

				$arrySale = $this->GetSale($OrderID,'','');
				$module = $arrySale[0]['Module'];

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
				}


				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$SalesPersonID."'";
				$arryEmp = $this->query($strSQLQuery, 1);

				$ToEmail = $arryEmp[0]['Email'];
				$CC = $Config['AdminEmail'];

				if($arrySale[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arrySale[0]['CreatedBy']);
				}
				
				$OrderDate = ($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED);				
				

				/**********************/
				if(!empty($ToEmail)){
					$htmlPrefix = $Config['EmailTemplateFolder'];				
					$contents = file_get_contents($htmlPrefix."sales_assigned.htm");
					
					$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

					$contents = str_replace("[Module]",$module,$contents);
					$contents = str_replace("[Action]",$Action,$contents);
					$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
					$contents = str_replace("[ModuleID]",$arrySale[0][$ModuleID],$contents);
					$contents = str_replace("[OrderDate]",$OrderDate,$contents);
					$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
					$contents = str_replace("[Status]",$arrySale[0]['Status'],$contents);
					//$contents = str_replace("[OrderType]",$arrySale[0]['OrderType'],$contents);
					$contents = str_replace("[UserName]",$arryEmp[0]['UserName'],$contents);
						
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($ToEmail);
					if(!empty($CC)) $mail->AddCC($CC);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Sale ".$module."(".$arrySale[0][$ModuleID].")"." has been assigned";
					$mail->IsHTML(true);
					$mail->Body = $contents;  
					//echo "To->".$ToEmail."=CC=>".$CC.$contents; exit;
					if($Config['Online'] == '1'){
						$mail->Send();	
					}
				}



			}

			return 1;
		}
		
		function sendSalesEmail($OrderID)
		{
			global $Config;	


			if($OrderID>0){
				$arrySale = $this->GetSale($OrderID,'','');
				$module = $arrySale[0]['Module'];
				//$CC = "rajeev@sakshay.in";
				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
				}

				if($arrySale[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arrySale[0]['CreatedBy']);
				}
				
				$OrderDate = ($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED);
				$Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

				$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_SPECIFIED);

				$PaymentTerm = (!empty($arrySale[0]['PaymentTerm']))? (stripslashes($arrySale[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$PaymentMethod = (!empty($arrySale[0]['PaymentMethod']))? (stripslashes($arrySale[0]['PaymentMethod'])): (NOT_SPECIFIED);
				$ShippingMethod = (!empty($arrySale[0]['ShippingMethod']))? (stripslashes($arrySale[0]['ShippingMethod'])): (NOT_SPECIFIED);
				$Comment = (!empty($arrySale[0]['Comment']))? (stripslashes($arrySale[0]['Comment'])): (NOT_SPECIFIED);
				$AssignedEmp = (!empty($arrySale[0]['AssignedEmp']))? (stripslashes($arrySale[0]['AssignedEmp'])): (NOT_SPECIFIED);
				$CreatedBy = ($arrySale[0]['AdminType'] == 'admin')? ('Administrator'): ($arrySale[0]['CreatedBy']);
				
				$SalesPerson = (!empty($arrySale[0]['SalesPerson']))? (stripslashes($arrySale[0]['SalesPerson'])): (NOT_SPECIFIED);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."sales_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arrySale[0][$ModuleID],$contents);
				$contents = str_replace("[OrderDate]",$OrderDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
				$contents = str_replace("[Approved]",$Approved,$contents);
				$contents = str_replace("[Status]",$arrySale[0]['Status'],$contents);
				$contents = str_replace("[SalesPerson]",$SalesPerson,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[DeliveryDate]",$DeliveryDate,$contents);
				$contents = str_replace("[PaymentTerm]",$PaymentTerm,$contents);
				$contents = str_replace("[PaymentMethod]",$PaymentMethod,$contents);
				$contents = str_replace("[ShippingMethod]",$ShippingMethod,$contents);
				$contents = str_replace("[AssignedEmp]",$AssignedEmp,$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($CC)) $mail->AddCC($CC);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Sales - New ".$module."(".$arrySale[0][$ModuleID].")";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo "To->".$Config['AdminEmail']."=CC=>".$CC.$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}
		
		function sendSalesPaymentEmail($arryDetails)
		{
		   extract($arryDetails);
			global $Config;	
	
			if($OrderID>0){
				
				$PaidDate = ($PaidDate>0)?(date($Config['DateFormat'], strtotime($PaidDate))):(NOT_SPECIFIED);
				$PaidReferenceNo = (!empty($PaidReferenceNo))? (stripslashes($PaidReferenceNo)): (NOT_SPECIFIED);

				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."sales_invoice_paid.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[InvoiceID]",$InvoiceID,$contents);
				$contents = str_replace("[PaidAmount]",$PaidAmount,$contents);
				$contents = str_replace("[CustomerName]",$CustomerName,$contents);
				$contents = str_replace("[PaidMethod]",$PaidMethod,$contents);
				$contents = str_replace("[PaidDate]",$PaidDate,$contents);
				$contents = str_replace("[PaidReferenceNo]",$PaidReferenceNo,$contents);
				$contents = str_replace("[Currency]",$Currency,$contents);
				
				//$CC = "rajeev@sakshay.in";
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				//if(!empty($CC)) $mail->AddCC($CC);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Payment paid for Invoice Number ".$InvoiceID;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}
			
			//End Email Code
			
			
	  function  ListCreditNote($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where o.Module='Credit' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($FromDate))?(" and (o.PostedDate>='".$FromDate."' OR o.ClosedDate>='".$FromDate."') "):("");
			$strAddQuery .= (!empty($ToDate))?(" and (o.PostedDate<='".$ToDate."' OR o.ClosedDate<='".$ToDate."') "):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.CreditID like '%".$SearchKey."%' or o.CustomerCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.PostedDate ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.ClosedDate, o.OrderDate, o.PostedDate, o.OrderID, o.SaleID, o.CreditID, o.CustomerName, o.CustCode, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency from s_order o ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function isCreditIDExists($CreditID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from s_order where Module='Credit' and CreditID='".trim($CreditID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}


		function sendOrderToCustomer($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			if($OrderID>0){
				$arrySale = $this->GetSale($OrderID,'','');
				$module = $arrySale[0]['Module'];

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID";
				}

				if($arrySale[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arrySale[0]['CreatedBy']);
				}
				
				$OrderDate = ($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED);
				$Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

				$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_SPECIFIED);

				$PaymentTerm = (!empty($arrySale[0]['PaymentTerm']))? (stripslashes($arrySale[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$PaymentMethod = (!empty($arrySale[0]['PaymentMethod']))? (stripslashes($arrySale[0]['PaymentMethod'])): (NOT_SPECIFIED);
				$ShippingMethod = (!empty($arrySale[0]['ShippingMethod']))? (stripslashes($arrySale[0]['ShippingMethod'])): (NOT_SPECIFIED);
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				#$CreatedBy = ($arrySale[0]['AdminType'] == 'admin')? ('Administrator'): ($arrySale[0]['CreatedBy']);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."sales_cust.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arrySale[0][$ModuleID],$contents);
				$contents = str_replace("[OrderDate]",$OrderDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
				$contents = str_replace("[Approved]",$Approved,$contents);
				$contents = str_replace("[Status]",$arrySale[0]['Status'],$contents);
				$contents = str_replace("[OrderType]",$arrySale[0]['OrderType'],$contents);
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[DeliveryDate]",$DeliveryDate,$contents);
				$contents = str_replace("[PaymentTerm]",$PaymentTerm,$contents);
				$contents = str_replace("[PaymentMethod]",$PaymentMethod,$contents);
				$contents = str_replace("[ShippingMethod]",$ShippingMethod,$contents);
				$contents = str_replace("[Customer]",stripslashes($arrySale[0]['CustomerName']),$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Sales ".$module;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}







	
}
?>
