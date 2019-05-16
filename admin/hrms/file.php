<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../../objectStorage/vendor/autoload.php';

use \OpenStack\Bootstrap;
use \OpenStack\Identity\v2\IdentityService;
use \OpenStack\ObjectStore\v1\ObjectStorage;
use \OpenStack\ObjectStore\v1\Resource\Object;
use \OpenStack\ObjectStore\v1\Resource\ACL;
use \OpenStack\Common\Transport;


$Username = "pramod";
$Password = "dMeK12I9I1jj";
$TenantId = "686913a917184cd88695ffc77d3b48a7";
$Url = 'http://172.21.15.15:5000';
$idService = new IdentityService($Url);
/*
$idService = new IdentityService($Url); 
$acl = ACL::makePublic();
$Token = $idService->authenticateAsUser($Username, $Password, $TenantId); 
$_SESSION['auth_token'] = $Token;
$catalog = $idService->serviceCatalog();

$storageList = $idService->serviceCatalog('object-store');  
$objectStorageUrl = $storageList[0]['endpoints'][0]['publicURL'];
$_SESSION['auth_storage_url'] = $objectStorageUrl;
$objectStore = new \OpenStack\ObjectStore\v1\ObjectStorage($Token, $objectStorageUrl);

 $container = $objectStore->container('abbas-1');
 $objectStore->changeContainerACL('abbas-1',$acl);

$name = '10.jpg';
$content = file_get_contents($name);

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo,$name); 


$localObject = new Object($name,$content,$mime);
if(!$container->save($localObject))
{
    echo "Not able to wirte please try again";
    exit;
}else{
echo "file savedin container";exit;
}
*/





	 $acl = ACL::makePublic();
	
	 $Token = $idService->authenticateAsUser($Username, $Password, $TenantId); 

	$_SESSION['auth_token'] = $Token;
	$catalog = $idService->serviceCatalog();
	$storageList = $idService->serviceCatalog('object-store'); 
	$objectStorageUrl = $storageList[0]['endpoints'][0]['publicURL'];
	$_SESSION['auth_storage_url'] = $objectStorageUrl;
	/*$objectStore = new \OpenStack\ObjectStore\v1\ObjectStorage($Token, $objectStorageUrl);

	$container = $objectStore->container('abbas-1');
	$objectStore->changeContainerACL('abbas-1',$acl);*/
	$allowed = array('png', 'jpg', 'gif','zip','mp4','mov','pdf');

if(isset($_FILES['image']) && $_FILES['image']['error'] == 0 && !empty($Token)){  

	$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
        
    // Create a new ObjectStorage instance:
    $objectStore = new \OpenStack\ObjectStore\v1\ObjectStorage($Token, $objectStorageUrl);
    // create container
     $CmpID = '37';
     $objectStore->createContainer($CmpID);
     $container = $objectStore->container($CmpID);
     $objectStore->changeContainerACL($CmpID,$acl);


//echo '<pre>';print_r($container);die;
     // move temp file
$folder = 'images/';
     $file_name =  $_FILES['image']['name'];
	$pic_loc = $_FILES['image']['tmp_name'];
    // $new_fileName =  time().'.'.substr($file_name, strrpos($file_name, '.')+1);
   // echo $_FILES['image']['tmp_name'].'<br>'.$new_fileName;die;
     if(move_uploaded_file($pic_loc,$file_name)){
                // save file
            shell_exec('chmod -R 777 /opt/lampp/htdocs/objectStorage/');
            $name =  $file_name;
           $content = file_get_contents($name);
           $finfo = finfo_open(FILEINFO_MIME_TYPE);
           $mime = finfo_file($finfo,$name); 
           // delete
           
           $localObject = new Object($name,$content,$mime);
           //echo '<pre>';print_r($localObject);die;
           if(!$container->save($localObject))
           {

               echo "you not upload the image on container";die;

           }else{
		echo "you upload the image on container";die;
		}
           //unlink($new_fileName);
	}else{

	echo "hello";die;
}
/*$pic_loc = $_FILES['image']['tmp_name'];
$folder = 'images/';
if(move_uploaded_file($pic_loc,$folder.$file_name))
        {
            ?><script>alert('successfully uploaded');</script><?php
        }
        else
        {
            ?><script>alert('error while uploading file');</script><?php
} */
    
     //echo 'file upload with name '.$name;
		//exit;
	
}

?>
<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
	Select Image :
         <input type="file" name="image" /><br/>
         <input type="submit"/>
      </form>
      
   </body>
</html>
