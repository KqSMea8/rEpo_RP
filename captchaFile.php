<?php

$code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$code = substr(str_shuffle($code), 0, 4);
if (session_status() == PHP_SESSION_NONE) { 
    session_start();
}
$_SESSION["CAPTCHA_CODE"]=$code;
$im = imagecreatetruecolor(62, 26);
$bg = imagecolorallocate($im, 22, 86, 165); //background color blue
$fg = imagecolorallocate($im, 255, 255, 255);//text color white
imagefill($im, 0, 0, $bg);
imagestring($im, 8, 13, 5,  $code, $fg);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);


