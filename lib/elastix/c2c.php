
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
 
<head><title>PHP-SIP Click to Call</title></head>
 
<body>
 
<?php if (isset($_POST['from']) && isset($_POST['to'])) : ?>
 
 <?php require_once('php-sip/PhpSIP.class.php') ?>
 
  <?php $from = $_POST['from']; $to = $_POST['to'] ?>
 
  Trying call from <?php echo $from ?> to <?php echo $to ?> ...<br />
 
  <?php flush() ?>
 
  <pre>
  <?php
 
    try{
 
      $api = new PhpSIP();
      // if you get "Failed to obtain IP address to bind. Please set bind address manualy."
      // error, use the line below instead
      // $api = new PhpSIP('you_server_IP_address');
 
      $api->setDebug(true);
 
      // if your SIP service doesn't accept anonymous inbound calls uncomment two lines below
      $api->setUsername('3020');
      $api->setPassword('pa123456');
 
      $api->addHeader('Subject: click2call');
      $api->setMethod('INVITE');
      $api->setFrom('sip:c2c@'.$api->getSrcIp());
      $api->setUri($from);
 
      $res = $api->send();
 
      if ($res == 200) {
        $api->setMethod('REFER');
        $api->addHeader('Refer-to: '.$to);
        $api->addHeader('Referred-By: sip:c2c@'.$api->getSrcIp());
        $api->send();
 
        $api->setMethod('BYE');
        $api->send();
 
        $api->listen('NOTIFY');
        $api->reply(481,'Call Leg/Transaction Does Not Exist');
      }
 
      if ($res == 'No final response in 5 seconds.') {
        $api->setMethod('CANCEL');
        $res = $api->send();
      }
 
      echo $res;
 
    } catch (Exception $e) {
 
      echo "Opps... Caught exception:";
      echo $e;
    }
 
  ?>
  </pre>
  <hr />
 
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Back</a>
 
<?php else : ?>
 
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <fieldset>
      From: <input type="text" name="from" size="25" value="sip:3020@66.55.11.57" />
      To: <input type="text" name="to" size="25" value="sip:3021@66.55.11.57" />
      <input type="submit" value="Call" />
    </fieldset>
  </form>
 
<?php endif ?>
 
</body>
</html>
