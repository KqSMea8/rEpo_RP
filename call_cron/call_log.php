<?php 		
	$Department = 7; $ThisPage = 'call_log.php';
	ob_start();
	session_start();
	
	
	$Prefix = "/var/www/html/erp/";
	ini_set("display_errors","1"); error_reporting(5);
	$Config['CronJob'] = '1';
	
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/MyMailer.php");	
    require_once($Prefix."classes/column_encode.class.php");
    require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objConfig=new admin();	
	$objCompany=new company(); 
	$objRegion=new region();
	$arrayConfig = $objConfig->GetSiteSettings(1);	
	$objphone=new phone();
	$allserver=$objphone->ListServer();
	
	if(!empty($allserver))	{	
		foreach($allserver as $server_data){
			$objphone->server_id	= $server_data->server_ip;
			$yesterday=date('Y-m-d',strtotime("-1 days"));
			$url='acl_cdr.php';
			$sql="Select COUNT(*) as c  From call_log WHERE date(call_date)='$yesterday'";
			$count=$objphone->get_results($sql);
			if(empty($count[0]->c)){
				if(!empty($yesterday)){			
				 $url .= '?date_start='.$yesterday;
				 $url .= '&date_end='.$yesterday;
				}			
				$results=$objphone->api($url);
				if(!empty($results->total)){			
				foreach($results->cdrs as $result){
					$res=array();
					$res['call_date']=$result[0];
					$res['server']=$server_data->server_ip;
					$res['call_from']=$result[1];
					$res['call_to']=$result[2];
					$res['call_status']=$result[5];
					$res['col4']=$result[3];
					$res['col5']=$result[4];
					$res['col7']=$result[6];
					$res['col8']=$result[7];
					$res['col9']=$result[8];
					$res['col10']=$result[9];
					$res['col11']=$result[10];
					$res['col12']=$result[11];
					$objphone->insert('call_log',$res);
				}
				}
			}
		}
	}	
	
			
	
	
?>
