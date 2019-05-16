<?php

/**
 * Mubashir Ali
 * saad_ali6@yahoo.com
 */
class fedexAPI
{
    protected $ship_account;
    protected $bill_account;
    protected $duty_account;
    protected $account_to_validate;
    protected $track_account;
    protected $account;
    
    protected $ServiceId;
    protected $Major;

    protected $meter;
    protected $key;
    protected $password;

    public $wsdl_root_path;
    public $wsdl_path;

    public function __construct($mode = "live")
    {
	global $Config;
	 
        if($Config['live'] == "1"){
		$this->ship_account       = $Config['Fedex_account_number'];
		$this->bill_account       = $Config['Fedex_account_number'];
		$this->duty_account       = $Config['Fedex_account_number'];
		$this->account_to_validate= $Config['Fedex_account_number'];
		$this->track_account      = $Config['Fedex_account_number'];
		$this->account            = $Config['Fedex_account_number'];

		$this->meter    = $Config['Fedex_meter_number']; 
		$this->key      = $Config['Fedex_key'];  
		$this->password = $Config['Fedex_password'];  

		$this->setWSDLRoot("wsdl-live/");		
        }else{
		$this->ship_account       = "510087704";
		$this->bill_account       = "510087704";
		$this->duty_account       = "510087704";
		$this->account_to_validate= "510087704";
		$this->track_account      = "510087704";
		$this->account            = "510087704";

		$this->meter    = "118684910";
		$this->key      = "8VQJwy95VCiZlSVa";
		$this->password = "fSkpYyHpuhOHv2hhcNppHqzFm";

		$this->setWSDLRoot("wsdl-test/");
        }
    }
    
    public function setWSDLRoot($root = "wsdl/")
    {
        $this->wsdl_root_path = $root;
    }
    
    public function requestError($exception, $client) 
    {
        $str = "";
        $str .= '<h2>Fault: </h2>';
        $str .= "<b>Code:</b>{$exception->faultcode}<br>\n";
        $str .= "<b>String:</b>{$exception->faultstring}<br>\n";
        return $str;
    }
    
    public function getAuthenticationDetail()
    {
        $aryAuthentication = array(
                'UserCredential' =>array(
                        'Key' => $this->key, 
                        'Password' => $this->password
                )
        ); 
        return $aryAuthentication;
    }
    
    public function getClientDetail()
    {
        $aryClient = array(
                'AccountNumber' => $this->ship_account, 
                'MeterNumber' => $this->meter
        );
        
        return $aryClient;
    }
    
    public function getServiceVersion()
    {
        $aryVersion = array(
                'ServiceId' => $this->ServiceId, 
                'Major' => $this->Major, 
                'Intermediate' => '0', 
                'Minor' => '0'
        );
        return $aryVersion;
    }
    
    function addShippingChargesPayment555()
    {
        $shippingChargesPayment = array
        (
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array
                (
                    'AccountNumber' => $this->bill_account,
                    'CountryCode' => 'US')
        );

        return $shippingChargesPayment;
    }
    

 function addShippingChargesPayment()
    {
    	
    	 $AccountType = $_POST['AccountType'];
    	 $AccountNumber = $_POST['AccountNumber'];
    	 
    	 if($AccountType==1){
    		$PaymentType = 'RECIPIENT';
    		$CountryCode = $_POST['CountryCgTo'];
    		
    	}else if($AccountType==2){
    		$PaymentType = 'SENDER';
    		$CountryCode = $_POST['CountryCgFrom'];
    	}else{
    		$PaymentType = 'THIRD_PARTY';
    		$CountryCode = 'US';
    	} 

	if($AccountType==1){
		$PaymentType = 'RECIPIENT';
		$CountryCode = $_POST['CountryCgTo'];
	
	}else if($AccountType==2){
		$PaymentType = 'SENDER';
		$CountryCode = $_POST['CountryCgFrom'];
	}else if($AccountType==4){
		$PaymentType = 'COLLECT';
		$CountryCode = 'US';
		}else{
		$PaymentType = 'THIRD_PARTY';
		$CountryCode = 'US';
	} 

    	
        $shippingChargesPayment = array
        (
            'PaymentType' => $PaymentType, // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array
                (
                 
                    'AccountNumber' => $AccountNumber,
                    'CountryCode' => $CountryCode)
        );

        return $shippingChargesPayment;
    }

   function addSpecialServices() 
    {
        $specialServices = array(
            'SpecialServiceTypes' => array('COD'),
            'CodDetail' => array(
                'CodCollectionAmount' => array(
			'Currency' => $_POST['Currency'],
			 'Amount' => $_POST['CODAmount']
		),
                'CollectionType' => $_POST['CollectionType'])// ANY, GUARANTEED_FUNDS
        );
	 
        return $specialServices;
    }
    
    public function requestType($type)
    {
        switch($type)
        {
            case "address":
                $this->wsdl_path = "AddressValidationService_v2.wsdl";
                $this->Major = 10;
                break;
            case "package":
                $this->wsdl_path = "PackageMovementInformationService_v5.wsdl";
                $this->Major = 10;
                break;
            case "close":
                $this->wsdl_path = "CloseService_v2.wsdl";
                $this->Major = 10;
                break;
            case "locator":
                $this->wsdl_path = "LocatorService_v2.wsdl";
                $this->Major = 10;
                break;
            case "pickup":
                $this->wsdl_path = "PickupService_v3.wsdl";
                $this->ServiceId = "disp";
                $this->Major = 3;
                break;
            case "rate":
                $this->wsdl_path = "RateService_v10.wsdl";
                $this->ServiceId = "crs";
                $this->Major = 10;
                break;
            case "return":
                $this->wsdl_path = "ReturnTagService_v1.wsdl";
                $this->Major = 10;
                break;
            case "shipment":
                $this->wsdl_path = "ShipService_v10.wsdl";
                $this->ServiceId = "ship";
                $this->Major = 10;
                break;
            case "track":
                $this->wsdl_path = "TrackService_v5.wsdl";
                $this->ServiceId = "trck";
                $this->Major = 5;
                break;
            case "upload":
                $this->wsdl_path = "UploadDocumentService_v1.wsdl";
                $this->Major = 10;
                break;
            default:
                $this->wsdl_path = "";
                $this->Major = 10;
                break;
        }
    }
    
    function setEndpoint($var)
    {
        if($var == 'changeEndpoint') 
            return false;

        if($var == 'endpoint') 
            return '';
    }
    
        
    public function addShipper()
    {
        $shipper = array
        (
              'Contact' => array(
                'PersonName' => $_POST['Contactname'],
                'CompanyName' => $_POST['CompanyFrom'],
                'PhoneNumber' => $_POST['PhonenoFrom']),
            'Address' => array(
                'StreetLines' => array($_POST['Address1From'],$_POST['Address2From']),
                'City' => $_POST['CityFrom'],
                'StateOrProvinceCode' => $_POST['StateFrom'],
                'PostalCode' => $_POST['ZipFrom'],
                'CountryCode' => $_POST['CountryCgFrom'])
           );

        return $shipper;
    }



 public function addShipperBack()
    {
        $shipper = array
        (
              'Contact' => array(
                'PersonName' => 'Mahir Abidi',
                'CompanyName' => 'MKBtechnology',
                'PhoneNumber' => '8668887812'),
            'Address' => array(
                'StreetLines' => array('Address Line 1'),
                'City' => 'LAKE MARY',
                'StateOrProvinceCode' => 'FL',

                'PostalCode' => '32746',
                'CountryCode' => 'US')
           );

        return $shipper;
    }
    
    public function showResponseMessage($response)
    {

        if(isset($response->Notifications->Message))
            return $response->Notifications->Message;
        else
            return $response->Notifications[0]->Message;
    }
    
    public function getServiceTypeName($service_type)
    {
        $s_type = "";
        if(trim($service_type) == "")
            return false;
        switch($service_type)
        {
            case "INTERNATIONAL_ECONOMY":
                $s_type = "International Economy";
                break;
            case "INTERNATIONAL_PRIORITY":
                $s_type = "International Priority";
                break;
            case "EUROPE_FIRST_INTERNATIONAL_PRIORITY":
                $s_type = "International Priority (Europe First)";
                break;
            case "INTERNATIONAL_FIRST":
                $s_type = "International First";
                break;
            default:
                $s_type = "";
        }
        return $s_type;
    }
    
}
?>
