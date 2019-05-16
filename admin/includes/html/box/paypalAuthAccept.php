<?php 
session_start();
require_once("includes/config.php"); 
require_once("includes/function.php");

if(!empty($_SESSION['AdminID'])){
		$code=$_GET['code'];	
		$myfile = fopen("paypal.auth.txt", "a") or die("Unable to open file!");
		$txt = $cmd;
		fwrite($myfile, print_r($_GET,true));
		fclose($myfile);
			
		/*$cmd='curl https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/tokenservice \
  -u "AeltrsAaLhkq_ENX_XqyJc3Xo5USwg7mBb9I2_xvmYL8GRp51q6Bd8PlyO5C5J6jksdboR1Rz7I73zRe:EN7TfQIXvzBDRhjl1YNqeAmX5zJeEHL9Ks8bkf-zGuXAwlQ0F77MNwABd49LGOzyToB2F7qqItWIJTet" \  -d grant_type=authorization_code \  -d code='.$code;*/
$cmd='curl https://www.paypal.com/webapps/auth/protocol/openidconnect/v1/tokenservice \
  -u "AQZ4wvC7sS6xKMgfNWdyqjmAYDxKLkdKNE5TEepaDKWIXouZKC5tki2rr1_nW-L0ok-b4VipmLB-0ny4:EDjgqc4HE-1TcHn9v-Ja96RwD_Im8sgpGFGI9f42CWr616-AquIfqrgDIhx2CYnnL7qQ1wq40HouUZkq" \  -d grant_type=authorization_code \  -d code='.$code;

  if($_SESSION['AdminID']==37){
$cmd='curl https://www.sandbox.paypal.com/webapps/auth/protocol/openidconnect/v1/tokenservice \
  -H "AeltrsAaLhkq_ENX_XqyJc3Xo5USwg7mBb9I2_xvmYL8GRp51q6Bd8PlyO5C5J6jksdboR1Rz7I73zRe:EN7TfQIXvzBDRhjl1YNqeAmX5zJeEHL9Ks8bkf-zGuXAwlQ0F77MNwABd49LGOzyToB2F7qqItWIJTet" \  -d grant_type=authorization_code \  -d code='.$code;


		}
		$myfile = fopen("paypal.auth.txt", "a") or die("Unable to open file!");
		$txt = $cmd;
		fwrite($myfile, $txt);
		fclose($myfile);

exec($cmd,$result);
$myfile = fopen("paypal.auth.txt", "a") or die("Unable to open file!");
		$txt = $cmd;
		fwrite($myfile, print_r($result,true));
		fclose($myfile);

$mydata=json_decode($result[0]);
$Config['DbName']=$_SESSION['CmpDatabase'];
$link=mysql_connect ($Config['DbHost'],mydecrypt($Config['DbUser']),mydecrypt($Config['DbPassword']),TRUE);
if(!$link){die("Could not connect to MySQL");}
mysql_select_db($Config['DbName'],$link) or die ("could not open db".mysql_error());
//$sql="UPDATE  `settings` SET `setting_value`='".$mydata->refresh_token."' WHERE setting_key='PAYPAL_TOKEN'";

$sql="UPDATE  `f_payment_provider` SET `PaypalToken`='".$mydata->refresh_token."' WHERE ProviderID='1'";


/*$sql="INSERT INTO `settings` (`visible`, `input_type`, `group_id`, 
`group_name`, `caption`, `setting_key`, `setting_value`, `options`, 
`validation`, `dep_id`, `priority`, `FixedCol`) VALUES ('Yes', 'text', 
1, 'Global Settings', 'PayPal Token', 'PAYPAL_TOKEN', '', '', 'No', 0, 
4, 0);";*/
mysql_query($sql);

echo '<script>  window.opener.location.reload();close();</script>';
	//return $server_output;
		
}


?>
