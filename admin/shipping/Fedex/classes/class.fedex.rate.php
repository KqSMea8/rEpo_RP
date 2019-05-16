<?php
/**
 * Mubashir Ali
 * saad_ali6@yahoo.com
 */
    class fedexRates extends fedexAPI
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function rateRequest($aryRecipient, $aryOrder, $aryPackage)
        {            
            $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();            
            $request['ClientDetail'] = $this->getClientDetail();

            $request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Rate Request v10 using PHP ***');
            $request['Version'] = $this->getServiceVersion();
            
            $request['ReturnTransitAndCommit'] = true;

            $request['RequestedShipment']['DropoffType'] = $aryOrder['DropoffType'];
            $request['RequestedShipment']['ShipTimestamp'] = date('c');
            $request['RequestedShipment']['ServiceType'] = $aryOrder['ServiceType'];
            $request['RequestedShipment']['PackagingType'] = $aryOrder['PackageType'];
            
            $request['International']['TermsOfSaleType'] = $aryOrder['TermsOfSaleType'];
            
            //$request['RequestedShipment']['TotalInsuredValue'] = array('Ammount'=>100,'Currency'=>'USD');//No Need
            
            $request['RequestedShipment']['Shipper'] = $this->addShipper();
            $request['RequestedShipment']['Recipient'] = $aryRecipient;
            //$request['RequestedShipment']['ShippingChargesPayment'] = $this->addShippingChargesPayment(); //No Need
            $request['RequestedShipment']['RateRequestTypes'] = 'ACCOUNT'; 
            $request['RequestedShipment']['RateRequestTypes'] = 'LIST'; 
            $request['RequestedShipment']['PackageCount'] = $aryOrder['TotalPackages'];
            $request['RequestedShipment']['RequestedPackageLineItems'] = $aryPackage;

            return $request;

        }/*end of rateRequest()*/
    }
?>