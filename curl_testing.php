           <?php  
			ini_set('error_reporting', E_ALL);
			  $ch = curl_init();
			//$postData="";
			//$url  =  "http://199.227.27.207/erp/curl_testing1.php";
			 //$url  =  "https://66.55.11.57/webservice/acl_extention.php";
			//curl_setopt($ch, CURLOPT_URL,$url);
			$post=array('companyid'=>37,'server'=>'www.eznetcrm.com');
			$handle=curl_init('https://www.eznetcrm.com:8080/getcompanylicence');
			curl_setopt($handle, CURLOPT_VERBOSE, true);
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			foreach($post as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
					rtrim($fields_string, '&');
				if(!empty($fields_string)){
					curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);
				}
			//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  // Wrong variable in Code
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 2); // Wrong variable in  Code
			curl_setopt($handle, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
			curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);  // Fixed Code
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);  // Fixed Code
$aaaa=curl_exec($handle);
			if(curl_exec($handle) === false)
			{
			    echo 'Curl error: ' . curl_error($handle);
			}
			else
			{
			    echo 'Operation completed without any errors';
			    echo "<br>";
			    echo $aaaa; 
			}
			
			// Close handle
			curl_close($ch);		
			
