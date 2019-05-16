<?php
 
echo $_SERVER["REMOTE_HOST"];

echo '<br><br>'.$_SERVER["REMOTE_ADDR"];

die;

echo '<pre>';

print_r($_SERVER);

phpinfo();


?>


