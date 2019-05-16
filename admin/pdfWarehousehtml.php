<?php
require_once("includes/settings.php");
require_once("../classes/warehouse.shipment.class.php");
require_once("../classes/sales.quote.order.class.php");
require("includes/htmltopdf/html2pdf.class.php");
$objSale = new sale();
$objShipment = new shipment();
/* * *Module PDF data ** */
$RedirectURL = "warehouse/viewbatchmgmt.php?curP=".$_GET['curP'];
if(!empty($_GET['batchId'])){
$batchidarray = $objShipment->GetBatchShippment($_GET['batchId']);
}
else{
	if($_GET['ModuleDepName']) {
		header("Location:".$RedirectURL);
	}else{
		echo "<script type=\"text/javascript\">
		window.opener.parent.location.reload(true);
		open(location, '_self').close();
		</script>";
	}
}

//$ModDepName = $_GET['ModuleDepName'];
$exists = '';
 

if (!empty($batchidarray)) {
	$InvoiceIDs = array();
	$PdfDir = $Config['FilePreviewDir'].$Config['S_Invoice'];
    foreach ($batchidarray as $values) {
	if($values['InvoiceID']!=''){
		$PdfFile = 'SalesInvoice-'.$values['InvoiceID'].'.pdf';
		if(file_exists($PdfDir.$PdfFile) )
		{
			$invoiceIds.= $PdfDir.$PdfFile.' ';
			$exists = 1;
		}	
	}
    }
  
    if($exists == ''){
	if($_GET['ModuleDepName']) {
		header("Location:".$RedirectURL);
	}else{
		echo "<script type=\"text/javascript\">
		window.opener.parent.location.reload(true);
		open(location, '_self').close();
		</script>";
	}
    	exit;
    }

    if(count($batchidarray) > 1)
    {		
	 #echo "convert -density 100x100 -quality 100 ".$invoiceIds." batchEntry.pdf"; die;

    	$result = exec("convert -density 100x100 -quality 100 ".$invoiceIds." batchEntry.pdf", $output, $return_var);
	 
	$readfl = "batchEntry.pdf";
    }else{
	$readfl = trim($invoiceIds);
    }
	
}
else {

	if($_GET['ModuleDepName']) {
		header("Location:".$RedirectURL);
	}else{
    		echo "<script type=\"text/javascript\">
		window.opener.parent.location.reload(true);
		open(location, '_self').close();
		</script>";
	}	
    	exit;
}

 
header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename=batchEntry.pdf');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($readfl));
ob_clean();
ob_flush();
readfile($readfl);
unlink('batchEntry.pdf');
exit;

?>

