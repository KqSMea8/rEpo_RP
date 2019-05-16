<? ob_start();
session_start();
 
$Config['CronJob'] = '1'; 

$RootDir = '/var/www/html/'; 
$Prefix = $RootDir.'erp/'; 

require_once($Prefix."includes/config.php"); 
require_once($Prefix."includes/function.php");
require_once($Prefix."/admin/includes/common.php");
require_once($Prefix."classes/function.class.php");
$objFunction=new functions();

/*****************/
if(empty($_GET['debug'])){
	$_GET['pk']=$argv['1'];
	$_GET['cmp']=$argv['2'];
	$_GET['tempid']=$argv['3'];
}
/*****************/

$Base = md5($_GET['pk']);  
 
/*****93e42d4acf46*******/
$UploadDir =  '../../upload/';  
$Folder = "banner/";
$Table = 'e_slider_banner';
$ColFile = 'Slider_image'; //SaleID, InvoiceID
$ColAuto = 'Id';

//$ModDepName = 'PurchaseInvoice';
//$Module = 'Invoice';
 
/************/

?>
