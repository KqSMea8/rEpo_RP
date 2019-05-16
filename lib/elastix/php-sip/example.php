<?php

require_once('PhpSIP.class.php');



try
{
  $api = new PhpSIP();
  $api->setUsername('4000'); // authentication username
  $api->setPassword('0a45601b845119cb403a391a8ffdgf5fba5e'); // authentication password
  // $api->setProxy('some_ip_here'); 
  $api->addHeader('Event: resync');
  $api->setMethod('NOTIFY');
  $api->setFrom('sip:4000@66.55.11.57');
  $api->setUri('sip:4000@66.55.11.57');
  $res = $api->send();

  echo "response: $res\n";
  
} catch (Exception $e) {
  
  echo $e;
}

?>
