<?php
/**
 * Mubashir Ali
 * saad_ali6@yahoo.com
 */
    class fedexPickup extends fedexAPI
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function pickupRequest($aryPickup)
        {   
            $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();;
            $request['ClientDetail'] = $this->getClientDetail();
            $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Create Pickup Request v2 using PHP ***');
            $request['Version'] = $this->getServiceVersion();
            $request['OriginDetail'] = array('PickupLocation' => $this->addShipper(),
                                                           'PackageLocation' => strtoupper($aryPickup['PackageLocation']), // valid values NONE, FRONT, REAR and SIDE
                                                           'BuildingPartCode' => $aryPickup['BuildingPartCode'], 
                                                           'BuildingPartDescription' => $aryPickup['BuildingPartDescription'],
                                                           'ReadyTimestamp' => mktime(8, 0, 0, date("m", strtotime($aryPickup['ReadyTimestamp'])) , date("d", strtotime($aryPickup['ReadyTimestamp'])), date("Y", strtotime($aryPickup['ReadyTimestamp']))),
                                                           'CompanyCloseTime' => $aryPickup['CompanyCloseTime']);
            
            $request['PackageCount'] = $aryPickup['PackageCount'];
            $request['TotalWeight'] = array('Value' => $aryPickup['TotalWeight'], 'Units' => 'LB');
            $request['CarrierCode'] = $aryPickup['CarrierCode'];
            //$request['OversizePackageCount'] = '1';
            $request['CourierRemarks'] = $aryPickup['CourierRemarks'];
            /*if(in_array($aryPickup['CarrierCode'], array('FDXC')) )
            {
                $request['Carriers'] = 'FDXE';
            }*/

            return $request;

        }/*end of pickupRequest()*/
        
        public function cancelPickupRequest($aryPickup)
        {
            $request = $aryPickup;
            $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();;
            $request['ClientDetail'] = $this->getClientDetail();
            $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Cancel Pickup Request v2 using PHP ***');
            $request['Version'] = $this->getServiceVersion();

            return $request;
        }
        
        public function pickupAvailabilityRequest($aryPickup)
        {
            $request = $aryPickup;
            $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();;
            $request['ClientDetail'] = $this->getClientDetail();
            $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Pickup Availability Request v2 using PHP ***');
            $request['Version'] = $this->getServiceVersion();

            return $request;
        }
    }
?>