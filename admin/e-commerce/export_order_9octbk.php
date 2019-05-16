<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/orders.class.php");
$objOrder = new orders();


$arryExportOrder=$objOrder->exportOrders();


$filename = "OrderList_".date('d-m-Y').".xls";
if(count($arryExportOrder)>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "OrderDate\tOrderID\tOrder Status\tPayment Status\tCustomer Name\tCompany Name\tBilling Address\tBilling City\tBilling State\tBilling Zip\tBilling Country\tPhone\tEmail Address\tShipping Address Type\tShipping Name\tShipping Company\tShipping Address\tShipping City\tShipping State\tShipping Zip\tShipping Country\tShipping Method\tSubtotal Amount\tDiscount Amount\tTax Amount\tShipping Amount\tTotal Amount\tProduct Name\tProduct Quantity\tProduct Price\tProduct Weight\tProduct Attributes";

	$data = '';
	foreach($arryExportOrder as $key=>$values){
		  if($values['PaymentStatus'] == "1")  { $paymentStatus = "Received";}
                    else if($values['PaymentStatus'] == "2") { $paymentStatus = "Refunded";}
                    else if($values['PaymentStatus'] == "3") { $paymentStatus = "Canceled";}
                  else{ $paymentStatus = "Pending"; }
                  
                 $discountAmnt  = $values["DiscountAmount"]+$values["PromoDiscountAmount"];
                 $productOptions  = $values["ProductOptions"];
                 $options = $objOrder->parseOptions($productOptions);
                 $optionAttr = "";
                 if(count($options) > 1){
                    foreach ($options as $option) {
                        $optionAttr .= $option.",";
                    }
                 }

		$line = $values["OrderDate"]."\t".$values["OrderID"]."\t".$values['OrderStatus']."\t".$paymentStatus."\t".stripslashes($values["FirstName"])." ".stripslashes($values["LastName"])."\t".$values["BillingCompany"]."\t".$values["BillingAddress"]."\t".$values["BillingCity"]."\t"
                        .$values["BillingState"]."\t".$values["BillingZip"]."\t".$values["BillingCountry"]."\t".$values["Phone"]."\t".$values["Email"]."\t".$values["ShippingAddressType"]."\t"
                        .$values["ShippingName"]."\t".$values["ShippingCompany"]."\t".$values["ShippingAddress"]."\t".$values["ShippingCity"]."\t".$values["ShippingState"]."\t".$values["ShippingZip"]."\t".$values["ShippingCountry"]."\t".$values["ShippingMethod"]."\t".$values["SubTotalPrice"]."\t".$discountAmnt."\t".$values["Tax"]."\t".$values["Shipping"]."\t".$values["TotalPrice"]."\t".$values["ProductName"]."\t".$values["Quantity"]."\t".$values["Price"]."\t".$values["Weight"]."\t".$optionAttr."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No Order found.";
}
exit;
?>

