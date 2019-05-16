<?php
//$SetFullPage = 1;
require_once($Prefix . "classes/finance.class.php");
$objCommon = new common();
$RedirectURL = "viewPaymentProvider.php";
$_GET['view']=(int)$_GET['view'];
if(!empty($_GET['view'])) {
    $arryProvider = $objCommon->GetPaymentProvider($_GET['view'], '');
    $ProviderID = $arryProvider[0]['ProviderID'];
}
       
if(empty($ProviderID)){
	header("Location:" . $RedirectURL);
	exit;
}

?>
<div><a href="<?= $RedirectURL ?>"  class="back">Back</a></div>


<div class="had">
    <?= $MainModuleName ?>    <span> &raquo;
        
<?=stripslashes($arryProvider[0]['ProviderName'])?> &raquo; API Instructions
    </span>
</div>
<style>
#infotable img { margin:10px auto;display:table; border:2px solid #666; border-radius:8px; }
</style>
 
 
<?
switch($ProviderID){
	case 1: //PayPal Standard Pro
		include("../includes/html/box/api_paypalpro_info.php");
		break;
	case 2: //PayPal Payflow
		include("../includes/html/box/api_paypalpayflow_info.php");
		break;
	case 3: //Authorize.Net
		include("../includes/html/box/api_authorize_info.php");
		break;
	case 4: //Authorize.Net
		include("../includes/html/box/api_velocity_info.php");
		break;
}

?>
   

       
 




