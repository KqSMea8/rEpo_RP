<?php

if ($_GET['type'] == 'Quote') {

    $ThisPageName = 'viewPO.php?module=Quote';
    $column = array
        (
        
        array("colum_name" => "Quote Number", "table_name" => "p_order", "colum_value" => "QuoteID"),
        array("colum_name" => " Order Type", "table_name" => "p_order", "colum_value" => "OrderType"),      
        array("colum_name" => " Vendor", "table_name" => "p_order", "colum_value" => "SuppCompany"),
        array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "TotalAmount"),
         array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        //array("colum_name" => "Assigned Emp", "table_name" => "p_order", "colum_value" => "AssignedEmp"),
        array("colum_name" => "Order Status", "table_name" => "p_order", "colum_value" => "Status"),
        array("colum_name" => "Approved", "table_name" => "p_order", "colum_value" => "Approved"),
        array("colum_name" => "Payment Term", "table_name" => "p_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "p_order", "colum_value" => "ShippingMethod"),
        array("colum_name" => "Order Date", "table_name" => "p_order", "colum_value" => "OrderDate"),
        array("colum_name" => "Delivery Date", "table_name" => "p_order", "colum_value" => "DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "p_order", "colum_value" => "Comment")
    );

    $column2 = array
        (
        
        array("colum_name" => "Quote Number", "table_name" => "p_order", "colum_value" => "QuoteID"),
         array("colum_name" => " Order Type", "table_name" => "p_order", "colum_value" => "OrderType"),
         array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "TotalAmount"),
         array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        array("colum_name" => " Vendor", "table_name" => "p_order", "colum_value" => "SuppCompany"),
        //array("colum_name" => "Assigned Emp", "table_name" => "p_order", "colum_value" => "AssignedEmp"),
        array("colum_name" => "Order Status", "table_name" => "p_order", "colum_value" => "Status"),
        array("colum_name" => "Payment Term", "table_name" => "p_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "p_order", "colum_value" => "ShippingMethod"),
        // array("colum_name"=>"Order Date","table_name"=>"p_order","colum_value"=>"OrderDate"),
        //array("colum_name"=>"Delivery Date","table_name"=>"p_order","colum_value"=>"DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "p_order", "colum_value" => "Comment")
    );
} else if ($_GET['type'] == 'Order') {
    $ThisPageName = 'viewPO.php?module=Order';
    $column = array
        (
        
        array("colum_name" => "PO Number", "table_name" => "p_order", "colum_value" => "PurchaseID"),
        array("colum_name" => " Vendor", "table_name" => "p_order", "colum_value" => "SuppCompany"),
         array("colum_name" => "Amount", "table_name" => "p_order", "colum_value" => "TotalAmount"),
         array("colum_name" => "Currency", "table_name" => "p_order", "colum_value" => "Currency"),
        //array("colum_name" => "Assigned Emp", "table_name" => "p_order", "colum_value" => "AssignedEmp"),
        array("colum_name" => "Order Status", "table_name" => "p_order", "colum_value" => "Status"),
         array("colum_name" => "Approved", "table_name" => "p_order", "colum_value" => "Approved"),
        array("colum_name" => "Payment Term", "table_name" => "p_order", "colum_value" => "PaymentTerm"),
        array("colum_name" => "Shipping Method", "table_name" => "p_order", "colum_value" => "ShippingMethod"),
        array("colum_name" => "Order Date", "table_name" => "p_order", "colum_value" => "OrderDate"),
        array("colum_name" => "Delivery Date", "table_name" => "p_order", "colum_value" => "DeliveryDate"),
        array("colum_name" => "Payment Method", "table_name" => "p_order", "colum_value" => "PaymentMethod"),
        array("colum_name" => "Comments", "table_name" => "p_order", "colum_value" => "Comment")
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
