<?php 
                 
$RightArray='';
        
if($ThisPageName=='viewAccount.php'){ //done
	$RightArray = array
	(
		array("label" => "Account Name",  "value" => "f.AccountName"),
		array("label" => "Account Number",  "value" => "f.AccountNumber"),
		array("label" => "Account Code",  "value" => "f.AccountCode")
		
	); 
}else if($ThisPageName=='viewAccountType.php'){ //done
	$RightArray = array
	(
		array("label" => "Account Type",  "value" => "t.AccountType"),
		array("label" => "Status",  "value" => "t.Status")
	); 
}else if($ThisPageName=='viewSalesPayments.php'){ //done
	$RightArray = array
	(
		array("label" => "Invoice Number",  "value" => "p.InvoiceID"),
		array("label" => "GL Code",  "value" => "b.AccountNumber"),
		array("label" => "Credit Memo",  "value" => "p.CreditID"),
		array("label" => "Payment Date",  "value" => "p.PaymentDate"),
		array("label" => "SO Number",  "value" => "p.SaleID"),
		array("label" => "Customer",  "value" => "o.CustomerName"),
		array("label" => "Amount",  "value" => "p.DebitAmnt")
	); 
}else if($ThisPageName=='viewCustomer.php'){ //done
	$RightArray = array
	(
		array("label" => "Customer Code",  "value" => "c1.CustCode"),
		array("label" => "Customer",  "value" => "c1.FullName"),
		array("label" => "Email Address",  "value" => "c1.Email"),
                array("label" => "Country",  "value" => "ab.CountryName"),
		array("label" => "State",  "value" => "ab.StateName"),
		array("label" => "Phone",  "value" => "c1.Landline"),
		array("label" => "Status",  "value" => "c1.Status")
	); 
}else if($ThisPageName=='viewInvoice.php'){ //done
	$RightArray = array
	(
		array("label" => "Invoice Number",  "value" => "o.InvoiceID"),
		array("label" => "SO Number",  "value" => "o.SaleID"),
		array("label" => "Customer",  "value" => "o.CustomerName"),
	  array("label" => "Customer Po",  "value" => "o.CustomerPO"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.CustomerCurrency"),
		array("label" => "Status",  "value" => "o.InvoicePaid"),
		array("label" => "Tracking Number",  "value" => "o.TrackingNo")

	); 
}else if($ThisPageName=='viewCreditNote.php'){ //done
	$RightArray = array
	(
		array("label" => "Credit Memo ID",  "value" => "o.CreditID"),
		array("label" => "Invoice ID",  "value" => "o.InvoiceID"),
		array("label" => "Customer",  "value" => "o.CustomerName"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.CustomerCurrency")
	); 
}else if($ThisPageName=='viewPurchasePayments.php'){ //done
	$RightArray = array
	(
		array("label" => "Invoice Number",  "value" => "p.InvoiceID"),
		array("label" => "Reference No",  "value" => "p.ReferenceNo"),
		array("label" => "Vendor",  "value" => "o.SuppCompany")
	); 
}else if($ThisPageName=='viewSupplier.php'){ //done
	$RightArray = array
	(
		array("label" => "Vendor Code",  "value" => "s.SuppCode"),
		array("label" => "Vendor Type",  "value" => "s.SuppType"),
		array("label" => "Vendor Name",  "value" => "VendorName"),
		array("label" => "Country",  "value" => "ab.Country"),
                array("label" => "State",  "value" => "ab.State"),
		array("label" => "City",  "value" => "ab.City"),
		array("label" => "Currency",  "value" => "s.Currency")
	); 
}else if($ThisPageName=='viewPoInvoice.php'){ //done
	$RightArray = array
	(
		array("label" => "Invoice Number",  "value" => "o.InvoiceID"),
		array("label" => "PO Number",  "value" => "o.PurchaseID"),
		array("label" => "Vendor",  "value" => "o.SuppCompany"),
                array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.Currency"),
		array("label" => "Invoice Paid",  "value" => "o.InvoicePaid"),
		array("label" => "Tracking Number",  "value" => "o.TrackingNo")
	); 
}else if($ThisPageName=='viewVendorInvoiceEntry.php'){ //done
	$RightArray = array
	(
		array("label" => "Invoice Number",  "value" => "o.InvoiceID"),		
		array("label" => "Vendor",  "value" => "o.SuppCompany"),
                array("label" => "Amount",  "value" => "o.TotalAmount"),
		array("label" => "Currency",  "value" => "o.Currency"),
		array("label" => "Invoice Paid",  "value" => "o.InvoicePaid")
	); 
}else if($ThisPageName=='viewPoCreditNote.php'){ //done
	$RightArray = array
	(
		array("label" => "Credit Memo ID",  "value" => "o.CreditID"),
		array("label" => "Vendor",  "value" => "o.SuppCompany"),
		array("label" => "Amount",  "value" => "o.TotalAmount"),
                array("label" => "Currency",  "value" => "o.Currency"),
		array("label" => "Status",  "value" => "o.Status"),
		array("label" => "Approved",  "value" => "o.Approved")
	); 
}else if($ThisPageName=='viewGeneralJournal.php'){ //done
	$RightArray = array
	(
		array("label" => "Journal No",  "value" => "j.JournalNo"),
		array("label" => "Memo",  "value" => "j.JournalMemo"),
		array("label" => "Debit Amount",  "value" => "j.TotalDebit"),
		array("label" => "Credit Amount",  "value" => "j.TotalCredit"),
		array("label" => "Currency",  "value" => "j.Currency")
	); 
}else if($ThisPageName=='viewTransfer.php'){ //done
	$RightArray = array
	(
		array("label" => "Reference No",  "value" => "t.ReferenceNo"),
		array("label" => "Amount",  "value" => "t.TotalAmount")
	); 
}else if($ThisPageName=='viewDeposit.php'){ //done
	$RightArray = array
	(
		array("label" => "Reference No",  "value" => "d.ReferenceNo"),
		array("label" => "Amount",  "value" => "d.Amount")
	); 
}else if($ThisPageName=='viewCashReceipt.php'){ //done
$RightArray = array
(
	array("label" => "Cash Receipt No",  "value" => "t.ReceiptID"),
	array("label" => "Total Amount",  "value" => "t.TotalAmount"),
	array("label" => "Check Number",  "value" => "t.CheckNumber")
); 
}else if($ThisPageName=='viewVendorPayment.php'){ //done
$RightArray = array
(
	array("label" => "Payment No",  "value" => "t.ReceiptID"),
	array("label" => "Total Amount",  "value" => "t.TotalAmount"),
	array("label" => "Check Number",  "value" => "t.CheckNumber")
); 
}
		                     
                    
						        



/*******************/
if(!empty($RightArray)){
	foreach($RightArray as $values){
		$arryRightCol[] = $values['value'];
	}
}

$arryRightOrder = array('Asc','Desc');
/*******************/
if(!empty($_GET['sortby'])){
	if(!in_array($_GET['sortby'],$arryRightCol)){
		$_GET['sortby']='';
	}
}
if(!empty($_GET['asc'])){
	if(!in_array($_GET['asc'],$arryRightOrder)){
		$_GET['asc']='';
	}
}
/*****************/


/*************************************/
/*************************************/



?>
