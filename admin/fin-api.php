<?php
$HideNavigation = 1;

	include_once("includes/header.php");
include_once("includes/finicity.config.php");
include_once("../classes/fin.api.class.php");
$objFiniCity = new fincity();

$Token = $objFiniCity->patnerAuth($Api_key,$url);




if(!empty($Token['token']) && $Token['token']!=''  ){


header('location:fin-api-customer.php?token='.$Token['token']); exit;




}

?>
