<?php

if ($_GET['type'] == 'Quote') {

    $ThisPageName = 'viewSalesQuoteOrder.php?module=Quote';
    $column = array
        (
        array("colum_name" => "Entry Type", "table_name" => "s_order", "colum_value" => "EntryType"),
        array("colum_name" => "Quote Number", "table_name" => "s_order", "colum_value" => "QuoteID"),
        array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"),
        array("colum_name" => "Sales Person", "table_name" => "s_order", "colum_value" => "SalesPerson"),
        array("colum_name" => "Order Status", "table_name" => "s_order", "colum_value" => "Status"),
         array("colum_name" => "Amount", "table_name" => "s_order", "colum_value" => "TotalAmount"),
        array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "CustomerCurrency"),
        array("colum_name" => "Payment Term", "table_name" => "s_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "s_order", "colum_value" => "ShippingMethod"),        
        array("colum_name" => "Order Date", "table_name" => "s_order", "colum_value" => "OrderDate"),
        array("colum_name" => "Delivery Date", "table_name" => "s_order", "colum_value" => "DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "s_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "s_order", "colum_value" => "Comment")
    );

    $column2 = array
        (
         array("colum_name" => "Entry Type", "table_name" => "s_order", "colum_value" => "EntryType"),
        array("colum_name" => "Quote Number", "table_name" => "s_order", "colum_value" => "QuoteID"),
        array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"),
        array("colum_name" => "Sales Person", "table_name" => "s_order", "colum_value" => "SalesPerson"),
        array("colum_name" => "Order Status", "table_name" => "s_order", "colum_value" => "Status"),
        array("colum_name" => "Amount", "table_name" => "s_order", "colum_value" => "TotalAmount"),
        array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "CustomerCurrency"),
        array("colum_name" => "Payment Term", "table_name" => "s_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "s_order", "colum_value" => "ShippingMethod"),
        // array("colum_name"=>"Order Date","table_name"=>"s_order","colum_value"=>"OrderDate"),
        //array("colum_name"=>"Delivery Date","table_name"=>"s_order","colum_value"=>"DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "s_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "s_order", "colum_value" => "Comment")
    );
} else if ($_GET['type'] == 'Order') {
    $ThisPageName = 'viewSalesQuoteOrder.php?module=Order';
    $column = array
        (
         array("colum_name" => "Entry Type", "table_name" => "s_order", "colum_value" => "EntryType"),
        array("colum_name" => "Sale Number", "table_name" => "s_order", "colum_value" => "SaleID"),
        array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"),
        array("colum_name" => "Sales Person", "table_name" => "s_order", "colum_value" => "SalesPerson"),
        array("colum_name" => "Order Status", "table_name" => "s_order", "colum_value" => "Status"),
        array("colum_name" => "Amount", "table_name" => "s_order", "colum_value" => "TotalAmount"),
        array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "CustomerCurrency"),
        array("colum_name" => "Payment Term", "table_name" => "s_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "s_order", "colum_value" => "ShippingMethod"),
        array("colum_name" => "Order Date", "table_name" => "s_order", "colum_value" => "OrderDate"),
        array("colum_name" => "Delivery Date", "table_name" => "s_order", "colum_value" => "DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "s_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "s_order", "colum_value" => "Comment")
    );

    $column2 = array
        (
        array("colum_name" => "Entry Type", "table_name" => "s_order", "colum_value" => "EntryType"),
        array("colum_name" => "Sale Number", "table_name" => "s_order", "colum_value" => "SaleID"),
        array("colum_name" => "Customer", "table_name" => "s_order", "colum_value" => "CustomerName"),
        array("colum_name" => "Sales Person", "table_name" => "s_order", "colum_value" => "SalesPerson"),
        array("colum_name" => "Order Status", "table_name" => "s_order", "colum_value" => "Status"),
        array("colum_name" => "Amount", "table_name" => "s_order", "colum_value" => "TotalAmount"),
        array("colum_name" => "Currency", "table_name" => "s_order", "colum_value" => "CustomerCurrency"),
        array("colum_name" => "Payment Term", "table_name" => "s_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "s_order", "colum_value" => "ShippingMethod"),
        // array("colum_name"=>"Order Date","table_name"=>"s_order","colum_value"=>"OrderDate"),
        //array("colum_name"=>"Delivery Date","table_name"=>"s_order","colum_value"=>"DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "s_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "s_order", "colum_value" => "Comment")
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
