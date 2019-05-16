 <?php
class fincity {


/* public function __fincity($Api_key,$url) {
        $this->patnerAuth($Api_key,$url);
     }*/


 public function patnerAuth($Api_key,$url) {

global $Config;


  $input_xml = '<credentials>
  <partnerId>'.$Config['partnerId'].'</partnerId>
  <partnerSecret>'.$Config['partnerSecret'].'</partnerSecret>
</credentials>';

				$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','Finicity-App-Key:'.$Api_key)); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

	$data = curl_exec($ch);
	curl_close($ch);


	$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

				
				return $array_data;
				


        
     }

public function GetInstution($Api_key,$url,$token) {

 $url='https://api.finicity.com/aggregation/v1/institutions';
$input_xml = ['search'=> " ",'start'=> "0",'limit'=> "10"];


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Finicity-App-Key:'.$Api_key.'','Finicity-App-Token:'.$token)); 
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

	$data = curl_exec($ch);
	curl_close($ch);


	$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

				
				return $array_data;
				
//curl -v -H "Finicity-App-Key:881b7bd2db8f58531838c6671a600911" -H "Finicity-App-Token:QMQtV5XyrFtIbwsCwwh4" -H "Accept:application/xml" -X GET "https://api.finicity.com/aggregation/v1/institutions"

        
     }
public function GetLoginForm($Api_key,$token) {

 $url='https://api.finicity.com/aggregation/v1/institutions/101211/loginForm';
//$input_xml = ['search'=> " ",'start'=> "0",'limit'=> "10"];

$input_xml='';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Finicity-App-Key:'.$Api_key.'','Finicity-App-Token:'.$token)); 
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

	$data = curl_exec($ch);
	curl_close($ch);


	$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

				
				return $array_data;
				
//curl -v -H "Finicity-App-Key:881b7bd2db8f58531838c6671a600911" -H "Finicity-App-Token:QMQtV5XyrFtIbwsCwwh4" -H "Accept:application/xml" -X GET "https://api.finicity.com/aggregation/v1/institutions"

        
     }

 function GetCutomer($Api_key,$arry) {

 $url='https://api.finicity.com/aggregation/v1/customers';
$token = $arry['token'];
$input_xml = ['search'=> $arry['customer']];

$input_xml='';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Finicity-App-Key:'.$Api_key.'','Finicity-App-Token:'.$token)); 
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

	$data = curl_exec($ch);
	curl_close($ch);


	$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

				
				return $array_data;
				
//curl -v -H "Finicity-App-Key:881b7bd2db8f58531838c6671a600911" -H "Finicity-App-Token:QMQtV5XyrFtIbwsCwwh4" -H "Accept:application/xml" -X GET "https://api.finicity.com/aggregation/v1/institutions"

        
     }

function GetCutomerAccounts($Api_key,$arry) {

 $url='https://api.finicity.com/aggregation/v1/customers/'.$arry['cuid'].'/accounts';
$token = $arry['token'];
//$input_xml = ['search'=> $arry['customer']];

$input_xml='';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Finicity-App-Key:'.$Api_key.'','Finicity-App-Token:'.$token)); 
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

	$data = curl_exec($ch);
	curl_close($ch);


	$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

				
				return $array_data;
				
//curl -v -H "Finicity-App-Key:881b7bd2db8f58531838c6671a600911" -H "Finicity-App-Token:QMQtV5XyrFtIbwsCwwh4" -H "Accept:application/xml" -X GET "https://api.finicity.com/aggregation/v1/institutions"

        
     }
function GetAccountTransaction($Api_key,$arry) {



 $url='https://api.finicity.com/aggregation/v1/customers/'.$arry['cuid'].'/accounts/'.$arry['accountID'].'/transactions?fromDate='.$arry['frDate'].'&toDate='.$arry['TDate'].'';
$token = $arry['token'];
//$input_xml = ['fromDate'=> $arry['frDate'],'toDate'=> $arry['TDate']];

//$input_xml='';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Finicity-App-Key:'.$Api_key.'','Finicity-App-Token:'.$token)); 
  curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

	$data = curl_exec($ch);
	curl_close($ch);


	$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

				
				return $array_data;
				
//curl -v -H "Finicity-App-Key:881b7bd2db8f58531838c6671a600911" -H "Finicity-App-Token:QMQtV5XyrFtIbwsCwwh4" -H "Accept:application/xml" -X GET "https://api.finicity.com/aggregation/v1/institutions"

        
     }


}
?>

