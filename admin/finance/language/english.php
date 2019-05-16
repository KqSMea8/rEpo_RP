<?php	
define("ACCOUNT_NUM_FORMAT","<span class=normal>Format : XXXX-XX </span>");
define("ADJUST_SAVED","Invoice amount has been adjusted successfully.");

define("BATCH_ADDED","Batch has been added successfully.");
define("BATCH_UPDATED","Batch has been updated successfully.");
define("BATCH_REMOVED","Batch has been removed successfully.");
define("BATCH_CLOSED","Batch has been closed successfully.");
define("BATCH_OPENED","Batch has been opened successfully.");
define("BATCH_ENTER","Please Enter Batch Name.");
define("BATCH_MOVED","Checks has been moved to batch successfully.");
define("BATCH_CHECK_REMOVED","Checks has been removed from batch successfully.");

define("CURRENCY_DETAIL","All amounts stated in [Currency].");
define("STATUS"," Status has been changed successfully.");
define("REMOVED"," has been removed successfully.");
define("ADDED"," has been added successfully.");
define("UPDATED"," has been updated successfully.");
define("CANCELLED"," has been cancelled successfully.");
define("ACTIVATED"," has been activated successfully.");
define("INACTIVATED"," has been inactivated.");
define("SEND"," sent successfully.");
 
define("EMAIL_STATEMENT_SETTING_UPDATED","Email Statement Setting has been updated successfully.");

define("FILL_ALL_MANDANTRY_FIELDS"," Please fill all mandatory fields.");
define("CUSTOMER_BILLING_ADDRESS","Billing Address");
define("CUSTOMER_SHIPPING_ADDRESS","Shipping Address");
define("ADD_PAYMENT_INFORMATION","The payment has been made successfully.");
define("NO_SO","No sales order found.");
 
define("TRANSACTION_SAVED","Payment has been saved successfully.");
define("TRANSACTION_UPDATED","Payment has been updated successfully.");
define("TRANSACTION_REMOVED","Payment has been removed successfully.");
define("TRANSFER_MSG","The transfer has been made successfully.");

define("SUPPLIER_ADDRESS","Vendor Address");
define("SHIP_TO_ADDRESS","Ship-To Address");
 
define("VIEW_ORDER_DETAIL","View Order Detail");

define("DEPOSIT_MSG","Amount has been deposit successfully.");
define("ERROR_IN_PAY_INVOICE","The payment has been decline.");
define("ERROR_IN_CASH_RECEIPT","Cash receipt payment has been declined.");
define("LINE_ITEM","Line Item");
define("RECEIVED_ITEM","Received Item");
define("CHART_OF_ACCOUNTS","Chart of Accounts");
define("MANAGE_ACCOUNT_TYPES","Manage Account Types");
define("BLANK_ASSIGN_AUTO_JOURNAL"," If you leave this field blank, A journal number will be assigned automatically.");

define("ATTACHMENT_REMOVED", "Attachment has been removed successfully.");
define("INVALID_FORM_ENTRY"," Invalid journal entry. Please fill all mandatory fields properly.");
define("ACCOUNT_HISTORY", "Account History");
define("SUPPORTED_ATTACHMENT","(Supported file types:  pdf, doc, docx, ppt, pptx, xls, xlsx, rtf, txt)");
define("REPORT_EMAIL","Report has been sent successfully.");
 
define("POSTED_TO_GL_AACOUNT","Journal entry has been posted successfully to GL account.");
define("AR_POSTED_TO_GL_AACOUNT","Cash receipt has been posted successfully to GL account.");
define("AP_POSTED_TO_GL_AACOUNT","Payment has been posted successfully to GL account.");
define("PAYMENT_REMOVED","Payment has been removed successfully.");
define("CASH_RECEIPT_REMOVED","Cash receipt has been removed successfully.");
define("CASH_RECEIPT_VOIDED","Cash receipt has been voided successfully.");

define("MSG_STOP_RECEIVE_PAPMENT","Sorry you can not receive payment.");
define("MSG_STOP_PAY_PAPMENT","Sorry you can not pay to vendor.");
define("MSG_STOP_JOURNAL_ENTRY","Sorry you can not add journal entry.");
define("MSG_STOP_INVOICE_ENTRY","Sorry you can not add invoice entry.");

define("MERGE_VENDOR_MSG","Merging a vendor will delete all the data related to current vendor and all those data will be merged to selected vendor. ");

define("MERGING_DONE","Merging has been done successfully. <br>Old vendor has been deleted and all the related data has been merged to selected vendor. ");

/**** New for Sales *******/
define("CREDIT_MEMO_POSTED_TO_GL_AACOUNT","Credit Memo has been posted successfully to GL account.");
define("INVOICE_NOT_GENERATED","Invoice can't be generated as ");
define("INVOICE_POSTED_TO_GL_AACOUNT","Invoice has been posted successfully to GL account.");
define("INVOICE_POSTED_TO_GL_NUM","Invoice has been posted to GL account.");
define("INVOICE_PO_NOT_POSTED","Invoice has been not been posted to GL account. Please fill all values for Account Payable in Global Settings");

define("INVOICE_AMNT_NOT_POSTED","Invoice: [INVOICE_ID] has been not been posted to GL account<br>as Total Invoice amount exceeds Sales Order amount.");
define("INVOICE_AMNT_NOT_POSTED_CHARGE","Invoice: [INVOICE_ID] has been not been posted to GL account<br>as credit card charge amount exceeds invoice amount.");

define("SERIALIZE_NUM_MSG","Serial numbers available for Sku [[Sku]] is [NumSerial] but invoiced quantity is [Qty]<br>");
 
define("GENERATE_INVOICE","Generate Invoice");
 
define("INVOICE_GENERATED_MESSAGE","Invoice has been generated successfully.");

define("NOT_EXIST_CREDIT","This credit memo no longer exist in the database.");
define("NOT_EXIST_INVOICE","This invoice no longer exist in the database.");
 
define("NOT_EXIST_ORDER","This sales order no longer exist in the database.");
define("NO_EMPLOYEE","No sales person found");
define("ALL_INVOICE_ITEM","All invoiced has been generated for this order.");
define("SELECT_SO_FIRST","Please go back and select sales order first.");

define("SO_ITEM_RECEIVED","All quantities has been received for this order.");
define("SO_ITEM_NOT_RECEIVED","No quantities has been received for this order.");
define("RECIEVE_ORDER","Receive Order");


 
define("PAYMENT_HISTORY","Payment History");
define("ENTER_CUSTOMER_ID", "Please Enter Customer Code.");


/**** New for Purchasing *******/
define("CREDIT_ADDED","Credit Memo has been added successfully.");
define("CREDIT_UPDATED","Credit Memo has been updated successfully.");
define("CREDIT_REMOVED","Credit Memo has been removed successfully.");

define("ENTER_SUPPLIER_ID", "Please Enter Vendor Code.");

define("INVOICE_REMOVED","Invoice has been removed successfully.");
define("INVOICE_UPDATED","Invoice has been updated successfully.");
define("INVOICE_REC_UPDATED","Invoice recurring has been updated successfully.");
define("INVOICE_ADJ_REMOVED","Invoice adjustment has been removed successfully.");

define("INVOICE_ENT_REMOVED","Invoice Entry has been removed successfully.");
define("INVOICE_ENT_UPDATED","Invoice Entry has been updated successfully.");
define("INVOICE_ENT_SAVED","Invoice Entry has been saved successfully.");
define("INVOICE_ENT_MULTIPLE_ERROR","Invoice Entry has not been saved due to mismatch total amount.");

define("JOURNAL_REC_UPDATED","Journal recurring has been updated successfully.");
define("JOURNAL_REC_CANCELLED","Journal recurring has been cancelled successfully.");

define("MAIL_SEND_CUST","Mail has been send to customer successfully.");
define("STMT_SEND_CUST","Statement has been send to customer successfully.");
define("STMT_SEND_FAILED","Statement sending failed !!");

define("NO_SUPPLIER","No vendor found.");
define("NO_PO","No purchase order found.");
define("NO_ITEM_RECEIVED","No item received.");
 
 
define("NOT_EXIST_SUPP","This vendor no longer exist in the database.");
define("NOT_POSTED_TOGL","Not allowed to post to gl as this is a future invoice.");
define("NOT_POSTED_TOGL_AMOUNT","Not allowed to post to gl as invoice amount and gl line amount is not same.");
define("NOT_FOR_PAYMENT","This invoice is not valid for credit card payment.");
define("ALREADY_PAID_INVOICE","This invoice is already paid.");

define("PO_ORDER_RECIEVED","Purchase order received detail has been saved successfully.");

define("PO_ITEM_RECEIVED","All qauntities has been received for this order.");
define("PO_ITEM_NOT_RECEIVED","No qauntities has been received for this order.");
define("PO_ITEM_TO_NO_RETURN","No qauntities left to return for this order.");
define("SELECT_SUPPLIER","Please select vendor first.");


define("SUPP_ADDED","Vendor has been added successfully.");
define("SUPP_UPDATED","Vendor has been updated successfully.");
define("SUPP_REMOVED","Vendor has been removed successfully.");
define("SUPP_STATUS_CHANGED","Vendor Status has been changed successfully.");

define("SUPP_CONTACT_ADDED","Contact has been added successfully.");
define("SUPP_CONTACT_UPDATED","Contact has been updated successfully.");
define("SUPP_CONTACT_REMOVED","Contact has been removed successfully.");


define("SETUP_FISCAL_YEAR","Please set up fiscal year under global settings.");
define("RECONCIL_MONTH","Month has been reconcile successfully.");
define("RECONCILB_EXIST_MONTH","This month is in process of being reconciled.");
define("RECONCIL_EXIST_MONTH","This month is in process to be reconciled.");

define("NOT_RECONCIL_MONTH","Month has been save successfully.");
define("NO_SERIAL_AVAILABLE","No Serial Number Available.");
define("ENTER_QTY_INVOICE","Please Enter Qty Invoice.");
define("SERIAL_NO_FPR_SKU","Serial Number For SKU");
define("ENTER_QTY_RECEIVE","Please Enter Qty Receive.");

define("UNDER_MAINT","Under Maintenance !");

define("SELECT_GL_AR","Please select Account Receivable in Global Settings first.");
define("SELECT_GL_AP","Please select Account Payable in Global Settings first.");
define("SELECT_GL_AP_ALL","Please set all accounts for Account Payable in Global Settings first.");
define("SELECT_GL_AR_ALL","Please set all accounts for Account Receivable in Global Settings first.");
define("SAME_GL_SELECTED_AR","Account Receivable and Sales Account defined under global settings should be different.");
define("SAME_GL_SELECTED_AP","Account Payable and Inventory Account defined under global settings should be different.");


define("CREDIT_MEMO_SEND","Credit memo has been send successfully.");
define("INVOICE_SEND","Invoice has been send successfully.");

define("SELECT_CON_AR","Please select Contra Account Receivable in Global Settings first.");
define("SELECT_CON_AP","Please select Contra Account Payable in Global Settings first.");
define("SETTING_CAPTION_MSG","Please mouseover on account captions to rename.");

/**sachin**/
define("Payment_History","Payment History");
define("NOT_EXIST_PAYMENT_HISTORY","This payment history no longer exist in the database.");
define("Invoice_Information","Invoice Information");
define("NOT_SPECIFIED_PDF","Not specified");
define("BILLING_ADDRESS","Billing Address");
define("SHIPPING_ADDRESS","Shipping Address");
define("Send_Vendor_Payment","Payment history has been send to vendor successfully.");
define("Send_Case_Payment","Payment history has been send to customer successfully.");
define("NOT_EXIST_PAYMENT","This vendor payment no longer exist in the database.");

define("PERIOD_UPDATED","Period end setting has been updated successfully."); 
define("PERIOD_YEAR_CLOSED","Year has been closed successfully."); 
define("PERIOD_YEAR_OPENED","Year has been opened successfully."); 
define("PERIOD_STATUS_CHANGED","Period status has been changed successfully."); 
define("PERIOD_YEAR_CLOSED_MSG","Period status can not be changed as [YEAR] is closed.<br>Please open the year [YEAR] first."); 
define("PERIOD_YEAR_NOT_OPEN","Year [YEAR] can not be opened as next year [NEXT] is closed now."); 


define("INVOICE_POSTED_FEE_GL_AACOUNT"," Invalid journal entry.There is not amount to credit and debit.");
define("BANK_CURRENCY_DISABLE","[Bank Currency is not allowed to change as finance payment table has data in it.]");

define("VOID_CS_MSG","Are you sure you want to void this cash receipt?");
define("VOID_VP_MSG","Are you sure you want to void this vendor payment?");
define("VENDOR_PAYMENT_VOIDED","Vendor payment has been voided successfully.");
define("SUPPORTED_SCAN_DOC","(Supported file types:  pdf, jpg, gif & png.)");

define("ERROR_IN_PAYMENT","Payment Declined !!!");
define("BLANK_DEPOSIT_AMOUNT","<br>Total Deposit Amount should not be blank.");  
define("BLANK_DEPOSIT_ACCOUNT","<br>Deposit To Account should not be blank.");  
define("BLANK_TERM","<br>Payment Term should not be blank.");  
define("DEPOSIT_AMOUNT_UNMATCHED","<br>Total Deposit Amount should be equal to Total Payment Amount.");  

 
define("BLANK_PAYMENT_AMOUNT","<br>Total Amount Paid should not be blank.");  
define("BLANK_PAYMENT_ACCOUNT","<br>Payment Account should not be blank.");  
define("PAYMENT_AMOUNT_UNMATCHED","<br>Total Amount Paid should be equal to Total Payment Amount.");  

define("VOID_TRANSFER_MSG","Are you sure you want to void this Vendor Transfer?");  
define("VENDOR_TRANSFER_VOIDED","Vendor Transfer has been voided successfully.");

?>
