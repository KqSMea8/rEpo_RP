<?php

if ($_GET['type'] == 'Journal') {

    $ThisPageName = 'viewGeneralJournal.php';
    $column = array
        (
        array("colum_name" => "Journal No", "table_name" => "p_order", "colum_value" => "JournalNo"),
        array("colum_name" => "Journal Date", "table_name" => "p_order", "colum_value" => "JournalDate"),
        array("colum_name" => "Memo", "table_name" => "p_order", "colum_value" => "JournalMemo"),
        array("colum_name" => "Debit", "table_name" => "p_order", "colum_value" => "TotalDebit"),
        array("colum_name" => "Credit", "table_name" => "p_order", "colum_value" => "TotalCredit")
    );

    $column2 = array
        (
        array("colum_name" => "Journal No", "table_name" => "p_order", "colum_value" => "JournalNo"),
        //array("colum_name" => "Journal Date", "table_name" => "p_order", "colum_value" => "JournalDate"),
        array("colum_name" => "Memo", "table_name" => "p_order", "colum_value" => "JournalMemo"),
        array("colum_name" => "Debit", "table_name" => "p_order", "colum_value" => "TotalDebit"),
        array("colum_name" => "Credit", "table_name" => "p_order", "colum_value" => "TotalCredit")
    );
} else if ($_GET['type'] == 'Transfer') {
    $ThisPageName = 'viewTransfer.php';
    $column = array
        (
        array("colum_name" => "Transfer From", "table_name" => "p_order", "colum_value" => "TransferFrom"),
        array("colum_name" => " Transfer To", "table_name" => "p_order", "colum_value" => "TransferTo"),
        array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "TransferAmount"),
        array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        array("colum_name" => "Transfer Date", "table_name" => "p_order", "colum_value" => "TransferDate"),
        array("colum_name" => "ReferenceNo", "table_name" => "p_order", "colum_value" => "ReferenceNo")
        
    );

    $column2 = array
        (
       array("colum_name" => "Transfer From", "table_name" => "p_order", "colum_value" => "TransferFrom"),
        array("colum_name" => " Transfer To", "table_name" => "p_order", "colum_value" => "TransferTo"),
        array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "TransferAmount"),
        array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        //array("colum_name" => "Transfer Date", "table_name" => "p_order", "colum_value" => "Status"),
        array("colum_name" => "ReferenceNo", "table_name" => "p_order", "colum_value" => "ReferenceNo")
        
    );
} else if ($_GET['type'] == 'Deposit') {
    $ThisPageName = 'viewDeposit.php';
    $column = array
        (
        array("colum_name" => "Deposit To", "table_name" => "p_order", "colum_value" => "PurchaseID"),     
        array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "Amount"),
        array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        array("colum_name" => "Deposit Date", "table_name" => "p_order", "colum_value" => "DepositDate"),
        array("colum_name" => "Received From", "table_name" => "p_order", "colum_value" => "ReceivedFrom"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Reference No", "table_name" => "p_order", "colum_value" => "ReferenceNo"),
        array("colum_name" => "Payment Description", "table_name" => "p_order", "colum_value" => "Comment")
       
    );

    $column2 = array
        (
        array("colum_name" => "Deposit To", "table_name" => "p_order", "colum_value" => "PurchaseID"),     
        array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "Amount"),
        array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        array("colum_name" => "Deposit Date", "table_name" => "p_order", "colum_value" => "DepositDate"),
        array("colum_name" => "Received From", "table_name" => "p_order", "colum_value" => "ReceivedFrom"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Reference No", "table_name" => "p_order", "colum_value" => "ReferenceNo"),
        array("colum_name" => "Payment Description", "table_name" => "p_order", "colum_value" => "Comment")
    );
} else if ($_GET['type'] == 'Receipt') {
    $ThisPageName = 'viewSalesPayments.php';
    $column = array
        (
        array("colum_name" => "Payment Date", "table_name" => "f_payment", "colum_value" => "PaymentDate"),
        array("colum_name" => "Invoice Number", "table_name" => "f_payment", "colum_value" => "InvoiceID"),
        array("colum_name" => "SO/Reference Number", "f_payment" => "p_order", "colum_value" => "ReferenceNo"),
        array("colum_name" => "Customer", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Entry Type", "table_name" => "f_payment", "colum_value" => "EntryType"),
        array("colum_name" => "Amount", "table_name" => "f_payment", "colum_value" => "DebitAmnt"),
        array("colum_name" => "Currency", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Payment Status", "table_name" => "f_payment", "colum_value" => "InvoicePaid"),
        
    );

    $column2 = array
        (
        //array("colum_name" => "Payment Date", "table_name" => "f_payment", "colum_value" => "PaymentDate"),
        array("colum_name" => " Invoice Number", "table_name" => "f_payment", "colum_value" => "InvoiceID"),
        array("colum_name" => "SO/Reference Number", "f_payment" => "p_order", "colum_value" => "ReferenceNo"),
        array("colum_name" => "Customer", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Entry Type", "table_name" => "f_payment", "colum_value" => "EntryType"),
        array("colum_name" => "Amount", "table_name" => "f_payment", "colum_value" => "DebitAmnt"),
        array("colum_name" => "Currency", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Payment Status", "table_name" => "f_payment", "colum_value" => "InvoicePaid"),
        
    );
} else if ($_GET['type'] == 'Customer') {
    $ThisPageName = 'viewCustomer.php';
    $column = array
        (
        array("colum_name" => "Customer Code", "table_name" => "p_order", "colum_value" => "CustCode"),
        array("colum_name" => "Customer Type", "table_name" => "p_order", "colum_value" => "CustomerType"),
        //array("colum_name" => "First Name", "table_name" => "p_order", "colum_value" => "FirstName"),
       // array("colum_name" => "Last Name", "table_name" => "p_order", "colum_value" => "LastName"),
        array("colum_name" => "Customer Name", "table_name" => "p_order", "colum_value" => "FullName"),
        array("colum_name" => "Email", "table_name" => "p_order", "colum_value" => "Email"),
        array("colum_name" => "Customer Since", "table_name" => "p_order", "colum_value" => "CustomerSince"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Payment Term", "table_name" => "p_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method ", "table_name" => "p_order", "colum_value" => "ShippingMethod"),
        
        array("colum_name" => "Taxable", "table_name" => "p_order", "colum_value" => "Taxable")
    );

    $column2 = array
        (
         array("colum_name" => "Customer Code", "table_name" => "p_order", "colum_value" => "CustCode"),
        array("colum_name" => "Customer Type", "table_name" => "p_order", "colum_value" => "CustomerType"),
        //array("colum_name" => "First Name", "table_name" => "p_order", "colum_value" => "FirstName"),
        //array("colum_name" => "Last Name", "table_name" => "p_order", "colum_value" => "LastName"),
        array("colum_name" => "Customer Name", "table_name" => "p_order", "colum_value" => "FullName"),
        array("colum_name" => "Email", "table_name" => "p_order", "colum_value" => "Email"),
        array("colum_name" => "Customer Since", "table_name" => "p_order", "colum_value" => "CustomerSince"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Payment Term", "table_name" => "p_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method ", "table_name" => "p_order", "colum_value" => "ShippingMethod"),
        
        array("colum_name" => "Taxable", "table_name" => "p_order", "colum_value" => "Taxable")
    );
} else if ($_GET['type'] == 'Invoice') {
    $ThisPageName = 'viewInvoice.php';
    $column = array
        (
        array("colum_name" => "Entry Type", "table_name" => "s_order", "colum_value" => "EntryType"),
        array("colum_name" => "Invoice Number", "table_name" => "s_order", "colum_value" => "InvoiceID"),
        array("colum_name" => "SO/Reference Number", "table_name" => "s_order", "colum_value" => "SaleID"),
        array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"), 
        array("colum_name" => "Status", "table_name" => "s_order", "colum_value" => "InvoicePaid"),
        array("colum_name" => "Amount", "table_name" => "s_order", "colum_value" => "TotalInvoiceAmount"),
        array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "CustomerCurrency"),
        array("colum_name" => "Invoice Date", "table_name" => "s_order", "colum_value" => "InvoiceDate"),
        array("colum_name" => "Ship From", "table_name" => "s_order", "colum_value" => "ShippingName"),
        array("colum_name" => "Comments", "table_name" => "s_order", "colum_value" => "Comment")
    );

    $column2 = array
        (
         array("colum_name" => "Entry Type", "table_name" => "s_order", "colum_value" => "EntryType"),
        array("colum_name" => "Invoice Number", "table_name" => "s_order", "colum_value" => "InvoiceID"),
        array("colum_name" => "SO/Reference Number", "table_name" => "s_order", "colum_value" => "SaleID"),
        array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"), 
        array("colum_name" => "Status", "table_name" => "s_order", "colum_value" => "InvoicePaid"),
        array("colum_name" => "Amount", "table_name" => "s_order", "colum_value" => "TotalInvoiceAmount"),
        array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "CustomerCurrency"),
        //array("colum_name" => "Invoice Date", "table_name" => "s_order", "colum_value" => "InvoiceDate"),
        array("colum_name" => "Ship From", "table_name" => "s_order", "colum_value" => "ShippingName"),
         array("colum_name" => "Comments", "table_name" => "s_order", "colum_value" => "Comment")
        
      
    );
} else if ($_GET['type'] == 'Note') {
    $ThisPageName = 'viewCreditNote.php';
    $column = array
        (
        array("colum_name" => "Credit Note ID", "table_name" => "s_order", "colum_value" => "CreditID"),
        array("colum_name" => " Posted Date", "table_name" => "s_order", "colum_value" => "PostedDate"),
        array("colum_name" => "Total Amount", "table_name" => "s_order", "colum_value" => "TotalAmount"),
        array("colum_name" => "Approved", "table_name" => "s_order", "colum_value" => "Approved"),     
        array("colum_name" => "Expiry Date", "table_name" => "s_order", "colum_value" => "EntryDate"),
        array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"),
        array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "Currency"),
        array("colum_name" => "Status", "table_name" => "s_order", "colum_value" => "Status")
    );

    $column2 = array
        (
       array("colum_name" => "Credit Note ID", "table_name" => "s_order", "colum_value" => "CreditID"),
       array("colum_name" => "Total Amount", "table_name" => "s_order", "colum_value" => "TotalAmount"),
        //array("colum_name" => " Posted Date", "table_name" => "s_order", "colum_value" => "PostedDate"),
        //array("colum_name" => "Expiry Date", "table_name" => "s_order", "colum_value" => "EntryDate"),
       array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"),
       array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "Currency"),
       array("colum_name" => "Status", "table_name" => "s_order", "colum_value" => "Status")
    );
} else if ($_GET['type'] == 'PoReceipt') {
    $ThisPageName = 'viewSalesPayments.php';
    $column = array
        (
        array("colum_name" => "Payment Date", "table_name" => "f_payment", "colum_value" => "PaymentDate"),
        array("colum_name" => "Invoice Number", "table_name" => "f_payment", "colum_value" => "InvoiceID"),
        array("colum_name" => "PO/Reference Number", "f_payment" => "p_order", "colum_value" => "ReferenceNo"),
        array("colum_name" => "Vendor", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Entry Type", "table_name" => "f_payment", "colum_value" => "EntryType"),
        array("colum_name" => "Amount", "table_name" => "f_payment", "colum_value" => "DebitAmnt"),
        array("colum_name" => "Currency", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Payment Status", "table_name" => "f_payment", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Payment Comment ", "table_name" => "f_payment", "colum_value" => "Comment")
    );

    $column2 = array
        (
        array("colum_name" => "Payment Date", "table_name" => "f_payment", "colum_value" => "PaymentDate"),
        array("colum_name" => " Invoice Number", "table_name" => "f_payment", "colum_value" => "InvoiceID"),
        array("colum_name" => "SO/Reference Number", "f_payment" => "p_order", "colum_value" => "ReferenceNo"),
        array("colum_name" => "Customer", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Entry Type", "table_name" => "f_payment", "colum_value" => "EntryType"),
        array("colum_name" => "Amount", "table_name" => "f_payment", "colum_value" => "DebitAmnt"),
        array("colum_name" => "Currency", "table_name" => "f_payment", "colum_value" => "Currency"),
        array("colum_name" => "Payment Status", "table_name" => "f_payment", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Payment Comment ", "table_name" => "f_payment", "colum_value" => "Comment"),
    );
}else if ($_GET['type'] == 'PoNote') {
    $ThisPageName = 'viewCreditNote.php';
    $column = array
        (
        array("colum_name" => "Credit Note ID", "table_name" => "p_order", "colum_value" => "PurchaseID"),
        array("colum_name" => " Posted Date", "table_name" => "p_order", "colum_value" => "SuppCompany"),
        array("colum_name" => "Expiry Date", "table_name" => "p_order", "colum_value" => "TotalAmount"),
        array("colum_name" => "Customer", "table_name" => "p_order", "colum_value" => "Status"),
        array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        //array("colum_name" => "Assigned Emp", "table_name" => "p_order", "colum_value" => "AssignedEmp"),
        array("colum_name" => "Approved", "table_name" => "p_order", "colum_value" => "Approved"),
        array("colum_name" => "Status", "table_name" => "p_order", "colum_value" => "PaymentTerm")
    );

    $column2 = array
        (
        array("colum_name" => "PO Number", "table_name" => "p_order", "colum_value" => "PurchaseID"),
        array("colum_name" => " Vendor", "table_name" => "p_order", "colum_value" => "SuppCompany"),
        //array("colum_name" => "Assigned Emp", "table_name" => "p_order", "colum_value" => "AssignedEmp"),
        array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "TotalAmount"),
        array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        array("colum_name" => "Order Status", "table_name" => "p_order", "colum_value" => "Status"),
        array("colum_name" => "Payment Term", "table_name" => "p_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "p_order", "colum_value" => "ShippingMethod"),
        // array("colum_name"=>"Order Date","table_name"=>"p_order","colum_value"=>"OrderDate"),
        //array("colum_name"=>"Delivery Date","table_name"=>"p_order","colum_value"=>"DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "p_order", "colum_value" => "Comment")
    );
}




$adv_filter_options = array("e" => "equals",
    "n" => "not equal to",
    "s" => "starts with",
    "ew" => "ends with",
    "c" => "contains",
    "k" => "does not contain",
    "l" => "less than",
    "g" => "greater than",
    "m" => "less or equal",
    "h" => "greater or equal",
    "b" => "before",
    "a" => "after",
    "bw" => "between"
);
?>
