<?php 

require_once dirname(__FILE__) . '/sdk/Velocity.php';

class Velocity{

	var $identitytoken = "";
	var $applicationprofileid = 0;
	var $merchantprofileid = ""; 
	var $workflowid = ''; 	
	var $IndustryType = '';
	
	function Velocity($arrdetails){ 
		extract($arrdetails);
		$this->identitytoken = $NabToken;
		$this->applicationprofileid = $NabApplicationID;
		$this->merchantprofileid = $NabMerchantID;
		$this->workflowid = $NabServiceID;
		$this->isTestAccount = false;
	 	$this->IndustryType = $NabIndustry; 
	}
	
	function validateCredential(){  
		//$si = new GetServiceInformation ();
		//$avsData  = array('Street' => '1 Main St', 'City' => 'San Jose', 'PostalCode' => '95131'); 
		//$cardData = array('cardowner' => 'Jane Doe', 'cardtype' => 'Visa', 'pan' => '4012888812348882', 'expire' => '1218', 'cvv' => '123');

		if(empty($this->identitytoken) || empty($this->applicationprofileid) || empty($this->merchantprofileid) || empty($this->workflowid) || empty($this->IndustryType)){
			return array('status'=>0,'errors'=>'An invalid credentials.');
		}
 


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


	function processPayment($OrderID,$amount,$creditCardType,$creditCardNumber,$expDate,$cvv2Number,$firstName,$lastName,$address1,$city,$state,$zip,$country,$currencyCode,$ReferenceNo) { //echo $currencyCode;die;
		$fullname = $firstName.' '.$lastName;

		$avsData  = array('Street' => $address1, 'City' => $city, 'State' => $state, 'PostalCode' => $zip);
		$cardData = array('cardowner' => trim($fullname), 'cardtype' => $creditCardType, 'pan' => $creditCardNumber, 'expire' => $expDate, 'cvv' => $cvv2Number);		

		
				
		if(empty($this->identitytoken) || empty($this->applicationprofileid) || empty($this->merchantprofileid) || empty($this->workflowid) || empty($this->IndustryType)){			 
			return array('status'=>0,'errors'=>'An invalid credentials.');
		}


	
		try {
			$obj_transaction = new VelocityProcessor( $this->applicationprofileid, $this->merchantprofileid, $this->workflowid, $this->isTestAccount, $this->identitytoken, null);  

		} catch(Exception $e) {

			if(strcmp($e->getMessage(), 'An invalid security token was provided') == 0)
				return array('status'=>0,'errors'=>'An invalid security token was provided.');
			else	
				return array('status'=>0,'errors'=>$e->getMessage());		 
				 
                      
		}
	
		try {
			//'entry_mode'   => 'Keyed',
			$response = $obj_transaction->verify(array(
					'amount'       => $amount,
					'currency_code' => $currencyCode,
					'avsdata'      => $avsData,
					'carddata'     => $cardData,
					'entry_mode'   => 'KeyedBadMagRead',
					'IndustryType' => $this->IndustryType,
					'Reference'    => $ReferenceNo
					//'EmployeeId'   => '11'
			));		 
			
			//echo '<pre>';print_r($response);die;
	
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	
		try {
	
			if (is_array($response) && isset($response['Status']) && $response['Status'] == 'Successful') { //echo "hello";die;

				$res_authandcap = $obj_transaction->authorizeAndCapture(array(
						'amount'       => $amount,
						'currency_code' => $currencyCode,
						'avsdata'      => $avsData,
						'token'        => $response['PaymentAccountDataToken'],
						'order_id'     => $OrderID,
						'entry_mode'   => 'Keyed',
						'IndustryType' => $this->IndustryType,
						'Reference'    => $ReferenceNo
						//'EmployeeId'   => '11'
				));
               
		//echo '<pre>';print_r($res_authandcap);die;
				/******************To get return message ****************/
				 if (is_array($res_authandcap) && isset($res_authandcap['StatusCode']) && $res_authandcap['StatusCode'] == '000' ) { //echo "hello";die;
					return $res_authandcap;
					/*try {
						$xml = VelocityXmlCreator::authorizeandcaptureXML( array(
								'amount'       => $amount,
								'token'        => $response['PaymentAccountDataToken'],
								'avsdata'      => $avsData,
								'order_id'     => $OrderID,
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


			/*if($_GET['pk']==1){
				print_r($response);
				echo '<br>'.$this->workflowid;
				die;
			}*/


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
        
        

	function processPayment555($order_id) {
		
		$address  = $_POST['address1'] . ' ' . $_POST['address2'];
		$city     = $_POST['city'];
		$state    = $_POST['state'];
		$postcode = $_POST['zip'];
		//$country  = $_POST['billing_country'];
		//$phone    = $_POST['billing_phone'];
		$total    = $_POST['amount']; // @In float no.
	
		$avsData  = array('Street' => $address, 'City' => $city, 'PostalCode' => $postcode);
		
		//@ expire in 4 digit 
		$cardData = array('cardowner' => 'Jane Doe', 'cardtype' => 'Visa', 'pan' => '4012888812348882', 'expire' => '1218', 'cvv' => '123');
		//$cardData = array('cardowner' => $_POST['card_owner'], 'cardtype' => $_POST['creditCardType'], 'pan' => $_POST['cardnumber'], 'expire' => $_POST['exp_month'].$_POST['exp_year'], 'cvv' => $_POST['cvvnumber'], 'track1data' => '', 'tarck2data' => '');
	
		try {
			$obj_transaction = new VelocityProcessor( $this->applicationprofileid, $this->merchantprofileid, $this->workflowid, $this->isTestAccount, $this->identitytoken, null);
		} catch(Exception $e) {
			if(strcmp($e->getMessage(), 'An invalid security token was provided') == 0)
				throw new Exception('Your order cannot be completed at this time. Please contact customer care. Error Code 8124');
				else
					throw new Exception($e->getMessage());
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
			
			//print_r($response);die;
	
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	
		try {
	
			if (is_array($response) && isset($response['Status']) && $response['Status'] == 'Successful') {
	
				$res_authandcap = $obj_transaction->authorizeAndCapture( array(
						'amount'       => $total,
						'avsdata'      => $avsData,
						'token'        => $response['PaymentAccountDataToken'],
						'order_id'     => $order_id,
						'entry_mode'   => 'Keyed',
						'IndustryType' => $this->IndustryType,
						'Reference'    => 'Ezneterp',
						'EmployeeId'   => '11'
				)
						);
				/******************To get return message ****************/
				/* if (is_array($res_authandcap) && isset($res_authandcap['StatusCode']) && $res_authandcap['StatusCode'] == '000' ) {
	
					try {
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
					}
				} */
				/***************************************/
			} else if (is_array($response) &&(isset($response['Status']) && $response['Status'] != 'Successful')) {
                        throw new Exception($response['StatusMessage']);
                } else if (is_string($response)) {
                        if (strcmp(trim($response) , 'ApplicationProfileId is not valid.<br>') == 0)
                            throw new Exception('Your order cannot be completed at this time. Please contact customer care. Error Code 1010');
                        else if (strip_tags(strstr($response , $this->workflowid)) == $this->workflowid)
                            throw new Exception('Your order cannot be completed at this time. Please contact customer care. Error Code 9621');   
                        else if (strlen($response) == 702) 
                            throw new Exception('Your order cannot be completed at this time. Please contact customer care. Error Code 2408');                                        
                        else
                            throw new Exception($response);
                } else {
                        throw new Exception('Unknown Error in verification process please contact the site admin');
                }
                
                
            } catch (Exception $ex) {
                    throw new Exception($ex->getMessage());
            }	

        }
        
        
        
        function refundPayment($refund_ammount, $transaction_id) {
        
        	try {
        		$obj_transaction = new VelocityProcessor($this->applicationprofileid, $this->merchantprofileid, $this->workflowid, $this->isTestAccount, $this->identitytoken, null);
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
        		/******************To get return message ****************/
        		/* try {
        			$xml = VelocityXmlCreator::returnByIdXML(number_format($refund_ammount, 2, '.', ''), $transaction_id);  // got ReturnById xml object.
        
        			$req = $xml->saveXML();
        			$obj_req = serialize($req);
        
        		} catch (Exception $e) {
        			throw new Exception($e->getMessage());
        		} */
        		/*************************************/
        
        		if (is_array($res_returnbyid) && isset($res_returnbyid['StatusCode']) && $res_returnbyid['StatusCode'] == '000') { 
        
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
			return array('status'=>0,'errors'=>$e->getMessage());         		
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
        		//print_r($ex->getMessage());
			return array('status'=>0,'errors'=>$ex->getMessage()); 
        	}
        
        }
}			
?>
