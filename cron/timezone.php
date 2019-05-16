<?php 
/*****timezone update by daylight saving in us**************/
require_once("includes/common.php");
$arryCompany = $objCompany->GetCompany('',1);

$StartTime = microtime(true);

$TodayDate = date("Y-m-d");
 						//$TodayDate = "2016-11-06"; //temp

$ArrylightSaving = $objCompany->GetDaylightSaving();
$DaylightStart = $ArrylightSaving[0]; 
$DaylightEnd = $ArrylightSaving[1]; 
$DaylightSaving  = $ArrylightSaving[2]; 
$TimezoneCompany = '';

 

if(sizeof($arryCompany)>0 && ($TodayDate==$DaylightStart || $TodayDate==$DaylightEnd)){ //march or november

	foreach($arryCompany as $key=>$values){
		$CountryName = trim(strtolower(stripslashes($values['Country'])));
		if($CountryName=='united states'){
			$TimezoneCompany .= $values['CompanyName'].', ';			
			$CmpDatabase = $Config['DbMain']."_".$values['DisplayName'];
			$objCompany->UpdateCompanyTimezone($values['CmpID'],$values['Country'],$values['State'],$values['City'],$CmpDatabase);
		}
		
	}
}


/**********/	 
$EndTime = microtime(true);
$ExecutionTime = $EndTime - $StartTime; 
echo "\nProcess Spent : ".time_diff(round($ExecutionTime))."\n";die;
/**********/



/*******************************************
	$FromName = 'ERP Cron';
	$FromEmail = 'source005@gmail.com';
	$To = 'parwez005@gmail.com';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();	
	$Subject = 'Cron Timezone '.$ThisPage;
	$contents = 'Cron Timezone updated for company: '.$TimezoneCompany;
	$pp = mail($To, $Subject, $contents, $headers);
	mail("pankaj.mca13@gmail.com", $Subject, $contents, $headers);	
	exit;
/*******************************************/

?>

