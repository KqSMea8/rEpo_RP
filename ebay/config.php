<?php
	global $Config;

	#date_default_timezone_set('Asia/Calcutta');
	ini_set('display_errors',0);
	
	$Config['localhost']			= '0';

	/*******************************************/
	if($Config['CronJob']!=1){
	require_once($_SERVER['DOCUMENT_ROOT'].'/erp/define.php');
	}
	/******************************************/

	if($Config['localhost']==1){
		$Config['DbHost']			= 'localhost';
		$Config['DbUser']			= 'root';
		$Config['DbPassword']			= '';
		$Config['DbName']			= 'erp';
		$Config['Url']				= 'http://localhost/erp/';

		$Config['Online']			= '0';
	
	}else{
		/***************
		$Config['DbHost']			= 'localhost';
		$Config['DbUser']			= 'root';   
		$Config['DbPassword']			= 'yG534b6oce';	
		$Config['DbName']			= 'erp';
		$Config['Url']				= 'http://54.235.157.220/erp/';
		/***************/

		$Config['DbHost']			= 'localhost';
		$Config['DbUser']			= 'root';     //'root';   
		$Config['DbPassword']			= 'root123#';    //'ERP2014!';	
		$Config['DbName']			= 'erp';
		$Config['Url']				= 'http://199.227.27.207/erp/';
		//$Config['Url']				= 'http://app01.eznetcrm.com/erp/';


		$Config['Online']			= '1';
	}

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
	$edit = '<img src="'.$Config['Url'].'admin/images/edit.png" border="0"  onMouseover="ddrivetip(\'<center>Edit</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$delete = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Delete</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$move = '<img src="'.$Config['Url'].'admin/images/move.png" border="0"  onMouseover="ddrivetip(\'<center>Move</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
	$search = '<img src="'.$Config['Url'].'admin/images/search.png" border="0"  onMouseover="ddrivetip(\'<center>Search</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
$result = '<img src="'.$Config['Url'].'admin/images/result.png" border="0"  onMouseover="ddrivetip(\'<center>Result</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';
		$download = '<img src="'.$Config['Url'].'admin/images/download.png" border="0"  onMouseover="ddrivetip(\'<center>Download</center>\', 60,\'\')"; onMouseout="hideddrivetip()" >';
        $ReuseImage = '<img src="'.$Config['Url'].'admin/images/reuse.png" border="0"  onMouseover="ddrivetip(\'<center>Reuse</center>\', 60,\'\')"; onMouseout="hideddrivetip()" >';

	/************************/
	$Config['SalesCommission'] = 1;
	
	
	


?>
