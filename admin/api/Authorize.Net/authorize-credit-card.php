<?php
//https://support.authorize.net/authkb/index?page=content&id=A510
/*

http://technet.massivetechnolab.co.in/authorize-net-payment-gateway-integration-using-php
[3:30:34 PM] rajeev kush: http://upshots.org/php/transacting-with-authorize-net-via-php-and-curl



// Set all fields
            $this->response_code        = $this->_response_array[0];
            $this->response_subcode     = $this->_response_array[1];
            $this->response_reason_code = $this->_response_array[2];
            $this->response_reason_text = $this->_response_array[3];
            $this->authorization_code   = $this->_response_array[4];
            $this->avs_response         = $this->_response_array[5];
            $this->transaction_id       = $this->_response_array[6];
            $this->invoice_number       = $this->_response_array[7];
            $this->description          = $this->_response_array[8];
            $this->amount               = $this->_response_array[9];
            $this->method               = $this->_response_array[10];
            $this->transaction_type     = $this->_response_array[11];
            $this->customer_id          = $this->_response_array[12];
            $this->first_name           = $this->_response_array[13];
            $this->last_name            = $this->_response_array[14];
            $this->company              = $this->_response_array[15];
            $this->address              = $this->_response_array[16];
            $this->city                 = $this->_response_array[17];
            $this->state                = $this->_response_array[18];
            $this->zip_code             = $this->_response_array[19];
            $this->country              = $this->_response_array[20];
            $this->phone                = $this->_response_array[21];
            $this->fax                  = $this->_response_array[22];
            $this->email_address        = $this->_response_array[23];
            $this->ship_to_first_name   = $this->_response_array[24];
            $this->ship_to_last_name    = $this->_response_array[25];
            $this->ship_to_company      = $this->_response_array[26];
            $this->ship_to_address      = $this->_response_array[27];
            $this->ship_to_city         = $this->_response_array[28];
            $this->ship_to_state        = $this->_response_array[29];
            $this->ship_to_zip_code     = $this->_response_array[30];
            $this->ship_to_country      = $this->_response_array[31];
            $this->tax                  = $this->_response_array[32];
            $this->duty                 = $this->_response_array[33];
            $this->freight              = $this->_response_array[34];
            $this->tax_exempt           = $this->_response_array[35];
            $this->purchase_order_number= $this->_response_array[36];
            $this->md5_hash             = $this->_response_array[37];
            $this->card_code_response   = $this->_response_array[38];
            $this->cavv_response        = $this->_response_array[39];
            $this->account_number       = $this->_response_array[50];
            $this->card_type            = $this->_response_array[51];
            $this->split_tender_id      = $this->_response_array[52];
            $this->requested_amount     = $this->_response_array[53];
            $this->balance_on_card      = $this->_response_array[54];


*/


  require 'vendor/autoload.php';

  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;

  define("AUTHORIZENET_LOG_FILE", "phplog");

  // Common setup for API credentials
  $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
  $merchantAuthentication->setName("5KP3u95bQpv");
  $merchantAuthentication->setTransactionKey("4Ktq966gC55GAX7S");
  $refId = 'ref' . time();

  // Create the payment data for a credit card
  $creditCard = new AnetAPI\CreditCardType();
  $creditCard->setCardNumber( "4111111111111111" );
  $creditCard->setExpirationDate( "2038-12");
  $paymentOne = new AnetAPI\PaymentType();
  $paymentOne->setCreditCard($creditCard);

  //create a transaction
  $transactionRequestType = new AnetAPI\TransactionRequestType();
  $transactionRequestType->setTransactionType( "authOnlyTransaction"); 
  $transactionRequestType->setAmount(151);
  $transactionRequestType->setPayment($paymentOne);

  $request = new AnetAPI\CreateTransactionRequest();
  $request->setMerchantAuthentication($merchantAuthentication);
  $request->setRefId( $refId);
  $request->setTransactionRequest( $transactionRequestType);

  $controller = new AnetController\CreateTransactionController($request);
  $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

  if ($response != null)
  {
    $tresponse = $response->getTransactionResponse();
echo '<pre>';print_r($tresponse->geterrors()[0]->geterrorText());
print_r($tresponse);
    if (($tresponse != null) && ($tresponse->getResponseCode()=="1") )   
    {
      echo " AUTH CODE : " . $tresponse->getAuthCode() . "\n";
      echo " TRANS ID  : " . $tresponse->getTransId() . "\n";
    }
    else
    {
        echo  "ERROR : " . $tresponse->getResponseCode() . "\n";
    }
    
  }
  else
  {
    echo  "No response returned";
  }

?>
