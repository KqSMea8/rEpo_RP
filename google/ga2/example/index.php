<?php

require_once '../PHPGangsta/GoogleAuthenticator.php';

$ga = new PHPGangsta_GoogleAuthenticator();

$secret = $ga->createSecret();
//echo "Secret is: ".$secret."\n\n";

$qrCodeUrl = $ga->getQRCodeGoogleUrl('Blog', $secret);
//echo "Google Charts URL for the QR-Code: ".$qrCodeUrl."\n\n";

echo "<img src='".$qrCodeUrl."'>";

$oneCode = $ga->getCode($secret);
echo "<br>Checking Code '$oneCode' :<br>";

$checkResult = $ga->verifyCode($secret, $oneCode, 2);    // 2 = 2*30sec clock tolerance
if ($checkResult) {
    //echo 'OK';
} else {
    //echo 'FAILED';
}
