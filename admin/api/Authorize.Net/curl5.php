<?


///////////////////////////////////////
//////////////////////////////////////

function xml2array($contents, $get_attributes=1) { 
    if(!$contents) return array(); 

    if(!function_exists('xml_parser_create')) { 
        //print "'xml_parser_create()' function not found!"; 
        return array(); 
    } 
    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create(); 
    xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 ); 
    xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 ); 
    xml_parse_into_struct( $parser, $contents, $xml_values ); 
    xml_parser_free( $parser ); 

    if(!$xml_values) return;//Hmm... 

    //Initializations 
    $xml_array = array(); 
    $parents = array(); 
    $opened_tags = array(); 
    $arr = array(); 

    $current = &$xml_array; 

    //Go through the tags. 
    foreach($xml_values as $data) { 
        unset($attributes,$value);//Remove existing values, or there will be trouble 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = ''; 
        if($get_attributes) {//The second argument of the function decides this. 
            $result = array(); 
            if(isset($value)) $result['value'] = $value; 

            //Set the attributes too. 
            if(isset($attributes)) { 
                foreach($attributes as $attr => $val) { 
                    if($get_attributes == 1) $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
                    /**  :TODO: should we change the key name to '_attr'? Someone may use the tagname 'attr'. Same goes for 'value' too */ 
                } 
            } 
        } elseif(isset($value)) { 
            $result = $value; 
        } 

        //See tag status and do the needed. 
        if($type == "open") {//The starting of the tag '<tag>' 
            $parent[$level-1] = &$current; 

            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
                $current[$tag] = $result; 
                $current = &$current[$tag]; 

            } else { //There was another element with the same tag name 
                if(isset($current[$tag][0])) { 
                    array_push($current[$tag], $result); 
                } else { 
                    $current[$tag] = array($current[$tag],$result); 
                } 
                $last = count($current[$tag]) - 1; 
                $current = &$current[$tag][$last]; 
            } 

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
            //See if the key is already taken. 
            if(!isset($current[$tag])) { //New Key 
                $current[$tag] = $result; 

            } else { //If taken, put all things inside a list(array) 
                if((is_array($current[$tag]) and $get_attributes == 0)//If it is already an array... 
                        or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1)) { 
                    array_push($current[$tag],$result); // ...push the new element into that array. 
                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value 
                } 
            } 

        } elseif($type == 'close') { //End of tag '</tag>' 
            $current = &$parent[$level-1]; 
        } 
    } 

    return($xml_array); 
} 

///////////////////////////////////////
//////////////////////////////////////	

//https://github.com/stymiee/Authorize.Net-XML/blob/master/examples/reporting/getTransactionDetailsRequest.php


$IS_ONLINE = FALSE;

if($IS_ONLINE == FALSE){
	$URL	= "https://apitest.authorize.net/xml/v1/request.api";
}else{
	$URL	= "https://api.authorize.net/xml/v1/request.api";
}
//2238968786

//REFUND TRANSACTION

$xml = '<?xml version="1.0"?>
<createTransactionRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
  <merchantAuthentication>
    <name>5KP3u95bQpv</name>
    <transactionKey>4Ktq966gC55GAX7S</transactionKey>
  </merchantAuthentication>
  <refId>'.rand(999,99999999).'</refId>
  <transactionRequest>
    <transactionType>refundTransaction</transactionType>
    <amount>50</amount>
    <currencyCode>USD</currencyCode>
    <payment>
      <creditCard>
        <cardNumber>4647979551208107</cardNumber>
        <expirationDate>122019</expirationDate>
      </creditCard>
    </payment>
    <authCode>7Z0G0O</authCode>
  </transactionRequest>
</createTransactionRequest>';


    //setting the curl parameters.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$URL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 0); 	
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        if (curl_errno($ch)) 
    {  
        // moving to display page to display curl errors
          echo curl_errno($ch) ;
          echo curl_error($ch);
    } 
    else 
    { 
        //getting response from server
        $response = curl_exec($ch);

	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	$info = curl_getinfo($ch);
	$err = curl_error($ch);  
	echo '<pre>';
	//print_r($info);
	//print_r($err);
 
         curl_close($ch);

$AraryResponse = xml2array($response);
	//echo $AraryResponse->$transactionResponse;
	$MSG = $AraryResponse['createTransactionResponse']['transactionResponse']['errors']['error']['errorText']['value'];
	echo $TransactionID = $AraryResponse['createTransactionResponse']['transactionResponse']['transId']['value'];	
	echo '<pre>';print_r($AraryResponse);

    }

?>
