<?
class rmasale extends dbClass
{
	//constructor
	function rmasale()
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

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");
		$strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
		$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
		$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
		$strAddQuery .= (!empty($FromDateInv))?(" and o.InvoiceDate>='".$FromDateInv."'"):("");
		$strAddQuery .= (!empty($ToDateInv))?(" and o.InvoiceDate<='".$ToDateInv."'"):("");

		if($SearchKey==strtolower(ST_CLR_CREDIT)){
			$SearchKey = 'Completed';
		}else if($SearchKey==strtolower(ST_TAX_APP_HOLD)){
			$SearchKey = 'Open';
			$strAddQuery .= " and o.tax_auths='Yes'";
		}else if($SearchKey==strtolower(ST_CREDIT_HOLD)){
			$SearchKey = 'Open';
			$strAddQuery .= " and o.tax_auths='No'";
		}

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

		$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");
		$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			
		if($ToApprove=='1'){
			$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
		}
			
		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

		$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.ReturnID = '' and o.Status != 'Cancelled'"):(" ");
		$strAddQuery .= (!empty($InvoiceID))?(" group by SaleID"):(" ");
			
		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.".$moduledd."Date desc, o.OrderID desc ");
		//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
		//$strAddQuery .= (!empty($asc))?($asc):(" desc");
		$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");
			
			

		#$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.SalesPersonID, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module,o.tax_auths  from s_order o ".$strAddQuery;

		$strSQLQuery = "select o.*  from s_order o " . $strAddQuery;
			
		// echo $strSQLQuery;
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


	function CountCustomerOrder($CustCode,$Module)
	{
		$strSQLQuery = "select Count(OrderID) as TotalOrder from s_order as o WHERE o.Module='".$Module."' and o.CustCode='".$CustCode."' ";
		$rs = $this->query($strSQLQuery, 1);
		return $rs[0]['TotalOrder'];
	}



	function  SalesCommReport($FromDate,$ToDate,$SalesPersonID)
	{
		global $Config;
		$strAddQuery = "";
		$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
		$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

		$strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales,o.SalesPersonID,o.SalesPerson,c.CommOn from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' ) left outer join h_commission c on o.SalesPersonID=c.EmpID where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and o.SalesPerson!='' ".$strAddQuery." group by o.SalesPersonID order by o.SalesPersonID asc";


		return $this->query($strSQLQuery, 1);
	}



	function  PaymentReport($FromDate,$ToDate,$SalesPersonID)
	{
		global $Config;
		$strAddQuery = "";
		$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
		$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

		$strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,o.InvoiceDate,o.OrderDate,o.CustomerName,o.SalesPersonID,o.SalesPerson,o.TotalAmount,c.CommOn from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' ) left outer join h_commission c on o.SalesPersonID=c.EmpID  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." order by p.PaymentDate desc,p.PaymentID desc";


		return $this->query($strSQLQuery, 1);
	}


	function  ListPaymentReport($arryDetails)
	{
		global $Config;
		extract($arryDetails);
		$strAddQuery = "";
		if($fby=='Year'){
			$strAddQuery .= " and YEAR(p.PaymentDate)='".$y."'";
		}else if($fby=='Month'){
			$strAddQuery .= " and MONTH(p.PaymentDate)='".$m."' and YEAR(p.PaymentDate)='".$y."'";
		}else{
			$strAddQuery .= (!empty($f))?(" and p.PaymentDate>='".$f."'"):("");
			$strAddQuery .= (!empty($t))?(" and p.PaymentDate<='".$t."'"):("");
		}

		$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");
		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");

		$strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,o.InvoiceDate,o.OrderDate,o.CustomerName,o.SalesPersonID,o.SalesPerson from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and (p.PaymentType='Sales'  or p.PaymentType = 'Other Income' ) and p.PostToGL='Yes' ) where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." order by p.PaymentDate desc,p.PaymentID desc";


		return $this->query($strSQLQuery, 1);
	}

	/*****************On Total Amount**********************/
	function  GetSalesPayment($FromDate,$ToDate,$SalesPersonID)
	{
		global $Config;
		$strAddQuery = "";
		$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
		$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

		$strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by o.SalesPersonID";

		$arryRow = $this->query($strSQLQuery, 1);
		return $arryRow[0]['TotalSales'];

	}

	function  GetSalesPaymentNonResidual($FromDate,$ToDate,$SalesPersonID)
	{
		global $Config;
		$strAddQuery = "";
		$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
		$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

		$sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by p.InvoiceID order by p.PaymentDate asc limit 0,1";
		$arryInvoice = $this->query($sql_invoice, 1);


		if(!empty($arryInvoice[0]["InvoiceID"])){
			$strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and p.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." group by o.SalesPersonID";

			$arryRow = $this->query($strSQLQuery, 1);
		}

		return $arryRow[0]['TotalSales'];

	}

	/*****************On Per Invoice Payment**********************/

	function  GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$SalesPersonID)
	{
		global $Config;
		$strAddQuery = "";
		$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
		$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");

		$strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." ";

		return $this->query($strSQLQuery, 1);
			
	}

	function  GetSalesPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$SalesPersonID)
	{
		global $Config;
		$strAddQuery = "";
		$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
		$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");
			

		$sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." group by p.InvoiceID order by p.PaymentDate asc limit 0,1";
		$arryInvoice = $this->query($sql_invoice, 1);
			
		$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
		if(!empty($arryInvoice[0]["InvoiceID"])){
			$strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and p.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." ";

			return $this->query($strSQLQuery, 1);
		}
			

	}

	/****************************************/

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

		if($_SESSION['vAllRecord']!=1){
			$strAddQuery .= " and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') ";
		}
		$strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
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
		$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");

		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
		$strAddQuery .= (!empty($asc))?($asc):(" desc");

		#$strSQLQuery = "select o.OrderDate, o.InvoiceEntry,o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from s_order o ".$strAddQuery;

		$strSQLQuery = "select o.*  from s_order o ".$strAddQuery;

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

		if($_SESSION['vAllRecord']!=1){
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



	function  GetSale($OrderID,$SaleID,$Module,$DB='')
	{
		$strAddQuery='';
		$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
		$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
		$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		$strSQLQuery = "select o.*,e.Email as CreatedByEmail from ".$DB."s_order o left outer join ".$DB."h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') where 1 ".$strAddQuery." order by o.OrderID desc";
		//echo $strSQLQuery;die;
			
		$data = $this->query($strSQLQuery, 1);
			
		return $this->query($strSQLQuery, 1);
	}

	function  GetInvoice($OrderID,$InvoiceID,$Module,$Db='')
	{
		$strAddQuery='';
		$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
		$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID='".$InvoiceID."'"):("");
		$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		$strSQLQuery = "select o.* from ".$Db."s_order o where 1".$strAddQuery." order by o.OrderID desc";
		return $this->query($strSQLQuery, 1);
	}

	function  GetReturn($OrderID,$ReturnID,$Module)
	{
		$strAddQuery='';
		$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
		$strAddQuery .= (!empty($ReturnID))?(" and o.ReturnID='".$ReturnID."'"):("");
		$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
		return $this->query($strSQLQuery, 1);
	}

	function  GetSaleItem($OrderID,$DB='')
	{
		$strAddQuery='';
		$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
		//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
		$strSQLQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType,itm.ItemID,itm.CategoryID,w.warehouse_code,w.warehouse_name from ".$DB."s_order_item i left outer join ".$DB."inv_tax_rates t on i.tax_id=t.RateId left outer join ".$DB."inv_items itm on i.item_id=itm.ItemID left outer join ".$DB."inv_categories c on c.CategoryID =itm.CategoryID left outer join ".$DB."w_warehouse w on i.WID=w.WID where 1".$strAddQuery." order by i.id asc";
		return $this->query($strSQLQuery, 1);
	}

	function  GetInvoiceOrder($SaleID)
	{
		$strSQLQuery = "select OrderID from s_order o where SaleID='".$SaleID."' and Module='Invoice' order by o.OrderID asc";
		return $this->query($strSQLQuery, 1);
	}

	function  GetSuppPurchase($CustCode,$OrderID,$SaleID,$Module)
	{
		$strAddQuery='';
		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
		$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
		$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
		$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
		return $this->query($strSQLQuery, 1);
	}

	function AddSale($arryDetails)
	{
		global $Config;
		extract($arryDetails);
		#echo '<pre>'; print_r($arryDetails);exit;
			
		if($Config['CronEntry']==1){ //cron entry
			$EntryType = 'one_time';
			$OrderDate = $Config['TodayDate'];
			$ClosedDate = '';
			$SaleID = '';
			$QuoteID = '';
			$CreditID = '';
			$InvoiceID = '';
			$MainTaxRate = $TaxRate;
			$Status = 'Open';
			if($Module=='Quote'){
				$ModuleID = "QuoteID"; $PrefixSale = "QT";
					
			}else{
				$ModuleID = "SaleID"; $PrefixSale = "SO";

			}
			$arryDetails[$ModuleID] = '';
		}else{
			//none
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
			if(empty($CustomerCurrency ))$CustomerCurrency =  $Config['Currency'];
			$CreatedBy = $_SESSION['UserName'];
			$AdminID = $_SESSION['AdminID'];
			$AdminType = $_SESSION['AdminType'];


		}

			
			

		if($EntryType == 'one_time'){
			$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';
		}

		if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
		if($EntryInterval == 'yearly'){$EntryWeekly = '';}
		if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
		if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

		if($OrderType == 'Against PO'){$PONumber=$PONumber;}else{$PONumber='';}

		$strSQLQuery = "INSERT INTO s_order SET Module = '".$Module."', OrderType = '".$OrderType."', PONumber = '".$PONumber."', EntryType='".$EntryType."',  EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', CreditID = '".$CreditID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', ClosedDate = '".$ClosedDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".addslashes($CustID)."',CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmnt)."', CreatedBy = '".addslashes($CreatedBy)."', AdminID='".$AdminID."',AdminType='".$AdminType."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."',InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."' ,Taxable='".addslashes($Taxable)."' ,Reseller='".addslashes($Reseller)."' , ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."', Spiff='".addslashes($Spiff)."',SpiffContact='".addslashes($SpiffContact)."', SpiffAmount='".addslashes($SpiffAmount)."', TaxRate='".addslashes($MainTaxRate)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."'";

		//crm quote fields
		$strSQLQuery .= " ,subject='".addslashes($subject)."' ,CustType='".addslashes($CustType)."' ,opportunityName='".addslashes($opportunityName)."' ,OpportunityID='".addslashes($OpportunityID)."', assignTo='".addslashes($assignTo)."', AssignType='".addslashes($AssignType)."', GroupID='".addslashes($GroupID)."' ";


		#echo "=>".$strSQLQuery;exit;
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

				if(isset($arryDetails['DropshipCheck'.$i])){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}

				if($id>0){
					$sql = "update s_order_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."',`Condition`='".addslashes($arryDetails['Condition'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."', discount ='".addslashes($arryDetails['discount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."', req_item='".addslashes($arryDetails['req_item'.$i])."',DropshipCheck='".addslashes($DropshipCheck)."',DropshipCost='".addslashes($arryDetails['DropshipCost'.$i])."', SerialNumbers='".addslashes($serial_value)."',WID='".$arryDetails['WID'.$i]."'  where id='".$id."'";
				}else{


					$sql = "insert into s_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, discount, Taxable, req_item,DropshipCheck,DropshipCost,SerialNumbers,`Condition`,WID) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['discount'.$i])."' ,'".addslashes($arryDetails['item_taxable'.$i])."' ,'".addslashes($arryDetails['req_item'.$i])."','".addslashes($DropshipCheck)."','".addslashes($arryDetails['DropshipCost'.$i])."','".addslashes($serial_value)."','".addslashes($arryDetails['Condition'.$i])."','".$arryDetails['WID'.$i]."')";
				}

				$this->query($sql, 0);

			}
		}

		#$strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'";
		$strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'";
		$this->query($strSQL, 0);
		return true;

	}



	function UpdateSale($arryDetails){
		global $Config;
		extract($arryDetails);
			
		if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];

		if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth='';$EntryWeekly = '';}

			
		if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
		if($EntryInterval == 'yearly'){$EntryWeekly = '';}
		if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
		if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

		$strSQLQuery = "UPDATE s_order SET Module = '".$Module."',EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."', OrderDate='".$OrderDate."', InvoiceID = '".$InvoiceID."',SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', ClosedDate = '".$ClosedDate."', Comment = '".addslashes($Comment)."', CustomerCurrency = '".addslashes($CustomerCurrency)."' , CustCode='".addslashes($CustCode)."', CustID = '".addslashes($CustID)."' , BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmnt)."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."',InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."',Spiff='".addslashes($Spiff)."',SpiffContact='".addslashes($SpiffContact)."',SpiffAmount='".addslashes($SpiffAmount)."', TaxRate='".addslashes($MainTaxRate)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."' WHERE OrderID='".$OrderID."'";
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
		$arrySale[0]["taxAmnt"] = $taxAmnt;
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
				$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount ,Taxable,`Condition`,WID) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["item_taxable"]."','".$arryItem[$Count]["Condition"]."','".$arryItem[$Count]["WID"]."')";

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

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");

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
	
	
	
	
	function  listRma($arryDetails)
	{
			
		global $Config;
		extract($arryDetails);

		$strAddQuery = "where o.Module='RMA' ";
		$SearchKey   = strtolower(trim($key));

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");

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
		$strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and UsedSerial = '0' and Sku='".$Sku."'";
		$arryRow = $this->query($strSQLQuery, 1);
			
		/*$sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='".$Sku."' group by i.sku";
			$arryInvoiced = $this->query($sqlInvoiced);


			$NumLeft = $arryRow[0]['TotalSerial']-$arryInvoiced[0]['QtyInvoiced'];

			if($NumLeft<0) $NumLeft=0;*/
		return $arryRow[0]['TotalSerial'];
	}

	function  CountSkuSerialNoAndQtyInvoiced($Sku)
	{
		$strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and Sku='".$Sku."'";
		$arryRow = $this->query($strSQLQuery, 1);
			
		$sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='".$Sku."' group by i.sku";
		$arryInvoiced = $this->query($sqlInvoiced);
		$SerialNoAndQtyInvoiced = $arryRow[0]['TotalSerial']."#".$arryInvoiced[0]['QtyInvoiced'];

		return $SerialNoAndQtyInvoiced;
	}

	function  selectSerialNumberForItem($Sku)
	{
		$strSQLQuery = "select * from inv_serial_item where Status='1' and Sku='".$Sku."' and UsedSerial = '0'";
		return $this->query($strSQLQuery, 1);
	}


	function checkSerializedItem($serialNumber)
	{
		$strSQLQuery = "select Sku from inv_serial_item where Status='1' and serialNumber='".trim($serialNumber)."'";
		$arryRow = $this->query($strSQLQuery, 1);
			
		return $arryRow[0]['Sku'];
	}

	function addSerailNumberForInvoice($arryDetails)
	{
		global $Config;
		extract($arryDetails);
		$strSQLQuery = "update inv_serial_item set UsedSerial = '1' where serialNumber = '".addslashes($serialNumber)."' and Sku = '".addslashes($Sku)."'";
		$this->query($strSQLQuery, 0);
	}

	function addSerailNumberForReturn($arryDetails)
	{
		global $Config;
		extract($arryDetails);
		$strSQLQuery = "update inv_serial_item set UsedSerial = '0' where serialNumber = '".addslashes($serialNumber)."' and Sku = '".addslashes($Sku)."' and warehouse ='".$WID."'";
		$this->query($strSQLQuery, 0);
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
		if(!empty($rs[0]['QtyReceived'])) return $rs[0]['QtyReceived'];
	}

	function  GetQtyInvoicedRma($id)
	{
		$sql = "select i.qty_received as QtyReceived from s_order_item i where i.id='".$id."' ";
		$rs = $this->query($sql);
		if(!empty($rs[0]['QtyReceived']))  return $rs[0]['QtyReceived'];
	}

	function  GetQtyOrderded($id)
	{
		$sql = "select i.qty as QtyOrderded from s_order_item i where i.id='".$id."'";
		$rs = $this->query($sql);
		if(!empty($rs[0]['QtyOrderded'])) return $rs[0]['QtyOrderded'];
	}

	function  GetRequiredItem($id)
	{
		$sql = "select i.req_item, i.sku from s_order_item i where i.id='".$id."'";
		$arrayRow = $this->query($sql);
		return $arrayRow;
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
		$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
		$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
		$strSQLQuery = "select o.* from s_order o where 1 ".$strAddQuery." order by o.OrderID desc";
		$arrayRow = $this->query($strSQLQuery, 1);
		return $arrayRow[0];
	}


	function GenerateInVoice($InvoiceData)
	{
		#echo "<pre>";print_r($InvoiceData);die;
			
		global $Config;
			
			
		//echo "<pre>";print_r($Config);die;
		$arryDetails = $this->GetSaleOrderForInvoice($InvoiceData['OrderID']);
			
			
		extract($arryDetails);

		if($Config['CronEntry']==1){ //cron entry
			$EntryType = 'one_time';
			$InvoiceID = '';
			$InvoiceDate = $Config['TodayDate'];
			$ShippedDate = $Config['TodayDate'];

		}else{

			$InvoiceID = $InvoiceData['InvoiceID'];
			$TotalInvoiceAmount = $InvoiceData['TotalAmount'];
			$Freight = $InvoiceData['Freight'];
			$taxAmnt = $InvoiceData['taxAmnt'];
			$ShippedDate = $InvoiceData['ShippedDate'];
			$wCode = $InvoiceData['wCode'];
			$wName = $InvoiceData['wName'];
			$InvoiceComment = $InvoiceData['InvoiceComment'];
			//	$InvoiceDate = $InvoiceData['InvoiceDate'];
			$InvoiceDate = date('Y-m-d');


			$EntryType = $InvoiceData['EntryType'];
			$EntryFrom = $InvoiceData['EntryFrom'];
			$EntryTo = $InvoiceData['EntryTo'];
			$EntryDate = $InvoiceData['EntryDate'];

			$EntryInterval = $InvoiceData['EntryInterval'];
			$EntryMonth = $InvoiceData['EntryMonth'];
			$EntryWeekly = $InvoiceData['EntryWeekly'];

			$CreatedBy = $_SESSION['UserName'];
			$AdminID = $_SESSION['AdminID'];
			$AdminType = $_SESSION['AdminType'];

		}
			
		if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];

		if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}

		if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
		if($EntryInterval == 'yearly'){$EntryWeekly = '';}
		if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
		if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			
		$strSQLQuery = "INSERT INTO s_order SET Module = 'Invoice', EntryType='".$EntryType."',  EntryInterval='".$EntryInterval."', EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', CustomerName = '".addslashes($CustomerName)."', BillingName = '".addslashes($BillingName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".addslashes($Freight)."' , taxAmnt ='".addslashes($taxAmnt)."', CreatedBy = '".addslashes($CreatedBy)."', AdminID='".$AdminID."',AdminType='".$AdminType."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$InvoiceDate."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."',Spiff='".addslashes($Spiff)."',SpiffContact='".addslashes($SpiffContact)."',SpiffAmount='".addslashes($SpiffAmount)."', TaxRate='".addslashes($TaxRate)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."' ";


		$this->query($strSQLQuery, 0);
		$OrderID = $this->lastInsertId();
			
		if(empty($InvoiceID)){
			$InvoiceID = 'IN000'.$OrderID;
		}

		$sql="UPDATE s_order SET InvoiceID='".$InvoiceID."' WHERE OrderID='".$OrderID."'";
		$this->query($sql,0);

		//SET TRANSACTION DATA

		$arryTransaction['TransactionOrderID'] = $OrderID;
		$arryTransaction['TransactionInvoiceID'] = $InvoiceID;
		$arryTransaction['TransactionDate'] = $InvoiceDate;
		$arryTransaction['TransactionType'] = 'SO Invoice';

		$objItem = new items();
		$objItem->addItemTransaction($arryTransaction,$InvoiceData,$type='SO');

		return $OrderID;
	}


	/* function addItemTransaction($arryTransaction,$arryDetails){

	global $Config;
	extract($arryDetails);
	extract($arryTransaction);


	for($i=1;$i<=$NumLine;$i++){
	if(!empty($arryDetails['qty'.$i])){

	$id = $arryDetails['id'.$i];

	/*if($arryDetails['tax'.$i] > 0){
	$actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i];
	$taxAmnt = ($actualAmnt*$arryDetails['tax'.$i])/100;
	$totalTaxAmnt += $taxAmnt;
	}*/


	/* $sql = "insert into inv_item_transaction set TransactionOrderID = '".$TransactionOrderID."',TransactionInvoiceID='".$TransactionInvoiceID."',TransactionDate='".$TransactionDate."',TransactionType='".$TransactionType."',TransactionSku='".addslashes($arryDetails['sku'.$i])."',TransactionItemID='".$arryDetails['item_id'.$i]."',TransactionDescription='".addslashes($arryDetails['description'.$i])."',TransactionUnitPrice='".addslashes($arryDetails['price'.$i])."',TransactionCurrency='".$Config['Currency']."',TransactionQty='".addslashes($arryDetails['qty'.$i])."'";
	  
	$this->query($sql, 0);


	}
	}

	}*/

	function GenerateInVoiceEntry($arryDetails)
	{
		global $Config;
		extract($arryDetails);

		if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];

		if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}

		if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
		if($EntryInterval == 'yearly'){$EntryWeekly = '';}
		if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
		if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			
		 $strSQLQuery = "INSERT INTO s_order SET Module = 'Invoice', EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."', OrderDate='".$OrderDate."', SaleID ='".$ReferenceNo."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '1',InvoiceEntry='1', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', CustomerName = '".addslashes($CustomerName)."', BillingName = '".addslashes($BillingName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmnt)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($TaxRate)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."' "; 


		$this->query($strSQLQuery, 0);
		$OrderID = $this->lastInsertId();
			
		if(empty($InvoiceID)){
			$InvoiceID = 'IN000'.$OrderID;
		}

		$sql="UPDATE s_order SET InvoiceID='".$InvoiceID."' WHERE OrderID='".$OrderID."'";
		$this->query($sql,0);
		return $OrderID;
	}

	function AddInvoiceItemForEntry($order_id, $arryDetails)
	{
		global $Config;
		extract($arryDetails);

		$discountAmnt = 0;$taxAmnt=0; $totalTaxAmnt=0;
		for($i=1;$i<=$NumLine;$i++){
			if(!empty($arryDetails['qty'.$i])){


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


				if(isset($arryDetails['DropshipCheck'.$i])){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}

				$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable,req_item,DropshipCheck,DropshipCost,SerialNumbers,`Condition`,WID) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".$id."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."', '".addslashes($arryDetails['discount'.$i])."', '".addslashes($arryDetails['item_taxable'.$i])."' , '".addslashes($arryDetails['req_item'.$i])."','".addslashes($DropshipCheck)."','".addslashes($arryDetails['DropshipCost'.$i])."','".$serial_value."','".addslashes($arryDetails['Condition'.$i])."','".addslashes($arryDetails['WID'.$i])."')";
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


		#$strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'";
		$strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'";
		$this->query($strSQL, 0);



		return true;

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



				$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable,req_item,DropshipCheck,DropshipCost,SerialNumbers,`Condition`,WID) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".$id."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".addslashes($arryDetails['tax_id'.$i])."', '".addslashes($arryDetails['tax'.$i])."', '".addslashes($arryDetails['amount'.$i])."', '".addslashes($arryDetails['discount'.$i])."', '".addslashes($arryDetails['item_taxable'.$i])."' , '".addslashes($arryDetails['req_item'.$i])."','".addslashes($arryDetails['DropshipCheck'.$i])."','".addslashes($arryDetails['DropshipCost'.$i])."','".trim($arryDetails['serial_value'.$i])."','".addslashes($arryDetails['Condition'.$i])."','".addslashes($arryDetails['WID'.$i])."')";
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


		#$strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'";
		$strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'";
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
	
	
	
	function  GetQtyRma($id)
	{
		$sql = "select sum(i.qty) as QtyRma from s_order_item i inner join s_order o on i.OrderID=o.OrderID where i.ref_id='".$id."' and o.Module='RMA' group by i.ref_id";
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
		$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
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
		$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
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




	function ReturnOrder($arryDetails,$Db=''){
		global $Config;
		extract($arryDetails);
		$arrySale = $this->GetSale($ReturnOrderID,'','',$Db);
		$arrySale[0]["Module"] = "RMA";
		$arrySale[0]["ModuleID"] = "ReturnID";
		$arrySale[0]["PrefixSale"] = "RTN";
		$arrySale[0]["ReturnID"] = $ReturnID;
		$arrySale[0]["ReturnDate"] = $ReturnDate;
		$arrySale[0]["Freight"] = $Freight;
		//$arrySale[0]["taxAmnt"] = $taxAmnt;
		$arrySale[0]["TotalAmount"] = $TotalAmount;
		$arrySale[0]["ReturnPaid"] = $ReturnPaid;
		$arrySale[0]["ReturnComment"] = $ReturnComment;
		$arrySale[0]["ExpiryDate"] = $ExpiryDate;
		$arrySale[0]["ReSt"] = $ReSt;
		$arrySale[0]["ReStocking"] = $ReStocking; 
		$arrySale[0]["Status"] = $Status; 	
		$arrySale[0]["TDiscount"] = $TDiscount; 
		$arrySale[0]["ReturnOrderID"] = $ReturnOrderID; 
    $arrySale[0]["taxAmntR"] = $taxAmnt;
		$arrySale[0]['EDIRefNo'] = $EDIRefNo;
		$order_id = $this->AddReturnOrder($arrySale[0],$Db);

		$strSQL = "select ReturnID from ".$Db."s_order where OrderID = '".$order_id."' ";
		$arryReturnID = $this->query($strSQL, 1);
		$arrySale[0]["ReturnID"] = $arryReturnID[0]['ReturnID'];


		/******** Item Updation for Return ************/
		$arryItem = $this->GetSaleItem($ReturnOrderID,$Db);

		$NumLine = sizeof($arryItem);
		for($i=1;$i<=$NumLine;$i++){

			$Count=$i-1;
			$id = $arryDetails['id'.$i];
			if(!empty($id) && $arryDetails['qty'.$i]>0){
				$qty_returned = $arryDetails['qty'.$i];
				$SerialNumbers = $arryDetails['serial_value'.$i];

				$Type = $arryDetails['Type'.$i];
				$Action = $arryDetails['Action'.$i];
				$Reason = $arryDetails['Reason'.$i];
					

				$sql = "insert into ".$Db."s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, discount, Taxable, req_item, SerialNumbers, `Condition`, Type, Action, Reason, WID, DropshipCheck, DropshipCost, fee) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".addslashes($arryItem[$Count]["sku"])."', '".addslashes($arryItem[$Count]["description"])."', '".$arryItem[$Count]["on_hand_qty"]."', '".$qty_returned."', '0','0','0', '".$arryDetails['price'.$i]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryDetails['discount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$arryDetails['serial_value'.$i]."','".addslashes($arryDetails['Condition'.$i])."','".$Type."','".$Action."','".$Reason."', '".$arryDetails['WID'.$i]."', '".$arryDetails['DropshipCheck'.$i]."', '".addslashes($arryDetails['DropshipCost'.$i])."' ,'".addslashes($arryDetails['restocking_fee'.$i])."' )";
				$this->query($sql, 0);


				
/********************CODE FOR ADD SERIAL NUMBERS*******************************************
         if($Status =='Completed' && $arryDetails['DropshipCheck'.$i]==1){ 
              if ($arryDetails['serial_value'.$i] != '' && !empty($arryDetails['serial_value'.$i])) {
                      $serial_no = explode(",", $arryDetails['serial_value'.$i]);
$wCode =1;
                      for ($j = 0; $j < sizeof($serial_no); $j++) {
                              $strSQLQuery = "insert into inv_serial_item (serialNumber,Sku,UsedSerial,ReceiveOrderID,`Condition`,warehouse,Status,	UnitCost)  values ('" . $serial_no[$j] . "','" .addslashes($arryItem[$Count]["sku"]). "','1','" . $order_id . "','".$arryDetails['Condition'.$i]."','".$arryDetails['WID'.$i]."',1,'".$arryDetails['DropshipCost'.$i]."')";
                              $this->query($strSQLQuery, 0);

                      }
              }
       }	*/
				//Update Item/*
				/*
				$sqlSelect = "select qty_returned from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
				$arrRow = $this->query($sqlSelect, 1);
				$qty_returned = $arrRow[0]['qty_returned'];
				$qty_returned = $qty_returned+$arryDetails['qty'.$i];
				$sqlupdate = "update s_order_item set qty_returned = '".$qty_returned."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
				$this->query($sqlupdate, 0);
				//end code*/


				/*
				if($Type=='AC'){
					$arrayCrData[$i]['item_id']=$arryItem[$Count]["item_id"];
					$arrayCrData[$i]['id']=$arryDetails['id'.$i];
					$arrayCrData[$i]['qty_returned']=$arryDetails['qty'.$i];
					$arrayCrData[$i]['SerialNumbers']=$arryDetails['serial_value'.$i];
					$arrayCrData[$i]['sku']=$arryItem[$Count]["sku"];
					$arrayCrData[$i]['description']=$arryItem[$Count]["description"];
					$arrayCrData[$i]['on_hand_qty']=$arryItem[$Count]["on_hand_qty"];
					$arrayCrData[$i]['qty']=$arryItem[$Count]["qty"];
					$arrayCrData[$i]['received_qty']=$arryDetails['received_qty'.$i];
					//$arrayCrData[$i]['price']=$arryItem[$Count]["price"];
					$arrayCrData[$i]['price']=$arryDetails['price'.$i];
					//$arrayCrData[$i]['tax_id']=$arryItem[$Count]["tax_id"];
					//$arrayCrData[$i]['tax']=$arryItem[$Count]["tax"];
					$arrayCrData[$i]['amount']=$arryDetails['amount'.$i];
					$arrayCrData[$i]['discount']=$arryDetails['discount'.$i];
					//$arrayCrData[$i]['Taxable']=$arryItem[$Count]["Taxable"];
					$arrayCrData[$i]['req_item']=$arryItem[$Count]["req_item"];
					//$arrayCrData[$i]['SerialNumbers']=$arryDetails['SerialNumbers'.$i];
					$arrayCrData[$i]['Condition']=$arryDetails['Condition'.$i];
					$arrayCrData[$i]['Type']=$Type;
					$arrayCrData[$i]['Action']=$Action;
					$arrayCrData[$i]['Reason']=$Reason;
						
				    $totalAmountForCredit+=$arryDetails['amount'.$i];

				}
					
				if($Type=='AR'){

					$arrayOrdData[$i]['item_id']=$arryItem[$Count]["item_id"];
					$arrayOrdData[$i]['id']=$arryDetails['id'.$i];
					$arrayOrdData[$i]['qty_returned']= $arryDetails['qty'.$i];
					$arrayOrdData[$i]['SerialNumbers']=$arryDetails['serial_value'.$i];
					$arrayOrdData[$i]['sku']=$arryItem[$Count]["sku"];
					$arrayOrdData[$i]['description']=$arryItem[$Count]["description"];
					$arrayOrdData[$i]['on_hand_qty']=$arryItem[$Count]["on_hand_qty"];
					$arrayOrdData[$i]['qty']=$arryItem[$Count]["qty"];
					$arrayOrdData[$i]['received_qty']=$arryDetails['received_qty'.$i];
					//$arrayOrdData[$i]['price']=$arryItem[$Count]["price"];
					$arrayOrdData[$i]['price']= $arryDetails['price'.$i];
					//$arrayOrdData[$i]['tax_id']=$arryItem[$Count]["tax_id"];
					//$arrayOrdData[$i]['tax']=$arryItem[$Count]["tax"];
					$arrayOrdData[$i]['amount']=$arryDetails['amount'.$i];
					//$arrayOrdData[$i]['Taxable']=$arryItem[$Count]["Taxable"];
					$arrayOrdData[$i]['discount']=$arryDetails['discount'.$i];
					$arrayOrdData[$i]['req_item']=$arryItem[$Count]["req_item"];
					//$arrayOrdData[$i]['SerialNumbers']=$arryDetails['SerialNumbers'.$i];
					$arrayOrdData[$i]['Condition']=$arryDetails['Condition'.$i];
					$arrayOrdData[$i]['Type']=$Type;
					$arrayOrdData[$i]['Action']=$Action;
					$arrayOrdData[$i]['Reason']=$Reason;
					
					$totalAmountForReplacement+=$arryDetails['amount'.$i];


				}*/
					

			}
		}

		/*****Add Credit Note********
		if(sizeof($arrayCrData)>0){
			$ct_id = $this->AddCreditSalesRma($arrySale[0],$totalAmountForCredit);
			foreach($arrayCrData as $arrayCrValue){				
				
				$sqls = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, discount, Taxable, req_item,SerialNumbers,`Condition`,Type,Action,Reason) values('".$ct_id."', '".$arrayCrValue['item_id']."' , '0', '".$arrayCrValue['sku']."', '".$arrayCrValue['description']."', '".$arrayCrValue["on_hand_qty"]."', '".$arrayCrValue["qty_returned"]."', '".addslashes($arrayCrValue['received_qty'])."', '".addslashes($arrayCrValue['received_qty'])."','".$arrayCrValue["qty_returned"]."', '".$arrayCrValue["price"]."', '".$arrayCrValue["tax_id"]."', '".$arrayCrValue["tax"]."', '".$arrayCrValue['amount']."' , '".$arrayCrValue['discount']."', '".$arrayCrValue["Taxable"]."', '".addslashes($arrayCrValue["req_item"])."','".$arrayCrValue['SerialNumbers']."','".$arrayCrValue['Condition']."','".$arrayCrValue['Type']."','".$arrayCrValue['Action']."','".$arrayCrValue['Reason']."')";
				
				$this->query($sqls, 0);
			}

		}
		/*****************/
		/*****Add SO********

		if(sizeof($arrayOrdData)>0){
			$rts_id = $this->AddReplacementSalesRma($arrySale[0],$totalAmountForReplacement);
			foreach($arrayOrdData as $arrayCrOrderValue){		
				
				$sqls = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, discount, Taxable, req_item,SerialNumbers,`Condition`,Type,Action,Reason) values('".$rts_id."', '".$arrayCrOrderValue['item_id']."' , '0', '".$arrayCrOrderValue['sku']."', '".$arrayCrOrderValue['description']."', '".$arrayCrOrderValue["on_hand_qty"]."', '".$arrayCrOrderValue["qty_returned"]."', '0', '0','0', '".$arrayCrOrderValue["price"]."', '".$arrayCrOrderValue["tax_id"]."', '".$arrayCrOrderValue["tax"]."', '".$arrayCrOrderValue['amount']."', '".$arrayCrOrderValue['discount']."' , '".$arrayCrOrderValue["Taxable"]."', '".addslashes($arrayCrOrderValue["req_item"])."','".$arrayCrOrderValue['SerialNumbers']."','".$arrayCrOrderValue['Condition']."','".$arrayCrOrderValue['Type']."','".$arrayCrOrderValue['Action']."','".$arrayCrOrderValue['Reason']."')";
				
				$this->query($sqls, 0);
			}


		}
		/*****************/

		return $order_id;
	}

	function AddCreditSalesRma($arryDetails,$totalAmountForCredit){
		global $Config;
		extract($arryDetails);
		$taxAmnt=0;
		$Taxable='';
		$TaxRate='';
		$IPAddress = GetIPAddress();
			
		/*if($CustomerCurrency != $Config['Currency']){  
			$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR');
		}else{   
			$ConversionRate=1;
		}*/

		/************Approved***********/
		$objConfigure = new configure();
		$AutomaticApprove = $objConfigure->getSettingVariable('SO_APPROVE'); 
		$Approved = $AutomaticApprove;
		/*******************************/

		if($ReSt==1 && $ReStocking>0){
			$totalAmountForCredit = $totalAmountForCredit - $ReStocking;
		}else{
			$ReSt=$ReStocking=0;
		}

		$strSQLQuery = "INSERT INTO s_order SET Module = 'Credit', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', ReturnID = '".$ReturnID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = 'Open', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".$totalAmountForCredit."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".$Freight."', taxAmnt ='".$taxAmnt."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',  ReturnDate='".$ReturnDate."',ReturnPaid='".$ReturnPaid."',ReturnComment='".addslashes($ReturnComment)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."' ,tax_auths='".addslashes($tax_auths)."', TaxRate='".$TaxRate."', ConversionRate='".addslashes($ConversionRate)."',IPAddress = '". $IPAddress."', CreatedDate='".$Config['TodayDate']."' ,ReSt = '". $ReSt."',ReStocking = '". $ReStocking."' ";
		//echo "=>".$strSQLQuery;exit;
		$this->query($strSQLQuery, 0);
		$CrID = $this->lastInsertId();
		

		$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('s_order','Credit',$CrID,'');  

 
		
		/*********CreditLimit Updation***********/
		$strSQlCust = "select PaymentTerm from s_customers c WHERE CustCode='".$CustCode."'";
		$arrCust = $this->query($strSQlCust, 1);			
		if(!empty($arrCust[0]['PaymentTerm'])){
			$arryTerm = explode("-",$arrCust[0]['PaymentTerm']);
			$TermDays = (int)trim($arryTerm[1]);
			if($TermDays > 0){
				$sql="UPDATE s_customers SET CreditLimit=CreditLimit-".$totalAmountForCredit." WHERE CustCode='".$CustCode."' and CreditLimit>0";
				$this->query($sql,0);
				$sql2="UPDATE s_customers SET CreditLimit='0' WHERE CustCode='".$CustCode."' and CreditLimit<0";
				$this->query($sql2,0);
			}
		}
		/*****************************************/

		 

		return $CrID;
	}


	function AddReplacementSalesRma($arryDetails,$totalAmountForReplacement){
		global $Config;
		extract($arryDetails);
		$IPAddress = GetIPAddress();
		$taxAmnt=0;
		$Taxable='';
		$TaxRate='';
		$Approved=0;
		$OrderedDate = $Config['TodayDate'];
		/*if($CustomerCurrency != $Config['Currency']){  
			$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR');
		}else{   
			$ConversionRate=1;
		}*/

		$strSQLQuery = "INSERT INTO s_order SET Module = 'Order', OrderDate='".$OrderedDate."', SaleID ='".$SaleID."', ReturnID = '".$ReturnID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = 'Open', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".$totalAmountForReplacement."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='0.00', taxAmnt ='".addslashes($taxAmnt)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',  ReturnDate='".$ReturnDate."',ReturnPaid='".$ReturnPaid."',ReturnComment='".addslashes($ReturnComment)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."' ,tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($TaxRate)."', ConversionRate='".addslashes($ConversionRate)."',IPAddress = '". $IPAddress."' , CreatedDate='".$Config['TodayDate']."'";
		//echo "=>".$strSQLQuery;exit;
		$this->query($strSQLQuery, 0);
		$RcID = $this->lastInsertId();
			
		

		/*$SaleID = 'SO000'.$RcID;

		$sql="UPDATE s_order SET SaleID='".$SaleID."' WHERE OrderID='".$RcID."'";
		$this->query($sql,0);*/

		$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('s_order','Order',$RcID,'');  


		return $RcID;
	}



	function updateSalesCrRt($SaleID,$CreditID,$OrderID){
		//$strSQLQuery="UPDATE s_order SET SaleID= '".$SaleID."',CreditID='".$CreditID."' WHERE OrderID='".$OrderID."'";
		//$this->query($strSQLQuery, 0);

	}

	function getSalesRID($OrderID){
		$strSQLQuery="SELECT `SaleID`,`CreditID` FROM s_order WHERE OrderID='".$OrderID."'";
		$this->query($strSQLQuery, 0);

	}


	function UpdateRma($arryDetails){
		global $Config;
		extract($arryDetails);
		if($OrderID>0){
			$strSQLQuery = "update s_order set  Status = '".$Status."',ReturnComment='".addslashes($ReturnComment)."', ReturnDate='".$ReturnDate."', UpdatedDate = '".$Config['TodayDate']."' , ExpiryDate='".addslashes($ExpiryDate)."', TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmnt)."', ReSt='".addslashes($ReSt)."' , ReStocking='".addslashes($ReStocking)."',TDiscount='".addslashes($TDiscount)."'	where OrderID='".$OrderID."'"; 
			
			$this->query($strSQLQuery, 0);

			$arryItem = $this->GetSaleItem($OrderID);
//echo '<pre>';print_r($arryItem);exit;
		$NumLine = sizeof($arryItem);
		for($i=1;$i<=$NumLine;$i++){

			$Count=$i-1;
			$id = $arryDetails['id'.$i];
			if(!empty($id)){
				$qty_returned = $arryDetails['qty'.$i];
				$SerialNumbers = $arryDetails['serial_value'.$i];

				$Type = $arryDetails['Type'.$i];
				$Action = $arryDetails['Action'.$i];
				$Reason = $arryDetails['Reason'.$i];	
$parent_item_id		= 	$arryDetails['parent_ItemID'.$i];	
$WID		= 	$arryDetails['WID'.$i];

				$sql = "update s_order_item set qty='".$qty_returned."', price =  '".$arryDetails['price'.$i]."', tax_id='".$arryItem[$Count]["tax_id"]."', tax='".$arryItem[$Count]["tax"]."', amount='".$arryDetails['amount'.$i]."', discount='".$arryDetails['discount'.$i]."', Taxable='".$arryItem[$Count]["Taxable"]."', req_item='".addslashes($arryItem[$Count]["req_item"])."',SerialNumbers='".addslashes($arryDetails['serial_value'.$i])."',`Condition`='".addslashes($arryDetails['Condition'.$i])."',Type='".$Type."',Action='".$Action."',Reason='".addslashes($Reason)."',parent_item_id='".addslashes($parent_item_id)."',WID='".addslashes($WID)."',avgCost ='".$arryDetails['avgcost'.$i]."', fee='".addslashes($arryDetails['restocking_fee'.$i])."'  where id='".$id."'";
				$this->query($sql, 0);

				//echo $sql.'<br>';

/*********************************************************
 if($Status =='Completed'){ 
              if ($arryDetails['serial_value'.$i] != '' && !empty($arryDetails['serial_value'.$i])) {
                      $serial_no = explode(",", $arryDetails['serial_value'.$i]);
$wCode =1;
                      for ($j = 0; $j < sizeof($serial_no); $j++) {
                              $strSQLQuery = "insert into inv_serial_item (serialNumber,Sku,UsedSerial,ReceiveOrderID,`Condition`,warehouse,Status)  values ('" . $serial_no[$j] . "','" .addslashes($arryItem[$Count]["sku"]). "','1','" . $OrderID . "','".$arryDetails['Condition'.$i]."','".$arryDetails['WID'.$i]."',1)";
                              $this->query($strSQLQuery, 0);

                      }
              }
       }
*********************************************************/


			}
		}
 

			$objConfigure = new configure();
			$objConfigure->EditUpdateAutoID('s_order','ReturnID',$OrderID,$ReturnID); 
		}

		return 1;
	}

	function AddReturnOrder($arryDetails,$Db=''){
		
		global $Config;

		extract($arryDetails);
		$IPAddress = GetIPAddress();

		$strSQLQuery = "INSERT INTO ".$Db."s_order SET Module = '".$Module."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmntR)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."' , CreatedDate='".$Config['TodayDate']."' ,
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."', ReturnID = '".$ReturnID."', ReturnDate='".$ReturnDate."',ReturnPaid='".$ReturnPaid."',ReturnComment='".addslashes($ReturnComment)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."' ,tax_auths='".addslashes($tax_auths)."', TaxRate='".$TaxRate."' , ExpiryDate='".addslashes($ExpiryDate)."', ReSt='".addslashes($ReSt)."' , TDiscount='".addslashes($TDiscount)."',ReStocking='".addslashes($ReStocking)."' , ConversionRate='".addslashes($ConversionRate)."',IPAddress = '". $IPAddress."',
CustomerPO='".addslashes($CustomerPO)."', OrderSource='".addslashes($OrderSource)."', reference_id='".addslashes($reference_id)."', EntryBy='".addslashes($EntryBy)."',EDIRefNo='".addslashes($EDIRefNo)."',EdiRefInvoiceID='".addslashes($EdiRefInvoiceID)."',EDICompName='".addslashes($EDICompName)."',EDICompId='".addslashes($EDICompId)."' ";
		//echo "=>".$strSQLQuery;exit;
		$this->query($strSQLQuery, 0);
		$OrderID = $this->lastInsertId();
			
		/*if(empty($ReturnID)){
			$ReturnID = 'RMA000'.$OrderID;
		}

		$sql="UPDATE s_order SET ReturnID='".$ReturnID."' WHERE OrderID='".$OrderID."'";
		$this->query($sql,0);*/

		$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('s_order',$Module,$OrderID,$ReturnID,$Db);  
		

		return $OrderID;
	}

	function RemoveReturn($OrderID){
		global $Config;
		$objFunction=new functions();
		$objConfig=new admin();	
		if(!empty($OrderID)){
			$strSQLQuery = "select Module,ReturnID from s_order where OrderID='".$OrderID."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			/******Delete PDF**********/ 
			$PdfFile = "SalesRMA-".$arryRow[0]['ReturnID'].'.pdf';
			$objFunction->DeleteFileStorage($Config['S_Rma'],$PdfFile);	

			$PdfTemplateArray = array('ModuleDepName' => "SalesRMA",  'PdfDir' => $Config['S_Rma'], 'TableName' => 's_order', 'OrderID' => $OrderID, 'ModuleID' => "ReturnID");
			$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);	
			/**************************/

			$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'";
			$this->query($strSQLQuery, 0);
		}

		return 1;

	}

	function AddCreditSalesFromRMA($OrderID){
	    	$arrySale = $this->GetRma($OrderID,'','');
 
		$arryItem = $this->GetSaleItem($OrderID);
		$NumLine = sizeof($arryItem);

		$ReStocking=0;
		for($i=1;$i<=$NumLine;$i++){
			$Count=$i-1;
			$Type = $arryItem[$Count]['Type'];	
			if($Type=="AC"){
				$arrayCrData[$i]['item_id']=$arryItem[$Count]["item_id"]; 
				$arrayCrData[$i]['SerialNumbers']=$arryItem[$Count]['SerialNumbers'];
				$arrayCrData[$i]['sku']=$arryItem[$Count]["sku"];
				$arrayCrData[$i]['description']=$arryItem[$Count]["description"];
				$arrayCrData[$i]['on_hand_qty']=$arryItem[$Count]["on_hand_qty"];
				$arrayCrData[$i]['qty'] = $arryItem[$Count]["qty"];				
				$arrayCrData[$i]['price']=$arryItem[$Count]['price'];
				$arrayCrData[$i]['amount']=$arryItem[$Count]['amount'];
				$arrayCrData[$i]['discount']=$arryItem[$Count]['discount'];
				$arrayCrData[$i]['req_item']=$arryItem[$Count]["req_item"];
				$arrayCrData[$i]['Condition']=$arryItem[$Count]['Condition'];			
				$arrayCrData[$i]['fee']=$arryItem[$Count]['fee'];	
		
				$ReStocking+= $arryItem[$Count]['fee'];	
			    	$totalAmountForCredit+= $arryItem[$Count]['amount']; 
			}else if($Type=="AR"){ 
				$arrayOrdData[$i]['item_id']= $arryItem[$Count]["item_id"];			
				$arrayOrdData[$i]['SerialNumbers']= $arryItem[$Count]['SerialNumbers'];
				$arrayOrdData[$i]['sku']= $arryItem[$Count]["sku"];
				$arrayOrdData[$i]['description']= $arryItem[$Count]["description"];
				$arrayOrdData[$i]['on_hand_qty']= $arryItem[$Count]["on_hand_qty"];
				$arrayOrdData[$i]['qty'] = $arryItem[$Count]["qty"];				
				$arrayOrdData[$i]['price']= $arryItem[$Count]['price'];
				$arrayOrdData[$i]['amount']=$arryItem[$Count]['amount'];
				$arrayOrdData[$i]['discount']=$arryItem[$Count]['discount'];
				$arrayOrdData[$i]['req_item']=$arryItem[$Count]["req_item"];
				$arrayOrdData[$i]['Condition']=$arryItem[$Count]['Condition'];				
				$totalAmountForReplacement+= $arryItem[$Count]['amount'];

			}
		}
		/******** Credit  ******/
		if(sizeof($arrayCrData)>0){	
			$arrySale[0]['ReStocking'] = $ReStocking;
			$CreditID = $this->AddCreditSalesRma($arrySale[0],$totalAmountForCredit);
			foreach($arrayCrData as $arrayCrValue){
				$sqlCrd = "insert into s_order_item(OrderID, item_id, sku, description, on_hand_qty, qty,  price, amount, discount, req_item,SerialNumbers,`Condition`,WID,fee) values('".$CreditID."', '".$arrayCrValue['item_id']."' , '".addslashes($arrayCrValue['sku'])."', '".addslashes($arrayCrValue['description'])."', '".$arrayCrValue["on_hand_qty"]."', '".$arrayCrValue["qty"]."', '".$arrayCrValue["price"]."', '".$arrayCrValue['amount']."' , '".$arrayCrValue['discount']."',  '".addslashes($arrayCrValue["req_item"])."','".addslashes($arrayCrValue['SerialNumbers'])."','".addslashes($arrayCrValue['Condition'])."','".$arrayCrValue['WID']."' ,'".addslashes($arrayCrValue['fee'])."')";
				$this->query($sqlCrd, 0);
			}
			$_SESSION["SR_CreditID"] = $CreditID;
		}
		/******** Replacement  ********/		
		if(sizeof($arrayOrdData)>0){
			$SaleID = $this->AddReplacementSalesRma($arrySale[0],$totalAmountForReplacement);
			foreach($arrayOrdData as $arrayCrOrderValue){
				$sqlSO = "insert into s_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price,  amount, discount, req_item,SerialNumbers,`Condition`,WID) values('".$SaleID."', '".$arrayCrOrderValue['item_id']."' , '".addslashes($arrayCrOrderValue['sku'])."', '".addslashes($arrayCrOrderValue['description'])."', '".$arrayCrOrderValue["on_hand_qty"]."', '".$arrayCrOrderValue["qty"]."', '".$arrayCrOrderValue["price"]."', '".$arrayCrOrderValue['amount']."', '".$arrayCrOrderValue['discount']."' , '".addslashes($arrayCrOrderValue["req_item"])."','".addslashes($arrayCrOrderValue['SerialNumbers'])."','".addslashes($arrayCrOrderValue['Condition'])."','".$arrayCrOrderValue['WID']."')";
				$this->query($sqlSO, 0);
			}


		}

}

	function UpdateReturn($arryDetails){
		global $Config;
		extract($arryDetails);

		$strSQLQuery = "update s_order set ReturnPaid='".$ReturnPaid."', ReturnComment='".addslashes($ReturnComment)."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID='".$OrderID."'"; 
		$this->query($strSQLQuery, 0);

		return 1;
	}
	
	
	function UpdateStatusRma($OrderID){
		$strSQLQuery = "update s_order set Status='Closed' where OrderID='".$OrderID."'"; 
		$this->query($strSQLQuery, 0);

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
		$strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
		$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
		$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");

		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.PostedDate ");
		$strAddQuery .= (!empty($asc))?($asc):(" desc");

		#$strSQLQuery = "select o.ClosedDate, o.OrderDate, o.PostedDate, o.OrderID, o.SaleID, o.CreditID, o.CustomerName, o.CustCode, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency from s_order o ".$strAddQuery;
		$strSQLQuery = "select o.* from s_order o ".$strAddQuery;

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



	/****************Recurring Function Satrt************************************/
	function RecurringInvoice(){
		global $Config;

		//$Config['TodayDate'] = '2015-02-14 12:08:09';

		$Config['CronEntry']=1;
		$arryDate = explode(" ", $Config['TodayDate']);
		$arryDay = explode("-", $arryDate[0]);

		$Month = (int)$arryDay[1];
		$Day = $arryDay[2];

		$Din = date("l",strtotime($arryDate[0]));

		#$strSQLQuery = "select o.OrderID from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' and o.EntryDate='".$arryDay[2]."' and CASE WHEN o.EntryInterval='yearly' THEN o.EntryMonth='".$Month."'  ELSE 1 END = 1 ";

	 $strSQLQuery = "select o.* from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."'";




	 $arrySale = $this->myquery($strSQLQuery, 1);
	 // echo "<pre>";print_r($arrySale);exit;


	 foreach($arrySale as $value){


	 	$OrderFlag=0;
	 	switch($value['EntryInterval']){
	 		case 'biweekly':
	 			$NumDay = 0;
	 			if($value['LastRecurringEntry']>0){
	 				$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);
	 			}

	 			if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
	 				$OrderFlag=1;
	 			}
	 			break;
	 		case 'semi_monthly':
	 			if($Day=="01" || $Day=="15"){
	 				$OrderFlag=1;
	 			}
	 			break;
	 		case 'monthly':
	 			if($value['EntryDate']==$Day){
	 				$OrderFlag=1;
	 			}
	 			break;
	 		case 'yearly':
	 			if($value['EntryDate']==$Day && $value['EntryMonth']==$Month){
	 				$OrderFlag=1;
	 			}
	 			break;

	 	}


	 	if($OrderFlag==1){
	 		//echo $value['OrderID'].'<br>';exit;
	 			
	 		$NumLine = 0;
	 		$arrySaleItem = $this->GetSaleItem($value['OrderID']);
	 			
	 		//echo"<pre>";print_r($arrySaleItem);die;
	 		$NumLine = sizeof($arrySaleItem);
	 		if($NumLine>0){

	 			//echo"<pre>";print_r($value);die;
	 			$order_id = $this->GenerateInVoice($value);

	 			$this->AddRecurringInvoiceItem($order_id,$arrySaleItem);

	 			$strSQL = "update s_order set LastRecurringEntry ='" . $Config['TodayDate'] . "' where OrderID='" . $value['OrderID'] . "'";
	 			$this->myquery($strSQL, 0);


	 		}
	 			
	 			

	 	}




	 }



	 return true;
	}

	function AddRecurringInvoiceItem($order_id, $arryDetails) {
		global $Config;
		extract($arryDetails);

		$discountAmnt = 0;
		$taxAmnt = 0;
		$totalTaxAmnt = 0;

		foreach($arryDetails as $values){
			if(!empty($values['sku'])) {
				$id = $values['ref_id'];

				$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable,req_item,DropshipCheck,DropshipCost,`Condition`,WID) values('" . $order_id . "', '" . $values['item_id' ] . "', '" .$id . "', '" . addslashes($values['sku' ]) . "', '" . addslashes($values['description' ]) . "', '" . addslashes($values['on_hand_qty' ]) . "', '" . addslashes($values['qty' ]) . "', '" . addslashes($values['qty_received' ]) . "', '" . addslashes($values['qty_invoiced' ]) . "', '" . addslashes($values['price' ]) . "', '" . addslashes($values['tax_id' ]) . "', '" . addslashes($values['tax' ]) . "', '" . addslashes($values['amount' ]) . "', '" . addslashes($values['discount' ]) . "', '" . addslashes($values['Taxable' ]) . "' , '" . addslashes($values['req_item' ]) . "','" . addslashes($values['DropshipCheck' ]) . "','" . addslashes($values['DropshipCost' ]) . "','" . addslashes($values['Condition' ]) . "','".$values['WID']."')";

				$this->myquery($sql, 0);

				$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '" .$id . "' and item_id = '" . $values['item_id'] . "'";
				$arrRow = $this->myquery($sqlSelect, 1);

				$qtyreceived = $arrRow[0]['qty_received'];
				$qtyreceived = $qtyreceived + $values['qty_invoiced' ];

				$qtyinvoiced = $arrRow[0]['qty_invoiced'];
				$qtyinvoiced = $qtyinvoiced + $values['qty_invoiced'];

				$sqlupdate = "update s_order_item set qty_received = '" . $qtyreceived . "',qty_invoiced = '" . $qtyinvoiced . "' where id = '" . $id . "' and item_id = '" . $values['item_id'] . "'";
				$this->myquery($sqlupdate, 0);
			}
		}


		/*$strSQL = "update s_order set discountAmnt ='" . $discountAmnt . "' where OrderID='" . $order_id . "'";
		 $this->myquery($strSQL, 0);*/



		return true;
	}



	function RecurringOrder($Module){
		global $Config;

		// $Config['TodayDate'] = '2015-02-19 12:08:09';

		$Config['CronEntry']=1;
		$arryDate = explode(" ", $Config['TodayDate']);
		$arryDay = explode("-", $arryDate[0]);

		$Month = (int)$arryDay[1];
		$Day = $arryDay[2];

		$Din = date("l",strtotime($arryDate[0]));


		#$strSQLQuery = "select o.* from s_order o where o.Module='".$Module."' and o.Status not in('Completed', 'Cancelled', 'Rejected') and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' and o.EntryDate='".$arryDay[2]."' and CASE WHEN o.EntryInterval='yearly' THEN o.EntryMonth='".$Month."'  ELSE 1 END = 1 ";

		$strSQLQuery = "select o.* from s_order o where o.Module='".$Module."' and o.Status not in('Cancelled', 'Rejected') and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' ";
		$arrySale = $this->myquery($strSQLQuery, 1);

		foreach($arrySale as $value){
			$OrderFlag=0;
			switch($value['EntryInterval']){
				case 'biweekly':
					$NumDay = 0;
					if($value['LastRecurringEntry']>0){
						$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);
					}

					if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
						$OrderFlag=1;
					}
					break;
				case 'semi_monthly':
					if($Day=="01" || $Day=="15"){
						$OrderFlag=1;
					}
					break;
				case 'monthly':
					if($value['EntryDate']==$Day){
						$OrderFlag=1;
					}
					break;
				case 'yearly':
					if($value['EntryDate']==$Day && $value['EntryMonth']==$Month){
						$OrderFlag=1;
					}
					break;

			}


			if($OrderFlag==1){
				//echo $value['OrderID'].'<br>';

				$NumLine = 0;
				$arrySaleItem = $this->GetSaleItem($value['OrderID']);
				$NumLine = sizeof($arrySaleItem);
				if($NumLine>0){
					$order_id = $this->AddSale($value);
					$this->AddRecurringOrderItem($order_id,$arrySaleItem);

					$strSQL = "update s_order set LastRecurringEntry ='" . $Config['TodayDate'] . "' where OrderID='" . $value['OrderID'] . "'";
					$this->myquery($strSQL, 0);

				}


			}


		}

		return true;
	}


	function AddRecurringOrderItem($order_id, $arryDetails){
		global $Config;
		extract($arryDetails);

		$discountAmnt = 0;$taxAmnt=0; $totalTaxAmnt=0;
		foreach($arryDetails as $values){

			if(!empty($values['sku'])) {


				$sql = "insert into s_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, discount, Taxable, req_item,DropshipCheck,DropshipCost,SerialNumbers,`Condition`,WID) values('".$order_id."', '".$values['item_id']."', '".addslashes($values['sku'])."', '".addslashes($values['description'])."', '".addslashes($values['on_hand_qty'])."', '".addslashes($values['qty'])."', '".addslashes($values['price'])."', '".addslashes($values['tax_id'])."', '".addslashes($values['tax'])."', '".addslashes($values['amount'])."','".addslashes($values['discount'])."' ,'".addslashes($values['Taxable'])."' ,'".addslashes($values['req_item'])."','".addslashes($values['DropshipCheck'])."','".addslashes($values['DropshipCost'])."','".addslashes($values['SerialNumbers'])."','".addslashes($values['Condition'])."','".$values['WID']."')";

				$this->query($sql, 0);

			}
		}

		/*
		 $strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'";
		 $this->query($strSQL, 0);*/

		return true;

	}



	function RemoveSaleRecurring($OrderID){
		$EntryType = 'one_time';
		$strSQL = "update s_order set EntryType ='".$EntryType."' where OrderID='".$OrderID."'";

		$this->query($strSQL, 0);

		return true;

	}

	function UpdateSaleRecurring($arryDetails){
		extract($arryDetails);
		$strSQL = "update s_order set EntryType='".$EntryType."',  EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."' where OrderID='".$OrderID."'";
		$this->query($strSQL, 0);

		return true;

	}


	function  ListRecurringOrder($arryDetails)
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

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");

		$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
		$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
		$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
		$strAddQuery .= (!empty($FromDateInv))?(" and o.InvoiceDate>='".$FromDateInv."'"):("");
		$strAddQuery .= (!empty($ToDateInv))?(" and o.InvoiceDate<='".$ToDateInv."'"):("");

		if($SearchKey==strtolower(ST_CLR_CREDIT)){
			$SearchKey = 'Completed';
		}else if($SearchKey==strtolower(ST_TAX_APP_HOLD)){
			$SearchKey = 'Open';
			$strAddQuery .= " and o.tax_auths='Yes'";
		}else if($SearchKey==strtolower(ST_CREDIT_HOLD)){
			$SearchKey = 'Open';
			$strAddQuery .= " and o.tax_auths='No'";
		}

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

		$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");
		$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			
		if($ToApprove=='1'){
			$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
		}
			
		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

		$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.ReturnID = '' and o.Status != 'Cancelled'"):(" ");
		$strAddQuery .= (!empty($InvoiceID))?(" group by SaleID"):(" ");
			
		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.CustomerName asc,  o.".$moduledd."Date desc,o.".$moduledd."Date desc, o.OrderID desc ");
		//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
		//$strAddQuery .= (!empty($asc))?($asc):(" desc");
		$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");
			


		$strSQLQuery = "select o.* from s_order o " . $strAddQuery;
			
		// echo $strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}


	function  ListRecurringInvoice($arryDetails)
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

		if($_SESSION['vAllRecord']!=1){
			$strAddQuery .= " and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') ";
		}
		$strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
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
		$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");

		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.CustomerName asc, o.OrderID ");
		$strAddQuery .= (!empty($asc))?($asc):(" desc");



		$strSQLQuery = "select o.*  from s_order o ".$strAddQuery;

		//echo "=>".$strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}


	/*****************Recurring Function End**********************************/



	function GetPOStatus($PurchaseID){


		$strSQLQuery = "select o.Status from p_order o where o.Module='Order' and o.InvoiceID = '' and o.ReturnID = '' and o.PurchaseID = '".$PurchaseID."'";
		$arryPurchase = $this->query($strSQLQuery, 1);
		return $arryPurchase[0]['Status'];
	}

	function ConvertToStandardOrder($OrderID)
	{
			
		$sql="UPDATE s_order SET OrderType ='Standard' WHERE OrderID='".$OrderID."'";
		$this->query($sql,0);
		return true;
	}




	/*madhurendra*/

	/*RMA */

	function  ListSalesRma($arryDetails)
	{
			
		global $Config;
		extract($arryDetails);

			
		$strAddQuery = "where o.Module='RMA' AND InvoiceID !=''";
			
		$SearchKey   = strtolower(trim($key));

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");

		$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");
		$strAddQuery .= (!empty($FromDateRtn))?(" and o.ReturnDate>='".$FromDateRtn."'"):("");
		$strAddQuery .= (!empty($ToDateInvRtn))?(" and o.ReturnDate<='".$ToDateInvRtn."'"):("");

		if($SearchKey=='yes' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
			$strAddQuery .= " and o.ReturnPaid='Yes'";
		}else if($SearchKey=='no' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
			$strAddQuery .= " and o.ReturnPaid!='Yes'";
		}else if($sortby != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (o.ReturnID like '%".$SearchKey."%'  or o.InvoiceID like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' ) " ):("");
		}
		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
		$strAddQuery .= (!empty($asc))?($asc):(" desc");


		if($Config['GetNumRecords']==1){
			$Columns = " count(o.OrderID) as NumCount ";				
		}else{				
			$Columns = "  o.OrderDate,o.Module,o.MailSend, o.ReturnDate, o.OrderID,o.ReturnID,o.InvoiceID, o.SaleID, o.CustomerName,o.CustCode, o.TotalAmount,o.RowColor, o.CustomerCurrency,o.ReturnPaid,o.SalesPerson,o.SalesPersonType,o.SalesPersonID, o.Status, o.ExpiryDate ,o.AdminType, o.AdminID,o.PdfFile, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}			
		}

		$strSQLQuery = "select ".$Columns." from s_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee')  ".$strAddQuery;
		
		return $this->query($strSQLQuery, 1);

	}




	

	function  GetRma($OrderID,$ReturnID,$Module)
	{
		$strAddQuery='';
		$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
		$strAddQuery .= (!empty($ReturnID))?(" and o.ReturnID='".$ReturnID."'"):("");
		$strAddQuery .= (!empty($Module))?(" and o.Module IN ('Return','Credit')"):("");
		$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
		return $this->query($strSQLQuery, 1);
	}

	/* credit */


	function  ListRmaCredit($arryDetails)
	{
			
		global $Config;
		extract($arryDetails);

		$strAddQuery = "where o.Module='Credit'";
		$SearchKey   = strtolower(trim($key));

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");

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

		$strSQLQuery = "select o.OrderDate,o.Module, o.ReturnDate, o.OrderID, o.SaleID,o.ReturnID,o.InvoiceID, o.CustCode, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.ReturnPaid,o.SalesPerson  from s_order o ".$strAddQuery;
		#$strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);

	}
function GetItemAliasSku($Sku) {
                $strSQLQuery = "select c.valuationType as evaluationType, ia.ItemAliasCode,ia.AliasID,ia.sku,ia.description,i.ItemID from inv_item_alias ia left join inv_items i on ia.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID where LOWER(ia.ItemAliasCode) = '" . strtolower($Sku) . "'";
return $this->query($strSQLQuery, 1);
}
function GetItemAlia($alasSku) {
                $strSQLQuery = "select c.valuationType as evaluationType, ia.ItemAliasCode,ia.AliasID,ia.sku,ia.description,i.ItemID from inv_item_alias ia left join inv_items i on ia.item_id = i.ItemID left outer join inv_categories c on c.CategoryID =i.CategoryID where LOWER(ia.sku) = '" . strtolower($alasSku) . "'";

        return $this->query($strSQLQuery, 1);
    }

 function IdentifieItemSku($Sku) {
	
    	
       $strSQLQuery = "select p1.*,cat.valuationType as evaluationType from inv_items  p1 left join inv_categories cat on cat.CategoryID=p1.CategoryID ".$custJoin." where p1.Sku = '" . $Sku . "' ";
		
       
     
        return $this->query($strSQLQuery, 1);
    }

	function ListInvoiceByCustomer($arryDetails){
			
		global $Config;
		extract($arryDetails);
			
		$strAddQuery = " where o.Module='Invoice' and o.InvoiceEntry in ('0','1') ";
		$SearchKey   = strtolower(trim($key));
 if($sortby == 'vo.sku'){
			
				$checkProduct=$this->IdentifieItemSku($SearchKey);

						//By Chetan 9sep// 
						if(empty($checkProduct))
						{
						$arryAlias = $this->GetItemAliasSku($SearchKey);
							if(count($arryAlias)){
									$mainaliasSku = $SearchKey;
                  $mainSku =$arryAlias[0]['sku'];
							}
						}else{
            $arryAlias = $this->GetItemAlia($SearchKey);
             if(count($arryAlias)){
									$mainaliasSku = $arryAlias[0]['ItemAliasCode'];
                  //$mainSku =$SearchKey;
							}
						$mainSku = $SearchKey;
						}

				$strAddQuery .= (!empty($SearchKey))?(" and (vo.sku like '%".$mainSku."%' or vo.sku like '%".$mainaliasSku."%')"):("");
      }else if($sortby != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'   or o.CustomerName like '%".$SearchKey."%'   or o.SalesPerson like '%".$SearchKey."%' or vo.sku like '%".$SearchKey."%' ) " ):("");
		}
		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");


		

		if($Config['GetNumRecords']==1){
			$Columns = " count(distinct(o.OrderID)) as NumCount ";				
		}else{	
			$strAddQuery .= " group by o.OrderID ";	
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$Columns = " o.OrderDate, o.ReturnDate, o.OrderID, o.ReturnID,o.InvoiceID, o.CustCode, o.CustomerName,o.TotalInvoiceAmount,o.CustomerCurrency,o.Status,o.InvoiceDate, o.CustomerCurrency,o.SalesPerson,o.InvoicePaid ";
			if($Config['RecordsPerPage']>0){
				$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			} 
						
		}

		$strSQLQuery = "select ".$Columns." from s_order o left join s_order_item vo ON o.OrderID = vo.OrderID ".$strAddQuery;
		
		//echo $strSQLQuery.'<br><br>';
		
		return $this->query($strSQLQuery, 1);
			

	}

	/*************End Reseller Default Invoice & Payment Entry ***************/


	/* finance */


	function  ListCustCredit($arryDetails)
	{
		global $Config;
		extract($arryDetails);

		$strAddQuery = "where o.Module='Credit' AND InvoiceID !=''";
		$SearchKey   = strtolower(trim($key));

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");

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
			$strAddQuery .= (!empty($SearchKey))?(" and (o.ReturnID like '%".$SearchKey."%'  or o.InvoiceID like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' ) " ):("");
		}
		//$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

		$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
		$strAddQuery .= (!empty($asc))?($asc):(" desc");

		$strSQLQuery = "select o.OrderDate,o.Module, o.ReturnDate,o.CustCode, o.OrderID,o.ReturnID,o.InvoiceID, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.ReturnPaid,o.SalesPerson  from s_order o ".$strAddQuery;
		$strSQLQuery;
		return $this->query($strSQLQuery, 1);

	}

	function ListInvoiceByCustomerCredit($arryDetails){

		global $Config;
		extract($arryDetails);
			
		$strAddQuery = " where 1";
		$SearchKey   = strtolower(trim($key));
			

		#$strAddQuery .= (!empty($SearchKey))?(" and ( o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");
			
		$strAddQuery .= (!empty($SearchKey))?(" and ( o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.SalesPerson like '%".$SearchKey."%' or o.TotalInvoiceAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' ) " ):("");

		$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");
			
		$strSQLQuery = "select o.*  from s_order o " . $strAddQuery;
			
		#echo $strSQLQuery;
		#exit;
		return $this->query($strSQLQuery, 1);
	}

	function UpdateCustCredit($arryDetails){
		global $Config;
		extract($arryDetails);

		$strSQLQuery = "update s_order set ReturnPaid='".$ReturnPaid."', ReturnComment='".addslashes($ReturnComment)."', Module='".$Module."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID=".$OrderID.""; 
		#echo $strSQLQuery;exit;
		$this->query($strSQLQuery, 0);

		return 1;
	}






	/* warehouse */

	function  warehouseRmaList($arryDetails)
	{
			
		global $Config;
		extract($arryDetails);

		$strAddQuery = "where o.Module='RMA' ";
		$SearchKey   = strtolower(trim($key));

		$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):("");

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



	function listRmaAction(){
		$strSQLQuery = "SELECT * FROM w_rma_action_value";
		$results=$this->query($strSQLQuery,1);
		return $results;
	}



	
 function listRmaReason(){
	 $strSQLQuery = "SELECT * FROM w_attribute_value WHERE attribute_id='7'";
	 $results=$this->query($strSQLQuery,1);
	return $results;
}
	

	
/*
	function listRmaReason(){
		$strSQLQuery = "SELECT * FROM w_status_attribute ";
		$results=$this->query($strSQLQuery,1);
		return $results;
	}
*/

               function getCustomersList()
                {
	   
                 $SqlCustomer = "select o.CustCode,IF(c.CustomerType = 'Company' and c.Company!='', c.Company, c.FullName) as CustomerName from s_order o inner join s_customers c on o.CustCode =c.CustCode where o.Module='Invoice' and o.CustCode!='' group by o.CustCode order by CustomerName ASC ";

                    return $this->query($SqlCustomer, 1);
                }

               
                
                
		function RmaTypeValue($type){
			$typeVal='';
			switch($type){
				case 'AC': $typeVal = 'Advance Credit'; break;
				case 'AR': $typeVal = 'Advance Replacement'; break;
				case 'C': $typeVal = 'Credit'; break;
				case 'R': $typeVal = 'Replacement'; break;
				
			}
			
			return $typeVal;


		}
/**************************Create Rma Form***************************/

function ListCreateRMA($arrayDetails) {
        global $Config;
        extract($arrayDetails);
        $strAddQuery = " where 1 ";
        $SearchKey = strtolower(trim($key));
        $SortBy = $sortby;

         if ($SortBy != '') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
        } 


        /*$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",t.AssignedTo) OR t.created_id='" . $_SESSION['AdminID'] . "') ") : ("");*/

       


        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by formID ");
        $strAddQuery .= (!empty($asc)) ? ($asc) : (" Desc");

        $strSQLQuery = "select * from s_rma_form  " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

 function GetRmaWebForm($formID) {
        global $Config;
        $strSQLQuery = "select * from s_rma_form where formID='".$formID."' ";
        return $this->query($strSQLQuery, 1);
    }    
 function UpdateRmaWebForm($arryDetails, $HtmlForm){   
                global $Config;
                extract($arryDetails);	
                #$formID=1;
                $sql = "select formID from c_lead_form where formID='".$formID."' ";
                $arryRow = $this->query($sql, 1);
               
                if($arryRow[0]['formID']>0){
                        $strSQLQuery = "update s_rma_form set FormTitle='".mysql_real_escape_string(strip_tags($FormTitle))."', Subtitle='".mysql_real_escape_string(strip_tags($Subtitle))."', Description='".mysql_real_escape_string(strip_tags($Description))."', AssignTo='".mysql_real_escape_string(strip_tags($AssignTo))."', ExtraInfo='".mysql_real_escape_string(strip_tags($ExtraInfo))."', Campaign='".mysql_real_escape_string(strip_tags($Campaign))."', ActionUrl='".mysql_real_escape_string(strip_tags($ActionUrl))."', HtmlForm='".addslashes($HtmlForm)."', LeadColumn='".addslashes($LeadColumn)."', UpdatedDate='".$Config['TodayDate']."' where formID='".mysql_real_escape_string($formID)."'" ;
$this->query($strSQLQuery, 0);	
                }else{
                        $strSQLQuery = "insert into s_rma_form (FormTitle, Subtitle, Description, AssignTo, ExtraInfo, Campaign, ActionUrl, HtmlForm, UpdatedDate,LeadColumn ) values('".mysql_real_escape_string($FormTitle)."', '".mysql_real_escape_string(strip_tags($Subtitle))."', '".mysql_real_escape_string(strip_tags($Description))."','".mysql_real_escape_string(strip_tags($AssignTo))."', '".mysql_real_escape_string(strip_tags($ExtraInfo))."', '".mysql_real_escape_string(strip_tags($Campaign))."', '".mysql_real_escape_string($ActionUrl)."', '".addslashes($HtmlForm)."', '".$Config['TodayDate']."', '".addslashes($LeadColumn)."')";
$this->query($strSQLQuery, 0);	

 $lastID = $this->lastInsertId();
return $lastID;	
                }     

               // return 1;

     }
function RemoveRmaForm($formID) {

         $strSQLQuery = "delete from s_rma_form where formID='" . $formID . "'";

        $this->query($strSQLQuery, 0);
        return 1;
    }


function ReturnOrderByForm($arryDetails){
		global $Config;
		extract($arryDetails);
		$arrySale = $this->GetSale($ReturnOrderID,'','');
		$arrySale[0]["Module"] = "RMA";
		$arrySale[0]["ModuleID"] = "ReturnID";
		$arrySale[0]["PrefixSale"] = "RTN";
		$arrySale[0]["ReturnID"] = $ReturnID;
		$arrySale[0]["ReturnDate"] = $Config['TodayDate'];
		$arrySale[0]["Freight"] = $Freight;
		//$arrySale[0]["taxAmnt"] = $taxAmnt;
		$arrySale[0]["TotalAmount"] = $TotalAmount;
		$arrySale[0]["ReturnPaid"] = $ReturnPaid;
		$arrySale[0]["ReturnComment"] = $ReturnComment;
		$arrySale[0]["ExpiryDate"] = $ExpiryDate;
		$arrySale[0]["ReSt"] = $ReSt;
		$arrySale[0]["ReStocking"] = $ReStocking; 
		$arrySale[0]["Status"] = 'Parked'; 	
			
		$order_id = $this->AddReturnOrder($arrySale[0]);

		$strSQL = "select ReturnID from s_order where OrderID = '".$order_id."' ";
		$arryReturnID = $this->query($strSQL, 1);
		$arrySale[0]["ReturnID"] = $arryReturnID[0]['ReturnID'];


		/******** Item Updation for Return ************/
		$arryItem = $this->GetSaleItem($ReturnOrderID);

		$NumLine = sizeof($arryItem);
		for($i=1;$i<=$NumLine;$i++){

			$Count=$i-1;
			$id = $arryItem[$Count]["id"];
			//if(!empty($id) && $arryDetails['qty'.$i]>0){

if(!empty($id) ){
				$qty_returned = $arryDetails['qty'.$i];
				$SerialNumbers = $arryDetails['serial_value'.$i];

				$Type = $arryDetails['Type'.$i];
				$Action = $arryDetails['Action'.$i];
				$Reason = $arryDetails['Reason'.$i];
					

				$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, discount, Taxable, req_item,SerialNumbers,`Condition`,Type,Action,Reason,parent_item_id,WID,avgCost) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryItem[$Count]["id"]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$qty_returned."', '0','0','0', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryDetails['discount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$arryDetails['serial_value'.$i]."','".$arryDetails['Condition'.$i]."','".$Type."','".$Action."','".$Reason."','".$arryDetails['parent_ItemID'.$i]."','".$arryDetails['WID'.$i]."','".$arryDetails['avgcost'.$i]."')";
				$this->query($sql, 0);

if($arryItem[$Count]["sku"] == $arryDetails['SKU']){


$amount = $arryItem[$Count]["price"]*$arryDetails['Qty'];

$TotAmt = $amount;

$sqlUpdate = "Update s_order_item set qty_returned =".$arryDetails['Qty'].",amount ='".$amount ."' where  sku ='".$arryDetails['SKU']."' and OrderID ='".$order_id."'";
$this->query($sqlUpdate, 0);
}
}				
}
		return $order_id;
	}
	
	/*************  By Ravi For get items serials by orderID and SKU*********/
	
	function GetOrderItembyOrderIDAndSKU($orderid,$sku,$condition=''){
	
		if(empty($orderid) || empty($sku)){		
		return false;
		}
		$where=' 1=1 ';
		
		if(!is_array($orderid)){
			$where .=" AND OrderID = '".$orderid."' AND sku='".$sku."'";
		}else{
		$where .=" AND OrderID IN(".implode(',',$orderid).") AND sku='".$sku."'";
		
		}
		if(!empty($condition)){
		$where .=" AND `Condition`='".$condition."'";
		
		}
		$strSQL = "select * from s_order_item where $where";
		$arryItems = $this->query($strSQL, 1);
		return  $arryItems;
	
	}
	
	/********** BY Ravi 26-01-17************/
	
	
	
	function getInvoiceOrderIDByRMA($orderid=0){
	
	$sql="SELECT invoiceorder.OrderID FROM `s_order` as rmorder INNER JOIN s_order as invoiceorder ON invoiceorder.InvoiceID=rmorder.InvoiceID AND invoiceorder.Module='Invoice' WHERE 1 AND rmorder.`OrderID`='".$orderid."'";
		$arryItems = $this->query($sql, 1);
		
return !empty($arryItems[0]['OrderID'])?$arryItems[0]['OrderID']:0;
	
	
	}
	
	function getOrderIDByMode($orderid=0,$mode){
			$sql="SELECT invoiceorder.OrderID FROM `s_order` as rmorder INNER JOIN s_order as invoiceorder ON invoiceorder.InvoiceID=rmorder.InvoiceID AND invoiceorder.Module='".$mode."' WHERE 1 AND rmorder.`OrderID`='".$orderid."'";
			$orders = $this->query($sql, 1);
			return $orders;
	}
	
	
	
	function SaveItemSerial($data){
	  global $Config;
	 $date=date('Y-m-d');
			$strSQLQuery = "insert into inv_serial_item (adjustment_no,warehouse,serialNumber,Sku,disassembly,`Condition`,description,type,UnitCost,ReceiptDate)  
			values ('".$data['adjustment_no']."','" . $data['WID'] . "','" . $data['serialNumber'] . "','" . addslashes($data['Sku']) . "','" . $data['disassembly'] . "','".$data['Condition']."','" . addslashes($data['description']) . "','".$data['type']."', '".addslashes($data['UnitCost'])."','".$date."')";

			$this->query($strSQLQuery, 0);
	
	}
	
	function getSerialDetails544545($sku,$condition,$allserials){
	$where=' Where 1=1 ';
	$where1='';
	if(!empty($allserials)){
	$i=0;
		foreach($allserials as $serial){
		if($i!=0){
		$where1 .=' || ';
		}
			$where1 .="( serialNumber='".$serial."' AND Sku='".$sku."' AND `Condition`='".$condition."')";
			$i++;
		
		}
	
	}else{
   $where1 .=" Sku='".$sku."' AND `Condition`='".$condition."'";

}
	$where .=' AND ('.$where1.')';
	 $strSQL="Select * from inv_serial_item $where";
	 	$arryserial = $this->query($strSQL, 1);
		return  $arryserial;
	
	}
function getSerialDetails($sku,$condition,$allserials,$OrderID=0){



	$allserials = "'".implode ( "', '", $allserials )."'";
	$where =' Where 1 ';

	/*if(!empty($allserials)){
		$where .=" and  (serialNumber IN (".$allserials.")  ";
	}*/
if($OrderID>0){
		$where .=" and  OrderID='".$OrderID."' and SelectType='SaleOrder'  ";
	}
	$where .= " and Sku='".$sku."' AND `Condition`='".$condition."' ";

	$strSQL="SELECT `serialNumber`,`Sku`,`UsedSerial`,`Condition`,`UnitCost`,LineID from inv_serial_item  ".$where." ";


	$arryserial = $this->query($strSQL, 1);
	return  $arryserial;
	 
	
	}
	
function updateRMASerialQTY($post){	
	$responce=array();

global $Config;



	for($i=1;$i<=$post['NumLine'];$i++){
		//$allselectedserial = explode(',',$post['serial_value'.$i]);
		$allserials = explode(',',$post['serial_value'.$i]);
		if($post['serial_value'.$i]!=''){
		foreach($allserials as $serial){
				if(1!=1){
					$responce['errors']['items'][$post['sku'.$i]][]=$serial;
				}else{

$SqlSerial = "Select * from inv_serial_item where serialNumber='".$serial."' AND Sku='".$post['mainSku'.$i]."' AND `Condition`='".$post['Condition'.$i]."' and warehouse='".$post['WID'.$i]."' ";
$arrSerial = $this->query($SqlSerial, 1);	
if($arrSerial[0]['serialNumber']==''){
$serialInsert = "insert into inv_serial_item (serialNumber,Sku,`Condition`,warehouse,Status,UsedSerial,CustRma,UnitCost,ReceiptDate)  
							values ('" . addslashes($arrSerial[0]['serialNumber']) . "','" . addslashes($arrSerial[0]['Sku']) . "','" . addslashes($arrSerial[0]['Condition']) . "','".addslashes($arrSerial[0]['warehouse'])."','1',0,'".addslashes($post['rcptID'])."','".addslashes($arrSerial[0]['UnitCost'])."','".$Config['TodayDate']."')";
							$this->query($serialInsert, 0);
}else{


					 $sqlUpdate="Update inv_serial_item set UsedSerial=0,CustRma='".addslashes($post['rcptID'])."',LineID=0,OrderID=0 Where serialNumber='".addslashes($serial)."' AND Sku='".$post['mainSku'.$i]."' AND `Condition`='".$post['Condition'.$i]."' and warehouse='".$post['WID'.$i]."'";

					$this->query($sqlUpdate, 0);
}


$SqlChk = "select count(*) as total from inv_item_quanity_condition WHERE Sku='".$post['mainSku'.$i]."' AND `condition`='".$post['Condition'.$i]."' and WID='".$post['WID'.$i]."' ";		
$arrqty = $this->query($SqlChk, 1);		

if($arrqty[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,WID)  
							values ('" . addslashes($post['item_id'.$i]) . "',
							'" . addslashes($post['Condition'.$i]) . "',
							'" . addslashes($post['mainSku'.$i]) . "','Rma Receipt',
							'1','" . $post['WID'.$i] . "')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
							 $sqlUpdate="Update inv_item_quanity_condition SET condition_qty=condition_qty+1 WHERE Sku='".$post['mainSku'.$i]."' AND `condition`='".$post['Condition'.$i]."' and WID='".$post['WID'.$i]."' ";
					 $this->query($sqlUpdate, 0);
							
						}
	 
					
				}
		}
}else{


$SqlChk = "select count(*) as total from inv_item_quanity_condition WHERE Sku='".$post['mainSku'.$i]."' AND `condition`='".$post['Condition'.$i]."' and WID='".$post['WID'.$i]."' ";		
$arrqty = $this->query($SqlChk, 1);		

if($arrqty[0]['total']==0){
							//If not find insert in tbl
							$strSQLQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,WID)  
							values ('" . addslashes($post['item_id'.$i]) . "',
							'" . addslashes($post['Condition'.$i]) . "',
							'" . addslashes($post['mainSku'.$i]) . "','Rma Receipt',
							'1','" . $post['WID'.$i] . "')";
							$this->query($strSQLQuery, 0);
						}else{
							// update in tbl
							 $sqlUpdate="Update inv_item_quanity_condition SET condition_qty=condition_qty+'".$post['qty'.$i]."' WHERE Sku='".$post['mainSku'.$i]."' AND `condition`='".$post['Condition'.$i]."' and WID='".$post['WID'.$i]."' ";
					 $this->query($sqlUpdate, 0);
							
						}



}
		
		
	
	}
		return $responce;
	
	}
	/***********************END ************************/
function setRowColorSale($OrderID,$RowColor) {
        //if (!empty($OrderID)) {
            $sql = "update s_order set RowColor='".$RowColor."' where OrderID in ( $OrderID)"; 
             $this->query($sql, 0);
        //}

       return true;
    }


/*************************************************
*       AMAZON RMA START
*************************************************/

	public function isAmazonRmaExist($CustomerPO, $amazonRMAID){
		$strSQLQuery = "select OrderID from s_order where Module='RMA' and reference_id='".$amazonRMAID."' and CustomerPO='".$CustomerPO."' ";
		$arryRow = $this->query($strSQLQuery, 1);

		if (!empty($arryRow[0]['OrderID'])) {
			return true;
		} else {
			return false;
		}
	}

	public function  GetAmazonSaleItem($OrderID,$sku)
	{
		$strAddQuery .= (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
		$strAddQuery .= (!empty($sku))?(" and i.sku='".$sku."'"):("");
		$strSQLQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType,itm.ItemID,itm.CategoryID,w.warehouse_code,w.warehouse_name from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID left outer join inv_categories c on c.CategoryID =itm.CategoryID left outer join w_warehouse w on i.WID=w.WID where 1".$strAddQuery." order by i.id asc";
		return $this->query($strSQLQuery, 1);
	}

	public function amazonRMA($arryDetails,$ApiType){
		global $Config;
		extract($arryDetails);
		$arrySale = $arryItem = array();
		$ReturnOrderID = $TotalAmount = $arryReturnID = 0;

		$isExist = $this->isAmazonRmaExist($Order_ID,$Amazon_RMA_ID);
		if($isExist) return;

		$sql = "select * from s_order where CustomerPO='".$Order_ID."' and module='Invoice' " ;
		$invData = $this->query($sql, 1);
		$ReturnOrderID = $invData[0]['OrderID'];

		$arrySale = $this->GetSale($ReturnOrderID,'','');
		
		$Label_cost = 0; // need confirmation 
		$arryItem = $this->GetAmazonSaleItem($ReturnOrderID,$Merchant_SKU);
		$TotalAmount = ( ($Return_quantity*$arryItem[0]["price"]) + ($Label_cost) );

		if(!empty($ReturnOrderID) && !empty($arryItem)){
			$arrySale[0]['reference_id'] = $Amazon_RMA_ID;
			$arrySale[0]["OrderSource"] = $ApiType; 
			$arrySale[0]["CustomerPO"] = $Order_ID; 
			$arrySale[0]["Module"] = "RMA";
			$arrySale[0]["ModuleID"] = "ReturnID";
			$arrySale[0]["PrefixSale"] = "RTN";
			$arrySale[0]["ReturnID"] = $ReturnID;
			$arrySale[0]["ReturnDate"] = date("Y-m-d",strtotime($Return_request_date));
			$arrySale[0]["Freight"] = $Label_cost;
			//$arrySale[0]["taxAmnt"] = $taxAmnt;
			$arrySale[0]["TotalAmount"] = $TotalAmount;
			$arrySale[0]["ReturnPaid"] = $ReturnPaid;
			$arrySale[0]["ReturnComment"] = $Return_reason;
			$arrySale[0]["ExpiryDate"] = date("Y-m-d",strtotime($Return_delivery_date));
			$arrySale[0]["ReSt"] = 0;
			$arrySale[0]["ReStocking"] = 0; // restocking fees 
			$arrySale[0]["Status"] = "Completed"; 
			$arrySale[0]["chooseItem"] = $Return_carrier;
			//$arrySale[0]["TDiscount"] = $TDiscount; 
			$arrySale[0]["EntryBy"] = 'C'; 
			$arrySale[0]["ReturnOrderID"] = $ReturnOrderID; 
	   		//$arrySale[0]["taxAmntR"] = $taxAmnt;
	//pr($arrySale[0],1);
			$order_id = $this->AddReturnOrder($arrySale[0]);

			$strSQL = "select ReturnID from s_order where OrderID = '".$order_id."' ";
			$arryReturnID = $this->query($strSQL, 1);
			$arrySale[0]["ReturnID"] = $arryReturnID[0]['ReturnID'];

			/******** Item Updation for Return ************/

			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){

				$Count=$i-1;
				if($Return_quantity>0){
					$qty_returned = $Return_quantity;
					$amount  = $Return_quantity*$arryItem[$Count]['price'];
					$Type = 'C';
					$Action = 'Return';
					$Reason = $Return_reason;
					
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, discount, Taxable, req_item,SerialNumbers,`Condition`,Type,Action,Reason,WID,DropshipCheck,DropshipCost) 
							values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryItem[$Count]['id']."', '".addslashes($arryItem[$Count]["sku"])."', '".addslashes($arryItem[$Count]["description"])."', '".$arryItem[$Count]["on_hand_qty"]."', '".$qty_returned."', '0','".$arryItem[$Count]["qty_invoiced"]."','0',
							 '".$arryItem[$Count]['price']."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$amount."', '0', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$arryItem[$Count]['serial_value']."',
							'".addslashes($arryItem[$Count]['Condition'])."','".$Type."','".$Action."','".$Reason."','".$arryItem[$Count]['WID']."','".$arryItem[$Count]['DropshipCheck']."','".addslashes($arryItem[$Count]['DropshipCost'])."')";
					$this->query($sql, 0);
				}
			}
			/******** END OF ITEM Updation for Return ************/
		
			# To update credit or advance credit		
			$this->AddCreditSalesFromRMA($order_id);
		}
		return $order_id;
	}
/*************************************************
*      END OF AMAZON RMA
*************************************************/

function AddRMAOrderItem($arryDetails,$Db=''){

global $Config;
		extract($arryDetails);
#echo $ReturnOrdID; exit;
if($ReturnOrdID>0){
	/******** Item Updation for Return ************/
		$arryItem = $this->GetSaleItem($ReturnOrdID,$Db);

		$NumL = count($arryItem);

/*echo "<pre>";
print_r($arryItem);
echo "<br>   Post value";
echo "<pre>";
print_r($arryDetails);*/

$sql = 'insert into '.$Db.'s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, discount, Taxable, req_item,SerialNumbers,`Condition`,Type,Action,Reason,WID,DropshipCheck,DropshipCost) values ';
    $query_parts = array();
   

	for($i=1;$i<=$NumL;$i++){
			$Count=$i-1;
			$id = $arryDetails['id'.$i];
			//if(!empty($id) && $arryDetails['qty'.$i]>0){
							$qty_returned = $arryDetails['qty'.$i];
							$SerialNumbers = $arryDetails['serial_value'.$i];
							$Type = $arryDetails['Type'.$i];
							$Action = $arryDetails['Action'.$i];
							$Reason = $arryDetails['Reason'.$i];

 $query_parts[] = "('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryItem[$Count]["id"]."', '".addslashes($arryItem[$Count]["sku"])."', '".addslashes($arryItem[$Count]["description"])."', '".$arryItem[$Count]["on_hand_qty"]."', '".$qty_returned."', '0','".$arryItem[$Count]["qty_invoiced"]."','0', '".$arryDetails['price'.$i]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryDetails['discount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$arryItem[$Count]['SerialNumbers']."','".addslashes($arryDetails['condition'.$i])."','".$Type."','".$Action."','".$Reason."','".$arryDetails['WID'.$i]."','".$arryDetails['DropshipCheck'.$i]."','".addslashes($arryDetails['DropshipCost'.$i])."')"; 


//$this->query($sql, 0);


}

/*echo $sql;
print_r($query_parts);
exit;*/
$sql .= implode(',', $query_parts);
 $this->query($sql, 0);


}

}

function AddReturnMAOrder($arryDetails,$Db=''){
		global $Config;
		extract($arryDetails);
#echo$ReturnOrderID
#echo $Db;
		$arrySale = $this->GetSale($ReturnOrderID,'','',$Db);

		$arrySale[0]["Module"] = "RMA";
		$arrySale[0]["ModuleID"] = "ReturnID";
		$arrySale[0]["PrefixSale"] = "RTN";
		$arrySale[0]["ReturnID"] = $ReturnID;
		$arrySale[0]["ReturnDate"] = $ReturnDate;
		$arrySale[0]["Freight"] = $Freight;
		//$arrySale[0]["taxAmnt"] = $taxAmnt;
		$arrySale[0]["TotalAmount"] = $TotalAmount;
		$arrySale[0]["ReturnPaid"] = $ReturnPaid;
		$arrySale[0]["ReturnComment"] = $ReturnComment;
		$arrySale[0]["ExpiryDate"] = $ExpiryDate;
		$arrySale[0]["ReSt"] = $ReSt;
		$arrySale[0]["ReStocking"] = $ReStocking; 
		$arrySale[0]["Status"] = $Status; 	
		$arrySale[0]["TDiscount"] = $TDiscount; 
		$arrySale[0]["ReturnOrderID"] = $ReturnOrderID; 
    $arrySale[0]["taxAmntR"] = $taxAmnt;
    $arrySale[0]['EDIRefNo'] = $EDIRefNo;
$arrySale[0]['EdiRefInvoiceID'] = $EdiRefInvoiceID;
			
		$order_id = $this->AddReturnOrder($arrySale[0],$Db);

		$strSQL = "select ReturnID from ".$Db."s_order where OrderID = '".$order_id."' ";
		$arryReturnID = $this->query($strSQL, 1);
		$arrySale[0]["ReturnID"] = $arryReturnID[0]['ReturnID'];

return $order_id;
}

}
?>
