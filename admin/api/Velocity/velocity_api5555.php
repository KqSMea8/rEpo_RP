<?php 

require_once dirname(__FILE__) . '/sdk/Velocity.php';

class velocity_api {

	var $identitytoken = 'PHNhbWw6QXNzZXJ0aW9uIE1ham9yVmVyc2lvbj0iMSIgTWlub3JWZXJzaW9uPSIxIiBBc3NlcnRpb25JRD0iX2E4ZDQyOTkzLWJlODctNDEwYS05NjZhLTYyZDJhYjNhMDNlOCIgSXNzdWVyPSJJcGNBdXRoZW50aWNhdGlvbiIgSXNzdWVJbnN0YW50PSIyMDE2LTA5LTIwVDIxOjE2OjQxLjg2MFoiIHhtbG5zOnNhbWw9InVybjpvYXNpczpuYW1lczp0YzpTQU1MOjEuMDphc3NlcnRpb24iPjxzYW1sOkNvbmRpdGlvbnMgTm90QmVmb3JlPSIyMDE2LTA5LTIwVDIxOjE2OjQxLjg2MFoiIE5vdE9uT3JBZnRlcj0iMjA0Ni0wOS0yMFQyMToxNjo0MS44NjBaIj48L3NhbWw6Q29uZGl0aW9ucz48c2FtbDpBZHZpY2U+PC9zYW1sOkFkdmljZT48c2FtbDpBdHRyaWJ1dGVTdGF0ZW1lbnQ+PHNhbWw6U3ViamVjdD48c2FtbDpOYW1lSWRlbnRpZmllcj42RUExMjlBOUM0NzAwMDAxPC9zYW1sOk5hbWVJZGVudGlmaWVyPjwvc2FtbDpTdWJqZWN0PjxzYW1sOkF0dHJpYnV0ZSBBdHRyaWJ1dGVOYW1lPSJTQUsiIEF0dHJpYnV0ZU5hbWVzcGFjZT0iaHR0cDovL3NjaGVtYXMuaXBjb21tZXJjZS5jb20vSWRlbnRpdHkiPjxzYW1sOkF0dHJpYnV0ZVZhbHVlPjZFQTEyOUE5QzQ3MDAwMDE8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48c2FtbDpBdHRyaWJ1dGUgQXR0cmlidXRlTmFtZT0iU2VyaWFsIiBBdHRyaWJ1dGVOYW1lc3BhY2U9Imh0dHA6Ly9zY2hlbWFzLmlwY29tbWVyY2UuY29tL0lkZW50aXR5Ij48c2FtbDpBdHRyaWJ1dGVWYWx1ZT5lYWZjMjU1Ny01ZWMxLTRjYTMtODVhNC0wODFlZjhmNTViNjU8L3NhbWw6QXR0cmlidXRlVmFsdWU+PC9zYW1sOkF0dHJpYnV0ZT48c2FtbDpBdHRyaWJ1dGUgQXR0cmlidXRlTmFtZT0ibmFtZSIgQXR0cmlidXRlTmFtZXNwYWNlPSJodHRwOi8vc2NoZW1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYWltcyI+PHNhbWw6QXR0cmlidXRlVmFsdWU+NkVBMTI5QTlDNDcwMDAwMTwvc2FtbDpBdHRyaWJ1dGVWYWx1ZT48L3NhbWw6QXR0cmlidXRlPjwvc2FtbDpBdHRyaWJ1dGVTdGF0ZW1lbnQ+PFNpZ25hdHVyZSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnIyI+PFNpZ25lZEluZm8+PENhbm9uaWNhbGl6YXRpb25NZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAxLzEwL3htbC1leGMtYzE0biMiPjwvQ2Fub25pY2FsaXphdGlvbk1ldGhvZD48U2lnbmF0dXJlTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnI3JzYS1zaGExIj48L1NpZ25hdHVyZU1ldGhvZD48UmVmZXJlbmNlIFVSST0iI19hOGQ0Mjk5My1iZTg3LTQxMGEtOTY2YS02MmQyYWIzYTAzZTgiPjxUcmFuc2Zvcm1zPjxUcmFuc2Zvcm0gQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjZW52ZWxvcGVkLXNpZ25hdHVyZSI+PC9UcmFuc2Zvcm0+PFRyYW5zZm9ybSBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDEvMTAveG1sLWV4Yy1jMTRuIyI+PC9UcmFuc2Zvcm0+PC9UcmFuc2Zvcm1zPjxEaWdlc3RNZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjc2hhMSI+PC9EaWdlc3RNZXRob2Q+PERpZ2VzdFZhbHVlPmJNcHNJNEJiTlV5YzJNRDl4dWdWSXFWWlplRT08L0RpZ2VzdFZhbHVlPjwvUmVmZXJlbmNlPjwvU2lnbmVkSW5mbz48U2lnbmF0dXJlVmFsdWU+cS9NRElsdEdqUzdpTnRrZ0VrcTlkQXY3VE02TDAxajdMckFDdmpEMlpSQUhYU1VFVWo4c0RvdGVob09xYktXMlhsTm5HRTVlRTcza293L2F5K0haVmhDTytaQk4xMExSdWVVNG1HSVkxWlJidnlTQysyQWZwQXlVQU11VVhLdFJSZHNBTHFBcnNRdkQrVjVXMTNreUtVeWJFUisyTWwwOTN6S2hFOWRXTy9vaHhHUzMrdGVSWWM5dTdvV0hYcENNY1pIOHI3VVg3ZTR0Qkt6U0xmSWU4UHpxbUNMOXhhNFlvWTNpQkR6YXE4eEFpRmpMVG54enVwQS8vQUV2QzMvRGgwamZ2UWdSaTNKNHRvUDJzVUtLaXp0K3FncGxzYW55SEc2SWdGWTRLa3FlaWk1TU9zSUQvamhGQ1FaaEt2em1FUzF5MEd6cFJGK3k3aFp3amQwcXVBPT08L1NpZ25hdHVyZVZhbHVlPjxLZXlJbmZvPjxvOlNlY3VyaXR5VG9rZW5SZWZlcmVuY2UgeG1sbnM6bz0iaHR0cDovL2RvY3Mub2FzaXMtb3Blbi5vcmcvd3NzLzIwMDQvMDEvb2FzaXMtMjAwNDAxLXdzcy13c3NlY3VyaXR5LXNlY2V4dC0xLjAueHNkIj48bzpLZXlJZGVudGlmaWVyIFZhbHVlVHlwZT0iaHR0cDovL2RvY3Mub2FzaXMtb3Blbi5vcmcvd3NzL29hc2lzLXdzcy1zb2FwLW1lc3NhZ2Utc2VjdXJpdHktMS4xI1RodW1icHJpbnRTSEExIj5ZREJlRFNGM0Z4R2dmd3pSLzBwck11OTZoQ2M9PC9vOktleUlkZW50aWZpZXI+PC9vOlNlY3VyaXR5VG9rZW5SZWZlcmVuY2U+PC9LZXlJbmZvPjwvU2lnbmF0dXJlPjwvc2FtbDpBc3NlcnRpb24+';
	var $applicationprofileid = '71213';
	var $merchantprofileid =  'Virtual Stacks Ecomm EPX';
	var $workflowid = '8D9DE00001';
	var $isTestAccount = true;
	var $IndustryType = 'Ecommerce';
	
	function Velocity($arrdetails){
		extract($arrdetails);
		$this->identitytoken = $identitytoken;
		$this->applicationprofileid = $applicationprofileid;
		$this->merchantprofileid = $merchantprofileid;
		$this->workflowid = $workflowid;
		$this->isTestAccount = $isTestAccount;
		$this->IndustryType = $IndustryType;
	}
	
	function validateCredential(){ 
		//$si = new GetServiceInformation (); 

		$avsData  = array('Street' => '1 Main St', 'City' => 'San Jose', 'PostalCode' => '95131');
		$cardData = array('cardowner' => 'Jane Doe', 'cardtype' => 'Visa', 'pan' => '4012888812348882', 'expire' => '1218', 'cvv' => '123');
		
		try {
			$obj_transaction = new VelocityProcessor( $this->applicationprofileid, $this->merchantprofileid, $this->workflowid, $this->isTestAccount, $this->identitytoken, null);
			return array('status'=>1,'message'=>'Authentication Validated Successfully.');
			/* try {
				$response = $obj_transaction->verify(array(
						'amount'       => 1.00,
						'avsdata'      => $avsData,
						'carddata'     => $cardData,
						'entry_mode'   => 'Keyed',
						'IndustryType' => $this->IndustryType,
						'Reference'    => 'Ezneterp',
						'EmployeeId'   => '11'
				));
				
				if (is_array($response) && isset($response['Status']) && $response['Status'] == 'Successful') 
					return array('status'=>1,'message'=>'Authentication Validated Successfully.');
				else
					return array('status'=>0,'errors'=>$response);
				
			} catch (Exception $e) {
				return array('status'=>0,'errors'=>$e->getMessage());
			} */
			
			
		} catch(Exception $e) {
			if(strcmp($e->getMessage(), 'An invalid security token was provided') == 0)
				return array('status'=>0,'errors'=>'An invalid security token was provided');
			else
				return array('status'=>0,'errors'=>$e->getMessage());
		}
	}

	function processPayment($Order_id,$paymentType,$amount,$creditCardType,$creditCardNumber,$expDate,$cvv2Number,$firstName,$lastName,$address1,$city,$state,$zip,$country,$currencyCode,$orderDescription) { //echo $currencyCode;die;
		//$address  = $_POST['address1'] . ' ' . $_POST['address2'];
		//$city     = $_POST['city'];
		//$state    = $_POST['state'];
		//$postcode = $_POST['zip'];
		//$country  = $_POST['billing_country'];
		//$phone    = $_POST['billing_phone'];
		//$total    = $_POST['amount']; // @In float no.
		$avsData  = array('Street' => '1 Main St', 'City' => 'San Jose', 'PostalCode' => '95131');
		$cardData = array('cardowner' => 'Jane Doe', 'cardtype' => 'Visa', 'pan' => '4012888812348882', 'expire' => '1218', 'cvv' => '123');
		//$cardData = array('cardowner' => $_POST['card_owner'], 'cardtype' => $_POST['creditCardType'], 'pan' => $_POST['cardnumber'], 'expire' => $_POST['exp_month'].$_POST['exp_year'], 'cvv' => $_POST['cvvnumber'], 'track1data' => '', 'tarck2data' => '');

		$fullname = $firstName.$lastName;
		$total    = $amount; 
		//$avsData  = array('Street' => $address1, 'City' => $city, 'PostalCode' => $zip);
		//$cardData = array('cardowner' => $fullname, 'cardtype' => $creditCardType, 'pan' => '4012888812348882', 'expire' => $expDate, 'cvv' => $cvv2Number);
	
		try {
			$obj_transaction = new VelocityProcessor( $this->applicationprofileid, $this->merchantprofileid, $this->workflowid, $this->isTestAccount, $this->identitytoken, null);  

		} catch(Exception $e) {
			if(strcmp($e->getMessage(), 'An invalid security token was provided') == 0)
				throw new Exception('Your order cannot be completed at this time. Please contact customer care. Error Code 8124');
				else
					throw new Exception($e->getMessage()); 
                                        return;
		}
	
		try {
			//print_r($obj_transaction);
	//die('dsfdsf');
			$response = $obj_transaction->verify(array(
					'amount'       => $total,
					'avsdata'      => $avsData,
					'carddata'     => $cardData,
					'entry_mode'   => 'Keyed',
					'IndustryType' => $this->IndustryType,
					'Reference'    => 'Ezneterp',
					'EmployeeId'   => '11'
			));
			//return $response;
			//echo '<pre>';print_r($response);die;
	
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	
		try {
	
			if (is_array($response) && isset($response['Status']) && $response['Status'] == 'Successful') { //echo "hello";die;

				$res_authandcap = $obj_transaction->authorizeAndCapture(array(
						'amount'       => $total,
						'avsdata'      => $avsData,
						'token'        => $response['PaymentAccountDataToken'],
						'order_id'     => $Order_id,
						'entry_mode'   => 'Keyed',
						'IndustryType' => $this->IndustryType,
						'Reference'    => 'Ezneterp',
						'EmployeeId'   => '11'
				));
               
		//echo '<pre>';print_r($res_authandcap);die;
				/******************To get return message ****************/
				 if (is_array($res_authandcap) && isset($res_authandcap['StatusCode']) && $res_authandcap['StatusCode'] == '000' ) { //echo "hello";die;
					return $res_authandcap;
					/*try {
						$xml = VelocityXmlCreator::authorizeandcaptureXML( array(
								'amount'       => $total,
								'token'        => $response['PaymentAccountDataToken'],
								'avsdata'      => $avsData,
								'order_id'     => $order_id,
								'entry_mode'   => 'Keyed',
								'IndustryType' => 'Ecommerce',
								'Reference'    => 'xyz',
								'EmployeeId'   => '11'
						)
								);  
	
								$req = $xml->saveXML();
								$obj_req = serialize($req);
	
					} catch (Exception $e) {
						throw new Exception($e->getMessage());
					}*/
				} 
				/***************************************/
			} else if (is_array($response) &&(isset($response['Status']) && $response['Status'] != 'Successful')) {
			 return array('status'=>0,'errors'=>$response['StatusMessage']);
                } else if (is_string($response)) {
                        if (strcmp(trim($response) , 'ApplicationProfileId is not valid.<br>') == 0)
                            return array('status'=>0,'errors'=>'Your order cannot be completed at this time. Please contact customer care. Error Code 1010');
                        else if (strip_tags(strstr($response , $this->workflowid)) == $this->workflowid)
                           // throw new Exception('Your order cannot be completed at this time. Please contact customer care. Error Code 9621'); 
				return array('status'=>0,'errors'=>'Your order cannot be completed at this time. Please contact customer care. Error Code 9621');  
                        else if (strlen($response) == 702) 
                            //throw new Exception('Your order cannot be completed at this time. Please contact customer care. Error Code2408'); 
return array('status'=>0,'errors'=>'Your order cannot be completed at this time. Please contact customer care. Error Code2408');                                       
                        else
                          return array('status'=>0,'errors'=>$response);  
                } else {
                        throw new Exception('Unknown Error in verification process please contact the site admin');
                }
                
                
            } catch (Exception $ex) {
                    throw new Exception($ex->getMessage());
            }

        }
        
        
        
        function refundPayment($refund_ammount, $transaction_id) { //echo $transaction_id;die;
        
        	try {
        		$obj_transaction = new VelocityProcessor($this->applicationprofileid, $this->merchantprofileid, $this->workflowid, $this->isTestAccount, $this->identitytoken, null);
//echo '<pre>';print_r($obj_transaction);die;
        	} catch(Exception $e) {
        		print_r($e->getMessage());
        		return;
        	}
        
        	try {
        
        		$res_returnbyid = $obj_transaction->returnById( array(
        				'amount' => $refund_ammount,
        				'TransactionId' => $transaction_id
        		)
        				);
//echo '<pre>';print_r($res_returnbyid);die;
        		/******************To get return message ****************/
        		/* try {
        			$xml = VelocityXmlCreator::returnByIdXML(number_format($refund_ammount, 2, '.', ''), $transaction_id);  // got ReturnById xml object.
        
        			$req = $xml->saveXML();
        			$obj_req = serialize($req);
        
        		} catch (Exception $e) {
        			throw new Exception($e->getMessage());
        		} */
        		/*************************************/
        
        		if (is_array($res_returnbyid) && isset($res_returnbyid['StatusCode']) && $res_returnbyid['StatusCode'] == '000' ) { 
        
        			echo "SuccessFully Refunded";
        
        		} else if (is_array($res_returnbyid) && isset($res_returnbyid['StatusCode']) && $res_authandcap['StatusCode'] != '000') {
        			throw new Exception($res_returnbyid['StatusMessage']);
        		} else if (is_string($res_returnbyid)) {
        			throw new Exception($res_returnbyid);
        		} else {
        			throw new Exception('Unkown Error occurs please contact the site admin or technical team.');
        		}
        
        	} catch(Exception $ex) {
        		print_r($ex->getMessage());
        	}
        
        }
        
        function voidPayment($transaction_id) {
        
        	try {
        		$obj_transaction = new VelocityProcessor($this->applicationprofileid, $this->merchantprofileid, $this->workflowid, $this->isTestAccount, $this->identitytoken, null);
	
        	} catch(Exception $e) {
        		print_r($e->getMessage());
        		return;
        	}
        
        	try {
        
        		$res_undo = $obj_transaction->undo(array(
				'TransactionId' => $transaction_id
				));
        		//return $res_undo;
        		/******************To get return message ****************/
        		/* try {
        			$xml = VelocityXmlCreator::undoXML(number_format($refund_ammount, 2, '.', ''), $transaction_id);  // got ReturnById xml object.
        
        			$req = $xml->saveXML();
        			$obj_req = serialize($req);
        
        		} catch (Exception $e) {
        			throw new Exception($e->getMessage());
        		} */
        		/*********************************************/
        		//echo '<pre>';print_r($res_undo);die;
        		if (is_array($res_undo) && isset($res_undo['StatusCode']) && $res_undo['Status'] == 'Successful') {  //echo "if condition";die;
        		//return array('status'=>0,'errors'=>'SuccessFully Void'); 
        			//echo "SuccessFully Void"; 
       				return $res_undo;
        		} else if (is_array($res_undo) && isset($res_undo['StatusCode']) && $res_undo['StatusCode'] != '000') { 
        			throw new Exception($res_undo['StatusMessage']);
        		} else if (is_string($res_undo)) {  
        			//throw new Exception($res_undo);
				return array('status'=>0,'errors'=>$res_undo); 
        		} else {  
        			throw new Exception('Unkown Error occurs please contact the site admin or technical team.');
        		}
        
        	} catch(Exception $ex) {
        		print_r($ex->getMessage());
        	}
        
        }
}			
?>
