<?php 
#this cron is running in each 5 minutes
if($parameters['ProcessName']=='AmazonLowestPrice'){
	$objProduct->runCronForLowestPrice($Prefix);
	#process name is same to run below function in each 5 minutes
	$objProduct->processAmazonSubmissionHistory($Prefix);
}

?>
