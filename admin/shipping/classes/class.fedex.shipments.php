<?php
/**
 * Mubashir Ali
 * saad_ali6@yahoo.com
 */

class fedexShipment extends fedexAPI {

    public $ship_label;

    public function __construct() 
    {
        parent::__construct();
    }

    public function requestShipment($aryRecipient, $aryOrder, $aryPackage, $aryCustomClearance, $is_first_package = array()) 
    {
        $request['WebAuthenticationDetail'] = $this->getAuthenticationDetail();
        $request['ClientDetail'] = $this->getClientDetail();

        $request['TransactionDetail'] = array('CustomerTransactionId' => '*** Express International Shipping Request v10 using PHP ***');
        $request['Version'] = $this->getServiceVersion();

	if($_POST['COD']=='1' && $_POST['CODAmount']>0){
		$request['RequestedShipment'] = array
		(
		    'ShipTimestamp' => date('c'),
		    'DropoffType' => $aryOrder['DropoffType'],
		    'ServiceType' => $aryOrder['ServiceType'],
		    'PackagingType' => $aryOrder['PackageType'],
		    'Shipper' => $this->addShipper(),
		    'Recipient' => $aryRecipient,
		    'ShippingChargesPayment' => $this->addShippingChargesPayment(),
		    'CustomsClearanceDetail' => $aryCustomClearance,
		    'LabelSpecification' => $this->addLabelSpecification(),
		    'SpecialServicesRequested' => $this->addSpecialServices(),
		    'CustomerSpecifiedDetail' => array(
		        'MaskedData' => 'SHIPPER_ACCOUNT_NUMBER'
		    ),
		    'RateRequestTypes' => array('ACCOUNT'), // valid values ACCOUNT and LIST
		    //'MasterTrackingID' => $is_first_package['master_tracking_id'],   //MasterTrackingID will return (794798508392)           [For All Other Secondary Packages]
		    'PackageCount' => $aryOrder['TotalPackages'],
		    'RequestedPackageLineItems' => $aryPackage,
			    'CustomerReferences' => array(
					'0' => array(
					'CustomerReferenceType' => 'CUSTOMER_REFERENCE',   // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
					'Value' => $_POST['CUSTOMERREFERENCE']
					),
					'1' => array(
					'CustomerReferenceType' => 'INVOICE_NUMBER', 
					'Value' => $_POST['INVOICENO']
					),
					'2' => array(
					'CustomerReferenceType' => 'P_O_NUMBER', 
					'Value' => $_POST['PONUMBER']
					)
				)


		);

	}else{

			$request['RequestedShipment'] = array
			(
			    'ShipTimestamp' => date('c'),
			    'DropoffType' => $aryOrder['DropoffType'],
			    'ServiceType' => $aryOrder['ServiceType'],
			    'PackagingType' => $aryOrder['PackageType'],
			    'Shipper' => $this->addShipper(),
			    'Recipient' => $aryRecipient,
			    'ShippingChargesPayment' => $this->addShippingChargesPayment(),
			    'CustomsClearanceDetail' => $aryCustomClearance,
			    'LabelSpecification' => $this->addLabelSpecification(),
			  //  'SpecialServicesRequested' => $this->addSpecialServices(),
			    'CustomerSpecifiedDetail' => array(
				'MaskedData' => 'SHIPPER_ACCOUNT_NUMBER'
			    ),
			    'RateRequestTypes' => array('ACCOUNT'), // valid values ACCOUNT and LIST
			    //'MasterTrackingID' => $is_first_package['master_tracking_id'],   //MasterTrackingID will return (794798508392)           [For All Other Secondary Packages]
			    'PackageCount' => $aryOrder['TotalPackages'],
			    'RequestedPackageLineItems' => $aryPackage,
		   	    'CustomerReferences' => array(
				'0' => array(
				'CustomerReferenceType' => 'CUSTOMER_REFERENCE',   // valid values CUSTOMER_REFERENCE, INVOICE_NUMBER, P_O_NUMBER and SHIPMENT_INTEGRITY
				'Value' => $_POST['CUSTOMERREFERENCE']
				),
				'1' => array(
				'CustomerReferenceType' => 'INVOICE_NUMBER', 
				'Value' => $_POST['INVOICENO']
				),
				'2' => array(
				'CustomerReferenceType' => 'P_O_NUMBER', 
				'Value' => $_POST['PONUMBER']
				)
			)

			);

	}


        




        $request['International']['TermsOfSaleType'] = $aryOrder['TermsOfSaleType'];
        
        //echo $is_first_package;
       
        if(count($is_first_package)>0)
        {
            $request['MasterTrackingID'] = $is_first_package['master_tracking_id'];
            //echo $request['MasterTrackingID'];exit;
            $request['FormId'] = $is_first_package['form_id'];
        }

        //echo "<pre>";print_r($request);echo"</pre>";exit;
        
        
        return $request;
    }

    public function addLabelSpecification() 
    {
        $labelSpecification = array(
            'LabelFormatType' => 'COMMON2D', // valid values COMMON2D, LABEL_DATA_ONLY
            'ImageType' => 'PDF', // valid values DPL, EPL2, PDF, ZPLII and PNG
            'LabelStockType' => 'PAPER_7X4.75');
        return $labelSpecification;
    }

    public function addCustomClearanceDetail($aryPackageItems, $package_amount) 
    {
        $aryCommodities = array();
        
        $nLoop = count($aryPackageItems);
        for($cnt=0;$cnt<$nLoop;$cnt++)
        {
            $aryCommodities[$cnt]['NumberOfPieces'] = $aryPackageItems[$cnt]['item_qty'];
            $aryCommodities[$cnt]['Description'] = $aryPackageItems[$cnt]['item_name'];
            $aryCommodities[$cnt]['CountryOfManufacture'] = 'US';
            $aryCommodities[$cnt]['Weight'] = array('Units'=>'LB','Value'=>$aryPackageItems[$cnt]['item_weight']);
            $aryCommodities[$cnt]['Quantity'] = $aryPackageItems[$cnt]['item_qty'];
            $aryCommodities[$cnt]['QuantityUnits'] = 'EA';
            $aryCommodities[$cnt]['UnitPrice'] = array('Currency'=>$_POST['Currency'], 'Amount'=>$aryPackageItems[$cnt]['item_price']);
            $aryCommodities[$cnt]['CustomsValue'] = array('Currency'=>$_POST['Currency'], 'Amount'=>$aryPackageItems[$cnt]['item_price']);
        }
    
/***************International******************/
if(!empty($_POST['BillDutiesTaxOpt'])){
 $cusAccountType = $_POST['BillDutiesTaxOpt'];
 $AccountNumber = $_POST['BillDutiesTaxAccount'];
}else{

         if($_POST['AccountType']==1){
        	 $cusAccountType='RECIPIENT';
        }elseif ($_POST['AccountType']==2){
        	 $cusAccountType='SENDER';
        }elseif ($_POST['AccountType']==3){
        	 $cusAccountType='THIRD_PARTY';
        }elseif ($_POST['AccountType']==4){
        	 $cusAccountType='COLLECT';
        }else{
        	 $cusAccountType='';
        }
      $AccountNumber = $_POST['AccountNumber'];

}

/*********************************/

	//if(empty($_POST['BillDutiesTax'])) $_POST['BillDutiesTax'] = $_POST['AccountNumber'];

        $customerClearanceDetail = array(
            'DutiesPayment' => array(
                 'PaymentType' => $cusAccountType, // valid values RECIPIENT, SENDER and THIRD_PARTY
                 'Payor' => array(
                    'AccountNumber' => $AccountNumber,
                    'CountryCode' => 'CA'
                )
            ),
            'DocumentContent' => 'NON_DOCUMENTS',
            'CustomsValue' => array(
                'Currency' => $_POST['CustomValueCurrency'],
                'Amount' => $_POST['CustomValue']
            ),
            'Commodities' => $aryCommodities,
            /*'CommercialInvoice' => array(
                'Comments'=>'Test Commercial Invoice',
                'FreightCharge'=>'100.00',
                'SpecialInstructions'=>'Test Spercial Instructions',
                'DeclarationStatement'=>'Test Desclaration Statement'
            ),*/
            'ExportDetail' => array(
                'B13AFilingOption' => 'NOT_REQUIRED',
  		'ExportComplianceStatement' => $_POST['AES_NUMBER'] //XYYYYMMDDNNNNNN20170329

            )
        );
        return $customerClearanceDetail;
    }

}

?>
