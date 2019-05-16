<?php 

/****************Header*********************************************/

function create_ISA($X12info)
{

	$segTer = ":~";
	$compEleSep = "*";
	
    $ISA     =  array();

    $ISA[0] = "ISA";                            // Interchange Control Header Segment ID

    $ISA[1] = "00";                                 // Author Info Qualifier

    $ISA[2] = str_pad("0000000", 10, " ");        // Author Information

    $ISA[3] = "00";                                 //   Security Information Qualifier
  
    $ISA[4] = str_pad("0000000000", 10, " ");         // Security Information

    $ISA[5] = str_pad("ZZ", 2, " ");              // Interchange ID Qualifier

    $ISA[6] = str_pad($X12info['SenderId'], 15, " ");      // INTERCHANGE SENDER ID

    $ISA[7] = str_pad("ZZ", 2, " ");              // Interchange ID Qualifier

    $ISA[8] = str_pad($X12info['RecevierId'], 15, " ");      // INTERCHANGE RECEIVER ID

    $ISA[9] = str_pad(date('ymd'), 6, " ");       // Interchange Date (YYMMDD)

    $ISA[10] = str_pad(date('Hi'), 4, " ");       // Interchange Time (HHMM)

    $ISA[11] = "^";                                 // Interchange Control Standards Identifier

    $ISA[12] = str_pad("00501", 5, " ");          // Interchange Control Version Number

    $ISA[13] = str_pad("000000001", 9, " ");      // INTERCHANGE CONTROL NUMBER

    $ISA[14] = str_pad("1", 1, " ");              // Acknowledgment Request [0= not requested, 1= requested]

    $ISA[15] =  str_pad("P", 1, " ");                 // Usage Indicator [ P = Production Data, T = Test Data ]

    $ISA['Created'] = implode('*', $ISA);       // Data Element Separator

    $ISA['Created'] = $ISA['Created'] ."*";

    $ISA['Created'] = $ISA ['Created'] . $compEleSep . $segTer;

    return trim($ISA['Created']);
}

function create_GS($X12info)
{
	$segTer = ":~";
	$compEleSep = "*";
	
    $GS    = array();

    $GS[0] = "GS";                      // Functional Group Header Segment ID

    $GS[1] = "HS";                      // Functional ID Code [ HS = Eligibility, Coverage or Benefit Inquiry (270) ]

    $GS[2] =  $X12info[2];              // Application Sender's ID

    $GS[3] =  $X12info[3];              // Application Receiver's ID

    $GS[4] = date('Ymd');               // Date [CCYYMMDD]

    $GS[5] = date('His');               // Time [HHMM] Group Creation Time

    $GS[6] = "2";                       // Group Control Number No zeros for 5010

    $GS[7] = "X";                   // Responsible Agency Code Accredited Standards Committee X12 ]

    $GS[8] = "005010X279A1";            // Version Release / Industry[ Identifier Code Query 005010X279A1

    $GS['Created'] = implode('*', $GS);         // Data Element Separator

    $GS['Created'] = $GS ['Created'] . $segTer;  // change the information in the tag or change the tag

    return trim($GS['Created']);
}


function create_ST($X12info)
{

	$segTer = ":~";
	$compEleSep = "*";
	
    $ST    =    array();

    $ST[0] = "ST";                              // Transaction Set Header Segment ID

    $ST[1] = "270";                                 // Transaction Set Identifier Code (Inquiry Request)

    $ST[2] = "000000003";                       // Transaction Set Control Number - Must match SE's

    $ST[3] = "005010X279A1";                    // Standard 005010X279A1 in $ST[3]

    $ST['Created'] = implode('*', $ST);             // Data Element Separator

    $ST['Created'] = $ST ['Created'] . $segTer;

    return trim($ST['Created']);
}


//*********************LOOP ID - BA1 Export Shipment Identifying Information***********************/

function create_BA1($X12info)
{

	
	
	//BA1
	$segTer = "~";
	
    $BA1    =   array();

    $BA1[0] = "BA1";                        // Beginning of Hierarchical Transaction Segment ID

    $BA1[1] = $X12info['CompanyIndication'];   //Related Company Indication Code                   

    $BA1[2] = $X12info['ActionCode'];   //Action Code    
                         
    $BA1[3] = $X12info['TransportationMethod']; //Transportation Method/Type Code

    $BA1[4] = $X12info['CountryDestinationCode'];//Country Code
    
    $BA1[5] =$X12info['ShipmentReferenceNo'];//Reference Identification
    
    $BA1[6] = $X12info['ZipCodeOfOrigin'];//Postal Code
    
    $BA1[7] = $X12info['CountryCodeOfOrigin'];//Country Code
    
    $BA1[8] = $X12info['StateCodeOfOrigin'];//$BA1[8] = "ABCD";//State or Province Code
    
    $BA1[9] = $X12info['Authority'];//Authority
    
    $BA1[10] = $X12info['CarrierAlphaCode'];//Standard Carrier Alpha Code
    
    $BA1[11] = $X12info['LocationIdentifier'];//Location Identifier
    
    $BA1[12] = $X12info['ExportingCareer'];//Vessel Name
                                            
    $BA1['Created'] = implode('*', $BA1);           // Data Element Separator

    $BA1['Created'] = $BA1 ['Created'] . $segTer;

    return trim($BA1['Created']);
}



function create_YNQ1($X12info)
{
	
	
	//YNQ Yes/No Question
	$segTer = "~";
	
    $YNQ1    =   array();

    $YNQ1[0] = "YNQ";                        // Beginning of Hierarchical Transaction Segment ID
    
    $YNQ1[1] = $X12info['HAZMAT']; //HAZARDOUS MATERIAL INDICATOR (HAZMAT) RZ QQ RX R3P R3F B
    
    $YNQ1[2] = $X12info['HAZMATResponseCode']; //Yes/No Condition or Response Code

    $YNQ1['Created'] = implode('*', $YNQ1);           // Data Element Separator

    $YNQ1['Created'] = $YNQ1 ['Created'] . $segTer;

    return trim($YNQ1['Created']);
}

function create_DTM($X12info)
{
			
	//DTM Date/Time Reference
	$segTer = "~";
	
    $DTM    =   array();

    $DTM[0] = "DTM";                        // Beginning of Hierarchical Transaction Segment ID
    
    $DTM[1] = $X12info['RequestedDepartureDate']; //Requested Departure Date
    
    $DTM[2] = str_pad(date('ymd'), 6, " "); //Date
    
    $DTM[3] = str_pad(date('Hi'), 4, " ");   //Time

    $DTM['Created'] = implode('*', $DTM);           // Data Element Separator

    $DTM['Created'] = $DTM ['Created'] . $segTer;

    return trim($DTM['Created']);
}

function create_P5($X12info)
{
	
	
	//P5 Port Function
	$segTer = "~";
	
    $P5    =   array();

    $P5[0] = "P5";                        // Beginning of Hierarchical Transaction Segment ID
    
    $P5[1] = $X12info['Portofunlading']; //Port or Terminal Function Code
    
    $P5[2] = $X12info['CensusSchedule']; //Location Qualifier
    
    $P5[3] = $X12info['LocationIdentifier']; //Location Identifier

    $P5['Created'] = implode('*', $P5);           // Data Element Separator

    $P5['Created'] = $P5 ['Created'] . $segTer;

    return trim($P5['Created']);
}


function create_REF($X12info)
{
	
	//REF Reference Information
	$segTer = "~";
	
    $P5    =   array();

    $P5[0] = "REF";                        // Beginning of Hierarchical Transaction Segment ID
    
    $P5[1] = $X12info['ReferenceIdQualifier']; //Reference Identification Qualifier
    
    $P5[2] = $X12info['ReferenceIdQualifier']; //Reference Identification Qualifier
    
    $P5[3] = $X12info['ReferenceIdentifier']; //Reference Identification

    $P5['Created'] = implode('*', $P5);           // Data Element Separator

    $P5['Created'] = $P5 ['Created'] . $segTer;

    return trim($P5['Created']);
}


function create_M12($X12info)
{

	//M12 In-bond Identifying Information
	$segTer = "~";
	
    $P5    =   array();

    $P5[0] = "M12";                        // Beginning of Hierarchical Transaction Segment ID
    
    $P5[1] = $X12info['CBPEntryType'];//Customs and Border Protection (CBP) Entry Type

    $P5[2] = $X12info['CBPEntryNumber']; //Customs and Border Protection (CBP) Entry Number
    
    $P5[3] = $X12info['ROUTEDEXPORTRANSACTION']; //ROUTED EXPORT TRANSACTION INDICATOR
    
    $P5['Created'] = implode('*', $P5);           // Data Element Separator

    $P5['Created'] = $P5 ['Created'] . $segTer;

    return trim($P5['Created']);
}



function create_VID($X12info)
{

	//M12 In-bond Identifying Information
	$segTer = "~";
	
    $P5    =   array();

    $P5[0] = "VID";                        // Beginning of Hierarchical Transaction Segment ID
    
    $P5[1] = $X12info['EquipmentDescriptionCode'];//Equipment Description Code

    $P5[2] = $X12info['EquipmentNumber']; //Equipment Number
    
    $P5[3] = $X12info['SealNumber']; //Seal Number

    $P5['Created'] = implode('*', $P5);           // Data Element Separator

    $P5['Created'] = $P5 ['Created'] . $segTer;

    return trim($P5['Created']);
}


/***************************************/


/*******LOOP ID - N1 SHIP-TO INFORMATION LOOP********/


function create_shiping_N1($X12info)
{

			$segTer = "~";
		
		    $SN1    =   array();
	
		    $SN1[0] = "N1";                        // Beginning of Hierarchical Transaction Segment ID
		    
		    $SN1[1] = $X12info['UltimateConsignee']; //Entity Identifier Code
		
		    $SN1[2] = $X12info['UltimateConsigneeName']; // PARTY NAME and USPPI NAME
		    
		    $SN1[3] = $X12info['EIN'];//Identification Code Qualifier
		    
		    $SN1[4] = $X12info['USPPIID'];//Identification Code identifying a party or other code
 
		    $SN1['Created'] = implode('*', $SN1);           // Data Element Separator
		
		    $SN1['Created'] = $SN1 ['Created'] . $segTer;
		
		    return trim($SN1['Created']);

}


	function create_shiping_N2($X12info)
	{

		if(!empty($X12info['CompanyFrom'])){
			$Contactname = $X12info['CompanyFrom'];
		}else{
			$Contactname = $X12info['FirstnameFrom'].' '.$X12info['LastnameFrom'];
		}
				$segTer = "~";
			
			    $SN2    =   array();
			
			    $SN2[0] = "N2";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $SN2[1] = $Contactname;//Company contact title and/or first name, and last name.
			
			    $SN2[2] = "70812345678"; // CONTACT PHONE NUMBER
	
			    $SN2['Created'] = implode('*', $SN2);           // Data Element Separator
			
			    $SN2['Created'] = $SN2 ['Created'] . $segTer;
			
			    return trim($SN2['Created']);
	
	}
	
	function create_shiping_N3($X12info)
	{
				
				$segTer = "~";
			
			    $SN3    =   array();
			
			    $SN3[0] = "N3";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $SN3[1] = $X12info['Address1From']; //Address Information ADDRESS LINE 1
			    
			    $SN3[2] = $X12info['Address2From']; //Address Information ADDRESS LINE 2
	
			    $SN3['Created'] = implode('*', $SN3);           // Data Element Separator
			
			    $SN3['Created'] = $SN3 ['Created'] . $segTer;
			
			    return trim($SN3['Created']);
	
	}
	
	
	function create_shiping_N4($X12info)
	{

				$segTer = "~";
			
			    $SN4    =   array();
			
			    $SN4[0] = "N4";                        // Beginning of Hierarchical Transaction Segment ID
			    
			    $SN4[1] = $X12info['CityFrom']; //City Name 	
			
			    $SN4[2] = $X12info['StateFrom']; //State or Province Code
			    
			    $SN4[3] = $X12info['ZipFrom']; //Postal Code
			    
			    $SN4[4] = $X12info['CountryFrom']; //Country Code
	
			    $SN4['Created'] = implode('*', $SN4);           // Data Element Separator
			
			    $SN4['Created'] = $SN4 ['Created'] . $segTer;
			
			    return trim($SN4['Created']);
	
	}
		

/********************LOOP ID - N1 BILL-TO INFORMATION LOOP********************/
	
	
	
		function create_billing_N1($X12info)
		{
				
		//Party Identification
	
		$segTer = "~";
	
	    $BN1    =   array();
	
	    $BN1[0] = "N1";                        // Beginning of Hierarchical Transaction Segment ID
	    
	    $BN1[1] = $X12info['UltimateConsignee']; //Entity Identifier Code
	    
	    $BN1[2] = $X12info['UltimateConsigneeName']; // PARTY NAME and USPPI NAME
	    
	    $BN1[3] = $X12info['EIN']; //Identification Code Qualifier
	    
	    $BN1[4] = $X12info['USPPIID']; //Identification Code identifying a party or other code
	    
	    $BN1[5] = $X12info['UltimateConsigneeAddress']; //Entity Relationship Code.
	    
	    $BN1[6] = $X12info['UltimateConsigneeType']; //Entity Identifier Code
	
	    $BN1['Created'] = implode('*', $BN1);           // Data Element Separator
	
	    $BN1['Created'] = $BN1 ['Created'] . $segTer;
	
	    return trim($BN1['Created']);
		
		}
		
		
		
		function create_billing_N2($X12info)
		{

			
		if(!empty($X12info['CompanyTo'])){
			$Contactname = $X12info['CompanyTo'];
		}else{
			$Contactname = $X12info['FirstnameFrom'].' '.$X12info['LastnameFrom'];
		}
		
		//Additional Name Information
		
		$segTer = "~";
	
	    $BN3    =   array();
	
	    $BN3[0] = "N2";                        // Beginning of Hierarchical Transaction Segment ID
	    
	    $BN3[1] = $Contactname; //Company contact title and/or first name, and last name.
	    
	    $SN2[2] = "70812345678"; // CONTACT PHONE NUMBER

	    $BN3['Created'] = implode('*', $BN3);           // Data Element Separator
	
	    $BN3['Created'] = $BN3 ['Created'] . $segTer;
	
	    return trim($BN3['Created']);
		
		}
		
		function create_billing_N4($X12info)
		{
		
		//Geographic Location

		$segTer = "~";
	
	    $BN4    =   array();
	
	    $BN4[0] = "N4";                        // Beginning of Hierarchical Transaction Segment ID
	    
	    $BN4[1] = $X12info['CityTo'];;//City Name 	
	    
	    $BN4[2] = $X12info['StateTo'];//State or Province Code
	    
	    $BN4[3] = $X12info['ZipTo'];//Postal Code
	    
	    $BN4[4] = $X12info['CountryTo'];//Country Code

	    $BN4['Created'] = implode('*', $BN4);           // Data Element Separator
	
	    $BN4['Created'] = $BN4 ['Created'] . $segTer;
	
	    return trim($BN4['Created']);
		
		}
				
/******************************************************************************/

/*******LOOP ID - L13 Commodity Details Line Item********/
		
function create_L13($X12info)
		{
		//L13 Commodity Details	
		$segTer = "~";
	
	    $L13    =   array();
	
	    $L13[0] = "L13";                        // Beginning of Hierarchical Transaction Segment ID
	  
	    $L13[1] = $X12info['HTSCode'];//Commodity Code Qualifier

	    $L13[2] = $X12info['HTSNumber'];//Commodity Code
	    
	    $L13[3] = $X12info['Unit'];//Unit or Basis for Measurement Code
	    
	    $L13[4] = $X12info['Quantity'];//Quantity
	    
	    $L13[5] = $X12info['ShippingAmount'];//Amount Qualifier Code
	    
	    $L13[6] = $X12info['ShippingMonetaryAmount'];//Monetary Amount
	    
	    $L13[7] = $X12info['LINENUMBER'];//Assigned Number
	    
	    $L13[8] = $X12info['WeightUnitCode'];//Unit or Basis for Measurement Code
	    
	    $L13[9] = $X12info['Weight'];//Quantity
	    
	    $L13[10] = $X12info['COMMODITYDESCRIPTION'];//EXPORT INFORMATION CODE COMMODITY DESCRIPTION
	    
	    $L13[11] = $X12info['EXPORTINFORMATIONCODE'];//EXPORT INFORMATION CODE
	    
	    $L13['Created'] = implode('*', $L13);           // Data Element Separator
	
	    $L13['Created'] = $L13 ['Created'] . $segTer;
	
	    return trim($L13['Created']);
		
		}
		
		
			
    function create_MAN($X12info)
		{
		//Marks and Numbers
		$segTer = "~";
	
	    $MAN    =   array();
	
	    $MAN[0] = "MAN";                        // Beginning of Hierarchical Transaction Segment ID
	  
	    $MAN[1] = $X12info['PGA'];//Commodity Code Qualifier
	    
	    $MAN[2] =$X12info['PGAID'];//Commodity Code

	    $MAN['Created'] = implode('*', $MAN);           // Data Element Separator
	
	    $MAN['Created'] = $MAN ['Created'] . $segTer;
	
	    return trim($L13['Created']);
		
		}
		
		
		function create_X1($X12info)
		{
			
		//X1 Export License
				
		$segTer = "~";
	
	    $X1    =   array();
	    
	    $X1[0] = "X1";                        // Beginning of Hierarchical Transaction Segment ID
	    
	    $X1[1] = $X12info['ExportLicenseNumber'];//Code For Licensing, Certification, Registration
	    
	    $X1[2] = $X12info['LICENSECODE'];//Export License Number
	    
	    $X1[3] = $X12info['ORIGININDICATOR'];//International/Domestic Code
	
	    $X1['Created'] = implode('*', $X1);           // Data Element Separator
	
	    $X1['Created'] = $X1 ['Created'] . $segTer;
	
	    return trim($X1['Created']);
		
		}
		
		
		
		function create_VEH($X12info)
		{
		//Marks and Numbers
		$segTer = "~";
	
	    $VEH    =   array();
	  
	    $VEH[0] = "VEH";                        // Beginning of Hierarchical Transaction Segment ID
	  
	    $VEH[1] = $X12info['VIN'];//Vehicle Identification Number
	    
	    $VEH[2] = $X12info['VEHICLEIDQUALIFIER'];// Reference Identification VEHICLE ID QUALIFIER
	    
	    $VEH[3] = $X12info['VEHICLETITLENUMBER'];// Reference Identification

	    $VEH['Created'] = implode('*', $VEH);           // Data Element Separator
	
	    $VEH['Created'] = $VEH ['Created'] . $segTer;
	
	    return trim($L13['Created']);
		
		}
		
/********************************************************/
		
		


/****************footer***********************/
function create_SE($segmentcount,$X12info)
{
	$segTer = ":~";
	$compEleSep = "*";
	
	//SE Transaction Set Trailer
    $SE     =   array();

    $SE[0] = "SE";                              // Transaction Set Trailer Segment ID

    $SE[1] = $segmentcount;                         // Segment Count

    $SE[2] = "000000003";                       // Transaction Set Control Number - Must match ST's

    $SE['Created'] = implode('*', $SE);             // Data Element Separator

    $SE['Created'] = $SE['Created'] . $segTer;

    return trim($SE['Created']);
}

// GE Segment - EDI-270 format

function create_GE($X12info)
{

	$segTer = ":~";
	$compEleSep = "*";
	
	//GE Functional Group Trailer
    $GE     =   array();

    $GE[0]  = "GE";                             // Functional Group Trailer Segment ID

    $GE[1]  = "1";                          // Number of included Transaction Sets

    $GE[2]  = "2";                          // Group Control Number

    $GE['Created'] = implode('*', $GE);                 // Data Element Separator

    $GE['Created'] = $GE['Created'] . $segTer;

    return trim($GE['Created']);
}

// IEA Segment - EDI-270 format

function create_IEA($X12info)
{
	$segTer = ":~";
	$compEleSep = "*";
	
	//IEA Interchange Control Trailer
    $IEA    =   array();

    $IEA[0] = "IEA";                        // Interchange Control Trailer Segment ID

    $IEA[1] = "1";                          // Number of Included Functional Groups

    $IEA[2] = "000000001";                  // Interchange Control Number

    $IEA['Created'] = implode('*', $IEA);

    $IEA['Created'] = $IEA['Created'] .  $segTer;

    return trim($IEA['Created']);
}

/**********************************************************************/


function print_elig($X12info)
{

	//echo "<pre>";print_r($X12info);
  	   $segmentcount = 2;
  // For Header Segment
	     $PATEDI    = create_ISA($X12info). PHP_EOL;
	     $PATEDI   .= create_GS($X12info). PHP_EOL;
	     $PATEDI   .= create_ST($X12info). PHP_EOL;
	     
	     $PATEDI   .= create_BA1($X12info). PHP_EOL;
	     $PATEDI   .= create_YNQ1($X12info). PHP_EOL;
	     $PATEDI   .= create_DTM($X12info). PHP_EOL;
	     $PATEDI   .= create_P5($X12info). PHP_EOL;
	     $PATEDI   .= create_REF($X12info). PHP_EOL;
	     $PATEDI   .= create_M12($X12info). PHP_EOL;
	     $PATEDI   .= create_VID($X12info). PHP_EOL;
	     
   // shipping 
         $PATEDI   .= create_shiping_N1($X12info). PHP_EOL;
         $PATEDI   .= create_shiping_N2($X12info). PHP_EOL;
         $PATEDI   .= create_shiping_N3($X12info). PHP_EOL;
         $PATEDI   .= create_shiping_N4($X12info). PHP_EOL;  
  // billing
        $PATEDI   .= create_billing_N1($X12info). PHP_EOL;
        $PATEDI   .= create_billing_N2($X12info). PHP_EOL;
        $PATEDI   .= create_billing_N4($X12info). PHP_EOL;
  //Electronic Export Informa on
  
        $PATEDI   .= create_L13($X12info). PHP_EOL;
        $PATEDI   .= create_MAN($X12info). PHP_EOL; 
	    $PATEDI   .= create_X1($X12info). PHP_EOL;
	    $PATEDI   .= create_VEH($X12info). PHP_EOL;
	    
  // For Footer Segment
	   $PATEDI   .= create_SE($segmentcount, $X12info). PHP_EOL;
	   $PATEDI   .= create_GE($X12info). PHP_EOL;
	   $PATEDI   .= create_IEA($X12info). PHP_EOL;

      return $PATEDI;
}


?>