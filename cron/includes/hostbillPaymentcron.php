<? 
//ini_set('display_errors',1);

require_once($Prefix."lib/hostbillapi/class.hbwrapper.php");

require_once($Prefix."classes/hostbill.class.php");

$objhostbill=new hostbill(array('cron'));
//var_dump($objhostbill->isActiveHostbill());
if($objhostbill->isActiveHostbill()==true){
			$hostbillsettingdata=$objhostbill->GetTempHostbillSetting();
			$objhostbill->api_url=$hostbillsettingdata['api_url'];
			$objhostbill->api_key=$hostbillsettingdata['api_key'];
			$objhostbill->api_id=$hostbillsettingdata['api_id'];	
			$responce=$objhostbill->CheckHostbillcredencial();
			if(empty($responce["error"])){
				$objhostbill->SaveHostbillpayment();
			}
}

 
?>
