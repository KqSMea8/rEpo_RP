<?php
   require 'vendor/autoload.php';

    use \OpenStack\Bootstrap;

    Bootstrap::useStreamWrappers();
$ini['username'] = "demo";
$ini['password'] = "pass@123";
$ini['tenantId'] = "163e0ee32577466f9f06d1a506aca147";
$ini['url']= 'http://192.168.0.114:5000';
	// $ini['url'] = 'http://192.168.0.114:8080/v1';
// Load these from an ini file.
//$ini = parse_ini_file(getenv('HOME') . '/.OpenStack.ini');
$username = $ini['username'];
$password = $ini['password'];
$tenantId = $ini['tenantId'];
$endpoint = $ini['url'];
    $cxt = stream_context_create(array(
      'swift' => array(
        'username' => $username,
        'password' => $password,
        'tenantid' => $tenantId,
        'endpoint' => $endpoint,    
      ),
    ));

    print file_get_contents('swift://192.168.0.114:8080/v1/AUTH_163e0ee32577466f9f06d1a506aca147/pramod-2/1454306186.jpg', FALSE, $cxt);
    ?>