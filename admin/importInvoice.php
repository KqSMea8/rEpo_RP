<?php
	ob_start();
	session_start();

//$argv[1]='CmpID=37&AdminID=37&AdminType=admin&TodayDate=2016-05-31+16%3A56%3A25&CmpDatabase=erp_sakshay&SyncButton=1';
	if(empty($argv[1])) exit;

if(!empty($argv[1])){
     $arr = explode("&",$argv[1]);
     foreach($arr as $arrIndex =>$arrValue){
         $arr1 = explode("=",$arrValue);
         $parameters[$arr1[0]] = $arr1[1];
     }
}
	$Config['CronJob'] = '1';
	$prefix='/var/www/html/erp/';
   	require_once($prefix."includes/config.php");
    	require_once($prefix."includes/function.php");
	require_once($prefix."classes/dbClass.php");
	require_once($prefix."classes/region.class.php");
	require_once($prefix."classes/admin.class.php");	
	require_once($prefix."classes/user.class.php");	
	require_once($prefix."classes/configure.class.php");	
	require_once($prefix."classes/territory.class.php");
	require_once($prefix."classes/sales.customer.class.php");
	require_once($prefix."lib/hostbillapi/class.hbwrapper.php");
	require_once($prefix."classes/hostbill.class.php");
	//require_once($prefix."language/english.php");
	$objConfig=new admin();
	
	
	
	//ini_set('display_errors',1);
	if(empty($_SERVER['HTTP_REFERER'])){
		//echo 'Protected.';exit;
	}
	$Config['CmpID']=$parameters['CmpID'];
	$Config['AdminID']=$parameters['AdminID'];
	$Config['AdminType']=$parameters['AdminType'];
	$Config['TodayDate']=$parameters['TodayDate'];
	$Config['SyncButton']=$parameters['SyncButton'];
	
	$Config['DbName'] = $parameters['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();			
	$objhostbill=new hostbill(array('cron'));
	
	if($objhostbill->isActiveHostbill()==true){
		$objhostbill->importInvoiceProcess();
	}
	//exit('Done');	
	
	
	?>
	
	
