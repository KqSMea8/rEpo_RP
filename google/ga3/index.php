<?php
require 'vendor/autoload.php';
$authenticator = new PHPGangsta_GoogleAuthenticator();
$secret = $authenticator->createSecret();
#echo "Secret: ".$secret."\n";;

$oneCode = $authenticator->getCode($secret);

$website = 'ezneterp.com';  
$title= 'eZnetERP';
$qrCodeUrl = $authenticator->getQRCodeGoogleUrl($title, $secret,$website);
 
 

?>

<br><br>
<div align="center">
	<img src="<?=$qrCodeUrl?>">
	<br><br>
	Authentication Code: <b><?=$oneCode?></b>
</div>
