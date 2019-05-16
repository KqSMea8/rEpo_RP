<?php
	global $Config;

	#date_default_timezone_set('Asia/Calcutta');

	if(!empty($_GET['debug'])){
		ini_set('display_errors',1);
		error_reporting(E_ALL);
	}else{
		ini_set('display_errors',0);
		error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED); 		
	}
	$Config['localhost']			= '0';

	/*******************************************/
	(empty($Config['CronJob']))?($Config['CronJob']=''):(""); 
	if($Config['CronJob']!=1){
		require_once($_SERVER['DOCUMENT_ROOT'].'/erp/define.php');
	}
	/******************************************/
 
	$Config['DbHost']			= 'localhost';

	$Config['DbUser']			= 'root';    
	$Config['DbPassword']			= 'z4dNKzoYAg1CkLYZYUqh8DE9f'; 
	 
	$Config['DbName']			= 'erp';
	$Config['WebUrl']			= 'https://www.eznetcrm.com/';
	$Config['Url']				= 'https://www.eznetcrm.com/erp/';
	$Config['Online']			= '1';



	$Config['DbMain']			= $Config['DbName'];


	$Config['AdminFolder']	= 'admin';
	$Config['EmpFolder']	= 'employee';



	define('_SiteUrl',$Config['Url']);



	$Config['Currency'] = 'USD';
	$Config['CurrencySymbol'] = '$';

	$Config['StorePrefix'] = '';

	
	
	
	$Config['NumDeliveryOption'] = '3';  
	$Config['NumLocation'] = '4';  


$Config['AdminCSS'] = "css/admin.css";
$Config['AdminCSS2'] = "css/admin-style.css";
$Config['AdminCSS3'] = "css/admin-ecom-style.css";
$Config['PrintCSS'] = "css/print.css";

$Config['ContactEmail'] = "info@test.com";

$Config['ShippingNote'] = '<strong>Note:</strong>
	  Final Shipping Cost will be calculated during check-out based upon product algorythm, (# of units * volume * weight) according to the rules as defined by courier agreements.';


	$Config['EmailTemplateFolder']		= 'includes/html/email/';


	$bgcolor ='#ffffff';
	$table_bg =' width="100%" align="center" cellpadding="3" cellspacing="1" id="list_table" ';

	$view = '<img src="'.$Config['Url'].'admin/images/view.png" border="0"  onMouseover="ddrivetip(\'<center>View</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$edit = '<img src="'.$Config['Url'].'admin/images/edit.png" border="0" class="editicon" onMouseover="ddrivetip(\'<center>Edit</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$delete = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0" class="delicon" onMouseover="ddrivetip(\'<center>Delete</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$move = '<img src="'.$Config['Url'].'admin/images/move.png" border="0"  onMouseover="ddrivetip(\'<center>Move</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$search = '<img src="'.$Config['Url'].'admin/images/search.png" border="0"  onMouseover="ddrivetip(\'<center>Search</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$download = '<img src="'.$Config['Url'].'admin/images/download.png" border="0"  onMouseover="ddrivetip(\'<center>Download</center>\', 60,\'\')"; onMouseout="hideddrivetip()" >';
$ReuseImage = '<img src="'.$Config['Url'].'admin/images/reuse.png" border="0"  onMouseover="ddrivetip(\'<center>Reuse</center>\', 60,\'\')"; onMouseout="hideddrivetip()" >';

	/************************/
	$Config['SalesCommission'] = 1;
	
	
	


?>
