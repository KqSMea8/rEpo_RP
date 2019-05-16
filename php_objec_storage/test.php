<?php
//ob_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//session_start();
require 'vendor/autoload.php';
//session_destroy();

use \OpenStack\Bootstrap;
use \OpenStack\Identity\v2\IdentityService;
use \OpenStack\ObjectStore\v1\ObjectStorage;
use \OpenStack\ObjectStore\v1\Resource\Object;
use \OpenStack\ObjectStore\v1\Resource\ACL;
use \OpenStack\Common\Transport;

 $url  =  $_REQUEST['url'];

                         $objUser = "pramod";
						 $objPassword = "dMeK12I9I1jj";
						 $teantID = "686913a917184cd88695ffc77d3b48a7";
						 $objURL = "http://172.21.15.15:5000";
                        
						$idService = new IdentityService($objURL); 
                         
						
						$token = $idService->authenticateAsUser($objUser, $objPassword, $teantID);
                                 
						$catalog = $idService->serviceCatalog();
						$storageList = $idService->serviceCatalog('object-store');
						$objectStorageUrl = $storageList[0]['endpoints'][0]['publicURL'];

						// Create a new ObjectStorage instance:
						$objectStore = new  ObjectStorage( $token,  $objectStorageUrl);
	
	
	
	
						$OpenFilePathaArray =  explode('/',$url);       

   try{
						$container = $objectStore->container($OpenFilePathaArray[5]);
						$name = $OpenFilePathaArray[6];
						$obj = $container->object($name); 
	                    header('Content-Disposition: attachment; filename="' . $name . '"');
						header("Content-type:".$obj->contentType());
						header("Content-length: " . $obj->ContentLength());

						print $obj->content();
	
	                     die;						
                        
   } catch (Exception $e) {
      // echo 'Caught exception: ',  $e->getMessage(), "\n";
       echo 'File has been removed from server';
	   die;
    }					
						
						
					
	



?>
