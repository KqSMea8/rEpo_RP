<?php 
require_once("includes/settings.php");
require_once("../classes/warehouse.class.php");
require_once("../classes/warehouse.shipment.class.php");
require_once("../classes/sales.quote.order.class.php");
require_once($Prefix."classes/sales.customer.class.php");
require("includes/htmltopdf/html2pdf.class.php");
$objSale = new sale();
$objShipment = new shipment();
$objCustomer = new Customer();
$objWarehouse = new warehouse();
/*$savefileUrl = "upload/batchpdf/".$_SESSION['CmpID']."/";
if (!is_dir($savefileUrl)) {
mkdir($savefileUrl);
chmod($savefileUrl,0777);
}*/

/* * *Module PDF data ** */
$RedirectURL = "warehouse/viewbatchmgmt.php?curP=".$_GET['curP'];
if(!empty($_GET['batchId'])){
	$batchidarray = $objShipment->GetBatchShippment($_GET['batchId']);
}
else{
    echo "<script type=\"text/javascript\">
		parent.$.fancybox.close();
		window.opener.location.reload(true);
		</script>";
    exit;
}

$ModDepName = 'BatchShipment';
$exists = '';

if (!empty($batchidarray)) {
  
    foreach ($batchidarray as $values) {

       if($values['InvoiceID']!=''){
		if(file_exists('/var/www/html/erp/admin/finance/upload/pdf/'.$_SESSION['CmpID'].'/SalesInvoice-'.$values['InvoiceID'].'.pdf') )
		{
			$attachment = '/var/www/html/erp/admin/finance/upload/pdf/'.$_SESSION['CmpID'].'/SalesInvoice-'.$values['InvoiceID'].'.pdf';
			//chmod($attachment, 0755);
			$arr = $objWarehouse->sendBatchPdfOnMail($shipId,$attachment);
			$exists = 1;
		}	
       }  

   }

     if($exists == ''){
	echo "<script type=\"text/javascript\">
		parent.$.fancybox.close();
		window.opener.location.reload(true);
		</script>";	
    	exit;
    }

}
else
{
    	echo "<script type=\"text/javascript\">
		parent.$.fancybox.close();
		window.opener.location.reload(true);
		</script>";	
    	exit;
}


echo '<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script><script type="text/javascript">$(function(){setTimeout(function(){ document.location.href="warehouse/batchclose.php?email=success"; }, 1000);});</script>';



?>

