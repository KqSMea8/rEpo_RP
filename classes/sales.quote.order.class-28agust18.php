<?
class sale extends dbClass
{
		//constructor
		function sale()
		{
			$this->dbClass();
		} 
		
		function  ListSale($arryDetails,$CustomerID=0)
		{
			global $Config;
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "SaleID"; 
			}
			$batchCol=$join='';
			$AdminID=$_SESSION['AdminID'];
			if($AdminID=='') $AdminID=$_SESSION['UserData']['AdminID'];
           
			if($module == "Invoice"){ $moduledd = 'Invoice';}else{$moduledd = 'Order';}
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));

			if((!empty($CustomerID) && $CustomerID!='0')){
				$strAddQuery .= " and o.CustID='".mysql_real_escape_string($CustomerID)."'";
			}else{
				$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$AdminID."' or o.AdminID='".$AdminID."') "):(""); 
			}




			$strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
			$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
$strAddQuery .= (!empty($Pick))?(" and o.PickID!='' or o.OrderType='Against PO'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
			$strAddQuery .= (!empty($FromDateInv))?(" and o.InvoiceDate>='".$FromDateInv."'"):("");
			$strAddQuery .= (!empty($ToDateInv))?(" and o.InvoiceDate<='".$ToDateInv."'"):("");
			$strAddQuery .= (!empty($batchId))?(" and o.batchId<='".$batchId."'"):("");

if(!empty($Picking)){

$strAddQuery .= " and (o.PaymentTerm not in ('Credit Card','PayPal') or o.OrderPaid in ('1','3')) and o.Approved='1' ";
}

			if(!empty($fby)){ //search
				$DateColumn = "o.".$moduledd.'Date';
				if($fby=='Year'){
					$strAddQuery .= " and YEAR(".$DateColumn.")='".$y."'";
				}else if($fby=='Month'){
					$strAddQuery .= " and MONTH(".$DateColumn.")='".$m."' and YEAR(".$DateColumn.")='".$y."'";
				}else{
					$strAddQuery .= (!empty($f))?(" and ".$DateColumn.">='".$f."'"):("");
					$strAddQuery .= (!empty($t))?(" and ".$DateColumn."<='".$t."'"):("");
				}
			}	


                        /*if($SearchKey==strtolower(ST_CLR_CREDIT)){
                            $SearchKey = 'Completed';
                        }else if($SearchKey==strtolower(ST_TAX_APP_HOLD)){
                            $SearchKey = 'Open';
                            $strAddQuery .= " and o.tax_auths='Yes'";
                        }else if($SearchKey==strtolower(ST_CREDIT_HOLD)){
                            $SearchKey = 'Open';
                            $strAddQuery .= " and o.tax_auths='No'";
                        }*/

			if($SearchKey==strtolower(ST_CLR_CREDIT)){
				$SearchKey = 'Completed';
			}else if($SearchKey==strtolower(ST_CREDIT_HOLD)){
				$SearchKey = 'Open';
				//$strAddQuery .= " and ((o.PaymentTerm!='' and o.PaymentTerm not like '%-%') or o.Approved!='1')";
				$strAddQuery .= " and (o.PaymentTerm in ('Credit Card','PayPal') and o.OrderPaid!='1') or o.Approved!='1' ";
			}else if($SearchKey==strtolower(ST_CREDIT_APP)){
				$SearchKey = 'Open';
				// $strAddQuery .= " and (o.PaymentTerm='' or o.PaymentTerm like '%-%') and o.Approved='1'";
				$strAddQuery .= " and (o.PaymentTerm not in ('Credit Card','PayPal') or o.OrderPaid='1') and o.Approved='1' ";
			}else if($SearchKey=="credit card"){
				$SearchKey = 'Open';
				$strAddQuery .= " and o.PaymentTerm='Credit Card' and o.OrderPaid in ('1','3')";
			}

	if(!empty($Config['CrditStatus'])){
	     if($Config['CrditStatus']==strtolower(ST_CREDIT_APP)){
			//$SearchKey = 'Open';
			$oRTpe = 'Drop Ship';
			// $strAddQuery .= " and (o.PaymentTerm='' or o.PaymentTerm like '%-%') and o.Approved='1'";
			$strAddQuery .= " and (o.PaymentTerm not in ('Credit Card','PayPal') or o.OrderPaid in ('1','3')) and o.Approved='1' and o.OrderType !='".$oRTpe."'  and o.Approved='1'";
		}
	}
                        
			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.TrackingNo like '%".$SearchKey."%' ) " ):("");	
			}

			

			$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");
			if(!empty($Status)){
				$strAddQuery .= " and o.Status='".$Status."'";
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}


			$strAddQuery .= (!empty($Approved))?(" and o.Approved='1'"):("");
			$strAddQuery .= (!empty($PostToGL))?(" and o.PostToGL='1'"):("");

			if(!empty($ToApprove)){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}
			
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.ReturnID = '' and o.Status != 'Cancelled'"):(" ");
			/********* By Karishma for MultiStore 22 Dec 2015******/
			
			/*****End By Karishma for MultiStore 22 Dec 2015**********/
			$strAddQuery .= (!empty($InvoiceID))?(" and o.Module='Invoice' and o.SaleID!='' "):(" ");
			//$strAddQuery .=  " group by i.OrderID HAVING SUM(i.qty)!=Sum(i.qty_invoiced) ";
			if(!empty($Config['batchmgmt']) && $module ='Order' && empty($Droplist) ){
						$batchCol = ",b.status as BatchStatus";
						$join = " left outer join batchmgmt b on (o.batchId=b.batchId and o.batchId>0)  ";
						$strAddQuery .=" and o.Status!='Completed' and (o.batchId='0' or b.status!='Closed')  ";
				//$strAddQuery .=" or (b.status!='Closed' and o.batchId='0' and o.Module='Order') ";
				 
			}

if(!empty($Droplist)){

$batchCol = ",b.PostToGL ";
						$join = " left outer join s_order b on o.SaleID=b.SaleID ";
						$strAddQuery .=" and b.PostToGL='0'  ";

}
			//$s_item_order = " inner join s_order_item i on (o.OrderID=i.OrderID and i.qty!=i.qty_invoiced ) ";
			//if($Config['batchmgmt']==1 && $module ='Order' && $Droplist!=1 ){
				$strAddQuery .=  " group by o.OrderID ";      
			//}
				
						
			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{	
				
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.".$moduledd."Date desc, o.OrderID desc ");
			
				$Columns = "  o.*,i.DropShipCheck, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			#$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.SalesPersonID, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module,o.tax_auths  from s_order o ".$strAddQuery;
		//left  join s_order inv on (o.SaleID=inv.SaleID and inv.PostToGL!='1' and inv.Module='Invoice')
		         $strSQLQuery = "select ".$Columns."".$batchCol."  from s_order o  left join s_order_item i on o.OrderID=i.OrderID  left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee') ".$join."  " . $strAddQuery;
	  		if(!empty($_GET['pk']))echo $strSQLQuery;
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
		
		function GetOrderStatusMsg($OrderStatus,$Approved,$PaymentTerm,$OrderPaid){
			
			 if($OrderStatus == 'Completed') {
		                $Status = ST_CLR_CREDIT;
		                $StatusCls = 'green';
		         }else {
		                $StatusCls = 'red';

		                if($OrderStatus == 'Open') {
		                    	if($Approved != 1) {
						$Status = ST_CREDIT_HOLD; $StatusCls = 'red';
					}else{
						$Status = ST_CREDIT_APP; $StatusCls = 'green';
						if(!empty($PaymentTerm)){
							$PaymentTerm = trim(strtolower($PaymentTerm));
							//$arryTerm = explode("-",$PaymentTerm);
							
							/*if($OrderPaid==1 && $PaymentTerm=='credit card'){
								$Status = 'Credit Card';
							}else if($OrderPaid!=1 && $arryTerm[1]=='' && $PaymentTerm!='end of month'){
								$Status = ST_CREDIT_HOLD; $StatusCls = 'red';
							}*/


							if($PaymentTerm=='credit card' || $PaymentTerm=='paypal'){
							//paid or partially refunded
								if($OrderPaid==1 || $OrderPaid==3){
									if($PaymentTerm=='credit card'){$Status = 'Credit Card';}
								}else{
									$Status = ST_CREDIT_HOLD; $StatusCls = 'red';
								}
							} 


						}
					}

		                }else {
		                    $Status = $OrderStatus;
		                }
		            }

		      return '<span class="' . $StatusCls . '">' . $Status . '</span>';
		}

		function GetCreditStatusMsg($OrderStatus,$OrderPaid){
			 $Status = $OrderStatus;
			 $StatusCls = 'red';
			 if($OrderStatus == 'Completed') {		                
		                $StatusCls = 'green';
			 }else if($OrderStatus == 'Open' || $OrderStatus == '') {
				if($OrderPaid == '2'){
					$Status = 'Refunded';
				}else if($OrderPaid == '3'){
					$Status = 'Partially Refunded';
				}else if($OrderPaid == '1'){
					$Status = 'Paid'; $StatusCls = 'green';
				}
		         }

		         return '<span class="' . $StatusCls . '">' . $Status . '</span>';
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
			$avgCost=0;
			for($i=0;$i<=count($rs);$i++)
			{
				if(!empty($rs[$i]['TotalAmount']) && ($Config['Currency'] != "INR")){
				 $avgCost += CurrencyConvertor($rs[$i]['TotalAmount'],$rs[$i]['CustomerCurrency'],$Config['Currency']);
				}else if(!empty($rs[$i]['TotalAmount'])){
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
			$avgCost=0;
			for($i=0;$i<=count($rs);$i++)
			{
				if(!empty($rs[$i]['TotalAmount']) && $Config['Currency'] != $rs[$i]['CustomerCurrency']){
				 $avgCost += CurrencyConvertor($rs[$i]['TotalAmount'],$rs[$i]['CustomerCurrency'],$Config['Currency']);
				}else if(!empty($rs[$i]['TotalAmount'])){
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



		function  SalesCommReport($FromDate,$ToDate,$SalesPersonID,$salesPersonType="")
		{
                         global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(isset($salesPersonType)){			
      				$strAddQuery .= " and o.SalesPersonType='".$salesPersonType."'";
				if($salesPersonType=="1"){
					$comCondition = 'o.SalesPersonID=c.SuppID';
				}
			}

			

			 $strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales,o.SalesPersonID,o.SalesPerson,o.OrderID as InID,c.CommOn, sum(i.qty_invoiced) as QtyInvoiced,sum(i.avgCost) as Cost from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' ) left outer join h_commission c on ".$comCondition." left outer join s_order_item i on o.OrderID=i.OrderID where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and o.SalesPerson!='' ".$strAddQuery." group by o.SalesPersonID order by o.SalesPersonID asc";
 
				
			return $this->query($strSQLQuery, 1);		
		}

		
	
		function  PaymentReport5555555($FromDate,$ToDate,$SalesPersonID)
		{
                         global $Config;
			//$strAddQuery = " and o.InvoiceID='IN000551'"; //temp
			$strAddQuery = (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");						 

			$strSQLQuery = "select p.*, SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DebitAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CreditAmnt,o.InvoiceDate,o.Fee,o.OrderDate,o.InvoiceID as MainInvoiceID, o.OrderID as InID,o.CustomerName,o.SalesPersonID, o.SalesPerson, o.InvoicePaid, o.TotalAmount, o.TotalInvoiceAmount, o.Freight, o.Fee, o.ConversionRate, o.CustomerCurrency, c.CommOn,c.CommPercentage from s_order o left outer join f_payments p  on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on o.SalesPersonID=c.EmpID  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by o.InvoiceID order by p.PaymentDate desc,p.PaymentID desc";
			 
			if($_GET['pk']) echo $strSQLQuery;
				
			return $this->query($strSQLQuery, 1);		
		}

function  PaymentReport($FromDate,$ToDate,$SalesPersonID,$salesPersonType='')
		{
                         global $Config;
			$strAddQuery = "";
			//$strAddQuery = " and o.InvoiceID='IN000551'"; //temp			

			if(!empty($FromDate) && !empty($ToDate)){
				#$strAddQuery .= " and CASE WHEN p.PaymentDate>0 THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END = 1  ";
				$strAddQuery .= " and CASE WHEN c.CommPaidOn='Paid' THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END = 1  ";
			}

			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(isset($salesPersonType)){			
      				$strAddQuery .= " and o.SalesPersonType='".$salesPersonType."'";
				if($salesPersonType=="1"){
					$comCondition = 'o.SalesPersonID=c.SuppID';
				}
			}						 

			  $strSQLQuery = "select p.*, SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DebitAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CreditAmnt,o.InvoiceDate,o.Fee,o.OrderDate,o.InvoiceID as MainInvoiceID, o.OrderID as InID,o.CustomerName,o.SalesPersonID, o.SalesPerson, o.InvoicePaid, o.TotalAmount, o.TotalInvoiceAmount, o.Freight, o.Fee, o.taxAmnt, o.ConversionRate, o.CustomerCurrency, c.CommOn,c.CommPercentage from s_order o left outer join f_payments p  on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on ".$comCondition."  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid')  ELSE 1 END = 1 ".$strAddQuery."  group by o.InvoiceID order by p.PaymentDate desc,  p.PaymentID desc , o.InvoiceDate Asc ";
			 
			 
				
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
			$strAddQuery .= (!empty($CustCode))?(" and p.CustCode='".$CustCode."'"):("");			
		
			$strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,o.InvoiceDate,o.OrderDate,o.CustomerName,o.SalesPersonID,o.SalesPersonType,o.SalesPerson from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.InvoiceID!='' and (p.PaymentType='Sales'  or p.PaymentType = 'Other Income' ) and p.PostToGL='Yes' ) where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." order by p.PaymentDate desc,p.PaymentID desc";

				
			return $this->query($strSQLQuery, 1);		
		}

		



		/*****************On Total Amount**********************/
		function  GetSalesPayment($FromDate,$ToDate,$EmpID,$SuppID=0,$OrderID=0)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		

 
	
			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}
			

			 $strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales from s_order o  left outer join f_payments p on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on ".$comCondition." where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1  group by o.SalesPersonID";

			$arryRow = $this->query($strSQLQuery, 1);

			return $arryRow[0]['TotalSales'];
				
		}
	


		function  GetSalesPaymentNonResidual($FromDate,$ToDate,$EmpID,$SuppID=0,$OrderID=0)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			 

       			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		

			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}	

			  $sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on ".$comCondition."  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by p.InvoiceID order by p.PaymentDate asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);
 
		
			if(!empty($arryInvoice[0]["InvoiceID"])){
				$strSQLQuery = "select sum(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales from  f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and o.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." group by o.SalesPersonID";
			
				$arryRow = $this->query($strSQLQuery, 1);
			}

			return $arryRow[0]['TotalSales'];
				
		}



		/*****************On Per Invoice Payment**********************/

		function  GetSalesPaymentPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID=0)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
		 			
			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
	
 		

			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}


			  $strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on ".$comCondition." where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 ".$strAddQuery." ";

			return $this->query($strSQLQuery, 1);
							
		}

		function  GetSalesPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID=0)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			 
 			
			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}

			$sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on ".$comCondition." where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by p.InvoiceID order by p.PaymentDate asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);
			
			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
			if(!empty($arryInvoice[0]["InvoiceID"])){
				 $strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and p.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." ";
			
				return $this->query($strSQLQuery, 1);
			}
			
				
		}

		/*****************On Per Invoice Payment**********************/




		/****************************************/
		function  GetSalesPaymentMargin($PaymentID,$FromDate,$ToDate,$EmpID,$OrderID=0,$SuppID=0)
		{
                        global $Config;
			$strAddQuery = "";			

			if(!empty($FromDate) && !empty($ToDate)){
				#$strAddQuery .= " and CASE WHEN p.PaymentDate>0 THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END =1  ";

				$strAddQuery .= " and CASE WHEN c.CommPaidOn='Paid' THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END =1  ";
			}

			
			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		

			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}

			 $strSQLQuery = "select SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales, o.CustomerCurrency,o.ConversionRate,o.OrderID as InID, o.InvoiceID, o.TotalInvoiceAmount,o.Freight,o.Fee ,o.TDiscount,c.CommPaidOn  from s_order o  left outer join f_payments p on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on ".$comCondition." where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by o.InvoiceID order by o.InvoiceDate asc";
			 
			return $this->query($strSQLQuery, 1);
							
		}

		function  GetSalesPaymentNonResidualMargin($PaymentID,$FromDate,$ToDate,$EmpID,$OrderID=0,$SuppID=0)
		{
                        global $Config;
			$strAddQuery = "";
			
			if(!empty($FromDate) && !empty($ToDate)){
				#$strAddQuery .= " and CASE WHEN p.PaymentDate>0 THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END =1  ";

				$strAddQuery .= " and CASE WHEN c.CommPaidOn='Paid' THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END =1  ";
			}


			 			
			//$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");

 			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		
				
			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}	

			  $strSQLQuery = "select  o.InvoiceID from s_order o  left outer join f_payments p on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') left outer join h_commission c on ".$comCondition." where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by o.InvoiceID order by o.InvoiceDate asc  limit 0,1";

			return $this->query($strSQLQuery, 1);
							
		}


		/*function  GetSalesPaymentNonResidualMargin($PaymentID,$FromDate,$ToDate,$EmpID,$OrderID=0)
		{
                        global $Config;
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($EmpID))?(" and o.SalesPersonID='".$EmpID."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");	

			$sql_invoice = "select o.InvoiceID from s_order o left outer join f_payments p  on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales') left outer join h_commission c on o.SalesPersonID=c.EmpID where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by o.InvoiceID order by p.PaymentDate asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);
			 
			//$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
			if(!empty($arryInvoice[0]["InvoiceID"])){
				 $strSQLQuery = "select SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as TotalSales, o.CustomerCurrency,o.ConversionRate,o.OrderID as InID,o.TotalInvoiceAmount,o.Freight,o.Fee from s_order o   left outer join f_payments p on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales')  where o.Module='Invoice' and o.ReturnID='' and o.CreditID='' and o.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." group by o.InvoiceID ";
			
				return $this->query($strSQLQuery, 1);
			}
			
				
		}*/

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
			
			$strAddQuery .= (!empty($sourceby))?(" and o.OrderSource='".$sourceby."'"):("");  // Add By Ravi  15-04-16
			
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

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by o.PostToGL asc,o.InvoiceDate desc,o.OrderID desc ");
			
			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{				
				$Columns = "  o.*,o.CustomerName as OrderCustomerName, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName   ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			#$strSQLQuery = "select o.OrderDate, o.InvoiceEntry,o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from s_order o ".$strAddQuery;

		$strSQLQuery = "select ".$Columns." from s_order o left outer join s_customers c on o.CustCode=c.CustCode ".$strAddQuery;
		
		  //echo "<br>=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}	

		function  ListARInvoice($arryDetails)
		{
			global $Config;
			extract($arryDetails);

			(empty($module))?($module=""):("");
			 
			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "SaleID"; 
			}
			 

			$module = 'Invoice';
			$strAddQuery = " where o.NoUse='0' ";
			$SearchKey   = strtolower(trim($key));


			if(!empty($CustCode)){
				$strAddQuery .= " and o.CustCode='".mysql_real_escape_string($CustCode)."'";
			}else if($_SESSION['vAllRecord']!=1){
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
			}else if($sortby=='o.InvoicePaid' && $SearchKey=='credit card'){
				$strAddQuery .=  " and o.InvoicePaid='Unpaid' and o.PaymentTerm='Credit Card' and o.OrderPaid in ('1','3') ";
			}else if($sortby=='o.InvoicePaid'){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '".$SearchKey."')"):("");
			}else if($sortby=='o.CustomerName'){
				$strAddQuery .= (!empty($SearchKey))?(" and (o.CustomerName like '%".$SearchKey."%' or c.Company like '%".$SearchKey."%'  or c.FullName like '%".$SearchKey."%' )"):("");
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.InvoicePaid like '".$SearchKey."' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.TrackingNo like '%".$SearchKey."%' ) " ):("");	
				
			}
			$strAddQuery .= " and o.InvoiceID != '' and o.ReturnID = ''";
			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strAddQuery .= (!empty($PostToGL))?(" and o.PostToGL='".$PostToGL."'"):("");
			$strAddQuery .= (!empty($TaxFreight))?(" and (o.taxAmnt>0 || o.Freight>0) "):("");
			$strAddQuery .= (!empty($PostGLFrom))?(" and o.PostToGLDate>='".$PostGLFrom."'"):("");
			$strAddQuery .= (!empty($InvoicePaid))?(" and o.InvoicePaid='".$InvoicePaid."'"):("");

			if(!empty($Status)){
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}


			$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");
			$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");
		
			$batchCol=$join='';
				
				if(!empty($_GET['batchOn'])){
					if($_GET['batchOn']==1){
					#$strAddQuery .= " and  (b.status='Closed' OR o.InvoiceEntry=1 OR o.PostToGL=1) ";
					
					$batchCol = ",b.status as BatchStatus";
					$join = " left outer join batchmgmt b on (o.batchId=b.batchId and b.status='Closed') ";
					}
				}
			
			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{		
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by o.PostToGL asc,o.InvoiceDate desc,o.OrderID desc ");
		
				$Columns = "  o.OrderID, o.InvoiceID, o.SaleID, o.CustCode, o.OrderPaid, o.TotalInvoiceAmount,o.BalanceAmount,  o.CustomerCurrency, o.InvoicePaid, o.StatusMsg, o.InvoiceDate, o.MailSend, o.InvoiceEntry, o.CustomerPO, o.SalesPerson, o.SalesPersonID, o.EntryType, o.PostToGLDate, o.PostToGL, o.CustomerName as OrderCustomerName, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName, o.AdminType, o.PdfFile, o.AdminID, if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy ,o.batchId,o.PaymentTerm,o.RowColor ".$batchCol."   ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

		 $strSQLQuery = "select ".$Columns." from s_order o left outer join s_customers c on o.CustCode=c.CustCode left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee') ".$join." ".$strAddQuery;
		 
		 
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
            /***by sachin 14-03-2107**/
            $newaddcolm='';
            $newsqlQuery="SHOW COLUMNS FROM `s_customers`";
            $newdataColumn = $this->query($newsqlQuery, 1);
              $i=0;
            foreach($newdataColumn as $val){
                    
                   foreach($val as $key=>$vals){
                    if($key=='Field'){
                    //echo $key.'  '.$vals.'<br>';
                    $fieldArry[$i]=$vals;
                    
                    }
                    $i++;
                   }
            }
            //PR($_SESSION);
            
            if($_SESSION['CmpID']=='612'){
            if(in_array('ebcf1c',$fieldArry)){
                //echo  'yes';
                $newaddcolm=',c.ebcf1c';
            }
            }
            //die('ll');
            /***by sachin 14-03-2107**/
			$strAddQuery='';

			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.*, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName, e.Email as CreatedByEmail,c.Email as CustomerEmail,c.VAT,c.CST,c.PAN,c.TRN ".$newaddcolm." from ".$DB."s_order o left outer join ".$DB."h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') left outer join ".$DB."s_customers c on o.CustCode=c.CustCode where 1 ".$strAddQuery." order by o.OrderID desc";
			//echo $strSQLQuery;die;
			
			$data = $this->query($strSQLQuery, 1);
			
			return $this->query($strSQLQuery, 1);
		}

		function  GetSalesBrief($OrderID,$SaleID,$Module)
		{
			$strAddQuery = (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.Module, o.OrderID, o.InvoiceID, o.CreditID, o.InvoiceEntry,o.StatusMsg from s_order o  where 1 ".$strAddQuery." order by o.OrderID desc"; 			
			return $this->query($strSQLQuery, 1);
		}

		function  GetSalesOrderItem($id,$OrderID)
		{
			$strAddQuery = (!empty($id))?(" and so.id='".$id."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");			
			 
			$strSQLQuery = "select so.*,o.SalesPersonID,o.AdminID,o.PaymentTerm,o.SaleID,o.QuoteID,o.OrderDate from s_order_item so inner join s_order o on so.OrderID=o.OrderID where 1 ".$strAddQuery; 			
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetInvoice($OrderID,$InvoiceID,$Module,$db='')
		{
			$strAddQuery = (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID='".$InvoiceID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from ".$db."s_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetReturn($OrderID,$ReturnID,$Module)
		{
			$strAddQuery = (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($ReturnID))?(" and o.ReturnID='".$ReturnID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		

		function  GetSaleItem($OrderID,$Db='') 
		{
global $Config;
			$strAddQuery = (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
$strAddQuery .= (!empty($Config['droppick']))?(" and i.DropShipCheck='0'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                         $strSQLQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType ,itm.qty_on_hand,itm.CategoryID,w.warehouse_code,w.warehouse_name  from ".$Db."s_order_item i left outer join ".$Db."inv_tax_rates t on i.tax_id=t.RateId left outer join ".$Db."inv_items itm on ( i.item_id=itm.ItemID) left outer join ".$Db."inv_categories c on c.CategoryID =itm.CategoryID left outer join ".$Db."w_warehouse w on i.WID =w.WID where 1 ".$strAddQuery." order by i.id asc"; 
			return $this->query($strSQLQuery, 1);
		}

		function  GetSaleItemIN($OrderID) 
		{
			$strAddQuery = (!empty($OrderID))?(" and i.OrderID in (".$OrderID.") "):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                         $strSQLQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType ,itm.qty_on_hand,itm.CategoryID,w.warehouse_code,w.warehouse_name  from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on ( i.item_id=itm.ItemID) left outer join inv_categories c on c.CategoryID =itm.CategoryID left outer join w_warehouse w on i.WID =w.WID where 1 ".$strAddQuery." order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}

function  GetSaleBomItem($OrderID) 
		{
			$strAddQuery = (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                        $strSQLQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType ,itm.qty_on_hand,itm.CategoryID,itm.ItemType,w.warehouse_code,w.warehouse_name  from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on ( i.item_id=itm.ItemID) left outer join inv_categories c on c.CategoryID =itm.CategoryID left outer join w_warehouse w on i.WID =w.WID where 1 ".$strAddQuery." and i.`Condition` ='' and req_item!='' and  itm.ItemType='Non Kit' order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}
function  GetSaleComponentItem($OrderID,$PidID) 
		{
			$strAddQuery = (!empty($OrderID))?(" and i.OrderID='".$OrderID."'"):("");
     $strAddQuery .= (!empty($OrderID))?(" and i.parent_item_id='".$PidID."'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                        $strSQLQuery = "select i.*,t.RateDescription,c.valuationType as evaluationType ,itm.qty_on_hand,itm.CategoryID,itm.ItemType,w.warehouse_code,w.warehouse_name  from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on ( i.item_id=itm.ItemID) left outer join inv_categories c on c.CategoryID =itm.CategoryID left outer join w_warehouse w on i.WID =w.WID where 1 ".$strAddQuery."  order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}
		function  GetInvoiceOrder($SaleID)
		{
			$strSQLQuery = "select OrderID from s_order o where SaleID='".$SaleID."' and Module='Invoice' order by o.OrderID asc";
			return $this->query($strSQLQuery, 1);
		}	

		function  GetSuppPurchase($CustCode,$OrderID,$SaleID,$Module)
		{
			$strAddQuery = (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
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

	//EDI Update	
	$DBName=''; $EDICompName=$EDIPurchaseCompName; 
		if($EDISalesCompName!='') { 
					$DBName='erp_'.$EDISalesCompName.'.'; 
					$EDICompName=$_SESSION['DisplayName']; 
					$EDICompId=$_SESSION['AdminID']; 
		}
	if($AdminID==''){
	$AdminID=$_SESSION['AdminID'];

	}
	//End EDI Update	

			$IPAddress = GetIPAddress();
			
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
				//if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
				if(empty($CustomerCurrency ))$CustomerCurrency =  $Config['Currency'];
				$CreatedBy = $_SESSION['UserName'];
				$AdminID = $_SESSION['AdminID'];
				$AdminType = $_SESSION['AdminType'];
                                
                              
			}	

			if($PostedDate<=0) $PostedDate = $Config['TodayDate'];
						
                        
                        if($EntryType == 'one_time'){
				$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';
			}
                        
                            if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                            if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                            if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                            if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
                            
                          if($OrderType == 'Against PO' || $OrderType == 'PO'){$PONumber=$PONumber;}else{$PONumber='';}

			
			if($CustomerCurrency != $Config['Currency']){  
				if($Module=='Invoice'){
					$CurrencyDate = $InvoiceDate;	
				}else if($Module=='Credit'){
					$CurrencyDate = $PostedDate;	
				}else{
					$CurrencyDate = $OrderDate;	
				}
				$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR',$CurrencyDate);
			}else{   
				$ConversionRate=1;
			}

	
		    $strSQLQuery = "INSERT INTO ".$DBName."s_order SET Module = '".$Module."',
																		OrderType = '".$OrderType."',
																		PONumber = '".$PONumber."',
																		EntryType='".$EntryType."',
																		EntryInterval='".$EntryInterval."',
																		EntryMonth='".$EntryMonth."',
																		EntryWeekly = '".$EntryWeekly."',
																		EntryFrom='".$EntryFrom."',
																		EntryTo='".$EntryTo."',
																		EntryDate='".$EntryDate."',
																		OrderDate='".$OrderDate."',
																		SaleID ='".$SaleID."',
																		QuoteID = '".$QuoteID."',
																		CreditID = '".$CreditID."',
																		SalesPersonID = '".$SalesPersonID."',
																		SalesPerson = '".addslashes($SalesPerson)."',
																		SalesPersonType = '".addslashes($SalesPersonType)."',
																		InvoiceID = '".$InvoiceID."',
																		Approved = '".$Approved."',
																		Status = '".$Status."',
																		DeliveryDate = '".$DeliveryDate."',
																		ClosedDate = '".$ClosedDate."',
																		Comment = '".addslashes($Comment)."',
																		CustCode='".addslashes($CustCode)."',
																		CustID = '".addslashes($CustID)."',
																		CustomerCurrency = '".addslashes($CustomerCurrency)."',
																		BillingName = '".addslashes($BillingName)."',
																		CustomerName = '".addslashes($CustomerName)."',
																		CustomerCompany = '".addslashes($CustomerCompany)."',
																		Address = '".addslashes(strip_tags($Address))."',
																		City = '".addslashes($City)."',
																		State = '".addslashes($State)."',
																		Country = '".addslashes($Country)."',
																		ZipCode = '".addslashes($ZipCode)."',
																		Mobile = '".$Mobile."', 
																		Landline = '".$Landline."',
																		Fax = '".$Fax."',
																		Email = '".addslashes($Email)."',
																		ShippingName = '".addslashes($ShippingName)."',
																		ShippingCompany = '".addslashes($ShippingCompany)."',
																		ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."',
																		ShippingCity = '".addslashes($ShippingCity)."',
																		ShippingState = '".addslashes($ShippingState)."',
																		ShippingCountry = '".addslashes($ShippingCountry)."',
																		ShippingZipCode = '".addslashes($ShippingZipCode)."',
																		ShippingMobile = '".$ShippingMobile."',
																		ShippingLandline = '".$ShippingLandline."',
																		ShippingFax = '".$ShippingFax."',
																		ShippingEmail = '".addslashes($ShippingEmail)."',
																		TotalAmount = '".addslashes($TotalAmount)."',
																		Freight ='".addslashes($Freight)."',
																		TDiscount ='".addslashes($TDiscount)."',
																		taxAmnt ='".addslashes($taxAmnt)."',
																		CreatedBy = '".addslashes($CreatedBy)."',
																		AdminID='".$AdminID."',
																		AdminType='".$AdminType."',
																		PostedDate='".$PostedDate."',
                                    CreatedDate='".$Config['TodayDate']."',
																	  UpdatedDate='".$Config['TodayDate']."',
																		ShippedDate='".$ShippedDate."',
																		InvoiceComment='".addslashes($InvoiceComment)."',
																		PaymentMethod='".addslashes($PaymentMethod)."',
																		ShippingMethod='".addslashes($ShippingMethod)."',
																		PaymentTerm='".addslashes($PaymentTerm)."' ,
																		Taxable='".addslashes($Taxable)."' ,
																		Reseller='".addslashes($Reseller)."' ,
																		ResellerNo='".addslashes($ResellerNo)."',
																		tax_auths='".addslashes($tax_auths)."',
																		Spiff='".addslashes($Spiff)."',
																		SpiffContact='".addslashes($SpiffContact)."',
																		SpiffAmount='".addslashes($SpiffAmount)."',
																		TaxRate='".addslashes($MainTaxRate)."',
																		freightTxSet='".addslashes($freightTxSet)."',
																		CustDisType='".addslashes($CustDisType)."',
																		CustDisAmt='".addslashes($CustDiscount)."',
																		MDType='".addslashes($MDType)."',
																		MDAmount ='".addslashes($MDAmount)."',
																		MDiscount ='".addslashes($MDiscount)."' ,
																		AccountID ='".addslashes($AccountID)."' ,		
																		CustomerPO ='".addslashes($CustomerPO)."',
																		ShippingMethodVal ='".addslashes($ShippingMethodVal)."',
																		TrackingNo ='".addslashes($TrackingNo)."',
																		ShipAccount ='".addslashes($ShipAccount)."',
		
ShippingAccountCustomer='".$ShippingAccountCustomer."',
																									ShippingAccountNumber='".$ShippingAccNO."',
		
FreightDiscounted='".$freightDiscounted."', IPAddress='".$IPAddress."' ,RecurringOption='".$RecurringOption."', RecurringDate='".$RecurringDate."',BillingPeriod='".$BillingPeriod."',BillingFrequency='".$BillingFrequency."' ";

			//crm quote fields 
			$strSQLQuery .= " ,subject='".addslashes($subject)."' ,CustType='".addslashes($CustType)."' ,opportunityName='".addslashes($opportunityName)."' ,OpportunityID='".addslashes($OpportunityID)."', assignTo='".addslashes($assignTo)."', AssignType='".addslashes($AssignType)."', GroupID='".addslashes($GroupID)."', ConversionRate='".addslashes($ConversionRate)."',OrderSource='".$OrderSource."',Fee='".$Fee."' ,paypalEmail='".addslashes($paypalemail)."',CountryId ='".addslashes($CountryId)."' ,StateID ='".addslashes($StateID)."' ,CityID ='".addslashes($CityID)."' ,ShippingCountryID ='".addslashes($ShippingCountryID)."' ,ShippingStateID ='".addslashes($ShippingStateID)."' ,ShippingCityID ='".addslashes($ShippingCityID)."'  ";
$strSQLQuery .= " ,EDICompId='".addslashes($EDICompId)."' ,EDICompName='".addslashes($EDICompName)."'";
		 	

			#echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);			
			$OrderID = $this->lastInsertId();

			/*if(empty($arryDetails[$ModuleID]) && !empty($ModuleID)){
				$ModuleIDValue = $PrefixSale.'000'.$OrderID;
				$strSQL = "update s_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);				
			}*/
			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('s_order',$Module,$OrderID,$arryDetails[$ModuleID],$DBName);  

 // Add EDI purchase
		if($EDICompId!='' && $EDIPurchaseCompName!=''){
			$DBName='';
			if($EDIPurchaseCompName!='') {
				$DBName='erp_'.$EDIPurchaseCompName.'.';

			}

			$sql= "select * from ".$DBName."p_supplier where EDICompId='".addslashes($AdminID)."' ";
			$supplierdetail = $this->query($sql);
			$arryDetails['SuppCode']=$supplierdetail[0]['SuppCode'];
			$arryDetails['SuppCompany']=$supplierdetail[0]['CompanyName'];
			$arryDetails['SuppContact']=$supplierdetail[0]['Mobile'];
			$arryDetails['SuppCurrency']=$supplierdetail[0]['Currency'];
			$arryDetails['PrefixPO']='PO';

			$arryDetails['AdminID']=$EDICompId;
			$arryDetails['ModuleID']='PurchaseID';
			$objPurchase=new purchase();
			$order_id = $objPurchase->AddPurchase($arryDetails);
			$objPurchase->sendPurchaseEmail($order_id);
			$objPurchase->AddUpdateItem($order_id, $arryDetails);


		$SElectQury = "select PurchaseID from ".$DBName."p_order where OrderID='".$order_id."'";
		$arryPur = $this->query($SElectQury, 1);

		$SElectSaleQury = "select SaleID from s_order where OrderID='".$OrderID."'";
		$arrySal = $this->query($SElectSaleQury, 1);


			 $strSQL = "update s_order set EDIRefNo='EDI/".$_SESSION['AdminID']."/".$EDICompId."/".$order_id."/".$arryPur[0]['PurchaseID']."',PONumber = '".$arryPur[0]['PurchaseID']."' where OrderID='".$OrderID."'"; 
			$this->query($strSQL, 0);

			$strSQL = "update ".$DBName."p_order set EDIRefNo='EDI/".$_SESSION['AdminID']."/".$EDICompId."/".$OrderID."/".$arrySal[0]['SaleID']."',EDICompId='".addslashes($_SESSION['AdminID'])."',EDICompName='".addslashes($_SESSION['DisplayName'])."' where OrderID='".$order_id."'";
			$this->query($strSQL, 0);

		}

		// end




			return $OrderID;

		}


		function  GetSaleCreditCard($OrderID){
			global $Config;
			$strSQLQuery = "select c.*, DECODE(c.CardNumber,'". $Config['EncryptKey']."') as CardNumber  from s_order_card c where c.OrderID='".$OrderID."' and c.CardNumber!='' and c.CardType!=''";			
			return $this->query($strSQLQuery, 1);
		}	
		function  RemoveSaleCreditCard($OrderID){
			$strSQLQuery = "delete from s_order_card  where OrderID='".$OrderID."'";			
			return $this->query($strSQLQuery, 0);
		}

		function AddUpdateCreditCard($order_id, $arryDetails){  
			global $Config;
			extract($arryDetails);
			if(isset($PaymentTerm)){
				if($PaymentTerm=='Credit Card' && !empty($CreditCardNumber) && !empty($CreditCardType)){
					$arryCard = $this->GetSaleCreditCard($order_id);

					$addsql = " SET CardID='".$CreditCardID."', CardNumber=ENCODE('" .$CreditCardNumber. "','".$Config['EncryptKey']."'), CardType='".$CreditCardType."', CardHolderName='".$CreditCardHolderName."', ExpiryMonth='".$CreditExpiryMonth."', ExpiryYear='".$CreditExpiryYear."', Address='".$CreditAddress."' , Comment='".$CreditComment."', City = '".$CreditCity."', Country = '".$CreditCountry."', State = '".$CreditState."', ZipCode = '".$CreditZipCode."',  SecurityCode = '".$CreditSecurityCode."'  ";

					if(!empty($arryCard[0]['ID'])){
						$sql = "UPDATE s_order_card ".$addsql." where ID='".$arryCard[0]['ID']."'";				$this->query($sql, 0);
					}else{
						$sql = "INSERT INTO s_order_card ".$addsql." , OrderID='".$order_id."' ";
						$this->query($sql, 0);
						$ID = $this->lastInsertId();
					}
				}else{
					$this->RemoveSaleCreditCard($order_id);
				}
			}
			return true;

		}



		function AddUpdateItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
$DBName=''; if($EDISalesCompName!='') { $DBName='erp_'.$EDISalesCompName.'.'; }

			if(!empty($DelItem)){
				$arrDel = explode(",",$DelItem);
				if(!empty($arrDel[0])){
					$strSQLQuery = "delete from s_order_item where id in(".$DelItem.")"; 
					$this->query($strSQLQuery, 0);
				}
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
				
/*************************/

$objItem=new items();		
$checkProduct=$objItem->checkItemSku($arryDetails['sku'.$i],$DBName);
		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($arryDetails['sku'.$i],$DBName);
			if(count($arryAlias))
			{
					$Mainsku = $arryAlias[0]['sku'];				
			}
		}else{
     $Mainsku = $arryDetails['sku'.$i];
    }

/***************************/





					if($arryTax[1] > 0){

							 $actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i];	
							 $taxAmnt = ($actualAmnt*$arryTax[1])/100;
							 $totalTaxAmnt += $taxAmnt;
					}
        //****************************************Amit Singh*******************************/
        //$attri=oa_attributes[$i];
               $attributes=serialize($arryDetails['oa_attributes'.$i]);
        //****************************************End*******************************/


 if($arryDetails['EntryType'.$i] == 'one_time'){
$arryDetails['EntryType'.$i]  = 0;  $arryDetails['EntryDate'.$i]  = 0;  $arryDetails['EntryFrom'.$i] ='';  $arryDetails['EntryTo'.$i] = ''; $arryDetails['EntryInterval'.$i] ='';
$arryDetails['EntryMonth'.$i] = ''; $arryDetails['EntryWeekly'.$i] = '';
				
			}


                                         if(isset($arryDetails['DropshipCheck'.$i])){$DropshipCheck = 1;$serial_value='';}else{$DropshipCheck = 0;$serial_value=trim($arryDetails['serial_value'.$i]);}

if($EDIExe==1){ $DropshipCheck =0; }  //Added for EDI Dropship remove

					if($id>0){


/*********Added By bhoodev based on Condition 6 june 2016*********************/
if($Module=='Order'){

$strAddConQuery  = (!empty($arryDetails['Condition'.$i]))?(" and `condition`='".addslashes($arryDetails['Condition'.$i])."' "):("");
$strAddWareQuery = (!empty($arryDetails['WID'.$i]))?(" and `WID`='".$arryDetails['WID'.$i]."'"):("");
//ALTER TABLE `inv_item_quanity_condition` ADD `SaleQty` INT(11) NOT NULL AFTER `condition_qty`, ADD `AvlQty` INT(11) NOT NULL AFTER `SaleQty`;
//SaleQty = SaleQty-" . $arryDetails['QtySel'.$i] . "
				if($arryDetails['Condition'.$i]!=''){
				 $sqlCondAdd="select count(*) as total from ".$DBName."inv_item_quanity_condition where 
				Sku='" . addslashes($Mainsku) . "' and ItemID='" . addslashes($arryDetails['item_id'.$i]) . "'
				".$strAddConQuery." ".$strAddWareQuery." "; 
				$restblAdd=$this->query($sqlCondAdd, 1);
				if($restblAdd[0]['total']>0){
					// update in tbl
					 $AddQtysql = "update ".$DBName."inv_item_quanity_condition set SaleQty = SaleQty-" . $arryDetails['QtySel'.$i] . "  where Sku='" . $Mainsku . "' ".$strAddConQuery." ".$strAddWareQuery.""; 
					$this->query($AddQtysql, 0);
				}
			}
}
						$sql = "update ".$DBName."s_order_item set   item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."',`Condition`='".addslashes($arryDetails['Condition'.$i])."', description='".addslashes($arryDetails['description'.$i])."',FromDate='".addslashes($arryDetails['PFromDate'.$i])."',ToDate='".addslashes($arryDetails['PToDate'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."', discount ='".addslashes($arryDetails['discount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."', req_item='".addslashes($arryDetails['req_item'.$i])."',DropshipCheck='".addslashes($DropshipCheck)."',DropshipCost='".addslashes($arryDetails['DropshipCost'.$i])."',DesComment='".addslashes($arryDetails['DesComment'.$i])."',CustDiscount='".addslashes($arryDetails['CustDiscount'.$i])."',attributes='".addslashes($attributes)."',parent_item_id = '".$arryDetails['parent_ItemID'.$i]."',avgCost = '".$arryDetails['avgCost'.$i]."',RecurringCheck = '".$arryDetails['RecurringCheck'.$i]."',EntryType = '".$arryDetails['EntryType'.$i]."',EntryFrom = '".$arryDetails['EntryFrom'.$i]."',EntryTo = '".$arryDetails['EntryTo'.$i]."',EntryInterval = '".$arryDetails['EntryInterval'.$i]."',EntryMonth = '".$arryDetails['EntryMonth'.$i]."',EntryWeekly = '".$arryDetails['EntryWeekly'.$i]."',EntryDate = '".$arryDetails['EntryDate'.$i]."',Org_Qty = '".$arryDetails['Org_Qty'.$i]."',parent_line_id = '".$arryDetails['parent_line_id'.$i]."',child_line_id = '".$arryDetails['child_line_id'.$i]."'  where id='".$id."'"; 

 $this->query($sql, 0);


      


                                                /***code for save quote variant****/
                                                /*$sqlvar="Delete From c_quote_item_variant where quote_item_ID='".$id."' and type='".$varianttype."'";
                                                
                                                $this->query($sqlvar, 0);
                                                if(!empty($arryDetails['variantID_'.$i])){
                                               foreach($arryDetails['variantID_'.$i] as $arryDetailsval){
                                                  $sql_variantV = "insert into c_quote_item_variant(quote_item_ID, item_id,OrderID, variantID,type) values('".$id."', '".$arryDetails['item_id'.$i]."', '".$order_id."','".$arryDetailsval."','".$varianttype."')";
                                                 $this->query($sql_variantV, 0);
                                                  
                                                }
                                                }*/
                                                /***code for save quote variant****/
                                                /************code for variant option**************/
                                                
                                               /* $sqlvarOP="Delete From c_quote_item_variantOptionValues where quote_item_ID='".$id."' and type='".$varianttype."'";
                                                $this->query($sqlvarOP, 0);
                                                
                                                if(!empty($arryDetails['varmul_'.$i])){
                                            foreach($arryDetails['varmul_'.$i] as $keys=>$values){
                                                
                                                
                                                foreach($values as $val){
                                                    
                                                    $sql_variantVOP = "insert into c_quote_item_variantOptionValues(quote_item_ID, item_id,OrderID, variantID,variantOPID,type) values('".$id."', '".$arryDetails['item_id'.$i]."', '".$order_id."','".$keys."','".$val."','".$varianttype."')";
                                                
                                                    $this->query($sql_variantVOP, 0);
                                                }
							
                                                
                                            }
                                                }*/
                                                /*************end code for variant*****************/
 



//  edited by amit singh
					}else{



$sql = "insert into ".$DBName."s_order_item(OrderID, item_id, sku, description,FromDate,ToDate,on_hand_qty, qty, price, tax_id, tax, amount, discount, Taxable, req_item,DropshipCheck,DropshipCost,SerialNumbers,`Condition`, DesComment,CustDiscount,attributes,parent_item_id,avgCost,RecurringCheck,EntryType,EntryFrom,EntryTo,EntryInterval, EntryMonth, EntryWeekly, EntryDate, Org_Qty,WID,parent_line_id,child_line_id) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."','".addslashes($arryDetails['PFromDate'.$i])."','".addslashes($arryDetails['PToDate'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['discount'.$i])."' ,'".addslashes($arryDetails['item_taxable'.$i])."' ,'".addslashes($arryDetails['req_item'.$i])."','".addslashes($DropshipCheck)."','".addslashes($arryDetails['DropshipCost'.$i])."','".addslashes($serial_value)."','".addslashes($arryDetails['Condition'.$i])."' ,'".addslashes($arryDetails['DesComment'.$i])."','".addslashes($arryDetails['CustDiscount'.$i])."','".addslashes($attributes)."','".$arryDetails['parent_ItemID'.$i]."','".$arryDetails['avgCost'.$i]."','".$arryDetails['RecurringCheck'.$i]."','".$arryDetails['EntryType'.$i]."','".$arryDetails['EntryFrom'.$i]."','".$arryDetails['EntryTo'.$i]."','".$arryDetails['EntryInterval'.$i]."','".$arryDetails['EntryMonth'.$i]."','".$arryDetails['EntryWeekly'.$i]."', '".$arryDetails['EntryDate'.$i]."', '".$arryDetails['Org_Qty'.$i]."','".$arryDetails['WID'.$i]."','".$arryDetails['parent_line_id'.$i]."','".$arryDetails['child_line_id'.$i]."')";
				
$this->query($sql, 0);
                                                /*start code by sachin*/
                                                $lastInsertIdVr = $this->lastInsertId();
                                                /***code for save quote variant****/
                                                if(!empty($arryDearryDetailstails['variantID_'.$i])){
                                               foreach($arryDetails['variantID_'.$i] as $arryDetailsval){
                                                  $sql_variantV = "insert into ".$DBName."c_quote_item_variant(quote_item_ID, item_id,OrderID, variantID,type) values('".$lastInsertIdVr."', '".$arryDetails['item_id'.$i]."', '".$order_id."','".$arryDetailsval."','".$varianttype."')";
                                                 $this->query($sql_variantV, 0);
                                                }
                                                }
                                                /************code for variant option**************/
                                                
                                                if(!empty($arryDetails['varmul_'.$i])){
                                            foreach($arryDetails['varmul_'.$i] as $keys=>$values){
                                               
                                                foreach($values as $val){
                                                    
                                                    $sql_variantVOP = "insert into ".$DBName."c_quote_item_variantOptionValues(quote_item_ID, item_id,OrderID, variantID,variantOPID,type) values('".$lastInsertIdVr."', '".$arryDetails['item_id'.$i]."', '".$order_id."','".$keys."','".$val."','".$varianttype."')";
                                                
                                                    $this->query($sql_variantVOP, 0);
                                                    
                                                   
                                                }
							
                                                 
                                            }
                                                }
                                                /*************end code for variant *end code by sachin******************/


}

if($arryDetails['PONumber']!=''){
 $this->UpdateSaleQtyInPO($arryDetails['PONumber'],$arryDetails['qty'.$i],$arryDetails['sku'.$i],$arryDetails['Condition'.$i],$DBName);
}


					//$this->query($sql, 0);	

				}


/*********Added By bhoodev based on Condition 6 june 2016*********************/
if($Module=='Order'){
$strAddConQuery  = (!empty($arryDetails['Condition'.$i]))?(" and `condition`='".addslashes($arryDetails['Condition'.$i])."' "):("");
$strAddWareQuery = (!empty($arryDetails['WID'.$i]))?(" and `WID`='".$arryDetails['WID'.$i]."'"):("");

				if($arryDetails['Condition'.$i]!=''){
				 $sqlCond="select count(*) as total from inv_item_quanity_condition where 
				Sku='" . addslashes($Mainsku) . "' and ItemID='" . addslashes($arryDetails['item_id'.$i]) . "' ".$strAddConQuery." ".$strAddWareQuery."
				  "; 
				$restbl=$this->query($sqlCond, 1);
				if($restbl[0]['total']>0){
					// update in tbl condition_qty = condition_qty-" . $arryDetails['qty'.$i] . "
					$UpdateQtysql = "update inv_item_quanity_condition set SaleQty = SaleQty+" . $arryDetails['qty'.$i] . "  where Sku='" . $Mainsku . "' ".$strAddConQuery." ".$strAddWareQuery."";
					$this->query($UpdateQtysql, 0);
				}else{


 $strInsQuery = "insert into inv_item_quanity_condition 
							(ItemID,`condition`,Sku,type,condition_qty,SaleQty,WID)  
							values ('" . addslashes($arryDetails['item_id'.$i]) . "',
							'" . addslashes($arryDetails['Condition'.$i]) . "',
							'" . addslashes($Mainsku) . "','Sale Order','0','" . $arryDetails['QtySel'.$i] . "','".$arryDetails['WID'.$i]."'
							)"; 
							$this->query($strInsQuery, 0);
       $QtyID = $this->lastInsertId();
$Qtysql = "update inv_item_quanity_condition set SaleQty = SaleQty+" . $arryDetails['QtySel'.$i] . "  where Sku='" . $Mainsku . "' ".$strAddConQuery." ".$strAddWareQuery."";
					//$this->query($Qtysql, 0);

}
			}
}



/*********end By bhoodev based on Condition 6 june 2016*********************/
			}

		        #$strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
			 $strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'"; 
			$this->query($strSQL, 0);
			return true;

		}



		function UpdateSale($arryDetails){ 
			global $Config;
			extract($arryDetails);	
			$DBName=''; $EDICompName=$EDIPurchaseCompName; if($EDISalesCompName!='') { $DBName='erp_'.$EDISalesCompName.'.'; $EDICompName=$_SESSION['DisplayName']; $EDICompId=$_SESSION['AdminID']; }
			//if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
                        
                       if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth='';$EntryWeekly = '';}
                      
                       
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			

			if($CustomerCurrency != $Config['Currency']){  
				if($Module=='Invoice'){
					$CurrencyDate = $InvoiceDate;	
				}else if($Module=='Credit'){
					$CurrencyDate = $PostedDate;	
				}else{
					$CurrencyDate = $OrderDate;	
				}
				$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR',$CurrencyDate);
			}else{   
				$ConversionRate=1;
			}

			$AddSql='';
			if(isset($PaymentTerm)){
				$AddSql .= ",PaymentTerm='".$PaymentTerm."'";
			}

			if(isset($PostedDate)){
				if($PostedDate>0) $AddSql .= ",PostedDate='".$PostedDate."'";
			}

			$strSQLQuery = "UPDATE ".$DBName."s_order SET Module = '".$Module."',EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."', OrderDate='".$OrderDate."', InvoiceID = '".$InvoiceID."',SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."',SalesPersonType = '".$SalesPersonType."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', ClosedDate = '".$ClosedDate."', Comment = '".addslashes($Comment)."', CustomerCurrency = '".addslashes($CustomerCurrency)."' , CustCode='".addslashes($CustCode)."', CustID = '".addslashes($CustID)."' , BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',ShippingAccountCustomer='".$ShippingAccountCustomer."',			ShippingAccountNumber='".$ShippingAccNO."',FreightDiscounted='".$freightDiscounted."',
			TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."',TDiscount ='".addslashes($TDiscount)."', taxAmnt ='".addslashes($taxAmnt)."',  UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."',InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."',Spiff='".addslashes($Spiff)."',SpiffContact='".addslashes($SpiffContact)."',SpiffAmount='".addslashes($SpiffAmount)."', TaxRate='".addslashes($MainTaxRate)."',freightTxSet='".addslashes($freightTxSet)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."',MDiscount ='".addslashes($MDiscount)."',AccountID ='".addslashes($AccountID)."',CustomerPO ='".addslashes($CustomerPO)."' ,ShippingMethodVal ='".addslashes($ShippingMethodVal)."',TrackingNo ='".addslashes($TrackingNo)."',ShipAccount ='".addslashes($ShipAccount)."' ,ConversionRate ='".addslashes($ConversionRate)."',OrderSource='".$OrderSource."' ,RecurringOption='".addslashes($RecurringOption)."'
			,RecurringDate='".addslashes($RecurringDate)."',BillingPeriod='".addslashes($BillingPeriod)."',BillingFrequency='".addslashes($BillingFrequency)."',CountryId='".addslashes($CountryId)."',StateID='".addslashes($StateID)."',CityID='".addslashes($CityID)."',ShippingCountryID='".addslashes($ShippingCountryID)."',ShippingStateID='".addslashes($ShippingStateID)."',ShippingCityID='".addslashes($ShippingCityID)."' ".$AddSql."  WHERE OrderID='".$OrderID."'";

			
			//echo $strSQLQuery; exit;
			$this->query($strSQLQuery, 0);


			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('s_order',$ModuleID,$OrderID,$arryDetails[$ModuleID]); 


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
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount ,Taxable,`Condition`,CustDiscount,RecurringCheck,EntryType,EntryFrom,EntryTo,EntryInterval,EntryMonth,EntryWeekly,Org_Qty,WID) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["item_taxable"]."','".$arryItem[$Count]["Condition"]."','".addslashes($arryDetails['CustDiscount'.$i])."','".$arryItem[$Count]['RecurringCheck']."','".$arryItem[$Count]['EntryType']."','".$arryItem[$Count]['EntryFrom']."','".$arryItem[$Count]['EntryTo']."','".$arryItem[$Count]['EntryInterval']."','".$arryItem[$Count]['EntryMonth']."','".$arryItem[$Count]['EntryWeekly']."','".$arryItem[$Count]['Org_Qty']."','".$arryItem[$Count]['WID']."')";

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

		function UpdateInvoice($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update s_order set ShippedDate='".$ShippedDate."', PaymentDate='".$PaymentDate."', InvoicePaid='".$InvoicePaid."', InvPaymentMethod='".$InvPaymentMethod."', PaymentRef='".addslashes($PaymentRef)."', InvoiceComment='".addslashes($InvoiceComment)."', UpdatedDate = '".$Config['TodayDate']."',OrderSource='".addslashes($OrderSource)."',Fee='".$Fee."',TDiscount ='".addslashes($TDiscount)."'
			where OrderID='".$OrderID."'"; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

		function  CountSkuSerialNo($Sku)
		{
			$strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1'  and Sku='".$Sku."' ";
			$arryRow = $this->query($strSQLQuery, 1);
			
			/*$sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='".$Sku."' group by i.sku";			
			$arryInvoiced = $this->query($sqlInvoiced);
                        
                         
			$NumLeft = $arryRow[0]['TotalSerial']-$arryInvoiced[0]['QtyInvoiced'];
                        
			if($NumLeft<0) $NumLeft=0;*/
			return $arryRow[0]['TotalSerial'];		
		}
                
                function  CountSkuSerialNoAndQtyInvoiced($Sku)
		{
			$strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and Sku='".$Sku."' ";
			$arryRow = $this->query($strSQLQuery, 1);
			
			$sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='".$Sku."' group by i.sku";			
			$arryInvoiced = $this->query($sqlInvoiced);
			$SerialNoAndQtyInvoiced = $arryRow[0]['TotalSerial']."#".$arryInvoiced[0]['QtyInvoiced'];
                        
			return $SerialNoAndQtyInvoiced;		
		}

			function  selectSerialNumberForItem27nov2017($Sku)
			{
							global $Config;
				$strAddQuery = '';
							$strAddQuery .= (!empty($Config['Condition']))?(" and `Condition`='".mysql_real_escape_string($Config['Condition'])."'"):("");
							//$strAddQuery .= (!empty($Config['LineID']))?(" and (`LineID`='".mysql_real_escape_string($Config['LineID'])."' or UsedSerial=0 or `OrderID`='".mysql_real_escape_string($Config['OrderID'])."' )"):(" and UsedSerial=0 ");
							$strAddQuery .= (!empty($Config['warehouse']))?(" and `warehouse`='".mysql_real_escape_string($Config['warehouse'])."'"):(" and warehouse=1 ");
							//$strAddQuery .= (!empty($Config['OrderID']))?(" and `OrderID`='".mysql_real_escape_string($Config['OrderID'])."'"):("");

							if($Config['GetNumRecords']==1){
							     $Columns = " count(serialID) as NumCount ";

							}else{

									$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by UsedSerial,serialID desc ");

									$Columns = " `Condition`,LineID,UnitCost,serialNumber,serialID,UsedSerial,Status ";
									if($Config['RecordsPerPage']>0)$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
							}




							 $strSQLQuery = "select ".$Columns." from inv_serial_item where Status='1'   and Sku='".$Sku."'   ".$strAddQuery." ";

							//$strSQLQuery = "select * from inv_serial_item where Status='1'   and Sku='".$Sku."'   ".$strAddQuery."  order by UsedSerial asc";
							return $this->query($strSQLQuery, 1);
			}
          

function  selectSerialNumberForItem($Sku)
			{
							global $Config;
$strAddQuery ='';
							$strAddQuery .= (!empty($Config['Condition']))?(" and `Condition`='".mysql_real_escape_string($Config['Condition'])."'"):("");
							$strAddQuery .= (!empty($Config['LineID']))?(" and (`LineID`='".mysql_real_escape_string($Config['LineID'])."' or UsedSerial='0'  )"):("  ");
							$strAddQuery .= (!empty($Config['warehouse']))?(" and `warehouse`='".mysql_real_escape_string($Config['warehouse'])."'"):(" and warehouse='1' ");
							//$strAddQuery .= (!empty($Config['OrderID']))?(" and `OrderID`='".mysql_real_escape_string($Config['OrderID'])."'"):("");

							if(!empty($Config['GetNumRecords'])){
							     $Columns = " count(serialID) as NumCount ";

							}else{

									$strAddQuery .= (!empty($sortby))?(" order order by UsedSerial asc"):("  order by UsedSerial desc ");

									$Columns = " Sku,`Condition`,LineID,UnitCost,serialNumber,serialID,UsedSerial,Status ";
									if($Config['RecordsPerPage']>0)$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
							}




							  $strSQLQuery = "select ".$Columns." from inv_serial_item where Status='1'   and Sku='".$Sku."'   ".$strAddQuery." ";

							//$strSQLQuery = "select * from inv_serial_item where Status='1'   and Sku='".$Sku."'   ".$strAddQuery."  order by UsedSerial asc";
							return $this->query($strSQLQuery, 1);
			}



 function  selectallSerialNumberForItem($Sku,$Condition,$warehouse,$lineID)
                 {
global $Config;
		$strAddQuery = '';
$strAddQuery .= (!empty($Condition))?(" and `Condition`='".mysql_real_escape_string($Condition)."'"):("");
$strAddQuery .= (" and UsedSerial='0' and LineID='0' ");
$strAddQuery .= (!empty($warehouse))?(" and `warehouse`='".mysql_real_escape_string($warehouse)."'"):(" and warehouse='1' ");
//$strAddQuery .= (!empty($Config['OrderID']))?(" and `OrderID`='".mysql_real_escape_string($Config['OrderID'])."'"):("");


				 
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by Sku asc ");

				//$Columns = " SUM(UnitCost),GROUP_CONCAT(serialNumber) as serial";

$Columns = " UnitCost,serialNumber";
				
        if($Config['Totalqty']>0)$strAddQuery .= " limit 0,".$Config['Totalqty'];
			


   $strSQLQuery = "select ".$Columns." from inv_serial_item where Status='1' and Sku='".$Sku."'   ".$strAddQuery." "; 

                         //$strSQLQuery = "select * from inv_serial_item where Status='1'   and Sku='".$Sku."'   ".$strAddQuery."  order by UsedSerial asc";
                         return $this->query($strSQLQuery, 1);
                  }


      
 function  selectallSerialNumberForItembak27nov2017($Sku,$Condition,$warehouse,$lineID)
                 {
global $Config;
$strAddQuery = '';
$strAddQuery .= (!empty($Condition))?(" and `Condition`='".mysql_real_escape_string($Condition)."'"):("");
$strAddQuery .= (" and UsedSerial=0 and LineID=0 ");
$strAddQuery .= (!empty($warehouse))?(" and `warehouse`='".mysql_real_escape_string($warehouse)."'"):(" and warehouse=1 ");
//$strAddQuery .= (!empty($Config['OrderID']))?(" and `OrderID`='".mysql_real_escape_string($Config['OrderID'])."'"):("");


				 
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  group by Sku asc ");

				$Columns = " SUM(UnitCost),GROUP_CONCAT(serialNumber) as serial";
				
        if($Config['Totalqty']>0)$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['Totalqty'];
			


   $strSQLQuery = "select ".$Columns." from inv_serial_item where Status='1' and Sku='".$Sku."'   ".$strAddQuery." "; 

                         //$strSQLQuery = "select * from inv_serial_item where Status='1'   and Sku='".$Sku."'   ".$strAddQuery."  order by UsedSerial asc";
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
                     $strSQLQuery = "update inv_serial_item set UsedSerial = '1' where serialNumber = '".addslashes($serialNumber)."' and Sku = '".addslashes($Sku)."'  ";
                     $this->query($strSQLQuery, 0);
                 }
                 
                  function addSerailNumberForReturn($arryDetails)
                 {
                     global $Config;
		     extract($arryDetails);
                     $strSQLQuery = "update inv_serial_item set UsedSerial = '0'  where serialNumber = '".addslashes($serialNumber)."' and Sku = '".addslashes($Sku)."'  ";
                     $this->query($strSQLQuery, 0);
                 }

		function  CountInvoices($SaleID)
		{
			$strSQLQuery = "select count(o.OrderID) as TotalInvoice from s_order o where o.Module='Invoice' and SaleID='".$SaleID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['TotalInvoice'];		
		}


		function isSalesTransactionExist($OrderID,$PaymentTerm=''){
			$AddSql='';
			if(!empty($PaymentTerm)) $AddSql .= " and PaymentTerm='".$PaymentTerm."' ";
			$strSQLQuery = "select ID from s_order_transaction where OrderID='".$OrderID."' ".$AddSql." limit 0,1 "; 
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ID'])) {
				return true;
			} else {
				return false;
			}
		}

		function GetSalesTransaction($OrderID,$PaymentTerm){
			global $Config;
			$AddSql='';
			if(!empty($Config["CreditOrderID"])) $AddSql .= " and t.CreditOrderID='".$Config["CreditOrderID"]."' ";
			$strSQLQuery = "select t.*,p.ProviderName,o.InvoiceID, o.SaleID,o.Module from s_order_transaction t inner join s_order o on t.OrderID=o.OrderID left outer join f_payment_provider p on t.ProviderID=p.ProviderID where t.OrderID='".$OrderID."' and t.PaymentTerm='".$PaymentTerm."' ".$AddSql." order by ID desc"; 
			return $this->query($strSQLQuery, 1);			 
		}

		function GetTransactionBySaleID($SaleID,$PaymentTerm){
			global $Config;
			$AddSql='';
			if(!empty($SaleID)){
				if(!empty($Config["CreditOrderID"])) $AddSql .= " and t.CreditOrderID='".$Config["CreditOrderID"]."' ";
				$strSQLQuery = "select t.*,p.ProviderName,o.InvoiceID, o.SaleID,o.Module from s_order_transaction t inner join s_order o on t.OrderID=o.OrderID left outer join f_payment_provider p on t.ProviderID=p.ProviderID where o.Module in ('Invoice','Order') and o.SaleID='".$SaleID."' and t.PaymentTerm='".$PaymentTerm."' ".$AddSql." order by t.ID desc"; 
				return $this->query($strSQLQuery, 1);	
			}		 
		}

		function RemoveSale($OrderID){
			global $Config;
			$objConfigure=new configure();
			$objConfig=new admin();	
			$objFunction=new functions();
		   if($OrderID>0){
			$arrySale = $this->GetSale($OrderID,'','');
			 

			if($_GET['module']=='Order'){
			$arryItem = $this->GetSaleItem($OrderID);
			$NumLine = sizeof($arryItem);
			for($i=0;$i<=$NumLine;$i++){


/*********Added By bhoodev based on Condition 6 june 2016*********************/
$objItem=new items();		
$checkProduct=$objItem->checkItemSku($arryItem[$i]['sku']);
		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($arryItem[$i]['sku']);
			if(count($arryAlias))
			{
					$Mainsku = $arryAlias[0]['sku'];				
			}
		}else{
     $Mainsku = $arryItem[$i]['sku'];
    }

					//if($Module=='Order' && !empty($id)){
					if($arryItem[$i]['Condition']!=''){
						 $sqlCond="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($Mainsku) . "' and ItemID='" . addslashes($arryItem[$i]['item_id']) . "'
						and `condition`='".addslashes($arryItem[$i]['Condition'])."' and WID='".$arryItem[$i]['WID']."' "; 
						$restbl=$this->query($sqlCond, 1);
						if($restbl[0]['total']>0){
							
							// update in tbl SaleQty = SaleQty+" . $arryDetails['QtySel'.$i] . "
							$UpdateQtysql = "update inv_item_quanity_condition set SaleQty = SaleQty-".$arryItem[$i]['qty']."  where Sku='".$Mainsku."' and `condition`='".addslashes($arryItem[$i]['Condition'])."' and WID='".$arryItem[$i]['WID']."' ";
							$this->query($UpdateQtysql, 0);
						}
					}
//}

			}
}




			/******Delete PDF**********/
			$ModuleDepName = "Sales";
			if($arrySale[0]['Module']=="Order"){
				$SaleIDCol = 'SaleID';				
				$PdfFolder = $Config['S_Order'];
			}else{
				$SaleIDCol = 'QuoteID'; 
				$PdfFolder = $Config['S_Quote'];
			}	
			$SaleID = $arrySale[0][$SaleIDCol];		 
			$PdfFile = $ModuleDepName.'-'.$SaleID.'.pdf';
			$objFunction->DeleteFileStorage($PdfFolder,$PdfFile);	

			$PdfTemplateArray = array('ModuleDepName' => $ModuleDepName,  'PdfDir' => $PdfFolder, 'TableName' => 's_order', 'OrderID' => $OrderID, 'ModuleID' => $SaleIDCol);
			$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);
 	
			/**************************/


			/******Delete Multi Document**********/
			$arrayM['OrderID']=$OrderID;
			$arrayM['Module']='Sales'.$_GET['module'];
			$arrayM['ModuleName']='Sales';
			$getDocumentArry=$objConfig->GetOrderDocument($arrayM);
			$DocDir = $Config['FileUploadDir'].$Config['S_DocomentDir'];

			foreach($getDocumentArry as $val) {
				if(!empty($val['FileName'])){ 
					$objFunction->DeleteFileStorage($Config['S_DocomentDir'],$val['FileName']);		
				}	
			}
			$objConfig->DeleteAllOrderDocument($arrayM);
			/*********************/

			$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			$strSQLQuery = "delete from s_order_card  where OrderID='".$OrderID."'";	
			$this->query($strSQLQuery, 0);


			

				


			}



			return 1;

		}

		function RemoveSaleItem($OrderID){		

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}


		function  GetQtyReceived($id)
		{
			$sql = "select sum(i.qty_received) as QtyReceived from s_order_item i where i.ref_id='".$id."' group by i.ref_id";
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
			global $Config;
			if(!empty($OrderID)){
				$objConfigure = new configure();
				$objFunction=new functions();
				$objConfig=new admin();		
			

				if(empty($SaleID)){
					$SaleID = $objConfigure->GetNextModuleID('s_order','Order');
 				}			 
				$sql="UPDATE s_order SET Module='Order', OrderDate='".$Config['TodayDate']."' WHERE OrderID='".$OrderID."'";
				$this->query($sql,0);						
				$objConfigure->EditUpdateAutoID('s_order','SaleID',$OrderID,$SaleID); 



				/******Delete Quote PDF and Generate Sales Pdf**********/ 
				$sqlc = "select QuoteID from s_order where OrderID = '".$OrderID."' ";
				$arryQT =  $this->query($sqlc, 1); 
				$PdfFile = "Sales".'-'.$arryQT[0]['QuoteID'].'.pdf';
				$objFunction->DeleteFileStorage($Config['S_Quote'],$PdfFile);

				$PdfTemplateArray = array('ModuleDepName' => "Sales",  'PdfDir' => $Config['S_Quote'], 'TableName' => 's_order', 'OrderID' => $OrderID, 'ModuleID' => "QuoteID");
				$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);

				/*******Generate PDF************/			
				$PdfArray['ModuleDepName'] = "Sales";
				$PdfArray['Module'] = "Order";
				$PdfArray['ModuleID'] = "SaleID";
				$PdfArray['TableName'] =  "s_order";
				$PdfArray['OrderColumn'] =  "OrderID";
				$PdfArray['OrderID'] =  $OrderID;		 	
				$objConfigure->GeneratePDF($PdfArray);
				$PdfFile = 'Sales-'.$SaleID.'.pdf';	
				$sqlo="UPDATE s_order SET PdfFile='".$PdfFile."' WHERE OrderID='".$OrderID."'";
				$this->query($sqlo,0);

				$sqld="update order_document set Module='SalesOrder' where Module='SalesQuote' and OrderID='".$OrderID."' and ModuleName='Sales'";
				$this->query($sqld,0);
						
				/**************************/
			}

			return true;
		}
		
		
		function  GetSaleOrderForInvoice($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
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
                        
			if($Config['CronEntry']==1){ //cron entry
				$EntryType = 'one_time';
				$InvoiceID = '';	
				$InvoiceDate = $Config['TodayDate'];
				$ShippedDate = $Config['TodayDate'];
				
			}else{
				
				$InvoiceID = $InvoiceData['InvoiceID'];
				$TotalInvoiceAmount = $InvoiceData['TotalAmount'];
				$Freight = $InvoiceData['Freight'];
				$ShipFreight = $InvoiceData['ShipFreight'];
				$TrackingNo = $InvoiceData['TrackingNo'];
				$taxAmnt = $InvoiceData['taxAmnt'];
				$ShippedDate = $InvoiceData['ShippedDate'];
				$wCode = $InvoiceData['wCode'];
				$wName = $InvoiceData['wName'];
				$InvoiceComment = $InvoiceData['InvoiceComment'];
				if(!empty($InvoiceData['chooseItem']))$ShippingMethod = $InvoiceData['chooseItem'];
				$InvoiceDate = $InvoiceData['InvoiceDate']; 
				if(empty($InvoiceDate)) $InvoiceDate = date('Y-m-d');

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

			if($CustomerCurrency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR',$InvoiceDate);
			}else{   
				$ConversionRate=1;
			}


			$IPAddress = GetIPAddress();

			$strSQLQuery = "INSERT INTO s_order SET Module = 'Invoice',
																		ConversionRate='".$ConversionRate."',
																		EntryType='".$EntryType."',
																		EntryInterval='".$EntryInterval."',
																		EntryMonth='".$EntryMonth."',
																		EntryWeekly = '".$EntryWeekly."',
																		EntryFrom='".$EntryFrom."',
																		EntryTo='".$EntryTo."',
																		EntryDate='".$EntryDate."',
																		OrderDate='".$OrderDate."',
																		SaleID ='".$SaleID."',
																		QuoteID = '".$QuoteID."',
																		SalesPersonID = '".$SalesPersonID."',
																		SalesPerson = '".addslashes($SalesPerson)."',
																		SalesPersonType = '".$SalesPersonType."',
																		InvoiceID = '".$InvoiceID."',
																		Approved = '".$Approved."',
																		Status = '".$Status."',
																		DeliveryDate = '".$DeliveryDate."',
																		Comment = '".addslashes($Comment)."',
																		CustCode='".addslashes($CustCode)."',
																		CustID = '".$CustID."',
																		CustomerCurrency = '".addslashes($CustomerCurrency)."',
																		CustomerName = '".addslashes($CustomerName)."',
																		BillingName = '".addslashes($BillingName)."',
																		CustomerCompany = '".addslashes($CustomerCompany)."',
																		Address = '".addslashes(strip_tags($Address))."',
																		City = '".addslashes($City)."',
																		State = '".addslashes($State)."',
																		Country = '".addslashes($Country)."',
																		ZipCode = '".addslashes($ZipCode)."',
																		Mobile = '".$Mobile."',
																		Landline = '".$Landline."',
																		Fax = '".$Fax."', 
																		Email = '".addslashes($Email)."',
																		ShippingName = '".addslashes($ShippingName)."',
																		ShippingCompany = '".addslashes($ShippingCompany)."',
																		ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."',
																		ShippingCity = '".addslashes($ShippingCity)."',
																		ShippingState = '".addslashes($ShippingState)."', 
																		ShippingCountry = '".addslashes($ShippingCountry)."',
																		ShippingZipCode = '".addslashes($ShippingZipCode)."',
																		ShippingMobile = '".$ShippingMobile."', 
																		ShippingLandline = '".$ShippingLandline."',
																		ShippingFax = '".$ShippingFax."', 
																		ShippingEmail = '".addslashes($ShippingEmail)."',
																		TotalAmount = '".addslashes($TotalAmount)."',
																		TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."',
																		Freight ='".addslashes($Freight)."' ,
																		ShipFreight ='".addslashes($ShipFreight)."' ,
																		TDiscount ='".$InvoiceData['TDiscount']."',

																		taxAmnt ='".addslashes($taxAmnt)."', 
																		CreatedBy = '".addslashes($CreatedBy)."',
																		AdminID='".$AdminID."',
																		AdminType='".$AdminType."',
																		PostedDate='".$Config['TodayDate']."', 
                                    CreatedDate='".$Config['TodayDate']."',
																		UpdatedDate='".$Config['TodayDate']."',
																		ShippedDate='".$ShippedDate."',
																		wCode ='".$wCode."',
																		wName = '".addslashes($wName)."',
																		InvoiceDate ='".$InvoiceDate."',
																		InvoiceComment='".addslashes($InvoiceComment)."',
																		PaymentMethod='".addslashes($PaymentMethod)."',
																		ShippingMethod='".addslashes($ShippingMethod)."',
																		PaymentTerm='".addslashes($PaymentTerm)."',
																		Taxable='".addslashes($Taxable)."',
																		Reseller='".addslashes($Reseller)."' ,
																		ResellerNo='".addslashes($ResellerNo)."',
																		tax_auths='".addslashes($tax_auths)."',
																		Spiff='".addslashes($Spiff)."',
																		SpiffContact='".addslashes($SpiffContact)."',
																		SpiffAmount='".addslashes($SpiffAmount)."',
																		TaxRate='".addslashes($TaxRate)."',
																		CustDisType='".addslashes($CustDisType)."',
																		CustDisAmt='".addslashes($CustDiscount)."',
																		MDType='".addslashes($MDType)."',
																		MDAmount ='".addslashes($MDAmount)."',
																		MDiscount ='".addslashes($MDiscount)."',
																		ShippingMethodVal='".addslashes($ShippingMethodVal)."',
																		CustomerPO ='".addslashes($CustomerPO)."', 
																		TrackingNo ='".$TrackingNo."', 
																		ShipAccount ='".addslashes($ShipAccount)."',
																		freightTxSet='".addslashes($freightTxSet)."',
																		OrderSource='".addslashes($OrderSource)."' ,
																		Fee='".$Fee."' ,
																		OrderPaid='".$OrderPaid."' , ActualFreight='".$ActualFreight."' ,

ShippingAccountCustomer='".$ShippingAccountCustomer."',
ShippingAccountNumber='".$ShippingAccountNumber."',
FreightDiscounted='".$FreightDiscounted."',
FreightDiscount='".$InvoiceData['freightdiscount']."',
PONumber='".$PONumber."',
																		IPAddress='".$IPAddress."', EntryBy = '".$EntryBy."', AccountID = '".$AccountID."',FileName = '".$FileName."',ShipAccountNumber = '".addslashes($ShipAccountNumber)."', CountryId='".$CountryId."', StateID='".$StateID."' , CityID='".$CityID."' , ShippingCountryID='".$ShippingCountryID."' , ShippingStateID='".$ShippingStateID."', ShippingCityID='".$ShippingCityID."',EDIRefNo = '".$EDIRefNo."',EDICompId='".addslashes($EDICompId)."' ,EDICompName='".addslashes($EDICompName)."'  ";
			
	 
												$this->query($strSQLQuery, 0);
												$OrderID = $this->lastInsertId();

												/*if(empty($InvoiceID)){
												   $InvoiceID = 'IN000'.$OrderID;
												}

												$sql="UPDATE s_order SET InvoiceID='".$InvoiceID."' WHERE OrderID='".$OrderID."'";
												$this->query($sql,0);	*/

												$objConfigure = new configure();
												$objConfigure->UpdateModuleAutoID('s_order','Invoice',$OrderID,$InvoiceID); 


												$selInvoice ="select * from s_order where OrderID ='".$OrderID."' and Module='Invoice'";
												//$inv = $this->query($selInvoice, 0);	
												$inv = $this->query($selInvoice, 1);

												$InvoiceID   = $inv[0]['InvoiceID']; 
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
                         if(empty($InvoiceDate)) $InvoiceDate =  $Config['TodayDate'];
                        if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                        
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
			
			if($CustomerCurrency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR',$InvoiceDate);
			}else{   
				$ConversionRate=1;
			}
			$IPAddress = GetIPAddress();

			$strSQLQuery = "INSERT INTO s_order SET Module = 'Invoice', ConversionRate='".$ConversionRate."', EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."', OrderDate='".$OrderDate."', SaleID ='".$ReferenceNo."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."',SalesPersonType = '".$SalesPersonType."', InvoiceID = '".$InvoiceID."',
			Approved = '1',InvoiceEntry='1', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', CustomerName = '".addslashes($CustomerName)."', BillingName = '".addslashes($BillingName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',ShippingAccountCustomer = '".$ShippingAccountCustomer."',ShippingAccountNumber = '".$ShippingAccNO."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."',TDiscount ='".addslashes($TDiscount)."', taxAmnt ='".addslashes($taxAmnt)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."', AdminType='".$_SESSION['AdminType']."', PostedDate='".$Config['TodayDate']."', UpdatedDate='".$Config['TodayDate']."', CreatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$InvoiceDate."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($TaxRate)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."',MDiscount ='".addslashes($MDiscount)."',AccountID ='".addslashes($AccountID)."',ShippingMethodVal='".addslashes($ShippingMethodVal)."',CustomerPO ='".addslashes($CustomerPO)."', TrackingNo ='".addslashes($TrackingNo)."',ShipAccount ='".addslashes($ShipAccount)."',OrderSource='".addslashes($OrderSource)."',Fee='".$Fee."', IPAddress='".$IPAddress."',freightTxSet='".addslashes($freightTxSet)."', CountryId = '".$CountryId."' , StateID = '".$StateID."' , CityID = '".$CityID."' , ShippingCountryID = '".$ShippingCountryID."' , ShippingStateID = '".$ShippingStateID."' , ShippingCityID = '".$ShippingCityID."'  "; 

	
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			/*if(empty($InvoiceID)){
				$InvoiceID = 'IN000'.$OrderID;
			}

			$sql="UPDATE s_order SET InvoiceID='".$InvoiceID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);	*/

			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('s_order','Invoice',$OrderID,$InvoiceID); 



			return $OrderID;
		}
                
function UpdateARInvoiceEntry($arryDetails)
		{
                        global $Config;
			extract($arryDetails);
		 	
			if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];
                        if(empty($InvoiceDate)) $InvoiceDate =  $Config['TodayDate']; 
                        if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                        
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			if($CustomerCurrency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR',$InvoiceDate);
			}else{   
				$ConversionRate=1;
			}
			
			$addSql='';
			if(isset($CardCharge) && isset($CardChargeDate)){
				 $addSql .= ",CardCharge='".$CardCharge."', CardChargeDate='".$CardChargeDate."' ";
			 }


			$strSQLQuery = "UPDATE s_order SET EntryType='".$EntryType."', ConversionRate='".$ConversionRate."', EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."',   SaleID ='".$ReferenceNo."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', CustomerName = '".addslashes($CustomerName)."', BillingName = '".addslashes($BillingName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',	City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',ShippingAccountCustomer = '".$ShippingAccountCustomer."',ShippingAccountNumber = '".$ShippingAccNO."',

			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."',TDiscount ='".addslashes($TDiscount)."', taxAmnt ='".addslashes($taxAmnt)."', UpdatedDate='".$Config['TodayDate']."',

			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$InvoiceDate."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($TaxRate)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."',MDiscount ='".addslashes($MDiscount)."',AccountID ='".addslashes($AccountID)."',ShippingMethodVal='".addslashes($ShippingMethodVal)."',CustomerPO ='".addslashes($CustomerPO)."', TrackingNo ='".addslashes($TrackingNo)."',ShipAccount ='".addslashes($ShipAccount)."',OrderSource='".addslashes($OrderSource)."',Fee='".$Fee."',freightTxSet='".addslashes($freightTxSet)."',SalesPersonType = '".$SalesPersonType."',CountryId = '".$CountryId."' , StateID = '".$StateID."' , CityID = '".$CityID."' , ShippingCountryID = '".$ShippingCountryID."' , ShippingStateID = '".$ShippingStateID."' , ShippingCityID = '".$ShippingCityID."' ".$addSql."   where OrderID='".$OrderID."' "; 

 
			$this->query($strSQLQuery, 0);
				
			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('s_order','InvoiceID',$OrderID,$SaleInvoiceID); 

		
			return true;
		}

		function RemoveInvoiceEntryItem($OrderID){

			if($OrderID>0){
				/*********Implemented on Post to Gl*******
				$arrySaleItem = $this->GetSaleItem($OrderID);
				foreach($arrySaleItem as $values){	
					
					if($values['qty_invoiced']>0){
						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$values['sku']. "' and ItemID ='".$values['item_id']."' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);

						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+".$values['qty_invoiced'] . "  where Sku='" .$values['sku']. "' and ItemID ='".$values['item_id']."' ";
						$this->query($UpdateQtysql, 0);
						
					}
									
				}
				/******************/	
		
				$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'";
				$this->query($strSQLQuery, 0);	
			}
			return 1;

		}
	//update by chetan 9feb//
                function AddInvoiceItemForEntry($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
if(empty($OrderID)) {	
			$selInvoice ="select * from s_order where OrderID ='".$order_id."' and Module='Invoice'";
			//$inv = $this->query($selInvoice, 0);	
$inv = $this->query($selInvoice, 1);

			 $InvoiceID   = $inv[0]['InvoiceID']; 
			$arryTransaction['TransactionOrderID'] = $order_id;
			$arryTransaction['TransactionInvoiceID'] = $InvoiceID;
			$arryTransaction['TransactionDate'] = $Config['TodayDate'];;
			$arryTransaction['TransactionType'] = 'SO Invoice';

			$objItem = new items();
			$objItem->addItemTransaction($arryTransaction,$arryDetails,$type='SO');

}
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
                                        
					$sql = "insert into s_order_item(avgCost, parent_item_id, OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable,req_item,DropshipCheck, DropshipCost, SerialNumbers, `Condition`, CustDiscount, RecurringCheck, EntryType, EntryFrom, EntryTo, EntryInterval, EntryMonth, EntryWeekly, EntryDate, Org_Qty,WID, CardCharge, CardChargeDate) values('".$arryDetails['avgCost'.$i]."', '".$arryDetails['parent_ItemID'.$i]."', '".$order_id."', '".$arryDetails['item_id'.$i]."', '".$id."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."', '".addslashes($arryDetails['discount'.$i])."', '".addslashes($arryDetails['item_taxable'.$i])."' , '".addslashes($arryDetails['req_item'.$i])."','".addslashes($DropshipCheck)."','".addslashes($arryDetails['DropshipCost'.$i])."','".$serial_value."','".addslashes($arryDetails['Condition'.$i])."','".addslashes($arryDetails['CustDiscount'.$i])."','".$arryDetails['RecurringCheck'.$i]."','".$arryDetails['EntryType'.$i]."','".$arryDetails['EntryFrom'.$i]."','".$arryDetails['EntryTo'.$i]."','".$arryDetails['EntryInterval'.$i]."','".$arryDetails['EntryMonth'.$i]."','".$arryDetails['EntryWeekly'.$i]."','".$arryDetails['EntryDate'.$i]."','".$arryDetails['Org_Qty'.$i]."','".$arryDetails['WID'.$i]."' ,'".addslashes($arryDetails['CardCharge'.$i])."' ,'".addslashes($arryDetails['CardChargeDate'.$i])."')";
					$this->query($sql, 0);	
					
					$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qtyreceived = $arrRow[0]['qty_received'];
					$qtyreceived = $qtyreceived+$arryDetails['qty'.$i];
					
					$qtyinvoiced = $arrRow[0]['qty_invoiced'];
					$qtyinvoiced = $qtyinvoiced+$arryDetails['qty'.$i];
					
					$sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);





/*************CODE FOR ADD SERIAL NUMBERS******/
                                         
                if ($serial_value != '') {
                        $serial_no = explode(",",$serial_value);

                        for ($j = 0; $j < sizeof($serial_no); $j++) {
                                
$strSQL = "update inv_serial_item set UsedSerial = '1' where serialNumber='".trim($serial_no[$j])."' and `Condition`='".$arryDetails['Condition'.$i]."' and Sku ='" . trim($arryDetails['sku'.$i]) ."' and warehouse='".$arryDetails['WID'.$i]."' "; 
																$this->query($strSQL, 0);

                        }
                }
				
                                                
 /***********************END CODE**********************************************/



					/**Implemented on Post to Gl**
					if($arryDetails['qty'.$i]>0){
						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$arryDetails['qty'.$i] . "  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
						$this->query($UpdateQtysql, 0);

						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);
					}
					/******************/


	
				}
			}


	
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

                                      
                                        // edited by Amit Singh for From Date & To Date
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description,FromDate, ToDate, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable,req_item,DropshipCheck,DropshipCost,SerialNumbers,`Condition`,CustDiscount,RecurringCheck,EntryType,EntryFrom,EntryTo,EntryInterval,EntryMonth,EntryWeekly,avgCost,Org_Qty,WID) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".$id."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."','".addslashes($arryDetails['PFromDate'.$i])."','".addslashes($arryDetails['PToDate'.$i])."','".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".addslashes($arryDetails['tax_id'.$i])."', '".addslashes($arryDetails['tax'.$i])."', '".addslashes($arryDetails['amount'.$i])."', '".addslashes($arryDetails['discount'.$i])."', '".addslashes($arryDetails['item_taxable'.$i])."' , '".addslashes($arryDetails['req_item'.$i])."','".addslashes($arryDetails['DropshipCheck'.$i])."','".addslashes($arryDetails['DropshipCost'.$i])."','".trim($arryDetails['serial_value'.$i])."','".addslashes($arryDetails['Condition'.$i])."','".addslashes($arryDetails['CustDiscount'.$i])."','".$arryDetails['RecurringCheck'.$i]."','".$arryDetails['EntryType'.$i]."','".$arryDetails['EntryFrom'.$i]."','".$arryDetails['EntryTo'.$i]."','".$arryDetails['EntryInterval'.$i]."','".$arryDetails['EntryMonth'.$i]."','".$arryDetails['EntryWeekly'.$i]."','".$arryDetails['avgCost'.$i]."','".$arryDetails['Org_Qty'.$i]."','".$arryDetails['WID'.$i]."')";
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


				/**Implemented on Post to Gl****
				if($arryDetails['qty'.$i]>0){
					$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$arryDetails['qty'.$i] . "  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
					$this->query($UpdateQtysql, 0);

					$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
					$this->query($UpdateQtysql2, 0);
				}
				/******************/

/*************CODE FOR ADD SERIAL NUMBERS***********************************/
                                         
if ($arryDetails['serial_value'.$i] != '') {
        $serial_no = explode(",",trim($arryDetails['serial_value'.$i]));

        for ($j = 0; $j < sizeof($serial_no); $j++) {
                
$strSQL = "update inv_serial_item set UsedSerial = '1',OrderID ='".$order_id."',SelectType='SaleOrder' where serialNumber='".trim($serial_no[$j])."' and Sku ='" . trim($arryDetails['sku'.$i]) ."' and `Condition` ='".$arryDetails['Condition'.$i]."' and warehouse='".$arryDetails['WID'.$i]."' "; 
								$this->query($strSQL, 0);

        }
}                                              
 /***********************END CODE**********************************************/




$sqlComSelect = "select SUM(avgCost) as TotCost,parent_item_id from s_order_item where  parent_item_id>'0' and OrderID='".$order_id."' group by parent_item_id";
$arrRowCost = $this->query($sqlComSelect, 1);
if(sizeof($arrRowCost)>0){
foreach($arrRowCost as $key=>$valCom){

$updateKit = "update s_order_item set avgCost = avgCost+".$valCom['TotCost']." where  parent_item_id='0' and OrderID='".$order_id."' and item_id='".$valCom['parent_item_id']."'";
					$this->query($updateKit, 0);

}
}


$strAddConQuery  = (!empty($arryDetails['Condition'.$i]))?(" and `condition`='".addslashes($arryDetails['Condition'.$i])."' "):("");
$strAddWareQuery = (!empty($arryDetails['WID'.$i]))?(" and `WID`='".$arryDetails['WID'.$i]."'"):("");

/*********Added By bhoodev based on Condition 6 june 2016*********************/
//if($arryDetails['Condition'.$i]!=''){
					if($arryDetails['Condition'.$i]!=''){
						 $sqlCond="select count(*) as total from inv_item_quanity_condition where 
						Sku='" . addslashes($arryDetails['sku'.$i]) . "' and ItemID='" . addslashes($arryDetails['item_id'.$i]) . "'
						".$strAddConQuery." ".$strAddWareQuery." "; 
						$restbl=$this->query($sqlCond, 1);
						if($restbl[0]['total']>0){
							
							// update in tbl
							$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty-" . $arryDetails['qty'.$i] . "  where Sku='" . $arryDetails['sku'.$i] . "' ".$strAddConQuery." ".$strAddWareQuery." ";
							$this->query($UpdateQtysql, 0);
						}
					}
//}
/*********end By bhoodev based on Condition 6 june 2016*********************/


			}


		#$strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
		$strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'"; 
		$this->query($strSQL, 0);



			return true;

		}
		
		
		function  GetTotalAverageCost($id)
		{
			$sql = "SELECT sum(avgCost * qty_invoiced) as TotalAvgCost from s_order_item  where OrderID = '".$id."' and avgCost>'0' and parent_item_id='0' and DropshipCheck!='1' ";   
			$rs = $this->query($sql);

			$sqldrp = "SELECT sum(DropshipCost * qty_invoiced) as TotalAvgCost from s_order_item  where OrderID = '".$id."' and DropshipCost>'0' and parent_item_id='0' and DropshipCheck='1' ";    
			$rsdrp = $this->query($sqldrp);
			$TotalAvgCost = $rs[0]["TotalAvgCost"] + $rsdrp[0]["TotalAvgCost"];

			return $TotalAvgCost;
		}

		function  GetSubTotal($id)
		{
			$sql = "SELECT sum(amount) as SubTotal from s_order_item  where OrderID = '".$id."' ";
			$rs = $this->query($sql);
			return $rs[0]["SubTotal"];
		}

		function  GetQtyInvoiced($id)
		{
			$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty) as Qty,sum(i.avgCost) as Cost from s_order_item i where i.id='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			return $rs;
		}
		
function  GetQtyInvoicedCheck($id)
		{
			$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty) as Qty,sum(i.avgCost) as Cost, sum(i.qty_shipped) as QtyShip from s_order_item i where i.OrderID='".$id."' ";
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
			global $Config;
			if($OrderID>0){
				$objConfigure=new configure();
				$objConfig=new admin();	
				$objFunction=new functions();
 
				
				$arrySale = $this->GetSale($OrderID,'','');
				$IncomeID = $arrySale[0]['IncomeID'];	
				$InvoiceEntry = $arrySale[0]['InvoiceEntry'];
				$InvoiceID = $arrySale[0]['InvoiceID'];	
				$arrySaleItem = $this->GetSaleItem($OrderID);

				$sql = "select OrderID from s_order where InvoiceID = '".$arrySale[0]['InvoiceID']."' and Module='Shipment' ";
				$arryship =  $this->query($sql, 1);
				$shipMentID = $arryship[0]['OrderID'];

				foreach($arrySaleItem as $values){	


$objItem=new items();
$checkProduct=$objItem->checkItemSku($values["sku"]);

		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($values["sku"]);
			if(count($arryAlias))
			{
					$mainSku = $arryAlias[0]["Sku"];			
			}
		}else{

$mainSku = $values["sku"];
}


					
					if($values['qty_invoiced']>0){

						$UpdateQtysql = "update inv_item_quanity_condition set condition_qty = condition_qty+" . $values['qty_invoiced'] . "   where Sku='" .$mainSku . "' and `condition`='".addslashes($values['Condition'])."' and WID='".$values['WID']."' ";  
							$this->query($UpdateQtysql, 0);


						//$sqlupdate = "update s_order_item set qty_received = qty_received-".$values['qty_invoiced'] . ", qty_invoiced = qty_invoiced-".$values['qty_invoiced'] . ",qty_shipped =qty_shipped-".$values['qty_invoiced'] . "  where id = '".$values['ref_id']."' ";
$sqlupdate = "update s_order_item set qty_received = qty_received-".$values['qty_invoiced'] . ", qty_invoiced = qty_invoiced-".$values['qty_invoiced'] . "  where id = '".$values['ref_id']."' ";
						$this->query($sqlupdate, 0);

						/**Implemented on Post to Gl***
						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$values['sku']. "' and ItemID ='".$values['item_id']."' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);

						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+".$values['qty_invoiced'] . "  where Sku='" .$values['sku']. "' and ItemID ='".$values['item_id']."' ";
						$this->query($UpdateQtysql, 0);
						/******************/	
					}

if($values['SerialNumbers']!=''){
$serial_no = explode(",",$values['SerialNumbers' . $i]);
//$result1 =  explode ( ",", $values['serial_value'] );
 $resultSr = "'".implode ( "', '", $serial_no )."'";

$strSQL = "update inv_serial_item set UsedSerial ='0',OrderID='0' where serialNumber IN (".$resultSr.") and Sku ='" . addslashes($mainSku) ."' and `Condition` ='".$values['Condition']."' and OrderID>'0' and warehouse='".$values['WID']."'"; 

																$this->query($strSQL, 0);
}

									
				}
				



				/******Delete PDF**********/
				if($InvoiceEntry == "2" || $InvoiceEntry == "3"){
					$ModuleDepName = "SalesInvoiceGl";
				}else{
					$ModuleDepName = "SalesInvoice";
				}
				$PdfFile = $ModuleDepName.'-'.$InvoiceID.'.pdf';
				$objFunction->DeleteFileStorage($Config['S_Invoice'],$PdfFile);		
 
				$PdfTemplateArray = array('ModuleDepName' => $ModuleDepName,  'PdfDir' => $Config['S_Invoice'], 'TableName' => 's_order', 'OrderID' => $OrderID, 'ModuleID' => "InvoiceID");
				$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);

				/******Delete Document**********/
				 
				 if($arrySale[0]['UploadDocuments'] !=''){ 
					$objFunction->DeleteFileStorage($Config['S_DocomentDir'],$arrySale[0]['UploadDocuments']);	
				}
				/******Delete Multi Document**********/
				$arrayM['OrderID']=$OrderID;
				$arrayM['Module']='SalesInvoice';
				$arrayM['ModuleName']='SalesInvoice';
				$getDocumentArry=$objConfig->GetOrderDocument($arrayM);
				 
				foreach($getDocumentArry as $val) {
					if(!empty($val['FileName'])){ 
						$objFunction->DeleteFileStorage($Config['S_DocomentDir'],$val['FileName']);		
					}	
				}
				$objConfig->DeleteAllOrderDocument($arrayM);
				/*********************/



				//$strDelSQLQuery = "delete from s_order where OrderID='".$shipMentID."'"; 
				//$this->query($strDelSQLQuery, 0);


				$UpdateQtysql2 = "update w_shipment set RefID='',GenrateShipInvoice='0',ShipmentStatus='Picked'  where ShippedID ='".$shipMentID."' ";
				$this->query($UpdateQtysql2, 0);

				$UpdateQtysql3 = "update s_order set InvoiceID=''  where OrderID ='".$shipMentID."' ";
				$this->query($UpdateQtysql3, 0);

				$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
				$this->query($strSQLQuery, 0);	
				 

				$strSQLQueryC = "delete from s_order_card where OrderID='".$OrderID."'"; 
				$this->query($strSQLQueryC, 0);	


				if($IncomeID>0){
					$strSQLQuery = "delete from f_income where IncomeID='".$IncomeID."'"; 
					$this->query($strSQLQuery, 0);

					$strSQLQuery = "delete from f_multi_account where IncomeID='".$IncomeID."'"; 
					$this->query($strSQLQuery, 0);	
				}

				


			}
			return 1;

		}


		function RemoveCreditNote($OrderID){ 
			global $Config;
			$objFunction=new functions();
			$objConfig=new admin();	
			if($OrderID>0){ 
				$arrySale = $this->GetSale($OrderID,'','');			
				$CreditID = $arrySale[0]['CreditID'];			
				

				/******Delete PDF**********/			 
				$PdfFile = 'SalesCreditMemo'.'-'.$CreditID.'.pdf';
				$objFunction->DeleteFileStorage($Config['S_Credit'],$PdfFile);	

				$PdfTemplateArray = array('ModuleDepName' => "SalesCreditMemo",  'PdfDir' => $Config['S_Credit'], 'TableName' => 's_order', 'OrderID' => $OrderID, 'ModuleID' => "CreditID");
			$objConfig->DeleteAllPdfTemplate($PdfTemplateArray);	
				/*********************/	
			

				$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
				$this->query($strSQLQuery, 0);	

				
			}
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
		   $strSQLQuery = "update s_order set Status = 'Completed' where SaleID='".$SaleID."' and Module='Order' ";
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

	 
		
		
	 function ReturnOrder($arryDetails,$db='')	{
			global $Config;
			extract($arryDetails);
			$arrySale = $this->GetSale($ReturnOrderID,'','',$db);
			$arrySale[0]["Module"] = "Return";
			$arrySale[0]["ModuleID"] = "ReturnID";
			$arrySale[0]["PrefixSale"] = "RTN";
			$arrySale[0]["ReturnID"] = $ReturnID;
			$arrySale[0]["ReturnDate"] = $ReturnDate;
			$arrySale[0]["Freight"] = $Freight;
			$arrySale[0]["taxAmnt"] = $taxAmnt;
			$arrySale[0]["TotalAmount"] = $TotalAmount;	
			$arrySale[0]["ReturnPaid"] = $ReturnPaid;	
			$arrySale[0]["ReturnComment"] = $ReturnComment;	
			/*$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	
			$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	*/
			$order_id = $this->AddReturnOrder($arrySale[0],$db);


			/******** Item Updation for Return ************/
			$arryItem = $this->GetSaleItem($ReturnOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id) && $arryDetails['qty'.$i]>0){
					$qty_returned = $arryDetails['qty'.$i];
                                        $SerialNumbers = $arryDetails['serial_value'.$i];
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount, Taxable, req_item,SerialNumbers,`Condition`,CustDiscount,WID) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['received_qty'.$i])."', '".addslashes($arryDetails['received_qty'.$i])."','".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$SerialNumbers."','".$arryDetails['Condition'.$i]."','".$arryDetails['CustDiscount'.$i]."','".$arryDetails['WID'.$i]."')";

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
		
		function AddReturnOrder($arryDetails,$db=''){
		
		    global $Config;
		    
			extract($arryDetails);
			 		 	
			$strSQLQuery = "INSERT INTO ".$db."s_order SET Module = '".$Module."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmnt)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."', ReturnID = '".$ReturnID."', ReturnDate='".$ReturnDate."',ReturnPaid='".$ReturnPaid."',ReturnComment='".addslashes($ReturnComment)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."' ,tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($TaxRate)."' ";
			//echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			if(empty($ReturnID)){
				$ReturnID = 'RTN000'.$OrderID;
			}

			$sql="UPDATE ".$db."s_order SET ReturnID='".$ReturnID."' WHERE OrderID='".$OrderID."'";
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
			where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			return 1;
		}
		
			function isReturnExists($ReturnID,$OrderID=0)
			{
				$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
				$strSQLQuery = "select OrderID from s_order where Module='RMA' and ReturnID='".trim($ReturnID)."'".$strSQLQuery;
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
							$TemplateID=51;
						}else if($module=='Order'){
							$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
							$TemplateID=52;
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
						
						
						/**********************/
						$htmlPrefix = $Config['EmailTemplateFolder'];				
						//$contents = file_get_contents($htmlPrefix."sales_auth.htm");
						$objConfigure = new configure();
						
						$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
                        			$contents = $TemplateContent[0]['Content'];

						
						$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
						$contents = str_replace("[URL]",$Config['Url'],$contents);
						$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
						$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
						$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

						 
						$contents = str_replace("[ACTION]",$Action,$contents);
						 
						$contents = str_replace("[QUOTE_NUMBER]",$arrySale[0][$ModuleID],$contents);					$contents = str_replace("[ORDER_NUMBER]",$arrySale[0][$ModuleID],$contents);
						$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
						$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
						$contents = str_replace("[ORDER_STATUS]",$arrySale[0]['Status'],$contents);
						$contents = str_replace("[SALES_PERSON]",$SalesPerson,$contents);
							
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($ToEmail);
						if(!empty($CC)) $mail->AddAddress($CC);
						$mail->sender($Config['SiteName'], $Config['AdminEmail']);   

//$TemplateContent[0]['subject']  
						$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
						$mail->IsHTML(true);
						$mail->Body = $contents;  
						//echo $mail->Subject.' <br> '. $contents;exit;
						if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
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
					$TemplateID=53;
				}else if($module=='Order'){
					$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID";
					$TemplateID=54;
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
					//$contents = file_get_contents($htmlPrefix."sales_assigned.htm");
					
					$objConfigure = new configure();
					$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
                     			$contents = $TemplateContent[0]['Content'];

					$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

					$contents = str_replace("[QUOTE_NUMBER]",$arrySale[0][$ModuleID],$contents);				$contents = str_replace("[ORDER_NUMBER]",$arrySale[0][$ModuleID],$contents);
					$contents = str_replace("[MODULE_ID]",$arrySale[0][$ModuleID],$contents);
					$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
					$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
					$contents = str_replace("[ORDER_STATUS]",$arrySale[0]['Status'],$contents);
					//$contents = str_replace("[ORDER_TYPE]",$arrySale[0]['OrderType'],$contents);
					$contents = str_replace("[SALES_PERSON]",$arryEmp[0]['UserName'],$contents);
						
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($ToEmail);
					if(!empty($CC)) $mail->AddCC($CC);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
					$mail->IsHTML(true);
					$mail->Body = $contents;  
					//echo $mail->Subject.'<br>'.$contents;exit;
					if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
						$mail->Send();	
					}
				}



			}

			return 1;
		}
		
		function sendSalesEmail($OrderID)
		{
			global $Config;	
			
				//print_r($Config);
			if($OrderID>0){
				$arrySale = $this->GetSale($OrderID,'','');
				$module = $arrySale[0]['Module'];
				 
				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $TemplateID=55;
				}else if($module=='Order'){
					$ModuleIDTitle = "SO Number"; $ModuleID = "SaleID"; $TemplateID=56;
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
				//$contents = file_get_contents($htmlPrefix."sales_admin.htm");
				$objConfigure = new configure();
				$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
             			$contents = $TemplateContent[0]['Content'];

				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[QUOTE_NUMBER]",$arrySale[0][$ModuleID],$contents);			$contents = str_replace("[ORDER_NUMBER]",$arrySale[0][$ModuleID],$contents);
				$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
				$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
				$contents = str_replace("[Approved]",$Approved,$contents);
				$contents = str_replace("[ORDER_STATUS]",$arrySale[0]['Status'],$contents);
				$contents = str_replace("[SALES_PERSON]",$SalesPerson,$contents);
				$contents = str_replace("[COMMENT]",$Comment,$contents);
				$contents = str_replace("[DeliveryDate]",$DeliveryDate,$contents);
				$contents = str_replace("[PaymentTerm]",$PaymentTerm,$contents);
				$contents = str_replace("[PaymentMethod]",$PaymentMethod,$contents);
				$contents = str_replace("[ShippingMethod]",$ShippingMethod,$contents);
				//$contents = str_replace("[AssignedEmp]",$AssignedEmp,$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($CC)) $mail->AddCC($CC);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				#echo "To->".$Config['AdminEmail']."=CC=>".$mail->Subject.$contents; exit;
				if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
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
					$mail->Send();	  //NOT IN USE NOW
				}

			}

			return 1;
		}
			
			//End Email Code
			
			
	  function  ListCreditNote($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$strAddQuery = " where o.Module='Credit' and OverPaid='0' ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'  "):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."' "):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby=='o.CustomerName'){
				$strAddQuery .= (!empty($SearchKey))?(" and (o.CustomerName like '%".$SearchKey."%' or c.Company like '%".$SearchKey."%'  or c.FullName like '%".$SearchKey."%' )"):("");
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.CreditID like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.CustomerCompany like '%".$SearchKey."%'  or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' ) " ):("");	
			}
			$strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
			
			if(!empty($Status)){
				$strAddQuery .= " and o.Status='".$Status."'";
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");
			
			if(!empty($fby)){ //search
				$DateColumn = "o.PostedDate";
				if($fby=='Year'){
					$strAddQuery .= " and YEAR(".$DateColumn.")='".$y."'";
				}else if($fby=='Month'){
					$strAddQuery .= " and MONTH(".$DateColumn.")='".$m."' and YEAR(".$DateColumn.")='".$y."'";
				}else{
					$strAddQuery .= (!empty($f))?(" and ".$DateColumn.">='".$f."'"):("");
					$strAddQuery .= (!empty($t))?(" and ".$DateColumn."<='".$t."'"):("");
				}
			}


			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";
				
			}else{
				 
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by o.PostToGL asc,o.PostedDate desc,o.OrderID desc ");

				$Columns = "  o.*, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName,  if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy  ";
				if($Config['RecordsPerPage']>0)$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
			}


			#$strSQLQuery = "select o.ClosedDate, o.OrderDate, o.PostedDate, o.OrderID, o.SaleID, o.CreditID, o.CustomerName, o.CustCode, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency from s_order o ".$strAddQuery;
			 $strSQLQuery = "select ".$Columns." from s_order o left outer join s_customers c on o.CustCode=c.CustCode left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee') ".$strAddQuery;
		
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
					$ModuleIDTitle = "Quote Number"; $ModuleID = "QuoteID"; $TemplateID=57;
				}else if($module=='Order'){
					$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID"; $TemplateID=58;
				}else if($module=='Credit'){
					$ModuleIDTitle = "Credit Note ID"; $ModuleID = "CreditID"; $module = "Credit Memo";
					$TemplateID=59;
				}else if($module=='Invoice'){
					$ModuleIDTitle = "Invoice ID"; $ModuleID = "InvoiceID"; $module = "Invoice";
					$TemplateID=60;


					/************/
					$InvoicePaid = $arrySale[0]['InvoicePaid'];
  					if($InvoicePaid=='Unpaid' && $arrySale[0]['PaymentTerm']=='Credit Card' && ($arrySale[0]['OrderPaid']==1 || $arrySale[0]['OrderPaid']==3)){
						$InvoicePaid = 'Paid';
					}
					/************/

				}else if($module=='RMA'){
					$ModuleIDTitle = "Sales RMA Number"; $ModuleID = "SaleID"; $TemplateID=79;
				}


				if($arrySale[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arrySale[0]['CreatedBy']);
				}
				
				$OrderDate = ($arrySale[0]['OrderDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['OrderDate']))):(NOT_SPECIFIED);
				$InvoiceDate = ($arrySale[0]['InvoiceDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['InvoiceDate']))):(NOT_SPECIFIED);
				$Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

				$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_SPECIFIED);

				$PaymentTerm = (!empty($arrySale[0]['PaymentTerm']))? (stripslashes($arrySale[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$PaymentMethod = (!empty($arrySale[0]['PaymentMethod']))? (stripslashes($arrySale[0]['PaymentMethod'])): (NOT_SPECIFIED);
				$ShippingMethod = (!empty($arrySale[0]['ShippingMethod']))? (stripslashes($arrySale[0]['ShippingMethod'])): (NOT_SPECIFIED);
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				#$CreatedBy = ($arrySale[0]['AdminType'] == 'admin')? ('Administrator'): ($arrySale[0]['CreatedBy']);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				//$contents = file_get_contents($htmlPrefix."sales_cust.htm");
				$objConfigure = new configure();
				$TemplateContent = $objConfigure->GetTemplateContent($TemplateID, 1);
       			$contents = $TemplateContent[0]['Content'];

				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
                 /**by sachin **/
				$mailsing=$Config['MailFooter'];
                if(!empty($footerSingnature)){
                  $mailsing=$footerSingnature;
                }
                /**by sachin **/
				$contents = str_replace("[FOOTER_MESSAGE]",$mailsing,$contents);


				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[QUOTE_NUMBER]",$arrySale[0][$ModuleID],$contents);			
        //$contents = str_replace("[ORDER_NUMBER]",$arrySale[0][$ModuleID],$contents);
			if($module == 'RMA'){					;
					$contents = str_replace("[ORDER_NUMBER]",$arrySale[0]['ReturnID'],$contents);
				}else{
					$contents = str_replace("[ORDER_NUMBER]",$arrySale[0][$ModuleID],$contents);
					
				}		
				$contents = str_replace("[CREDIT_MEMO_NUMBER]",$arrySale[0][$ModuleID],$contents);
				$contents = str_replace("[INVOICE_NUMBER]",$arrySale[0][$ModuleID],$contents);
				$contents = str_replace("[ORDER_DATE]",$OrderDate,$contents);
				$contents = str_replace("[INVOICE_DATE]",$InvoiceDate,$contents);
				$contents = str_replace("[CREATED_BY]",$CreatedBy,$contents);
				$contents = str_replace("[APPROVED]",$Approved,$contents);
				$contents = str_replace("[ORDER_STATUS]",$arrySale[0]['Status'],$contents);
				$contents = str_replace("[INVOICE_STATUS]",$InvoicePaid,$contents);
				$contents = str_replace("[ORDER_TYPE]",$arrySale[0]['OrderType'],$contents);
				$contents = str_replace("[MESSAGE]",$Message,$contents);
				$contents = str_replace("[DELIVERY_DATE]",$DeliveryDate,$contents);
				$contents = str_replace("[PAYMENT_TERM]",$PaymentTerm,$contents);
				$contents = str_replace("[PAYMENT_METHOD]",$PaymentMethod,$contents);
				$contents = str_replace("[SHIPPING_METHOD]",$ShippingMethod,$contents);
				$contents = str_replace("[CUSTOMER_NAME]",stripslashes($arrySale[0]['CustomerName']),$contents);
				//if($module == 'RMA'){$TemplateContent[0]['subject']='Sales RMA';}
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
       			$senderEmail=$Config['AdminEmail'];
       			if($_SESSION['AdminType']=='employee'){$senderEmail=$_SESSION['EmpEmail'];  }

				$mail->sender($_SESSION['UserName'], $senderEmail);   
				$mail->Subject = $Config['SiteName']." :: ".$TemplateContent[0]['subject'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				
				//if($_GET['pk']==1){echo $ToEmail.$CCEmail.$Config['AdminEmail'].$mail->Subject.$contents; exit;}
				if($Config['Online'] == 1 && $TemplateContent[0]['Status'] == 1) {
					$mail->Send();	
				}
				//if($_GET['pk']==1){echo $Attachment.'#'.$ToEmail.$CCEmail.$Config['AdminEmail'].$mail->Subject.$contents; exit;}
				/***********/
				$strSQL = "update s_order set MailSend ='1' where OrderID='" . $OrderID . "'";
				$this->query($strSQL, 0); 
				/***********/

                                if($DefaultEmailConfig=='1') {
                                   $objImportEmail=new email();
                                   //echo $Attachment;die;
                                    if (!file_exists($output_dir)) {
                                        mkdir($output_dir, 0777);
            
                                    }
        
                                   if(copy($Attachment,$output_dir.$ConvetFilename))
                                        {
                                           chmod($output_dir.$ConvetFilename, 777);
                                           //$_SESSION['attcfile'][$fileName]=$fileName;

                                           //$save_var='Saved';

                                        }
                                        if(!empty($CCEmail)) {
                                            $CCEmaill=$CCEmail;
                                                    
                                        }
                                   $arrayForImportedEmail=array('OwnerEmailId'=>$_SESSION['AdminEmail'],'emaillistID'=>'','Subject'=>$Config['SiteName']." - Sales ".$module." # ".$arrySale[0][$ModuleID],'EmailContent'=>$Message,'Recipient'=>$ToEmail,'Cc'=>$CCEmaill,'Bcc'=>'','FromEmail'=>$OwnerEmailId,'TotalRecipient'=>'','MailType'=>'Sent','Action'=>'SendFromPurchage','ActionMailId'=>'','AdminId'=>$_SESSION['AdminID'],'ImportedDate'=>$_SESSION['TodayDate'],'FromDD'=>$Config["AdminEmail"],'AdminType'=>$_SESSION['AdminType'],'CompID'=>$_SESSION['CmpID'],'From_Email'=>$Config["AdminEmail"],'To_Email'=>$ToEmail,'composedDate'=>'','OrgMailType'=>'Sent','FileName'=>$ConvetFilename);
                                   $objImportEmail->SaveSentEmailForVendorCustomer($arrayForImportedEmail);
                               }
				
					 

			}

			return 1;
		}



 /****************Recurring Function Satrt************************************/  
   function RecurringInvoice(){    
	global $Config;
	
	//$Config['TodayDate'] = '2016-05-15 12:08:09';
	
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
				}//echo $value['InvoiceID'];exit;
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

                $sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable,req_item,DropshipCheck,DropshipCost,`Condition`,CustDiscount,RecurringCheck,EntryType,EntryFrom,EntryTo,EntryInterval,EntryMonth,EntryWeekly,WID) values('" . $order_id . "', '" . $values['item_id' ] . "', '" .$id . "', '" . addslashes($values['sku' ]) . "', '" . addslashes($values['description' ]) . "', '" . addslashes($values['on_hand_qty' ]) . "', '" . addslashes($values['qty' ]) . "', '" . addslashes($values['qty_received' ]) . "', '" . addslashes($values['qty_invoiced' ]) . "', '" . addslashes($values['price' ]) . "', '" . addslashes($values['tax_id' ]) . "', '" . addslashes($values['tax' ]) . "', '" . addslashes($values['amount' ]) . "', '" . addslashes($values['discount' ]) . "', '" . addslashes($values['Taxable' ]) . "' , '" . addslashes($values['req_item' ]) . "','" . addslashes($values['DropshipCheck' ]) . "','" . addslashes($values['DropshipCost' ]) . "','" . addslashes($values['Condition' ]) . "','".$arryDetails['CustDiscount'.$i]."','".$arryDetails['RecurringCheck'.$i]."','".$arryDetails['EntryType'.$i]."','".$arryDetails['EntryFrom'.$i]."','".$arryDetails['EntryTo'.$i]."','".$arryDetails['EntryInterval'.$i]."','".$arryDetails['EntryMonth'.$i]."','".$arryDetails['EntryWeekly'.$i]."','".$arryDetails['WID'.$i]."')";
		
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
			if(!empty($values['sku'])){
			          
				/*$FromDate=''; $ToDate=''; 
				if($values['FromDate']>0 && $values['ToDate']>0){

					$date1 = new DateTime($values['FromDate']);
					$date2 = new DateTime($values['ToDate']);
					$diff = $date2->diff($date1)->format("%a");

					$FromDate=date('Y-m-d',strtotime($values['ToDate']."+1 days"));
					$ToDate=date('Y-m-d',strtotime($FromDate."+$diff days"));
				}*/

				$sql = "insert into s_order_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, discount, Taxable, req_item, DropshipCheck, DropshipCost, SerialNumbers,`Condition`, CustDiscount , FromDate, ToDate,RecurringCheck,EntryType,EntryFrom,EntryTo,EntryInterval,EntryMonth,EntryWeekly,WID) values('".$order_id."', '".$values['item_id']."', '".addslashes($values['sku'])."', '".addslashes($values['description'])."', '".addslashes($values['on_hand_qty'])."', '".addslashes($values['qty'])."', '".addslashes($values['price'])."', '".addslashes($values['tax_id'])."', '".addslashes($values['tax'])."', '".addslashes($values['amount'])."','".addslashes($values['discount'])."' ,'".addslashes($values['Taxable'])."' ,'".addslashes($values['req_item'])."','".addslashes($values['DropshipCheck'])."','".addslashes($values['DropshipCost'])."','".addslashes($values['SerialNumbers'])."','".addslashes($values['Condition'])."','".addslashes($values['CustDiscount'])."','".addslashes($FromDate)."','".addslashes($ToDate)."','".$arryDetails['RecurringCheck'.$i]."','".$arryDetails['EntryType'.$i]."','".$arryDetails['EntryFrom'.$i]."','".$arryDetails['EntryTo'.$i]."','".$arryDetails['EntryInterval'.$i]."','".$arryDetails['EntryMonth'.$i]."','".$arryDetails['EntryWeekly'.$i]."','".$arryDetails['WID'.$i]."')";		
			
				$this->query($sql, 0);	
				//echo $sql;exit;
			}
		}  

		/*
		 $strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'"; 
		$this->query($strSQL, 0);*/

		return true;

	}

       

	function RemoveSaleRecurring($id){	
		$EntryType = 'one_time';
		 $strSQL = "update s_order_item set EntryType ='".$EntryType."' , EntryDate='', EntryFrom='',EntryTo='',EntryInterval='',EntryMonth='',EntryWeekly='',RecurringCheck='' where id='".$id."'"; 

		$this->query($strSQL, 0);
 
		return true;

	}

	function RemoveInvoiceRecurring($OrderID, $id){	
		$EntryType = 'one_time';
		if($OrderID>0){
			if($id>0){
				 $strSQL = "update s_order_item set EntryType ='".$EntryType."' , EntryDate='', EntryFrom='', EntryTo='', EntryInterval='',EntryMonth='',EntryWeekly='', RecurringCheck='', RecurringAmount='', RecurringQty='',RecurringPrice='' where id='".$id."'"; 
				$this->query($strSQL, 0);
			}else{
				 $strSQL = "update s_order set EntryType ='".$EntryType."' , EntryDate='', EntryFrom='', EntryTo='', EntryInterval='',EntryMonth='', EntryWeekly=''  where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
			}
		}
 
		return true;

	}

	function UpdateSaleRecurring($arryDetails){	
		extract($arryDetails);
		 $strSQL = "update s_order_item set EntryType='".$EntryType."',  EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."' where OrderID='".$OrderID."' and id='".$EditID."' "; 
		$this->query($strSQL, 0);

		return true;

	}
	function UpdateInvoiceRecurring($arryDetails){	
		extract($arryDetails);
		if($OrderID>0){
			if($id>0){
				 $addSql = "";
				 if(isset($RecurringAmount)){
					 $addSql .= ",RecurringQty='".$RecurringQty."', RecurringPrice='".$RecurringPrice."', RecurringAmount='".$RecurringAmount."'";
				 }

				  if(isset($CardCharge) && isset($CardChargeDate)){
					 $addSql .= ",CardCharge='".$CardCharge."', CardChargeDate='".$CardChargeDate."' ";
				 }
				 $strSQL = "update s_order_item set EntryType='".$EntryType."',  EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."' ".$addSql." where OrderID='".$OrderID."' and id='".$id."' "; 
				 
			}else{
				 $strSQL = "update s_order set EntryType='".$EntryType."',  EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."' where OrderID='".$OrderID."'  "; 
			}
			$this->query($strSQL, 0);	
		}
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
			$strAddQuery = " where so.id>0 and so.sku!='' ";
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

			$strAddQuery .= (!empty($EntryType))?(" and so.EntryType='".$EntryType."'"):("");

			if(!empty($Status)){
				$strAddQuery .= " and o.Status='".$Status."'";
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}
			
			
			if(!empty($ToApprove)){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}
			
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.ReturnID = '' and o.Status != 'Cancelled'"):(" ");
			$strAddQuery .= (!empty($InvoiceID))?(" group by SaleID"):(" ");
			
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.CustomerName asc,  o.".$moduledd."Date desc,o.".$moduledd."Date desc, o.OrderID desc ");
			
			
			if($Config['GetNumRecords']==1){
				$Columns = " count(so.OrderID) as NumCount ";				
			}else{				
				$Columns = " o.CustCode, o.CustomerName, o.CustomerCurrency,o.Module, o.TaxRate, o.freightTxSet, o.Freight, o.TDiscount, o.TotalAmount , o.taxAmnt, so.*  ";
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}			
			}
			
		
		        $strSQLQuery = "select ".$Columns." from s_order_item so inner join s_order o on so.OrderID=o.OrderID " . $strAddQuery;
			  
 			// echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
				
		}


	function  ListRecurringInvoice($arryDetails)
		{
			global $Config;
			extract($arryDetails);
 
			$moduledd = 'Invoice';
			$strAddQuery = " where 1";

			

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
			$strAddQuery .= " and o.InvoiceID != '' and o.ReturnID = ''";
			
			$strAddQuery .= (!empty($InvoicePaid))?(" and o.InvoicePaid='".$InvoicePaid."'"):("");
			if(!empty($Status)){
				$strAddQuery .= " and o.Status='".$Status."'";
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}

			$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");
			$SoColumns ='';
			if($type == "GL"){
				$strAddQuery .= (!empty($EntryInterval))?(" and o.EntryInterval='".$EntryInterval."'"):("");
				$strAddQuery .= " and o.InvoiceEntry in ('2','3') ";
				$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");
				$FromTable = " from s_order o "; 
			}else{
				$strAddQuery .= (!empty($EntryInterval))?(" and so.EntryInterval='".$EntryInterval."'"):("");
				$strAddQuery .= " and o.InvoiceEntry in ('0','1') and so.id>'0' and so.sku!='' ";
				$strAddQuery .= (!empty($EntryType))?(" and so.EntryType='".$EntryType."'"):("");
				$SoColumns = " ,so.*, cd.CardType, DECODE(cd.CardNumber,'". $Config['EncryptKey']."') as CardNumber,cd.ExpiryMonth,cd.ExpiryYear, cd.RecurringCardInfo  ";
				$FromTable = " from s_order_item so inner join s_order o on so.OrderID=o.OrderID left outer join s_order_card cd on o.OrderID=cd.OrderID  ";
			}
			
  
			$pre = ($type == "GL") ? 'o' : 'so';
			$todate = explode(" ", $Config['TodayDate']);
			if($status == 'Active'){				
				$strAddQuery .=  " and (year(".$pre.".EntryTo) = '0' or  ".$pre.".EntryTo >= '".$todate[0]."') ";
			}else{				 
				$strAddQuery .=  " and (".$pre.".EntryTo < '".$todate[0]."' and year(".$pre.".EntryTo) > '0' ) ";
			} 


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by CustomerName asc, o.OrderID desc ");
			 

			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{		
				$Columns = "  o.OrderID, o.InvoiceID, o.SaleID, o.CustCode, o.TotalInvoiceAmount, o.CustomerCurrency, o.ConversionRate, o.StatusMsg, o.PaymentTerm , o.InvoicePaid, o.InvoiceDate,o.InvoiceEntry, o.EntryType, o.PostToGLDate, o.PostToGL, o.EntryInterval, o.EntryDate, o.EntryMonth, o.EntryWeekly, o.EntryFrom, o.EntryTo, o.CustomerName as OrderCustomerName, IF(c.CustomerType = 'Company' and c.Company!='', Company, FullName) as CustomerName   ".$SoColumns;
		
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

			$strSQLQuery = "select ".$Columns."  ".$FromTable." left outer join s_customers c on o.CustCode=c.CustCode ".$strAddQuery;
		
		 	// echo $strSQLQuery;
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



	 /*************Start Reseller Default Invoice & Payment Entry ***************/
        
    function basicInv($order_id,$arryDetails) {    
       $currentDt=date("Y-m-d h:i:s");
        $sqlInventry = "select ItemID,Sku from inv_items WHERE Sku='".$arryDetails['PaymentPlan']."'";
        $arryChkInvt = $this->query($sqlInventry, 1);
         $countINV=sizeof($arryChkInvt);
        
        if($countINV<=0){
          $strSQLQuery = "INSERT INTO inv_items set Sku = '" . $arryDetails['PaymentPlan'] . "',
        description='" . $arryDetails['PaymentPlan'] . "',
        non_inventory='No',
        Status='1',
        AddedDate='".$currentDt."',
        LastAdminType='".$_SESSION['AdminType']."',
        LastCreatedBy='".$_SESSION['DisplayName']."'"; 
        $this->query($strSQLQuery, 0);
        
        $ItemID=mysql_insert_id();
        $Sku=$arryDetails['PaymentPlan'];
        }else{
        $ItemID=$arryChkInvt[0]['ItemID'];
        $Sku=$arryChkInvt[0]['Sku'];    
        
        }
        
    $sql = "insert into s_order_item(OrderID,item_id,sku, description, on_hand_qty, qty,price, amount) 
    values
    ('".$order_id."', '".$ItemID."', '".$Sku."', '".$arryDetails['PaymentPlan']."', '0', '1', '".$arryDetails['TotalAmount']."', '".$arryDetails['TotalAmount']."')";
    $this->query($sql, 0);
   }
    
    
    
    function GenerateInVoiceEntryUI($arryDetails)
    {
        global $Config;
        $currentDate=date("Y-m-d h:i:s");
      $IPAddress = GetIPAddress();
             /*varible for s_order  table*/
        
            $EntryType='one_time';
            $City = $arryDetails['customer_city'];
            $State = $arryDetails['customer_state'];
            $Country = $arryDetails['country_id'];
            $ZipCode = $arryDetails['customer_zip'];
            $Email=$arryDetails['customer_email_id'];
            $TotalAmount=$arryDetails['TotalAmount'];
            $PaymentMethod='Electronic Transfer';
            $CustomerCompany=$arryDetails['CompanyName'];
            $Address = $arryDetails['customer_address1'].' '.$arryDetails['customer_address2'];
            $CustomerName=$arryDetails['customer_first_name'].' '.$arryDetails['customer_last_name'];
            $BillingName=$arryDetails['customer_first_name'].' '.$arryDetails['customer_last_name'];
            
            $ShippingName=$arryDetails['customer_first_name'].' '.$arryDetails['customer_last_name'];
            $ShippingAddress=$arryDetails['customer_address1'].' '.$arryDetails['customer_address2'];
            $ShippingCity=$arryDetails['customer_city'];
            $ShippingState=$arryDetails['customer_state'];
            $ShippingCountry=$arryDetails['country_id'];
            $ShippingZipCode=$arryDetails['customer_zip'];
            $ShippingEmail=$arryDetails['customer_email_id'];
            $ShippingCompany=$arryDetails['CompanyName'];

	$InvoiceComment= 'MaxUser: '.$arryDetails['MaxUser'];
	if(!empty($arryDetails['AdditionalSpace'])) 
		$InvoiceComment.= ', AdditionalSpace: '.$arryDetails['AdditionalSpace'].' '.$arryDetails['AdditionalSpaceUnit'];
	if(!empty($arryDetails['CouponCode']))
		$InvoiceComment.= ', CouponCode: '.$arryDetails['CouponCode'];

            /* end here */
            $objCustomer=new Customer();
          $sqlCustCheck = "select Cid,CustCode from s_customers where Email='".$Email."'";
    
        $arryCustCheck = $this->query($sqlCustCheck, 1);
        

        if(empty($arryCustCheck[0]['Cid'])){
         /*varible for opportunity start here*/
            $arryOpp['FirstName'] = $arryDetails['customer_first_name'];
            $arryOpp['LastName'] =  $arryDetails['customer_last_name'];
            $arryOpp['Email'] =  $arryDetails['customer_email_id'];
            $arryOpp['Company'] = $arryDetails['CompanyName'];
            $arryOpp['CustomerType'] = 'Company';
    
            /*  varible for opportunity end here */
             $CustID =  $objCustomer->addCustomer($arryOpp);
   
        $sqlCCode = "select Cid,CustCode from s_customers where Cid='".$CustID."'";
        $arryCusC = $this->query($sqlCCode, 1);
        $CustCode=$arryCusC[0]['CustCode'];
        //$CustID=$arryCusC[0]['CustCode'];
            //$arryQuote[0]['CustID'] = $OppCustID;
        }else{
            
            //$arryQuote[0]['CustID'] = $arryCustCheck[0]['Cid'];
            $CustCode=$arryCustCheck[0]['CustCode'];
            $CustID=$arryCustCheck[0]['Cid'];    
            
        }
        if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];
            $EntryType='one_time';
            $strSQLQuery = "INSERT INTO s_order SET Module = 'Invoice', 
            EntryType='".$EntryType."', 
            EntryInterval='".$EntryInterval."',
            EntryMonth='".$EntryMonth."', 
            EntryWeekly = '".$EntryWeekly."', 
            EntryFrom='".$EntryFrom."',
            EntryTo='".$EntryTo."',
            EntryDate='".$EntryDate."', 
            OrderDate='".$currentDate."', 
            SaleID ='".$ReferenceNo."', 
            QuoteID = '".$QuoteID."', 
            SalesPersonID = '".$SalesPersonID."', 
            SalesPerson = '".addslashes($SalesPerson)."', 
            InvoiceID = '".$InvoiceID."',
            Approved = '1',InvoiceEntry='1', 
            Status = '".$Status."', 
            DeliveryDate = '".$DeliveryDate."', 
            Comment = '".addslashes($Comment)."', 
            CustCode='".addslashes($CustCode)."', 
            CustID = '".$CustID."', 
            CustomerCurrency = '".addslashes($CustomerCurrency)."', 
            CustomerName = '".addslashes($CustomerName)."', 
            BillingName = '".addslashes($BillingName)."', 
            CustomerCompany = '".addslashes($CustomerCompany)."', 
            Address = '".addslashes(strip_tags($Address))."',
            City = '".addslashes($City)."',
            State = '".addslashes($State)."', 
            Country = '".addslashes($Country)."', 
            ZipCode = '".addslashes($ZipCode)."', 
            Mobile = '".$Mobile."', 
            Landline = '".$Landline."', 
            Fax = '".$Fax."', 
            Email = '".addslashes($Email)."',
            ShippingName = '".addslashes($ShippingName)."', 
            ShippingCompany = '".addslashes($ShippingCompany)."', 
            ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', 
            ShippingCity = '".addslashes($ShippingCity)."',
            ShippingState = '".addslashes($ShippingState)."', 
            ShippingCountry = '".addslashes($ShippingCountry)."', 
            ShippingZipCode = '".addslashes($ShippingZipCode)."', 
            ShippingMobile = '".$ShippingMobile."', 
            ShippingLandline = '".$ShippingLandline."', 
            ShippingFax = '".$ShippingFax."', 
            ShippingEmail = '".addslashes($ShippingEmail)."',
            TotalAmount = '".addslashes($TotalAmount)."', 
            TotalInvoiceAmount = '".addslashes($TotalAmount)."', 
            Freight ='".addslashes($Freight)."', 
            taxAmnt ='".addslashes($taxAmnt)."', 
            CreatedBy = '".addslashes($_SESSION['UserName'])."', 
            AdminID='".$_SESSION['AdminID']."',
            AdminType='".$_SESSION['AdminType']."',
            PostedDate='".$currentDate."',
            UpdatedDate='".$currentDate."',
            ShippedDate='".$ShippedDate."', 
            wCode ='".$wCode."', 
            wName = '".addslashes($wName)."', 
            InvoiceDate ='".$currentDate."', 
            InvoiceComment='".addslashes($InvoiceComment)."',
            InvoicePaid='Paid',
            PaymentMethod='".addslashes($PaymentMethod)."',
            ShippingMethod='".addslashes($ShippingMethod)."',
            PaymentTerm='".addslashes($PaymentTerm)."',
            Taxable='".addslashes($Taxable)."',
            Reseller='".addslashes($Reseller)."' ,
            ResellerNo='".addslashes($ResellerNo)."',
            tax_auths='".addslashes($tax_auths)."', 
            TaxRate='".addslashes($TaxRate)."',
            RsID='".$_SESSION['CrmRsID']."',
		CustomerPO ='".addslashes($CustomerPO)."',
		TrackingNo ='".addslashes($TrackingNo)."',
		ShipAccount ='".addslashes($ShipAccount)."' ,
		IPAddress='".$IPAddress."'
            ";
        $this->query($strSQLQuery, 0);
        $OrderID = $this->lastInsertId();
            
        if(empty($InvoiceID)){
            $InvoiceID = 'IN000'.$OrderID;
        }
        $sql="UPDATE s_order SET InvoiceID='".$InvoiceID."' WHERE OrderID='".$OrderID."'";
        $this->query($sql,0);
        
        
       
        $Date=date("Y-m-d");
    
            
        $strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$OrderID."',CustID='".$CustID."',InvoiceID='".$InvoiceID."', LocationID='1', AccountID='5', CustCode = '".addslashes($CustCode)."',Method = 'Electronic Transfer',EntryType = 'Invoice',PaymentDate = '".$Date."', CreatedDate='".$Date."',UpdatedDate='".$Date."',PaymentType = 'Sales', Currency = 'USD', IPAddress='".$IPAddress."', DebitAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt= ENCODE('0.00','".$Config['EncryptKey']."')     ";
        $this->query($strSQLQuery, 0);
	$PID = $this->lastInsertId(); 

	  $strSQLQuery = "INSERT INTO f_payments SET  PID='".$PID."', CustID='".$CustID."', LocationID='1', AccountID='30', CustCode = '".addslashes($CustCode)."',Method = 'Electronic Transfer',EntryType = 'Invoice',PaymentDate = '".$Date."', CreatedDate='".$Date."',UpdatedDate='".$Date."',PaymentType = 'Sales',Flag= '1', Currency = 'USD', IPAddress='".$IPAddress."', CreditAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), DebitAmnt= ENCODE('0.00','".$Config['EncryptKey']."')     ";
        $this->query($strSQLQuery, 0);


            
        return $OrderID;
        
    }
 
      /*************End Reseller Default Invoice & Payment Entry ***************/
/*RMA */
    
		function  ListRma($arryDetails)
		{
			
			global $Config;
			extract($arryDetails);

			if(!empty($Module)){
			$strAddQuery = "where o.Module='".$Module."' AND InvoiceID !=''";	
			}else{
		    $strAddQuery = "where o.Module='Return' AND InvoiceID !=''";
			}
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
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.OrderDate,o.Module, o.ReturnDate, o.OrderID,o.ReturnID,o.InvoiceID, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.ReturnPaid,o.SalesPerson  from s_order o ".$strAddQuery;
		    $strSQLQuery;
			return $this->query($strSQLQuery, 1);	
				
		}
		
		function UpdateRma($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update s_order set ReturnPaid='".$ReturnPaid."', ReturnComment='".addslashes($ReturnComment)."', Module='".$Module."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID=".$OrderID.""; 
			
			$this->query($strSQLQuery, 0);

			return 1;
		}
		
		function  GetRma($OrderID,$ReturnID,$Module)
		{
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

		
    function ListInvoiceByCustomer($arryDetails){
 
    	
		    global $Config;
			extract($arryDetails);
			
			$strAddQuery = " where Module='Invoice'";
			$SearchKey   = strtolower(trim($key));

			if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.InvoiceID like '%".$SearchKey."%'   or o.CustomerName like '%".$SearchKey."%'  or soi.sku like '%".$SearchKey."%' or o.SalesPerson like '%".$SearchKey."%') " ):("");	
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.OrderDate, o.ReturnDate, o.OrderID,o.ReturnID,o.InvoiceID, o.CustCode, o.CustomerName,o.TotalInvoiceAmount,o.CustomerCurrency,o.Status,o.InvoiceDate, o.CustomerCurrency,o.SalesPerson,soi.sku  from s_order o left outer join s_order_item soi on (o.OrderID=soi.OrderID) ".$strAddQuery;
		    #$strSQLQuery;
			return $this->query($strSQLQuery, 1);	

    }
      /*************End Reseller Default Invoice & Payment Entry ***************/

/* finance RMA Credit */




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

			$strSQLQuery = "select o.OrderDate,o.Module, o.ReturnDate,o.CustCode,o.OrderID,o.ReturnID,o.InvoiceID, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.ReturnPaid,o.SalesPerson  from s_order o ".$strAddQuery;
		    $strSQLQuery;
			return $this->query($strSQLQuery, 1);	
				
		}
		
      
    
	function UpdateCustCredit($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update s_order set ReturnPaid='".$ReturnPaid."', ReturnComment='".addslashes($ReturnComment)."', Module='".$Module."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID='".$OrderID."'"; 
			#echo $strSQLQuery;exit;
			$this->query($strSQLQuery, 0);

			return 1;
		}

/* finance RMA Credit end here */
	function GetSalesContactInformationInv($id){
	    
	    $sql="SELECT * FROM `s_address_book` WHERE `CustID` = '".$id."' && `AddType`='contact' &&  InvoiceDelivery='1'";
	    return $this->query($sql, 1);	
	}

	function GetSalesContactInformationSO($id){
	    
	    $sql="SELECT * FROM `s_address_book` WHERE `CustID` = '".$id."' && `AddType`='contact' &&  SoDelivery='1'";
	    return $this->query($sql, 1);	
	}
	function GetSalesContactInformationSendCreditNote($id){
	    
	    $sql="SELECT * FROM `s_address_book` WHERE `CustID` = '".$id."' && `AddType`='contact' &&  CreditDelivery='1'";
	    return $this->query($sql, 1);	
	}
	function GetSalesContactInformationSendCsaseReceipt($id){
	    
	    $sql="SELECT * FROM `s_address_book` WHERE `CustID` = '".$id."' && `AddType`='contact' &&  PaymentInfo='1'";
	    return $this->query($sql, 1);	
	}


	function GetReceivedQty($id){	    
		$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' ";
		$arrRow = $this->query($sqlSelect, 1);
		return $arrRow[0]['qty_received'];	
	}


	function UpdateSOInvoice($arryDetails)	{
			global $Config;
			extract($arryDetails);

			if(!empty($OrderID)){
				$arryInvoice = $this->GetSale($OrderID,'','');
				$InvoiceID = $arryInvoice[0]['InvoiceID'];
				$SaleID = $arryInvoice[0]['SaleID'];
				$CustomerCurrency = $arryInvoice[0]['CustomerCurrency'];
			}
			
			if(!empty($SaleID)){
				$arrySale = $this->GetSale('',$SaleID,'Order');
				$SalesOrderID	 = $arrySale[0]['OrderID'];
				
				$TotalInvoiceAmount = $TotalAmount;

	
                        if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                        
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			if($CustomerCurrency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR',$InvoiceDate);
			}else{   
				$ConversionRate=1;
			}



				$strSQLQuery = "update s_order set EntryType='".$EntryType."', ConversionRate='".$ConversionRate."',  EntryInterval='".$EntryInterval."', EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."',	InvoiceDate  = '".$InvoiceDate."', ShippedDate  = '".$ShippedDate."',   wCode ='".$wCode."', wName = '".$wName."', InvoiceComment  = '".$InvoiceComment."',TotalAmount  = '".$TotalAmount."', TotalInvoiceAmount  = '".$TotalInvoiceAmount."', Freight  = '".$Freight."',TDiscount ='".addslashes($TDiscount)."', taxAmnt  = '".$taxAmnt."', UpdatedDate  = '".$Config['TodayDate']."',CustomerPO ='".addslashes($CustomerPO)."',ShippingMethodVal ='".addslashes($ShippingMethodVal)."',TrackingNo ='".$TrackingNo."',ShipAccount ='".addslashes($ShipAccount)."',Fee ='".addslashes($Fee)."',OrderSource ='".$OrderSource."'	where OrderID='".$OrderID."'  ";                
				$this->query($strSQLQuery, 0);                                                     
                               
				/******** Item Updation for Invoice ************/
				$arryItem = $this->GetSaleItem($OrderID);
				$NumLine = sizeof($arryItem);
                                
                                                
				$totalTaxAmnt = 0;$taxAmnt=0;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;					
					if(!empty($arryDetails['id'.$i])){
					        $id = $arryDetails['id'.$i];
						if($arryDetails['tax'.$i] > 0){
							$actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i]; 	
							$taxAmnt = ($actualAmnt*$arryDetails['tax'.$i])/100;
							$totalTaxAmnt += $taxAmnt;
						}

					/**************/
					$oldqty = $arryDetails['oldqty'.$i];
					$qty_received = $arryDetails['qty'.$i];
					$qty_left = $qty_received - $oldqty; 
	
					$sql = "update s_order_item set qty_received='".$qty_received."', qty_invoiced='".$qty_received."', amount = '".addslashes($arryDetails['amount'.$i])."',  req_item='".addslashes($arryDetails['req_item'.$i])."', SerialNumbers ='".trim($arryDetails['serial_value'.$i])."'  where id='".$id."' ";
					$this->query($sql, 0);	
					/**************/	
					$sqlSel = "select ref_id from s_order_item where id = '".$id."' ";
					$arrRef = $this->query($sqlSel, 1);
	 				$ref_id = $arrRef[0]['ref_id'];

					$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$ref_id."' ";
					$arrRow = $this->query($sqlSelect, 1);
					$qtyreceived = $arrRow[0]['qty_received'];
					$qtyreceived = $qtyreceived+$qty_left;
					
					$qtyinvoiced = $arrRow[0]['qty_invoiced'];
					$qtyinvoiced = $qtyinvoiced+$qty_left;
					
					$sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."'  where id = '".$ref_id."' ";
					$this->query($sqlupdate, 0);							



					/**Implemented on Post to Gl***
					if($qty_left!=''){
						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$qty_left . "  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
						$this->query($UpdateQtysql, 0);

						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);
					}
					/******************/


                                               
					}
				}


			$strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$OrderID."'"; 
			$this->query($strSQL, 0);


			}


			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('s_order','InvoiceID',$OrderID,$SaleInvoiceID); 

			return true;
		}



	  function  getSerialNumberForItemById($OrderID,$item_id,$sku)
                 {
                          $strSQLQuery = "select SerialNumbers from s_order_item where OrderID = '".$OrderID."' and item_id= '".$item_id."' and Sku='".$sku."'";
                         return $this->query($strSQLQuery, 1);
                 }


//***************************Amit Singh* 27-11-2015*************************
                function getSelectedAttributes($ods){
                 $strSQLQuery="SELECT s_ord.id, s_ord.OrderID,s_ord.item_id,s_ord.sku,s_ord.attributes, inv_item.paid,inv_item.pid,inv_item.name,inv_item.caption, inv_global.id,inv_global.paid,inv_global.title FROM s_order_item s_ord LEFT OUTER JOIN inv_item_attributes inv_item ON s_ord.item_id=inv_item.pid LEFT OUTER JOIN inv_global_optionList inv_global ON inv_global.paid=inv_item.paid WHERE 1 and s_ord.OrderID='".$ods."'";   
                return $this->query($strSQLQuery, 1);
                }

		/*****code by sachin 17-11-2015 ****/
	function SaveSalesPdfTempalte($arryDetails){
	    global $Config;
	    extract($arryDetails);
	    $strSQLQuery = "INSERT INTO dynamic_pdf_template SET ModuleName = '".$ModuleName."', ModuleId='".$ModuleId."',TemplateName='".addslashes($TemplateName)."',Module='".$Module."', InformationFieldFontSize = '".$InformationFieldFontSize."', InformationFieldAlign = '".$InformationFieldAlign."',InformationColor='".addslashes($InformationColor)."', BillAddHeading = '".$BillAddHeading."',BillAdd_Heading_FieldFontSize='".$BillAdd_Heading_FieldFontSize."',BillAdd_Heading_FieldAlign='".$BillAdd_Heading_FieldAlign."',BillAddColor='".$BillAddColor."',BillHeadColor='".$BillHeadColor."',BillHeadbackgroundColor='".$BillHeadbackgroundColor."',ShippAddColor='".$ShippAddColor."',ShippAddHeading='".$ShippAddHeading."',ShippAdd_Heading_FieldFontSize='".$ShippAdd_Heading_FieldFontSize."',ShippAdd_Heading_FieldAlign='".$ShippAdd_Heading_FieldAlign."',ShippHeadColor='".$ShippHeadColor."',ShippHeadbackgroundColor='".$ShippHeadbackgroundColor."',LineItemHeadingFontSize='".$LineItemHeadingFontSize."',LineColor='".$LineColor."',LineHeadColor='".$LineHeadColor."',LineHeadbackgroundColor='".$LineHeadbackgroundColor."',LineHeading='".$LineHeading."',CompanyFieldFontSize='".$CompanyFieldFontSize."',CompanyFieldAlign='".$CompanyFieldAlign."',CompanyColor='".$CompanyColor."',CompanyHeadingFontSize='".$CompanyHeadingFontSize."',CompanyHeadColor='".$CompanyHeadColor."',TitleFontSize='".$TitleFontSize."',Title='".$Title."',TitleColor='".$TitleColor."',LogoSize='".$LogoSize."',SpecialHeadColor='".$SpecialHeadColor."',SpecialHeadbackgroundColor='".$SpecialHeadbackgroundColor."',SpecialHeadingFontSize='".$SpecialHeadingFontSize."',SpecialFieldColor='".$SpecialFieldColor."',SpecialHeading='".$SpecialHeading."'";
	    //echo $strSQLQuery; die;
	    return $this->query($strSQLQuery, 1);
	}
	function GetSalesPdfTemplate($arryDetails){
	    global $Config;
	    extract($arryDetails);
	    $sqlqury .=" Where 1 ";
	    $sqlqury .=(!empty($ModuleId))?(" and ModuleId='".$ModuleId."'"):('');
	    $sqlqury .=(!empty($id))?(" and id='".$id."'"):('');
	    $sqlqury .=(!empty($ModuleName))?(" and ModuleName='".$ModuleName."'"):('');
	    $sqlqury .=(!empty($Module))?(" and Module='".$Module."'"):('');
	    
	    $sql="Select * From dynamic_pdf_template".$sqlqury;
	    //echo $sql;die('ggg');
	    return $this->query($sql, 1);
	  }
	function UpdateSalesPdfTempalte($arryDetails) {
	    global $Config;
	    
	    extract($arryDetails);
	    //echo '<pre>';print_r($arryDetails);die('fftt');
	    $sql="Update dynamic_pdf_template SET TemplateName='".addslashes($TemplateName)."', InformationFieldFontSize = '".$InformationFieldFontSize."', InformationFieldAlign = '".$InformationFieldAlign."',InformationColor='".addslashes($InformationColor)."', BillAddHeading = '".$BillAddHeading."',BillAdd_Heading_FieldFontSize='".$BillAdd_Heading_FieldFontSize."',BillAdd_Heading_FieldAlign='".$BillAdd_Heading_FieldAlign."',BillAddColor='".$BillAddColor."',BillHeadColor='".$BillHeadColor."',BillHeadbackgroundColor='".$BillHeadbackgroundColor."',ShippAddColor='".$ShippAddColor."',ShippAddHeading='".$ShippAddHeading."',ShippAdd_Heading_FieldFontSize='".$ShippAdd_Heading_FieldFontSize."',ShippAdd_Heading_FieldAlign='".$ShippAdd_Heading_FieldAlign."',ShippHeadColor='".$ShippHeadColor."',ShippHeadbackgroundColor='".$ShippHeadbackgroundColor."',LineItemHeadingFontSize='".$LineItemHeadingFontSize."',LineColor='".$LineColor."',LineHeadColor='".$LineHeadColor."',LineHeadbackgroundColor='".$LineHeadbackgroundColor."',LineHeading='".$LineHeading."',CompanyFieldFontSize='".$CompanyFieldFontSize."',CompanyFieldAlign='".$CompanyFieldAlign."',CompanyColor='".$CompanyColor."',CompanyHeadingFontSize='".$CompanyHeadingFontSize."',CompanyHeadColor='".$CompanyHeadColor."',TitleFontSize='".$TitleFontSize."',Title='".$Title."',TitleColor='".$TitleColor."',LogoSize='".$LogoSize."',SpecialHeadColor='".$SpecialHeadColor."',SpecialHeadbackgroundColor='".$SpecialHeadbackgroundColor."',SpecialHeadingFontSize='".$SpecialHeadingFontSize."',SpecialFieldColor='".$SpecialFieldColor."',SpecialHeading='".$SpecialHeading."' where ModuleId='".$ModuleId."' and id='".$id."' and Module='".$Module."' and ModuleName='".$ModuleName."'";
	    return $this->query($sql, 1);
	}

	function DeleteTemplateName($arryDetails){
	    global $Config;
	    extract($arryDetails);
	    $sql="Delete from dynamic_pdf_template where 1 and Module='".$Module."' and ModuleId='".$ModuleId."' and id='".$id."' and ModuleName='".$ModuleName."'";
	    return $this->query($sql, 1);
	}
/*****code by sachin 17-11-2015 ****/


	//By chetan 26Feb//
	function  ListSaleOrdersOnly($arryDetails,$CustomerID=0)
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


			if(!empty($fby)){ //search
				$DateColumn = "o.".$moduledd.'Date';
				if($fby=='Year'){
					$strAddQuery .= " and YEAR(".$DateColumn.")='".$y."'";
				}else if($fby=='Month'){
					$strAddQuery .= " and MONTH(".$DateColumn.")='".$m."' and YEAR(".$DateColumn.")='".$y."'";
				}else{
					$strAddQuery .= (!empty($f))?(" and ".$DateColumn.">='".$f."'"):("");
					$strAddQuery .= (!empty($t))?(" and ".$DateColumn."<='".$t."'"):("");
				}
			}	


                       /* if($SearchKey==strtolower(ST_CLR_CREDIT)){
                            $SearchKey = 'Completed';
                        }else if($SearchKey==strtolower(ST_TAX_APP_HOLD)){
                            $SearchKey = 'Open';
                            $strAddQuery .= " and o.tax_auths='Yes'";
                        }else if($SearchKey==strtolower(ST_CREDIT_HOLD)){
                            $SearchKey = 'Open';
                            $strAddQuery .= " and o.tax_auths='No'";
                        }*/
 
			if($SearchKey==strtolower(ST_CLR_CREDIT)){
                            $SearchKey = 'Completed';
                        }else if($SearchKey==strtolower(ST_CREDIT_HOLD)){
                            $SearchKey = 'Open';
                            //$strAddQuery .= " and ((o.PaymentTerm!='' and o.PaymentTerm not like '%-%') or o.Approved!='1')";
			    $strAddQuery .= " and (o.PaymentTerm in ('Credit Card','PayPal') and o.OrderPaid!='1') or o.Approved!='1' ";
                        }else if($SearchKey==strtolower(ST_CREDIT_APP)){
                            $SearchKey = 'Open';
                            //$strAddQuery .= " and (o.PaymentTerm='' or o.PaymentTerm like '%-%') and o.Approved='1'";
			    $strAddQuery .= " and (o.PaymentTerm not in ('Credit Card','PayPal') or o.OrderPaid in (1,3)) and o.Approved='1' ";
                        }else if($SearchKey=="credit card"){
				$SearchKey = 'Open';
				$strAddQuery .= " and o.PaymentTerm='Credit Card' and o.OrderPaid in (1,3)";
			}
                        
			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.TrackingNo like '%".$SearchKey."%' ) " ):("");	
			}

			

			$strAddQuery .= (!empty($EntryType))?(" and o.EntryType='".$EntryType."'"):("");
 
 
				
			if(!empty($Status)){
				$strAddQuery .= " and o.Status='".$Status."'";
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}

			if(!empty($ToApprove)){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}
			
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.ReturnID = '' and o.Status != 'Cancelled'"):(" ");
			/********* By Karishma for MultiStore 22 Dec 2015******/
			$strAddQuery .= (!empty($CustomerID) && $CustomerID!='0')?(" and o.CustID='".mysql_real_escape_string($CustomerID)."'"):("");
			/*****End By Karishma for MultiStore 22 Dec 2015**********/

			//$strAddQuery .= (!empty($InvoiceID))?(" group by SaleID"):(" ");
			//$strAddQuery .=  " group by o.SaleID having tempModule='Order' ";

			
			if($Config['GetNumRecords']==1){
				$Columns = " count(o.OrderID) as NumCount ";				
			}else{		
//$strAddQuery .=  " group by o.OrderID HAVING SUM(i.qty)!=Sum(i.qty_invoiced) ";
			//$strAddQuery  .= ($module == 'Order')? " and o.SaleID NOT IN (select SaleID from s_order where Module = 'Invoice' OR Module = 'Return') " : '';
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.".$moduledd."Date desc, o.OrderID desc ");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");		
				$Columns = "  o.* , if(o.AdminType='employee',e.UserName,'Administrator') as PostedBy ";
				
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
		
		
		        $strSQLQuery = "select ".$Columns."  from s_order o  left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType='employee') " . $strAddQuery;
			 
			return $this->query($strSQLQuery, 1);	
	
				
		}

function  GetUserCommision($id=0)
		{

			//$strSQLQuery = "select *  from h_employee  where EmpID='".$id."'";
				$strSQLQuery = "SELECT * FROM `h_commission` WHERE 1 and `EmpID`='".$id."'";

			return $this->query($strSQLQuery, 1);
		}

	/*********Next Prevoius by Chetan 13Apr***********/
	function NextPrevRow($OrderID,$Next,$module) {
		global $Config;
		$strAddQuery='';
		if($OrderID>0){			
			//$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (FIND_IN_SET(" . $_SESSION['AdminID'] . ",l.AssignTo) OR l.created_id='" . $_SESSION['AdminID'] . "') ") : ("");
		$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (o.SalesPersonID='".$AdminID."' or o.AdminID='".$AdminID."')") : ("");
			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select o.OrderID,InvoiceEntry  from s_order o where o.OrderID ".$operator."'" . $OrderID . "' and o.Module= '".$module."' ". $strAddQuery. " order by o.OrderID ".$asc." limit 0,1";
			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow;
		}
	}
/*********Next Prevoius by Chetan 13Apr***********/
	function NextPrevRowShipment($OrderID,$Next,$module,$batch) {
		global $Config;
		$strAddQuery='';
		if($OrderID>0){			
			$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (o.SalesPersonID='".$AdminID."' or o.AdminID='".$AdminID."')") : ("");
		$strAddQuery .= (!empty($batch)) ? (" and  o.batchId='" .$batch. "' ") : ("");
			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select o.OrderID,o.ShippedID  from s_order o where o.OrderID ".$operator."'" . $OrderID . "' and o.Module= '".$module."' ". $strAddQuery. " order by o.OrderID ".$asc." limit 0,1";
			$arrRow = $this->query($strSQLQuery, 1);
			return $arrRow;
		}
	}


function GetLineItemById($id){

$strSQLQuery = "select * from s_order_item  where id = '".$id."'  "; 

return $arrRow = $this->query($strSQLQuery, 1);


}

//Added by chetan 6May//
	function setBatchIdToSaleOrder($saleId,$batchId)
	{
            $strSQLQuery = "select OrderID from s_order where batchId =  '".$batchId."' and  SaleID = '".$saleId."'";            
            $resArr = $this->query($strSQLQuery, 1);
            
            if(!empty($resArr))
            {
                return false;
            }else{
                $strSQLQuery = "update s_order set batchId =  '".$batchId."' where SaleID = '".$saleId."' and (Module = 'Order' || Module = 'Invoice'  )";
                $this->query($strSQLQuery, 1);
            
                $this->saveCountToBatch($batchId);
                return true;
            }    
	}
        
        
        function ListbatchEntries($batchId)
        {
            //$strSqlQuery = "select * from s_order where (Module = 'Invoice' and batchId =  '".$batchId."') or (Module = 'Order' and batchId =  '".$batchId."')";
$strSqlQuery = "select * from s_order where Module = 'Shipment' and batchId =  '".$batchId."'";
            return $this->query($strSqlQuery, 1);
        }
        
        function moveInvoicesto($batchId,$orderId,$frbatchId)
        {
            if(strstr($orderId,','))
            {
                $arr = explode(',',$orderId);
            }else{
                $arr = array($orderId);
            }
            foreach($arr as $Id)
            {
                $this->updateBatchIdToOrder($batchId,$Id);
                $this->saveCountToBatch($batchId);
            }
            
            $this->saveCountToBatch($frbatchId);
            
        }
        
        
        function updateBatchIdToOrder($batchId,$Id)
        {
            $strSQLQuery = "update s_order set batchId =  '".$batchId."' where OrderId = '".$Id."' ";
            $this->query($strSQLQuery, 1);
        }
        
        function saveCountToBatch($batchId)
        {
            $strSqlQuery = "select count(orderId) as Icount from s_order where Module = 'Invoice' and batchId =  '".$batchId."' ";
            $arrIRes = $this->query($strSqlQuery, 1);
            $strSqlQuery = "select count(orderId) as Ocount from s_order where Module = 'Order' and batchId =  '".$batchId."' ";
            $arrORes = $this->query($strSqlQuery, 1);
            
            $strSQLQuery = "update batchmgmt set salesEntries = '".$arrORes[0]['Ocount']."', invoiceEntries = '".$arrIRes[0]['Icount']."' where batchId = '".$batchId."'  ";
            $this->query($strSQLQuery, 1);
        }
	//End//

function UpdateInvoiceIDInShip($arryDetails,$InvOrderID,$ShipOrderID){
					extract($arryDetails);
					$strSqlQuery = "select InvoiceID from s_order where Module = 'Invoice' and OrderID =  '".$InvOrderID."' ";
					$rs = $this->query($strSqlQuery, 1);

					$strShipSqlQuery = "select ShippedID from s_order where Module = 'Shipment' and OrderID =  '".$ShipOrderID."' ";
					$arryShip = $this->query($strShipSqlQuery, 1);

					if($rs[0]['InvoiceID']!=''){

					$strUpdateQuery = "update s_order set InvoiceID = '".$rs[0]['InvoiceID']."' where Module = 'Shipment' and OrderID = '".$ShipOrderID."'  ";
					$this->query($strUpdateQuery, 1);

					$strInvUpdateQuery = "update s_order set batchId = '".$batchId."',ShippedID ='".$arryShip[0]['ShippedID']."'  where Module = 'Invoice' and OrderID = '".$InvOrderID."'  ";
					$this->query($strInvUpdateQuery, 1);

					$strshipUpdateQuery = "update w_shipment set GenrateShipInvoice = '1',RefID='".$rs[0]['InvoiceID']."' where  ShippedID = '".$ShipOrderID."'  ";
					$this->query($strshipUpdateQuery, 1);


					}

return 1;

}
//By chetan 25May//
function getBatchShipBySaleId($saleId)
{
    $strSqlQuery = "select count(*) as count from s_order where Module = 'Shipment' and SaleID =  '".$saleId."' and batchId <> '' ";
    $res =  $this->query($strSqlQuery, 1);
    return $res[0]['count'];
}
//End//

function GetShipOrderStatus($SaleID,$Module){

	$strSqlQuery = "select InvoiceID from s_order where Module = '".$Module."' and SaleID =  '".$SaleID."' ";
	$rs = $this->query($strSqlQuery, 1);
	if(!empty($rs[0]['InvoiceID'])){
		return $rs[0]['InvoiceID'];
	}else{
		return 0;

	}

}

function GetBatchStatusById($batchId){

	$strSqlQuery = "select status from batchmgmt where  batchId =  '".$batchId."' ";
	$rs = $this->query($strSqlQuery, 1);
	if(!empty($rs[0]['status'])){
		return $rs[0]['status'];
	}else{
		return false;

	}

}

function GetShipmentStatusById($OrderID){

 $strSqlQuery = "select ShipmentStatus from w_shipment where  OrderID =  '".$OrderID."' ";
$rs = $this->query($strSqlQuery, 1);
if(!empty($rs[0]['status'])){
return $rs[0]['status'];
}else{
return false;

}

}
function setRowColorSale($OrderID,$RowColor) {
        //if (!empty($OrderID)) {
             $sql = "update s_order set RowColor='".$RowColor."' where OrderID in ( $OrderID)"; 
             $this->query($sql, 0);
        //}

       return true;
    }

	function UpdateSaleDropshipItem($arryDetails){  
			global $Config;
			extract($arryDetails);
		
			for($i=1;$i<=$NumLine;$i++){

				if(!empty($arryDetails['id'.$i])){					
					$id = $arryDetails['id'.$i];
					         

                                 if(isset($arryDetails['DropshipCheck'.$i])){$DropshipCheck = 1;}else{$DropshipCheck = 0;}

					if($id>0){
						$sql = "update s_order_item set DropshipCheck='".addslashes($DropshipCheck)."',DropshipCost='".addslashes($arryDetails['DropshipCost'.$i])."' where id='".$id."'"; 
 						$this->query($sql, 0);
            
					}	

				}




		}
}

/* Function for bose added by karishma orders 10 Aug 2016**/

	function addToCartCustomer($data){
		global $Config;
		$Cid=$_SESSION['UserData']['Cid'];
		$CustCode=$_SESSION['UserData']['CustCode'];

		foreach($data['ProductID'] as $key=>$val){


			$ProductID=$val;
			$Quantity=$data['Quantity'][$val];
			$DesComment=$data['DesComment'][$val];

			$sql = "select count(*) as total,CartID from s_cart_sales where ProductID='".addslashes($ProductID)."' and Cid = '" . $Cid . "' ";
			$res=$this->query($sql, 1);
			$sql = "select * from inv_items where ItemID='".addslashes($ProductID)."'";
			$productDetails=$this->query($sql, 1);
			$Price=$productDetails[0]['sell_price'];


			if($res[0]['total']>0){
				// update
				$sql = "update s_cart_sales set Quantity=Quantity+'" . addslashes($Quantity) . "',
				AddedDate='" . date('Y-m-d h:i:s') . "' where CartID='" . $res[0]['CartID'] . "'";
				$this->query($sql, 0);
			}else{
				// add
				$sql = "insert into s_cart_sales SET Cid = '" . $Cid . "', ProductID = '" .addslashes($ProductID) . "',
				Price = '" . $Price . "', Quantity = '" . $Quantity . "',DesComment = '" . $DesComment . "',AddedDate = '" .date('Y-m-d h:i:s') . "' ";			

				$this->query($sql, 0);
			}

		}
			
		return true;
	}

	function getCartItem(){
		global $Config;
		if(!empty($_SESSION['UserData']['Cid'])){
			$Cid=$_SESSION['UserData']['Cid'];
			$sql = "select ec.*,ep.Sku,ep.Image from s_cart_sales as ec
			inner join inv_items ep on ep.ItemID=ec.ProductID
			where ec.Cid='".addslashes($Cid)."'";
			return $this->query($sql, 1);
		}
	}

	function addOrderCustomer($arryDetails){
		global $Config;
		extract($arryDetails);
		
		
		$Cid=$_SESSION['UserData']['CustID'];
		$CustCode=$_SESSION['UserData']['CustCode'];
		$objCustomer = new Customer();
		$arryCustomer = $objCustomer->GetCustomerAllInformation('',$CustCode,'');
		$arryCustomerShip = $objCustomer->GetCustomerShippingContact($Cid,$shipto);
		
		$Module='Order';
		$OrderType='Standard';
		$SalesPersonID=	$arryDetails['SalesPersonID'];
		$SalesPerson=	$arryDetails['SalesPerson'];
		$CustomerCurrency=$arryDetails['CustomerCurrency'];
		$CustomerName=$arryCustomer[0]['CustomerName'];
		$CustomerCompany=$arryCustomer[0]['CustomerCompany'];
	
		$Address=$arryCustomer[0]['Address'];
		$City=$arryCustomer[0]['CityName'];
		$State=$arryCustomer[0]['StateName'];
		$Country=$arryCustomer[0]['CountryName'];
		$ZipCode=$arryCustomer[0]['ZipCode'];
		$Mobile=$arryCustomer[0]['Mobile'];
		$Landline=$arryCustomer[0]['Landline'];
		$Fax=$arryCustomer[0]['Fax'];
		$Email=$arryCustomer[0]['Email'];
		$Landline=$arryCustomer[0]['Landline'];
		$ShippingCompany=$arryCustomerShip[0]['Company'];
		$ShippingAddress=$arryCustomerShip[0]['Address'];
		$ShippingCity=$arryCustomerShip[0]['CityName'];
		$ShippingState=$arryCustomerShip[0]['StateName'];
		$ShippingCountry=$arryCustomerShip[0]['CountryName'];
		$ShippingZipCode=$arryCustomerShip[0]['ZipCode'];
		$ShippingMobile=$arryCustomerShip[0]['Mobile'];
		$ShippingLandline=$arryCustomerShip[0]['Landline'];
		$ShippingFax=$arryCustomerShip[0]['Fax'];
		$ShippingEmail=$arryCustomerShip[0]['Email'];
		$ModuleID = "SaleID"; $PrefixSale = "SO";		
		//$AdminID=$_SESSION['UserData']['AdminID'];
		//$AdminType = $_SESSION['UserData']['AdminType'];
		$AdminID=$_SESSION['UserData']['AdminID'];
		$AdminType = $_SESSION['UserType'];
		$ClosedDate = $Config['TodayDate'];
		$CustomerCurrency =  $Config['Currency'];
		$CreatedBy = $_SESSION['UserName'];
		$arryDetails[$ModuleID] = '';
		$strSQLQuery = "INSERT INTO s_order SET Module = '".$Module."', OrderType = '".$OrderType."',
		 	OrderDate='".date('Y-m-d h:i:s')."',  
		    SalesPerson = '".addslashes($SalesPerson)."',CustCode='".addslashes($CustCode)."', 
		    CustID = '".addslashes($Cid)."',	 CustomerCurrency = '".addslashes($CustomerCurrency)."', 
			 BillingName = '".addslashes($CustomerName)."', CustomerName = '".addslashes($CustomerName)."', 
			 CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', 
			Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', 
			Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', 
			ShippingCompany = '".addslashes($ShippingCompany)."', 
			ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', 
			ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', 
			ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', 
			ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', 
			ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."',  CreatedBy = '".addslashes($CreatedBy)."', 
			PostedDate='".$Config['TodayDate']."',
			UpdatedDate='".$Config['TodayDate']."',Status='Open' ";			
			$strSQLQuery .= ",AdminID='".$AdminID."',AdminType='".$AdminType."',SalesPersonID = '".$SalesPersonID."'";
			//crm quote fields
			$strSQLQuery .= " ,subject='".addslashes($subject)."' ,CustType='".addslashes($CustType)."' ,opportunityName='".addslashes($opportunityName)."' ,OpportunityID='".addslashes($OpportunityID)."', 
			assignTo='".addslashes($assignTo)."', AssignType='".addslashes($AssignType)."', GroupID='".addslashes($GroupID)."' ,Comment='".addslashes($Comment)."',		CustomerPO ='".addslashes($CustomerPO)."',DeliveryDate = '".$DeliveryDate."',
			PaymentTerm='".addslashes($PaymentTerm)."' ,PaymentMethod='".addslashes($PaymentMethod)."',
			ShippingMethod='".addslashes($ShippingMethod)."',ShippingMethodVal = '".addslashes($ShippingMethodVal)."',
			 Approved = '".$Approved."'";
			

			//echo "=>".$strSQLQuery;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			
		
		$CartItem=$this->getCartItem();
		$TotalAmount='';
		foreach($CartItem as $list){

			$CartID=$list['CartID'];
			$Cid=$list['Cid'];
			$ProductID=$list['ProductID'];
			$Currency=$Config['Currency'];
			$CurrencySymbol=$Config['CurrencySymbol'];

			$ProducrPrice=$list['Price'];
			$Price=$list['Price']*$list['Quantity'];
			$TotalQuantity=$list['Quantity'];
			$ProductName=$list['Sku'];			
			$TotalAmount=$TotalAmount+$Price;
			$DesComment = $list['DesComment'];
			/***********************************************/
        $selQuery = "select i.description,i.itemType,c.valuationType as evaluationType from inv_items  i left outer join inv_categories c on c.CategoryID =i.CategoryID where  i.ItemID='" . $ProductID. "' ";
        $arrItem =  $this->query($selQuery, 1);
				$description = $arrItem[0]['description'];
			/***********************************************/
			$sql = "insert into s_order_item SET OrderID = '" . $OrderID . "',item_id ='" .addslashes($ProductID) . "',
			sku = '" .addslashes($ProductName) . "',description ='" .addslashes($description) . "', qty = '" .addslashes($TotalQuantity) . "',
			DesComment = '" .addslashes($DesComment) . "',Price = '" . $ProducrPrice . "',amount= '" . $Price ."'";			
			$this->query($sql, 0);

			
			$sql = "DELETE FROM s_cart_sales WHERE CartID = '".addslashes($CartID)."'";
			$this->query($sql, 0);
		}
		
		$sql = "update s_order set TotalAmount='" . addslashes($TotalAmount) . "' where OrderID='" .$OrderID . "'";
		$this->query($sql, 0);

		/*if(empty($arryDetails[$ModuleID]) && !empty($ModuleID)){
			$objConfigure=new configure();
			$NextModuleID = $objConfigure->GetNextModuleID('s_order',$Module);
			$ModuleIDValue = $NextModuleID;
			$strSQL = "update ".$DBName."s_order set ".$ModuleID."='".$ModuleIDValue."' where OrderID='".$OrderID."'";
			$this->query($strSQL, 0);
		}*/
		
	
		$objConfigure = new configure();
		$objConfigure->UpdateModuleAutoID('s_order',$Module,$OrderID,'');  

		
		$this->sendSalesEmail($OrderID);
		 
		return true;
	}

	function getCartProductQty($ProductID){
		$Cid=$_SESSION['AdminID'];
		$sql = "select ec.Quantity,ep.Sku from s_cart_sales ec
		inner join inv_items ep on ep.ItemID=ec.ProductID	
		where ec.ProductID='".addslashes($ProductID)."' and  ec.Cid='".addslashes($Cid)."'";
		return $this->query($sql, 1);
	}

	function RemoveCart($Cid) {
		$strSQLQuery = "delete from s_cart_sales where CartID = '".mysql_real_escape_string($Cid)."'";
		$this->query($strSQLQuery, 0);

		return 1;
	}
	
	/*********Next Prevoius by Karishma 26Aug 2016***********/
	function NextPrevRowCustomer($OrderID,$Next,$module,$CustomerID=0) {
		global $Config;
		$AdminID=$_SESSION['AdminID'];
		if($AdminID=='') $AdminID=$_SESSION['UserData']['AdminID'];
		if($OrderID>0){
			$strAddQuery .= ($Config['vAllRecord'] != 1) ? (" and (o.SalesPersonID='".$AdminID."' or o.AdminID='".$AdminID."')") : ("");
			$strAddQuery .= (!empty($CustomerID) && $CustomerID!='0')?(" and o.CustID='".mysql_real_escape_string($CustomerID)."'"):("");
			if($Next==1){
				$operator = "<"; $asc = 'desc';
			}else{
				$operator = ">"; $asc = 'asc';
			}

			$strSQLQuery = "select o.OrderID,InvoiceEntry  from s_order o where o.OrderID ".$operator."'" . $OrderID . "' and o.Module= '".$module."' ". $strAddQuery. " order by o.OrderID ".$asc." limit 0,1";
			$arrRow = $this->query($strSQLQuery, 1);
			
			return $arrRow[0]['OrderID'];
		}
	}
function UpdateSHIPInvoice($arryDetails)	{
			global $Config;
			extract($arryDetails);

			if(!empty($OrderID)){
				$arryInvoice = $this->GetSale($OrderID,'','');
				$InvoiceID = $arryInvoice[0]['InvoiceID'];
				$SaleID = $arryInvoice[0]['SaleID'];
				$CustomerCurrency = $arryInvoice[0]['CustomerCurrency'];
			}
			
			if(!empty($SaleID)){
				$arrySale = $this->GetSale('',$SaleID,'Order');
				$SalesOrderID	 = $arrySale[0]['OrderID'];
				
				$TotalInvoiceAmount = $TotalAmount;
				if(empty($ShippingMethod)){
					$ShippingMethodVal = $arrySale[0]['ShippingMethodVal'];	
					$ShippingMethod = $arrySale[0]['ShippingMethod'];
				}
	
                        if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                        
                        if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                        if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                        if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                        if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}

			if($CustomerCurrency != $Config['Currency']){  
				$ConversionRate = CurrencyConvertor(1,$CustomerCurrency,$Config['Currency'],'AR',$InvoiceDate);
			}else{   
				$ConversionRate=1;
			}

//$strSQLQuery = "UPDATE s_order SET EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',  EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."', OrderDate='".$OrderDate."', InvoiceID = '".$InvoiceID."',SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."',
			//Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', ClosedDate = '".$ClosedDate."', Comment = '".addslashes($Comment)."', CustomerCurrency = '".addslashes($CustomerCurrency)."' ,  CustID = '".addslashes($CustID)."' , BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			//City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			//ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			//TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."',TDiscount ='".addslashes($TDiscount)."', taxAmnt ='".addslashes($taxAmnt)."',  UpdatedDate='".$Config['TodayDate']."',
			//ShippedDate='".$ShippedDate."',InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."',tax_auths='".addslashes($tax_auths)."',Spiff='".addslashes($Spiff)."',SpiffContact='".addslashes($SpiffContact)."',SpiffAmount='".addslashes($SpiffAmount)."', TaxRate='".addslashes($MainTaxRate)."',freightTxSet='".addslashes($freightTxSet)."',CustDisType='".addslashes($CustDisType)."',CustDisAmt='".addslashes($CustDiscount)."',MDType='".addslashes($MDType)."',MDAmount ='".addslashes($MDAmount)."',MDiscount ='".addslashes($MDiscount)."',AccountID ='".addslashes($AccountID)."',CustomerPO ='".addslashes($CustomerPO)."' ,ShippingMethodVal ='".addslashes($ShippingMethodVal)."',TrackingNo ='".addslashes($TrackingNo)."',ShipAccount ='".addslashes($ShipAccount)."' ,ConversionRate ='".addslashes($ConversionRate)."',OrderSource='".$OrderSource."' ".$AddSql."  WHERE OrderID='".$OrderID."'";


				if(isset($PaymentTerm)){
					$addSQLQuery .= " ,PaymentTerm ='".addslashes($PaymentTerm)."'";
				}


				$strSQLQuery = "update s_order set EntryType='".$EntryType."', ConversionRate='".$ConversionRate."',  EntryInterval='".$EntryInterval."', EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."',	InvoiceDate  = '".$InvoiceDate."', ShippedDate  = '".$ShippedDate."',   wCode ='".$wCode."', wName = '".$wName."', InvoiceComment  = '".$InvoiceComment."',TotalAmount  = '".$TotalAmount."', TotalInvoiceAmount  = '".$TotalInvoiceAmount."', Freight  = '".$Freight."',TDiscount ='".addslashes($TDiscount)."', freightdiscount='".addslashes($freightdiscount)."', taxAmnt  = '".$taxAmnt."', UpdatedDate  = '".$Config['TodayDate']."',CustomerPO ='".addslashes($CustomerPO)."',ShippingMethodVal ='".addslashes($ShippingMethodVal)."',TrackingNo ='".$TrackingNo."',ShipAccount ='".addslashes($ShipAccount)."',Fee ='".addslashes($Fee)."',OrderSource ='".$OrderSource."',
City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',ShippingMethod='".addslashes($ShippingMethod)."',ShippingMethodVal ='".addslashes($ShippingMethodVal)."',CountryId ='".addslashes($CountryId)."',StateID ='".addslashes($StateID)."',CityID ='".addslashes($CityID)."',ShippingCountryID ='".addslashes($ShippingCountryID)."',ShippingStateID ='".addslashes($ShippingStateID)."',ShippingCityID ='".addslashes($ShippingCityID)."'  ".$addSQLQuery." where OrderID='".$OrderID."'  ";                
				$this->query($strSQLQuery, 0);                                                     
                               
				/******** Item Updation for Invoice ************/
				$arryItem = $this->GetSaleItem($OrderID);
				$NumLine = sizeof($arryItem);
                                
                                                
				$totalTaxAmnt = 0;$taxAmnt=0;
				for($i=1;$i<=$NumLine;$i++){
					$Count=$i-1;					
					if(!empty($arryDetails['id'.$i])){
					        $id = $arryDetails['id'.$i];
						if($arryDetails['tax'.$i] > 0){
							$actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i]; 	
							$taxAmnt = ($actualAmnt*$arryDetails['tax'.$i])/100;
							$totalTaxAmnt += $taxAmnt;
						}

					/**************/
					$oldqty = $arryDetails['oldqty'.$i];
					$qty_received = $arryDetails['qty'.$i];
					$qty_left = $qty_received - $oldqty; 
	
					$sql = "update s_order_item set qty_received='".$qty_received."',price='".$arryDetails['price'.$i]."', qty_invoiced='".$qty_received."',avgCost='".addslashes($arryDetails['avgCost'.$i])."', amount = '".addslashes($arryDetails['amount'.$i])."',  req_item='".addslashes($arryDetails['req_item'.$i])."', SerialNumbers ='".trim($arryDetails['serial_value'.$i])."' , RecurringCheck='".$arryDetails['RecurringCheck'.$i]."', EntryType='".$arryDetails['EntryType'.$i]."', EntryFrom='".$arryDetails['EntryFrom'.$i]."', EntryTo='".$arryDetails['EntryTo'.$i]."', EntryInterval='".$arryDetails['EntryInterval'.$i]."', EntryMonth='".$arryDetails['EntryMonth'.$i]."', EntryWeekly='".$arryDetails['EntryWeekly'.$i]."', EntryDate='".$arryDetails['EntryDate'.$i]."', CardCharge= '".addslashes($arryDetails['CardCharge'.$i])."' , CardChargeDate ='".addslashes($arryDetails['CardChargeDate'.$i])."' where id='".$id."' ";


					$this->query($sql, 0);	
					/**************/	
					$sqlSel = "select ref_id from s_order_item where id = '".$id."' ";
					$arrRef = $this->query($sqlSel, 1);
	 				$ref_id = $arrRef[0]['ref_id'];

					$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$ref_id."' ";
					$arrRow = $this->query($sqlSelect, 1);
					$qtyreceived = $arrRow[0]['qty_received'];
					$qtyreceived = $qtyreceived+$qty_left;
					
					$qtyinvoiced = $arrRow[0]['qty_invoiced'];
					$qtyinvoiced = $qtyinvoiced+$qty_left;
					
					$sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."'  where id = '".$ref_id."' ";
					$this->query($sqlupdate, 0);							



					/**Implemented on Post to Gl***
					if($qty_left!=''){
						$UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand-" .$qty_left . "  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' ";
						$this->query($UpdateQtysql, 0);

						$UpdateQtysql2 = "update inv_items set qty_on_hand ='0'  where Sku='" .$arryDetails['sku'.$i]. "' and ItemID ='".$arryDetails['item_id'.$i]."' and qty_on_hand<0";
						$this->query($UpdateQtysql2, 0);
					}
					/******************/


                                               
					}
				}


			$strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$OrderID."'"; 
			$this->query($strSQL, 0);


			}


			$objConfigure = new configure();			
			$objConfigure->EditUpdateAutoID('s_order','InvoiceID',$OrderID,$SaleInvoiceID); 

			return true;
		}

//Import Excel functions by chetan 23 sep 2016//

	function MoveRecordToMasterTable(){
		$sql = "update s_customers set PID = '0', Status = 'Yes' where AdminID = '".$_SESSION['AdminID']."'  and AdminType = '".$_SESSION['AdminType']."' and PID = '1'";
		$this->query($sql);
    	}  
    
	function DropDataOFImport(){
		 $sql = "DELETE FROM s_customers, s_address_book USING s_customers INNER JOIN s_address_book ON s_customers.Cid = s_address_book.CustID WHERE s_customers.AdminID = '".$_SESSION['AdminID']."' and s_customers.AdminType = '".$_SESSION['AdminType']."' and s_customers.PID = '1' and s_customers.Status = 'No' ";
		$this->query($sql);
  	}
	
	function CountForImport(){
	    	$sql = "SELECT count(*) count from s_customers where AdminID = '".$_SESSION['AdminID']."' and AdminType = '".$_SESSION['AdminType']."' and PID = '1' and Status = 'No'";
	    	$count = $this->query($sql,1);
	    	return $c = ($count[0]['count']>0)?$count[0]['count']:0; 
   	}	
	
	//End//	

/********************Update Order Logs *************************/

function AddUpdateLogs($Order_ID,$arryDetails){
			global $Config;
			extract($arryDetails);

 $sql = "insert into update_log SET updID = '" . $Order_ID . "',ModuleType = '".addslashes($ModuleType)."',AdminID = '".addslashes($_SESSION['AdminID'])."',AdminType = '".addslashes($_SESSION['AdminType'])."',
			UserName = '" .addslashes($_SESSION['UserName']) . "',IpAdd = '" .addslashes($ipAdd) . "',UpdateDate = '".$Config['TodayDate']."'";		
			$this->query($sql, 0);
}


function GetLogs ($Order){

	global $Config;

			if($Config['GetNumRecords']==1){
				$Columns = " count(id) as NumCount ";				
			}else{				
				$Columns = "  * ";
				if($Config['RecordsPerPage']>0){
					//$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}

	 $strSQLQuery = "select ".$Columns." from update_log  where ModuleType = '" . $Order . "' ".$strAddQuery;



			return $this->query($strSQLQuery, 1);

}

function deleteLogs($arryDetails){


		 $count=count($arryDetails);
		 for($i=0;$i<$count;$i++){
		 	$logID=$arryDetails[$i];
		 	$strSQLQuery="DELETE FROM update_log WHERE id='".$logID."'";
		    $this->query($strSQLQuery, 1);

		 }

}
/********************End Order Logs *************************/


function getVendorNamePOS($VendorID){
		         $strSQLQuery = "select CONCAT(FirstName,' ',LastName) as name  from e_customers where Cid = '".$VendorID."'";
			     $results=$this->query($strSQLQuery,1);
			     return $results[0]['name'];
			
		}


function GetPosInvoice(){

		$strSqlQuery = "select inv.OrderID,	inv.OrderDate,inv.Module,inv.AutoID,inv.InvoiceID,inv.CustomerCurrency,inv.Status,inv.Approved,inv.ClosedDate,inv.DeliveryDate,inv.OrderType,inv.PaymentTerm,inv.TotalInvoiceAmount,	inv.TotalAmount,inv.PaymentDate,inv.OrderSource,inv.Fee,inv.paypalEmail,inv.paypalInvoiceId,inv.paypalInvoiceNumber,inv.OrderPaid,inv.CustomerPO,inv.VendorID,pos.order_id,pos.location_id,pos.vendor_id,s.data from s_order inv left outer join pos_order pos on (pos.order_id=inv.CustomerPO)  left outer join pos_settings s on (s.vendor_id=inv.VendorID and s.action='basic_location_sttings') where inv.Module='Invoice'  and inv.OrderSource ='POS' ";
		return $this->query($strSqlQuery, 1);

}

function GetPosRefInvoice($SaleID){

 $strSQLQuery = "select SaleID  from s_order where SaleID = '".$SaleID."'";
			     $results=$this->query($strSQLQuery,1);
if($results[0]['SaleID']!=''){
return 1;

}else{

return 0;

}
			    // return $results[0]['name'];

}


/*function getPosMarginReport(){


$sql = "SELECT  a.*,b.`Message`
FROM  erp_"".`UserName` COLLATE latin1_swedish_ci a  
      LEFT JOIN erp_"".`PrivateMessage` COLLATE latin1_swedish_ci b    
         ON a.`username` = b.`username`"


}*/

function UpdateUploadDocuments($document,$OrderID)
		{   // echo "hello";die;
			if(!empty($OrderID) && !empty($document)){
			    $strSQLQuery = "update s_order set UploadDocuments='".$document."' where OrderID='".$OrderID."'";
				return $this->query($strSQLQuery, 0);
			}
		}

function RecurringItemInvoice(){    
	global $Config;
	
	//$Config['TodayDate'] = '2016-05-15 12:08:09';
	
	$Config['CronEntry']=1;
	$arryDate = explode(" ", $Config['TodayDate']);
	$arryDay = explode("-", $arryDate[0]);

	$Month = (int)$arryDay[1];
	$Day = $arryDay[2];	

	$Din = date("l",strtotime($arryDate[0]));

          #$strSQLQuery = "select o.OrderID from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' and o.EntryDate='".$arryDay[2]."' and CASE WHEN o.EntryInterval='yearly' THEN o.EntryMonth='".$Month."'  ELSE 1 END = 1 ";

	 //$strSQLQuery = "select o.* from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."'";

 $strSQLQuery = "select o.* from s_order o where o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' ";
	 

	 
	 
          $arrySale = $this->myquery($strSQLQuery, 1);
		 // echo "<pre>";print_r($arrySale);exit;
		
	 
	  foreach($arrySale as $value){
		  
		  
 $strQuery = "select o.* from s_order_item o where OrderID = '".$value['OrderID']."' and  o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."'"; 

$arryItem = $this->myquery($strQuery, 1);

foreach($arryItem as $Itemvalue){
		$OrderFlag=0;
		switch($Itemvalue['EntryInterval']){
			case 'biweekly':
				$NumDay = 0;
				if($Itemvalue['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($Itemvalue['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($Itemvalue['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
					$OrderFlag=1;
				}//echo $value['InvoiceID'];exit;
				break;
			case 'semi_monthly':
				if($Day=="01" || $Day=="15"){
					$OrderFlag=1;
				}
				break;
			case 'monthly':
				if($Itemvalue['EntryDate']==$Day){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($Itemvalue['EntryDate']==$Day && $Itemvalue['EntryMonth']==$Month){
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

				$strSQL = "update s_order_item set LastRecurringEntry ='" . $Config['TodayDate'] . "' where id='" . $Itemvalue['id'] . "'";
				$this->myquery($strSQL, 0);

			
			}	
			
			

		}

}

	
	  }
		
		  exit;

       	  return true;
   }
/*********************************************************/

	function getOrderIDBySaleID($SaleID){
		if(!empty($SaleID)){
			$strSqlQuery = "select OrderID from s_order where Module = 'Order' and SaleID =  '".$SaleID."' ";
			$res =  $this->query($strSqlQuery, 1);
			return $res[0]['OrderID'];
		}
	}
	function getSaleID($OrderID){
		if(!empty($OrderID)){
			$strSqlQuery = "select SaleID from s_order where OrderID =  '".$OrderID."' ";
			$res =  $this->query($strSqlQuery, 1);
			return $res[0]['SaleID'];
		}
	}

	function AllInvoiceTotalBySaleID($SaleID){
		if(!empty($SaleID)){
			$strSqlQuery = "select sum(TotalInvoiceAmount) as TotalAmount from s_order where Module = 'Invoice' and SaleID =  '".$SaleID."' ";
			$res =  $this->query($strSqlQuery, 1);
			return $res[0]['TotalAmount'];
		}
	}

	function AllShipFreightBySaleID($SaleID){
		if(!empty($SaleID)){
			$strSqlQuery = "select sum(w.totalFreight) as ShipFreight from s_order o inner join s_order s on o.InvoiceID=s.InvoiceID  inner join w_shipment w on (s.InvoiceID=w.RefID and s.OrderID=w.ShippedID) where o.Module = 'Invoice' and o.SaleID =  '".$SaleID."' and  s.Module = 'Shipment' and s.SaleID =  '".$SaleID."'";
			$res =  $this->query($strSqlQuery, 1);
			return $res[0]['ShipFreight'];
		}
	}

function CounchildItem($ItemID,$OrderID){
        $strSQLQuery = "SELECT count(*) as child FROM s_order_item where parent_item_id= '".$ItemID."' and OrderID ='".$OrderID."' ";
        $rs = $this->query($strSQLQuery, 1);
if(!empty($rs[0]['child'])&& $rs[0]['child']>0){

return $rs[0]['child'];

}else{
    
return 0;
}}


	function GetChildCount($itemid){
			
			$strSQLQuery="select count(id) as count from s_order_item WHERE parent_item_id='".$itemid."' and parent_item_id!='0'";
			return $this->query($strSQLQuery, 1);
		}

/*************************By Bhoodev 06-06-2017****************************/

function CheckSerialCost($Sku,$Serial,$Condition,$WID){

				$serial_no = explode(",",$Serial);
				$resultSr = "'" . implode ( "', '", $serial_no ) . "'";
				$strSQLQuery = " select SUM(UnitCost) as Cost from inv_serial_item where serialNumber IN (".$resultSr.") and Sku ='".$Sku."' and `Condition` = '".$Condition."' and warehouse ='".$WID."' and Status='1' and disassembly='0' "; 
				$arryRow = $this->query($strSQLQuery, 1);
				return $arryRow[0]['Cost'];


}




function AddShipmentInvoiceItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			$discountAmnt = 0;$taxAmnt=0; $totalTaxAmnt=0;


				$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description,FromDate, ToDate, on_hand_qty, qty, qty_received, qty_invoiced, price, tax_id, tax, amount, discount,Taxable,req_item,DropshipCheck,DropshipCost,SerialNumbers,`Condition`,CustDiscount,RecurringCheck,EntryType,EntryFrom,EntryTo,EntryInterval,EntryMonth,EntryWeekly,avgCost,parent_item_id,Org_Qty,WID) values ";
 $query_parts = array();
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['qty'.$i])){
					
					$id = $arryDetails['id'.$i];
					
					if($arryDetails['tax'.$i] > 0){
						$actualAmnt = ($arryDetails['price'.$i]-$arryDetails['discount'.$i])*$arryDetails['qty'.$i]; 	
						$taxAmnt = ($actualAmnt*$arryDetails['tax'.$i])/100;
						$totalTaxAmnt += $taxAmnt;
					}

						//if($arryDetails['Org_Qty'.$i]>0 && $arryDetails['Org_Qty'.$i]!=''){
						       //$arryDetails['avgCost'.$i] = $arryDetails['avgCost'.$i]*$arryDetails['Org_Qty'.$i];
						//}           


/*if($arryDetails['serial_value'.$i]!=''){
  $SerialCost =  $this->CheckSerialCost($arryDetails['sku'.$i],$arryDetails['serial_value'.$i],$arryDetails['Condition'.$i],$arryDetails['WID'.$i]);
$arryDetails['avgCost'.$i] = $SerialCost/$arryDetails['qty'.$i];
}*/
if($arryDetails['Condition'.$i]=='' && $arryDetails['req_item'.$i]!='' ){
$arryDetails['avgCost'.$i]=0;
}
                                        // edited by Amit Singh for From Date & To Date
	$query_parts[] = "('".$order_id."', '".$arryDetails['item_id'.$i]."', '".$id."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."','".addslashes($arryDetails['PFromDate'.$i])."','".addslashes($arryDetails['PToDate'.$i])."','".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".addslashes($arryDetails['tax_id'.$i])."', '".addslashes($arryDetails['tax'.$i])."', '".addslashes($arryDetails['amount'.$i])."', '".addslashes($arryDetails['discount'.$i])."', '".addslashes($arryDetails['item_taxable'.$i])."' , '".addslashes($arryDetails['req_item'.$i])."','".addslashes($arryDetails['DropshipCheck'.$i])."','".addslashes($arryDetails['DropshipCost'.$i])."','".trim($arryDetails['serial_value'.$i])."','".addslashes($arryDetails['Condition'.$i])."','".addslashes($arryDetails['CustDiscount'.$i])."','".$arryDetails['RecurringCheck'.$i]."','".$arryDetails['EntryType'.$i]."','".$arryDetails['EntryFrom'.$i]."','".$arryDetails['EntryTo'.$i]."','".$arryDetails['EntryInterval'.$i]."','".$arryDetails['EntryMonth'.$i]."','".$arryDetails['EntryWeekly'.$i]."','".$arryDetails['avgCost'.$i]."','".$arryDetails['parent_ItemID'.$i]."','".$arryDetails['Org_Qty'.$i]."','".$arryDetails['WID'.$i]."')";
						
					
					 $sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qtyreceived = $arrRow[0]['qty_received'];
					$qtyreceived = $qtyreceived+$arryDetails['qty'.$i];
					
					$qtyinvoiced = $arrRow[0]['qty_invoiced'];
					$qtyinvoiced = $qtyinvoiced+$arryDetails['qty'.$i];
					
					$sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);	
				}




$objItem=new items();		
$checkProduct=$objItem->checkItemSku($arryDetails['sku'.$i]);
		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($arryDetails['sku'.$i]);
			if(count($arryAlias))
			{
					$Mainsku = $arryAlias[0]['sku'];				
			}
		}else{
     $Mainsku = $arryDetails['sku'.$i];
    }


/*************CODE FOR ADD SERIAL NUMBERS***********************************/
                                         
if ($arryDetails['serial_value'.$i] != '' && $arryDetails['DropshipCheck'.$i]!=1) {
        //$serial_no = explode(",",trim($arryDetails['serial_value'.$i]));
$serial_no = explode(",",$arryDetails['serial_value'.$i]);
				$resultSr = "'" . implode ( "', '", $serial_no ) . "'";
        //for ($j = 0; $j < sizeof($serial_no); $j++) {
                
$strSQL = "update inv_serial_item set UsedSerial = '1',OrderID ='".$order_id."',SelectType='SaleOrder' where serialNumber IN (".$resultSr.") and Sku ='" . trim($Mainsku) ."' and `Condition` ='".$arryDetails['Condition'.$i]."' and warehouse='".$arryDetails['WID'.$i]."' and (UsedSerial = 0 or OrderID!='' or LineID!=0) "; 
								$this->query($strSQL, 0);

        //}
}                                              
 /***********************END CODE**********************************************/



			}

 $sql .= implode(',', $query_parts); 
 $this->query($sql, 0);


$sqlComSelect = "select SUM(avgCost) as TotCost,parent_item_id from s_order_item where  parent_item_id>0 and OrderID='".$order_id."' group by parent_item_id";
$arrRowCost = $this->query($sqlComSelect, 1);
if(sizeof($arrRowCost)>0){
foreach($arrRowCost as $key=>$valCom){

$updateKit = "update s_order_item set avgCost = avgCost+".$valCom['TotCost']." where  parent_item_id='0' and OrderID='".$order_id."' and item_id='".$valCom['parent_item_id']."'";
					$this->query($updateKit, 0);

}
}
		#$strSQL = "update s_order set discountAmnt ='".$discountAmnt."',taxAmnt = '".$totalTaxAmnt."' where OrderID='".$order_id."'"; 
		$strSQL = "update s_order set discountAmnt ='".$discountAmnt."' where OrderID='".$order_id."'"; 
		$this->query($strSQL, 0);



			return true;

		}

function GetOrderStatus($OrderStatus,$Approved,$PaymentTerm,$OrderPaid){
			 if($OrderStatus == 'Completed') {
		                $Status = ST_CLR_CREDIT;
		                $StatusCls = 'green';
		         }else {
		                $StatusCls = 'red';

		                if($OrderStatus == 'Open') {
		                    	if($Approved != 1) {
						$Status = ST_CREDIT_HOLD; $StatusCls = 'red';
					}else{
						$Status = ST_CREDIT_APP; $StatusCls = 'green';
						if(!empty($PaymentTerm)){
							$arryTerm = explode("-",$PaymentTerm);
							if($OrderPaid!=1 && $arryTerm[1]==''){
								$Status = ST_CREDIT_HOLD; $StatusCls = 'red';
							}
						}
					}

		                }else {
		                    $Status = $OrderStatus;
		                }
		            }

		      return  $Status;
		}
/**************************************************************************/
/*     * ********** Comment Section ********** */

    function AddComment($arrydetail) {    	
        global $Config;
        extract($arrydetail);		
  $time = time();
 if($CommentID!= "" )
	{		

 $strSQLQuery = "update c_all_comments set Comment = '" . addslashes($Comment) . "' ,CommentDate = '" . $_SESSION['TodayDate'] . "',timestamp = '" . $time . "' where CommentID = '" . $CommentID . "'";

	$this->query($strSQLQuery, 0);
	return '1';

	}else{
	
   	   $strSQLQuery = "insert into c_all_comments (parent,commented_by,commented_id,parent_type,module_type,parentID,Comment,CommentDate,timestamp ) values( '" .$parent. "', '" .$commented_by. "','" .$commented_id. "','" .$parent_type. "','" .$module_type. "','" . $parentID. "','" . addslashes($Comment) . "','" . $_SESSION['TodayDate'] . "','" . $time . "')";

        $this->query($strSQLQuery, 0);
	
        $cmtID = $this->lastInsertId();
       
        return $cmtID;
    }
    }

    function GetCommentUser($id, $parentID, $parent_type, $parent, $status = 0) {

        $strAddQuery = 'where parent = ""';
        $strAddQuery .= (!empty($id)) ? (" c.CommentID='" . $id . "'") : ("  ");
        $strAddQuery .= (!empty($parentID)) ? (" and c.parentID='" . $parentID . "'") : ("  ");
        $strAddQuery .= (!empty($parent_type)) ? (" and c.parent_type='" . $parent_type . "'") : (" ");
        $strAddQuery .= (!empty($parent)) ? (" and c.parent='" . $parent . "'") : (" ");


        $strAddQuery .= " order by c.CommentID ASC ";
         $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_all_comments c left outer join h_employee e  on e.EmpID=c.commented_id  " . $strAddQuery;
     
        return $this->query($strSQLQuery, 1);
    }
    
     function GetCommentListBySaleOrderId($arrydetail) {

         if(empty($arrydetail))extract($arrydetail);
                 
    
        $strAddQuery = " order by c_all_comments.CommentID DESC ";
       // $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_all_comments c left outer join h_employee e  on e.EmpID=c.commented_id   " . $strAddQuery;
        $strSQLQuery = "SELECT * FROM c_all_comments WHERE `commented_id` = '1487'";
       
     return $this->query($strSQLQuery, 1);
    }
	
	
    
    function GetCommentList($arrydetail) {

         extract($arrydetail);
                 
         $SearchKey = strtolower(trim($SearchKey));
         $SearchKey = str_replace("opportunity","customer",$SearchKey);
         
        $strAddQuery = "where ( c.parentID='" . $parentID . "'  and  c.parent_type='" . $parent_type . "')";       
        $strAddQuery .= (!empty($SearchKey)) ? (" and (c.comment like '%" . $SearchKey . "%' or e.UserName like '%" . $SearchKey . "%'  )" ) : ("");

        $strAddQuery .= " order by c.CommentID asc ";

        $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_all_comments c left outer join h_employee e  on e.EmpID=c.commented_id   " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }
    
    function GetCommentListMain($arrydetail) {

         extract($arrydetail);
                 
         $SearchKey = strtolower(trim($SearchKey));
         $SearchKey = str_replace("opportunity","customer",$SearchKey);
         
        $strAddQuery = "where (( c.parentID='" . $parentID . "'  and  c.parent_type='" . $parent_type . "') or ( c.parent_type='Ticket' and t.CustID = '".$parentID."'))";       
        $strAddQuery .= (!empty($SearchKey)) ? (" and ( c.parent_type like '" . $SearchKey . "' or c.comment like '%" . $SearchKey . "%' or e.UserName like '%" . $SearchKey . "%'  )" ) : ("");

        $strAddQuery .= " order by c.CommentID asc ";

        $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_all_comments c left outer join h_employee e  on e.EmpID=c.commented_id  left outer join c_ticket t  on (c.parentID=t.TicketID and t.CustID = '".$parentID."') " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function GetCommentByID($id, $parent) {

        $strAddQuery = 'where 1';
        $strAddQuery .= (!empty($id)) ? (" c.CommentID='" . $id . "'") : ("  ");
        $strAddQuery .= (!empty($parent)) ? (" and c.parent='" . $parent . "'") : (" ");

        $strAddQuery .= " order by c.CommentID asc ";

        $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_all_comments c left outer join h_employee e  on e.EmpID=c.commented_id  " . $strAddQuery;
        return $this->query($strSQLQuery, 1);
    }

    function RemoveComment($commentID) {

        $strSQLQuery = "delete from c_all_comments where CommentID='" . $commentID . "'";
        $this->query($strSQLQuery, 0);

        return 1;
    }

function UpdateSaleQtyInPO($PurchaseID,$Qty,$Sku,$Condition,$DBName=''){

$objItem=new items();		
$checkProduct=$objItem->checkItemSku($Sku);
		//By Chetan 9sep// 
		if(empty($checkProduct))
		{
		$arryAlias = $objItem->checkItemAliasSku($Sku);
			if(count($arryAlias))
			{
					$Sku = $arryAlias[0]['sku'];				
			}
		}
  $strSQLQuery = "select OrderID from ".$DBName."p_order where PurchaseID='" . $PurchaseID . "' and Module='Order'";
	$rs = $this->query($strSQLQuery, 1);
		if(!empty($rs[0]['OrderID'])){

				$strSQLQuery = "update ".$DBName."p_order_item set SaleQty = '" .$Qty. "'  where OrderID = '" .$rs[0]['OrderID']. "' and sku='".$Sku."' and `Condition` = '".$Condition."'";
				$this->query($strSQLQuery, 0);

		}
return 1;

}

	
    function salesOrderRecurring(){       
          global $Config;
	  $Config['CronEntry']=1;
	 #$Config['TodayDate'] = '2018-02-01 05:48:55';
          $arryDate = explode(" ", $Config['TodayDate']);
   	  $arryDay = explode("-", $arryDate[0]);
 	
	  $Month = (int)$arryDay[1];
	  $Day = $arryDay[2];	
	
	  $Din = date("l",strtotime($arryDate[0]));

	/**************/
	$TodayDate = $arryDate[0];
	$Year = $arryDay[0];	
	$YearMonth = $arryDay[0].'-'.$arryDay[1];
	/**************/
	  
	 

  	$strSQLQuery = "select o.Module, o.OrderDate, o.InvoiceDate, o.InvoiceID, o.InvoicePaid,  o.TaxRate, o.freightTxSet, o.Freight, o.TDiscount, o.TotalAmount , o.PostToGL, o.taxAmnt, si.* from s_order_item si inner join s_order o on si.OrderID=o.OrderID where o.Module in('Quote','Order','Invoice') ".$strAdd." and o.Status not in('Cancelled', 'Rejected') and  si.EntryType ='recurring' and si.EntryFrom<='".$arryDate[0]."' and CASE WHEN si.EntryTo>0 THEN  si.EntryTo>='".$arryDate[0]."' ELSE 1 END = 1 "; 
	  $arrySaleLineItem = $this->query($strSQLQuery, 1);
	//pr($arrySaleLineItem);exit;
	  
	  foreach($arrySaleLineItem as $value)
	  {
		if(empty($value['EntryDate'])) $value['EntryDate']="01";

		/*****Parent Check for same interval*******/
		if($value['Module']=="Invoice"){
			$ModuleDate = $value['InvoiceDate'];
		}else{
			$ModuleDate = $value['OrderDate'];
		}
		$arryDt = explode("-", $ModuleDate);
		$YearOrder = $arryDt[0]; 
		$YearMonthOrder = $arryDt[0].'-'.$arryDt[1];
		/**************/
		 
		/*****Child Check for same interval*******/
		#$sql = "select InvoiceID, OrderDate, InvoiceDate from s_order where Parent='".$value['OrderID']."' and Module='".$value['Module']."' order by OrderID desc limit 0,1";
		$sql = "select o.InvoiceID, o.OrderDate, o.InvoiceDate,si.sku,si.amount from s_order_item si inner join s_order o on si.OrderID=o.OrderID where o.Parent='".$value['OrderID']."' and o.Module='".$value['Module']."' and si.sku='".$value['sku']."'  order by o.OrderID desc limit 0,1";
		$arryLastChild = $this->query($sql, 1);
		if($value['Module']=="Invoice"){
			$ChildDate = $arryLastChild[0]['InvoiceDate'];
		}else{
			$ChildDate = $arryLastChild[0]['OrderDate'];
		}
		$arryDtChild = explode("-", $ChildDate);
		$YearChild = $arryDtChild[0]; 
		$YearMonthChild = $arryDtChild[0].'-'.$arryDtChild[1];
		// echo pr($arryLastChild);die; 
		/**************/

		$OrderFlag=0; 
		if($ModuleDate!=$TodayDate){ 
			switch($value['EntryInterval']){
				case 'biweekly':
					$NumDay = 0;
					if($value['LastRecurringEntry']>0)
					{
						$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
					}			
				
					if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10))
					{
						$OrderFlag=1;
					}
					break;
				case 'semi_monthly':
					if($Day=="01" || $Day=="15"){
						$OrderFlag=1;
					}
					break;
				  case 'monthly':
					 
					if($value['EntryDate']==$Day && $YearMonthOrder!=$YearMonth && $YearMonthChild!=$YearMonth)
					{ 
						$OrderFlag=1;
					}
					break;
				  case 'yearly':
					if($value['EntryDate']==$Day && $value['EntryMonth']==$Month && $YearOrder!=$Year && $YearChild!=$Year)
					{
						
						$OrderFlag=1;
					}
					break;		
		
			}
		}
		
		
		

		if($OrderFlag==1){
			
			//echo '<br>'.$value['OrderID'].'#'.$value['InvoiceID'].'#'.$OrderFlag;  die;

			/******Tax & GrandTotal********/
			$taxAmnt = 0;
			$line_amount = $value['amount'];			
			if($value['Module']=="Invoice" && $value['PostToGL']=="1" && $value['RecurringAmount']>0){ 
				$line_qty = $value['RecurringQty'];
				$line_price = $value['RecurringPrice'];
				$line_amount = $value['RecurringAmount'];
			}

			if($value['Taxable']=='Yes' && !empty($value['TaxRate'])){
				$TaxRateArray = explode(":",$value['TaxRate']);
				$Rate = $TaxRateArray[2];
				$TaxableAmount = $line_amount - $value['TDiscount'];
				if(!empty($value['Freight']) && $value['freightTxSet']=='Yes'){
					$TaxableAmount += $value['Freight'];
				}
				$taxAmnt = round((($TaxableAmount * $Rate) / 100),2);
			}
			$TotalAmount = round((($line_amount - $value['TDiscount']) + $value['Freight'] + $taxAmnt),2);
			 
			/******Tax & GrandTotal********/
			
			 

			$order_id = $this->addSalesRecurring($value['OrderID'],$value['Module'], $value['item_id'],$taxAmnt,$TotalAmount,$line_qty,$line_price,$line_amount);
			

			/**Update Unpaid Parent Invoice for No Use in Future**/
			if($order_id>0 && $value['Module']=="Invoice" && $value['InvoicePaid']=="Unpaid" && $value['PostToGL']!="1"){
				$strSQL = "update s_order set NoUse ='1' where OrderID='" .$value['OrderID']. "'";
				$this->query($strSQL, 0);
				
			}
			//echo $order_id;exit; 
			/*********************/


	 	 }
		
       	  
   	}
	
	# exit;//temp

	return true;
  }
  
 


	   function addSalesRecurring($order_id,$Module,$item_id,$taxAmnt,$TotalAmount,$line_qty,$line_price,$line_amount){
			global $Config;
			/*****************/
			$ArrayFieldName = $this->GetFieldName('s_order');
			foreach($ArrayFieldName as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='AutoID'){
					$FeildAndValuesArray[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues = implode(", ",$FeildAndValuesArray);
			/*****************/ 
			$strSQLQuery = "insert into s_order (".$FeildAndValues.") select ".$FeildAndValues."  FROM s_order
			where OrderID = '".$order_id."'";
			$this->query($strSQLQuery, 0);			
			$OrderID = $this->lastInsertId();
		
			if($Module=="Invoice"){
				$strAdd = " ,InvoiceDate ='" .$Config['TodayDate']."', TotalInvoiceAmount ='" .$TotalAmount."' , InvoicePaid='Unpaid', InvoiceEntry='1' ";
				/*****CardCharge******************/
			 	$strSQLItem = "select item_id, CardChargeDate from s_order_item WHERE OrderID = '".$order_id."' and item_id = '".$item_id."' and  EntryType ='recurring' and  CardCharge ='1' and CardChargeDate>0 ";
				$ArryItem = $this->query($strSQLItem, 1);
				if(!empty($ArryItem[0]['item_id'])){
					$strAdd .= " ,CardCharge ='1',CardChargeDate ='".$ArryItem[0]['CardChargeDate']."' ";
	
				}	
				/***********************/
				
			}else{
				$strAdd = " , Status='Open' ,OrderDate ='" .$Config['TodayDate']."' ";
			}
			$strSQL = "update s_order set  EntryBy='C', SaleID = '', QuoteID = '',CreditID='', InvoiceID='', taxAmnt ='" .$taxAmnt."',TotalAmount ='" .$TotalAmount."', LastRecurringEntry ='" . $Config['TodayDate'] . "', EntryType = 'one_time' , OrderPaid='0' , ShippedDate='', Fee='', StatusMsg='', PostToGL='0', NoUse ='0', PickID='',batchId='0', PostToGLDate='' , ClosedDate = '', IPAddress='".$IPAddress."', Parent='".$order_id."',  DeliveryDate = '', PostedDate='".$Config['TodayDate']."', CreatedDate='".$Config['TodayDate']."' ,UpdatedDate='".$Config['TodayDate']."',PdfFile=''  ".$strAdd." where OrderID='" .$OrderID. "'";	  
			
			$this->query($strSQL, 0);	
	 
			$objConfigure = new configure();
			$objConfigure->UpdateModuleAutoID('s_order',$Module,$OrderID,'');
			/*****************/
			/*****************/
			$ArrayFieldName2 = $this->GetFieldName('s_order_item');
			foreach($ArrayFieldName2 as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='OrderID'){
					$FeildAndValuesArray2[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues2 = implode(", ",$FeildAndValuesArray2);
			/*****************/ 
			/*****************/
			$strSQLQuery = "insert into s_order_item (".$FeildAndValues2.") SELECT ".$FeildAndValues2." FROM s_order_item WHERE OrderID = '".$order_id."' and item_id = '".$item_id."'";
			$this->query($strSQLQuery, 0);
			$id = $this->lastInsertId();
			if(!empty($id)){
				if($Module=="Invoice" && $line_qty>0 && $line_price>0){//for Post to gl invoice only
					$amntSql = " ,qty='', qty_invoiced='".$line_qty."', price='".$line_price."', amount='".$line_amount."' ";
				}
				 $strSQL = "update s_order_item set OrderID ='" .$OrderID."', EntryType='one_time', EntryDate='', EntryFrom='',EntryTo='',EntryInterval='',EntryMonth='',EntryWeekly='',RecurringCheck='', CardCharge = '', CardChargeDate ='' ".$amntSql." where id='" .$id. "'";
				$this->query($strSQL, 0);
			}
			/*****************/
			/*****************/
			$strSQLItem = "select ID, RecurringCardInfo from s_order_card WHERE OrderID = '".$order_id."' ";
			$ArryCard = $this->query($strSQLItem, 1);
			if(!empty($ArryCard[0]['ID'])){
				$ArrayFieldName4 = $this->GetFieldName('s_order_card');
				foreach($ArrayFieldName4 as $key=>$values){
					if($values['Key'] != 'PRI' && $values['Field']!='OrderID'){
						$FeildAndValuesArray4[] = "`".$values['Field']."`";
					} 	 
				}
				$FeildAndValues4 = implode(", ",$FeildAndValuesArray4);
				$strSQL = "insert into s_order_card (".$FeildAndValues4.") SELECT ".$FeildAndValues4." FROM s_order_card WHERE OrderID = '".$order_id."' ";
				$this->query($strSQL, 0);
				$CardID = $this->lastInsertId();
				if(!empty($CardID)){	
					/******RecurringCardInfo**********/
					$SqlCardInfo = ''; 
					if($Module=="Invoice" && !empty($ArryCard[0]["RecurringCardInfo"])){
						$jsonCardArray = json_decode($ArryCard[0]["RecurringCardInfo"], true);						
						foreach($jsonCardArray as $keyC=>$valueC){
							if(!empty($valueC)){

								if($keyC=="CardNumber"){
									$SqlCardInfo .= ", CardNumber=ENCODE('" .$valueC. "','".$Config['EncryptKey']."') "; 
								}else{
									$SqlCardInfo .= ", ".$keyC ."= '". addslashes($valueC)."'";
								}
								
							}
				  		}
					}
					/********************************/
					$strSQL = "update s_order_card set RecurringCardInfo='', OrderID ='" .$OrderID."' ".$SqlCardInfo." where ID='" .$CardID. "'";
					$this->query($strSQL, 0);

					#echo $strSQL; die;
				}
			}
			/*****************/ 
			/*****************/
	  		

			return $OrderID;
		
	 }
	   

	/****code by sachin-19-4-17****/
          function GetOrderIDForOrderDocument($SaleID,$module){
		global $Config;
		$sql="select OrderID from s_order where SaleID='".trim($SaleID)."' and Module='".trim($module)."'";
		//echo $sql;
		return $this->query($sql, 1);
		}
        /****code by sachin****/

	function UpdateCardBalance($OrderID,$BalanceAmount){ 	
		if($OrderID>0){
			$strSQLQuery = "update s_order set BalanceAmount='".$BalanceAmount."' where OrderID=".$OrderID.""; 		 
			$this->query($strSQLQuery, 0);
		}
		return 1;
	}
	

	function CreateCloneOrder($order_id,$Module){    
		global $Config;
		$IPAddress = GetIPAddress();
		/*****************/
		if($order_id>0){
			$arrySaleItem = $this->GetSaleItem($order_id);
			/*****************/ 	
			$ArrayFieldName = $this->GetFieldName('s_order');
			foreach($ArrayFieldName as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='AutoID'){
					$FeildAndValuesArray[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues = implode(", ",$FeildAndValuesArray);
			/*****************/ 		
			$strSQLQuery = "insert into s_order (".$FeildAndValues.") select ".$FeildAndValues."  FROM s_order
			where OrderID = '".$order_id."'";	
			$this->query($strSQLQuery, 0);			
			$OrderID = $this->lastInsertId();
			if($OrderID>0){
				if($Module=="Invoice"){
					$strAdd = " ,InvoiceDate ='" .$Config['TodayDate']."', InvoicePaid='Unpaid' ";
				}else{
					$strAdd = " , Status='Open' ,OrderDate ='" .$Config['TodayDate']."' ";
				}		
			    	$strSQL = "update s_order set  SaleID = '', QuoteID = '',CreditID='', InvoiceID='', EntryType = 'one_time', OrderPaid='0' , batchId='0', PickID ='',PickStatus='',PickDate='0000-00-00',CardCharge ='',  EntryBy='', CardChargeDate ='' , ShippedDate='', StatusMsg='', Fee='', PostToGL='0', PostToGLDate='', ClosedDate = '', LastRecurringEntry ='', IPAddress='".$IPAddress."', Parent='".$order_id."', DeliveryDate = '', PostedDate='".$Config['TodayDate']."', CreatedDate='".$Config['TodayDate']."' ,UpdatedDate='".$Config['TodayDate']."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PdfFile='' ".$strAdd." where OrderID='" .$OrderID. "'";	
				$this->query($strSQL, 0); 
				$objConfigure = new configure();
				$objConfigure->UpdateModuleAutoID('s_order',$Module,$OrderID,'');
						
				/*****************/
				$ArrayFieldName2 = $this->GetFieldName('s_order_item');	
				foreach($ArrayFieldName2 as $key=>$values){
					if($values['Key'] != 'PRI' && $values['Field']!='OrderID'){
						$FeildAndValuesArray2[] = "`".$values['Field']."`";
					} 	 
				}
				$FeildAndValues2 = implode(", ",$FeildAndValuesArray2);
				/*****************/ 				
				foreach($arrySaleItem as $key=>$values){
					 $strSQLQuery = "insert into s_order_item (".$FeildAndValues2.") SELECT ".$FeildAndValues2." FROM s_order_item WHERE OrderID = '".$order_id."' and id = '".$values['id']."'";
					$this->query($strSQLQuery, 0);
					$id = $this->lastInsertId();
					if(!empty($id)){

						if($Module=="Invoice"){
							$stqty = " ,qty =''  ";
						}else{
							$stqty = " ,qty_invoiced ='' ";
						}

					
						$strSQL = "update s_order_item set OrderID ='" .$OrderID."' , EntryType = 'one_time', RecurringCheck = '', CardCharge = '', CardChargeDate ='' , qty_returned ='' , qty_received='' , qty_picked='',SerialNumbers='', qty_shipped=''  ".$stqty." where id='" .$id. "'";
						$this->query($strSQL, 0);
					}
				}
				/*****************/				 
				$strSQLItem = "select ID from s_order_card WHERE OrderID = '".$order_id."' ";
				$ArryCard = $this->query($strSQLItem, 1);
				if(!empty($ArryCard[0]['ID'])){
					$ArrayFieldName4 = $this->GetFieldName('s_order_card');
					foreach($ArrayFieldName4 as $key=>$values){
						if($values['Key'] != 'PRI' && $values['Field']!='OrderID'){
							$FeildAndValuesArray4[] = "`".$values['Field']."`";
						} 	 
					}
					$FeildAndValues4 = implode(", ",$FeildAndValuesArray4);
					$strSQL = "insert into s_order_card (".$FeildAndValues4.") SELECT ".$FeildAndValues4." FROM s_order_card WHERE OrderID = '".$order_id."' ";
					$this->query($strSQL, 0);
					$CardID = $this->lastInsertId();
					if(!empty($CardID)){					
						$strSQL = "update s_order_card set RecurringCardInfo='', OrderID ='" .$OrderID."' where ID='" .$CardID. "'";
						$this->query($strSQL, 0);
					}
				}
				/*****************/ 
			 


					
				$arrySale = $this->GetSale($OrderID,'','');
				if($Module=='Quote'){	
					$ModuleID = "QuoteID"; 
				}else if($Module=='Order'){
					$ModuleID = "SaleID";
				}else if($Module=='Credit'){
					$ModuleID = "CreditID"; 					
				}else if($Module=='Invoice'){
					$ModuleID = "InvoiceID"; 					
				}
				/*****************/	

				return $arrySale[0][$ModuleID];
			}
		}
		
	 }








	function CreateCloneGlInvoice($order_id,$Module){    
		global $Config;
		$IPAddress = GetIPAddress();
		/*****************/
		if($order_id>0){
			if($Module=="Invoice"){
				$arryOrder = $this->GetSale($order_id,'','');
				$InvoiceEntry = $arryOrder[0]['InvoiceEntry'];
				$income_id = $arryOrder[0]['IncomeID'];
			}
			//pr($arryOrder);exit;			
			/*****************/ 	
			$ArrayFieldName = $this->GetFieldName('s_order');
			foreach($ArrayFieldName as $key=>$values){
				if($values['Key'] != 'PRI' && $values['Field']!='AutoID'){
					$FeildAndValuesArray[] = "`".$values['Field']."`";
				} 	 
			}
			$FeildAndValues = implode(", ",$FeildAndValuesArray);
			/*****************/ 		
			$strSQLQuery = "insert into s_order (".$FeildAndValues.") select ".$FeildAndValues."  FROM s_order
			where OrderID = '".$order_id."'";	
			$this->query($strSQLQuery, 0);			
			$OrderID = $this->lastInsertId();
			if($OrderID>0 && $income_id>0){					
				if($InvoiceEntry==2 || $InvoiceEntry==3){ 
					/*****************/
					$ArrayFieldName3 = $this->GetFieldName('f_income');
					foreach($ArrayFieldName3 as $key=>$values){
						if($values['Key'] != 'PRI'){ 
							$FeildAndValuesArray3[] = "`".$values['Field']."`";
						} 	 
					}
					$FeildAndValues3 = implode(", ",$FeildAndValuesArray3);
					/*****************/
					$strSQLIncome = "insert into f_income (".$FeildAndValues3.") select ".$FeildAndValues3."  FROM f_income where IncomeID = '".$income_id."'";		
					$this->query($strSQLIncome, 0);			
					$IncomeID = $this->lastInsertId();
					$strAdd = " , InvoiceDate ='" .$Config['TodayDate']."' , InvoicePaid='Unpaid' , IncomeID='".$IncomeID."' ";
				
					/*****************/
					$strSQL = "update s_order set  SaleID = '', QuoteID = '',CreditID='', InvoiceID='', EntryType = 'one_time', OrderPaid='0', PickID ='', batchId='0', PostToGL='0', PostToGLDate='', ShippedDate='', StatusMsg='', Fee='', ClosedDate = '', LastRecurringEntry ='', IPAddress='".$IPAddress."', Parent='".$order_id."', DeliveryDate = '', PostedDate='".$Config['TodayDate']."' , CreatedDate='".$Config['TodayDate']."' ,UpdatedDate='".$Config['TodayDate']."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PdfFile='' ".$strAdd." where OrderID='" .$OrderID. "'";	
						
					$this->query($strSQL, 0); 
					$objConfigure = new configure();
					$objConfigure->UpdateModuleAutoID('s_order',$Module,$OrderID,'');			
					/*****************/
					$arrySale = $this->GetSale($OrderID,'','');	
					$InvoiceID = $arrySale[0]["InvoiceID"];
					/*****************/
					$strSQL = "update f_income set  InvoiceID='".$InvoiceID."', PaymentDate ='" .$Config['TodayDate']."'  where IncomeID='" .$IncomeID. "'";	
					$this->query($strSQL, 0);
 
					$strSQLInc = "select GlEntryType  from f_income  where IncomeID = '".$IncomeID."'";
		        		$arryIncome=$this->query($strSQLInc,1);					 
					if($arryIncome[0]['GlEntryType'] == "Multiple"){
						/*****************/	
						$ArrayFieldName4 = $this->GetFieldName('f_multi_account');
						foreach($ArrayFieldName4 as $key=>$values){
							if($values['Key'] != 'PRI'){ 
								$FeildAndValuesArray4[] = "`".$values['Field']."`";
							} 	 
						}
						$FeildAndValues4 = implode(", ",$FeildAndValuesArray4);	
						/*****************/
						$sqlM = "select * FROM f_multi_account where IncomeID = '".$income_id."'";
						$arryMultiple = $this->query($sqlM, 1);
						/*****************/ 				
						foreach($arryMultiple as $key=>$values){
							 $strSQLQuery = "insert into f_multi_account (".$FeildAndValues4.") SELECT ".$FeildAndValues4." FROM f_multi_account WHERE IncomeID = '".$income_id."' and ID = '".$values['ID']."'";
							$this->query($strSQLQuery, 0);
							$ID = $this->lastInsertId();
							if(!empty($ID)){					
								$strSQL = "update f_multi_account set IncomeID ='" .$IncomeID."'  where ID='" .$ID. "'";
								$this->query($strSQL, 0);
							}
						}
						/*****************/	
 
					}
					/*****************/

				}
				return $InvoiceID;
			}
		}
		
	 }

function  ListSalePick($arryDetails,$CustomerID=0)
		{
			global $Config;
			extract($arryDetails);

		
			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "SaleID"; 
			}
			
			$AdminID=$_SESSION['AdminID'];
			if($AdminID=='') $AdminID=$_SESSION['UserData']['AdminID'];
           
			if($module == "Invoice"){ $moduledd = 'Invoice';}else{$moduledd = 'Order';}
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));

			if((!empty($CustomerID) && $CustomerID!='0')){
				$strAddQuery .= " and o.CustID='".mysql_real_escape_string($CustomerID)."'";
			}else{
				$strAddQuery .= ($_SESSION['vAllRecord']!=1)?(" and (o.SalesPersonID='".$AdminID."' or o.AdminID='".$AdminID."') "):(""); 
			}




			$strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
			$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
			$strAddQuery .= (!empty($FromDateShip))?(" and o.OrderDate>='".$FromDateShip."'"):("");
			$strAddQuery .= (!empty($ToDateShip))?(" and o.OrderDate<='".$ToDateShip."'"):("");		
			$strAddQuery .= (!empty($batchId))?(" and o.batchId!='".$batchId."'"):("");

			 if($CREDIT_APP=='Credit Approved'){
				$strAddQuery .= " and (o.PaymentTerm not in ('Credit Card','PayPal') or o.OrderPaid in (1,3)) and o.Approved='1' ";
			}

     
                        
			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
				$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or o.TrackingNo like '%".$SearchKey."%' ) " ):("");	
			}

			if(!empty($Status)){
				$strAddQuery .= " and o.Status='".$Status."'";	
				$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			}


			$strAddQuery .= (!empty($Approved))?(" and o.Approved='1'"):("");
			$strAddQuery .= (!empty($PostToGL))?(" and o.PostToGL='1'"):("");
$strAddQuery .= (!empty($Pick))?(" and (o.PickID!='' or i.DropShipCheck=1) "):(" and i.DropShipCheck!=1 ");

 
			if(!empty($ToApprove)){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}
			//$strAddQuery .= " and i.DropShipCheck =0 ";	
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");

			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.ReturnID = '' and o.Status != 'Cancelled'"):(" ");
			/********* By Karishma for MultiStore 22 Dec 2015******/
			$batchCol = $join = '';
			if($Config['batchmgmt']==1 && $module ='Order' && $Droplist!=1 ){
						$batchCol = ",b.status as BatchStatus";
						$join = " left outer join batchmgmt b on o.batchId=b.batchId  ";
						$strAddQuery .=" and o.Status!='Completed' and (o.batchId=0 or b.status!='Closed')  ";
				//$strAddQuery .=" or (b.status!='Closed' and o.batchId=0 and o.Module='Order') ";
				 
			}

if($Droplist==1){

$batchCol = ",b.PostToGL ";
						$join = " left outer join s_order b on o.SaleID=b.SaleID ";
						$strAddQuery .=" and b.PostToGL=0  ";

}

			//$s_item_order = " inner join s_order_item i on (o.OrderID=i.OrderID and i.qty!=i.qty_invoiced ) ";
			
			//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by o.".$moduledd."Date desc, o.OrderID desc ");
						
			if($Config['GetNumRecords']==1){
				$batchCol = '';
				$Columns = " count(distinct(o.OrderID)) as NumCount ";				
			}else{	
				
			//if($Config['batchmgmt']==1 && $module ='Order' && $Droplist!=1 ){
					$strAddQuery .=  " group by o.OrderID ";      
				//}


				//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by o.".$moduledd."Date desc, o.OrderID desc ");
				//$strAddQuery .= (!empty($sortby))?(" group by o.OrderID order by ".$sortby." ".$asc):(" group by o.OrderID order by o.".$moduledd."Date desc, o.OrderID desc ");
			
				//$Columns = "  o.*,i.DropShipCheck,SUM(i.qty) as orderqty ,SUM(i.qty_shipped) as totship ";
$Columns = "  o.*,i.DropShipCheck  ";
$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by o.".$moduledd."Date desc, o.OrderID desc ");
				if($Config['RecordsPerPage']>0){
					$strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
				}
				
			}
//$strSQLQuery = "select ".$Columns." ".$batchCol."  from s_order o left outer join s_order_item i on o.OrderID=i.OrderID  ".$join."  " . $strAddQuery;
		         $strSQLQuery = "select ".$Columns." ".$batchCol."  from s_order o inner join s_order_item i on (o.OrderID=i.OrderID and i.qty!=i.qty_invoiced ) ".$join."  " . $strAddQuery;
 
			return $this->query($strSQLQuery, 1);		
				
		}


	function  GetTotalSO($Year,$FromDate,$ToDate,$CustCode,$SalesPID,$Status)
		{

			$strAddQuery = "";
      $strAddQuery .= (!empty($Year))?(" and YEAR(o.OrderDate)='".$Year."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");

			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($SalesPID))?(" and o.SalesPersonID='".$SalesPID."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.Status!='".$Status."'"):("");

			$strSQLQuery = "select SUM(o.TotalAmount) as TotalOrder,o.CustomerCurrency  from s_order o where o.Module='Order'   ".$strAddQuery." group by o.CustomerCurrency order by o.OrderDate desc";
				//echo "=>".$strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}
function StockItemOnHand($OrderID){


       $sql = "SELECT * FROM s_order_item where OrderID ='".$OrderID."' and `Condition`!=''  order BY OrderID";
        $rslT = $this->query($sql, 1);


				$onhandQty=0;
				foreach($rslT as $value){

							$Condition = $value['Condition'];
							$WID  = $value['WID'];
							$ItemID = $value['item_id'];

							$strSQLQuery = "select condition_qty as onHanqty,ItemID,WID,`condition`  from inv_item_quanity_condition where `condition`='".$Condition."' and `WID`='".$WID."' and `ItemID`='".$ItemID."' ";
							$rs = $this->query($strSQLQuery, 1);

							$onhand = 0;
							if(!empty($rs[0]['onHanqty'])){
							if($rs[0]['onHanqty']>=$value['qty']) {
								$onhand = $value['qty']; 
							} 
							}
							$onhandQty +=$onhand;

				}
 
	
		 
		return 	$onhandQty;
}

function SalesOrderQty($OrderID){

			$sql = "SELECT SUM(qty) as OrderQty FROM s_order_item where OrderID ='".$OrderID."' and `Condition`!=''  group BY OrderID";
			  $rslT = $this->query($sql, 1);

			if(!empty($rslT[0]['OrderQty'])){

			     $OrderQty = $rslT[0]['OrderQty'];

			}else{
			      $OrderQty = 0;

			}
return $OrderQty;

}

function  SearchSerialNumber($arryDetails)
			{
	global $Config;
				extract($arryDetails);

				$strSQLQuery = "select Sku,`Condition`,LineID,UnitCost,serialNumber,serialID,UsedSerial,Status from inv_serial_item where Status='1' and `Condition`='".$Condition."' and `warehouse`='".$WID."' and serialNumber='".$SerialNo."'  and Sku='".$Sku."' ";

				$rs =  $this->query($strSQLQuery, 1);
				if(!empty($rs[0]['serialID'])){
							$strUpdateQuery = "update inv_serial_item set UsedSerial = '1',LineID='".$LineID."' where serialID =  '".$rs[0]['serialID']."'  ";
						   $this->query($strUpdateQuery, 0);

							  return $rs;

				}else{

				       return 0;
				}

}

function UpdateSerialNumber($arryDetails){
				extract($arryDetails);
				$strUpdateQuery = "update inv_serial_item set UsedSerial = 0,LineID=0 where LineID =  '".$LineID."'  ";
				$this->query($strUpdateQuery, 0);
				return 1;

}

//added by Nisha for sales history
/**
 * This function is used to get sales history per customer
 * @param array $arryDetails 
 * @return array 
 */
function ListCustomerSales($arryDetails) {
	global $Config;
	extract($arryDetails);
	
	
    if($module == "Invoice"){ $moduledd = 'Invoice';}else{$moduledd = 'Order';}
	$strAddQuery = " where o.NoUse='0' ";
			$SearchKey   = strtolower(trim($key));

			if(!empty($CustCode)){
				$strAddQuery .= " and o.CustCode='".mysql_real_escape_string($CustCode)."'";
			}else if($_SESSION['vAllRecord']!=1){
				$strAddQuery .= " and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') ";				
			}
	 $strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
	$DateColumn = "o.".$moduledd.'Date';
	           if($fby=='Year'){
					$strAddQuery .= " and YEAR(".$DateColumn.")='".$y."'";
				}else if($fby=='Month'){
					$strAddQuery .= " and MONTH(".$DateColumn.")='".$m."' and YEAR(".$DateColumn.")='".$y."'";
				}else{
					$strAddQuery .= (!empty($f))?(" and ".$DateColumn.">='".$f."'"):("");
					$strAddQuery .= (!empty($t))?(" and ".$DateColumn."<='".$t."'"):("");
				}
			
	
    
	          $strAddQuery .= " and o.InvoiceID != '' and o.ReturnID = ''";
	          $strAddQuery .= (!empty($PostToGL))?(" and o.PostToGL='".$PostToGL."'"):("");
	          $strAddQuery .= " and o.InvoicePaid IN('Part Paid','Paid')";
	
	            
	          if($Config['GetNumRecords']==1) {
				$Columns = " count(o.OrderID) as NumCount ";				
	         }
	        else {
		        $strAddQuery .=" GROUP BY MONTH(o.InvoiceDate),YEAR(o.InvoiceDate)";
		        $strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by o.InvoiceDate ASC");
		
		       $Columns = "  o.OrderID, COUNT(DISTINCT(o.InvoiceID)) as TotalInvoiceNo, SUM(DISTINCT(o.TotalInvoiceAmount)) as TotalInvoiceAmount,o.InvoiceDate, SUM(i.amount) as amount   ";
		
                 if($Config['RecordsPerPage']>0) {
				    $strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
	             }
		
         }
	    $strSQLQuery = "select ".$Columns." from s_order o left outer join s_order_item i on o.OrderID=i.OrderID ".$join." ".$strAddQuery;
	
    return $this->query($strSQLQuery, 1);
}

//added by Nisha for sales history
/**
 * This function is used to get cash received per customer
 * @param array $arryDetails
 * @param string $dateRange 
 * @return array 
 */
function getCashReciviedByDate($arryDetails,$dateRange="") {
    global $Config;
	
	extract($arryDetails);
	$SearchKey   = strtolower(trim($key));

			if(!empty($CustID)){
				
			    $strAddQuery .= " and t.CustID='".mysql_real_escape_string($CustID)."'";
			}
	        $moduledd="Payment";
	        $DateColumn = "t.".$moduledd.'Date';
				
					if(!empty($dateRange)) { $strAddQuery .=" and MONTH(".$DateColumn.")='".$dateRange."'"; }
				    $strAddQuery .= (!empty($f))?(" and YEAR(".$DateColumn.")>='".$f."'"):("");
                    $strAddQuery .= (!empty($t))?(" and YEAR(".$DateColumn.")<='".$t."'"):("");
			
	     
	    if($Config['GetNumRecords']==1) {
				$Columns = " count(distinct(t.TransactionID)) as NumCount ";				
	      }
	       else {
		        $strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):("  order by t.TransactionID ASC");
		
		      $Columns = " SUM(DECODE(t.TotalAmount,'". $Config['EncryptKey']."')) as TotalAmount";
		
                 if($Config['RecordsPerPage']>0) {
				    $strAddQuery .= " limit ".$Config['StartPage'].",".$Config['RecordsPerPage'];
	             }
		
          }
	
        $strSQLQuery = "select ".$Columns." from f_transaction t  where t.PaymentType = 'Sales' and t.Voided=0 ".$strAddQuery; 
	
return $rs = $this->query($strSQLQuery, 1);
}

		function GetSalesTotalTransaction($OrderID,$PaymentTerm){
			global $Config;
			$AddSql='';
			if(!empty($Config["CreditOrderID"])) $AddSql .= " and t.CreditOrderID='".$Config["CreditOrderID"]."' ";
			 $strSQLQuery = "select SUM(if(TransactionType='Charge', t.TotalAmount, 0)) as TotalCharge, SUM(if(TransactionType='Void', t.TotalAmount, 0)) as TotalVoid from s_order_transaction t inner join s_order o on t.OrderID=o.OrderID where t.OrderID='".$OrderID."' and t.PaymentTerm='".$PaymentTerm."' ".$AddSql." order by ID desc"; 
			return $this->query($strSQLQuery, 1);			 
		}

		function GetTotalTransactionBySaleID($SaleID,$PaymentTerm){
			global $Config;
			$AddSql='';
			if(!empty($SaleID)){
				if(!empty($Config["CreditOrderID"])) $AddSql .= " and t.CreditOrderID='".$Config["CreditOrderID"]."' ";
				$strSQLQuery = "select SUM(if(TransactionType='Charge', t.TotalAmount, 0)) as TotalCharge, SUM(if(TransactionType='Void', t.TotalAmount, 0)) as TotalVoid  from s_order_transaction t inner join s_order o on t.OrderID=o.OrderID left outer join f_payment_provider p on t.ProviderID=p.ProviderID where o.Module in ('Invoice','Order') and o.SaleID='".$SaleID."' and t.PaymentTerm='".$PaymentTerm."' ".$AddSql." order by t.ID desc"; 
				return $this->query($strSQLQuery, 1);	
			}		 
		}
		/*****************Commission Report**********************/
		function  SalesCommissionReport($FromDate,$ToDate,$SalesPersonID,$SalesPersonType=0)
		{
                        global $Config;
			$strAddQuery = "";			
			if(!empty($FromDate) && !empty($ToDate)){				
				$strAddQuery .= " and CASE WHEN c.CommOn='1' THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END = 1  ";
			}

			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

			if($SalesPersonType=="1"){
				$SalesPersonCol = " IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as SalesPerson";
				$comCondition = "inner join h_commission c on o.SalesPersonID=c.SuppID inner join p_supplier s on o.SalesPersonID=s.SuppID ";
			}else{
				$SalesPersonCol = " e.UserName as SalesPerson";
				$comCondition = " inner join h_commission c on o.SalesPersonID=c.EmpID inner join h_employee e on o.SalesPersonID=e.EmpID ";
			}

			if($Config['ConversionType']==1){
				$ConvertedAmount =  "(o.TotalInvoiceAmount-o.taxAmnt)/(o.ConversionRate)" ;
			}else{
				$ConvertedAmount = "(o.TotalInvoiceAmount-o.taxAmnt)*(o.ConversionRate)";
			}


			$strSQLQuery = "select o.SalesPersonID, sum(IF(c.CommPaidOn='Paid', DECODE(p.DebitAmnt,'". $Config['EncryptKey']."'), ".$ConvertedAmount.")) as TotalSales , ".$SalesPersonCol." , o.OrderID as InID,c.CommOn,c.CommPaidOn, sum(i.qty_invoiced) as QtyInvoiced,sum(i.avgCost) as Cost from s_order o ".$comCondition." left outer join f_payments p on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='')  left outer join s_order_item i on o.OrderID=i.OrderID where o.Module='Invoice' and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1' and o.SalesPersonType='".$SalesPersonType."'  ".$strAddQuery." group by o.SalesPersonID order by SalesPerson asc";
 
				
			return $this->query($strSQLQuery, 1);		
		}
		
		/*****************Commission Report Summary**********************/
		function  CommReport($CommOn, $FromDate,$ToDate,$SalesPersonID,$SalesPersonType=0)
		{
                        global $Config;
 
 
			$strAddQuery = "";
			
			$strAddQuery .= (!empty($SalesPersonID))?(" and o.SalesPersonID='".$SalesPersonID."'"):("");

			$strAddQuery .= " and o.SalesPersonType='".$SalesPersonType."'";
						
			if($SalesPersonType=="1"){
				$SalesPersonCol = " IF(s.SuppType = 'Individual' and s.UserName!='', s.UserName, s.CompanyName) as SalesPerson";
				$comCondition = "inner join h_commission c on o.SalesPersonID=c.SuppID inner join p_supplier s on o.SalesPersonID=s.SuppID ";
			}else{
				$SalesPersonCol = " e.UserName as SalesPerson";
				$comCondition = " inner join h_commission c on o.SalesPersonID=c.EmpID inner join h_employee e on o.SalesPersonID=e.EmpID ";
			}
			 
			if($CommOn=="1"){ //per invoice payment
				$groupby = 'group by  o.InvoiceID,p.PaymentDate,p.PaymentID';
				$orderby = ' order by p.PaymentDate desc, p.PaymentID desc, o.OrderID desc ';
				$DateCol = 'p.PaymentDate';
			}else{
				$groupby = 'group by  o.InvoiceID ';
				$orderby = ' order by o.InvoiceDate desc, o.OrderID desc';
				$DateCol = 'o.InvoiceDate';
			}
			 
			
			if(!empty($FromDate) && !empty($ToDate)){				 
				$strAddQuery .= " and ".$DateCol." >='".$FromDate."' and ".$DateCol."<='".$ToDate."' ";
			}
					 
 
			 $strSQLQuery = "select p.*, SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as DebitAmnt, SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as CreditAmnt, ".$SalesPersonCol." ,  o.InvoiceDate,o.Fee,o.OrderDate,o.InvoiceID as MainInvoiceID, o.OrderID as InID,o.CustomerName,o.SalesPersonID, o.InvoicePaid, o.TotalAmount, o.TotalInvoiceAmount, o.Freight, o.Fee, o.taxAmnt, o.ConversionRate, o.CustomerCurrency, c.CommOn,c.CommPercentage,c.CommPaidOn from s_order o ".$comCondition."  left outer join f_payments p  on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='')  where o.Module='Invoice' and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1' and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid')  ELSE 1 END = 1 ".$strAddQuery."  ".$groupby.$orderby;
			 
			 //echo $strSQLQuery.'<br>';
				
			return $this->query($strSQLQuery, 1);		
		}
		/*****************On Total Amount**********************/
		function  GetInvPayment($FromDate,$ToDate,$EmpID,$SuppID=0,$OrderID=0)
		{
                        global $Config;
			$strAddQuery = "";			 
			if(!empty($FromDate) && !empty($ToDate)){				
				$strAddQuery .= " and o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."' ";
			}
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		
	
			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}

			if($Config['ConversionType']==1){
				$ConvertedAmount =  "(o.TotalInvoiceAmount-o.taxAmnt)/(o.ConversionRate)" ;
			}else{
				$ConvertedAmount = "(o.TotalInvoiceAmount-o.taxAmnt)*(o.ConversionRate)";
			}

			$strSQLQuery = "select sum(".$ConvertedAmount.") as TotalSales from s_order o   inner join h_commission c on ".$comCondition." where o.Module='Invoice'  and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1  group by o.SalesPersonID";

			$arryRow = $this->query($strSQLQuery, 1);

			if(isset($arryRow[0]['TotalSales'])) return $arryRow[0]['TotalSales'];
				
		}
	


		function  GetInvPaymentNonResidual($FromDate,$ToDate,$EmpID,$SuppID=0,$OrderID=0)
		{
                        global $Config;
			$strAddQuery = "";
			if(!empty($FromDate) && !empty($ToDate)){				
				$strAddQuery .= "  and o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."' ";
			}

       			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		

			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}	

			 $sql_invoice = "select o.InvoiceID from s_order o inner join h_commission c on ".$comCondition."  where o.Module='Invoice' and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1'  ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by o.InvoiceID order by o.InvoiceDate asc,o.OrderID asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);
 
		
			if(!empty($arryInvoice[0]["InvoiceID"])){

				if($Config['ConversionType']==1){
					$ConvertedAmount =  "(o.TotalInvoiceAmount-o.taxAmnt)/(o.ConversionRate)" ;
				}else{
					$ConvertedAmount = "(o.TotalInvoiceAmount-o.taxAmnt)*(o.ConversionRate)";
				}


				$strSQLQuery = "select sum(".$ConvertedAmount.") as TotalSales from s_order o  where o.Module='Invoice' and o.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." group by o.SalesPersonID";
			
				$arryRow = $this->query($strSQLQuery, 1);
				return $arryRow[0]['TotalSales'];
			}
		
				
		}



		/*****************On Per Invoice Payment**********************/

		function  GetInvPaymentPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID=0)
		{
                        global $Config;
			$strAddQuery = "";
			if(!empty($FromDate) && !empty($ToDate)){				
				$strAddQuery .= " and CASE WHEN c.CommOn='Paid' THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END = 1  ";
			}		
			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}


			 $strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') inner join h_commission c on ".$comCondition." where o.Module='Invoice'  and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1' and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 ".$strAddQuery." ";

		// echo  $strSQLQuery.'<br>';
			return $this->query($strSQLQuery, 1);
							
		}

		function  GetInvPaymentNonResidualPer($PaymentID,$FromDate,$ToDate,$EmpID,$SuppID=0)
		{
                        global $Config;
			$strAddQuery = "";
			if(!empty($FromDate) && !empty($ToDate)){				
				$strAddQuery .= " and CASE WHEN c.CommPaidOn='Paid' THEN (p.PaymentDate>='".$FromDate."' and p.PaymentDate<='".$ToDate."') ELSE  (o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."') END = 1  ";
			} 
 			
			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}

			 $sql_invoice = "select p.InvoiceID from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='') inner join h_commission c on ".$comCondition." where o.Module='Invoice' and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by p.InvoiceID order by p.PaymentDate asc,p.PaymentID asc limit 0,1";
			$arryInvoice = $this->query($sql_invoice, 1);
			 
			$strAddQuery .= (!empty($PaymentID))?(" and p.PaymentID='".$PaymentID."'"):("");
			if(!empty($arryInvoice[0]["InvoiceID"])){
				 $strSQLQuery = "select DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as TotalSales from f_payments p left outer join s_order o on (p.InvoiceID=o.InvoiceID and p.PaymentType='Sales' and p.InvoiceID!='')  where o.Module='Invoice'   and p.InvoiceID='".$arryInvoice[0]["InvoiceID"]."' ".$strAddQuery." ";
				 
				return $this->query($strSQLQuery, 1);
			}
			
				
		}

		/*****************On Per Invoice Payment**********************/




		/****************************************/
		function  GetInvPaymentMargin($FromDate,$ToDate,$EmpID,$SuppID=0,$OrderID=0)
		{
                        global $Config;
			$strAddQuery = "";
			if(!empty($FromDate) && !empty($ToDate)){
				$strAddQuery .= "  and o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."' ";
			}
			 			 
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		

			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}

			if($Config['ConversionType']==1){
				$ConvertedAmount =  "(o.TotalInvoiceAmount-o.taxAmnt)/(o.ConversionRate)" ;
			}else{
				$ConvertedAmount = "(o.TotalInvoiceAmount-o.taxAmnt)*(o.ConversionRate)";
			}


			  $strSQLQuery = "select  sum(".$ConvertedAmount.") as TotalSales, o.CustomerCurrency,o.ConversionRate,o.OrderID as InID, o.InvoiceID, o.TotalInvoiceAmount,o.Freight,o.Fee ,o.TDiscount,c.CommPaidOn  from s_order o inner join h_commission c on ".$comCondition." where o.Module='Invoice' and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1'  ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by o.InvoiceID order by o.InvoiceDate asc, o.OrderID asc";
			 
			return $this->query($strSQLQuery, 1);
							
		}

		function  GetInvPaymentNonResidualMargin($FromDate,$ToDate,$EmpID,$SuppID=0,$OrderID=0)
		{
                        global $Config;
			$strAddQuery = "";
			if(!empty($FromDate) && !empty($ToDate)){
				$strAddQuery .= " and o.InvoiceDate>='".$FromDate."' and o.InvoiceDate<='".$ToDate."' ";
			} 
 			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");		
				
			$comCondition = 'o.SalesPersonID=c.EmpID';
			if(!empty($SuppID)){			
				$strAddQuery .= " and o.SalesPersonID='".$SuppID."' and o.SalesPersonType='1' "; 
				$comCondition = 'o.SalesPersonID=c.SuppID';

			}else if(!empty($EmpID)){	
				$strAddQuery .= " and o.SalesPersonID='".$EmpID."' and o.SalesPersonType='0' "; 	 
			}	

			 $strSQLQuery = "select  o.InvoiceID from s_order o  inner join h_commission c on ".$comCondition." where o.Module='Invoice'  and o.SalesPerson!='' and o.SalesPersonID>0 and o.PostToGL='1' ".$strAddQuery." and CASE WHEN c.CommPaidOn='Paid' THEN o.InvoicePaid in ('Paid','Part Paid') ELSE 1 END = 1 group by o.InvoiceID order by o.InvoiceDate asc, o.OrderID asc limit 0,1";

			return $this->query($strSQLQuery, 1);
							
		}

	

}
?>
