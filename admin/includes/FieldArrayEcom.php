<?php

if ($_GET['type'] == 'EcomOrder') {

    $ThisPageName = 'viewOrder.php';
    $column = array
        (
					array("colum_name" => "Order Id", "table_name" => "e_orders", "colum_value" => "AmazonOrderId","column_type" => "text"),
						array("colum_name" => "Order Type", "table_name" => "e_orders", "colum_value" => "OrderType","column_type" => "text"),
						array("colum_name" => "Order Date", "table_name" => "e_orders", "colum_value" => "OrderDate","column_type" => "date"),
						array("colum_name" => "Billing Name", "table_name" => "e_orders", "colum_value" => "BillingName","column_type" => "text"),
						array("colum_name" => "Billing Company", "table_name" => "e_orders", "colum_value" => "BillingCompany","column_type" => "text"),
						array("colum_name" => "Billing Address", "table_name" => "e_orders", "colum_value" => "BillingAddress","column_type" => "text"),
						array("colum_name" => "Billing State", "table_name" => "e_orders", "colum_value" => "BillingCity","column_type" => "text"),
						array("colum_name" => "Billing Country", "table_name" => "e_orders", "colum_value" => "BillingState","column_type" => "text"),
						array("colum_name" => "Billing Country", "table_name" => "e_orders", "colum_value" => "BillingCountry","column_type" => "text"),
						array("colum_name" => "Billing Zip", "table_name" => "e_orders", "colum_value" => "BillingZip","column_type" => "text"),
						array("colum_name" => "Phone", "table_name" => "e_orders", "colum_value" => "Phone","column_type" => "text"),
						array("colum_name" => "Email", "table_name" => "e_orders", "colum_value" => "Email","column_type" => "text"),

						array("colum_name" => "Tax", "table_name" => "e_orders", "colum_value" => "Tax","column_type" => "text"),
						array("colum_name" => "Shipping", "table_name" => "e_orders", "colum_value" => "Shipping","column_type" => "text"),
						array("colum_name" => "Shipping Method", "table_name" => "e_orders", "colum_value" => "ShippingMethod","column_type" => "text"),
						array("colum_name" => "Discount Amount", "table_name" => "e_orders", "colum_value" => "DiscountAmount","column_type" => "text"),
						array("colum_name" => "Shipping Name", "table_name" => "e_orders", "colum_value" => "ShippingName","column_type" => "text"),
						array("colum_name" => "Shipping Company", "table_name" => "e_orders", "colum_value" => "ShippingCompany","column_type" => "text"),
						array("colum_name" => "Shipping Address", "table_name" => "e_orders", "colum_value" => "ShippingAddress","column_type" => "text"),
array("colum_name" => "Amount", "table_name" => "e_orders", "colum_value" => "TotalPrice","column_type" => "text"),
					 array("colum_name" => "Shipping City", "table_name" => "e_orders", "colum_value" => "ShippingCity","column_type" => "text"),
				    array("colum_name" => "Shipping State", "table_name" => "e_orders", "colum_value" => "ShippingState","column_type" => "text"),
				    array("colum_name" => "Shipping Country", "table_name" => "e_orders", "colum_value" => "ShippingCountry","column_type" => "text"),
				    array("colum_name" => "Shipping Zip", "table_name" => "e_orders", "colum_value" => "ShippingZip","column_type" => "text"),
				    array("colum_name" => "Shipping Phone", "table_name" => "e_orders", "colum_value" => "ShippingPhone","column_type" => "text"),
				    array("colum_name" => "Shipping Address Type", "table_name" => "e_orders", "colum_value" => "ShippingAddressType","column_type" => "text"),
				    array("colum_name" => "Shipping Status", "table_name" => "e_orders", "colum_value" => "ShippingStatus","column_type" => "text"),

						array("colum_name" => "Payment Status", "table_name" => "e_orders", "colum_value" => "PaymentStatus","column_type" => "text"),
						array("colum_name" => "Order Status", "table_name" => "e_orders", "colum_value" => "OrderStatus","column_type" => "text"),
						array("colum_name" => "Payment Gateway", "table_name" => "e_orders", "colum_value" => "PaymentGateway"),
						array("colum_name" => "Delivery Date", "table_name" => "e_orders", "colum_value" => "DelivaryDate","column_type" => "date"),
						array("colum_name" => "Ship Date", "table_name" => "e_orders", "colum_value" => "ShipDate","column_type" => "date"),
						
				
						array("colum_name" => "Seller Channel", "table_name" => "e_orders", "colum_value" => "SellerChannel","column_type" => "text"),
						array("colum_name" => "RowColor", "table_name" => "e_orders", "colum_value" => "RowColor","column_type" => "text")
    );

    $column2 = array
        (
						array("colum_name" => " Order Id", "table_name" => "e_orders", "colum_value" => "AmazonOrderId","column_type" => "text"),
						//array("colum_name" => "Order ID", "table_name" => "e_orders", "colum_value" => "OrderID","column_type" => "text"),
						array("colum_name" => "Amount", "table_name" => "e_orders", "colum_value" => "TotalPrice","column_type" => "text"),
						array("colum_name" => "Order Type", "table_name" => "e_orders", "colum_value" => "OrderType","column_type" => "text"),
						array("colum_name" => "Order Date", "table_name" => "e_orders", "colum_value" => "OrderDate","column_type" => "date"),
						array("colum_name" => "Phone", "table_name" => "e_orders", "colum_value" => "Phone","column_type" => "text"),
						array("colum_name" => "Email", "table_name" => "e_orders", "colum_value" => "Email","column_type" => "text"),
						array("colum_name" => "Payment Status", "table_name" => "e_orders", "colum_value" => "PaymentStatus","column_type" => "text"),
						array("colum_name" => "Order Status", "table_name" => "e_orders", "colum_value" => "OrderStatus","column_type" => "text"),
						array("colum_name" => "Payment Gateway", "table_name" => "e_orders", "colum_value" => "PaymentGateway","column_type" => "text"),
						array("colum_name" => "Delivery Date", "table_name" => "e_orders", "colum_value" => "DelivaryDate","column_type" => "date"),
						array("colum_name" => "Ship Date", "table_name" => "e_orders", "colum_value" => "ShipDate","column_type" => "date"),

						
					
						array("colum_name" => "Seller Channel", "table_name" => "e_orders", "colum_value" => "SellerChannel","column_type" => "text"),
						array("colum_name" => "RowColor", "table_name" => "e_orders", "colum_value" => "RowColor","column_type" => "text")
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
